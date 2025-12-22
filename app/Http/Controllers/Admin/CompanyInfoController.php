<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CompanyInfoController extends Controller
{
    public function index()
    {
        $company = CompanyInfo::first() ?? new CompanyInfo();
        return view('admin.company.edit', compact('company'));
    }

    public function update(Request $request)
    {
        // FIX: Use first() or create a real record
      $company = CompanyInfo::first();
        if (!$company) {
            $company = new CompanyInfo(); // New record
        }

        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => ['required', 'email', Rule::unique('company_infos')->ignore($company->id ?? null)],
            'reg_no'        => ['nullable', 'string', Rule::unique('company_infos')->ignore($company->id ?? null)],
            'pan_no'        => ['nullable', 'string', Rule::unique('company_infos')->ignore($company->id ?? null)],
            'logo'          => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'favicon'       => 'nullable|image|mimes:png,jpg,ico,svg|max:512',
            'bg_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'about_us_image'=> 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'working_hours' => 'nullable|json',
            'extra_links'   => 'nullable|json',
            'is_active'     => 'required|boolean',
        ]);

        $data = $request->except(['logo', 'favicon', 'bg_image', 'about_us_image']);

        // Handle file uploads
        foreach (['logo', 'favicon', 'bg_image', 'about_us_image'] as $field) {
            if ($request->hasFile($field)) {
                if ($company->$field && Storage::exists('public/' . $company->$field)) {
                    Storage::delete('public/' . $company->$field);
                }
                $data[$field] = $request->file($field)->store('company', 'public');
            }
        }

        $data['is_active'] = $request->has('is_active');

        // Fix JSON fields (they come as string)
        if ($request->filled('working_hours')) {
            $data['working_hours'] = json_decode($request->working_hours, true);
        }
        if ($request->filled('extra_links')) {
            $data['extra_links'] = json_decode($request->extra_links, true);
        }

        $company->fill($data);
        $company->save();

        return back()->with('success', 'Company information updated successfully!');
    }
}

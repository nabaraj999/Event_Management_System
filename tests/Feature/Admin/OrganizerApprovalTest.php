<?php

use App\Mail\OrganizerApprovedMail;
use App\Models\Admin;
use App\Models\OrganizerApplication;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

test('approving an organizer activates and locks the account', function () {
    Mail::fake();

    $admin = Admin::create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => 'password',
        'phone' => '9800000000',
        'status' => 'active',
    ]);

    $application = OrganizerApplication::create([
        'organization_name' => 'Events Co',
        'contact_person' => 'Casey Doe',
        'email' => 'organizer@example.com',
        'phone' => '9800000001',
        'company_type' => 'private_limited',
        'address' => 'Kathmandu',
        'status' => 'pending',
        'is_frozen' => false,
    ]);

    $response = $this
        ->actingAs($admin, 'admin')
        ->post(route('admin.organizer-applications.approve', $application));

    $response->assertRedirect(route('admin.organizer-applications.index'));

    $application->refresh();

    expect($application->status)->toBe('approved');
    expect($application->is_frozen)->toBeTrue();
    expect($application->password)->not->toBeNull();
    expect(Hash::check('password', $application->password))->toBeFalse();

    Mail::assertSent(OrganizerApprovedMail::class, function (OrganizerApprovedMail $mail) use ($application) {
        return $mail->organizer->is($application) && $mail->plainPassword !== '';
    });
});

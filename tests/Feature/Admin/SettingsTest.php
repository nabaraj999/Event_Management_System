<?php

use App\Models\Admin;
use App\Models\Setting;

test('admin settings update creates the settings row when missing', function () {
    $admin = Admin::create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => 'password',
        'phone' => '9800000000',
        'status' => 'active',
    ]);

    expect(Setting::query()->count())->toBe(0);

    $response = $this
        ->actingAs($admin, 'admin')
        ->patch(route('admin.settings.update'), [
            'user_algorithm' => '0',
            'organizer_algorithm' => '1',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    $settings = Setting::query()->first();

    expect($settings)->not->toBeNull();
    expect($settings->user_algorithm)->toBeFalse();
    expect($settings->organizer_algorithm)->toBeTrue();
});

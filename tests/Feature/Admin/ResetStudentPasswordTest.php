<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('admin can reset a student password to the default password', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $student = User::factory()->create(['role' => 'siswa']);

    $response = $this->actingAs($admin)
        ->post(route('admin.siswa.reset-password', $student->id));

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Password berhasil direset menjadi 12345.');
    expect(Hash::check('12345', $student->fresh()->password))->toBeTrue();
});

test('a non-admin cannot reset a student password', function () {
    $student = User::factory()->create(['role' => 'siswa']);
    $anotherStudent = User::factory()->create(['role' => 'siswa']);

    $this->actingAs($student)
        ->post(route('admin.siswa.reset-password', $anotherStudent->id))
        ->assertForbidden();

    expect(Hash::check('password', $anotherStudent->fresh()->password))->toBeTrue();
});

test('admin cannot use the student reset route to change another admin password', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $anotherAdmin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->post(route('admin.siswa.reset-password', $anotherAdmin->id))
        ->assertNotFound();

    expect(Hash::check('password', $anotherAdmin->fresh()->password))->toBeTrue();
});

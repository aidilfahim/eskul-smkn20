<?php

use App\Models\Ekstrakurikuler;
use App\Models\Pendaftaran;
use App\Models\User;

function createBulkUpdateEkstrakurikuler(int $kuota = 5): Ekstrakurikuler
{
    return Ekstrakurikuler::create([
        'nama_ekskul' => 'Basket',
        'kategori' => 'Olahraga',
        'hari' => 'Senin',
        'jam' => '15:00',
        'deskripsi' => 'Ekskul basket',
        'pembina' => 'Pembina Basket',
        'kuota' => $kuota,
    ]);
}

test('admin can bulk approve selected pending registrations', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $ekskul = createBulkUpdateEkstrakurikuler(3);
    $firstStudent = User::factory()->create(['role' => 'siswa']);
    $secondStudent = User::factory()->create(['role' => 'siswa']);
    $firstRegistration = Pendaftaran::create([
        'user_id' => $firstStudent->id,
        'ekstrakurikuler_id' => $ekskul->id,
        'status' => 'pending',
    ]);
    $secondRegistration = Pendaftaran::create([
        'user_id' => $secondStudent->id,
        'ekstrakurikuler_id' => $ekskul->id,
        'status' => 'pending',
    ]);

    $response = $this->actingAs($admin)->post(route('admin.pendaftaran.bulk-update'), [
        'ids' => [$firstRegistration->id, $secondRegistration->id],
        'status' => 'diterima',
    ]);

    $response->assertRedirect()
        ->assertSessionHas('success', '2 pendaftaran berhasil diterima.');
    $this->assertDatabaseHas('pendaftarans', ['id' => $firstRegistration->id, 'status' => 'diterima']);
    $this->assertDatabaseHas('pendaftarans', ['id' => $secondRegistration->id, 'status' => 'diterima']);
    $this->assertDatabaseHas('ekstrakurikulers', ['id' => $ekskul->id, 'kuota' => 3]);
});

test('admin can bulk reject pending registrations and restore their reserved quotas', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $ekskul = createBulkUpdateEkstrakurikuler(3);
    $firstStudent = User::factory()->create(['role' => 'siswa']);
    $secondStudent = User::factory()->create(['role' => 'siswa']);
    $firstRegistration = Pendaftaran::create([
        'user_id' => $firstStudent->id,
        'ekstrakurikuler_id' => $ekskul->id,
        'status' => 'pending',
    ]);
    $secondRegistration = Pendaftaran::create([
        'user_id' => $secondStudent->id,
        'ekstrakurikuler_id' => $ekskul->id,
        'status' => 'pending',
    ]);

    $response = $this->actingAs($admin)->post(route('admin.pendaftaran.bulk-update'), [
        'ids' => [$firstRegistration->id, $secondRegistration->id],
        'status' => 'ditolak',
    ]);

    $response->assertRedirect()
        ->assertSessionHas('success', '2 pendaftaran berhasil ditolak.');
    $this->assertDatabaseHas('pendaftarans', ['id' => $firstRegistration->id, 'status' => 'ditolak']);
    $this->assertDatabaseHas('pendaftarans', ['id' => $secondRegistration->id, 'status' => 'ditolak']);
    $this->assertDatabaseHas('ekstrakurikulers', ['id' => $ekskul->id, 'kuota' => 5]);
});

test('admin can accept a single pending registration without reserving the quota twice', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $student = User::factory()->create(['role' => 'siswa']);
    $ekskul = createBulkUpdateEkstrakurikuler(3);
    $registration = Pendaftaran::create([
        'user_id' => $student->id,
        'ekstrakurikuler_id' => $ekskul->id,
        'status' => 'pending',
    ]);

    $response = $this->actingAs($admin)->post(route('admin.pendaftaran.status', $registration->id), [
        'status' => 'diterima',
    ]);

    $response->assertRedirect()
        ->assertSessionHas('success', 'Status pendaftaran berhasil diperbarui.');
    $this->assertDatabaseHas('pendaftarans', ['id' => $registration->id, 'status' => 'diterima']);
    $this->assertDatabaseHas('ekstrakurikulers', ['id' => $ekskul->id, 'kuota' => 3]);
});

test('non-admin users cannot bulk update registrations', function () {
    $student = User::factory()->create(['role' => 'siswa']);
    $anotherStudent = User::factory()->create(['role' => 'siswa']);
    $ekskul = createBulkUpdateEkstrakurikuler();
    $registration = Pendaftaran::create([
        'user_id' => $anotherStudent->id,
        'ekstrakurikuler_id' => $ekskul->id,
        'status' => 'pending',
    ]);

    $this->actingAs($student)
        ->post(route('admin.pendaftaran.bulk-update'), [
            'ids' => [$registration->id],
            'status' => 'diterima',
        ])
        ->assertForbidden();

    $this->assertDatabaseHas('pendaftarans', ['id' => $registration->id, 'status' => 'pending']);
});

test('bulk update validates IDs and status before changing registrations', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $student = User::factory()->create(['role' => 'siswa']);
    $ekskul = createBulkUpdateEkstrakurikuler();
    $registration = Pendaftaran::create([
        'user_id' => $student->id,
        'ekstrakurikuler_id' => $ekskul->id,
        'status' => 'pending',
    ]);

    $response = $this->actingAs($admin)->from('/admin/dashboard')
        ->post(route('admin.pendaftaran.bulk-update'), [
            'ids' => [$registration->id, $registration->id],
            'status' => 'pending',
        ]);

    $response->assertRedirect('/admin/dashboard')
        ->assertSessionHasErrors(['ids.1', 'status']);
    $this->assertDatabaseHas('pendaftarans', ['id' => $registration->id, 'status' => 'pending']);
    $this->assertDatabaseHas('ekstrakurikulers', ['id' => $ekskul->id, 'kuota' => 5]);
});

test('bulk update ignores registrations that are no longer pending', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $student = User::factory()->create(['role' => 'siswa']);
    $ekskul = createBulkUpdateEkstrakurikuler();
    $registration = Pendaftaran::create([
        'user_id' => $student->id,
        'ekstrakurikuler_id' => $ekskul->id,
        'status' => 'diterima',
    ]);

    $response = $this->actingAs($admin)->from('/admin/dashboard')
        ->post(route('admin.pendaftaran.bulk-update'), [
            'ids' => [$registration->id],
            'status' => 'ditolak',
        ]);

    $response->assertRedirect('/admin/dashboard')
        ->assertSessionHas('error', 'Tidak ada pendaftaran berstatus menunggu yang dipilih.');
    $this->assertDatabaseHas('pendaftarans', ['id' => $registration->id, 'status' => 'diterima']);
    $this->assertDatabaseHas('ekstrakurikulers', ['id' => $ekskul->id, 'kuota' => 5]);
});

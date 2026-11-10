<?php

use App\Models\User;
use App\Models\Ekstrakurikuler;
use App\Models\Pendaftaran;

test('admin can view all student accounts including students without extracurricular registrations', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $registeredStudent = User::factory()->create([
        'name' => 'Siswa Terdaftar',
        'role' => 'siswa',
    ]);
    $unregisteredStudent = User::factory()->create([
        'name' => 'Siswa Belum Daftar',
        'role' => 'siswa',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.siswa.index'));

    $response->assertOk()
        ->assertSee($registeredStudent->name)
        ->assertSee($unregisteredStudent->name)
        ->assertDontSee($admin->email)
        ->assertSee(route('admin.siswa.reset-password', $unregisteredStudent->id), false)
        ->assertSee(route('admin.siswa.destroy', $unregisteredStudent->id), false)
        ->assertSee('seluruh riwayat pendaftaran ekskulnya', false);
});

test('non-admin users cannot view the student directory', function () {
    $student = User::factory()->create(['role' => 'siswa']);

    $this->actingAs($student)
        ->get(route('admin.siswa.index'))
        ->assertForbidden();
});

test('admin can search student accounts by name email or class', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $matchingStudent = User::factory()->create([
        'name' => 'Siswa Kelas X',
        'email' => 'siswa.kelasx@example.com',
        'kelas' => 'X RPL 1',
        'role' => 'siswa',
    ]);
    $otherStudent = User::factory()->create([
        'name' => 'Siswa Lain',
        'email' => 'siswa.lain@example.com',
        'kelas' => 'XI RPL 1',
        'role' => 'siswa',
    ]);

    $response = $this->actingAs($admin)
        ->get(route('admin.siswa.index', ['search' => 'X RPL']));

    $response->assertOk()
        ->assertSee($matchingStudent->name)
        ->assertDontSee($otherStudent->name);
});

test('admin can permanently delete a student and their registrations while restoring extracurricular quotas', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $student = User::factory()->create(['role' => 'siswa']);
    $firstExtracurricular = Ekstrakurikuler::create([
        'nama_ekskul' => 'Basket',
        'kategori' => 'Olahraga',
        'hari' => 'Senin',
        'jam' => '15:00',
        'deskripsi' => 'Ekskul basket',
        'pembina' => 'Pembina Basket',
        'kuota' => 3,
    ]);
    $secondExtracurricular = Ekstrakurikuler::create([
        'nama_ekskul' => 'Musik',
        'kategori' => 'Seni',
        'hari' => 'Selasa',
        'jam' => '15:00',
        'deskripsi' => 'Ekskul musik',
        'pembina' => 'Pembina Musik',
        'kuota' => 4,
    ]);
    Pendaftaran::create([
        'user_id' => $student->id,
        'ekstrakurikuler_id' => $firstExtracurricular->id,
        'status' => 'pending',
    ]);
    Pendaftaran::create([
        'user_id' => $student->id,
        'ekstrakurikuler_id' => $secondExtracurricular->id,
        'status' => 'diterima',
    ]);

    $response = $this->actingAs($admin)
        ->delete(route('admin.siswa.destroy', $student->id));

    $response->assertRedirect(route('admin.siswa.index'))
        ->assertSessionHas('success', 'Data siswa dan seluruh riwayat pendaftarannya berhasil dihapus.');
    $this->assertDatabaseMissing('users', ['id' => $student->id]);
    $this->assertDatabaseMissing('pendaftarans', ['user_id' => $student->id]);
    $this->assertDatabaseHas('ekstrakurikulers', [
        'id' => $firstExtracurricular->id,
        'kuota' => 4,
    ]);
    $this->assertDatabaseHas('ekstrakurikulers', [
        'id' => $secondExtracurricular->id,
        'kuota' => 5,
    ]);
});

test('non-admin users cannot delete student accounts', function () {
    $student = User::factory()->create(['role' => 'siswa']);
    $anotherStudent = User::factory()->create(['role' => 'siswa']);

    $this->actingAs($student)
        ->delete(route('admin.siswa.destroy', $anotherStudent->id))
        ->assertForbidden();

    $this->assertDatabaseHas('users', ['id' => $anotherStudent->id]);
});

test('admin cannot delete another admin through the student directory', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $anotherAdmin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->delete(route('admin.siswa.destroy', $anotherAdmin->id))
        ->assertNotFound();

    $this->assertDatabaseHas('users', ['id' => $anotherAdmin->id]);
});

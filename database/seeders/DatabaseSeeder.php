<?php

namespace Database\Seeders;

use App\Models\JenisDokumen;
use App\Models\JenisPermohonan;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // Role::create([
        //     'slug' => 'engginer',
        //     'role' => 'Engginer'
        // ]);
        // Role::create([
        //     'slug' => 'osmtth',
        //     'role' => 'OSM TTH'
        // ]);
        // Role::create([
        //     'slug' => 'manajemen',
        //     'role' => 'Manajemen'
        // ]);
        // Role::create([
        //     'slug' => 'pengendalidokumen',
        //     'role' => 'Pengendali Dokumen'
        // ]);
        // Role::create([
        //     'slug' => 'manageriqa',
        //     'role' => 'Manager IQA'
        // ]);
        // Role::create([
        //     'slug' => 'managerurel',
        //     'role' => 'Manager UREL'
        // ]);
        // Role::create([
        //     'slug' => 'managerdeqa',
        //     'role' => 'Manager DEQA'
        // ]);
        // User::create([
        //     'nik' => '12930281290391',
        //     'name' => 'engginer 1',
        //     'email' => 'engginer1@gmail.com',
        //     'password' => Hash::make(12345),
        //     'role' => 1
        // ]);
        // User::create([
        //     'nik' => '1293020981290391',
        //     'name' => 'engginer 2',
        //     'email' => 'engginer2@gmail.com',
        //     'password' => Hash::make(12345),
        //     'role' => 1
        // ]);
        // User::create([
        //     'nik' => '129302812900890',
        //     'name' => 'OSM TTH',
        //     'email' => 'osmtth@gmail.com',
        //     'password' => Hash::make(12345),
        //     'role' => 2
        // ]);
        // User::create([
        //     'nik' => '129302812990008',
        //     'name' => 'Manajemen',
        //     'email' => 'manajemen@gmail.com',
        //     'password' => Hash::make(12345),
        //     'role' => 3
        // ]);
        // User::create([
        //     'nik' => '129302812900800',
        //     'name' => 'Pengendali Dokumen',
        //     'email' => 'pengendalidokumen@gmail.com',
        //     'password' => Hash::make(12345),
        //     'role' => 4
        // ]);
        // User::create([
        //     'nik' => '129302812900809',
        //     'name' => 'Manager IQA',
        //     'email' => 'manageriqa@gmail.com',
        //     'password' => Hash::make(12345),
        //     'role' => 5
        // ]);
        // User::create([
        //     'nik' => '120002812900809',
        //     'name' => 'Manager UREL',
        //     'email' => 'managerurel@gmail.com',
        //     'password' => Hash::make(12345),
        //     'role' => 6
        // ]);
        // User::create([
        //     'nik' => '120002865900809',
        //     'name' => 'Manager DEQA',
        //     'email' => 'managerdeqa@gmail.com',
        //     'password' => Hash::make(12345),
        //     'role' => 7
        // ]);
        JenisDokumen::create([
            'slug' => 'panduanmutu',
            'name' => 'Panduan Mutu'
        ]);
        JenisDokumen::create([
            'slug' => 'prosedur',
            'name' => 'Prosedur'
        ]);
        JenisDokumen::create([
            'slug' => 'instruksikerja',
            'name' => 'Instruksi Kerja'
        ]);
        JenisDokumen::create([
            'slug' => 'testprocedure',
            'name' => 'Test Procedure'
        ]);
        JenisPermohonan::create([
            'slug' => 'penerbitandokumenbaru',
            'name' => 'Penerbitan Dokumen Baru'
        ]);
        JenisPermohonan::create([
            'slug' => 'perubahandokumen',
            'name' => 'Perubahan Dokumen'
        ]);
        JenisPermohonan::create([
            'slug' => 'penghapusandokumen',
            'name' => 'Penghapusan Dokumen'
        ]);
        Status::create([
            'slug' => 'ditinjau',
            'status' => 'Ditinjau'
        ]);
        Status::create([
            'slug' => 'dikembalikan',
            'status' => 'Dikembalikan'
        ]);
        Status::create([
            'slug' => 'selesai',
            'status' => 'Selesai'
        ]);
    }
}

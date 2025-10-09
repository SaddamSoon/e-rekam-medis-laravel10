<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        // user admin
        \App\Models\User::factory()->create([
            'id_dokter' => null,
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'no_hp' => fake()->phoneNumber(),
            'roles' => 'Admin',
            'password' => bcrypt(123),
        ]);
        // 5 user dokter
        for($i=1; $i<=5; $i++){
            \App\Models\User::factory()->create([
            'id_dokter' => $i,
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'no_hp' => fake()->phoneNumber(),
            'roles' => 'Dokter',
            'password' => bcrypt(123),
        ]);
        }
        // Dummy tabel Dokter
        for($i=1; $i<=5; $i++){
            \App\Models\Dokter::create([
            'nama' => fake()->name(),
            'id_spesialis' => rand(1,2),
            'no_str' => rand(810030100, 867392838)
        ]);
        }
        // Dummy tabel Spesialis
            \App\Models\Spesialis::create([
            'nama' => 'Dokter Umum',
            'id_poly' => 2
        ]);
        \App\Models\Spesialis::create([
            'nama' => 'Dokter Gigi',
            'id_poly' => 2
            ]);
        //Dummy Data Obat
        $obat = [
                'Paracetamol',
                'Amoxicillin',
                'Ibuprofen',
                'Cetirizine',
                'Loratadine',
                'Omeprazole',
                'Ranitidine',
                'Metformin',
                'Glibenclamide',
                'Salbutamol',
                'Ambroxol',
                'Dextromethorphan',
                'Vitamin C',
                'Vitamin B12',
                'Folic Acid',
                'Ciprofloxacin',
                'Clindamycin',
                'Ketoconazole',
                'Miconazole',
                'Hydrocortisone',
                'Betadine',
                'Diazepam',
                'Mefenamic Acid',
                'Amlodipine',
                'Simvastatin',
                'Atorvastatin',
                'Losartan',
                'Captopril',
                'Antasida Doen',
                'ORS (Oralit)'
            ];

        foreach($obat as $ob){
            \App\Models\Obat::create([
                'nama' => $ob,
                 'harga' => rand(3, 50)*1000
                ]);
        }
        //Dummy Data Pasien
        for($i=1; $i<=27; $i++){
            \App\Models\Pasien::create([
            'nama' => fake()->name(),
            'alamat' => fake()->address(),
            'tanggal_lahir' => fake()->date(),
            'no_hp' => fake()->phoneNumber(),
            'created_by' => rand(1,5) 
        ]);
        }
        //Dummy Data Slider
        for($i=1; $i<=2; $i++){
            \App\Models\Slider::create([
            'img_url' => 'gambar'.$i.'.jpg',
            'caption' => 'Lorem ipsum dolor, sit amet',
            'order' => $i,
            'is_active' => true,
            'created_by' => 1,
            'lastupdate_by' => 1,
        ]);
        }
    }
}

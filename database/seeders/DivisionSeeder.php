<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisions = [
            ['name' => 'TEKNOLOGI INFORMASI', 'status' => '1'],
            ['name' => 'PELAYANAN DAN PEMELIHARAAN', 'status' => '1'],
            ['name' => 'UMUM', 'status' => '1'],
            ['name' => 'MANAJEMEN GERBANG TOL', 'status' => '1'],
            ['name' => 'KEUANGAN', 'status' => '1'],
            ['name' => 'SATUAN PENGAWAS INTERN', 'status' => '1'],
            ['name' => 'SEKRETARIS PERUSAHAAN', 'status' => '1'],
            ['name' => 'HUKUM', 'status' => '1'],
            ['name' => 'AKUNTANSI', 'status' => '1'],
            ['name' => 'TEKNIK DAN QUALITY ASSURANCE', 'status' => '1'],
            ['name' => 'INVESTASI', 'status' => '1'],
            ['name' => 'SUMBER DAYA MANUSIA', 'status' => '1'],
            ['name' => 'HARBOUR ROUD (HBR) 2', 'status' => '1'],
            // Tambahkan data division lainnya sesuai kebutuhan
        ];

        foreach ($divisions as $division) {
            Division::create($division);
        }
    }
}

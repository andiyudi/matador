<?php

namespace Database\Seeders;

use App\Models\CoreBusiness;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CorebusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $corebusinesses = [
            ['name' => 'INFRASTRUKTUR'],
            ['name' => 'MEKANIKAL & ELEKTRIKAL'],
            ['name' => 'TEKNOLOGI INFORMASI'],
            ['name' => 'KONSULTAN'],
            ['name' => 'KANTOR JASA PENILAI PUBLIK'],
            ['name' => 'SUPPLIER'],
            ['name' => 'ASURANSI'],
        ];

        foreach ($corebusinesses as $corebusiness) {
            CoreBusiness::create($corebusiness);
        }
    }
}

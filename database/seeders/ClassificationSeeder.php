<?php

namespace Database\Seeders;

use App\Models\Classification;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classifications = [
            ['core_business_id' => 1, 'name' => 'ASPAL'],
            ['core_business_id' => 1, 'name' => 'GROUTING'],
            ['core_business_id' => 1, 'name' => 'INJEKSI'],
            ['core_business_id' => 1, 'name' => 'PATCHING'],
            ['core_business_id' => 1, 'name' => 'MARKA'],
            ['core_business_id' => 1, 'name' => 'RIGID PAVEMENT'],
            ['core_business_id' => 1, 'name' => 'PENGECATAN'],
            ['core_business_id' => 1, 'name' => 'ELEKTRIKAL JALAN TOL'],
            ['core_business_id' => 1, 'name' => 'PEMBERSIHAN RUAS & RAMBU JALAN'],
            ['core_business_id' => 1, 'name' => 'PERAWATAN TAMAN RUAS'],
            ['core_business_id' => 1, 'name' => 'PEMBUATAN RAMBU'],
            ['core_business_id' => 1, 'name' => 'PELAYANAN LALU LINTAS'],
            ['core_business_id' => 1, 'name' => 'PELAYANAN MEDICAL'],
            ['core_business_id' => 1, 'name' => 'PEMBANGUNAN JALAN TOL'],
            ['core_business_id' => 1, 'name' => 'PJU'],
            ['core_business_id' => 1, 'name' => 'PEMBONGKARAN'],
            ['core_business_id' => 1, 'name' => 'DRAINASE'],
            ['core_business_id' => 1, 'name' => 'STEEL PLATE BONDING'],
            ['core_business_id' => 1, 'name' => 'FIBER REINFORCED POLYMER'],
            ['core_business_id' => 1, 'name' => 'POMPA'],
            ['core_business_id' => 1, 'name' => 'EXPANSION JOINT'],
            ['core_business_id' => 2, 'name' => 'PERAWATAN AC'],
            ['core_business_id' => 2, 'name' => 'RADIO RIG'],
            ['core_business_id' => 2, 'name' => 'CLOSED CIRCUIT TELEVISION (CCTV)'],
            ['core_business_id' => 2, 'name' => 'PENGECATAN BANGUNAN'],
            ['core_business_id' => 2, 'name' => 'ELEKTRIKAL BANGUNAN'],
            ['core_business_id' => 2, 'name' => 'INTERIOR BANGUNAN'],
            ['core_business_id' => 2, 'name' => 'EXTERIOR BANGUNAN'],
            ['core_business_id' => 2, 'name' => 'APAR'],
            ['core_business_id' => 2, 'name' => 'POMPA'],
            ['core_business_id' => 2, 'name' => 'PEST CONTROL'],
            ['core_business_id' => 2, 'name' => 'PABX'],
            ['core_business_id' => 3, 'name' => 'PERALATAN TOL'],
            ['core_business_id' => 3, 'name' => 'CLOSED CIRCUIT TELEVISION (CCTV)'],
            ['core_business_id' => 3, 'name' => 'VARIABLE MESSAGE SIGN'],
            ['core_business_id' => 3, 'name' => 'GOOGLE MAP'],
            ['core_business_id' => 3, 'name' => 'INTERNET'],
            ['core_business_id' => 3, 'name' => 'SOFTWARE'],
            ['core_business_id' => 3, 'name' => 'HARDWARE'],
            ['core_business_id' => 3, 'name' => 'GPS'],
            ['core_business_id' => 4, 'name' => 'KEUANGAN'],
            ['core_business_id' => 4, 'name' => 'TRAFFIC'],
            ['core_business_id' => 4, 'name' => 'BASIC DESIGN'],
            ['core_business_id' => 4, 'name' => 'DETAIL ENGINEERING DESIGN'],
            ['core_business_id' => 4, 'name' => 'PERENCANAAN KONSTRUKSI'],
            ['core_business_id' => 4, 'name' => 'MANAJEMEN KONSTRUKSI'],
            ['core_business_id' => 4, 'name' => 'MANAJEMEN MUTU'],
            ['core_business_id' => 4, 'name' => 'AUDIT STRUKTUR'],
            ['core_business_id' => 4, 'name' => 'INTERNATIONAL STANDARDIZATION ORGANIZATION (ISO)'],
            ['core_business_id' => 4, 'name' => 'OWNER ESTIMATE'],
            ['core_business_id' => 4, 'name' => 'PERIJINAN'],
            ['core_business_id' => 4, 'name' => 'AMDAL'],
            ['core_business_id' => 4, 'name' => 'RIKSA UJI'],
            ['core_business_id' => 5, 'name' => 'KANTOR JASA PENILAI PUBLIK'],
            ['core_business_id' => 6, 'name' => 'ALAT BERAT'],
            ['core_business_id' => 6, 'name' => 'BARANG'],
            ['core_business_id' => 6, 'name' => 'ANNUAL REPORT'],
            ['core_business_id' => 6, 'name' => 'AIR MINUM'],
            ['core_business_id' => 6, 'name' => 'SARANA PERLENGKAPAN KERJA'],
            ['core_business_id' => 6, 'name' => 'MESIN FOTOCOPY'],
            ['core_business_id' => 6, 'name' => 'AIR BERSIH'],
            ['core_business_id' => 6, 'name' => 'ALAT TULIS KANTOR'],
            ['core_business_id' => 7, 'name' => 'KESEHATAN'],
            ['core_business_id' => 7, 'name' => 'CIVIL ENGINEERING COMPLETED RISK ( CECR )'],
            ['core_business_id' => 7, 'name' => 'PROPERTY ALL RISK EARTHQUAKE'],
            // Tambahkan data classification lainnya sesuai kebutuhan
        ];

        foreach ($classifications as $classification) {
            Classification::create($classification);
        }
    }
}

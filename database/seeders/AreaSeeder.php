<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    public function run(): void
    {
        $areas = [
        'Kabupaten Bandung',
        'Kabupaten Bandung Barat',
        'Kota Cimahi',
        'Kota Bandung',
        'Kabupaten Bogor',
        ];

        foreach ($areas as $nama) {
            Area::firstOrCreate(['nama' => $nama]);
        }
    }
}
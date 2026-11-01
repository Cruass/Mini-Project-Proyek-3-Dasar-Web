<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    public function run(): void
    {
        $areas = [
            'Kabupaten Pelalawan',
            'Kabupaten Kapuas',
            'Kabupaten Ogan Komering Ilir',
            'Kabupaten Kubu Raya',
            'Kabupaten Muaro Jambi',
        ];

        foreach ($areas as $nama) {
            Area::firstOrCreate(['nama' => $nama]);
        }
    }
}
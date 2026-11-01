<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    public function run(): void
    {
        $pelapor = User::where('role', 'pelapor')->orderBy('id')->get();
        $relawan = User::where('email', 'relawan@gmail.com')->first();
        $areas   = Area::orderBy('id')->get();

        // titik dasar koordinat (dummy) per area: [latitude, longitude]
        $koordinat = [
            'Kabupaten Bandung'       => [-7.02, 107.52],
            'Kabupaten Bandung Barat' => [-6.85, 107.49],
            'Kota Cimahi'             => [-6.88, 107.54],
            'Kota Bandung'            => [-6.91, 107.61],
            'Kabupaten Bogor'         => [-6.60, 106.80],
        ];

        $data = [
            ['Asap tebal di area perkebunan', 'Asap putih tebal terlihat dari jalan, api belum terlihat.', 'sedang', 'baru'],
            ['Api kecil di semak belukar', 'Api kecil di pinggir jalan, angin cukup kencang.', 'ringan', 'baru'],
            ['Lahan gambut terbakar', 'Api menjalar di lahan gambut, asap sangat pekat.', 'berat', 'baru'],
            ['Bau asap di dekat permukiman', 'Bau asap tercium kuat sejak pagi, sumber belum jelas.', 'ringan', 'baru'],

            ['Kebakaran di lahan kosong', 'Api terlihat di lahan kosong dekat kebun warga.', 'sedang', 'ditinjau'],
            ['Asap dari area hutan', 'Asap muncul dari arah hutan sejak sore.', 'sedang', 'ditinjau'],
            ['Titik api di pinggir sungai', 'Api kecil di pinggir sungai, dekat jalan desa.', 'ringan', 'ditinjau'],
            ['Lahan sawit terbakar sebagian', 'Beberapa pohon terbakar, api masih menyala.', 'berat', 'ditinjau'],

            ['Kebakaran lahan dekat jalan lintas', 'Api cukup besar, mengganggu jarak pandang kendaraan.', 'berat', 'diteruskan'],
            ['Kebakaran semak luas', 'Api menyebar di semak kering seluas lapangan.', 'sedang', 'diteruskan'],
            ['Lahan gambut berasap', 'Gambut berasap terus-menerus selama dua hari.', 'berat', 'diteruskan'],

            ['Api di kebun warga', 'Api membakar sebagian kebun, warga sudah berusaha memadamkan.', 'sedang', 'selesai'],
            ['Pembakaran sampah meluas', 'Pembakaran sampah merambat ke lahan sekitar.', 'ringan', 'selesai'],
            ['Asap di area perkebunan', 'Asap tipis terlihat, kemudian hilang.', 'ringan', 'selesai'],
        ];

        foreach ($data as $i => [$judul, $kondisi, $tingkat, $status]) {
            $area       = $areas[$i % $areas->count()];
            $user       = $pelapor[$i % $pelapor->count()];
            $base       = $koordinat[$area->nama];
            $ditinjau   = $status !== 'baru';
            $diteruskan = in_array($status, ['diteruskan', 'selesai']);

            Report::create([
                'user_id'         => $user->id,
                'area_id'         => $area->id,
                'reviewer_id'     => $ditinjau ? $relawan->id : null,
                'judul'           => $judul,
                'kondisi'         => $kondisi,
                'tingkat'         => $tingkat,
                'latitude'        => $base[0] + ($i * 0.01),
                'longitude'       => $base[1] + ($i * 0.01),
                'waktu_kejadian'  => now()->subDays(14 - $i),
                'status'          => $status,
                'catatan_relawan' => ($ditinjau && $i !== 6) ? 'Informasi sudah ditinjau dan tampak wajar.' : null, // $i === 6: data uji BR-03 (ditinjau tanpa catatan)
                'diteruskan_ke'   => $diteruskan ? 'BPBD setempat' : null,
                'diteruskan_pada' => $diteruskan ? now()->subDays(max(1, 12 - $i)) : null,
            ]);
        }
    }
}
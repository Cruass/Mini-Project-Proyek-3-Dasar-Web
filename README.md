# Lapor Karhutla

Mini Project Proyek 3 - D3 Teknik Informatika
Kasus B: Pelaporan dan Pemantauan Kebakaran Hutan dan Lahan

## Identitas

- Nama       : Muhammad Rayhan Maulana Farid
- NIM        : 25151105
- Kelas      : 2B-D3
- Repository : https://github.com/Cruass/Mini-Project-Proyek-3-Dasar-Web

## Deskripsi Singkat

Aplikasi web komunitas untuk melaporkan, meninjau, meneruskan, dan memantau
indikasi kebakaran hutan dan lahan. Terdapat tiga fungsi pengguna:
Pelapor, Relawan Pemantau, dan Koordinator Relawan.

## Kebutuhan Environment

- PHP 8.2 atau lebih baru
- Composer
- Node.js dan npm
- MySQL atau MariaDB (contoh: XAMPP)
- Git

## Langkah Instalasi

```bash
git clone https://github.com/Cruass/Mini-Project-Proyek-3-Dasar-Web.git
cd Mini-Project-Proyek-3-Dasar-Web
composer install
copy .env.example .env      
php artisan key:generate
npm install
npm run build
```

## Konfigurasi Database

1. Nyalakan MySQL (misalnya lewat XAMPP).
2. Buat database kosong bernama `db_miniproject_karhutla`.
3. Sesuaikan bagian berikut pada file `.env` bila perlu:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_miniproject_karhutla
DB_USERNAME=root
DB_PASSWORD=
```

## Migration dan Seeding

```bash
php artisan migrate --seed
php artisan storage:link
```

Untuk mengulang dari data awal: `php artisan migrate:fresh --seed`

## Akun Demo

Semua akun memakai password: `password`

| Peran               | Email                   |
|---------------------|-------------------------|
| Pelapor 1           | pelapor1@gmail.com    |
| Pelapor 2           | pelapor2@gmail.com    |
| Relawan Pemantau    | relawan@gmail.com     |
| Koordinator Relawan | koordinator@gmail.com |

Akun baru yang mendaftar lewat halaman Daftar otomatis menjadi Pelapor.

## Menjalankan Aplikasi

```bash
php artisan serve
```

Buka http://127.0.0.1:8000

## Alur Status Laporan

`baru` -> `ditinjau` -> `diteruskan` -> `selesai`

| Aksi                    | Pelaku      | Dari       | Ke         |
|-------------------------|-------------|------------|------------|
| Tinjau + beri catatan   | Relawan     | baru       | ditinjau   |
| Catat penerusan         | Koordinator | ditinjau   | diteruskan |
| Tandai selesai          | Koordinator | diteruskan | selesai    |

## Business Rule

- BR-01: Pelapor hanya dapat mengubah laporan yang berstatus `baru`.
- BR-02: Status hanya dapat maju satu langkah sesuai urutan alur.
- BR-03: Laporan hanya dapat diteruskan jika sudah memiliki catatan relawan.

## Catatan

- Seluruh data pada aplikasi adalah data dummy.
- Status `selesai` berarti proses pada aplikasi komunitas selesai, bukan
  pernyataan resmi bahwa kebakaran telah padam.
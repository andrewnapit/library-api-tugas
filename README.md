# library-api-tugas
TUGAS API
Project ini adalah RESTful API untuk sistem manajemen perpustakaan yang dibangun menggunakan framework Laravel 11.

## Fitur Utama:
- **Books API**: CRUD data buku dengan validasi stok.
- **Members API**: CRUD data anggota dengan validasi status aktif.
- **JSON Response**: Menggunakan API Resources untuk format data yang konsisten.

## Cara Menjalankan Project:

1. Ekstrak & Persiapan:
   - Ekstrak file project atau clone dari GitHub.
   - Buka terminal di folder project, jalankan: `composer install`

2. Konfigurasi Environment:
   - Copy file `.env.example` menjadi `.env`
   - Buat database baru di MySQL dengan nama `library_api`
   - Sesuaikan `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` di file `.env`

3. Setup Database & Key;
   - Jalankan: `php artisan key:generate`
   - Jalankan migrasi tabel: `php artisan migrate`

4. Menjalankan Server:
   - Jalankan: `php artisan serve`
   - API dapat diakses di: `http://127.0.0.1:8000/api/`


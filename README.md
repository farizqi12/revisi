# Laravel Absensi & Tabungan Sekolah

Proyek ini adalah aplikasi berbasis web yang dibangun dengan Laravel untuk mengelola absensi dan tabungan siswa di sekolah. Aplikasi ini memungkinkan guru dan kepala sekolah untuk memantau kehadiran siswa, mengelola tabungan, dan melihat riwayat transaksi.

## Fitur

*   **Manajemen Pengguna:** Kelola pengguna dengan peran yang berbeda (kepala sekolah, guru, murid).
*   **Absensi:** Siswa dapat melakukan absensi secara online, dan guru dapat memantau kehadiran.
*   **Tabungan:** Kelola tabungan siswa, termasuk setoran dan penarikan.
*   **Riwayat:** Lihat riwayat absensi dan transaksi tabungan.
*   **Laporan:** Hasilkan laporan absensi dan tabungan.

## Prasyarat

*   PHP >= 8.1
*   Composer
*   Node.js & NPM
*   Database (MySQL, MariaDB, atau yang lainnya yang didukung oleh Laravel)

## Instalasi

1.  **Clone repositori:**

    ```bash
    git clone https://github.com/username/repo.git
    cd repo
    ```

2.  **Instal dependensi:**

    ```bash
    composer install
    npm install
    ```

3.  **Buat file `.env`:**

    Salin file `.env.example` menjadi `.env`:

    ```bash
    cp .env.example .env
    ```

4.  **Hasilkan kunci aplikasi:**

    ```bash
    php artisan key:generate
    ```

5.  **Konfigurasi database:**

    Buka file `.env` dan atur kredensial database Anda:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6.  **Jalankan migrasi:**

    ```bash
    php artisan migrate
    ```

7.  **Jalankan seeder (opsional):**

    Jika Anda ingin mengisi database dengan data dummy, jalankan seeder:

    ```bash
    php artisan db:seed
    ```

## Menjalankan Aplikasi

1.  **Jalankan server pengembangan:**

    ```bash
    php artisan serve
    ```

2.  **Kompilasi aset:**

    ```bash
    npm run dev
    ```

Aplikasi akan berjalan di `http://localhost:8000`.

## Kontribusi

Kontribusi dalam bentuk apa pun dipersilakan! Silakan buat *pull request* atau buka *issue* jika Anda menemukan masalah.
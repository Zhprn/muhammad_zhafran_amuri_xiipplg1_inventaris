# 📦 Sistem Inventaris --- Installation & Usage Guide

Aplikasi ini merupakan sistem inventaris sederhana yang dapat dijalankan
pada lingkungan PHP seperti **XAMPP** atau **Laragon**. Panduan ini
menjelaskan proses instalasi, konfigurasi, serta cara menggunakan
aplikasi.

------------------------------------------------------------------------

## 🏗️ 1. Instalasi Database

1.  Buka **phpMyAdmin** dari XAMPP atau Laragon.
2.  Klik **New** untuk membuat database baru.
3.  Buat database dengan nama:

```{=html}
<!-- -->
```
    muhammad_zhafran_amuri_xiipplg1_inventaris

4.  Setelah database berhasil dibuat, pilih menu **Import**.
5.  Pilih file SQL yang sudah disertakan pada project.
6.  Klik **Go** untuk memulai proses import hingga muncul pesan sukses.

------------------------------------------------------------------------

## 📁 2. Penempatan File Project

1.  Ekstrak seluruh file project hasil download.
2.  Pindahkan folder project ke:

### Jika menggunakan XAMPP:

    C:\xampp\htdocs\nama_folder

### Jika menggunakan Laragon:

    C:\laragon\www\nama_folder

Pastikan seluruh file seperti `index.php`, folder `assets`, `config`,
dan lainnya berada di dalam satu folder tersebut.

------------------------------------------------------------------------

## ▶️ 3. Menjalankan Aplikasi

1.  Aktifkan modul berikut pada XAMPP / Laragon:
    -   **Apache**
    -   **MySQL**
2.  Buka browser dan akses URL berikut:

```{=html}
<!-- -->
```
    http://localhost/(nama folder)

Contoh:

    http://localhost/inventaris

Jika struktur file benar dan database berhasil diimport, aplikasi akan
terbuka tanpa error.

------------------------------------------------------------------------

## 🔐 4. Login Aplikasi

Gunakan akun login berikut untuk masuk ke dashboard:

-   **Username:** admin\
-   **Password:** pran123

Setelah login, Anda dapat mengelola data inventaris sesuai fitur yang
tersedia.

------------------------------------------------------------------------

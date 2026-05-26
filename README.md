# PortfolioCV

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?logo=php&logoColor=white)
![Filament](https://img.shields.io/badge/Filament-3-F59E0B)
![Livewire](https://img.shields.io/badge/Livewire-3-4E56A6)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3-06B6D4?logo=tailwindcss&logoColor=white)
![Alpine.js](https://img.shields.io/badge/Alpine.js-3-8BC0D0)
![Docker](https://img.shields.io/badge/Docker-Compose-2496ED?logo=docker&logoColor=white)

Aplikasi portofolio + CV generator berbasis Laravel. Data dikelola dari Admin Panel (Filament), ditampilkan ke halaman publik, dan bisa diunduh sebagai PDF.

## Tujuan Proyek
- Menyatukan profil profesional, pengalaman, proyek, sertifikasi, bahasa, dan publikasi dalam satu sistem.
- Mempermudah update CV: input sekali di admin, otomatis sinkron ke web dan PDF.
- Mendukung pengelolaan publikasi akademik (Scopus, SINTA, Scholar, dll) untuk personal branding.

## Fitur Utama
### Frontend Publik
- Landing page modern (Livewire + Tailwind + Alpine.js).
- Halaman CV publik responsif.
- Download CV dalam format PDF.

### Admin Panel
- CRUD data CV (profil, pengalaman, pendidikan, skill, proyek, sertifikasi, bahasa, highlight, publikasi).
- Kontrol visibilitas konten.
- Struktur resource berbasis Filament agar mudah dikelola.

## Teknologi
- Backend: Laravel 12, PHP 8.3
- Admin: Filament 3
- Frontend: Livewire, Blade, Tailwind CSS, Alpine.js, Vite
- PDF: barryvdh/laravel-dompdf
- Infra: Docker Compose (Nginx, PHP-FPM, MariaDB)

## Panduan Instalasi
1. Clone repository dan masuk ke folder project.
2. Jalankan service:
   ```bash
   docker compose up -d --build
   ```
3. Install dependency PHP dan JS (jika belum):
   ```bash
   docker compose exec php composer install
   docker compose exec php php artisan key:generate
   cd src && npm install && npm run build
   ```
4. Migrasi dan seed database:
   ```bash
   docker compose exec php php artisan migrate --seed
   ```
5. Buka aplikasi:
   - Frontend: `https://portofolio.test`
   - Admin: `https://portofolio.test/admin`

## Contoh Penggunaan
- Lihat CV publik: `GET /cv`
- Unduh PDF CV: `GET /cv/download`
- Import data publikasi SINTA (opsional):
  ```bash
  docker compose exec php php artisan cv:import-sinta-outputs --profile-id=1 --username=EMAIL --password=PASSWORD
  ```

## Screenshot / Demo
- Demo lokal:
  - `https://portofolio.test`
  - `https://portofolio.test/cv`
  - `https://portofolio.test/admin`
- Screenshot dapat ditaruh di folder `docs/` (contoh: `docs/homepage.png`, `docs/cv-page.png`, `docs/admin-dashboard.png`).

## Panduan Kontribusi
1. Fork repository dan buat branch fitur (`feature/nama-fitur`).
2. Lakukan perubahan dengan commit yang jelas.
3. Jalankan test/lint yang relevan.
4. Buat Pull Request dengan ringkasan perubahan dan screenshot jika ada perubahan UI.

## Lisensi
Saat ini belum ada file lisensi resmi. Secara default project dianggap **proprietary / internal use only** sampai lisensi ditetapkan.

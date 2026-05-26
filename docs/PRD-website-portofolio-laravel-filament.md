# PRD - Website Portofolio Pribadi (Laravel + Filament)

## 1. Informasi Dokumen
- Nama produk: PortfolioCV
- Tipe produk: Website portofolio pribadi dengan admin panel
- Tech stack utama:
  - Backend: Laravel
  - Admin Panel: Filament
  - Frontend: Blade + Tailwind CSS (opsional Livewire untuk komponen interaktif)
  - Database: MySQL
  - PDF Engine: DomPDF atau Snappy (wkhtmltopdf)
- Versi dokumen: 1.0
- Tanggal: 26 Mei 2026
- Status: Draft siap implementasi

## 2. Latar Belakang
Pengguna membutuhkan website portofolio pribadi yang dikelola lewat panel admin. Semua data yang diinput di panel harus otomatis membentuk CV profesional pada halaman publik, lalu CV tersebut dapat diunduh dalam format PDF.

## 3. Tujuan Produk
- Menyediakan sumber data tunggal untuk profil profesional (single source of truth).
- Memudahkan pemilik portofolio memperbarui data tanpa edit kode.
- Menghasilkan CV online yang konsisten dengan versi PDF.
- Mempercepat proses apply kerja/freelance dengan CV yang selalu terbaru.

## 4. Sasaran Pengguna
- Primary user: Pemilik website (admin) yang mengelola isi portofolio.
- Secondary user: Recruiter/klien/pengunjung yang melihat CV dan portofolio.

## 5. Scope Produk
### 5.1 In Scope (MVP)
- Login admin dan manajemen konten via Filament.
- Modul data CV:
  - Profil personal
  - Ringkasan profesional
  - Pengalaman kerja
  - Pendidikan
  - Keahlian (skills)
  - Sertifikasi
  - Proyek/portofolio
  - Bahasa
  - Kontak dan sosial media
- Halaman publik:
  - Landing portofolio
  - Halaman CV online
  - Tombol unduh PDF CV
- Template CV PDF yang rapih dan ATS-friendly.
- Pengaturan visibilitas item (show/hide) untuk tiap entri.

### 5.2 Out of Scope (Tahap Lanjutan)
- Multi-user/multi-tenant (lebih dari 1 pemilik CV).
- AI auto-writing isi CV.
- Integrasi job board otomatis (LinkedIn, Jobstreet, dsb).
- Multi-template PDF dinamis di MVP.

## 6. Problem Statement
- Data CV sering tersebar di banyak file (Word, PDF, note), sulit sinkron.
- Update portofolio sering terlambat karena perlu edit manual beberapa tempat.
- CV PDF cepat outdated terhadap data terbaru.

## 7. Solusi yang Diusulkan
Membangun aplikasi Laravel dengan Filament sebagai CMS internal. Admin mengelola data terstruktur di panel. Sistem merender:
1. CV online pada halaman publik.
2. CV PDF dari source data yang sama.

Hasilnya: update sekali di panel, otomatis tercermin di CV online dan file PDF.

## 8. Kebutuhan Fungsional
### 8.1 Authentication Admin
- Admin dapat login/logout.
- Hanya user berotorisasi yang dapat mengakses panel Filament.
- Session management mengikuti standar Laravel.

### 8.2 Manajemen Data Profil
- Admin dapat membuat/mengubah data personal:
  - Nama lengkap, jabatan, foto profil, domisili.
  - Email, nomor telepon, website, LinkedIn, GitHub, dll.
  - Ringkasan profesional (rich text sederhana).
- Validasi field wajib.

### 8.3 Manajemen Pengalaman Kerja
- CRUD pengalaman kerja.
- Field: posisi, perusahaan, lokasi, tanggal mulai, tanggal akhir, status saat ini, deskripsi, poin pencapaian.
- Urutan dapat diatur (default terbaru ke terlama).

### 8.4 Manajemen Pendidikan
- CRUD pendidikan.
- Field: institusi, gelar/jurusan, periode, deskripsi.
- Opsi menampilkan IPK (opsional).

### 8.5 Manajemen Skills
- CRUD skill.
- Field: nama skill, kategori, level (beginner/intermediate/advanced atau skor 1-5), urutan tampil.

### 8.6 Manajemen Proyek Portofolio
- CRUD proyek.
- Field: nama proyek, role, deskripsi, stack teknologi, URL demo/repo, thumbnail, periode.
- Opsi tampil di landing saja, CV saja, atau keduanya.

### 8.7 Manajemen Sertifikasi dan Bahasa
- CRUD sertifikasi: nama, penerbit, tahun, credential URL.
- CRUD bahasa: nama bahasa, level kemampuan.

### 8.8 Pengaturan Visibilitas
- Setiap entri memiliki toggle `is_visible`.
- Data `is_visible = false` tidak tampil di CV publik dan PDF.

### 8.9 Halaman CV Online
- Menampilkan seluruh data aktif secara terstruktur.
- Layout responsif desktop/mobile.
- SEO dasar (meta title/description).

### 8.10 Download CV PDF
- Pengunjung dapat menekan tombol `Download CV PDF`.
- Sistem menghasilkan PDF real-time dari data terbaru.
- Nama file mengikuti format: `CV-{nama}-{yyyyMMdd}.pdf`.
- PDF menggunakan template profesional, mudah dibaca ATS.

### 8.11 Kontrol Publish
- Opsi status global CV: draft/published.
- Jika draft, halaman publik dapat menampilkan versi terakhir published atau halaman maintenance (sesuai konfigurasi).

## 9. Kebutuhan Non-Fungsional
- Performa:
  - Waktu render halaman CV < 2 detik pada koneksi normal.
  - Waktu generate PDF target < 5 detik untuk data standar.
- Keamanan:
  - Validasi input server-side.
  - Proteksi CSRF, XSS, SQL injection sesuai default Laravel best practice.
- Reliabilitas:
  - Error PDF generation ditangani dengan fallback message yang jelas.
- Maintainability:
  - Struktur kode mengikuti konvensi Laravel + Filament resources.
- Kompatibilitas:
  - PDF dapat dibuka di browser modern dan aplikasi PDF umum.

## 10. User Stories
1. Sebagai admin, saya ingin mengisi data pengalaman kerja di panel agar CV selalu up to date.
2. Sebagai admin, saya ingin menyembunyikan beberapa entri agar hanya data relevan yang tampil.
3. Sebagai pengunjung, saya ingin melihat CV secara online dengan layout yang jelas.
4. Sebagai recruiter, saya ingin mengunduh CV PDF dengan cepat dari halaman CV.

## 11. Alur Pengguna (High Level)
1. Admin login ke Filament.
2. Admin input/update data profil, pengalaman, pendidikan, skill, proyek.
3. Admin set visibilitas entri dan publish.
4. Pengunjung membuka URL CV publik.
5. Pengunjung klik tombol download PDF.
6. Sistem generate PDF dari data aktif dan mengirim file unduhan.

## 12. Data Model (Konseptual)
Entitas utama yang disarankan:
- users
- profiles (1:1 dengan user pemilik CV)
- work_experiences (1:N ke profile)
- educations (1:N)
- skills (1:N)
- projects (1:N)
- certifications (1:N)
- languages (1:N)
- social_links (1:N)

Kolom standar tabel konten:
- id
- profile_id
- title/name
- description
- start_date/end_date (jika relevan)
- sort_order
- is_visible
- created_at/updated_at

## 13. Halaman dan Navigasi
- Publik:
  - `/` : landing portofolio
  - `/cv` : CV online
  - `/cv/download` : endpoint download PDF
- Admin (Filament):
  - `/admin` : dashboard
  - Modul resource per entitas

## 14. Requirement UI/UX
- Gaya desain bersih, profesional, fokus keterbacaan.
- Hierarki informasi jelas (heading, subheading, section blocks).
- Tombol CTA download PDF mudah terlihat.
- Mobile-first untuk halaman CV.
- Template PDF konsisten dengan branding personal (warna/typography sederhana).

## 15. Requirement Teknis Implementasi
- Laravel policies untuk akses panel admin.
- Filament Resource untuk setiap entitas data.
- Service khusus `CvPdfService` untuk memisahkan logika generate PDF.
- Blade template terpisah:
  - Template CV web
  - Template CV PDF
- Queue optional untuk generate PDF berat (fase lanjut).
- Caching optional untuk CV publik dan file PDF sementara.

## 16. Acceptance Criteria MVP
1. Admin dapat CRUD seluruh modul CV dari panel Filament tanpa error.
2. Perubahan data di panel langsung tercermin di halaman `/cv`.
3. Tombol download menghasilkan file PDF valid.
4. PDF memuat hanya data berstatus visible.
5. Format PDF rapi dan dapat terbaca ATS (teks selectable, bukan gambar penuh).
6. Halaman CV dapat diakses baik di desktop maupun mobile.

## 17. Metrik Keberhasilan
- 100% data CV dikelola melalui panel (tanpa edit manual file).
- Waktu update CV oleh admin < 10 menit per revisi.
- Tingkat keberhasilan download PDF > 99%.
- Tidak ada mismatch data antara CV online dan PDF.

## 18. Risiko dan Mitigasi
- Risiko: Layout PDF berbeda antar environment.
  - Mitigasi: Gunakan engine PDF yang sama di semua environment dan snapshot test PDF.
- Risiko: Data terlalu panjang merusak tata letak.
  - Mitigasi: Batasi panjang field + style wrapping yang aman.
- Risiko: Endpoint download disalahgunakan (traffic berlebih).
  - Mitigasi: Rate limiting dan caching file PDF.

## 19. Rencana Tahapan Implementasi
1. Setup entitas database + migration.
2. Bangun Filament Resources untuk semua modul CV.
3. Bangun halaman publik CV.
4. Integrasi PDF generator + template PDF.
5. Validasi acceptance criteria + UAT.
6. Hardening (security, performance, error handling).

## 20. Future Enhancements
- Multi-template CV (modern, minimal, ATS-only).
- Multi-bahasa CV (ID/EN).
- Public share link per versi CV.
- Export DOCX.
- Analytics klik tombol download.

## 21. Dokumen Turunan Implementasi
- Checklist field final Filament: `docs/Filament-Field-Checklist.md`
- Mapping CV acuan ke database: `docs/CV-to-Database-Mapping.md`
- Template konten CV bilingual (ID/EN): `docs/CV-Content-Template-ID-EN.md`

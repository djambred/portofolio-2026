# Mapping CV Jefry ke Struktur Database

Dokumen ini memetakan isi awal dari PDF acuan ke field database yang akan diisi dari panel Filament.

## 1. Sumber Acuan
- Dokumen: CV-Jefry Sunupurwa Asri.pdf
- Catatan: beberapa teks memiliki typo, disarankan normalisasi saat input.

## 2. Mapping Data Profil
### 2.1 Identitas
- Nama: Jefry Sunupurwa Asri -> `profiles.full_name`
- Tempat lahir: Padang -> `profiles.birth_place`
- Tanggal lahir: 16 January 1990 -> `profiles.birth_date`
- Email: jefrysunupurwa@gmail.com -> `profiles.email`
- Kontak: +62821 1122 1990 -> `profiles.phone`
- Instagram: https://instagram.com/djambred -> `profiles.instagram_url` atau `social_links`
- LinkedIn: https://id.linkedin.com/in/djambred -> `profiles.linkedin_url` atau `social_links`

### 2.2 Ringkasan Profil
- Isi PROFILE SUMMARY -> `profiles.summary_en`
- Versi terjemahan Indonesia (perlu ditulis ulang) -> `profiles.summary_id`

## 3. Mapping Pendidikan
### 3.1 Esa Unggul University S2
- Institusi -> `educations.institution_name`
- Degree -> `educations.degree` = Postgraduate (S2)
- Major -> `educations.major` = Computer Science
- Periode -> `educations.start_date`, `educations.end_date`
- GPA 3.75/4 -> `educations.gpa`, `educations.gpa_scale`

### 3.2 Esa Unggul University S1
- Degree -> Bachelor (S1)
- Major -> Computer Science
- Periode dan GPA 3.19/4 -> field yang sama

## 4. Mapping Pengalaman Kerja
### 4.1 PT Rekayasa Informatika Distribusi Indonesia
- Company -> `work_experiences.company_name`
- Position -> `work_experiences.position_title` = Ass. Manager
- Period -> `start_date`/`end_date`
- Tools -> `work_experiences.tools_text`
- Job descriptions -> `work_experiences.description`
- Poin hasil terukur (perlu ditambah) -> `work_experiences.achievements_en` dan `achievements_id`

### 4.2 PT Dompet Unikas Indonesia
- Position -> IT Design, Plan Architecture and Analyst
- Deskripsi role analyst + architecture -> `description`
- Tambahkan hasil terukur agar kuat untuk recruiter -> `achievements_*`

### 4.3 Esa Unggul University
- Position -> Staff Laboratory
- Role -> Assistant Lecturer (opsional disimpan di deskripsi)
- Job descriptions -> `description`

## 5. Mapping Skills
### 5.1 Programming and Tools
- PHP, HTML, CSS, JS, Python, .Net, Unix, Bash, Shell Script
- Simpan per skill sebagai baris terpisah di `skills`
- Category diisi sesuai klasifikasi
- Tambahkan level proficiency saat input di panel

### 5.2 Database
- MySQL, SQL, PostgreSQL -> `skills` category database

### 5.3 Reporting
- Microsoft Office Family, Markdown -> `skills` category reporting/other

## 6. Mapping Sertifikasi
Setiap item sertifikasi menjadi satu baris `certifications`:
- Training SAP an Overview (Monsoon, Jul 2017)
- Cisco CCNA R&S (CISCO, Aug 2017)
- Mikrotik MTCNA (Mikrotik, Jan 2020)
- Network Security CNSS (ICSI, May 2020)
- IT Services Management System (BNSP, Aug 2020)
- Associate Data Scientist (BNSP, Nov 2021)

Field minimal:
- `name`
- `issuer`
- `issued_at`
- `credential_url` (jika ada)

## 7. Mapping Bahasa
Dari CV saat ini:
- Indonesian (native) -> `languages` dengan proficiency native
- English (spoken and written) -> `languages` dengan proficiency professional/intermediate

## 8. Data yang Belum Ada di CV Acuan (Perlu Diisi)
- `profiles.headline`
- `profiles.current_city`
- `profiles.photo_path`
- Modul `projects` (proyek portofolio detail)
- Impact metrics terukur di pengalaman kerja
- Link GitHub/GitLab/website personal
- Ringkasan profil versi bilingual final

## 9. Normalisasi Data yang Disarankan
- Samakan format tanggal: MMM YYYY
- Perbaiki typo:
  - Architechture -> Architecture
  - developt -> developed
  - has been develop -> has been developed
- Standarkan penamaan tools tanpa duplikasi
- Ringkas job descriptions menjadi poin hasil + tanggung jawab

## 10. Prioritas Input ke Panel
1. Isi Profile lengkap + social links
2. Input Work Experiences + achievements terukur
3. Input Educations
4. Input Skills dengan level
5. Input Certifications
6. Input Languages
7. Input Projects minimal 3 studi kasus
8. Set visibility + publish

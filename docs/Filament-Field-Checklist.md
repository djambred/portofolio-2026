# Checklist Field Final per Modul Filament

Dokumen ini adalah turunan implementasi dari PRD untuk mempercepat pembuatan migration, model, dan Filament Resource.

## 1. Modul Profile (single profile)
### 1.1 Tujuan
Menyimpan identitas utama pemilik CV dan pengaturan global tampilan CV.

### 1.2 Tabel
- `profiles`

### 1.3 Field Wajib
- `id` (bigint)
- `user_id` (fk -> users.id)
- `full_name` (string, 120)
- `headline` (string, 160)
- `birth_place` (string, 100)
- `birth_date` (date)
- `current_city` (string, 100)
- `email` (string, 150)
- `phone` (string, 30)
- `summary_id` (text) -> ringkasan Bahasa Indonesia
- `summary_en` (text) -> ringkasan Bahasa Inggris
- `photo_path` (string, 255)
- `cv_status` (enum: draft, published)
- `is_visible` (boolean, default true)
- `created_at`, `updated_at`

### 1.4 Field Opsional
- `website_url` (string, 255, nullable)
- `linkedin_url` (string, 255, nullable)
- `github_url` (string, 255, nullable)
- `instagram_url` (string, 255, nullable)
- `preferred_locale` (enum: id, en, default id)
- `show_birth_date` (boolean, default true)
- `last_published_at` (datetime, nullable)

### 1.5 Validasi Form Filament
- `full_name`: required|min:3|max:120
- `headline`: required|max:160
- `email`: required|email
- `phone`: required|max:30
- URL fields: nullable|url
- `summary_id`, `summary_en`: required|min:40

## 2. Modul Social Links
### 2.1 Tabel
- `social_links`

### 2.2 Field
- `id`
- `profile_id` (fk)
- `platform` (enum: linkedin, github, instagram, x, website, youtube, medium, other)
- `label` (string, 80)
- `url` (string, 255)
- `sort_order` (unsigned integer, default 0)
- `is_visible` (boolean, default true)
- `created_at`, `updated_at`

## 3. Modul Work Experiences
### 3.1 Tabel
- `work_experiences`

### 3.2 Field Wajib
- `id`
- `profile_id` (fk)
- `company_name` (string, 150)
- `position_title` (string, 150)
- `employment_type` (enum: full_time, part_time, contract, internship, freelance)
- `location` (string, 120)
- `start_date` (date)
- `is_current` (boolean, default false)
- `description` (longText)
- `sort_order` (unsigned integer, default 0)
- `is_visible` (boolean, default true)
- `created_at`, `updated_at`

### 3.3 Field Opsional
- `end_date` (date, nullable)
- `tools_text` (text, nullable)
- `achievements_id` (json, nullable) -> list bullet hasil terukur (ID)
- `achievements_en` (json, nullable) -> list bullet hasil terukur (EN)

### 3.4 Validasi
- `end_date` wajib null jika `is_current = true`
- `end_date >= start_date` jika tidak null

## 4. Modul Educations
### 4.1 Tabel
- `educations`

### 4.2 Field
- `id`
- `profile_id` (fk)
- `institution_name` (string, 150)
- `degree` (string, 120)
- `major` (string, 120)
- `start_date` (date)
- `end_date` (date, nullable)
- `gpa` (decimal 3,2, nullable)
- `gpa_scale` (decimal 3,2, default 4.00)
- `description` (text, nullable)
- `sort_order` (unsigned integer, default 0)
- `is_visible` (boolean, default true)
- `created_at`, `updated_at`

## 5. Modul Skills
### 5.1 Tabel
- `skills`

### 5.2 Field
- `id`
- `profile_id` (fk)
- `name` (string, 100)
- `category` (enum: programming, database, devops, analysis, networking, reporting, other)
- `proficiency_level` (enum: beginner, intermediate, advanced, expert)
- `proficiency_score` (unsigned tinyInteger, nullable, range 1-5)
- `years_of_experience` (unsigned tinyInteger, nullable)
- `sort_order` (unsigned integer, default 0)
- `is_visible` (boolean, default true)
- `created_at`, `updated_at`

## 6. Modul Projects
### 6.1 Tabel
- `projects`

### 6.2 Field Wajib
- `id`
- `profile_id` (fk)
- `name` (string, 150)
- `role` (string, 120)
- `description_id` (text)
- `description_en` (text)
- `tech_stack` (json)
- `start_date` (date)
- `is_visible` (boolean, default true)
- `show_on_landing` (boolean, default true)
- `show_on_cv` (boolean, default true)
- `sort_order` (unsigned integer, default 0)
- `created_at`, `updated_at`

### 6.3 Field Opsional
- `end_date` (date, nullable)
- `project_url` (string, 255, nullable)
- `repository_url` (string, 255, nullable)
- `thumbnail_path` (string, 255, nullable)
- `impact_metrics` (json, nullable)

## 7. Modul Certifications
### 7.1 Tabel
- `certifications`

### 7.2 Field
- `id`
- `profile_id` (fk)
- `name` (string, 180)
- `issuer` (string, 150)
- `issued_at` (date)
- `expired_at` (date, nullable)
- `credential_id` (string, 120, nullable)
- `credential_url` (string, 255, nullable)
- `sort_order` (unsigned integer, default 0)
- `is_visible` (boolean, default true)
- `created_at`, `updated_at`

## 8. Modul Languages
### 8.1 Tabel
- `languages`

### 8.2 Field
- `id`
- `profile_id` (fk)
- `name` (string, 80)
- `proficiency` (enum: native, fluent, professional, intermediate, basic)
- `sort_order` (unsigned integer, default 0)
- `is_visible` (boolean, default true)
- `created_at`, `updated_at`

## 9. Modul Highlights (Opsional tetapi direkomendasikan)
### 9.1 Tabel
- `career_highlights`

### 9.2 Field
- `id`
- `profile_id` (fk)
- `title` (string, 160)
- `description_id` (text)
- `description_en` (text)
- `metric_value` (string, 80, nullable)
- `sort_order` (unsigned integer, default 0)
- `is_visible` (boolean, default true)
- `created_at`, `updated_at`

## 10. Komponen Form Filament yang Disarankan
- TextInput: field string sederhana
- RichEditor/MarkdownEditor: summary/deskripsi panjang
- DatePicker: tanggal
- Toggle: is_visible, show_on_landing, show_on_cv
- Select: enum fields
- Repeater: achievements, impact metrics, tech stack
- FileUpload: photo_path, thumbnail_path

## 11. Checklist Implementasi
- [ ] Migration semua tabel selesai
- [ ] Relasi Eloquent selesai
- [ ] Filament Resource per modul selesai
- [ ] Validasi form sesuai aturan
- [ ] Table listing support sorting dan filter visibility
- [ ] Seeder contoh data awal tersedia
- [ ] Data tampil di halaman CV web
- [ ] Data tampil konsisten di PDF

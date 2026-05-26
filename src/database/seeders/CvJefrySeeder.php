<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CvJefrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $owner = User::where('email', 'admin@admin.com')->first() ?? User::first();

        if (! $owner) {
            return;
        }

        DB::transaction(function () use ($owner): void {
            $now = now();

            $profile = DB::table('profiles')->where('user_id', $owner->id)->first();

            $profilePayload = [
                'user_id' => $owner->id,
                'full_name' => 'Jefry Sunupurwa Asri',
                'headline' => 'Lecturer, Developer, IT Design, Architecture and System Analyst',
                'birth_place' => 'Padang',
                'birth_date' => '1990-01-16',
                'current_city' => 'Jakarta',
                'email' => 'jefrysunupurwa@gmail.com',
                'phone' => '+628561121076',
                'photo_path' => 'mine.jpg',
                'nidn' => '0316019003',
                'academic_position' => 'Lektor',
                'professional_summary_id' => 'Praktisi TI dengan pengalaman pada desain arsitektur sistem, analisis kebutuhan, implementasi solusi enterprise, serta pengelolaan delivery aplikasi dan infrastruktur cloud untuk mendorong kualitas layanan dan efisiensi operasional.',
                'professional_summary_en' => 'IT practitioner with experience in system architecture design, requirements analysis, enterprise solution implementation, and application delivery with cloud infrastructure operations to improve service quality and operational efficiency.',
                'academic_summary_id' => 'Dosen Teknik Informatika Universitas Esa Unggul yang aktif mengampu mata kuliah pemrograman, basis data, machine learning, arsitektur layanan, dan jaringan komputer lanjut, serta berkontribusi pada penelitian terindeks SINTA, publikasi bereputasi, dan pengabdian masyarakat berbasis literasi digital.',
                'academic_summary_en' => 'Informatics Engineering lecturer at Universitas Esa Unggul who actively teaches programming, databases, machine learning, service-oriented architecture, and advanced computer networking, while contributing to SINTA-indexed research, reputable publications, and digital literacy-oriented community service.',
                'sinta_overall_score' => 480,
                'sinta_score_3yr' => 178,
                'affil_score' => 0,
                'affil_score_3yr' => 0,
                'summary_id' => 'Sebagai Lecturer: Dosen Teknik Informatika Universitas Esa Unggul yang aktif mengampu mata kuliah pemrograman, basis data, machine learning, arsitektur layanan, dan jaringan komputer lanjut, serta berkontribusi pada penelitian terindeks SINTA, publikasi bereputasi, dan pengabdian masyarakat berbasis literasi digital. Sebagai Professional: Praktisi TI dengan pengalaman pada desain arsitektur sistem, analisis kebutuhan, implementasi solusi enterprise, dan pengelolaan delivery aplikasi serta infrastruktur cloud untuk mendorong kualitas layanan dan efisiensi operasional.',
                'summary_en' => 'As a Lecturer: Informatics Engineering lecturer at Universitas Esa Unggul who actively teaches programming, databases, machine learning, service-oriented architecture, and advanced computer networking, while contributing to SINTA-indexed research, reputable publications, and digital literacy-oriented community service. As a Professional: IT practitioner with experience in system architecture design, requirements analysis, enterprise solution implementation, and application delivery with cloud infrastructure operations to improve service quality and operational efficiency.',
                //'linkedin_url' => 'https://id.linkedin.com/in/djambred',
                'instagram_url' => 'https://instagram.com/djambred',
                'github_url' => 'https://github.com/djambred',
                'preferred_locale' => 'id',
                'show_birth_date' => true,
                'cv_status' => 'published',
                'last_published_at' => $now,
                'is_visible' => true,
                'updated_at' => $now,
            ];

            if ($profile) {
                DB::table('profiles')->where('id', $profile->id)->update($profilePayload);
                $profileId = $profile->id;
            } else {
                $profilePayload['created_at'] = $now;
                $profileId = DB::table('profiles')->insertGetId($profilePayload);
            }

            foreach (['social_links', 'work_experiences', 'educations', 'skills', 'projects', 'certifications', 'languages', 'career_highlights', 'publications'] as $table) {
                DB::table($table)->where('profile_id', $profileId)->delete();
            }

            DB::table('social_links')->insert([
                [
                    'profile_id' => $profileId,
                    'platform' => 'linkedin',
                    'label' => 'LinkedIn',
                    'url' => 'https://id.linkedin.com/in/djambred',
                    'sort_order' => 1,
                    'is_visible' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'profile_id' => $profileId,
                    'platform' => 'instagram',
                    'label' => 'Instagram',
                    'url' => 'https://instagram.com/djambred',
                    'sort_order' => 2,
                    'is_visible' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);

            DB::table('work_experiences')->insert([
                [
                    'profile_id' => $profileId,
                    'company_name' => 'BPKS / Perpusnas',
                    'position_title' => 'Narasumber Review Arsitektur SPBE Perpusnas',
                    'employment_type' => 'contract',
                    'location' => 'Indonesia',
                    'start_date' => '2023-03-01',
                    'end_date' => '2023-05-31',
                    'is_current' => false,
                    'tools_text' => null,
                    'description' => 'Narasumber BPKS untuk review Arsitektur SPBE Perpusnas pada periode Maret-Mei 2023.',
                    'achievements_id' => json_encode([
                        'Memberikan masukan arsitektur SPBE untuk peningkatan tata kelola layanan digital Perpusnas.',
                    ]),
                    'achievements_en' => json_encode([
                        'Provided SPBE architecture review input to improve Perpusnas digital governance.',
                    ]),
                    'sort_order' => 1,
                    'is_visible' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'profile_id' => $profileId,
                    'company_name' => 'BPKS',
                    'position_title' => 'Pembicara dan Narasumber Penyusunan Rencana Induk & Arsitektur SPBE',
                    'employment_type' => 'contract',
                    'location' => 'Indonesia',
                    'start_date' => '2022-04-01',
                    'end_date' => '2022-09-30',
                    'is_current' => false,
                    'tools_text' => null,
                    'description' => 'Pembicara dan narasumber pada kegiatan penyusunan Rencana Induk dan Arsitektur SPBE BPKS periode April-September 2022.',
                    'achievements_id' => json_encode([
                        'Mendukung penyusunan dokumen rencana induk dan arsitektur SPBE BPKS.',
                    ]),
                    'achievements_en' => json_encode([
                        'Supported development of SPBE master plan and architecture documents for BPKS.',
                    ]),
                    'sort_order' => 2,
                    'is_visible' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'profile_id' => $profileId,
                    'company_name' => 'Asesor SPBE Nasional',
                    'position_title' => 'Asesor SPBE (Pemantauan dan Evaluasi/Tauval)',
                    'employment_type' => 'contract',
                    'location' => 'Indonesia',
                    'start_date' => '2022-01-01',
                    'end_date' => '2025-12-31',
                    'is_current' => false,
                    'tools_text' => null,
                    'description' => 'Melaksanakan pemantauan dan evaluasi (tauval) terhadap pelaksanaan Sistem Pemerintahan Berbasis Elektronik (SPBE) di instansi pemerintah pusat maupun daerah (periode 2022-2025).',
                    'achievements_id' => json_encode([
                        'Melakukan asesmen dan evaluasi implementasi SPBE lintas instansi.',
                    ]),
                    'achievements_en' => json_encode([
                        'Conducted monitoring and evaluation of SPBE implementation across government institutions.',
                    ]),
                    'sort_order' => 3,
                    'is_visible' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'profile_id' => $profileId,
                    'company_name' => 'PT Rekayasa Informatika Distribusi Indonesia',
                    'position_title' => 'Assistant Manager',
                    'employment_type' => 'full_time',
                    'location' => 'Jakarta',
                    'start_date' => '2020-08-01',
                    'end_date' => '2021-12-31',
                    'is_current' => false,
                    'tools_text' => 'WSL, VSCode, Microsoft Office, Acrobat Reader, Enterprise Architecture, Winbox, Alibaba Cloud, MobaXterm, Vega Vulnerability Scanner, Navicat, Postman, FileZilla, Balsamiq',
                    'description' => 'Initialized, planned, monitored, and controlled IT projects. Led team rebuilding existing applications into scalable services and adopted microservices architecture. Built development, testing, and production environments using cloud infrastructure and virtualization. Published releases using Docker, Git, and GitLab. Configured VPN network connectivity for head office, branches, and warehouses to support near real-time operations.',
                    'achievements_id' => json_encode([
                        'Memimpin inisiatif modernisasi aplikasi ke arsitektur yang lebih scalable.',
                        'Membangun environment development dan production berbasis cloud.',
                        'Mengimplementasikan konektivitas VPN antar lokasi untuk mendukung data operasional real-time.',
                    ]),
                    'achievements_en' => json_encode([
                        'Led application modernization initiatives toward a more scalable architecture.',
                        'Built development and production environments on cloud infrastructure.',
                        'Implemented VPN connectivity across sites to support real-time operational data.',
                    ]),
                    'sort_order' => 4,
                    'is_visible' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'profile_id' => $profileId,
                    'company_name' => 'PT Dompet Unikas Indonesia',
                    'position_title' => 'IT Design, Plan Architecture and Analyst',
                    'employment_type' => 'full_time',
                    'location' => 'Jakarta',
                    'start_date' => '2018-05-01',
                    'end_date' => '2020-03-31',
                    'is_current' => false,
                    'tools_text' => 'WSL, VSCode, Microsoft Office, Enterprise Architecture, Winbox, Alibaba Cloud, MobaXterm, Vega, SQLYog, Postman, FileZilla, Balsamiq',
                    'description' => 'Designed and implemented network topology and architecture for core payment systems with high availability setup. Produced BRD, FSD, UML, flowcharts, mockups, and user stories across multiple SDLC methodologies. Performed application validation and testing using manual and automated approaches, including API verification and vulnerability scanning. Supported transaction analysis and reporting requirements.',
                    'achievements_id' => json_encode([
                        'Mendesain arsitektur high availability untuk sistem core payment.',
                        'Menyusun artefak analisis bisnis dan teknis end-to-end (BRD, FSD, UML, mockup).',
                        'Meningkatkan kualitas UAT melalui validasi API, pengujian keamanan, dan debugging kode sumber.',
                    ]),
                    'achievements_en' => json_encode([
                        'Designed high-availability architecture for a core payment system.',
                        'Delivered end-to-end business and technical analysis artifacts (BRD, FSD, UML, mockups).',
                        'Improved UAT quality through API validation, security testing, and source code debugging.',
                    ]),
                    'sort_order' => 5,
                    'is_visible' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'profile_id' => $profileId,
                    'company_name' => 'Esa Unggul University',
                    'position_title' => 'Laboratory Staff and Assistant Lecturer',
                    'employment_type' => 'part_time',
                    'location' => 'Jakarta',
                    'start_date' => '2017-10-01',
                    'end_date' => '2020-01-31',
                    'is_current' => false,
                    'tools_text' => null,
                    'description' => 'Oversaw practicum implementation, taught students as assistant lecturer, and managed laboratory materials and assignments.',
                    'achievements_id' => json_encode([
                        'Mendampingi pelaksanaan praktikum dan pembelajaran mahasiswa secara rutin.',
                        'Menjaga kesiapan laboratorium, materi, dan assignment akademik.',
                    ]),
                    'achievements_en' => json_encode([
                        'Supported regular practicum sessions and student learning activities.',
                        'Maintained laboratory readiness, materials, and academic assignments.',
                    ]),
                    'sort_order' => 6,
                    'is_visible' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);

            DB::table('educations')->insert([
                [
                    'profile_id' => $profileId,
                    'institution_name' => 'Esa Unggul University',
                    'degree' => 'Postgraduate Degree (S2)',
                    'major' => 'Magister Computer Science',
                    'start_date' => '2017-10-01',
                    'end_date' => '2019-12-31',
                    'gpa' => 3.75,
                    'gpa_scale' => 4.00,
                    'description' => 'Jakarta, Indonesia',
                    'sort_order' => 1,
                    'is_visible' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'profile_id' => $profileId,
                    'institution_name' => 'Esa Unggul University',
                    'degree' => 'Bachelor Degree (S1)',
                    'major' => 'Computer Science',
                    'start_date' => '2013-02-01',
                    'end_date' => '2017-04-30',
                    'gpa' => 3.19,
                    'gpa_scale' => 4.00,
                    'description' => 'Jakarta, Indonesia',
                    'sort_order' => 2,
                    'is_visible' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);

            DB::table('skills')->insert([
                ['profile_id' => $profileId, 'name' => 'PHP', 'category' => 'programming', 'proficiency_level' => 'advanced', 'proficiency_score' => 4, 'years_of_experience' => 4, 'sort_order' => 1, 'is_visible' => true, 'created_at' => $now, 'updated_at' => $now],
                ['profile_id' => $profileId, 'name' => 'HTML', 'category' => 'programming', 'proficiency_level' => 'advanced', 'proficiency_score' => 4, 'years_of_experience' => 4, 'sort_order' => 2, 'is_visible' => true, 'created_at' => $now, 'updated_at' => $now],
                ['profile_id' => $profileId, 'name' => 'CSS', 'category' => 'programming', 'proficiency_level' => 'intermediate', 'proficiency_score' => 3, 'years_of_experience' => 3, 'sort_order' => 3, 'is_visible' => true, 'created_at' => $now, 'updated_at' => $now],
                ['profile_id' => $profileId, 'name' => 'JavaScript', 'category' => 'programming', 'proficiency_level' => 'intermediate', 'proficiency_score' => 3, 'years_of_experience' => 3, 'sort_order' => 4, 'is_visible' => true, 'created_at' => $now, 'updated_at' => $now],
                ['profile_id' => $profileId, 'name' => 'Python', 'category' => 'programming', 'proficiency_level' => 'intermediate', 'proficiency_score' => 3, 'years_of_experience' => 2, 'sort_order' => 5, 'is_visible' => true, 'created_at' => $now, 'updated_at' => $now],
                ['profile_id' => $profileId, 'name' => '.NET', 'category' => 'programming', 'proficiency_level' => 'intermediate', 'proficiency_score' => 3, 'years_of_experience' => 2, 'sort_order' => 6, 'is_visible' => true, 'created_at' => $now, 'updated_at' => $now],
                ['profile_id' => $profileId, 'name' => 'MySQL', 'category' => 'database', 'proficiency_level' => 'advanced', 'proficiency_score' => 4, 'years_of_experience' => 4, 'sort_order' => 7, 'is_visible' => true, 'created_at' => $now, 'updated_at' => $now],
                ['profile_id' => $profileId, 'name' => 'PostgreSQL', 'category' => 'database', 'proficiency_level' => 'intermediate', 'proficiency_score' => 3, 'years_of_experience' => 2, 'sort_order' => 8, 'is_visible' => true, 'created_at' => $now, 'updated_at' => $now],
                ['profile_id' => $profileId, 'name' => 'Enterprise Architecture', 'category' => 'analysis', 'proficiency_level' => 'advanced', 'proficiency_score' => 4, 'years_of_experience' => 3, 'sort_order' => 9, 'is_visible' => true, 'created_at' => $now, 'updated_at' => $now],
                ['profile_id' => $profileId, 'name' => 'Linux', 'category' => 'devops', 'proficiency_level' => 'advanced', 'proficiency_score' => 4, 'years_of_experience' => 4, 'sort_order' => 10, 'is_visible' => true, 'created_at' => $now, 'updated_at' => $now],
                ['profile_id' => $profileId, 'name' => 'Docker', 'category' => 'devops', 'proficiency_level' => 'intermediate', 'proficiency_score' => 3, 'years_of_experience' => 2, 'sort_order' => 11, 'is_visible' => true, 'created_at' => $now, 'updated_at' => $now],
                ['profile_id' => $profileId, 'name' => 'Networking', 'category' => 'networking', 'proficiency_level' => 'advanced', 'proficiency_score' => 4, 'years_of_experience' => 4, 'sort_order' => 12, 'is_visible' => true, 'created_at' => $now, 'updated_at' => $now],
                ['profile_id' => $profileId, 'name' => 'Microsoft Office', 'category' => 'reporting', 'proficiency_level' => 'advanced', 'proficiency_score' => 4, 'years_of_experience' => 6, 'sort_order' => 13, 'is_visible' => true, 'created_at' => $now, 'updated_at' => $now],
            ]);

            DB::table('projects')->insert([
                [
                    'profile_id' => $profileId,
                    'name' => 'Core Payment Architecture for NOBUePay',
                    'role' => 'IT Architecture Analyst',
                    'description_id' => 'Merancang arsitektur aplikasi inti dengan high availability untuk mendukung kebutuhan pengembangan, UAT, dan produksi pada layanan pembayaran.',
                    'description_en' => 'Designed high-availability core application architecture to support development, UAT, and production workloads for payment services.',
                    'tech_stack' => json_encode(['CentOS 7', 'Nginx', 'Apache', 'PHP', '.NET Core', 'MariaDB Cluster', 'AIX', 'React Native']),
                    'start_date' => '2018-05-01',
                    'end_date' => '2020-03-31',
                    'impact_metrics' => json_encode(['availability_target' => 'high availability', 'environment_coverage' => 'dev, uat, production']),
                    'show_on_landing' => true,
                    'show_on_cv' => true,
                    'sort_order' => 1,
                    'is_visible' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'profile_id' => $profileId,
                    'name' => 'Cloud Deployment and DevOps Modernization',
                    'role' => 'Assistant Manager',
                    'description_id' => 'Memimpin modernisasi deployment aplikasi menggunakan Docker, Git, dan GitLab serta membangun environment cloud untuk development dan production.',
                    'description_en' => 'Led deployment modernization using Docker, Git, and GitLab while building cloud environments for development and production.',
                    'tech_stack' => json_encode(['Docker', 'Git', 'GitLab', 'Alibaba Cloud', 'DigitalOcean', 'Proxmox']),
                    'start_date' => '2020-08-01',
                    'end_date' => '2021-12-31',
                    'impact_metrics' => json_encode(['delivery_improvement' => 'standardized release process', 'infrastructure' => 'cloud and virtualized environments']),
                    'show_on_landing' => true,
                    'show_on_cv' => true,
                    'sort_order' => 2,
                    'is_visible' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);

            DB::table('certifications')->insert([
                ['profile_id' => $profileId, 'name' => 'Training SAP an Overview', 'issuer' => 'Monsoon', 'issued_at' => '2017-07-01', 'sort_order' => 1, 'is_visible' => true, 'created_at' => $now, 'updated_at' => $now],
                ['profile_id' => $profileId, 'name' => 'Training Cisco (CCNA R&S)', 'issuer' => 'CISCO', 'issued_at' => '2017-08-01', 'sort_order' => 2, 'is_visible' => true, 'created_at' => $now, 'updated_at' => $now],
                ['profile_id' => $profileId, 'name' => 'Training Mikrotik (MTCNA)', 'issuer' => 'Mikrotik', 'issued_at' => '2020-01-01', 'sort_order' => 3, 'is_visible' => true, 'created_at' => $now, 'updated_at' => $now],
                ['profile_id' => $profileId, 'name' => 'Training Network Security (CNSS)', 'issuer' => 'ICSI', 'issued_at' => '2020-05-01', 'sort_order' => 4, 'is_visible' => true, 'created_at' => $now, 'updated_at' => $now],
                ['profile_id' => $profileId, 'name' => 'IT Services Management System', 'issuer' => 'BNSP', 'issued_at' => '2020-08-01', 'sort_order' => 5, 'is_visible' => true, 'created_at' => $now, 'updated_at' => $now],
                ['profile_id' => $profileId, 'name' => 'Associate Data Scientist', 'issuer' => 'BNSP', 'issued_at' => '2021-11-01', 'sort_order' => 6, 'is_visible' => true, 'created_at' => $now, 'updated_at' => $now],
            ]);

            DB::table('languages')->insert([
                [
                    'profile_id' => $profileId,
                    'name' => 'Indonesian',
                    'proficiency' => 'native',
                    'sort_order' => 1,
                    'is_visible' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'profile_id' => $profileId,
                    'name' => 'English',
                    'proficiency' => 'professional',
                    'sort_order' => 2,
                    'is_visible' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);

            DB::table('career_highlights')->insert([
                [
                    'profile_id' => $profileId,
                    'title' => 'IT Project Delivery in Financial Services',
                    'description_id' => 'Berpengalaman menangani proyek TI pada sektor layanan keuangan dari fase inisiasi hingga deployment.',
                    'description_en' => 'Experienced in delivering IT projects in financial services from initiation to deployment.',
                    'metric_value' => '2+ years',
                    'sort_order' => 1,
                    'is_visible' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'profile_id' => $profileId,
                    'title' => 'Architecture and Analysis',
                    'description_id' => 'Menggabungkan perencanaan arsitektur, analisis sistem, dan dokumentasi teknis untuk memperkuat kualitas delivery.',
                    'description_en' => 'Combines architecture planning, system analysis, and technical documentation to improve delivery quality.',
                    'metric_value' => 'BRD/FSD/UML',
                    'sort_order' => 2,
                    'is_visible' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'profile_id' => $profileId,
                    'title' => 'Infrastructure and Operations Readiness',
                    'description_id' => 'Menyiapkan environment development, testing, dan production berbasis cloud untuk mendukung operasi yang stabil.',
                    'description_en' => 'Built cloud-based development, testing, and production environments to support stable operations.',
                    'metric_value' => 'Cloud + VPN',
                    'sort_order' => 3,
                    'is_visible' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);
        });
    }
}

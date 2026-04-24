<?php

namespace Database\Seeders;

use App\Models\AlumniProfile;
use App\Models\CareerOpportunity;
use App\Models\EventAgenda;
use App\Models\FaqItem;
use App\Models\GalleryItem;
use App\Models\NewsArticle;
use App\Models\OrganizationMember;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\WorkProgram;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin Alumni FTI',
            'email' => 'admin@alumni-fti.test',
            'role' => 'admin',
        ]);

        $alumniUser = User::factory()->create([
            'name' => 'Perwakilan Alumni',
            'email' => 'alumni@alumni-fti.test',
            'role' => 'alumni',
        ]);

        $alumni = [
            ['name' => 'Raka Pratama', 'program' => 'Teknik Informatika', 'batch_year' => 2017, 'graduation_year' => 2021, 'employer' => 'Tokopedia', 'job_title' => 'Software Engineer', 'city' => 'Jakarta', 'province' => 'DKI Jakarta', 'industry' => 'E-commerce', 'employment_status' => 'Bekerja', 'bio' => 'Aktif di komunitas backend dan mentoring mahasiswa tingkat akhir.', 'achievements' => ['Pemateri Laravel Camp 2025', 'Lead proyek integrasi API pembayaran'], 'testimonial_quote' => 'Komunitas alumni FTI membuka banyak pintu kolaborasi dan karier.', 'is_featured' => true],
            ['name' => 'Nadia Azzahra', 'program' => 'Sistem Informasi', 'batch_year' => 2016, 'graduation_year' => 2020, 'employer' => 'Bank Syariah Indonesia', 'job_title' => 'Business Analyst', 'city' => 'Bandung', 'province' => 'Jawa Barat', 'industry' => 'Financial Services', 'employment_status' => 'Bekerja', 'bio' => 'Berfokus pada transformasi proses bisnis dan digital onboarding.', 'achievements' => ['Best Analyst Project 2024'], 'testimonial_quote' => 'Jaringan alumni membuat transisi kampus ke industri jauh lebih cepat.', 'is_featured' => true],
            ['name' => 'Ilham Saputra', 'program' => 'Teknik Informatika', 'batch_year' => 2018, 'graduation_year' => 2022, 'employer' => 'Traveloka', 'job_title' => 'Data Engineer', 'city' => 'Yogyakarta', 'province' => 'DI Yogyakarta', 'industry' => 'Travel Tech', 'employment_status' => 'Bekerja', 'bio' => 'Mengembangkan pipeline data dan dashboard performa produk.', 'achievements' => ['Speaker Data Day Jogja'], 'testimonial_quote' => 'Alumni jadi tempat bertanya paling relevan soal dunia kerja.', 'is_featured' => true],
            ['name' => 'Putri Maharani', 'program' => 'Teknik Industri', 'batch_year' => 2015, 'graduation_year' => 2019, 'employer' => 'Unilever Indonesia', 'job_title' => 'Supply Chain Planner', 'city' => 'Surabaya', 'province' => 'Jawa Timur', 'industry' => 'Consumer Goods', 'employment_status' => 'Bekerja', 'bio' => 'Mendorong efisiensi operasi dan optimasi distribusi.', 'achievements' => ['Top Young Planner 2023'], 'testimonial_quote' => 'Reuni alumni bukan sekadar nostalgia, tapi ruang kolaborasi nyata.', 'is_featured' => false],
            ['name' => 'Farhan Akbar', 'program' => 'Sistem Informasi', 'batch_year' => 2019, 'graduation_year' => 2023, 'employer' => 'Shopee', 'job_title' => 'UI Engineer', 'city' => 'Jakarta', 'province' => 'DKI Jakarta', 'industry' => 'E-commerce', 'employment_status' => 'Bekerja', 'bio' => 'Fokus pada performa antarmuka dan pengalaman pengguna.', 'achievements' => ['Juara 1 Hackathon UX 2024'], 'testimonial_quote' => 'Kolaborasi lintas angkatan sangat terasa manfaatnya.', 'is_featured' => false],
            ['name' => 'Dewi Safitri', 'program' => 'Teknik Informatika', 'batch_year' => 2014, 'graduation_year' => 2018, 'employer' => 'Dicoding', 'job_title' => 'Curriculum Manager', 'city' => 'Bandung', 'province' => 'Jawa Barat', 'industry' => 'Education Technology', 'employment_status' => 'Bekerja', 'bio' => 'Mendesain kurikulum teknologi yang relevan dengan industri.', 'achievements' => ['Penyusun modul cloud learning nasional'], 'testimonial_quote' => 'FTI memberi pondasi, alumni memperluas dampaknya.', 'is_featured' => false],
            ['name' => 'Bagas Wicaksono', 'program' => 'Teknik Industri', 'batch_year' => 2017, 'graduation_year' => 2021, 'employer' => 'Kementerian BUMN', 'job_title' => 'Project Officer', 'city' => 'Jakarta', 'province' => 'DKI Jakarta', 'industry' => 'Government', 'employment_status' => 'Bekerja', 'bio' => 'Menangani inisiatif transformasi digital lintas lembaga.', 'achievements' => ['Koordinator program digitalisasi UMKM'], 'testimonial_quote' => 'Alumni FTI punya jejaring yang adaptif dan suportif.', 'is_featured' => false],
            ['name' => 'Alya Nurfadila', 'program' => 'Sistem Informasi', 'batch_year' => 2020, 'graduation_year' => 2024, 'employer' => 'Telkom Indonesia', 'job_title' => 'Product Management Trainee', 'city' => 'Bandung', 'province' => 'Jawa Barat', 'industry' => 'Telecommunications', 'employment_status' => 'Bekerja', 'bio' => 'Sedang mendalami product discovery dan agile delivery.', 'achievements' => ['Finalis Product Innovation Challenge'], 'testimonial_quote' => 'Senior alumni banyak membantu saya memahami ritme kerja industri.', 'is_featured' => true],
        ];

        collect($alumni)->each(function (array $alumnus) {
            AlumniProfile::create([
                ...$alumnus,
                'slug' => Str::slug($alumnus['name']),
                'linkedin_url' => 'https://www.linkedin.com',
                'photo_url' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=600&q=80',
                'email' => Str::slug($alumnus['name'], '.') . '@example.com',
                'phone' => '08' . fake()->numerify('##########'),
            ]);
        });

        collect([
            ['name' => 'Dr. Hendra Wijaya', 'role' => 'Ketua Ikatan Alumni', 'division' => 'Pengurus Harian', 'period' => '2025-2029', 'focus_area' => 'Penguatan jejaring dan kemitraan industri', 'sort_order' => 1],
            ['name' => 'Sinta Larasati', 'role' => 'Sekretaris', 'division' => 'Pengurus Harian', 'period' => '2025-2029', 'focus_area' => 'Koordinasi program dan komunikasi organisasi', 'sort_order' => 2],
            ['name' => 'M. Rizqi Ananda', 'role' => 'Bendahara', 'division' => 'Pengurus Harian', 'period' => '2025-2029', 'focus_area' => 'Tata kelola dana kegiatan alumni', 'sort_order' => 3],
            ['name' => 'Nabila Rahma', 'role' => 'Koordinator Karier & Mentoring', 'division' => 'Bidang Program', 'period' => '2025-2029', 'focus_area' => 'Lowongan, magang, dan mentoring alumni', 'sort_order' => 4],
        ])->each(fn(array $member) => OrganizationMember::create($member + [
            'photo_url' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=600&q=80',
        ]));

        collect([
            ['title' => 'Mentoring Karier Alumni Muda', 'category' => 'Karier', 'summary' => 'Program pendampingan alumni baru untuk persiapan karier, CV, portofolio, dan simulasi wawancara.', 'impact_target' => '100 peserta per semester', 'status' => 'Berjalan', 'sort_order' => 1],
            ['title' => 'FTI Industry Connect', 'category' => 'Kolaborasi', 'summary' => 'Mempertemukan alumni dengan mitra industri untuk proyek riset, magang, dan pengembangan talenta.', 'impact_target' => '10 kolaborasi strategis per tahun', 'status' => 'Prioritas', 'sort_order' => 2],
            ['title' => 'Tracer Study Berkelanjutan', 'category' => 'Data Alumni', 'summary' => 'Pengumpulan dan analisis data karier alumni untuk evaluasi kurikulum dan perencanaan program.', 'impact_target' => 'Tingkat respons 70%', 'status' => 'Berjalan', 'sort_order' => 3],
        ])->each(fn(array $program) => WorkProgram::create($program));

        collect([
            ['title' => 'Alumni FTI Luncurkan Program Mentoring Nasional', 'category' => 'Berita', 'excerpt' => 'Ikatan alumni memperluas program mentoring lintas angkatan untuk memperkuat kesiapan karier mahasiswa dan alumni muda.', 'content' => 'Program mentoring nasional mempertemukan alumni berpengalaman dengan mahasiswa tingkat akhir dan lulusan baru. Fokus program mencakup kesiapan karier, penguatan portofolio, dan simulasi proses rekrutmen.', 'is_featured' => true, 'published_at' => now()->subDays(6)],
            ['title' => 'Reuni Akbar FTI 2026 Siap Digelar di Kampus Utama', 'category' => 'Agenda', 'excerpt' => 'Agenda tahunan alumni akan menghadirkan sesi networking, penghargaan alumni, dan showcase kolaborasi industri.', 'content' => 'Reuni akbar tahun ini dirancang lebih kolaboratif dengan sesi business matching, talkshow karier, dan galeri prestasi alumni.', 'is_featured' => false, 'published_at' => now()->subDays(3)],
            ['title' => 'Prestasi Alumni di Bidang AI Terapan Raih Penghargaan Nasional', 'category' => 'Prestasi', 'excerpt' => 'Tim alumni FTI mendapat pengakuan nasional atas implementasi AI untuk otomasi layanan publik.', 'content' => 'Penghargaan ini menegaskan kontribusi alumni FTI dalam mendorong inovasi teknologi yang berdampak langsung pada masyarakat.', 'is_featured' => true, 'published_at' => now()->subDay()],
        ])->each(fn(array $article) => NewsArticle::create($article + [
            'slug' => Str::slug($article['title']),
            'cover_image_url' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80',
        ]));

        collect([
            ['title' => 'Seminar Karier Data & AI', 'slug' => 'seminar-karier-data-ai', 'category' => 'Seminar', 'summary' => 'Sesi bersama alumni praktisi data untuk membahas skill map dan peluang karier terbaru.', 'location' => 'Auditorium FTI', 'starts_at' => now()->addDays(10), 'registration_url' => 'https://forms.alumni-fti.ac.id/seminar-data-ai', 'is_featured' => true],
            ['title' => 'Reuni Lintas Angkatan FTI', 'slug' => 'reuni-lintas-angkatan-fti', 'category' => 'Reuni', 'summary' => 'Ajang temu alumni sekaligus penggalangan ide program kerja dan kemitraan baru.', 'location' => 'Convention Hall Kampus', 'starts_at' => now()->addDays(25), 'registration_url' => 'https://forms.alumni-fti.ac.id/reuni-2026', 'is_featured' => true],
            ['title' => 'Workshop Portofolio Digital', 'slug' => 'workshop-portofolio-digital', 'category' => 'Workshop', 'summary' => 'Pelatihan singkat untuk alumni muda yang ingin meningkatkan kualitas CV dan portofolio digital.', 'location' => 'Ruang Kolaborasi FTI', 'starts_at' => now()->addDays(18), 'registration_url' => 'https://forms.alumni-fti.ac.id/workshop-portfolio', 'is_featured' => false],
        ])->each(fn(array $event) => EventAgenda::create($event));

        collect([
            ['title' => 'Backend Engineer', 'slug' => 'backend-engineer', 'company' => 'GoTo Group', 'location' => 'Jakarta', 'employment_type' => 'Full-time', 'summary' => 'Mencari alumni dengan pengalaman Laravel, distributed systems, dan observability.', 'apply_url' => 'https://linkedin.com/jobs/view/3876543210', 'closes_at' => now()->addDays(14)->toDateString(), 'is_featured' => true],
            ['title' => 'Business Intelligence Analyst', 'slug' => 'business-intelligence-analyst', 'company' => 'Telkom Indonesia', 'location' => 'Bandung', 'employment_type' => 'Full-time', 'summary' => 'Posisi untuk alumni dengan kemampuan analisis data, dashboarding, dan stakeholder management.', 'apply_url' => 'https://www.kalibrr.id/jobs/business-intelligence-analyst-telkom', 'closes_at' => now()->addDays(20)->toDateString(), 'is_featured' => true],
            ['title' => 'UI/UX Intern', 'slug' => 'uiux-intern', 'company' => 'Mekari', 'location' => 'Remote', 'employment_type' => 'Internship', 'summary' => 'Magang untuk alumni baru yang ingin mengembangkan kemampuan desain produk digital.', 'apply_url' => 'https://careers.mekari.com/jobs/uiux-intern', 'closes_at' => now()->addDays(7)->toDateString(), 'is_featured' => false],
        ])->each(fn(array $job) => CareerOpportunity::create($job + [
            'submitted_by' => $alumniUser->id,
            'approved_by' => $admin->id,
            'approval_status' => CareerOpportunity::STATUS_APPROVED,
            'approval_notes' => 'Disetujui seeder admin.',
            'approved_at' => now()->subDay(),
        ]));

        CareerOpportunity::create([
            'title' => 'Mobile Developer (Flutter)',
            'slug' => 'mobile-developer-flutter',
            'company' => 'Startup Alumni Labs',
            'location' => 'Bandung',
            'employment_type' => 'Full-time',
            'summary' => 'Lowongan ini diajukan alumni dan menunggu persetujuan admin.',
            'apply_url' => 'https://www.jobstreet.co.id/en/job/mobile-developer-flutter',
            'closes_at' => now()->addDays(30)->toDateString(),
            'is_featured' => false,
            'submitted_by' => $alumniUser->id,
            'approval_status' => CareerOpportunity::STATUS_PENDING,
        ]);

        collect([
            ['title' => 'Galeri Reuni Akbar 2025', 'media_type' => 'image', 'media_url' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=1200&q=80', 'caption' => 'Momen networking lintas angkatan dalam reuni akbar tahun lalu.', 'event_name' => 'Reuni Akbar 2025', 'published_at' => now()->subMonths(4)],
            ['title' => 'Seminar Industri Digital', 'media_type' => 'image', 'media_url' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1200&q=80', 'caption' => 'Diskusi kolaborasi industri bersama alumni dan mitra perusahaan.', 'event_name' => 'Seminar Industri', 'published_at' => now()->subMonths(2)],
        ])->each(fn(array $item) => GalleryItem::create($item));

        collect([
            ['question' => 'Bagaimana cara memperbarui data alumni?', 'answer' => 'Pada fase pertama, pembaruan data dilakukan melalui formulir eksternal yang ditautkan dari halaman Data Alumni.', 'sort_order' => 1],
            ['question' => 'Apakah lowongan hanya untuk alumni FTI?', 'answer' => 'Mayoritas lowongan diprioritaskan untuk alumni FTI, namun beberapa program kolaborasi juga terbuka bagi mahasiswa tingkat akhir.', 'sort_order' => 2],
            ['question' => 'Bagaimana mengikuti tracer study?', 'answer' => 'Anda dapat membuka halaman Tracer Study lalu mengisi form yang telah disediakan atau menaut ke formulir resmi.', 'sort_order' => 3],
        ])->each(fn(array $faq) => FaqItem::create($faq));

        collect([
            ['name' => 'Raka Pratama', 'batch_year' => 2017, 'role' => 'Software Engineer', 'company' => 'Tokopedia', 'quote' => 'Ikatan alumni FTI membuat proses belajar setelah lulus tetap hidup dan relevan.', 'sort_order' => 1],
            ['name' => 'Nadia Azzahra', 'batch_year' => 2016, 'role' => 'Business Analyst', 'company' => 'BSI', 'quote' => 'Banyak kolaborasi kerja dimulai dari percakapan sederhana di komunitas alumni.', 'sort_order' => 2],
            ['name' => 'Alya Nurfadila', 'batch_year' => 2020, 'role' => 'PM Trainee', 'company' => 'Telkom Indonesia', 'quote' => 'Bagi alumni muda, komunitas ini membantu mempercepat adaptasi ke dunia profesional.', 'sort_order' => 3],
        ])->each(fn(array $testimonial) => Testimonial::create($testimonial + [
            'photo_url' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=600&q=80',
        ]));

        SiteSetting::setValue('home_hero_slides', [
            [
                'title' => 'Bersama Membangun Teknologi dan Karier',
                'subtitle' => 'Jejaring alumni FTI untuk kolaborasi, pembelajaran, dan peluang profesional.',
                'image' => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1600&q=80',
                'cta_label' => 'Lihat Direktori Alumni',
                'cta_url' => '/data-alumni',
            ],
            [
                'title' => 'Kolaborasi Nyata Lintas Angkatan',
                'subtitle' => 'Hubungkan alumni, mahasiswa, dan industri dalam satu ekosistem modern.',
                'image' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&w=1600&q=80',
                'cta_label' => 'Lihat Karier',
                'cta_url' => '/karier-kolaborasi',
            ],
            [
                'title' => 'Peluang Karier Terbaru',
                'subtitle' => 'Jelajahi lowongan pekerjaan eksklusif dari perusahaan-perusahaan terkemuka.',
                'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1600&q=80',
                'cta_label' => 'Jelajahi Karier',
                'cta_url' => '/karier-kolaborasi',
            ],
            [
                'title' => 'Mentoring dan Pengembangan Diri',
                'subtitle' => 'Dapatkan bimbingan dari alumni berpengalaman untuk kemajuan karier Anda.',
                'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1600&q=80',
                'cta_label' => 'Ikuti Program Mentoring',
                'cta_url' => '/berita-agenda',
            ],
            [
                'title' => 'Acara dan Networking Alumni',
                'subtitle' => 'Hadiri berbagai event eksklusif untuk membangun koneksi dan memperluas jaringan.',
                'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1600&q=80',
                'cta_label' => 'Lihat Agenda Event',
                'cta_url' => '/berita-agenda',
            ],
        ]);

        // Add more alumni
        \Database\Factories\AlumniProfileFactory::new()->count(10)->create();

        // Add more news articles
        \Database\Factories\NewsArticleFactory::new()->count(8)->create();

        // Add more events
        \Database\Factories\EventAgendaFactory::new()->count(6)->create();

        // Add more career opportunities
        \Database\Factories\CareerOpportunityFactory::new()->count(5)->create();
    }
}

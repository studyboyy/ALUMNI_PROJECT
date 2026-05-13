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
use Illuminate\Support\Facades\Hash;
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
            'password' => Hash::make('Admin123!'),
        ]);

        $registeredUsers = User::factory()->count(5)->create([
            'role' => 'alumni',
            'password' => Hash::make('Alumni123!'),
        ]);

        $registeredUsers->each(function (User $user) {
            AlumniProfile::factory()->create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'slug' => Str::slug($user->name),
            ]);
        });

        AlumniProfile::factory()->count(5)->create([
            'user_id' => null,
        ]);

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

        CareerOpportunity::factory()->count(6)->create();

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

        NewsArticle::factory()->count(6)->create();
        EventAgenda::factory()->count(4)->create();
    }
}

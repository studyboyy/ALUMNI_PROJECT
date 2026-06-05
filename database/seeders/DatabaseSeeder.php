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
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    // ─────────────────────────────────────────────
    // Pool foto portrait Unsplash — tiap record
    // mendapat foto yang berbeda
    // ─────────────────────────────────────────────
    private static array $memberPhotos = [
        'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?fit=crop&w=600&h=600&q=80',
        'https://images.unsplash.com/photo-1494790108377-be9c29b29330?fit=crop&w=600&h=600&q=80',
        'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?fit=crop&w=600&h=600&q=80',
        'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?fit=crop&w=600&h=600&q=80',
        'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?fit=crop&w=600&h=600&q=80',
        'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?fit=crop&w=600&h=600&q=80',
        'https://images.unsplash.com/photo-1580489944761-15a19d654956?fit=crop&w=600&h=600&q=80',
        'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?fit=crop&w=600&h=600&q=80',
    ];

    private static array $testimonialPhotos = [
        'https://images.unsplash.com/photo-1463453091185-61582044d556?fit=crop&w=200&h=200&q=80',
        'https://images.unsplash.com/photo-1544005313-94ddf0286df2?fit=crop&w=200&h=200&q=80',
        'https://images.unsplash.com/photo-1560250097-0b93528c311a?fit=crop&w=200&h=200&q=80',
        'https://images.unsplash.com/photo-1517841905240-472988babdf9?fit=crop&w=200&h=200&q=80',
        'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?fit=crop&w=200&h=200&q=80',
        'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?fit=crop&w=200&h=200&q=80',
    ];

    public function run(): void
    {
        // ── ADMIN ──────────────────────────────────
        User::factory()->create([
            'name'     => 'Admin Alumni FTI',
            'email'    => 'admin@alumni-fti.test',
            'role'     => 'admin',
            'password' => Hash::make('Admin123!'),
        ]);

        // ── ALUMNI DENGAN AKUN ──────────────────────
        $registeredUsers = User::factory()->count(8)->create([
            'role'     => 'alumni',
            'password' => Hash::make('Alumni123!'),
        ]);

        $registeredUsers->each(function (User $user) {
            AlumniProfile::factory()->create([
                'user_id' => $user->id,
                'name'    => $user->name,
                'email'   => $user->email,
                'slug'    => Str::slug($user->name) . '-' . Str::random(4),
            ]);
        });

        // ── ALUMNI TANPA AKUN (data direktori) ─────
        AlumniProfile::factory()->count(20)->create([
            'user_id' => null,
        ]);

        // ── PENGURUS ORGANISASI ────────────────────
        $orgMembers = [
            ['name' => 'Dr. Hendra Wijaya',   'role' => 'Ketua Ikatan Alumni',          'division' => 'Pengurus Harian',  'period' => '2025–2029', 'focus_area' => 'Penguatan jejaring dan kemitraan industri',     'sort_order' => 1, 'photo' => self::$memberPhotos[0]],
            ['name' => 'Sinta Larasati',       'role' => 'Sekretaris',                   'division' => 'Pengurus Harian',  'period' => '2025–2029', 'focus_area' => 'Koordinasi program dan komunikasi organisasi',  'sort_order' => 2, 'photo' => self::$memberPhotos[1]],
            ['name' => 'M. Rizqi Ananda',      'role' => 'Bendahara',                    'division' => 'Pengurus Harian',  'period' => '2025–2029', 'focus_area' => 'Tata kelola dana dan keuangan alumni',          'sort_order' => 3, 'photo' => self::$memberPhotos[2]],
            ['name' => 'Nabila Rahma',         'role' => 'Koordinator Karier',           'division' => 'Bidang Program',   'period' => '2025–2029', 'focus_area' => 'Lowongan, magang, dan mentoring alumni muda',   'sort_order' => 4, 'photo' => self::$memberPhotos[3]],
            ['name' => 'Dimas Arief Saputra',  'role' => 'Koordinator IT & Data',        'division' => 'Bidang Program',   'period' => '2025–2029', 'focus_area' => 'Digitalisasi layanan alumni dan tracer study',  'sort_order' => 5, 'photo' => self::$memberPhotos[4]],
            ['name' => 'Aulia Putri Santika',  'role' => 'Koordinator Humas & Media',   'division' => 'Bidang Eksternal', 'period' => '2025–2029', 'focus_area' => 'Komunikasi publik dan media sosial alumni',     'sort_order' => 6, 'photo' => self::$memberPhotos[5]],
        ];

        foreach ($orgMembers as $member) {
            OrganizationMember::create([
                'name'       => $member['name'],
                'role'       => $member['role'],
                'division'   => $member['division'],
                'period'     => $member['period'],
                'focus_area' => $member['focus_area'],
                'sort_order' => $member['sort_order'],
                'photo_url'  => $member['photo'],
            ]);
        }

        // ── PROGRAM KERJA ──────────────────────────
        $workPrograms = [
            ['title' => 'Mentoring Karier Alumni Muda',   'category' => 'Karier',      'summary' => 'Program pendampingan alumni baru untuk persiapan karier, CV, portofolio, dan simulasi wawancara.', 'impact_target' => '100 peserta per semester',          'status' => 'Berjalan',   'sort_order' => 1],
            ['title' => 'FTI Industry Connect',           'category' => 'Kolaborasi',  'summary' => 'Mempertemukan alumni dengan mitra industri untuk proyek riset, magang, dan pengembangan talenta.', 'impact_target' => '10 kolaborasi strategis per tahun', 'status' => 'Prioritas',  'sort_order' => 2],
            ['title' => 'Tracer Study Berkelanjutan',     'category' => 'Data Alumni', 'summary' => 'Pengumpulan dan analisis data karier alumni untuk evaluasi kurikulum dan perencanaan program.',     'impact_target' => 'Tingkat respons 70%',               'status' => 'Berjalan',   'sort_order' => 3],
            ['title' => 'Beasiswa Alumni untuk Adik Tingkat', 'category' => 'Sosial',  'summary' => 'Program beasiswa kecil dari dana alumni untuk mahasiswa aktif FTI yang berprestasi dan kurang mampu.', 'impact_target' => '20 penerima per tahun',          'status' => 'Perencanaan','sort_order' => 4],
        ];

        foreach ($workPrograms as $p) {
            WorkProgram::create($p);
        }

        // ── BERITA & ARTIKEL ───────────────────────
        $newsImages = [
            'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?fit=crop&w=1200&q=80',
            'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?fit=crop&w=1200&q=80',
            'https://images.unsplash.com/photo-1515187029135-18ee286d815b?fit=crop&w=1200&q=80',
            'https://images.unsplash.com/photo-1522071820081-009f0129c71c?fit=crop&w=1200&q=80',
            'https://images.unsplash.com/photo-1573164713714-d95e436ab8d6?fit=crop&w=1200&q=80',
        ];

        $articles = [
            ['title' => 'Alumni FTI Luncurkan Program Mentoring Nasional',      'category' => 'Berita',   'is_featured' => true,  'days' => 6,  'excerpt' => 'Ikatan alumni memperluas program mentoring lintas angkatan untuk memperkuat kesiapan karier.', 'content' => 'Program mentoring nasional mempertemukan alumni berpengalaman dengan mahasiswa tingkat akhir dan lulusan baru. Fokus mencakup kesiapan karier, penguatan portofolio, dan simulasi proses rekrutmen.'],
            ['title' => 'Reuni Akbar FTI 2026 Siap Digelar di Kampus Utama',   'category' => 'Agenda',   'is_featured' => false, 'days' => 3,  'excerpt' => 'Agenda tahunan alumni menghadirkan sesi networking, penghargaan, dan showcase kolaborasi.',     'content' => 'Reuni akbar tahun ini dirancang lebih kolaboratif dengan sesi business matching, talkshow karier, dan galeri prestasi alumni.'],
            ['title' => 'Prestasi Alumni di Bidang AI Terapan Raih Penghargaan','category' => 'Prestasi', 'is_featured' => true,  'days' => 1,  'excerpt' => 'Tim alumni FTI mendapat pengakuan nasional atas implementasi AI untuk otomasi layanan publik.',  'content' => 'Penghargaan ini menegaskan kontribusi alumni FTI dalam mendorong inovasi teknologi yang berdampak langsung pada masyarakat.'],
            ['title' => 'FTI Industry Connect: 15 Perusahaan Bergabung',        'category' => 'Kolaborasi','is_featured'=> false,  'days' => 10, 'excerpt' => 'Program kolaborasi industri FTI berhasil menarik 15 perusahaan teknologi terkemuka sebagai mitra.', 'content' => 'Mitra industri akan membuka akses magang eksklusif, proyek riset bersama, dan jalur rekrutmen langsung bagi alumni dan mahasiswa FTI.'],
            ['title' => 'Workshop Data Science Alumni FTI Dihadiri 200 Peserta','category' => 'Workshop',  'is_featured' => false, 'days' => 15, 'excerpt' => 'Workshop dua hari mengupas tren terbaru machine learning dan praktik data engineering di industri.', 'content' => 'Para pembicara adalah alumni senior yang kini bekerja di perusahaan teknologi besar seperti Gojek, Tokopedia, dan Shopee.'],
        ];

        foreach ($articles as $i => $article) {
            NewsArticle::create([
                'title'           => $article['title'],
                'slug'            => Str::slug($article['title']),
                'category'        => $article['category'],
                'excerpt'         => $article['excerpt'],
                'content'         => $article['content'],
                'cover_image_url' => $newsImages[$i % count($newsImages)],
                'is_featured'     => $article['is_featured'],
                'published_at'    => now()->subDays($article['days']),
            ]);
        }

        NewsArticle::factory()->count(4)->create();

        // ── EVENT AGENDA ───────────────────────────
        $events = [
            ['title' => 'Seminar Karier Data & AI',      'slug' => 'seminar-karier-data-ai',      'category' => 'Seminar',   'summary' => 'Sesi bersama alumni praktisi data untuk membahas skill map dan peluang karier terbaru.', 'location' => 'Auditorium FTI, Gedung A',         'starts_at' => now()->addDays(10), 'is_featured' => true,  'registration_url' => 'https://forms.alumni-fti.ac.id/seminar-data-ai'],
            ['title' => 'Reuni Lintas Angkatan FTI',     'slug' => 'reuni-lintas-angkatan-fti',   'category' => 'Reuni',     'summary' => 'Ajang temu alumni sekaligus penggalangan ide program kerja dan kemitraan baru.',       'location' => 'Convention Hall Kampus Utama',     'starts_at' => now()->addDays(25), 'is_featured' => true,  'registration_url' => 'https://forms.alumni-fti.ac.id/reuni-2026'],
            ['title' => 'Workshop Portofolio Digital',   'slug' => 'workshop-portofolio-digital', 'category' => 'Workshop',  'summary' => 'Pelatihan singkat untuk alumni muda yang ingin meningkatkan kualitas CV dan portofolio.',  'location' => 'Ruang Kolaborasi FTI Lt. 3',       'starts_at' => now()->addDays(18), 'is_featured' => false, 'registration_url' => 'https://forms.alumni-fti.ac.id/workshop-portfolio'],
            ['title' => 'Talkshow Startup Alumni FTI',   'slug' => 'talkshow-startup-alumni-fti', 'category' => 'Talkshow',  'summary' => 'Berbagi pengalaman membangun startup dari alumni yang telah berhasil di ekosistem digital.','location' => 'Aula FTI, Gedung Rektorat',        'starts_at' => now()->addDays(32), 'is_featured' => false, 'registration_url' => 'https://forms.alumni-fti.ac.id/talkshow-startup'],
        ];

        foreach ($events as $event) {
            EventAgenda::create($event);
        }

        EventAgenda::factory()->count(2)->create();

        // ── LOWONGAN KARIER ────────────────────────
        CareerOpportunity::factory()->count(8)->create();

        // ── GALERI ─────────────────────────────────
        $galleryItems = [
            ['title' => 'Galeri Reuni Akbar 2025',      'media_url' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?fit=crop&w=1200&q=80', 'caption' => 'Momen networking lintas angkatan dalam reuni akbar tahun lalu.',      'event_name' => 'Reuni Akbar 2025'],
            ['title' => 'Seminar Industri Digital',      'media_url' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?fit=crop&w=1200&q=80', 'caption' => 'Diskusi kolaborasi industri bersama alumni dan mitra perusahaan.',     'event_name' => 'Seminar Industri 2025'],
            ['title' => 'Workshop Data Science 2025',   'media_url' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?fit=crop&w=1200&q=80', 'caption' => 'Peserta antusias mengikuti sesi hands-on data engineering.',           'event_name' => 'Workshop Data Science'],
            ['title' => 'Pelantikan Pengurus Baru 2025','media_url' => 'https://images.unsplash.com/photo-1515187029135-18ee286d815b?fit=crop&w=1200&q=80', 'caption' => 'Serah terima jabatan pengurus Ikatan Alumni FTI periode 2025–2029.',  'event_name' => 'Pelantikan Pengurus 2025'],
        ];

        foreach ($galleryItems as $item) {
            GalleryItem::create([
                'title'        => $item['title'],
                'media_type'   => 'image',
                'media_url'    => $item['media_url'],
                'caption'      => $item['caption'],
                'event_name'   => $item['event_name'],
                'published_at' => now()->subMonths(fake()->numberBetween(1, 6)),
            ]);
        }

        // ── FAQ ────────────────────────────────────
        $faqs = [
            ['question' => 'Bagaimana cara memperbarui data alumni?',             'answer' => 'Login ke akun alumni Anda, lalu buka menu "Update Profil" di dashboard. Perubahan langsung tersimpan ke direktori publik.',                'sort_order' => 1],
            ['question' => 'Apakah lowongan hanya untuk alumni FTI?',             'answer' => 'Mayoritas lowongan diprioritaskan untuk alumni FTI, namun beberapa program kolaborasi terbuka bagi mahasiswa tingkat akhir.',             'sort_order' => 2],
            ['question' => 'Bagaimana mengikuti tracer study?',                   'answer' => 'Buka halaman Tracer Study di navigasi utama dan isi form yang tersedia. Data langsung tersimpan tanpa perlu mengirim email.',             'sort_order' => 3],
            ['question' => 'Siapa yang bisa mengajukan lowongan?',                'answer' => 'Alumni yang sudah memiliki akun aktif dapat mengajukan lowongan melalui menu Submit Lowongan di dashboard. Lowongan akan diverifikasi admin.','sort_order' => 4],
            ['question' => 'Bagaimana cara mendapatkan akun alumni?',             'answer' => 'Klik Daftar di navbar, cari NIM Anda, lalu buat akun dengan email dan password. NIM harus sudah terdaftar oleh admin terlebih dahulu.',   'sort_order' => 5],
            ['question' => 'Apakah data alumni bersifat publik?',                 'answer' => 'Nama, program studi, dan informasi karier alumni bersifat publik. Email dan nomor telepon hanya terlihat di halaman profil detail.',       'sort_order' => 6],
        ];

        foreach ($faqs as $faq) {
            FaqItem::create($faq);
        }

        // ── TESTIMONI ─────────────────────────────
        $testimonials = [
            ['name' => 'Raka Pratama',    'batch_year' => 2017, 'role' => 'Software Engineer',     'company' => 'Tokopedia',        'quote' => 'FTI memberi fondasi yang kuat. Komunitas alumni selalu menjadi sumber inspirasi dan peluang kolaborasi baru.',              'sort_order' => 1, 'photo' => self::$testimonialPhotos[0]],
            ['name' => 'Nadia Azzahra',   'batch_year' => 2016, 'role' => 'Business Analyst',      'company' => 'Bank BSI',         'quote' => 'Banyak kolaborasi kerja yang saya lakukan dimulai dari percakapan sederhana di forum alumni FTI.',                         'sort_order' => 2, 'photo' => self::$testimonialPhotos[1]],
            ['name' => 'Alya Nurfadila',  'batch_year' => 2020, 'role' => 'Product Manager',       'company' => 'Telkom Indonesia', 'quote' => 'Bagi alumni muda, komunitas ini membantu mempercepat adaptasi ke dunia profesional dengan cara yang menyenangkan.',       'sort_order' => 3, 'photo' => self::$testimonialPhotos[2]],
            ['name' => 'Fadhil Nugroho',  'batch_year' => 2018, 'role' => 'Data Scientist',        'company' => 'Gojek',            'quote' => 'Koneksi sesama alumni FTI membuka lebih banyak pintu dari yang saya bayangkan saat masih kuliah.',                        'sort_order' => 4, 'photo' => self::$testimonialPhotos[3]],
            ['name' => 'Nabila Rahma',    'batch_year' => 2019, 'role' => 'UI/UX Designer',        'company' => 'Shopee',           'quote' => 'Program mentoring alumni sangat membantu saya mempersiapkan diri sebelum melamar kerja pertama kali.',                   'sort_order' => 5, 'photo' => self::$testimonialPhotos[4]],
            ['name' => 'Galih Prayoga',   'batch_year' => 2015, 'role' => 'Tech Lead',             'company' => 'Traveloka',        'quote' => 'Ilmu dari FTI jadi kompas profesional saya. Alumni yang saling mendukung adalah aset paling berharga.',                  'sort_order' => 6, 'photo' => self::$testimonialPhotos[5]],
        ];

        foreach ($testimonials as $t) {
            Testimonial::create([
                'name'       => $t['name'],
                'batch_year' => $t['batch_year'],
                'role'       => $t['role'],
                'company'    => $t['company'],
                'quote'      => $t['quote'],
                'sort_order' => $t['sort_order'],
                'photo_url'  => $t['photo'],
            ]);
        }

        // ── SITE SETTINGS ─────────────────────────
        SiteSetting::setValue('home_hero_slides', [
            [
                'title'     => 'Bersama Membangun Teknologi dan Karier',
                'subtitle'  => 'Jejaring alumni FTI untuk kolaborasi, pembelajaran, dan peluang profesional.',
                'image'     => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?fit=crop&w=1600&q=80',
                'cta_label' => 'Lihat Direktori Alumni',
                'cta_url'   => '/data-alumni',
            ],
            [
                'title'     => 'Kolaborasi Nyata Lintas Angkatan',
                'subtitle'  => 'Hubungkan alumni, mahasiswa, dan industri dalam satu ekosistem modern.',
                'image'     => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?fit=crop&w=1600&q=80',
                'cta_label' => 'Lihat Kolaborasi',
                'cta_url'   => '/karier-kolaborasi',
            ],
            [
                'title'     => 'Peluang Karier dari Jaringan Alumni',
                'subtitle'  => 'Lowongan eksklusif dari alumni dan mitra industri terpercaya FTI.',
                'image'     => 'https://images.unsplash.com/photo-1552664730-d307ca884978?fit=crop&w=1600&q=80',
                'cta_label' => 'Jelajahi Karier',
                'cta_url'   => '/karier-kolaborasi',
            ],
        ]);

        SiteSetting::setValue('contact_channels', [
            ['label' => 'Email Humas',      'value' => 'humas@alumni-fti.ac.id'],
            ['label' => 'WhatsApp Admin',   'value' => '+62 811-2222-3333'],
            ['label' => 'Sekretariat',      'value' => 'Gedung FTI Lt. 2, Kampus Utama'],
            ['label' => 'Instagram',        'value' => '@alumni.fti'],
        ]);
    }
}

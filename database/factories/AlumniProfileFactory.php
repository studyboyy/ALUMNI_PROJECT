<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AlumniProfileFactory extends Factory
{
    /**
     * Pool foto portrait dari Unsplash — tiap ID menghasilkan foto yang berbeda.
     * Format: photo.jpg?fit=crop&w=600&h=600&q=80
     * Semua foto bersifat publik dan gratis.
     */
    private static array $photoPool = [
        // Pria
        'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?fit=crop&w=600&h=600&q=80',
        'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?fit=crop&w=600&h=600&q=80',
        'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?fit=crop&w=600&h=600&q=80',
        'https://images.unsplash.com/photo-1531891437562-4301cf35b7e4?fit=crop&w=600&h=600&q=80',
        'https://images.unsplash.com/photo-1489980557514-251d61e3eeb6?fit=crop&w=600&h=600&q=80',
        'https://images.unsplash.com/photo-1463453091185-61582044d556?fit=crop&w=600&h=600&q=80',
        'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?fit=crop&w=600&h=600&q=80',
        'https://images.unsplash.com/photo-1560250097-0b93528c311a?fit=crop&w=600&h=600&q=80',
        'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?fit=crop&w=600&h=600&q=80',
        'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?fit=crop&w=600&h=600&q=80',
        'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?fit=crop&w=600&h=600&q=80',
        'https://images.unsplash.com/photo-1545167622-3a6ac756afa4?fit=crop&w=600&h=600&q=80',
        // Wanita
        'https://images.unsplash.com/photo-1494790108377-be9c29b29330?fit=crop&w=600&h=600&q=80',
        'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?fit=crop&w=600&h=600&q=80',
        'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?fit=crop&w=600&h=600&q=80',
        'https://images.unsplash.com/photo-1544005313-94ddf0286df2?fit=crop&w=600&h=600&q=80',
        'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?fit=crop&w=600&h=600&q=80',
        'https://images.unsplash.com/photo-1580489944761-15a19d654956?fit=crop&w=600&h=600&q=80',
        'https://images.unsplash.com/photo-1534528741775-53994a69daeb?fit=crop&w=600&h=600&q=80',
        'https://images.unsplash.com/photo-1517841905240-472988babdf9?fit=crop&w=600&h=600&q=80',
        'https://images.unsplash.com/photo-1522071820081-009f0129c71c?fit=crop&w=600&h=600&q=80',
        'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?fit=crop&w=600&h=600&q=80',
        'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?fit=crop&w=600&h=600&q=80',
        'https://images.unsplash.com/photo-1610088441520-4352457e7095?fit=crop&w=600&h=600&q=80',
    ];

    private static int $photoIndex = 0;

    private static function nextPhoto(): string
    {
        $photo = self::$photoPool[self::$photoIndex % count(self::$photoPool)];
        self::$photoIndex++;
        return $photo;
    }

    public function definition(): array
    {
        static $names = [
            'Raka Pratama', 'Fadhil Nugroho', 'Dimas Arief', 'Rizqi Ananda', 'Hendra Saputra',
            'Bagas Kurniawan', 'Aldi Setiawan', 'Taufik Hidayat', 'Wahyu Santoso', 'Irfan Maulana',
            'Galih Prayoga', 'Akbar Ramadhan', 'Farhan Hakim', 'Yusuf Abdillah', 'Nanda Putra',
            'Nadia Azzahra', 'Sinta Larasati', 'Alya Nurfadila', 'Nabila Rahma', 'Aulia Putri',
            'Desi Ratnasari', 'Fitri Handayani', 'Laila Zahra', 'Mutia Dewi', 'Rini Kusuma',
            'Indah Permata', 'Yuni Safitri', 'Ayu Lestari', 'Nisa Fadilah', 'Mega Silviana',
        ];

        static $nameIndex = 0;
        $name = $names[$nameIndex % count($names)];
        $nameIndex++;

        $programs = [
            'Teknik Informatika',
            'Sistem Informasi',
            'Teknik Industri',
            'Teknik Elektro',
            'Manajemen Informatika',
        ];

        $campuses = [
            'Universitas Indonesia',
            'Institut Teknologi Bandung',
            'Universitas Gadjah Mada',
            'Universitas Brawijaya',
            'Universitas Diponegoro',
            'Institut Teknologi Sepuluh Nopember',
            'Universitas Padjadjaran',
            'Universitas Hasanuddin',
            'Universitas Andalas',
            'Universitas Airlangga',
        ];

        $employers = [
            'Tokopedia', 'Shopee', 'Gojek', 'Traveloka', 'Grab',
            'Bank BNI', 'Bank BRI', 'Telkom Indonesia', 'Pertamina', 'PLN',
            'Mandiri Sekuritas', 'XL Axiata', 'Indosat Ooredoo', 'DANA',
            'OVO', 'Bukalapak', 'Blibli', 'Tiket.com', 'Ruangguru', 'Kita Bisa',
        ];

        $jobTitles = [
            'Software Engineer', 'Backend Developer', 'Frontend Developer',
            'Full Stack Developer', 'Data Analyst', 'Data Scientist',
            'Product Manager', 'Business Analyst', 'UI/UX Designer',
            'DevOps Engineer', 'System Analyst', 'Network Engineer',
            'IT Project Manager', 'Quality Assurance Engineer', 'Mobile Developer',
        ];

        $industries = [
            'E-commerce', 'Financial Technology', 'Telekomunikasi',
            'Perbankan', 'Energi & Utilitas', 'Pendidikan',
            'Kesehatan Digital', 'Logistik & Supply Chain', 'Media Digital',
            'Konsultasi IT',
        ];

        $cities = [
            'Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Semarang',
            'Medan', 'Makassar', 'Bali', 'Malang', 'Solo',
            'Tangerang', 'Bekasi', 'Depok', 'Bogor', 'Palembang',
        ];

        $provinces = [
            'DKI Jakarta', 'Jawa Barat', 'Jawa Timur', 'DI Yogyakarta', 'Jawa Tengah',
            'Sumatera Utara', 'Sulawesi Selatan', 'Bali', 'Jawa Timur', 'Jawa Tengah',
            'Banten', 'Jawa Barat', 'Jawa Barat', 'Jawa Barat', 'Sumatera Selatan',
        ];

        $cityIndex   = array_rand($cities);
        $batchYear   = fake()->numberBetween(2015, 2022);
        $employer    = fake()->randomElement($employers);
        $jobTitle    = fake()->randomElement($jobTitles);
        $city        = $cities[$cityIndex];
        $province    = $provinces[$cityIndex];

        $bios = [
            'Alumni FTI yang berfokus pada pengembangan aplikasi berbasis cloud dan microservices.',
            'Profesional IT dengan pengalaman lebih dari 3 tahun di industri teknologi dan finansial.',
            'Passionate terhadap data engineering dan machine learning untuk solusi bisnis.',
            'Spesialis pengembangan produk digital dengan pendekatan user-centric design.',
            'Berpengalaman dalam manajemen proyek teknologi dan transformasi digital perusahaan.',
            'Pengembang mobile yang aktif berkontribusi pada komunitas open source Indonesia.',
            'Konsultan IT yang membantu perusahaan mendigitalisasi proses bisnis mereka.',
            'Business analyst yang menjembatani kebutuhan bisnis dengan solusi teknologi tepat guna.',
        ];

        $quotes = [
            'FTI memberi fondasi yang kuat untuk karier teknologi yang saya bangun sekarang.',
            'Komunitas alumni selalu menjadi sumber inspirasi dan peluang kolaborasi baru.',
            'Ilmu yang didapat di kampus menjadi kompas dalam setiap keputusan profesional.',
            'Alumni FTI tersebar di seluruh industri — itu kekuatan jaringan yang luar biasa.',
            'Belajar tidak berhenti saat wisuda, justru semakin seru setelah terjun ke industri.',
            'Koneksi sesama alumni FTI membuka lebih banyak pintu dari yang saya bayangkan.',
        ];

        return [
            'user_id'           => null,
            'nim'               => fake()->unique()->numerify('20####'),
            'name'              => $name,
            'slug'              => Str::slug($name) . '-' . fake()->unique()->numerify('####'),
            'email'             => Str::slug($name) . '@' . fake()->randomElement(['gmail.com', 'yahoo.com', 'outlook.com']),
            'phone'             => '08' . fake()->numerify('##########'),
            'program'           => fake()->randomElement($programs),
            'campus_name'       => fake()->randomElement($campuses),
            'batch_year'        => $batchYear,
            'graduation_year'   => $batchYear + fake()->numberBetween(3, 5),
            'employer'          => $employer,
            'job_title'         => $jobTitle,
            'city'              => $city,
            'province'          => $province,
            'industry'          => fake()->randomElement($industries),
            'employment_status' => fake()->randomElement(['Bekerja', 'Bekerja', 'Bekerja', 'Berwiraswasta', 'Melanjutkan Kuliah']),
            'bio'               => fake()->randomElement($bios),
            'achievements'      => [
                fake()->randomElement([
                    'Juara 1 Hackathon Nasional ' . fake()->numberBetween(2020, 2024),
                    'Speaker di Indonesia Tech Summit ' . fake()->numberBetween(2022, 2024),
                    'Kontributor open source dengan 500+ GitHub stars',
                    'Penerima beasiswa Google Developer Expert',
                    'Co-founder startup yang telah mendapat pendanaan seed',
                    'Certified AWS Solutions Architect',
                    'Finalis kompetisi inovasi digital Kemenkominfo',
                ]),
                fake()->randomElement([
                    'Mentor aktif di program alumni muda FTI',
                    'Bergabung dalam tim inti produk di perusahaan unicorn',
                    'Publikasi riset di jurnal internasional terindeks Scopus',
                    'Pembicara tamu mata kuliah rekayasa perangkat lunak',
                    'Lead engineer untuk produk dengan 1 juta pengguna aktif',
                ]),
            ],
            'linkedin_url'      => 'https://linkedin.com/in/' . Str::slug($name),
            'photo_url'         => self::nextPhoto(),
            'testimonial_quote' => fake()->randomElement($quotes),
            'is_featured'       => fake()->boolean(35),
        ];
    }
}

<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\Guide;
use App\Models\Review;
use App\Models\Thread;
use App\Models\ThreadReply;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $spots = [
            [
                'name' => 'Kota Lama Semarang & Taman Srigunting',
                'category' => 'Sejarah',
                'price_range' => 'Gratis (Parkir Rp 3.000 - Rp 5.000)',
                'budget_tier' => 'Gratis / Parkir Aja',
                'estimated_cost' => 5000,
                'best_time' => 'Sore / Sunset',
                'opening_hours' => '24 Jam (Kafe & galeri 09.00 - 22.00 WIB)',
                'area' => 'Semarang Tengah / Kota Lama',
                'address' => 'Jl. Letjen Suprapto, Tanjung Mas, Kec. Semarang Utara',
                'description' => 'Kawasan bangunan kolonial ikonik dengan Gereja Blenduk, spot foto estetik di setiap sudut gang, sepeda ontel, dan deretan kafe heritage yang hidup menjelang sore hingga malam.',
                'image_url' => 'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'name' => 'Lawang Sewu',
                'category' => 'Sejarah',
                'price_range' => 'Rp 20.000 (Dewasa) / Rp 10.000 (Anak)',
                'budget_tier' => 'Hemat (< Rp 25rb)',
                'estimated_cost' => 20000,
                'best_time' => 'Pagi / Sunrise',
                'opening_hours' => '08.00 - 20.00 WIB',
                'area' => 'Semarang Tengah / Kota Lama',
                'address' => 'Jl. Pemuda No.160, Sekayu, Kec. Semarang Tengah',
                'description' => 'Gedung bersejarah bekas kantor pusat perusahaan kereta api Hindia Belanda dengan arsitektur kaca patri megah dan lorong pintu seribu. Datang pagi hari agar cahaya matahari masuk cantik dan belum terlalu ramai.',
                'image_url' => 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'name' => 'Umbul Sidomukti',
                'category' => 'Alam',
                'price_range' => 'Rp 10.000 - Rp 35.000',
                'budget_tier' => 'Menengah (Rp 25rb - 75rb)',
                'estimated_cost' => 35000,
                'best_time' => 'Pagi / Sunrise',
                'opening_hours' => '08.00 - 18.00 WIB',
                'area' => 'Ungaran / Bandungan',
                'address' => 'Desa Sidomukti, Kec. Bandungan, Kab. Semarang',
                'description' => 'Kolam renang alami di lereng Gunung Ungaran dengan pemandangan lautan awan dan lembah hijau. Tersedia wahana flying fox, jembatan tali, dan Pondok Kopi untuk nongkrong dingin-dingin.',
                'image_url' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'name' => 'Pantai Marina Semarang',
                'category' => 'Pantai',
                'price_range' => 'Rp 10.000 / orang',
                'budget_tier' => 'Hemat (< Rp 25rb)',
                'estimated_cost' => 10000,
                'best_time' => 'Sore / Sunset',
                'opening_hours' => '05.00 - 18.30 WIB',
                'area' => 'Semarang Barat',
                'address' => 'Tawangsari, Kec. Semarang Barat',
                'description' => 'Spot favorit berburu sunset dekat pusat kota dengan tanggul batu pemecah ombak, jogging track pinggir laut, dan perahu wisata keliling teluk.',
                'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'name' => 'Kawasan Kuliner Semawis & Pecinan',
                'category' => 'Kuliner',
                'price_range' => 'Rp 15.000 - Rp 50.000',
                'budget_tier' => 'Menengah (Rp 25rb - 75rb)',
                'estimated_cost' => 35000,
                'best_time' => 'Malam / Kulineran',
                'opening_hours' => 'Jumat - Minggu, 18.00 - 22.30 WIB',
                'area' => 'Semarang Tengah / Kota Lama',
                'address' => 'Jl. Gang Warung, Kranggan, Kec. Semarang Tengah',
                'description' => 'Pasar malam kuliner akhir pekan paling ramai di Semarang. Wajib coba pisang plenet, lumpia basah/goreng, nasi ayam, es puter Cong Lik, dan aneka jajanan khas Pecinan.',
                'image_url' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'name' => 'Brown Canyon Semarang',
                'category' => 'Hidden Gems',
                'price_range' => 'Gratis (Parkir Rp 5.000)',
                'budget_tier' => 'Gratis / Parkir Aja',
                'estimated_cost' => 5000,
                'best_time' => 'Sore / Sunset',
                'opening_hours' => '06.00 - 18.00 WIB',
                'area' => 'Semarang Selatan / Tembalang',
                'address' => 'Rowosari, Kec. Tembalang, Kota Semarang',
                'description' => 'Tebing-tebing bekas galian batu yang membentuk siluet dramatis ala Grand Canyon. Disarankan datang sore di atas jam 16.00 saat truk proyek sudah berhenti beroperasi.',
                'image_url' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=900&q=80',
            ],
        ];

        foreach ($spots as $spot) {
            $dest = Destination::create($spot);

            Review::create([
                'destination_id' => $dest->id,
                'user_name' => 'Rara',
                'rating' => 5,
                'rating_scenery' => 5,
                'rating_access' => 4,
                'rating_cleanliness' => 4,
                'rating_facilities' => 5,
                'visit_period' => 'November 2026',
                'crowd_status' => 'Ramai Lancar',
                'comment' => 'Worth it banget buat dikunjungi! Datang sesuai jam rekomendasi biar dapet pencahayaan dan suasana paling pas.',
                'helpful_count' => 14,
            ]);
        }

        Guide::create([
            'badge' => 'ITINERARY 1 HARI',
            'title' => 'Rute Searah Seharian: Lawang Sewu → Kota Lama → Kuliner Pecinan',
            'excerpt' => 'Rute hemat tanpa bolak-balik jauh di area Semarang Tengah dengan estimasi total budget di bawah Rp 75.000.',
            'content' => "08.30 - Mulai di Lawang Sewu (HTM Rp 20.000) selagi masih sepi.\n11.30 - Makan siang Tahu Gimbal / Lumpia di sekitar Pemuda.\n15.30 - Jalan kaki santai & foto-foto di Kota Lama Semarang.\n18.30 - Lanjut kulineran malam di kawasan Pecinan / Semawis.",
            'author_name' => 'Tim Dolan Semarang',
            'read_time' => '4 menit baca',
            'likes_count' => 38,
        ]);

        Guide::create([
            'badge' => 'TIPS ANTI-HUJAN',
            'title' => '5 Spot Indoor & Kafe Heritage Semarang Saat Cuaca Mendung',
            'excerpt' => 'Rencana jalan-jalan tetap aman meski Semarang lagi gerimis sore hari.',
            'content' => "1. Museum Ranggawarsita (koleksi lengkap & teduh).\n2. Semarang Contemporary Art Gallery di Kota Lama.\n3. Lawang Sewu bagian ruang pamer utama.\n4. Nongkrong di kafe-kafe kolonial sekitar Taman Srigunting.",
            'author_name' => 'Rara',
            'read_time' => '3 menit baca',
            'likes_count' => 27,
        ]);

        $thread = Thread::create([
            'tag' => 'TANYA DOLAN!',
            'title' => 'Rekomendasi tempat sunsetan yang dekat dari Tembalang?',
            'body' => 'Halo teman-teman, kalau sore pulang kuliah dari area Tembalang enaknya ke spot mana ya yang dekat tapi pemandangannya bagus?',
            'author_name' => 'Rara',
        ]);

        ThreadReply::create([
            'thread_id' => $thread->id,
            'author_name' => 'Zizi',
            'reply_text' => 'Bisa langsung melipir ke Brown Canyon di Rowosari kalau di atas jam 4 sore, atau naik dikit ke arah Gombel buat lihat city light Semarang!',
        ]);
    }
}
<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Umkm;
use Database\Seeders\Concerns\SeedsImages;
use Illuminate\Database\Seeder;

class UmkmSeeder extends Seeder
{
    use SeedsImages;

    /**
     * Seed contoh UMKM Kelurahan Tanjung Mas.
     *
     * Nama usaha, pemilik, dan nomor kontak bersifat fiktif.
     */
    public function run(): void
    {
        /** @var array<int, array<string, mixed>> $umkms */
        $umkms = [
            [
                'category' => 'makanan-minuman',
                'name' => 'Sari Laut',
                'slug' => 'sari-laut',
                'owner_name' => 'Bu Siti Aminah',
                'description' => 'Olahan ikan khas pesisir Tanjung Mas, dibuat dari ikan segar hasil tangkapan nelayan setempat tanpa bahan pengawet.',
                'address' => 'Jl. Tanjung Mas Raya No. 12, Tanjung Mas, Semarang Utara',
                'whatsapp' => '081200000001',
                'instagram' => '@sarilaut.tanjungmas',
                'latitude' => -6.9531000,
                'longitude' => 110.4216000,
                'is_featured' => true,
            ],
            [
                'category' => 'makanan-minuman',
                'name' => 'Dapur Bu Lastri',
                'slug' => 'dapur-bu-lastri',
                'owner_name' => 'Bu Lastri Wulandari',
                'description' => 'Camilan dan lauk rumahan, mulai dari keripik, sambal, hingga kue basah yang dibuat setiap hari.',
                'address' => 'Jl. Kakap No. 5, Tanjung Mas, Semarang Utara',
                'whatsapp' => '081200000002',
                'instagram' => '@dapurbulastri',
                'latitude' => -6.9559000,
                'longitude' => 110.4251000,
                'is_featured' => true,
            ],
            [
                'category' => 'kerajinan',
                'name' => 'Anyam Pesisir',
                'slug' => 'anyam-pesisir',
                'owner_name' => 'Pak Darmawan',
                'description' => 'Kerajinan anyaman tangan dari bahan alami: tas, tikar, dan keranjang untuk kebutuhan rumah tangga.',
                'address' => 'Jl. Pelabuhan Gg. 3 No. 8, Tanjung Mas, Semarang Utara',
                'whatsapp' => '081200000003',
                'instagram' => '@anyampesisir',
                'latitude' => -6.9547000,
                'longitude' => 110.4189000,
                'is_featured' => false,
            ],
            [
                'category' => 'fashion',
                'name' => 'Batik Mas Jaya',
                'slug' => 'batik-mas-jaya',
                'owner_name' => 'Bu Rina Susanti',
                'description' => 'Batik tulis dan cap motif khas Semarang, tersedia kain, kemeja, dan scarf dengan sentuhan motif pesisir.',
                'address' => 'Jl. Yos Sudarso No. 21, Tanjung Mas, Semarang Utara',
                'whatsapp' => '081200000004',
                'instagram' => '@batikmasjaya',
                'latitude' => -6.9572000,
                'longitude' => 110.4228000,
                'is_featured' => true,
            ],
            [
                'category' => 'perikanan',
                'name' => 'Nelayan Mandiri',
                'slug' => 'nelayan-mandiri',
                'owner_name' => 'Pak Hasan Basri',
                'description' => 'Kelompok nelayan yang menjual ikan segar, udang, dan cumi langsung dari kapal setiap pagi.',
                'address' => 'Dermaga Tambak Lorok, Tanjung Mas, Semarang Utara',
                'whatsapp' => '081200000005',
                'instagram' => null,
                'latitude' => -6.9498000,
                'longitude' => 110.4262000,
                'is_featured' => false,
            ],
            [
                'category' => 'pertanian',
                'name' => 'Tani Kota Hijau',
                'slug' => 'tani-kota-hijau',
                'owner_name' => 'Bu Yuni Astuti',
                'description' => 'Urban farming warga Tanjung Mas: sayuran hidroponik, bibit, dan tanaman hias dalam pot.',
                'address' => 'Jl. Sumbing Raya No. 17, Tanjung Mas, Semarang Utara',
                'whatsapp' => '081200000006',
                'instagram' => '@tanikotahijau',
                'latitude' => -6.9584000,
                'longitude' => 110.4204000,
                'is_featured' => false,
            ],
            [
                'category' => 'lainnya',
                'name' => 'Laundry Bersih Kilat',
                'slug' => 'laundry-bersih-kilat',
                'owner_name' => 'Pak Andi Prasetyo',
                'description' => 'Jasa cuci kiloan dan satuan dengan layanan antar-jemput di sekitar Kelurahan Tanjung Mas.',
                'address' => 'Jl. Tanjung Mas Timur No. 3, Tanjung Mas, Semarang Utara',
                'whatsapp' => '081200000007',
                'instagram' => null,
                'latitude' => -6.9521000,
                'longitude' => 110.4243000,
                'is_featured' => false,
            ],
            [
                'category' => 'makanan-minuman',
                'name' => 'Lumpia Mbak Wulan',
                'slug' => 'lumpia-mbak-wulan',
                'owner_name' => 'Mbak Wulan Sari',
                'description' => 'Lumpia isi rebung dan udang khas Semarang serta tahu gimbal dan tahu petis, digoreng dadakan saat dipesan.',
                'address' => 'Jl. Ronggowarsito No. 9, Tanjung Mas, Semarang Utara',
                'whatsapp' => '081200000008',
                'instagram' => '@lumpiambakwulan',
                'latitude' => -6.9563000,
                'longitude' => 110.4197000,
                'is_featured' => true,
            ],
            [
                'category' => 'makanan-minuman',
                'name' => 'Kopi Dermaga',
                'slug' => 'kopi-dermaga',
                'owner_name' => 'Mas Bayu Pratama',
                'description' => 'Kedai kopi kecil dekat pelabuhan dengan kopi tubruk, es kopi susu gula aren, dan bubuk kopi robusta untuk dibawa pulang.',
                'address' => 'Jl. Coaster No. 4, Tanjung Mas, Semarang Utara',
                'whatsapp' => '081200000009',
                'instagram' => '@kopidermaga',
                'latitude' => -6.9512000,
                'longitude' => 110.4221000,
                'is_featured' => false,
            ],
            [
                'category' => 'perikanan',
                'name' => 'Asap Bahari Tambak Lorok',
                'slug' => 'asap-bahari-tambak-lorok',
                'owner_name' => 'Bu Sumiyati',
                'description' => 'Pengasapan ikan tradisional Tambak Lorok: ikan manyung asap, mangut siap santap, kerang hijau, dan terasi rebon.',
                'address' => 'Kampung Bahari Tambak Lorok RT 05 RW 15, Tanjung Mas, Semarang Utara',
                'whatsapp' => '081200000010',
                'instagram' => '@asapbahari',
                'latitude' => -6.9506000,
                'longitude' => 110.4278000,
                'is_featured' => true,
            ],
            [
                'category' => 'kerajinan',
                'name' => 'Kerang Craft Bahari',
                'slug' => 'kerang-craft-bahari',
                'owner_name' => 'Mbak Dewi Lestari',
                'description' => 'Suvenir dan hiasan rumah dari kerang laut pesisir Semarang, dirangkai tangan oleh ibu-ibu PKK setempat.',
                'address' => 'Jl. Kakap Gg. 2 No. 14, Tanjung Mas, Semarang Utara',
                'whatsapp' => '081200000011',
                'instagram' => '@kerangcraftbahari',
                'latitude' => -6.9541000,
                'longitude' => 110.4270000,
                'is_featured' => false,
            ],
            [
                'category' => 'makanan-minuman',
                'name' => 'Oleh-oleh Kampung Bahari',
                'slug' => 'oleh-oleh-kampung-bahari',
                'owner_name' => 'Pak Joko Santoso',
                'description' => 'Pusat oleh-oleh khas Semarang di Tanjung Mas: wingko babat, roti ganjel rel, kerupuk udang, dan moaci.',
                'address' => 'Jl. Ronggowarsito No. 30, Tanjung Mas, Semarang Utara',
                'whatsapp' => '081200000012',
                'instagram' => '@olehkampungbahari',
                'latitude' => -6.9578000,
                'longitude' => 110.4183000,
                'is_featured' => false,
            ],
            [
                'category' => 'fashion',
                'name' => 'Busana Muslim Bu Ani',
                'slug' => 'busana-muslim-bu-ani',
                'owner_name' => 'Bu Ani Rahmawati',
                'description' => 'Penjahit rumahan yang membuat mukena bordir, kerudung, dan gamis katun dengan jahitan rapi.',
                'address' => 'Jl. Tanjung Mas Timur Gg. 5 No. 2, Tanjung Mas, Semarang Utara',
                'whatsapp' => '081200000013',
                'instagram' => '@busanabuani',
                'latitude' => -6.9533000,
                'longitude' => 110.4256000,
                'is_featured' => false,
            ],
        ];

        foreach ($umkms as $data) {
            $category = Category::query()
                ->where('slug', $data['category'])
                ->firstOrFail();

            unset($data['category']);

            Umkm::query()->updateOrCreate(
                ['slug' => $data['slug']],
                $data + [
                    'category_id' => $category->id,
                    'cover_image' => $this->seedImage("umkm/{$data['slug']}.jpg"),
                    'status' => 'published',
                ],
            );
        }
    }
}

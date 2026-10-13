<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Umkm;
use Illuminate\Database\Seeder;

class UmkmSeeder extends Seeder
{
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
                    'status' => 'published',
                ],
            );
        }
    }
}

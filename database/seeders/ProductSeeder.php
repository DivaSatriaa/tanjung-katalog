<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Umkm;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Seed contoh produk untuk UMKM yang dibuat oleh UmkmSeeder.
     */
    public function run(): void
    {
        /** @var array<string, array<int, array{0: string, 1: int|null, 2: string, 3?: bool}>> $productsByUmkm */
        $productsByUmkm = [
            'sari-laut' => [
                ['Ikan Asin Tanjung Mas', 25000, 'Ikan asin pilihan yang dijemur alami, gurih dan tidak terlalu asin. Kemasan 250 gram.', true],
                ['Kerupuk Ikan', 15000, 'Kerupuk ikan khas Tanjung Mas dengan cita rasa gurih dan renyah. Diproduksi dari bahan baku ikan segar pilihan.', true],
                ['Bandeng Presto', 30000, 'Bandeng presto empuk hingga ke tulang, siap digoreng atau dipanggang. Isi 1 ekor sekitar 400 gram.', true],
                ['Sambal Ikan', 18000, 'Sambal ikan pedas gurih untuk teman nasi hangat. Botol 150 gram.'],
                ['Abon Ikan', 25000, 'Abon ikan tuna halus tanpa pengawet, cocok untuk lauk dan isian roti. Kemasan 100 gram.'],
            ],
            'dapur-bu-lastri' => [
                ['Keripik Bawang', 10000, 'Keripik bawang renyah dengan bumbu rumahan. Kemasan 150 gram.', true],
                ['Keripik Pisang', 12000, 'Keripik pisang kepok manis dan renyah, digoreng dengan minyak baru.'],
                ['Sambal Bawang Bu Lastri', 20000, 'Sambal bawang pedas harum yang dibuat tanpa pengawet. Botol 200 gram.'],
                ['Kue Lapis Legit Mini', 35000, 'Kue lapis legit mini berlapis rapi dengan rasa mentega yang legit. Isi 6 potong.'],
                ['Es Teh Lemon Botol', 8000, 'Teh lemon segar dalam botol 350 ml, dibuat setiap hari. Simpan di kulkas.'],
            ],
            'anyam-pesisir' => [
                ['Tas Anyaman Pandan', 85000, 'Tas anyaman tangan dari daun pandan dengan lapisan dalam kain katun. Kuat dan ringan.', true],
                ['Tikar Pandan Ukuran Sedang', 60000, 'Tikar anyaman pandan ukuran 120 x 180 cm, nyaman untuk bersantai.'],
                ['Keranjang Serbaguna', 45000, 'Keranjang anyaman untuk menyimpan pakaian, mainan, atau belanjaan.'],
                ['Tempat Tisu Anyaman', 25000, 'Tempat tisu anyaman bambu yang menambah kesan alami di ruang tamu.'],
            ],
            'batik-mas-jaya' => [
                ['Kemeja Batik Cap Semarangan', 175000, 'Kemeja batik cap motif khas Semarang, bahan katun adem. Tersedia ukuran M, L, dan XL.', true],
                ['Kain Batik Tulis Motif Kapal', 350000, 'Kain batik tulis dengan motif kapal dan ombak yang terinspirasi pelabuhan Tanjung Mas. Ukuran 2,4 meter.'],
                ['Scarf Batik Pesisir', 65000, 'Scarf batik berbahan katun primisima, lembut dan mudah dipadukan.'],
                ['Dompet Kain Batik', 40000, 'Dompet kecil dari perca batik, cocok sebagai suvenir.'],
            ],
            'nelayan-mandiri' => [
                ['Ikan Kembung Segar (1 kg)', 38000, 'Ikan kembung segar hasil tangkapan pagi ini, harga per kilogram.'],
                ['Udang Segar (500 g)', 55000, 'Udang segar ukuran sedang, dijual per 500 gram dalam kondisi dingin.'],
                ['Cumi Segar (500 g)', 45000, 'Cumi segar bersih dan siap masak, per 500 gram.'],
            ],
            'tani-kota-hijau' => [
                ['Selada Hidroponik', 12000, 'Selada hidroponik segar tanpa pestisida. Isi 250 gram per kemasan.', true],
                ['Bibit Cabai Rawit', 5000, 'Bibit cabai rawit sehat siap tanam dalam polybag kecil.'],
                ['Tanaman Hias Lidah Mertua', 30000, 'Lidah mertua dalam pot, mudah dirawat dan baik untuk dalam ruangan.'],
            ],
            'laundry-bersih-kilat' => [
                ['Cuci Kiloan Reguler', 7000, 'Cuci dan setrika kiloan, selesai dalam 2 hari. Harga per kilogram.'],
                ['Cuci Selimut dan Bed Cover', null, 'Cuci khusus selimut dan bed cover, hubungi penjual untuk harga sesuai ukuran.'],
            ],
        ];

        foreach ($productsByUmkm as $umkmSlug => $products) {
            $umkm = Umkm::query()
                ->where('slug', $umkmSlug)
                ->firstOrFail();

            foreach ($products as $product) {
                [$name, $price, $description] = $product;

                Product::query()->updateOrCreate(
                    ['slug' => Str::slug($name)],
                    [
                        'umkm_id' => $umkm->id,
                        'name' => $name,
                        'description' => $description,
                        'price' => $price,
                        'is_featured' => $product[3] ?? false,
                        'status' => 'published',
                    ],
                );
            }
        }
    }
}

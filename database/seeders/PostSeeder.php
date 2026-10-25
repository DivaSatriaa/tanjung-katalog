<?php

namespace Database\Seeders;

use App\Models\Post;
use Database\Seeders\Concerns\SeedsImages;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    use SeedsImages;

    private const SOURCE_URL = 'https://tanjungmas.semarangkota.go.id/umkm/';

    /**
     * Berita contoh fiktif dari versi sebelumnya yang diganti berita kelurahan.
     *
     * @var array<int, string>
     */
    private const LEGACY_DEMO_POST_SLUGS = [
        'pelatihan-foto-produk-dengan-ponsel-untuk-pelaku-umkm',
        'tanjungkatalog-resmi-hadir-sebagai-etalase-digital-umkm',
        'bazar-produk-olahan-ikan-ramaikan-kampung-bahari',
        'kampung-bahari-tambak-lorok-bersolek-jadi-wisata-pesisir',
        'kemasan-menarik-bantu-produk-umkm-naik-kelas',
    ];

    /**
     * Seed berita UMKM dari halaman UMKM situs resmi Kelurahan Tanjung Mas.
     */
    public function run(): void
    {
        $this->removeLegacyDemoPosts();

        /** @var array<int, array{title: string, excerpt: string, body: string, image: string, source: string, published_at: string}> $posts */
        $posts = [
            [
                'title' => 'Workshop Branding Industri Program Kemitraan Masyarakat Udinus di Aula Kelurahan Tanjung Mas',
                'excerpt' => 'Camat Semarang Utara membuka workshop teknik logo sebagai media promosi produk UMKM.',
                'body' => "Semarang (28/7/2022) Camat Semarang Utara Drs. Margo Haryadi, M.M. membuka Workshop Branding Industri dengan mengangkat tema \"teknik logo sebagai media promosi produk UMKM dalam meningkatkan nilai jual produk\" dalam rangka mendukung kelurahan ramah perempuan dan peduli anak di Balai Kelurahan Tanjung Mas.\n\nKegiatan tersebut merupakan Program Kemitraan Masyarakat (PKM) Udinus Semarang yang juga dihadiri Luky Widyastuti Puspitaningrum, S.STP, M.Si selaku Sub Koordinator Peningkatan Kualitas Keluarga Dinas Pemberdayaan Perempuan dan Perlindungan Anak Kota Semarang, Elkaf Rahmawan Pramudya, S.Kom., M.Kom. yang juga Dosen Desain Komunikasi Visual (DKV) Universitas Dian Nuswantoro Semarang, Ibu Ika perwakilan Yayasan Anantaka, serta warga Kelurahan Tanjung Mas pengelola UMKM.",
                'image' => 'workshop-branding-industri-pkm-udinus-di-aula-kelurahan-tanjung-mas.jpg',
                'source' => 'workshop-branding-industri-program-kemitraan-masyarakat-udinus-di-aula-kelurahan-tanjung-mas',
                'published_at' => '2022-08-01',
            ],
            [
                'title' => 'Pengurus Gerai KOPIMI Ikut Sosialisasi Perizinan Usaha melalui OSS',
                'excerpt' => 'Pengurus Gerai KOPIMI aktif dalam sosialisasi OSS bersama Dinas Koperasi dan Usaha Mikro Kota Semarang.',
                'body' => 'Selasa (11/2), pengurus Gerai KOPIMI turut berperan aktif dalam sosialisasi perizinan usaha melalui OSS (Online Single Submission) bersama Dinas Koperasi dan Usaha Mikro Kota Semarang.',
                'image' => 'pengurus-gerai-kopimi-ikut-sosialisasi-perizinan-usaha-melalui-oss.jpg',
                'source' => 'osskopimiumkm',
                'published_at' => '2020-02-14',
            ],
            [
                'title' => 'Pelatihan Pemasaran Pengurus Gerai KOPIMI bersama Tokopedia',
                'excerpt' => 'Pengurus Gerai KOPIMI mengikuti pelatihan pemasaran bersama Tokopedia.',
                'body' => 'Kamis (26/12), pengurus Gerai KOPIMI Kelurahan Tanjung Mas mengikuti pelatihan pemasaran bersama Tokopedia.',
                'image' => 'pelatihan-pemasaran-pengurus-gerai-kopimi-bersama-tokopedia.jpg',
                'source' => 'kopimitokopedia',
                'published_at' => '2019-12-26 10:00',
            ],
            [
                'title' => 'Rapat Koordinasi bersama Pengurus Gerai KOPIMI Kelurahan Tanjung Mas',
                'excerpt' => 'Rapat koordinasi bersama pengurus Gerai KOPIMI Kelurahan Tanjung Mas.',
                'body' => 'Jumat (20/12), Kelurahan Tanjung Mas mengadakan rapat koordinasi bersama pengurus Gerai KOPIMI Kelurahan Tanjung Mas.',
                'image' => 'rapat-koordinasi-pengurus-gerai-kopimi-kelurahan-tanjung-mas.jpg',
                'source' => 'rakorgeraimi',
                'published_at' => '2019-12-26 09:00',
            ],
            [
                'title' => 'Kunjungan Dinas Sosial Kota Probolinggo dan Kota Semarang ke Galeri Olahan Ikan Asin Tawangsari',
                'excerpt' => 'Dinas Sosial Kota Probolinggo dan Kota Semarang mengunjungi home industri UMKM di Tawangsari.',
                'body' => 'Jumat (29/11), Dinas Sosial Kota Probolinggo bersama Dinas Sosial Kota Semarang berkunjung ke home industri UMKM dan galeri olahan ikan asin di Tawangsari, Kelurahan Tanjung Mas.',
                'image' => 'kunjungan-dinas-sosial-probolinggo-dan-semarang-ke-galeri-olahan-ikan-asin-tawangsari.jpg',
                'source' => 'kunjungandinsosprobolinggo',
                'published_at' => '2019-11-29',
            ],
            [
                'title' => 'UMKM Kelurahan Tanjung Mas Ikuti Bazar Pengabdian Masyarakat Sekolah Inspektur Polisi Akpol Semarang',
                'excerpt' => 'UMKM Kelurahan Tanjung Mas mengikuti bazar di Kecamatan Semarang Utara.',
                'body' => 'UMKM Kelurahan Tanjung Mas mengikuti bazar dalam rangka mendukung kegiatan pengabdian masyarakat Sekolah Inspektur Polisi Akpol Semarang. Kegiatan bertempat di Kecamatan Semarang Utara pada 19 Agustus 2019.',
                'image' => 'umkm-tanjung-mas-ikuti-bazar-pengabdian-masyarakat-sip-akpol-semarang.jpg',
                'source' => 'akmil',
                'published_at' => '2019-05-29 11:00',
            ],
            [
                'title' => 'UMKM Kelurahan Tanjung Mas pada Perayaan HUT RI ke-73',
                'excerpt' => 'UMKM Kelurahan Tanjung Mas turut meramaikan perayaan HUT RI ke-73.',
                'body' => 'UMKM Kelurahan Tanjung Mas turut meramaikan kegiatan perayaan HUT RI ke-73.',
                'image' => 'umkm-kelurahan-tanjung-mas-meriahkan-hut-ri-ke-73.jpg',
                'source' => 'umkm',
                'published_at' => '2019-05-29 10:00',
            ],
            [
                'title' => 'Hasil Kerajinan UMKM dari Kulit Kerang',
                'excerpt' => 'Kerajinan hiasan karya UMKM Kelurahan Tanjung Mas yang dibuat dari kulit kerang.',
                'body' => 'Hasil kerajinan UMKM Kelurahan Tanjung Mas yang dibuat dari kulit kerang.',
                'image' => 'hasil-kerajinan-umkm-dari-kulit-kerang.jpg',
                'source' => 'umkmkerajinankulitkerang',
                'published_at' => '2019-05-29 09:00',
            ],
            [
                'title' => 'Gerai UMKM Kelurahan Tanjung Mas',
                'excerpt' => 'Gerai UMKM bantuan CSR Petronas diresmikan untuk menampung UMKM Kelurahan Tanjung Mas.',
                'body' => "Dibangun oleh CSR PETRONAS, Kelurahan Tanjung Mas memperoleh bantuan pembangunan gerai UMKM untuk menampung UMKM yang ada di Kelurahan Tanjung Mas guna meningkatkan perekonomian warga.\n\nGerai diresmikan pada tanggal 30 Oktober 2018 oleh istri Wali Kota Semarang dan segenap jajaran PETRONAS.",
                'image' => 'gerai-umkm-kelurahan-tanjung-mas.jpg',
                'source' => 'geraiumkmkelurahantanjungmas',
                'published_at' => '2019-05-26',
            ],
        ];

        foreach ($posts as $post) {
            Post::query()->updateOrCreate(
                ['slug' => Str::slug($post['title'])],
                [
                    'title' => $post['title'],
                    'excerpt' => $post['excerpt'],
                    'body' => $post['body']."\n\nSumber: situs resmi Kelurahan Tanjung Mas, ".self::SOURCE_URL.$post['source'],
                    'cover_image' => $this->seedImage('posts/'.$post['image']),
                    'status' => 'published',
                    'published_at' => $post['published_at'],
                ],
            );
        }
    }

    private function removeLegacyDemoPosts(): void
    {
        Post::query()
            ->whereIn('slug', self::LEGACY_DEMO_POST_SLUGS)
            ->get()
            ->each(function (Post $post): void {
                if ($post->cover_image) {
                    Storage::disk('public')->delete($post->cover_image);
                }

                $post->delete();
            });
    }
}

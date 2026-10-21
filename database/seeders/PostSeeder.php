<?php

namespace Database\Seeders;

use App\Models\Post;
use Database\Seeders\Concerns\SeedsImages;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    use SeedsImages;

    /**
     * Seed contoh berita kegiatan UMKM.
     *
     * Isi berita bersifat contoh dan perlu diganti dengan kabar asli.
     */
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Pelatihan Foto Produk dengan Ponsel untuk Pelaku UMKM',
                'excerpt' => 'Pelaku UMKM belajar memotret produk agar tampil lebih menarik di katalog digital.',
                'body' => "Pelaku UMKM Kelurahan Tanjung Mas mengikuti pelatihan foto produk menggunakan ponsel. Peserta belajar memanfaatkan cahaya alami, memilih latar sederhana, dan mengatur sudut pengambilan gambar.\n\nHasil foto dari pelatihan ini akan dipakai untuk memperbarui tampilan produk di TanjungKatalog sehingga calon pembeli lebih mudah mengenali produk lokal.\n\nPelatihan serupa direncanakan rutin agar semakin banyak pelaku usaha yang siap memasarkan produknya secara digital.",
                'days_ago' => 3,
            ],
            [
                'title' => 'TanjungKatalog Resmi Hadir sebagai Etalase Digital UMKM',
                'excerpt' => 'Katalog digital ini memudahkan warga menemukan usaha dan produk lokal Tanjung Mas.',
                'body' => "TanjungKatalog hadir sebagai etalase digital bagi usaha mikro, kecil, dan menengah di Kelurahan Tanjung Mas. Melalui katalog ini, warga dapat melihat profil usaha, daftar produk, hingga lokasi UMKM di peta.\n\nPengunjung dapat langsung menghubungi penjual melalui WhatsApp dari halaman produk. Pelaku usaha yang ingin terdaftar dapat menghubungi pengelola di kantor kelurahan.",
                'days_ago' => 10,
            ],
            [
                'title' => 'Bazar Produk Olahan Ikan Ramaikan Kampung Bahari',
                'excerpt' => 'Aneka olahan ikan khas pesisir dipamerkan dan dijual langsung oleh pelaku UMKM.',
                'body' => "Bazar produk olahan ikan digelar di kawasan Kampung Bahari dengan menghadirkan berbagai produk khas pesisir, mulai dari bandeng presto, kerupuk ikan, hingga abon ikan.\n\nKegiatan ini menjadi ajang promosi sekaligus mempertemukan pelaku usaha dengan pembeli dari luar kelurahan.",
                'days_ago' => 21,
            ],
            [
                'title' => 'Kampung Bahari Tambak Lorok Bersolek Jadi Wisata Pesisir',
                'excerpt' => 'Kampung nelayan Tambak Lorok kini makin tertata dan mulai dilirik wisatawan.',
                'body' => "Kampung Bahari Tambak Lorok terus berbenah. Deretan perahu nelayan yang berwarna-warni, pasar ikan, dan sentra pengasapan ikan kini menjadi daya tarik bagi pengunjung dari luar kota.\n\nPelaku UMKM setempat ikut merasakan dampaknya. Produk seperti ikan asap, kerang hijau, dan kerajinan kerang semakin banyak dicari sebagai oleh-oleh.\n\nWarga berharap penataan kawasan ini terus berlanjut agar ekonomi pesisir Tanjung Mas semakin kuat.",
                'days_ago' => 30,
            ],
            [
                'title' => 'Kemasan Menarik Bantu Produk UMKM Naik Kelas',
                'excerpt' => 'Pelaku usaha belajar memilih kemasan, label, dan informasi produk yang tepat.',
                'body' => "Puluhan pelaku UMKM Tanjung Mas mengikuti pendampingan kemasan produk. Materi yang dibahas mulai dari memilih bahan kemasan yang aman untuk makanan, membuat label yang jelas, hingga mencantumkan informasi komposisi dan tanggal kedaluwarsa.\n\nKemasan yang rapi membuat produk lebih dipercaya pembeli dan siap dipasarkan ke toko oleh-oleh maupun secara daring.\n\nPeserta juga didorong untuk mendaftarkan izin PIRT agar produknya dapat menjangkau pasar yang lebih luas.",
                'days_ago' => 45,
            ],
        ];

        foreach ($posts as $post) {
            $slug = Str::slug($post['title']);

            Post::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $post['title'],
                    'excerpt' => $post['excerpt'],
                    'body' => $post['body'],
                    'cover_image' => $this->seedImage("posts/{$slug}.jpg"),
                    'status' => 'published',
                    'published_at' => now()->subDays($post['days_ago'])->setTime(9, 0),
                ],
            );
        }
    }
}

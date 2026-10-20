<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
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
        ];

        foreach ($posts as $post) {
            Post::query()->updateOrCreate(
                ['slug' => Str::slug($post['title'])],
                [
                    'title' => $post['title'],
                    'excerpt' => $post['excerpt'],
                    'body' => $post['body'],
                    'status' => 'published',
                    'published_at' => now()->subDays($post['days_ago'])->setTime(9, 0),
                ],
            );
        }
    }
}

<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Pesan Validasi
    |--------------------------------------------------------------------------
    */

    'accepted' => ':attribute harus disetujui.',
    'after' => ':attribute harus tanggal setelah :date.',
    'after_or_equal' => ':attribute harus tanggal setelah atau sama dengan :date.',
    'array' => ':attribute harus berupa daftar.',
    'before' => ':attribute harus tanggal sebelum :date.',
    'before_or_equal' => ':attribute harus tanggal sebelum atau sama dengan :date.',
    'between' => [
        'array' => ':attribute harus memiliki :min sampai :max item.',
        'file' => ':attribute harus berukuran :min sampai :max kilobyte.',
        'numeric' => ':attribute harus bernilai antara :min sampai :max.',
        'string' => ':attribute harus terdiri dari :min sampai :max karakter.',
    ],
    'boolean' => ':attribute harus bernilai ya atau tidak.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'date' => ':attribute bukan tanggal yang valid.',
    'email' => ':attribute harus berupa alamat email yang valid.',
    'exists' => ':attribute yang dipilih tidak valid.',
    'file' => ':attribute harus berupa file.',
    'image' => ':attribute harus berupa gambar.',
    'in' => ':attribute yang dipilih tidak valid.',
    'integer' => ':attribute harus berupa bilangan bulat.',
    'max' => [
        'array' => ':attribute maksimal berisi :max item.',
        'file' => ':attribute maksimal berukuran :max kilobyte.',
        'numeric' => ':attribute maksimal bernilai :max.',
        'string' => ':attribute maksimal :max karakter.',
    ],
    'mimes' => ':attribute harus berupa file dengan format: :values.',
    'mimetypes' => ':attribute harus berupa file dengan format: :values.',
    'min' => [
        'array' => ':attribute minimal berisi :min item.',
        'file' => ':attribute minimal berukuran :min kilobyte.',
        'numeric' => ':attribute minimal bernilai :min.',
        'string' => ':attribute minimal :min karakter.',
    ],
    'numeric' => ':attribute harus berupa angka.',
    'present' => ':attribute wajib ada.',
    'regex' => 'Format :attribute tidak valid.',
    'required' => ':attribute wajib diisi.',
    'string' => ':attribute harus berupa teks.',
    'unique' => ':attribute sudah digunakan.',
    'uploaded' => ':attribute gagal diunggah. Pastikan ukurannya tidak melebihi batas server.',
    'url' => ':attribute harus berupa URL yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Nama Atribut
    |--------------------------------------------------------------------------
    */

    'attributes' => [
        'address' => 'alamat',
        'body' => 'isi berita',
        'category' => 'kategori',
        'category_id' => 'kategori',
        'cover_image' => 'foto sampul',
        'description' => 'deskripsi',
        'email' => 'email',
        'excerpt' => 'ringkasan',
        'gallery' => 'galeri foto',
        'gallery.*' => 'foto galeri',
        'image' => 'foto',
        'instagram' => 'Instagram',
        'is_featured' => 'unggulan',
        'latitude' => 'garis lintang',
        'longitude' => 'garis bujur',
        'name' => 'nama',
        'owner_name' => 'nama pemilik',
        'password' => 'password',
        'phone' => 'nomor telepon',
        'price' => 'harga',
        'published_at' => 'tanggal terbit',
        'q' => 'kata kunci',
        'status' => 'status',
        'title' => 'judul',
        'umkm_id' => 'UMKM',
        'whatsapp' => 'nomor WhatsApp',
    ],

];

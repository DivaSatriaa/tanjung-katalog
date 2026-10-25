<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Umkm;
use Database\Seeders\Support\XlsxReader;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UmkmSeeder extends Seeder
{
    /**
     * Pola kata kunci jenis produk untuk menentukan kategori, dicek berurutan.
     *
     * @var array<int, array{0: string, 1: string}>
     */
    private const CATEGORY_PATTERNS = [
        ['jasa', '/\b(?:jasa|laundry|laundri|binatu|cuci|setrika|ojek|ojol|grab|gojek|jahit|permak|servis|service|bengkel|salon|pangkas|potong rambut|barber|rias|angkut|ekspedisi|kurir|pemasangan|ac\b|sablon|foto ?copy|fotokopi|print|percetakan|rental|sewa|tambal|kursus|les\b|pijat|urut|tukang|parkir|travel|reparasi|cleaning|loundry|londry|kos\b|kost|bimbel|kunci|servic|transportasi|cargo|logistik|persewaan)/u'],
        ['sembako-kelontong', '/\b(?:sembako|kelontong|kebutuhan|keb\.? ?rt|gas\b|lpg|elpiji|isi ulang|galon|air minum|bensin|pertamini|bbm|telur|telor|beras|minyak|rokok|tembakau|pulsa|token|atk|sabun|daging|ayam potong|bahan kue|plastik|grosir|ayam mentah|bumbu|bawang|brambang|kelapa|empon)/u'],
        ['makanan-minuman', '/\b(?:makan|minum|nasi|mie|mi\b|bakmi|bakso|soto|sate|kue|snack|jajan|gorengan|es\b|kopi|catering|katering|roti|martabak|pecel|lauk|masak|olahan|keripik|kripik|kerupuk|krupuk|frozen|donat|seblak|bubur|siomay|cilok|sambal|tahu|tempe|lontong|ketoprak|penyet|burger|sosis|jus|susu|kuliner|dimsum|pempek|rujak|nugget|lumpia|bandung|kolak|pisang|wedang|teh\b|cendol|dawet|bolu|brownies|cake|kerak|takjil|gudeg|rames|mangut|pepes|bothok|botok|tela|gethuk|getuk|serabi|apem|onde|risol|pastel|tape|jamu|minuman|makanan|ayam|peyek|kebab|snak|sneck|angkringan|kucingan|wingko|crispy|krispi|krispy|chicken|chiken|katsu|pia\b|kentucky|egg ?roll|harum manis|seafood|bakar|caterr?ing|ubi\b|kentang|usus|nagor|nasgor|frosen)/u'],
        ['perikanan', '/\b(?:ikan|udang|kerang|cumi|rajungan|kepiting|terasi|rebon|bandeng|teri|lele|nila|kakap|tongkol|asin)/u'],
        ['pertanian', '/\b(?:sayur|tanaman|bibit|bunga|pupuk|pakan|ternak|burung|unggas|buah|tani|kebun|hidroponik)/u'],
        ['fashion', '/\b(?:pakaian|baju|busana|sandal|sepatu|hijab|jilbab|kerudung|kaos|batik|celana|daster|mukena|tas\b|dompet|konveksi|fashion|seragam|sprei|gorden|handuk|acc?esoris|asesoris|accessories|aksesoris|kacamata|gelang|arloji|jam tangan)/u'],
        ['kerajinan', '/\b(?:kerajinan|anyam|souvenir|suvenir|handicraft|handycraft|hiasan|mainan|manik|rajut|craft)/u'],
        ['sembako-kelontong', '/\b(?:toko|warung|kios|kedai)/u'],
    ];

    /**
     * UMKM dan berita contoh fiktif dari versi sebelumnya yang diganti data kelurahan.
     *
     * @var array<int, string>
     */
    private const LEGACY_DEMO_UMKM_SLUGS = [
        'sari-laut', 'dapur-bu-lastri', 'anyam-pesisir', 'batik-mas-jaya', 'nelayan-mandiri',
        'tani-kota-hijau', 'laundry-bersih-kilat', 'lumpia-mbak-wulan', 'kopi-dermaga',
        'asap-bahari-tambak-lorok', 'kerang-craft-bahari', 'oleh-oleh-kampung-bahari', 'busana-muslim-bu-ani',
    ];

    /**
     * @param  string|null  $spreadsheetDirectory  Folder berisi berkas XLSX daftar UMKM dari kelurahan.
     */
    public function __construct(private ?string $spreadsheetDirectory = null) {}

    /**
     * Seed UMKM Kelurahan Tanjung Mas dari daftar UMKM per RW (format XLSX kelurahan).
     *
     * Berkas XLSX tidak disimpan di repositori karena memuat data pribadi
     * warga; letakkan berkasnya di database/seeders/data sebelum seeding.
     */
    public function run(): void
    {
        $this->removeLegacyDemoUmkms();

        $files = File::glob(($this->spreadsheetDirectory ?? database_path('seeders/data')).'/*.xlsx');

        if ($files === []) {
            $this->command?->warn('Lewati UmkmSeeder: letakkan berkas XLSX daftar UMKM kelurahan di database/seeders/data.');

            return;
        }

        $categoryIds = Category::query()->pluck('id', 'slug');

        DB::transaction(function () use ($files, $categoryIds): void {
            foreach ($files as $file) {
                foreach (XlsxReader::read($file) as $sheetName => $rows) {
                    foreach ($this->records($rows) as $record) {
                        $this->seedRecord($record, $sheetName, $categoryIds->all());
                    }
                }
            }
        });
    }

    /**
     * Ubah baris sheet menjadi data UMKM berdasarkan baris judul kolom.
     *
     * @param  array<int, array<int, string>>  $rows
     * @return array<int, array<string, string>>
     */
    private function records(array $rows): array
    {
        $columns = null;
        $records = [];

        foreach ($rows as $cells) {
            if ($columns === null) {
                $headers = array_map(fn (string $value): string => Str::upper(trim($value)), $cells);

                if (in_array('NAMA USAHA', $headers, true)) {
                    $columns = array_flip($headers);
                }

                continue;
            }

            if (Str::upper(trim($cells[0] ?? '')) === 'CONTOH') {
                continue;
            }

            $record = [];

            foreach (['NAMA USAHA', 'JENIS PRODUK', 'NAMA PEMILIK', 'NO HP', 'ALAMAT'] as $header) {
                $record[$header] = isset($columns[$header]) ? $this->clean($cells[$columns[$header]] ?? '') : '';
            }

            if ($record['NAMA USAHA'] === '' && $record['NAMA PEMILIK'] === '') {
                continue;
            }

            $records[] = $record;
        }

        return $records;
    }

    /**
     * Buat UMKM beserta satu produk dari jenis produknya.
     *
     * Data yang sudah ada tidak ditimpa agar perubahan dari panel admin tetap aman
     * saat seeder dijalankan ulang.
     *
     * @param  array<string, string>  $record
     * @param  array<string, int>  $categoryIds
     */
    private function seedRecord(array $record, string $sheetName, array $categoryIds): void
    {
        $owner = $this->titleCase($record['NAMA PEMILIK'], force: true) ?: null;
        $name = $this->titleCase($record['NAMA USAHA'], force: $this->hasLowercaseWord($record['NAMA USAHA']))
            ?: 'Usaha '.($owner ?? 'Warga');
        $productType = $record['JENIS PRODUK'];
        $address = $this->address($record['ALAMAT'], $sheetName);
        [$whatsapp, $phone] = $this->phoneNumbers($record['NO HP']);
        $categorySlug = $this->categorySlug($productType) ?? $this->categorySlug($record['NAMA USAHA']) ?? 'lainnya';

        $umkm = Umkm::query()->firstOrCreate(
            [
                'name' => Str::limit($name, 250, ''),
                'owner_name' => $owner,
                'address' => $address,
            ],
            [
                'slug' => Umkm::uniqueSlugFor($name, fallback: 'umkm'),
                'category_id' => $categoryIds[$categorySlug] ?? $categoryIds['lainnya'],
                'description' => $productType !== '' ? Str::ucfirst(Str::lower($productType)) : null,
                'whatsapp' => $whatsapp,
                'phone' => $phone,
                'status' => 'published',
            ],
        );

        if ($productType === '') {
            return;
        }

        $productName = Str::limit($this->titleCase($productType, force: $this->hasLowercaseWord($productType)), 250, '');
        $intro = Str::lower($productName) === Str::lower($umkm->name) ? '' : "{$productName} dari {$umkm->name}. ";

        Product::query()->firstOrCreate(
            [
                'umkm_id' => $umkm->id,
                'name' => $productName,
            ],
            [
                'slug' => Product::uniqueSlugFor("{$productName} {$umkm->name}", fallback: 'produk'),
                'description' => $intro.'Hubungi penjual untuk harga dan ketersediaan.',
                'status' => 'published',
            ],
        );
    }

    private function categorySlug(string $text): ?string
    {
        $text = Str::lower($text);

        foreach (self::CATEGORY_PATTERNS as [$slug, $pattern]) {
            if (preg_match($pattern, $text) === 1) {
                return $slug;
            }
        }

        return null;
    }

    /**
     * Pisahkan nomor seluler (untuk WhatsApp) dari nomor telepon rumah.
     *
     * @return array{0: string|null, 1: string|null}
     */
    private function phoneNumbers(string $raw): array
    {
        $digits = preg_replace('/\D+/', '', $raw);

        if (str_starts_with($digits, '62')) {
            $digits = '0'.substr($digits, 2);
        } elseif (str_starts_with($digits, '8')) {
            $digits = '0'.$digits;
        }

        if (strlen($digits) < 9 || strlen($digits) > 14 || ! str_starts_with($digits, '0')) {
            return [null, null];
        }

        return str_starts_with($digits, '08') ? [$digits, null] : [null, $digits];
    }

    private function address(string $raw, string $sheetName): ?string
    {
        $address = $this->titleCase(preg_replace('/([.,])(?=\p{L})/u', '$1 ', $raw), force: true);

        if ($address === '') {
            $address = trim(str_replace('Rw', 'RW', Str::title($sheetName)));
        }

        if ($address === '') {
            return null;
        }

        return Str::contains(Str::lower($address), 'tanjung') ? $address : $address.', Tanjung Mas, Semarang Utara';
    }

    /**
     * Ubah teks menjadi Title Case dengan singkatan tetap kapital.
     *
     * Tanpa $force, teks yang sudah bercampur huruf besar-kecil dibiarkan apa adanya.
     */
    private function titleCase(string $text, bool $force = false): string
    {
        if ($text === '') {
            return '';
        }

        if ($force || $text === Str::upper($text) || $text === Str::lower($text)) {
            $text = Str::title(Str::lower($text));
        }

        $text = preg_replace('/\b(rt|rw)\s*\.?\s*(?=\d)/iu', '$1 ', $text);
        $text = preg_replace_callback(
            '/(?<=\s)(Dan|Di|Ke|Dari|Yang|Untuk|Atau|Dengan|Dll)(?=[\s.,]|$)/u',
            fn (array $match): string => Str::lower($match[1]),
            $text,
        );

        return preg_replace_callback(
            '/\b(rt|rw|umkm|cv|pt|ud|ac|lpg|atk|bbm|tni|cpm|pkk|ii|iii|iv)\b/iu',
            fn (array $match): string => Str::upper($match[1]),
            $text,
        );
    }

    private function hasLowercaseWord(string $text): bool
    {
        return preg_match('/(?:^|\s)\p{Ll}/u', $text) === 1;
    }

    private function clean(string $value): string
    {
        $value = trim(preg_replace(['/\s+/u', '/\s*,\s*(?=\S)/u', '/\s*&\s*/u'], [' ', ', ', ' & '], $value));

        return in_array($value, ['-', '0'], true) ? '' : trim($value, " ,.-\t");
    }

    private function removeLegacyDemoUmkms(): void
    {
        Umkm::query()
            ->whereIn('slug', self::LEGACY_DEMO_UMKM_SLUGS)
            ->with('products.images')
            ->get()
            ->each(function (Umkm $umkm): void {
                Storage::disk('public')->delete(array_filter([
                    $umkm->cover_image,
                    ...$umkm->products->pluck('image'),
                    ...$umkm->products->flatMap->images->pluck('path'),
                ]));

                $umkm->delete();
            });
    }
}

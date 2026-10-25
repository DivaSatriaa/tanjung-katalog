<?php

namespace Database\Seeders\Support;

use RuntimeException;
use SimpleXMLElement;
use ZipArchive;

/**
 * Pembaca XLSX sederhana tanpa dependensi tambahan.
 *
 * Hanya membaca nilai sel (teks dan angka) dari setiap sheet; format,
 * rumus, dan gaya diabaikan.
 */
class XlsxReader
{
    private const RELATIONSHIP_NAMESPACE = 'http://schemas.openxmlformats.org/officeDocument/2006/relationships';

    /**
     * Baca semua sheet menjadi baris-baris berisi nilai sel.
     *
     * @return array<string, array<int, array<int, string>>> Nama sheet => nomor baris => indeks kolom (0) => nilai.
     */
    public static function read(string $path): array
    {
        $zip = new ZipArchive;

        if ($zip->open($path) !== true) {
            throw new RuntimeException("Tidak dapat membuka berkas XLSX: {$path}");
        }

        try {
            $sharedStrings = self::sharedStrings($zip);
            $sheets = [];

            foreach (self::sheetPaths($zip) as $name => $sheetPath) {
                $xml = $zip->getFromName($sheetPath);

                if ($xml !== false) {
                    $sheets[$name] = self::rows(self::parse($xml), $sharedStrings);
                }
            }

            return $sheets;
        } finally {
            $zip->close();
        }
    }

    /**
     * @return array<string, string> Nama sheet => path XML di dalam arsip.
     */
    private static function sheetPaths(ZipArchive $zip): array
    {
        $workbook = self::parse((string) $zip->getFromName('xl/workbook.xml'));
        $relations = self::parse((string) $zip->getFromName('xl/_rels/workbook.xml.rels'));

        $targets = [];

        foreach ($relations->Relationship as $relation) {
            $target = ltrim((string) $relation['Target'], '/');
            $targets[(string) $relation['Id']] = str_starts_with($target, 'xl/') ? $target : 'xl/'.$target;
        }

        $paths = [];

        foreach ($workbook->sheets->sheet as $sheet) {
            $relationId = (string) $sheet->attributes(self::RELATIONSHIP_NAMESPACE)['id'];

            if (isset($targets[$relationId])) {
                $paths[(string) $sheet['name']] = $targets[$relationId];
            }
        }

        return $paths;
    }

    /**
     * @return array<int, string>
     */
    private static function sharedStrings(ZipArchive $zip): array
    {
        $xml = $zip->getFromName('xl/sharedStrings.xml');

        if ($xml === false) {
            return [];
        }

        $strings = [];

        foreach (self::parse($xml)->si as $item) {
            $strings[] = self::inlineText($item);
        }

        return $strings;
    }

    /**
     * @param  array<int, string>  $sharedStrings
     * @return array<int, array<int, string>>
     */
    private static function rows(SimpleXMLElement $sheet, array $sharedStrings): array
    {
        $rows = [];

        foreach ($sheet->sheetData->row as $row) {
            $rowNumber = (int) $row['r'];
            $cells = [];
            $columnIndex = -1;

            foreach ($row->c as $cell) {
                $columnIndex = isset($cell['r']) ? self::columnIndex((string) $cell['r']) : $columnIndex + 1;

                $value = match ((string) $cell['t']) {
                    's' => $sharedStrings[(int) $cell->v] ?? '',
                    'inlineStr' => self::inlineText($cell->is),
                    default => self::numberToString((string) $cell->v),
                };

                if ($value !== '') {
                    $cells[$columnIndex] = $value;
                }
            }

            if ($cells !== []) {
                $rows[$rowNumber] = $cells;
            }
        }

        return $rows;
    }

    private static function inlineText(SimpleXMLElement $item): string
    {
        if (isset($item->t)) {
            return (string) $item->t;
        }

        $text = '';

        foreach ($item->r as $run) {
            $text .= (string) $run->t;
        }

        return $text;
    }

    /**
     * Angka besar (mis. nomor HP) kadang disimpan dalam notasi ilmiah.
     */
    private static function numberToString(string $value): string
    {
        if (is_numeric($value) && stripos($value, 'e') !== false) {
            return sprintf('%.0f', (float) $value);
        }

        return $value;
    }

    private static function columnIndex(string $reference): int
    {
        $letters = preg_replace('/\d+/', '', $reference);
        $index = 0;

        foreach (str_split(strtoupper($letters)) as $letter) {
            $index = $index * 26 + (ord($letter) - 64);
        }

        return $index - 1;
    }

    private static function parse(string $xml): SimpleXMLElement
    {
        $element = simplexml_load_string($xml, SimpleXMLElement::class, LIBXML_NONET);

        if ($element === false) {
            throw new RuntimeException('Isi XLSX tidak valid.');
        }

        return $element;
    }
}

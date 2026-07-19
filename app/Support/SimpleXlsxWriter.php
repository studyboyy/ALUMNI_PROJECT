<?php

namespace App\Support;

use XLSXWriter;

class SimpleXlsxWriter
{
    /**
     * @param  array<int, string>  $headers
     * @param  array<int, array<int, string|int|float|null>>  $rows
     * @param  array<int, float|int>  $widths
     */
    public static function make(string $title, array $headers, array $rows, array $widths = []): string
    {
        $writer = new XLSXWriter;
        $writer->setAuthor('Alumni FTI');
        $writer->setTempDir(storage_path('framework/cache'));

        $headerTypes = array_fill_keys($headers, 'string');

        $writer->writeSheetHeader($title, $headerTypes, [
            'widths' => $widths,
            'auto_filter' => true,
            'freeze_rows' => 1,
            'font' => 'Arial',
            'font-size' => 10,
            'font-style' => 'bold',
            'fill' => '#E85D57',
            'color' => '#FFFFFF',
            'halign' => 'center',
            'valign' => 'center',
            'border' => 'left,right,top,bottom',
            'border-style' => 'thin',
            'border-color' => '#E2E8F0',
            'wrap_text' => true,
            'height' => 24,
        ]);

        foreach ($rows as $row) {
            $writer->writeSheetRow($title, self::normalizeRow($row, count($headers)), [
                'font' => 'Arial',
                'font-size' => 10,
                'valign' => 'top',
                'border' => 'left,right,top,bottom',
                'border-style' => 'thin',
                'border-color' => '#E2E8F0',
                'wrap_text' => true,
                'height' => 20,
            ]);
        }

        return $writer->writeToString();
    }

    /**
     * @param  array<int, string|int|float|null>  $row
     * @return array<int, string>
     */
    private static function normalizeRow(array $row, int $columnCount): array
    {
        $normalized = [];

        for ($index = 0; $index < $columnCount; $index++) {
            $value = $row[$index] ?? '-';
            $normalized[] = $value === null || $value === '' ? '-' : (string) $value;
        }

        return $normalized;
    }
}

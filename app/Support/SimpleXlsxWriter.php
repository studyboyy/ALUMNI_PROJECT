<?php

namespace App\Support;

class SimpleXlsxWriter
{
    /**
     * @param  array<int, array<int, string|int|float|null>>  $rows
     * @param  array<int, float|int>  $widths
     */
    public static function make(string $title, array $headers, array $rows, array $widths = []): string
    {
        $lastColumn = self::columnName(count($headers));
        $lastDataRow = max(count($rows) + 4, 4);

        $sheetXml = self::sheetXml($title, $headers, $rows, $widths, $lastColumn, $lastDataRow);

        $zip = new self();
        $zip->addFile('[Content_Types].xml', self::contentTypesXml());
        $zip->addFile('_rels/.rels', self::relsXml());
        $zip->addFile('xl/workbook.xml', self::workbookXml($title));
        $zip->addFile('xl/_rels/workbook.xml.rels', self::workbookRelsXml());
        $zip->addFile('xl/styles.xml', self::stylesXml());
        $zip->addFile('xl/worksheets/sheet1.xml', $sheetXml);
        $zip->addFile('docProps/core.xml', self::coreXml($title));
        $zip->addFile('docProps/app.xml', self::appXml());

        return $zip->toString();
    }

    /** @var array<int, array{name: string, contents: string}> */
    private array $files = [];

    private function addFile(string $name, string $contents): void
    {
        $this->files[] = compact('name', 'contents');
    }

    private function toString(): string
    {
        $local = '';
        $central = '';
        $offset = 0;

        foreach ($this->files as $file) {
            $name = $file['name'];
            $contents = $file['contents'];
            $crc = crc32($contents);
            $size = strlen($contents);
            $nameLength = strlen($name);

            $localHeader = pack('VvvvvvVVVvv', 0x04034b50, 20, 0, 0, 0, 0, $crc, $size, $size, $nameLength, 0)
                . $name
                . $contents;

            $central .= pack('VvvvvvvVVVvvvvvVV', 0x02014b50, 20, 20, 0, 0, 0, 0, $crc, $size, $size, $nameLength, 0, 0, 0, 0, 0, $offset)
                . $name;

            $local .= $localHeader;
            $offset += strlen($localHeader);
        }

        $centralOffset = strlen($local);
        $centralSize = strlen($central);
        $fileCount = count($this->files);

        return $local
            . $central
            . pack('VvvvvVVv', 0x06054b50, 0, 0, $fileCount, $fileCount, $centralSize, $centralOffset, 0);
    }

    /**
     * @param  array<int, string>  $headers
     * @param  array<int, array<int, string|int|float|null>>  $rows
     * @param  array<int, float|int>  $widths
     */
    private static function sheetXml(string $title, array $headers, array $rows, array $widths, string $lastColumn, int $lastDataRow): string
    {
        $cols = '';
        foreach ($headers as $index => $_header) {
            $columnIndex = $index + 1;
            $width = $widths[$index] ?? 18;
            $cols .= '<col min="' . $columnIndex . '" max="' . $columnIndex . '" width="' . $width . '" customWidth="1"/>';
        }

        $sheetRows = [];
        $sheetRows[] = '<row r="1" ht="26" customHeight="1">' . self::cell('A', 1, $title, 1) . '</row>';
        $sheetRows[] = '<row r="2">' . self::cell('A', 2, 'Dibuat pada ' . now()->format('d/m/Y H:i'), 2) . '</row>';
        $sheetRows[] = '<row r="3"></row>';

        $headerCells = '';
        foreach ($headers as $index => $header) {
            $headerCells .= self::cell(self::columnName($index + 1), 4, $header, 3);
        }
        $sheetRows[] = '<row r="4" ht="22" customHeight="1">' . $headerCells . '</row>';

        foreach ($rows as $rowIndex => $row) {
            $excelRow = $rowIndex + 5;
            $cells = '';

            foreach ($headers as $columnIndex => $_header) {
                $value = $row[$columnIndex] ?? '';
                $cells .= self::cell(self::columnName($columnIndex + 1), $excelRow, $value, 4);
            }

            $sheetRows[] = '<row r="' . $excelRow . '">' . $cells . '</row>';
        }

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<sheetViews><sheetView workbookViewId="0"><pane ySplit="4" topLeftCell="A5" activePane="bottomLeft" state="frozen"/></sheetView></sheetViews>'
            . '<sheetFormatPr defaultRowHeight="18"/>'
            . '<cols>' . $cols . '</cols>'
            . '<sheetData>' . implode('', $sheetRows) . '</sheetData>'
            . '<mergeCells count="2"><mergeCell ref="A1:' . $lastColumn . '1"/><mergeCell ref="A2:' . $lastColumn . '2"/></mergeCells>'
            . '<autoFilter ref="A4:' . $lastColumn . $lastDataRow . '"/>'
            . '<pageMargins left="0.3" right="0.3" top="0.5" bottom="0.5" header="0.3" footer="0.3"/>'
            . '</worksheet>';
    }

    private static function cell(string $column, int $row, string|int|float|null $value, int $style): string
    {
        $value = $value === null || $value === '' ? '-' : (string) $value;

        return '<c r="' . $column . $row . '" t="inlineStr" s="' . $style . '"><is><t xml:space="preserve">'
            . self::escape($value)
            . '</t></is></c>';
    }

    private static function columnName(int $number): string
    {
        $name = '';

        while ($number > 0) {
            $number--;
            $name = chr(65 + ($number % 26)) . $name;
            $number = intdiv($number, 26);
        }

        return $name;
    }

    private static function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_XML1, 'UTF-8');
    }

    private static function contentTypesXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            . '<Default Extension="xml" ContentType="application/xml"/>'
            . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            . '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
            . '<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'
            . '<Override PartName="/docProps/core.xml" ContentType="application/vnd.openxmlformats-package.core-properties+xml"/>'
            . '<Override PartName="/docProps/app.xml" ContentType="application/vnd.openxmlformats-officedocument.extended-properties+xml"/>'
            . '</Types>';
    }

    private static function relsXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
            . '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/package/2006/relationships/metadata/core-properties" Target="docProps/core.xml"/>'
            . '<Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/extended-properties" Target="docProps/app.xml"/>'
            . '</Relationships>';
    }

    private static function workbookXml(string $title): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<sheets><sheet name="' . self::escape(substr($title, 0, 31)) . '" sheetId="1" r:id="rId1"/></sheets>'
            . '</workbook>';
    }

    private static function workbookRelsXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'
            . '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'
            . '</Relationships>';
    }

    private static function stylesXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<fonts count="3"><font><sz val="10"/><name val="Calibri"/></font><font><b/><sz val="16"/><color rgb="FF0F172A"/><name val="Calibri"/></font><font><b/><sz val="10"/><color rgb="FFFFFFFF"/><name val="Calibri"/></font></fonts>'
            . '<fills count="3"><fill><patternFill patternType="none"/></fill><fill><patternFill patternType="gray125"/></fill><fill><patternFill patternType="solid"><fgColor rgb="FFE85D57"/><bgColor indexed="64"/></patternFill></fill></fills>'
            . '<borders count="2"><border><left/><right/><top/><bottom/><diagonal/></border><border><left style="thin"><color rgb="FFE2E8F0"/></left><right style="thin"><color rgb="FFE2E8F0"/></right><top style="thin"><color rgb="FFE2E8F0"/></top><bottom style="thin"><color rgb="FFE2E8F0"/></bottom><diagonal/></border></borders>'
            . '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
            . '<cellXfs count="5">'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/>'
            . '<xf numFmtId="0" fontId="1" fillId="0" borderId="0" xfId="0" applyFont="1"><alignment vertical="center"/></xf>'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"><alignment vertical="center"/></xf>'
            . '<xf numFmtId="0" fontId="2" fillId="2" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1"><alignment horizontal="center" vertical="center" wrapText="1"/></xf>'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0" applyBorder="1"><alignment vertical="top" wrapText="1"/></xf>'
            . '</cellXfs>'
            . '<cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles>'
            . '</styleSheet>';
    }

    private static function coreXml(string $title): string
    {
        $timestamp = now()->toIso8601String();

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<cp:coreProperties xmlns:cp="http://schemas.openxmlformats.org/package/2006/metadata/core-properties" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:dcterms="http://purl.org/dc/terms/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">'
            . '<dc:title>' . self::escape($title) . '</dc:title><dc:creator>Alumni FTI</dc:creator>'
            . '<dcterms:created xsi:type="dcterms:W3CDTF">' . $timestamp . '</dcterms:created>'
            . '<dcterms:modified xsi:type="dcterms:W3CDTF">' . $timestamp . '</dcterms:modified>'
            . '</cp:coreProperties>';
    }

    private static function appXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Properties xmlns="http://schemas.openxmlformats.org/officeDocument/2006/extended-properties" xmlns:vt="http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes">'
            . '<Application>Alumni FTI</Application>'
            . '</Properties>';
    }
}

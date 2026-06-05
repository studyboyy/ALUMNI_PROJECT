<?php

namespace App\Http\Controllers;

use App\Models\AlumniProfile;
use Illuminate\Http\Response;

class AlumniExportController extends Controller
{
    public function export(): Response
    {
        $alumni = AlumniProfile::query()
            ->orderBy('batch_year')
            ->orderBy('name')
            ->get();

        $columns = [
            'No', 'Nama', 'NIM', 'Email', 'No HP',
            'Program Studi', 'Kampus', 'Angkatan', 'Tahun Lulus',
            'Status Pekerjaan', 'Perusahaan / Instansi', 'Jabatan',
            'Bidang Industri', 'Kota', 'Provinsi', 'LinkedIn',
        ];

        // Tulis ke buffer in-memory
        $handle = fopen('php://temp', 'r+');

        // BOM UTF-8 supaya Excel langsung baca dengan benar
        fwrite($handle, "\xEF\xBB\xBF");

        fputcsv($handle, $columns);

        foreach ($alumni as $i => $row) {
            fputcsv($handle, [
                $i + 1,
                $row->name,
                $row->nim ?? '-',
                $row->email ?? '-',
                $row->phone ?? '-',
                $row->program,
                $row->campus_name ?? '-',
                $row->batch_year,
                $row->graduation_year ?? '-',
                $row->employment_status ?? '-',
                $row->employer ?? '-',
                $row->job_title ?? '-',
                $row->industry ?? '-',
                $row->city ?? '-',
                $row->province ?? '-',
                $row->linkedin_url ?? '-',
            ]);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        $filename = 'data-alumni-' . now()->format('Y-m-d') . '.csv';

        return response($csv, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Content-Length'      => strlen($csv),
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'no-store, no-cache, must-revalidate',
        ]);
    }
}

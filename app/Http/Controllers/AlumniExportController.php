<?php

namespace App\Http\Controllers;

use App\Models\AlumniProfile;
use App\Support\SimpleXlsxWriter;
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

        $rows = $alumni->map(function (AlumniProfile $row, int $i): array {
            return [
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
            ];
        })->all();

        $xlsx = SimpleXlsxWriter::make('Data Alumni', $columns, $rows, [
            7, 24, 18, 28, 18, 24, 26, 12, 14, 20, 26, 24, 22, 18, 20, 34,
        ]);

        $filename = 'data-alumni-' . now()->format('Y-m-d') . '.xlsx';

        return response($xlsx, 200, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Content-Length'      => strlen($xlsx),
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'no-store, no-cache, must-revalidate',
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\TracerStudyResponse;
use App\Support\SimpleXlsxWriter;
use Illuminate\Http\Response;

class TracerStudyExportController extends Controller
{
    public function export(): Response
    {
        $responses = TracerStudyResponse::query()
            ->orderBy('batch_year')
            ->orderBy('name')
            ->get();

        $columns = [
            'No', 'Nama', 'NIM', 'Email', 'No HP',
            'Program Studi', 'Angkatan', 'Tahun Lulus',
            'Status Pekerjaan', 'Perusahaan/Instansi', 'Jabatan',
            'Bidang Industri', 'Kota Bekerja', 'Provinsi',
            'Kesesuaian Bidang Studi', 'Lama Cari Kerja (Bulan)',
            'Rating Kurikulum (1-5)', 'Saran', 'Tanggal Isi',
        ];

        $rows = $responses->map(function (TracerStudyResponse $row, int $i): array {
            return [
                $i + 1,
                $row->name,
                $row->nim ?? '-',
                $row->email,
                $row->phone ?? '-',
                $row->program,
                $row->batch_year,
                $row->graduation_year ?? '-',
                $row->employment_status,
                $row->employer ?? '-',
                $row->job_title ?? '-',
                $row->industry ?? '-',
                $row->city ?? '-',
                $row->province ?? '-',
                $row->job_relevance ?? '-',
                $row->waiting_time_months !== null ? $row->waiting_time_months : '-',
                $row->curriculum_rating ?? '-',
                $row->suggestion ?? '-',
                $row->created_at?->format('d/m/Y H:i'),
            ];
        })->all();

        $xlsx = SimpleXlsxWriter::make('Tracer Study', $columns, $rows, [
            7, 24, 18, 28, 18, 24, 12, 14, 20, 26, 24, 22, 18, 20, 24, 20, 20, 42, 18,
        ]);

        $filename = 'tracer-study-' . now()->format('Y-m-d') . '.xlsx';

        return response($xlsx, 200, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Content-Length'      => strlen($xlsx),
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'no-store, no-cache, must-revalidate',
        ]);
    }
}

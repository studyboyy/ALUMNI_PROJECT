<?php

namespace App\Http\Controllers;

use App\Models\TracerStudyResponse;
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

        $handle = fopen('php://temp', 'r+');

        // BOM UTF-8
        fwrite($handle, "\xEF\xBB\xBF");

        fputcsv($handle, $columns);

        foreach ($responses as $i => $row) {
            fputcsv($handle, [
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
            ]);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        $filename = 'tracer-study-' . now()->format('Y-m-d') . '.csv';

        return response($csv, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Content-Length'      => strlen($csv),
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'no-store, no-cache, must-revalidate',
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PantauAbsen extends Controller
{
    public function show()
    {
        try {
            $today = now()->toDateString();
            $absensi = Absensi::with([
                'user' => function ($query) {
                    $query->select('id', 'name', 'username', 'role', 'fotoprofil');
                },
                'lokasi' => function ($query) {
                    $query->select('id', 'name', 'type', 'alamat', 'radius', 'jam_masuk', 'jam_sampai', 'latitude', 'longitude');
                }
            ])->paginate(10)
                ->withQueryString();

            return view('pantau-absen', compact('absensi'));
        } catch (\Exception $e) {
            Log::error('Error in PantauAbsen@show: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat riwayat absensi');
        }
    }

    public function showNow()
    {
        try {
            $today = now()->toDateString();
            $absensi = Absensi::with([
                'user' => function ($query) {
                    $query->select('id', 'name', 'username', 'role', 'fotoprofil');
                },
                'lokasi' => function ($query) {
                    $query->select('id', 'name', 'type', 'alamat', 'radius', 'jam_masuk', 'jam_sampai', 'latitude', 'longitude');
                }
            ])
                ->whereDate('created_at', $today)
                ->orderBy('created_at', 'desc')
                ->paginate(10)
                ->withQueryString();

            return view('pantau-absen', compact('absensi'));
        } catch (\Exception $e) {
            Log::error('Error in PantauAbsen@show: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat riwayat absensi');
        }
    }

    public function showSort()
    {
        try {
            $year = request('year') ?? date('Y');
            $month = request('month') ?? date('m');

            $absensi = Absensi::with([
                'user' => function ($query) {
                    $query->select('id', 'name', 'username', 'role', 'fotoprofil');
                },
                'lokasi' => function ($query) {
                    $query->select('id', 'name', 'type', 'alamat', 'radius', 'jam_masuk', 'jam_sampai', 'latitude', 'longitude');
                }
            ])
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->orderBy('created_at', 'desc')
                ->paginate(10)
                ->withQueryString();

            return view('pantau-absen', compact('absensi', 'year', 'month'));
        } catch (\Exception $e) {
            Log::error('Error in PantauAbsen@showNow: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat riwayat absensi');
        }
    }

    public function export()
    {
        try {

            $today = now()->toDateString();
            $year = request('year');
            $month = request('month');
            $filter = request('filter');

            $query = Absensi::with(['user', 'lokasi']);

            if (request()->has('filter') || $year || $month) {
                if ($filter === 'today') {
                    $query->whereDate('created_at', $today)->orderBy('created_at', 'desc');
                } elseif ($year && $month) {
                    $query->whereYear('created_at', $year)->whereMonth('created_at', $month)->orderBy('created_at', 'desc');
                }
            } else {
                $query->orderBy('created_at', 'desc');
            }

            $absensi = $query->get();
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // ===================== BAGIAN ATAS (MERGE JUDUL) =====================
            $sheet->mergeCells('A1:K1')->setCellValue('A1', 'REKAP PRESENSI TENAGA PENDIDIK DAN TENAGA KEPENDIDIKAN');
            $sheet->mergeCells('A2:K2')->setCellValue('A2', 'SDIT ARRAHMAH TUKUM TEKUNG LUMAJANG');
            // Gunakan filter tahun dan bulan jika tersedia, jika tidak gunakan bulan dan tahun saat ini
            $bulan = $month ? str_pad($month, 2, '0', STR_PAD_LEFT) : now()->format('m');
            $tahun = $year ?? now()->format('Y');
            // Konversi angka bulan ke nama bulan
            $namaBulan = \Carbon\Carbon::createFromFormat('m', $bulan)->translatedFormat('F');
            $sheet->mergeCells('A3:K3')->setCellValue('A3', 'BULAN : ' . strtoupper($namaBulan . ' ' . $tahun));

            // ===================== HEADER =====================
            $headers = ['No','Nama', 'Tanggal', 'Tipe', 'Status Waktu', 'Status Lokasi', 'Nama Lokasi', 'Alamat Lokasi', 'Tipe Lokasi', 'Durasi', 'Catatan'];
            $sheet->fromArray($headers, null, 'A7');

            // ===================== ISI TABEL =====================
            $row = 8;
            foreach ($absensi as $index => $absen) {
                $sheet->setCellValue("A{$row}", $index + 1);
                $sheet->setCellValue("B{$row}", $absen->user->name ?? '-');
                $sheet->setCellValue("C{$row}", $absen->created_at ? $absen->created_at->format('d-m-Y H:i:s') : '-');
                $sheet->setCellValue("D{$row}", ucfirst($absen->type ?? '-'));
                $sheet->setCellValue("E{$row}", ucfirst($absen->status_waktu ?? '-'));
                $sheet->setCellValue("F{$row}", ucfirst($absen->status_lokasi ?? '-'));
                $sheet->setCellValue("G{$row}", $absen->lokasi->name ?? '-');
                $sheet->setCellValue("H{$row}", $absen->lokasi->alamat ?? '-');
                $sheet->setCellValue("I{$row}", $absen->lokasi->type ?? '-');
                $sheet->setCellValue("J{$row}", $absen->durasi ?? '-');
                $sheet->setCellValue("K{$row}", $absen->notes ?? '-');
                $row++;
            }

            // ===================== STYLING =====================
            $lastRow = $row - 1;
            $lastCol = 'K';

            $sheet->getStyle("A7:{$lastCol}{$lastRow}")
                ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

            $sheet->getStyle("A7:{$lastCol}7")
                ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('D9D9D9');
            $sheet->getStyle("A7:{$lastCol}7")->getFont()->setBold(true);
            $sheet->getStyle("A7:{$lastCol}{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $sheet->getStyle('A1:K3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:K3')->getFont()->setBold(true);

            foreach (range('A', $lastCol) as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            // ===================== EXPORT =====================
            $filename = 'Rekap_Absensi_' . now()->format('Ymd_His') . '.xlsx';
            $writer = new Xlsx($spreadsheet);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment; filename=\"{$filename}\"");
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
            exit;
        } catch (\Exception $e) {
            Log::error('Error in RiwayatAbsen@export: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengekspor data absensi');
        }
    }
}

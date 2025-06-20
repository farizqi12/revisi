<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class RiwayatAbsen extends Controller
{
    public function show()
    {
        try {
            $user = Auth::user();

            if (!$user) {
                abort(403, 'Unauthorized');
            }

            $absensi = Absensi::with(['lokasi' => function ($query) {
                $query->select('id', 'name', 'type', 'alamat', 'radius', 'jam_masuk', 'jam_sampai', 'latitude', 'longitude');
            }])
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10)
                ->withQueryString();

            return view('riwayat-absensi', compact('absensi'));
        } catch (\Exception $e) {
            // Log error jika diperlukan
            Log::error('Error in RiwayatAbsen@show: ' . $e->getMessage());

            // Redirect ke halaman sebelumnya dengan pesan error
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

            return view('riwayat-absensi', compact('absensi'));
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

            return view('riwayat-absensi', compact('absensi', 'year', 'month'));
        } catch (\Exception $e) {
            Log::error('Error in PantauAbsen@showNow: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat riwayat absensi');
        }
    }

    public function export()
    {
        try {
            $user = Auth::user();
            $userId = $user ? $user->id : null;

            if (!$userId) {
                abort(403, 'Unauthorized');
            }

            $today = now()->toDateString();
            $year = request('year');
            $month = request('month');
            $filter = request('filter');

            $query = Absensi::with([
                'user' => function ($query) {
                    $query->select('id', 'name', 'username', 'role');
                },
                'lokasi' => function ($query) {
                    $query->select('id', 'name', 'type', 'alamat', 'radius', 'jam_masuk', 'jam_sampai', 'latitude', 'longitude');
                }
            ])
                ->where('user_id', $userId);

            $hasActiveFilter = request()->has('filter') || request()->has('year') || request()->has('month');

            if ($hasActiveFilter) {
                if ($filter === 'today' || request()->fullUrlIs(route('riwayat-absen.now'))) {
                    $query->whereDate('created_at', $today)
                        ->orderBy('created_at', 'desc');
                } elseif (($year && $month) || request()->fullUrlIs(route('riwayat-absen.sort'))) {
                    $query->whereYear('created_at', $year)
                        ->whereMonth('created_at', $month)
                        ->orderBy('created_at', 'desc');
                }
            } else {
                $query->orderBy('created_at', 'desc');
            }

            $absensi = $query->get();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Header tabel sesuai tampilan view
            $headers = [
                'No',
                'Nama',
                'Tanggal',
                'Tipe',
                'Status Waktu',
                'Status Lokasi',
                'Nama Lokasi',
                'Alamat Lokasi',
                'Tipe Lokasi',
                'Durasi',
                'Catatan',
            ];
            $sheet->fromArray($headers, null, 'A1');

            $row = 2;
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

            $lastCol = 'K';
            $lastRow = $row - 1;
            $sheet->getStyle("A1:{$lastCol}{$lastRow}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle("A1:{$lastCol}1")->getFont()->setBold(true);
            $sheet->getStyle("A1:{$lastCol}{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A1:{$lastCol}1")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('D9D9D9');

            foreach (range('A', $lastCol) as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            $filename = 'Data_Absensi_' . now()->format('Ymd_His') . '.xlsx';
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

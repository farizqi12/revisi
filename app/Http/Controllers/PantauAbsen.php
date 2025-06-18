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
            // Mendapatkan parameter dari request yang sama dengan view
            $today = now()->toDateString();
            $year = request('year') ?? null;
            $month = request('month') ?? null;
            $filter = request('filter');

            // Membuat query dasar
            $query = Absensi::with([
                'user' => function ($query) {
                    $query->select('id', 'name', 'username', 'role');
                },
                'lokasi' => function ($query) {
                    $query->select('id', 'name', 'type', 'alamat', 'radius', 'jam_masuk', 'jam_sampai', 'latitude', 'longitude');
                }
            ]);

            // Menerapkan filter yang sama dengan view
            if ($filter === 'today' || request()->fullUrlIs(route('pantau-absen.now'))) {
                // Filter untuk tampilan hari ini
                $query->whereDate('created_at', $today)
                    ->orderBy('created_at', 'desc');
            } elseif ($year && $month || request()->fullUrlIs(route('pantau-absen.sort'))) {
                // Filter untuk tampilan bulan/tahun tertentu
                $query->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->orderBy('created_at', 'desc');
            } else {
                // Default (tampilan semua data)
                $query->orderBy('created_at', 'desc');
            }

            // Mengambil semua data tanpa pagination
            $absensi = $query->get();

            // Membuat spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Header tabel (sesuai dengan kolom di view)
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
                'Radius Lokasi (m)',
                'Koordinat Absen',
                'Koordinat Acuan',
                'Durasi',
                'Catatan',
                'Jam Masuk Lokasi',
                'Jam Pulang Lokasi'
            ];
            $sheet->fromArray($headers, null, 'A1');

            // Isi data
            $row = 2;
            foreach ($absensi as $index => $absen) {
                $sheet->setCellValue("A{$row}", $index + 1);
                $sheet->setCellValue("B{$row}", $absen->user->name ?? '-');
                $sheet->setCellValue("C{$row}", $absen->created_at->format('d-m-Y H:i:s'));
                $sheet->setCellValue("D{$row}", ucfirst($absen->type ?? '-'));
                $sheet->setCellValue("E{$row}", ucfirst($absen->status_waktu ?? '-'));
                $sheet->setCellValue("F{$row}", ucfirst($absen->status_lokasi ?? '-'));

                // Data lokasi
                $sheet->setCellValue("G{$row}", $absen->lokasi->name ?? '-');
                $sheet->setCellValue("H{$row}", $absen->lokasi->alamat ?? '-');
                $sheet->setCellValue("I{$row}", $absen->lokasi->type ?? '-');
                $sheet->setCellValue("J{$row}", $absen->lokasi->radius ?? '-');

                // Koordinat
                $sheet->setCellValue(
                    "K{$row}",
                    ($absen->latitude && $absen->longitude) ?
                        number_format($absen->latitude, 6) . ', ' . number_format($absen->longitude, 6) : '-'
                );
                $sheet->setCellValue(
                    "L{$row}",
                    ($absen->lokasi && $absen->lokasi->latitude && $absen->lokasi->longitude) ?
                        number_format($absen->lokasi->latitude, 6) . ', ' . number_format($absen->lokasi->longitude, 6) : '-'
                );

                // Detail tambahan
                $sheet->setCellValue("M{$row}", $absen->durasi ?? '-');
                $sheet->setCellValue("N{$row}", $absen->notes ?? '-');
                $sheet->setCellValue("O{$row}", $absen->lokasi->jam_masuk ?? '-');
                $sheet->setCellValue("P{$row}", $absen->lokasi->jam_sampai ?? '-');

                $row++;
            }

            // Styling
            $lastRow = $row - 1;
            $sheet->getStyle("A1:P{$lastRow}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle("A1:P1")->getFont()->setBold(true);
            $sheet->getStyle("A1:P{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A1:P1")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('D9D9D9');

            foreach (range('A', 'P') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            // Export file
            $filename = 'Data_Absensi_' . now()->format('Ymd_His') . '.xlsx';
            $writer = new Xlsx($spreadsheet);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment; filename=\"{$filename}\"");
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
            exit;
        } catch (\Exception $e) {
            Log::error('Error in PantauAbsen@export: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengekspor data absensi');
        }
    }
}

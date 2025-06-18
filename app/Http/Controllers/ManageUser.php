<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;


class ManageUser extends Controller
{
    /**
     * Menampilkan form pembuatan user baru
     */
    public function show()
    {
        $users = User::all();
        return view('user-manage', compact('users'));
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:kepala sekolah,guru,murid', // Diubah dari 'siswa' ke 'murid'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->back()->with('success', 'User berhasil ditambahkan.');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $request->id,
            'password' => 'nullable|string|min:8|confirmed', // Password dibuat nullable agar tidak wajib diupdate
            'role' => 'required|string|in:kepala sekolah,guru,murid', // Diubah dari 'siswa' ke 'murid'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::find($request->id);
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->role = $request->role;

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'User berhasil diperbarui.');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id'
        ]);

        $user = User::find($request->id);
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        // Cek jika user mencoba menghapus diri sendiri
        if (Auth::id() === $user->id) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus (soft delete).');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $users = User::when($query, function ($q) use ($query) {
            return $q->where('name', 'LIKE', "%{$query}%")
                ->orWhere('username', 'LIKE', "%{$query}%")
                ->orWhere('role', 'LIKE', "%{$query}%");
        })
            ->get();

        return view('user-manage', compact('users'));
    }


    public function export()
    {
        $users = User::all(); // Sesuaikan jika ada filter dari search atau lainnya

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header tabel
        $headers = ['No', 'Nama', 'Username', 'Role', 'Tanggal Daftar', 'Tanggal Diubah'];
        $sheet->fromArray($headers, null, 'A1');

        $row = 2;
        $no = 1;

        foreach ($users as $user) {
            $sheet->setCellValue("A{$row}", $no++);
            $sheet->setCellValue("B{$row}", $user->name);
            $sheet->setCellValue("C{$row}", $user->username);
            $sheet->setCellValue("D{$row}", ucfirst($user->role));
            $sheet->setCellValue("E{$row}", $user->created_at->format('d/m/Y H:i'));
            $sheet->setCellValue("F{$row}", $user->updated_at->format('d/m/Y H:i'));
            $row++;
        }

        // Styling
        $lastRow = $row - 1;
        $sheet->getStyle("A1:F$lastRow")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle("A1:F1")->getFont()->setBold(true);
        $sheet->getStyle("A1:F$lastRow")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("A1:F1")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('D9D9D9');

        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Export file
        $filename = 'Data_Pengguna_' . now()->format('Ymd_His') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}

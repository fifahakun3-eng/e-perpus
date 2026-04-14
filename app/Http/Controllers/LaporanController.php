<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Anggota;
use App\Models\Pengunjung;
use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $jenis = $request->input('jenis', 'bulanan');
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        return view('pages.admin.laporan.index', compact('jenis', 'bulan', 'tahun'));
    }

    private function makeSpreadsheet(string $judul, array $headers): array
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $lastCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($headers));
        $sheet->mergeCells("A1:{$lastCol}1");
        $sheet->setCellValue('A1', $judul);
        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FF1A1A2E']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(24);

        $sheet->mergeCells("A2:{$lastCol}2");
        $sheet->setCellValue('A2', 'Dicetak: ' . now()->isoFormat('D MMMM YYYY, HH:mm') . ' WIB');
        $sheet->getStyle('A2')->applyFromArray([
            'font'      => ['italic' => true, 'size' => 10, 'color' => ['argb' => 'FF7A7060']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        $colIdx = 1;
        foreach ($headers as $h) {
            $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx);
            $sheet->setCellValue("{$col}3", $h);
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $colIdx++;
        }
        $sheet->getStyle("A3:{$lastCol}3")->applyFromArray([
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1A1A2E']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFD4C9B0']]],
        ]);
        $sheet->getRowDimension(3)->setRowHeight(18);

        return [$spreadsheet, $sheet, $lastCol];
    }

    private function styleRows($sheet, int $startRow, int $endRow, string $lastCol): void
    {
        for ($r = $startRow; $r <= $endRow; $r++) {
            $bg = ($r % 2 === 0) ? 'FFFFF8F0' : 'FFFFFFFF';
            $sheet->getStyle("A{$r}:{$lastCol}{$r}")->applyFromArray([
                'fill'    => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $bg]],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFE8E0D0']]],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
            ]);
            $sheet->getRowDimension($r)->setRowHeight(16);
        }
    }

    private function streamExcel(Spreadsheet $spreadsheet, string $filename): StreamedResponse
    {
        $writer = new Xlsx($spreadsheet);
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename . '_' . now()->format('Ymd_His') . '.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    public function exportAnggota(Request $request)
    {
        $srA  = $request->input('search_a');
        $klsA = $request->input('kelas');
        $q    = User::query();
        if ($srA)  $q->where(fn($x) => $x->where('name', 'like', "%$srA%")->orWhere('email', 'like', "%$srA%"));
        if ($klsA) $q->where('kelas', $klsA);
        $data = $q->orderBy('name')->get();

        $headers = ['No', 'Nama Lengkap', 'Email', 'Kelas', 'No. Telepon', 'Alamat', 'Tanggal Daftar'];
        [$spreadsheet, $sheet, $lastCol] = $this->makeSpreadsheet('Laporan Data Anggota — E-Perpustakaan', $headers);

        $row = 4;
        foreach ($data as $i => $item) {
            $sheet->fromArray([
                $i + 1,
                $item->name,
                $item->email ?? '-',
                $item->kelas ?? '-',
                $item->no_telp ?? '-',
                $item->alamat ?? '-',
                optional($item->created_at)->format('d/m/Y') ?? '-',
            ], null, "A{$row}");
            $row++;
        }
        $this->styleRows($sheet, 4, $row - 1, $lastCol);

        return $this->streamExcel($spreadsheet, 'laporan_anggota');
    }

    public function exportPengunjung(Request $request)
    {
        $srP  = $request->input('search_p');
        $blnP = $request->input('bulan_p');
        $thnP = $request->input('tahun_p', now()->year);
        $q    = Pengunjung::query();
        if ($srP)  $q->where('nama', 'like', "%$srP%");
        if ($blnP) $q->whereMonth('tanggal', $blnP);
        if ($thnP) $q->whereYear('tanggal', $thnP);
        $data = $q->orderByDesc('tanggal')->get();

        $headers = ['No', 'Nama', 'Kelas', 'Keperluan', 'Tanggal Kunjungan'];
        [$spreadsheet, $sheet, $lastCol] = $this->makeSpreadsheet('Laporan Data Pengunjung — E-Perpustakaan', $headers);

        $row = 4;
        foreach ($data as $i => $item) {
            $sheet->fromArray([
                $i + 1,
                $item->nama,
                $item->kelas ?? '-',
                $item->keperluan ?? '-',
                Carbon::parse($item->tanggal)->isoFormat('D MMMM YYYY'),
            ], null, "A{$row}");
            $row++;
        }
        $this->styleRows($sheet, 4, $row - 1, $lastCol);

        return $this->streamExcel($spreadsheet, 'laporan_pengunjung');
    }

    public function exportPeminjaman(Request $request)
    {
        $srPm  = $request->input('search_pm');
        $stsPm = $request->input('status_pm');
        $blnPm = $request->input('bulan_pm');
        $thnPm = $request->input('tahun_pm', now()->year);

        $q = Peminjaman::with(['anggota', 'buku']);
        if ($blnPm) $q->whereMonth('tanggal_pinjam', $blnPm);
        if ($thnPm) $q->whereYear('tanggal_pinjam', $thnPm);
        if ($srPm)  $q->where(
            fn($x) =>
            $x->whereHas('anggota', fn($a) => $a->where('name', 'like', "%$srPm%"))
                ->orWhereHas('buku', fn($b) => $b->where('judul', 'like', "%$srPm%"))
        );
        if ($stsPm === 'terlambat') $q->where('status', 'dipinjam')->where('tanggal_kembali', '<', now()->toDateString());
        elseif ($stsPm) $q->where('status', $stsPm);
        $data = $q->orderByDesc('tanggal_pinjam')->get();

        $headers = ['No', 'Nama Anggota', 'Judul Buku', 'Tanggal Pinjam', 'Tanggal Kembali', 'Status', 'Terlambat'];
        [$spreadsheet, $sheet, $lastCol] = $this->makeSpreadsheet('Laporan Data Peminjaman — E-Perpustakaan', $headers);

        $row = 4;
        foreach ($data as $i => $item) {
            $terlambat = $item->status === 'dipinjam' && $item->tanggal_kembali < now()->toDateString();
            $statusLabel = $terlambat ? 'Terlambat' : ucfirst($item->status ?? '-');
            $hariTerlambat = $terlambat
                ? Carbon::parse($item->tanggal_kembali)->diffInDays(now()) . ' hari'
                : '-';

            $sheet->fromArray([
                $i + 1,
                optional($item->anggota)->name ?? '-',
                optional($item->buku)->judul ?? '-',
                Carbon::parse($item->tanggal_pinjam)->format('d/m/Y'),
                Carbon::parse($item->tanggal_kembali)->format('d/m/Y'),
                $statusLabel,
                $hariTerlambat,
            ], null, "A{$row}");

            // Warnai baris terlambat merah muda
            if ($terlambat) {
                $sheet->getStyle("A{$row}:{$lastCol}{$row}")->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFFDECEA');
            }
            $row++;
        }
        $this->styleRows($sheet, 4, $row - 1, $lastCol);

        return $this->streamExcel($spreadsheet, 'laporan_peminjaman');
    }

    public function exportBuku(Request $request)
    {
        $srB   = $request->input('search_b');
        $katB  = $request->input('kategori_b');
        $rakB  = $request->input('rak_b');
        $stokB = $request->input('stok_b');
        $q     = Buku::query();
        if ($srB)  $q->where(fn($x) => $x->where('judul', 'like', "%$srB%")->orWhere('penulis', 'like', "%$srB%"));
        if ($katB) $q->where('kategori', $katB);
        if ($rakB) $q->where('rak', $rakB);
        if ($stokB === 'tersedia') $q->where('stok', '>', 5);
        if ($stokB === 'terbatas') $q->whereBetween('stok', [1, 5]);
        if ($stokB === 'habis')    $q->where('stok', 0);
        $data = $q->orderBy('judul')->get();

        $headers = ['No', 'Judul', 'Penulis', 'Kategori', 'Rak', 'Tahun Terbit', 'Stok', 'Keterangan'];
        [$spreadsheet, $sheet, $lastCol] = $this->makeSpreadsheet('Laporan Koleksi Buku — E-Perpustakaan', $headers);

        $row = 4;
        foreach ($data as $i => $item) {
            $stokLabel = $item->stok > 5 ? 'Tersedia' : ($item->stok > 0 ? 'Terbatas' : 'Habis');
            $sheet->fromArray([
                $i + 1,
                $item->judul,
                $item->penulis ?? '-',
                $item->kategori ?? '-',
                $item->rak ?? '-',
                $item->tahun_terbit ?? '-',
                $item->stok,
                $stokLabel,
            ], null, "A{$row}");

            if ($item->stok == 0) {
                $sheet->getStyle("A{$row}:{$lastCol}{$row}")->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFFDECEA');
            }
            $row++;
        }
        $this->styleRows($sheet, 4, $row - 1, $lastCol);

        return $this->streamExcel($spreadsheet, 'laporan_buku');
    }
}

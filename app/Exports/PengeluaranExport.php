<?php

namespace App\Exports;

use App\Models\Pengeluaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PengeluaranExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    private $index = 0;
    private $totalJumlah = 0;
    private $startDate;
    private $endDate;
    private $totalsByKebutuhan;
    private $totalsBySumber;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;

        $this->totalsByKebutuhan = Pengeluaran::whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->select('kebutuhan', Pengeluaran::raw('SUM(jumlah) as total'))
            ->groupBy('kebutuhan')
            ->get();

        $this->totalsBySumber = Pengeluaran::whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->select('sumber', Pengeluaran::raw('SUM(jumlah) as total'))
            ->groupBy('sumber')
            ->get();
    }

    public function collection()
    {
        return Pengeluaran::whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Kebutuhan',
            'Keterangan',
            'Tanggal',
            'Sumber',
            'Jumlah'
        ];
    }

    public function map($pengeluaran): array
    {
        $this->index++;
        $this->totalJumlah += $pengeluaran->jumlah;

        return [
            $this->index,
            $pengeluaran->kebutuhan,
            $pengeluaran->keterangan,
            \Carbon\Carbon::parse($pengeluaran->tanggal)->format('d-m-Y'),
            $pengeluaran->sumber,
            'Rp ' . number_format($pengeluaran->jumlah, 2, ',', '.')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $this->index + 2; // +1 for heading row, +1 for total row

        // Add total row
        $sheet->mergeCells('A' . $lastRow . ':E' . $lastRow);
        $sheet->setCellValue('A' . $lastRow, 'Total Pengeluaran:');
        $sheet->setCellValue('F' . $lastRow, 'Rp ' . number_format($this->totalJumlah, 2, ',', '.'));

        // Add total per kebutuhan
        $currentRow = $lastRow + 2; // Skip one row
        $sheet->setCellValue('A' . $currentRow, 'Total Pengeluaran Berdasarkan Kategori Kebutuhan');
        $currentRow++;
        $sheet->setCellValue('A' . $currentRow, 'No');
        $sheet->setCellValue('B' . $currentRow, 'Kebutuhan');
        $sheet->setCellValue('C' . $currentRow, 'Total Pengeluaran');

        $index = 1;
        $totalPerKebutuhan = 0;
        foreach ($this->totalsByKebutuhan as $totalByKebutuhan) {
            $currentRow++;
            $sheet->setCellValue('A' . $currentRow, $index);
            $sheet->setCellValue('B' . $currentRow, $totalByKebutuhan->kebutuhan);
            $sheet->setCellValue('C' . $currentRow, 'Rp ' . number_format($totalByKebutuhan->total, 2, ',', '.'));
            $totalPerKebutuhan += $totalByKebutuhan->total;
            $index++;
        }

        // Add total for all kebutuhan
        $currentRow++;
        $sheet->mergeCells('A' . $currentRow . ':B' . $currentRow);
        $sheet->setCellValue('A' . $currentRow, 'Total Pengeluaran:');
        $sheet->setCellValue('C' . $currentRow, 'Rp ' . number_format($totalPerKebutuhan, 2, ',', '.'));

        // Add total per sumber
        $currentRow += 2; // Skip one row
        $sheet->setCellValue('A' . $currentRow, 'Total Pengeluaran Berdasarkan Kategori Sumber');
        $currentRow++;
        $sheet->setCellValue('A' . $currentRow, 'No');
        $sheet->setCellValue('B' . $currentRow, 'Sumber');
        $sheet->setCellValue('C' . $currentRow, 'Total Pengeluaran');

        $index = 1;
        $totalPerSumber = 0;
        foreach ($this->totalsBySumber as $totalBySumber) {
            $currentRow++;
            $sheet->setCellValue('A' . $currentRow, $index);
            $sheet->setCellValue('B' . $currentRow, $totalBySumber->sumber);
            $sheet->setCellValue('C' . $currentRow, 'Rp ' . number_format($totalBySumber->total, 2, ',', '.'));
            $totalPerSumber += $totalBySumber->total;
            $index++;
        }

        // Add total for all sumber
        $currentRow++;
        $sheet->mergeCells('A' . $currentRow . ':B' . $currentRow);
        $sheet->setCellValue('A' . $currentRow, 'Total Pengeluaran:');
        $sheet->setCellValue('C' . $currentRow, 'Rp ' . number_format($totalPerSumber, 2, ',', '.'));

        // Apply styles
        return [
            1 => ['font' => ['bold' => true]], // Heading row
            $lastRow => ['font' => ['bold' => true]], // Total row
            ($lastRow + 2) => ['font' => ['bold' => true]], // Total per kebutuhan category heading
            ($lastRow + 3) => ['font' => ['bold' => true]], // Total per kebutuhan category column headers
            ($lastRow + 3 + count($this->totalsByKebutuhan) + 1) => ['font' => ['bold' => true]], // Total per kebutuhan row
            ($lastRow + 5 + count($this->totalsByKebutuhan) + 1) => ['font' => ['bold' => true]], // Total per sumber category heading
            ($lastRow + 6 + count($this->totalsByKebutuhan) + 1) => ['font' => ['bold' => true]], // Total per sumber category column headers
            $currentRow => ['font' => ['bold' => true]], // Total for all sumber
        ];
    }
}

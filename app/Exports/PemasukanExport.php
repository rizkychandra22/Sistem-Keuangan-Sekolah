<?php

namespace App\Exports;

use App\Models\Pemasukan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PemasukanExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    private $index = 0;
    private $totalJumlah = 0;
    private $startDate;
    private $endDate;
    private $totalsBySource;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;

        $this->totalsBySource = Pemasukan::whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->select('sumber', Pemasukan::raw('SUM(jumlah) as total'))
            ->groupBy('sumber')
            ->get();
    }

    public function collection()
    {
        return Pemasukan::whereBetween('tanggal', [$this->startDate, $this->endDate])->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Sumber',
            'Keterangan',
            'Tanggal',
            'Jumlah'
        ];
    }

    public function map($pemasukan): array
    {
        $this->index++;
        $this->totalJumlah += $pemasukan->jumlah;

        return [
            $this->index,
            $pemasukan->sumber,
            $pemasukan->keterangan,
            \Carbon\Carbon::parse($pemasukan->tanggal)->format('d-m-Y'),
            'Rp ' . number_format($pemasukan->jumlah, 2, ',', '.')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $this->index + 2; // +1 for heading row, +1 for total row

        // Add total row
        $sheet->mergeCells('A' . $lastRow . ':D' . $lastRow);
        $sheet->setCellValue('A' . $lastRow, 'Total Pemasukan:');
        $sheet->setCellValue('E' . $lastRow, 'Rp ' . number_format($this->totalJumlah, 2, ',', '.'));

        // Add total per source category
        $currentRow = $lastRow + 2; // Skip one row
        $sheet->setCellValue('A' . $currentRow, 'Total Pemasukan Berdasarkan Kategori Sumber');
        $currentRow++;
        $sheet->setCellValue('A' . $currentRow, 'No');
        $sheet->setCellValue('B' . $currentRow, 'Sumber');
        $sheet->setCellValue('C' . $currentRow, 'Jumlah');

        $index = 1;
        $totalPerSource = 0;
        foreach ($this->totalsBySource as $totalBySource) {
            $currentRow++;
            $sheet->setCellValue('A' . $currentRow, $index);
            $sheet->setCellValue('B' . $currentRow, $totalBySource->sumber);
            $sheet->setCellValue('C' . $currentRow, 'Rp ' . number_format($totalBySource->total, 2, ',', '.'));
            $totalPerSource += $totalBySource->total;
            $index++;
        }

        // Add total for all sources
        $currentRow++;
        $sheet->mergeCells('A' . $currentRow . ':B' . $currentRow);
        $sheet->setCellValue('A' . $currentRow, 'Total Pemasukan:');
        $sheet->setCellValue('C' . $currentRow, 'Rp ' . number_format($totalPerSource, 2, ',', '.'));

        // Apply styles
        return [
            1 => ['font' => ['bold' => true]], // Heading row
            $lastRow => ['font' => ['bold' => true]], // Total row
            ($lastRow + 2) => ['font' => ['bold' => true]], // Total per source category heading
            ($lastRow + 3) => ['font' => ['bold' => true]], // Total per source category column headers
            $currentRow => ['font' => ['bold' => true]], // Total for all sources
        ];
    }
}

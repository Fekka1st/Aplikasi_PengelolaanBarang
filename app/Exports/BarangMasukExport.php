<?php

namespace App\Exports;

use App\Models\barang_masuk;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithEvents
};
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;

class BarangMasukExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $tglAwal;
    protected $tglAkhir;

    public function __construct(string $tglAwal = null, string $tglAkhir = null)
    {
        $this->tglAwal = $tglAwal;
        $this->tglAkhir = $tglAkhir;
    }

    public function collection()
    {
        $data = barang_masuk::with(['barang', 'staff'])
            ->when($this->tglAwal && $this->tglAkhir, function($query) {
                return $query->whereBetween('created_at', [
                    Carbon::parse($this->tglAwal)->startOfDay(),
                    Carbon::parse($this->tglAkhir)->endOfDay()
                ]);
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($item, $index) {
                return [
                    $index + 1,
                    $item->kode_transaksi,
                    optional($item->barang)->kode_barang ?? '-',
                    optional($item->barang)->serial_number ?? '-',
                    optional($item->barang)->nama_barang ?? '-',
                    $item->jumlah,
                    $item->created_at->format('d-m-Y H:i'),
                    optional($item->staff)->name ?? '-',
                ];
            });

        return $data;
    }

    public function headings(): array
    {
        $periode = $this->tglAwal && $this->tglAkhir
            ? "Periode: " . Carbon::parse($this->tglAwal)->format('d-m-Y') . " - " . Carbon::parse($this->tglAkhir)->format('d-m-Y')
            : "Periode: Semua Data";

        return [
            ['LAPORAN BARANG MASUK'],
            [$periode],
            ['Dicetak pada: ' . now()->format('d-m-Y H:i')],
            [
                'No',
                'Kode Transaksi',
                'Kode Barang',
                'Serial Number',
                'Nama Barang',
                'Jumlah',
                'Tanggal Masuk',
                'Di Input Oleh'
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                $highestRow = $sheet->getHighestRow();

                // Merge cells untuk judul dan informasi
                $sheet->mergeCells('A1:H1');
                $sheet->mergeCells('A2:H2');
                $sheet->mergeCells('A3:H3');

                // Styling untuk judul laporan
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                    ],
                ]);

                // Styling untuk periode
                $sheet->getStyle('A2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                    ],
                ]);

                // Styling untuk tanggal cetak
                $sheet->getStyle('A3')->applyFromArray([
                    'font' => [
                        'italic' => true,
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                    ],
                ]);

                // Styling untuk header tabel
                $sheet->getStyle('A4:H4')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'color' => ['argb' => 'FFD9EDF7'], // Warna biru muda
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Styling untuk seluruh data
                if ($highestRow > 4) {
                    $sheet->getStyle('A5:H'.$highestRow)->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                            ],
                        ],
                    ]);

                    // Menambahkan total jumlah di akhir
                    $totalRow = $highestRow + 1;
                    $sheet->setCellValue('A'.$totalRow, 'TOTAL BARANG MASUK:');
                    $sheet->mergeCells('A'.$totalRow.':E'.$totalRow);
                    $sheet->setCellValue('F'.$totalRow, '=SUM(F5:F'.$highestRow.')');

                    $sheet->getStyle('A'.$totalRow.':H'.$totalRow)->applyFromArray([
                        'font' => [
                            'bold' => true,
                        ],
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'color' => ['argb' => 'FFE6E6E6'], // Warna abu-abu muda
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                            ],
                        ],
                    ]);
                }

                // Auto size semua kolom
                foreach (range('A', 'H') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}

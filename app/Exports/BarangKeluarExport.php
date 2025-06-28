<?php

namespace App\Exports;

use App\Models\barang_keluar;
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

class BarangKeluarExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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
        $data = barang_keluar::with(['barang', 'jenis', 'staff'])
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
                    optional($item->jenis)->nama_jenis ?? '-',
                    optional($item->barang)->nama_barang ?? '-',
                    $item->jumlah,
                    $item->created_at->format('d-m-Y H:i'),
                    $item->nama_penerima,
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
            ['LAPORAN BARANG KELUAR'],
            [$periode],
            ['Dicetak pada: ' . now()->format('d-m-Y H:i')],
            [
                'No',
                'Kode Transaksi',
                'Kode Barang',
                'Serial Number',
                'Jenis Barang',
                'Nama Barang',
                'Jumlah',
                'Tanggal Keluar',
                'Nama Penerima',
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

                // Merge header rows
                $sheet->mergeCells('A1:J1');
                $sheet->mergeCells('A2:J2');
                $sheet->mergeCells('A3:J3');

                // Style judul
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                    ],
                ]);

                // Style periode
                $sheet->getStyle('A2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                    ],
                ]);

                // Style dicetak pada
                $sheet->getStyle('A3')->applyFromArray([
                    'font' => [
                        'italic' => true,
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                    ],
                ]);

                // Style heading tabel
                $sheet->getStyle('A4:J4')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'color' => ['argb' => 'FFD9EDF7'],
                    ],
                    'alignment' => ['horizontal' => 'center'],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Border data
                if ($highestRow > 4) {
                    $sheet->getStyle('A5:J'.$highestRow)->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                            ],
                        ],
                    ]);

                    // Total barang keluar
                    $totalRow = $highestRow + 1;
                    $sheet->setCellValue('A'.$totalRow, 'TOTAL BARANG KELUAR:');
                    $sheet->mergeCells('A'.$totalRow.':F'.$totalRow);
                    $sheet->setCellValue('G'.$totalRow, '=SUM(G5:G'.$highestRow.')');

                    $sheet->getStyle('A'.$totalRow.':J'.$totalRow)->applyFromArray([
                        'font' => ['bold' => true],
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'color' => ['argb' => 'FFE6E6E6'],
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                            ],
                        ],
                    ]);
                }

                // Auto size kolom
                foreach (range('A', 'J') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}

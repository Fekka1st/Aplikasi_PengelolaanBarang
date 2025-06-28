<?php

namespace App\Exports;

use App\Models\Barang;
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

class TotalStockBarangExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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
        $data = Barang::with('kategori', 'pengguna')
            ->when($this->tglAwal && $this->tglAkhir, function($query) {
                return $query->whereBetween('created_at', [$this->tglAwal, $this->tglAkhir]);
            })
            ->get()
            ->map(function($row, $index) {
                return [
                    $index + 1,
                    $row->kode_barang,
                    $row->serial_number,
                    $row->kategori->nama_kategori ?? '-',
                    $row->nama_barang,
                    $row->stok,
                    $row->created_at->format('d-m-Y H:i'),
                    $row->pengguna->name ?? '-',
                ];
            });

        return $data;
    }

    public function headings(): array
    {
        $periode = $this->tglAwal && $this->tglAkhir
            ? "Periode: {$this->tglAwal} - {$this->tglAkhir}"
            : "Periode: Semua Data";

        return [
            ['LAPORAN TOTAL STOK BARANG'],
            [$periode],
            ['Dicetak pada: ' . now()->format('d-m-Y H:i')],
            ['No', 'Kode Barang', 'Serial Number', 'Kategori Barang', 'Nama Barang', 'Stok Barang', 'Tanggal Input', 'Di Input Oleh']
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;

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
                        'color' => ['argb' => 'FFD9EDF7'],
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                    ],
                ]);

                // Styling untuk seluruh data
                $lastRow = $sheet->getHighestRow();
                $sheet->getStyle('A4:H'.$lastRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);

                // Menambahkan total stok di akhir
                if ($lastRow > 4) { // Jika ada data
                    $totalRow = $lastRow + 1;
                    $sheet->setCellValue('A'.$totalRow, 'TOTAL Barang:');
                    $sheet->mergeCells('A'.$totalRow.':E'.$totalRow);
                    $sheet->setCellValue('F'.$totalRow, '=SUM(F5:F'.$lastRow.')');

                    $sheet->getStyle('A'.$totalRow.':H'.$totalRow)->applyFromArray([
                        'font' => [
                            'bold' => true,
                        ],
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'color' => ['argb' => 'FFE6E6E6'],
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

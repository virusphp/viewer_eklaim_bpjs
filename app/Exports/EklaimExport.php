<?php

namespace App\Exports;

use App\Repository\Sep\Eklaim;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;

class EklaimExport implements FromQuery, ShouldAutoSize, WithMapping, WithEvents, WithHeadings
{
    use Exportable;

    protected $eklaim;

    public function __construct($request)
    {
        $this->eklaim = new Eklaim;
        $this->request = $request;
    }

    public function query()
    {
        return $this->eklaim->exportEklaim($this->request);
    }

    public function headings(): array
    {
        return [
            // 'NO',
            'Tgl Pulang',
            'No. RM',
            'Nama Pasien',
            'No. Klaim / SEP',
            'No Kartu',
            'Jenis Rawat',
        ];
    }

    public function map($eklaim): array
    {
        if ($eklaim->jns_pelayanan == "01") {
            $jns_peyalayan = "Rawat Jalan";
        } else if($eklaim->jns_pelayanan == "02") {
            $jns_peyalayan = "Rawat Inap";
        } else {
            $jns_peyalayan = "Rawat Darurat";
        }

        return [
            // $eklaim->number,
            $eklaim->tgl_pulang,
            $eklaim->no_rm,
            $eklaim->nama_pasien,
            $eklaim->no_sep,
            $eklaim->no_kartu,
            $jns_peyalayan
        ];
    }

    public function registerEvents(): array
    {
        return [
            BeforeExport::class => function(BeforeExport $event) {
                $event->writer->getProperties()->setCreator('RSUD-KRATON');
                $event->writer->getProperties()->setLastModifiedBy("RSUD KRATON");
                $event->writer->getProperties()->setTitle('LAPORAN REKAP KLAIM - RSUD KRATON');
                $event->writer->getProperties()->setSubject('Office 2007 xlxs Text Document');
                $event->writer->getProperties()->setDescription('LAPORAN REKAP KLAIM - RSUD KRATON');
            },

            BeforeSheet::class => function(BeforeSheet $event) {
                $styleArray = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                    ]
                ];

                $event->sheet->getDelegate()->insertNewRowBefore(1, 4);
                $event->sheet->getDelegate()->getCell('A1')->setValue("LAPORAN REKAP KLAIM - RSUD KRATON");
                $event->sheet->getDelegate()->getCell('A2')->setValue("Pasien Rawat Inap dan Rawat Jalan, Periode Tanggal");
                $event->sheet->getDelegate()->getCell('A3')->setValue("JL. Veteran No. 31 Telp (0285) 421621-423523 Fax. 423225 Pekalongan 51116");
                $event->sheet->getDelegate()->getStyle('A1:A3')->applyFromArray($styleArray);
                $event->sheet->getDelegate()->mergeCells('A1:F1');
                $event->sheet->getDelegate()->mergeCells('A2:F2');
                $event->sheet->getDelegate()->mergeCells('A3:F3');
            },
            AfterSheet::class => function(AfterSheet $event) {
                
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000']
                        ]
                    ],
                ];
                
                $styleHeader = [
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'rotation' => 90,
                        'startColor' => [
                            'argb' => 'FFA0A0A0',
                        ],
                        'endColor' => [
                            'argb' => 'FFFF0000',
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ]
                ];

                $cellHeader = 'A4:F4'; // All headers
                $event->sheet->getDelegate()->getStyle($cellHeader)->applyFromArray($styleHeader);

                $last = $event->sheet->getDelegate()->getHighestRowAndColumn(); // mendapatkan row dan colom terakhir
                $row = $last['row']; // row ke yan gke bawah = 1 - 9999 tp yang terakhir
                $column = $last['column']; // column ke sing A - Z  tp  yang terakhir

                $event->sheet->getDelegate()->getStyle('A4:'. $column.$row)->applyFromArray($styleArray);
                
            }
        ];
    }
}

<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Carbon\Carbon;

class KardexExport implements FromCollection, WithCustomStartCell, WithStyles, WithHeadings, WithMapping, WithEvents
{
    protected $fechaHoy;
    protected $packages;

    public function __construct($fecha, $packages)
    {
        $this->fechaHoy = $fecha;
        $this->packages = $packages;
    }

    public function collection()
    {
        return $this->packages;
    }

    public function map($package): array
    {
        return [
            $package->id, // Nro
            Carbon::parse($package->deleted_at)->format('d/m/Y'), // FECHA DE BAJA
            'DESCONOCIDO', // TIPO DE ENVÍO
            $package->codigo, // CÓDIGO
            $package->cantidad ?? 1, // CANTIDAD
            $package->peso ?? 0, // PESO
            $package->factura ?? '', // FACTURA N.º
            $package->precio_final ?? $package->precio ?? 0 // IMPORTE
        ];
    }

    public function headings(): array
    {
        return [
            'Nro',
            'FECHA',
            'TIPO DE ENVÍO',
            'CÓDIGO',
            'CANTIDAD',
            'PESO',
            'FACTURA N.º',
            'IMPORTE'
        ];
    }

    public function startCell(): string
    {
        return 'B10';
    }

    public function styles(Worksheet $sheet)
    {
        $startRow = 10;
        $endRow = $startRow + $this->packages->count();

        // Encabezado principal
        $sheet->mergeCells('B1:D3');
        $sheet->setCellValue('B1', "KARDEX DIARIO DE RENDICIÓN\nAGENCIA BOLIVIANA DE CORREOS\nEXPRESADO EN BS.");
        $sheet->getStyle('B1')->getAlignment()
            ->setWrapText(true)
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->mergeCells('F1:H3');
        $sheet->setCellValue('F1', "Dirección de Operaciones\nDistribución Domiciliaria\nKardex 3");
        $sheet->getStyle('F1')->getAlignment()
            ->setWrapText(true)
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);

        // Información día/usuario
        $firstPackage = $this->packages->first();
        $sheet->mergeCells('B6:E6');
        $sheet->setCellValue('B6', 'Oficina Postal: ' . ($firstPackage->cuidad ?? 'N/A'));
        $sheet->mergeCells('B7:E7');
        $sheet->setCellValue('B7', 'Ventanilla: ENCOMIENDAS');
        $sheet->mergeCells('B8:I8');
        $sheet->setCellValue('B8', 'Nombre del Cartero: ' . ($firstPackage->user ?? 'N/A'));
        $sheet->mergeCells('F6:I6');
        $sheet->setCellValue('F6', 'Nombre Responsable:' . ($firstPackage->user ?? 'N/A'));
        $sheet->mergeCells('F7:I7');
        $sheet->setCellValue('F7', 'Fecha de Recaudación: ' . $this->fechaHoy);

        // Encabezados de tabla
        $sheet->getStyle('B' . $startRow . ':I' . $startRow)->getFont()->setBold(true);
        $sheet->getStyle('B' . $startRow . ':I' . $startRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Columnas
        $sheet->getColumnDimension('B')->setWidth(5);
        $sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(13);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(10);
        $sheet->getColumnDimension('G')->setWidth(10);
        $sheet->getColumnDimension('H')->setWidth(12);
        $sheet->getColumnDimension('I')->setWidth(12);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $startRow = 10;
                $endRow = $startRow + $this->packages->count();

                // Bordes de la tabla de datos
                $sheet->getStyle('B' . $startRow . ':I' . $endRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                // -------------------
                // Total General
                // -------------------
                $totalRow = $endRow + 1;
                $sheet->mergeCells('B' . $totalRow . ':D' . $totalRow);
                $sheet->setCellValue('B' . $totalRow, 'TOTAL GENERAL');

                $totalCantidad = $this->packages->sum('cantidad');
                $totalPeso = $this->packages->sum('peso');
                $totalImporte = $this->packages->sum(function ($p) {
                    return $p->precio_final ?? $p->precio ?? 0;
                });

                $sheet->setCellValue('F' . $totalRow, $totalCantidad);
                $sheet->setCellValue('G' . $totalRow, number_format($totalPeso, 2, ',', ''));
                $sheet->setCellValue('I' . $totalRow, number_format($totalImporte, 2, ',', ''));

                $sheet->getStyle('B' . $totalRow . ':I' . $totalRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_MEDIUM);
                $sheet->getStyle('B' . $totalRow . ':I' . $totalRow)->getFont()->setBold(true);
                $sheet->getStyle('B' . $totalRow . ':I' . $totalRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // -------------------
                // Observaciones y sellos/firma
                // -------------------
                $finalRow = $totalRow + 2;

                $sheet->mergeCells('B' . $finalRow . ':D' . ($finalRow + 8));
                $sheet->setCellValue('B' . $finalRow, 'Observaciones:');
                $sheet->getStyle('B' . $finalRow)->getAlignment()
                    ->setVertical(Alignment::VERTICAL_TOP)
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT);

                $sheet->mergeCells('E' . $finalRow . ':F' . ($finalRow + 8));
                $sheet->setCellValue('E' . $finalRow, "SELLO / FIRMA DE CONFORMIDAD\nRECAUDADOR");
                $sheet->getStyle('E' . $finalRow)->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_BOTTOM)
                    ->setWrapText(true);

                $sheet->mergeCells('G' . $finalRow . ':H' . ($finalRow + 8));
                $sheet->setCellValue('G' . $finalRow, "SELLO / FIRMA DE CONFORMIDAD\nREVISOR");
                $sheet->getStyle('G' . $finalRow)->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_BOTTOM)
                    ->setWrapText(true);

                $sheet->mergeCells('I' . $finalRow . ':I' . ($finalRow + 8));
                $sheet->setCellValue('I' . $finalRow, 'SELLO RECEPCIÓN TESORERÍA');
                $sheet->getStyle('I' . $finalRow)->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_BOTTOM)
                    ->setWrapText(true);
            },
        ];
    }
}

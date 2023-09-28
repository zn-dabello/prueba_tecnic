<?php

namespace App\Exports\MiInstitucion\Direccion\Sheets;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DireccionesExport implements FromArray, WithTitle, WithHeadings, WithColumnWidths, WithStyles, WithColumnFormatting, WithEvents
{
    public $direcciones;
    public $filtros;

    public function __construct(array $data)
    {
        $this->direcciones = $data['direcciones'];
        $this->filtros = $data['filtros'];
    }


    /**
     * Metodo que permite asignar nomber a la pestaña excel
     *  @date 16-08-2023
     * @copyright ZonaNube (zonanube.cl)
     * @author Raudely Pimentel <rpimentel@zonanube.com>
     */
    public function title(): string
    {
        return 'Direcciones';
    }


    /**
     * Metodo que permite asignar valores a las primeras filas del excel
     *  @date 16-08-2023
     * @copyright ZonaNube (zonanube.cl)
     * @author Raudely Pimentel <rpimentel@zonanube.com>
     */

    public function headings(): array
    {
        $filtro_nombre = !empty($this->filtros['buscar_nombre']) ? '['.$this->filtros['buscar_nombre'].']' : ' ';
        $filtro_telefono = !empty($this->filtros['buscar_telefono']) ? '['.$this->filtros['buscar_telefono'].']' : '';
        $filtro_domicilio = !empty($this->filtros['buscar_domicilio']) ? '['.$this->filtros['buscar_domicilio'].']' : '';

        return [
            // Encabezado
            [
                'NOMBRE ' . $filtro_nombre,
                'TELÉFONO ' . $filtro_telefono,
                'DOMICILIO ' . $filtro_domicilio,
                'ESTADO '
            ]
        ];
    }


    /**
     * Metodo que permite asignar tamaños a las columnas
     *  @date 16-08-2023
     * @copyright ZonaNube (zonanube.cl)
     * @author Raudely Pimentel <rpimentel@zonanube.com>
     */

    public function columnWidths(): array
    {
        return [  
            'A' => 50,
            'C' => 50,
            'D' => 30   
        ];
    } 


    /**
     * Metodo que permite devulve los datos de la consulta
     *  @date 16-08-2023
     * @copyright ZonaNube (zonanube.cl)
     * @author Raudely Pimentel <rpimentel@zonanube.com>
     */

    public function array(): array
    {

        return $this->mapDatos();
    }


    /**
     * Metodo que permite asignar formatos a las columnas
     *  @date 16-08-2023
     * @copyright ZonaNube (zonanube.cl)
     * @author Raudely Pimentel <rpimentel@zonanube.com>
     */

    public function columnFormats(): array
    {
        return [
            // 'H' => NumberFormat::FORMAT_TEXT
        ];
    }


    /**
     * Metodo que permite dar estilos
     *  @date 16-08-2023
     * @copyright ZonaNube (zonanube.cl)
     * @author Raudely Pimentel <rpimentel@zonanube.com>
     */

    public function styles(Worksheet $sheet)
    {

        $sheet->getStyle('A1:D1')->getFont()->setBold(true)->getColor()->setARGB('FFFFFF');
        $sheet->getStyle('A1:D1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('3BAAE3');
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->setAutoFilter('A1:D1');
        $registros = $this->direcciones->count();
        $fila = 2;
        for ($i=0; $i < $registros ; $i++) {

            $fila_completa = 'A'.$fila.':D'.$fila;
            if (($fila % 2) == 0) {
            } else {
                $sheet->getStyle($fila_completa)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('F2F2F2');
            }
            $sheet->getStyle($fila_completa)->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => 'D4D4D4'],
                            ],
                        ],
            ]);
            $fila++;
        }
    }

    /**
     * Metodo que permite mapear los datos
     *  @date 16-08-2023
     * @copyright ZonaNube (zonanube.cl)
     * @author Raudely Pimentel <rpimentel@zonanube.com>
     */

    public function mapDatos () {

        $datos = $this->direcciones->map(function($dato){

            return $dato;

        });

        return ( ! empty($datos) ? $datos->toArray() : $datos);
    }

    /**
     * Metodo que permite agregar eventos, em este caso inmovilizar primera fila
     *  @date 08-06-2022
     * @copyright ZonaNube (zonanube.cl)
     * @author Raudely Pimentel <rpimentel@zonanube.com>
     */
    
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $workSheet = $event->sheet->getDelegate();
                $workSheet->freezePane('A2'); // Si se coloca A2 toma la primera fila
            }
        ];
    }
}

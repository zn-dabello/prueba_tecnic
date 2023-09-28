<?php
namespace App\Exports\Generales;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use Maatwebsite\Excel\Concerns\WithCharts;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\Title;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InfoUserExport implements FromArray, WithTitle, WithHeadings, WithColumnWidths, WithStyles, WithColumnFormatting, WithEvents //, WithCharts
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
    

     /**
     * Funcion que permite asignar nomber a la pestaña excel
     *  @date Ene 2020
     * @copyright ZonaNube (zonanube.cl)
     * @author Steven Salcedo <ssalcedo@zonanube.cl>
     */
    public function title(): string
    {
        return 'Info';
    }


    /**
     * Metodo que permite asignar valores a las primeras filas del excel
     *  @date 14-01-2022
     * @copyright ZonaNube (zonanube.cl)
     * @author Raudely Pimentel <rpimentel@zonanube.com>
     */

    public function headings(): array
    {
        return [
            // Encabezado
            [
                'USUARIO',
                $this->data['nombre_user']

            ],

            [
                'ENCARGADO DE',
                $this->data['encargado']

            ],

            [
                'FECHA',
                date('d-m-Y H:i:s')

            ]
        ];
    }


    /**
     * Metodo que permite asignar tamaños a las columnas
     *  @date 14-01-2022
     * @copyright ZonaNube (zonanube.cl)
     * @author Raudely Pimentel <rpimentel@zonanube.com>
     */

    public function columnWidths(): array
    {
        return [
            'A' => 15   
        ];
    } 


    /**
     * Metodo que permite devulve los datos de la consulta
     *  @date 14-01-2022
     * @copyright ZonaNube (zonanube.cl)
     * @author Raudely Pimentel <rpimentel@zonanube.com>
     */

    public function array(): array
    {

        return [];
    }


    /**
     * Metodo que permite asignar formatos a las columnas
     *  @date 14-01-2022
     * @copyright ZonaNube (zonanube.cl)
     * @author Raudely Pimentel <rpimentel@zonanube.com>
     */

    public function columnFormats(): array
    {
        return [
        ];
    }


    /**
     * Metodo que permite dar estilos
     *  @date 14-01-2022
     * @copyright ZonaNube (zonanube.cl)
     * @author Raudely Pimentel <rpimentel@zonanube.com>
     */

    public function styles(Worksheet $sheet)
    {

        $sheet->getStyle('A1:A3')->getFont()->setBold(true)->getColor()->setARGB('FFFFFF');
        $sheet->getStyle('A1:A3')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('3BAAE3');
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
    }

    /**
     * Metodo que permite mapear los datos
     *  @date 14-01-2022
     * @copyright ZonaNube (zonanube.cl)
     * @author Raudely Pimentel <rpimentel@zonanube.com>
     */

    public function mapDatos () {


    }

    /**
     * Metodo que permite agregar eventos, em este caso inmovilizar primera fila
     *  @date 08-06-2022
     * @copyright ZonaNube (zonanube.cl)
     * @author Raudely Pimentel <rpimentel@zonanube.com>
     */
    
    public function registerEvents(): array
    {
        return [];
    }


    // public function charts()
    // {
    //     $label      = [new DataSeriesValues('String', 'Worksheet!$A$7', null, 1)];
    //     $categories = [new DataSeriesValues('String', 'Worksheet!$A$8:$A$9', null, 2)];
    //     $values     = [new DataSeriesValues('Number', 'Worksheet!$B$8:$B$9', null, 2)];

    //     $series = new DataSeries(DataSeries::TYPE_PIECHART, DataSeries::GROUPING_STANDARD,
    //         range(0, \count($values) - 1), $label, $categories, $values);
    //     $plot   = new PlotArea(null, [$series]);

    //     $legend = new Legend();
    //     $chart  = new Chart('chart name', new Title('chart title'), $legend, $plot);
    //     $chart->setTopLeftPosition('D1');

    //     return $chart;
    // }
}
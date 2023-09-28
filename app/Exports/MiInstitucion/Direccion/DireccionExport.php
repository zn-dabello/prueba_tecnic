<?php

namespace App\Exports\MiInstitucion\Direccion;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Exports\MiInstitucion\Direccion\Sheets\DireccionesExport;
use App\Exports\Generales\InfoUserExport;

class DireccionExport implements WithMultipleSheets
{
    use Exportable;

    protected $sheets;

    public function __construct(array $sheets)
    {
        $this->sheets = $sheets;
    }

    /**
     * Funcion que contiene las pestañas del archivo de Contratistas Trabajadores
     * @date 16-08-2023
     * @copyright ZonaNube (zonanube.cl)
     * @author Raudely Pimentel <rpimentel@zonanube.com>
     */
    public function sheets(): array
    {

        $sheets = [
            new DireccionesExport($this->sheets),
            new InfoUserExport($this->sheets) // informacion usuario quien descarga archivo
        ];


        return $sheets;

    }
}

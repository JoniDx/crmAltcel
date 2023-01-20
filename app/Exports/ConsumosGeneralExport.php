<?php

namespace App\Exports;

use App\User;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ConsumosGeneralExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    public $info;
    public function __construct($data)
    {
        $this->info = $data;
    }

    public function styles(Worksheet $sheet){
        return [
            1 => ['font' => ['bold' => true,
                             'italic' => true
                             ]
                ]
        ];
    }

    public function headings(): array{
        return [
            'Fecha',
            'MSISDN',
            'Consumos'
        ];
    }

    public function collection()
    {
        $start = $this->info['start_date'];
        $end = $this->info['end_date'];
        $type = $this->info['type'];
        $año = substr($start, -4);
        $mes = substr($start, 0,2);
        $dia = substr($start, 3, -5);
        $dateStart = $año. '-'. $mes.'-'.$dia;
        $añoEnd = substr($end, -4);
        $mesEnd = substr($end, 0,2);
        $diaEnd = substr($end, 3, -5);
        $dateEnd = $añoEnd. '-'. $mesEnd.'-'.$diaEnd;

        if ($type == 'datosgeneral') {
            $consumos = DB::select("CALL sftp_altan.consumos_datos_general('".$dateStart."','".$dateEnd."')");
        }elseif ($type == 'smsGeneral') {
            $consumos = DB::select("CALL sftp_altan.consumos_sms_general('".$dateStart."','".$dateEnd."')");
        }elseif ($type == 'minGeneral') {
            $consumos = DB::select("CALL sftp_altan.consumos_voz_general('".$dateStart."','".$dateEnd."')");
        }elseif($type == 'datosAnual'){
            $consumos = DB::select("CALL sftp_altan.consumos_datos_monthly('".$dateStart."','".$dateEnd."')");
        }
        
        return collect($consumos);
    }
}

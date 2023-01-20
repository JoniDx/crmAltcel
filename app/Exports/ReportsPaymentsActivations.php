<?php

namespace App\Exports;

use App\User;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportsPaymentsActivations implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
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
            'Fecha de Activación',
            'Monto Plan',
            'Monto Dispositivo',
            'Cliente',
            'Tipo',
            'MSISDN'
        ];
    }

    public function collection()
    {
        $start = $this->info['start'];
        $end = $this->info['end'];
        $type = $this->info['type'];

        $news = DB::table('activations_cash')->whereBetween('date_activation',[$start,$end])->select('activations_cash.*')->get();
        
        return collect($news);
    }
}

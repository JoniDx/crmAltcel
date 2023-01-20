<?php

namespace App\Exports;

use App\User;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MonthlyPayments implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
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
            'SIM',
            'MONTO',
            'FECHA'
        ];
    }

    public function collection()
    {
        $start = $this->info['date_start'];
        $end = $this->info['date_end'];
        $news = DB::table('monthly_payments_dayli')->whereBetween('fecha',[$start,$end])->select('monthly_payments_dayli.*')->get();
               
        
        return collect($news);
    }
}

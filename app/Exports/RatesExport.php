<?php

namespace App\Exports;

use App\Rate;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RatesExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
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
            'Plan',
            'Precio',
            'Oferta Primaria',
            'Recurrencia',
        ];
    }
    public function collection()
    {
        return DB::table('rates')
                  ->join('offers','offers.id','=','rates.alta_offer_id')
                  ->where('rates.status','activo')
                  ->select('rates.name','rates.price','offers.name AS offer_name','rates.recurrency')
                  ->get();
    }
}

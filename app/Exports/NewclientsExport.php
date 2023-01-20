<?php

namespace App\Exports;

use App\User;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class NewclientsExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
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
            'Nombre',
            'Apellido',
            'Email',
            'Dirección',
            'Contacto',
            'Añadido Por',
            'Interesado En',
            'Fecha de Alta'
        ];
    }

    public function collection()
    {
        $news = DB::table('users')
               ->leftJoin('activations','activations.client_id','=','users.id')
               ->leftJoin('instalations','instalations.client_id','=','users.id')
               ->join('clients','clients.user_id','=','users.id')
               ->where('role_id',3)
               ->where('activations.client_id',null)
               ->where('instalations.client_id',null)
               ->select('users.name','users.lastname','users.email','clients.address AS address','clients.cellphone AS phone','clients.who_did_id AS who_added','clients.interests AS interests','clients.date_created AS date_created')
               ->get();
               
        $newClients = [];

        foreach($news as $new){
            $who_added = $new->who_added;
            $user_who_added = User::where('id',$who_added)->first();
            $email_bool = strpos($new->email, '@');
            $email = $email_bool ? $new->email : 'N/A';
            array_push($newClients,array(
                'name' => strtoupper($new->name),
                'lastname' => strtoupper($new->lastname),
                'email' => $email,
                'address' => strtoupper($new->address),
                'phone' => $new->phone,
                'who_did_id' => strtoupper($user_who_added->name.' '.$user_who_added->lastname),
                'interests' => $new->interests,
                'date_created' => $new->date_created
            ));
        }
        return collect($newClients);
    }
}

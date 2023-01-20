<?php

namespace App\Exports;

use App\User;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportsActivations implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
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
            'Nombre',
            'Apellido',
            'Contacto',
            'MSISDN/Número',
            'IMEI/No. Serie',
            'ICC',
            'Plan/Paquete',
            'Servicio',
            'Status',
            'Plan',
            'CPE',
            'Fecha de Activación',
            'Activador Por'
        ];
    }

    public function collection()
    {
        $start = $this->info['start_date'];
        $end = $this->info['end_date'];
        $type = $this->info['type'];
        if($start != null && $end != null){
            $año = substr($start, -4);
            $mes = substr($start, 0,2);
            $dia = substr($start, 3, -5);
            $dateStart = $año. '-'. $mes.'-'.$dia;
            $añoEnd = substr($end, -4);
            $mesEnd = substr($end, 0,2);
            $diaEnd = substr($end, 3, -5);
            $dateEnd = $añoEnd. '-'. $mesEnd.'-'.$diaEnd;
        }
        
        $response = [];

        if ($type == 'general') {
            $dataOne = DB::table('users')
                        ->join('activations','activations.client_id','=','users.id')
                        ->join('numbers','numbers.id','=','activations.numbers_id')
                        ->join('rates','rates.id','=','activations.rate_id')
                        ->leftJoin('devices','devices.id','=','activations.devices_id')
                        ->leftJoin('clients','clients.user_id','=','users.id')
                        ->select('users.name AS name', 'users.lastname','clients.cellphone AS cellphone','numbers.MSISDN AS MSISDN','devices.no_serie_imei AS imei','numbers.icc_id AS icc','rates.name AS rate_name','numbers.producto AS service','numbers.traffic_outbound_incoming AS status_one','numbers.traffic_outbound AS status_two','numbers.status_altan AS status_three','rates.price_subsequent AS amount_rate','activations.amount_device AS amount_device','activations.date_activation AS date_activation','activations.who_did_id AS activated_by')
                        ->get();
            $dataTwo = DB::table('users')
                    ->join('instalations','instalations.client_id','=','users.id')
                    ->join('packs','packs.id','=','instalations.pack_id')
                    ->leftJoin('clients','clients.user_id','=','users.id')
                    ->where('packs.service_name', 'like','%Telmex%')
                    ->select('users.name AS name', 'users.lastname','clients.cellphone AS cellphone','instalations.number AS MSISDN','instalations.serial_number AS imei','instalations.mac_address_router AS icc','packs.name AS rate_name','packs.service_name AS service','instalations.radiobase_id AS status_one','instalations.radiobase_id AS status_two','instalations.radiobase_id AS status_three','packs.price AS amount_rate','instalations.amount_install AS amount_device','instalations.date_instalation AS date_activation','instalations.who_did_id AS activated_by')
                    ->get(); 
            
        }else if($type == 'TELMEX'){
            $data = DB::table('users')
                    ->join('instalations','instalations.client_id','=','users.id')
                    ->join('packs','packs.id','=','instalations.pack_id')
                    ->leftJoin('clients','clients.user_id','=','users.id')
                    ->where('packs.service_name', 'like','%'.$type.'%')
                    ->select('users.name AS name', 'users.lastname','clients.cellphone AS cellphone','instalations.number AS MSISDN','instalations.serial_number AS imei','instalations.mac_address_router AS icc','packs.name AS rate_name','packs.service_name AS service','instalations.radiobase_id AS status_one','instalations.radiobase_id AS status_two','instalations.radiobase_id AS status_three','packs.price AS amount_rate','instalations.amount_install AS amount_device','instalations.date_instalation AS date_activation','instalations.who_did_id AS activated_by')
                    ->get(); 
        }else{
            if($start == null || $end == null){
                $data = DB::table('users')
                    ->join('activations','activations.client_id','=','users.id')
                    ->join('numbers','numbers.id','=','activations.numbers_id')
                    ->join('rates','rates.id','=','activations.rate_id')
                    ->leftJoin('devices','devices.id','=','activations.devices_id')
                    ->leftJoin('clients','clients.user_id','=','users.id')
                    ->where('numbers.producto', 'like','%'.$type.'%')
                    ->select('users.name AS name', 'users.lastname','clients.cellphone AS cellphone','numbers.MSISDN AS MSISDN','devices.no_serie_imei AS imei','numbers.icc_id AS icc','rates.name AS rate_name','numbers.producto AS service','numbers.traffic_outbound_incoming AS status_one','numbers.traffic_outbound AS status_two','numbers.status_altan AS status_three','rates.price_subsequent AS amount_rate','activations.amount_device AS amount_device','activations.date_activation AS date_activation','activations.who_did_id AS activated_by')
                    ->get(); 
                    
            }else{
                $data = DB::table('users')
                    ->join('activations','activations.client_id','=','users.id')
                    ->join('numbers','numbers.id','=','activations.numbers_id')
                    ->join('rates','rates.id','=','activations.rate_id')
                    ->leftJoin('devices','devices.id','=','activations.devices_id')
                    ->leftJoin('clients','clients.user_id','=','users.id')
                    ->where('numbers.producto', 'like','%'.$type.'%')
                    ->whereBetween('activations.date_activation', [$dateStart, $dateEnd])
                    ->select('users.name AS name', 'users.lastname','clients.cellphone AS cellphone','numbers.MSISDN AS MSISDN','devices.no_serie_imei AS imei','numbers.icc_id AS icc','rates.name AS rate_name','numbers.producto AS service','numbers.traffic_outbound_incoming AS status_one','numbers.traffic_outbound AS status_two','numbers.status_altan AS status_three','rates.price_subsequent AS amount_rate','activations.amount_device AS amount_device','activations.date_activation AS date_activation','activations.who_did_id AS activated_by')
                    ->get(); 
                    
            }
            
        }

        if($type == 'general'){
            foreach ($dataOne as $row) {
                $status = '';
                $service = $row->service;
                $service = trim($service);
                if($row->status_three == 'activo'){
                    if($service == 'MIFI' || $service == 'HBB'){
                        $status = $row->status_one;
                    }else if($service == 'MOV'){
                        $status = $row->status_two;
                    }
                }else{
                    $status = $row->status_three;
                }

                $activatedBy = 'N/A';

                if($row->activated_by != null){
                    $dataClient = User::where('id',$row->activated_by)->first();
                    $activatedBy = $dataClient->name.' '.$dataClient->lastname;
                }

                array_push($response,array(
                    'name' => $row->name,
                    'lastname' => $row->lastname,
                    'cellphone' => $row->cellphone,
                    'msisdn' => $row->MSISDN,
                    'imei' => $row->imei,
                    'icc' => $row->icc,
                    'rate_name' => $row->rate_name,
                    'service' => $row->service,
                    'status' => $status,
                    'amount_rate' => $row->amount_rate,
                    'amount_device' => $row->amount_device,
                    'date_activation' => $row->date_activation,
                    'activated_by' => $activatedBy
                ));
            }

            foreach ($dataTwo as $row) {
                $status = '';
                $service = $row->service;
                $service = trim($service);
                if($row->status_three == 'activo'){
                    if($service == 'MIFI' || $service == 'HBB'){
                        $status = $row->status_one;
                    }else if($service == 'MOV'){
                        $status = $row->status_two;
                    }
                }else{
                    $status = $row->status_three;
                }

                $activatedBy = 'N/A';

                if($row->activated_by != null){
                    $dataClient = User::where('id',$row->activated_by)->first();
                    $activatedBy = $dataClient->name.' '.$dataClient->lastname;
                }

                array_push($response,array(
                    'name' => $row->name,
                    'lastname' => $row->lastname,
                    'cellphone' => $row->cellphone,
                    'msisdn' => $row->MSISDN,
                    'imei' => $row->imei,
                    'icc' => $row->icc,
                    'rate_name' => $row->rate_name,
                    'service' => $row->service,
                    'status' => $status,
                    'amount_rate' => $row->amount_rate,
                    'amount_device' => $row->amount_device,
                    'date_activation' => $row->date_activation,
                    'activated_by' => $activatedBy
                ));
            }
        }else{
            foreach ($data as $row) {
                $status = '';
                $service = $row->service;
                $service = trim($service);
                if($row->status_three == 'activo'){
                    if($service == 'MIFI' || $service == 'HBB'){
                        $status = $row->status_one;
                    }else if($service == 'MOV'){
                        $status = $row->status_two;
                    }
                }else{
                    $status = $row->status_three;
                }

                $activatedBy = 'N/A';

                if($row->activated_by != null){
                    $dataClient = User::where('id',$row->activated_by)->first();
                    $activatedBy = $dataClient->name.' '.$dataClient->lastname;
                }

                array_push($response,array(
                    'name' => $row->name,
                    'lastname' => $row->lastname,
                    'cellphone' => $row->cellphone,
                    'msisdn' => $row->MSISDN,
                    'imei' => $row->imei,
                    'icc' => $row->icc,
                    'rate_name' => $row->rate_name,
                    'service' => $row->service,
                    'status' => $status,
                    'amount_rate' => $row->amount_rate,
                    'amount_device' => $row->amount_device,
                    'date_activation' => $row->date_activation,
                    'activated_by' => $activatedBy
                ));
            }
        }
        
        return collect($response);
    }
}

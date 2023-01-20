@extends('layouts.octopus')
@section('content')

<section class="panel">
    <header class="panel-heading">
        <h2 class="panel-title">Facturas</h2>
    </header>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed mb-none">
                <thead>
                    <tr>
                        <th class="text-left">UUID</th>
                        <th class="text-left">RFC Emisor</th>
                        <th class="text-left">Nombre Emisor</th>
                        <th class="text-left">RFC Receptor</th>
                        <th class="text-left">Nombre Receptor</th>
                        <th class="text-left">Ver</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $data)
                    <tr>
              
                        <td class="text-left">{{$data->id}}</td>
                        <td class="text-left">{{$data->rfc_emisor}}</td>
                        <td class="text-left">{{$data->name_emisor}}</td>
                        <td class="text-left">{{$data->rfc_recptor}}</td>
                        <td class="text-left">{{$data->name_recptor}}</td>
                        <td class="text-left">
                            <form action="{{url('/details/'.$data['id'])}}" method="GET">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class="fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3">
                                    <a href="{{url('/details/'.$data['id'])}}"><i class="fa fa-file-text-o"></i></a>
                                </div>
                            </form>
                        </td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
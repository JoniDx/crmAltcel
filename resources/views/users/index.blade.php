@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Usuarios</h2>
    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="{{route('home')}}">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li><span>Dashboard</span></li>
        </ol>
        <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
    </div>
</header>
@if(session('message'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <strong>¡Éxito!</strong> {{session('message')}}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <strong>Upps!!</strong> {{session('error')}} <br>
        <a href="#create" class="alert-link">Intentar de nuevo.</a>
    </div>
@endif
<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">Usuarios</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead >
                <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Email</th>
                <th scope="col">Rol</th>
                <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach( $users as $user )
            <tr style="cursor: pointer;">
                <td>{{ $user->name.' '.$user->lastname }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <select class="form-control form-control-sm select-rol" data-user="{{ $user->id }}">
                        <option selected value='{{ $user->role_id }}'>{{ $user->rol }}</option>
                    @foreach( $roles as $role )
                        @if($user->role_id == $role->id)
                        @else
                        <option value="{{ $role->id }}">{{ $role->rol }}</option>
                        @endif
                    @endforeach
                    </select>
                </td>
                <td>
                    <button type="button" class="mb-xs mt-xs mr-xs btn btn-info update-user" data-user="{{ $user->id }}" data-toggle="modal" ><i class="fa fa-edit"></i></button>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</section>

<div class="row" id="create">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                    <a href="#" class="fa fa-times"></a>
                </div>

                <h2 class="panel-title">Crear Usuario</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="{{route('add-user.post')}}" method="post">
                @csrf
                    <div class="form-group"  style="padding-right: 1rem; padding-left: 1rem;">
                        <h3>Información personal</h3>
                        <div class="form-group col-md-12">
                            <!-- <label class="control-label col-md-6">Vertical Group w/ icon</label> -->
                            <div class="col-md-12">
                                <section class="form-group-vertical">
                                    <div class="input-group input-group-icon">
                                        <span class="input-group-addon">
                                            <span class="icon"><i class="fa fa-user"></i></span>
                                        </span>
                                        <input class="form-control" type="text" id="name" name="name" placeholder="Nombre(s)" required>
                                    </div>
                                    <div class="input-group input-group-icon">
                                        <span class="input-group-addon">
                                            <span class="icon"><i class="fa fa-user"></i></span>
                                        </span>
                                        <input class="form-control" type="text" id="lastname" name="lastname" placeholder="Apellidos" required>
                                    </div>
                                    <div class="input-group input-group-icon">
                                        <span class="input-group-addon">
                                            <span class="icon"><i class="fa fa-envelope"></i></span>
                                        </span>
                                        <input class="form-control" type="text" id="email" name="email" placeholder="Email" required>
                                    </div>
                                    <div class="input-group input-group-icon">
                                        <span class="input-group-addon">
                                            <span class="icon"><i class="fa fa-key"></i></span>
                                        </span>
                                        <input class="form-control" type="password" id="password" name="password" placeholder="Password" required>
                                    </div>
                                   
                                </section>
                            </div>
                            <div class="col-md-6" style="margin-top: 1rem;">
                                <label for="exampleFormControlSelect1">Rol: </label>
                                <select class="form-control form-control-sm" id="role_id" name="role_id" >
                                    @foreach($roles as $role)
                                    <option value="{{$role->id}}">{{$role->rol}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top: 1rem;">
                            <button type="submit" class="btn btn-success">Agregar</button>
                        </div>
                    </div>              

                </form>
            </div>
        </section>

    </div>
</div>

<div class="modal fade" id="modalInfoUser" tabindex="-1" role="dialog" aria-labelledby="myModalTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalTitle"></h4>
            </div>
            <div class="modal-body">
            <form class="form-horizontal form-bordered" action="{{route('update-user.post')}}" method="post">
                @csrf
                    <div class="form-group"  style="padding-right: 1rem; padding-left: 1rem;">
                        <h3>Información personal</h3>
                        <div class="form-group col-md-12">
                            <!-- <label class="control-label col-md-6">Vertical Group w/ icon</label> -->
                            <div class="col-md-12">
                                <section class="form-group-vertical">
                                    <div class="input-group input-group-icon">
                                        <span class="input-group-addon">
                                            <span class="icon"><i class="fa fa-user"></i></span>
                                        </span>
                                        <input class="form-control" type="text" id="name-modal" name="name" placeholder="Nombre(s)" required>
                                    </div>
                                    <div class="input-group input-group-icon">
                                        <span class="input-group-addon">
                                            <span class="icon"><i class="fa fa-user"></i></span>
                                        </span>
                                        <input class="form-control" type="text" id="lastname-modal" name="lastname" placeholder="Apellidos" required>
                                    </div>
                                    <div class="input-group input-group-icon">
                                        <span class="input-group-addon">
                                            <span class="icon"><i class="fa fa-envelope"></i></span>
                                        </span>
                                        <input class="form-control" type="text" id="email-modal" name="email" placeholder="Email" required>
                                    </div>
                                    <div class="input-group input-group-icon">
                                        <span class="input-group-addon">
                                            <span class="icon"><i class="fa fa-key"></i></span>
                                        </span>
                                        <input class="form-control" type="password" id="password" name="password" placeholder="Password" >
                                    </div>
                                   
                                </section>
                                <input type="hidden" name="id" id="id_user_update">
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top: 1rem;">
                        <button type="submit" class="btn btn-success">Agregar</button>
                        </div>
                    </div>              

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('.select-rol').change(function(){
        let value = $(this).val();
        let id = $(this).attr('data-user');
        let token = $('meta[name="csrf-token"]').attr('content');
        let datos = "_token="+token+"&user="+id+"&rol="+value;
        $.ajax({
            url:"{{route('change-rol.post')}}",
            method: "POST",
            data: datos,
            success: function(data){
            //    if(data == 1){
            //        alert('Rol actualizado...');
            //    }
            }
        });  
    });

    $('.update-user').click(function(){
        let id = $(this).attr('data-user');
        $.ajax({
            url:"{{route('get-user.get')}}",
            data: {id:id},
            success: function(data){
                console.log(data);
                $('#id_user_update').val(id)
                $('#myModalTitle').html('Datos de <strong>'+data.name+' '+data.lastname+'</strong>');
                $('#name-modal').val(data.name);
                $('#lastname-modal').val(data.lastname);
                $('#email-modal').val(data.email);
                $('#modalInfoUser').modal('show');
            }
        }); 
        
    });
</script>
@endsection
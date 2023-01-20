@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Mi Perfil</h2>
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
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                    <a href="#" class="fa fa-times"></a>
                </div>

                <h2 class="panel-title">Datos Personales</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" method="get">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="control-label" for="inputPopover">Nombre</label>
                                    <input type="text" class="form-control" id="name" value="{{Auth::user()->name}}">
                                </div>
                                <div class="visible-xs mb-md"></div>
                                <div class="col-sm-6">
                                    <label class="control-label" for="inputPopover">Apellidos</label>
                                    <input type="text" class="form-control" id="lastname" value="{{Auth::user()->lastname}}">
                                </div>
                                <div class="visible-xs mb-md"></div>
                                <div class="col-sm-6">
                                    <label class="control-label" for="inputPopover">Email</label>
                                    <input type="text" class="form-control" id="email" value="{{Auth::user()->email}}">
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label" for="inputPopover">Contraseña</label>
                                    <input type="password" class="form-control" id="password" placeholder="Contraseña Nueva">
                                </div>
                                <input type="hidden" id="user_id" value="{{Auth::user()->id}}">
                            </div>

                            <button type="button" class="btn btn-success" style="margin-top: 1rem;" id="save">Guardar</button>
                        </div>
                    </div>

                </form>
            </div>
        </section>

    </div>
</div>

<script>
    $('#save').click(function(){
        let name = $('#name').val();
        let lastname = $('#lastname').val();
        let email = $('#email').val();
        let password = $('#password').val();
        let user_id = $('#user_id').val();

        if(name.length == 0 || /^\s+$/.test(name)){
            let message = "El campo Nombre no puede estar vacío.";
            sweetAlertFunction(message);
            document.getElementById('name').focus();
            return false;
        }

        if(lastname.length == 0 || /^\s+$/.test(lastname)){
            let message = "El campo Apellidos no puede estar vacío.";
            sweetAlertFunction(message);
            document.getElementById('lastname').focus();
            return false;
        }

        if(email.length == 0 || /^\s+$/.test(email)){
            let message = "El campo Email no puede estar vacío.";
            sweetAlertFunction(message);
            document.getElementById('email').focus();
            return false;
        }

        if(password.length == 0 || /^\s+$/.test(password)){
            password = "null";
        }

        $.ajax({
                url: "{{ route('update-my-profile')}}",
                data:{name:name, lastname:lastname, email:email, password:password,id:user_id},
                success: function(data){
                    location.reload();
                }
            });
    });

    function sweetAlertFunction(message){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: message,
        });
    }
</script>
@endsection
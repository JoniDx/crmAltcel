<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accesos Altcel II</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body col-md-12">
                <h5 class="card-title">Hola, {{$name}} {{$lastname}}.</h5>
                <p class="card-text">Te proporcionamos los accesos a nuestra plataforma, donde podrás 
                consultar tus servicios y asuntos relacionados con los mismos, así como realizar tus pagos sin atrasarte.<br>
                <strong>Usuario: </strong>{{$user}}<br>
                <strong>Contraseña: </strong>{{$password}}<br>
                <span class="text-danger">Te sugerimos cambiar tu contraseña a una más segura.</span></p>
                <a href="https://clientes.altcel2.com" class="btn btn-success">Ingresar</a>
            </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificaciones Altcel II</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body col-md-12">
                <div class="alert alert-success" role="alert">
                    Pago realizado con éxito.
                </div>
                <h5 class="card-title">Hola, {{$name}} {{$lastname}}.</h5>
                <p class="card-text">Te notificamos que tu pago de servicio {{$service}} con el plan {{$rate}} fue registrado exitosamente con la referencia {{$reference}}.</p>
                <a href="https://contact.altcel2.com" class="btn btn-success">Ver mis productos</a>
            </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
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
                <h5 class="card-title">Remitente: {{$remitente}}, {{$email_remitente}}</h5>
                <h5 class="card-title">Destinatario: {{$email[0]}} {{$email[1]}} {{$email[2]}} {{$email[3]}} {{$email[4]}} {{$email[5]}} {{$email[5]}}</h5><br>
                <p class="card-text">Hola, {{$body}} {{$product}} para el cliente {{$name}} {{$lastname}} con correo {{$correo}}<br><br>

                <strong>Comentario: </strong>{{$comment}}
            </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ url('/img/Isotipo.ico') }}" type="image/x-icon">
    <title> Informe al Patrono</title>
    <style>
        table {
            border-collapse: collapse;
        }
        table,
        th,
        td {
            border: 1px solid black;
        }
        th,
        td {
            padding: 5px;
        }
    </style>

    <body style="font-size: 14px; font-family: 'Roboto Slab', serif;">
        <div style="float: left; margin-top: -25px;" >
            <img src="{{ url('static/imagenes/Isotipo.png') }}" alt="" width="80" height="80"/>
        </div>
        <div style="text-align: center; margin-top: 0px; margin-left: -1000px;">
            <span><strong> INFORME AL PATRONO </strong> </span>
            <br>
            <span>(Asistencia del afiliado)</span>
        </div>
        <div style="float: right; margin-top: -25px;">
            <span><strong> DGPS-231 </strong> </span>
        </div>
        <br><br>
        <div style="float: left; margin-top: 50px; margin-left: 0px;  width: 500px; height: 25px; font-size: 16px;" >
            <span ><strong> Unidad: </strong>{{ $appointment->patient->unit->name }}  </span>            
        </div>
        <div style="float: right; margin-top: 50px; margin-right: -300px;  width: 500px; height: 25px; font-size: 16px;" >
            <span ><strong> Fecha: </strong>{{ \Carbon\Carbon::parse($appointment->date)->isoFormat('DD MMMM YYYY', 'es') }}  </span>                 
        </div>
        <br><br>
        <div style="float: left; margin-top: 50px; margin-left: -500px;  width: 500px; height: 25px; font-size: 16px;" >
            <span ><strong> Nombre del Afiliado: </strong>{{ $appointment->patient->name.' '.$appointment->patient->lastname }}  </span>            
        </div>
        <div style="float: right; margin-top: 50px; margin-right: -500px;  width: 500px; height: 25px; font-size: 16px;" >
            <span ><strong> No. de Afiliación: </strong>{{ $appointment->patient->affiliation  }}  </span>                 
        </div>

        <br><br>
        <table width="100%"  style=" margin-top:60px; text-align: center; font-size: 12px;">
            <tr>
                <th ROWSPAN="2">Llegó</th>
                <th>Clinica</th>
                <th>Farmacia</th>
                <th>Laboratorio</th>
                <th>Rayos X</th>
                <th></th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th>{{ $appointment->check_in }}</th>
                <th></th>
            </tr>
            <tr>
                <th>Salió</th>
                <th></th>
                <th></th>
                <th></th>
                <th>{{ $appointment->check_out }}</th>
                <th></th>
            </tr>
            <tr>
                <th>Nombre R.</th>
                <th></th>
                <th></th>
                <th></th>
                <th>{{ Auth::user()->name }} {{ Auth::user()->lastname }}</th>
                <th></th>
            </tr>
            <tr>
                <th>Firma R.</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </table>

        
        <span>
            <h3>Observaciones: </h3>
        </span>
    </body>

    
</html>
@extends('admin.master')
@section('title','Agendar Cita')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/equipments/all') }}" class="nav-link"><i class="fas fa-columns"></i> Citas</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/equipments/add') }}" class="nav-link"><i class="fas fa-plus-circle"></i> Agendar Nueva</a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        {!! Form::open(['url'=>'/admin/cita/agregar']) !!}
        <div class="row">
            <div class="col-md-4 d-flex">
                <div class="panel shadow">
                    <!-- Modal -->

                    <div class="header">
                        <h2 class="title"><i class="fas fa-cogs"></i><strong> Información Paciente</strong></h2>
                    </div>

                    <div class="inside">   
                        
                        {!! Form::hidden('patient_id', null, ['class'=>'form-control', 'id'=> 'patient_id']) !!}
                        {!! Form::hidden('type_exam', null, ['class'=>'form-control', 'id'=> 'type_examp']) !!}

                        <label for="name" ><strong> Numero de Afiliacion: </strong></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-keyboard"></i></span>
                            {!! Form::text('affiliationp', null, ['class'=>'form-control', 'id'=>'affiliationp']) !!}
                            {!! Form::select('type', getExamB('list', null),0,['class'=>'form-select col-md-4', 'id'=> 'exam_b' ]) !!}
                            <a href="#" class="btn btn-sm btn-info " id="btn_add_patient_search" data-toogle="tooltrip" data-placement="top" title="Buscar" ><i class="fas fa-search"></i> </a>
                            <a href="{{ url('/admin/cita/agregar') }}" class="btn btn-sm btn-warning " data-toogle="tooltrip" data-placement="top" title="Limpiar" ><i class="fa fa-refresh"></i> </a>
                        </div>

                        <label for="name" class="mtop16"><strong> Nombre:</strong></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-keyboard"></i></span>
                            {!! Form::text('namep', null, ['class'=>'form-control', 'id'=> 'namep', 'readonly']) !!}
                        </div>

                        <label for="name" class="mtop16"><strong> Apellidos:</strong></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-keyboard"></i></span>
                            {!! Form::text('lastnamep', null, ['class'=>'form-control', 'id'=>'lastnamep', 'readonly']) !!}
                        </div>

                        <label for="name" class="mtop16"><strong> Contacto:</strong></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-keyboard"></i></span>
                            {!! Form::text('contactp', null, ['class'=>'form-control', 'id'=>'contactp']) !!}
                        </div>

                        <label for="name" class="mtop16"><strong> Numero de Expediente Actual:</strong></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-keyboard"></i></span>
                            {!! Form::text('numexpp', null, ['class'=>'form-control', 'id' => 'numexpp','readonly']) !!}
                        </div>

                        


                    </div>

                </div>
            </div>

            <div class="col-md-4 d-flex"> 
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"><i class="fas fa-calendar-alt"></i><strong> Ultimo Examen Realizado</strong></h2>
                    </div>

                    <div class="inside"> 

                        <div class="row">
                            <div class="col-md-12">
                                <label for="name" ><strong> Fecha de Cita:</strong></label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-keyboard"></i></span>
                                    {!! Form::text('date_al', null, ['class'=>'form-control', 'id' => 'date_al', 'readonly']) !!} 
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <label for="name"><strong> Numero de Expediente:</strong></label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-keyboard"></i></span>
                                    {!! Form::text('numexp_al', null, ['class'=>'form-control', 'id' => 'numexp_al', 'readonly']) !!}
                                </div>
                            </div>

                        </div>
                        
                        

                        <label for="name" class="mtop16"><strong> Detalle de la Cita:</strong></label>
                        <table id="detalles1" class= "table table-striped table-bordered table-condensed table-hover">
                            <thead style="background-color: #c3f3ea">
                                <th><strong> SERVICIO SOLICITANTE </strong></th>
                                <th><strong> ESTUDIO </strong></th>
                            </thead>
                            <tbody>
                                

                            </tbody>
                        </table> 


                        <label class="mtop16" style="color: red; font-size: 1.5em; margin-left: 50px; font-weight: bold; display: none;" id="appointment_msg" >¡No se encontraron citas previas!</label>


                        
                    </div>

                </div>
            </div>

            <div class="col-md-4 d-flex">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"><i class="fas fa-calendar-plus"></i><strong> Información Para Cita Nueva</strong></h2>
                    </div>

                    <div class="inside"> 
                        
                        <label for="name"><strong>Fecha a Agendar:</strong></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-keyboard"></i></span>
                            {!! Form::date('date', null, ['class'=>'form-control', 'id' => 'date_new_app']) !!}
                        </div>

                        {!! Form::hidden('citas_configuradas', Config::get('agem.citas_configuradas'), ['id' => 'citas_configuradas']) !!}
                        <label for="name" class="mtop16"><strong>Horarios de Atención:</strong></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-keyboard"></i></span>
                            <select name="schedule" id="schedules" style="width: 88%" >
                                @foreach($schedules as $s)
                                    <option value=""></option>
                                    <option value="{{ $s->id }}">{{ \Carbon\Carbon::parse($s->hour_in)->format('H:i').' '.getHourType(null, $s->type) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <label for="idsupplier" class="mtop16"><strong> Servicio Solicitante:</strong></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-layer-group"></i></span>                            
                            <select name="pidservice" id="pidservice" style="width: 88%" >
                                @foreach ($services as $s)
                                    <option value=""></option>
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <label for="idsupplier" class="mtop16"><strong> Estudio / Examen A Realizar:</strong></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-layer-group"></i></span>
                            {!! Form::select('studies', $studies,0,['class'=>'form-select', 'id' => 'studies', 'style' => 'width: 88%']) !!}
                            {!! Form::hidden('studies_actual', 0, ['id' => 'studies_actual']) !!}
                        </div>

                        <label for="name" class="mtop16"><strong> Comentario:</strong></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-keyboard"></i></span>
                            {!! Form::textarea('pcomment', null, ['class'=>'form-control', 'rows' => '2', 'id'=>'pcomment']) !!}
                        </div>

                        <div class="input-group mtop16">
                            {!! Form::button('Agregar', ['class'=>'btn btn-primary', 'id'=>'btn_agregar']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mtop16">
            <div class="col-md-12">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"><i class="fas fa-calendar-plus"></i><strong> Detalle de Estudio(s) a Realizar</strong></h2>
                    </div>

                    <div class="inside">

                        <div class="card-body table-responsive">
                            <table id="detalles" class= "table table-striped table-bordered table-condensed table-hover">
                                <thead style="background-color: #c3f3ea">
                                    <th><strong> ELIMINAR </strong></th>
                                    <th><strong> SERVICIO </strong></th>
                                    <th><strong> ESTUDIO </strong></th>
                                    <th><strong> COMENTARIO </strong></th>
                                </thead>

                                <tbody>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>                    
            </div>
        </div>

        <div class="row mtop16">
            <div class="col-md-12">
                <div class="panel shadow">
                    <div class="inside">
                        {!! Form::submit('Guardar', ['class'=>'btn btn-success', 'id'=>'btn_guardar']) !!}
                    </div>
                </div>                    
            </div>
        </div>
        {!! Form::close() !!}
    </div>


    <script>
        var modal = document.getElementById('modelId');
        $("#btn_guardar").hide();
        var cont = 0;


        $(document).ready(function(){
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!
            var yyyy = today.getFullYear();

            if (dd < 10) {
                dd = '0' + dd;
            }

            if (mm < 10) {
                mm = '0' + mm;
            } 
                
            today = yyyy + '-' + mm + '-' + dd;
            document.getElementById("date_new_app").setAttribute("min", today);



            $('#btn_agregar').click(function(){
                agregar_tabla();
            });

            $('#bt_add').click(function(){
                agregar();
            });

            

            $('#bt_search').click(function(){
                $('#modelId').modal("show");
            });
            $('#bt_closeModal').click(function(){
                $('#modelId').modal("hide");
            });
        });



        function limpiar(){
            $("#ppatient_id").val("");
            $("#affiliation_b").val("");
            $("#ppatient_name").val("");
            $("#ppatient_lastname").val("");
            $("#ppatient_contact").val("");
            $("#pcodelast").val("");
            $("#pdate").val("");
            $("#pnumexp").val("");
            $("#pstudie").val("");
            $("#pservice").val("");
        }

        function agregar_tabla(){
            idservice=$("#pidservice").val();
            service=$("#pidservice option:selected").text();
            idstudy=$("#studies").val();
            study=$("#studies option:selected").text();
            comment=$("#pcomment").val();
            if (idservice !="" && idstudy !="" ){
                var fila='<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+');">X</button></td><td><input type="hidden" name="idservice[]" value="'+idservice+'">'+service+'</td><td><input type="hidden" name="idstudy[]" value="'+idstudy+'">'+study+'</td><td><input type="hidden" name="comment[]" value="'+comment+'">'+comment+'</td></tr>';
                cont++;
                limpiar();
                evaluar();
                $('#detalles').append(fila);
            }else{
                alert("Error al ingresar el detalle de la cita, revise los datos de seleccionados.")
            }
        }

        function evaluar(){
            if (cont > 0){
                $("#btn_guardar").show();
            }else{
                $("#btn_guardar").hide();
            }
        }

        function eliminar(index){
            $("#fila" + index).remove();
            cont--;
            evaluar();
        }
        
    </script>
@endsection
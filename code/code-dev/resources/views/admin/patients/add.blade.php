@extends('admin.master')
@section('title','Agregar Paciente')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/equipments/all') }}" class="nav-link"><i class="fas fa-columns"></i> Pacientes</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/equipments/add') }}" class="nav-link"><i class="fas fa-plus-circle"></i> Agregar</a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        {!! Form::open(['url'=>'/admin/paciente/agregar']) !!}
        <div class="row">
            <div class="col-md-4 d-flex">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"><i class="fas fa-cogs"></i><strong> Información Basica</strong></h2>
                    </div>

                    <div class="inside">   
                        <label for="name" class="mtop16"><strong><sup style="color: red;">(*)</sup> Numero de Afiliacion: </strong></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-keyboard"></i></span>
                            {!! Form::select('type_patient', getTypePatient('list', null),0,['class'=>'form-select col-md-2', 'id'=> 'patient_type' ]) !!}
                            {!! Form::text('affiliation', null, ['class'=>'form-control']) !!}                            
                        </div>

                        <div id="af_prin">
                            <label for="name" class="mtop16"><strong><sup style="color: red;">(*)</sup> Afiliacion Principal: </strong></label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-keyboard"></i></span>
                                {!! Form::text('af_prin', null, ['class'=>'form-control']) !!}
                            </div>
                        </div>                        

                        <label for="name" class="mtop16"><strong><sup style="color: red;">(*)</sup> Nombre:</strong></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-keyboard"></i></span>
                            {!! Form::text('name', null, ['class'=>'form-control']) !!}
                        </div>

                        <label for="name" class="mtop16"><strong><sup style="color: red;">(*)</sup> Apellidos:</strong></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-keyboard"></i></span>
                            {!! Form::text('lastname', null, ['class'=>'form-control']) !!}
                        </div>

                        <br>
                        <label for="idsupplier"><strong><sup style="color: red;">(*)</sup> Unidad del Afiliado:</strong></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-layer-group"></i></span>
                            <select name="unit_id" id="idsupplier" style="width: 88%" >
                                @foreach ($units as $u)
                                    <option value=""></option>
                                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-4 d-flex">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"><i class="fas fa-cogs"></i><strong> Información Adicional</strong></h2>
                    </div>

                    <div class="inside"> 
                        <label for="name" class="mtop16"><strong>Genero:</strong></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-layer-group"></i></span>
                            {!! Form::select('gender', getGenderPatient('list', null),0,['class'=>'form-select']) !!}
                        </div>

                        <label for="name" class="mtop16"><strong>Edad:</strong></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-keyboard"></i></span>
                            {!! Form::text('age', null, ['class'=>'form-control']) !!}
                        </div>

                        <label for="name" class="mtop16"><strong>Fecha de Nacimiento:</strong></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-keyboard"></i></span>
                            {!! Form::date('birth', null, ['class'=>'form-control']) !!}
                        </div>

                        <label for="name" class="mtop16"><strong> Numero de Contacto:</strong></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-keyboard"></i></span>
                            {!! Form::text('contact', null, ['class'=>'form-control']) !!}
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-4 d-flex"> 
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"><i class="fas fa-qrcode"></i><strong> Correlativos de Expedientes</strong></h2>
                    </div>

                    <div class="inside"> 
                        <label for="ibm" class="mtop16"><strong><sup style="color: red;">(*)</sup> Numero RX:</strong></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-keyboard"></i></span>
                            {!! Form::text('num_rx', null, ['class'=>'form-control', 'id' => 'pnum_rx']) !!} 
                            <a href="#" class="btn btn-sm btn-primary " id="btn_generate_code_rx" ><i class="fas fa-qrcode"></i> Generar</a>
                            <a href="#" class="btn btn-sm btn-warning " id="btn_manual_code_rx" ><i class="fas fa-qrcode"></i> Ingreso Manual</a>
                            
                            <div id="div_manual_code_rx" style="display: none; margin-top: 10px;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="ibm" class="mtop16"><strong><sup style="color: red;">(*)</sup> Nomenclatura:</strong></label>
                                        {!! Form::text('num_rx_nom', null, ['class'=>'form-control', 'id' => 'pnum_rx_nom']) !!}
                                    </div>

                                    <div class="col-md-6"> 
                                        <label for="ibm" class="mtop16"><strong><sup style="color: red;">(*)</sup> Correlativo:</strong></label>
                                        {!! Form::text('num_rx_cor', null, ['class'=>'form-control', 'id' => 'pnum_rx_cor']) !!} 
                                    </div>                                    
                                </div>

                                <div class="row">
                                    <div class="col-md-12">  
                                        <label for="ibm" class="mtop16"><strong><sup style="color: red;">(*)</sup> Año:</strong></label>
                                        {!! Form::text('num_rx_y', null, ['class'=>'form-control', 'id' => 'pnum_rx_y']) !!} 
                                    </div>
                                </div>
                                
                            </div>
                            
                        </div>

                        <label for="ibm" class="mtop16"><strong><sup style="color: red;">(*)</sup> Numero USG:</strong></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-keyboard"></i></span>
                            {!! Form::text('num_usg', null, ['class'=>'form-control', 'id' => 'pnum_usg']) !!} 
                            <a href="#" class="btn btn-sm btn-primary " id="btn_generate_code_usg" ><i class="fas fa-qrcode"></i> Generar</a>
                            <a href="#" class="btn btn-sm btn-warning " id="btn_manual_code_usg" ><i class="fas fa-qrcode"></i> Ingreso Manual</a>
                            
                            <div id="div_manual_code_usg" style="display: none; margin-top: 10px;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="ibm" class="mtop16"><strong><sup style="color: red;">(*)</sup> Nomenclatura:</strong></label>
                                        {!! Form::text('num_usg_nom', null, ['class'=>'form-control', 'id' => 'pnum_usg_nom']) !!}
                                    </div>

                                    <div class="col-md-6"> 
                                        <label for="ibm" class="mtop16"><strong><sup style="color: red;">(*)</sup> Correlativo:</strong></label>
                                        {!! Form::text('num_usg_cor', null, ['class'=>'form-control', 'id' => 'pnum_usg_cor']) !!} 
                                    </div>                                    
                                </div>

                                <div class="row">
                                    <div class="col-md-12">  
                                        <label for="ibm" class="mtop16"><strong><sup style="color: red;">(*)</sup> Año:</strong></label>
                                        {!! Form::text('num_usg_y', null, ['class'=>'form-control', 'id' => 'pnum_usg_y']) !!} 
                                    </div>
                                </div>
                                
                            </div> 
                        </div>

                        <label for="ibm" class="mtop16"><strong><sup style="color: red;">(*)</sup> Numero MMO:</strong></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-keyboard"></i></span>
                            {!! Form::text('num_mmo', null, ['class'=>'form-control', 'id' => 'pnum_mmo']) !!} 
                            <a href="#" class="btn btn-sm btn-primary " id="btn_generate_code_mmo" ><i class="fas fa-qrcode"></i> Generar</a>
                            <a href="#" class="btn btn-sm btn-warning " id="btn_manual_code_mmo" ><i class="fas fa-qrcode"></i> Ingreso Manual</a>
                            
                            <div id="div_manual_code_mmo" style="display: none; margin-top: 10px;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="ibm" class="mtop16"><strong><sup style="color: red;">(*)</sup> Nomenclatura:</strong></label>
                                        {!! Form::text('num_mmo_nom', null, ['class'=>'form-control', 'id' => 'pnum_mmo_nom']) !!}
                                    </div>

                                    <div class="col-md-6"> 
                                        <label for="ibm" class="mtop16"><strong><sup style="color: red;">(*)</sup> Correlativo:</strong></label>
                                        {!! Form::text('num_mmo_cor', null, ['class'=>'form-control', 'id' => 'pnum_mmo_cor']) !!} 
                                    </div>                                    
                                </div>

                                <div class="row">
                                    <div class="col-md-12">  
                                        <label for="ibm" class="mtop16"><strong><sup style="color: red;">(*)</sup> Año:</strong></label>
                                        {!! Form::text('num_mmo_y', null, ['class'=>'form-control', 'id' => 'pnum_mmo_y']) !!} 
                                    </div>
                                </div>
                                
                            </div> 
                        </div>

                        <label for="ibm" class="mtop16"><strong><sup style="color: red;">(*)</sup> Numero DMO:</strong></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-keyboard"></i></span>
                            {!! Form::text('num_dmo', null, ['class'=>'form-control', 'id' => 'pnum_dmo']) !!} 
                            <a href="#" class="btn btn-sm btn-primary " id="btn_generate_code_dmo" ><i class="fas fa-qrcode"></i> Generar</a>
                            <a href="#" class="btn btn-sm btn-warning " id="btn_manual_code_dmo" ><i class="fas fa-qrcode"></i> Ingreso Manual</a>
                           
                            <div id="div_manual_code_dmo" style="display: none; margin-top: 10px;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="ibm" class="mtop16"><strong><sup style="color: red;">(*)</sup> Nomenclatura:</strong></label>
                                        {!! Form::text('num_dmo_nom', null, ['class'=>'form-control', 'id' => 'pnum_dmo_nom']) !!}
                                    </div>

                                    <div class="col-md-6"> 
                                        <label for="ibm" class="mtop16"><strong><sup style="color: red;">(*)</sup> Correlativo:</strong></label>
                                        {!! Form::text('num_dmo_cor', null, ['class'=>'form-control', 'id' => 'pnum_dmo_cor']) !!} 
                                    </div>                                    
                                </div>

                                <div class="row">
                                    <div class="col-md-12">  
                                        <label for="ibm" class="mtop16"><strong><sup style="color: red;">(*)</sup> Año:</strong></label>
                                        {!! Form::text('num_dmo_y', null, ['class'=>'form-control', 'id' => 'pnum_dmo_y']) !!} 
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        
                    </div>

                </div>
            </div>
        </div>

        <div class="row mtop16">
            <div class="col-md-12">
                <div class="panel shadow">
                    <div class="inside">
                        {!! Form::submit('Guardar', ['class'=>'btn btn-success']) !!}
                    </div>
                </div>                    
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <script>
        $(document).ready(function(){
            
            var patient_type = document.getElementById('patient_type');
            var af_prin = document.getElementById('af_prin');
            
            af_prin.hidden = true;

            $('#patient_type').click(function(){
                if(patient_type.value == 1 || patient_type.value == 2){
                    af_prin.hidden = false;
                }else{
                    af_prin.hidden = true;
                }
            });
        });
    </script>

@endsection
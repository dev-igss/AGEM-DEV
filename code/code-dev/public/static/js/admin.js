const http = new XMLHttpRequest();
const csrfToken = document.getElementsByName('csrf-token')[0].getAttribute('content');
var base = location.protocol+'//'+location.host;
var route = document.getElementsByName('routeName')[0].getAttribute('content');

document.addEventListener('DOMContentLoaded', function(){
    var servicegeneral = document.getElementById('servicegeneral');
    var service = document.getElementById('service');
    var btn_add_patient_search = document.getElementById('btn_add_patient_search');
    var btn_generate_code_rx = document.getElementById('btn_generate_code_rx');
    var btn_generate_code_usg = document.getElementById('btn_generate_code_usg');
    var btn_generate_code_mmo = document.getElementById('btn_generate_code_mmo');
    var btn_generate_code_dmo = document.getElementById('btn_generate_code_dmo');
    var btn_generate_code = document.getElementById('btn_generate_code');
    var btn_generate_code_patient_actual = document.getElementById('btn_generate_code_patient_actual');
    var btn_manual_code_rx = document.getElementById('btn_manual_code_rx');
    var btn_manual_code_usg = document.getElementById('btn_manual_code_usg');
    var btn_manual_code_mmo = document.getElementById('btn_manual_code_mmo');
    var btn_manual_code_dmo = document.getElementById('btn_manual_code_dmo');
    var btn_manual_code = document.getElementById('btn_manual_code');
    var btn_manual_code_patient_actual = document.getElementById('btn_manual_code_patient_actual');
    var btn_update_affiliation = document.getElementById('btn_update_affiliation');

    if(btn_add_patient_search){
        btn_add_patient_search.addEventListener('click', function(e){
            e.preventDefault();
            setInfoAddPatient();
        });
    }

    if(btn_generate_code_rx){
        btn_generate_code_rx.addEventListener('click', function(e){
            e.preventDefault();
            setGenerateCodeRx();
        });
    }

    if(btn_generate_code_usg){
        btn_generate_code_usg.addEventListener('click', function(e){
            e.preventDefault();
            setGenerateCodeUsg();
        });
    }

    if(btn_generate_code_mmo){
        btn_generate_code_mmo.addEventListener('click', function(e){
            e.preventDefault();
            setGenerateCodeMmo();
        });
    }

    if(btn_generate_code_dmo){
        btn_generate_code_dmo.addEventListener('click', function(e){
            e.preventDefault();
            setGenerateCodeDmo();
        });
    }

    if(btn_generate_code){
        btn_generate_code.addEventListener('click', function(e){
            e.preventDefault();
            setGenerateCode();
        });
    }

    if(btn_generate_code_patient_actual){
        btn_generate_code_patient_actual.addEventListener('click', function(e){
            e.preventDefault();
            setGenerateCodePatientActual();
        });
    }


    if(btn_manual_code_rx){
        btn_manual_code_rx.addEventListener('click', function(e){
            e.preventDefault();
            document.getElementById("div_manual_code_rx").style.display = "block";
        });
    }
    
    if(btn_manual_code_usg){
        btn_manual_code_usg.addEventListener('click', function(e){
            e.preventDefault();
            document.getElementById("div_manual_code_usg").style.display = "block";
        });
    }
    
    if(btn_manual_code_mmo){
        btn_manual_code_mmo.addEventListener('click', function(e){
            e.preventDefault();
            document.getElementById("div_manual_code_mmo").style.display = "block";
        });
    }
    
    if(btn_manual_code_dmo){
        btn_manual_code_dmo.addEventListener('click', function(e){
            e.preventDefault();
            document.getElementById("div_manual_code_dmo").style.display = "block";
        });
    }

    if(btn_manual_code){
        btn_manual_code.addEventListener('click', function(e){
            e.preventDefault();
            document.getElementById("div_manual_code_new").style.display = "block";
        });
    }

    if(btn_manual_code_patient_actual){
        btn_manual_code_patient_actual.addEventListener('click', function(e){
            e.preventDefault();
            document.getElementById("div_manual_code_patient_actual").style.display = "block";
        });
    }
    
    if(btn_update_affiliation){
        btn_update_affiliation.addEventListener('click', function(e){
            e.preventDefault();
            document.getElementById("div_update_affiliation").style.display = "block";
        });
    }

   
    if(route == "equipment_add"){
        setServiceToEquipment();
        setEnvironmentToEquipment();
    }

    if(route == "appointment_add"){
        getDisponibilidadHorario();
    }

    document.getElementsByClassName('lk-'+route)[0].classList.add('active');

    btn_deleted = document.getElementsByClassName('btn-deleted');
    for(i=0; i < btn_deleted.length; i++){
        btn_deleted[i].addEventListener('click', delete_object);
    }

    if(servicegeneral){
        servicegeneral.addEventListener('change', setServiceToEquipment);
    }

    if(service){
        service.addEventListener('change', setEnvironmentToEquipment);
    }

    $('#table-modules').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        language: {
            "decimal": "",
            "emptyTable": "No hay registros",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
            "infoEmpty": "Mostrando 0 to 0 of 0 Registros",
            "infoFiltered": "(Filtrado de _MAX_ total registros)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Registros",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    });

    $('#table-modules1').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        language: {
            "decimal": "",
            "emptyTable": "No hay registros",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
            "infoEmpty": "Mostrando 0 to 0 of 0 Registros",
            "infoFiltered": "(Filtrado de _MAX_ total registros)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Registros",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    });

    $('#table-modules2').DataTable({ 
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        language: {
            "decimal": "",
            "emptyTable": "No hay registros",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
            "infoEmpty": "Mostrando 0 to 0 of 0 Registros",
            "infoFiltered": "(Filtrado de _MAX_ total registros)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Registros",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    });

    $("#pidservice").select2({
        placeholder: "Seleccione una Opci??n",
        allowClear: true
    });

    $("#pidstudy").select2({
        placeholder: "Seleccione una Opci??n",
        allowClear: true
    });

    $("#idsupplier").select2({
        placeholder: "Seleccione una Opci??n",
        allowClear: true
    });

    $("#idproduct").select2({
        placeholder: "Seleccione una Opci??n",
        allowClear: true
    });

    $("#studies").select2({
        placeholder: "Seleccione una Opci??n",
        allowClear: true
    });

    $("#schedules").select2({
        placeholder: "Seleccione una Opci??n",
        allowClear: true
    });


});



function delete_object(e){
    e.preventDefault();
    var object = this.getAttribute('data-object');
    var action = this.getAttribute('data-action');
    var path = this.getAttribute('data-path');
    var idstudy = this.getAttribute('data-study');
    var exam = this.getAttribute('data-exam');
    var date = this.getAttribute('data-date');
    //console.log(exam);
    var url = base + '/agem/public/' + path + '/' + object + '/' + action;
    //var url = base + '/' + path + '/' + object + '/' + action;
    var title, text, icon, date, status, material, amount, comment;
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
    //console.log(today);

    if(action == "borrar"){ 
        title = '??Esta seguro de '+'"Borrar"'+' est?? registro?';
        text = "Recuerde que esta acci??n no se podra realizar nuevamente.";
        icon = "warning";
    }

    if(action == "reprogramar"){ 
        title = '??Esta seguro de '+'"Reprogramar"'+' esta cita?';
        text = "Recuerde que esta acci??n no se podra realizar nuevamente.";
        icon = "warning";
    }

    if(action == "reprogramacion_forzada"){
        title = '??Esta seguro de '+'"Reprogramar"'+' esta cita?';
        text = "Recuerde que esta acci??n no se podra realizar nuevamente.";
        icon = "warning";
    }

    if(action == "cambio_horario"){
        title = '??Esta seguro de '+'"Cambiar el horario"'+' de esta cita?';
        text = "Recuerde que esta acci??n no se podra realizar nuevamente.";
        icon = "warning";
    }

    if(action == "paciente_presente"){
        title = '??Esta seguro de marcar como'+'"Paciente Presente"'+' en esta cita?';
        text = "Recuerde que esta acci??n no se podra realizar nuevamente.";
        icon = "success";
    }

    if(action == "paciente_ausente"){
        title = '??Esta seguro de marcar como'+'"Paciente Ausente"'+' en esta cita?';
        text = "Recuerde que esta acci??n no se podra realizar nuevamente.";
        icon = "error";
    }

    if(action == "registro_materiales"){
        title = '??Esta seguro de agregar m??s materiales a este estudio?';
        text = "Recuerde que esta acci??n no se podra realizar nuevamente.";
        icon = "info";
    }

    if(action == "material_desechado"){
        title = '??Esta seguro de marcar como'+'"Desechado"'+' este(s) material(es)?';
        text = "Recuerde que esta acci??n no se podra realizar nuevamente.";
        icon = "warning";
    }

    if(action == "reprogramar"){ 
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            showCancelButton: true,
            html: '<input type="date" id="swal-input" class="swal2-input" min="'+today+'">',
            focusConfirm: false,
            allowOutsideClick: false,
            preConfirm: () => {
                
                return document.getElementById('swal-input').value;
            }
        }).then((result) =>{
            if (result.isConfirmed) {
                date = result.value;
                
                window.location.href = url+'/'+date;
            }            
        });
    }else if(action == "reprogramacion_forzada"){
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            showCancelButton: true,
            html: '<input type="date" id="swal-input" class="swal2-input" min="'+today+'"><label>Motivo:</label><input type="text" id="swal-input2" class="swal2-input" min="'+today+'">',
            focusConfirm: false,
            allowOutsideClick: false,
            preConfirm: () => {

                return [
                            
                    date = document.getElementById('swal-input').value,                           
                    comment = document.getElementById('swal-input2').value
                ]
                
            }
        }).then((result) =>{
            if (result.isConfirmed) {        
                if(document.getElementById('swal-input3').value != ""){
                    window.location.href = url+'/'+date+'/'+comment;
                }else{
                    window.location.href = url+'/'+date;
                }

                
            } 

            
                       
        });
    }else if(action == "paciente_presente"){
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            showCancelButton: true
        }).then((result) =>{
            if (result.isConfirmed) {
                status = "1";
                window.location.href = url+'/'+status;
            }            
        });
    }else if(action == "paciente_ausente"){
        Swal.fire({
            title: title,
            text: text, 
            icon: icon,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            showCancelButton: true
        }).then((result) =>{
            if (result.isConfirmed) {
                status = "2";
                window.location.href = url+'/'+status;
            }            
        });
    }else if(action == "registro_materiales"){
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            html:
            '<label> <strong> Seleccione el material utilizado </strong> </label>'
            +
            '<select id="swal-input2" class="swal2-input"> <option value="0">Placa 8x10</option> <option value="1">Placa 10x12</option> <option value="2">Placa 11x14</option> <option value="3">Placa 14x17</option> <option value="8">SINGOPLAZA</option> <option value="4">Hojas</option> <option value="5">Fotos</option> <option value="6">Pelicula 8x10</option> <option value="7">Pelicula 10x12</option></select>'
            + 
            '<label> <strong> Cantidad de material utilizado </strong> </label>'
            +
           '<input id="swal-input3" class="swal2-input">',
            preConfirm: () => {
                return [
                    material = document.getElementById('swal-input2').value,
                    amount = document.getElementById('swal-input3').value
                ]
            }
        }).then((result) =>{
            if (result.isConfirmed) {
                
                window.location.href = url+'/'+idstudy+'/'+material+'/'+amount;
            }            
        });
    }else if(action == "material_desechado"){
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showDenyButton: true,
            confirmButtonText: 'Desechar',
            denyButtonText: 'Cancelar',
        }).then((result) =>{

            if (result.isConfirmed) {
                
                window.location.href =  url;
            }
        });
    }else if(action == "borrar"){
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showDenyButton: true,
            confirmButtonText: 'Aceptar',
            denyButtonText: 'Cancelar',
        }).then((result) =>{

            if (result.isConfirmed) {
                //console.log(url);
                window.location.href =  url;
            }
        });
    }else if(action == "cambio_horario"){       
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showDenyButton: true,
            confirmButtonText: 'Cambiar',
            denyButtonText: 'Cancelar',
        }).then((result) =>{
            if (result.isConfirmed) {
                

                Swal.fire({
                    
                    title: title,
                    text: text,
                    icon: icon,
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    html:
                    '<label> <strong> Seleccione el nuevo horario </strong> </label>'
                    +
                    '<select id="swal-input2" class="swal2-input"> </select>',
                    preConfirm: () => {
                        return [
                            
                            horario = document.getElementById('swal-input2').value                          
                        ]
                    }
                    
                }).then((result) =>{
                    if (result.isConfirmed) {
                        
                        window.location.href = url+'/'+horario;

                          
                        //console.log(url+'/'+horario);
                    }
                    
                });    
                select = document.getElementById('swal-input2');
                select.innerHTML = "";
                var url1 = base + '/agem/public/admin/agem/api/load/schedules/change';
                //var url1 = base + '/admin/agem/api/load/schedules/'+fecha+'/'+exam;
                http.open('GET', url1, true);
                http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
                http.send();
                http.onreadystatechange = function(){
                    if(this.readyState == 4 && this.status == 200){
                        var data = this.responseText;
                        data = JSON.parse(data);
                        //console.log(data);   
                        if(data.length > 0){
                            data.forEach( function(schedule, index){
                                    //console.log(citas_configuradas);
                                        select.innerHTML += "<option value=\""+schedule.id+"\" selected>"+schedule.hour_in+"</option>";   
                                  
                            });  
                        }
                    }
                }        
            }

            //console.log(request);
            
        });
    }

    

}

function setInfoAddPatient(){
    var exam = document.getElementById('exam_b').value;    
    var affiliation_b = document.getElementById('affiliationp').value;
    var url = base + '/agem/public/admin/agem/api/load/add/patient/'+affiliation_b+'/'+exam;
    //var url = base + '/admin/agem/api/load/add/patient/'+affiliation_b+'/'+exam;
    var patient_id = document.getElementById('patient_id');
    var name = document.getElementById('namep');
    var lastname = document.getElementById('lastnamep');
    var contact = document.getElementById('contactp');
    var code_last = document.getElementById('numexpp');
    var date_al = document.getElementById('date_al');
    var numexp_al = document.getElementById('numexp_al'); 
    var type_exam = document.getElementById('type_examp');

    http.open('GET', url, true);
    http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    http.send(); 
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            var data = this.responseText;
            data = JSON.parse(data);
            type_exam.value = data.exam;
            //console.log(data);
            if('patient' in data){
                patient_id.value = data.patient[0].id;
                name.value = data.patient[0].name;
                lastname.value = data.patient[0].lastname;
                contact.value = data.patient[0].contact;
            }      
            else{
                document.getElementById("patient_msg").style.display = "block";
                document.getElementById("register").style.display = "block";
                document.getElementById("register").classList.add("d-flex");
            }  

            if('code_last' in data){
                code_last.value = data.code_last[0].code;
            }
            
            //console.log(data.patient.length);

            if(data.patient.length > 1){
                document.getElementById("div_beneficiarios").style.display = "block";
                var inputquestion = document.getElementById('beneficiario_question');
                
                $(inputquestion).change(function(){
                    if(inputquestion.value == 1){
                        patient_id.value = "";
                        name.value = "";
                        lastname.value = "";
                        contact.value = "";
                        code_last.value = "";
                        document.getElementById("div_select_beneficiarios").style.display = "block";
                        select_beneficiarios = document.getElementById('beneficiarios');
                        select_beneficiarios.innerHTML = "";
                        select_beneficiarios.innerHTML += "<option value=\""+0+"\">Seleccione una opci??n</option>";
                        for(var i=0; i< data.patient.length; i++){
                            if(data.patient[i].type != 0){
                                select_beneficiarios.innerHTML += "<option value=\""+data.patient[i].id+"-"+data.patient[i].name+"-"+data.patient[i].lastname+"-"+data.patient[i].contact+"\">"+data.patient[i].name+" "+data.patient[i].lastname+"</option>";
                            }
                        }

                        $(select_beneficiarios).change(function(){
                            console.log(select_beneficiarios.value);
                            if(select_beneficiarios != 0){
                                beneficiario_seleccionado = select_beneficiarios.value;
                                informacion_beneficiario = beneficiario_seleccionado.split('-');
                                //console.log(informacion_beneficiario[0]);
                                patient_id.value = informacion_beneficiario[0];
                                name.value = informacion_beneficiario[1];
                                lastname.value = informacion_beneficiario[2];
                                contact.value = informacion_beneficiario[3];
                                if(select_beneficiarios != 0){
                                    var url = base + '/agem/public/admin/agem/api/load/add/patient/beneficiario/'+informacion_beneficiario[0]+'/'+exam;
                                    http.open('GET', url, true);
                                    http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
                                    http.send(); 
                                    http.onreadystatechange = function(){
                                        if(this.readyState == 4 && this.status == 200){
                                            var data = this.responseText;
                                            data = JSON.parse(data);

                                            //console.log(data);
                                            code_last.value = data.code_last[0].code;
                                        }else{
                                            code_last.value = "";
                                        }
                                    }
                                }
                            }else{
                                patient_id.value = "";
                                name.value = "";
                                lastname.value = "";
                                contact.value = "";
                                code_last.value = "";
                            }
                        });
                    }
                    if(inputquestion.value == 0){
                        document.getElementById("div_beneficiarios").style.display = "none";
                        document.getElementById("div_select_beneficiarios").style.display = "none";
                        patient_id.value = "";
                        name.value = "";
                        lastname.value = "";
                        contact.value = "";
                        code_last.value = "";

                        if('patient' in data){
                            patient_id.value = data.patient[0].id;
                            name.value = data.patient[0].name;
                            lastname.value = data.patient[0].lastname;
                            contact.value = data.patient[0].contact;
                        }  
            
                        if('code_last' in data){
                            code_last.value = data.code_last[0].code;
                        }
                    }
                    
                    
                });
                
            }
            

            var studies_actual = document.getElementById('studies_actual').value;
            select = document.getElementById('studies');
            select.innerHTML = "";
            var url = base + '/agem/public/admin/agem/api/load/studies/'+exam;
            //var url = base + 'admin/agem/api/load/studies/'+exam;
            http.open('GET', url, true);
            http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            http.send();
            http.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    var data = this.responseText;
                    data = JSON.parse(data);
                    data.forEach( function(element){
                        if(studies_actual == element.id){
                            select.innerHTML += "<option value=\""+element.id+"\" selected>"+element.name+"</option>";
                        }else{
                            select.innerHTML += "<option value=\""+element.id+"\">"+element.name+"</option>";
                        }
                    });

                    

                }
            }

        }
    }
}

function setGenerateCodeRx(){
    var nomenclatura = 'RX';
    var url = base + '/agem/public/admin/agem/api/load/generate/code/'+nomenclatura;
    //var url = base + '/admin/agem/api/load/generate/code/'+nomenclatura;
    var num_rx = document.getElementById('pnum_rx');
    var nomenclature = document.getElementById('pnum_rx_nom');
    var correlative = document.getElementById('pnum_rx_cor');
    var year = document.getElementById('pnum_rx_y');

    http.open('GET', url, true);
    http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            var data = this.responseText;
            data = JSON.parse(data);
            num_rx.value = data.code;
            nomenclature.value = data.nomenclature;
            correlative.value = data.correlative;
            year.value = data.year;            
        }
    }
}

function setGenerateCodeUsg(){
    var nomenclatura = 'USG';
    var url = base + '/agem/public/admin/agem/api/load/generate/code/'+nomenclatura;
    //var url = base + '/admin/agem/api/load/generate/code/'+nomenclatura;
    var num_usg = document.getElementById('pnum_usg');
    var nomenclature = document.getElementById('pnum_usg_nom');
    var correlative = document.getElementById('pnum_usg_cor');
    var year = document.getElementById('pnum_usg_y');

    http.open('GET', url, true);
    http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            var data = this.responseText;
            data = JSON.parse(data);
            num_usg.value = data.code;
            nomenclature.value = data.nomenclature;
            correlative.value = data.correlative;
            year.value = data.year;
        }
    }
}

function setGenerateCodeMmo(){
    var nomenclatura = 'MMO';
    var url = base + '/agem/public/admin/agem/api/load/generate/code/'+nomenclatura;
    //var url = base + '/admin/agem/api/load/generate/code/'+nomenclatura;
    var num_mmo = document.getElementById('pnum_mmo');
    var nomenclature = document.getElementById('pnum_mmo_nom');
    var correlative = document.getElementById('pnum_mmo_cor');
    var year = document.getElementById('pnum_mmo_y');

    http.open('GET', url, true);
    http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            var data = this.responseText;
            data = JSON.parse(data);
            num_mmo.value = data.code;
            nomenclature.value = data.nomenclature;
            correlative.value = data.correlative;
            year.value = data.year;
        }
    }
}

function setGenerateCodeDmo(){
    var nomenclatura = 'DMO';
    var url = base + '/agem/public/admin/agem/api/load/generate/code/'+nomenclatura;
    //var url = base + '/admin/agem/api/load/generate/code/'+nomenclatura;
    var num_dmo = document.getElementById('pnum_dmo');
    var nomenclature = document.getElementById('pnum_dmo_nom');
    var correlative = document.getElementById('pnum_dmo_cor');
    var year = document.getElementById('pnum_dmo_y');

    http.open('GET', url, true);
    http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            var data = this.responseText;
            data = JSON.parse(data);
            num_dmo.value = data.code;
            nomenclature.value = data.nomenclature;
            correlative.value = data.correlative;
            year.value = data.year;
        }
    }
}

function setGenerateCode(){
    var area_exam = document.getElementById('exam_b');
    var nomenclatura;
    //console.log(area_exam.value);
    
    if(area_exam.value === '0'){
        nomenclatura = "RX";
    }else if(area_exam.value === '1'){
        nomenclatura = "RX";
    }else if(area_exam.value === '2'){
        nomenclatura = "USG";
    }else if(area_exam.value === '3'){
        nomenclatura = "MMO";
    }else if(area_exam.value === '4'){
        nomenclatura = "DMO";
    }        
    //console.log(nomenclatura);
    
    var url = base + '/agem/public/admin/agem/api/load/generate/code/'+nomenclatura;
    //var url = base + '/admin/agem/api/load/generate/code/'+nomenclatura;
    var num_code = document.getElementById('num_code_new');
    var nomenclature = document.getElementById('num_code_nom');
    var correlative = document.getElementById('num_code_cor');
    var year = document.getElementById('num_code_y');

    http.open('GET', url, true);
    http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            var data = this.responseText;
            data = JSON.parse(data);
            num_code.value = data.code;
            nomenclature.value = data.nomenclature;
            correlative.value = data.correlative;
            year.value = data.year;            
        }
    }
}

function setGenerateCodePatientActual(){
    var area_exam = document.getElementById('exam_b');
    var nomenclatura;
    //console.log(area_exam.value);
    
    if(area_exam.value === '0'){
        nomenclatura = "RX";
    }else if(area_exam.value === '1'){
        nomenclatura = "RX";
    }else if(area_exam.value === '2'){
        nomenclatura = "USG";
    }else if(area_exam.value === '3'){
        nomenclatura = "MMO";
    }else if(area_exam.value === '4'){
        nomenclatura = "DMO";
    }        
    //console.log(nomenclatura);
    
    var url = base + '/agem/public/admin/agem/api/load/generate/code/'+nomenclatura;
    //var url = base + '/admin/agem/api/load/generate/code/'+nomenclatura;
    var num_code = document.getElementById('numexpp');
    var nomenclature = document.getElementById('num_code_nom_act');
    var correlative = document.getElementById('num_code_cor_act');
    var year = document.getElementById('num_code_y_act');

    http.open('GET', url, true);
    http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            var data = this.responseText;
            data = JSON.parse(data);
            num_code.value = data.code;
            nomenclature.value = data.nomenclature;
            correlative.value = data.correlative;
            year.value = data.year;            
        }
    }
}

function getDisponibilidadHorario(){
    var citas_configuradas = document.getElementById('citas_configuradas').value;
    var inputdate = document.getElementById('date_new_app');
    var options=$('#schedules option').clone();
    var control_am = document.getElementById('control_am');
    var control_pm = document.getElementById('control_pm');
    

    $(inputdate).change(function(){
        
        control_am.value = "";
        control_pm.value = "";
        

        var fecha = document.getElementById("date_new_app").value;
        //console.log(fecha);
        var dia = fecha[8]+fecha[9];
        var mes = fecha[6];
        var year = fecha[0]+fecha[1]+fecha[2]+fecha[3];
        var exam = document.getElementById('exam_b').value;
        
        
        var url = base + '/agem/public/admin/agem/api/load/schedules/'+fecha+'/'+exam;
        //var url = base + '/admin/agem/api/load/schedules/'+fecha+'/'+exam;
        http.open('GET', url, true);
        http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
        http.send();
        http.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                //console.log(data); 
                var data = this.responseText;
                data = JSON.parse(data);
                  
                if(data.length > 0){
                    data.forEach( function(schedule, index){
                        
                        if(schedule.total >= citas_configuradas){
                            for(i=1; i <= 18; i++){
                                //console.log(citas_configuradas);
                                if(schedule.schedule_id == i){
                                    $('#schedules option[value="'+schedule.schedule_id+'"]').remove();    
                                }
                            }                                                          
                        }    
                    });  
                }else{
                    $('#schedules').html(options);
                }

                
                
            }
        }

        
        var url1 = base + '/agem/public/admin/agem/api/load/control/studies/'+fecha;
        //var url1 = base + '/admin/agem/api/load/control/studies/'+fecha;
        http.open('GET', url1, true);
        http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
        http.send();
        http.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                var data = this.responseText;
                data = JSON.parse(data);
                  
                //console.log(data); 
                if(data.length != 0){
                     
                    data.forEach( function(element){
                        //console.log(element);
                        switch(exam){
                            case '1':
                                if(element.amount_rx_special_am == null){
                                    control_am.value = 0;
                                }else{
                                    control_am.value = element.amount_rx_special_am;
                                }

                                if(element.amount_rx_special_pm == null){
                                    control_pm.value = 0;
                                }else{
                                    control_pm.value = element.amount_rx_special_pm;
                                }
                            break;

                            case '2':
                                if(element.amount_usg_am == null){
                                    control_am.value = 0;
                                }else{
                                    control_am.value = element.amount_usg_am;
                                }

                                if(element.amount_usg_pm == null){
                                    control_pm.value = 0;
                                }else{
                                    control_pm.value = element.amount_usg_pm;
                                }
                                
                            break;

                            case '3':
                                if(element.amount_mmo_am == null){
                                    control_am.value = 0;
                                }else{
                                    control_am.value = element.amount_mmo_am;
                                }

                                if(element.amount_mmo_pm == null){
                                    control_pm.value = 0;
                                }else{
                                    control_pm.value = element.amount_mmo_pm;
                                }
                            break;

                            case '4':
                                if(element.amount_dmo_am == null){
                                    control_am.value = 0;
                                }else{
                                    control_am.value = element.amount_dmo_am;
                                }

                                if(element.amount_dmo_pm == null){
                                    control_pm.value = 0;
                                }else{
                                    control_pm.value = element.amount_dmo_pm;
                                }
                            break;

                        }
                        
                    });                  
                    
                    
                }
                
            }
        }

        

        
    });
}

 

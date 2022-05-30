<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Appointment, App\Http\Models\ControlAppointment, App\Http\Models\DetailAppointment, App\Http\Models\MaterialAppointment, App\Http\Models\Patient, App\Http\Models\CodePatient, App\Http\Models\Service, App\Http\Models\Studie, App\Http\Models\Schedule, App\Http\Models\Bitacora;
use Validator, Str, Config, Auth, Session, DB, PDF, Response, Carbon\Carbon;

class AppointmentController extends Controller
{
    public function __Construct(){
        $this->middleware('auth');
        $this->middleware('IsAdmin');
        $this->middleware('UserStatus');
        $this->middleware('Permissions');
    }

    public function getHome(){        

        $appointments = Appointment::all();            

        $data = [
            'appointments' => $appointments
        ];

        return view('admin.appointments.home',$data);
    }

    public function getAppointmentAdd(){
        $services = Service::where('type','1')
            ->where('unit_id', '1')
            ->get();
        $studies = Studie::pluck('name','id');
        $detalles = DetailAppointment::all();
        $schedules = Schedule::all();

        $data = [
            'services' => $services,
            'studies' => $studies,
            'detalles' => $detalles,
            'schedules' => $schedules
        ];

        return view('admin.appointments.add', $data);
    } 

    public function postAppointmentAdd(Request $request){
        $rules = [
            'date' => 'required'
    	];
    	$messagess = [
            'date.required' => 'Se requiere que asigne una fecha para la cita.'
    	];

        $validator = Validator::make($request->all(), $rules, $messagess);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('messages', 'Se ha producido un error.')->with('typealert', 'danger');
        else: 
            $area_temp = NULL;
            $idpatient = $request->input('patient_id');            
            $type_exam = $request->input('type_exam');
           
            $affiliation_p = Patient::select('affiliation', 'exp_prev')
                                ->where('id', $idpatient)
                                ->limit(1)
                                ->get();

            switch($type_exam):

                case '0':
                    $code_exp = CodePatient::select('code')
                        ->where('patient_id', $idpatient)
                        ->where('nomenclature', 'RX')
                        ->where('status', '0')
                        ->get();
                    $area = '0';
                    $appointments_odls = Appointment::where('patient_id', $idpatient)
                                ->where('area',$area)
                                ->count();
                break;

                case '1':
                    $code_exp = CodePatient::select('code')
                        ->where('patient_id', $idpatient)
                        ->where('nomenclature', 'RX')
                        ->where('status', '0')
                        ->get();
                    $area = '0';
                    $area_temp = '1';
                    $appointments_odls = Appointment::where('patient_id', $idpatient)
                                ->where('area',$area)
                                ->count();
                break;

                case '2':
                    $code_exp = CodePatient::select('code')
                        ->where('patient_id', $idpatient)
                        ->where('nomenclature', 'USG')
                        ->where('status', '0')
                        ->get();
                    $area = '2';
                    $appointments_odls = Appointment::where('patient_id', $idpatient)
                                ->where('area',$area)
                                ->count();
                break;

                case '3':
                    $code_exp = CodePatient::select('code')
                        ->where('patient_id', $idpatient)
                        ->where('nomenclature', 'MMO')
                        ->where('status', '0')
                        ->get();
                    $area = '3';
                    $appointments_odls = Appointment::where('patient_id', $idpatient)
                                ->where('area',$area)
                                ->count();
                break;

                case '4':
                    $code_exp = CodePatient::select('code')
                        ->where('patient_id', $idpatient)
                        ->where('nomenclature', 'DMO')
                        ->where('status', '0')
                        ->get();
                    $area = '4';
                    $appointments_odls = Appointment::where('patient_id', $idpatient)
                                ->where('area',$area)
                                ->count();
                break;

            endswitch;

            if(count($code_exp) == 0):
                $code_assig = "";
            else:
                foreach($code_exp as $ce):
                    $code_assig = $ce->code;
                endforeach;
            endif;


            foreach($affiliation_p as $ap):
                $ep = $ap->exp_prev;

                if($ep == '1'):
                    $appointments_type = '1';
                else:
                    if($appointments_odls == '0'):
                        $appointments_type = '0';
                    else:
                        $appointments_type = '1';
                    endif;
                endif;
            endforeach;

            DB::beginTransaction();

            $servicio = Service::with(['parent'])->where('id', $request->get('idservice')[0])->get();

            foreach($servicio as $ser):
                $solicitante = $ser->parent->name;
            endforeach;

            $appointment = new Appointment;
            $appointment->patient_id = $idpatient;
            $appointment->date = $request->input('date');
            if($request->input('schedule') != ""):
                $appointment->schedule_id = $request->input('schedule');
            else:
                $appointment->schedule_id = $request->input('schedule1'); 
            endif;

            $ca = ControlAppointment::where('date', $appointment->date)->count();

            if($ca == 0):
                $control = new ControlAppointment;
                $control->date = $request->input('date');
                if($area == 0 ):
                    $control->amount_rx = '1';
                    if($area_temp != NULL):
                        if($request->input('schedule') >= 1 && $request->input('schedule') <= 10):
                            $control->amount_rx_special_am = '1';
                        else:
                            $control->amount_rx_special_pm = '1';
                        endif;
                    endif;                    
                elseif($area == 2):
                    $doppler = Studie::findOrFail($request->get('idstudy'));                    
                    foreach($doppler as $d):
                        if($d->is_doppler == '1'):
                            $control->amount_usg_doppler = '1';
                            if($request->input('schedule') >= 1 && $request->input('schedule') <= 10):
                                $c->amount_usg_doppler_am = '1';
                            else:
                                $c->amount_usg_doppler_pm = '1';
                            endif;
                        else:
                            $control->amount_usg = '1';
                        endif;                    
                    endforeach;                              
                elseif($area == 3):
                    if($request->input('schedule') >= 1 && $request->input('schedule') <= 10):
                        $control->amount_mmo_am = '1';
                    else:
                        $control->amount_mmo_pm = '1';
                    endif;
                elseif($area == 4):
                    if($request->input('schedule') >= 1 && $request->input('schedule') <= 10):
                        $control->amount_dmo_am = '1';
                    else:
                        $control->amount_dmo_pm = '1';
                    endif;
                endif;
                $control->save();
            else:
                $ca1 = ControlAppointment::where('date' , $request->input('date'))->get();
                foreach($ca1 as $c):
                    if($area == 0 ):
                        $c->amount_rx = $c->amount_rx + 1;   
                        if($area_temp != NULL):
                            if($request->input('schedule') >= 1 && $request->input('schedule') <= 10):
                                if($c->amount_rx_special_am == Config::get('agem.appo_rx_special_am')):
                                    return back()->with('messages', '¡No se pueden agendar mas citas, espacios llenos!.') 
                                        ->with('typealert', 'warning');                                
                                else:
                                    $c->amount_rx_special_am = $c->amount_rx_special_am + 1;
                                endif;
                            else:
                                if($c->amount_rx_special_pm == Config::get('agem.appo_rx_special_pm')):
                                    return back()->with('messages', '¡No se pueden agendar mas citas, espacios llenos!.')
                                        ->with('typealert', 'warning');                                
                                else:
                                    $c->amount_rx_special_pm = $c->amount_rx_special_pm + 1;
                                endif;
                            endif;
                        endif;     

                    elseif($area == 2):
                        if($c->amount_usg == 10 || $c->amount_usg_doppler == 4 ):
                            return back()->with('messages', '¡No se pueden agendar mas citas, espacios llenos!.')
                                    ->with('typealert', 'warning');
                        else:
                            $doppler = Studie::findOrFail($request->get('idstudy'));                    
                            foreach($doppler as $d):
                                if($d->is_doppler == '1'):
                                    $c->amount_usg_doppler = $c->amount_usg_doppler + 1;
                                    if($request->input('schedule') >= 1 && $request->input('schedule') <= 10):
                                        $c->amount_usg_doppler_am = $c->amount_usg_doppler_am + 1;
                                    else:
                                        $c->amount_usg_doppler_pm = $c->amount_usg_doppler_pm + 1;
                                    endif;
                                else:
                                    if($request->input('schedule') >= 1 && $request->input('schedule') <= 10):
                                        $c->amount_usg_am = $c->amount_usg_am + 1;
                                    else:
                                        $c->amount_usg_pm = $c->amount_usg_pm + 1;
                                    endif;
                                endif;                    
                            endforeach;                            
                        endif;                        
                    elseif($area == 3):
                        if($request->input('schedule') >= 1 && $request->input('schedule') <= 10):
                            if($c->amount_mmo_am == Config::get('agem.appo_mmo_am')):
                                return back()->with('messages', '¡No se pueden agendar mas citas, espacios llenos!.')
                                    ->with('typealert', 'warning');                                
                            else:
                                $c->amount_mmo_am = $c->amount_mmo_am + 1;
                            endif;
                        else:
                            if($c->amount_mmo_pm == Config::get('agem.appo_mmo_pm')):
                                return back()->with('messages', '¡No se pueden agendar mas citas, espacios llenos!.')
                                    ->with('typealert', 'warning');                                
                            else:
                                $c->amount_mmo_pm = $c->amount_mmo_pm + 1;
                            endif;
                        endif;                        
                    elseif($area == 4):
                        if($request->input('schedule') >= 1 && $request->input('schedule') <= 10):
                            if($c->amount_dmo_am == Config::get('agem.appo_dmo_am')):
                                return back()->with('messages', '¡No se pueden agendar mas citas, espacios llenos!.')
                                    ->with('typealert', 'warning');                                
                            else:
                                $c->amount_dmo_am = $c->amount_dmo_am + 1;
                            endif;
                        else:
                            if($c->amount_dmo_pm == Config::get('agem.appo_dmo_pm')):
                                return back()->with('messages', '¡No se pueden agendar mas citas, espacios llenos!.')
                                    ->with('typealert', 'warning');                                
                            else:
                                $c->amount_dmo_pm = $c->amount_dmo_pm + 1;
                            endif;
                        endif;                        
                    endif;
                    $c->save();
                endforeach;
                
            endif;          

            if($code_assig != NULL):
                $appointment->num_study = $code_assig;
            endif;
            $appointment->type = $appointments_type;
            $appointment->area = $area;
            $appointment->service = $solicitante;
            $appointment->status = '0';    
            $appointment->save();      

            $idservice = $request->get('idservice');          
            $idstudy = $request->get('idstudy');
            $comment = $request->get('comment');

            $cont=0;

            while ($cont<count($idservice)) {
                $detalle = new DetailAppointment();
                $detalle->idappointment=$appointment->id;
                $detalle->idservice=$idservice[$cont];
                $detalle->idstudy=$idstudy[$cont];
                $detalle->comment=$comment[$cont];
                $detalle->save();
                $cont=$cont+1;
            }

            DB::commit();

            if($appointment->save()):  
                

                

                foreach($affiliation_p as $ap):
                    $afp = $ap->affiliation;
                endforeach;

                $b = new Bitacora;
                $b->action = "Registro de cita para paciente con afiliación: ".$afp;
                $b->user_id = Auth::id();
                $b->save();

                return redirect('/admin/citas')->with('messages', '¡Cita agendada y guardada con exito!.')
                    ->with('typealert', 'success');
    		endif;
        endif;
    }

    public function getCalendar(){
        

        $data = [
            
        ];

        return view('admin.appointments.calendar', $data);
    }

    public function getCalendarRx(){
        

        $data = [
            
        ];

        return view('admin.appointments.calendar_rx', $data);
    }

    public function getCalendarUmd(){
        

        $data = [
            
        ];

        return view('admin.appointments.calendar_umd', $data);
    }

    public function getAppointmentMaterials($id){        
        $materials = MaterialAppointment::where('idappointment', $id)->get();
        $detalles = DetailAppointment::where('idappointment', $id)->get();



        $data = [
            'materials' => $materials,
            'detalles' => $detalles
        ];

        return view('admin.appointments.materials', $data);
    }

    public function getAppointmentMaterialsDiscarded($id){
        $material = MaterialAppointment::findOrFail($id);
        $material->status = '1';

        if($material->save()):
            $b = new Bitacora;
            $b->action = "Material marcado como desechado ";
            $b->user_id = Auth::id();
            $b->save();

            return back()->with('messages', '¡Material desechado con exito!.')
                ->with('typealert', 'success');
        endif;
    }

    public function getAppointmentRegisterMaterials($id, $idstudy, $idmaterial, $amount){
        $material = new MaterialAppointment;
        $material->idappointment = $id;
        $material->idstudy = $idstudy;
        $material->material = $idmaterial;
        $material->amount = $amount;

        if($material->save()):
            $b = new Bitacora;
            $b->action = "Registro de material a cita no.".$id;
            $b->user_id = Auth::id();
            $b->save();

            return back()->with('messages', '¡Material registrado y guardado con exito!.')
                ->with('typealert', 'success');
        endif;
    }

    public function getAppointmentReschedule($id, $date, $comment = NULL){
        $appointment = Appointment::findOrFail($id);
        $horario = $appointment->schedule_id;
        $appointment->date_old = $appointment->date;
        $appointment->date = $date;
        $appointment->status = '4';

        $cant_citas = Appointment::select(DB::raw('schedule_id, count(*) as total'))
                    ->where('date', $date)
                    ->where('schedule_id', $appointment->schedule_id)
                    ->groupBy('schedule_id')
                    ->get();
        
        foreach($cant_citas as $cc):
            if($cc->schedule_id === $appointment->schedule_id && $cc->total == 2):
                $disponibles = Appointment::select(DB::raw('schedule_id, count(*) as total'))
                    ->where('date', $date)
                    ->where('schedule_id', '!=' ,$appointment->schedule_id)
                    ->groupBy('schedule_id')
                    ->get();
                
                if(count($disponibles) > 0):
                    foreach($disponibles as $d):
                        if($d->total == 1):
                            $appointment->schedule_id = $d->schedule_id;
                        endif;
                    endforeach;
                endif;                                          
            else:
                $appointment->schedule_id = $horario;          
            endif;
        endforeach;
                

        if($appointment->save()):               

            $b = new Bitacora;
            $b->action = "Reprogamación de cita para paciente con afiliación: ".$appointment->patient->affiliation;
            $b->user_id = Auth::id();
            $b->save();

            return redirect('/admin/citas')->with('messages', '¡Cita reprogramada y guardada con exito!.')
                ->with('typealert', 'success');
        endif;

        
    }

    public function getAppointmentPatientsStatus($id, $status){        
        $appointment = Appointment::findOrFail($id);
        $patient = Patient::where('id', $appointment->patient_id)
                        ->limit(1)
                        ->get();
        
        switch($appointment->area):
            case '0':
                $nomen = 'RX';
            break;

            case '1':
                $nomen = 'RX';
            break;

            case '2':
                $nomen = 'USG';
            break;

            case '3':
                $nomen = 'MMO';
            break;

            case '4':
                $nomen = 'DMO';
            break;
        endswitch;
        
        $code_study = CodePatient::where('patient_id', $appointment->patient_id)
                        ->where('nomenclature', $nomen)
                        ->where('status', '0')
                        ->limit(1)
                        ->get();  
                        
        $num_exp = 0;
        foreach($code_study as $cs):            
            $num_exp = $cs->code;                        
        endforeach;

        if($status == "1"):
            if($num_exp === 0):
                return redirect('/admin/citas')->with('messages', '¡Asigne un numero de expediente primero!.')
                    ->with('typealert', 'warning'); 
            else:
                
                $appointment->num_study = $num_exp;                    

                $appointment->status = $status;
                $hora = Carbon::now()->format('H:i');
                $appointment->check_in = $hora;
            endif; 
        else:
            $appointment->status = $status;
        endif; 
            
        if($appointment->save()):               

            $b = new Bitacora;
            if($status == "1"):
                $b->action = "Cita no. ".$appointment->id.", paciente con afiliación ".$appointment->patient->affiliation." presente";
            else:
                $b->action = "Cita no. ".$appointment->id.", paciente con afiliación ".$appointment->patient->affiliation." ausente";
            endif;            
            $b->user_id = Auth::id();
            $b->save();

            return redirect('/admin/citas')->with('messages', '¡Estado de cita actualizado con exito!.')
                ->with('typealert', 'success');            
        endif;
    }

    public function getAppointmentInforme($id){
        $appointment = Appointment::findOrFail($id);

        $data = [
            'appointment' => $appointment
        ];

        $pdf = PDF::loadView('admin.appointments.informe',$data)->setPaper('a4', 'portrait');
        return $pdf->stream('Informe al Patrono '.$appointment->date.'.pdf');
    }

    public function getSetting(){
        

        $data = [
            
        ];

        return view('admin.appointments.setting', $data);
    }

    public function postSetting(Request $request){
        $year =  Carbon::now()->format('Y');
        $password = "Igss.".$year;
        
        if(!file_exists(config_path().'/agem.php')):
            fopen(config_path().'/agem.php','w');
        endif;

        $file = fopen(config_path().'/agem.php','w');
        fwrite($file, '<?php'.PHP_EOL);
        fwrite($file, 'return ['.PHP_EOL);
        fwrite($file, '\'name\' => \'AGEM\','.PHP_EOL);
        fwrite($file, '\'default_password\' => \''.$password.'\','.PHP_EOL);
        foreach($request->except(['_token']) as $key => $value):
            if(is_null($value)):
                $value = "null";
            endif;
            fwrite($file, '\''.$key.'\' => \''.$value.'\','.PHP_EOL);
        endforeach;   
        fwrite($file, ']'.PHP_EOL);
        fwrite($file, '?>'.PHP_EOL);
        fclose($file);

        return back()->with('messages', '¡Configuración de citas realizada con éxito!.')
                                    ->with('typealert', 'success');
    }
}

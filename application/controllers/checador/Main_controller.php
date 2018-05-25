<?php

class Main_controller extends CI_Controller {

    public function view($page = 'home')
    {

        if( ! file_exists(APPPATH.'views/content/'.$page.'.php'))
        {
            $page = 'home';
        }

        if( ! $this->session->has_userdata('auth')){
            $page = 'home';
        }
        else{
            if($this->session->userdata('auth') == false){
                $this->session->sess_destroy();
                redirect('home');
            }
        }

        switch ($page) {
            case 'home':
            $data['date'] = get_date_string(get_date());
            $this->load->view('layout/head');
            $this->load->view('content/'.$page, $data);
            $this->load->view('layout/scripts', array(
                'view_controller' => 'home_vs.js'
            ));
            break;
            
            default:
            $panel_data['name'] = $this->session->userdata('name');
            $this->load->view('layout/head');
            $this->load->view('layout/header', $panel_data);
            $this->load->view('content/'.$page);
            $this->load->view('layout/scripts', array(
                'view_controller' => 'panel_vs.js'
            ));
            break;
        }
    }

    public function new_user(){
        $data = array(
            'nombre' => $_POST['name'],
            'clave' => $_POST['password1'],
            'tipo' => $_POST['type'],
            'status' => 1,
            'date' => get_date(),
            'time' => get_time()
        );

        if($this->db->insert('usuarios', $data)){
            echo true;
        }
        else{
            echo false;
        }
    }

    public function delete_user(){
        $id = $_POST["id_eliminar"];

        $this->db->set('status', 0);
        $this->db->where('id', $id);

        if($this->db->update('usuarios')){
            echo true;
        }
        else{
            echo false;
        }
    }

    public function delete_register(){
        $id = $_POST["id_eliminar"];

        $this->db->set('status', 0);
        $this->db->where('id', $id);

        if($this->db->update('historial')){
            echo true;
        }
        else{
            echo false;
        }
    }

    public function edit_user(){
        $id = $this->uri->segment(2);
        $row = '';
        $data = '';

        if( ! $this->session->has_userdata('auth')){
            $page = 'home';
            $data['date'] = get_date_string(get_date());
            $this->load->view('layout/head');
            $this->load->view('content/'.$page, $data);
            $this->load->view('layout/scripts', array(
                'view_controller' => 'home_vs.js'
            ));
        }
        else{
            $page = 'editar_usuario';
            $panel_data['name'] = $this->session->userdata('name');

            $this->db->select('id, nombre, clave, tipo');
            $this->db->from('usuarios');
            $this->db->where('id', $id);
            $this->db->where('status', 1);
            $query = $this->db->get();
            $row = $query->row();

            if (isset($row)){
                $this->load->view('layout/head');
                $this->load->view('layout/header', $panel_data);
                $this->load->view('content/'.$page, $row);
                $this->load->view('layout/scripts', array(
                    'view_controller' => 'panel_vs.js'
                ));
            }
            else{

                $page = 'users';
                $this->load->view('layout/head');
                $this->load->view('layout/header', $panel_data);
                $this->load->view('content/'.$page);
                $this->load->view('layout/scripts', array(
                    'view_controller' => 'panel_vs.js'
                ));
            } 
        }
    }

    public function edit_user_control(){

        $id = $_POST["id_user"];

        $this->db->set('nombre', $_POST["name"]);
        $this->db->set('clave', $_POST["password1"]);
        $this->db->set('tipo', $_POST["type"]);
        $this->db->where('id', $id);

        if($this->db->update('usuarios')){
            if($id == $this->session->userdata('id')){
                if($_POST["type"] == 1){
                    $auth = true;
                }
                else{
                    $auth = false;
                }

                $data = array(
                    'id' => $id,
                    'name' => $_POST["name"],
                    'auth' => $auth
                ); 

                $this->session->set_userdata($data);
            }
            echo true;
        }
        else{
            echo false;
        }
    }

    public function change_password(){
        $id = $_POST["id"];
        $password = $_POST["password"];

        $this->db->set('clave', $password);
        $this->db->where('id', $id);

        if($this->db->update('usuarios')){
            echo true;
        }
        else{
            echo false;
        }
    }

    public function get_username(){
        $password = $_POST["clave"];
        $this->db->select('id, nombre, tipo');
        $this->db->from('usuarios');
        $this->db->where('clave', $password);
        $this->db->where('status', 1);
        $query = $this->db->get();
        $row = $query->row();

        if (isset($row)){
            echo $row->nombre;
        }
        else{
            echo false;
        } 
    }

    public function load_report_users(){
        $query = $this->db->get('usuarios');

        $html = '<option value="0">Todos los usuarios</option>';

        foreach ($query->result_array() as $row)
        {
            if($row['status'] != 0){
                $html.='<option value="'.$row['id'].'">'.$row['nombre'].'</option>';
            }
        }

        echo $html;
    }

    public function get_month(){
        $this->db->select('MONTH(entry_date) as mes');
        $this->db->group_by('MONTH(entry_date)'); 
        $this->db->from('historial');
        $query = $this->db->get();
        $res = $query->result_array();
        $aux = [];
        $html = '';

        foreach ($res as $mes) {
            array_push($aux, $mes["mes"]);
        }

        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        for ($i=1; $i <= 12 ; $i++) { 
            $html .= '<option value="'.$i.'"';
            if(!in_array($i, $aux)){
                $html.=' disabled';
            }
            if($i == date('n')){
                $html.=' selected';
            }
            $html.= '>'.$meses[$i-1].'</option>';
        }

        echo $html;
    }

    public function check_hash(){
        $password = $_POST["password"];
        $this->db->select('id, tipo');
        $this->db->from('usuarios');
        $this->db->where('clave', $password);
        $this->db->where('status', 1);
        $query = $this->db->get();
        $row = $query->row();

        if (isset($row)){
            echo json_encode(true);
        }
        else{
            echo json_encode(false);
        }
    }

    public function check_admin_hash(){
        $password = $_POST["admin_password"];
        $this->db->select('id, tipo');
        $this->db->from('usuarios');
        $this->db->where('clave', $password);
        $this->db->where('tipo', 1);
        $this->db->where('status', 1);
        $query = $this->db->get();
        $row = $query->row();

        if (isset($row)){
            echo json_encode(true);
        }
        else{
            echo json_encode(false);
        }
    }

    public function login_auth(){
        $password = $_POST['admin_password'];

        $this->db->select('id, nombre');
        $this->db->from('usuarios');
        $this->db->where('clave', $password);
        $this->db->where('tipo', 1);
        $this->db->where('status', 1);
        $query = $this->db->get();
        $row = $query->row();

        if (isset($row))
        {
            $data = array(
                'id' => $row->id,
                'name' => $row->nombre,
                'auth' => true
            );

            $this->session->set_userdata($data);

            echo true;
        }
        else{
            echo false;
        }
    }

    public function logout(){
        $this->session->sess_destroy();
        redirect('home');
    }


    public function register_hash(){
        $password = $_POST["clave"];

        $response = array(
            'type' => 0,
            'message' => 'Error.' 
        );

        $this->db->select('id, nombre, tipo');
        $this->db->from('usuarios');
        $this->db->where('clave', $password);   
        $this->db->where('status', 1);
        $query = $this->db->get();
        $row = $query->row();

        if (isset($row)){
            $fecha_actual = get_date();
            $tiempo = get_time();

            $this->db->select('id, id_user, tipo');
            $this->db->from('historial');
            $this->db->where('id_user', $row->id);
            $this->db->where('entry_date', $fecha_actual);
            $this->db->where('status', 1);
            $query2 = $this->db->get();
            $row2 = $query2->row();

            if (isset($row2)){
                $this->db->select('id, id_user, tipo');
                $this->db->from('historial');
                $this->db->where('id_user', $row->id);
                $this->db->where('exit_date', $fecha_actual);
                $this->db->where('tipo', 2);
                $this->db->where('status', 1);
                $query3 = $this->db->get();
                $row3 = $query3->row();

                if (isset($row3)){
                    $response = array(
                        'type' => 3,
                        'message' => 'La salida ya había sido registrada.' 
                    );
                }
                else{
                    $response = array(
                        'type' => 2,
                        'message' => 'Se necesita registrar la actividad.' 
                    );
                }
            }
            else{
                $data = array(
                    'id_user' => $row->id,
                    'tipo' => 1,
                    'entry_date' => $fecha_actual,
                    'entry_time' => $tiempo,
                    'status' => 1
                );

                if($this->db->insert('historial', $data)){
                    $response = array(
                        'type' => 1,
                        'message' => 'Entrada registrada correctamente.' 
                    );
                }
                else{
                    $response = array(
                        'type' => 0,
                        'message' => 'Ha ocurrido un error en el servidor, por favor intente nuevamente.' 
                    );
                }
            }
        }
        else{
            $response = array(
                'type' => 0,
                'message' => 'Ha ocurrido un error en el servidor, por favor intente nuevamente.' 
            );
        }

        echo json_encode($response);
    }

    public function checkout(){
        $password = $_POST["clave_trabajador"];
        $activity = $_POST["actividad"];

        $this->db->select('id, nombre, tipo');
        $this->db->from('usuarios');
        $this->db->where('clave', $password);   
        $this->db->where('status', 1);
        $query = $this->db->get();
        $row = $query->row();

        if(isset($row)){
            $this->db->select('id, status');
            $this->db->from('historial');
            $this->db->where('id_user', $row->id);  
            $this->db->where('tipo', 1);
            $query2 = $this->db->get();
            $row2 = $query2->row();
            if(isset($row2)){
                $fecha_actual = get_date();
                $tiempo = get_time();

                $this->db->set('tipo', 2);
                $this->db->set('exit_date', $fecha_actual);
                $this->db->set('exit_time', $tiempo);
                $this->db->set('updated_at', $fecha_actual.' '.$tiempo);
                $this->db->where('id', $row2->id);

                if($this->db->update('historial')){
                    $data = array(
                        'id_user' => $row->id,
                        'id_historial' => $row2->id,
                        'actividad' => $activity,
                        'date' => $fecha_actual,
                        'time' => $tiempo
                    );

                    if($this->db->insert('actividades', $data)){
                        $response = 'Salida registrada correctamente.';
                    }
                    else{
                        $response = false;
                    }
                }
                else{
                    $response = false;
                }
            }
            else{
                $response = false;
            }
        }
        else{
            $response = false;
        }

        echo $response;
    }

    public function register_data(){

        $html ='
        <div class="card col s12">
            <table class="responsive-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Prueba</td>
                        <td>Prueba</td>
                        <td>Prueba</td>
                    </tr>
                </tbody>
            </table>
        </div>';

        echo $html;
    }

    public function last_register_data(){
        $this->db->select('MAX(updated_at) as last_update');
        $this->db->from('historial');
        $query = $this->db->get();
        $row = $query->row();

        $this->db->select('id');
        $this->db->from('historial');
        $this->db->where('updated_at', $row->last_update);
        $query = $this->db->get();
        $row = $query->row();

        if (isset($row)){
            $this->db->select('id_user, tipo, entry_date, entry_time, exit_date, exit_time');
            $this->db->from('historial');
            $this->db->where('id', $row->id);
            $query2 = $this->db->get();
            $row2 = $query2->row();

            if (isset($row2)){
                $this->db->select('nombre');
                $this->db->from('usuarios');
                $this->db->where('id', $row2->id_user);
                $query3 = $this->db->get();
                $row3 = $query3->row();

                if (isset($row3)){

                    $tipo = '';
                    switch($row2->tipo){
                        case 1:
                        $tipo = '<span class="c-white-normal pd5 br-2 green">Entrada</span>';
                        $date = get_date_string($row2->entry_date);
                        $time = $row2->entry_time;
                        break;
                        case 2:
                        $tipo = '<span class="c-white-normal pd5 br-2 red">Salida</span>';
                        $date = get_date_string($row2->exit_date);
                        $time = $row2->exit_time;
                        break;
                    }

                    $html = '<p class="last-insert-title">Último registro realizado:</p><p class="last-insert-type">'.$tipo.'</p><p class="last-insert-description">'.$date.' - '.$time.'</p><p class="last-insert-description"><strong>'.$row3->nombre.'</strong></p>';

                    echo $html;
                }
                else{
                    echo false;
                } 
            }
            else{
                echo false;
            } 
        }
        else{
            echo false;
        }
    }

    public function home_table_data(){
        $month = $_POST['month'];
        $table = "historial";

        if(!empty($month)){
            if($month != 0){
                $this->db->where('MONTH(entry_date)', $month);
            }
        }
        
        $query = $this->db->get($table);

        $html = '';

        foreach ($query->result_array() as $row)
        {
            $bandera = 0;
            if($row['status'] != 0){
                $this->db->select('nombre');
                $this->db->from('usuarios');
                $this->db->where('id', $row['id_user']);
                $query2 = $this->db->get();
                $row2 = $query2->row();
                $name_user = $row2->nombre;

                $html.='
                <tr>
                <td>'.$name_user.'</td>
                <td>'.$row['entry_date'].'</td>
                <td>'.$row['entry_time'].'</td>
                <td>';
                if(!empty($row['exit_date'])){
                    $html.= $row['exit_date'];
                    $bandera = 1;
                }
                else{
                    $html.= "Sin registrar";
                }
                $html.='</td>
                <td>';
                if(!empty($row['exit_time'])){
                    $html.= $row['exit_time'];
                }
                else{
                    $html.= "Sin registrar";
                }
                $html.='</td>
                <td class="center-align">';

                if($bandera == 1){
                    $html.= '<a href="javascript:;" class="btn-floating btn-small waves-effect waves-light teal tooltipped ml5" data-position="right" data-delay="50" data-tooltip="Detalle de actividad" onclick="detalles('.$row['id'].')"><i class="material-icons">receipt</i></a>';
                }

                $html.='
                <a href="'.base_url('/editar_registro/').$row['id'].'" class="btn-floating btn-small waves-effect waves-light amber accent-3 tooltipped ml5" data-position="right" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>
                <a href="javascript:;" class="btn-floating btn-small waves-effect waves-light red darken-1 tooltipped ml5" data-position="right" data-delay="50" data-tooltip="Eliminar" onclick="eliminar('.$row['id'].')"><i class="material-icons">delete</i></a>
                </td>
                ';
            }
        }

        echo $html;
    }

    public function users_table_data(){
        $table = "usuarios";
        $query = $this->db->get($table);
        $html = '';

        foreach ($query->result_array() as $row)
        {
            $html.='
            <tr>
            <td>'.$row['nombre'].'</td>';

            switch($row['tipo']){
                case 1: $html.= '<td>Administrador</td>'; break;
                default: $html.= '<td>Empleado</td>'; break;
            }

            switch($row['status']){
                case 0: $html.= '<td>Inactivo</td>'; break;
                default: $html.= '<td>Activo</td>'; break;
            }
            
            $html.='
            <td class="center-align">
            <a href="javascript:;" class="btn-floating btn-small waves-effect waves-light grey darken-1 tooltipped" data-position="right" data-delay="50" data-tooltip="Cambiar Contraseña" onclick="change_password('.$row['id'].', \''.$row['nombre'].'\')"><i class="material-icons">vpn_key</i></a>
            <a href="'.base_url('/editar_usuario/').$row['id'].'" class="btn-floating btn-small waves-effect waves-light amber accent-3 tooltipped ml5" data-position="right" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';

            if($row['id'] != $this->session->userdata('id')){
                $html.='<a href="javascript:;" class="btn-floating btn-small waves-effect waves-light red darken-1 tooltipped ml5" data-position="right" data-delay="50" data-tooltip="Eliminar" onclick="eliminar('.$row['id'].', \''.$row['nombre'].'\')"><i class="material-icons">delete</i></a>';
            }

            $html.='
            </td>
            ';
        }

        echo $html;
    }

    public function get_graph_registros_dia(){
        $registros = [];
        $labels = [];
        $month = $_POST['month'];
        $date = date("Y").'-'.$month.'-01';
        $result = [];
        $contador = 0;

        for ($i=1; $i <= date('t', strtotime($date)); $i++) {
            array_push($labels, $i);

            $this->db->select('entry_date, count(entry_date) as total');
            $this->db->where('MONTH(entry_date)', $month);
            $this->db->where('DAYOFMONTH(entry_date)', $i);
            $this->db->from('historial');
            $this->db->group_by('entry_date');
            $query = $this->db->get();
            $row = $query->row();

            if (isset($row)){
                array_push($registros, $row->total);
            }
            else{
                array_push($registros, 0);
            }

        }

        array_push($result, $labels);
        array_push($result, $registros);

        echo json_encode($result);
    }

    public function get_graph_horas_dia(){
        $horas = [];
        $labels = [];
        $month = $_POST['month'];
        $date = date("Y").'-'.$month.'-01';
        $result = [];

        for ($i=1; $i <= date('t', strtotime($date)); $i++) {
            array_push($labels, $i);

            $this->db->select('entry_date,  TIMESTAMPDIFF(minute, entry_time, exit_time) as tiempo');
            $this->db->where('MONTH(entry_date)', $month);
            $this->db->where('DAYOFMONTH(entry_date)', $i);
            $this->db->from('historial');
            $query = $this->db->get();

            $date_id = date("Y").'-'.$month.'-'.$i;
            $contador = 0;

            foreach ($query->result() as $row)
            {
                $contador += $row->tiempo;
            }

            array_push($horas, (number_format((float)$contador/60, 2, '.', '')));
        }

        array_push($result, $labels);
        array_push($result, $horas);

        echo json_encode($result);
    }

    public function get_graph_horas_usuario(){
        $month = $_POST['month'];
        $result = [];
        $aux = [];
        $label = '';
        $contador = 0;
        $tiempo = 0;
        $tiempo_aux = 0;

        $data = $this->config->item('colores');

        switch ($month) {
            case 1: $label = 'Enero'; break;
            case 2: $label = 'Febrero'; break;
            case 3: $label = 'Marzo'; break;
            case 4: $label = 'Abril'; break;
            case 5: $label = 'Mayo'; break;
            case 6: $label = 'Junio'; break;
            case 7: $label = 'Julio'; break;
            case 8: $label = 'Agosto'; break;
            case 9: $label = 'Septiembre'; break;
            case 10: $label = 'Octubre'; break;
            case 11: $label = 'Noviembre'; break;
            case 12: $label = 'Diciembre'; break;
        }

        $this->db->select('id, nombre');
        $this->db->from('usuarios');
        $this->db->where('status >', 0);
        $query = $this->db->get();

        foreach ($query->result() as $usuarios) {

            $this->db->select('TIMESTAMPDIFF(minute, entry_time, exit_time) as tiempo');
            $this->db->from('historial');
            $this->db->where('status', 1);
            $this->db->where('id_user', $usuarios->id);
            $query2 = $this->db->get();

            $tiempo = 0;

            foreach ($query2->result() as $usuario) {
                $tiempo = $tiempo + $usuario->tiempo;
            }

            $tiempo_aux = (number_format((float)$tiempo/60, 2, '.', ''));

            $obj = array(
                'label' => $usuarios->nombre,
                'backgroundColor' => 'rgba('.$data[$contador]['rgb'].',0.4)',
                'borderColor' => 'rgba('.$data[$contador]['rgb'].',1)',
                'borderWidth' => 1,
                'data' => array($tiempo_aux)
            );

            $contador++;

            array_push($aux, $obj);
        }

        array_push($result, $label);
        array_push($result, $aux);

        echo json_encode($result);
    }

    public function get_graph_horas_dia_usuario(){
        $horas = [];
        $labels = [];
        $month = $_POST['month'];
        $usuario = $_POST['usuario'];
        $date = date("Y").'-'.$month.'-01';
        $result = [];
        $contador_global = 0;

        for ($i=1; $i <= date('t', strtotime($date)); $i++) {
            array_push($labels, $i);

            $this->db->select('entry_date,  TIMESTAMPDIFF(minute, entry_time, exit_time) as tiempo');
            $this->db->where('MONTH(entry_date)', $month);
            $this->db->where('DAYOFMONTH(entry_date)', $i);
            $this->db->where('id_user', $usuario);
            $this->db->from('historial');
            $query = $this->db->get();

            $date_id = date("Y").'-'.$month.'-'.$i;
            $contador = 0;

            foreach ($query->result() as $row)
            {
                $contador += $row->tiempo;
                $contador_global += $row->tiempo;
            }

            array_push($horas, (number_format((float)$contador/60, 2, '.', '')));
        }

        array_push($result, $labels);
        array_push($result, $horas);
        array_push($result, (number_format((float)$contador_global/60, 2, '.', '')));

        echo json_encode($result);
    }

    public function get_graph_horario_usuario(){
        $month = $_POST['month'];
        $usuario = $_POST['usuario'];
        $date = date("Y").'-'.$month.'-01';
        $response = array();
        $aux = array();

        for ($i=1; $i <= date('t', strtotime($date)); $i++) {
            $this->db->select('entry_date, entry_time, exit_time');
            $this->db->where('MONTH(entry_date)', $month);
            $this->db->where('DAYOFMONTH(entry_date)', $i);
            $this->db->where('id_user', $usuario);
            $this->db->from('historial');
            $query = $this->db->get();
            $row = $query->row();

            $date_id = date("Y").'-'.$month.'-'.$i.' 12:00:00';
            $aux = array();

            if (isset($row)){
                array_push($aux, (strtotime($date_id) * 1000 - 18000000));
                array_push($aux, strtotime($row->entry_time) * 1000 - 18000000);
                array_push($aux, strtotime($row->exit_time) * 1000 - 18000000);
            }
            else{
                array_push($aux, (strtotime($date_id) * 1000 - 18000000));
                // array_push($aux, strtotime('12:00:00') * 1000 - 18000000);
                // array_push($aux, strtotime('12:00:00') * 1000 - 18000000);
                array_push($aux, null);
                array_push($aux, null);
            }

            array_push($response, $aux);
        }

        echo json_encode($response);
    }

}
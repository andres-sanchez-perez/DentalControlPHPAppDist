<?php 
namespace App\Controllers;

use App\Models\Cirujia;
use App\Models\Paciente;
use CodeIgniter\Controller;
use DateTime;

class Cirujias extends BaseController{

    public function index($id=null){
        if(!isset($_SESSION['Rol'])){
            $tituloPagina['TituloPagina'] = "Not Logged";
            $datos['headerError'] = view('templates/HeaderNotLogged',$tituloPagina);
            return view('/errors/error',$datos);
        }
        else{
            $cirujias = new Cirujia();
            $sql = "SELECT CirujiaId, AntecedenteId,NombreCirujia,FechaCirujia,	PacienteId , DoctorACargo from cirujias where 	PacienteId  = ?";
            $query = $cirujias->db->query($sql,$id);
            $datos['Cirujias'] =$query->getResultArray();
            $tituloPagina['TituloPagina'] = "Ver Cirujias";
            $datos['header'] = view('templates/Header',$tituloPagina);
            
            
            return view('PacientesViews/VerCirujias',$datos);
        }
    }

    public function registrarCirujia(){
        if(!isset($_SESSION['Rol'])){
            $tituloPagina['TituloPagina'] = "Not Logged";
            $datos['headerError'] = view('templates/HeaderNotLogged',$tituloPagina);
            return view('/errors/error',$datos);
        }else{
            $paciente = new Paciente();
            $datos['pacientes'] = $paciente->getPacientes();
            $tituloPagina['TituloPagina'] = "Agregar Cirugia";
            $datos['header'] = view('templates/Header',$tituloPagina);
            return view('PacientesViews/RegistrarCirujias',$datos);
        }
    }

    public function agregarCirujia(){

        $cirujias = new Cirujia();
        $idPaciente = $_POST['idPaciente'];
        $nombreCirujia = $this->request->getVar('NombreCirujia');
        $FechaCirujia = new DateTime($this->request->getVar('FechaCirujia'));
        $FechaCirujia = $FechaCirujia->format('Y/m/d');
        $DoctorACargo = $this->request->getVar('DoctorACargo');
        $data =[
            'NombreCirujia' => $nombreCirujia,
            'FechaCirujia' => $FechaCirujia,
            'PacienteId ' => $idPaciente,
            'DoctorACargo' => $DoctorACargo
        ];
        $cirujias->insert($data);
        $url = base_url('/verCirujias/'.$idPaciente);
        return redirect($url);
    }
}
<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Inventario;
use Exception;

class Inventarios extends BaseController{

    public function index(){
        if(!Comprobadores::isLogged()){
            $tituloPagina['TituloPagina'] = "Not Logged";
            $datos['headerError'] = view('templates/HeaderNotLogged',$tituloPagina);
            return view('/errors/error',$datos);
        }
        else{
            try{
            $inventarios = new Inventario();
            
            
            $url ="http://localhost:60750/api/Gateway/Inventarios/ObtenerProductos";
            $result = file_get_contents($url);
            //return $result;
            $datos['inventarios'] = json_decode($result,true);
            $tituloPagina['TituloPagina'] = "Ver Inventario";
            $datos['header'] = view('templates/Header',$tituloPagina);
            
            return view('InventariosViews/VerInventarios',$datos);
            }
            catch(Exception $e){
                $url ="http://localhost:60800/api/Gateway/Inventarios/ObtenerProductos";
                $result = file_get_contents($url);
                //return $result;
                $datos['inventarios'] = json_decode($result,true);
                $tituloPagina['TituloPagina'] = "Ver Inventario";
                $datos['header'] = view('templates/Header',$tituloPagina);
                
                return view('InventariosViews/VerInventarios',$datos);
            }
        }
    }

    public function actualizarProducto(){
        if(!isset($_SESSION['Rol'])){
            $tituloPagina['TituloPagina'] = "Not Logged";
            $datos['headerError'] = view('templates/HeaderNotLogged',$tituloPagina);
            return view('/errors/error',$datos);
        }
        else{
            $inventarios = new Inventario();
            
            $datos['inventarios'] =$inventarios->getInventarios();
            $tituloPagina['TituloPagina'] = "Actualizar producto";
            $datos['header'] = view('templates/Header',$tituloPagina);
            
            
            return view('InventariosViews/actualizarCantidades',$datos);
        }
    }
    public function actualizarCantidades(){
        $id = $this->request->getVar('IdInventario');
        $tipo = $this->request->getVar('Tipo');
        $selector=$_POST['Agregar-Reducir'];
        $CantidadAIngresarOReducir=$this->request->getVar('CantidadAgregada-reducida');
        $dataToSend=[
            "Id" => $id,
            "Tipo"=> $tipo,
            "Selector" => $selector,
            "AgregarReducir" => $CantidadAIngresarOReducir
        ];
        $url="http://localhost:60750/api/Gateway/Inventarios/ActualizarProducto";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen(json_encode($dataToSend))));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($dataToSend));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $return = curl_exec($ch);
        curl_close($ch);
        if($return == false){
            $url="http://localhost:60800/api/Gateway/Inventarios/ActualizarProducto";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen(json_encode($dataToSend))));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($dataToSend));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $return = curl_exec($ch);
            curl_close($ch);
        }
        return redirect()->to(base_url('/verInventarios'));
    }

    
    public function setPrioridad($cantidadActual, $cantidadMaxima, $cantidadMinima) {
        $prioridad=0;
        $PrioL=$cantidadMaxima*0.75;
        $CantAc=$cantidadActual;
        
        if($cantidadActual<=$cantidadMaxima &&$CantAc>$PrioL){
            $prioridad = 3;
        }else if($CantAc<$PrioL && $cantidadActual>$cantidadMinima){
            $prioridad = 2;
        }else{
            $prioridad = 1;
        }
        return  $prioridad;
    }
    public function borrarProducto($id=null){
        $inventario = new Inventario();
        $url ="http://localhost:60750/api/Gateway/Inventarios/EliminarPorducto/".$_GET['id'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        $server_output = curl_exec($ch);
        curl_close ($ch);
        if($server_output == false){
            $url ="http://localhost:60800/api/Gateway/Inventarios/EliminarPorducto/".$_GET['id'];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            $server_output = curl_exec($ch);
            curl_close ($ch);
        }
        // $datosTratamiento = $inventario->where('id_inventario',$_GET['id'])->first();
        // $inventario->delete($datosTratamiento);
        //$data['url'] = curl_error($ch);
        $data['url']=base_url('/verInventarios');
        return json_encode($data,JSON_FORCE_OBJECT);
    }
    
    public function registrarProducto(){
        if(!isset($_SESSION['Rol'])){
            $tituloPagina['TituloPagina'] = "Not Logged";
            $datos['headerError'] = view('templates/HeaderNotLogged',$tituloPagina);
            return view('/errors/error',$datos);
        }else{
            $inventario = new Inventario();
            $datos['inventarios'] = $inventario->getInventarios();
            $tituloPagina['TituloPagina'] = "Agregar Producto";
            $datos['header'] = view('templates/Header',$tituloPagina);
            return view('InventariosViews/AgregarProducto',$datos);
        }
    }
    public function agregarProducto(){

        $inventario = new Inventario();
        $nombreProducto = $_POST['NombreProducto'];
        $TipoProducto = $_POST['TipoProducto'];
        $precio = $_POST['Precio'];
        $CantidadInicial = $_POST['CantidadInicial'];
        $Medida = $_POST['Medida'];
        $datos =[
            'Nombre' => $nombreProducto,
            'Precio' => $precio,
            'Tipo' => $TipoProducto,
            'CantidadActual' => $CantidadInicial,
            'CantidadMaxima' => $CantidadInicial,
            'CantidadMinima' => $CantidadInicial/2,
            'Prioridad' => 3,
            'Medida' => $Medida
        ];
        $url ="http://localhost:60750/api/Gateway/Inventarios/AgregarProducto";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($datos));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $err = curl_errno($ch);
        curl_close ($ch);
        if($server_output == false){
            $url ="http://localhost:60800/api/Gateway/Inventarios/AgregarProducto";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($datos));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            $err = curl_errno($ch);
            curl_close ($ch);
        }
        //$inventario->insert($data);
        $url = base_url('/verInventarios');
        $data['url'] = $url;
        $data['ServerResponse'] = $server_output;
        $data['error'] = $err;
        return json_encode($data,JSON_FORCE_OBJECT);
    }

    public static function IsPrioridad3($id){
        $inventarios = new Inventario();
        $sql= "SELECT Nombre,Precio,Tipo,CantidadActual,CantidadMinima,Prioridad,CantidadMaxima,Medida from inventario where id_inventario  = ?";
        $query = $inventarios->db->query($sql,$id);
        $inventario = $query->getResultArray();
        if($inventario[0]['Prioridad'] == 3){
            return true;
        }
        else{
            return false;
        }
    }
    public static function IsPrioridad2($id){
        $inventarios = new Inventario();
        $sql= "SELECT Nombre,Precio,Tipo,CantidadActual,CantidadMinima,Prioridad,CantidadMaxima,Medida from inventario where id_inventario  = ?";
        $query = $inventarios->db->query($sql,$id);
        $inventario = $query->getResultArray();
        if($inventario[0]['Prioridad'] == 2){
            return true;
        }
        else{
            return false;
        }
    }
    public static function IsPrioridad1($id){
        $inventarios = new Inventario();
        $sql= "SELECT Nombre,Precio,Tipo,CantidadActual,CantidadMinima,Prioridad,CantidadMaxima,Medida from inventario where id_inventario  = ?";
        $query = $inventarios->db->query($sql,$id);
        $inventario = $query->getResultArray();
        if($inventario[0]['Prioridad'] == 1){
            return true;
        }
        else{
            return false;
        }
    }
    public function editarProducto(){
        if(!isset($_SESSION['Rol'])){
            $tituloPagina['TituloPagina'] = "Not Logged";
            $datos['headerError'] = view('templates/HeaderNotLogged',$tituloPagina);
            return view('/errors/error',$datos);
        }
        else{
            $inventarios = new Inventario();
            
            $datos['inventarios'] =$inventarios->getInventarios();
            $tituloPagina['TituloPagina'] = "editar producto";
            $datos['header'] = view('templates/Header',$tituloPagina);
            
            
            return view('InventariosViews/VerInventarios',$datos);
        }
    }

    public function getSingleProduct($id=null){
        
        $inventarios = new Inventario();
        $id= $_GET['id'];
        $url="http://localhost:60750/api/Gateway/Inventarios/ObtenerProductoPorId/".$id;
        $result = file_get_contents($url);
        $data['inventario'] = json_decode($result,true);
        return json_encode($data,JSON_FORCE_OBJECT);
    }
}

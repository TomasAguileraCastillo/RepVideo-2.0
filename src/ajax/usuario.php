<?php


ob_start();
if (strlen(session_id()) < 1) {
    session_start(); //Validamos si existe o no la sesión
}
require_once "../modelo/Video.php";

$videos = new Videos();

class usuario
{
   
    

    // Atributos
                $idusuario int; 
				$nombre string; 
				$tipo_documentostring; 
				$num_documento int;
				$direccion string;
				$telefono int;
				$email string; 
                $imagenstring; 
				$condicion int;
				$descripcion string;
				$fechSubida timestamp;
                $creadopor string;

 // constructor
    public function __construct()
    {
    }
    



    // Metodos



    // Getters y Setters




}
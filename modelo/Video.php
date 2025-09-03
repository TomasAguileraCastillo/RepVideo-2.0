<?php
//Incluye inicialmente la conexión a la base de datos
require "../config/Conexion.php";

    Class Videos
    {
        //Implementamos nuestro constructor
        public function __construct()
        {

        }
        /****************************************************************************** */

        //Implementamos un método para insertar registros
        public function insertar($nombre, $descripcion, $comentario, $fechasubida, $subidopor, $curso, $ubicacion)
        {
            $sql =  "INSERT INTO `video`(   `nombre_videos`,
                                            `descripcion_videos`,
                                            `comentario_videos`,
                                            `fechasubida_videos`,
                                            `subidopor_videos`,
                                            `curso_videos`,
                                            `ubicacion_videos`,
                                            `condicion_videos`)
                    VALUES                ( `$nombre`,
                                            `$descripcion`,
                                            `$comentario`,
                                            `$fechasubida`,
                                            `$subidopor`,
                                            `$curso`,
                                            `$ubicacion`,
                                            '1')";
            return ejecutarConsulta( $sql );
        }
        /****************************************************************************** */
        //Implementamos un método para editar registros
        public function editar($idvideos, $nombre, $descripcion, $comentario, $fechasubida, $subidopor, $curso, $ubicacion)
        {
            $sql="  UPDATE `video`
                    SET `nombre_videos`='$nombre',
                        `descripcion_videos`='$descripcion',
                        `comentario_videos`='$comentario',
                        `fechasubida_videos`='$fechasubida',
                        `subidopor_videos`='$subidopor',
                        `curso_videos`='$curso',
                        `ubicacion_videos`='$ubicacion',
                        `condicion_videos`='1'
                     WHERE id_videos ='$idvideos' ";
            return ejecutarConsulta( $sql );
        }
        /****************************************************************************** */
          //Implementamos un método para desactivar registros
          public function desactivar( $idvideos )
          {
              $sql = "UPDATE video SET condicion_videos='0' WHERE id_videos='$idvideos'";
              return ejecutarConsulta( $sql );
          }
        /****************************************************************************** */
        //Implementamos un método para activar registros
        public function activar( $idvideos )
        {
            $sql = "UPDATE video SET condicion_videos='1' WHERE id_videos='$idvideos'";
            return ejecutarConsulta( $sql );
        }
        /****************************************************************************** */
        //Implementar un método para mostrar los datos de un registro a modificar
        public function mostrar($idvideos)
        {
            $sql = "SELECT * FROM video WHERE id_videos='$idvideos'";
            return ejecutarConsultaSimpleFila( $sql );
        }
        /****************************************************************************** */
        //Método para listar los registros
        public function listar()
        {
            $sql = "SELECT * FROM video";
            return ejecutarConsulta( $sql );

        }
        /****************************************************************************** */
    //Método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM `cursos` WHERE `condicion_cursos`=1";
		return ejecutarConsulta($sql);
	}


     /****************************************************************************** */
     public function verifica($login,$clave)
     {

        //$sql="SELECT * FROM usuario WHERE nombre_usuario = BINARY '$login' AND password_usuario = BINARY '$clave'";
        $sql="SELECT idusuario,nombre,tipo_documento,num_documento,telefono,email,cargo,imagen,login FROM usuario WHERE login='$login' AND clave='$clave'";
        //$sql="SELECT * FROM usuario WHERE nombre_usuario= $login and password_usuario= $clave";
         return ejecutarConsulta($sql);
     }
}

?>
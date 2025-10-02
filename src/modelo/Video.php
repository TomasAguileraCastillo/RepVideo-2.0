<?php

//Incluye inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Videos
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
        return ejecutarConsulta($sql);
    }
    /****************************************************************************** */
    //Implementamos un método para editar registros
    public function editar($idvideos, $nombre, $descripcion, $comentario, $fechasubida, $subidopor, $curso, $ubicacion)
    {
        $sql = "  UPDATE `video`
                    SET `nombre_videos`='$nombre',
                        `descripcion_videos`='$descripcion',
                        `comentario_videos`='$comentario',
                        `fechasubida_videos`='$fechasubida',
                        `subidopor_videos`='$subidopor',
                        `curso_videos`='$curso',
                        `ubicacion_videos`='$ubicacion',
                        `condicion_videos`='1'
                     WHERE id_videos ='$idvideos' ";
        return ejecutarConsulta($sql);
    }
    /****************************************************************************** */
    //Implementamos un método para desactivar registros
    public function desactivar($idvideos)
    {
        $sql = "UPDATE videos SET condicion_video='0' WHERE id_video='$idvideos'";
        return ejecutarConsulta($sql);
    }
    /****************************************************************************** */
    //Implementamos un método para activar registros
    public function activar($idvideos)
    {
        $sql = "UPDATE videos SET condicion_video='1' WHERE id_video='$idvideos'";
        return ejecutarConsulta($sql);
    }
    /****************************************************************************** */
    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($idvideos)
    {
        $sql = "SELECT * FROM video WHERE id_videos='$idvideos'";
        return ejecutarConsultaSimpleFila($sql);
    }
    /****************************************************************************** */
    //Método para listar los registros
    public function listar()
    {

        //$sql = "SELECT * FROM videos";
        $sql = "SELECT id_video, nombre_video, descripcion_video, fechaSub_video, subidopor_video, curso_video, peso_video, ubicacion_video, condicion_video
FROM db_videos.videos;";



        return ejecutarConsulta($sql);

    }
    /****************************************************************************** */
    //Método para listar los registros y mostrar en el select
    public function selectHtml()
    {
        $sql = "SELECT * FROM cursos WHERE estado_cursos = '1';";
        return ejecutarConsulta($sql);
    }


    /****************************************************************************** */
    public function verifica($login, $clave)
    {

        //$sql="SELECT * FROM usuario WHERE nombre_usuario = BINARY '$login' AND password_usuario = BINARY '$clave'";
        $sql = "SELECT idusuario,nombre,tipo_documento,num_documento,telefono,email,cargo,imagen,login FROM usuario WHERE login='$login' AND clave='$clave'";
        //$sql="SELECT * FROM usuario WHERE nombre_usuario= $login and password_usuario= $clave";
        return ejecutarConsulta($sql);
    }

    /********************************************************************************* */
    /**
     * Función para obtener y formatear el tamaño de un archivo a una unidad legible (incluyendo KB y Bytes).
     * @param string $ruta_archivo La ruta completa al archivo.
     * @param int $precision El número de decimales a mostrar.
     * @return string El tamaño formateado (ej: "450.00 KB") o un mensaje de error.
     */
    public function tamanoArchivo(string $ruta_archivo, int $precision = 2): string
    {
        // Usa la función nativa filesize() para obtener el tamaño en bytes.
        $bytes = @filesize($ruta_archivo);

        if ($bytes === false) {
            return "ERROR: Archivo no encontrado o sin permisos.";
        }

        if ($bytes === 0) {
            return '0 Bytes';
        }

        // Unidades de medida: Bytes, KB, MB, GB, TB, PB
        $unidades = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB'];

        // Calcula qué unidad usar (0=Bytes, 1=KB, 2=MB, etc.)
        $factor = floor(log($bytes, 1024));

        // Calcula el tamaño formateado a la unidad correcta
        $tamano_formateado = round($bytes / (1024 ** $factor), $precision);

        // Combina el número formateado con su unidad
        return $tamano_formateado . ' ' . $unidades[$factor];
    }

}
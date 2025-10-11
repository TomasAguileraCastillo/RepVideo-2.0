<?php

// Incluye inicialmente la conexión a la base de datos
require '../config/Conexion.php';

class Usuarios
{
    // Implementamos nuestro constructor
    public function __construct() {}

    // Implementamos un método para insertar registros
    public function insertar(
        $nombre,
        $tipoDoc,
        $numDoc,
        $direccion,
        $telefono,
        $email,
        $login,
        $clave,
        $imagen,
        $descripcion,
        $fechasubida,
        $subidopor,
        $condicion
    ) {
        $sql = "INSERT INTO    usuario (   nombre,
                                            tipo_documento, 
                                            num_documento,
                                            direccion,
                                            telefono,
                                            email,
                                            login,
                                            clave,
                                            imagen,
                                            condicion,
                                            descripcion,
                                            fechSubida,
                                            creadopor)
                VALUES  (   '$nombre',
                            '$tipoDoc', 
                            '$numDoc', 
                            '$direccion', 
                            ' $telefono', 
                            '$email', 
                            '$login', 
                            '$clave', 
                            '$imagen', 
                            '$descripcion', 
                            '$fechasubida', 
                            '$subidopor',
                            $condicion = 1);";

        return ejecutarConsulta($sql);
    }

    /* */

    // Implementamos un método para editar registros




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

    /* */

    // Implementamos un método para desactivar registros
    public function desactivar($idvideos)
    {
        $sql = "UPDATE videos SET condicion_video='0' WHERE id_video='$idvideos'";
        return ejecutarConsulta($sql);
    }

    /* */

    // Implementamos un método para activar registros
    public function activar($idvideos)
    {
        $sql = "UPDATE videos SET condicion_video='1' WHERE id_video='$idvideos'";
        return ejecutarConsulta($sql);
    }

    /* */

    // Método para mostrar los datos de un registro a modificar
    public function mostrar($idvideo)
    {
        // Esto mejora la legibilidad y el rendimiento (SELECT * debe evitarse).
        $sql = "SELECT id_video, curso_video, descripcion_video  
                FROM videos 
                WHERE id_video = $idvideo";

        // NOTA DE SEGURIDAD: Mantenemos el estándar de usar $idvideo sin comillas,
        // asumiendo que el controlador lo limpió con intval().

        return ejecutarConsultaSimpleFila($sql);
    }

    /* */

    // Método para listar los registros
    public function listar()
    {
        $sql = "SELECT  v.id_video,
                        v.descripcion_video, 
                        v.fechaSub_video, 
                        v.subidopor_video, 
                        v.peso_video,
                        v.ubicacion_video,
                        v.condicion_video,
                        v.nombre_video,
                        -- Campo del curso: usamos la columna de la tabla 'curso'
                        c.descripcion_cursos AS nombreCurso,
                        c.codigo_cursos as codigoCurso,
                        v.curso_video AS curso_id  -- Mantenemos el ID por si se necesita
                FROM videos v 
                INNER JOIN cursos c ON v.curso_video = c.id_cursos;";

        /*
         * $sql = "SELECT  id_video,
         *             nombre_video,
         *             descripcion_video,
         *             fechaSub_video,
         *             subidopor_video,
         *             curso_video,
         *             peso_video,
         *             ubicacion_video,
         *             condicion_video
         *     FROM videos;";
         */

        return ejecutarConsulta($sql);
    }

    /* */
    // Método para listar los registros y mostrar en el select

    public function selectHtml()
    {
        // Seleccionamos solo las columnas que se usarán en el HTML
        // y asumimos que estado_cursos es numérico (1)
        $sql = 'SELECT id_cursos, codigo_cursos, descripcion_cursos FROM cursos WHERE estado_cursos = 1';

        // Llamar a la función que ejecuta la consulta y devuelve el resultado (mysqli_result)
        return ejecutarConsulta($sql);
    }

    /**
     * 
     */


    /* */
    public function verifica($login, $clave)
    {
        // $sql="SELECT * FROM usuario WHERE nombre_usuario = BINARY '$login' AND password_usuario = BINARY '$clave'";
        $sql = "SELECT idusuario,nombre,tipo_documento,num_documento,telefono,email,cargo,imagen,login 
        FROM usuario 
        WHERE login='$login' AND clave='$clave'";
        // $sql="SELECT * FROM usuario WHERE nombre_usuario= $login and password_usuario= $clave";
        return ejecutarConsulta($sql);
    }

    /* */

    /**
     * Función para obtener y formatear el tamaño de un archivo a una unidad legible (incluyendo KB y Bytes).
     * @param string $ruta_archivo La ruta completa al archivo.
     * @param int $precision El número de decimales a mostrar.
     * @return string El tamaño formateado (ej: "450.00 KB") o un mensaje de error.
     */
    public function tamanoArchivo($ruta_archivo, int $precision = 2): string
    {
        // Usa la función nativa filesize() para obtener el tamaño en bytes.
        $bytes = @filesize($ruta_archivo);

        if ($bytes === false) {
            return 'ERROR: Archivo no encontrado o sin permisos.';
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

    /* */

    // Método para listar los registros
    public function listarCursos()
    {
        $sql = "SELECT  id_cursos,
                        codigo_cursos,
                        descripcion_cursos,
                        condicion_cursos,
                        creadopor_cursos,
                        fechaCreado_cursos
\t\t\tFROM cursos;";

        return ejecutarConsulta($sql);
    }

    /* */
    // Método para eliminar un usuario de forma segura usando MySQLi y consultas preparadas

    /**
     * Undocumented function
     *
     * @param int $idUsuario
     * @param objet $conexion
     * @return void
     */
    public function eliminaUsuario($idUsuario, $conexion)
    {
        // 1. Definir la consulta con el marcador de posición '?'
        $sql = 'DELETE FROM usuario WHERE id_usuario = ?';

        // 2. Preparar la sentencia
        $stmt = $conexion->prepare($sql);

        // Verificar si la preparación falló
        if ($stmt === false) {
            // En un entorno real, manejarías el error de forma más elegante
            die('Error al preparar la consulta: ' . $conexion->error);
        }

        // 3. Vincular el parámetro: 'i' indica que $idUsuario es un entero (integer)
        $stmt->bind_param('i', $idUsuario);

        // 4. Ejecutar la sentencia
        $resultado = $stmt->execute();

        // 5. Cerrar la sentencia (liberar recursos)
        $stmt->close();

        // 6. Retornar el resultado de la ejecución (true/false)
        return $resultado;
    }
}
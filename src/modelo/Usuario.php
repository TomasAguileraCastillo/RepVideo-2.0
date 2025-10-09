<?php

require '../config/Conexion.php';

class UsuarioDAO
{
    // Atributos

    private $conexion;

    // Constructor

    /**
     * Inicializa el objeto DAO (Data Access Object) con la conexión a la base de datos.
     * @param mysqli $conexion Objeto de conexión a la base de datos.
     */
    public function __construct(mysqli $conexion)
    {
        $this->conexion = $conexion;
    }

    // Getters y Setters

    // Métodos

    /*
     * Inserta un nuevo registro de usuario de forma segura con sentencia preparada.
     *
     * @param string $nombre Nombre del usuario.
     * @param string $tipoDoc Tipo de documento.
     * @param int $numDoc Número de documento.
     * @param string $direccion Dirección.
     * @param int $telefono Teléfono.
     * @param string $email Correo electrónico.
     * @param string $login Nombre de usuario para login.
     * @param string $clave Contraseña (debe ser hasheada).
     * @param string $imagen Ruta de la imagen.
     * @param string $descripcion Descripción del usuario.
     * @param string $fechasubida Fecha de subida (formato 'YYYY-MM-DD').
     * @param int $subidopor ID del usuario que crea el registro.
     * @param int $condicion Condición/estado del usuario (por defecto 1).
     * @return bool Retorna true si la inserción fue exitosa, false en caso contrario.
     */

    public function insertar(
        $nombre, $tipoDoc, $numDoc, $direccion, $telefono, $email, $login,
        $clave, $imagen, $descripcion, $fechasubida, $subidopor, $condicion = 1
    ) {
        // 1. Hashear la clave antes de cualquier otra cosa (¡Seguridad!)
        // Nota: Solo se inserta el hash, no la clave original.
        $clave_hasheada = password_hash($clave, PASSWORD_DEFAULT);

        // 2. Definir el SQL con marcadores de posición (?)
        $sql = 'INSERT INTO usuario 
            (nombre, tipo_documento, num_documento, direccion, telefono, 
            email, login, clave, imagen, descripcion, fechSubida, creadopor, condicion) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

        // 3. Preparar la sentencia
        $stmt = $this->conexion->prepare($sql);

        if ($stmt === false) {
            // Manejo de error: la consulta SQL es inválida
            return false;
        }

        // 4. Definir los tipos de datos: 's' por string, 'i' por integer.
        // Asumimos 'i' para numDoc, telefono, subidopor y condicion.
        $tipos = 'ssissssssssii';

        // 5. Vincular los parámetros con los valores
        $stmt->bind_param(
            $tipos,
            $nombre, $tipoDoc, $numDoc, $direccion, $telefono, $email,
            $login, $clave_hasheada, $imagen, $descripcion, $fechasubida,
            $subidopor, $condicion
        );

        // 6. Ejecutar y retornar resultado
        $resultado = $stmt->execute();
        $stmt->close();

        return $resultado;
    }
}
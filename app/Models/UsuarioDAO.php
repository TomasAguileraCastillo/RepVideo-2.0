<?php

namespace App\Models;

use App\Core\Conexion;

class UsuarioDAO
{
    // Atributos
    private $db;

    // Constructor
    public function __construct()
    {
        // Obtiene la instancia Singleton de la conexión segura
        $this->db = Conexion::getInstancia();
    }

    // Métodos

    /**
     * Inserta un nuevo registro de usuario de forma segura con sentencia preparada y transacción.
     * Mantiene la lógica de transacción aquí, usando la conexión MySQLi directa.
     *
     * @param string $nombre      Nombre del usuario.
     * @param string $tipoDoc     Tipo de documento.
     * @param int $numDoc         Número de documento.
     * @param string $direccion   Dirección.
     * @param int $telefono      Teléfono.
     * @param string $email       Correo electrónico.
     * @param string $login       Nombre de usuario para login.
     * @param string $clave       Contraseña (será hasheada internamente).
     * @param string $imagen      Ruta de la imagen.
     * @param string $descripcion Descripción del usuario.
     * @param string $fechasubida Fecha de subida (formato 'YYYY-MM-DD').
     * @param int $subidopor      ID del usuario que crea el registro.
     * @param int $condicion      Condición/estado del usuario (por defecto 1).
     * @return bool Retorna TRUE si la inserción fue exitosa y la transacción se confirmó.
     * @throws \Exception Si falla la preparación, la vinculación, la ejecución o la transacción.
     */
    public function insertarRegistro(
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
        $condicion = 1
    ) {
        // 1. Hashear la clave antes de cualquier otra cosa (¡Seguridad!)
        $clave_hasheada = password_hash($clave, PASSWORD_DEFAULT);

        $sql = 'INSERT INTO usuario 
        (nombre, tipo_documento, num_documento, direccion, telefono, 
        email, login, clave, imagen, descripcion, fechSubida, creadopor, condicion) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

        $conn = $this->db->getConexion();  // <--- Acceso a la conexión una sola vez

        try {
            // INICIAR TRANSACCIÓN (Garantiza atomicidad)
            $conn->begin_transaction();

            // 2. Preparar la sentencia
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                throw new \Exception('Error al preparar la sentencia SQL: ' . $conn->error);
            }

            // 3. Vincular los parámetros con los valores (13 parámetros)
            // TIPOS: s, s, i, s, i, s, s, s, s, s, s, i, i
            $tipos = 'ssisssisssii';

            $stmt->bind_param(
                $tipos,
                $nombre, $tipoDoc, $numDoc, $direccion, $telefono, $email,
                $login, $clave_hasheada, $imagen, $descripcion, $fechasubida,
                $subidopor, $condicion
            );

            // 4. Ejecutar y verificar
            if ($stmt->execute() === false) {
                throw new \Exception('Error al ejecutar la inserción: ' . $stmt->error);
            }

            // 5. CONFIRMAR LA TRANSACCIÓN (éxito)
            $conn->commit();
            $stmt->close();
            return true;
        } catch (\Exception $e) {
            // 6. DESHACER LA TRANSACCIÓN y registrar el error
            if (isset($conn))
                $conn->rollback();
            error_log('Transacción de inserción de usuario fallida: ' . $e->getMessage());

            if (isset($stmt))
                $stmt->close();
            return false;
        }
    }

    /**
     * Actualiza la información de un registro en la base de datos (Usuario).
     *
     * @param int $idUsuario ID único del usuario a actualizar (condición WHERE).
     * @param string $nombre    Nombre completo del usuario.
     * @param string $tipoDoc Tipo de documento de identificación.
     * @param int $numDoc         Número de documento.
     * @param string $direccion    Dirección residencial del usuario.
     * @param int $telefono       Número de teléfono de contacto.
     * @param string $email        Correo electrónico.
     * @param string $imagen     Ruta o nombre del archivo de imagen de perfil.
     * @param string $descripcion Descripción o notas adicionales del usuario.
     * @return bool Retorna TRUE si la actualización fue exitosa y la transacción se confirmó.
     * @throws \Exception Si falla la preparación de la consulta, la vinculación o la ejecución.
     */
    public function editarregistro(
        $idUsuario,
        $nombre,
        $tipoDoc,
        $numDoc,
        $direccion,
        $telefono,
        $email,
        $imagen,
        $descripcion
    ) {
        // 1. Definir la consulta con MARCADO de POSICIÓN (?)
        $sql = '
    UPDATE usuario SET 
        nombre = ?, 
        tipo_documento = ?, 
        num_documento = ?, 
        direccion = ?, 
        telefono = ?, 
        email = ?, 
        imagen = ?, 
        descripcion = ?,
        condicion = 1 
    WHERE idusuario = ?
    ';

        $conn = $this->db->getConexion();  // <--- Acceso a la conexión una sola vez

        // 2. Usar un bloque TRY-CATCH para manejar transacciones y excepciones
        try {
            // INICIAR TRANSACCIÓN
            $conn->begin_transaction();

            // 3. Preparar y vincular la sentencia
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                throw new \Exception('Error al preparar la sentencia SQL: ' . $conn->error);
            }

            // Cadena de tipos: s (nombre), s (tipoDoc), i (numDoc), s (direccion),
            // i (telefono), s (email), s (imagen), s (descripcion), i (idUsuario en el WHERE)
            $stmt->bind_param(
                'ssisisssi',
                $nombre,
                $tipoDoc,
                $numDoc,
                $direccion,
                $telefono,
                $email,
                $imagen,
                $descripcion,
                $idUsuario
            );

            // 4. Ejecutar y verificar
            if ($stmt->execute() === false) {
                // Si falla la ejecución, lanza una excepción para forzar el rollback
                throw new \Exception('Error al ejecutar la actualización: ' . $stmt->error);
            }

            // 5. CONFIRMAR LA TRANSACCIÓN
            $conn->commit();
            $stmt->close();
            return true;
        } catch (\Exception $e) {
            // 6. DESHACER LA TRANSACCIÓN y registrar el error
            if (isset($conn))
                $conn->rollback();
            error_log('Transacción de edición de usuario fallida: ' . $e->getMessage());

            // Cierra el statement si está abierto
            if (isset($stmt))
                $stmt->close();

            return false;
        }
    }

    /**
     * Obtiene y lista todos los registros de usuarios.
     *
     * @return array|false Retorna un array asociativo con los registros de usuarios,
     * o false si ocurre un error en la base de datos.
     */
    public function listarusuarios()
    {
        // 1. Definición de la consulta (sin parámetros necesarios)
        // Nota: Agregué 'apellido', 'fech_Nac', 'rut' a esta consulta de ejemplo,
        // pero asegúrate de que existen en tu tabla si los necesitas.
        $sql = 'SELECT   idusuario, 
                         nombre, 
                         apellido, 
                         fech_Nac, 
                         rut, 
                         direccion, 
                         telefono, 
                         email, 
                         login, 
                         imagen, 
                         condicion, 
                         descripcion, 
                         fechSubida, 
                         creadopor
                FROM usuario;';

        try {
            // 2. Ejecución simplificada:
            // La función del Core ya maneja el prepare, execute, y get_result()
            $resultado = $this->db->ejecutarSentenciaSegura($sql, [], '');

            if ($resultado === false || $resultado->num_rows === 0) {
                // Si la consulta no devolvió filas o hubo un error manejado en el Core
                return [];
            }

            // 3. Procesar el resultado (solo requiere esta línea)
            $usuarios = $resultado->fetch_all(MYSQLI_ASSOC);

            return $usuarios;
        } catch (\Exception $e) {
            // El Core lanza una excepción si falla la preparación
            error_log('Error al listar usuarios (excepción del Core): ' . $e->getMessage());
            // Devuelve un error para que el Controlador sepa que la operación falló
            return false;
        }
    }

    /**
     * Obtiene un único registro de usuario por su ID.
     * Utiliza consultas preparadas para mayor seguridad, excluyendo la clave de acceso.
     *
     * @param int $idUsuario ID único del usuario a buscar.
     * @return array|false Retorna un array asociativo con los datos del usuario,
     * o FALSE si ocurre un error, o un array vacío si no se encuentra.
     */
    public function obtenerUsuarioPorId($idUsuario)
    {
        $sql = ' SELECT idusuario,
                         nombre, 
                         tipo_documento, 
                         num_documento, 
                         direccion, 
                         telefono, 
                         email, 
                         imagen, 
                         condicion, 
                         descripcion, 
                         fechSubida, 
                         creadopor
                FROM usuario
                WHERE idusuario = ?;';

        try {
            // Se usa el método seguro del Core. Parámetros: [Valor], [Tipo]
            $resultado = $this->db->ejecutarSentenciaSegura($sql, [$idUsuario], 'i');

            if ($resultado === false || $resultado->num_rows === 0) {
                // Si la consulta no devolvió filas o hubo un error manejado en el Core
                return [];
            }

            // fetch_assoc para obtener una sola fila
            $usuario = $resultado->fetch_assoc();

            return $usuario;
        } catch (\Exception $e) {
            error_log('Error al obtener usuario por ID (excepción del Core): ' . $e->getMessage());
            return false;
        }
    }

    /**
     * ELIMINA FÍSICAMENTE un registro de usuario de la base de datos.
     * ⚠️ Usar con precaución. No debe usarse si se requiere el historial o auditoría del registro.
     *
     * @param int $idUsuario ID único del usuario a eliminar.
     * @return bool Retorna TRUE si la eliminación fue exitosa, FALSE en caso contrario.
     * @throws \Exception Si falla la preparación, la ejecución o la transacción.
     */
    public function eliminaUsuario($idUsuario)
    {
        // 1. Definir la consulta con el marcador de posición '?'
        $sql = 'DELETE FROM usuario WHERE idusuario = ?';

        $conn = $this->db->getConexion();  // <--- Acceso a la conexión una sola vez

        try {
            // INICIAR TRANSACCIÓN
            $conn->begin_transaction();

            // 2. Preparar la sentencia
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                throw new \Exception('Error al preparar la sentencia SQL: ' . $conn->error);
            }

            // 3. Vincular el parámetro: 'i' indica que $idUsuario es un entero (integer)
            $stmt->bind_param('i', $idUsuario);

            // 4. Ejecutar y verificar
            if ($stmt->execute() === false) {
                // Si falla la ejecución, lanza una excepción para forzar el rollback
                throw new \Exception('Error al ejecutar la eliminación: ' . $stmt->error);
            }

            // 5. CONFIRMAR LA TRANSACCIÓN
            $conn->commit();
            $stmt->close();
            return true;
        } catch (\Exception $e) {
            // 6. DESHACER LA TRANSACCIÓN y registrar el error
            if (isset($conn))
                $conn->rollback();
            error_log('Transacción de eliminación de usuario fallida: ' . $e->getMessage());

            // Cierra el statement si está abierto
            if (isset($stmt))
                $stmt->close();

            return false;
        }
    }

    /**
     * Activa un registro de usuario cambiando su 'condicion' a 1.
     *
     * @param int $idUsuario ID único del usuario a activar.
     * @return bool Retorna TRUE si la operación fue exitosa, FALSE en caso contrario.
     * @throws \Exception Si falla la preparación, la ejecución o la transacción.
     */
    public function activarRegistro($idUsuario)
    {
        // 1. Consulta SQL para Activación (condicion = 1)
        $sql = 'UPDATE usuario SET condicion = 1 WHERE idusuario = ?';

        $conn = $this->db->getConexion();  // <--- Acceso a la conexión una sola vez

        try {
            // INICIAR TRANSACCIÓN
            $conn->begin_transaction();

            // 2. Preparar la sentencia
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                throw new \Exception('Error al preparar la sentencia SQL: ' . $conn->error);
            }

            // 3. Vincular el parámetro: 'i' para el ID
            $stmt->bind_param('i', $idUsuario);

            // 4. Ejecutar y verificar
            if ($stmt->execute() === false) {
                throw new \Exception('Error al ejecutar la activación: ' . $stmt->error);
            }

            // 5. CONFIRMAR LA TRANSACCIÓN
            $conn->commit();
            $stmt->close();
            return true;
        } catch (\Exception $e) {
            // 6. DESHACER LA TRANSACCIÓN y registrar el error
            if (isset($conn))
                $conn->rollback();
            error_log('Transacción de activación de usuario fallida: ' . $e->getMessage());

            if (isset($stmt))
                $stmt->close();
            return false;
        }
    }

    /**
     * Desactiva un registro de usuario cambiando su 'condicion' a 0 (Eliminación Lógica).
     *
     * @param int $idUsuario ID único del usuario a desactivar.
     * @return bool Retorna TRUE si la operación fue exitosa, FALSE en caso contrario.
     * @throws \Exception Si falla la preparación, la ejecución o la transacción.
     */
    public function desactivarRegistro($idUsuario)
    {
        // 1. Consulta SQL para Soft Delete (condicion = 0)
        $sql = 'UPDATE usuario SET condicion = 0 WHERE idusuario = ?';

        $conn = $this->db->getConexion();  // <--- Acceso a la conexión una sola vez

        try {
            // INICIAR TRANSACCIÓN
            $conn->begin_transaction();

            // 2. Preparar la sentencia
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                throw new \Exception('Error al preparar la sentencia SQL: ' . $conn->error);
            }

            // 3. Vincular el parámetro: 'i' para el ID
            $stmt->bind_param('i', $idUsuario);

            // 4. Ejecutar y verificar
            if ($stmt->execute() === false) {
                throw new \Exception('Error al ejecutar la desactivación: ' . $stmt->error);
            }

            // 5. CONFIRMAR LA TRANSACCIÓN
            $conn->commit();
            $stmt->close();
            return true;
        } catch (\Exception $e) {
            // 6. DESHACER LA TRANSACCIÓN y registrar el error
            if (isset($conn))
                $conn->rollback();
            error_log('Transacción de desactivación de usuario fallida: ' . $e->getMessage());

            if (isset($stmt))
                $stmt->close();
            return false;
        }
    }

    // Getters y Setters
}
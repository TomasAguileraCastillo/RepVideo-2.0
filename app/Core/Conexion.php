<?php

namespace App\Core;

class conexion implements DbConnectionInterface
{
    // Atributos

    private $connection;
    private static $instance = null;

    // Constructor

    private function __construct()
    {
        $config = require __DIR__ . '/../../config/database.php';

        $this->connection = new \mysqli(
            $config['host'],
            $config['user'],
            $config['pass'],
            $config['dbname']
        );

        // Define la codificación
        $this->connection->query('SET NAMES "' . $config['encode'] . '"');

        // Manejo de errores de conexión
        if (mysqli_connect_errno()) {
            printf("Falló conexión a la base de datos: %s\n", mysqli_connect_error());
            exit();
        }
    }

    // Métodos

    // Método estático público para obtener la única instancia de la clase

    /**
     * @return Conexion
     */
    public static function getInstancia()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Método para obtener el objeto de conexión mysqli

    /**
     * @return \mysqli
     */
    public function getConexion(): object
    {
        return $this->connection;
    }

    // Métodos de consulta centralizados

    public function ejecutarSentenciaSegura(string $sql, array $params = [], string $types = '')
    {
        $stmt = $this->connection->prepare($sql);
        // Manejar errores de preparación (por ejemplo, SQL malformado)
        if (!$stmt) {
            throw new \Exception('Error al preparar la sentencia: ' . $this->connection->error);
        }

        // 2. Enlaza los parámetros (si existen)
        if (!empty($params)) {
            // Necesitamos enlazar el array de parámetros a la función bind_param()
            $bindArgs = array_merge([$types], $params);

            // Uso de referencias para bind_param (requerido en PHP)
            $refs = [];
            foreach ($bindArgs as $key => $value) {
                $refs[$key] = &$bindArgs[$key];
            }

            // Llamada dinámica a bind_param
            call_user_func_array([$stmt, 'bind_param'], $refs);
        }
        // 3. Ejecuta la sentencia
        $stmt->execute();

        // 4. Retorna el resultado (dependiendo del tipo de consulta)

        if (strtoupper(substr(trim($sql), 0, 6)) === 'INSERT') {
            // Retorna el ID insertado para INSERT
            $result = $stmt->insert_id;
        } elseif (strtoupper(substr(trim($sql), 0, 6)) === 'SELECT') {
            // Retorna el resultado para SELECT
            $result = $stmt->get_result();
        } else {
            // Para UPDATE/DELETE, retorna el número de filas afectadas
            $result = $stmt->affected_rows;
        }

        $stmt->close();
        return $result;
    }

    // getters y setters
}
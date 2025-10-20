<?php

namespace App\Core;

// CRÍTICO: Asegúrate de que existe la interfaz DbConnectionInterface
// (Se omite por brevedad, asumiendo que existe)

class Conexion // Implementa DbConnectionInterface
{
    // Atributos
    private $connection;
    private static $instance = null;

    // Constructor (Privado para el patrón Singleton)
    private function __construct()
    {
        // Ruta al archivo de configuración
        $config = require __DIR__ . '/../../config/database.php';

        // 1. Intentar la conexión
        $this->connection = new \mysqli(
            $config['host'],
            $config['user'],
            $config['pass'],
            $config['dbname']
        );

        // 2. Manejo de errores de conexión
        if (mysqli_connect_errno()) {
            // CRÍTICO: Usamos error_log en lugar de printf para NO ENVIAR SALIDA al navegador.
            error_log("FALLO DE CONEXIÓN A LA BASE DE DATOS: " . mysqli_connect_error());
            // Detenemos la ejecución de la aplicación, ya que la conexión es vital.
            exit(); 
        }

        // 3. Definir la codificación
        $this->connection->query('SET NAMES "' . $config['encode'] . '"');

        // Nota: Asumiendo que DbConnectionInterface existe y se implementa
        // si la necesitas, vuelve a añadir 'implements DbConnectionInterface'
    }

    // Métodos

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
            // Asegúrate de que las excepciones se manejan o se registran, pero no se imprimen
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

        $sql_upper = strtoupper(trim($sql));
        if (str_starts_with($sql_upper, 'INSERT')) {
            // Retorna el ID insertado para INSERT
            $result = $stmt->insert_id;
        } elseif (str_starts_with($sql_upper, 'SELECT')) {
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
// IMPORTANTE: Etiqueta de cierre eliminada
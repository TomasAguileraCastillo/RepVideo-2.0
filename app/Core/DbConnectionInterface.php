<?php
// app/Core/DbConnectionInterface.php (¡CORREGIDO!)

namespace App\Core;

interface DbConnectionInterface
{
    // Mantiene el patrón Singleton (aunque es estático, es bueno definirlo)
    public static function getInstancia();

    // El método que los Modelos usan para obtener el objeto de conexión
    public function getConexion(): object;

    // ¡El nuevo método seguro que reemplaza a los demás!
    public function ejecutarSentenciaSegura(string $sql, array $params = [], string $types = '');
}
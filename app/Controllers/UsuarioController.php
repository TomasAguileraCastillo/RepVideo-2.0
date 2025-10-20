<?php

namespace App\Controllers;

// CRÍTICO: Incluir el archivo de inicialización (Autoloader y Conexión DB)
require_once __DIR__ . '/../Core/init.php';

use App\Models\UsuarioDAO;

/**
 * Clase UsuarioController
 * Responsable de manejar las peticiones relacionadas con la gestión de usuarios.
 * Configurado para DataTables en MODO CLIENTE (Client-Side Processing).
 */
class UsuarioController
{
    private $usuarioDAO;

    public function __construct()
    {
        // Inicializa el Modelo DAO
        $this->usuarioDAO = new UsuarioDAO();
    }

    /**
     * Devuelve TODOS los registros de usuarios en formato JSON para DataTables.
     * El filtrado, paginación y ordenación se realizan en el frontend por DataTables.
     * @return void
     */
    public function listar()
    {
        header('Content-Type: application/json');

        // Solo se lee el 'draw' si el frontend lo requiere para sincronización,
        // pero se IGNORAN 'start', 'length', 'search', 'order', etc., ya que
        // DataTables hará el trabajo en el navegador.
        $draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;

        // 1. OBTENER TODOS LOS REGISTROS DEL DAO (sin LIMIT/OFFSET)
        $rsptaData = $this->usuarioDAO->listarusuarios();

        if ($rsptaData === false) {
            http_response_code(500);
            echo json_encode(['status' => false, 'mensaje' => 'Error al listar usuarios desde la base de datos.']);
            exit();
        }

        $datos = [];
        $totalRegistros = count($rsptaData);

        // 2. Formatear los datos para DataTables
        foreach ($rsptaData as $reg) {

            // Lógica para los botones
            // Usamos un div con 'btn-group' de Bootstrap para asegurar que queden juntos.
            $botones = '<div class="btn-group shadow-sm">';

            if ($reg['condicion'] == 1) {
                // ACTIVO: Mostrar (lapiz) y Desactivar (x)
                $botones .= '<button class="btn btn-health-marine-primary btn-sm shadow-sm" onclick="mostrar(' . htmlspecialchars($reg['idusuario']) . ')"><i class="bi bi-pencil-fill"></i></button>';
                // NOTA: Se eliminó el espacio entre las concatenaciones.
                $botones .= '<button class="btn btn-health-cyan-alert btn-sm shadow-sm" onclick="desactivar(' . htmlspecialchars($reg['idusuario']) . ')"><i class="bi bi-x-lg"></i></button>';
            } else {
                // INACTIVO: Mostrar (lapiz) y Activar (check)
                $botones .= '<button class="btn btn-health-teal-success btn-sm shadow-sm" onclick="mostrar(' . htmlspecialchars($reg['idusuario']) . ')"><i class="bi bi-pencil-fill"></i></button>';
                // NOTA: Se eliminó el espacio entre las concatenaciones.
                $botones .= '<button class="btn btn-health-marine-primary btn-sm shadow-sm" onclick="activar(' . htmlspecialchars($reg['idusuario']) . ')"><i class="bi bi-check2"></i></button>';
            }

            // Botón de Eliminar (basurero) siempre visible
            // NOTA: Se eliminó el espacio al inicio.
            $botones .= '<button class="btn btn-health-deep-secondary btn-sm shadow-sm" onclick="eliminar(' . htmlspecialchars($reg['idusuario']) . ')"><i class="bi bi-trash"></i></button>';

            $botones .= '</div>'; // Cerrar el btn-group

            /*
            // Lógica para los botones
            $botones = '';
            if ($reg['condicion'] == 1) {
                $botones .= '<button class="btn btn-warning btn-xs" onclick="mostrar(' . htmlspecialchars($reg['idusuario']) . ')"><i class="bi bi-pencil"></i></button>';
                $botones .= ' <button class="btn btn-danger btn-xs" onclick="desactivar(' . htmlspecialchars($reg['idusuario']) . ')"><i class="bi bi-x"></i></button>';
            } else {
                $botones .= '<button class=" btn btn-warning btn-xs" onclick="mostrar(' . htmlspecialchars($reg['idusuario']) . ')"><i class="bi bi-pencil"></i></button>';
                $botones .= ' <button class="btn btn-primary btn-xs" onclick="activar(' . htmlspecialchars($reg['idusuario']) . ')"><i class="bi bi-check"></i></button>';
            }
            $botones .= ' <button class="btn btn-dark btn-xs" onclick="eliminar(' . htmlspecialchars($reg['idusuario']) . ')"><i class="bi bi-trash"></i></button>';
*/
            // Estilo para la imagen
         // ----------------------------------------------------------------------
// 🔥 CÓDIGO DE LA IMAGEN CORREGIDO 🔥
// Se corrigieron los errores de sintaxis en onerror y onclick.
// ----------------------------------------------------------------------
$imagenHtml = (isset($reg['imagen']) && $reg['imagen'] != '')
    ? '<img 
        src="../../files/imgProfile/' . htmlspecialchars($reg['imagen']) . '" 
        onerror="this.src=\'../../files/imgProfile/huevo.jpg\';" 
        onclick="verImagenGrande(\'../../files/imgProfile/' . htmlspecialchars($reg['imagen']) . '\')" 
        style="
            height: 50px;
            width: 50px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #3498db;
            display: block;
            margin: 0 auto;
            cursor: pointer;
        "
        alt="imagen Usuario"
      />'
    : '<img src="../../files/imgProfile/huevo.jpg" 
        style=" 
            height: 50px; 
            width: 50px; 
            object-fit: cover; 
            border-radius: 50%; 
            display: block; 
            margin: 0 auto;"
        alt="imagen placeholder"
      />';





            // Los índices deben coincidir con la tabla HTML
            $datos[] = [
                '0' => $botones,
                '1' => htmlspecialchars($reg['nombre']),
                '2' => htmlspecialchars($reg['apellido']),
                '3' => htmlspecialchars($reg['fech_Nac']),
                '4' => htmlspecialchars($reg['rut']),
                '5' => htmlspecialchars($reg['direccion']),
                '6' => htmlspecialchars($reg['telefono']),
                '7' => htmlspecialchars($reg['email']),
                '8' => htmlspecialchars($reg['login']),
                '9' => $imagenHtml,
                '10' => htmlspecialchars($reg['descripcion']),
                '11' => htmlspecialchars($reg['fechSubida']),
                '12' => htmlspecialchars($reg['creadopor']),
                '13' => ($reg['condicion'] == 1) ? '<span class="label bg-green">Activo</span>' : '<span class="label bg-red">Inactivo</span>'
            ];
        }

        // 3. Devolver la respuesta en formato JSON para DataTables (Modo Cliente)
        $output = [
            'sEcho' => $draw,
            // En modo Cliente, el total de registros es igual al total a mostrar
            'iTotalRecords' => $totalRegistros,
            'iTotalDisplayRecords' => $totalRegistros,
            'aaData' => $datos  // Todos los datos para que DataTables haga el trabajo
        ];

        echo json_encode($output);
        exit();
    }

    /**
     * Procesa la solicitud POST para guardar un nuevo registro de usuario o actualizar uno existente.
     * ... (el resto de los métodos se mantienen igual) ...
     */
    public function guardar()
    {
        // Headers para indicar que la respuesta será JSON
        header('Content-Type: application/json');

        // 1. Validar y Sanitizar la Entrada
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);  // Método no permitido
            echo json_encode(['status' => false, 'mensaje' => 'Método de solicitud no válido.']);
            exit();  // Detener ejecución
        }

        // --- Simulación de manejo de imagen ---
        $imagen_nombre = isset($_POST['imagenactual']) ? $_POST['imagenactual'] : 'placeholder.png';

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            // ... (Lógica de subida de imagen)
            $temp_name = $_FILES['imagen']['tmp_name'];
            $file_extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $new_file_name = round(microtime(true)) . '.' . $file_extension;
            // Asegúrate de que esta ruta de subida sea correcta en tu entorno.
            $upload_dir = __DIR__ . '/../../public/files/usuarios/';

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            if (move_uploaded_file($temp_name, $upload_dir . $new_file_name)) {
                $imagen_nombre = $new_file_name;
            } else {
                error_log('Fallo al mover archivo subido para usuario.');
            }
        }
        // -------------------------------------

        // Simulación de sanitización (debes implementar una función más robusta en el Core)
        $limpiar = function ($data) {
            return filter_var($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        };

        $idUsuario = isset($_POST['idusuario']) ? intval($_POST['idusuario']) : 0;
        $nombre = isset($_POST['nombre']) ? $limpiar($_POST['nombre']) : '';
        $tipoDoc = isset($_POST['tipoDoc']) ? $limpiar($_POST['tipoDoc']) : '';
        $numDoc = isset($_POST['numDoc']) ? filter_var($_POST['numDoc'], FILTER_SANITIZE_NUMBER_INT) : '';
        $direccion = isset($_POST['direccion']) ? $limpiar($_POST['direccion']) : '';
        $telefono = isset($_POST['telefono']) ? filter_var($_POST['telefono'], FILTER_SANITIZE_NUMBER_INT) : '';
        $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
        $login = isset($_POST['login']) ? $limpiar($_POST['login']) : '';
        $clave = isset($_POST['clave']) ? $_POST['clave'] : '';
        $imagen = $imagen_nombre;
        $descripcion = isset($_POST['descripcion']) ? $limpiar($_POST['descripcion']) : '';

        // Simulación de valores del sistema
        date_default_timezone_set('America/Santiago');
        $fechasubida = date('Y-m-d H:i:s');
        $subidopor = 1;

        // 2. Validación de Campos Requeridos
        if (empty($nombre) || empty($tipoDoc) || empty($numDoc) || empty($email) || empty($login) || ($idUsuario == 0 && empty($clave))) {
            http_response_code(400);  // Bad Request
            echo json_encode(['status' => false, 'mensaje' => 'Faltan campos obligatorios (Nombre, Tipo/Número Doc, Email, Login, y Clave para nuevo registro).']);
            exit();  // Detener ejecución
        }

        // 3. Lógica de Guardar o Actualizar
        $rspta = false;

        if ($idUsuario == 0) {
            // NUEVO REGISTRO: Insertar
            $rspta = $this->usuarioDAO->insertarRegistro(
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
                $subidopor
            );
            $mensaje = $rspta ? 'Usuario registrado correctamente.' : 'Error al registrar el usuario.';
        } else {
            // EDICIÓN DE REGISTRO: Actualizar
            $rspta = $this->usuarioDAO->editarRegistro(
                $idUsuario,
                $nombre,
                $tipoDoc,
                $numDoc,
                $direccion,
                $telefono,
                $email,
                $imagen,
                $descripcion
            );
            $mensaje = $rspta ? 'Usuario actualizado correctamente.' : 'Error al actualizar el usuario.';
        }

        // 4. Devolver la respuesta al cliente
        if ($rspta) {
            echo json_encode(['status' => true, 'mensaje' => $mensaje]);
            exit();  // CRÍTICO: Detener la ejecución
        } else {
            http_response_code(500);  // Error interno del servidor/DAO
            echo json_encode(['status' => false, 'mensaje' => $mensaje . ' Por favor, revise los logs.']);
            exit();  // CRÍTICO: Detener la ejecución
        }
    }

    /**
     * Obtiene y devuelve en formato JSON los datos de un usuario por su ID.
     * @return void
     */
    public function mostrar()
    {
        // Headers para indicar que la respuesta será JSON
        header('Content-Type: application/json');

        $idUsuario = isset($_POST['idusuario']) ? intval($_POST['idusuario']) : 0;

        if ($idUsuario <= 0) {
            http_response_code(400);
            echo json_encode(['status' => false, 'mensaje' => 'ID de usuario no proporcionado o inválido.']);
            exit();  // Detener ejecución
        }

        // Llamar al DAO
        $usuario = $this->usuarioDAO->obtenerUsuarioPorId($idUsuario);

        if ($usuario === false) {
            // Error de conexión o DAO falló
            http_response_code(500);
            echo json_encode(['status' => false, 'mensaje' => 'Error al acceder a la base de datos.']);
            exit();  // Detener ejecución
        } elseif (empty($usuario)) {
            // Usuario no encontrado (array vacío)
            http_response_code(404);
            echo json_encode(['status' => false, 'mensaje' => 'Usuario no encontrado.']);
            exit();  // Detener ejecución
        } else {
            // Éxito
            echo json_encode(['status' => true, 'data' => $usuario]);
            exit();  // CRÍTICO: Detener la ejecución
        }
    }

    /**
     * Desactiva lógicamente un usuario.
     * @return void
     */
    public function desactivar()
    {
        header('Content-Type: application/json');

        $idUsuario = isset($_POST['idusuario']) ? intval($_POST['idusuario']) : 0;

        if ($idUsuario <= 0) {
            http_response_code(400);
            echo json_encode(['status' => false, 'mensaje' => 'ID de usuario no proporcionado o inválido.']);
            exit();  // Detener ejecución
        }

        $rspta = $this->usuarioDAO->desactivarRegistro($idUsuario);

        if ($rspta) {
            // ENVIAR UN OBJETO: {"status":true}
            echo json_encode(['status' => true]);
            exit();
        } else {
            http_response_code(500);
            // ENVIAR UN OBJETO: {"status":false}
            echo json_encode(['status' => false]);
            exit();
        }

        /*        if ($rspta) {
            echo json_encode(['status' => true, 'mensaje' => $mensaje]);
            exit();  // CRÍTICO: Detener la ejecución
        } else {
            http_response_code(500);
            echo json_encode(['status' => false, 'mensaje' => $mensaje . ' Revise los logs.']);
            exit();  // CRÍTICO: Detener la ejecución
        }*/
    }

    /**
     * Activa lógicamente un usuario.
     * @return void
     */
    public function activar()
    {
        header('Content-Type: application/json');

        $idUsuario = isset($_POST['idusuario']) ? intval($_POST['idusuario']) : 0;

        if ($idUsuario <= 0) {
            http_response_code(400);
            echo json_encode(['status' => false, 'mensaje' => 'ID de usuario no proporcionado o inválido.']);
            exit();  // Detener ejecución
        }

        $rspta = $this->usuarioDAO->activarRegistro($idUsuario);

        $mensaje = $rspta ? 'Usuario activado correctamente.' : 'Error al activar el usuario.';

        if ($rspta) {
            echo json_encode(['status' => true, 'mensaje' => $mensaje]);
            exit();  // CRÍTICO: Detener la ejecución
        } else {
            http_response_code(500);
            echo json_encode(['status' => false, 'mensaje' => $mensaje . ' Revise los logs.']);
            exit();  // CRÍTICO: Detener la ejecución
        }
    }

    /**
     * Elimina físicamente un usuario de la base de datos (DELETE).
     * @return void
     */
    public function eliminar()
    {
        header('Content-Type: application/json');

        $idUsuario = isset($_POST['idusuario']) ? intval($_POST['idusuario']) : 0;

        if ($idUsuario <= 0) {
            http_response_code(400);
            echo json_encode(['status' => false, 'mensaje' => 'ID de usuario no proporcionado o inválido.']);
            exit();  // Detener ejecución
        }

        $rspta = $this->usuarioDAO->eliminaUsuario($idUsuario);

        $mensaje = $rspta ? 'Usuario eliminado permanentemente.' : 'Error al intentar eliminar el usuario.';

        if ($rspta) {
            echo json_encode(['status' => true, 'mensaje' => $mensaje]);
            exit();  // CRÍTICO: Detener la ejecución
        } else {
            http_response_code(500);
            echo json_encode(['status' => false, 'mensaje' => $mensaje . ' Revise los logs de la base de datos.']);
            exit();  // CRÍTICO: Detener la ejecución
        }
    }
}

// --- Lógica de Ejecución (Punto de entrada para las peticiones AJAX) ---

// Determina la operación solicitada (op)
$op = isset($_GET['op']) ? $_GET['op'] : '';

// Crea la instancia del controlador usando el nombre de clase completo (FQCN)
$controller = new \App\Controllers\UsuarioController();

// Ejecuta el método basado en la operación
switch ($op) {
    case 'guardar':
        $controller->guardar();
        break;
    case 'mostrar':
        $controller->mostrar();
        break;
    case 'listar':
        $controller->listar();
        break;
    case 'desactivar':
        $controller->desactivar();
        break;
    case 'activar':
        $controller->activar();
        break;
    case 'eliminar':
        $controller->eliminar();
        break;
    default:
        // Si no se especifica 'op', no se hace nada
        break;
}
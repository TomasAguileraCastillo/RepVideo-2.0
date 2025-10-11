 <?php

namespace App\Controllers;

use App\Models\UsuarioDAO;

/**
 * Clase UsuarioController
 * * Responsable de manejar las peticiones relacionadas con la gestión de usuarios.
 * Interactúa con la capa del Modelo (UsuarioDAO) para obtener/modificar datos
 * y con la capa de Vista para renderizar el resultado.
 */
class UsuarioController
{
    // Atribitos
    private $usuarioDAO;

    // Constructor
    public function __construct()
    {
        // Inicializa el Modelo DAO al crear una instancia del Controlador
        $this->usuarioDAO = new UsuarioDAO();
    }

    /**
     * Muestra la página principal de gestión de usuarios, listando todos los registros.
     * * Esta es la función principal que el router llamará al acceder a la ruta de usuarios.
     *
     * @return void
     */
    public function index()
    {
        // 1. Obtener los datos del modelo (DAO)
        $usuarios = $this->usuarioDAO->listarusuarios();

        // 2. Comprobar si hubo un error en la base de datos (retorno 'false' del DAO)
        if ($usuarios === false) {
            // Manejo de error en el Controlador: Si el DAO falló,
            // establecemos un mensaje de error para la vista.
            $data = [
                'error' => 'No se pudieron cargar los datos de la base de datos.'
            ];

            // Nota: Aquí se llamaría a la vista con el mensaje de error.
            // Por ejemplo: $this->render('usuario/index', $data);

            echo '<h1>Error al cargar usuarios. Revise logs.</h1>';
            return;
        }

        // 3. Preparar los datos para la vista
        $data = [
            'usuarios' => $usuarios,
            'titulo' => 'Gestión de Usuarios'
        ];

        // 4. Renderizar la vista (en un entorno MVC real, aquí llamarías a un método
        // de tu clase BaseController o sistema de vistas, por ejemplo:
        // $this->view('usuario/index', $data);

        // --- Placeholder de la Vista (temporal) ---
        echo '<h1>' . htmlspecialchars($data['titulo']) . '</h1>';

        if (empty($data['usuarios'])) {
            echo '<p>No hay usuarios registrados.</p>';
        } else {
            echo "<table border='1'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Condición</th>
                        </tr>
                    </thead>
                    <tbody>";
            foreach ($data['usuarios'] as $usuario) {
                echo '<tr>
                        <td>' . htmlspecialchars($usuario['idusuario']) . '</td>
                        <td>' . htmlspecialchars($usuario['nombre']) . '</td>
                        <td>' . htmlspecialchars($usuario['email']) . '</td>
                        <td>' . ($usuario['condicion'] == 1 ? 'Activo' : 'Inactivo') . '</td>
                      </tr>';
            }
            echo '</tbody></table>';
        }
        // ------------------------------------------
    }

    // Aquí irían otros métodos como:
    // public function crear() {} // Muestra el formulario de creación
    // public function guardar() {} // Procesa el POST del formulario de creación
    // public function editar($id) {} // Muestra el formulario de edición
    // public function actualizar() {} // Procesa el POST del formulario de edición
    // public function activar($id) {}
    // public function desactivar($id) {}
}
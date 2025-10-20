<?php

ob_start();
if (strlen(session_id()) < 1) {
    session_start(); //Validamos si existe o no la sesión
}
//session_start();
//archivo ajax
//llama al modelo de la clase para creacion de objeto
require_once "../modelo/Video.php";
//creacion de objeto instanciando la clase, objeto de la clase Personal
$videos = new Videos();
//obtencion de datos desde formulario
//validacion exixtencia de variable por metodo post, condicional de una linea
$idvideo        = isset($_POST["idvideo"]) ? limpiarCadena($_POST["idvideo"]) : "";
$archivoVideo   = isset($_POST["archivoVideo"]) ? limpiarCadena($_POST["archivoVideo"]) : "";
$descripcion    = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]) : "";
//$curso          = isset($_POST["curso"     ]) ? limpiarCadena($_POST[ "curso"   ]) : "";
$comentario     = isset($_POST["comen"]) ? limpiarCadena($_POST["comen"]) : "";
$video          = isset($_POST["arch "]) ? limpiarCadena($_POST["arch"]) : "";
$idcurso        = isset($_POST["idcurso"]) ? limpiarCadena($_POST["idcurso"]) : "";
date_default_timezone_set('America/Santiago');
$fechaActual = date('Y-m-d');
//estructura switch para evaluacion de los valores consultados al modelo
switch ($_GET["op"]) {
    case 'guardaryeditar':
        //* ************************************************************************************************************
        /********************************************************** */
        //validacion de objeto imagen
        $file_name = $_FILES['archivoVideo']['name'];
        $file_temp = $_FILES['archivoVideo']['tmp_name'];
        $file_size = $_FILES['archivoVideo']['size'];
        $subidopor = $_SESSION['nombre'];

        if ($file_size < 1000000000) {
            $file = explode('.', $file_name);
            $end = end($file);
            $allowed_ext = ['wmv', 'mov', 'mp4', 'mkv'];
            if (in_array($end, $allowed_ext)) {
                $nombreArch = date("Ymd") . time();
                $ubicacion = '../videos/' . $nombreArch . "." . $end;

                if (move_uploaded_file($file_temp, $ubicacion)) {
                    $pesoArchivo = $videos->tamanoArchivo($ubicacion);

                    if (empty($idvideos)) {
                        $condicion = 1;
                        $rspta = $videos->insertar(
                            $nombreArch,
                            $descripcion,
                            $fechaActual,
                            $subidopor,
                            $idcurso,
                            $pesoArchivo,
                            $ubicacion,
                            $condicion
                        );
                        //$rspta = $vide->insertar($idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen);
                        echo $rspta ? "Video registrado" : "Video no se pudo registrar";
                    } else {
                        $rspta = $videos->editar(
                            $nombreArch,
                            $descripcion,
                            $fechaActual,
                            $subidopor,
                            $idcurso,
                            $pesoArchivo,
                            $ubicacion,
                            $condicion
                        );
                        echo $rspta ? "Video actualizado" : "Video no se pudo actualizar";
                    }
                }
            } else {
                echo "<script>alert('Formato de Video Equivocado')</script>";
                echo "<script>window.location = '../index.php'</script>";
            }
        } else {
            echo "<script>alert('El Archivo es muy grande para subir')</script>";
            echo "<script>window.location = '../index.php'</script>";
        }
        /*
        if (!file_exists($_FILES['video']['tmp_name']) || !is_uploaded_file($_FILES['video']['tmp_name'])) {
            $video = $_POST["imagenactual"];
        } else {
            $ext = explode(".", $_FILES["video"]["name"]);

            if ($_FILES['video']['type'] == "video/mp4" || $_FILES['video']['type'] == "video/mvk") {
                $videos = round(microtime(true)) . '.' . end($ext);
                move_uploaded_file($_FILES["video"]["tmp_name"], "../files/videos_cursos/" . $videos);
            }
        }*/
        /********************************************************** */
        break;

    /************************************************************************************************************** */
    case 'desactivar':
        $rspta = $videos->desactivar($idvideo);
        echo $rspta ? "Registro Desactivado " : "Registro no se puede Desactivar";
        break;
    /************************************************************************************************************** */
    case 'activar':

        $rspta = $videos->activar($idvideo);
        echo $rspta ? "Registro Activado" : "Registro no se puede Activar";
        break;
    /************************************************************************************************************** */
    case 'mostrar':

        if (ob_get_level() > 0) {
            ob_clean(); // Limpia el búfer. Usar ob_end_clean() también es válido.
        }
        // Usamos intval() para asegurar que el dato sea SÓLO un número entero.
        if (!isset($_POST['idvideo'])) {
            echo json_encode(["error" => "ID de video no existe."]);
            exit();
        }
        $idvideo_limpio = intval($idvideo);
        // 2. Ejecutar el método con la variable limpia.
        $rspta = $videos->mostrar($idvideo_limpio);
        // 3. Devolver los datos.
        echo json_encode($rspta);
        exit();

        /*
        $rspta = $videos->mostrar($idvideos); /*Codificar el resultado utilizando json

        echo json_encode($rspta);
        break;**/
    /************************************************************************************************************** */
    case 'listar':

        $rspta = $videos->listar();
        //se declara un array
        $data = [];

        while ($reg = $rspta->fetch_object()) {
            $data[] = [
                /*por posiscion de registro segun el indice  */
                //validacion con estructura condicional de una sola linea
                "0" => ($reg->condicion_video) ? '
                        <button class="btn btn-primary btn-sm " onclick="mostrar(' . $reg->id_video . ')"> 
                            <i class="bi bi-pencil-square "></i>
                        </button> ' .
                    '   <button class="btn btn-danger btn-sm " onclick="desactivar(' . $reg->id_video . ')"> 
                            <i class="bi bi-x-square"></i>
                        </button> ' :
                    '   <button class="btn btn-primary btn-sm " onclick="mostrar(' . $reg->id_video . ')"> 
                            <i class="bi bi-pencil-square "></i>
                        </button> ' .
                    '    <button class="btn btn-success btn-sm " onclick="activar(' . $reg->id_video . ')"> 
                           <i class="bi bi-check-lg"></i>
                        </button>',
                "1" => $reg->codigoCurso, //curso_video,
                "2" => $reg->nombreCurso,
                "3" => $reg->descripcion_video,
                "4" => $reg->fechaSub_video,
                "5" => $reg->subidopor_video,
                "6" => //"<a href='../vistas/Reproductor/reproductor.php?saludo=".$reg->ubicacion_video." ' target='_blank'>link</a>
                "<div class='input-group'>
                            <a  class='btn btn-outline-secondary border-0' 
                                href='../vistas/Reproductor/video_player/video_player.php?videos=" . $reg->ubicacion_video . " ' 
                                target='_blank' role='button'> 
                                <i class='bi bi-lightning-charge-fill'></i>
                            </a> 
                            <!--<input type='hidden' name='target1' id='target1' value='../vistas/Reproductor/reproductor.php?saludo=" . $reg->ubicacion_video . " '>
                                <button type='button' class='btn btn-outline-secondary border-0' onclick='copiar()'>
                                    <i class='bi bi-clipboard'></i>
                                </button>-->
                        </div>",
                /*link Usuario*/    //"4"=>"<a href='../vistas/Reproductor/reproductor.php?saludo=".$reg->ubicacion_video." ' target='_blank'>link</a>",
                /*link Admin*/
                "7" => //"<a class='btn btn-outline-secondary border-0' href='../files/".$reg->ubicacion_video."' target='_blank' rel='noopener noreferrer' >link</a>",
                "<div class='input-group'>
                        <a  class='btn btn-outline-secondary border-0' 
                            href='../files/" . $reg->ubicacion_video . "'  
                            target='_blank' role='button'>
                                <i class='bi bi-lightning-charge-fill'></i>
                        </a>
                </div>",
                "8" => $reg->nombre_video,
                "9" => $reg->peso_video,
                "10" => "<video width='100%' height='35'>
                            <source src='../files/" . $reg->ubicacion_video . "'>
                        </video>",
                "11" => ($reg->condicion_video) ?
                    '<span class="badge bg-success" >Activo</span>' :
                    '<span class="badge bg-danger">Inactivo</span>',
                "12" => ($reg->condicion_video) ?
                    '<span class="badge bg-success" >Activo</span>' :
                    '<span class="badge bg-danger">Inactivo</span>'
            ];
        }
        $results = [
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        ];
        echo json_encode($results);
        break;
        /*************************************************************** */
    case "seleccionCurso":
        require_once "../modelo/Video.php";
        echo '<option value="" selected disabled hidden>  </option>';

        $rspta = $videos->selectHtml(); // instanciacion de clase


        while ($reg = $rspta->fetch_object()) {
            $valor_opcion = htmlspecialchars($reg->id_cursos);
            $texto_opcion = htmlspecialchars($reg->codigo_cursos . '     |    ' . $reg->descripcion_cursos);
            echo '<option value="' . $valor_opcion . '">' . $texto_opcion . '</option>';
        }
        break;

    /************************************************************************************************************ */
    case 'verificar':
        $loginac = $_POST['loginac'];
        $claveac = $_POST['claveac'];

        //Hash SHA256 en la contraseña
        $clavehash = hash("SHA256", $claveac);

        $rspta = $videos->verifica($loginac, $clavehash);

        $fetch = $rspta->fetch_object();

        if (isset($fetch)) {
            $_SESSION['nombre'] = $fetch->loginac;
            $_SESSION['idusuario'] = $fetch->idusuario;
            $_SESSION['nombre'] = $fetch->nombre;
            $_SESSION['imagen'] = $fetch->imagen;
            $_SESSION['login'] = $fetch->login;
        }
        echo json_encode($fetch);
        break;
    case 'listarCursoVideo':

        $rspta = $videos->listarCursos();
        //se declara un arra y
        $data = [];

        while ($reg = $rspta->fetch_object()) {
            $data[] = [
                /*por posiscion de registro segun el indice  */
                //validacion con estructura condicional de una sola linea
                "0" => ($reg->condicion_cursos) ? '
                        <button class="btn btn-primary btn-sm " onclick="elimina(' . $reg->id_cursos . ')"> 
                            <i class="bi bi-trash"></i>
                        </button> ' .
                    '   <button class="btn btn-danger btn-sm " onclick="desactivar(' . $reg->id_cursos . ')"> 
                            <i class="fa fa-close"></i> 
                        </button> ' :
                    '   <button class="btn btn-primary btn-sm " onclick="elimina(' . $reg->id_cursos . ')"> 
                            <i class="bi bi-trash"></i>
                        </button> ' .
                    '    <button class="btn btn-success btn-sm " onclick="activar(' . $reg->id_cursos . ')"> 
                           <i class="bi bi-check-lg"></i>
                        </button>',
                "1" => $reg->codigo_cursos, //curso_video,
                "2" => $reg->descripcion_cursos,
                "3" => $reg->fechaCreado_cursos,
                "4" => $reg->creadopor_cursos,
                "5" => ($reg->condicion_cursos) ?
                    '<span class="badge bg-success" >Activo</span>' :
                    '<span class="badge bg-danger">Inactivo</span>',
                /*"6" => ($reg->condicion_cursos) ?
                    '<span class="badge bg-success" >Activo</span>' :
                    '<span class="badge bg-danger">Inactivo</span>'*/
            ];
        }
        $results = [
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        ];
        echo json_encode($results);
        break;
    /************************************************************************************************************** */
    case 'eliminarCurso':
        $rspta = $videos->eliminarCurso($idvideo);
        echo $rspta ? "Registro eliminado " : "Registro no se puede eliminar";
        break;
        /************************************************************************************************************** */
}
ob_end_flush();
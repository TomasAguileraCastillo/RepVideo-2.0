<?php

ob_start();
if (strlen(session_id()) < 1) {
    session_start();//Validamos si existe o no la sesión
}
//session_start();
//archivo ajax
//llama al modelo de la clase para creacion de objeto
require_once "../modelo/Video.php";

//creacion de objeto instanciando la clase, objeto de la clase Personal
$videos = new Videos();


//obtencion de datos desde formulario
//validacion exixtencia de variable por metodo post, condicional de una linea
$idvideos       = isset($_POST["idvideo"   ]) ? limpiarCadena($_POST[ "idvideo" ]) : "";
$nombre         = isset($_POST["nomb"      ]) ? limpiarCadena($_POST[ "nomb"    ]) : "";
$descripcion    = isset($_POST["desc"      ]) ? limpiarCadena($_POST[ "desc"    ]) : "";
$curso          = isset($_POST["curso"     ]) ? limpiarCadena($_POST[ "curso"   ]) : "";
$comentario     = isset($_POST["comen"     ]) ? limpiarCadena($_POST[ "comen"   ]) : "";
$video          = isset($_POST["arch "     ]) ? limpiarCadena($_POST[ "arch"    ]) : "";
$idcurso        = isset($_POST["idcurso"   ]) ? limpiarCadena($_POST[ "idcurso" ]) : "";


//estructura switch para evaluacion de los valores consultados al modelo
switch ($_GET["op"]) {

    case 'guardaryeditar':
        //* ************************************************************************************************************
        /********************************************************** */
        //validacion de objeto imagen
        if (!file_exists($_FILES['video']['tmp_name']) || !is_uploaded_file($_FILES['video']['tmp_name'])) {
            $video = $_POST["imagenactual"];
        } else {
            $ext = explode(".", $_FILES["video"]["name"]);

            if ($_FILES['video']['type'] == "video/mp4" || $_FILES['video']['type'] == "video/mvk") {
                $videos = round(microtime(true)) . '.' . end($ext);
                move_uploaded_file($_FILES["video"]["tmp_name"], "../files/videos_cursos/" . $videos);
            }
        }
        /********************************************************** */


        if (empty($idvideos)) {
            $rspta = $vide->insertar($idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen);
            echo $rspta ? "Artículo registrado" : "Artículo no se pudo registrar";
        } else {
            $rspta = $articulo->editar($idarticulo, $idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen);
            echo $rspta ? "Artículo actualizado" : "Artículo no se pudo actualizar";
        }
        break;

        /************************************************************************************************************** */
    case 'desactivar':
        $rspta = $videos->desactivar($idvideos);
        echo $rspta ? "Registro Desactivado " : "Registro no se puede Desactivar";
        break;
        /************************************************************************************************************** */
    case 'activar':

        $rspta = $videos->activar($idvideos);
        echo $rspta ? "Registro Activado" : "Registro no se puede Activar";
        break;
        /************************************************************************************************************** */
    case 'mostrar':

        $rspta = $videos->mostrar($idvideos); /*Codificar el resultado utilizando json*/

        echo json_encode($rspta);
        break;
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
                        <button class="btn btn-primary " onclick="mostrar('.$reg->id_video.')"> 
                            <i class="bi bi-pencil-square "></i>
                        </button> ' .
                '   <button class="btn btn-danger " onclick="desactivar('.$reg->id_video.')"> 
                            <i class="fa fa-close"></i> 
                        </button> ' :
                '   <button class="btn btn-primary " onclick="mostrar('.$reg->id_video.')"> 
                            <i class="bi bi-pencil-square "></i>
                        </button> ' .
                '    <button class="btn btn-success " onclick="activar('.$reg->id_video.')"> 
                           <i class="bi bi-check-lg"></i>
                        </button>',
                "1" => $reg->nombre_video,
                "2" => $reg->descripcion_video,
                "3" => $reg->fechaSub_video,
                "4" => $reg->subidopor_video,
                "5" => $reg->curso_video,
                "6" => $reg->peso_video,
                "7" => //"<a href='../vistas/Reproductor/reproductor.php?saludo=".$reg->ubicacion_video." ' target='_blank'>link</a>
                     "<div class='input-group'>
                            <a class='btn btn-outline-secondary border-0' href='../vistas/Reproductor/video_player/video_player.php?videos=".$reg->ubicacion_video." ' target='_blank' role='button'> 
                                <i class='bi bi-lightning-charge-fill'></i>
                            </a> 
                            <!--<input type='hidden' name='target1' id='target1' value='../vistas/Reproductor/reproductor.php?saludo=".$reg->ubicacion_video." '>
                                <button type='button' class='btn btn-outline-secondary border-0' onclick='copiar()'>
                                    <i class='bi bi-clipboard'></i>
                                </button>-->
                        </div>",
/*link Usuario*/    //"4"=>"<a href='../vistas/Reproductor/reproductor.php?saludo=".$reg->ubicacion_video." ' target='_blank'>link</a>",
/*link Admin*/      "8" => //"<a class='btn btn-outline-secondary border-0' href='../files/".$reg->ubicacion_video."' target='_blank' rel='noopener noreferrer' >link</a>",
                "<div class='input-group'>
                        <a class='btn btn-outline-secondary border-0' href='../files/".$reg->ubicacion_video."'  target='_blank' role='button'>
                            <i class='bi bi-lightning-charge-fill'></i>
                        </a>
                    </div>",
                "9" => "  <video width='100%' height='35'>
                                <source src='../files/".$reg->ubicacion_video."'>
                            </video>",
                "10" => ($reg->condicion_video) ?
                '<span class="badge bg-success" >Activo</span>' :
                '<span class="badge bg-danger">Inactivo</span>',
                "11" => ($reg->condicion_video) ?
                '<span class="badge bg-success" >Activo</span>' :
                '<span class="badge bg-danger">Inactivo</span>'
            ];
        }
        $results = [
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data];
        echo json_encode($results);
        break;
    case "seleccionCurso":
        //require_once "../modelos/Video.php";
        $rspta = $videos->select(); // instanciacion de clase
        while ($reg = $rspta->fetch_object()) {
            echo '<option value='. $reg->id_cursos . '>' .$reg->nombre_cursos.' </option>';
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
}
ob_end_flush();
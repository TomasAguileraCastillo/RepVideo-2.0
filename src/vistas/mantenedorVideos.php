<?php
// ==========================================================
// 1. LÓGICA DE SESIÓN Y AUTENTICACIÓN (Prioridad)
// ==========================================================

// Iniciar y gestionar el buffer (útil para errores y encabezados)
ob_start();
session_start();

// Comprobación de seguridad: Si el usuario NO está autenticado, redirigir y detener la ejecución.
if (!isset($_SESSION["nombre"]) || $_SESSION["nombre"] == null) {
  // Mejor práctica: usar la ruta correcta a tu página de login
  header("Location: ../index.php");
  // CRÍTICO: Detener la ejecución para evitar que se muestre el contenido
  exit();
}

// 2. INCLUIR EL ENCABEZADO (Usamos require_once para dependencia crítica)
require_once 'header.php';

// ==========================================================
?>
<style>
img.tamaño {
    max-width: 30%;
    max-height: 30%;
}

/*
                * ESTILO PARA HACER LA TABLA MÁS COMPACTA Y SIMILAR A EXCEL
                * Sin amontonar contenido largo.
                */
.tabla-compacta-excel {
    /* 1. Reducir el tamaño de la fuente en toda la tabla */
    font-size: 11px;
}

/* 2. Ajuste CRÍTICO: Asegurar que el contenido largo se ajuste (wrap) */
.tabla-compacta-excel td,
.tabla-compacta-excel th {
    /* Permite el ajuste de línea para que el contenido no se corte */
    white-space: normal !important;
    word-wrap: break-word;

    /* Reducir el padding (relleno) vertical y horizontalmente */
    padding: 0.3rem 0.5rem !important;

    /* Opcional: Centrar el texto verticalmente para mejor lectura */
    vertical-align: top;
}

/* 3. Ajustar el encabezado si es necesario */
.tabla-compacta-excel thead th {
    font-size: 11px;
    /* Mantiene la fuente pequeña en los títulos de columna */
}
</style>
<script>
function copiar() {
    var origen = document.getElementById("target1");
    var copyFrom = document.createElement("textarea");
    copyFrom.textContent = origen.value;
    var body = document.getElementsByTagName("body")[0];
    body.appendChild(copyFrom);
    copyFrom.select();
    document.execCommand("copy");
    body.removeChild(copyFrom);
    //destino.focus();
    //document.execCommand('paste');
}
</script>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Administracion de Videos para Cursos</h1>
            </div>
            <div class="card-body">
                <div class="box-header with-border">
                    <button class="btn btn-primary" id="btnagregar" onclick="mostrarform(true)">
                        <i class="fa fa-plus-square"></i> Agregar Video
                    </button>
                </div>
                <br />
                <!--inicio de Formulario-->
                <div class="panel-body" id="formularioregistros">
                    <form class="row g-3" name="formulario" id="formulario" method="POST" enctype="multipart/form-data">
                        <span id="mensaje">Ingrese los datos correspondientes para el registro adecuado del
                            video.</span>
                        <div class="form-floating">
                            <input type="hidden" class="form-control" name="idvideo" id="idvideo" />
                        </div>
                        <div class="form-floating col-md-6">
                            <select class="form-select" id="idcurso" name="idcurso" data-live-search="true"
                                required></select>
                            <label>Curso al que Pertenece</label>
                        </div>
                        <!--<div class="form-floating col-md-6">
                            <input type="text" class="form-control" id="nomb" name="nomb" autocomplete="off"
                                placeholder="Nombre" onkeypress="return OnLchr(event)" required>
                            <label>Nombre del Video</label>
                        </div>-->
                        <div class="form-floating col-md-6">
                            <input type="text" class="form-control" id="descripcion" name="descripcion"
                                autocomplete="off" placeholder="Descripcion" onkeypress="return OnLchr(event)"
                                required />
                            <label>Descripción del Video</label>
                        </div>
                        <div class="col-md-6">
                            <div>
                                Archivo
                                <input type="file" class="form-control tamaño" name="archivoVideo" id="archivoVideo"
                                    accept="video/*" required />
                            </div>
                        </div>
                        <!--<div class=" form-floating col-md-12">
                            <textarea type="text" class="form-control" id="comen" name="come "
                                onkeypress="return OnLchr(event)" onblur="clen(comentarios)" aria-label="With textarea"
                                placeholder="Comentarios" autocomplete="off" required></textarea>
                            <label>Comentarios</label>
                        </div>-->
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary col-md-2" type="submit" id="btnGuardar" name="btnGuardar">
                                <i class="fa fa-save"></i> Guardar
                            </button>
                            <button class="btn btn-danger col-md-2" onclick="cancelarform()" type="button">
                                <i class="fa fa-arrow-circle-left"></i> Cancelar
                            </button>
                        </div>
                    </form>
                </div>
                <!--fin form-->
                <br />
                <div class="panel-body table-responsive" id="listadoregistros">
                    <table class="table caption-top table-hover table-striped table-sm tabla-compacta-excel"
                        id="tbllistado">
                        <caption>
                            <b>Listado de Videos Registrados</b>
                        </caption>
                        <thead class="table-light">
                            <th style="width: 12%">Opciones</th>
                            <th style="width: 13%">Codigo</th>
                            <th style="width: 15%">Curso</th>
                            <th style="width: 10%">Descripción</th>
                            <th style="width: 8%">Fecha subido</th>
                            <th style="width: 8%">Subido por:</th>
                            <th style="width: 7%">Link Usuario</th>
                            <th style="width: 7%">Link Admin</th>
                            <th style="width: 5%">Nombre</th>
                            <th style="width: 10%">Tamaño</th>
                            <th style="width: 5%">Imagen</th>
                            <th style="width: 3%">Condición</th>
                        </thead>
                        <tbody class="table-group-divider"></tbody>
                        <tfoot></tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
// 4. INCLUIR EL PIE DE PÁGINA
require_once 'footer.php';
// Liberación del buffer al final del archivo
ob_end_flush();
?>
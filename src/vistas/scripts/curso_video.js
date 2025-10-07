var tabla;
new DataTable("#tbllistadoCursos", { responsive: true });
/*********************************************************************************** */
//Función que se ejecuta al inicio
function init() {
  mostrarform(false);
  listar();
  $("#formulario").on("submit", function (e) {
    guardaryeditar(e);
  });

  //  $("#imagenmuestra").hide();

  $.post("../ajax/video.php?op=seleccionCurso", function (r) {
    $("#idcurso").html(r);
    //$("#idcurso").selectpicker("refresh");
  });
}
/********************************************************************************** */
//Función limpiar
function limpiar() {
  // Campos de Texto/Select (Todos deben limpiarse)
  $("#descripcion").val("");
  $("#idcurso").val(""); // Limpiar el select del curso
  // Campo de Archivo (Usamos .val("") para vaciar el input type="file")
  $("#archivoVideo").val("");
  // Campo Oculto
  $("#idvideo").val("");

  // Opcional: etiqueta <video> o <img> de vista previa, limpia el src
  //$("#vista_previa_video").attr("src", "");
}

/*//Función limpiar
function limpiar() {
  $("#descripcion").val("");
  $("#idcurso").val("");
  $("#archivoVideo").attr("src", "");
  $("#idvideo").val("");
}*/

/********************************************************************************** */
//Función mostrar formulario
function mostrarform(flag) {
  limpiar();
  if (flag) {
    $("#listadoregistros").hide();
    $("#formularioregistros").show();
    $("#btnGuardar").prop("disabled", false);
    $("#btnagregar").hide();
  } else {
    $("#listadoregistros").show();
    $("#formularioregistros").hide();
    $("#btnagregar").show();
  }
}

/********************************************************************************** */

//Función cancelarform
function cancelarform() {
  limpiar();
  mostrarform(false);
}

/********************************************************************************** */

//Función Listar
function listar() {
  tabla = $("#tbllistadoCursos")
    .dataTable({
      lengthMenu: [5, 10, 25, 75, 100], //mostramos el menú de registros
      aProcessing: true, //Activamos el procesamiento del datatables
      aServerSide: true, //Paginación y filtrado realizados por el servidor
      dom: "<Bl<f>rtip>", //Definimos los elementos del control de tabla
      buttons: ["copyHtml5", "excelHtml5", "csvHtml5", "pdfHtml5"],
      ajax: {
        url: "../ajax/video.php?op=listarCursoVideo",
        type: "get",
        dataType: "json",
        error: function (e) {
          console.log(e.responseText);
        },
      },
      language: {
        processing: "Trabajando ...",
        search: "Buscar&nbsp;:",
        info: "Mostrando Pagina _PAGE_ of _PAGES_",
        infoEmpty: "No hay Registros Disponibles",
        infoFiltered: "(filtered from _MAX_ total records)",
        lengthMenu: "Mostrar _MENU_ Registros",
        zeroRecords: "No Existen Registros para Mostrar",
        paginate: {
          first: "Primera",
          previous: "Anterior",
          next: "Proxima",
          last: "Ultima",
        },
        buttons: {
          copyTitle: "Tabla Copiada",
          copySuccess: {
            _: "%d líneas copiadas",
            1: "1 línea copiada",
          },
        },
      },
      bDestroy: true,
      iDisplayLength: 5, //Paginación
      order: [[0, "desc"]], //Ordenar (columna,orden)
    })
    .DataTable();
}

/********************************************************************************** */
//Función para guardar o editar

function guardaryeditar(e) {
  e.preventDefault(); //No se activará la acción predeterminada del evento
  $("#btnGuardar").prop("disabled", true);
  var formData = new FormData($("#formulario")[0]);
  $.ajax({
    url: "../ajax/video.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (datos) {
      bootbox.alert(datos);
      mostrarform(false);
      tabla.ajax.reload();
    },
  });
  limpiar();
}
/********************************************************************************** */

function mostrar(idvideo) {
  // 1. Corregir el bug (usar idvideo, no idvideos)
  var dataToSend = { idvideo: idvideo };
  // 2. jQuery se encarga de serializar y parsear la respuesta
  $.post(
    "../ajax/video.php?op=mostrar",
    dataToSend,
    function (data) {
      // Manejo de error si el servidor devuelve un objeto con la propiedad 'error'
      if (data && data.error) {
        console.error("Error del servidor: ", data.error);
        alert("No se pudieron cargar los datos.");
        mostrarform(false);
        return;
      }

      mostrarform(true);

      // 3. Cargamos los campos
      $("#idvideo").val(data.id_video);
      // REVISAR: Usar el nombre de columna de la base de datos
      $("#idcurso").val(data.curso_video);
      $("#descripcion").val(data.descripcion_video);
    },
    "json" // OPTIMIZACIÓN: Le decimos a jQuery que espere JSON
  ).fail(function (jqXHR, textStatus, errorThrown) {
    // Mejor manejo de fallos de conexión o parsing
    alert("Fallo al comunicarse con el servidor: " + textStatus);
    mostrarform(false);
  });
}

/*function mostrar(idvideo) {
  $.post(
    "../ajax/video.php?op=mostrar",
    { idvideo: idvideos },
    function (data, status) {
      data = JSON.parse(data);
      mostrarform(true);

      $("#idcurso").val(data.id_cursos);
      $("#nomb").val(data.nombre_videos);
      $("#desc").val(data.descripcion_videos);
      $("#comen").val(data.comentario_videos);
      $("#idcurso").val(data.curso_videos);
      $("#video").val(data.ubicacion_videos);
      $("#idvideo").val(data.id_videos);
    }
  );
}*/

/*********************************************************************************** */
//Función para desactivar registros
function desactivar(idadesactivar) {
  bootbox.confirm("¿Está Seguro de desactivar el Registro?", function (result) {
    if (result) {
      $.post(
        "../ajax/video.php?op=desactivar",
        { idvideo: idadesactivar },
        function (e) {
          bootbox.alert(e); //muestra el mensaje del metodo ajax
          tabla.ajax.reload();
        }
      );
    }
  });
}
/********************************************************************************** */
//Función para activar registros
function activar(idadesactivar) {
  bootbox.confirm("¿Está Seguro de activar el Registro?", function (result) {
    if (result) {
      $.post(
        "../ajax/video.php?op=activar",
        { idvideo: idadesactivar },
        function (e) {
          bootbox.alert(e);
          tabla.ajax.reload();
        }
      );
    }
  });
}
/*********************************************************************************** */
//Función para eliminar cursos
function elimina(idadesactivar) {
  bootbox.confirm("¿Está Seguro de Eliminar el Curso?", function (result) {
    if (result) {
      $.post(
        "../ajax/video.php?op=eliminarCurso",
        { idvideo: idadesactivar },
        function (e) {
          bootbox.alert(e); //muestra el mensaje del metodo ajax
          tabla.ajax.reload();
        }
      );
    }
  });
}

init();

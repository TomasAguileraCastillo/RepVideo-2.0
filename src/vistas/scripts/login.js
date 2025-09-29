$('#frmAcceso').on('submit',function(e)
{
    e.preventDefault();
    loginAcceso=$('#loginacc').val();
    claveAcceso=$('#claveacc').val();

        $.post("../ajax/video.php?op=verificar",
            {loginac : loginAcceso , claveac : claveAcceso}, 
            function(data)
            {
                if(data!="null")
                    {
                        $(location).attr("href","../vistas/dashboard.php");
                    }
                    else
                        {

                        /*
                        bootbox.alert({
                        size: 'small',
                        title: 'Error de Acceso',
                        message: 'Usuario y/o Password incorrectos ',    
                        callback: function() {  $("#loginacc").val("");
                                                $("#claveacc").val("");}});
                                                */

                        bootbox.alert("Usuario y/o Password incorrectos");
                        }
            }
        );
})
 
 
$("#frmAccesos").on('submit',function(e){
	e.preventDefault();


    

    let loginac=$("#loginacc").val();
    let claveac=$("#claveacc").val();
    

    $.post("../../controllers/ajax/video.php?op=verificar", {loginac : loginac , claveac : claveac }, 
        
    function(data){
        if (data!="null")
        {
         
            $(location).attr("href","../../views/mantenedor/mantenedor.php");           
                  
        }else{

           bootbox.alert({
                size: 'small',
                title: 'Error de Acceso',
                message: 'Usuario y/o Password incorrectos ',    
                callback: function() {  $("#loginacc").val("");
                                        $("#claveacc").val("");}
  
                });
        }
    });
});
 

 
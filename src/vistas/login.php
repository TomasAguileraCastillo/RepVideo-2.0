<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="../../src/Public/img/icons/favicon.png">
    <title>Acceso UDOP - HEP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="../Public/css/stylelogin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
</head>
<body>
  <div class="container-fluid  ">
                       <div class="row g-2 align-items-center vh-100">
                         <div class="col-md-6 animate__animated animate__fadeInLeft">
                          <div class="col-md text-center">
                            <div class="img-fluid " >
                              <img src="../../src/Public/img/imglog1.JPG" width="60% " height="60%" alt="...">
                            </div>
                            <h1 > Unos clics más para entrar a su cuenta</h1>
                            <h4> Gestione todos tus trabajos UDOP desde aquí</h4>
                          </div>
                        </div>
                         <div class="col-md-6 animate__animated animate__fadeInRight border-start  ">
                          <div class="col-md  text-center  ">
                              <h1 class="text-dark">Bienvenido a Sistema UDOP</h1>
                              <br><br><br>
                               <div class="row justify-content-around align-items-center">
                               <div class="col-auto">

                                <form class="g-3 needs-validation " method="post" id="frmAcceso"  >
                                         <div  class=" col-md  ">
                                          <div class="input-group p-2">
                                            <span class="input-group-text" id="inputGroupPrepend">
                                              <i class="bi bi-person-square "></i>
                                            </span>
                                            <input  type="text" 
                                                    class="form-control" 
                                                    id="loginacc" 
                                                    name="loginacc" 
                                                    placeholder="Usuario" 
                                                    autocomplete="off" required>
                                          </div>
                                        </div>
                                        <br>
                                        <div class=" col-md " >
                                          <div class="input-group p-2">
                                            <span class="input-group-text" id="inputGroupPrepend">
                                              <i class="bi bi-key-fill"></i>
                                            </span>
                                            <input  type="password" 
                                                    class="form-control" 
                                                    id="claveacc" 
                                                    name="claveacc" 
                                                    placeholder="Password" 
                                                    autocomplete="off" required>
                                          </div>
                                        </div>
                                        <br>
                                        <div >
                                          <input type="submit" class="btn btn-primary" value="Acceder" id="acceder" name = "acceder">
                                        </div>
                                  </form>
                                  
                                </div>
                              </div>
                          </div>
                        </div>
                      </div>
               
   
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha512-U6K1YLIFUWcvuw5ucmMtT9HH4t0uz3M366qrF5y4vnyH6dgDzndlcGvH/Lz5k8NFh80SN95aJ5rqGZEdaQZ7ZQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/6.0.0/bootbox.min.js" integrity="sha512-oVbWSv2O4y1UzvExJMHaHcaib4wsBMS5tEP3/YkMP6GmkwRJAa79Jwsv+Y/w7w2Vb/98/Xhvck10LyJweB8Jsw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script type="text/javascript" src="scripts/login.js"></script> 
</body>
</html>
 <!doctype html>
 <html lang="en">
    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />
 
        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
        <link rel="stylesheet" href="style.css" />
    </head>
 
    <body>
        <header>
            <!-- place navbar here -->
        </header>
        <main>
            >
    <div id="app">
      <!--Header-->
      <div id="header">
        <h3><i class="fas fa-sliders-h"></i> </h3>

        <!--File element container-->
        <div id="fileElemContainer">
          <input    type="file"
                    id="fileElem"
                    webkitdirectory
                    multiple
                    accept="video/*"
                    class="visually-hidden"
          />
          <label for="fileElem" id="fileElemLabel">Select some files</label>
        </div>
      </div>

      <!--Videos container-->
      <div id="videosContainer">
        <!--current video container-->
        <div id="currentVideoContainer">
          <video src="../../../files/videos_cursos/PROA_2025_Mod_2.2._Antimicrobiano_Según_Sitio_De_Infección1A.mp4" id="video"></video>

          <div id="dc">
            <!--duration bars-->
            <div id="duration">
              <span id="durationBarContainer">
                <span id="durationBar"></span>
              </span>
              <span id="durationCount">00:00</span>
            </div>

            <!--*********************controls*******************-->
            <div id="controlsContainer">
              <!--playbtn-->
              <div id="playBtnContainer">
                <button id="play" disabled>
                  <i class="fas fa-play fa-lg" id="playIcon"></i>
                </button>
              </div>

              <!--prev next stop button-->
              <div id="btnsContainer">
                <button id="prev">
                  <i class="fas fa-step-backward fa-lg"></i>
                </button>
                <button id="stop"><i class="fas fa-stop fa-lg"></i></button>
                <button id="next">
                  <i class="fas fa-step-forward fa-lg"></i>
                </button>
              </div>

              <!--volume-->
              <div id="volumeContainer">
                <i class="fas fa-volume-up fa-lg" id="volumeIcon"></i>
                <span id="volumeRange">
                  <span id="volume"></span>
                </span>
              </div>
            </div>
          </div>
        </div>

        <!--all video container-->
        <!--<div id="allVideosContainer">
          
               <div class="video">
                        <video  src="./MY VIDEOS/Command Line Crash Course For Beginners - Terminal Commands.mp4"></video>
                        <p>HTML5 Canvas API Crash Course.mp4</p>
                        <hr />
                    </div>
                    <div class="video">
                        <video  src="./MY VIDEOS/E-Commerce App Landing Hero Section by UGEM on Dribbble.mp4"></video>
                        <p>HTML5 Canvas API Crash Course.mp4</p>
                        <hr />
                    </div>
                    <div class="video">
                        <video  src="./MY VIDEOS/Git & GitHub Crash Course For Beginners.mp4"></video>
                        <p>HTML5 Canvas API Crash Course.mp4</p>
                        <hr />
                    </div>
                    <div class="video">
                        <video src="./MY VIDEOS/intro.mp4"></video>
                        <p>HTML5 Canvas API Crash Course.mp4</p>
                        <hr />
                    </div> 
            
        </div>-->
      </div>
    </div>

   


        </main>
        <footer>
            <!-- place footer here -->
        </footer>
        <!-- Bootstrap JavaScript Libraries -->
       
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>
 
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>

         <script src="script.js"></script>
    </body>
 </html>
 
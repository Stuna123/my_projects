<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Burger</title>

    <link rel="stylesheet" type="text/css" media="screen" href="style2.css">
    <script src="script.js"></script>
</head>

<body>
        <header>
                <nav class="nav">
                    <ul> 
                        <li><a href="index2.php"> PRODUITS </a></li>
                        <li><a href="apropos.html"> A PROPOS </a></li>
                        <li><a href="FAQ.html"> FAQ </a></li>
                        <li><a href="admin/inscription.php"> INSCRIPTION</a></li>
                        <li><a href="admin/login.php"> CONNEXION</a></li>
                    </ul>
                </nav>
        </header>

           <div class="wrapper">
                    <div class="container">
                        <div class="mySlides">
                            <div class="numbertext"></div>
                            <img src="big.png" style="width:100%">
                        </div>

                        <div class="mySlides">
                            <div class="numbertext"></div>
                            <img src="big2.png" style="width:100%">
                        </div>

                        <div class="mySlides">
                            <div class="numbertext"></div>
                            <img src="big3.png" style="width:100%">
                        </div>

                        <div class="mySlides">
                            <div class="numbertext"></div>
                            <img src="big4.png" style="width:100%">
                        </div>

                        <div class="mySlides">
                            <div class="numbertext"></div>
                            <img src="big5.png" style="width:100%">
                        </div>

                        <div class="mySlides">
                            <div class="numbertext"></div>
                            <img src="big6.png" style="width:100%">
                        </div>

                      <a class="prev" onclick="plusSlides(-1)">❮</a>
                      <a class="next" onclick="plusSlides(1)">❯</a>

                      <div class="caption-container">
                        <p></p>
                      </div>

                      <div class="row" style="padding-top:10px">
                        <div class="column">
                          <img class="demo cursor" src="big.png" alt="Erreur" style="width:100%" onclick="currentSlide(1)" >
                        </div>
                        <div class="column">
                          <img class="demo cursor" src="big2.png" alt="Erreur" style="width:100%" onclick="currentSlide(2)" >
                        </div>
                        <div class="column">
                            <img class="demo cursor" src="big3.png" alt="Erreur" style="width:100%" onclick="currentSlide(3)" >
                        </div> 
                        <div class="column">
                            <img class="demo cursor" src="big4.png" alt="Erreur" style="width:100%" onclick="currentSlide(4)" >
                        </div>
                        <div class="column">
                            <img class="demo cursor" src="big5.png" alt="Erreur" style="width:100%" onclick="currentSlide(5)" >
                        </div>
                        <div class="column">
                            <img class="demo cursor" src="big6.png" alt="Erreur" style="width:100%" onclick="currentSlide(6)" >
                        </div>
                      </div>
                </div>
           </div>

        
<!--<footer class="section footer-classic context-dark bg-image" style="background: #2d3246;">-->
<!--
        <div class="container">
          <div class="row row-30">
            <div class="col-md-4 col-xl-5">
              <div class="pr-xl-4"><a class="brand" href="index.html"><img class="brand-logo-light" src="images/agency/logo-inverse-140x37.png" alt="" width="140" height="37" srcset="images/agency/logo-retina-inverse-280x74.png 2x"></a>
                <p><em>"A chaque bouchée une nouvelle saveur!"</em></p>
                 Rights
                <p class="rights"><span>©  </span><span class="copyright-year">2019</span><span>. </span><span>All Rights Reserved.</span></p>
              </div>
            </div>
            <div class="col-md-4">
              <h5>Contacts</h5>
              <dl class="contact-list">
                <dt>Address:</dt>
                <dd>ESIEA, 38 Rue Des Docteurs et Calmette et Guérin, 53000 Laval </dd>
              </dl>
              <dl class="contact-list">
                <dt>email:</dt>
                <dd><a href="mailto:#">burger@esiea.et.fr</a></dd>
              </dl>
              <dl class="contact-list">
                <dt>phones:</dt>
                <dd><a href="tel:#">+91 7568543012</a> 
                </dd>
              </dl>
            </div>
          </div>
        </div>
-->
    

                <footer class="section footer-classic context-dark bg-image">
                    <div id="copyright" style="padding-top: 230px;">
                        <center>
                            <strong>
                                Copyright © 2019, <span> ESIEA Laval </span> <br>All Rights    Reserved.
                            </strong>
                        </center>
                    </div>
                </footer>

        
    
<!--
        <footer class="section footer-classic context-dark bg-image">
            <h2>
                <span class="orange"> 
                    <span class="glyphicon glyphicon-cutlery"></span>
                </span> 
                    A chaque bouchée une nouvelle saveur !
                <span class="orange"> 
                    <span class="glyphicon glyphicon-cutlery"></span> 
                </span>
            </h2>
                <div class="copyright">
                    <p>Phone : +91 7568543012 </p>
                    Copyright © 2019, <span> ESIEA Laval </span> <br>All Rights Reserved.
                </div>
            
        </footer>
-->
    
<!--
        <script>
        var slideIndex = 1;
        showSlides(slideIndex);
        
        function plusSlides(n) {
          showSlides(slideIndex += n);
        }
        
        function currentSlide(n) {
          showSlides(slideIndex = n);
        }
        
        function showSlides(n) {
          var i;
          var slides = document.getElementsByClassName("mySlides");
          var dots = document.getElementsByClassName("demo");
          var captionText = document.getElementById("caption");
          if (n > slides.length) {slideIndex = 1}
          if (n < 1) {slideIndex = slides.length}
          for (i = 0; i < slides.length; i++) {
              slides[i].style.display = "none";
          }
          for (i = 0; i < dots.length; i++) {
              dots[i].className = dots[i].className.replace(" active", "");
          }
          slides[slideIndex-1].style.display = "block";
          dots[slideIndex-1].className += " active";
          captionText.innerHTML = dots[slideIndex-1].alt;
        }
        </script>
-->
<!--    </footer>-->

</body>
</html>
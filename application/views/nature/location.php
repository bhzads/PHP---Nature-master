<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// add image gallery
// display images in gallery
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <title>Adopt A Tree</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <script src="https://storage.googleapis.com/code.getmdl.io/1.0.0/material.min.js"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="/css/mijnstyle.css"/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    </head>
    <body>
        <!-- ====sidebar====== -->
        <div class="w3-sidebar w3-bar-block w3-green w3-animate-left"  style="width:390px" id="mySidebar">
            <!-- sidebar Banner buttons --><br>
            <div id="sidbarbaner">
                <a class="lang"><?= anchor("/pageloader/change/english","EN"); ?> | <?= anchor("/pageloader/change/dutch","NL"); ?></a>
                <button class="btn" onclick="w3_close()" ><i class="fa fa-close"></i></button>
                <div class="dropdown" style="margin-top: -16px;">
                   <button class="btn" type="button" data-toggle="dropdown" > <i class="material-icons">share</i>
                   <span class="caret"></span></button>
                   <ul class="dropdown-menu"style="text-align: center;" >
                       <a  href="http://www.facebook.com/sharer.php?u=http://www.adopteerregenwoud.nl"><i class="fa fa-facebook-official" style="font-size:35px;color:#3B5998;"></i></a>
                       <a  href="http://twitter.com/share?text=AdoptTheForest&url=http://www.adopteerregenwoud.nl"><i class="fa fa-twitter" style="font-size:35px;color:#1DA1F2;"></i></a>
                       <a  href="http://www.linkedin.com/shareArticle?mini=true&url=http://www.adopteerregenwoud.nl"><i class="fa fa-linkedin" style="font-size:35px;color:#0077B5;"></i></a>
                       <a  href="mailto:?subject=Adopt The Forest&body=Check out this site http://www.adopteerregenwoud.nl"><i class="fa fa-envelope" style="font-size:35px;color:#DB4437;"></i></a>
                   </ul>
                </div>
                <!-- - Back button -->
                <button class="btn" onclick="javascript:window.history.go(-1);"><i class="material-icons">arrow_back</i></button>
                <!-- <button class="btn" href="/ "><i class="material-icons">arrow_back</i></button> -->
                <!-- ==================================== -->
            </div>
            <!-- sidcontaint -->
            <div class="sidcontaint">
                <!-- show images -->
                <?php if(!empty($photos)) { ?>
                <div class="photos-carusel">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="<?= $photos[0]['link']; ?>" alt="First slide">
                            </div>
                            <?php for ($i=1; $i < count($photos); $i++) {
                                ?>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="<?= $photos[$i]['link']; ?>" alt="Second slide">
                                </div> <?php
                            } ?>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
                <?php } ?>
                <h5 style="margin-top: 10px;margin-bottom: 5%;"><?= $coordinates['latitude'] . "°N / " . $coordinates['longitude'] . "°W"?></h5>

                <p class=loc style="text-align:left;padding-left:25px;"><b><?= $this->lang->line('owner_location') ?></p></b>
                <h5 style="text-align:left;padding-left:25px;"> <?= $this->session->userdata['username'] ?></h5>
                <div>
                    <div style="display: inline-block;padding-right: 100px;">
                        <p class=loc><b><?= $this->lang->line('meter_location') ?></b></p>
                        <h6> <?= $coordinates['sqm'] . "m" ?><sup>2</sup></h6>
                    </div>
                    <div style="display: inline-block;">
                        <p class=loc><b><?= $this->lang->line('adopted_location') ?></b></p>
                        <h6> <?= $sum['sum'] . "m" ?><sup>2</sup></h6>
                    </div>
                </div>
                <a href ="http://www.adopteerregenwoud.nl" class="logo"><img src="/img/logo.png" alt="Nature Logo"></a>
            </div>
        </div>
        <!-- page containt with map -->
        <div class="mapcontainer">
            <div id="map"></div>
            <button class="btn" onclick="w3_open()">&#9776;</button>
        </div>
        <script>
            // closing side bar
            function w3_open() {
                document.getElementById("mySidebar").style.display = "block";
            }
            function w3_close() {
                document.getElementById("mySidebar").style.display = "none";
            }
        </script>

        <!-- google map  -->
        <script>
            // loads map
            var map;
            function initMap() {
                var lat = <?php echo $coordinates['latitude']; ?>;
                var long = -<?php echo $coordinates['longitude']; ?>;
                map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: lat, lng: long},
                    zoom: 12.5,
                    mapTypeId: 'satellite',
                    mapTypeControl: false
                });
                // draws square for addopted territory
                var rectangle = new google.maps.Rectangle({
                    map: map,
                    bounds: new google.maps.LatLngBounds(
                    new google.maps.LatLng(10.105276, -83.383103),
                    new google.maps.LatLng(10.007095, -83.250103)
                    ),
                    fillcolor:"darkgreen",
                    strokeColor: "darkgreen"
                });
                // draws square for certain location
                var rectangle = new google.maps.Rectangle({
                    map: map,
                    bounds: new google.maps.LatLngBounds(
                    new google.maps.LatLng(lat, long),
                    new google.maps.LatLng((lat - 0.005), (long + 0.005))
                    ),
                    fillcolor:"white",
                    strokeColor: "white"
                });
            }
        </script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6nhveJrJGLPkqa6gpSgbQVyssBWM63oc&callback=initMap"
        async defer></script>
    </body>
</html>

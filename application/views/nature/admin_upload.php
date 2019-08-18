<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ob_start();
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
        <link rel="stylesheet" href="https://storage.googleapis.com/code.getmdl.io/1.0.0/material.indigo-pink.min.css">
        <script src="https://storage.googleapis.com/code.getmdl.io/1.0.0/material.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="/css/mijnstyle.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body>
        <!-- ====sidebar====== -->
        <div class="w3-sidebar w3-bar-block w3-green w3-animate-left"  style="width:390px" id="mySidebar">
            <!-- sidebar Banner buttons --><br>
            <div id="sidbarbaner">
                <button class="btn" onclick="w3_close()" ><i class="fa fa-close"></i></button>
                <a href="/admin/logout">Log Out</a>
            </div>
            <!-- sidcontaint -->
            <div class="sidcontaint">
                <h3>Hello, Admin! </h3>
                <?php echo form_open_multipart('admin/upload', 'id="admin"');
                    if(!empty($this->session->flashdata('image_error'))) { ?>
                        <h5> <?= $this->session->flashdata('image_error') ?> </h5> <?php ;
                    }?>
                    <input type="file" name="image" value="image" class="image">
                    <input type="text" class="form-control admin" placeholder="Latitude" name="latitude">
                    <input type="text" class="form-control admin" placeholder="longitude" name="longitude">
                    <button type="submit" class="btn btn-default btnadmin" value="upload">Upload</button>
                </form>

                <a href ="http://www.adopteerregenwoud.nl" class="logo"><img src="/img/Logo.png" alt="Nature Logo"></a>
            </div>
        </div>
        <!-- page containt with map -->
        <div class="mapcontainer">
            <div id="map"></div>
            <button class="btn" onclick="w3_open()">&#9776;</button>

        </div>
        <script>
        function w3_open() {
            document.getElementById("mySidebar").style.display = "block";
        }
        function w3_close() {
            document.getElementById("mySidebar").style.display = "none";
        }
        </script>

        <!-- google map  -->
        <script>
                var map;

                // load the map
                function initMap() {
                map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: 10.037054, lng: -83.350640},
                    zoom: 12.5,
                    mapTypeId: 'satellite',
                    mapTypeControl: false
                });

                // draws rectangle for addopted territory
                var rectangle = new google.maps.Rectangle({
                map: map,
                bounds: new google.maps.LatLngBounds(
                  new google.maps.LatLng(10.105276, -83.383103),
                  new google.maps.LatLng(10.007095, -83.250103)
                ),
                fillcolor:"darkgreen",
                strokeColor: "darkgreen"
                });
                google.maps.event.addListener (rectangle, "bounds_changed", function (){
                document.getElementByid("info").innerHTML = rectangle.getBounds();
                })

                // show locations
                <?php foreach ($coordinates as $coordinate) { ?>
                    var lat = <?php echo $coordinate['latitude']; ?>;
                    var long = -<?php echo $coordinate['longitude']; ?>;
                    var myLatLng = {lat: lat, lng: long};
                    var marker = new google.maps.Marker({

                        position: myLatLng,
                        map: map,
                        title: lat + ', ' + long
                    });
                <?php } ?>
                }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6nhveJrJGLPkqa6gpSgbQVyssBWM63oc&callback=initMap"
        async defer></script>
    </body>
</html>

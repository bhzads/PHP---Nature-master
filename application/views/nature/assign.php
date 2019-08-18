<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// search fiel
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/css/mijnstyle.css"/>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body>
        <!-- ====sidebar====== -->
        <div class="w3-sidebar w3-bar-block w3-green w3-animate-left"  style="width:390px" id="mySidebar">
            <!-- sidebar Banner buttons --><br>
            <div id="sidbarbaner">
                <a class=""><?= anchor("/pageloader/change/english","EN"); ?> | <?= anchor("/pageloader/change/dutch","NL"); ?></a>
                <button class="btn" onclick="w3_close()" ><i class="fa fa-close"></i></button>
            </div>
            <!-- sidcontaint -->
            <div class="sidcontaint">
                <h4><?= $this->lang->line('hello_personal') . " " . $this->session->userdata('username') ?></h4>
                <p><?= $this->lang->line('goodjob_user') ?></p>
                <br>
                <form class="form-inline" action="/assign/write" method="post">
                    <button type="submit" class="btn btn-default " style="width:350px;"><?= $this->lang->line('assign_location') ?></button>
                </form>
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
            // load map
            var coord;
            var markers = [];
            function initMap() {
                map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: 10.037054, lng: -83.350640},
                    zoom: 12.5,
                    mapTypeId: 'satellite',
                    mapTypeControl: false
                });
                var rectangle = new google.maps.Rectangle({
                    map: map,
                    bounds: new google.maps.LatLngBounds(
                    new google.maps.LatLng(10.105276, -83.383103),
                    new google.maps.LatLng(10.007095, -83.250103)
                    ),
                    fillcolor:"darkgreen",
                    strokeColor: "darkgreen"
                });
                var marker = new google.maps.Rectangle({
                    map: map,
                    bounds: new google.maps.LatLngBounds(
                    new google.maps.LatLng(10.007095, -83.350103),
                    new google.maps.LatLng(09.990000, -83.250103)
                    ),
                    fillcolor:"white",
                    strokeColor: "white",
                    title: 'Chose Me'
                });
                var longitude;
                var latitude;
                google.maps.event.addListener(marker, "click", function (event) {
                    //Event.preventDefault();
                    var latitudeTemp = event.latLng.lat();
                    latitude = latitudeTemp.toFixed(4);
                    var longitudeTemp = -1 * event.latLng.lng();
                    longitude = longitudeTemp.toFixed(4);
                    console.log(latitude + ', ' + longitude);
                    // Sets the map on all markers in the array.
                      function setMapOnAll(map) {
                        for (var i = 0; i < markers.length; i++) {
                          markers[i].setMap(map);
                        }
                      }
                      // Removes the markers from the map, but keeps them in the array.
                      function clearMarkers() {
                        setMapOnAll(null);
                      }
                      // Deletes all markers in the array by removing references to them.
                      function deleteMarkers() {
                        clearMarkers();
                        markers = [];
                      }
                    $.ajax({
                        method: "POST",
                        url: "/assign/savelocation",
                        data: { lat: latitude, long: longitude },
                        error: function() {
                            alert('Something is wrong');
                        },
                        success: function() {
                            // location.reload();
                            deleteMarkers();
                            var marker = new google.maps.Rectangle({
                                map: map,
                                bounds: new google.maps.LatLngBounds(
                                new google.maps.LatLng(latitude, -longitude),
                                new google.maps.LatLng(latitude - 0.005, -longitude + 0.005)
                                ),
                                fillcolor:"red",
                                strokeColor: "red"
                            });
                            markers.push(marker);
                        }
                    })
                });
            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6nhveJrJGLPkqa6gpSgbQVyssBWM63oc&callback=initMap"
        async defer></script>
    </body>
</html>

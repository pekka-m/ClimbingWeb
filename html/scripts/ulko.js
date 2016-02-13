// Note: This example requires that you consent to location sharing when
// prompted by your browser. If you see a blank space instead of the map, this
// is probably because you have denied permission for location sharing.
var map;

function initialize() {
    var mapOptions = {
        zoom: 12
    };
    map = new google.maps.Map(document.getElementById('map-canvas'),
        mapOptions);
    
    // Create the DIV to hold the control and
    // call the CenterControl() constructor passing
    // in this DIV.
    var centerControlDiv = document.createElement('div');
    var centerControl = new CenterControl(centerControlDiv, map);
    
    centerControlDiv.index = 1;
    map.controls[google.maps.ControlPosition.BOTTOM_LEFT].push(centerControlDiv);
    
    // Try HTML5 geolocation
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var pos = new google.maps.LatLng(position.coords.latitude,
                position.coords.longitude);
            
            GeoMarker = new GeolocationMarker();

            GeoMarker.setMap(map);
            GeoMarker.setCircleOptions({
                fillColor: '#808080'
            });

            google.maps.event.addListenerOnce(GeoMarker, 'position_changed', function () {
                map.setCenter(this.getPosition());
                map.fitBounds(this.getBounds());
            });

            google.maps.event.addListener(GeoMarker, 'geolocation_error', function (e) {
                alert('There was an error obtaining your position. Message: ' + e.message);
            });

            map.setCenter(pos);
        }, function () {
            handleNoGeolocation(true);
        });
    } else {
        // Browser doesn't support Geolocation
        handleNoGeolocation(false);
    }
    
    google.maps.event.addListener(map, 'idle', function() {
        var latupperbound, latlowerbound;
        var longupperbound, longlowerbound;
        var bounds = map.getBounds();
        var NE = bounds.getNorthEast();
        var SW = bounds.getSouthWest();
        console.log ("NE: ", NE.A, NE.F);
        console.log("SW: ", SW.A, SW.F);
        console.log("vasen yläkulma:", SW.A, NE.F);
        console.log("oikea alakulma:", NE.A, SW.F);
        console.log("latit väliltä: ", SW.A , "ja" , NE.A);
        console.log("longitude väliltä:", NE.F, "ja", SW.F);
        /*
        SELECT *
        FROM Crag
        WHERE
        (Lat between SW.A and NE.A)
        AND
        (Lon BETWEEN SW.F and NE.F);
        
        */
        // need to make a new function with marker array
        // to load all the markers to the viewport area
           jQuery.ajax({
            type: "POST",
            url: "ajax/getcrags.php",
            data: ({
                latupperbound: latupperbound,
                latlowerbound: latlowerbound,
                longuppperbound: longupperbound,
                longlowerbound: longlowerbound
            }),
            success: function (response) {
                console.log("fetched all the crags that are visible on the viewport");
                console.log(response.CragId);
            }
        });
    });
   
}

function handleNoGeolocation(errorFlag) {
    if (errorFlag) {
        var content = 'Error: The Geolocation service failed.';
    } else {
        var content = 'Error: Your browser doesn\'t support geolocation.';
    }

    var options = {
        map: map,
        position: new google.maps.LatLng(60, 105),
        content: content
    };

    map.setCenter(options.position);
}

function CenterControl(controlDiv, map) {

    // Set CSS for the control border
    var controlUI = document.createElement('div');
    controlUI.style.backgroundColor = '#fff';
    controlUI.style.border = '2px solid #fff';
    controlUI.style.borderRadius = '3px';
    controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
    controlUI.style.cursor = 'pointer';
    controlUI.style.marginBottom = '22px';
    controlUI.style.textAlign = 'center';
    controlUI.title = 'Click to recenter the map';
    controlDiv.appendChild(controlUI);

    // Set CSS for the control interior
    var controlText = document.createElement('div');
    controlText.style.color = 'rgb(25,25,25)';
    controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
    controlText.style.fontSize = '12px';
    controlText.style.lineHeight = '25px';
    controlText.style.paddingLeft = '5px';
    controlText.style.paddingRight = '5px';
    controlText.innerHTML = 'current<br>location';
    controlUI.appendChild(controlText);

    // Setup the click event listeners: simply set the map to
    // Chicago
    google.maps.event.addDomListener(controlUI, 'click', function () {
        map.panTo(GeoMarker.getPosition())
    });
}



function moveToLocation(lat, lng) {
    var center = new google.maps.LatLng(lat, lng);
    map.panTo(center);
}

function addMarkerToCragLocation(lat, lng) {
    var latlon = new google.maps.LatLng(lat, lng);
    var marker = new google.maps.Marker({
        position: latlon,
        map: map,
        animation: google.maps.Animation.DROP
    });
}

var Latitude;
var longitude;

jQuery(document).ready(function () {
    // when any option from crag list is selected
    jQuery("select[name='crag']").change(function () {
        // get the selected option value of crag
        var optionValue = jQuery("select[name='crag']").val();
        
        $.getJSON("ajax/routecoord.php", {
                crag: optionValue
            })
            .done(function (json) {
                Latitude = json.Lat;
                longitude = json.Lon;
                moveToLocation(Latitude, longitude);
                addMarkerToCragLocation(Latitude, longitude);
            })
            .fail(function (jqxhr, textStatus, error) {
                var err = textStatus + ", " + error;
                console.log("Request Failed: " + err);
            })
            /**
             * pass crag id through POST method
             * the 'status' parameter is only a dummy parameter (just to show how                  multiple parameters can be passed)
             * if we get response from data.php, then only the cityAjax div is displayed
             * otherwise the cityAjax div remains hidden
             * 'beforeSend' is used to display loader image
             * 'complete' is used to hide the loader image
             */
        jQuery.ajax({
            type: "POST",
            url: "ajax/routedata.php",
            data: ({
                crag: optionValue
            }),
            success: function (response) {
                jQuery("#route").html(response);
            }
        });
    });
});

google.maps.event.addDomListener(window, 'load', initialize);
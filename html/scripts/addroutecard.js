    var RouteName;
    var RouteGrade;
    $(document).on('change', '#crags', function () {
        var cragValue = jQuery("select[name='crag']").val();
        if (cragValue == 0) {
            $('#kortti').html(" ");
        }
             $.getJSON("ajax/cragdata_ajax.php", {
                    crag: cragValue
                })
                .done(function (json) {
                    cragName = json.Name;
                    cragId = json.CragId;
                    //for future
                    //Cragdesc = json.Description;
                    $('#kortti').html("<span id='routename'> " + cragName + "</span><div id='image'><img src='"+json.Image+"' alt='crag image'></div>"); 
        })
    });

    $(document).on('change', '#reitti', function () {
        var routeValue = jQuery("select[name='route']").val();

        if (routeValue == 0) {
            $('#kortti').html(" ");
        } else {
            $.getJSON("ajax/routedata_ajax.php", {
                    route: routeValue
                })
                .done(function (json) {
                    RouteName = json.Name;
                    RouteGrade = json.Grade;
                    RouteId = json.RouteId;
                    $('#kortti').html("<span id='routename'> " + RouteName + "</span><span id='routegrade'>" + RouteGrade + "</span><div id='image'><img src='"+json.Image+"' alt='route picture'></div><form method='POST' action='addoutdoorexercise.php' class='button'><input type=hidden name='routeId' value='" + RouteId + "'> <!-- saadaan mmm outdoor-top / outdoor-attempt --> <input type=hidden name='type' value='outdoor-top'> <input type='submit' name='nappi' value='toppaus'></form> <form method='POST' action='addoutdoorexercise.php' class='button' id='attempt'> <input type=hidden name='routeId' value='" + RouteId + "'> <!-- saadaan mmm outdoor-top / outdoor-attempt --> <input type=hidden name='type' value='outdoor-attempt'> <input type='submit' name='yritys' value='yritys' id='yritys'> </form>");
                })
                .fail(function (jqxhr, textStatus, error) {
                    var err = textStatus + ", " + error;
                    console.log("Request Failed: " + err);
                })
        }
    });
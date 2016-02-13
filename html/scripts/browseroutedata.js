    var RouteName;
    var RouteGrade;
    $(document).on('change', '#crags', function () {
        $('#testi').html('');

        var cragValue = jQuery("select[name='crag']").val();
        $('#kortti').html();
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
                
                  $('#targetti').val(cragId);
                $('#commenttable').val('crag');
                         $.each(json.Comments, function(key, value){
                    $('#testi').append("<div class='comment'> <a href='profile.php?user="+value.CommenterId+"'> <span class='commenter'> "+value.CommenterId+" </span> </a> <span class='comment_text'> "+value.Comment+" </span> <span class='comment_date'> "+value.DateTime+" </span> </div>");  
                    
                    
                })
                })
                .fail(function (jqxhr, textStatus, error) {
                    var err = textStatus + ", " + error;
                    console.log("Request Failed: " + err);
                })
        });

    $(document).on('change', '#reitti', function () {
        var routeValue = jQuery("select[name='route']").val();
        $('#testi').html('');

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
                    RouteDescription = json.Description;
                    $('#kortti').html("<span id='routename'> " + RouteName + "</span><span id='routegrade'>" + RouteGrade + "</span><div id='image'><img src='"+json.Image+"' alt='route image'></div><p class='description'>"+RouteDescription+"</p>");
                //$('#testi').html('<p>jotain tekstiä</p>');
                $('#targetti').val(RouteId);
                $('#commenttable').val('route');
                $.each(json.Comments, function(key, value){
                    $('#testi').append("<div class='comment'> <a href='profile.php?user="+value.CommenterId+"'> <span class='commenter'> "+value.CommenterId+" </span> </a> <span class='comment_text'> "+value.Comment+" </span> <span class='comment_date'> "+value.DateTime+" </span> </div>");  
                    
                    
                })
                })
                .fail(function (jqxhr, textStatus, error) {
                    var err = textStatus + ", " + error;
                    console.log("Request Failed: " + err);
                })
        }
    });
/*********************VALIKKO**************************************/

$("#sivun_otsikko").click(function () {
    "use strict";
    if ($('#valikko').length === 0) { //tapahtuu ainoastaan kun valikkoa ei ole
        $("<div id='valikko'></div>").hide().appendTo("#container").slideDown("fast");
        $("<ul><li><form action='search.php' method='POST'><input type='text' name='search' placeholder='hae profiilia...' autofocus/></form></li><li><a href='main.php'>Etusivu</a></li><li><a href='profile.php?page=profile'>Profiili</a></li><li><a href='statistics.php?section=indoor'>Harjoitukset</a></li><li><a href='logout.php'>Kirjaudu ulos</a></li></ul>").hide().appendTo("#valikko").slideDown("fast");
    }
});

$(document).mouseup(function (e) {
    "use strict";
    var container = $("#valikko");
    // if the target of the click isn't the container...
    // ... nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0) {
        $('#valikko').slideToggle("fast", function () {
            $('#valikko').remove();
        });
    }
});
/*jslint browser: true*/
/*global $, jQuery, alert*/

/*------------------YLÄLAATIKOT----------------------*/

/*------------------YLÄ-VASEN----------------------*/

$("#laatikkoVasYla").click(function () {
    "use strict";
    if ($('#sisa').length === 0) {
        $('#laatikkoVasYla > p').fadeOut('400', function () {
            $('#laatikkoVasYla').css({"width": "100%"});
            $('#laatikkoVasYla').css({"z-index": "1"});
            $('#laatikkoOikYla').css({"z-index": "0"});
            $("<a href='sisa.php'><div id='sisa'>Sisällä</div></a><a href='ulko.php'><div id='ulko'>Ulkona</div></a>").hide().appendTo("#laatikkoVasYla").fadeIn();
        });
        $('#laatikkoVasYla > div > img').fadeOut("400", function () {
            $('#laatikkoVasYla > div').remove();
        });
    }
});

$(document).mouseup(function (e) {
    "use strict";
    var container = $("#laatikkoVasYla");

    // if the target of the click isn't the container...
    // ... nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0) {
        $('#sisa, #ulko').fadeOut("400", function () {
            container.css({"width": "45%"});
            $('#laatikkoOikYla').css({"z-index": "0"});
            $('#laatikkoVasYla > a').remove();
            $('#laatikkoVasYla > p').fadeIn();
            $('#laatikkoVasYla > div > img').fadeIn();
            $("<div class='climb_kuva'><img src='images/climbing.png' alt='climbing' /></div>").hide().appendTo("#laatikkoVasYla").fadeIn();
        });
    }
});

/*------------------YLÄ-OIKEA----------------------*/

$("#laatikkoOikYla").click(function () {
    "use strict";
    window.location.href = 'markroute.php';
});

/*------------------ALALAATIKOT----------------------*/

/*------------------ALA-VASEN----------------------*/

$("#laatikkoVasAla").click(function () {
    "use strict";
    window.location.href = '#';
});

/*------------------ALA-OIKEA----------------------*/

$("#laatikkoOikAla").click(function () {
    "use strict";
    window.location.href = 'browse.php';
});



/*******************TOPPAUS*********************************/

$('#top-plus').click(function () {
    "use strict";
    var color = $('#top-plus').css("background-color");
    if (color === "rgb(255, 255, 255)" || color === "white") {
        $('#top-plus').css({"background-color": "rgb(229, 85, 2)"});
        $('.grade-plus').val("1");
    } else {
        $('#top-plus').css({"background-color": "white"});
        $('.grade-plus').val("");
    }
});

$('#yritys-plus').click(function () {
    "use strict";
    var color = $('#yritys-plus').css("background-color");
    if (color === "rgb(255, 255, 255)" || color === "white") {
        $('#yritys-plus').css({"background-color": "rgb(229, 85, 2)"});
        $('.grade-plus').val("1");
    } else {
        $('#yritys-plus').css({"background-color": "white"});
        $('.grade-plus').val("");
    }
});
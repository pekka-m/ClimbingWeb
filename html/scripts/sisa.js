/*jslint browser: true*/
/*global $, jQuery, alert*/

/*------------------CAMPUS-LAATIKKO-TESTI----------------------*/

$(document).ready(function() {
    $("#campus_form > input").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
	if ($('#startTimer').text() == '1') {
		$('#laatikkoVasYla > p').text('00:00');
		function get_elapsed_time_string(total_seconds) {
			function pretty_time_string(num) {
				return ( num < 10 ? "0" : "" ) + num;
			}
			var minutes = Math.floor(total_seconds / 60);
			total_seconds = total_seconds % 60;
			var seconds = Math.floor(total_seconds);
			minutes = pretty_time_string(minutes);
			seconds = pretty_time_string(seconds);
			var currentTimeString = minutes + ":" + seconds;
			return currentTimeString;
		}
		var elapsed_seconds = 0;
		setInterval(function() {
			elapsed_seconds = elapsed_seconds + 1;
			$('#laatikkoVasYla > p').text(get_elapsed_time_string(elapsed_seconds));
		}, 1000);
	}
});

/*------------------OTELAUTA-LAATIKKO----------------------*/

$("#laatikkoVasYla").click(function () {
    "use strict";
	window.location.href = 'fingerboard.php';
});

/*---------------LOPETA-OTELAUTA-NAPPULA--------------------------*/

/* (laatikkoVasYlan sisällä olevaa lopeta_otelautaa kun klikataan
pelkkä click ei toimi dynaamisesti luoduille elementeille) */
$("#laatikkoVasYla").on('click', '#lopeta_otelauta', function () {
    "use strict";
    if ($('#lopeta_otelauta').length === 1) {
        $('#lopeta_otelauta').fadeOut("400", function () {
            $('#lopeta_otelauta').remove();
            $('#laatikkoVasYla').css({"width": "45%"});
            $('#laatikkoOikYla').css({"z-index": "0"});
            $('#aloita_otelauta').fadeIn();
        });
        $('#laskuri').fadeOut("400", function () {
            $('#laskuri').remove();
        });
    }
});

/*---------------------CAMPUS-LAATIKKO-----------------------*/

$("#laatikkoOikYla").click(function () {
    "use strict";
    if ($('#tallenna_campus').length === 0) {
        var laatikko = $('#laatikkoOikYla').width();
        laatikko = $('#laatikkoOikYla').css({"width": "100%"});
        $('#laatikkoOikYla').css({"z-index": "1"});
        $('#laatikkoVasYla').css({"z-index": "0"});
        $('#merkkaa_campus').fadeOut("400", function () {
            $("<div id='tallenna_campus'><h3>merkkaa</h3></div>").hide().appendTo("#laatikkoOikYla").fadeIn();
            $("#campus_tiedot").fadeIn();
        });
    }
});

/*---------------MERKKAA-CAMPUS-NAPPULA--------------------------*/

$("#laatikkoOikYla").on('click', '#tallenna_campus', function () {
    "use strict";
    $("#campus_form").submit();
});


/*---------------PLUS-NAPPULAT--------------------------*/

$('#top-plus').click(function () {
    "use strict";
    var color = $('#top-plus').css("background-color");
    if (color === "rgb(255, 255, 255)" || color === "white") {
        $('#top-plus').css({"background-color": "rgb(229, 85, 2)"});
        $('.grade-plus').val("+");
    } else {
        $('#top-plus').css({"background-color": "white"});
        $('.grade-plus').val("-");
    }
});

$('#attempt-plus').click(function () {
    "use strict";
    var color = $('#attempt-plus').css("background-color");
    if (color === "rgb(255, 255, 255)" || color === "white") {
        $('#attempt-plus').css({"background-color": "rgb(229, 85, 2)"});
        $('.grade-plus').val("+");
    } else {
        $('#attempt-plus').css({"background-color": "white"});
        $('.grade-plus').val("-");
    }
});

/*---------------LOPETA-HARJOITUS-NAPPULA--------------------------*/

$('#lopeta').on('click', function () {
    "use strict";
    window.location.href = 'endpractice.php';
});
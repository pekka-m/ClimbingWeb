/*jslint browser: true*/
/*global $, jQuery, alert*/

$("#register").click(function () {
    "use strict";
    $('#form').attr('action', 'register.php');
    $('#form').submit();
});
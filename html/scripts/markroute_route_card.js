var RouteName;
var RouteGrade;
$(document).on('change', '#crags', function () {
    var cragValue = jQuery("select[name='crag']").val();
    $('#kortti').html("<input type='text' name='routename' placeholder='route name'><div class='clear'></div><select name='grade_number'><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option></select><select name='grade_letter'><option value='-'></option><option value='A'>A</option><option value='B'>B</option><option value='C'>C</option></select><div id='top-plus'>+</div><input class='grade-plus' type='hidden' name='grade_plus' value='-'><input type='text' name='description' placeholder='add description..'><div class='upload'><input id='image_upload' name='filetto' type='file'><input type='hidden' name='datadir' value='/var/www/html/images/route/'></div><p><input type='submit' name='addroute' value='add route'></p>");
});
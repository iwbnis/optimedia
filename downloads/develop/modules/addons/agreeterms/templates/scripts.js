$(document).ready(function () {
    if ($('#iCheck-accepttos').length > 0) {
        $('#accepttos').iCheck('disable');
    } else {
        $('#accepttos').prop('disabled', 'disabled');
    }
    $('#iagreeterms').click(function (e) {
        if ($('#iCheck-accepttos').length > 0) {
            $('#accepttos').iCheck('enable');
        } else {
            $('#accepttos').removeProp('disabled');
        }
    });
    $('#tosreading').click(function (e) {
        e.preventDefault;
        $('#myModal').modal('show');
        return false;
    });
});

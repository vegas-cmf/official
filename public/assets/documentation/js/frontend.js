$(document).ready(function () {
    $('#version').change(function () {
        window.location = '/documentation/'+$('#version').val();
    });
});

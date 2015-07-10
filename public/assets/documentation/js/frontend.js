$(document).ready(function () {
    $('#version').change(function () {
        var locationArr = window.location.pathname.split('/');
        locationArr[2] = $('#version').val();
        window.location = locationArr.join('/');
    });
});

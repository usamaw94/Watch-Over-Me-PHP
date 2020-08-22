$(document).ready(function () {

    initialMap();

    function initialMap() {
        var lat = document.getElementById("latitude").value;
        var long = document.getElementById("longitude").value;
        // var wearerPosition = new google.maps.LatLng(lat, long);
        // var mapOptions = {
        //     center: wearerPosition,
        //     zoom: 4,
        // };
        // var map = new google.maps.Map(document.getElementById("helpMeWearerLocation"), mapOptions);

        var wearerPosition = new google.maps.LatLng(lat,long);
        var mapOptions = {
            center: wearerPosition,
            zoom: 15,
        };
        var map = new google.maps.Map(document.getElementById("helpMeWearerLocation"), mapOptions);
        var marker = new google.maps.Marker({
            position: wearerPosition,
        });
        marker.setMap(map);
    }

    // function myMap(lat,long) {
    //     var lat = document.getElementById("latitude").value;
    //     var long = document.getElementById("longitude").value;
    //
    //     var wearerPosition = new google.maps.LatLng(lat,long);
    //     var mapOptions = {
    //         center: wearerPosition,
    //         zoom: 15,
    //     };
    //     var map = new google.maps.Map(document.getElementById("helpMeWearerLocation"), mapOptions);
    //     var marker = new google.maps.Marker({
    //         position: wearerPosition,
    //     });
    //     marker.setMap(map);
    // }

});

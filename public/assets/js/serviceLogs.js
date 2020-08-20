$(document).ready(function () {

    window.Echo.channel('showlogs.'+$('#serviceId').text())
        .listen('NewLog', (e) => {

            alert(e.serviceId);

            $( "#logsContainer" ).load(window.location.href + " #logsContent", function () {

                var index = localStorage.getItem("activeLogId");

                var id  = "#"+index;

                $(id).addClass("logs-active");

            });


        });

    initialMap();
    // listen();

    $('.logs-date-picker').datetimepicker({
        format: 'MM/DD/YYYY',
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-chevron-up",
            down: "fa fa-chevron-down",
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'fa fa-screenshot',
            clear: 'fa fa-trash',
            close: 'fa fa-remove'
        }
    });

    function initialMap() {
        //var lat = document.getElementById("latitude").value;
        //var long = document.getElementById("longitude").value;
        var wearerPosition = new google.maps.LatLng(-24.870193, 134.171259);
        var mapOptions = {
            center: wearerPosition,
            zoom: 4,
        };
        var map = new google.maps.Map(document.getElementById("googleMap"), mapOptions);
    }

    function myMap(lat,long) {
        //var lat = document.getElementById("latitude").value;
        //var long = document.getElementById("longitude").value;

        var wearerPosition = new google.maps.LatLng(lat,long);
        var mapOptions = {
            center: wearerPosition,
            zoom: 15,
        };
        var map = new google.maps.Map(document.getElementById("googleMap"), mapOptions);
        var marker = new google.maps.Marker({
            position: wearerPosition,
        });
        marker.setMap(map);
    }



    $(document).on("click", ".logs", function(){
        var lat=$(this).attr('data-lat');
        var long=$(this).attr('data-long');

        $(".logs").removeClass("logs-active");

        localStorage.setItem("activeLogId", $(this).attr('id'));

        $(this).addClass("logs-active");

        myMap(lat,long);
    });

    $(document).on("click",'.logs-action', function(event) {
        event.stopPropagation();
    });

    $(document).on("click",'#showWearerLocation', function(event) {

        var lat = "-38.042411928573614";
        var long = "145.1096239604738";


        var wearerPosition = new google.maps.LatLng(lat,long);
        var mapOptions = {
            center: wearerPosition,
            zoom: 15,
        };
        var map = new google.maps.Map(document.getElementById("wearerLocationMap"), mapOptions);
        var marker = new google.maps.Marker({
            position: wearerPosition,
        });
        marker.setMap(map);

    });


});

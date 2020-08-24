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



    $(document).on("click", "#helpMeResponseYes", function () {

        $("#helpMeResponseYesLoad").fadeIn("slow");

        var userId = $(this).attr("data-user-id");
        var serviceId = $(this).attr("data-service-id");
        var logId = $(this).attr("data-log-id");
        var response = 'Yes';
        var sentDate = $(this).attr("data-sent-date");
        var sentTime = $(this).attr("data-sent-time");
        var responderName = $(this).attr("data-responder-name");

        var url="/helpMeRespond/";

        $.ajax({
            url: url,
            data: {
                userId: userId,
                serviceId: serviceId,
                logId: logId,
                response: response,
                sentDate: sentDate,
                sentTime: sentTime,
                responderName: responderName
            },
            datatype: "json",
            method: "GET",
            success: function (data) {

                $( "#reloadPage" ).load(window.location.href + " #reloadContent" , function () {
                    initialMap();
                    $("#helpMeResponseYesLoad").fadeOut("slow");
                });


            },
            complete: function () {
            }
        });

    });

    $(document).on("click", "#helpMeResponseNo", function () {

        $("#helpMeResponseNoLoad").fadeIn("slow");

        var userId = $(this).attr("data-user-id");
        var serviceId = $(this).attr("data-service-id");
        var logId = $(this).attr("data-log-id");
        var response = 'No';
        var sentDate = $(this).attr("data-sent-date");
        var sentTime = $(this).attr("data-sent-time");
        var responderName = $(this).attr("data-responder-name");

        var url="/helpMeRespond/";

        $.ajax({
            url: url,
            data: {
                userId: userId,
                serviceId: serviceId,
                logId: logId,
                response: response,
                sentDate: sentDate,
                sentTime: sentTime,
                responderName: responderName
            },
            datatype: "json",
            method: "GET",
            success: function (data) {

                $( "#reloadPage" ).load(window.location.href + " #reloadContent" , function () {
                    initialMap();
                    $("#helpMeResponseNoLoad").fadeOut("slow");
                });

            },
            complete: function () {
            }
        });

    });


});

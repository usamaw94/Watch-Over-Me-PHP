$(document).ready(function () {

    window.Echo.channel('help-me-response.'+$('#helpMeCredentials').attr('data-service-id')+'.'+$('#helpMeCredentials').attr('data-log-id'))
        .listen('NewHelpMeResponse', (e) => {

            $("#helpMeResponseYes").attr("disabled", true);
            $("#helpMeResponseNo").attr("disabled", true);

            var currentUserId = $('#helpMeCredentials').attr("data-user-id");

            var logId = e.logId;
            var serviceId = e.serviceId;
            var responderId = e.responderId
            var responderName = e.responderName;
            var response = e.response;


            if (currentUserId != responderId) {

                if (response == 'No') {

                    color = 'danger';

                    $.notify({
                        icon: "nc-icon nc-bell-55",
                        message: "<b>"+responderName+"</b> has declined the request</br>",

                    }, {
                        type: color,
                        timer: 5000,
                        placement: {
                            from: 'top',
                            align: 'right'
                        }
                    });

                } else if (response == 'Yes') {

                    color = 'success';

                    $.notify({
                        icon: "nc-icon nc-bell-55",
                        message: "<b>"+responderName+"</b> has accepted the request</br>",

                    }, {
                        type: color,
                        timer: 5000,
                        placement: {
                            from: 'top',
                            align: 'right'
                        }
                    });

                }

            }

            $( "#reloadPage" ).load(window.location.href + " #reloadContent", function () {
                initialMap();
            });


        });

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

        $("#helpMeResponseYes").attr("disabled", true);
        $("#helpMeResponseNo").attr("disabled", true);

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

        $("#helpMeResponseYes").attr("disabled", true);
        $("#helpMeResponseNo").attr("disabled", true);

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

$(document).ready(function () {


    var num = 0;

    localStorage.clear();

    // window.Echo.channel('showlogs.'+$('#serviceId').text())
    //     .listen('NewLog', (e) => {
    //
    //         // alert(e.serviceId);
    //
    //         $( "#logsContainer" ).load(window.location.href + " #logsContent", function () {
    //
    //             var index = localStorage.getItem("activeLogId");
    //
    //             var id  = "#"+index;
    //
    //             $(id).addClass("logs-active");
    //
    //         });
    //
    //
    //     });


    // alert('location.'+$('#serviceId').text()+'.'+$('#showWearerLocation').attr('data-user-id'));



    initialMap();
    // listen();

    $('.logs-date-picker').datetimepicker({
        format: 'DD-MM-YYYY',
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
        var locality=$(this).attr('data-locality');

        $(".logs").removeClass("logs-active");

        localStorage.setItem("activeLogId", $(this).attr('id'));

        $(this).addClass("logs-active");

        myMap(lat,long);


        $(".map-marker-icon").removeClass('sr-only');
        $("#wearerLogLocality").text(locality);
    });

    $(document).on("click",'.logs-action', function(event) {
        event.stopPropagation();
    });



    $(document).on("click",'#showWearerLocation', function(event) {


        var id = $(this).attr('data-service-id');

        var userId = $(this).attr('data-user-id');

        var userName = $(this).attr('data-user-name');

        $("#trackWearerLoad").removeClass("sr-only");

        var url="/adminTrackWearer/";


        $.ajax({
            url: url,
            data: {
                serviceId: id,
                userName: userName,
                userId:userId
            },
            datatype: "json",
            method: "GET",
            success: function (data) {
            },
            complete: function () {
            }
        });

    });

    window.Echo.channel('location.'+$('#serviceId').text()+'.'+$('#showWearerLocation').attr('data-user-id'))
        .listen('WearerLocation', (e) => {

            var userId = e.userId;
            var serviceId = e.serviceId;
            var lat = e.locationLatitude;
            var long = e.locationLongitude;
            var locality = e.locality;

            $("#wearerLocality").text(locality);

            var getDirectionLink = "https://www.google.com/maps/dir//"+lat+","+long;


            $("#wearerGetDirectionLink").attr("href", getDirectionLink);

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

            $('#trackWearer').modal('show');

            $("#trackWearerLoad").addClass("sr-only");

        });


    $(document).on("click",'.show-hourly-log-details', function(event) {

        var id = $(this).attr('data-id');
        var date = $(this).attr('data-date');
        var time = $(this).attr('data-time');
        var description = $(this).attr('data-description');
        var type = $(this).attr('data-type');
        var deviceBattery = $(this).attr('data-battery');

        $("#hModalId").text(id);
        $("#hModalDateTime").text(date +" - "+time);
        $("#hModalDescription").text(description);
        $("#hModalType").text(type);
        $("#hModalBattery").text(deviceBattery+"%");


        $('#hourlyLogDetails').modal('show');
    });


    $(document).on("click",'.show-alert-log-details', function(event) {

        $("#alertLogInfoIcon").addClass("sr-only");
        $("#alertLogLoad").removeClass("sr-only");

        var id = $(this).attr('data-id');
        var wearerName = $(this).attr('data-wearer-name');


        var url="/adminAlertLogDetails/";


        $.ajax({
            url: url,
            data: {
                logId: id
            },
            datatype: "json",
            method: "GET",
            success: function (data) {

                $("#aModalWearerName").text(wearerName);
                $("#aModalTime").text(data.logDetails.log_time);
                $("#aModalDate").text(data.logDetails.log_date);
                $("#aModalBattery").text(data.logDetails.battery_percentage+"%");

                $("#helpMeResponse").text("");

                if(data.logDetails.response_status == "true"){
                    $("#helpMeResponse").html(
                        "<p class='text-success'><b>"+data.logDetails.responded_by_name+"</b> accepted the help request</p>");
                } else {
                    $("#helpMeResponse").html("<p class='text-danger'>No one accepted the help request</p>");
                }

                $("#alertLogTimeline").empty();

                var length = data.logResponses.length;


                for(i=0; i<data.logResponses.length; i++){
                    var alertLogId = data.logResponses[i].alert_log_id;
                    var responseFrom = data.logResponses[i].response_from;
                    var responseTo = data.logResponses[i].response_to;
                    var sendText = data.logResponses[i].send_text;
                    var sendDate = data.logResponses[i].send_date;
                    var sendTime = data.logResponses[i].send_time;
                    var responseType = data.logResponses[i].response_type;
                    var responseStatus = data.logResponses[i].response_status;
                    var replyText = data.logResponses[i].reply_text;
                    var replyDate = data.logResponses[i].reply_date;
                    var replyTime = data.logResponses[i].reply_time;
                    var responseLink = data.logResponses[i].response_link;
                    var personId = data.logResponses[i].person_id;
                    var fName = data.logResponses[i].f_name;
                    var lName = data.logResponses[i].l_name;
                    var fullName = data.logResponses[i].full_name;
                    var email = data.logResponses[i].email;
                    var phone = data.logResponses[i].phone;

                    var response = "";

                    if (responseStatus == "true") {

                        if(responseType == "Yes") {

                            //Yes

                            response = "<li class='timeline-inverted'>" +
                                "<div class='timeline-badge success'>" +
                                "<i class='nc-icon nc-single-02'></i>" +
                                "</div>" +
                                "<div class='timeline-panel'>" +
                                "<div class='timeline-heading'>" +
                                "<span class='badge badge-pill badge-success'>Response</span>" +
                                "</div>" +
                                "<div class='timeline-body'>" +
                                "<p><b>"+fName+"</b> accepted the help request</p>\n" +
                                "</div>" +
                                "<h6>" +
                                "<i class='ti-time'></i>" +
                                replyTime+" - "+ replyDate +
                                "</h6>" +
                                "</div>" +
                                "</li>";


                        } else {

                            // No

                            response = "<li class='timeline-inverted'>" +
                                "<div class='timeline-badge danger'>" +
                                "<i class='nc-icon nc-single-02'></i>" +
                                "</div>" +
                                "<div class='timeline-panel'>" +
                                "<div class='timeline-heading'>" +
                                "<span class='badge badge-pill badge-danger'>Response</span>" +
                                "</div>" +
                                "<div class='timeline-body'>" +
                                "<p><b>"+fName+"</b> declined the help request</p>\n" +
                                "</div>" +
                                "<h6>" +
                                "<i class='ti-time'></i>" +
                                replyTime+" - "+ replyDate +
                                "</h6>" +
                                "</div>" +
                                "</li>";

                        }

                    } else {

                        // Didn't respond

                        response = "<li class='timeline-inverted'>" +
                            "<div class='timeline-badge warning'>" +
                            "<i class='nc-icon nc-single-02'></i>" +
                            "</div>" +
                            "<div class='timeline-panel'>" +
                            "<div class='timeline-heading'>" +
                            "<span class='badge badge-pill badge-warning'>Response</span>" +
                            "</div>" +
                            "<div class='timeline-body'>" +
                            "<p><b>"+fName+"</b> didn't respond</p>" +
                            "</div>" +
                            "</div>" +
                            "</li>";

                    }

                    var row = "<li class='timeline'>" +
                        "<div class='timeline-badge info'>" +
                        "<i class='nc-icon nc-circle-10'></i>" +
                        "</div>" +
                        "<div class='timeline-panel'>" +
                        "<div class='timeline-heading'>" +
                        "<span class='badge badge-pill badge-info'>Help Me Request</span>" +
                        "</div>" +
                        "<div class='timeline-body'>" +
                        "<p>Request was sent to <b>"+fullName+"</b></p>" +
                        "</div>" +
                        "<h6>" +
                        "<i class='ti-time'></i>" +
                        sendTime+" - "+sendDate+
                        "</h6>" +
                        "</div>" +
                        "</li>" + response;


                    $("#alertLogTimeline").append(row);
                }


                $('#alertLogDetails').modal('show');
            },
            complete: function () {
                $("#alertLogInfoIcon").removeClass("sr-only");
                $("#alertLogLoad").addClass("sr-only");
            }
        });

    });

    $(document).on("submit", "#logFiltersForm", function (e) {
        e.preventDefault();


        $("#apllyLogFilterLoad").removeClass("sr-only");

        // var data = JSON.stringify( $(this).serializeArray() );

        var data = $(this).serializeArray();


        var serviceId = data[0]['value'];

        var logType = data[1]['value'];

        var date = data[2]['value'];

        if (date == ''){
            date = 'all';
        }

        var url="/adminLogHistory/"+serviceId+"/"+date+"/"+logType;

        // window.location.href = url;

        $( "#reloadPage" ).load(url + " #pageContent", function () {
            $("#apllyLogFilterLoad").addClass("sr-only");
            initialMap();
            $('#logFilters').modal('hide');
        });

    });


});

$(document).ready(function () {

    window.Echo.channel('showlogs.'+$('#serviceId').text())
        .listen('NewLog', (e) => {

            // alert(e.serviceId);

            $( "#logsContainer" ).load(window.location.href + " #logsContent", function () {

                var index = localStorage.getItem("activeLogId");

                var id  = "#"+index;

                $(id).addClass("logs-active");

            });


        });


    window.Echo.channel('location.'+$('#serviceId').text()+'.'+$('#showWearerLocation').attr('data-user-id'))
        .listen('NewLog', (e) => {

            alert(e.locationLatitude);

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
                alert(data);
            },
            complete: function () {
                $("#trackWearerLoad").addClass("sr-only");
            }
        });


        // var lat = "-38.042411928573614";
        // var long = "145.1096239604738";
        //
        //
        // var wearerPosition = new google.maps.LatLng(lat,long);
        // var mapOptions = {
        //     center: wearerPosition,
        //     zoom: 15,
        // };
        // var map = new google.maps.Map(document.getElementById("wearerLocationMap"), mapOptions);
        // var marker = new google.maps.Marker({
        //     position: wearerPosition,
        // });
        // marker.setMap(map);

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

        var id = $(this).attr('data-id');
        var date = $(this).attr('data-date');
        var time = $(this).attr('data-time');
        var description = $(this).attr('data-description');
        var type = $(this).attr('data-type');
        var deviceBattery = $(this).attr('data-battery');

        $("#aModalId").text(id);
        $("#aModalDateTime").text(date +" - "+time);
        $("#aModalDescription").text(description);
        $("#aModalType").text(type);
        $("#aModalBattery").text(deviceBattery+"%");


        $('#alertLogDetails').modal('show');
    });

    // $(document).on("submit", "#logFiltersForm", function (e) {
    //     e.preventDefault();
    //
    //
    //     $("#apllyLogFilterLoad").removeClass("sr-only");
    //
    //     var data = $(this).serialize();
    //
    //     var url="/adminApplyLogFilters/";
    //
    //     $.ajax({
    //         url: url,
    //         data: data,
    //         datatype: "json",
    //         method: "GET",
    //         success: function (data) {
    //
    //             $("#logsContent").empty();
    //
    //             var length = data.length;
    //
    //
    //             for(i=0; i<data.length; i++){
    //                 var personId = data[i].person_id;
    //                 var personName = data[i].f_name + " "
    //                     + data[i].l_name;
    //                 var personPhone = data[i].phone;
    //                 var personEmail = data[i].email;
    //                 var priorityNum = data[i].priority_num;
    //
    //                 var listItem =
    //                     "<a data-id='" + personId + "' data-priority-num='"+priorityNum+"' class='list-group-item list-group-item-action'>" +
    //                     "<div class='row'>" +
    //                     "<div class='col-12'>" +
    //                     "<div class='float-right'>" +
    //                     "<span class='badge badge-default priority-num'>" + priorityNum + "</span>" +
    //                     "</div>" +
    //                     "<h6 class='card-title'>" + personName + " &nbsp;" +
    //                     "<span class='card-category'>" + personPhone + "</span>" +
    //                     "</h6>" +
    //                     "<h6 class='text-muted text-lowercase'>" + personEmail + "</h6>" +
    //                     "</div>" +
    //                     "</div>" +
    //                     "</a>";
    //
    //                 $("#logsContent").append(listItem);
    //             }
    //
    //         },
    //         complete: function () {
    //             $("#apllyLogFilterLoad").addClass("sr-only");
    //
    //             $('#logFilters').modal('hide');
    //         }
    //     });
    //
    // });


});

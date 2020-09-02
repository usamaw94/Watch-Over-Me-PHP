$(document).ready(function () {

    window.Echo.channel('notifyAlertLog.'+$('#userCredentials').attr('data-id'))
        .listen('NewAlertLog', (e) => {

            console.log(e);

            color = 'danger';
            $.notify({
                icon:"add_alert",
                message:"Wearer: <b>"+ e.wearerName +"</b> needs your help.</br>" +
                    "Service ID: <b>"+ e.serviceId +"<b><br>" +
                    "Created at: "+ e.created_at +"<br>" +
                    "<b>Click this dialogue to respond</b>",
                url: e.respondingLink,
            }, {
                type: color,
                timer:5000,
                placement: {
                    from:'top',
                    align:'right'
                }
            });

            $( "#notificationContainer" ).load(window.location.href + " #reloadNotification");

        });


    $(document).on("click", ".person-details-modal", function () {

        var personId = $(this).attr("data-id");

        var userType = $(this).attr("data-type");

        $(this).find(".fa-spinner").removeClass('sr-only');

        var url="/getPersonDetails/";


        $.ajax({
            url: url,
            data: {personId},
            datatype: "json",
            method: "GET",
            success: function (data) {

                console.log(data);

                if(userType == "wearer") {

                    $("#personModalTitle").text("Wearer Details");

                } else if (userType == "customer") {

                    $("#personModalTitle").text("Customer Details");

                }

                $("#modalUserId").text(data.person_id);
                $("#modalUserName").text(data.full_name);
                $("#modalUserPhone").text(data.phone);
                $("#modalUserEmail").text(data.email);

                if (data.verification_status == 'true') {

                    $("#modalUserVerification")
                        .html("<span class='badge badge-success'>" +
                            "<i class='fa fa-check'></i>" +
                            "&nbsp; Verified" +
                            "</span>");

                } else if (data.verification_status == 'false') {

                    $("#modalUserVerification")
                        .html("<span class='badge badge-default'>" +
                            "<i class='fa fa-info'></i>" +
                            "&nbsp; Verification Required" +
                            "</span>");

                }

                $('#personDetails').modal('show');

            },
            complete: function () {
                $('.person-details-modal[data-id=' + personId + ']').find(".fa-spinner").addClass("sr-only");
            }
        });

    });



    $(document).on("click", ".watcher-details-modal" , function () {

        $(this).find(".fa-spinner").removeClass("sr-only");

        var serviceId = $(this).attr("data-id");

        var url="/getWatchersList/";

        $.ajax({
            url: url,
            data: {serviceId},
            datatype: "json",
            method: "GET",
            success: function (data) {

                $("#watchersList").empty();

                var length = data.length;

                $('#totalWatchersNum').text(length);

                for(i=0; i<data.length; i++){
                    var personId = data[i].person_id;
                    var personName = data[i].full_name;
                    var personPhone = data[i].phone;
                    var personEmail = data[i].email;
                    var verification = data[i].verification_status;
                    var priority = data[i].priority_num;

                    var verificationBadge = "";

                    if (verification == "true") {

                        verificationBadge = "<span class='badge badge-success'>" +
                            "<i class='fa fa-check'></i>" +
                            "&nbsp; Verified" +
                            "</span>";

                    } else if (verification == "false") {

                        verificationBadge = "<span class='badge badge-default'>" +
                            "<i class='fa fa-info'></i>" +
                            "&nbsp; Verification Required" +
                            "</span>";

                    }

                    var row = "<tr><td>"+ priority +"</td><td>"+ personId +"</td><td>" + personName + "</td><td>" + personPhone + "</td><td>" + personEmail + "</td><td>" + verificationBadge + "</td></tr>";
                    $("#watchersList").append(row);
                }

                $('#watchersDetail').modal('show');

            },
            complete: function () {
                $('.watcher-details-modal[data-id=' + serviceId + ']').find(".fa-spinner").addClass("sr-only");
            }
        });

    });



});

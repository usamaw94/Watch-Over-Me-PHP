$(document).ready(function() {

    $(document).on("click", ".wearer-name" , function () {

        var personId = $(this).attr("data-id");

        $(this).find(".wearer-details-load").removeClass("sr-only");

        var url="/adminGetPerson/";


        $.ajax({
            url: url,
            data: {personId},
            datatype: "json",
            method: "GET",
            success: function (data) {

                $("#modalWearerId").text(data.person_id);
                $("#modalWearerName").text(data.f_name + " " + data.l_name);
                $("#modalWearerPhone").text(data.phone);
                $("#modalWearerEmail").text(data.email);

                $('#wearerDetails').modal('show');

            },
            complete: function () {
                $('.wearer-name[data-id=' + personId + ']').find(".wearer-details-load").addClass("sr-only");
            }
        });

    });

    $(document).on("click", ".customer-name" , function () {


        var personId = $(this).attr("data-id");

        $(this).find(".customer-details-load").removeClass("sr-only");

        var url="/adminGetPerson/";


        $.ajax({
            url: url,
            data: {personId},
            datatype: "json",
            method: "GET",
            success: function (data) {

                $("#modalCustomerId").text(data.person_id);
                $("#modalCustomerName").text(data.f_name + " " + data.l_name);
                $("#modalCustomerPhone").text(data.phone);
                $("#modalCustomerEmail").text(data.email);

                $('#customerDetails').modal('show');

            },
            complete: function () {
                $('.customer-name[data-id=' + personId + ']').find(".customer-details-load").addClass("sr-only");
            }
        });


    });

    $(document).on("click", ".watcher-name" , function () {

        $(this).find(".watchers-details-load").removeClass("sr-only");

        var serviceId = $(this).attr("data-id");

        var url="/adminGetWatchersList/";

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
                    var personName = data[i].f_name + " "
                        + data[i].l_name;
                    var personPhone = data[i].phone;
                    var personEmail = data[i].email;

                    var row = "<tr><td>"+ personId +"</td><td>" + personName + "</td><td>" + personPhone + "</td><td>" + personEmail + "</td></tr>";
                    $("#watchersList").append(row);
                }

                $('#watcherDetails').modal('show');

            },
            complete: function () {
                $('.watcher-name[data-id=' + serviceId + ']').find(".watchers-details-load").addClass("sr-only");
            }
        });


    });
});

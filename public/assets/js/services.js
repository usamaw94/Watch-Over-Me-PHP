$(document).ready(function() {

    $(document).on("click", "#searchServices", function () {

        var searchText = $("#servicesSearchText").val();

        if(searchText == ''){

            location.reload();

        } else {

            $("#servicesSearchLoad").removeClass("sr-only");

            var url="/adminSearchServices/";


            $.ajax({
                url: url,
                data: {searchText},
                datatype: "json",
                method: "GET",
                success: function (data) {

                    $("#paginationContainer").addClass('sr-only');

                    $("#showServiceList").empty();

                    var length = data.length;

                    $("#serviceSearchControl").removeClass('sr-only');

                    $("#noOfServices").text(length);

                    for(i=0; i<data.length; i++){
                        var serviceId = data[i].service_id;
                        var wearerId = data[i].wearer_id;
                        var wearerFullName = data[i].wearerFullName;
                        var womNum = data[i].wom_num;
                        var serviceStatus = data[i].service_status;
                        var noOfWatchers = data[i].no_of_watchers;
                        var customerId = data[i].customer_id;
                        var customerFullName = data[i].customerFullName;



                        var listItem =
                            "<tr>" +
                            "<td class='text-center'>" + serviceId + "</td>" +
                            "<td>"+ womNum +"</td>" +
                            "<td class='link-text wearer-name' data-id='"+ wearerId +"'>" +
                             wearerFullName + " &nbsp; <i class='fa fa-refresh fa-spin wearer-details-load sr-only'></i>" +
                            "</td>" +
                            "<td class='link-text customer-name' data-id='"+customerId+"'>" +
                            customerFullName +" &nbsp; <i class='fa fa-refresh fa-spin customer-details-load sr-only'></i>" +
                            "</td>" +
                            "<td class='link-text watcher-name text-center' data-id='"+ serviceId +"'>" +
                            "<b class='link-text watcher-num'>"+noOfWatchers+"</b> &nbsp; <i class='fa fa-refresh fa-spin watchers-details-load sr-only'></i>" +
                            "</td>" +
                            "<td class='text-center'>"
                            + serviceStatus +
                            "</td>" +
                            "<td class='text-right'>" +
                            "<a target='_blank' href='/adminServiceDetails/?id="+serviceId+"' rel='tooltip' class='btn btn-outline-default btn-round btn-sm'>" +
                            "Details" +
                            "</a>" +
                            "</td>" +
                            "</tr>";

                        $("#showServiceList").append(listItem);
                    }

                },
                complete: function () {
                    $("#servicesSearchLoad").addClass("sr-only");
                }
            });

        }

    });

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

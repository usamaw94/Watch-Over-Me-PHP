$(document).ready(function() {

    $(document).on("click", "#searchUsers", function () {

        var searchText = $("#usersSearchText").val();

        if(searchText == ''){

            location.reload();

        } else {

            $("#usersSearchLoad").removeClass("sr-only");

            var url="/adminSearchUsers/";


            $.ajax({
                url: url,
                data: {searchText},
                datatype: "json",
                method: "GET",
                success: function (data) {

                    $("#usersPaginationContainer").addClass('sr-only');

                    $("#showUserList").empty();

                    var length = data.length;

                    $("#userSearchControl").removeClass('sr-only');

                    $("#noOfUsers").text(length);

                    for(i=0; i<data.length; i++){
                        var personId = data[i].person_id;
                        var fName = data[i].f_name;
                        var lName = data[i].l_name;
                        var fullName = data[i].full_name;
                        var email = data[i].email;
                        var phone = data[i].phone;
                        var createdAt = data[i].created_at;



                        var listItem =
                            "<tr>" +
                            "<td class='text-center'>" + personId + "</td>" +
                            "<td>"+ fullName +"</td>" +
                            "<td>"+ phone +"</td>" +
                            "<td>"+ email +"</td>" +
                            "<td class='text-center'>" +
                            "<a target='_blank' href='/adminUserDetails/?id="+personId+"' rel='tooltip' class='btn btn-outline-default btn-round btn-sm'>" +
                            "Details" +
                            "</a>" +
                            "</td>" +
                            "</tr>";

                        $("#showUserList").append(listItem);
                    }

                },
                complete: function () {
                    $("#usersSearchLoad").addClass("sr-only");
                }
            });

        }

    });

});

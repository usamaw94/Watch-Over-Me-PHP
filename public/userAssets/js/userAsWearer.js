$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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


    $(document).on("click","#openAddWatcherForm", function () {

        var serviceId = $(this).attr("data-id");

        $("#modalServiceId").val(serviceId);

        $("#modalAddWatcherSubmit").attr("disabled", true);

        $('#addWatcher').modal('show');

    });


    var watcherInput = document.querySelector("#modalWatcherPhoneNum");
    var watcherIti = window.intlTelInput(watcherInput, {
        autoHideDialCode: true,
        autoPlaceholder: "on",
        dropdownContainer: document.body,
        // excludeCountries: ["us"],
        formatOnDisplay: false,
        hiddenInput: "full_number",
        initialCountry: "au",
        // localizedCountries: { 'de': 'Deutschland' },
        nationalMode: true,
        // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
        placeholderNumberType: "MOBILE",
        preferredCountries: ['au'],
        separateDialCode: true,
        utilsScript: "/build/js/utils.js",
    });

    var watcherErrorMsg = document.querySelector("#watcher-error-msg");
    var watcherValidMsg = document.querySelector("#watcher-valid-msg");

    var watcherErrorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

    var watcherReset = function() {
        watcherInput.classList.remove("has-danger");
        watcherErrorMsg.innerHTML = "";
        watcherErrorMsg.classList.add("sr-only");
        watcherValidMsg.classList.add("sr-only");
        $("#watcher-info-msg").text("");
        $("#watcher-info-msg").addClass("sr-only");
        $("#modalWatcherFormContainer").slideUp("medium");
        $("#modalWatcherFirstName").val("");
        $("#modalWatcherLastName").val("");
        $("#modalWatcherEmail").val("");
        $("#modalVerifyWatcherPhone").attr("disabled", true);
        $("#modalWatcherStorePhoneNum").val('');
        $("#modalAddWatcherSubmit").attr("disabled", true);
        $('#watcher-email-info-msg').slideUp('slow');
        $('#watcher-email-info-msg').text("");
    };

// on blur: validate
    watcherInput.addEventListener('change', function() {
        watcherReset();
        if (watcherInput.value.trim()) {
            if (watcherIti.isValidNumber()) {
                watcherValidMsg.classList.remove("sr-only");
                $("#modalVerifyWatcherPhone").attr("disabled", false);
            } else {
                watcherInput.classList.add("has-danger");
                var watcherErrorCode = watcherIti.getValidationError();
                watcherErrorMsg.innerHTML = watcherErrorMap[watcherErrorCode];
                watcherErrorMsg.classList.remove("sr-only");
                $("#modalVerifyWatcherPhone").attr("disabled", true);
            }
        }
    });

    // on keyup / change flag: reset
    // input.addEventListener('change', reset);
    watcherInput.addEventListener('keyup', function() {
        watcherReset();
        if (watcherInput.value.trim()) {
            if (watcherIti.isValidNumber()) {
                watcherValidMsg.classList.remove("sr-only");
                $("#modalVerifyWatcherPhone").attr("disabled", false);
            } else {
                watcherInput.classList.add("watcher-phone-error");
                watcherErrorMsg.classList.remove("sr-only");
                $("#modalVerifyWatcherPhone").attr("disabled", true);
            }
        }
    });


    $(document).on("click", "#modalVerifyWatcherPhone" , function(event) {

        event.preventDefault();

        $("#modalVerifyWatcherPhone").attr("disabled", true);

        $('#addWatcherPhoneLoad').fadeIn('slow');

        var watcherNum = watcherIti.getNumber();

        var serviceId = $("#modalServiceId").val();

        $("#modalWatcherStorePhoneNum").val(watcherNum);

        var url="/verifyServiceWatcherPhone";


        $.ajax({
            url: url,
            data: {watcherNum : watcherNum,
                serviceId: serviceId},
            datatype: "json",
            method: "POST",
            success: function (data) {

                if(data.existStatus == "wearer") {

                    $("#modalNewEmail").addClass("sr-only");
                    $("#modalExistEmail").removeClass("sr-only");
                    $('#watcher-info-msg').removeClass("sr-only");
                    $('#watcher-info-msg').removeClass("text-warning");
                    $('#watcher-info-msg').addClass("text-danger");
                    $('#watcher-info-msg').text('User already registered as a wearer for this service');
                    $("#modalAddWatcherSubmit").attr("disabled", true);
                    $("#modalWatcherFirstName").prop('readonly', true);
                    $("#modalWatcherLastName").prop('readonly', true);
                    $("#modalWatcherEmail").prop('readonly', true);
                    $("#modalWatcherId").val(data.personDetails.person_id);
                    $("#modalWatcherEmail").val(data.personDetails.email);
                    $("#modalWatcherFirstName").val(data.personDetails.f_name);
                    $("#modalWatcherLastName").val(data.personDetails.l_name);
                    $("#modalExistWatcherType").addClass("sr-only");
                    $("#modalNewWatcherType").addClass("sr-only");
                    $("#modalWatcherFormContainer").slideDown("slow");


                }
                else if(data.existStatus == "watcher") {

                    $("#modalNewEmail").addClass("sr-only");
                    $("#modalExistEmail").removeClass("sr-only");
                    $('#watcher-info-msg').removeClass("sr-only");
                    $('#watcher-info-msg').removeClass("text-warning");
                    $('#watcher-info-msg').addClass("text-danger");
                    $('#watcher-info-msg').text('User already registered as a watcher for this service');
                    $("#modalAddWatcherSubmit").attr("disabled", true);
                    $("#modalWatcherFirstName").prop('readonly', true);
                    $("#modalWatcherLastName").prop('readonly', true);
                    $("#modalWatcherEmail").prop('readonly', true);
                    $("#modalWatcherId").val(data.personDetails.person_id);
                    $("#modalWatcherEmail").val(data.personDetails.email);
                    $("#modalWatcherFirstName").val(data.personDetails.f_name);
                    $("#modalWatcherLastName").val(data.personDetails.l_name);
                    $("#watcherType").text(data.watcherType);
                    $("#modalExistWatcherType").removeClass("sr-only");
                    $("#modalNewWatcherType").addClass("sr-only");
                    $("#modalWatcherFormContainer").slideDown("slow");


                }
                else if(data.existStatus == "exist") {

                    $("#modalNewEmail").addClass("sr-only");
                    $("#modalExistEmail").removeClass("sr-only");
                    $('#watcher-info-msg').removeClass("sr-only");
                    $('#watcher-info-msg').removeClass("text-danger");
                    $('#watcher-info-msg').addClass("text-warning");
                    $('#watcher-info-msg').text('User exists');
                    $("#modalAddWatcherSubmit").attr("disabled", false);
                    $("#modalWatcherFirstName").prop('readonly', true);
                    $("#modalWatcherLastName").prop('readonly', true);
                    $("#modalWatcherEmail").prop('readonly', true);
                    $("#modalWatcherId").val(data.personDetails.person_id);
                    $("#modalWatcherEmail").val(data.personDetails.email);
                    $("#modalWatcherFirstName").val(data.personDetails.f_name);
                    $("#modalWatcherLastName").val(data.personDetails.l_name);
                    $("#watcherType").text("");
                    $("#modalExistWatcherType").addClass("sr-only");
                    $("#modalNewWatcherType").removeClass("sr-only");
                    $("#modalWatcherFormContainer").slideDown("slow");


                }
                else if (data.existStatus == "new") {

                    $("#modalNewEmail").removeClass("sr-only");
                    $("#modalExistEmail").addClass("sr-only");
                    $('#watcher-info-msg').text('');
                    $('#watcher-info-msg').removeClass("sr-only");
                    $('#watcher-info-msg').removeClass("text-danger");
                    $('#watcher-info-msg').removeClass("text-warning");
                    $("#modalAddWatcherSubmit").attr("disabled", true);
                    $("#modalWatcherFirstName").prop('readonly', true);
                    $("#modalWatcherLastName").prop('readonly', true);
                    $("#modalWatcherEmail").prop('readonly', false);
                    $("#modalWatcherId").val('');
                    $("#modalWatcherEmail").val('');
                    $("#modalWatcherFirstName").val('');
                    $("#modalWatcherLastName").val('');
                    $("#watcherType").text("");
                    $("#modalExistWatcherType").addClass("sr-only");
                    $("#modalNewWatcherType").removeClass("sr-only");
                    $("#modalWatcherFormContainer").slideDown("slow");

                    $(document).on("keyup", "#modalNewWatcherEmail", function () {

                        $("#modalWatcherFirstName").prop('readonly', true);
                        $("#modalWatcherLastName").prop('readonly', true);
                        $("#modalAddWatcherSubmit").attr("disabled", true);
                        $("#modalVerifyEmail").attr("disabled", false);
                        $('#watcher-email-info-msg').slideUp('slow');
                        $('#watcher-email-info-msg').text("");

                    });

                    $(document).on("click", "#modalVerifyEmail", function (e) {

                        e.preventDefault();

                        $("#addWatcherEmailLoad").fadeIn('slow');

                        $(this).attr("disabled", true);

                        var checkEmail = $("#modalNewWatcherEmail").val();

                        var url = "/checkEmail/";

                        $.ajax({
                            url: url,
                            data: {
                                checkEmail: checkEmail,
                            },
                            datatype: "json",
                            method: "GET",
                            success: function (data) {

                                if(data.existStatus == 'exist'){

                                    $('#watcher-email-info-msg').slideDown('slow');
                                    $('#watcher-email-info-msg').text("This email is already registered with another user. Try a different one");

                                } else if(data.existStatus == 'not exist') {

                                    $('#watcher-email-info-msg').slideUp('slow');
                                    $('#watcher-email-info-msg').text("");
                                    $("#modalWatcherFirstName").prop('readonly', false);
                                    $("#modalWatcherLastName").prop('readonly', false);
                                    $("#modalAddWatcherSubmit").attr("disabled", false);

                                }

                            },
                            complete: function () {

                                $("#addWatcherEmailLoad").fadeOut("medium");

                            }
                        });
                    })

                }

            },
            complete: function () {
                $('#addWatcherPhoneLoad').hide();
            }
        });


    });

    var $validator = $('.add-new-watcher-form').validate({
        rules: {
            watcherPhone: {
                required: true,
            },
            watcherFirstName: {
                required: true,
            },
            watcherLastName: {
                required: true,
            },
            watcherEmail: {
                email: true
            },
            watcherNewEmail: {
                email: true
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-danger');
        },
        success: function(element) {
            $(element).closest('.form-group').removeClass('has-danger').addClass('has-success');
        }
    });


    function addWatcherModalClose(){

        $('#modalWatcherPhoneNum').val('');
        $('#modalVerifyWatcherPhone').attr("disabled", true);
        $('#watcher-valid-msg').addClass("sr-only");
        $('#watcher-info-msg').addClass("sr-only");
        $('#watcher-info-msg').text('');
        $("#modalAddWatcherSubmit").attr("disabled", true);
        $("#modalWatcherId").val('');
        $("#modalWatcherEmail").val('');
        $("#modalWatcherFirstName").val('');
        $("#modalWatcherLastName").val('');
        $('#watcher-email-info-msg').slideUp('fast');
        $('#watcher-email-info-msg').text("");
        $('#modalNewWatcherEmail').val("");
        $("#modalWatcherFormContainer").slideUp("fast");
        $validator.resetForm();

    }

    $("#addWatcher").on('hide.bs.modal', function(){

        addWatcherModalClose();

    });


    $(document).on("submit","#addWatcherForm", function (e) {
        e.preventDefault();

        $("#addWatcherSubmitLoad").fadeIn("slow");
        var data = $(this).serialize();

        var url = "/addNewWatcher";

        $.ajax({
            url: url,
            data: data,
            datatype: "json",
            method: "POST",
            success: function (data) {

                if(data == "success") {


                    $( "#reloadPage" ).load(window.location.href + " #reloadContent", function () {

                        addWatcherModalClose();

                        $("#addWatcherSubmitLoad").fadeOut("slow");

                        $('#addWatcher').modal('hide');


                        Swal.fire(
                            'Saved!',
                            'Watcher has been added to service.',
                            'success'
                        )

                    } );


                }

            },
            complete: function () {


            }
        });

    });


    // ----------------------- Change Priority -----------------------

    $(document).on("click", "#changeProrityOrder", function () {

        $("#openChangePriorityLoad").fadeIn("slow");

        var serviceId = $(this).attr("data-id");

        var url="/getWatchersList/";

        $.ajax({
            url: url,
            data: {serviceId},
            datatype: "json",
            method: "GET",
            success: function (data) {

                $("#watchersPriorityList").empty();

                var length = data.length;

                // $('#totalWatchersNum').text(length);

                for(i=0; i<data.length; i++){
                    var personId = data[i].person_id;
                    var personName = data[i].full_name;
                    var personPhone = data[i].phone;
                    var personEmail = data[i].email;
                    var priorityNum = data[i].priority_num;

                    var listItem =
                        "<a data-id='" + personId + "' data-priority-num='"+priorityNum+"' class='watcher-priority-list-item list-group-item-action list-group-item-action'>" +
                        "<div class='row'>" +
                        "<div class='col-12'>" +
                        "<div class='float-right'>" +
                        "<span class='badge badge-default priority-num'>" + priorityNum + "</span>" +
                        "</div>" +
                        "<h6 class='card-title'>" + personName + " &nbsp;" +
                        "<span class='card-description'>" + personPhone + "</span>" +
                        "</h6>" +
                        "<h6 class='text-muted text-lowercase'>" + personEmail + "</h6>" +
                        "</div>" +
                        "</div>" +
                        "</a>";

                    $("#watchersPriorityList").append(listItem);
                }

                $("#modalBtnSavePriorityOrder").attr("disabled", true);

                $('#modalChangePriority').modal('show');

            },
            complete: function () {
                $("#openChangePriorityLoad").fadeOut("slow");
            }
        });

    });


    $( "#watchersPriorityList" ).sortable({
        placeholder: "ui-state-highlight",
        update: function (event, ui) {
            $(this).children().each(function (index) {
                if($(this).attr('data-priority-num') != index+1){
                    $(this).attr('data-priority-num',(index+1)).addClass('updatedPriority');
                    $(this).find('.priority-num').text(index+1);
                }
            });
            $("#modalBtnSavePriorityOrder").attr("disabled", false);
        }
    });

    function saveNewPriorityOrder(serviceId){

        $("#modaSavePriorityOrderLoad").fadeIn("slow");

        var prorityChanges = [];
        $('.updatedPriority').each(function () {
            prorityChanges.push([$(this).attr('data-id'), $(this).attr('data-priority-num')]);
            $(this).removeClass('updatedPriority');

        });

        var url = "/updatePriorityOrder";

        $.ajax({
            url: url,
            method: 'post',
            datatype:'json',
            data: {
                serviceId: serviceId,
                priorityChanges: prorityChanges
            },
            success: function (data) {

                if(data == "success"){


                    $( "#reloadPage" ).load(window.location.href + " #reloadContent", function () {

                        $("#modaSavePriorityOrderLoad").fadeOut("slow");

                        $('#modalChangePriority').modal('hide');

                        Swal.fire(
                            'Changes saved!',
                            'Watcher priority order has been updated',
                            'success'

                        )


                    });

                }
            },
            complete: function () {
            }

        });

    }
    // $( "#watchersPriorityList" ).disableSelection();

    $(document).on("click", "#modalBtnSavePriorityOrder", function (e) {
        e.preventDefault();
        var serviceId = $(this).attr("data-id");

        saveNewPriorityOrder(serviceId);
    });

});

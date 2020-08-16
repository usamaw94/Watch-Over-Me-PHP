$(document).ready( function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on("click","#activateService", function () {

        var serviceId = $(this).attr("data-id");

        const url = "/adminActivateService?serviceId="+serviceId;

        Swal.fire({
            title: "Activate service ?",
            showCancelButton: "Yes",
            confirmButtonText: "Yes",
            showLoaderOnConfirm: true,
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-default'
            },
            buttonsStyling: false,
            cancelButtonText: "No",
            // reverseButtons: "Yes"

            preConfirm: function () {

                return fetch(url)
                .then(response => {

                    if (!response.ok) {
                        throw new Error(response.statusText)
                    }

                    $( "#reloadPage" ).load(window.location.href + " #reloadContent" );

                    return response.json();
                })
                    .catch(error => {
                        Swal.showValidationMessage(
                            `Request failed: ${error}`
                        )})

            },
            allowOutsideClick: () => !Swal.isLoading(),

        }).then(function (data) {

                if (data.value == "success") {

                    Swal.fire(
                        'Activated!',
                        'Service is active now',
                        'success'
                    )
                }

        })
    });


    $(document).on("click","#deactivateService", function () {

        const serviceId = $(this).attr("data-id");

        const url = "/adminDeactivateService?serviceId="+serviceId;

        Swal.fire({
            title: "Deactivate service ?",
            showCancelButton: "Yes",
            confirmButtonText: "Yes",
            showLoaderOnConfirm: true,
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-default'
            },
            buttonsStyling: false,
            cancelButtonText: "No",
            // reverseButtons: "Yes"

            preConfirm: function () {

                return fetch(url)
                    .then(response => {

                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }

                        return response.json();
                    })
                    .catch(error => {
                        Swal.showValidationMessage(
                            `Request failed: ${error}`
                        )})

            },
            allowOutsideClick: () => !Swal.isLoading(),

        }).then(function (data) {

            if (data.value == "success") {

                $( "#reloadPage" ).load(window.location.href + " #reloadContent" );

                Swal.fire(
                    'Deactivated!',
                    'Service is inactive now',
                    'success'
                )
            }

        })
    });

    // ---------------------- Add New Watcher -----------------

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
        $("#modalWatcherFormContainer").slideUp("fast");
        $validator.resetForm();

    }

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
                required: true,
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

    $(document).on("submit","#addWatcherForm", function (e) {
        e.preventDefault();

        $("#addWatcherSubmitLoad").fadeIn("slow");
        var data = $(this).serialize();

        var url = "/adminAddNewWatcher";

        $.ajax({
            url: url,
            data: data,
            datatype: "json",
            method: "POST",
            success: function (data) {

                if(data == "success") {

                    addWatcherModalClose();
                    $('#addWatcher').modal('hide');

                    $( "#reloadPage" ).load(window.location.href + " #reloadContent" );

                    Swal.fire(
                        'Saved!',
                        'Watcher has been added to service.',
                        'success'
                    )

                }

            },
            complete: function () {

                $("#addWatcherSubmitLoad").fadeOut("slow");

            }
        });

    });

    $("#addWatcher").on('hide.bs.modal', function(){

        addWatcherModalClose();

    });

    $(document).on("click","#openAddWatcherForm", function () {

        var serviceId = $(this).attr("data-id");

        $("#modalServiceId").val(serviceId);

        $("#modalAddWatcherSubmit").attr("disabled", true);

        $('#addWatcher').modal('show');

    });

    $(document).on("click", "#modalVerifyWatcherPhone" , function(event) {

        $('#addWatcherPhoneLoad').fadeIn('slow');

        var watcherNum = watcherIti.getNumber();

        var serviceId = $("#modalServiceId").val();

        $("#modalWatcherStorePhoneNum").val(watcherNum);

        var url="/adminVerifyServiceWatcherPhone";


        $.ajax({
            url: url,
            data: {watcherNum : watcherNum,
                serviceId: serviceId},
            datatype: "json",
            method: "POST",
            success: function (data) {

                if(data.existStatus == "watcher") {

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

                    $(document).on("keyup", "#modalWatcherEmail", function () {

                        $("#modalWatcherFirstName").prop('readonly', true);
                        $("#modalWatcherLastName").prop('readonly', true);
                        $("#modalAddWatcherSubmit").attr("disabled", true);

                    });

                    $(document).on("change", "#modalWatcherEmail", function () {

                        $("#addWatcherEmailLoad").slideDown("medium");

                        var checkEmail = $(this).val();

                        var url = "/adminCheckEmail/";

                        $.ajax({
                            url: url,
                            data: {
                                checkEmail: checkEmail,
                            },
                            datatype: "json",
                            method: "GET",
                            success: function (data) {

                                if(data.existStatus == 'exist'){

                                    alert("This email is already registered with another user.\nTry a different one");

                                } else if(data.existStatus == 'not exist') {

                                    $("#modalWatcherFirstName").prop('readonly', false);
                                    $("#modalWatcherLastName").prop('readonly', false);
                                    $("#modalAddWatcherSubmit").attr("disabled", false);

                                }

                            },
                            complete: function () {

                                $("#addWatcherEmailLoad").slideUp("medium");

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
        utilsScript: "build/js/utils.js",
    });

    var watcherErrorMsg = document.querySelector("#watcher-error-msg");
    var watcherValidMsg = document.querySelector("#watcher-valid-msg");

    var watcherErrorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

    var watcherReset = function() {
        watcherInput.classList.remove("watcher-phone-error");
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
    };

// on blur: validate
    watcherInput.addEventListener('change', function() {
        watcherReset();
        if (watcherInput.value.trim()) {
            if (watcherIti.isValidNumber()) {
                watcherValidMsg.classList.remove("sr-only");
                $("#modalVerifyWatcherPhone").attr("disabled", false);
            } else {
                watcherInput.classList.add("watcher-phone-error");
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


    // ----------------------- Change Priority -----------------------

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

        var url = "/adminUpdatePriorityOrder";

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

                    $('#modalChangePriority').modal('hide');

                    Swal.fire(
                        'Changes saved!',
                        'Watcher priority order has been updated',
                        'success'
                    )

                    $( "#reloadPage" ).load(window.location.href + " #reloadContent" );

                }
            },
            complete: function () {
                $("#modaSavePriorityOrderLoad").fadeOut("slow");
            }

        });

    }
    // $( "#watchersPriorityList" ).disableSelection();

    $(document).on("click", "#modalBtnSavePriorityOrder", function (e) {
        e.preventDefault();
        var serviceId = $(this).attr("data-id");

        saveNewPriorityOrder(serviceId);
    });

    $(document).on("click", "#changeProrityOrder", function () {

        $("#openChangePriorityLoad").fadeIn("slow");

        var serviceId = $(this).attr("data-id");

        var url="/adminGetWatchersList/";

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
                    var personName = data[i].f_name + " "
                        + data[i].l_name;
                    var personPhone = data[i].phone;
                    var personEmail = data[i].email;
                    var priorityNum = data[i].priority_num;

                    var listItem =
                        "<a data-id='" + personId + "' data-priority-num='"+priorityNum+"' class='list-group-item list-group-item-action'>" +
                        "<div class='row'>" +
                        "<div class='col-12'>" +
                        "<div class='float-right'>" +
                        "<span class='badge badge-default priority-num'>" + priorityNum + "</span>" +
                        "</div>" +
                        "<h6 class='card-title'>" + personName + " &nbsp;" +
                        "<span class='card-category'>" + personPhone + "</span>" +
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

});

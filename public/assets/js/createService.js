$(document).ready(function() {

    var $validator = $('.card-wizard form').validate({
        rules: {
            wearerPhone: {
                required: true,
            },
            wearerFirstName: {
                required: true,
            },
            wearerLastName: {
                required: true,
            },
            wearerEmail: {
                required: true,
                email: true
            },
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
            },
            customerPhone: {
                required: true,
            },
            customerFirstName: {
                required: true,
            },
            customerLastName: {
                required: true,
            },
            customerEmail: {
                required: true,
                email: true
            },
        },
        highlight: function(element) {
            $(element).closest('.input-group').removeClass('has-success').addClass('has-danger');
        },
        success: function(element) {
            $(element).closest('.input-group').removeClass('has-danger').addClass('has-success');
        }
    });

    // Wizard Initialization
    $('.card-wizard').bootstrapWizard({
        'tabClass': 'nav nav-pills',
        'nextSelector': '.btn-next',
        'previousSelector': '.btn-previous',

        onNext: function(tab, navigation, index) {
            // if (index == 1){
            // } else if (index == 2){
            // } else if (index == 3){
            // } else {
            // }

            var $valid = $('.card-wizard form').valid();
            if (!$valid) {
                $validator.focusInvalid();
                return false;
            }
        },

        onInit: function(tab, navigation, index) {
            //check number of tabs and fill the entire row
            var $total = navigation.find('li').length;
            var $wizard = navigation.closest('.card-wizard');

            first_li = navigation.find('li:first-child a').html();
            $moving_div = $("<div class='moving-tab'></div>");
            $moving_div.append(first_li);
            $('.card-wizard .wizard-navigation').append($moving_div);



            refreshAnimation($wizard, index);

            $('.moving-tab').css('transition', 'transform 0s');
        },

        onTabClick: function(tab, navigation, index) {
            var $valid = $('.card-wizard form').valid();

            if (!$valid) {
                return false;
            } else {
                return true;
            }
        },

        onTabShow: function(tab, navigation, index) {
            var $total = navigation.find('li').length;
            var $current = index + 1;

            var $wizard = navigation.closest('.card-wizard');

            // If it's the last tab then hide the last button and show the finish instead
            if ($current >= $total) {
                $($wizard).find('.btn-next').hide();
                $($wizard).find('.btn-finish').show();
            } else {
                if($current == 1){
                    if ($("#wearerDetailsFormCheck").val() == "show") {
                            $("#nextTab").attr("disabled", false);
                    } else {
                        $("#nextTab").attr("disabled", true);
                    }
                } else if($current == 2){
                    if ($("#watcherDetailsFormCheck").val() == "show") {
                        $("#nextTab").attr("disabled", false);
                    } else {
                        $("#nextTab").attr("disabled", true);
                    }
                } else if($current == 3){
                    $("#nextTab").attr("disabled", true);
                } else if($current == 4){

                }
                $($wizard).find('.btn-next').show();
                $($wizard).find('.btn-finish').hide();
            }

            button_text = navigation.find('li:nth-child(' + $current + ') a').html();

            setTimeout(function() {
                $('.moving-tab').html(button_text);
            }, 150);

            var checkbox = $('.footer-checkbox');

            if (!index == 0) {
                $(checkbox).css({
                    'opacity': '0',
                    'visibility': 'hidden',
                    'position': 'absolute'
                });
            } else {
                $(checkbox).css({
                    'opacity': '1',
                    'visibility': 'visible'
                });
            }

            refreshAnimation($wizard, index);
        }
    });


    // Prepare the preview for profile picture
    $("#wizard-picture").change(function() {
        readURL(this);
    });

    $('[data-toggle="wizard-radio"]').click(function() {
        wizard = $(this).closest('.card-wizard');
        wizard.find('[data-toggle="wizard-radio"]').removeClass('active');
        $(this).addClass('active');
        $(wizard).find('[type="radio"]').removeAttr('checked');
        $(this).find('[type="radio"]').attr('checked', 'true');

    });

    $('[data-toggle="wizard-checkbox"]').click(function() {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $(this).find('[type="checkbox"]').removeAttr('checked');
        } else {
            $(this).addClass('active');
            $(this).find('[type="checkbox"]').attr('checked', 'true');
        }
    });

    $('.set-full-height').css('height', 'auto');

    //Function to show image before upload

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(window).resize(function() {
        $('.card-wizard').each(function() {
            $wizard = $(this);

            index = $wizard.bootstrapWizard('currentIndex');
            refreshAnimation($wizard, index);

            $('.moving-tab').css({
                'transition': 'transform 0s'
            });
        });
    });

    function refreshAnimation($wizard, index) {
        $total = $wizard.find('.nav li').length;
        $li_width = 100 / $total;

        total_steps = $wizard.find('.nav li').length;
        move_distance = $wizard.width() / total_steps;
        index_temp = index;
        vertical_level = 0;

        mobile_device = $(document).width() < 600 && $total > 3;

        if (mobile_device) {
            move_distance = $wizard.width() / 2;
            index_temp = index % 2;
            $li_width = 50;
        }

        $wizard.find('.nav li').css('width', $li_width + '%');

        step_width = move_distance;
        move_distance = move_distance * index_temp;

        $current = index + 1;

        // if($current == 1 || (mobile_device == true && (index % 2 == 0) )){
        //     move_distance -= 8;
        // } else if($current == total_steps || (mobile_device == true && (index % 2 == 1))){
        //     move_distance += 8;
        // }

        if (mobile_device) {
            vertical_level = parseInt(index / 2);
            vertical_level = vertical_level * 38;
        }

        $wizard.find('.moving-tab').css('width', step_width);
        $('.moving-tab').css({
            'transform': 'translate3d(' + move_distance + 'px, ' + vertical_level + 'px, 0)',
            'transition': 'all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1)'

        });
    }

    setTimeout(function() {
        $('.card.card-wizard').addClass('active');
    }, 600);

    // ----------------- Wearer Tab ---------------------

    $(document).on("click", "#wearerCheckNumberBtn" , function(event) {

        var wearerNum = iti.getNumber();
        var url="adminCheckWearerPhone/"+ wearerNum;

        var watcherPhoneValue = watcherIti.getNumber();

        var customerPhoneValue = customerIti.getNumber();

        if(watcherPhoneValue == wearerNum){
            $("#watcherPhoneNum").val("");
            $("watcherDetailsFormCheck").val("hide");
        }

        if(customerPhoneValue == wearerNum){
            $("customerPhoneNum").val("");
            $("customerDetailsFormCheck").val("hide");
        }

        $.ajax({
            url:url,
            data:{wearerNum},
            datatype:"json",
            method:"GET",
            success:function(data) {

                if (data.existStatus == 'not exist'){

                    $('#wearer-info-msg').text('');
                    $('#wearer-info-msg').addClass('sr-only');
                    $("#wearerFirstName").prop('readonly', false);
                    $("#wearerLastName").prop('readonly', false);
                    $("#wearerEmail").prop('readonly', false);
                    $("#wearerDetailsForm").slideDown("medium");
                    $("#wearerDetailsFormCheck").val("show");
                    var wearerNum = iti.getNumber();
                    $("#wearerStorePhoneNum").val(wearerNum);
                    $("#nextTab").attr("disabled", false);
                    $("#wearerExistStatus").val(data.existStatus);

                } else if (data.existStatus == 'exist'){

                    $('#wearer-info-msg').text('*User already exist');
                    $('#wearer-info-msg').removeClass('sr-only');
                    $("#wearerFirstName").prop('readonly', true);
                    $("#wearerLastName").prop('readonly', true);
                    $("#wearerEmail").prop('readonly', true);

                    $("#wearerExistStatus").val(data.existStatus);
                    $("#wearerId").val(data.personDetails.person_id);
                    $("#wearerFirstName").val(data.personDetails.f_name);
                    $("#wearerLastName").val(data.personDetails.l_name);
                    $("#wearerEmail").val(data.personDetails.email);


                    $("#wearerDetailsForm").slideDown("medium");
                    $("#wearerDetailsFormCheck").val("show");
                    var wearerNum = iti.getNumber();
                    $("#wearerStorePhoneNum").val(wearerNum);
                    $("#nextTab").attr("disabled", false);

                } else if(data.existStatus == 'wearer')  {

                    $('#wearer-info-msg').text('*User already registered as a wearer');
                    $('#wearer-info-msg').removeClass('sr-only');
                    $("#wearerFirstName").prop('readonly', true);
                    $("#wearerLastName").prop('readonly', true);
                    $("#wearerEmail").prop('readonly', true);

                    $("#wearerExistStatus").val(data.existStatus);
                    $("#wearerId").val(data.personDetails.person_id);
                    $("#wearerFirstName").val(data.personDetails.f_name);
                    $("#wearerLastName").val(data.personDetails.l_name);
                    $("#wearerEmail").val(data.personDetails.email);

                    $("#wearerDetailsForm").slideDown("medium");
                    $("#wearerDetailsFormCheck").val("show");
                    var wearerNum = iti.getNumber();
                    $("#wearerStorePhoneNum").val(wearerNum);
                    $("#nextTab").attr("disabled", true);
                }
            }
        });

    });

    var input = document.querySelector("#wearerPhoneNum");
    var iti = window.intlTelInput(input, {
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

    var errorMsg = document.querySelector("#error-msg");
    var validMsg = document.querySelector("#valid-msg");

    var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

    var reset = function() {
        input.classList.remove("weare-phone-error");
        errorMsg.innerHTML = "";
        errorMsg.classList.add("sr-only");
        validMsg.classList.add("sr-only");
        $('#wearer-info-msg').text('');
        $('#wearer-info-msg').addClass('sr-only');
        $("#wearerDetailsForm").slideUp("medium");
        $("#wearerDetailsFormCheck").val("hide");
        $("#nextTab").attr("disabled", true);
        $("#wearerFirstName").val("");
        $("#wearerLastName").val("");
        $("#wearerEmail").val("");
        $("#wearerCheckNumberBtn").attr("disabled", true);
    };

// on blur: validate
    input.addEventListener('change', function() {
        reset();
        if (input.value.trim()) {
            if (iti.isValidNumber()) {
                validMsg.classList.remove("sr-only");
                $("#wearerCheckNumberBtn").attr("disabled", false);
            } else {
                input.classList.add("weare-phone-error");
                var errorCode = iti.getValidationError();
                errorMsg.innerHTML = errorMap[errorCode];
                errorMsg.classList.remove("sr-only");
                $("#wearerCheckNumberBtn").attr("disabled", true);
            }
        }
    });

// on keyup / change flag: reset
    // input.addEventListener('change', reset);
    input.addEventListener('keyup', function() {
        reset();
        if (input.value.trim()) {
            if (iti.isValidNumber()) {
                validMsg.classList.remove("sr-only");
                $("#wearerCheckNumberBtn").attr("disabled", false);
            } else {
                input.classList.add("weare-phone-error");
                var errorCode = iti.getValidationError();
                errorMsg.classList.remove("sr-only");
                $("#wearerCheckNumberBtn").attr("disabled", true);
            }
        }
    });
    // input.addEventListener('keyup', reset);


    // ----------------- Watcher Tab ---------------------


    $(document).on("click", "#watcherCheckNumberBtn" , function(event) {

        var wearerNum = iti.getNumber();
        var watcherNum = watcherIti.getNumber();

        if(watcherNum == wearerNum) {
            $('#watcher-info-msg').html('*This number has already registered for wearer <br> Wearer cannot become watcher');
            $('#watcher-info-msg').removeClass('sr-only');
        } else {
            var url="adminCheckWatcherPhone/"+ watcherNum;

            $.ajax({
                url: url,
                data: {watcherNum},
                datatype: "json",
                method: "GET",
                success: function (data) {


                    if (data.existStatus == 'not exist'){

                        $('#watcher-info-msg').text('');
                        $('#watcher-info-msg').addClass('sr-only');
                        $("#watcherFirstName").prop('readonly', false);
                        $("#watcherLastName").prop('readonly', false);
                        $("#watcherEmail").prop('readonly', false);
                        $("#watcherDetailsForm").slideDown("medium");
                        $("#watcherDetailsFormCheck").val("show");
                        var watcherNum = watcherIti.getNumber();
                        $("#watcherStorePhoneNum").val(watcherNum);
                        $("#nextTab").attr("disabled", false);
                        $("#watcherExistStatus").val(data.existStatus);

                    } else if (data.existStatus == 'exist'){

                        $('#watcher-info-msg').text('*User already exist');
                        $('#watcher-info-msg').removeClass('sr-only');
                        $("#watcherFirstName").prop('readonly', true);
                        $("#watcherLastName").prop('readonly', true);
                        $("#watcherEmail").prop('readonly', true);

                        $("#watcherExistStatus").val(data.existStatus);
                        $("#watcherId").val(data.personDetails.person_id);
                        $("#watcherFirstName").val(data.personDetails.f_name);
                        $("#watcherLastName").val(data.personDetails.l_name);
                        $("#watcherEmail").val(data.personDetails.email);


                        $("#watcherDetailsForm").slideDown("medium");
                        $("#watcherDetailsFormCheck").val("show");
                        var watcherNum = watcherIti.getNumber();
                        $("#watcherStorePhoneNum").val(watcherNum);
                        $("#nextTab").attr("disabled", false);

                    }

                }
            });
        }
    });

    var watcherInput = document.querySelector("#watcherPhoneNum");
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
        $('#watcher-info-msg').text('');
        $('#watcher-info-msg').addClass('sr-only');
        $("#watcherDetailsForm").slideUp("medium");
        $("#watcherDetailsFormCheck").val("hide");
        $("#nextTab").attr("disabled", true);
        $("#watcherFirstName").val("");
        $("#watcherLastName").val("");
        $("#watcherEmail").val("");
        $("#watcherCheckNumberBtn").attr("disabled", true);

    };

// on blur: validate
    watcherInput.addEventListener('change', function() {
        watcherReset();
        if (watcherInput.value.trim()) {
            if (watcherIti.isValidNumber()) {
                watcherValidMsg.classList.remove("sr-only");
                $("#watcherCheckNumberBtn").attr("disabled", false);
            } else {
                watcherInput.classList.add("watcher-phone-error");
                var watcherErrorCode = watcherIti.getValidationError();
                watcherErrorMsg.innerHTML = watcherErrorMap[watcherErrorCode];
                watcherErrorMsg.classList.remove("sr-only");
                $("#watcherCheckNumberBtn").attr("disabled", true);
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
                $("#watcherCheckNumberBtn").attr("disabled", false);
            } else {
                watcherInput.classList.add("watcher-phone-error");
                watcherErrorMsg.classList.remove("sr-only");
                $("#watcherCheckNumberBtn").attr("disabled", true);
            }
        }
    });
    // input.addEventListener('keyup', reset);


    // ----------------- Customer Tab ---------------------



    $(document).on("click","#wearerCustomer", function () {
        $("#otherCustomerTab").slideUp("slow");
        $("#nextTab").attr("disabled", false);
    });

    $(document).on("click","#watcherCustomer", function () {
        $("#otherCustomerTab").slideUp("slow");
        $("#nextTab").attr("disabled", false);
    });

    $(document).on("click","#otherCustomer", function () {
        $("#otherCustomerTab").slideDown("slow");
        $("#nextTab").attr("disabled", true);
    });


    $(document).on("click", "#customerCheckNumberBtn" , function(event) {

        $("#customerDetailsForm").slideDown("medium");
        $("#customerDetailsFormCheck").val("show");
        $("#nextTab").attr("disabled", false);
        var customerNum = customerIti.getNumber();
        alert(customerNum);

    });

    var customerInput = document.querySelector("#customerPhoneNum");
    var customerIti = window.intlTelInput(customerInput, {
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

    var customerErrorMsg = document.querySelector("#customer-error-msg");
    var customerValidMsg = document.querySelector("#customer-valid-msg");

    var customerErrorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

    var customerReset = function() {
        customerInput.classList.remove("customer-phone-error");
        customerErrorMsg.innerHTML = "";
        customerErrorMsg.classList.add("sr-only");
        customerValidMsg.classList.add("sr-only");
        $("#customerDetailsForm").slideUp("medium");
        $("#customerDetailsFormCheck").val("hide");
        $("#nextTab").attr("disabled", true);
        $("#customerFirstName").val("");
        $("#customerLastName").val("");
        $("#customerEmail").val("");
        $("#customerCheckNumberBtn").attr("disabled", true);
    };

// on blur: validate
    customerInput.addEventListener('change', function() {
        customerReset();
        if (customerInput.value.trim()) {
            if (customerIti.isValidNumber()) {
                customerValidMsg.classList.remove("sr-only");
                $("#customerCheckNumberBtn").attr("disabled", false);
            } else {
                customerInput.classList.add("customer-phone-error");
                var customerErrorCode = customerIti.getValidationError();
                customerErrorMsg.innerHTML = customerErrorMap[customerErrorCode];
                customerErrorMsg.classList.remove("sr-only");
                $("#customerCheckNumberBtn").attr("disabled", true);
            }
        }
    });

// on keyup / change flag: reset
    // input.addEventListener('change', reset);
    customerInput.addEventListener('keyup', function() {
        customerReset();
        if (customerInput.value.trim()) {
            if (customerIti.isValidNumber()) {
                customerValidMsg.classList.remove("sr-only");
                $("#customerCheckNumberBtn").attr("disabled", false);
            } else {
                customerInput.classList.add("customer-phone-error");
                customerErrorMsg.classList.remove("sr-only");
                $("#customerCheckNumberBtn").attr("disabled", true);
            }
        }
    });
    // input.addEventListener('keyup', reset);

});

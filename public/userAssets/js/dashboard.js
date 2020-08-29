$(document).ready(function () {
    // function alertLogNotification(from,align){

    window.Echo.channel('notifyAlertLog.'+$('#userCredentials').attr('data-id'))
        .listen('NewAlertLog', (e) => {

            alert("notification received");

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


        });

    $(document).on("click", "#showNotification", function () {

        color = 'danger';
        $.notify({
            icon:"add_alert",
            message:"Wearer: <b>"+ e.wearerName +"</b> needs your help.</br>" +
                "Service ID: <b>"+ e.serviceId +"<b><br>" +
                "Created at: "+ e.created_at +"<br>" +
                "<b>Click this dialogue to respond</b>",
            url: "https://www.google.com/",
        }, {
            type: color,
            timer:5000,
            placement: {
                from:'top',
                align:'right'
            }
        });
    });
    // }
});

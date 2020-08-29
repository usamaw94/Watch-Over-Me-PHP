$(document).ready(function () {
    // function alertLogNotification(from,align){

    // window.Echo.channel('notifyAlertLog.'+$('#userId').text())
    //     .listen('NewAlertLog', (e) => {
    //
    //         alert("notification received");
    //
    //         console.log(e);
    //
    //         $.notify({
    //             icon: "nc-icon nc-bell-55",
    //             message: "Wearer: <b>"+ e.wearerName +"</b> needs your help.</br>" +
    //                 "Service ID: <b>"+ e.serviceId +"<b><br>" +
    //                 "Created at: "+ e.created_at +"<br>" +
    //                 "<b>Click this dialogue to respond</b>",
    //             url: "https://www.google.com/",
    //
    //         }, {
    //             type: 'danger',
    //             timer: 5000,
    //             placement: {
    //                 from: 'top',
    //                 align: 'right'
    //             }
    //         });
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

    $(document).on("click", "#showNotification", function () {

        color = 'danger';
        $.notify({
            icon:"add_alert",
            message:"Wearer: <b>Usama Waheed</b> needs your help.</br>" +
                "Service ID: <b>WOM001<b><br>" +
                "Created at: 01/02/2020 - 14:00<br>" +
                "<b>Click this dialogue to respond</b>",
            url:"https://www.google.com/",
        }, {
            type: color,
            timer:5000,
            placement: {
                from:'top',
                align:'right'
            }
        })
    });
    // }
});

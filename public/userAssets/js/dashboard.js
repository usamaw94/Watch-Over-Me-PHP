$(document).ready(function () {
    // function alertLogNotification(from,align){

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

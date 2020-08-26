<!DOCTYPE html>
<html lang="en">
<head>

    <!-- orange #fb7500
    //blue #025ead

    -->

    <style>
        body {
            font-family: 'Arial';
            margin: 0px;
        }

        .table-container {
            background: #e1e1e6;
            padding-top: 20px;
            padding-bottom: 20px;
        }
        .table {
            border-collapse: collapse;
            background: white;
            width: 80%;
            margin-left: 10%;
        }

        .table-head {
            border:2px solid #4e9fd1;
            color: #4e9fd1;
            text-align: left;
            font-weight: normal;
            padding: 20px;
            font-size: 25px;
        }

        .left-space {
            margin-left: 12px;
        }

        td, th {
            padding: 12px;
            border-bottom: 1px solid #e1e1e6;
        }

        .text-blue {
            color: #4e9fd1;
        }
        .text-dark-blue {
            color: #4975aa;
        }

        .text-purple {
            color: #595386;
        }
    </style>

</head>

<body>

<div>
    <h2 class="text-dark-blue left-space">
        <strong>Dear {{  $contactName }},</strong></h2>
    <h4 class="left-space">Your new <b>Watch Over Me Service</b> has been created.</h4>
    <h5>Service details</h5>
    <br>
    <div class="table-container">
        <table class="table">
            <tr>
                <th align="left">Service ID:</th>
                <td>{{  $serviceId }}</td>
            </tr>


            <tr>
                <th class="table-head" colspan="2">
                    Wearer Details
                </th>
            </tr>
            <tr>
                <th align="left">Name:</th>
                <td><b>{{  $wearerFullName }}</b></td>
            </tr>
            <tr>
                <th align="left">Phone:</th>
                <td><b>{{  $wearerPhone }}</b></td>
            </tr>
            <tr>
                <th align="left">Email:</th>
                <td><b>{{  $wearerEmail }}</b></td>
            </tr>


            <tr>
                <th class="table-head" colspan="2">
                    Watcher Details
                </th>
            </tr>
            <tr>
                <th align="left">Name:</th>
                <td><b>{{  $watcherFullName }}</b></td>
            </tr>
            <tr>
                <th align="left">Phone:</th>
                <td><b>{{  $watcherPhone }}</b></td>
            </tr>
            <tr>
                <th align="left">Email:</th>
                <td><b>{{  $watcherEmail }}</b></td>
            </tr>

            <tr>
                <th class="table-head" colspan="2">
                    Customer Details
                </th>
            </tr>

    @if($customerType == "wearer")

                <tr>
                    <td colspan="2">
                        Wearer is the customer for service
                    </td>
                </tr>

    @elseif($customerType == "watcher")

                <tr>
                    <td colspan="2">
                        Watcher is the customer for service
                    </td>
                </tr>

    @else

                <tr>
                    <th align="left">Name:</th>
                    <td><b>{{  $wearerFullName }}</b></td>
                </tr>
                <tr>
                    <th align="left">Phone:</th>
                    <td><b>{{  $wearerPhone }}</b></td>
                </tr>
                <tr>
                    <th align="left">Email:</th>
                    <td><b>{{  $wearerEmail }}</b></td>
                </tr>

    @endif
        </table>
    </div>
    <center>
        <h1><span class="text-blue">Watch</span> <span class="text-dark-blue">Over</span> <span class="text-purple">ME</span></h1>
    </center>
</div>

</body>
</html>

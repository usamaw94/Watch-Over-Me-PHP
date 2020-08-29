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

        a{
            color: #fff;
        }

        .verify-link{
            background-color:#4975aa;
            border: #B80C4D;
            font-family: Arial, Geneva, Arial, Helvetica,  sans-serif;
            color: #fff;
            letter-spacing: 1px;
            padding: 8px 12px;
            font-size: 20px;
            font-weight: normal;
            border-radius: 4px;
            line-height: 1.5;
            text-decoration:none
        }
    </style>

</head>

<body>

<div>
    <h2 class="text-dark-blue left-space">
        <strong>Dear {{  $watcherFName }},</strong></h2>
    <h4 class="left-space">{{  $wearerFullNme }} has request for help. Please respond as soon as possible</h4>
    <br>
    <a href="{{ $respondingLink }}" class="verify-link">Respond</a>
    <center>
        <h1><span class="text-blue">Watch</span> <span class="text-dark-blue">Over</span> <span class="text-purple">ME</span></h1>
    </center>
</div>

</body>
</html>

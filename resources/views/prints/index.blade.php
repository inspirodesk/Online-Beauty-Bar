<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prints</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @page {
            size: A4;
            margin: 10mm;
        }
        @media print {
            html, body {
                width: 210mm;
                height: 297mm;
                margin: 0;
                padding: 0;
                color: #000;
                background-color: #fff;
            }
            body {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                line-height: 1.1;
            }
            .container {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
                width: 100%;
                height: 100%;
                box-sizing: border-box;
                page-break-inside: avoid;
            }
            .box {
                width: 49%;
                box-sizing: border-box;
                border: 1px solid #000;
                padding: 10px;
                page-break-inside: avoid;
                height: 63%; /* Adjust height to fit within the page */
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                background-color: #fff;
                color: #000;
            }
            .logo {
                text-align: center;
                margin-bottom: 5px;
            }
            .logo img {
                max-width: 100%;
                height: auto;
            }
            .details {
                text-align: center;
                font-size: 29px;
                font-weight: bold;
            }
            .info {
                font-size: 26px;
                line-height: 1;
            }
            .highlight {
                color: red;
                font-weight: bold;
            }
            .footer {
                font-size: 19px;
                text-align: center;
                line-height: 1;
            }
            .page-break {
                page-break-before: always;
                margin: 10px;
            }
        }
        .no-print {
            display: none;
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="btn btn-primary no-print">Print</button>
    <div class="container">
        @foreach ($customers as $customer)
            <div class="box" style="font-size:23px;padding-top:18px">
                <table border="2">
                    <tr>
                        <td><img src="https://cdn.inspirodesk.host/obb/obb.png" alt="Logo" width="190px"></td>
                    </tr>
                    <tr >
                        <td style="padding: 15px"><strong><u>Recipient Details</u></strong><br><br>
                            <strong>Name:</strong> {{ $customer->name }}<br><strong>Address:</strong> {{ $customer->address }}<br><strong>Phone No:</strong> {{ $customer->phone_no }}<br><br>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 15px"><u><strong>From</u></strong><br><br>
                            <strong>Name:</strong> Online Beauty Bar<br>
                            <strong>Address:</strong><br> 53/15/CT, Peer Saibo Street Colombo 12<br>
                            <strong>Contact No:</strong> 94752070907<br><strong>Total:</strong>
                        @if($customer->payment_status ==='completed')
                            Paid
                        @else
                            {{ $customer->payment }}
                        @endif
                        <br><br>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 15px">
                            IF CUSTOMER NOT REACHABLE DO NOT RETURN THE PACKAGE. PLEASE INFORM OUR HOTLINE<strong> 0752070907/ 0757992707/ 0760607096</strong>
                        </td>
                    </tr>
                </table>
            </div>
            @if ($loop->iteration % 4 == 0 && !$loop->last)
                <div class="page-break"></div>
            @endif
        @endforeach
    </div>
</body>
</html>

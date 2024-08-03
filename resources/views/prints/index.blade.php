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
            margin: 10px;
        }
        @media print {
            html, body {
                width: 210mm;
                height: 297mm;
                margin: 0;
                padding: 0;
                color: #000;
            }
            body {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                line-height: 1.1; /* Reduced line height for the entire body */
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
                width: 48%;
                box-sizing: border-box;
                border: 1px solid #000;
                padding: 5px;
                page-break-inside: avoid;
                height: calc(50% - 10px); /* Adjust height to fit within the page */
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
                font-size: 20px;
                font-weight: bold;
            }
            .info {
                font-size: 18px;
                line-height: 1; /* Further reduced line height */
            }
            .highlight {
                color: red;
                font-weight: bold;
            }
            .footer {
                font-size: 14px;
                text-align: center;
                line-height: 1; /* Further reduced line height */
            }
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="btn btn-primary no-print">Print</button>
    <div class="container">
        @foreach ($customers as $customer)
            <div class="box">
                <div class="logo">
                    <img src="{{ asset('storage/obb.png') }}" alt="Logo" width="150px">
                </div>
                <div class="details">CUSTOMER DETAILS</div>
                <div class="info"><strong>Name:</strong> {{ $customer->name }}</div>
                <div class="info"><strong>Address:</strong> {{ $customer->address }}</div>
                <div class="info"><strong>Phone No:</strong> {{ $customer->phone_no }}</div>
                <div class="info"><strong>Total:</strong>  </div>
                <div class="footer">
                    IF CUSTOMER NOT REACHABLE DO NOT RETURN THE PACKAGE. PLEASE INFORM OUR HOTLINE 0752070907/ 0757992707/ 0760607096
                </div>
            </div>
            @if ($loop->iteration % 4 == 0 && !$loop->last)
                <div class="page-break"></div>
            @endif
        @endforeach
    </div>
</body>
</html>

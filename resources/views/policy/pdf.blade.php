<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Policy Document</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 100%;
            max-width: 800px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 2px solid #f4f4f4;
            padding-bottom: 10px;
        }

        .header h1 {
            font-size: 30px;
            color: #333;
            margin: 0;
        }

        .header p {
            font-size: 16px;
            color: #555;
            margin: 0;
        }

        .section-title {
            color: #333;
            border-bottom: 2px solid #f4f4f4;
        }

        .policy-details, .vehicle-details {
            width: 100%;
            border-collapse: collapse;
        }

        .policy-details th, .vehicle-details th {
            text-align: left;
            font-weight: bold;
            background-color: #f7f7f7;
            padding: 8px;
            border: 1px solid #ddd;
        }

        .policy-details td, .vehicle-details td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .signature {
            margin-top: 15px;
            text-align: center;
        }

        .signature p {
            font-size: 18px;
            color: #555;
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: center;
            padding: 10px;
            background-color: #f4f4f4;
            font-size: 14px;
            color: #777;
        }

        .footer-text {
            margin-top: 5px;
        }

        .footer-text small {
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h1>Car4Sure Policy Document</h1>
            <p>Policy Number: {{ $policy->policy_no }}</p>
            <p><strong>Effective Date:</strong> {{ $policy->policy_effective_date }} <strong>Expiry Date:</strong> {{ $policy->policy_expiration_date }}</p>
        </div>

        <div class="section-title">
            <h3>Policy Holder Information</h3>
        </div>
        <table class="policy-details">
            <tr>
                <th>Full Name</th>
                <td>{{ $policy->policyHolder->first_name }} {{ $policy->policyHolder->last_name }}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>
                    {{ $policy->policyHolder->street . ', ' . $policy->policyHolder->city . ', ' . $policy->policyHolder->state . ', ' . $policy->policyHolder->zip}}
                </td>
            </tr>
        </table>

        <div class="section-title">
            <h3>Policy Details</h3>
        </div>
        <table class="policy-details">
            <tr>
                <th>Policy Type</th>
                <td>{{ $policy->policy_type }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $policy->policy_status }}</td>
            </tr>
            <tr>
                <th>Effective Date</th>
                <td>{{ $policy->policy_effective_date }}</td>
            </tr>
            <tr>
                <th>Expiration Date</th>
                <td>{{ $policy->policy_expiration_date }}</td>
            </tr>
        </table>

        <div class="section-title">
            <h3>Vehicles Covered</h3>
        </div>
        <table class="vehicle-details">
            <tr>
                <th>Make</th>
                <th>Model</th>
                <th>Year</th>
            </tr>
            @foreach ($policy->vehicles as $vehicle)
                <tr>
                    <td>{{ $vehicle->make }}</td>
                    <td>{{ $vehicle->model }}</td>
                    <td>{{ $vehicle->year }}</td>
                </tr>
            @endforeach
        </table>

        <div class="section-title">
            <h3>Coverage Information</h3>
        </div>
        <table class="policy-details">
            <tr>
                <th>Coverage Type</th>
                <th>Limit</th>
            </tr>
            @foreach ($policy->vehicles as $vehicle)
                @foreach ($vehicle->coverages as $coverage)
                    <tr>
                        <td>{{ $coverage->type }}</td>
                        <td>{{ $coverage->limit }}</td>
                    </tr>
                @endforeach
            @endforeach
        </table>

        <div class="signature">
            <p>Authorized Signature</p>
            <p>___________________________</p>
        </div>
    </div>

    <footer>
        <p>Car4Sure - Insurance Policy</p>
        <div class="footer-text">
            <small>&copy; {{ now()->year }} All rights reserved.</small>
        </div>
    </footer>

</body>
</html>
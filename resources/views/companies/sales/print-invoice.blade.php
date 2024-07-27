<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Print Receipt</title>
    <style>
        html, body, table {
            margin: 0;
            padding: 0;
            font-size: 12px;
            background-color: #fff;
        }

        #products {
            width: 100%;
        }

        #products tr td {
            font-size: 12px;
        }

        #printbox {
            width: 280px;
            margin: 5pt;
            padding: 5px;
            text-align: justify;
        }

        /* .inv_info tr th td {
            padding-right: 10pt;
            border: 1px solid #dddddd;
            text-align: left;
        } */

        .inv_info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .inv_info th, .inv_info td {
            padding: 4px 6px;
            text-align: left;
            word-wrap: break-word;
        }

        .inv_info th {
            background-color: #f9f9f9;
        }

        .product_row {
            margin: 15pt;
        }

        .stamp {
            margin: 5pt;
            padding: 3pt;
            border: 3pt solid #111;
            text-align: center;
            font-size: 20pt;
            color
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>

<div id='printbox'>
    <h3 style="margin-top:0" class="text-center">R E C E I P T<br><b style="font-size: 10px;"></b></h3>
    <h3 style="margin-top:0" class="text-center">{{ $company->name }} Cooperative<br><b style="font-size: 10px;"> {{ $farmer->center_name }} Center<br>Meru, Kenya.</b></h3>
    <p style="font-size: 10px; text-align: center; !important">TEL: 0795 974 284<br>Email: info@cowango.org</p></h3>
    &nbsp;

    <table class="inv_info">
        <tr>
            <td>Invoiced To:</td>
            <td>{{ $farmer->fname . " " . $farmer->lname }}</td>
        </tr>
        <tr>
            <td>Farmer Code:</td>
            <td>{{ $farmer->farmerID }}</td>
        </tr>
        <tr>
            <td>Invoice no:</td>
            <td># {{ $sale_details->transaction_id }}</td>
        </tr>
        <tr>
            <td>Date: </td>
            <td>{{ format_date($sale_details->order_date) }}<br></td>
        </tr>
    </table>

    <hr>
   
    <table class="inv_info">
        <thead>
            <tr>
                <th>#</th>
                <th>Item</th>
                <th>Qty</th>
                <th>@</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php $totalCost = 0; @endphp
            @foreach (json_decode($items, true) as $key => $item)  
                <tr class="text-center">
                    <td style="width: 5%;">{{ ++$key }}</td>
                    <td style="width: 35%;">{{ $item['item_name'] }}</td>
                    <td style="width: 10%;">{{ $item['qty'] }}</td>
                    <td style="width: 20%;" class="text-right">{{ num_format($item['unit_cost']) }}</td>
                    <td style="width: 30%;" class="text-right">{{ num_format($item['total_cost']) }}</td>
                </tr>
                @php $totalCost += $item['total_cost']; @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="1"></td>
                <td><b>Total</b></td>
                <td></td>
                <td></td>
                <td><b>{{ num_format($totalCost) }}</b></td>
            </tr>
        </tfoot>
    </table>
    
    <hr>
    <table>
        <tr>
            <td>Invoiced by: </td>
            <td></td>
        </tr>
        <tr>
            <td>Stamp: </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3">
                &nbsp;
            </td>
        </tr>
    </table>
    <hr>
</div>

<script>
    window.onload = function() {
        window.print();
    };
</script>

</body>
</html>

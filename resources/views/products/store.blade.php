<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Packing Results</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Packing Results</h1>





    @if (count($packedBoxes) > 0)
        <table>
            <thead>
                <tr>
                    <th>Box Name</th>
                    <th>Dimensions (LxWxH cm)</th>
                    <th>Weight Limit (kg)</th>
                    <th>Total Volume</th>
                    <th>Packed Products</th>
                </tr>
            </thead>
            <tbody>
                @php

                @endphp
                @foreach ($packedBoxes as $packedBox)
                    <tr>
                        @php

                        @endphp
                        <td>{{ $packedBox['box']['name'] }}</td>
                        <td>{{ $packedBox['box']['length'] }}x{{ $packedBox['box']['width'] }}x{{ $packedBox['box']['height'] }}
                        </td>
                        <td>{{ $packedBox['box']['weight_limit'] }}</td>
                        <td>{{ $packedBox['box']['total_volume'] }}</td>
                        <td>
                            <ul>
                                @foreach ($packedBox['products'] as $key => $product)
                                    <li>
                                        Product {{ $key }}: Dimensions
                                        {{ $product['length'] }}x{{ $product['width'] }}x{{ $product['height'] }},
                                        Weight {{ $product['weight'] }}kg, Quantity {{ $product['quantity'] }}
                                        <br>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No boxes available to pack the products.</p>
    @endif




    @if (count($unfitProducts) > 0)


        <h1>Unfit Products</h1>


        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Length</th>
                    <th>Width</th>
                    <th>Height</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                @php

                @endphp
                @foreach ($unfitProducts as $key => $unfitProduct)
                    <tr>
                        <td>Product: {{ $key }}</td>
                        <td>{{ $unfitProduct['length'] }}</td>
                        <td>{{ $unfitProduct['width'] }}</td>
                        <td>{{ $unfitProduct['height'] }}</td>
                        <td>{{ $unfitProduct['quantity'] }}</td>

                    </tr>
                @endforeach

            </tbody>
        </table>


    @endif



    @if ($status == 'error' || $status == 'success')
        <h2>Result: <span style="color: {{ $status == 'error' ? 'red' : 'green' }}">{{ $status }}</span></h2>
    @endif




</body>

</html>

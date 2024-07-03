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
        th, td {
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

    <form method="POST" action="{{ route('products.store') }}">
        @csrf
        <div id="product-inputs">
            <h2>Guide</h2>
    
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Length (cm)</th>
                        <th>Width (cm)</th>
                        <th>Height (cm)</th>
                        <th>Weight Limit (kg)</th>
                        <th>Total Volume</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($boxes as $box)
                        <tr>
                            <td>{{ $box['name'] }}</td>
                            <td>{{ $box['length'] }}</td>
                            <td>{{ $box['width'] }}</td>
                            <td>{{ $box['height'] }}</td>
                            <td>{{ $box['weight_limit'] }}</td>
                            <td>{{ $box['total_volume'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    
            <h2>Input</h2>
    
    
            <div class="product">
                <label>Length: <input type="number" name="products[0][length]" required></label>
                <label>Width: <input type="number" name="products[0][width]" required></label>
                <label>Height: <input type="number" name="products[0][height]" required></label>
                <label>Weight: <input type="number" name="products[0][weight]" required></label>
                <label>Quantity: <input type="number" name="products[0][quantity]" required></label>
            </div>
        </div>
        <br>
        <button type="button" id="add-product">Add Another Product</button>
        <button type="submit">Pack Products</button>
    </form>
    <script>
        let productIndex = 1;
        document.getElementById('add-product').addEventListener('click', function() {
            let newProduct = document.querySelector('.product').cloneNode(true);
            newProduct.querySelectorAll('input').forEach(input => {
                input.name = input.name.replace(/\d+/, productIndex);
                input.value = '';
            });
            document.getElementById('product-inputs').appendChild(newProduct);
            productIndex++;
        });
    </script>

</body>
</html>

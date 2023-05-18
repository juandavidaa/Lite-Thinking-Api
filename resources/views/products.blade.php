<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Inventory</title>

    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        table{
            width: 100%;
        }
    </style>

</head>
<body>
    <h1>{{ $name }} - {{ $nit }} </h1>
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($products as $product)
            <tr>
                <td><img src="{{ $product->image_url }}" alt="logo" height="50" /></td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->quantity }}</td>
                <td>{{ $product->price }}</td>
            </tr>
        @endforeach
        </tbody>

    </table>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Product page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">

        <h1>View Products</h1>
        
        <form id="productForm">
            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" id="product_name" name="product_name" class="form-control">
            </div>
            <div class="form-group">
                <label for="quantity">Stock Quantity</label>
                <input type="number" id="quantity" name="quantity" class="form-control">
            </div>
            <div class="form-group">
                <label for="price">Item Price</label>
                <input type="number" id="price" name="price" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#productForm").submit(function(event) {
                event.preventDefault();

                var productName = $("#product_name").val();
                var quantity = $("#quantity").val();
                var price = $("#price").val();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/products",
                    type: "POST",
                    data: {
                        product_name: productName,
                        quantity: quantity,
                        price: price
                    },
                    success: function(response) {
                        alert("Product added successfully!");
                        $("#productForm")[0].reset();
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
</body>
</html>
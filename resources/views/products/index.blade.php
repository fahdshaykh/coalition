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

    <a href="/" class="btn btn-default mt-5">Home Page</a>

        <h1>View Products</h1>
        
        <form id="productForm">
            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" id="product_name" name="product_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="quantity">Stock Quantity</label>
                <input type="number" id="quantity" name="quantity" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="price">Item Price</label>
                <input type="number" id="price" name="price" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>


        <h2>Products</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Stock Quantity</th>
                    <th>Price</th>
                    <th>Total Price</th>
                    <th>Created at</th>
                </tr>
            </thead>
            <tbody class="table" id="productTable">
                
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="3" class="text-right">Total Price:</td>
                    <td id="sumPrice"></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        <script src="{{ asset('js/app.js') }}"></script>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {

            function fetchProducts() {
            
                $.ajax({
                    url: "{{ url('fetch') }}", 
                    type: 'GET', 
                    dataType: 'json',
                    success: function(response) {
                        let rows = '';
                        let TotalPrice = 0;

                        response.data.forEach(function(row) {

                            TotalPrice += row.total_value;
                            
                            rows += `
                                <tr>
                                    <td>${row.product_name}</td>
                                    <td>${row.quantity}</td>
                                    <td>${row.price}</td>
                                    <td>${row.total_value}</td>
                                    <td>${row.created_at}</td>
                                </tr>
                            `;
                        });

                        $("#productTable").html(rows);
                        $("#sumPrice").html(TotalPrice);
                    }
                });

            }

            $("#productForm").submit(function(event) {
                event.preventDefault();

                var productName = $("#product_name").val();
                var quantity = $("#quantity").val();
                var price = $("#price").val();
                // var created_at = new Date().toISOString().slice(0, 19).replace("T", " ");

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
                        // $("#productTable").append(`
                        //     <tr>
                        //         <td>${productName}</td>
                        //         <td>${quantity}</td>
                        //         <td>${price}</td>
                        //         <td>${created_at}</td>
                        //     </tr>
                        // `);

                        fetchProducts();

                        $("#productForm")[0].reset();
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });

            fetchProducts();

        });
    </script>
</body>
</html>
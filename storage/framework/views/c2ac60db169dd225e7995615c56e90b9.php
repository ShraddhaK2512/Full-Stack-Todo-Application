<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Laravel To-Do App</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery -->
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>To-Do Application</h1>

    <!-- Form for adding items -->
    <form id="itemForm">
        <?php echo csrf_field(); ?>
        <label for="name">Item Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" required>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" required>

        <button type="submit">Add Item</button>
    </form>

    <h2>Item List</h2>
    <table border="1px solid black" width="100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Date and Time</th>
                <th>Total Value</th>
            </tr>
        </thead>
        <tbody id="itemsList">
            <!-- Item rows will be dynamically added here by AJAX -->
        </tbody>
        <tfoot>
            <tr id="Total">
                <!-- Grand Total will be updated here -->
            </tr>
        </tfoot>
    </table>

    <script>
        $(document).ready(function() {
            // Fetch the initial list of items
            fetchItems();

            // Handle form submission with AJAX
            $('#itemForm').submit(function(e) {
                e.preventDefault();  // Prevent form from submitting normally

            let name = $('#name').val();
            let quantity = $('#quantity').val();
            let price = $('#price').val();

            $.post('/items', {
                name: name,
                quantity: quantity,
                price: price,
                _token: '<?php echo e(csrf_token()); ?>'
            }, function(data) {
                // Clear inputs
                $('#name').val('');
                $('#quantity').val('');
                $('#price').val('');

                // Refresh the item list with updated total
                fetchItems();
            });
        });

            // Fetch and display items
            function fetchItems() {
                $.get('/items', function(response) {
                    $('#itemsList').empty();  // Clear the current items list
                    let total = 0;

                    $.each(response.items, function(index, item) {
                        //const total = item.quantity*item.price;
                        // Create a row for each item
                        const row = `<tr>
                                    <td>${item.name}</td>
                                    <td>${item.quantity}</td>
                                    <td>${item.price}</td>
                                    <td>${item.created_at}</td>
                                    <td>${item.totalvalue}</td>
                                    </tr>`;
                        // Append the row to the table
                        $('#itemsList').append(row);
                        total += item.totalvalue
                    });

                    $('#Total').html(`
                    <td colspan="4" style="text-align:right;"><strong>Grand Total:</strong></td>
                    <td><strong>${total.toFixed(2)}</strong></td>
                `);
                });
            }
        });
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\todo-sample\resources\views/items.blade.php ENDPATH**/ ?>
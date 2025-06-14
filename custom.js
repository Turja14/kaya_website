$(document).ready(function(){

    $(document).on('click', '.delete_product_btn', function(e) {
        e.preventDefault();
    
        var id = $(this).val();
        var row = $(this).closest('tr'); // Get the closest row to remove later
    
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    method: "POST",
                    url: "code.php",
                    data: {
                        'product_id': id,
                        'delete_product_btn': true,
                    },
                    success: function(response) {
                        console.log(response);
                        if (response == 200) {
                            swal("Success!", "Product deleted successfully", "success");
                            row.remove(); // Remove the row directly from the table
                        } else if (response == 500) {
                            swal("Error!", "Something went wrong", "error");
                        }
                    }
                });
            } else {
                swal("Product deletion canceled");
            }
        });
    });
    

    $(document).on('click', '.delete_category_btn', function(e) {
        e.preventDefault();
    
        var id = $(this).val();
        var row = $(this).closest('tr'); // Get the closest row to remove later
    
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    method: "POST",
                    url: "code.php",
                    data: {
                        'category_id': id,
                        'delete_category_btn': true,
                    },
                    success: function(response) {
                        console.log(response);
                        if (response == 200) {
                            swal("Success!", "Category deleted successfully", "success");
                            row.remove(); // Remove the row directly from the table
                        } else if (response == 500) {
                            swal("Error!", "Something went wrong", "error");
                        }
                    }
                });
            } else {
                swal("Category deletion canceled");
            }
        });
    });

    
    

});

 
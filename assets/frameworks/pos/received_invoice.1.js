$(document).ready(function() {
    $('#newsalesperson').on('change', function() {
        var salespersonID = $(this).val();
        if (salespersonID != "0") {
           
            $.ajax({
                url: "findemploeeroute",
                method: 'POST',
                data: { salespersonID: salespersonID },
                dataType: 'json',
                success: function(response) {
                    
                    $('#route').empty();
                    $('#route').append('<option value="0">-Select-</option>');
                    
                    $.each(response, function(index, routeID) {
                    console.log(routeID);
                    $('#route').append('<option value="'+ routeID.route_id +'">'+ routeID.route_name +'</option>');
                });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching routes:', error);
                }
            });
        } else {
            $('#route').empty();
            $('#route').append('<option value="0">-Select-</option>');
        }
    });

    $('#route').on('change', function() {
        var routeID = $(this).val();
        var newsalesperson = $('#newsalesperson').val();
        console.log("Route ID changed to:", routeID);
        console.log("Customer newsalesperson selected:", newsalesperson);

        $.ajax({
            url: 'loadcustomersroutewise',
            type: 'POST',
            dataType: "json",
            data: {
                routeID: routeID,
                newsalesperson:newsalesperson
            },
            success: function(data) {
                console.log("Customer Data:", data); 
                $("#customer").html('<option value="">Select Customer</option>');
                
               
                if (data.length > 0) {
                    $.each(data, function(index, customer) {
                        $("#customer").append(
                            `<option value="${customer.CusCode}">${customer.DisplayName}</option>`
                        );
                    });

                  
                }

                $('#customer').select2({
                    placeholder: "Select a customer",
                    allowClear: true,
                    width: '100%'
                });
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error); 
            }
        });
    });

    $("#itemCode").autocomplete({
        source: function(request, response) {
            //alert('aaa');
            $.ajax({
                url: 'getSalesProductCodes',
                dataType: "json",
                data: {
                    name_startsWith: request.term 
                },
                success: function(data) {
                    response($.map(data, function (item) {
                        return {
                            label: item.SalesProductCode + ' - ' + item.SalesProductName,
                            value: item.SalesProductCode, 
                            productName: item.SalesProductName,
                            totalQty: item.TotalSalesQty,
                            data: item
                        };
                    }));
                }
            });
        },

        select: function (event, ui) {
            const selectedProduct = ui.item.data;
            $("#productName").val(ui.item.productName);
            $("#totalQty").val(ui.item.totalQty);
            console.log("Selected Product:", selectedProduct); 
        }
    });

    let itemCount = 0;

    $('#addItem').click(function () {
        const productCode = $('#itemCode').val(); 
        const productName = $('#productName').val(); 
        const totalQty = parseFloat($("#totalQty").val()); 
      
        const quantity = parseFloat($('#qty').val()); 
        if (!productCode || !productName || !quantity) {
            alert('Please fill out all fields before adding an item.');
            return;
        }

        if (quantity > totalQty) {
            alert('Quantity Above the Sales Quantity ');
            return;
        }

        let existingRow = $('#tbl_item tbody tr').filter(function() {
            return $(this).find('td').eq(1).text() === productCode;
        });

        if (existingRow.length > 0) {
           
            existingRow.find('td').eq(3).text(quantity);
            
        } else{

            itemCount++;
    
            const newRow = `
                <tr id="row_${itemCount}">
                    <td>${itemCount}</td>
                    <td>${productCode}</td>
                    <td>${productName}</td>
                    <td>${quantity}</td>
                     <td></td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-item" data-row-id="${itemCount}">
                            Remove
                        </button>
                    </td>
                </tr>
            `;
    
            $('#tbl_item tbody').append(newRow);
    
            $('#itemCode').val('');
            $('#productName').val('');
            $('#quantity').val('');
        }
    });

    $('#tbl_item').on('click', '.remove-item', function () {
        const rowId = $(this).data('row-id');
        $(`#row_${rowId}`).remove();
        $('#tbl_item tbody tr').each(function (index) {
            $(this).find('td:first').text(index + 1); 
        });
    });


    $('#saveItems').click(function () {
        const items = [];
    
        
        $('#tbl_item tbody tr').each(function () {
            const productCode = $(this).find('td').eq(1).text();  
            const productName = $(this).find('td').eq(2).text();  
            const quantity = $(this).find('td').eq(3).text();     
    
            items.push({
                productCode: productCode,
                productName: productName,
                quantity: quantity
            });
        });
    
        if (items.length === 0) {
            alert('Please add items before saving.');
            return;
        }
    
        
        const grnNo = $('#grn_no').val();
        const invDate = $('#invDate').val();
        const grnRemark = $('#grnremark').val();
        const location = $('#invlocation').val();
        const invUser = $('#invUser').val();
        const salesperson = $('#newsalesperson').val();
        const route = $('#route').val();
        const customer = $('#customer').val();
        const nonInv = $('#nonInv').is(':checked') ? 1 : 0;
    
       
        $.ajax({
            url: 'saveReturnDetails', 
            type: 'POST',
            dataType: 'json',
            data: {
                grnNo: grnNo,
                invDate: invDate,
                grnRemark: grnRemark,
                location: location,
                invUser: invUser,
                salesperson: salesperson,
                route: route,
                customer: customer,
                nonInv: nonInv,
                items: items  
            },
            success: function(response) {
                if  (response == '1') {
                    alert('Items saved successfully.');
                    
                    $('#tbl_item tbody').empty();
                } else {
                    alert('Failed to save items.');
                }
            },
            error: function() {
                alert('Error while saving items.');
            }
        });
    });
    
});
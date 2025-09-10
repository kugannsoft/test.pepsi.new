 $(document).ready(function() { 

     $('#newsalesperson').on('change', function() {
        
             var salespersonID = $(this).val();
             if (salespersonID != "0") {
    
                 $.ajax({
                    
                     url:  "../../admin/customer/findemploeeroute",
                     method: 'POST',
                     data: { salespersonID: salespersonID },
                     dataType: 'json',
                     success: function(response) {
    
                         $('#route').empty();
                         $('#route').append('<option value="0">-Select-</option>');   url: "../Admin/Controller/Product.php",
    
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
        
        $.ajax({
            url: baseUrl + '/job/loadcustomersroutewise',
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
                console.error("AJAX Error:", error); // Log any AJAX errors
            }
        });
    });

    function loadCustomerDatabyId(customer) {
        clearCustomerData();
    
        $.ajax({
            type: "POST",
            url: baseUrl + "/Payment/getCustomersDataById",
            data: { cusCode: customer },
            success: function(data) {
                let resultData;
    
                try {
                    resultData = JSON.parse(data);
                } catch (e) {
                    console.error("Invalid JSON:", e);
                    return;
                }
    
                if (resultData && resultData.cus_data) {
                    let cusCode = resultData.cus_data.CusCode;
                    let outstanding = parseFloat(resultData.cus_data.CusOustandingAmount);
                    let available_balance = parseFloat(resultData.cus_data.CreditLimit) - outstanding;
                    let customer_name = resultData.cus_data.CusName;
                    let encode_url = "../Payment/view_customer/" + cusCode;
    
                    $("#cusName").html("<a href='" + encode_url + "'>" + customer_name + "</a>");
                    $("#customer, #cusCode").val(cusCode);
                    $("#creditLimit").html(accounting.formatMoney(resultData.cus_data.CreditLimit));
                    $("#creditPeriod").html(resultData.cus_data.CreditPeriod);
                    $("#cusOutstand").html(accounting.formatMoney(outstanding));
                    $("#availableCreditLimit").html(accounting.formatMoney(available_balance));
                    $("#cusAddress").html(resultData.cus_data.Address01 + ", " + resultData.cus_data.Address02);
                    $("#cusAddress2").html(resultData.cus_data.Address03);
                    $("#cusPhone").html(resultData.cus_data.MobileNo);
                } else {
                    console.error("Customer data missing in response:", data);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX error loading customer data:", error);
            }
        });
    }
})
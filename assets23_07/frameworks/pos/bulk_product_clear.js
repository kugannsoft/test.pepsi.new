/*
 * stock clear java script goes here
 * author esanka
 */
$(document).ready(function() {
    $('.prd_icheck').iCheck({
    checkboxClass: 'icheckbox_square-green',
    radioClass: 'iradio_square-blue',
    increaseArea: '50%' // optional
});

    var loc = $("#location").val();
    var barCode = 0;
    var itemCode = 0;
    var selLoc = 0;
    var totalStock = 0;
    var locName = '';
    var depName = '';
    var subdepName = '';
    var dep = 0;
    var subdep = 0;
     var dep1 = [];
    selLoc = $("#sel_location option:selected").val();
    locName = $("#sel_location option:selected").html();
    dep = $("#dep_ar").val();
    $("#pay").attr('disabled', true);

    $("#sel_location").change(function() {
        $("#errGrid").hide();
         $("#pay").attr('disabled', true);
        selLoc = $("#sel_location option:selected").val();
        locName = $("#sel_location option:selected").html();
         dep=0;
        $("#dep_ar").val('');
        $("input[name='dep']:checked").each(function() {
            $(this).iCheck('uncheck'); 
        });
         dep1.length = 0;
    });
    
   

    $("input[name='dep']").on('ifChanged', function(event) {
        dep1.length = 0;
        $("input[name='dep']:checked").each(function() {
            dep1.push($(this).val());
        });
        $("#dep_ar").val(JSON.stringify(dep1));
        dep = $("#dep_ar").val();
        
        if(dep1.length !=0){
            loadProducts();
            $("#pay").attr('disabled', false);
        }
        
    });
    
   
    
    function loadProducts() {
        dep = $("#dep_ar").val();
        subdep = $("#subdep option:selected").val();
        selLoc = $("#sel_location option:selected").val();
        locName = $("#sel_location option:selected").html();
        if ((dep != '' || dep != 0 || dep1.length !=0) && (selLoc != '' || selLoc != 0)) {
            $("#errGrid").hide();
            $.ajax({
                type: "post",
                url: "loadproductbyDeps",
                data: {dep: dep, location: selLoc},
                success: function(json) {
                    var totalAmount = 0;
                    $("#totalAmount").html(accounting.formatMoney(totalAmount));
                    $("#tbl_payment tbody").html('');
                    var resultData = JSON.parse(json);
                    if (resultData) {
                        $.each(resultData, function(key, value) {
                            itemCode = value.ProductCode;
                            var serial = '';
                            if (value.SerialNo) {
                                serial = value.SerialNo;
                            }
                            var grn = '';
                            if (value.GrnNo) {
                                grn = value.GrnNo;
                            }
                            $("#tbl_payment tbody").append("<tr id='" + (key + 1) + "'><td>" + (key + 1) + "</td><td>" + itemCode + "</td><td>" + value.Prd_Description + "</td><td>" + value.Quantity + "</td></tr>");
                            totalAmount += parseFloat(value.Quantity);
                            totalStock = totalAmount;
                            $("#totalAmount").html(accounting.formatMoney(totalAmount));
                        });
                    } else {
                        $("#errGrid").show();
                        $("#errGrid").html('Product not found ').addClass('alert alert-danger alert-dismissible alert-sm').fadeOut(2000);
                        $("#itemCode").val('');
                        $("#itemCode").focus();
                        return false;
                    }
                },
                error: function() {
                    alert('Error while request..');
                }
            });
        } else {
            $("#errGrid").show();
            $("#errGrid").html('Select a location ').addClass('alert alert-danger alert-dismissible alert-sm').fadeOut(2000);
            return false;
        }
    }

    $("#pay").click(function() {
        var r = confirm("Are you sure,Do you want to clear this produt stock.?");
        if (r == true) {
            if (dep == '' || dep == 0) {
                $("#errGrid").show();
                $("#errGrid").html('Select a department ').addClass('alert alert-danger alert-dismissible alert-sm').fadeOut(2000);
                return false;
            } else if (selLoc == '' || selLoc == 0) {
                $("#errGrid").show();
                $("#errGrid").html('Select a location ').addClass('alert alert-danger alert-dismissible alert-sm').fadeOut(2000);
                return false;
            } else {
                $("#pay").attr('disabled', true);
                var invUser = $("#invUser").val();
                var location = $("#sel_location option:selected").val();
                locName = $("#sel_location option:selected").html();
                $.ajax({
                    type: "post",
                    url: "clearBulkProductStock",
                    data: {invUser: invUser, dep: dep, subdep: subdep, location: location, totalStock: totalStock},
                    success: function(data) {
                        var resultData = JSON.parse(data);
                        var feedback = resultData['fb'];
                        var invNumber = resultData['InvNo'];
                        if (feedback != 1) {
                            $("#errGrid").show();
                            $("#errGrid").html('Stock not cleared successfully').addClass('alert alert-danger alert-dismissible alert-sm').fadeOut(2000);
                            $("#pay").attr('disabled', false);
                            return false;
                        } else {
                            $("#lastTranaction").html("<i>Last stock cleared product</i> : <b>" + depName + "->" + subdepName + "</b> in " + locName);
                            $("#errGrid").show();$("#errGrid").html('');
                            $("#errGrid").html('Stock cleared successfully').addClass('alert alert-success alert-sm');
                            $("#tbl_payment tbody").html('');
                           $("#sel_location").val('');
                            location = 0;
                            dep = 0;
                            selLoc = 0;
                            totalStock = 0;
                            $("#dep_ar").val('');
                            $("input[name='dep']:checked").each(function() {
                                $(this).iCheck('uncheck'); 
                            });
                             dep1.length = 0;
                            $("#totalAmount").html(accounting.formatMoney(0));
                            $("#pay").attr('disabled', true);
                            return false;
                        }
                    }
                });
            }
        } else {
            return false;
        }
    });
});
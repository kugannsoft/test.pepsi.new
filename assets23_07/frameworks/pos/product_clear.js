/*
 * stock clear java script goes here
 * author esanka
 */
$(document).ready(function() {
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
    selLoc = $("#sel_location option:selected").val();
    locName = $("#sel_location option:selected").html();
    dep = $("#dep option:selected").val();
    subdep = $("#subdep option:selected").val();
    depName = $("#dep option:selected").html();
    if(subdep!='' || subdep!=0){ subdepName = $("#subdep option:selected").html(); }
    $("#pay").attr('disabled', true);

    $("#dep option[value=" + 1 + "]").attr('disabled', 'disabled');
    
    $("#sel_location").change(function() {
        $("#errGrid").hide();
         $("#pay").attr('disabled', true);
        selLoc = $("#sel_location option:selected").val();
        locName = $("#sel_location option:selected").html();
         dep=0;
        $("#dep").val('');
         subdep=0;
        $("#subdep").val('');
    });

    $('#dep').change(function() {
        $("#pay").attr('disabled', true);
        dep = $("#dep option:selected").val();
        depName = $("#dep option:selected").html();
        subdep=0;
        $("#tbl_payment tbody").html('');
        $.ajax({
            url: "../product/loadsubdepartment/",
            type: 'POST',
            data: {dep: $(this).val()},
            success: function(resp) {
                resp = JSON.parse(resp);
                $('#subdep').empty().append("<option value=''>--Select a sub department --</option>");

                $.each(resp, function(k, v) {
                    $('<option>').val(v.SubDepCode).text(v.Description).appendTo('#subdep');
                });
            }
        });
        
        loadProducts();
        if(dep!='' || dep!=0){ $("#pay").attr('disabled', false); }
        subdep=0;
        $("#subdep").val('');
    });

    $('#subdep').change(function() {
         $("#pay").attr('disabled', true);
        $("#tbl_payment tbody").html('');
        subdep = $("#subdep option:selected").val();
        subdepName = $("#subdep option:selected").html();
        loadProducts();
        if((dep!='' || dep!=0) && (subdep!='' || subdep!=0) ){ $("#pay").attr('disabled', false); }
    });
    
    function loadProducts() {
        dep = $("#dep option:selected").val();
        subdep = $("#subdep option:selected").val();
        selLoc = $("#sel_location option:selected").val();
        locName = $("#sel_location option:selected").html();
        if (selLoc != '' || selLoc != 0) {
            $("#errGrid").hide();
            $.ajax({
                type: "post",
                url: "loadproductbyDepandSubdep",
                data: {dep: dep, subdep: subdep, location: selLoc},
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
                    url: "clearProductStock",
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
                            $("#errGrid").show();
                            $("#errGrid").html('Stock cleared successfully').addClass('alert alert-success alert-sm');
                            $("#tbl_payment tbody").html('');
                            $("#dep").val('');
                            $("#subdep").val('');
                            $("#sel_location").val('');
                            location = 0;
                            dep = 0;
                            selLoc = 0;
                            totalStock = 0;
                            subdep = 0;
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
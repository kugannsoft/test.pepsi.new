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
    selLoc = $("#sel_location option:selected").val();
 locName = $("#sel_location option:selected").html();
    $("#sel_location").change(function() {
        $("#errGrid").hide();
        selLoc = $("#sel_location option:selected").val();
        locName = $("#sel_location option:selected").html();
    });

    $('#itemCode').on('keydown', function(e) {
        if (e.which == 13) {
            barCode = $(this).val();
            selLoc = $("#sel_location option:selected").val();
            locName = $("#sel_location option:selected").html();
            if (selLoc != '' || selLoc != 0) {
                $("#errGrid").hide();
                $.ajax({
                    type: "post",
                    url: "loadproductSerial",
                    data: {proCode: barCode, location: selLoc},
                    success: function(json) {
                        var totalAmount = 0;
                        $("#totalAmount").html(accounting.formatMoney(totalAmount));
                        $("#tbl_payment tbody").html('');
                        var resultData = JSON.parse(json);
                        if (resultData) {
                            $.each(resultData, function(key, value) {
                                itemCode = value.ProductCode;
                                var serial = '';
                                if(value.SerialNo){ serial=value.SerialNo; }
                                var grn = '';
                                if(value.GrnNo){ grn=value.GrnNo; }
                                $("#tbl_payment tbody").append("<tr id='" + (key + 1) + "'><td>" + (key + 1) + "</td><td>" + itemCode + "</td><td>" + value.Prd_Description + "</td><td>" + serial + "</td><td>" + value.Quantity + "</td><td>" + grn + "</td></tr>");
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
            e.preventDefault();
        }
    });

    var autoSerial = 0;
//==============load products========================
    $("#itemCode").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: 'loadproductjson',
                dataType: "json",
                data: {
                    q: request.term,
                    row_num: 1
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.label,
                            value: item.value,
                            data: item
                        }
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function(event, ui) {
            $("#errGrid").hide();
            barCode = ui.item.value;
            if (selLoc != '' || selLoc != 0) {
                $.ajax({
                    type: "post",
                    url: "loadproductSerial",
                    data: {proCode: barCode, location: selLoc},
                    success: function(json) {
                        var totalAmount = 0;
                        $("#totalAmount").html(accounting.formatMoney(totalAmount));
                        $("#tbl_payment tbody").html('');
                        var resultData = JSON.parse(json);
                        if (resultData!='') {
                            $.each(resultData, function(key, value) {
                                itemCode = value.ProductCode;
                                var serial = '';
                                if(value.SerialNo){ serial=value.SerialNo; }
                                var grn = '';
                                if(value.GrnNo){ grn=value.GrnNo; }
                                $("#tbl_payment tbody").append("<tr id='" + (key + 1) + "'><td>" + (key + 1) + "</td><td>" + itemCode + "</td><td>" + value.Prd_Description + "</td><td>" + serial + "</td><td>" + value.Quantity + "</td><td>" + grn + "</td></tr>");
                                totalAmount += parseFloat(value.Quantity);
                                totalStock = totalAmount;
                                $("#totalAmount").html(accounting.formatMoney(totalAmount));
                            });
                        }else{
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
    });

    $("#pay").click(function() {
        var r = confirm("Do you want to clear this serial stock.?");
        if (r == true) {
            if (itemCode == '' || itemCode == 0) {
                $("#errGrid").show();
                $("#errGrid").html('Select a product ').addClass('alert alert-danger alert-dismissible alert-sm').fadeOut(2000);
                return false;
            } else if (selLoc == '' || selLoc == 0) {
                $("#errGrid").show();
                $("#errGrid").html('Select a location ').addClass('alert alert-danger alert-dismissible alert-sm').fadeOut(2000);
                return false;
            } else {
                var invUser = $("#invUser").val();
                var location = $("#sel_location option:selected").val();
                locName = $("#sel_location option:selected").html();
                $.ajax({
                    type: "post",
                    url: "clearSerialStock",
                    data: {invUser: invUser, productCode: itemCode, location: location, totalStock: totalStock},
                    success: function(data) {
                        var resultData = JSON.parse(data);
                        var feedback = resultData['fb'];
                        var invNumber = resultData['InvNo'];
                        if (feedback != 1) {
                            $("#errGrid").show();
                            $("#errGrid").html('Stock not cleared successfully').addClass('alert alert-danger alert-dismissible alert-sm').fadeOut(2000);
                            return false;
                        } else {
                            $("#lastTranaction").html("<i>Last stock cleared product</i> : <b>"+itemCode+"</b> in "+locName);
                            $("#errGrid").show();
                            $("#errGrid").html('Stock cleared successfully').addClass('alert alert-success alert-sm');
                             $("#tbl_payment tbody").html('');
                             $("#itemCode").val('');
                             $("#sel_location").val('');
                             location=0;
                             itemCode=0;selLoc=0;totalStock=0;barCode=0;
                            $("#totalAmount").html(accounting.formatMoney(0));
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
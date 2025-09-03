$(document).ready(function() {
    $('body').addClass('sidebar-collapse');
    
    var proCode = 0;
    $("#tblSale").hide();
    $("#tblGrn").hide();
    $("#tblTrans").hide();
    //barcode read
    $('#search_product').on('keydown', function(e) {
        if (e.which == 13) {
            $('#result > span').text('');
            $("#search_product").css("background-color", "#fff");
            $("#search_product").css("color", "#555");
            proCode = $(this).val();
            var loc = $("#location").val();
            $("#serial,#costPrice,#productCode,#sellingPrice,#model,#shop,#sup,#stock,#sup,#grnNo,#grnDate,#invShop,#invNo,#invDate").html('');
            $("#invCostPrice,#invSellingPrice,#invAmount,#discount,#invNet,#cusPay").html('0.00');
            $.ajax({
                type: "post",
                url: "getProductByBarCode",
                data: {proCode: proCode, location: loc},
                success: function(json) {

                    var resultData = JSON.parse(json);

                    if (resultData) {
                        if (!resultData.stock) {
                            $("#stock").html("<span class='label label-danger'>Serial Not found</span>");
                        }
                        if (!resultData.product) {
                            $("#tblGrn").hide();
                        } else {
                            $("#tblGrn").show();
                            $("#serial").html(resultData.product.SerialNo);
                            $("#costPrice").html(accounting.formatMoney(resultData.product.GRN_UnitCost));
                            $("#productCode").html(resultData.product.ProductCode);
                            $("#sellingPrice").html(accounting.formatMoney(resultData.product.ProductPrice));
                            $("#model").html(resultData.product.Prd_Description);
                            $("#shop").html(resultData.product.location);
                            $("#sup").html(resultData.product.Prd_Supplier);
                            if(resultData.stock.Quantity==1){
                                 $("#stock").html("<span class='label label-success'>Stock In "+resultData.stock.location+"</span>");
                            }else{
                                 $("#stock").html("<span class='label label-danger'>Out of Stock</span>");
                            }
                           
                            $("#sup").html(resultData.product.SupName);
                            $("#grnNo").html(resultData.product.GRN_No);
                            $("#grnDate").html(resultData.product.GRN_DateORG);
                        }
//                        alert(resultData.sale);
                        if (!resultData.sale) {
                            $("#tblSale").hide();
                        } else {
                            $("#tblSale").show();
                            $("#invShop").html(resultData.sale.location);
                            $("#invCostPrice").html(accounting.formatMoney(resultData.sale.InvCostPrice));
                            $("#invSellingPrice").html(accounting.formatMoney(resultData.sale.InvUnitPrice));
                            $("#invAmount").html(accounting.formatMoney(resultData.sale.InvAmount));
                            $("#discount").html(accounting.formatMoney(resultData.sale.InvDisAmount));
                            $("#invNet").html(accounting.formatMoney(resultData.sale.InvNetAmount));
                            $("#invNo").html(resultData.sale.InvNo);
                            $("#cusPay").html(accounting.formatMoney(resultData.sale.InvCustomerPayment));
                            $("#invDate").html(resultData.sale.InvDate);
                        }

                        if (!resultData.trans) {
                            $("#tblTrans").hide();
                        } else {
                            var toloc = setLocation(resultData.trans.ToLocation);
                            var fromloc = setLocation(resultData.trans.FromLocation);

                            $("#tblTrans").show();
                            $("#fromShop").html(fromloc);
                            $("#toShop").html(toloc);
                            $("#trnsInDate").html((resultData.trans.TransInDate));
                            $("#trnsNo").html(resultData.trans.TrnsNo);
                            $("#trnsDate").html(resultData.trans.TransDateORG);

                            if (resultData.trans.TransIsInProcess == 0) {
                                $("#trnsStat").html("<span class='label label-success'>Success</span>");
                            } else if (resultData.trans.TransIsInProcess == 1) {
                                $("#trnsStat").html("<span class='label label-warning'>Pending</span>");
                            }
                        }
                    } else {
                        $("#errGrid").show();
                        $("#errGrid").html('Product not found ').addClass('alert alert-danger alert-dismissible alert-sm').fadeOut(2000);
                        $("#search_product").val('');
                        $("#search_product").focus();
                        
                        return false;
                    }
                },
                error: function() {
                    alert('Error while request..');
                }
            });
            e.preventDefault();

        }
    });

    $("#srClear").click(function() {
        $("#serial,#costPrice,#productCode,#sellingPrice,#model,#shop,#sup,#stock,#sup,#grnNo,#grnDate,#invShop,#invNo,#invDate").html('');
        $("#invCostPrice,#invSellingPrice,#invAmount,#discount,#invNet,#cusPay").html('0.00');
        $("#tblTrans,tblSale").hide();
        $('#result > span').text('');
        $("#search_product").css("background-color", "#fff");
        $("#search_product").css("color", "#555");
        $("#search_product").val('').focus();
    });

    function setLocation(id) {
        var str = '';
        if (id == 1) {
            str = 'Stores';
        } else if (id == 2) {
            str = 'VCOM';
        } else if (id == 3) {
            str = 'NAWODDYA';
        } else if (id == 4) {
            str = 'PUJA';
        } else if (id == 5) {
            str = 'NAWODA';
        } else if (id == 6) {
            str = 'HIRU';
        }
        else if (id == 7) {
            str = 'Loona Bell';
        }
        else if (id == 8) {
            str = 'JANAKA PRASAD';
        }
        else if (id == 9) {
            str = 'Company';
        }
        else if (id == 10) {
            str = 'HUAWEI';
        }
        else if (id == 11) {
            str = 'WASANA';
        }
        return str;
    }
});
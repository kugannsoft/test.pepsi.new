/*
 * point of sale java script goes here
 * author esanka
 */
$(document).ready(function() {
    $('body').addClass('sidebar-collapse');
    $("#addCustomer").click(function() {
        $('#cusModal').load('customer/loadmodal_customeradd/', function(result) {
            $('#customermodal').modal({show: true});
        });
    });

    $("#customer_id").select2();

    $("#suggestPanel").hide();
    var proCode = 0;
    var upc = 1;
    var proName = '';
    var qty = 0;
    var freeQty = 0;
    var serialNo = 0;
    var sellPrice = 0;
    var costPrice = 0;
    var net_amount = 0;
    var priceLevel = 0;
    var total_amount = 0;
    var total_cost = 0;
    var disType = 1;
    var disAmountType = 1;
    var disPresentage = 0;
    var disCash = 0;
    var productDiscount = 0;
    var totalDiscount = 0;
    var total = 0;
    var toPay = 0;
    var prlevel = 0;
    var cashAmount = 0;
    var creditAmount = 0;
    var cardAmount = 0;
    var dueAmount = 0;
    var ref = 0;
    var totalCost = 0;
    var warrnty = 0;

    $('#search_product').on('keydown', function(e) {
        if (e.which == 13) {
            $("#errGrid").hide();
            $("#cart-table-notice").remove();
            proCode = $(this).val();
            prlevel = $("#prLevel option:selected").val();
            var loc = $("#location").val();
            $.ajax({
                type: "post",
                url: "Product/getProductByBarCode",
                data: {proCode: proCode, prlevel: prlevel, location: loc},
                success: function(json) {

                    var resultData = JSON.parse(json);
                    if (resultData) {
                        var qty_text = "<div class='input-group input-group-sm'><span class='input-group-btn'><button class='btn btn-default item-reduce'>-</button></span><input type='number' name='shop_item_quantity' value='1' class='form-control' aria-describedby='sizing-addon3'><span class='input-group-btn'><button class='btn btn-default item-add'>+</button></span></div>";
                        $("#modelBilling").modal('toggle');
                        loadProModal(resultData.Prd_Description, resultData.ProductCode, resultData.ProductPrice, resultData.Prd_CostPrice, resultData.SerialNo, resultData.IsSerial, resultData.IsFreeIssue, resultData.IsOpenPrice, resultData.IsMultiPrice, resultData.Prd_UPC, resultData.WarrantyPeriod);
                        $('html, body').animate({scrollTop: $('#cart-table-body').offset().top}, 'slow');
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

    $("#search_product").autocomplete({
        minLength: 3,
        search: function() {
            $("#filter-list").empty();
            $("#suggestPanel").toggle();
        },
        source: "product/get_products",
        focus: function(event, ui) {
            $("#search_product").val(ui.item.label);
        },
        select: function(event, ui) {return false;}
    }).autocomplete("instance")._renderItem = function(ul, item) {
        $("#suggestPanel").show();
        return $("<div proCode='" + item.value + "' proName='" + item.label + "' class='col-lg-2 col-md-3 col-xs-6 shop-items filter-add-product noselect text-center' style='min-height: 75px;padding:5px; border-right: solid 1px #DEDEDE;border-bottom: solid 1px #DEDEDE;'>")
                .append("<div class='caption text-center' style='padding:2px;overflow:hidden;'>" +
                        "<strong class='item-grid-title'>" + item.label + "</strong><br><span class='pull-left'>" + item.value + "</span><span class='pull-right'><i class='fa fa-tag'></i> " + item.price + "</span>" +
                        "</div>")
                .appendTo("#filter-list");
    };

    //show hide grid toggle
    $("#SHGrid").click(function() {
        $("#suggestPanel").toggle();
    });
    
    //load product from search grid
    $("#filter-list").on('click', '.shop-items', function() {
        $("#cart-table-notice").remove();
        proCode = $(this).attr('proCode');
        prlevel = $("#prLevel option:selected").val();
        $.ajax({
            type: "post",
            url: "Product/getProductById",
            data: {proCode: proCode, prlevel: prlevel},
            success: function(json) {
                var resultData = JSON.parse(json);
                var qty_text = "<div class='input-group input-group-sm'><span class='input-group-btn'><button class='btn btn-default item-reduce'>-</button></span><input type='number' name='shop_item_quantity' value='1' class='form-control' aria-describedby='sizing-addon3'><span class='input-group-btn'><button class='btn btn-default item-add'>+</button></span></div>";
                if (resultData) {
                    $("#modelBilling").modal('toggle');
                    $("#mQty").focus();
                    loadProModal(resultData.Prd_Description, resultData.ProductCode, resultData.ProductPrice, resultData.Prd_CostPrice, 0, resultData.IsSerial, resultData.IsFreeIssue, resultData.IsOpenPrice, resultData.IsMultiPrice, resultData.Prd_UPC, resultData.WarrantyPeriod);
                    $("#mQty").focus();
                    $('html, body').animate({scrollTop: $('#cart-table-body').offset().top}, 'slow');
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
    });
    
    //load model
    function loadProModal(mname, mcode, msellPrice, mcostPrice, mserial, misSerial, misFree, isOP, isMP, upc, waranty) {
        clearProModal();
        if (mserial) {
            $("#mSerial").val(mserial);
            $("#mQty").val(1);
            $("#mQty").attr('disabaled', true);
        } else {
            $("#mSerial").val('');
            $("#mQty").attr('disabaled', false);
        }
        $("#mQty").val(1);
        $("#mLProCode").html(mcode);
        $("#mProName").val(mname);
        $("#mProCode").val(mcode);
        $("#mSellPrice").val(msellPrice);
        $("#mCostPrice").val(mcostPrice);
        $("#mWarrnty").val(waranty);
        $("#mUpc").val(upc);

        if (misSerial == 1) {
            $("#dv_SN").show();
        } else {
            $("#dv_SN").hide();
        }
        if (misFree == 1) {
            $("#dv_FreeQty").show();
        } else {
            $("#dv_FreeQty").hide();
        }
        if (isOP == 1) {
            $("#mSellPrice").attr('disabaled', false);
        } else {
            $("#mSellPrice").attr('disabaled', true);
        }
        if (isMP == 1) {
            $("#mSellPrice").attr('disabaled', false);
        } else {
            $("#mSellPrice").attr('disabaled', true);
        }

    }

    $("#mSellPrice").blur(function() {
        sellPrice = parseFloat($(this).val());
        costPrice = parseFloat($("#mCostPrice").val());

        if (costPrice >= sellPrice) {
            $("#errProduct").show();
            $("#errProduct").html('Selling price can not be greater than cost price').addClass('alert alert-danger alert-dismissible alert-sm').fadeOut(3000);
            return false;
        }
    });
    
    //add product to grid
    var i = 1;
    var proCodeArr = [];
    $("#addProduct").click(function() {
        proName = $("#mProName").val();
        qty = parseFloat($("#mQty").val());
        freeQty = parseFloat($("#mFreeQty").val());
        sellPrice = parseFloat($("#mSellPrice").val());
        costPrice = parseFloat($("#mCostPrice").val());
        upc = parseFloat($("#mUpc").val());
        ref = $("#mRef option:selected").val();
        serialNo = $("#mSerial").val();
        priceLevel = $("#prLevel option:selected").val();
        warrnty = $("#mWarrnty").val();
        var case1 = $("#mUnit option:selected").val();
        var proCodeArrIndex = $.inArray(proCode, proCodeArr);
        if (case1 == 'Unit') {
            qty = qty;
        } else if (case1 == 'Case') {
            qty = upc * qty;
        }
        if (qty == '' || qty == 0) {
            $("#errProduct").show();
            $("#errProduct").html('Please enter a qty').addClass('alert alert-danger alert-dismissible alert-sm').fadeOut(3000);
            return false;
        } else if (proCode == '' || proCode == 0) {
            $("#errProduct").show();
            $("#errProduct").html('Please select a product').addClass('alert alert-danger alert-dismissible alert-sm').fadeOut(3000);
            return false;
        } else {
            if (proCodeArrIndex < 0) {
                total_amount = qty * sellPrice;
                total_cost = qty * costPrice;
                calProductDiscount(disType, disAmountType, total_amount, total);

                net_amount = parseFloat(total_amount) - parseFloat(productDiscount);

                $("#cart-table-body table tbody").append("<tr id='" + i + "' proName='" + proName + "' totalAmount='" + total_amount + "' warranty='" + warrnty + "' netAmount='" + net_amount + "' productDiscount='" + productDiscount + "' qty='" + qty + "' freeQty='" + freeQty + "' productCode='" + proCode + "' sellingPrice='" + sellPrice + "' costPrice='" + costPrice + "'  ref='" + ref + "' serialNo='" + serialNo + "' priceLevel='" + priceLevel + "' unit='" + case1 + "'  upc='" + upc + "'>" +
                        "<td  width='50'  class='text-center'>" + i + "</td><td width='50'></td><td width='210' style='font-size:14px'  class='text-left'>" + proName + "</td><td width='130' class='text-right'>" + accounting.formatMoney(sellPrice) + "</td><td width='130' class='text-right'>" + accounting.formatMoney(qty) + "</td><td width='130' class='text-right'>" + accounting.formatMoney(freeQty) + "</td><td width='130' class='text-right'>" + accounting.formatMoney(productDiscount) + "</td><td width='110' class='text-right'>" + accounting.formatMoney(net_amount) + "</td><td class='text-right' width='50'><a href='#' class='btn btn-danger btn-xs removeRw'><i class='fa fa-close'></i></a></td></tr>");

                i++;
                proCodeArr.push(proCode);
                total += total_amount;
                totalDiscount += productDiscount;
                totalCost += total_cost;
                toPay = parseFloat(total) - parseFloat(totalDiscount);
                $("#cart-value").html(accounting.formatMoney(total));
                $("#cart-topay").html(accounting.formatMoney(toPay));
                $("#cart-discount").html(accounting.formatMoney(totalDiscount));
                $("#mtotal").html(accounting.formatMoney(total));
                $("#mnetpay").html(accounting.formatMoney(toPay));
                $("#mdiscount").html(accounting.formatMoney(totalDiscount));

                productDiscount = 0;
                total_amount = 0;
                net_amount = 0;
                disType = 1;
                disAmountType = 1;
                qty = 0;
                freeQty = 0;
                sellPrice = 0;
                costPrice = 0;
                clearProModal();
                $("#modelBilling").modal('toggle');
                $("#search_product").val('');
                $("#search_product").focus();
                $('#cart-table-body table tbody tr').each(function(rowIndex, element) {
                    var row = rowIndex + 1;
                    $(this).find("[class]").eq(0).parent().attr("id", row);
                    $(this).find("[class]").eq(0).html(row);
                });
            } else {
                $("#errProduct").show();
                $("#errProduct").html('Product already exists.').addClass('alert alert-danger alert-dismissible alert-sm').fadeOut(3000);
                return false;
            }

        }
    });

    $("#addDiscount").click(function() {
        disType = 2;

        calProductDiscount(disType, disAmountType, total_amount, total);
        toPay = parseFloat(total) - parseFloat(totalDiscount);
        $("#cart-value").html(accounting.formatMoney(total));
        $("#cart-topay").html(accounting.formatMoney(toPay));
        $("#cart-discount").html(accounting.formatMoney(totalDiscount));
        $("#mtotal").html(accounting.formatMoney(total));
        $("#mnetpay").html(accounting.formatMoney(toPay));
        $("#mdiscount").html(accounting.formatMoney(totalDiscount));
        $("#modelTotalDis").modal('toggle');
        $("#totalAmountDiscount").val(0);
    });
    function calProductDiscount(c_disType, c_disAmountType, c_totNetAmount, c_totalAmout) {
        var disVal = 0;
        if (c_disType == 1) {
            disVal = parseFloat($("#proWiseDiscount").val());
            if (c_disAmountType == 1) {
                productDiscount = c_totNetAmount * disVal / 100;
            } else if (c_disAmountType == 2) {
                productDiscount = disVal;
            }

        } else if (c_disType == 2) {
            disVal = parseFloat($("#totalAmountDiscount").val());
            if (c_disAmountType == 1) {
                totalDiscount += (c_totalAmout * disVal / 100);
                productDiscount = 0;
            } else if (c_disAmountType == 2) {
                productDiscount = 0;
                totalDiscount += disVal;
            }
        }

    }

    $(".percentage_discount,.flat_discount").click(function() {
        disAmountType = $(this).attr("val");
        disType = $(this).attr("disType");
        $(".percentage_discount").removeClass("active");
        $(".flat_discount").removeClass("active");
        $(this).addClass("active");
        if (disAmountType == 1) {
            $(".discount_type").html("<span class='label label-primary'>" + $(this).html() + "</span>");
        } else {
            $(".discount_type").html("<span class='label label-warning'>" + $(this).html() + "</span>");
        }
    });
//clear modal
    function clearProModal() {
        $("#proWiseDiscount").val(0);
        $("#mProName").val(0);
        $("#mProCode").val(0);
        $("#mLProCode").html('');
        $("#mSellPrice").val(0);
        $("#mCostPrice").val(0);
        $("#mSerial").val(0);
        $("#mWarrnty").val(0);
        $("#mQty").val(0);
        $("#mFreeQty").val(0);
        $("#mUpc").val(0);
        $("#mUnit").val('Unit');
    }


    $("#cart-table-body table tbody").on('click', '.removeRw', function() {
        var removeItem = $(this).parent().parent().attr('productCode');
        proCodeArr = jQuery.grep(proCodeArr, function(value) {
            return value != removeItem;
        });
        $(this).parent().parent().remove();
        $("#search_product").focus();

        total -= parseFloat($(this).parent().parent().attr('totalAmount'));
        totalDiscount -= parseFloat($(this).parent().parent().attr('productDiscount'));
        totalCost -= parseFloat($(this).parent().parent().attr('costPrice'));
        toPay = parseFloat(total) - parseFloat(totalDiscount);
        $("#cart-value").html(accounting.formatMoney(total));
        $("#cart-topay").html(accounting.formatMoney(toPay));
        $("#cart-discount").html(accounting.formatMoney(totalDiscount));
        $("#mtotal").html(accounting.formatMoney(total));
        $("#mnetpay").html(accounting.formatMoney(toPay));
        $("#mdiscount").html(accounting.formatMoney(totalDiscount));

        $('#cart-table-body table tbody tr').each(function(rowIndex, element) {
            var row = rowIndex + 1;
            $(this).find("[class]").eq(0).parent().attr("id", row);
            $(this).find("[class]").eq(0).html(row);
        });

    });

    function addPayment(pcash, pcredit, pcard) {
        dueAmount = toPay - parseFloat(pcash + pcard);
        if (dueAmount > 0) {
            pcredit = dueAmount;
            creditAmount = dueAmount;
            $("#credit_amount").val((pcredit));
            $("#changeLable").html('Credit');
            $("#changeLable").css({"color": "red", "font-size": "100%"});
            $("#mchange").css({"color": "red", "font-size": "150%"});
//                dueAmount=0;
        } else {
            dueAmount = Math.abs(dueAmount);
            creditAmount = 0;
            $("#credit_amount").val((0));
            $("#changeLable").html('Change/Refund');
            $("#changeLable").css({"color": "green", "font-size": "100%"});
            $("#mchange").css({"color": "green", "font-size": "150%"});
        }
        $("#mcash").html(accounting.formatMoney(pcash));
        $("#mcard").html(accounting.formatMoney(pcard));
        $("#mcredit").html(accounting.formatMoney(pcredit));
        $("#mchange").html(accounting.formatMoney(dueAmount));
    }

    $("#cash_amount").keyup(function() {
        cashAmount = parseFloat($(this).val());
        creditAmount = parseFloat($("#credit_amount").val());
        cardAmount = parseFloat($("#card_amount").val());
        addPayment(cashAmount, creditAmount, cardAmount);
    });

    $("#credit_amount").keyup(function() {
        creditAmount = parseFloat($(this).val());
        cashAmount = parseFloat($("#cash_amount").val());
        cardAmount = parseFloat($("#card_amount").val());
        addPayment(cashAmount, creditAmount, cardAmount);
    });

    $("#cash_amount").blur(function() {
        cashAmount = parseFloat($(this).val());
        creditAmount = parseFloat($("#credit_amount").val());
        cardAmount = parseFloat($("#card_amount").val());
        addPayment(cashAmount, creditAmount, cardAmount);
    });

    $("#credit_amount").blur(function() {
        creditAmount = parseFloat($(this).val());
        cashAmount = parseFloat($("#cash_amount").val());
        cardAmount = parseFloat($("#card_amount").val());
        addPayment(cashAmount, creditAmount, cardAmount);
    });

    $("#saveInvoice").click(function() {
        var rowCount = $('#cart-table-body table tbody tr').length;
        var product_code = new Array();
        var product_name = new Array();
        var unit = new Array();
        var serial_no = new Array();
        var qty = new Array();
        var freeQty = new Array();
        var sell_price = new Array();
        var cost_price = new Array();
        var ref = new Array();
        var pro_discount = new Array();
        var total_amount = new Array();
        var total_net = new Array();
        var price_level = new Array();
        var warranty = new Array();
        var unitPC = new Array();

        var ccRef = new Array();
        var ccAmount = new Array();
        var ccType = new Array();
        var ccName = new Array();
        var cusCode = $("#customer_id option:selected").val();
        var location = $("#location").val();
        var invUser = $("#invUser").val();
        var invfname = $("#invfname").val();


        $('#cart-table-body table tbody tr').each(function(rowIndex, element) {
            var row = rowIndex + 1;
            product_code.push($(this).attr('productCode'));
            product_name.push($(this).attr('proName'));
            unit.push($(this).attr('unit'));
            serial_no.push($(this).attr('serialNo'));
            qty.push($(this).attr('qty'));
            freeQty.push($(this).attr('freeQty'));
            sell_price.push($(this).attr('sellingPrice'));
            cost_price.push($(this).attr('costPrice'));
            ref.push($(this).attr('ref'));
            pro_discount.push($(this).attr('productDiscount'));
            total_amount.push($(this).attr('totalAmount'));
            total_net.push($(this).attr('netAmount'));
            price_level.push($(this).attr('priceLevel'));
            warranty.push($(this).attr('warranty'));
            unitPC.push($(this).attr('upc'));
        });

        $('#tblCard tbody tr').each(function(rowIndex, element) {
            ccAmount.push($(this).attr('camount'));
            ccRef.push($(this).attr('cref'));
            ccType.push($(this).attr('ctype'));
            ccName.push($(this).attr('cname'));
        });

        var product_codeArr = JSON.stringify(product_code);
        var unitArr = JSON.stringify(unit);
        var serial_noArr = JSON.stringify(serial_no);
        var qtyArr = JSON.stringify(qty);
        var freeQtyArr = JSON.stringify(freeQty);
        var sell_priceArr = JSON.stringify(sell_price);
        var cost_priceArr = JSON.stringify(cost_price);
        var refArr = JSON.stringify(ref);
        var pro_discountArr = JSON.stringify(pro_discount);
        var total_amountArr = JSON.stringify(total_amount);
        var total_netArr = JSON.stringify(total_net);
        var price_levelArr = JSON.stringify(price_level);
        var warrantyArr = JSON.stringify(warranty);
        var unitPCArr = JSON.stringify(unitPC);

        var ccAmountArr = JSON.stringify(ccAmount);
        var ccRefArr = JSON.stringify(ccRef);
        var ccTypeArr = JSON.stringify(ccType);
        var ccNameArr = JSON.stringify(ccName);

        if (product_code.length == 0) {
            $("#errPayment").show();
            $("#errPayment").html('Add products').addClass('alert alert-danger alert-dismissible alert-sm').fadeOut(3000);
            return false;
        } else if (creditAmount > 0 && (cusCode == 0)) {
            $("#errPayment").show();
            $("#errPayment").html('Please select a customer').addClass('alert alert-danger alert-dismissible alert-sm').fadeOut(3000);
            return false;
        } else if (creditAmount == 0 && (cashAmount == 0)) {
            $("#errPayment").show();
            $("#errPayment").html('Please cash amount').addClass('alert alert-danger alert-dismissible alert-sm').fadeOut(3000);
            return false;
        } else {
            $.ajax({
                type: "post",
                url: "Pos/saveInvoice",
                data: {product_code: product_codeArr, unit: unitArr, freeQty: freeQtyArr, ref: refArr, warranty: warrantyArr, unitPC: unitPCArr, serial_no: serial_noArr, qty: qtyArr, sell_price: sell_priceArr, cost_price: cost_priceArr, pro_discount: pro_discountArr, total_net: total_netArr, price_level: price_levelArr, totalNetWODis: total_amountArr, cusCode: cusCode,
                    invDate: 'invDate', invUser: invUser, cash_amount: cashAmount, card_amount: cardAmount, credit_amount: creditAmount, total_amount: total, total_cost: totalCost, return_amount: 0, refund_amount: 0,
                    total_discount: totalDiscount, final_amount: toPay, location: location, ccAmount: ccAmountArr, ccRef: ccRefArr, ccType: ccTypeArr,ccName:ccNameArr},
                success: function(data) {
                    var resultData = JSON.parse(data);
                    var feedback = resultData['fb'];
                    var invNumber = resultData['InvNo'];
                    var invoicedate = resultData['InvDate'];
                    if (feedback != 1) {
                        alert('Invoice not saved successfully');
                        return false;
                    } else {
                        $("#tblData tbody").html('');
                        var j = 0;
                        for (j = 0; j < product_code.length; j++) {
                            $("#tblData tbody").append("<tr><td style='border-left:#000 solid 1px;font-size:9px;border-right:#000 solid 1px;'>" + product_name[j] + "</td><td style='border-right:#000 solid 1px;text-align:right;'>" + accounting.formatMoney(qty[j]) + "</td><td style='border-right:#000 solid 1px;text-align:right;'>" + accounting.formatMoney(sell_price[j]) + "</td><td style='text-align:right;border-right:#000 solid 1px;'>" + accounting.formatMoney(total_net[j]) + "</td></tr>");
//                        $("#tblData tbody").append("<tr><td colspan='4'>" + product_name[j] + "</td></tr>" +
//                                "<tr><td>" + qty[j] + "</td><td>" + sell_price[j] + "</td><td>" + pro_discount[j] + "</td><td style='text-align:right'>" + total_net[j] + "</td></tr>");
                        }
                        if (totalDiscount > 0) {
                            $("#discountRow").show();
                        } else {
                            $("#discountRow").hide();
                        }
                        if (dueAmount > 0) {
                            $("#balanceRow").show();
                        } else {
                            $("#balanceRow").hide();
                        }

                        if (total != toPay) {
                            $("#netAmountRow").show();
                        } else {
                            $("#netAmountRow").hide();
                        }
                        if (cashAmount != toPay) {
                            $("#cusPayRow").show();
                        } else {
                            $("#cusPayRow").hide();
                        }
                        $("#invNumber").html(invNumber);
                        $("#invoiceDate").html(invoicedate);
                        $("#invCashier").html(invfname);
                        $("#invTotal").html(accounting.formatMoney(total));
                        $("#invTotalDis").html(accounting.formatMoney(totalDiscount));
                        $("#invNet").html(accounting.formatMoney(toPay));
                        $("#invCusPay").html(accounting.formatMoney(cashAmount));
                        $("#invBalance").html(accounting.formatMoney(dueAmount));
                        $("#invNoItem").html(accounting.formatMoney(product_code.length));

                        var divContents = $("#printArea").html();
                        var printWindow = window.open('', '', 'height=400,width=800');
                        printWindow.document.write('<html><head><title>DIV Contents</title>');
                        printWindow.document.write('</head><body >');
                        printWindow.document.write(divContents);
                        printWindow.document.write('</body></html>');
                        printWindow.document.close();
                        printWindow.print();
                        setTimeout(function() {
                            printWindow.close();
                        }, 10);

                        product_code.length = 0;
                        unit.length = 0;
                        serial_no.length = 0;
                        qty.length = 0;
                        freeQty.length = 0;
                        sell_price.length = 0;
                        cost_price.length = 0;
                        ref.length = 0;
                        pro_discount.length = 0;
                        total_amount.length = 0;
                        total_net.length = 0;
                        price_level.length = 0;
                        warranty.length = 0;
                        unitPC.length = 0;
                        ccAmountArr.length = 0;
                        ccRefArr.length = 0;
                        ccTypeArr.length = 0;
                        cancelInvoice();
                        $("#modelPayment").modal('toggle');
                        $("#search_product").focus();
                    }
                }
            });
        }
    });
    // add card refrence

    $("#addCard").click(function() {
        var cref = $("#card_ref").val();
        var ctype = $("#card_type option:selected").val();
        var cname = $("#card_type option:selected").html();
        var camount = parseFloat($("#ccard_amount").val());

        if (ctype == '' || ctype == 0) {
            $("#errCard").show();
            $("#errCard").html('Please select a card type').addClass('alert alert-danger alert-sm');
            $("#errCard").fadeOut(1500);
            return false;
        } else if (camount == '' || camount == 0) {
            $("#errCard").show();
            $("#errCard").html('Please enter card amount').addClass('alert alert-danger alert-xs');
            $("#errCard").fadeOut(1500);
            return false;
        } else {
            $("#tblCard tbody").append("<tr ctype='" + ctype + "'  cref='" + cref + "'  camount='" + camount + "' cname='"+cname+"' ><td>" + cname + "</td><td>" + cref + "</td><td class='text-right'>" + accounting.formatMoney(camount) + "</td><td><a href='#' class='btn btn-danger btn-xs removeCard' ><i class='fa fa-close'></i></a></td></tr>");
        }
        cardAmount += camount;
        addPayment(cashAmount, creditAmount, cardAmount);
        $("#card_amount").val((cardAmount));
        $("#card_ref").val('');
        $("#card_type").val(0);
        $("#ccard_amount").val(0);
    });

    $("#tblCard tbody").on('click', '.removeCard', function() {
        $(this).parent().parent().remove();

        cardAmount -= parseFloat($(this).parent().parent().attr('camount'));
        addPayment(cashAmount, creditAmount, cardAmount);
        $("#card_amount").val((cardAmount));
    });

    $("#printInvoice").click(function() {
        var divContents = $("#printArea").html();
        var printWindow = window.open('', '', 'height=400,width=800');
        printWindow.document.write('<html><head><title>DIV Contents</title>');
        printWindow.document.write('</head><body >');
        printWindow.document.write(divContents);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    });

    $("#cart-return-to-order").click(function() {
        cancelInvoice();
    });
    function loadInvoice() {
        var j = 0;
        for (j = 0; j < product_code.length; j++) {
            $("#tblData").append("<tr><td colspan='4'>" + product_name[j] + "</td></tr>" +
                    "<tr><td>" + qty[j] + "</td><td>" + sell_price[j] + "</td><td>" + pro_discount[j] + "</td><td style='text-align:right'>" + total_net[j] + "</td></tr>");
        }
    }

    function cancelInvoice() {
        proCodeArr.length = 0;

        $('#cart-table-body table tbody').empty();
        $("#tblCard tbody").empty();

        proCode = 0;
        upc = 1;
        proName = '';
        qty = 0;
        freeQty = 0;
        serialNo = 0;
        sellPrice = 0;
        costPrice = 0;
        net_amount = 0;
        priceLevel = 0;
        total_amount = 0;
        total_cost = 0;
        disType = 1;
        disAmountType = 1;
        disPresentage = 0;
        disCash = 0;
        productDiscount = 0;
        totalDiscount = 0;
        total = 0;
        toPay = 0;
        prlevel = 0;
        cashAmount = 0;
        creditAmount = 0;
        cardAmount = 0;
        dueAmount = 0;
        ref = 0;
        totalCost = 0;
        warrnty = 0;

        $("#customer_id").val(0);
        $("#mcash").html('0.00');
        $("#mcard").html('0.00');
        $("#mcredit").html('0.00');
        $("#mchange").html('0.00');
        $("#card_amount").val((0));
        $("#cash_amount").val(0);
        $("#credit_amount").val(0);
        $("#cart-value").html('0.00');
        $("#cart-topay").html('0.00');
        $("#cart-discount").html('0.00');
        $("#mtotal").html('0.00');
        $("#mnetpay").html('0.00');
        $("#mdiscount").html('0.00');
        $("#changeLable").html('Change/Refund');
        $("#search_product").focus();
        $("#suggestPanel").toggle();


    }
});
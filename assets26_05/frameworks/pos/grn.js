$(document).ready(function() {
    var supcode;

    $('#grnDate,#deliverydate,#chequeReciveDate,#expenses_date,#quartPayDate,#chequeDate,#downPayDate1,#downPayDate2,#downPayDate3,#downPayDate4,#downPayDate5,#downPayDate6').datepicker({
        dateFormat: 'yy-mm-dd',
        startDate: '-3d'
    });

    $('#grnDate,#chequeReciveDate,#expenses_date,#quartPayDate,#downPayDate1,#downPayDate2,#downPayDate3,#downPayDate4,#downPayDate5,#downPayDate6').datepicker().datepicker("setDate", new Date());
    $("#dv_FreeQty").hide();
    $("#cusImage").hide();
    $("#lotPriceLable").hide();
    $('#costTable').hide();
    $('#paymentTable').hide();
    $('#payView').hide();
    $("#dv_SN").hide();
    $("#dwnLink").hide();
    $("#loadBarCode").hide();

    $("#lbl_lotNo").hide();
    $("#lbl_polishWeight").hide();
    $("#lbl_buyAmount").hide();
    $("#lbl_cutWeight").hide();
    $("#chequeData").hide();
    $("#refundAmountLable").hide();
    $("#returnAmountLable").hide();
    $("#tbl_payment_schedule").hide();

//    $("#panel_down_payments").hide();
//    $("#panel_quarter").hide();
    var item_ref = 0;
    var itemImagesArr = [];
    var gemOption = [];
    var cusCode = 0;
    var acc_no = 0;
    var invNo = 0;
    var batchNo = 0;
    var cusType = 2;
    var customer_payment = 0;
    var accType = 0;
    var accCategory = 0;
    var totalExtraChrages = 0;
    var downPayment = 0;
    var totalIterest = 0;
    var finalAmount = 0;
    var Interest = 0;
    var dwnInt = 0;
    var return_amount = 0;
    var itemCode = '';

    var i = 0;
    var itemcode = [];
    var isBuy = 0;
    var isCut = 0;
    var isPolish = 0;
    var total_amount = 0;
    var total_amount2 = 0;
    var totalCost = 0;
    var cashAmount = 0;
    var chequeAmount = 0;
    var creditAmount = 0;
    var dueAmount = 0;
    var lotPrice = 0;
    var returnAmount = 0;
    var refundAmount = 0;
    var returnPayment = 0;

    var discount_precent = 0;
    var discount_amount = 0;
    var product_discount = 0;
    var totalNet2 = 0;
    var totalNet = 0;
    var totalNetAmount = 0;
    var total_discount = 0;
    var total_item_discount = 0;
    var discount = 0;
    var discount_type = 0;
    var total_dwn_interest = 0;
    var total_qur_interest = 0;
    var totalExtraAmount = 0;
    var totalProWiseDiscount = 0;
    var totalGrnDiscount = 0;

    var accType2 = 1;
    var price_level = 1;
    var supcode = 0;
    var isSup = 0;
    
    var sinput = 0;
    var fsinput = 0;
    var maxSerialQty = 0;
    var serialAutoGen = 0;
    var maxSerialQty2=0;
//get auto serial max number
    $.ajax({
        type: "post",
        url: "getAutoSerialMax",
        data: {proCode: 1},
        success: function(json) {
            sinput = json;
            fsinput = json;
            $("#maxSerial").val(json);
        },
        error: function() {
            alert('Error while request..');
        }
    });

    //======= set price levels ==========
    $("#priceLevel").change(function() {
        price_level = $("#priceLevel option:selected").val();
    });

    $("#supplier").change(function() {
        supcode = $("#supplier option:selected").val();
    });
    var loc = $("#location").val();
    $('#itemCode').on('keydown', function(e) {
        if (e.which == 13) {
            $("#errGrid").hide();
//            $("#cart-table-notice").remove();
            var barCode = $(this).val();
            price_level = $("#priceLevel option:selected").val();
            //var loc = $("#location").val();
//            alert(price_level);
            $.ajax({
                type: "post",
                url: "../../admin/Product/getProductByBarCodeforGrn",
                data: {proCode: barCode, prlevel: price_level, location: loc},
                success: function(json) {

                    var resultData = JSON.parse(json);
                    if (resultData) {
                        itemCode = resultData.product.ProductCode;
                        $.each(resultData.serial, function(key, value) {
                            var serialNoArrIndex2 = $.inArray(value, serialnoarr);
                            if (serialNoArrIndex2 < 0) {
                                serialnoarr.push(value);
                            }
                        });
                        autoSerial = resultData.product.IsRawMaterial;
                        loadProModal(resultData.product.Prd_Description, resultData.product.ProductCode, resultData.product.ProductPrice, resultData.product.Prd_CostPrice, 0, resultData.product.IsSerial, resultData.product.IsFreeIssue, resultData.product.IsOpenPrice, resultData.product.IsMultiPrice, resultData.product.Prd_UPC, resultData.product.WarrantyPeriod, resultData.product.IsRawMaterial);

//                        itemCode = resultData.ProductCode;
//                        loadProModal(resultData.Prd_Description, resultData.ProductCode, resultData.ProductPrice, resultData.Prd_CostPrice, resultData.SerialNo, resultData.IsSerial, resultData.IsFreeIssue, resultData.IsOpenPrice, resultData.IsMultiPrice, resultData.Prd_UPC, resultData.WarrantyPeriod);
//                        $('html, body').animate({scrollTop: $('#cart-table-body').offset().top}, 'slow');
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
            e.preventDefault();
        }
    });

//isSup =  $("[name='suppliercheck']:checked").val();

    $("input[name='suppliercheck']").on('ifChanged', function() {
        isSup = $("input[name='suppliercheck']:checked").val();
        if (!isSup) {
            isSup = 0;
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
                    type: 'getActiveProductCodes',
                    sup: isSup,
                    supcode: supcode,
                    row_num: 1,
                    action: "getActiveProductCodes",
                    price_level: price_level
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
//            var names = (ui.item.label);
            itemCode = ui.item.value;
//        alert(itemCode);
            $.ajax({
                type: "post",
                url: "../../admin/Product/getProductByIdforGrn",
                data: {proCode: itemCode, prlevel: price_level, location: loc},
                success: function(json) {
                    var resultData = JSON.parse(json);
//                    alert(resultData.serial);
                    if (resultData) {

                        $.each(resultData.serial, function(key, value) {
                            var serialNoArrIndex1 = $.inArray(value, serialnoarr);
                            if (serialNoArrIndex1 < 0) {
                                serialnoarr.push(value);
                            }
                        });
                        autoSerial = resultData.product.IsRawMaterial;
                        loadProModal(resultData.product.Prd_Description, resultData.product.ProductCode, resultData.product.ProductPrice, resultData.product.Prd_CostPrice, 0, resultData.product.IsSerial, resultData.product.IsFreeIssue, resultData.product.IsOpenPrice, resultData.product.IsMultiPrice, resultData.product.Prd_UPC, resultData.product.WarrantyPeriod, resultData.product.IsRawMaterial);
                        //  loadProModal(resultData.Prd_Description, resultData.ProductCode, resultData.ProductPrice, resultData.Prd_CostPrice, 0, resultData.IsSerial, resultData.IsFreeIssue, resultData.IsOpenPrice, resultData.IsMultiPrice, resultData.Prd_UPC, resultData.WarrantyPeriod);

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
        }
    });

//load model
    function loadProModal(mname, mcode, msellPrice, mcostPrice, mserial, misSerial, misFree, isOP, isMP, upc, waranty, isautoSerial) {
//        clearProModal();
        $("#qty").focus();
//       alert(misSerial);
        if (misSerial == 1 || isautoSerial == 1) {
//            $("#serialNo").val(mserial);
//            $("#qty").val(1);
//            $("#qty").attr('disabled', true);
            $("#dv_SN").show();
            $("#qty").focus();
        } else {
//            $("#mSerial").val('');
            $("#qty").attr('disabled', false);
            $("#dv_SN").hide();
        }
        $("#qty").val(1);
//        $("#mLProCode").html(mcode);
        $("#prdName").val(mname);
        $("#itemCode").val(mcode);
        $("#sellingPrice").val(msellPrice);
        $("#unitcost").val(mcostPrice);
        $("#isSerial").val(misSerial);
        $("#upc").val(upc);

        if (misSerial == 1) {

        } else {
            $("#dv_SN").hide();
        }
        if (misFree == 1) {
            $("#dv_FreeQty").show();
        } else {
            $("#dv_FreeQty").hide();
        }


    }
    discount_precent = parseFloat($("#disPercent").val());
    discount_amount = parseFloat($("#disAmount").val());
    discount = $("input[name='discount']:checked").val();
    discount_type = $("input[name='discount_type']:checked").val();

//===========discount types===========================
    $("input[name='discount']").on('ifChanged', function() {
        var check = ($(this).val());

        if (check == 1) {
            $("#disAmount").val(0);
        } else if (check == 2) {
            $("#disPercent").val(0);
        }
    });

    $("input[name='discount_type']").on('ifChanged', function() {
        var check = ($(this).val());

        if (check == 1) {
            $("#disAmount").val(0);
        } else if (check == 2) {
            $("#disPercent").val(0);
        }
    });

    var sellingPrice = 0;
    var costPrice = 0;
    var casecost = 0;
    $("#sellingPrice").blur(function() {
        sellingPrice = parseFloat($(this).val());
        costPrice = parseFloat($("#unitcost").val());

        if (costPrice > sellingPrice) {
            $("#errProduct").show();
            $("#errProduct").html('Selling price can not be less than cost price').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
            return false;
        }
    });

    $("#unitcost").blur(function() {
        costPrice = parseFloat($(this).val());
        sellingPrice = parseFloat($("#sellingPrice").val());

        if (costPrice > sellingPrice) {
            $("#errProduct").show();
            $("#errProduct").html('Selling price can not be less than cost price').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
            return false;
        }
    });

    $("#qty").blur(function() {
        $("#serialQty").val($(this).val());
    });
    var serialQty = 0;
    var newSerialQty = 0;
    var serialnoarr = [];
//=========Add products===============================
    $("#addItem").click(function() {
        add_products();
    });

    $('#serialNo').on('keydown', function(e) {
        if (e.which == 13) {
            add_products();
        }
    });

    $('#sellingPrice').on('keydown', function(e) {
        if (e.which == 13) {
            add_products();
        }
    });

    function add_products() {
        var serialQty = 0;
        sellingPrice = parseFloat($("#sellingPrice").val());
        var unit = $("#mUnit option:selected").val();
        var prdName = $("#prdName").val();
        var serialNo = $("#serialNo").val();
        var is_serail = $("#isSerial").val();
        var priceLevel = $("#priceLevel option:selected").val();
        var qty = parseFloat($("#qty").val());
        var upc = parseFloat($("#upc").val());
        costPrice = parseFloat($("#unitcost").val());
        var freeQty = parseFloat($("#freeqty").val());
        var case1 = $("#mUnit option:selected").val();
        newSerialQty = parseFloat($("#serialQty").val());
        maxSerialQty = qty;
        maxSerialQty2 = qty;
        if (is_serail == 1 && autoSerial == 0) {
            serialQty = newSerialQty;
            qty = 1;
        } else {
            qty = qty;
        }

        if (case1 == 'Unit' || case1 == 'UNIT') {
            qty = qty;
        } else if (case1 == 'Case' || case1 == 'CASE') {
            qty = upc * qty;
            casecost = costPrice * qty;
        }
        var itemCodeArrIndex = $.inArray(itemCode, itemcode);

        if (itemCode == '' || itemCode == 0) {
            $("#errProduct").show();
            $('html, body').animate({scrollTop: $('#location').offset().top}, 'slow');
            $("#errProduct").html('Please select a item.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
            return false;
        } else if (sellingPrice == '' || sellingPrice == 0 || isNaN(sellingPrice) == true) {
            $("#errProduct").show();
            $('html, body').animate({scrollTop: $('#location').offset().top}, 'slow');
            $("#errProduct").html('Selling price can not be 0.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
            return false;
        } else if (costPrice == '' || costPrice == 0 || isNaN(costPrice) == true) {
            $("#errProduct").show();
            $('html, body').animate({scrollTop: $('#location').offset().top}, 'slow');
            $("#errProduct").html('Cost price can not be 0.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
            return false;
        } else if (qty == '' || qty == 0 || isNaN(qty) == true) {
            $("#errProduct").show();
            $('html, body').animate({scrollTop: $('#location').offset().top}, 'slow');
            $("#errProduct").html('Please enter a qty').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
            return false;
        } else if (costPrice > sellingPrice) {
            $("#errProduct").show();
            $('html, body').animate({scrollTop: $('#location').offset().top}, 'slow');
            $("#errProduct").html('Selling price can not be less than cost price').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
            return false;
        } else {
            if (is_serail == 0) {
                if ((itemCodeArrIndex < 0 && is_serail == 0)) {

                    totalNet2 = (costPrice * qty);
                    itemcode.push(itemCode);
                    total_amount2 += totalNet2;
                    totalCost += costPrice;
                    $("#totalWithOutDiscount").val(total_amount2);

                    calculateProductWiseDiscount(totalNet2, discount, discount_type, discount_precent, discount_amount, total_amount2);
                    cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount);
                    i++;
                    if (is_serail == 1) {
                        serialQty--;
                        $("#serialQty").val(serialQty);
                    }

                    $("#tbl_item tbody").append("<tr ri=" + i + " id=" + i + " proCode='" + itemCode + "' uc='" + unit + "' qty='" + qty + "' unit_price='" + sellingPrice + "' upc='" + upc + "' caseCost='" + casecost + "' isSerial='" + is_serail + "' serial='" + serialNo + "' discount_percent='" + discount_precent + "' cPrice='" + costPrice + "' pL='" + priceLevel + "' fQ='" + freeQty + "' nonDisTotalNet='" + totalNet2 + "' netAmount='" + totalNet + "' proDiscount='" + product_discount + "' proName='" + prdName + "'>\n\
                <td class='text-center'>" + i + "</td><td class='text-left'>" + itemCode + "</td><td>" + prdName + "</td><td>" + unit + "</td><td class='qty" + i + "'>" + accounting.formatNumber(qty) + "</td><td class='text-right'>" + accounting.formatNumber(costPrice) + "</td><td class='text-center'>" + discount_precent + "</td><td class='text-right' >" + accounting.formatMoney(totalNet) + "</td><td>" + serialNo + "</td><td class='rem" + i + "'><a href='#' class='remove btn btn-xs btn-danger'><i class='fa fa-remove'></i></a></td></tr>");

                    if (is_serail != 1) {
                        clear_gem_data();
                    } else {
                        if (serialQty == 0) {
                            clear_gem_data();
                        } else {
                            $("#serialNo").val('');
                            $("#serialNo").focus();
                        }
                    }
                    setProductTable();
                } else {
                    $("#errProduct").show();
                    $('html, body').animate({scrollTop: $('#location').offset().top}, 'slow');
                    $("#errProduct").html('Item already exists.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                    return false;
                }

            } else if (is_serail == 1) {
                if (autoSerial == 1) {
                    serialAutoGen = 1;
                    var serialNoArrIndex = $.inArray(serialNo, serialnoarr);
                    sinput=parseFloat($("#maxSerial").val());
//                    serialNo = strPad((sinput + 1), 8, '', 0);
                    var sQty = maxSerialQty;

                    for (var s = 0; s < sQty; s++) {
                        qty = 1;
                        sinput++;
                        serialNo = strPad(sinput, 8, '', 0);
                        totalNet2 = (costPrice * qty);
                        itemcode.push(itemCode);
                        serialnoarr.push(serialNo);
                        total_amount2 += totalNet2;
                        totalCost += costPrice;
                        $("#totalWithOutDiscount").val(total_amount2);

                        calculateProductWiseDiscount(totalNet2, discount, discount_type, discount_precent, discount_amount, total_amount2);
                        cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount);
                        i++;
                        if (is_serail == 1) {
                            serialQty--;
                            $("#serialQty").val(serialQty);
                        }

                        $("#tbl_item tbody").append("<tr ri=" + i + " id=" + i + " proCode='" + itemCode + "' uc='" + unit + "' qty='" + qty + "' unit_price='" + sellingPrice + "' upc='" + upc + "' caseCost='" + casecost + "' isSerial='" + is_serail + "' serial='" + serialNo + "' discount_percent='" + discount_precent + "' cPrice='" + costPrice + "' pL='" + priceLevel + "' fQ='" + freeQty + "' nonDisTotalNet='" + totalNet2 + "' netAmount='" + totalNet + "' proDiscount='" + product_discount + "' proName='" + prdName + "'>\n\
                        <td class='text-center'>" + i + "</td><td class='text-left'>" + itemCode + "</td><td>" + prdName + "</td><td>" + unit + "</td><td class='qty" + i + "'>" + accounting.formatNumber(qty) + "</td><td class='text-right'>" + accounting.formatNumber(costPrice) + "</td><td class='text-center'>" + discount_precent + "</td><td class='text-right' >" + accounting.formatMoney(totalNet) + "</td><td>" + serialNo + "</td><td class='rem" + i + "'><a href='#' class='remove btn btn-xs btn-danger'><i class='fa fa-remove'></i></a></td></tr>");

                        if (is_serail != 1) {
                            clear_gem_data();
                        } else {
                            if (serialQty == 0) {
                                clear_gem_data();
                            } else {
                                $("#serialNo").val('');
                                $("#serialNo").focus();
                            }
                        }
                        setProductTable();
                    }
                } else {
                    var serialNoArrIndex = $.inArray(serialNo, serialnoarr);
                    if (serialNo == '' || serialNo == 0) {
                        $("#errProduct").show();
                        $('html, body').animate({scrollTop: $('#location').offset().top}, 'slow');
                        $("#errProduct").html('Serial Number can not be empty.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                        $("#serialNo").focus();
                        return false;
                    }
                    else if (((serialNoArrIndex >= 0 && is_serail == 1))) {
                        $("#errProduct").show();
                        $('html, body').animate({scrollTop: $('#location').offset().top}, 'slow');
                        $("#errProduct").html('Serial Number already exsits.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                        $("#serialNo").val('');
                        return false;
                    }
                    else if (((itemCodeArrIndex >= 0 && is_serail == 1) || (itemCodeArrIndex < 0 && is_serail == 1))) {

                        totalNet2 = (costPrice * qty);
                        itemcode.push(itemCode);
                        serialnoarr.push(serialNo);
                        total_amount2 += totalNet2;
                        totalCost += costPrice;
                        $("#totalWithOutDiscount").val(total_amount2);

                        calculateProductWiseDiscount(totalNet2, discount, discount_type, discount_precent, discount_amount, total_amount2);
                        cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount);
                        i++;
                        if (is_serail == 1) {
                            serialQty--;
                            $("#serialQty").val(serialQty);
                        }

                        $("#tbl_item tbody").append("<tr ri=" + i + " id=" + i + " proCode='" + itemCode + "' uc='" + unit + "' qty='" + qty + "' unit_price='" + sellingPrice + "' upc='" + upc + "' caseCost='" + casecost + "' isSerial='" + is_serail + "' serial='" + serialNo + "' discount_percent='" + discount_precent + "' cPrice='" + costPrice + "' pL='" + priceLevel + "' fQ='" + freeQty + "' nonDisTotalNet='" + totalNet2 + "' netAmount='" + totalNet + "' proDiscount='" + product_discount + "' proName='" + prdName + "'>\n\
                <td class='text-center'>" + i + "</td><td class='text-left'>" + itemCode + "</td><td>" + prdName + "</td><td>" + unit + "</td><td class='qty" + i + "'>" + accounting.formatNumber(qty) + "</td><td class='text-right'>" + accounting.formatNumber(costPrice) + "</td><td class='text-center'>" + discount_precent + "</td><td class='text-right' >" + accounting.formatMoney(totalNet) + "</td><td>" + serialNo + "</td><td class='rem" + i + "'><a href='#' class='remove btn btn-xs btn-danger'><i class='fa fa-remove'></i></a></td></tr>");

                        if (is_serail != 1) {
                            clear_gem_data();
                        } else {
                            if (serialQty == 0) {
                                clear_gem_data();
                            } else {
                                $("#serialNo").val('');
                                $("#serialNo").focus();
                            }
                        }
                        setProductTable();
                    } else {
                        $("#errProduct").show();
                        $('html, body').animate({scrollTop: $('#location').offset().top}, 'slow');
                        $("#errProduct").html('Item already exists.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                        $("#serialNo").val('');
                        return false;
                    }
                }
            }
        }
    }

//=========calculate total item wise discount by precentage=============================
    $("#disPercent").blur(function() {
        discount_precent = parseFloat($("#disPercent").val());
        discount_amount = parseFloat($("#disAmount").val());
        discount = $("input[name='discount']:checked").val();
        discount_type = $("input[name='discount_type']:checked").val();
        var total_amount3 = $("#totalWithOutDiscount").val();

        if (discount_type == 2) {
            calculateTotalItemWiseDiscount(discount, discount_type, discount_precent, discount_amount, total_amount3);
        }
    });

//=========calculate total item wise discount by amount=============================
    $("#disAmount").blur(function() {
        discount_precent = parseFloat($("#disPercent").val());
        discount_amount = parseFloat($("#disAmount").val());
        discount = $("input[name='discount']:checked").val();
        discount_type = $("input[name='discount_type']:checked").val();
        var total_amount3 = $("#totalWithOutDiscount").val();
        if (discount_type == 2) {
            calculateTotalItemWiseDiscount(discount, discount_type, discount_precent, discount_amount, total_amount3);
        }
    });

    //================remove row from grid subtraction total amount and discount==============================================
    $("#tbl_item").on('click', '.remove', function() {
        var rid = $(this).parent().parent().attr('ri');

        var r = confirm('Do you want to remove row no ' + rid + ' ?');
        if (r === true) {
            var totalNets = parseFloat(($(this).parent().parent().attr("nonDisTotalNet")));
            var proDiscount = parseFloat(($(this).parent().parent().attr("proDiscount")));
            var proCost = parseFloat(($(this).parent().parent().attr("cPrice")));

            total_amount -= totalNets;
            total_amount2 -= totalNets;
//            total_discount -= proDiscount;
            totalCost -= proCost;
            totalProWiseDiscount -= proDiscount;

            total_discount = totalProWiseDiscount + totalGrnDiscount;
            $("#totalWithOutDiscount").val(total_amount2);
            $("#totalAmount").html(accounting.formatMoney(total_amount2));
            $('#totalprodiscount').html(accounting.formatMoney(totalProWiseDiscount));

            cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount);
            //remove product code from array
            var removeItem = $(this).parent().parent().attr("proCode");
            var removeSerial = $(this).parent().parent().attr("serial");

            itemcode = jQuery.grep(itemcode, function(value) {
                return value != removeItem;
            });

            serialnoarr = jQuery.grep(serialnoarr, function(value) {
                return value != removeSerial;
            });

            $(this).parent().parent().remove();
            setProductTable();
            return false;
        } else {
            return false;
        }
    });

//===============save products ==============================
    $("#saveItems").click(function() {
        setProductTable();
        var rowCount = $('#tbl_item tr').length;
        var product_code = new Array();
        var item_code = new Array();
        var serial_no = new Array();
        var pro_name = new Array();
        var qty = new Array();
        var unit_price = new Array();
        var unit_type = new Array();
        var unitPC = new Array();
        var caseCost = new Array();
        var discount_precent = new Array();
        var pro_discount = new Array();
        var total_net = new Array();
        var isSerial = new Array();
        var price_level = new Array();
        var fee_qty = new Array();
        var cost_price = new Array();
        var pro_total = new Array();

        var grnDate = $("#grnDate").val();
        var invUser = $("#invUser").val();
        var location = $("#location option:selected").val();
        

        var invoicenumber = $("#invoicenumber").val();
        var additional = $("#additional").val();
        var grnremark = $("#grnremark").val();

        $('#tbl_item tbody tr').each(function(rowIndex, element) {
            product_code.push($(this).attr('proCode'));
            serial_no.push($(this).attr('serial'));
            qty.push(($(this).attr('qty')));
            unit_price.push(($(this).attr('unit_price')));
            discount_precent.push(($(this).attr('discount_percent')));
            pro_discount.push($(this).attr('proDiscount'));
            total_net.push(($(this).attr('netAmount')));
            price_level.push($(this).attr("pL"));
            unit_type.push($(this).attr("uc"));
            fee_qty.push($(this).attr("fQ"));
            cost_price.push(($(this).attr("cPrice")));
            unitPC.push(($(this).attr("upc")));
            caseCost.push(($(this).attr("caseCost")));
            pro_total.push($(this).attr("nonDisTotalNet"));
            isSerial.push($(this).attr("isSerial"));
            pro_name.push($(this).attr("proName"));
        });

        var sendProduct_code = JSON.stringify(product_code);
        var sendPro_name = JSON.stringify(pro_name);
        var sendSerial_no = JSON.stringify(serial_no);
        var sendQty = JSON.stringify(qty);
        var sendUnit_price = JSON.stringify(unit_price);
        var sendDiscount_precent = JSON.stringify(discount_precent);
        var sendPro_discount = JSON.stringify(pro_discount);
        var sendTotal_net = JSON.stringify(total_net);
        var sendPrice_level = JSON.stringify(price_level);
        var sendUnit_type = JSON.stringify(unit_type);
        var sendFree_qty = JSON.stringify(fee_qty);
        var sendCost_price = JSON.stringify(cost_price);
        var sendUpc = JSON.stringify(unitPC);
        var sendCaseCost = JSON.stringify(caseCost);
        var sendPro_total = JSON.stringify(pro_total);
        var sendIsSerial = JSON.stringify(isSerial);


        var r = confirm("Do you want to save this GRN.?");
        if (r == true) {
            if (supcode == '' || supcode == '0') {
                $("#errData").show();
                $('html, body').animate({scrollTop: $('#location').offset().top}, 'slow');
                $("#errData").html('Please select a supplier.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
//                maxSerialQty= maxSerialQty;
                return false;
            } else if ((rowCount - 1) == '0' || (rowCount - 1) == '') {
                $("#errData").show();
                $('html, body').animate({scrollTop: $('#location').offset().top}, 'slow');
                $("#errData").html('Please add products.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
//                maxSerialQty= maxSerialQty;
                return false;
            } else {
                maxSerialQty += parseFloat($("#maxSerial").val());
//alert(maxSerialQty);
                $("#saveItems").attr('disabled', true);
                $.ajax({
                    type: "post",
                    url: "saveGrn",
                    data: {invoicenumber: invoicenumber, additional: additional, grnremark: grnremark, product_code: sendProduct_code, serial_no: sendSerial_no, qty: sendQty, unit_price: sendUnit_price,
                        discount_precent: sendDiscount_precent, pro_discount: sendPro_discount, total_net: sendTotal_net, unit_type: sendUnit_type, price_level: sendPrice_level, upc: sendUpc,
                        case_cost: sendCaseCost, freeQty: sendFree_qty, cost_price: sendCost_price, pro_total: sendPro_total, isSerial: sendIsSerial, proName: sendPro_name, total_cost: totalCost, totalProDiscount: totalProWiseDiscount, totalGrnDiscount: totalGrnDiscount,
                        grnDate: grnDate, invUser: invUser, total_amount: total_amount, total_discount: total_discount, total_net_amount: totalNetAmount, location: location, supcode: supcode, maxSerialQty: maxSerialQty, serialAutoGen: serialAutoGen},
                    success: function(data) {
                        var resultData = JSON.parse(data);
                        var feedback = resultData['fb'];
                        var invNumber = resultData['InvNo'];
                        if (feedback != 1) {
                            $("#errData").show();
                            $('html, body').animate({scrollTop: $('#location').offset().top}, 'slow');
                            $("#errData").html('GRN not saved successfully.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                            $("#loadBarCode").hide();
                            $("#dwnLink").hide();
                            $("#saveItems").attr('disabled', false);
                            return false;
                        } else {
                            $("#errData").show();
                            $('html, body').animate({scrollTop: $('#location').offset().top}, 'slow');
                            $("#errData").html('GRN saved successfully.').addClass('alert alert-success alert-dismissible alert-xs').delay(1500).fadeOut(600);
                            $("input[name=suppliercheck][value='1']").prop('checked', false);
//                        $('#tbl_item tbody').html("");
                            $("#invoicenumber").val("");
                            $("#supplier").val("");
                            $("#totalgrn").html('0.00');
                            $("#grndiscount").html('0.00');
                            $("#netgrnamount").html('0.00');
                            $("#grnremark").val('');
                            serialAutoGen = 0;
                            total_amount = 0;
                            total_discount = 0;
                            totalNetAmount = 0;
                            supcode = 0;
                            creditAmount = 0;
                            dueAmount = 0;
                            totalProWiseDiscount = 0;
                            totalGrnDiscount = 0;
                            $("#cashAmount").val(0);
                            $("#chequeAmount").val(0);
                            $("#creditAmount").val(0);

                            $("#totalExpenses").html(0);
//                        getLastBatchNo();
                            $('#itemTable').show();
                            $('#costTable').hide();
                            $('#totalAmount').html('0.00');
                            $('#totalgrndiscount').html('0.00');
                            $('#totalprodiscount').html('0.00');
                            $('#dueAmount2').html('0.00');
                            $("#loadBarCode").hide();
                            $("#dwnLink").show();
                            $("#saveItems").attr('disabled', true);
                        }
                    }
                });

            }
        } else {
            return false;
        }
    });
    $("#resetItems").click(function() {
        var r = confirm("Do you want to Reset.?");
        if (r == true) {
            location.reload();
        } else {
            return false;
        }
    });
    $("#loadBarCode").click(function() {
        setProductTable();
        var rowCount = $('#tbl_item tr').length;
        var product_code = new Array();
        var item_code = new Array();
        var pro_name = new Array();
        var serial_no = new Array();
        var qty = new Array();
        var unit_price = new Array();
        var unit_type = new Array();
        var unitPC = new Array();
        var caseCost = new Array();
        var discount_precent = new Array();
        var pro_discount = new Array();
        var total_net = new Array();
        var isSerial = new Array();
        var price_level = new Array();
        var fee_qty = new Array();
        var cost_price = new Array();
        var pro_total = new Array();

        var grnDate = $("#grnDate").val();
        var invUser = $("#invUser").val();
        var location = $("#location option:selected").val();

        var invoicenumber = $("#invoicenumber").val();
        var additional = $("#additional").val();
        var grnremark = $("#grnremark").val();

//        customer_payment = cash_amount + cheque_amount + credit_amount + return_amount;

        $('#tbl_item tbody tr').each(function(rowIndex, element) {
            product_code.push($(this).attr('proCode'));
            serial_no.push($(this).attr('serial'));
            qty.push(($(this).attr('qty')));
            unit_price.push(($(this).attr('unit_price')));
            discount_precent.push(($(this).attr('discount_percent')));
            pro_discount.push($(this).attr('proDiscount'));
            total_net.push(($(this).attr('netAmount')));
            price_level.push($(this).attr("pL"));
            unit_type.push($(this).attr("uc"));
            fee_qty.push($(this).attr("fQ"));
            cost_price.push(($(this).attr("cPrice")));
            unitPC.push(($(this).attr("upc")));
            caseCost.push(($(this).attr("caseCost")));
            pro_total.push($(this).attr("nonDisTotalNet"));
            isSerial.push($(this).attr("isSerial"));
            pro_name.push($(this).attr("proName"));

        });

        var sendProduct_code = JSON.stringify(product_code);
        var sendPro_name = JSON.stringify(pro_name);
        var sendSerial_no = JSON.stringify(serial_no);
        var sendQty = JSON.stringify(qty);
        var sendUnit_price = JSON.stringify(unit_price);
        var sendDiscount_precent = JSON.stringify(discount_precent);
        var sendPro_discount = JSON.stringify(pro_discount);
        var sendTotal_net = JSON.stringify(total_net);
        var sendPrice_level = JSON.stringify(price_level);
        var sendUnit_type = JSON.stringify(unit_type);
        var sendFree_qty = JSON.stringify(fee_qty);
        var sendCost_price = JSON.stringify(cost_price);
        var sendUpc = JSON.stringify(unitPC);
        var sendCaseCost = JSON.stringify(caseCost);
        var sendPro_total = JSON.stringify(pro_total);
        var sendIsSerial = JSON.stringify(isSerial);


        var r = confirm("Do you want to save this GRN.?");
        if (r == true) {
            $.ajax({
                type: "post",
                url: "barcodeGen",
                data: {invoicenumber: invoicenumber, additional: additional, grnremark: grnremark, product_code: sendProduct_code, serial_no: sendSerial_no, qty: sendQty, unit_price: sendUnit_price,
                    discount_precent: sendDiscount_precent, pro_discount: sendPro_discount, total_net: sendTotal_net, unit_type: sendUnit_type, price_level: sendPrice_level, upc: sendUpc,
                    case_cost: sendCaseCost, freeQty: sendFree_qty, cost_price: sendCost_price, pro_total: sendPro_total, isSerial: sendIsSerial, proName: sendPro_name, total_cost: totalCost, totalProDiscount: totalProWiseDiscount, totalGrnDiscount: totalGrnDiscount,
                    grnDate: grnDate, invUser: invUser, total_amount: total_amount, total_discount: total_discount, total_net_amount: totalNetAmount, location: location, supcode: supcode},
                success: function(data) {
                    var resultData = JSON.parse(data);
                    var feedback = resultData['fb'];
                    var invNumber = resultData['InvNo'];
                    var filedata = resultData['fileData'];
                    if (feedback != 1) {
                        alert('Invoice not saved successfully');
                        return false;
                    } else {
                        $("#dwnLink").show();
                    }
                }
            });
        } else {
            return false;
        }
    });

    var p = 0;
    //add expenses
    var expensesArr = [];
    var total_expenses = 0;


    //================Common Functions====================//



    //===========calculate total summery======================================
    function cal_total(total, discount, extra, downPay, downPayInt, qurPayInt, totalInt, totalExtra) {

        var total_net2 = parseFloat(total) - parseFloat(discount);
        finalAmount = parseFloat(total_net2);
//        alert(total); alert(discount);
        $("#netgrnamount").html(accounting.formatMoney(total_net2));
        $("#grndiscount").html(accounting.formatMoney(discount));
        $("#totalgrn").html(accounting.formatMoney(total));
        total_discount = discount;
        total_amount = total;
        total_amount2 = total;
        totalNetAmount = total_net2;
    }

    //===============calculate product wise discount================================
    function calculateProductWiseDiscount(totalNet3, discount, discount_type, disPercent, disAmount, total_amount4) {

        //product wise discount 
        if (discount_type == 1) {
            if (discount == 1) {
                //discount by percent
                product_discount = totalNet3 * (disPercent / 100);
                disAmount = 0;
            } else if (discount == 2) {
                //discount by amount
                product_discount = disAmount;
                disPercent = product_discount * 100 / totalNet3;
            }
            total_item_discount = 0;
        } else if (discount_type == 2) {
            //total item wise discount
            total_discount = 0;
            product_discount = 0;
            disPercent = 0;
        }
        totalProWiseDiscount += product_discount;
        total_discount = totalProWiseDiscount + totalGrnDiscount;
        total_amount += totalNet3;
        totalNet = totalNet3 - parseFloat(product_discount);
        discount_precent = accounting.formatNumber(disPercent);
        totalNetAmount = total_amount - parseFloat(total_discount);
        cal_total(total_amount, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest);
        $('#discountAmount').html(accounting.formatMoney(total_discount));
        $('#totalprodiscount').html(accounting.formatMoney(totalProWiseDiscount));
    }

    //=============calculate total item wise discount================================
    function calculateTotalItemWiseDiscount(discount, discount_type, disPercent, disAmount, total_amount4) {

        //product wise discount 
        if (discount_type == 1) {
            product_discount = 0;
        } else if (discount_type == 2) {
            //total item wise discount
            total_discount = 0;
            product_discount = 0;
            if (discount == 1) {
                //discount by percent
                product_discount = total_amount4 * (disPercent / 100);

                disAmount = 0;
                disPercent = 0;
            } else if (discount == 2) {
                //discount by amount

                product_discount = disAmount;
                disPercent = 0;
            }
        }

        totalGrnDiscount = product_discount;

        total_discount = totalProWiseDiscount + totalGrnDiscount;
        discount_precent = 0;
        total_amount2 += parseFloat(total_amount4) - parseFloat(product_discount);
        total_amount = parseFloat(total_amount4);
        totalNetAmount = total_amount - parseFloat(total_discount);
        cal_total(total_amount, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest);

        $('#discountAmount').html(accounting.formatMoney(total_discount));
        $('#netgrnamount').html(accounting.formatMoney(totalNetAmount));
        $('#totalgrndiscount').html(accounting.formatMoney(totalGrnDiscount));
    }

    function clear_data_after_save() {
        $("input[name=isLot][value='0']").prop('checked', true);
        getLastBatchNo();
        $('#tbl_item tbody').html("");
        $('#table_expenses tbody').html("");
        $("#cusCode").html("");
        $("#customer").val("");
        $("#creditLimit").html('0.00');
        $("#creditPeriod").html('0');
        $("#cusOutstand").html('0.00');
        $("#availableCreditLimit").html('0.00');
        $("#city").html('');
        $("#cusImage").hide();
        expensesArr.length = 0;
        pcode.length = 0;
        total_expenses = 0;
        $("#totalExpenses").html(0);
    }

    function setProductTable() {
        $('#tbl_item tbody tr').each(function(rowIndex, element) {
            var row = rowIndex + 1;
            $(this).find("[class]").eq(0).html(row);
            $(this).find("[class]").eq(0).parent().attr("ri", row);
            $(this).find("[class]").eq(0).parent().attr("id", row);
        });
    }

    function clear_gem_data() {
        $("#sellingPrice").val('');
        $("#serialNo").val('');
        $("#dv_SN").hide();
        $("#itemCode").val('');
        $("#itemCode").focus();
        $("#batchCode").val('');
        $("#unitcost").val(0);
        $("#remark").val('');
        $("#guessAmount").val(0);
        $("#qty").val(0);
        $("#cutWeight").val(0);
        $("#polishWeight").val(0);
        $("#totalNet").val(0);
        $("#buyAmount").val(0);
        $("#isCut").val(1);
        $("#isPolish").val(1);
        $("#isBuy").val(1);
        $(".gemoption").prop('checked', false);
        $('.rank').val(0);
        $("#disPercent").val(0);
        $("#disAmount").val(0);

        $("#totalAmount").html(accounting.formatMoney(total_amount));
        $("#netAmount").html(accounting.formatMoney(totalNetAmount));

        $("input[name=isCut][value='1']").prop('checked', false);
        $("input[name=isPolish][value='1']").prop('checked', false);
        $("input[name=isBuy][value='1']").prop('checked', false);
        totalNet2 = 0;
        discount = 0;
        discount_type = 0;
        discount_precent = 0;
        discount_amount = 0;
        product_discount = 0;
        itemCode = 0;
        casecost = 0;
        costPrice = 0;
        sellingPrice = 0;
    }

    function deleteImg(imgid) {
        $.ajax({
            type: 'POST',
            url: "../Admin/Controller/Product.php",
            data: {action: 'deleteimagedata', pid: pid, imgid: imgid},
            success: function(data) {
                if (data == 'success') {
                    $("div[imgdata='" + imgid + "']").parent().hide();
                }
            }
        });
    }
});
$('.supplier_icheck').iCheck({
    checkboxClass: 'icheckbox_square-green',
    radioClass: 'iradio_square-blue',
    increaseArea: '50%' // optional
});

function strPad(input, length, string, code) {
    string = string || '0';
    input = input + '';
    return input.length >= length ? code + input : code + (new Array(length - input.length + 1).join(string)) + input;
}
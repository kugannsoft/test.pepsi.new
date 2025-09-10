/*
 * point of sale java script goes here
 * author esanka
 */
$(document).ready(function() {
    $('body').addClass('sidebar-collapse');

    //billing clock
    startTime();

    function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('Clock').innerHTML = h + ":" + m + ":" + s;
        var t = setTimeout(startTime, 500);
    }

    function checkTime(t) {
        if (t < 10) {
            t = "0" + t
        }
        ;  // add zero in front of numbers < 10
        return t;
    }

    $("#addCustomer").click(function() {
        $('#cusModal').load('customer/loadmodal_customeradd/', function(result) {
            $('#customermodal').modal({show: true});
        });
    });

    $('.prd_icheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '50%'
    });

//load customers
    $("#customer_id").select2({
        ajax: {
            url: "customer/loadacustomersjson",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term // search term
                };
            },
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        minimumInputLength: 2
    });

    $("#suggestPanel").hide();
    var disPrint = 0;
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
    var disAmountType = 2;
    var disPresentage = 0;
    var disCash = 0;
    var productDiscount = 0;
    var productDiscountTotal = 0;
    var totalDiscount = 0;
    var invoiceDiscountTotal = 0;
    var cusPayment = 0;
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
    var itemCount = 0;

    // PRINT DISABLE
    $("input[name='disablePrint']").on('ifChanged', function() {
        disPrint = $("input[name='disablePrint']:checked").val();
    });
    
    //barcode read
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
                        proCode = resultData.ProductCode;
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
        select: function(event, ui) {
            return false;
        }
    }).autocomplete("instance")._renderItem = function(ul, item) {
        $("#suggestPanel").show();
        return $("<div proCode='" + item.value + "' proName='" + item.label + "' class='col-lg-2 col-md-3 col-xs-6 shop-items filter-add-product noselect text-center' style='min-height: 75px;padding:5px; border-right: solid 1px #DEDEDE;border-bottom: solid 1px #DEDEDE;cursor:pointer;'>")
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
                    loadProModal(resultData.Prd_Description, resultData.ProductCode, resultData.ProductPrice, resultData.Prd_CostPrice, 0, resultData.IsSerial, resultData.IsFreeIssue, resultData.IsOpenPrice, resultData.IsMultiPrice, resultData.Prd_UPC, resultData.WarrantyPeriod);
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
        $(".percentage_discount,.flat_discount").removeClass("active");
        $(".flat_discount").addClass("active");
        $(".discount_type").html("<span class='label label-warning'>Cash</span>");

        $('#modelBilling').on('shown.bs.modal', function() {
            $("#mQty").focus();
        });

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
        $("#mIsFree").val(misFree);
        

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

        if (costPrice > sellPrice) {
            $("#errProduct").show();
            $("#errProduct").html('Selling price can not be less than cost price').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
            ;
            return false;
        }
    });

    //add product to grid
    var i = 1;
    var proCodeArr = [];
    var disVal = 0;

    function addProducts() {
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
        var mIsFree = $("#mIsFree").val();
        
        if (case1 == 'Unit') {
            qty = qty;
        } else if (case1 == 'Case') {
            qty = upc * qty;
        }
        if (sellPrice == '' || sellPrice == 0 || isNaN(sellPrice) == true) {
            $("#errProduct").show();
            $("#errProduct").html('Selling Price can not be 0.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
            ;
            return false;
        } else if ((qty+freeQty) == '' || (qty+freeQty) == 0 || isNaN((qty+freeQty)) == true) {
            $("#errProduct").show();
            $("#errProduct").html('Please enter a qty').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
            ;
            return false;
        } else if (proCode == '' || proCode == 0) {
            $("#errProduct").show();
            $("#errProduct").html('Please select a product').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
            ;
            return false;
        } else {
            if (proCodeArrIndex < 0) {
                total_amount = qty * sellPrice;
                total_cost = qty * costPrice;

                //skip dicount check
                if(mIsFree==1){
                    
                }else if(qty<0){
                    
                }else{
                //discount limit check    
                disVal = parseFloat($("#proWiseDiscount").val());
                if (isNaN(disVal) == false) {
                    if (disAmountType == 1) {
                        if (disVal < 100) {
                            productDiscount = total_amount * disVal / 100;
                        } else {
                            $("#errProduct").show();
                            $("#errProduct").html('Discount precentage can not be greater than 100').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                            ;
                            return false;
                        }
                    } else if (disAmountType == 2) {
                        if ((total_amount - disVal) > costPrice) {
                            productDiscount = disVal;
                        } else {
                            $("#errProduct").show();
                            $("#errProduct").html('Discount amount can not be greater than cost ("' + costPrice + '").').addClass('alert alert-danger alert-dismissible alert-sm').delay(2000).fadeOut(600);
                            ;
                            return false;
                        }
                    }
                } else {
                    $("#proWiseDiscount").val(0);
                }
            }

                net_amount = parseFloat(total_amount) - parseFloat(productDiscount);

                $("#cart-table-body table tbody").append("<tr id='" + i + "' proName='" + proName + "' totalAmount='" + total_amount + "' warranty='" + warrnty + "' netAmount='" + net_amount + "' productDiscount='" + productDiscount + "' qty='" + qty + "' freeQty='" + freeQty + "' productCode='" + proCode + "' sellingPrice='" + sellPrice + "' costPrice='" + costPrice + "'  ref='" + ref + "' serialNo='" + serialNo + "' priceLevel='" + priceLevel + "' unit='" + case1 + "'  upc='" + upc + "'>" +
                        "<td  width='50'  class='text-center'>" + i + "</td><td width='50'></td><td width='210' style='font-size:14px'  class='text-left'>" + proName+" " +serialNo + "</td><td width='130' class='text-right'>" + accounting.formatMoney(sellPrice) + "</td><td width='130' class='text-right'>" + accounting.formatMoney(qty) + "</td><td width='130' class='text-right'>" + accounting.formatMoney(freeQty) + "</td><td width='130' class='text-right'>" + accounting.formatMoney(productDiscount) + "</td><td width='110' class='text-right'>" + accounting.formatMoney(net_amount) + "</td><td class='text-right' width='50'><a href='#' class='btn btn-danger removeRw'><i class='fa fa-close'></i></a></td></tr>");

                i++;
                itemCount++;
                proCodeArr.push(proCode);
                total += total_amount;
                totalDiscount += productDiscount; //total discount
                productDiscountTotal += parseFloat(productDiscount);//productwise total discout
                totalCost += total_cost;
                toPay = parseFloat(total) - parseFloat(totalDiscount);
                $("#cart-value").html(accounting.formatMoney(total));
                $("#cart-topay").html(accounting.formatMoney(toPay));
                $("#cart-discount").html(accounting.formatMoney(totalDiscount));
                $("#mtotal").html(accounting.formatMoney(total));
                $("#mnetpay").html(accounting.formatMoney(toPay));
                $("#mdiscount").html(accounting.formatMoney(totalDiscount));
                $("#cash_amount").val(toPay);
                $("#mcash").html(accounting.formatMoney(toPay));
                $("#itemCount").html((itemCount));
                productDiscount = 0;
                total_amount = 0;
                net_amount = 0;
                disType = 1;
                disAmountType = 2;
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

                $("#suggestPanel").toggle();
            } else {
                $("#errProduct").show();
                $("#errProduct").html('Product already exists.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                ;
                return false;
            }

        }
    }

    $("#addProduct").click(function() {
        addProducts();
    });

    $('#mQty').on('keydown', function(e) {
        var checkqty = parseFloat($(this).val());
        if (e.which == 13 && checkqty > 0) {
            addProducts();
            e.preventDefault();
        }
    });

    $("#addDiscount").click(function() {
        disType = 2;
        disVal = parseFloat($("#totalAmountDiscount").val());
        if (isNaN(disVal) == false) {
            if (disAmountType == 1) {
                var td = (total * disVal / 100);
//                   alert(totalCost);
//                   alert(total-td);
//                   if((total-td)<totalCost){
                totalDiscount += td;
                invoiceDiscountTotal += td;
                productDiscount = 0;
//                    }else{
//                        $("#errTotalDis").show();
//                        $("#errTotalDis").html('Discount can not be greater than cost.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);;
//                        return false;
//                    }
            } else if (disAmountType == 2) {
//                    if((total-disVal)<totalCost){
                productDiscount = 0;
                totalDiscount += disVal;
                invoiceDiscountTotal += disVal;
//                    }else{
//                        $("#errTotalDis").show();
//                        $("#errTotalDis").html('Discount can not be greater than cost.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);;
//                        return false;
//                    }
            }
        } else {
            $("#totalAmountDiscount").val(0);
        }
        toPay = parseFloat(total) - parseFloat(totalDiscount);
        $("#cart-value").html(accounting.formatMoney(total));
        $("#cart-topay").html(accounting.formatMoney(toPay));
        $("#cart-discount").html(accounting.formatMoney(totalDiscount));
        $("#mtotal").html(accounting.formatMoney(total));
        $("#mnetpay").html(accounting.formatMoney(toPay));
        $("#mdiscount").html(accounting.formatMoney(totalDiscount));
        $("#modelTotalDis").modal('toggle');
        $("#totalAmountDiscount").val(0);
        disAmountType = 2;
        $(".percentage_discount,.flat_discount").removeClass("active");
        $(".flat_discount").addClass("active");
        $("#cash_amount").val(toPay);
        $("#mcash").html(accounting.formatMoney(toPay));
    });
    function calProductDiscount(c_disType, c_disAmountType, c_totNetAmount, c_totalAmout, c_cost, c_totalCost) {
        var disVal = 0;
        if (c_disType == 1) {
            disVal = parseFloat($("#proWiseDiscount").val());
            if (isNaN(disVal) == false) {
                if (c_disAmountType == 1) {
                    if (disVal < 100) {
                        productDiscount = c_totNetAmount * disVal / 100;
                    } else {
                        $("#errProduct").show();
                        $("#errProduct").html('Discount precentage can not be greater than 100').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                        ;
                        return false;
                    }
                } else if (c_disAmountType == 2) {
                    if (disVal < c_cost) {
                        productDiscount = disVal;
                    } else {
                        $("#errProduct").show();
                        $("#errProduct").html('Discount amount can not be greater than cost.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                        ;
                        return false;
                    }
                }
            } else {
                $("#proWiseDiscount").val(0);
            }
        } else if (c_disType == 2) {
            disVal = parseFloat($("#totalAmountDiscount").val());
            if (isNaN(disVal) == false) {
                if (c_disAmountType == 1) {
                    var td = (c_totalAmout * disVal / 100);
                    totalDiscount += td;
                    invoiceDiscountTotal += td;
                    productDiscount = 0;
                } else if (c_disAmountType == 2) {
                    productDiscount = 0;
                    totalDiscount += disVal;
                    invoiceDiscountTotal += disVal;
                }
            } else {
                $("#totalAmountDiscount").val(0);
            }

        }

    }
    $("#clearTotalDiscount").click(function() {
        disType = 2;
        totalDiscount -= invoiceDiscountTotal;
        toPay = parseFloat(total) - parseFloat(totalDiscount);
        $("#cart-value").html(accounting.formatMoney(total));
        $("#cart-topay").html(accounting.formatMoney(toPay));
        $("#cart-discount").html(accounting.formatMoney(totalDiscount));
        $("#mtotal").html(accounting.formatMoney(total));
        $("#mnetpay").html(accounting.formatMoney(toPay));
        $("#mdiscount").html(accounting.formatMoney(totalDiscount));
        $("#modelTotalDis").modal('toggle');
        $("#totalAmountDiscount").val(0);
        disAmountType = 2;
        $(".percentage_discount,.flat_discount").removeClass("active");
        $(".flat_discount").addClass("active");
        invoiceDiscountTotal = 0;
        $("#cash_amount").val(toPay);
        $("#mcash").html(accounting.formatMoney(toPay));
    });

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
        $("#mIsFree").val(0);
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
        productDiscountTotal -= parseFloat($(this).parent().parent().attr('productDiscount'));
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
        itemCount--;
        $("#cash_amount").val(toPay);
        $("#mcash").html(accounting.formatMoney(toPay));
        $("#itemCount").html((itemCount));

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

    $('#modelPayment').on('shown.bs.modal', function() {
        $("#cash_amount").focus();
    });

    $('#modelTotalDis').on('shown.bs.modal', function() {
        $("#totalAmountDiscount").focus();
    });

    $("#cart-discount-button").click(function() {
        $(".discount_type").html("<span class='label label-warning'>Cash</span>");
        disAmountType = 2;
    });

//    $("#cart-pay-button").click(function(){
//        $("#card_amount").val(toPay);
//        cashAmount = toPay;
//    });
    function saveInvoice() {
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
        var invDate=$('#invDate').val();
        cusPayment = cashAmount + cardAmount;

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
        
        if (proCodeArr.length == 0) {
            $("#errPayment,#errPrint").show();
            $("#errPayment").html('Add products').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
            $("#errPrint").html('Add products').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
            ;
            return false;
        } else if ((toPay == '' || (toPay == 0)) && proCodeArr.length == 0 ) {
            $("#errPayment,#errPrint").show();
            $("#errPayment").html('Please add products').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
            $("#errPrint").html('Please add products').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);

            return false;
        } else if (creditAmount > 0 && (cusCode == 0)) {
            $("#errPayment,#errPrint").show();
            $("#errPayment").html('Please select a customer').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
            $("#errPrint").html('Please select a customer').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
            
            return false;
        } else if (creditAmount == 0 && (cashAmount == 0) && (cardAmount == 0) && proCodeArr.length == 0) {
            $("#errPayment,#errPrint").show();
            $("#errPayment").html('Please cash amount').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
            $("#errPrint").html('Please cash amount').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
            
            return false;
        } else {
            $("#saveInvoice").attr('disabled', true);
            $.ajax({
                type: "post",
                url: "Pos/saveInvoice",
                data: {product_code: product_codeArr, unit: unitArr, freeQty: freeQtyArr, ref: refArr, warranty: warrantyArr, unitPC: unitPCArr, serial_no: serial_noArr, qty: qtyArr, sell_price: sell_priceArr, cost_price: cost_priceArr, pro_discount: pro_discountArr, total_net: total_netArr, price_level: price_levelArr, totalNetWODis: total_amountArr, cusCode: cusCode,
                    invDate: invDate, invUser: invUser, cash_amount: cashAmount, card_amount: cardAmount, credit_amount: creditAmount, total_amount: total, total_cost: totalCost, cusPayment: cusPayment, return_amount: 0, refund_amount: 0,
                    total_discount: totalDiscount, final_amount: toPay, location: location, ccAmount: ccAmountArr, ccRef: ccRefArr, ccType: ccTypeArr, ccName: ccNameArr},
                success: function(data) {
                    var resultData = JSON.parse(data);
                    var feedback = resultData['fb'];
                    var invNumber = resultData['InvNo'];
                    var invoicedate = resultData['InvDate'];
                    if (feedback != 1) {
                        alert('Invoice not saved successfully');
                        $("#saveInvoice").attr('disabled', false);
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
                        if (creditAmount > 0) {
                            $("#crdLabel").html('Credit Amount');
                        } else {
                            $("#crdLabel").html('Balance Amount');
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
                        $("#lastInv").html("Last Invoice - " + invNumber);
                        $("#invoiceDate").html(invoicedate);
                        $("#invCashier").html(invfname);
                        $("#invTotal").html(accounting.formatMoney(total));
                        $("#invTotalDis").html(accounting.formatMoney(totalDiscount));
                        $("#invNet").html(accounting.formatMoney(toPay));
                        $("#invCusPay").html(accounting.formatMoney(cusPayment));
                        $("#invBalance").html(accounting.formatMoney(dueAmount));
                        $("#invNoItem").html(accounting.formatMoney(product_code.length));

                        if (disPrint != 1) {
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
                        }
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
                        ccNameArr.length = 0;
                        itemCount = 0;
                        $('#disablePrint').iCheck('uncheck');
                        cancelInvoice();

                        $("#search_product").focus();
                        $("#saveInvoice").attr('disabled', false);
                    }
                }
            });
        }
    }

    $("#saveInvoice").click(function() {
        saveInvoice();
        $("#modelPayment").modal('toggle');
        if (!$('#suggestPanel').is(":visible")) {
            $("#suggestPanel").toggle();
        }
    });

    $("#savePrint").click(function() {
        cashAmount = toPay;
        saveInvoice();
        if (!$('#suggestPanel').is(":visible")) {
            $("#suggestPanel").toggle();
        }
    });

    // add card refrence
    var ccard = [];
    $("#addCard").click(function() {
        var cref = $("#card_ref").val();
        var ctype = $("#card_type option:selected").val();
        var cname = $("#card_type option:selected").html();
        var camount = parseFloat($("#ccard_amount").val());
        var ccTypeArrIndex = $.inArray(ctype, ccard);
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
            if (ccTypeArrIndex < 0) {
                $("#tblCard tbody").append("<tr ctype='" + ctype + "'  cref='" + cref + "'  camount='" + camount + "' cname='" + cname + "' ><td>" + cname + "</td><td>" + cref + "</td><td class='text-right'>" + accounting.formatMoney(camount) + "</td><td><a href='#' class='btn btn-danger removeCard' ><i class='fa fa-close'></i></a></td></tr>");
                ccard.push(ctype);
                cardAmount += camount;
                addPayment(cashAmount, creditAmount, cardAmount);
                $("#card_amount").val((cardAmount));
                $("#card_ref").val('');
                $("#card_type").val(0);
                $("#ccard_amount").val(0);
            } else {
                $("#errCard").show();
                $("#errCard").html('Card type already exist').addClass('alert alert-danger alert-sm');
                $("#errCard").fadeOut(1500);
            }
        }

    });

    $("#tblCard tbody").on('click', '.removeCard', function() {
        $(this).parent().parent().remove();
        var removeItem = $(this).parent().parent().attr('ctype');
        ccard = jQuery.grep(ccard, function(value) {
            return value != removeItem;
        });
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
        ccard.length = 0;
        $('#cart-table-body table tbody').empty();
        $("#tblCard tbody").empty();
        cusPayment = 0;
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
        productDiscountTotal = 0;
        invoiceDiscountTotal = 0;
        itemCount = 0;

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
        $("#itemCount").html(0);


    }

    $('#modelBilling').on('shown.bs.modal', function() {
        $("#proWiseDiscount").focus(function() {
            $(this).val('');
        });
    });
});
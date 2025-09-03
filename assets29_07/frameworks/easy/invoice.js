//str pad
function strPad(input, length, string, code) {
    string = string || '0';
    input = input + '';
    return input.length >= length ? code + input : code + (new Array(length - input.length + 1).join(string)) + input;
}

//str pad right
function strPadRight(input, length, string, code) {
    string = string || ' ';
    input = input + '';
    return input.length >= length ? code + input : code + (new Array(length - input.length + 1).join(string)) + input;
}

//str pad left
function strPadLeft(input, length, string, code) {
    string = string || ' ';
    input = input + '';
    return input.length >= length ? code + input : code + input + (new Array(length - input.length + 1).join(string));
}


$(document).ready(function() {

    $('#invDate,#chequeReciveDate,#mothly_payment_date,#expenses_date,#quartPayDate,#chequeDate,#downPayDate1,#downPayDate2,#downPayDate3,#downPayDate4,#downPayDate5,#downPayDate6').datepicker({
        format: 'yyyy-mm-dd',
        startDate: '-3d'
    });

    $('#invDate,#chequeReciveDate,#mothly_payment_date,#expenses_date,#quartPayDate,#downPayDate1,#downPayDate2,#downPayDate3,#downPayDate4,#downPayDate5,#downPayDate6').datepicker().datepicker("setDate", new Date());

    $("#cusImage").hide();
    $("#lotPriceLable").hide();
    $('#costTable').show();
    $('#paymentTable').show();

    $('#dwPaymentTbl').hide();
    $('#payView').show();

    $("#lbl_lotNo").hide();
    $("#lbl_polishWeight").hide();
    $("#lbl_buyAmount").hide();
    $("#lbl_cutWeight").hide();
    $("#chequeData").hide();
    $("#refundAmountLable").hide();
    $("#returnAmountLable").hide();
    $("#tbl_payment_schedule").hide();
    $("#payment_schedule").hide();

//    $("#panel_down_payments").hide();
    $("#panel_quarter").hide();
    var item_ref = 0;
    var itemImagesArr = [];
    var gemOption = [];
    var cusCode = 0;
    var acc_no = 0;
    var invNo = 0;
    var batchNo = 0;
    var cusType = 1;
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
    var loanAmount = 0;

    var ICtotalLength;
    var ICstringLength;
    var ICcodeLength;
    var ICString;
    var ICCode;

    var BNtotalLength;
    var BNstringLength;
    var BNcodeLength;
    var BNString;
    var BNCode;
    var accType2 = 1;
    var price_level = 1;

    dwnInt = parseFloat($("#dwnInterest").val());

    var outAccNo = 0;
    outAccNo = $("#outAccNo").val();
    if (outAccNo !=0) {
        $.ajax({
            type: "post",
            url: "../easyPayment/getActiveAccounts",
            data: {accNo: outAccNo, cus_type: cusType},
            success: function(data) {
            cal_total(0, 0, 0, 0, 0, 0, 0, 0);
            clearAll();
            var resultData = JSON.parse(data);
            $.each(resultData, function(key, value) {
                acc_no = value.id;
            $("#cusCode").html(value.Nic);
            $("#referralNo").html(value.refNo);
            $("#lbl_acc_no").html(acc_no);
            $("#customer").val(acc_no);
            $("#creditLimit").html(accounting.formatMoney(value.CreditLimit));
            $("#creditPeriod").html(value.CreditPeriod);
            $("#cusOutstand").html((value.CreditPeriod));
            $("#availableCreditLimit").html(accounting.formatMoney(0));
            $("#cusName").val((value.CusName));
            $("#cusName").prop('disabled',true);
            $("#city").html(value.CusName);
            cusCode = value.CusCode;
            accType = value.AccType;
            });

            if (accType == 1) {
                setEasyPayment();
            } else if (accType == 2) {
                setLoanPayment();

                $('#itemTable').hide();
                $('#payView').show();
                $('#paymentTable').show();
            }
            $("#exChargesTbl tbody").empty();
            $.ajax({
                type: "post",
                url: "../easyPayment/getExtraChargesById",
                data: {itemType: accType},
                success: function(data) {
                    try {
                        var resultData = JSON.parse(data);
                        var charge_amount = 0;
                        $.each(resultData, function(key, value) {
                            var charge_type = value.charge_type;
                            charge_amount = parseFloat(value.ChargeAmount);
                            totalExtraChrages += charge_amount;
                            $("#exChargesTbl tbody").append("<tr><td>" + (key + 1) + "</td><td>" + charge_type + "</td><td class='text-right'>" + accounting.formatMoney(charge_amount) + "</td>/tr>");
                        });
                        $("#total_extra").html(accounting.formatMoney(totalExtraChrages));
                        cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount, totalDwnPayment);
                    } catch (e){
                        console.log('test',data);
                    }

                }
            });

            $.ajax({
                type: "post",
                url: "../easyPayment/getTermInterest",
                data: {itemType: accType},
                success: function(data) {
                    var resultData = JSON.parse(data);
                    $("#noOfIntTerm").empty();
                    $("#noOfIntTerm").append("<option value='0'>-Select a term-</option>");
                    $.each(resultData, function(key, value) {
                        var charge_type = value.IntTerm;
                        $("#noOfIntTerm").append("<option value=" + value.IntId + ">" + charge_type + "</option>");
                    });
                }
            });
            }
        });
    }
    //get interest terms--------------------------------------------------------------------------
    $.ajax({
        type: "post",
        url: "../easyPayment/getTermInterest",
        data: {itemType: accType2},
        success: function(data) {
            try {
            var resultData = JSON.parse(data);
            $.each(resultData, function(key, value) {
                var charge_type = value.IntTerm;
                $("#noOfIntTerm").append("<option value=" + value.IntId + ">" + charge_type + "</option>");
            });
            }catch (e) {

            }
        }
    });

    //account autoload--------------------------------------------------------------------------
    $("#account_no").autocomplete({
        source: function(request, response) {

            $.ajax({
                url: '../easyPayment/getActiveAccounts',
                dataType: "json",
                data: {
                    name_startsWith: request.term,
                    cus_type: cusType
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.text,
                            value: item.id,
                            data: item
                        }
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function(event, ui) {
            cal_total(0, 0, 0, 0, 0, 0, 0, 0);
            clearAll();
            acc_no = ui.item.value;
            $("#cusCode").html(ui.item.data.Nic);
            $("#referralNo").html(ui.item.data.refNo);
            $("#lbl_acc_no").html(acc_no);
            $("#customer").val(acc_no);
            $("#creditLimit").html(accounting.formatMoney(ui.item.data.CreditLimit));
            $("#creditPeriod").html(ui.item.data.CreditPeriod);
            $("#cusOutstand").html(ui.item.data.CreditPeriod);
            $("#availableCreditLimit").html(accounting.formatMoney(0));
            $("#city").html(ui.item.data.CusName);
            $("#cusName").val(ui.item.data.CusName);

            $("#cusName").prop('disabled',true);
            // $("#cusImage").show();
            // $("#cusImage img").attr("src", "../dist/img/customer/" + names[4]);
            cusCode = ui.item.data.CusCode;
            accType = ui.item.data.AccType;
            // accCategory = names[2];

            if (accType == 1) {
                setEasyPayment();
            } else if (accType == 2) {
                setLoanPayment();
                $('#itemTable').hide();
                $('#payView').show();
                $('#paymentTable').show();
            }
            $("#exChargesTbl tbody").empty();
            $.ajax({
                type: "post",
                url: "../easyPayment/getExtraChargesById",
                data: {itemType: accType},
                success: function(data) {
                   try {
                       var resultData = JSON.parse(data);
                       var charge_amount = 0;
                       $.each(resultData, function(key, value) {
                           var charge_type = value.charge_type;
                           charge_amount = parseFloat(value.ChargeAmount);
                           totalExtraChrages += charge_amount;
                           $("#exChargesTbl tbody").append("<tr><td>" + (key + 1) + "</td><td>" + charge_type + "</td><td class='text-right'>" + accounting.formatMoney(charge_amount) + "</td>/tr>");
                       });
                       $("#total_extra").html(accounting.formatMoney(totalExtraChrages));
                       cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount, totalDwnPayment);
                   }catch (e){

                   }

                }
            });

            $.ajax({
                type: "post",
                url: "../easyPayment/getTermInterest",
                data: {itemType: accType},
                success: function(data) {
                    try {
                        var resultData = JSON.parse(data);
                        $("#noOfIntTerm").empty();
                        $("#noOfIntTerm").append("<option value='0'>-Select a term-</option>");
                        $.each(resultData, function(key, value) {
                            var charge_type = value.IntTerm;
                            $("#noOfIntTerm").append("<option value=" + value.IntId + ">" + charge_type + "</option>");
                        });
                    }catch (e){

                    }
                }
            });
        }
    });

    $("#priceLevel").change(function() {
        price_level = $("#priceLevel option:selected").val();
    });

    //change interest terms--------------------------------------------------------------------------
    $("#noOfIntTerm").change(function() {
        var id = $(this).val();
        var check = $("input[name='installmentType']:checked").val();
        $.ajax({
            type: "post",
            url: "../easyPayment/getTermInterestByID",
            data: {id: id},
            success: function(data) {
                var resultData = JSON.parse(data);
                console.log('data',resultData.Interest);
                $("#term_interest_rate").val(resultData.Interest);
                $("#term_interest_rate2").val(resultData.Interest);
                $("#instalment").val(resultData.installment);

                var month = $("#noOfIntTerm option:selected").html();
                var rate = $("#term_interest_rate2").val();

                Interest = calcTotalInterest(totalNetAmount, rate, month);
                $("#termInterst").html(accounting.formatMoney(Interest));
                // paytbl(totalNetAmount, rate, month, totalExtraAmount);
                cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount, totalDwnPayment);
                $("#tbl_payment_schedule").hide();
            }
        });
        //
        // if (check2 == 1) {
        //     $("#tbl_payment_schedule").show();
        //     rate = $("#term_interest_rate2").val();
        //     Interest = calcTotalInterest(totalNetAmount, rate, month);
        //     paytbl(totalNetAmount, rate, month, totalExtraAmount);
        //     totalIterest = Interest;
        //     $("#termInterst").html(accounting.formatMoney(Interest));
        //     cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount, totalDwnPayment);
        // } else {
        //     rate =0;
            // $("#tbl_payment_schedule").show();
            // Interest = calcTotalInterest(totalNetAmount, rate, month);
            // paytbl(totalNetAmount, rate, month, totalExtraAmount);
//            $("#tbl_payment_schedule").hide();
//             totalIterest = 0;
//             $("#termInterst").html(accounting.formatMoney(Interest));
            // cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount, totalDwnPayment);
        // }
    });


    $("input[name='installmentType']").on('ifChanged', function() {
        var check = $("input[name='installmentType']:checked").val();
        var rate = $("#term_interest_rate").val();
        var instalment = $("#instalment").val();
        var month = $("#noOfIntTerm option:selected").html();
        $("#instalmentTypes").val(check);

        console.log(rate);
        if (check == 1) {
            $("#tbl_payment_schedule").show();
            if(rate==0){
                rate = $("#term_interest_rate2").val();
                $("#term_interest_rate").val(rate);
            }else{
                rate = $("#term_interest_rate").val();
            }
            Interest = calcTotalInterest(totalNetAmount, rate, month);
            totalIterest = Interest;
            $("#termInterst").html(accounting.formatMoney(Interest));
            paytbl(totalNetAmount, rate, month, totalExtraAmount, instalment);
            cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount, totalDwnPayment);

        } else if (check == 2) {
            $("#tbl_payment_schedule").show();
            if(rate==0){
                rate = $("#term_interest_rate2").val();
                $("#term_interest_rate").val(rate);
            }else{
                rate = $("#term_interest_rate").val();
            }
            Interest = calcTotalInterest(totalNetAmount, rate, month);
            totalIterest = Interest;
            $("#termInterst").html(accounting.formatMoney(Interest));
            paytblWeekly(totalNetAmount, rate, month, totalExtraAmount, instalment);
            cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount, totalDwnPayment);
        }else if (check == 3) {
            $("#tbl_payment_schedule").show();
            if(rate==0){
                rate = $("#term_interest_rate2").val();
                $("#term_interest_rate").val(rate);
            }else{
                rate = $("#term_interest_rate").val();
            }
            Interest = calcTotalInterest(totalNetAmount, rate, month);
            totalIterest = Interest;
            $("#termInterst").html(accounting.formatMoney(Interest));
            paytblDaily(totalNetAmount, rate, month, totalExtraAmount, instalment);
            cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount, totalDwnPayment);
        }
    });


    //calculate interest by checking--------------------------------------------------------------------------
    $("input[name='isTermInterest']").on('ifChanged', function() {
        var check2 = $("input[name='isTermInterest']:checked").val();
        var rate = $("#term_interest_rate").val();
        var month = $("#noOfIntTerm option:selected").html();


        if (check2 == 1) {
            $("#tbl_payment_schedule").show();
            if(rate==0){
                rate = $("#term_interest_rate2").val();
                $("#term_interest_rate").val(rate);
            }else{
                rate = $("#term_interest_rate").val();
            }
            Interest = calcTotalInterest(totalNetAmount, rate, month);
            totalIterest = Interest;
            $("#termInterst").html(accounting.formatMoney(Interest));
            paytbl(totalNetAmount, rate, month, totalExtraAmount);
            cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount, totalDwnPayment);
        } else {
            rate =0;
            $("#tbl_payment_schedule").show();
            Interest = calcTotalInterest(totalNetAmount, rate, month);
            totalIterest = 0;
            $("#termInterst").html(accounting.formatMoney(0));
            paytbl(totalNetAmount, rate, month, totalExtraAmount);
            cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount, totalDwnPayment);
        }
    });


    // load return invoice--------------------------------------------------------------------------
    $("#returnInvoice").autocomplete({
        source: function(request, response) {

            $.ajax({
                url: '../Admin/Controller/Product.php',
                dataType: "json",
                data: {
                    name_startsWith: request.term,
                    type: 'getActiveReturnInvoicesByCustomer',
                    row_num: 1,
                    action: "getActiveReturnInvoicesByCustomer",
                    cus_code: cusCode
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        var code = item.split("|");
                        return {
                            label: code[0],
                            value: code[0],
                            data: item
                        }
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function(event, ui) {
            var names = ui.item.data.split("|");
            return_amount = names[1] - names[2];
            returnAmount = names[1] - names[2];
            $("#returnAmount").val(return_amount);
            $("#returnAmountLable").show();
            $("#return_amount").html(accounting.formatMoney(return_amount));
        }
    });

// load customer details--------------------------------------------------------------------------
    $("#cusName").autocomplete({
        source: function(request, response) {

            $.ajax({
                url: '../Admin/Controller/Customer.php',
                dataType: "json",
                data: {
                    name_startsWith: request.term,
                    type: 'getActiveCustomers',
                    row_num: 1,
                    action: "getActiveCustomers",
                    cus_type: 1,
                    item_type: 1
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        var code = item.split("|");
                        return {
                            label: code[0],
                            value: code[0],
                            data: item
                        }
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function(event, ui) {
            var names = ui.item.data.split("|");
            $("#cusCode").html(names[7]);
            $("#cusName").val(names[0]);
            $("#creditLimit").html(accounting.formatMoney(0));
            $("#creditPeriod").html(names[3]);
            $("#cusOutstand").html(accounting.formatMoney(0));
            $("#availableCreditLimit").html(accounting.formatMoney(0));
            $("#city").html(names[0]);
            $("#cusName").val(names[7]);
        }
    });


//--------------------------------------------------------------------------
    $("#itemCode").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../easyPayment/getActiveProductCodes',
                dataType: "json",
                data: {
                    name_startsWith: request.term,
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
            $("#sellingPrice").focus();
            itemCode = ui.item.value;

            $("#ItemCode").val(itemCode);
            $("#sellingPrice").val(ui.item.data.ProductPrice);
            $("#batchCode").val(ui.item.label);
            $("#productName").html(ui.item.label);
            $("#prdName").val(ui.item.label);
            $("#remark").val(ui.item.data.ProductPrice);
            $("#qty").val(1);
            $("#buyAmount").val(ui.item.data.Prd_CostPrice);
            // $("#isCut").val(names[6]);
            // $("#cutWeight").val(names[7]);
            // $("#isPolish").val(names[8]);
            // $("#polishWeight").val(names[9]);
            // var check_is_cut = (names[6]);
            // var check_is_polish = (names[8]);
            //
            // if (check_is_cut == 1) {
            //     $("#lbl_cutWeight").show();
            //     $("#isCut").prop("checked", true);
            // } else {
            //     $("#isCut").prop("checked", false);
            // }
            //
            // if (check_is_polish == 1) {
            //     $("#lbl_polishWeight").show();
            //     $("#isPolish").prop("checked", true);
            // } else {
            //     $("#isPolish").prop("checked", false);
            // }
        }
    });

//--------------------------------------------------------------------------
    $("#lotNo").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../Admin/Controller/Product.php',
                dataType: "json",
                data: {
                    name_startsWith: request.term,
                    type: 'getActiveLotGems',
                    row_num: 1,
                    action: "getActiveLotGems"
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        var code = item.split("|");
                        return {
                            label: code[2] + " " + code[0] + " " + code[1] + " - " + code[4] + " ct",
                            value: code[0],
                            data: item
                        }
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function(event, ui) {
            var names = ui.item.data.split("|");
            $("#lotPrice").focus();
            batchNo = names[2];

            $("#batchCode").val(names[2]);
            $("#lotNo").val(names[2]);

            var check_is_cut = (names[6]);
            var check_is_polish = (names[8]);
            $("#totalNet").prop("disabled", true);

            if (check_is_cut == 1) {
                $("#lbl_cutWeight").show();
                $("#isCut").prop("checked", true);
            } else {
                $("#isCut").prop("checked", false);
            }

            if (check_is_polish == 1) {
                $("#lbl_polishWeight").show();
                $("#isPolish").prop("checked", true);
            } else {
                $("#isPolish").prop("checked", false);
            }

            $("#tbl_item tbody").html("");
            $.ajax({
                type: "POST",
                url: "../Admin/Controller/Product.php",
                data: {action: "getActiveGemsByBatchNo", batchNo: batchNo},
                success: function(data)
                {
                    var resultData = JSON.parse(data);
                    $.each(resultData, function(key, value) {
                        var sellingPrice = value.PrdCode;
                        var item_Code = value.ItemCode;
                        var qty = value.KaratWeight;
                        var buyAmount = value.BuyAmount;
                        var totalNet = value.SoldAmount;
                        var rank = value.PrdRank;
                        $("#tbl_item tbody").append("<tr ri=" + (key + 1) + " id=" + (key + 1) + "><td>" + (key + 1) + "</td><td class='product_code" + (key + 1) + "'>" + sellingPrice + "</td><td class='item_code" + (key + 1) + "'>" + item_Code + "</td><td class='carat_weight" + (key + 1) + "'>" + accounting.formatNumber(qty) + "</td><td class='guess_amount" + (key + 1) + "'>" + accounting.formatMoney(buyAmount) + "</td><td class='sold_amount" + (key + 1) + "'>" + accounting.formatMoney(totalNet) + "</td><td class='other" + (key + 1) + "' rank='" + rank + "' isBuyW='" + isBuy + "' isCutW='" + isCut + "' isPolishW='" + isPolish + "' cutW='" + cutWeight + "' batchNo='" + batchNo + "' polishW='" + polishWeight + "' remark='" + remark + "' gemOption='" + gemOption + "' itemImages='" + itemImagesArr + "' >" + "" + "</td><td class='rem" + (key + 1) + "'><a href='#' class='remove btn btn-xs btn-danger'>Remove</a></td></tr>");
                    });
                }
            });
        }
    });

    discount_precent = parseFloat($("#disPercent").val());
    discount_amount = parseFloat($("#disAmount").val());
    discount = $("input[name='discount']:checked").val();
    discount_type = $("input[name='discount_type']:checked").val();

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

//----Add products----------------------------------------------------------------------
    $("#addItem").click(function() {

        var isLot = $("input[name='isLot']:checked").val();
        var sellingPrice = parseFloat($("#sellingPrice").val());
        var remark = $("#remark").val();
        var batchNo = $("#batchCode").val();
        var prdName = $("#prdName").val();
        var serialNo = $("#serialNo").val();
        var priceLevel = $("#priceLevel option:selected").val();
        var qty = parseFloat($("#qty").val());
        var polishWeight = parseFloat($("#polishWeight").val());
        var cutWeight = parseFloat($("#cutWeight").val());
        var buyAmount = parseFloat($("#buyAmount").val());
        var rank = $("#rank").val();

        isBuy = $("input[name='isBuy']:checked").val();
        isCut = $("input[name='isCut']:checked").val();
        isPolish = $("input[name='isPolish']:checked").val();
        var itemCodeArrIndex = $.inArray(itemCode, itemcode);

        $("input[name='gemOption[]']:checked").each(function(k) {
            gemOption[k] = $(this).val();
        });

        if (itemCode == '' && isLot == 0) {
            $.notify("Please select a item.", "warning");
            return false;
        }else if(isLot == 1){
            $.notify("All Ready Added Loan Amount.", "success");
            return false;
        }else if (sellingPrice == '') {
            $.notify("Please enter unit price.", "warning");
            return false;
        } else {
            if (itemCodeArrIndex < 0) {
                totalNet2 = (sellingPrice * qty);
                itemcode.push(itemCode);
                total_amount2 += totalNet2;
                $("#totalWithOutDiscount").val(total_amount2);

                calculateProductWiseDiscount(totalNet2, discount, discount_type, discount_precent, discount_amount, total_amount2);
                cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount, totalDwnPayment);
                i++;
                $("#tbl_item tbody").append("<tr ri=" + i + " id=" + i + "><td>" + i + "</td><td class='product_code" + i + "' proCode='" + itemCode + "'>" + prdName + "</td><td class='serial_no" + i + "'>" + serialNo + "</td><td class='qty" + i + "'>" + accounting.formatNumber(qty) + "</td><td class='unit_price" + i + "'>" + accounting.formatNumber(sellingPrice) + "</td><td class='discount_percent" + i + "'>" + discount_precent + "</td><td class='totalNet" + i + "' nonDisTotalNet='" + totalNet2 + "' proDiscount='" + product_discount + "' >" + accounting.formatMoney(totalNet) + "</td><td class='other" + i + "' priceLvl='" + price_level + "' rank='" + rank + "' isBuyW='" + isBuy + "' isCutW='" + isCut + "' isPolishW='" + isPolish + "' cutW='" + cutWeight + "' batchNo='" + batchNo + "' polishW='" + polishWeight + "' remark='" + remark + "' gemOption='" + gemOption + "' itemImages='" + itemImagesArr + "' >" + "" + "</td><td class='rem" + i + "'><a href='#' class='remove btn btn-xs btn-danger'><i class='fa fa-remove'></i></a></td></tr>");
                clear_gem_data();

            } else {
                $.notify("Item already exists.", "warning");
                return false;
            }
        }
    });

    $("#disPercent").blur(function() {
        discount_precent = parseFloat($("#disPercent").val());
        discount_amount = parseFloat($("#disAmount").val());
        discount = $("input[name='discount']:checked").val();
        discount_type = $("input[name='discount_type']:checked").val();
        var total_amount3 = $("#totalWithOutDiscount").val();

        if (discount_type == 2) {
            calculateTotalItemWiseDiscount(discount, discount_type, discount_precent, discount_amount, total_amount3);

        }
        cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount, totalDwnPayment);

    });

    $("#disAmount").blur(function() {
        discount_precent = parseFloat($("#disPercent").val());
        discount_amount = parseFloat($("#disAmount").val());
        discount = $("input[name='discount']:checked").val();
        discount_type = $("input[name='discount_type']:checked").val();
        var total_amount3 = $("#totalWithOutDiscount").val();
        if (discount_type == 2) {
            calculateTotalItemWiseDiscount(discount, discount_type, discount_precent, discount_amount, total_amount3);
        }
        cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount, totalDwnPayment);

    });

    //remove row from grid subtraction total amount and discount--------------------------------------------------------------------------
    $("#tbl_item").on('click', '.remove', function() {
        var rid = $(this).parent().parent().attr('ri');

        var r = confirm('Do you want to remove row no ' + rid + ' ?');
        if (r === true) {

            var totalNets = parseFloat(($("#" + rid + " .totalNet" + rid).attr("nonDisTotalNet")));
            var proDiscount = parseFloat(($("#" + rid + " .totalNet" + rid).attr("proDiscount")));

            total_amount -= totalNets;
            total_amount2 -= totalNets;
            total_discount -= proDiscount;

            $("#totalWithOutDiscount").val(total_amount2);
            $("#totalAmount").html(accounting.formatMoney(total_amount2));

            cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount, totalDwnPayment);
            //remove product code from array
            var removeItem = $(".product_code" + rid).attr("proCode");

            itemcode = jQuery.grep(itemcode, function(value) {
                return value != removeItem;
            });

            $(this).parent().parent().remove();
            return false;
        }
        else {
            return false;
        }
    });

    if (chequeAmount > 0) {
        $("#chequeData").show();
    } else {
        $("#chequeData").hide();
    }

    $("#cashAmount").blur(function() {
        cashAmount = parseFloat($(this).val());
        cashAmount = '' ? 0 : cashAmount;
        returnPayment = parseFloat($("#returnPayment").val());
        dueAmount = cashAmount + returnPayment - totalNetAmount;

        if (chequeAmount > 0) {
            chequeAmount = parseFloat($("#chequeAmount").val());
            dueAmount = cashAmount + chequeAmount + returnPayment - totalNetAmount;
            $("#chequeAmount").val(chequeAmount);
            $("#chequeData").show();
        } else {
            $("#chequeData").hide();
        }

        dueAmount = dueAmount.toFixed(2);
        creditAmount = Math.abs(dueAmount);
        if (dueAmount >= 0) {
            $("#dueAmountLable").html("Change Amount  ");
            $("#dueAmountLable").css({"color": "green", "font-size": "100%"});
            $("#dueAmount").css({"color": "green", "font-size": "100%"});
            $("#dueAmountLable2").html("Change Amount  ");
            $("#dueAmountLable2").css({"color": "green", "font-size": "100%"});
            $("#dueAmount2").css({"color": "green", "font-size": "100%"});
            $("#creditAmount").val(0);
        } else if (dueAmount < 0) {
            $("#dueAmountLable").html("Credit Amount  ");
            $("#dueAmountLable").css({"color": "red", "font-size": "100%"});
            $("#dueAmount").css({"color": "red", "font-size": "100%"});
            $("#dueAmountLable2").html("Credit Amount  ");
            $("#dueAmountLable2").css({"color": "red", "font-size": "100%"});
            $("#dueAmount2").css({"color": "red", "font-size": "100%"});
            $("#creditAmount").val(creditAmount);
        }
        $("#dueAmount").html(dueAmount);
        $("#dueAmount2").html(dueAmount);
    });

//----------cheque amount----------------------------------------------------------------
    $("#chequeAmount").blur(function() {
        chequeAmount = parseFloat($(this).val());
        cashAmount = parseFloat($('#cashAmount').val());
        returnPayment = parseFloat($("#returnPayment").val());
        chequeAmount = '' ? 0 : chequeAmount;
        dueAmount = cashAmount + chequeAmount + returnPayment - totalNetAmount;
        dueAmount = dueAmount.toFixed(2);

        if (chequeAmount > 0) {
            $("#chequeData").show();
        } else {
            $("#chequeData").hide();
        }

        creditAmount = Math.abs(dueAmount);
        if (dueAmount >= 0) {
            $("#dueAmountLable").html("Change Amount  ");
            $("#dueAmountLable").css({"color": "green", "font-size": "100%"});
            $("#dueAmount").css({"color": "green", "font-size": "100%"});
            $("#dueAmountLable2").html("Change Amount ");
            $("#dueAmountLable2").css({"color": "green", "font-size": "100%"});
            $("#dueAmount2").css({"color": "green", "font-size": "100%"});
            $("#creditAmount").val(0);
        } else if (dueAmount < 0) {
            $("#dueAmountLable").html("Credit Amount  ");
            $("#dueAmountLable").css({"color": "red", "font-size": "100%"});
            $("#dueAmount").css({"color": "red", "font-size": "100%"});
            $("#dueAmountLable2").html("Credit Amount  ");
            $("#dueAmountLable2").css({"color": "red", "font-size": "100%"});
            $("#dueAmount2").css({"color": "red", "font-size": "100%"});
            $("#creditAmount").val(creditAmount);
        }
        $("#dueAmount").html(dueAmount);
        $("#dueAmount2").html(dueAmount);
    });

//------------return Amount-------------------------------------------------------------
    $("#returnAmount").blur(function() {
        returnAmount = parseFloat($(this).val());
        $("#returnPayment").val(returnAmount);
    });

    $("#returnInvoice").focus(function() {
        if (cusCode == '' || cusCode == '0') {
            alert('Please select a customer.');
            return false;
        }
        $("#returnPayment").val(0);
    });

    $("#refundAmount").blur(function() {
        refundAmount = parseFloat($(this).val());
        returnAmount = parseFloat($("#returnAmount").val());

        if (refundAmount > returnAmount) {
            alert("Refund amount can not be greater than return amount");
            $("#refundAmount").val(0);
            return false;
        }
        returnAmount -= refundAmount;
        $("#returnPayment").val(returnAmount);
    });

    $("#returnPayment").blur(function() {
        var returnPayment2 = parseFloat($(this).val());
        returnAmount = parseFloat($("#returnAmount").val());

        if (returnPayment2 > returnAmount) {
            alert("Return payment can not be greater than return amount");
            return false;
        } else {

        }

    });

    $("#lotPrice").blur(function() {
        lotPrice = parseFloat($(this).val());
        if ($("input[name='isLot']:checked").val() == 1) {
            $("#lotPriceLable").show();
            total_amount = lotPrice;
            $("#totalAmount").html(accounting.formatMoney(total_amount));

        } else {
            $("#lotPriceLable").hide();
            total_amount = total_amount2;
            $("#totalAmount").html(accounting.formatMoney(total_amount));
        }

        cal_total(total_amount, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount, totalDwnPayment);
    });

    $("#downPayment").blur(function() {
        downPayment = parseFloat($(this).val());

        cal_total(total_amount, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount, totalDwnPayment);
    });

    $("input[name='isLot']").on('ifChanged', function() {

        if ($("input[name='isLot']:checked").val() == 1) {
            $("#lotPriceLable").show();
            $("#lbl_lotNo").show();
            $("#lbl_refCode").hide();
            $("#productLable").hide();
            $('#payView').hide();
            $("#lotPriceLable").show();
            $('#easyPay').iCheck('check');

            $.ajax({
                type: "post",
                url: "../easyPayment/getTermInterest",
                data: {itemType: 2},
                success: function(data) {
                    try {
                        var resultData = JSON.parse(data);
                        $("#noOfIntTerm").html('');
                        $("#noOfIntTerm").append("<option value='0'>-Select a term-</option>");
                        $.each(resultData, function(key, value) {
                            var charge_type = value.IntTerm;
                            $("#noOfIntTerm").append("<option value=" + value.IntId + ">" + charge_type + "</option>");
                        });
                    }catch (e) {

                    }

                }
            });

        } else {
            $("#productLable").show();
            $("#lotPriceLable").hide();
            $("#lbl_lotNo").hide();
            $("#lbl_refCode").show();
            $("#totalNet").prop("disabled", false);
            $('#normalPay').iCheck('check');
            $('#payView').show();

            $.ajax({
                type: "post",
                url: "../easyPayment/getTermInterest",
                data: {itemType: 1},
                success: function(data) {
                    var resultData = JSON.parse(data);
                    $("#noOfIntTerm").html('');
                    $("#noOfIntTerm").append("<option value='0'>-Select a term-</option>");
                    $.each(resultData, function(key, value) {
                        var charge_type = value.IntTerm;
                        $("#noOfIntTerm").append("<option value=" + value.IntId + ">" + charge_type + "</option>");
                    });
                }
            });
        }
    });

    $("#setTable").click(function() {
        setProductTable();
        $('#payView').show();
        $("#t1").attr("class", "");
        $("#t2").attr("class", "active");
        if ($("input[name='payType']:checked").val() == 1) {
            $('#costTable').show();
        } else {
            $('#paymentTable').hide();
        }
    });

    $("#backItems").click(function() {
        $("#t2").attr("class", "");
        $("#t1").attr("class", "active");
        setProductTable();

//        $('#itemTable').show();
//        $('#costTable').hide();
//        $('#paymentTable').hide();
//        $('#payView').hide();
    });

    $("#next3").click(function() {
        $("#t2").attr("class", "");
        $("#t3").attr("class", "active");
        setProductTable();
    });

    $("#next4").click(function() {
        $("#t3").attr("class", "");
        $("#t4").attr("class", "active");
        setProductTable();
    });

    $("#next5").click(function() {
        $("#t4").attr("class", "");
        $("#t5").attr("class", "active");
        setProductTable();
    });

    $("#back3").click(function() {
        $("#t4").attr("class", "");
        $("#t3").attr("class", "active");
        setProductTable();
    });

    $("#back2").click(function() {
        $("#t3").attr("class", "");
        $("#t2").attr("class", "active");
        setProductTable();
    });

    $("#back4").click(function() {
        $("#t5").attr("class", "");
        $("#t4").attr("class", "active");
        setProductTable();
    });


//--------------------------------------------------------------------------
    $("#saveItems").click(function() {

        var rowCount = $('#tbl_item tr').length;
        var product_code = new Array();
        var item_code = new Array();
        var serial_no = new Array();
        var qty = new Array();
        var unit_price = new Array();
        var discount_precent = new Array();
        var pro_discount = new Array();
        var discount_val = new Array();
        var total_net = new Array();
        var batch_no = new Array();
        var price_level = new Array();
        var guess_amount = new Array();
        var carat_weight = new Array();
        var rank = new Array();
        var cut_weight = new Array();
        var is_cut = new Array();
        var is_polish = new Array();
        var is_buy = new Array();
        var polish_weight = new Array();
        var sold_amount = new Array();
        var item_images = new Array();
        var gem_options = [];
        var extra_date = new Array();
        var extra_desc = new Array();
        var extra_amount = new Array();
        var expensRowCount = $('#table_expenses tr').length;

        //down payments

        var dwn_paymentAr = new Array();
        var dwn_pay_interestAr = new Array();
        var dwn_pay_int_rateAr = new Array();
        var dwn_pay_dateAr = new Array();
        var dwn_is_intAr = new Array();


        var isLot = $("input[name='isLot']:checked").val();

        var invDate = $("#invDate").val();
        var location =$("#location").val();
        lotPrice = $("#lotPrice").val();
        var invUser = $("#invUser").val();
        var chequeNo = $("#chequeNo").val();
        var chequeReference = $("#chequeReference").val();
        var chequeRecivedDate = $("#chequeReciveDate").val();
        var chequeDate = $("#chequeDate").val();
        var cash_amount = parseFloat($("#cashAmount").val());
        var cheque_amount = parseFloat($("#chequeAmount").val());
        var credit_amount = parseFloat($("#creditAmount").val());
        var return_amount = parseFloat($("#returnPayment").val());
        var refund_amount = parseFloat($("#refundAmount").val());

        var totalItemPercent = parseFloat($("#disPercent").val());

        var dwn_payment = parseFloat(accounting.unformat($("#downPayment").val()));
        var int_term = parseFloat(accounting.unformat($("#noOfIntTerm option:selected").html()));
        var int_term_interest = parseFloat(accounting.unformat($("#termInterst").html()));
        var int_term_rate = parseFloat(accounting.unformat($("#term_interest_rate").val()));
        var is_int_term = parseFloat(($("#isTermInterest:checked").val()));

        var qur_payment = parseFloat(accounting.unformat($("#quartPayment").val()));
        var qur_pay_interest = parseFloat(accounting.unformat($("#quartInterest").html()));
        var qur_pay_int_rate = parseFloat(accounting.unformat($("#quart_interest_rate").val()));
        var qur_pay_date = $("#quartPayDate").val();
        var qur_is_int = parseFloat($("#isQuartInterest:checked").val());

        var monthAr = $("#monthAr").val();
        var monPayAr = $("#monPayAr").val();
        var pricAr = $("#pricAr").val();
        var intAr = $("#intAr").val();
        var balAr = $("#balAr").val();
        var mothly_payment_date = $("#mothly_payment_date").val();
        var instalPymentTypes = $("#instalmentTypes").val();

        customer_payment = cash_amount + cheque_amount + credit_amount + return_amount;

        for (var c = 1; c <= expensRowCount - 2; c++) {
            extra_date.push($("#exr" + c + " .expenses_nameEx" + c).attr("expenseType"));  //Extra amount date
            extra_desc.push(($("#exr" + c + " .expenses_name" + c).html()));
            extra_amount.push(accounting.unformat($("#exr" + c + " .expense_amountEx" + c).html()));   //Extra amount
        }

        for (var d = 1; d <= div_index.length; d++) {
            dwn_paymentAr.push(accounting.unformat($("#downPayment" + d).val()));  //Extra amount date
            dwn_pay_interestAr.push(accounting.unformat($("#interest" + d).html()));
            dwn_pay_int_rateAr.push(accounting.unformat($("#interest_rate" + d).val()));   //Extra amount
            dwn_pay_dateAr.push($("#downPayDate" + d).val());   //Extra amount
            dwn_is_intAr.push(accounting.unformat($("input[name='isInterest" + d + "']:checked").val()));   //Extra amount
        }

        for (var i = 1; i <= rowCount - 1; i++) {
            product_code.push($("#" + i + " .product_code" + i).attr("proCode"));
            serial_no.push($("#" + i + " .serial_no" + i).html());
            qty.push(accounting.unformat($("#" + i + " .qty" + i).html()));
            unit_price.push(accounting.unformat($("#" + i + " .unit_price" + i).html()));
            discount_precent.push(accounting.unformat($("#" + i + " .discount_percent" + i).html()));
            pro_discount.push($("#" + i + " .totalNet" + i).attr("proDiscount"));
            total_net.push(accounting.unformat($("#" + i + " .totalNet" + i).html()));
            price_level.push($("#" + i + " .other" + i).attr("priceLvl"));   //pushing all the free_qty listed in the table
            guess_amount.push(accounting.unformat($("#" + i + " .totalNet" + i).attr("nonDisTotalNet")));   //pushing all the DiscountPresent listed in the table
            carat_weight.push($("#" + i + " .carat_weight" + i).html());   //pushing all the total_net_amount listed in the table
            rank.push($("#" + i + " .other" + i).attr("rank"));   //pushing all the total_net_amount listed in the table
            cut_weight.push($("#" + i + " .other" + i).attr("cutW"));   //pushing all the total_net_amount listed in the table
            is_cut.push($("#" + i + " .other" + i).attr("isCutW"));   //pushing all the total_net_amount listed in the table
            is_polish.push($("#" + i + " .other" + i).attr("isPolishW"));   //pushing all the total_net_amount listed in the table
            batch_no.push($("#" + i + " .other" + i).attr("batchNo"));   //pushing all the total_net_amount listed in the table
            is_buy.push($("#" + i + " .other" + i).attr("isBuyW"));   //pushing all the total_net_amount listed in the table
            polish_weight.push($("#" + i + " .other" + i).attr("polishW"));   //pushing all the total_net_amount listed in the table
            sold_amount.push(accounting.unformat($("#" + i + " .sold_amount" + i).html()));   //pushing all the total_net_amount listed in the table
            gem_options.push({
                sellingPrice: $("#" + i + " .product_code" + i).html(),
                itemCode: $("#" + i + " .item_code" + i).html(),
                gemOptions: $("#" + i + " .other" + i).attr("gemOption")
            });

            item_images.push({
                sellingPrice: $("#" + i + " .product_code" + i).html(),
                itemCode: $("#" + i + " .item_code" + i).html(),
                itemImages: $("#" + i + " .other" + i).attr("itemImages")
            });
        }

        var discount_types = $("input[name='discount_type']:checked").val();

        var sendProduct_code = JSON.stringify(product_code);
        var sendItem_code = JSON.stringify(item_code);
        var sendSerial_no = JSON.stringify(serial_no);
        var sendQty = JSON.stringify(qty);
        var sendUnit_price = JSON.stringify(unit_price);
        var sendDiscount_precent = JSON.stringify(discount_precent);
        var sendPro_discount = JSON.stringify(pro_discount);
        var sendTotal_net = JSON.stringify(total_net);
        var sendBatchNo = JSON.stringify(batch_no);
        var sendPrice_level = JSON.stringify(price_level);
        var sendGuess_amount = JSON.stringify(guess_amount);
        var sendCarat_weight = JSON.stringify(carat_weight);
        var sendRank = JSON.stringify(rank);
        var sendCut_weight = JSON.stringify(cut_weight);
        var sendIs_cut = JSON.stringify(is_cut);
        var sendIs_polish = JSON.stringify(is_polish);
        var sendIs_buy = JSON.stringify(is_buy);
        var sendPolish_weight = JSON.stringify(polish_weight);
        var sendSold_amount = JSON.stringify(sold_amount);
        var sendItem_images = JSON.stringify(item_images);
        var sendGem_options = JSON.stringify(gem_options);
        var sendExtra_date = JSON.stringify(extra_date);
        var sendExtra_amount = JSON.stringify(extra_amount);
        var sendExtra_desc = JSON.stringify(extra_desc);

        var sendDwn_paymentAr = JSON.stringify(dwn_paymentAr);
        var sendDwn_pay_interestAr = JSON.stringify(dwn_pay_interestAr);
        var sendDwn_pay_int_rateAr = JSON.stringify(dwn_pay_int_rateAr);
        var sendDwn_pay_dateAr = JSON.stringify(dwn_pay_dateAr);
        var sendDwn_is_intAr = JSON.stringify(dwn_is_intAr);

        if ((acc_no=='' && cusCode=='') || (acc_no==0 && cusCode==0)) {
            $.notify("Please select an account number.", "warning");
            return false;
        } else if (int_term == '' || int_term == '0'){
            $.notify("Please select a No of Term.", "warning");
            return false;
        } else if (instalPymentTypes == '' || instalPymentTypes == '0'){
            $.notify("Please select a Installment Type.", "warning");
            return false;
        } else if (cusCode == '' || cusCode == '0') {
            $.notify("Please select a customer.", "warning");
            return false;
        } else if (((rowCount - 1) == '0' || (rowCount - 1) == '') && (isLot == 0)) {
            $.notify("Please add items.", "warning");
            return false;
        } else {
//            return false;
        $.ajax({
            type: "post",
            url: "../easyPayment/saveInvoice",
            data: {acc_no: acc_no, accType: accType, accCategory: accCategory, product_code: sendProduct_code, serial_no: sendSerial_no, qty: sendQty, unit_price: sendUnit_price, discount_precent: sendDiscount_precent, pro_discount: sendPro_discount, total_net: sendTotal_net, batch_no: sendBatchNo, price_level: sendPrice_level, totalNetWODis: sendGuess_amount, sold_amount: sendSold_amount, item_images: sendItem_images, gem_option: sendGem_options, isLot: isLot, invNo: invNo, extra_date: sendExtra_date, extra_desc: sendExtra_desc, extra_amount: sendExtra_amount, cusCode: cusCode, dwn_payment: dwn_payment,
                dwn_paymentAr: sendDwn_paymentAr, dwn_pay_interestAr: sendDwn_pay_interestAr, dwn_pay_int_rateAr: sendDwn_pay_int_rateAr, dwn_pay_dateAr: sendDwn_pay_dateAr, dwn_is_intAr: sendDwn_is_intAr, qur_payment: qur_payment, qur_pay_interest: qur_pay_interest, qur_pay_int_rate: qur_pay_int_rate, qur_pay_date: qur_pay_date, qur_is_int: qur_is_int, invDate: invDate, lotPrice: lotPrice, total_extra: total_expenses, invUser: invUser, chequeNo: chequeNo, chequeReference: chequeReference, chequeRecivedDate: chequeRecivedDate, chequeDate: chequeDate, cash_amount: cash_amount, cheque_amount: cheque_amount, credit_amount: credit_amount, total_amount: total_amount, return_amount: return_amount, refund_amount: refund_amount,
                tot_extra_chrages: totalExtraChrages, tot_extra_amount: totalExtraAmount, total_discount: total_discount, gross_amount: totalNetAmount,final_amount: finalAmount, int_term: int_term, int_term_interest: int_term_interest, int_term_rate: int_term_rate, is_int_term: is_int_term, monthAr: monthAr, monPayAr: monPayAr, pricAr: pricAr, intAr: intAr, balAr: balAr, instalPymentTypes: instalPymentTypes, discount_type:discount_types,total_dis_percent:totalItemPercent,mothly_payment_date:mothly_payment_date,location:location},
            success: function(data) {
                var resultData = JSON.parse(data);
                var feedback = resultData['fb'];
                if (feedback != 1){
                    $.notify("Invoice not saved successfully.", "warning");
                    return false;
                } else {
                    $.notify("Invoice saved successfully.", "success");
                    document.getElementById("saveItems").disabled = true;
                    window.location.reload();
                }
            }
        });

        }
    });

    var p = 0;
    //add expenses
    var expensesArr = [];
    var total_expenses = 0;
    $("#addExpenses").click(function() {

        var expensesType = $("#expenses_date").val();
        var expensesName = $("#expenses").val();
        var expenseAmount = parseFloat($("#expenses_amount").val());


        if (expenseAmount == '' || expenseAmount == 0) {
            $.notify("Please enter extra amount.", "warning");
            return false;
        }else if (expensesName == '' || expensesName == 0) {
            $.notify("Please enter extra amount description.", "warning");
            return false;
        } else {
            p++;
            total_expenses = parseFloat(total_expenses) + parseFloat(expenseAmount);
            totalExtraAmount = total_expenses;
            cal_total(total_amount, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount, totalDwnPayment);
            $("#table_expenses tbody").append("<tr rid=" + p + " id='exr" + p + "'><td>" + p + "</td><td class='expenses_nameEx" + p + "' expenseType='" + expensesType + "'>" + expensesType + "</td><td class='expenses_name" + p + "' >" + expensesName + "</td><td class='expense_amountEx" + p + " pull-right'>" + accounting.formatMoney(expenseAmount) + "</td><td class='expense_rem" + p + "'><a href='#' class='expense_remove btn btn-xs btn-danger'><i class='fa fa-remove'></i></a></td></tr>");

            $("#totalExpenses").html(accounting.formatMoney(total_expenses));
            $("#expenses_amount").val(0);
            $("#expenses").val('');
        }
    });

    //remove row from grid subtraction total amount and discount
    $("#table_expenses").on('click', '.expense_remove', function() {
        var rid = $(this).parent().parent().attr('rid');

        var r = confirm('Do you want to remove row no ' + rid + ' ?');
        if (r === true) {
            total_expenses = parseFloat(total_expenses) - parseFloat(accounting.unformat($(".expense_amountEx" + rid).html()));
            $("#totalExpenses").html(accounting.formatMoney(total_expenses));
            totalExtraAmount = total_expenses;
            cal_total(total_amount, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount, totalDwnPayment);
            //remove product code from array
            var removeItem = $(".expenses_nameEx" + rid).attr("expenseType");

            expensesArr = jQuery.grep(expensesArr, function(value) {
                return value != removeItem;
            });

            $(this).parent().parent().remove();
            return false;
        }
        else {
            return false;
        }
    });

    $("input[name='isBuy']").click(function() {
        if ($("input[name='isBuy']").prop('checked') == true) {
            $("#lbl_buyAmount").show();
        } else {
            $("#lbl_buyAmount").hide();
        }
    });

    //check is buy
    $("input[name='payType']").click(function() {
        if ($("input[name='payType']").prop('checked') == true) {

//            $("#lbl_cutWeight").show();
        } else {
//            $("#lbl_cutWeight").hide();
        }
    });

    $("input[name='payType']").on('ifChanged', function() {
            var check = ($(this).val());
         if (check == 1) {
            $('#paymentTable').hide();
            $('#costTable').show();
            $('#payView').show();
            $('#dwPaymentTbl').hide();
            $('#payment_schedule').hide();

            if(acc_no=='' || acc_no==0){

            $("#cusName").prop('disabled',true);
            }else{
                $("#cusName").prop('disabled',true);
            }

//            $("#lbl_cutWeight").show();
        } else if(check == 2) {

            $('#paymentTable').show();
            $('#costTable').hide();
            $('#payView').show();
            $('#dwPaymentTbl').show();
            $('#payment_schedule').show();
            if(acc_no=='' || acc_no==0){

            $("#cusName").prop('disabled',true);
            }else{
                $("#cusName").prop('disabled',true);
            }
//            $("#lbl_cutWeight").hide();
        }
    });

    //check is buy
    $("input[name='isPolish']").click(function() {
        if ($("input[name='isPolish']").prop('checked') == true) {
            $("#lbl_polishWeight").show();
        } else {
            $("#lbl_polishWeight").hide();
        }
    });

    //down payments
    var b = 0;
    var num = '';
    var payDate = '';
    var isInrest = 0;
    var interest = 0;
    var dwPayment = 0;

    $("#add_dp" + b).click(function() {
        b++;
        switch (b) {
            case 0:
                num = "";
                break;
            case 1:
                num = "1st ";
                break;
            case 2:
                num = "2nd ";
                break;
            case 3:
                num = "3rd ";
                break;
            case 4:
                num = "4th ";
                break;
            case 5:
                num = "5th ";
                break;
            case 6:
                num = "6th ";
                break;
            case 7:
                num = "7th ";
                break;
            case 8:
                num = "8th ";
                break;
            case 9:
                num = "9th ";
                break;
            case 10:
                num = "10th ";
                break;
        }
        var clone2 = "<tr>\n\
            <td id=" + b + ">" + b + "</td>\n\
            <td><input type='checkbox' class='dp_icheck'   name='isInterestp" + b + "' id='isInterest" + b + "' value='1'></td>\n\
            <td><input type='text'  min='0'  class='form-control' required='required'  name='downPayDate" + b + "' id='downPayDate" + b + "' placeholder='Payment date'  ></td>\n\
            <td><input type='number'  min='0' step='1000' class='form-control' required='required'  name='downPayment" + b + "' id='downPayment" + b + "' placeholder='Down payment'  value='0'></td>\n\
            <td>\n\
                <input type='number'  min='0' step='1' class='form-control' required='required'  name='interest_rate" + b + "' id='interest_rate" + b + "' placeholder='Interest Rate'  value='0'></td>\n\
            <td><span  id='interest" + b + "' class='pull-right'>0.00</span></td>\n\
            <td><a href='#' class='rem_div btn btn-xs btn-danger' div_no='" + b + "' id='btn" + b + "'><i class='fa fa-remove'></i></a></td>\n\
        </tr>";
        var clone = "<div class='down_pay thumbnail' id='d" + b + "' div_no='" + b + "' data-index='" + b + "'><div class='form-group'><label for='product' class='col-sm-4 control-labe'> Payment Date <span class='required'></span></label>\n\
        <div class='col-sm-4'><input type='text'  min='0'  class='form-control' required='required'  name='downPayDate" + b + "' id='downPayDate" + b + "' placeholder='Payment date'  ></div></div>\n\
        <div class='form-group'><label for='product' class='col-sm-4 control-label'>" + num + " Down Payment <span class='required'></span></label><div class='col-sm-4'><input type='number'  min='0' step='1000' class='form-control' required='required'  name='downPayment" + b + "' id='downPayment" + b + "' placeholder='Down payment'  value='0'>\n\
        </div></div><div class='form-group'><label for='totalNet' class='col-sm-2 control-label'>Interest <span class='required'></span></label><div class='col-sm-5 input-group'><span class='input-group-addon'><input type='checkbox' class='dp_icheck'   name='isInterestp" + b + "' id='isInterest" + b + "' value='1'></span>\n\
        <input type='number'  min='0' step='1' class='form-control' required='required'  name='interest_rate" + b + "' id='interest_rate" + b + "' placeholder='Interesr rate'  value='0'><span  id='interest" + b + "' class='input-group-addon'>0.00</span></div></div><button class='rem_div btn btn-xs btn-danger' div_no='" + b + "'>Remove</button></div>";
//        $("#down_pays").append(clone);
        $("#dwPaymentTbl tbody").append(clone2);

        div_index.push(b);
        $("#interest_rate" + b).val(dwnInt);

        $('#downPayDate' + b).datepicker({
            dateFormat: 'yy-mm-dd',
            startDate: '-3d'
        });
        $('#downPayDate' + b).datepicker().datepicker("setDate", new Date());

        $('.dp_icheck').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '50%' // optional
        });
    });

    $("#isInterestp1").click(function() {
        alert();
    });
    var a = 1;
    var today = new Date();
    var div_index = [];

    $("#dwPaymentTbl").on('click', '.rem_div', function() {
        var rid = $(this).attr('div_no');
        var r = confirm('Do you want to remove this down payment ' + rid + ' ?');
        if (r === true) {
            div_index = jQuery.grep(div_index, function(value) {
                return value != rid;
            });
            $(this).parent().parent().remove();
            setDownPayments();
        }
        else {
            return false;
        }
    });

    var c = 1;
    $("#down_pays").on('click', '.down_pay', function() {
        var no = $("this").attr('data-index');
    });

    $("input[name='isInterest']").on('ifChecked', function() {
        var check = ($(this).val());

        if (check == 1) {
            $("#disAmount").val(0);
        } else if (check == 2) {
            $("#disPercent").val(0);
        }
    });

    var totalDwnPayment = 0;
    //add down payments interest
    $("#add_dp_int").click(function() {
        setDownPayments();
        total_dwn_interest = 0;
        totalDwnPayment = 0;
        $.each(div_index, function(index, value) {

            $("#downPayDate" + value).datepicker("destroy");

            payDate = $("#downPayDate" + value).val();
            isInrest = $("#isInterest" + value + ":checked").val();

            if (isInrest == 1) {
                interest = parseFloat($("#interest_rate" + value).val());
            } else {
                interest = 0;
            }
            dwPayment = parseFloat(accounting.unformat($("#downPayment" + value).val()));
            totalDwnPayment+=dwPayment;
            calDwPayMonthlyInterest(interest, payDate, dwPayment, value);
            var div_intrest = (parseFloat(accounting.unformat($("#interest" + value).html())));
            total_dwn_interest += div_intrest;

            $('#downPayDate' + value).datepicker({
                dateFormat: 'yy-mm-dd',
                startDate: '-3d'
            });
        });
        $("#totalDp").html(accounting.formatMoney(total_dwn_interest));
        cal_total(total_amount, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount, totalDwnPayment);
    });

    // add quater payment
    $("#quart_interest_rate").val(dwnInt);
    $("input[name='isQuartInterest']").on('ifChanged', function() {

        var check2 = $("input[name='isQuartInterest']:checked").val();
        var payDate = $("#quartPayDate").val();
        var rate = $("#quart_interest_rate").val();
        var dwPayment = parseFloat($("#quartPayment").val());

        if (check2 == 1) {
            calQutPayMonthlyInterest(rate, payDate, dwPayment, '');
            total_qur_interest = (parseFloat(accounting.unformat($("#quartInterest").html())));
            cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount, totalDwnPayment);
        } else {
            total_qur_interest = 0;
            $("#quartInterest").html('0.00');
            cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount, totalDwnPayment);
        }
    });

    $("#resetItems").click(function(){
        resetAll();
    });


    //================Common Functions====================//

    //calculate down payment monthly interest
    function calDwPayMonthlyInterest(intrest, date, dwPayment, no) {
        var current_date = new Date();
        var date1 = new Date(date);
        var selMon = date1.getMonth() + 1;
        var curMon = current_date.getMonth() + 1;
        var time = parseFloat(selMon - curMon);

        var A = dwPayment * (intrest / 100) * (time);

        $("#interest" + no).html(accounting.formatMoney(A));
    }

    //calculate quarter payment monthly interest
    function calQutPayMonthlyInterest(intrest, date, dwPayment, no) {
        var current_date = new Date();
        var date1 = new Date(date);
        var selMon = date1.getMonth() + 1;
        var curMon = current_date.getMonth() + 1;
        var time = parseFloat(selMon - curMon);

        var A = dwPayment * (intrest / 100) * (time);

        $("#quartInterest").html(accounting.formatMoney(A));
    }

    //calculate total summery
    function cal_total(total, discount, extra, downPay, downPayInt, qurPayInt, totalInt, totalExtra ,totalDwnPay) {

        var total_net2 = parseFloat(total) - parseFloat(discount) + parseFloat(extra) - parseFloat(downPay) + parseFloat(downPayInt) + parseFloat(qurPayInt) + parseFloat(totalExtra) - parseFloat(totalDwnPay);
        finalAmount = parseFloat(total_net2) + parseFloat(totalInt);
        $("#netAmount").html(accounting.formatMoney(total_net2));
        $("#discountAmount").html(accounting.formatMoney(discount));
        $("#totalAmount").html(accounting.formatMoney(total));
        $("#extCharges").html(accounting.formatMoney(extra));
        $("#dwnPayments").html(accounting.formatMoney(downPay));
        $("#dwnPaymentInt").html(accounting.formatMoney(downPayInt));
        $("#totalDwnPayments").html(accounting.formatMoney(totalDwnPay));
        $("#quarterPaymentInt").html(accounting.formatMoney(qurPayInt));
        $("#interestAmount").html(accounting.formatMoney(totalInt));
        $("#netAmountWithInt").html(accounting.formatMoney(finalAmount));
        $("#extraAmount").html(accounting.formatMoney(totalExtra));
        total_discount = discount;
        total_amount = total;
        total_amount2 = total;
        totalNetAmount = total_net2;
    }

    //calculate product wise discount
    function calculateProductWiseDiscount(totalNet3, discount, discount_type, disPercent, disAmount, total_amount4) {

        //product wise discount
        if (discount_type == 1) {
            if (discount == 1) {
                //discount by percent
                product_discount = totalNet3 * (disPercent / 100);
                disAmount = 0;
            }else if (discount == 2) {
                //discount by amount
                product_discount = disAmount;
                disPercent = product_discount * 100 / totalNet3;
            }
            total_item_discount = 0;
        }else if (discount_type == 2) {
            //total item wise discount
            total_discount = 0;
            product_discount = 0;
            disPercent = 0;
        }

        total_discount += product_discount;
        total_amount += totalNet3;
        totalNet = totalNet3 - parseFloat(product_discount);
        discount_precent = accounting.formatNumber(disPercent);
        totalNetAmount = total_amount - parseFloat(total_discount);
        cal_total(total_amount, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest);
        $('#discountAmount').html(accounting.formatMoney(total_discount));
    }

    //calculate total item wise discount
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
        total_discount = product_discount;
        discount_precent = 0;

        total_amount2 += parseFloat(total_amount4) - parseFloat(product_discount);
        total_amount = parseFloat(total_amount4);
        totalNetAmount = total_amount - parseFloat(total_discount);

        cal_total(total_amount, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest);

        $('#discountAmount').html(accounting.formatMoney(total_discount));
        $('#netAmount').html(accounting.formatMoney(totalNetAmount));
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

    function setExpensesTable() {
        $('#table_expenses tbody tr').each(function(rowIndex2, element) {
            var row2 = rowIndex2 + 1;
            $(this).find("[class]").eq(0).parent().attr("rid", row2);
            $(this).find("[class]").eq(0).parent().attr("id", "exr" + row2);
            $(this).find("[class]").eq(0).attr("class", 'expenses_nameEx' + row2);
            $(this).find("[class]").eq(1).attr("class", 'expense_name' + row2);
            $(this).find("[class]").eq(2).attr("class", 'expense_amountEx' + row2);
            $(this).find("[class]").eq(3).attr("class", 'expense_rem' + row2);
        });
    }

    function setProductTable() {
        $('#tbl_item tbody tr').each(function(rowIndex, element) {
            var row = rowIndex + 1;
            $(this).find("[class]").eq(0).parent().attr("ri", row);
            $(this).find("[class]").eq(0).parent().attr("id", row);
            $(this).find("[class]").eq(0).attr("class", 'product_code' + row);
            $(this).find("[class]").eq(1).attr("class", 'serial_no' + row);
            $(this).find("[class]").eq(2).attr("class", 'qty' + row);
            $(this).find("[class]").eq(3).attr("class", 'unit_price' + row);
            $(this).find("[class]").eq(4).attr("class", 'discount_percent' + row);
            $(this).find("[class]").eq(5).attr("class", 'totalNet' + row);
            $(this).find("[class]").eq(6).attr("class", 'other' + row);
            $(this).find("[class]").eq(7).attr("class", 'rem' + row);
        });
    }

    function setDownPayments() {
        div_index.length = 0;
        $('#dwPaymentTbl tbody tr').each(function(rowIndex, element) {

            var row = rowIndex + 1;

            div_index.push(row);

            $("#downPayDate" + row).datepicker("destroy");

            $(this).find("[id]").eq(0).parent().parent().attr("id", "d".row);
            $(this).find("[id]").eq(0).html(row);
            $(this).find("[id]").eq(0).attr("id", row);
            $(this).find("[id]").eq(1).attr("id", 'isInterest' + row);
            $(this).find("[id]").eq(1).attr("name", 'isInterest' + row);
            $(this).find("[id]").eq(2).attr("id", 'downPayDate' + row);
            $(this).find("[id]").eq(2).attr("name", 'downPayDate' + row);
            $(this).find("[id]").eq(3).attr("id", 'downPayment' + row);
            $(this).find("[id]").eq(3).attr("name", 'downPayment' + row);
            $(this).find("[id]").eq(4).attr("id", 'interest_rate' + row);
            $(this).find("[id]").eq(4).attr("name", 'interest_rate' + row);
            $(this).find("[id]").eq(5).attr("id", 'interest' + row);
            $(this).find("[id]").eq(6).attr("div_no", row);
            $(this).find("[id]").eq(6).attr("id", "btn" + row);

            $('#downPayDate' + row).datepicker({
                dateFormat: 'yy-mm-dd',
                startDate: '-3d'
            });
        });
    }

    function getLastBatchNo() {
        //get last batch no max int
        var batch_input = parseFloat(invNo.substr(BNcodeLength, BNtotalLength));

        //add int to string
        invNo = strPad(batch_input + 1, BNcodeLength, BNCode, BNString);

        $("#invNo").val(invNo);
        $("#lbl_batch_no").html("Invoice No - " + invNo);
    }

    //set as noraml payment method
    function setNormalPayment() {
        $("#productLable").show();
        $("#lotPriceLable").hide();
        $("#lbl_lotNo").hide();
        $("#lbl_refCode").show();
        $("#totalNet").prop("disabled", false);
//            $("#normalPay").prop("checked", true);
        $('#normalPay').iCheck('check');
        $("#panel_down_payments").hide();
        $("#panel_quarter").hide();
    }

    //set as easy payment method
    function setEasyPayment() {
        $("#productLable").show();
        $("#lotPriceLable").hide();
        $("#lbl_lotNo").hide();
        $("#lbl_refCode").show();
        $("#totalNet").prop("disabled", false);
        $('#notLot').iCheck('check');
        $('#easyPay').iCheck('check');
        $("#panel_down_payments").show();
//        $("#panel_quarter").show();
    }

    //set as loan payment method
    function setLoanPayment() {
        $("#lotPriceLable").show();
        $("#lbl_lotNo").show();
        $("#lbl_refCode").hide();
        $("#productLable").hide();
        $("#lotPriceLable").show();
        $('#isLot').iCheck('check');
        $('#easyPay').iCheck('check');
        $("#loanType").val(accCategory);
        $("#lotPrice").focus();
        $("#panel_down_payments").hide();
        $("#panel_quarter").hide();
    }

    function clear_gem_data() {
        $("#sellingPrice").val('');
        $("#itemCode").val('');
        $("#batchCode").val('');
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
        $("#serialNo").val('');
         $("#productName").html('');

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
        product_discount =0;

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
    function resetAll(){
         item_ref = 0;
        itemImagesArr.length = 0;
        gemOption.length = 0;
        cusCode = 0;
        invNo = 0;
        batchNo = 0;
        cusType = 1;
        customer_payment = 0;
        accType = 0;
        accCategory = 0;
        totalExtraChrages = 0;
        downPayment = 0;
        totalIterest = 0;
        finalAmount = 0;
        Interest = 0;
        totalExtraAmount = 0;
        ICtotalLength;
        ICstringLength;
        ICcodeLength;
        ICString;
        ICCode;

        BNtotalLength;
        BNstringLength;
        BNcodeLength;
        BNString;
        BNCode;
        accType2 = 1;
        return_amount = 0;
        itemCode = '';

        i = 0;
        itemcode.length = 0;
        isBuy = 0;
        isCut = 0;
        isPolish = 0;
        total_amount = 0;
        total_amount2 = 0;
        cashAmount = 0;
        chequeAmount = 0;
        creditAmount = 0;
        dueAmount = 0;
        lotPrice = 0;
        returnAmount = 0;
        refundAmount = 0;
        returnPayment = 0;

        discount_precent = 0;
        discount_amount = 0;
        product_discount = 0;
        totalNet2 = 0;
        totalNet = 0;
        totalNetAmount = 0;
        total_discount = 0;
        total_item_discount = 0;
        discount = 0;
        discount_type = 0;
        total_dwn_interest = 0;
        total_qur_interest = 0;

        //down payments
        b = 0;
        num = '';
        payDate = '';
        isInrest = 0;
        interest = 0;
        dwPayment = 0;

        a = 1;
        div_index.length = 0;

        $("#exChargesTbl tbody").html('');
        $("#tbl_payment_schedule tbody").html('');
        $("#tbl_item tbody").html('');
        $("#table_expenses tbody").html('');

        $("#totalAmount").html('0.00');
        $("#discountAmount").html('0.00');
        $("#dwnPayments").html('0.00');
        $("#extCharges").html('0.00');
        $("#dwnPaymentInt").html('0.00');
        $("#quarterPaymentInt").html('0.00');
        $("#extraAmount").html('0.00');
        $("#netAmount").html('0.00');
        $("#interestAmount").html('0.00');
        $("#netAmountWithInt").html('0.00');
        $("#dueAmount2").html('0.00');
        $("#return_amount").html('0.00');
        $("#refund_amount").html('0.00');

    }
    function clearAll() {
        item_ref = 0;
        itemImagesArr.length = 0;
        gemOption.length = 0;
        cusCode = 0;
        invNo = 0;
        batchNo = 0;
        cusType = 1;
        customer_payment = 0;
        accType = 0;
        accCategory = 0;
        totalExtraChrages = 0;
        downPayment = 0;
        totalIterest = 0;
        finalAmount = 0;
        Interest = 0;
        totalExtraAmount = 0;
        ICtotalLength;
        ICstringLength;
        ICcodeLength;
        ICString;
        ICCode;

        BNtotalLength;
        BNstringLength;
        BNcodeLength;
        BNString;
        BNCode;
        accType2 = 1;
        return_amount = 0;
        itemCode = '';

        i = 0;
        itemcode.length = 0;
        isBuy = 0;
        isCut = 0;
        isPolish = 0;
        total_amount = 0;
        total_amount2 = 0;
        cashAmount = 0;
        chequeAmount = 0;
        creditAmount = 0;
        dueAmount = 0;
        lotPrice = 0;
        returnAmount = 0;
        refundAmount = 0;
        returnPayment = 0;

        discount_precent = 0;
        discount_amount = 0;
        product_discount = 0;
        totalNet2 = 0;
        totalNet = 0;
        totalNetAmount = 0;
        total_discount = 0;
        total_item_discount = 0;
        discount = 0;
        discount_type = 0;
        total_dwn_interest = 0;
        total_qur_interest = 0;

        //down payments
        b = 0;
        num = '';
        payDate = '';
        isInrest = 0;
        interest = 0;
        dwPayment = 0;

        a = 1;
        div_index.length = 0;

//        $("#exChargesTbl tbody").html('');
        $("#tbl_payment_schedule tbody").html('');
        $("#tbl_item tbody").html('');

    }
});

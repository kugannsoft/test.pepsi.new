
$(document).ready(function() {
    var supcode;
    var loc = $("#location").val();
    var location_from = 0;
    var location_to = 0;
    var location = 0;
    $("#errData").hide();
    $('#grnDate,#deliverydate,#chequeReciveDate,#expenses_date,#quartPayDate,#chequeDate,#downPayDate1,#downPayDate2,#downPayDate3,#downPayDate4,#downPayDate5,#downPayDate6').datepicker({
        dateFormat: 'yy-mm-dd',
        startDate: '-3d'
    });

    $('#grnDate,#chequeReciveDate,#expenses_date,#quartPayDate,#downPayDate1,#downPayDate2,#downPayDate3,#downPayDate4,#downPayDate5,#downPayDate6').datepicker().datepicker("setDate", new Date());
    //location disable
    $("#location_to option").each(function() {
        if ($(this).val() == loc) {
            $(this).attr('disabled', true);
        }
    });

    $("#location_from").change(function() {
        var selval = $(this).val();
        $("#location_to option").each(function() {
            $(this).attr('disabled', false);
            if ($(this).val() == selval) {
                $(this).attr('disabled', true);
                if ($("#location_to option:Selected").val() == selval) {
                    $("#location_to").val('');
                }
            }
        });
    });

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

    var paymentId = 0;
    var paymentNo = 0;
    var invNo = 0;
    var cusCode = 0;
    var ItemCodeArr = [];
    var TotalAmount = 0;
    var TotalNetAmount = 0;
    var proDiscount = 0;
    location_from = $("#location_from option:selected").val();
    location_to = $("#location_to option:selected").val();

    $("#location_from").change(function() {
        paymentNo = 0;
        location_from = $("#location_from option:selected").val();
        $("#tbl_payment tbody").html("");
        $("#invoice").val('');
    });

    $("#location_to").change(function() {
        paymentNo = 0;
        location_to = $("#location_to option:selected").val();
        $("#tbl_payment tbody").html("");
        $("#invoice").val('');
    });

    $("#invoice").focus(function() {
        if (location_from == 0 || location_from == '') {
           $("#errData").show();
            $('html, body').animate({scrollTop: $('#pay').offset().top}, 'slow');
            $("#errData").html('Select a from location.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
            return false;
        } else if (location_to == 0 || location_to == '') {
            $("#errData").show();
            $('html, body').animate({scrollTop: $('#pay').offset().top}, 'slow');
            $("#errData").html('Select a from location.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
            return false;
        } else {
            $("#invoice").autocomplete({
                source: function(request, response) {

                    $.ajax({
                        url: 'getActiveSTOut',
                        dataType: "json",
                        data: {
                            name_startsWith: request.term, location_from: location_from, location_to: location_to
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
                    paymentId = (ui.item.value);
                    $("#cusCode").html();
//                        invNo = 0;
                    $("#tbl_payment tbody").html("");

                    $.ajax({
                        type: "POST",
                        url: "getSTOutDataById",
                        data: {transNo: paymentId},
                        success: function(data)
                        {
                            TotalAmount = 0;
                            TotalNetAmount = 0;
                            proDiscount = 0;

                            var resultData = JSON.parse(data);

                            $.each(resultData, function(key, value) {
                                paymentNo = value.TrnsNo;
                                var ItemCode = value.ProductCode;
                                TotalAmount += parseFloat(value.GRN_Amount);
                                TotalNetAmount += parseFloat(value.TransAmount);
                                var Product = value.Prd_Description;
                                proDiscount += parseFloat(0);
                                invNo = value.TrnsNo;
                                cusCode = value.TransAmount;
                                ItemCodeArr.push(ItemCode);


                                $("#tbl_payment tbody").append("<tr id='" + (key + 1) + "'><td>" + (key + 1) + "</td><td>" + ItemCode + "</td><td>" + Product + "</td><td>" + value.TransQty + "</td><td>" + value.CostPrice + "</td><td class='text-right'>" + accounting.formatMoney(value.SellingPrice) + "</td><td class='text-right'>" + (value.Serial) + "</td><td class='text-right'>" + accounting.formatMoney(value.TransAmount) + "</td></tr>");
                                $("#totalAmount").html(accounting.formatMoney(value.GRN_totalAmount));
                                $("#totalDis").html(accounting.formatMoney(value.TotalDiscount));
                                $("#totalNet").html(accounting.formatMoney(value.totalNet));
                            });

                            $("#tbl_payment tbody").append("<tr><td></td><td></td><td></td><td></td><td></td><td></td><td>Total Amount</td><td class='text-right'><b>" + accounting.formatMoney(TotalNetAmount) + "</b></td></tr>");

                        }
                    });


                }
            });
        }
    });


    $("#pay").click(function() {
        var payDate = $("#invDate").val();
        var remark = $("#remark").val();
        var invUser = $("#invUser").val();
        location = $("#location").val();
        var sendItem_code = JSON.stringify(ItemCodeArr);

        var r = confirm("Do you want to save this transaction?");
        if (r == true) {
            if (paymentNo == '' || paymentNo == 0) {
                alert('Please select an invoice ');
                return false;
            } else {
                $("#pay").prop('disabled', true);
                $.ajax({
                    type: "POST",
                    url: "cancelTranser",
                    data: { paymentNo: paymentNo, remark: remark, payDate: payDate, invUser: invUser, supCode: cusCode, invNo: invNo, Item_codeArr: sendItem_code, location: location,location_from:location_from,location_to:location_to},
                    success: function(data)
                    {
                        var resultData = JSON.parse(data);
                        var feedback = resultData['fb'];
                        var invNumber = resultData['InvNo'];
                        var cancelNo = resultData['CancelNo'];
                        if (feedback == 1) {
                            $("#errData").show();
                            $('html, body').animate({scrollTop: $('#remark').offset().top}, 'slow');
                            $("#errData").html('Stock transfer in successfully saved.').addClass('alert alert-success alert-dismissible alert-sm').delay(1500).fadeOut(600);
                            rid = 0;
                            paymentNo = 0;
                            clearPaymentDetails();
                            $("#customer").val('');
                            $("#remark").val('');
                            $("#lastTranaction").html("Last Transfer Cancel : " + invNumber + " <br> Last Cancel No : " + cancelNo);
                            $("#pay").prop('disabled', false);
                        } else {
                            $("#errData").show();
                            $('html, body').animate({scrollTop: $('#remark').offset().top}, 'slow');
                            $("#errData").html('Transaction not saved.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                            return false;
                            alert('Transaction not saved');
                                    $("#pay").prop('disabled', false);
                                    return false;
                        }

                    }
                });
            }
        } else {
            return false;
        }



    });

    function clearPaymentDetails() {

        $("#remark").val('');
        ItemCodeArr.length = 0;
        $("#invoice").val('');
        invNo = 0;
        TotalAmount = 0;
        TotalNetAmount = 0;
        proDiscount = 0;
        paymentId = 0;
        paymentNo = 0;
        cusCode = 0;
        $("#tbl_payment tbody").empty();
        $("#totalAmount").html(accounting.formatMoney(0));
        $("#totalDis").html(accounting.formatMoney(0));
        $("#totalNet").html(accounting.formatMoney(0));
         $("#location_to").val(loc);
         $("#location_from").val('');

    }

});


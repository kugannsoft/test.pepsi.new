
$(document).ready(function() {
    $('#invDate,#rd_chequeReciveDate,#rd_chequeDate,#expenses_date,#dwn_pay_date,#rd_pay_date,#quartPayDate,#chequeDate,#downPayDate1,#downPayDate2,#downPayDate3,#downPayDate4,#downPayDate5,#downPayDate6').datepicker({
        format: 'yyyy-mm-dd',
        startDate: '-3d'
    });

    $('#invDate,#rd_chequeReciveDate,#rd_chequeDate,#expenses_date,#dwn_pay_date,#rd_pay_date,#quartPayDate,#downPayDate1,#downPayDate2,#downPayDate3,#downPayDate4,#downPayDate5,#downPayDate6').datepicker().datepicker("setDate", new Date());

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
    $("#rental_cheque").hide();
    $("#dwn_cheque").hide();
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
    var InvNo = '';

    dwnInt = parseFloat($("#dwnInterest").val());

    var outAccNo = 0;
    outAccNo = $("#outAccNo").val();
    if (outAccNo != 0) {
        $.ajax({
            type: "post",
            url: "../EasyPayment/getActiveAccountsDetails",
            data: {accNo: outAccNo},
            success: function(data) {
                cal_total(0, 0, 0, 0, 0, 0, 0, 0);
                clearAll();
                var resultData = JSON.parse(data);
                $.each(resultData, function(key, value) {
                    acc_no = value.AccNo;
                    $("#cusCode").html(value.CusNic);
                    $("#lbl_acc_no").html(value.AccNo);
                    $("#customer").val(value.AccNo);
                    $("#creditLimit").html(accounting.formatMoney(0));
                    $("#creditPeriod").html(value.CusCode);
                    $("#cusOutstand").html((value.CusName));
                    $("#cusName").val((value.CusName));
                    $("#cusName").prop('disabled', true);
                    $("#city").html(value.CusName);
                    $("#cusImage").show();
                    cusCode = value.CusCode;
                    accType = value.AccType;
                    accCategory = value.ItemCategory;
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
                    url: "../EasyPayment/getRentalExtraAmount",
                    data: {itemType: accType, itemCategory: accCategory},
                    success: function(data) {
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
                    }
                });

                $.ajax({
                    type: "post",
                    url: "../Admin/Controller/Account.php",
                    data: {action: 'getTermInterest', itemType: accType, itemCategory: accCategory},
                    success: function(data) {
                        var resultData = JSON.parse(data);
                        $("#noOfIntTerm").empty();
                        $("#noOfIntTerm").append("<option value='0'>-Select a term-</option>");
                        $.each(resultData, function(key, value) {
                            var charge_type = value.IntTerm;
                            $("#noOfIntTerm").append("<option value=" + value.Interest + ">" + charge_type + "</option>");
                        });
                    }
                });
            }
        });
    }
    //get interest terms--------------------------------------------------------------------------
//    $.ajax({
//        type: "post",
//        url: "../Admin/Controller/Account.php",
//        data: {action: 'getTermInterestByType', itemType: accType2},
//        success: function(data) {
//            var resultData = JSON.parse(data);
//            $.each(resultData, function(key, value) {
//                var charge_type = value.IntTerm;
//                $("#noOfIntTerm").append("<option value=" + value.Interest + ">" + charge_type + "</option>");
//            });
//        }
//    });
    var AccNo = '';
    var total_instal_due = 0;
    var total_rd_due = 0;

    var checkedTerm = [];
    var checkedAcc = [];
    var chInvNo = [];
    var chDueAmount = [];
    var chDueDate = [];

    //account autoload--------------------------------------------------------------------------
    $("#account_no").autocomplete({
        source: function(request, response) {

            $.ajax({
                url: '../EasyPayment/loadAccounts',
                dataType: "json",
                data: {
                    name_startsWith: request.term,
                    cus_type: cusType
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.AccNo,
                            value: item.AccNo,
                            AccNo: item.AccNo, InvNo: item.InvNo, AccType: item.AccType, ItemCategory: item.ItemCategory, CusCode: item.CusCode, refNo: item.refNo, CusNic: item.CusNic, CusName: item.CusName,
                            InvDate: item.InvDate, TotalAmount: item.TotalAmount, DisAmount: item.DisAmount, DownPayment: item.DownPayment, TotalExCharges: item.TotalExCharges, TotalExAmount: item.TotalExAmount,
                            TotalDwPayment: item.TotalDwPayment, FinalAmount: item.FinalAmount, InterestTerm: item.InterestTerm, InterestRate: item.InterestRate, Interest: item.Interest, GrossAmount: item.GrossAmount, InstallAmount: item.InstallAmount, payt_type: item.payt_type, pay_date: item.pay_date
                        };
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function(event, ui) {

//            cal_total(0, 0, 0, 0, 0, 0, 0, 0);
            clearAll();
            AccNo = ui.item.AccNo;
            var AccType = ui.item.AccType;
            InvNo = ui.item.InvNo;
            var ItemCategory = ui.item.ItemCategory;
            var CusCode = ui.item.CusCode;
            var CusNic = ui.item.CusNic;
            var refNo = ui.item.refNo;
            var CusName = ui.item.CusName;
            var InvDate = ui.item.InvDate;
            var TotalAmount = ui.item.TotalAmount;
            var DisAmount = ui.item.DisAmount;
            var DownPayment = ui.item.DownPayment;
            var TotalExCharges = ui.item.TotalExCharges;
            var TotalExAmount = ui.item.TotalExAmount;
            var TotalDwPayment = ui.item.TotalDwPayment;
            var FinalAmount = ui.item.FinalAmount;
            var InterestTerm = ui.item.InterestTerm;
            var InterestRate = ui.item.InterestRate;
            var Interest = ui.item.Interest;
            var GrossAmount = ui.item.GrossAmount;
            var InstallAmount = ui.item.InstallAmount;
            var payt_type = ui.item.payt_type;
            var pay_date = ui.item.pay_date;

            // console.log(pay_date);
            if (payt_type == 1){
                $("#pay_type").html('Monthly');
            }else if(payt_type == 2){
                $("#pay_type").html('Weekly');
            }else if(payt_type == 3){
                console.log(payt_type);
                $("#pay_type").html('Daily');
            }

            $("#pay_typeHidden").val(payt_type);
            $("#pay_dateHidden").val(pay_date);

            total_amount2 = TotalAmount;
            total_discount = DisAmount;
            totalExtraChrages = TotalExCharges;
            downPayment = DownPayment;
            totalIterest = Interest;
            totalExtraAmount = TotalExAmount;
            totalDwnPayment = TotalDwPayment;
            acc_no = AccNo;
            $("#cusCode").html(CusNic);
            $("#referralNo").html(refNo);
            $("#lbl_acc_no").html(AccNo);
            $("#accNo").html(AccNo);
            $("#invoiceNo").html(InvNo);
            $("#customer").val(AccNo);
            $("#creditLimit").html(accounting.formatMoney(0));
            $("#creditPeriod").html(CusCode);
            $("#cusOutstand").html(accounting.formatMoney(0));
            $("#availableCreditLimit").html(accounting.formatMoney(0));
            $("#city").html(CusName);
            $("#cusName").val(CusName);
            $("#invoiceDate").html(InvDate);
            $("#totalAmount").html(accounting.formatMoney(TotalAmount));
            $("#discountAmount").html(accounting.formatMoney(DisAmount));
            $("#dwnPayments").html(accounting.formatMoney(DownPayment));
            $("#extCharges").html(accounting.formatMoney(TotalExCharges));
            $("#totalDwnPayments").html(accounting.formatMoney(TotalDwPayment));
            $("#dwnPaymentInt").html(accounting.formatMoney(DownPayment));
            $("#extraAmount").html(accounting.formatMoney(TotalExAmount));
            $("#netAmount").html(accounting.formatMoney(GrossAmount));
            $("#interestAmount").html(accounting.formatMoney(Interest));
            $("#netAmountWithInt").html(accounting.formatMoney(FinalAmount));

            $("#tbl_payment_schedule").show();
//            paytblForEasyPayment(GrossAmount, InterestRate, InterestTerm, totalExtraAmount,InvDate);


            $("#cusName").prop('disabled', true);
            $("#cusImage").show();

            cusCode = CusCode;
            accType = AccType;
            accCategory = ItemCategory;

            if (accType == 1) {
                setEasyPayment();
            } else if (accType == 2) {
                setLoanPayment();
//                $('#itemTable').hide();
                $('#payView').show();
                $('#paymentTable').show();
            }
            $("#exChargesTbl tbody").empty();
            var total_settle = 0;
            $.ajax({
                type: "post",
                url: "../EasyPayment/getRentalPaymentData",
                data: {accNo: acc_no},
                success: function(data) {
                    var resultData = JSON.parse(data);
                    // var charge_amount = 0;
                    // var total_instal_due = 0;
                    var total_ext = 0;
                    var due_date = '';
                    var monPayment = 0;
                    var rentalDefault = 0;
                    var total_rdue = 0;
                    var rd = 0;
                    var rdr = parseFloat($("#rental_rate").val());
                    var rdwp = 0;
                    var total_rental = 0;
                    var dueAmountWithExtra = 0;
                    var dueAmountWithRD = 0;
                    var rental_bal = 0;
                    var settleAmount = 0;
                    var today = new Date($("#invDate").val());
                    var rental_date = parseFloat($("#excuse_date").val()) + 1;
                    today.setDate(today.getDate() - rental_date);
                    var dueAmount = 0;
                    var dueAmount2 = 0;
                    var total_dueAmount = 0;
                    var total_rd_paid = 0;
                    var bal_amount = 0;
                    var pending_date = 0;
                    var currentDate = new Date();
                            var cuDate = set_date(today);

                            checkedAcc.length = 0;
                            checkedTerm.length = 0;
                            chInvNo.length = 0;
                            chDueAmount.length = 0;
                            chDueDate.length = 0;
                    $("#tbl_payment_schedule tbody").empty();
                    $.each(resultData, function(key, value) {

                        due_date = value.PaymentDate;
                        monPayment = (value.MonPayment);
                        settleAmount = parseFloat(value.SettleAmount);

                        total_settle += parseFloat(value.SettleAmount);
                        var paymentDate = new Date(value.PaymentDate);
                        dueAmountWithExtra = parseFloat(value.MonPayment) + parseFloat(value.ExtraAmount);
                        bal_amount = parseFloat(dueAmountWithExtra) + parseFloat(dueAmount2);

                        var days = (paymentDate - today) / (1000 * 60 * 60 * 24);
                        if (days < 0 && (value.IsPaid) == 0) {
                            rd = (bal_amount) * rdr / 100;
                        } else {
                            rd = 0;
                        }
                        
                        var daysCount = Math.round((currentDate - paymentDate) / (1000 * 60 * 60 * 24));
                        // (paymentDate - currentDate) / (1000 * 60 * 60 * 24);
                        console.log('test',daysCount);
                        var displayDays =0;
                        if (daysCount > 0 && (value.IsPaid) == 0) {
                            displayDays = daysCount;
                        } else {
                            displayDays = 0;

                        }
// console.log('Asanka',displayDays);
                        rentalDefault = parseFloat(value.RentalDefault) + parseFloat(rd);

                        dueAmountWithRD = parseFloat(dueAmountWithExtra);
                        total_rdue = dueAmountWithRD;
                        rental_bal += dueAmountWithRD;
//                        alert(dueAmountWithRD);
                        dueAmount = parseFloat(dueAmountWithRD - settleAmount);
                        dueAmount2 = parseFloat(rental_bal - total_settle);
                        total_dueAmount += dueAmount;
                        total_ext += parseFloat(value.ExtraAmount);
                        rdwp = parseFloat(dueAmountWithExtra + rd);

                        // total paid rental default
                        if ((value.IsPaid) == 1) {
                            total_rd_paid += parseFloat(value.RentalDefault);
                        }
                        
                        pending_date = new Date(due_date);
                                var due_yr = pending_date.getFullYear();
                                var due_mn = pending_date.getMonth();

                                var curMn = today.getMonth();
                                var curYr = today.getFullYear();

                                if (due_date < cuDate && due_yr == curYr && due_mn == curMn) {
                                    checkedAcc.push(value.AccNo);
                                    checkedTerm.push(value.Month);
                                    chInvNo.push(value.InvNo);
                                    chDueAmount.push(dueAmount2);
                                    chDueDate.push(due_date);
                                }

                        // $("#tbl_payment_schedule").append("<tr id='" + (key + 1) + "'>
                        // <td  class='month'>" + value.Month + "</td>
                        // <td>" + (due_date) + "</td>
                        // <td>" + accounting.formatMoney(monPayment) + "</td>
                        // <td>" + accounting.formatMoney(value.ExtraAmount) + "</td>
                        // <td>" + accounting.formatMoney(dueAmountWithExtra) + "</td>
                        // <td class='rental_default'>" + accounting.formatMoney(rentalDefault) + "</td>
                        // <td class='dueWRD'>" + accounting.formatMoney(dueAmountWithRD) + "</td>
                        // <td class='text-right creditAmount'>" + accounting.formatMoney(total_rdue) + "</td>
                        // <td class='text-right rentalAmount'>" + accounting.formatMoney(rental_bal) + "</td>
                        // <td class='text-right settleAmount' invPay='0'>" + accounting.formatMoney(value.SettleAmount) + "</td>
                        // <td class='text-right dueAmount' isColse='0'>" + accounting.formatMoney(dueAmount2) + "</td></tr>");
                        $("#tbl_payment_schedule").append("<tr id='" + (key + 1) + "'>" +
                            "<td  class='month'>" + value.Month + "</td>" +
                            "<td>" + (due_date) + "</td>" +
                            "<td>" + accounting.formatMoney(monPayment) + "</td>" +
                            "<td>" + accounting.formatMoney(value.ExtraAmount) + "</td>" +
                            "<td>" + accounting.formatMoney(dueAmountWithExtra) + "</td>" +
                             "<td class='rental_default'>" + displayDays + "</td>" +
                            // "<td class='dueWRD'>" + accounting.formatMoney(dueAmountWithRD) + "</td>" +
                            "<td class='text-right creditAmount'>" + accounting.formatMoney(total_rdue) + "</td>" +
                            "<td class='text-right rentalAmount'>" + accounting.formatMoney(rental_bal) + "</td>" +
                            "<td class='text-right settleAmount' invPay='0'>" + accounting.formatMoney(value.SettleAmount) + "</td>" +
                            "<td class='text-right dueAmount' isColse='0'>" + accounting.formatMoney(dueAmount2) + "</td>" +
                            "</tr>");

                        total_instal_due = parseFloat(rental_bal);
                        $("#s_totalDueWRD").html(accounting.formatMoney(total_instal_due));
                        $("#s_installDue").html(accounting.formatMoney(total_instal_due - total_settle));
                        $("#s_totalDueWRD").html(accounting.formatMoney(total_instal_due));
                        $("#tps_tot_pay").html(accounting.formatMoney(rental_bal));
                        $("#tps_tot_prin").html(accounting.formatMoney(rental_bal));
                        $("#tps_tot_int").html(accounting.formatMoney(total_settle));
                        $("#tps_tot_bal").html(accounting.formatMoney(total_dueAmount));
                        var rd_term_due = parseFloat((total_instal_due - total_settle) / InstallAmount);
                        $("#rd_term_due").val(accounting.formatMoney(rd_term_due));
                        $("#s_installTermDue").html(accounting.formatMoney(rd_term_due));
                        $("#s_installPaidAmount").html(accounting.formatMoney(total_settle));
                        var rd_term_paid = parseFloat(total_settle / InstallAmount);
                        $("#s_installPaidTerm").html(accounting.formatMoney(rd_term_paid));
                        $("#totalExAmount").html(accounting.formatMoney(total_ext));
                        $("#s_totalPaidRD").html(accounting.formatMoney(total_rd_paid));

                        total_rd_due = parseFloat(total_instal_due) - parseFloat(total_settle) + parseFloat($("#rd_extr_amount").val()) + parseFloat($("#rd_insu_amount").val());
                        $("#rd_tot_due_amount").val(accounting.formatMoney(total_rd_due));
                    });
                }
            });

            //Check Reschedule
            $.ajax({
                type: "post",
                url: "../EasyPayment/checkIsReschedule",
                data: {accNo: acc_no},
                success: function(data) {
                    try {
                            if (data){

                                $("#reScheduleNotice").html('This loan is already Rescheduled. You Can Not any process.');

                                $("#reschedule").attr('disabled', true);
                                $("#printFinalLetter").attr('disabled', true);
                                $("#printRemLetter").attr('disabled', true);
                                $("#rdPay").attr('disabled', true);
                                $("#saveItems").attr('disabled', true);
                                $("#dwnPay").attr('disabled', true);
                                $("#printDwPayment").attr('disabled', true);
                                $("#saveExtra").attr('disabled', true);
                            } else {
                                $("#reScheduleNotice").html('');

                                $("#reschedule").attr('disabled', false);
                                $("#printFinalLetter").attr('disabled', false);
                                $("#printRemLetter").attr('disabled', false);
                                $("#rdPay").attr('disabled', false);
                                $("#saveItems").attr('disabled', false);
                                $("#dwnPay").attr('disabled', false);
                                $("#printDwPayment").attr('disabled', false);
                                $("#saveExtra").attr('disabled', false);
                            }
                    } catch (e){

                    }
                }
            });

//load down payments
            $.ajax({
                type: "post",
                url: "../EasyPayment/getDownPaymentData",
                data: {InvNo: InvNo},
                success: function(data) {
                    try {
                        var today = new Date($("#invDate").val());
                        var rental_date = parseFloat($("#excuse_date").val()) + 1;
                        var rdr = parseFloat($("#rental_rate").val());
                        var dWrd = 0;
                        today.setDate(today.getDate() - rental_date);
                        var total_due = 0;
                        var total_dwn = 0;
                        var dwnDueAmount = 0;
                        var resultData = JSON.parse(data);
                        $("#table_dwnPayment tbody").empty();
                        var rentaldefault = 0;
                        $.each(resultData, function (key, value) {
                            var paymentDate = new Date(value.PaymentDate);
                            var days = (paymentDate - today) / (1000 * 60 * 60 * 24);

                            if (days < 0) {
                                rentaldefault = parseFloat((value.DownPayment) * rdr / 100);
                            } else {
                                rentaldefault = 0;
                            }
                            dWrd = parseFloat(value.RentalDefault) + parseFloat(rentaldefault);

                            total_due = dWrd + parseFloat(value.DownPayment);
                            dwnDueAmount = total_due - parseFloat(value.SettleAmount);
                            $("#table_dwnPayment tbody").append("<tr  id='d" + (key + 1) + "'><td>" + (key + 1) + "</td><td class='DwNo'>" + (value.DwPayType) + "</td><td class='dwInvNo'>" + (InvNo) + "</td><td class='dwPayDate'>" + (value.PaymentDate) + "</td><td>" + accounting.formatMoney(value.DownPayment) + "</td><td class='dWrentalDefault'>" + accounting.formatMoney(dWrd) + "</td><td class='dWcreditAmount'>" + accounting.formatMoney(total_due) + "</td><td class='text-right dWsettleAmount' dWinvPay='0'>" + accounting.formatMoney(value.SettleAmount) + "</td><td class='DwDueAmount'>" + accounting.formatMoney(dwnDueAmount) + "</td></tr>");
                            total_dwn += dwnDueAmount;
                        });

                        $("#tot_dwnpay").val(total_dwn);
                        var total_dwn_dues = parseFloat($("#tot_extr").val()) + parseFloat(total_dwn);
                        $("#dwn_due_amount").val(accounting.formatMoney(total_dwn_dues));
                        var tda = parseFloat(total_dwn_dues) + parseFloat($("#dwn_extr_amount").val());
                        $("#tot_due_amount").val(accounting.formatMoney(tda));
                    }catch (e){

                    }
                }
            });
            var total_extra = 0;
            // load Extra amounts
            $.ajax({
                type: "post",
                url: "../EasyPayment/getRentalExtraAmount",
                data: {InvNo: InvNo},
                success: function(data) {
                    try {
                    var today = new Date($("#invDate").val());
                    var rental_date = parseFloat($("#excuse_date").val()) + 1;
                    var rdr = parseFloat($("#rental_rate").val());
                    today.setDate(today.getDate() - rental_date);
                    var total_due = 0;
                    var resultData = JSON.parse(data);
                    $("#table_extPayment tbody").empty();
                    var rentaldefault = 0;
                    $.each(resultData, function(key, value) {
                        var paymentDate = new Date(value.PayDate);
                        var days = (paymentDate - today) / (1000 * 60 * 60 * 24);

                        if (days < 0) {
                            rentaldefault = parseFloat((value.ExtraAmount) * rdr / 100);
                        } else {
                            rentaldefault = 0;
                        }
                        total_due = rentaldefault + parseFloat(value.ExtraAmount);
                        $("#table_extPayment tbody").append("<tr><td>" + (key + 1) + "</td><td>" + (InvNo) + "</td><td>" + (value.PayDesc) + "</td><td>" + (value.PayDate) + "</td><td class='extAmount'>" + accounting.formatMoney(value.ExtraAmount) + "</td><td>" + accounting.formatMoney(rentaldefault) + "</td><td>" + accounting.formatMoney(total_due) + "</td></tr>");
                        total_extra += total_due;
                    });
                    $("#tot_extr").html(accounting.formatMoney(total_extra));
                    total_dwn_due = parseFloat($("#tot_dwnpay").val());
                    $("#dwn_due_amount").val(accounting.formatMoney(total_dwn_due));
                    var tda = parseFloat(total_dwn_due);
                    $("#tot_due_amount").val(accounting.formatMoney(tda));

                    } catch (e) {

                    }
                }
            });

            $('#tbl_payment_history tbody').empty();

            var totps_paid = 0;
            var totps_exAmount = 0;
            var totps_insAmount = 0;
            var totps_dueAmount = 0;
            var totalps_due = 0;
            $.ajax({
                type: "post",
                url: "../EasyPayment/getPaymentDataByAccNo",
                data: {InvNo: InvNo},
                success: function(data) {
                    try {
                        var resultData = JSON.parse(data);
                        var cheque_date = '';
                        $.each(resultData, function (key, value) {
                            totalps_due = parseFloat(value.PayAmount) + parseFloat(value.ExtraAmount) + parseFloat(value.InsuranceAmount);
                            if (value.ChequeDate == '0000-00-00') {
                                cheque_date = '-';
                            } else {
                                cheque_date = value.ChequeDate;
                            }
                            $("#tbl_payment_history").append("<tr id='ph" + (key + 1) + "'><td  class='ph_id'>" + (key + 1) + "</td><td class='ph_PayNo'>" + (value.PaymentId) + "</td><td class='text-right'>" + value.PayDate + "</td><td class='text-right'>" + value.payType + "</td><td class='text-right'>" + accounting.formatMoney(value.PayAmount) + "</td><td class='text-right ph_extra'>" + accounting.formatMoney(value.ExtraAmount) + "</td><td class='text-right ph_InsuAmount'>" + accounting.formatMoney(value.InsuranceAmount) + "</td><td class='text-right ph_iddueAmount' isColse='0'>" + accounting.formatMoney(totalps_due) + "</td><td class='text-right ph_idcreditAmount'>" + cheque_date + "</td><td class='text-right ph_idrentalAmount'>" + (value.ChequeNo) + "</td><td class='text-right ph_idsettleAmount' invPay='0'>" + (value.ChequeReference) + "</td></tr>");
                            totps_paid += parseFloat(value.PayAmount);
                            totps_exAmount += parseFloat(value.ExtraAmount);
                            totps_insAmount += parseFloat(value.InsuranceAmount);
                            totps_dueAmount += parseFloat(totalps_due);

                            $("#tph_tot_prin").html(accounting.formatMoney(totps_paid));
                            $("#tph_tot_pay").html(accounting.formatMoney(totps_exAmount));
                            $("#tph_tot_int").html(accounting.formatMoney(totps_insAmount));
                            $("#tph_tot_bal").html(accounting.formatMoney(totps_dueAmount));
                        });
                    } catch (e) {

                    }
                }
            });


//         alert($("#tot_extr").val());

            cal_Rental_collection_summery(FinalAmount, 0, FinalAmount, InterestTerm, InstallAmount, total_instal_due, total_instal_due, 0, total_settle, 0, 0, 0, 0);
//            cal_Rental_collection_summery(GrossAmount, 0, GrossAmount, InterestTerm, InstallAmount, totDueWRD1, totIntDueAmount1, totalIntTermDue1 ,totIntPaid1,totIntTermPaid1,totPaid1,totPaidWRD1,totExAmount1);
        }
    });

    $("#dwn_extr_amount").blur(function() {
        var tot_due_rd = parseFloat($(this).val()) + parseFloat(accounting.unformat($("#dwn_due_amount").val()));
        $("#tot_due_amount").val(accounting.formatMoney(tot_due_rd));
    });

    $("#rd_extr_amount").blur(function() {
        var tot_due_rd = parseFloat($(this).val()) + parseFloat(total_rd_due) + parseFloat(accounting.unformat($("#rd_insu_amount").val()));
        $("#rd_tot_due_amount").val(accounting.formatMoney(tot_due_rd));
    });

    $("#rd_insu_amount").blur(function() {
        var tot_due_rd = parseFloat($(this).val()) + parseFloat(total_rd_due) + parseFloat(accounting.unformat($("#rd_extr_amount").val()));
        $("#rd_tot_due_amount").val(accounting.formatMoney(tot_due_rd));
    });

//     $("#invDate").change(function() {
//         $.ajax({
//             type: "post",
//             url: "../Admin/Controller/Payment.php",
//             data: {action: 'loadAccounts', cus_type: cusType, name_startsWith: AccNo, row_num: 1},
//             success: function(data) {
//                 clearAll();
//
//                 var resultData = JSON.parse(data);
//
// //                    var charge_amount = 0;
//                 $.each(resultData, function(key, value) {
//                     var AccNo = value.AccNo;
//                     var AccType = value.AccType;
//                     var ItemCategory = value.ItemCategory;
//                     var CusCode = value.CusCode;
//                     var CusNic = value.CusNic;
//                     var CusName = value.CusName;
//                     var InvDate = value.InvDate;
//                     var TotalAmount = value.TotalAmount;
//                     var DisAmount = value.DisAmount;
//                     var DownPayment = value.DownPayment;
//                     var TotalExCharges = value.TotalExCharges;
//                     var TotalExAmount = value.TotalExAmount;
//                     var TotalDwPayment = value.TotalDwPayment;
//                     var FinalAmount = value.FinalAmount;
//                     var InterestTerm = value.InterestTerm;
//                     var InterestRate = value.InterestRate;
//                     var Interest = value.Interest;
//                     var GrossAmount = value.GrossAmount;
//                     var InstallAmount = value.InstallAmount;
//                     cusCode = value.CusCode;
//                     total_amount2 = TotalAmount;
//                     total_discount = DisAmount;
//                     totalExtraChrages = TotalExCharges;
//                     downPayment = DownPayment;
//                     totalIterest = Interest;
//                     totalExtraAmount = TotalExAmount;
//                     totalDwnPayment = TotalDwPayment;
//                     acc_no = AccNo;
//                     $("#cusCode").html(CusNic);
//                     $("#lbl_acc_no").html(AccNo);
//                     $("#accNo").html(AccNo);
//                     $("#customer").val(AccNo);
//                     $("#creditLimit").html(accounting.formatMoney(0));
//                     $("#creditPeriod").html(CusCode);
//                     $("#cusOutstand").html(accounting.formatMoney(0));
//                     $("#availableCreditLimit").html(accounting.formatMoney(0));
//                     $("#city").html(CusName);
//                     $("#cusName").val(CusName);
//                     $("#invoiceDate").html(InvDate);
//                     $("#totalAmount").html(accounting.formatMoney(TotalAmount));
//                     $("#discountAmount").html(accounting.formatMoney(DisAmount));
//                     $("#dwnPayments").html(accounting.formatMoney(DownPayment));
//                     $("#extCharges").html(accounting.formatMoney(TotalExCharges));
//                     $("#totalDwnPayments").html(accounting.formatMoney(TotalDwPayment));
//                     $("#dwnPaymentInt").html(accounting.formatMoney(DownPayment));
//                     $("#extraAmount").html(accounting.formatMoney(TotalExAmount));
//                     $("#netAmount").html(accounting.formatMoney(GrossAmount));
//                     $("#interestAmount").html(accounting.formatMoney(Interest));
//                     $("#netAmountWithInt").html(accounting.formatMoney(FinalAmount));
//
//                     $("#tbl_payment_schedule").show();
//                     $.ajax({
//                         type: "post",
//                         url: "../Admin/Controller/Payment.php",
//                         data: {action: 'getRentalPaymentData', accNo: acc_no},
//                         success: function(data) {
//                             var resultData = JSON.parse(data);
//                             // var charge_amount = 0;
//                             // var total_instal_due = 0;
//                             var total_settle = 0;
//                             var total_ext = 0;
//                             var due_date = '';
//                             var monPayment = 0;
//                             var rentalDefault = 0;
//                             var total_rdue = 0;
//                             var rd = 0;
//                             var rdr = parseFloat($("#rental_rate").val());
//                             var rdwp = 0;
//                             var total_rental = 0;
//                             var dueAmountWithExtra = 0;
//                             var dueAmountWithRD = 0;
//                             var rental_bal = 0;
//                             var settleAmount = 0;
//                             var today = new Date($("#invDate").val());
//                             var rental_date = parseFloat($("#excuse_date").val()) + 1;
//                             today.setDate(today.getDate() - rental_date);
//                             var dueAmount = 0;
//                             var dueAmount2 = 0;
//                             var total_dueAmount = 0;
//                             var total_rd_paid = 0;
//                             var bal = 0;
//                             var bal_amount = 0;
//                             var pending_date = 0;
//                             var cuDate = set_date(today);
//
//                             checkedAcc.length = 0;
//                             checkedTerm.length = 0;
//                             chInvNo.length = 0;
//                             chDueAmount.length = 0;
//                             chDueDate.length = 0;
//
//                             $("#tbl_payment_schedule tbody").empty();
//                             $.each(resultData, function(key, value) {
//
//                                 due_date = value.PaymentDate;
//                                 monPayment = (value.MonPayment);
//                                 settleAmount = parseFloat(value.SettleAmount);
//
//                                 total_settle += parseFloat(value.SettleAmount);
//                                 var paymentDate = new Date(value.PaymentDate);
//                                 dueAmountWithExtra = parseFloat(value.MonPayment) + parseFloat(value.ExtraAmount);
//                                 total_ext += parseFloat(value.ExtraAmount);
//                                 var days = (paymentDate - today) / (1000 * 60 * 60 * 24);
//                                 bal = parseFloat(dueAmountWithExtra) + parseFloat(dueAmount);
// //                                parseFloat(rental_bal - settleAmount);
//                                 bal_amount = parseFloat(dueAmountWithExtra) + parseFloat(dueAmount2);
//
//                                 // calculate rental defalt
//                                 if (days < 0 && (value.IsPaid) == 0 && settleAmount == 0) {
//                                     rd = (bal_amount) * rdr / 100;
//                                 } else {
//                                     rd = 0;
//                                 }
//
//                                 rentalDefault = parseFloat(value.RentalDefault) + parseFloat(rd);
//
//                                 dueAmountWithRD = parseFloat(dueAmountWithExtra + rentalDefault);
//                                 total_rdue = dueAmountWithRD;
//                                 rental_bal += dueAmountWithRD;
//                                 dueAmount = parseFloat(dueAmountWithRD - settleAmount);
//                                 dueAmount2 = parseFloat(rental_bal - total_settle);
//                                 total_dueAmount += dueAmount;
//                                 rdwp = parseFloat(dueAmountWithExtra + rd);
//
//                                 // total paid rental default
//                                 if ((value.IsPaid) == 1) {
//                                     total_rd_paid += parseFloat(value.RentalDefault);
//                                 }
//
//                                 pending_date = new Date(due_date);
//                                 var due_yr = pending_date.getFullYear();
//                                 var due_mn = pending_date.getMonth();
//
//                                 var curMn = today.getMonth();
//                                 var curYr = today.getFullYear();
//
//                                 if (due_date < cuDate && due_yr == curYr && due_mn == curMn) {
//                                     checkedAcc.push(value.AccNo);
//                                     checkedTerm.push(value.Month);
//                                     chInvNo.push(value.InvNo);
//                                     chDueAmount.push(dueAmount2);
//                                     chDueDate.push(due_date);
//                                 }
//
//                                 $("#tbl_payment_schedule").append("<tr id='" + (key + 1) + "'><td  class='month'>" + value.Month + "</td><td>" + (due_date) + "</td><td>" + accounting.formatMoney(monPayment) + "</td><td class='extAmount'>" + accounting.formatMoney(value.ExtraAmount) + "</td><td>" + accounting.formatMoney(dueAmountWithExtra) + "</td><td class='rental_default'>" + accounting.formatMoney(rentalDefault) + "</td><td class='dueWRD'>" + accounting.formatMoney(dueAmountWithRD) + "</td><td class='text-right creditAmount'>" + accounting.formatMoney(total_rdue) + "</td><td class='text-right rentalAmount'>" + accounting.formatMoney(rental_bal) + "</td><td class='text-right settleAmount' invPay='0'>" + accounting.formatMoney(value.SettleAmount) + "</td><td class='text-right dueAmount' isColse='0'>" + accounting.formatMoney(dueAmount2) + "</td></tr>");
//
// //                                alert(dueAmountWithExtra);
//
//                                 total_instal_due = parseFloat(rental_bal);
//                                 $("#s_totalDueWRD").html(accounting.formatMoney(total_instal_due));
//                                 $("#s_installDue").html(accounting.formatMoney(total_instal_due - total_settle));
//                                 $("#s_totalDueWRD").html(accounting.formatMoney(total_instal_due));
//                                 $("#tps_tot_pay").html(accounting.formatMoney(rental_bal));
//                                 $("#tps_tot_prin").html(accounting.formatMoney(rental_bal));
//                                 $("#tps_tot_int").html(accounting.formatMoney(total_settle));
//                                 $("#tps_tot_bal").html(accounting.formatMoney(total_dueAmount));
//                                 var rd_term_due = parseFloat((total_instal_due - total_settle) / InstallAmount);
//                                 $("#rd_term_due").val(accounting.formatMoney(rd_term_due));
//                                 $("#s_installTermDue").html(accounting.formatMoney(rd_term_due));
//                                 $("#s_installPaidAmount").html(accounting.formatMoney(total_settle));
//                                 var rd_term_paid = parseFloat(total_settle / InstallAmount);
//                                 $("#s_installPaidTerm").html(accounting.formatMoney(rd_term_paid));
//                                 $("#totalExAmount").html(accounting.formatMoney(total_ext));
//                                 total_rd_due = parseFloat(total_instal_due) + parseFloat($("#rd_extr_amount").val()) + parseFloat($("#rd_insu_amount").val());
//                                 $("#rd_tot_due_amount").val(accounting.formatMoney(total_rd_due));
//                                 $("#s_totalPaidRD").html(accounting.formatMoney(total_rd_paid));
//                             });
//                         }
//                     });
// //load down payments
//                     $.ajax({
//                         type: "post",
//                         url: "../Admin/Controller/Payment.php",
//                         data: {action: 'getDownPaymentData', InvNo: InvNo},
//                         success: function(data) {
//                             try {
//                                 var today = new Date($("#invDate").val());
//                                 var rental_date = parseFloat($("#excuse_date").val()) + 1;
//                                 var rdr = parseFloat($("#rental_rate").val());
//                                 var dWrd = 0;
//                                 today.setDate(today.getDate() - rental_date);
//                                 var total_due = 0;
//                                 var total_dwn = 0;
//                                 var dwnDueAmount = 0;
//                                 var resultData = JSON.parse(data);
//                                 $("#table_dwnPayment tbody").empty();
//                                 var rentaldefault = 0;
//                                 $.each(resultData, function (key, value) {
//                                     var paymentDate = new Date(value.PaymentDate);
//                                     var days = (paymentDate - today) / (1000 * 60 * 60 * 24);
//
//                                     if (days < 0) {
//                                         rentaldefault = parseFloat((value.DownPayment) * rdr / 100);
//                                     } else {
//                                         rentaldefault = 0;
//                                     }
//                                     dWrd = parseFloat(value.RentalDefault) + parseFloat(rentaldefault);
//
//                                     total_due = dWrd + parseFloat(value.DownPayment);
//                                     dwnDueAmount = total_due - parseFloat(value.SettleAmount);
//                                     $("#table_dwnPayment tbody").append("<tr  id='d" + (key + 1) + "'><td>" + (key + 1) + "</td><td class='DwNo'>" + (value.DwPayType) + "</td><td class='dwInvNo'>" + (InvNo) + "</td><td class='dwPayDate'>" + (value.PaymentDate) + "</td><td>" + accounting.formatMoney(value.DownPayment) + "</td><td class='dWrentalDefault'>" + accounting.formatMoney(dWrd) + "</td><td class='dWcreditAmount'>" + accounting.formatMoney(total_due) + "</td><td class='text-right dWsettleAmount' dWinvPay='0'>" + accounting.formatMoney(value.SettleAmount) + "</td><td class='DwDueAmount'>" + accounting.formatMoney(dwnDueAmount) + "</td></tr>");
//                                     total_dwn += dwnDueAmount;
//                                 });
//
//                                 $("#tot_dwnpay").val(total_dwn);
//                                 var total_dwn_dues = parseFloat($("#tot_extr").val()) + parseFloat(total_dwn);
//                                 $("#dwn_due_amount").val(accounting.formatMoney(total_dwn_dues));
//                                 var tda = parseFloat(total_dwn_dues) + parseFloat($("#dwn_extr_amount").val());
//                                 $("#tot_due_amount").val(accounting.formatMoney(tda));
//                             }catch (e){
//
//                             }
//                         }
//                     });
//                     var total_extra = 0;
//                     // load Extra amounts
//                     $.ajax({
//                         type: "post",
//                         url: "../Admin/Controller/Payment.php",
//                         data: {action: 'getRentalExtraAmount', InvNo: InvNo},
//                         success: function(data) {
//                             try {
//                             var today = new Date($("#invDate").val());
//                             var rental_date = parseFloat($("#excuse_date").val()) + 1;
//                             var rdr = parseFloat($("#rental_rate").val());
//                             today.setDate(today.getDate() - rental_date);
//                             var total_due = 0;
//                             var resultData = JSON.parse(data);
//                             $("#table_extPayment tbody").empty();
//                             var rentaldefault = 0;
//                             $.each(resultData, function(key, value) {
//
//                                 var paymentDate = new Date(value.PayDate);
//                                 var days = (paymentDate - today) / (1000 * 60 * 60 * 24);
//
//                                 if (days < 0) {
//                                     rentaldefault = parseFloat((value.ExtraAmount) * rdr / 100);
//                                 } else {
//                                     rentaldefault = 0;
//                                 }
//                                 total_due = rentaldefault + parseFloat(value.ExtraAmount);
//                                 $("#table_extPayment tbody").append("<tr><td>" + (key + 1) + "</td><td>" + (InvNo) + "</td><td>" + (value.PayDesc) + "</td><td>" + (value.PayDate) + "</td><td>" + accounting.formatMoney(value.ExtraAmount) + "</td><td>" + accounting.formatMoney(rentaldefault) + "</td><td>" + accounting.formatMoney(total_due) + "</td></tr>");
//                                 total_extra += total_due;
//                             });
//                             $("#tot_extr").val(total_extra);
//                             total_dwn_due = parseFloat($("#tot_dwnpay").val()) + parseFloat(total_extra);
//                             $("#dwn_due_amount").val(accounting.formatMoney(total_dwn_due));
//                             var tda = parseFloat(total_dwn_due) + parseFloat($("#dwn_extr_amount").val());
//                             $("#tot_due_amount").val(accounting.formatMoney(tda));
//
//                             } catch (e) {
//
//                             }
//                         }
//                     });
//                     $('#tbl_payment_history tbody').empty();
//                     var totps_paid = 0;
//                     var totps_exAmount = 0;
//                     var totps_insAmount = 0;
//                     var totps_dueAmount = 0;
//                     var totalps_due = 0;
//                     $.ajax({
//                         type: "post",
//                         url: "../Admin/Controller/Payment.php",
//                         data: {action: 'getPaymentDataByAccNo', accNo: InvNo},
//                         success: function(data) {
//                             try {
//                             var resultData = JSON.parse(data);
//                             var cheque_date = 0;
//                             $.each(resultData, function(key, value) {
//                                 totalps_due = parseFloat(value.PayAmount) + parseFloat(value.ExtraAmount) + parseFloat(value.InsuranceAmount);
//                                 if (value.ChequeDate == '0000-00-00') {
//                                     cheque_date = '-';
//                                 } else {
//                                     cheque_date = value.ChequeDate;
//                                 }
//                                 $("#tbl_payment_history").append("<tr id='ph" + (key + 1) + "'><td  class='ph_id'>" + (key + 1) + "</td><td class='ph_PayNo'>" + (value.PaymentId) + "</td><td class='text-right'>" + value.PayDate + "</td><td class='text-right'>" + (value.PayTypeName) + "</td><td class='text-right'>" + accounting.formatMoney(value.PayAmount) + "</td><td class='text-right ph_extra'>" + accounting.formatMoney(value.ExtraAmount) + "</td><td class='text-right ph_InsuAmount'>" + accounting.formatMoney(value.InsuranceAmount) + "</td><td class='text-right ph_iddueAmount' isColse='0'>" + accounting.formatMoney(totalps_due) + "</td><td class='text-right ph_idcreditAmount'>" + (cheque_date) + "</td><td class='text-right ph_idrentalAmount'>" + (value.ChequeNo) + "</td><td class='text-right ph_idsettleAmount' invPay='0'>" + (value.ChequeReference) + "</td></tr>");
//                                 totps_paid += parseFloat(value.PayAmount);
//                                 totps_exAmount += parseFloat(value.ExtraAmount);
//                                 totps_insAmount += parseFloat(value.InsuranceAmount);
//                                 totps_dueAmount += parseFloat(totalps_due);
//
//                                 $("#tph_tot_prin").html(accounting.formatMoney(totps_paid));
//                                 $("#tph_tot_pay").html(accounting.formatMoney(totps_exAmount));
//                                 $("#tph_tot_int").html(accounting.formatMoney(totps_insAmount));
//                                 $("#tph_tot_bal").html(accounting.formatMoney(totps_dueAmount));
//                             });
//                             } catch (e) {
//
//                             }
//                         }
//                     });
//
//                     cal_Rental_collection_summery(FinalAmount, 0, FinalAmount, InterestTerm, InstallAmount, total_instal_due, total_instal_due, 0, 0, 0, 0, 0, 0);
//
//                 });
//             }
//         });
//     });


    $("#printRemLetter").click(function() {
        var invDate = $('#invDate').val();
        var sendTerm = JSON.stringify(checkedTerm);
        var sendInvNo = JSON.stringify(chInvNo);
        var sendDueAmount = JSON.stringify(chDueAmount);
        var sendDueDate = JSON.stringify(chDueDate);
        var sendAccNo = JSON.stringify(checkedAcc);

        $("#h_invNo").val(sendInvNo);
        $("#h_accNo").val(sendAccNo);
        $("#h_dueDate").val(sendDueDate);
        $("#h_dueAmount").val(sendDueAmount);
        $("#h_term").val(sendTerm);
        $("#h_invDate").val(invDate);
        $('#printRemLetter').attr('type', 'submit');
        $('#post_rl').attr('target', '_blank');

        $("#post_rl").attr('action', '../Admin/all-rem-letter_1.php');

    });

    $("#printFinalLetter").click(function() {
        var invDate = $('#invDate').val();
        var sendTerm = JSON.stringify(checkedTerm);
        var sendInvNo = JSON.stringify(chInvNo);
        var sendDueAmount = JSON.stringify(chDueAmount);
        var sendDueDate = JSON.stringify(chDueDate);
        var sendAccNo = JSON.stringify(checkedAcc);

        $("#h_invNo").val(sendInvNo);
        $("#h_accNo").val(sendAccNo);
        $("#h_dueDate").val(sendDueDate);
        $("#h_dueAmount").val(sendDueAmount);
        $("#h_term").val(sendTerm);
        $("#h_invDate").val(invDate);
        $('#printFinalLetter').attr('type', 'submit');
        $('#post_rl').attr('target', '_blank');

        $("#post_rl").attr('action', '../Admin/final-rem-letter.php');

    });

    $("#priceLevel").change(function() {
        price_level = $("#priceLevel option:selected").val();
    });

    // save extara amounts
    $("#saveExtra").click(function() {
        var extra_date = new Array();
        var extra_desc = new Array();
        var extra_amount = new Array();
        var expensRowCount = $('#table_expenses tr').length;

        var chequeNo = $("#dwn_chequeNo").val();
        var chequeReference = $("#dwn_chequeReference").val();
        var chequeRecivedDate = $("#dwn_chequeReciveDate").val();
        var chequeDate = $("#dwn_chequeDate").val();

        for (var c = 1; c <= expensRowCount - 2; c++) {
            extra_date.push($("#exr" + c + " .expenses_nameEx" + c).attr("expenseType"));  //Extra amount date
            extra_desc.push(($("#exr" + c + " .expenses_name" + c).html()));
            extra_amount.push(accounting.unformat($("#exr" + c + " .expense_amountEx" + c).html()));   //Extra amount
        }

        var sendExtra_date = JSON.stringify(extra_date);
        var sendExtra_amount = JSON.stringify(extra_amount);
        var sendExtra_desc = JSON.stringify(extra_desc);

        if ((acc_no == '' && cusCode == '') || (acc_no == 0 && cusCode == 0)) {
            alert('Please select an acount number.');
            return false;
        } else if (cusCode == '' || cusCode == '0') {
            alert('Please select a customer.');
            return false;
        } else if ((expensRowCount - 1) == '0' || (expensRowCount - 1) == '') {
            alert("Please add Extra Amounts.");
            return false;
        } else {

            $.ajax({
                type: "post",
                url: "../Admin/Controller/Account.php",
                data: {acc_no: acc_no, invNo: InvNo, extra_date: sendExtra_date, extra_desc: sendExtra_desc, extra_amount: sendExtra_amount, cusCode: cusCode, action: 'addExtraAmount', chequeNo: chequeNo, chequeReference: chequeReference, chequeRecivedDate: chequeRecivedDate, chequeDate: chequeDate},
                success: function(data) {

                    if (data != 1) {
                        alert('Extra amounts not saved successfully');
                        return false;
                    } else {

                        alert('Extra amounts saved successfully');
                    }
                }
            });

        }
    });

    $("#reschedule").click(function () {
        var finale_balance = parseFloat(accounting.unformat($("#tps_tot_bal").html()));
        var id_no = $("#cusCode").html();
        var invDate = $('#invDate').val();
        var invUser = $('#invUser').val();
        if (acc_no == ''){
            $.notify('Please Select Loan');
            return false;
        } else {

            var check = confirm('Are sure you want to reschedule this loan?');
            if (check == true) {
                $.ajax({
                    type: "POST",
                    url: "../EasyPayment/reschedule",
                    data: {
                        cusCode: cusCode,
                        acc_no: acc_no,
                        invDate: invDate,
                        finale_balance: finale_balance,
                        invUser: invUser,
                        id_no: id_no
                    },
                    success: function (data) {

                        var resultData = JSON.parse(data);
                        var feedback = resultData['fb'];
                        var lastAccount = resultData['lastAccount'];
                        if (feedback != 1){
                            $.notify("Reschedule not saved.", "warning");
                        }
                        else {
                            $.notify("Reschedule successfully saved.", "success");

                        window.location.href = "../EasyPayment/easyPayment?ac_no=" + lastAccount + "&balance=" + finale_balance;

                        }

                    }
                });
            } else {
                return false;
            }
        }
    });



    var pay_amount = 0;
    var due_amount = 0;
    var credit_amount = 0;
    var settle_amount = 0;
    var total_settle = 0;
    var change_amount = 0;
    var isInvoiceColse = 0;
    var over_pay_amount = 0;
    var over_pay_inv = 0;
    var totalPaidAmount = 0;
    var totalDueAmount = 0;

    //rental payment
    $("#rdPay").click(function() {
        pay_amount = parseFloat($("#rd_pay_amount").val());
        var payType = $("#rd_pay_type option:selected").val();
        var chequeDate = $("#rd_chequeDate").val();
        var chequeReference = $("#rd_chequeReference").val();
        var chequeReciveDate = $('#rd_chequeReciveDate').val();
        var chequeNo = $('#rd_chequeNo').val();
        var payDate = $('#rd_pay_date').val();
        var invDate = $('#invDate').val();
        var rd_extraAmount = parseFloat($('#rd_extr_amount').val());
        var rd_InsuranceAmount = parseFloat($('#rd_insu_amount').val());

        totalPaidAmount = parseFloat(pay_amount) + parseFloat(accounting.unformat($("#s_installPaidAmount").html()));
        totalDueAmount = parseFloat(accounting.unformat($("#s_installDue").html())) - pay_amount;

        if ((acc_no == '' && cusCode == '') || (acc_no == 0 && cusCode == 0)) {
            $.notify("Please select an account number.", "warning");
            return false;
        } else if (payType == '' || payType == '0') {
            $.notify("Please select a payment method.", "warning");
            return false;
        } else if (pay_amount == '' || pay_amount == '0') {
            $.notify("Please enter the payment amount.", "warning");
            return false;
        } else {

            for (var i = 1; i <= $("#tbl_payment_schedule tbody tr").length; i++) {
                due_amount = parseFloat(accounting.unformat($("#tbl_payment_schedule tbody").find("[id='" + i + "']").children('.dueAmount').html()));
                credit_amount = parseFloat(accounting.unformat($("#tbl_payment_schedule tbody").find("[id='" + i + "']").children('.creditAmount').html()));
                settle_amount = parseFloat(accounting.unformat($("#tbl_payment_schedule tbody").find("[id='" + i + "']").children('.settleAmount').html()));

                if (due_amount == 0){
                    continue;
                }
                if (due_amount <= pay_amount) {
                    var due_amount3 = due_amount;
                    var pay_amount3 = pay_amount;

                    $("#" + i + " .settleAmount").attr('invPay', (due_amount));
                    total_settle += due_amount;
                    pay_amount -= due_amount;
                    settle_amount = settle_amount + due_amount;

                    // change_amount = 0;
                    due_amount = credit_amount;
                    //over payment for last invoice
                    if (i == $("#tbl_payment_schedule tbody tr").length) {
                        if (due_amount3 < pay_amount3) {
                            var q = confirm('Your Payment greater than the due amount. Do you want to continue this over payment? *Cancel to pay only due amount');
                            if (q === true) {

                                total_settle = pay_amount;
                                settle_amount = settle_amount + pay_amount;

                                over_pay_amount = credit_amount - settle_amount;
                                over_pay_inv = $("#" + i + " .month").html();
                                change_amount = over_pay_amount;
                                due_amount = change_amount;
                                $("#" + i + " .settleAmount").attr('invPay', settle_amount);
                            } else {
                                total_settle = due_amount;
                                settle_amount = settle_amount + due_amount;
                                change_amount = 0;
                                due_amount = change_amount;
                            }
                        }
                    }

                } else if (due_amount > pay_amount) {
                    $("#" + i + " .settleAmount").attr('invPay', (pay_amount));
                    change_amount = due_amount - pay_amount;
                    settle_amount = settle_amount + pay_amount;
                    total_settle += pay_amount;
                    due_amount = change_amount;
                    pay_amount -= due_amount;

                    if (total_settle > pay_amount) {
                        pay_amount = 0;
                    }
                }

                if (settle_amount >= credit_amount) {
                    isInvoiceColse = 1;
                } else {
                    isInvoiceColse = 0;
                }

                if ($("#" + i + " .settleAmount").attr('invPay') > 0) {
                    $("#" + i).addClass("rowselected").siblings();
                }

                if (change_amount == 0) {
                    // var before_due_amount = parseFloat(accounting.unformat($("#tbl_payment_schedule tbody").find("[id='" + (i - 1) + "']").children('.dueAmount').html()));
                    //
                    // if (before_due_amount != 0) {

                        $("#tbl_payment_schedule tbody").find("[id='" + (i + 1) + "']").children('.dueAmount').html(accounting.formatMoney(due_amount));
                    // }

                    $("#tbl_payment_schedule tbody").find("[id='" + i + "']").children('.dueAmount').html(accounting.formatMoney(0.00));
                } else {

                    $("#tbl_payment_schedule tbody").find("[id='" + i + "']").children('.dueAmount').html(accounting.formatMoney(change_amount));
                }


                $("#tbl_payment_schedule tbody").find("[id='" + i + "']").children('.settleAmount').html(accounting.formatMoney(settle_amount));
            }


            var month = new Array();
            var cus_settle_amount = new Array();
            var rental_default = new Array();
            var cus_credit_amount = new Array();
            var cus_inv_payment = new Array();
            var extAmounts = new Array();
            var rowCounts = $("#tbl_payment_schedule tbody tr").length;

            for (var k = 1; k <= rowCounts; k++) {
                month.push($("#" + k + " .month").html());  //pushing all the product_code listed in the table
                cus_settle_amount.push(accounting.unformat($("#" + k + " .settleAmount").html()));   //pushing all the qty listed in the table
                cus_credit_amount.push(accounting.unformat($("#" + k + " .creditAmount").html()));
                rental_default.push(accounting.unformat($("#" + k + " .rental_default").html()));
                cus_inv_payment.push(accounting.unformat($("#" + k + " .settleAmount").attr('invPay')));
                extAmounts.push(accounting.unformat($("#" + k + " .extAmount").html()));
            }

            var sendMonth = JSON.stringify(month);
            var sendCus_settle_amount = JSON.stringify(cus_settle_amount);
            var sendCus_credit_amount = JSON.stringify(cus_credit_amount);
            var sendCus_inv_payment = JSON.stringify(cus_inv_payment);
            var sendRental_default = JSON.stringify(rental_default);
            var sendExtAmounts = JSON.stringify(extAmounts);
            over_pay_amount = Math.abs(over_pay_amount);

            $.ajax({
                type: "POST",
                url: "../EasyPayment/customerPayment",
                data: {invNo: InvNo, cusCode: cusCode, acc_no: acc_no,
                    invDate: invDate, payAmount: total_settle, payType: payType, rd_extraAmount: rd_extraAmount,
                    rd_InsuranceAmount: rd_InsuranceAmount, chequeReference: chequeReference, chequeRecivedDate: chequeReciveDate,
                    chequeDate: chequeDate, payDate: payDate, settleAmount: settle_amount, isInvoiceColse: isInvoiceColse,
                    chequeNo: chequeNo, month: sendMonth, cus_credit_amount: sendCus_credit_amount,
                    cus_settle_amount: sendCus_settle_amount, total_settle: total_settle, cus_inv_payment: sendCus_inv_payment,
                    rental_default: sendRental_default, over_pay_amount: over_pay_amount, over_pay_inv: over_pay_inv,
                    ExtAmounts: sendExtAmounts, totalPaidAmount: totalPaidAmount, totalDueAmount: totalDueAmount},
                success: function(data)
                {
                    var resultData = JSON.parse(data);
                    var feedback = resultData['fb'];
                    if (feedback != 1){
                        $.notify("Payment not saved.", "warning");
                    }
                    else {
                        $.notify("Payment successfully saved.", "success");
                        // afterPayment(acc_no,InvNo);
                        printPayReceipt(InvNo);
                        clearRentalPaymentDetails();
                        // location.reload();
                    }
                }
            });
        }
    });

    function printPayReceipt(InvNo) {
        $.ajax({
            type: "POST",
            url: "../EasyPayment/getReceiptInvNo",
            data: { invNo: InvNo },
            success: function(data) {
                var resultData = JSON.parse(data);

                loadReceptToPrint(resultData);
            }
        });

    }

    function loadReceptToPrint(resultData) {

        if(resultData.receipt_hed){
            $("#rcpdate,#rcpdate1").html(resultData.receipt_hed.PayDate);
            $("#rcpreceiptno,#rcpreceiptno1").html(resultData.receipt_hed.PaymentId);
            $("#rcpamountword,#rcpamountword1").html(resultData.pay_amount_word);
            // $("#rcpreason,#rcpreason1").html(resultData.resultData.Remark);
            $("#rcpcusname,#rcpcusname1").html(resultData.receipt_hed.DisplayName);
            $("#rcpcusaddress,#rcpcusaddress1").html(nl2br(resultData.receipt_hed.Address01));
            $("#rcpcuscode,#rcpcuscode1").html(resultData.receipt_hed.CusCode);
            $("#rcpamount,#rcpamount1").html(accounting.formatMoney(resultData.receipt_hed.TotalPayment));
            $("#rcpinvno,#rcpinvno1").html(resultData.receipt_hed.InvNo);
            $("#rcpvno,#rcpvno1").html(resultData.receipt_hed.AccNo);
            $("#rcpchequeno,#rcpchequeno1").html(resultData.receipt_hed.ChequeNo);
            // $("#rcpbank,#rcpbank1").html(resultData.receipt_hed.BankName);
            $("#rcpchequedate,#rcpchequedate1").html(resultData.receipt_hed.ChequeDate);
            $("#rcppaytype,#rcppaytype1").html(resultData.receipt_hed.payType+" Payment");
        }

        $("#rdPay").prop("disabled", true);
        $('#printArea2').focus().print();

    }


    var dw_pay_amount = 0;
    var dw_due_amount = 0;
    var dw_credit_amount = 0;
    var dw_settle_amount = 0;
    var dw_total_settle = 0;
    var dw_change_amount = 0;
    var dw_isInvoiceColse = 0;
    var dw_over_pay_amount = 0;
    var dw_over_pay_inv = 0;


//Down Payment
    $("#dwnPay").click(function() {
        dw_pay_amount = parseFloat($("#dwn_pay_amount").val());
        var dw_payType = $("#payType2 option:selected").val();
        var dw_chequeDate = $("#dwn_chequeDate").val();
        var dw_chequeReference = $("#dwn_chequeReference").val();
        var dw_chequeReciveDate = $('#dwn_chequeReciveDate').val();
        var dw_chequeNo = $('#dwn_chequeNo').val();
        var dw_payDate = $('#dwn_pay_date').val();
        var dw_invDate = $('#invDate').val();
        var dw_extraAmount = parseFloat($('#dwn_extr_amount').val());
        var dw_InsuranceAmount = parseFloat($('#rd_insu_amount').val());


        if ((acc_no == '' && cusCode == '') || (acc_no == 0 && cusCode == 0)) {
            $.notify("Please select an acount number.", "warning");
            return false;
        } else if (dw_payType == '' || dw_payType == '0') {
            $.notify("Please select a payment method.", "warning");
            return false;
        } else if (dw_pay_amount == '' || dw_pay_amount == '0') {
            $.notify("Please enter the payment amount.", "warning");
            return false;
        } else {
            for (var i = 1; i <= $("#table_dwnPayment tbody tr").length; i++) {
                dw_due_amount = parseFloat(accounting.unformat($("#table_dwnPayment tbody").find("[id='d" + i + "']").children('.DwDueAmount').html()));
                dw_credit_amount = parseFloat(accounting.unformat($("#table_dwnPayment tbody").find("[id='d" + i + "']").children('.dWcreditAmount').html()));
                dw_settle_amount = parseFloat(accounting.unformat($("#table_dwnPayment tbody").find("[id='d" + i + "']").children('.dWsettleAmount').html()));

                if (dw_due_amount <= dw_pay_amount) {
                    var dw_due_amount3 = dw_due_amount;
                    var dw_pay_amount3 = dw_pay_amount;
//alert(dw_due_amount);
                    $("#d" + i + " .dWsettleAmount").attr('dWinvPay', (dw_due_amount));
                    dw_total_settle += dw_due_amount;
                    dw_pay_amount -= dw_due_amount;
                    dw_settle_amount = dw_settle_amount + dw_due_amount;

                    dw_change_amount = 0;
                    dw_due_amount = dw_change_amount;
                    //over payment for last invoice
                    if (i == $("#table_dwnPayment tbody tr").length) {
                        if (dw_due_amount3 < dw_pay_amount3) {
                            var q = confirm('Your Payment greater than the due amount. Do you want to continue this over payment? *Cancel to pay only due amount');
                            if (q === true) {

                                dw_total_settle = dw_pay_amount;
                                dw_settle_amount = dw_settle_amount + dw_pay_amount;

                                dw_over_pay_amount = dw_credit_amount - dw_settle_amount;
                                dw_over_pay_inv = $("#d" + i + " .dWNo").html();
                                dw_change_amount = dw_over_pay_amount;
                                dw_due_amount = dw_change_amount;
                                $("#d" + i + " .dWsettleAmount").attr('dWinvPay', dw_settle_amount);
                            } else {
                                dw_total_settle = dw_due_amount;
                                dw_settle_amount = dw_settle_amount + dw_due_amount;
                                dw_change_amount = 0;
                                dw_due_amount = dw_change_amount;
                            }
                        }
                    }

                } else if (dw_due_amount > dw_pay_amount) {
//                alert(dw_pay_amount);
                    $("#d" + i + " .dWsettleAmount").attr('dWinvPay', (dw_pay_amount));
                    dw_change_amount = dw_due_amount - dw_pay_amount;
                    dw_settle_amount = dw_settle_amount + dw_pay_amount;
                    dw_total_settle += dw_pay_amount;
                    dw_due_amount = dw_change_amount;
                    dw_pay_amount -= dw_due_amount;

                    if (dw_total_settle > dw_pay_amount) {
                        dw_pay_amount = 0;
                    }
                }

                if (dw_settle_amount >= dw_credit_amount) {
                    dw_isInvoiceColse = 1;
                } else {
                    dw_isInvoiceColse = 0;
                }

                if ($("#d" + i + " .dWsettleAmount").attr('dWinvPay') > 0) {
                    $("#d" + i).addClass("rowselected").siblings();
                }

                $("#table_dwnPayment tbody").find("[id='d" + i + "']").children('.DwDueAmount').html(accounting.formatMoney(dw_change_amount));
                $("#table_dwnPayment tbody").find("[id='d" + i + "']").children('.dWsettleAmount').html(accounting.formatMoney(dw_settle_amount));
            }


            var dwNo = new Array();
            var dw_cus_settle_amount = new Array();
            var dw_rental_default = new Array();
            var dw_cus_credit_amount = new Array();
            var dw_cus_inv_payment = new Array();
            var dw_extAmounts = new Array();
            var dw_rowCounts = $("#table_dwnPayment tbody tr").length;

            for (var k = 1; k <= dw_rowCounts; k++) {
                dwNo.push($("#d" + k + " .DwNo").html());  //pushing all the product_code listed in the table
                dw_cus_settle_amount.push(accounting.unformat($("#d" + k + " .dWsettleAmount").html()));   //pushing all the qty listed in the table
                dw_cus_credit_amount.push(accounting.unformat($("#d" + k + " .dWcreditAmount").html()));
                dw_rental_default.push(accounting.unformat($("#d" + k + " .rental_default").html()));
                dw_cus_inv_payment.push(accounting.unformat($("#d" + k + " .dWsettleAmount").attr('dWinvPay')));
                dw_extAmounts.push(accounting.unformat($("#d" + k + " .extAmount").html()));
            }

            var sendMonth = JSON.stringify(dwNo);
            var sendCus_settle_amount = JSON.stringify(dw_cus_settle_amount);
            var sendCus_credit_amount = JSON.stringify(dw_cus_credit_amount);
            var sendCus_inv_payment = JSON.stringify(dw_cus_inv_payment);
            var sendRental_default = JSON.stringify(dw_rental_default);
            var sendExtAmounts = JSON.stringify(dw_extAmounts);
            dw_over_pay_amount = Math.abs(dw_over_pay_amount);
            var dw_pay_amount2 = parseFloat($("#dwn_pay_amount").val());


            $.ajax({
                type: "POST",
                url: "../EasyPayment/downPayment",
                data: {invNo: InvNo, cusCode: cusCode, acc_no: acc_no, invDate: dw_invDate, payAmount: dw_total_settle, payType: dw_payType, rd_extraAmount: dw_extraAmount, rd_InsuranceAmount: dw_InsuranceAmount, chequeReference: dw_chequeReference, chequeRecivedDate: dw_chequeReciveDate, chequeDate: dw_chequeDate, payDate: dw_payDate, settleAmount: dw_settle_amount, isInvoiceColse: dw_isInvoiceColse, chequeNo: dw_chequeNo, month: sendMonth, cus_credit_amount: sendCus_credit_amount, cus_settle_amount: sendCus_settle_amount, total_settle: dw_total_settle, cus_inv_payment: sendCus_inv_payment, rental_default: sendRental_default, over_pay_amount: dw_over_pay_amount, over_pay_inv: dw_over_pay_inv, ExtAmounts: sendExtAmounts},
                success: function(data)
                    {
                        var resultData = JSON.parse(data);
                        var feedback = resultData['fb'];
                        if (feedback != 1){
                            $.notify("Down Payment not saved.", "warning");
                        }
                        else {
                            $.notify("Down Payment successfully saved.", "success");
                            clearDownPaymentDetails();
                            location.reload();
                        }
                    }
            });
        }
    });
    var rid = 0;
    var PayNo = 0;
    // load payment history details
    $('#tbl_payment_history tbody').on('click', 'tr', function() {
        rid = $(this).attr('id');
        pay_amount = $("#payAmount").val();

        $(this).addClass("rowselected").siblings().removeClass("rowselected");

        PayNo = ($("#tbl_payment_history tbody").find("[id='" + rid + "']").children('.ph_PayNo').html());
        $('#tbl_payment_history_dtl tbody').empty();
        $("#tphd_tot_bal").html(accounting.formatMoney(0));
        var tphd_tot_bal = 0;
        $.ajax({
            type: "post",
            url: "../Admin/Controller/Payment.php",
            data: {action: 'getPaymentHistoryDataByPayNo', payNo: PayNo},
            success: function(data) {
                var resultData = JSON.parse(data);
                $.each(resultData, function(key, value) {
                    $("#tbl_payment_history_dtl").append("<tr id='phd" + (key + 1) + "'><td  class='phd_id'>" + (key + 1) + "</td><td class='phd_PayNo'>" + (value.PaymentId) + "</td><td class='text-right'>" + value.InvNo + "</td><td class='text-right'>" + (value.PayTypeName) + "</td><td class='text-right phd_extra'>" + (value.Month) + "</td><td class='text-right'>" + accounting.formatMoney(value.PayAmount) + "</td></tr>");
                    tphd_tot_bal += parseFloat(value.PayAmount);
                    $("#tphd_tot_bal").html(accounting.formatMoney(tphd_tot_bal));
                });
            }
        });

    });
    //load rental payment cheque boxes
    $("#rd_pay_type").change(function() {
        var payType = ($(this).val());

        if (payType == 3) {
            $("#chequeDate").val('');
            $("#chequeReference").val('');
            $('#chequeReciveDate').datepicker().datepicker("setDate", new Date());
            $("#rental_cheque").show();
            $("#load_return").hide();
            $("#payAmount").val(0);
            $("#returnInvoice").val('');
        } else if (payType == 4) {
            $("#load_return").show();
            $("#rental_cheque").val('');
            $("#chequeReference").val('');
            $('#chequeReciveDate').datepicker().datepicker("setDate", new Date());
            $("#rental_cheque").hide();
        } else {
            $("#chequeDate").val('');
            $("#chequeReference").val('');
            $('#chequeReciveDate').datepicker().datepicker("setDate", new Date());
            $("#rental_cheque").hide();
            $("#load_return").hide();
            $("#payAmount").val(0);
            $("#returnInvoice").val('');
        }
    });

    //load down payment cheque boxes
    $("#payType2").change(function() {
        var payType = ($(this).val());

        if (payType == 3) {
            $("#chequeDate").val('');
            $("#chequeReference").val('');
            $('#chequeReciveDate').datepicker().datepicker("setDate", new Date());
            $("#dwn_cheque").show();
            $("#load_return").hide();
            $("#payAmount").val(0);
            $("#returnInvoice").val('');
        } else if (payType == 4) {
            $("#load_return").show();
            $("#dwn_cheque").val('');
            $("#chequeReference").val('');
            $('#chequeReciveDate').datepicker().datepicker("setDate", new Date());
            $("#dwn_cheque").hide();
        } else {
            $("#chequeDate").val('');
            $("#chequeReference").val('');
            $('#chequeReciveDate').datepicker().datepicker("setDate", new Date());
            $("#dwn_cheque").hide();
            $("#load_return").hide();
            $("#payAmount").val(0);
            $("#returnInvoice").val('');
        }
    });

    //print rental schdule
    $("#printRdShedule").click(function() {
        if (acc_no != 0 || acc_no != '') {
            window.location.href = "../EasyPayment/printRSchedule?ac_no=" + acc_no;
        }
    });
    
    $("#printInvoice").click(function() {
        if (acc_no != 0 || acc_no != '') {
    window.location.href = "../EasyPayment/invoicePrint?ac_no=" + acc_no;
        }
    });



    //print payment schdule
    $("#printPayShedule").click(function() {
        if (acc_no != 0 || acc_no != '') {
            // window.location = ("payment-sch-print.php?id=" + acc_no);
            window.location.href = "../EasyPayment/easyPaymentSchedule?ac_no=" + acc_no;

        }
    });

    //change interest terms--------------------------------------------------------------------------
    $("#noOfIntTerm").change(function() {

        $("#term_interest_rate").val($(this).val());
        $("#term_interest_rate2").val($(this).val());
        var rate = $("#term_interest_rate").val();
        var month = $("#noOfIntTerm option:selected").html();
        var check2 = $("input[name='isTermInterest']:checked").val();



        if (check2 == 1) {
            $("#tbl_payment_schedule").show();
            rate = $("#term_interest_rate2").val();
            Interest = calcTotalInterest(totalNetAmount, rate, month);
            paytbl(totalNetAmount, rate, month, totalExtraAmount);
            totalIterest = Interest;
            $("#termInterst").html(accounting.formatMoney(Interest));
            cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount, totalDwnPayment);
        } else {
            rate = 0;
            $("#tbl_payment_schedule").show();
            Interest = calcTotalInterest(totalNetAmount, rate, month);
            paytbl(totalNetAmount, rate, month, totalExtraAmount);
//            $("#tbl_payment_schedule").hide();
            totalIterest = 0;
            $("#termInterst").html(accounting.formatMoney(0));
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
            if (rate == 0) {
                rate = $("#term_interest_rate2").val();
                $("#term_interest_rate").val(rate);
            } else {
                rate = $("#term_interest_rate").val();
            }
            Interest = calcTotalInterest(totalNetAmount, rate, month);
            totalIterest = Interest;
            $("#termInterst").html(accounting.formatMoney(Interest));
            paytbl(totalNetAmount, rate, month, totalExtraAmount);
            cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount, totalDwnPayment);
        } else {
            rate = 0;
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
                    cus_type: 1
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


////--------------------------------------------------------------------------
//    $("#itemCode").autocomplete({
//        source: function(request, response) {
//            $.ajax({
//                url: '../Admin/Controller/Product.php',
//                dataType: "json",
//                data: {
//                    name_startsWith: request.term,
//                    type: 'getActiveProductCodes',
//                    row_num: 1,
//                    action: "getActiveProductCodes",
//                    price_level: price_level
//                },
//                success: function(data) {
//                    response($.map(data, function(item) {
//                        var code = item.split("|");
//                        return {
//                            label: code[0] + " " + code[2] + " - " + code[4] + " ",
//                            value: code[0],
//                            data: item
//                        }
//                    }));
//                }
//            });
//        },
//        autoFocus: true,
//        minLength: 0,
//        select: function(event, ui) {
//            var names = ui.item.data.split("|");
//            $("#sellingPrice").focus();
//            itemCode = names[0];
//
//            $("#ItemCode").val(names[0]);
//            $("#sellingPrice").val(names[3]);
//            $("#batchCode").val(names[2]);
//            $("#productName").html(names[2]);
//            $("#prdName").val(names[2]);
//            $("#remark").val(names[3]);
//            $("#qty").val(names[4]);
//            $("#buyAmount").val(names[5]);
//            $("#isCut").val(names[6]);
//            $("#cutWeight").val(names[7]);
//            $("#isPolish").val(names[8]);
//            $("#polishWeight").val(names[9]);
//            var check_is_cut = (names[6]);
//            var check_is_polish = (names[8]);
//
//            if (check_is_cut == 1) {
//                $("#lbl_cutWeight").show();
//                $("#isCut").prop("checked", true);
//            } else {
//                $("#isCut").prop("checked", false);
//            }
//
//            if (check_is_polish == 1) {
//                $("#lbl_polishWeight").show();
//                $("#isPolish").prop("checked", true);
//            } else {
//                $("#isPolish").prop("checked", false);
//            }
//        }
//    });
//
////--------------------------------------------------------------------------
//    $("#lotNo").autocomplete({
//        source: function(request, response) {
//            $.ajax({
//                url: '../Admin/Controller/Product.php',
//                dataType: "json",
//                data: {
//                    name_startsWith: request.term,
//                    type: 'getActiveLotGems',
//                    row_num: 1,
//                    action: "getActiveLotGems"
//                },
//                success: function(data) {
//                    response($.map(data, function(item) {
//                        var code = item.split("|");
//                        return {
//                            label: code[2] + " " + code[0] + " " + code[1] + " - " + code[4] + " ct",
//                            value: code[0],
//                            data: item
//                        }
//                    }));
//                }
//            });
//        },
//        autoFocus: true,
//        minLength: 0,
//        select: function(event, ui) {
//            var names = ui.item.data.split("|");
//            $("#lotPrice").focus();
//            batchNo = names[2];
//
//            $("#batchCode").val(names[2]);
//            $("#lotNo").val(names[2]);
//
//            var check_is_cut = (names[6]);
//            var check_is_polish = (names[8]);
//            $("#totalNet").prop("disabled", true);
//
//            if (check_is_cut == 1) {
//                $("#lbl_cutWeight").show();
//                $("#isCut").prop("checked", true);
//            } else {
//                $("#isCut").prop("checked", false);
//            }
//
//            if (check_is_polish == 1) {
//                $("#lbl_polishWeight").show();
//                $("#isPolish").prop("checked", true);
//            } else {
//                $("#isPolish").prop("checked", false);
//            }
//
//            $("#tbl_item tbody").html("");
//            $.ajax({
//                type: "POST",
//                url: "../Admin/Controller/Product.php",
//                data: {action: "getActiveGemsByBatchNo", batchNo: batchNo},
//                success: function(data)
//                {
//                    var resultData = JSON.parse(data);
//                    $.each(resultData, function(key, value) {
//                        var sellingPrice = value.PrdCode;
//                        var item_Code = value.ItemCode;
//                        var qty = value.KaratWeight;
//                        var buyAmount = value.BuyAmount;
//                        var totalNet = value.SoldAmount;
//                        var rank = value.PrdRank;
//                        $("#tbl_item tbody").append("<tr ri=" + (key + 1) + " id=" + (key + 1) + "><td>" + (key + 1) + "</td><td class='product_code" + (key + 1) + "'>" + sellingPrice + "</td><td class='item_code" + (key + 1) + "'>" + item_Code + "</td><td class='carat_weight" + (key + 1) + "'>" + accounting.formatNumber(qty) + "</td><td class='guess_amount" + (key + 1) + "'>" + accounting.formatMoney(buyAmount) + "</td><td class='sold_amount" + (key + 1) + "'>" + accounting.formatMoney(totalNet) + "</td><td class='other" + (key + 1) + "' rank='" + rank + "' isBuyW='" + isBuy + "' isCutW='" + isCut + "' isPolishW='" + isPolish + "' cutW='" + cutWeight + "' batchNo='" + batchNo + "' polishW='" + polishWeight + "' remark='" + remark + "' gemOption='" + gemOption + "' itemImages='" + itemImagesArr + "' >" + "" + "</td><td class='rem" + (key + 1) + "'><a href='#' class='remove btn btn-xs btn-danger'>Remove</a></td></tr>");
//                    });
//                }
//            });
//        }
//    });
//
//    discount_precent = parseFloat($("#disPercent").val());
//    discount_amount = parseFloat($("#disAmount").val());
//    discount = $("input[name='discount']:checked").val();
//    discount_type = $("input[name='discount_type']:checked").val();
//
//    $("input[name='discount']").on('ifChanged', function() {
//        var check = ($(this).val());
//
//        if (check == 1) {
//            $("#disAmount").val(0);
//        } else if (check == 2) {
//            $("#disPercent").val(0);
//        }
//    });
//
//    $("input[name='discount_type']").on('ifChanged', function() {
//        var check = ($(this).val());
//
//        if (check == 1) {
//            $("#disAmount").val(0);
//        } else if (check == 2) {
//            $("#disPercent").val(0);
//        }
//    });
//
////----Add products----------------------------------------------------------------------
//    $("#addItem").click(function() {
//
//        var sellingPrice = parseFloat($("#sellingPrice").val());
//        var remark = $("#remark").val();
//        var batchNo = $("#batchCode").val();
//        var prdName = $("#prdName").val();
//        var serialNo = $("#serialNo").val();
//        var priceLevel = $("#priceLevel option:selected").val();
//        var qty = parseFloat($("#qty").val());
//        var polishWeight = parseFloat($("#polishWeight").val());
//        var cutWeight = parseFloat($("#cutWeight").val());
//        var buyAmount = parseFloat($("#buyAmount").val());
//        var rank = $("#rank").val();
//
//        isBuy = $("input[name='isBuy']:checked").val();
//        isCut = $("input[name='isCut']:checked").val();
//        isPolish = $("input[name='isPolish']:checked").val();
//        var itemCodeArrIndex = $.inArray(itemCode, itemcode);
//
//        $("input[name='gemOption[]']:checked").each(function(k) {
//            gemOption[k] = $(this).val();
//        });
//
//        if (itemCode == '') {
//            alert('Please select a item');
//            return false;
//        } else if (sellingPrice == '') {
//            alert('Please enter unit price');
//            return false;
//        } else {
//            if (itemCodeArrIndex < 0) {
//                totalNet2 = (sellingPrice * qty);
//                itemcode.push(itemCode);
//                total_amount2 += totalNet2;
//                $("#totalWithOutDiscount").val(total_amount2);
//
//                calculateProductWiseDiscount(totalNet2, discount, discount_type, discount_precent, discount_amount, total_amount2);
//                cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount, totalDwnPayment);
//                i++;
//                $("#tbl_item tbody").append("<tr ri=" + i + " id=" + i + "><td>" + i + "</td><td class='product_code" + i + "' proCode='" + itemCode + "'>" + prdName + "</td><td class='serial_no" + i + "'>" + serialNo + "</td><td class='qty" + i + "'>" + accounting.formatNumber(qty) + "</td><td class='unit_price" + i + "'>" + accounting.formatNumber(sellingPrice) + "</td><td class='discount_percent" + i + "'>" + discount_precent + "</td><td class='totalNet" + i + "' nonDisTotalNet='" + totalNet2 + "' proDiscount='" + product_discount + "' >" + accounting.formatMoney(totalNet) + "</td><td class='other" + i + "' priceLvl='" + price_level + "' rank='" + rank + "' isBuyW='" + isBuy + "' isCutW='" + isCut + "' isPolishW='" + isPolish + "' cutW='" + cutWeight + "' batchNo='" + batchNo + "' polishW='" + polishWeight + "' remark='" + remark + "' gemOption='" + gemOption + "' itemImages='" + itemImagesArr + "' >" + "" + "</td><td class='rem" + i + "'><a href='#' class='remove btn btn-xs btn-danger'><i class='fa fa-remove'></i></a></td></tr>");
//                clear_gem_data();
//
//            } else {
//                alert("Item already exists");
//                return false;
//            }
//        }
//    });
//
//    $("#disPercent").blur(function() {
//        discount_precent = parseFloat($("#disPercent").val());
//        discount_amount = parseFloat($("#disAmount").val());
//        discount = $("input[name='discount']:checked").val();
//        discount_type = $("input[name='discount_type']:checked").val();
//        var total_amount3 = $("#totalWithOutDiscount").val();
//
//        if (discount_type == 2) {
//            calculateTotalItemWiseDiscount(discount, discount_type, discount_precent, discount_amount, total_amount3);
//
//        }
//        cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount, totalDwnPayment);
//
//    });
//
//    $("#disAmount").blur(function() {
//        discount_precent = parseFloat($("#disPercent").val());
//        discount_amount = parseFloat($("#disAmount").val());
//        discount = $("input[name='discount']:checked").val();
//        discount_type = $("input[name='discount_type']:checked").val();
//        var total_amount3 = $("#totalWithOutDiscount").val();
//        if (discount_type == 2) {
//            calculateTotalItemWiseDiscount(discount, discount_type, discount_precent, discount_amount, total_amount3);
//        }
//        cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount, totalDwnPayment);
//
//    });
//
//    //remove row from grid subtraction total amount and discount--------------------------------------------------------------------------
//    $("#tbl_item").on('click', '.remove', function() {
//        var rid = $(this).parent().parent().attr('ri');
//
//        var r = confirm('Do you want to remove row no ' + rid + ' ?');
//        if (r === true) {
//
//            var totalNets = parseFloat(($("#" + rid + " .totalNet" + rid).attr("nonDisTotalNet")));
//            var proDiscount = parseFloat(($("#" + rid + " .totalNet" + rid).attr("proDiscount")));
//
//            total_amount -= totalNets;
//            total_amount2 -= totalNets;
//            total_discount -= proDiscount;
//
//            $("#totalWithOutDiscount").val(total_amount2);
//            $("#totalAmount").html(accounting.formatMoney(total_amount2));
//
//            cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount, totalDwnPayment);
//            //remove product code from array
//            var removeItem = $(".product_code" + rid).attr("proCode");
//
//            itemcode = jQuery.grep(itemcode, function(value) {
//                return value != removeItem;
//            });
//
//            $(this).parent().parent().remove();
//            return false;
//        }
//        else {
//            return false;
//        }
//    });
//
//    if (chequeAmount > 0) {
//        $("#chequeData").show();
//    } else {
//        $("#chequeData").hide();
//    }
//
//    $("#cashAmount").blur(function() {
//        cashAmount = parseFloat($(this).val());
//        cashAmount = '' ? 0 : cashAmount;
//        returnPayment = parseFloat($("#returnPayment").val());
//        dueAmount = cashAmount + returnPayment - totalNetAmount;
//
//        if (chequeAmount > 0) {
//            chequeAmount = parseFloat($("#chequeAmount").val());
//            dueAmount = cashAmount + chequeAmount + returnPayment - totalNetAmount;
//            $("#chequeAmount").val(chequeAmount);
//            $("#chequeData").show();
//        } else {
//            $("#chequeData").hide();
//        }
//
//        dueAmount = dueAmount.toFixed(2);
//        creditAmount = Math.abs(dueAmount);
//        if (dueAmount >= 0) {
//            $("#dueAmountLable").html("Change Amount  ");
//            $("#dueAmountLable").css({"color": "green", "font-size": "100%"});
//            $("#dueAmount").css({"color": "green", "font-size": "100%"});
//            $("#dueAmountLable2").html("Change Amount  ");
//            $("#dueAmountLable2").css({"color": "green", "font-size": "100%"});
//            $("#dueAmount2").css({"color": "green", "font-size": "100%"});
//            $("#creditAmount").val(0);
//        } else if (dueAmount < 0) {
//            $("#dueAmountLable").html("Credit Amount  ");
//            $("#dueAmountLable").css({"color": "red", "font-size": "100%"});
//            $("#dueAmount").css({"color": "red", "font-size": "100%"});
//            $("#dueAmountLable2").html("Credit Amount  ");
//            $("#dueAmountLable2").css({"color": "red", "font-size": "100%"});
//            $("#dueAmount2").css({"color": "red", "font-size": "100%"});
//            $("#creditAmount").val(creditAmount);
//        }
//        $("#dueAmount").html(dueAmount);
//        $("#dueAmount2").html(dueAmount);
//    });
//
////----------cheque amount----------------------------------------------------------------
//    $("#chequeAmount").blur(function() {
//        chequeAmount = parseFloat($(this).val());
//        cashAmount = parseFloat($('#cashAmount').val());
//        returnPayment = parseFloat($("#returnPayment").val());
//        chequeAmount = '' ? 0 : chequeAmount;
//        dueAmount = cashAmount + chequeAmount + returnPayment - totalNetAmount;
//        dueAmount = dueAmount.toFixed(2);
//
//        if (chequeAmount > 0) {
//            $("#chequeData").show();
//        } else {
//            $("#chequeData").hide();
//        }
//
//        creditAmount = Math.abs(dueAmount);
//        if (dueAmount >= 0) {
//            $("#dueAmountLable").html("Change Amount  ");
//            $("#dueAmountLable").css({"color": "green", "font-size": "100%"});
//            $("#dueAmount").css({"color": "green", "font-size": "100%"});
//            $("#dueAmountLable2").html("Change Amount ");
//            $("#dueAmountLable2").css({"color": "green", "font-size": "100%"});
//            $("#dueAmount2").css({"color": "green", "font-size": "100%"});
//            $("#creditAmount").val(0);
//        } else if (dueAmount < 0) {
//            $("#dueAmountLable").html("Credit Amount  ");
//            $("#dueAmountLable").css({"color": "red", "font-size": "100%"});
//            $("#dueAmount").css({"color": "red", "font-size": "100%"});
//            $("#dueAmountLable2").html("Credit Amount  ");
//            $("#dueAmountLable2").css({"color": "red", "font-size": "100%"});
//            $("#dueAmount2").css({"color": "red", "font-size": "100%"});
//            $("#creditAmount").val(creditAmount);
//        }
//        $("#dueAmount").html(dueAmount);
//        $("#dueAmount2").html(dueAmount);
//    });
//
////------------return Amount-------------------------------------------------------------
//    $("#returnAmount").blur(function() {
//        returnAmount = parseFloat($(this).val());
//        $("#returnPayment").val(returnAmount);
//    });
//
//    $("#returnInvoice").focus(function() {
//        if (cusCode == '' || cusCode == '0') {
//            alert('Please select a customer.');
//            return false;
//        }
//        $("#returnPayment").val(0);
//    });
//
//    $("#refundAmount").blur(function() {
//        refundAmount = parseFloat($(this).val());
//        returnAmount = parseFloat($("#returnAmount").val());
//
//        if (refundAmount > returnAmount) {
//            alert("Refund amount can not be greater than return amount");
//            $("#refundAmount").val(0);
//            return false;
//        }
//        returnAmount -= refundAmount;
//        $("#returnPayment").val(returnAmount);
//    });
//
//    $("#returnPayment").blur(function() {
//        var returnPayment2 = parseFloat($(this).val());
//        returnAmount = parseFloat($("#returnAmount").val());
//
//        if (returnPayment2 > returnAmount) {
//            alert("Return payment can not be greater than return amount");
//            return false;
//        } else {
//
//        }
//
//    });
//
//    $("#lotPrice").blur(function() {
//        lotPrice = parseFloat($(this).val());
//        if ($("input[name='isLot']:checked").val() == 1) {
//            $("#lotPriceLable").show();
//            total_amount = lotPrice;
//            $("#totalAmount").html(accounting.formatMoney(total_amount));
//
//        } else {
//            $("#lotPriceLable").hide();
//            total_amount = total_amount2;
//            $("#totalAmount").html(accounting.formatMoney(total_amount));
//        }
//
//        cal_total(total_amount, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount, totalDwnPayment);
//    });
//
//    $("#downPayment").blur(function() {
//        downPayment = parseFloat($(this).val());
//
//        cal_total(total_amount, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount, totalDwnPayment);
//    });
//
//    $("input[name='isLot']").on('ifChanged', function() {
//
//        if ($("input[name='isLot']:checked").val() == 1) {
//            $("#lotPriceLable").show();
//            $("#lbl_lotNo").show();
//            $("#lbl_refCode").hide();
//            $("#productLable").hide();
//            $("#lotPriceLable").show();
//            $('#easyPay').iCheck('check');
//
//            $.ajax({
//                type: "post",
//                url: "../Admin/Controller/Account.php",
//                data: {action: 'getTermInterestByType', itemType: 2},
//                success: function(data) {
//                    var resultData = JSON.parse(data);
//                    $("#noOfIntTerm").html('');
//                    $("#noOfIntTerm").append("<option value='0'>-Select a term-</option>");
//                    $.each(resultData, function(key, value) {
//                        var charge_type = value.IntTerm;
//                        $("#noOfIntTerm").append("<option value=" + value.Interest + ">" + charge_type + "</option>");
//                    });
//                }
//            });
//
//        } else {
//            $("#productLable").show();
//            $("#lotPriceLable").hide();
//            $("#lbl_lotNo").hide();
//            $("#lbl_refCode").show();
//            $("#totalNet").prop("disabled", false);
//            $('#normalPay').iCheck('check');
//
//            $.ajax({
//                type: "post",
//                url: "../Admin/Controller/Account.php",
//                data: {action: 'getTermInterestByType', itemType: 1},
//                success: function(data) {
//                    var resultData = JSON.parse(data);
//                    $("#noOfIntTerm").html('');
//                    $("#noOfIntTerm").append("<option value='0'>-Select a term-</option>");
//                    $.each(resultData, function(key, value) {
//                        var charge_type = value.IntTerm;
//                        $("#noOfIntTerm").append("<option value=" + value.Interest + ">" + charge_type + "</option>");
//                    });
//                }
//            });
//        }
//    });

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



    var p = 0;
    //add expenses
    var expensesArr = [];
    var total_expenses = 0;
    $("#addExpenses").click(function() {

        var expensesType = $("#expenses_date").val();
        var expensesName = $("#expenses").val();
        var expenseAmount = parseFloat($("#expenses_amount").val());


        if (expenseAmount == '' || expenseAmount == 0) {
            alert('Please enter extra amount.');
            return false;
        } else if (expensesName == '' || expensesName == 0) {
            alert('Please enter extra amount description.');
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

            if (acc_no == '' || acc_no == 0) {

                $("#cusName").prop('disabled', false);
            } else {
                $("#cusName").prop('disabled', true);
            }

//            $("#lbl_cutWeight").show();
        } else if (check == 2) {

            $('#paymentTable').show();
            $('#costTable').hide();
            $('#payView').show();
            $('#dwPaymentTbl').show();
            $('#payment_schedule').show();
            if (acc_no == '' || acc_no == 0) {

                $("#cusName").prop('disabled', true);
            } else {
                $("#cusName").prop('disabled', false);
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
    function cal_total(total, discount, extra, downPay, downPayInt, qurPayInt, totalInt, totalExtra, totalDwnPay) {

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
    var total_dwn_due = 0;
    //calculate total summery
    function cal_Rental_collection_summery(netAmount1, prvPaidAmount1, totalNetAmount1, install1, installAmount1, totDueWRD1, totIntDueAmount1, totalIntTermDue1, totIntPaid1, totIntTermPaid1, totPaid1, totPaidWRD1, totExAmount1) {

//        var total_net2 = parseFloat(total) - parseFloat(discount) + parseFloat(extra) - parseFloat(downPay) + parseFloat(downPayInt) + parseFloat(qurPayInt) + parseFloat(totalExtra) - parseFloat(totalDwnPay);
//        finalAmount = parseFloat(total_net2) + parseFloat(totalInt);
        $("#s_netAmount").html(accounting.formatMoney(netAmount1));
        $("#s_prevPaidAmount").html(accounting.formatMoney(prvPaidAmount1));
        $("#s_totalNetAmount").html(accounting.formatMoney(totalNetAmount1));
        $("#s_installment").html(accounting.formatMoney(install1));
        $("#s_installAmount").html(accounting.formatMoney(installAmount1));
        $("#s_totalDueWRD").html(accounting.formatMoney(totDueWRD1));
        $("#s_installDue").html(accounting.formatMoney(totIntDueAmount1));
        $("#s_installTermDue").html(accounting.formatMoney(totalIntTermDue1));
        $("#s_installPaidAmount").html(accounting.formatMoney(totIntPaid1));
        $("#s_installPaidTerm").html(accounting.formatMoney(totIntTermPaid1));
        $("#s_totalPaid").html(accounting.formatMoney(totPaid1));
        $("#s_totalPaidRD").html(accounting.formatMoney(totPaidWRD1));
        $("#totalExAmount").html(accounting.formatMoney(totExAmount1));
//        alert($("#tot_dwnpay").val());

//        total_discount = discount;
//        total_amount = total;
//        total_amount2 = total;
//        totalNetAmount = total_net2;
    }

    //calculate product wise discount
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
        product_discount = 0;

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

    function clearRentalPaymentDetails() {
        $("#rd_extr_amount").val(0);
        $("#rd_insu_amount").val(0);
        $("#rd_pay_amount").val(0);
        $("#rd_chequeNo").val('');
        $("#rd_chequeDate").val('');
        $("#rd_chequeReference").val('');
        $("#rd_pay_type").val(0);
    }

    function clearDownPaymentDetails() {
        $("#dw_extr_amount").val(0);
        $("#dw_insu_amount").val(0);
        $("#dw_pay_amount").val(0);
        $("#dw_chequeNo").val('');
        $("#dw_chequeDate").val('');
        $("#dw_chequeReference").val('');
        $("#dw_pay_type").val(0);
        dw_pay_amount = 0;
        dw_due_amount = 0;
        dw_credit_amount = 0;
        dw_settle_amount = 0;
        dw_total_settle = 0;
        dw_change_amount = 0;
        dw_isInvoiceColse = 0;
        dw_over_pay_amount = 0;
        dw_over_pay_inv = 0;
    }

    function resetAll() {
        item_ref = 0;
        itemImagesArr.length = 0;
        gemOption.length = 0;
        cusCode = 0;
        invNo = 0;
        batchNo = 0;
        cusType = 2;
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

        $("#table_dwnPayment tbody").empty();
        $("#tbl_payment_schedule tbody").empty();
        $("#table_extPayment tbody").empty();
        $('#tbl_payment_history tbody').empty();
        $('#tbl_payment_history_dtl tbody').empty();

        $("#tot_dwnpay").val(0);
        $("#tot_extr").val(0);

        $("#tph_tot_prin").html(0);
        $("#tph_tot_pay").html(0);
        $("#tph_tot_int").html(0);
        $("#tph_tot_bal").html(0);
        $("#tphd_tot_bal").html(0);

        $("#tps_tot_prin").html(0);
        $("#tps_tot_pay").html(0);
        $("#tps_tot_int").html(0);
        $("#tps_tot_bal").html(0);

        $("#accNo").html('');
        $("#invoiceNo").html('');
        $("#invoiceDate").html('');
//        $("#accNo").html('');
//        $("#accNo").html('');
//        $("#accNo").html('');
//        $("#accNo").html('');
//        $("#accNo").html('');
//        $("#accNo").html('');
//        $("#accNo").html('');
//        $("#accNo").html('');
//        $("#accNo").html('');
//        $("#accNo").html('');
//        $("#accNo").html(''); 
//        
//        $("#accNo").html('');
//        $("#accNo").html('');
//        $("#accNo").html('');
//        $("#accNo").html('');
//        $("#accNo").html('');




        item_ref = 0;
        itemImagesArr.length = 0;
        gemOption.length = 0;
        cusCode = 0;
        invNo = 0;
        batchNo = 0;
        cusType = 2;
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
//        b = 0;
//        num = '';
//        payDate = '';
//        isInrest = 0;
//        interest = 0;
//        dwPayment = 0;
//
//        a = 1;
//        div_index.length = 0;

//        $("#exChargesTbl tbody").html('');
        $("#tbl_payment_schedule tbody").html('');
//        $("#tbl_item tbody").html('');

    }


    function set_date(date) {
//    var today = new Date();
        var dd = date.getDate();
        var mm = date.getMonth() + 1; //January is 0!
        var yyyy = date.getFullYear();


        if (dd < 10) {
            dd = '0' + dd
        }

        if (mm < 10) {
            mm = '0' + mm
        }



        date = yyyy + '-' + mm + '-' + dd;
        return date;
    }

    function afterPayment(acc_no,InvNo) {

        alert(acc_no);
        $.ajax({
            type: "post",
            url: "../Admin/Controller/Payment.php",
            data: {action: 'getRentalPaymentData', accNo: acc_no},
            success: function(data) {
                var resultData = JSON.parse(data);
                // var charge_amount = 0;
                // var total_instal_due = 0;
                var total_ext = 0;
                var due_date = '';
                var monPayment = 0;
                var rentalDefault = 0;
                var total_rdue = 0;
                var rd = 0;
                var rdr = parseFloat($("#rental_rate").val());
                var rdwp = 0;
                var total_rental = 0;
                var dueAmountWithExtra = 0;
                var dueAmountWithRD = 0;
                var rental_bal = 0;
                var settleAmount = 0;
                var today = new Date($("#invDate").val());
                var rental_date = parseFloat($("#excuse_date").val()) + 1;
                today.setDate(today.getDate() - rental_date);
                var dueAmount = 0;
                var dueAmount2 = 0;
                var total_dueAmount = 0;
                var total_rd_paid = 0;
                var bal_amount = 0;
                var pending_date = 0;
                var cuDate = set_date(today);

                checkedAcc.length = 0;
                checkedTerm.length = 0;
                chInvNo.length = 0;
                chDueAmount.length = 0;
                chDueDate.length = 0;
                $("#tbl_payment_schedule tbody").empty();
                $.each(resultData, function(key, value) {

                    due_date = value.PaymentDate;
                    monPayment = (value.MonPayment);
                    settleAmount = parseFloat(value.SettleAmount);

                    total_settle += parseFloat(value.SettleAmount);
                    var paymentDate = new Date(value.PaymentDate);
                    dueAmountWithExtra = parseFloat(value.MonPayment) + parseFloat(value.ExtraAmount);
                    bal_amount = parseFloat(dueAmountWithExtra) + parseFloat(dueAmount2);

                    var days = (paymentDate - today) / (1000 * 60 * 60 * 24);

                    if (days < 0 && (value.IsPaid) == 0 && settleAmount == 0) {
                        rd = (bal_amount) * rdr / 100;
                    } else {
                        rd = 0;
                    }
                    rentalDefault = parseFloat(value.RentalDefault) + parseFloat(rd);

                    dueAmountWithRD = parseFloat(dueAmountWithExtra);
                    total_rdue = dueAmountWithRD;
                    rental_bal += dueAmountWithRD;
//                        alert(dueAmountWithRD);
                    dueAmount = parseFloat(dueAmountWithRD - settleAmount);
                    dueAmount2 = parseFloat(rental_bal - total_settle);
                    total_dueAmount += dueAmount;
                    total_ext += parseFloat(value.ExtraAmount);
                    rdwp = parseFloat(dueAmountWithExtra + rd);

                    // total paid rental default
                    if ((value.IsPaid) == 1) {
                        total_rd_paid += parseFloat(value.RentalDefault);
                    }

                    pending_date = new Date(due_date);
                    var due_yr = pending_date.getFullYear();
                    var due_mn = pending_date.getMonth();

                    var curMn = today.getMonth();
                    var curYr = today.getFullYear();

                    if (due_date < cuDate && due_yr == curYr && due_mn == curMn) {
                        checkedAcc.push(value.AccNo);
                        checkedTerm.push(value.Month);
                        chInvNo.push(value.InvNo);
                        chDueAmount.push(dueAmount2);
                        chDueDate.push(due_date);
                    }

                    // $("#tbl_payment_schedule").append("<tr id='" + (key + 1) + "'><td  class='month'>" + value.Month + "</td><td>" + (due_date) + "</td><td>" + accounting.formatMoney(monPayment) + "</td><td>" + accounting.formatMoney(value.ExtraAmount) + "</td><td>" + accounting.formatMoney(dueAmountWithExtra) + "</td><td class='rental_default'>" + accounting.formatMoney(rentalDefault) + "</td><td class='dueWRD'>" + accounting.formatMoney(dueAmountWithRD) + "</td><td class='text-right creditAmount'>" + accounting.formatMoney(total_rdue) + "</td><td class='text-right rentalAmount'>" + accounting.formatMoney(rental_bal) + "</td><td class='text-right settleAmount' invPay='0'>" + accounting.formatMoney(value.SettleAmount) + "</td><td class='text-right dueAmount' isColse='0'>" + accounting.formatMoney(dueAmount2) + "</td></tr>");
                    $("#tbl_payment_schedule").append("<tr id='" + (key + 1) + "'><td  class='month'>" + value.Month + "</td><td>" + (due_date) + "</td><td>" + accounting.formatMoney(monPayment) + "</td><td>" + accounting.formatMoney(value.ExtraAmount) + "</td><td>" + accounting.formatMoney(dueAmountWithExtra) + "</td><td class='text-right creditAmount'>" + accounting.formatMoney(total_rdue) + "</td><td class='text-right rentalAmount'>" + accounting.formatMoney(rental_bal) + "</td><td class='text-right settleAmount' invPay='0'>" + accounting.formatMoney(value.SettleAmount) + "</td><td class='text-right dueAmount' isColse='0'>" + accounting.formatMoney(dueAmount2) + "</td></tr>");

                    total_instal_due = parseFloat(rental_bal);
                    $("#s_totalDueWRD").html(accounting.formatMoney(total_instal_due));
                    $("#s_installDue").html(accounting.formatMoney(total_instal_due - total_settle));
                    $("#s_totalDueWRD").html(accounting.formatMoney(total_instal_due));
                    $("#tps_tot_pay").html(accounting.formatMoney(rental_bal));
                    $("#tps_tot_prin").html(accounting.formatMoney(rental_bal));
                    $("#tps_tot_int").html(accounting.formatMoney(total_settle));
                    $("#tps_tot_bal").html(accounting.formatMoney(total_dueAmount));
                    var rd_term_due = parseFloat((total_instal_due - total_settle) / InstallAmount);
                    $("#rd_term_due").val(accounting.formatMoney(rd_term_due));
                    $("#s_installTermDue").html(accounting.formatMoney(rd_term_due));
                    $("#s_installPaidAmount").html(accounting.formatMoney(total_settle));
                    var rd_term_paid = parseFloat(total_settle / InstallAmount);
                    $("#s_installPaidTerm").html(accounting.formatMoney(rd_term_paid));
                    $("#totalExAmount").html(accounting.formatMoney(total_ext));
                    $("#s_totalPaidRD").html(accounting.formatMoney(total_rd_paid));

                    total_rd_due = parseFloat(total_instal_due) - parseFloat(total_settle) + parseFloat($("#rd_extr_amount").val()) + parseFloat($("#rd_insu_amount").val());
                    $("#rd_tot_due_amount").val(accounting.formatMoney(total_rd_due));
                });
            }
        });

//load down payments
        $.ajax({
            type: "post",
            url: "../Admin/Controller/Payment.php",
            data: {action: 'getDownPaymentData', InvNo: InvNo},
            success: function(data) {
                try {
                    var today = new Date($("#invDate").val());
                    var rental_date = parseFloat($("#excuse_date").val()) + 1;
                    var rdr = parseFloat($("#rental_rate").val());
                    var dWrd = 0;
                    today.setDate(today.getDate() - rental_date);
                    var total_due = 0;
                    var total_dwn = 0;
                    var dwnDueAmount = 0;
                    var resultData = JSON.parse(data);
                    $("#table_dwnPayment tbody").empty();
                    var rentaldefault = 0;
                    $.each(resultData, function (key, value) {
                        var paymentDate = new Date(value.PaymentDate);
                        var days = (paymentDate - today) / (1000 * 60 * 60 * 24);

                        if (days < 0) {
                            rentaldefault = parseFloat((value.DownPayment) * rdr / 100);
                        } else {
                            rentaldefault = 0;
                        }
                        dWrd = parseFloat(value.RentalDefault) + parseFloat(rentaldefault);

                        total_due = dWrd + parseFloat(value.DownPayment);
                        dwnDueAmount = total_due - parseFloat(value.SettleAmount);
                        $("#table_dwnPayment tbody").append("<tr  id='d" + (key + 1) + "'><td>" + (key + 1) + "</td><td class='DwNo'>" + (value.DwPayType) + "</td><td class='dwInvNo'>" + (InvNo) + "</td><td class='dwPayDate'>" + (value.PaymentDate) + "</td><td>" + accounting.formatMoney(value.DownPayment) + "</td><td class='dWrentalDefault'>" + accounting.formatMoney(dWrd) + "</td><td class='dWcreditAmount'>" + accounting.formatMoney(total_due) + "</td><td class='text-right dWsettleAmount' dWinvPay='0'>" + accounting.formatMoney(value.SettleAmount) + "</td><td class='DwDueAmount'>" + accounting.formatMoney(dwnDueAmount) + "</td></tr>");
                        total_dwn += dwnDueAmount;
                    });

                    $("#tot_dwnpay").val(total_dwn);
                    var total_dwn_dues = parseFloat($("#tot_extr").val()) + parseFloat(total_dwn);
                    $("#dwn_due_amount").val(accounting.formatMoney(total_dwn_dues));
                    var tda = parseFloat(total_dwn_dues) + parseFloat($("#dwn_extr_amount").val());
                    $("#tot_due_amount").val(accounting.formatMoney(tda));
                }catch (e){

                }
            }
        });
        var total_extra = 0;
        // load Extra amounts
        $.ajax({
            type: "post",
            url: "../Admin/Controller/Payment.php",
            data: {action: 'getRentalExtraAmount', InvNo: InvNo},
            success: function(data) {
                try {
                    var today = new Date($("#invDate").val());
                    var rental_date = parseFloat($("#excuse_date").val()) + 1;
                    var rdr = parseFloat($("#rental_rate").val());
                    today.setDate(today.getDate() - rental_date);
                    var total_due = 0;
                    var resultData = JSON.parse(data);
                    $("#table_extPayment tbody").empty();
                    var rentaldefault = 0;
                    $.each(resultData, function(key, value) {
                        var paymentDate = new Date(value.PayDate);
                        var days = (paymentDate - today) / (1000 * 60 * 60 * 24);

                        if (days < 0) {
                            rentaldefault = parseFloat((value.ExtraAmount) * rdr / 100);
                        } else {
                            rentaldefault = 0;
                        }
                        total_due = rentaldefault + parseFloat(value.ExtraAmount);
                        $("#table_extPayment tbody").append("<tr><td>" + (key + 1) + "</td><td>" + (InvNo) + "</td><td>" + (value.PayDesc) + "</td><td>" + (value.PayDate) + "</td><td class='extAmount'>" + accounting.formatMoney(value.ExtraAmount) + "</td><td>" + accounting.formatMoney(rentaldefault) + "</td><td>" + accounting.formatMoney(total_due) + "</td></tr>");
                        total_extra += total_due;
                    });
                    $("#tot_extr").html(accounting.formatMoney(total_extra));
                    total_dwn_due = parseFloat($("#tot_dwnpay").val());
                    $("#dwn_due_amount").val(accounting.formatMoney(total_dwn_due));
                    var tda = parseFloat(total_dwn_due);
                    $("#tot_due_amount").val(accounting.formatMoney(tda));

                } catch (e) {

                }
            }
        });

        $('#tbl_payment_history tbody').empty();

        var totps_paid = 0;
        var totps_exAmount = 0;
        var totps_insAmount = 0;
        var totps_dueAmount = 0;
        var totalps_due = 0;
        $.ajax({
            type: "post",
            url: "../Admin/Controller/Payment.php",
            data: {action: 'getPaymentDataByAccNo', accNo: InvNo},
            success: function(data) {
                try {
                    var resultData = JSON.parse(data);
                    var cheque_date = '';
                    $.each(resultData, function (key, value) {
                        totalps_due = parseFloat(value.PayAmount) + parseFloat(value.ExtraAmount) + parseFloat(value.InsuranceAmount);
                        if (value.ChequeDate == '0000-00-00') {
                            cheque_date = '-';
                        } else {
                            cheque_date = value.ChequeDate;
                        }
                        $("#tbl_payment_history").append("<tr id='ph" + (key + 1) + "'><td  class='ph_id'>" + (key + 1) + "</td><td class='ph_PayNo'>" + (value.PaymentId) + "</td><td class='text-right'>" + value.PayDate + "</td><td class='text-right'>" + (value.PayTypeName) + "</td><td class='text-right'>" + accounting.formatMoney(value.PayAmount) + "</td><td class='text-right ph_extra'>" + accounting.formatMoney(value.ExtraAmount) + "</td><td class='text-right ph_InsuAmount'>" + accounting.formatMoney(value.InsuranceAmount) + "</td><td class='text-right ph_iddueAmount' isColse='0'>" + accounting.formatMoney(totalps_due) + "</td><td class='text-right ph_idcreditAmount'>" + cheque_date + "</td><td class='text-right ph_idrentalAmount'>" + (value.ChequeNo) + "</td><td class='text-right ph_idsettleAmount' invPay='0'>" + (value.ChequeReference) + "</td></tr>");
                        totps_paid += parseFloat(value.PayAmount);
                        totps_exAmount += parseFloat(value.ExtraAmount);
                        totps_insAmount += parseFloat(value.InsuranceAmount);
                        totps_dueAmount += parseFloat(totalps_due);

                        $("#tph_tot_prin").html(accounting.formatMoney(totps_paid));
                        $("#tph_tot_pay").html(accounting.formatMoney(totps_exAmount));
                        $("#tph_tot_int").html(accounting.formatMoney(totps_insAmount));
                        $("#tph_tot_bal").html(accounting.formatMoney(totps_dueAmount));
                    });
                } catch (e) {

                }
            }
        });


//         alert($("#tot_extr").val());

        cal_Rental_collection_summery(FinalAmount, 0, FinalAmount, InterestTerm, InstallAmount, total_instal_due, total_instal_due, 0, total_settle, 0, 0, 0, 0);

    }

    function nl2br (str, is_xhtml) {
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }

});

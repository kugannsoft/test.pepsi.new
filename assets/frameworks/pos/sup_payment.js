$(document).ready(function() {
    $('#invDate,#chequeReciveDate,#chequeDate').datetimepicker({ dateFormat: 'yy-mm-dd', timeFormat: "HH:mm:ss" });
    $('#invDate,#chequeReciveDate').datetimepicker().datetimepicker("setDate", new Date());


    $("#cusImage").hide();
    $("#lotPriceLable").hide();
    $('#costTable').hide();

    $("#lbl_polishWeight").hide();
    $("#lbl_buyAmount").hide();
    $("#lbl_cutWeight").hide();
    $("#chequeData").hide();
    $("#load_return").hide();
    $("#returnPayment").hide();

$('.prd_icheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '50%'
    });

    var item_ref = 0;
    var itemImagesArr = [];
    var gemOption = [];
    var SupCode = 0;
    var paymentNo = 0;
    var cusType = 2;

    var outstanding = 0;
    var available_balance = 0;
    var total_due_amount = 0;
    var total_over_payment = 0;
    
    var customer_name = '';

    $("#CustType").change(function() {
        $("#customer").val('');
        $("#tbl_payment tbody").html("");
    });

    //customer autoload
    $("#customer").autocomplete({
        source: function(request, response) {
            cusType = $("#CustType option:selected").val();

            $.ajax({
                url: 'loadsuppliersjson',
                dataType: "json",
                data: {
                    q: request.term
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
            SupCode = ui.item.value;
            $("#tbl_payment tbody").html("");
            total_due_amount = 0;
            total_over_payment = 0;

            $.ajax({
                type: "POST",
                url: "../../admin/Payment/getSuppliersDataById",
                data: { supCode: SupCode},
                success: function(data)
                {
                    var resultData = JSON.parse(data);

                    SupCode = resultData.sup_data.SupCode;
                    outstanding = resultData.sup_data.SupOustandingAmount;
                    available_balance = parseFloat(resultData.sup_data.CreditLimit) - parseFloat(outstanding);
                    customer_name=resultData.sup_data.SupName;
                    $("#cusCode,#cusname").html(resultData.sup_data.SupName);
                    $("#customer").val(resultData.sup_data.SupCode);
                    $("#creditLimit").html(accounting.formatMoney(resultData.sup_data.CreditLimit));
                    $("#creditPeriod").html(resultData.sup_data.CreditPeriod);
                    $("#cusOutstand").html(accounting.formatMoney(outstanding));
                    $("#availableCreditLimit").html(accounting.formatMoney(available_balance));
                    $("#city").html(resultData.sup_data.MobileNo);


                    var creditAmount = 0;
                    var settleAmount = 0;
                    $.each(resultData.credit_data, function(key, value) {

                        var paymentNo = value.GRNNo;
                        var invDate = value.GRNDate;
                        var totalNetAmount = value.NetAmount;
                        var creditAmount = value.CreditAmount;
                        var settleAmount = value.SettledAmount;
                        var customerPayment = value.payAmount;
                        var dueAmount = 0;
                        total_due_amount += (creditAmount - settleAmount);

                        $("#tbl_payment tbody").append("<tr id='" + (key + 1) + "'><td>" + (key + 1) + "</td><td  class='invoiceNo'>" + paymentNo + "</td><td>" + invDate + "</td><td class='text-right'>" + accounting.formatMoney(totalNetAmount) + "</td><td class='text-right creditAmount'>" + accounting.formatMoney(creditAmount) + "</td><td class='text-right settleAmount' invPay='0'>" + accounting.formatMoney(settleAmount) + "</td><td class='text-right dueAmount' isColse='0'>" + accounting.formatMoney(creditAmount - settleAmount) + "</td><td></td></tr>");

                    });
                    $("#tbl_payment").dataTable().fnDestroy();
                }
            });


        }
    });

    $("#bank").select2({
        placeholder: "Select a bank",
        allowClear: true,
        ajax: {
            url: "loadbankjson",
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

//    if(SupCode!='' || SupCode!='0'){
    $("#returnInvoice").autocomplete({
        source: function(request, response) {

            $.ajax({
                url: '.../../admin/Payment/getSuppliersDataById',
                dataType: "json",
                data: {
                    name_startsWith: request.term,
                    type: 'getActiveReturnInvoicesByCustomer',
                    row_num: 1,
                    action: "getActiveReturnInvoicesByCustomer",
                    cus_code: SupCode
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
//            $("#SupCode").html(names[1]);
            $("#payAmount").val(names[1] - names[2]);
            pay_amount = names[1] - names[2];
            $("#returnPayment").show();
            $("#returnPayment").html(accounting.formatMoney(names[1] - names[2]));

        }
    });

    var settleAmount = 0;
    var total_due = 0;
    var pay_amount = 0;
    var due_amount = 0;
    var credit_amount = 0;
    var settle_amount = 0;
    var invoiceNo = 0;
    var rid = 0;
    var outstanding = 0;
    var available_balance = 0;
    var isInvoiceColse = 0;
    var total_settle = 0;
    var disPrint = 1;
    var bank = 0;
    var bank_name = '';

    $('#tbl_payment tbody').on('click', 'tr', function() {
        rid = $(this).attr('id');
        pay_amount = $("#payAmount").val();

        $(this).addClass("rowselected").siblings().removeClass("rowselected");

        due_amount = parseFloat(accounting.unformat($("#tbl_payment tbody").find("[id='" + rid + "']").children('.dueAmount').html()));
        credit_amount = parseFloat(accounting.unformat($("#tbl_payment tbody").find("[id='" + rid + "']").children('.creditAmount').html()));
        settle_amount = parseFloat(accounting.unformat($("#tbl_payment tbody").find("[id='" + rid + "']").children('.settleAmount').html()));
        invoiceNo = $("#tbl_payment tbody").find("[id='" + rid + "']").children('.invoiceNo').html();
        $("#payAmount").focus();

    });

    $("#payType").change(function() {
        var payType = ($(this).val());

        if (payType == 3) {
            $("#chequeDate").val('');
            $("#chequeReference").val('');
            $('#chequeReciveDate').datetimepicker({ dateFormat: 'yy-mm-dd', timeFormat: "HH:mm:ss" });
            $("#chequeData").show();
            $("#load_return").hide();
            $("#payAmount").val(0);
            $("#returnInvoice").val('');
        } else if (payType == 4) {
            $("#load_return").show();
            $("#chequeDate").val('');
            $("#chequeReference").val('');
            $('#chequeReciveDate').datetimepicker({ dateFormat: 'yy-mm-dd', timeFormat: "HH:mm:ss" });
            $("#chequeData").hide();
        } else {
            $("#chequeDate").val('');
            $("#chequeReference").val('');
            $('#chequeReciveDate').datetimepicker({ dateFormat: 'yy-mm-dd', timeFormat: "HH:mm:ss" });
            $("#chequeData").hide();
            $("#load_return").hide();
            $("#payAmount").val(0);
            $("#returnInvoice").val('');
        }
    });

    $("#payAmount").blur(function() {
        pay_amount = parseFloat($("#payAmount").val());
    });

$("input[name='disablePrint']").on('ifChanged', function() {
        disPrint = $("input[name='disablePrint']:checked").val();
    });
    
     $("#bank").change(function() {
            bank = $("#bank option:selected").val();
            bank_name =$("#bank option:selected").html();
        });
    
    $("#pay").click(function() {

        var payType = $("#payType option:selected").val();
        var payDate = $("#invDate").val();
        var chequeDate = $("#chequeDate").val();
        var chequeReference = $("#chequeReference").val();
        var chequeReciveDate = $('#chequeReciveDate').val();
        var chequeNo = $('#chequeNo').val();
        var auto_payment = $("input[name=payAuto]:checked").val();
        var location = $("#invlocation").val();
        var invUser = $("#invUser").val();
        var remark = $("#remark").val();
        var change_amount = 0;
        var pay_amount2 = 0;
        var over_pay_amount = 0;
        var over_pay_inv = '';
       
         
       
        //pay autometically
        if (auto_payment == 1) {
            if (pay_amount == 0) {
                $("#errPayment").show();
                $("#errPayment").html('Please enter pay amount.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                return false;
            } else {

                var r = confirm('Do you want to pay automatically?');
                if (r === true) {

                    for (var i = 1; i <= $("#tbl_payment tbody tr").length; i++) {
                        due_amount = parseFloat(accounting.unformat($("#tbl_payment tbody").find("[id='" + i + "']").children('.dueAmount').html()));
                        credit_amount = parseFloat(accounting.unformat($("#tbl_payment tbody").find("[id='" + i + "']").children('.creditAmount').html()));
                        settle_amount = parseFloat(accounting.unformat($("#tbl_payment tbody").find("[id='" + i + "']").children('.settleAmount').html()));

                        if (due_amount <= pay_amount) {
                            var due_amount3 = due_amount;
                            var pay_amount3 = pay_amount;

                            $("#" + i + " .settleAmount").attr('invPay', (due_amount));
                            total_settle += due_amount;
                            pay_amount -= due_amount;
                            settle_amount = settle_amount + due_amount;

                            change_amount = 0;
                            due_amount = change_amount;
                            //over payment for last invoice
                            if (i == $("#tbl_payment tbody tr").length) {
                                if (due_amount3 < pay_amount3) {
                                    var q = confirm('Your Payment greater than the due amount. Do you want to continue this over payment? *Cancel to pay only due amount');
                                    if (q === true) {

                                        total_settle = pay_amount;
                                        settle_amount = settle_amount + pay_amount;

                                        over_pay_amount = credit_amount - settle_amount;
                                        over_pay_inv = $("#" + i + " .invoiceNo").html();
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

                        $("#tbl_payment tbody").find("[id='" + i + "']").children('.dueAmount').html(accounting.formatMoney(change_amount));
                        $("#tbl_payment tbody").find("[id='" + i + "']").children('.settleAmount').html(accounting.formatMoney(settle_amount));
                    }

                    pay_amount2 = parseFloat($("#payAmount").val());
                    if (total_settle < pay_amount2) {
                        total_settle = pay_amount2;
                    }
//                    $("#payAmount").val(0);
                    $("#totalPayment").html(accounting.formatMoney(total_settle));

                    var credit_invoice = new Array();
                    var cus_settle_amount = new Array();
                    var cus_credit_amount = new Array();
                    var cus_inv_payment = new Array();
                    var rowCounts = $("#tbl_payment tbody tr").length;

                    for (var k = 1; k <= rowCounts; k++) {
                        credit_invoice.push($("#" + k + " .invoiceNo").html());  //pushing all the product_code listed in the table
                        cus_settle_amount.push(accounting.unformat($("#" + k + " .settleAmount").html()));   //pushing all the qty listed in the table
                        cus_credit_amount.push(accounting.unformat($("#" + k + " .creditAmount").html()));
                        cus_inv_payment.push(accounting.unformat($("#" + k + " .settleAmount").attr('invPay')));
                    }

                    var sendCredit_invoice = JSON.stringify(credit_invoice);
                    var sendCus_settle_amount = JSON.stringify(cus_settle_amount);
                    var sendCus_credit_amount = JSON.stringify(cus_credit_amount);
                    var sendCus_inv_payment = JSON.stringify(cus_inv_payment);
                    over_pay_amount = Math.abs(over_pay_amount);
                    
                    $("#pay").attr('disabled', true);
                    $.ajax({
                        type: "POST",
                        url: "../../admin/Payment/supplierPayment",
                        data: {paymentNo: paymentNo, location: location, remark: remark, invUser: invUser, invNo: invoiceNo, SupCode: SupCode,outstanding:outstanding, payAmount: pay_amount2, payType: payType, bank: bank, chequeReference: chequeReference, chequeRecivedDate: chequeReciveDate, chequeDate: chequeDate, payDate: payDate, settleAmount: settle_amount, isInvoiceColse: isInvoiceColse, chequeNo: chequeNo, credit_invoice: sendCredit_invoice, cus_credit_amount: sendCus_credit_amount, cus_settle_amount: sendCus_settle_amount, total_settle: total_settle, cus_inv_payment: sendCus_inv_payment, over_pay_amount: over_pay_amount, over_pay_inv: over_pay_inv},
                        success: function(data)
                        {
                            var resultData = JSON.parse(data);
                            var feedback = resultData['fb'];
                            var invNumber = resultData['InvNo'];
                            var invoicedate = resultData['InvDate'];
                            if (feedback == 1) {
                                $("#reset").attr('disabled', false);
                                $("#errPayment").show();
                                $("#errPayment").html('Payment successfully saved.').addClass('alert alert-success alert-dismissible alert-sm').delay(1500).fadeOut(600);
                                outstanding = outstanding - total_settle;
                                invoicePrint(invNumber,invoicedate,'invfname',total_settle,disPrint,payType,chequeDate,chequeNo,bank_name);
                                rid = 0;
                                invoiceNo = 0;
                                
                                outstanding = outstanding - total_settle;
                                available_balance = parseFloat(available_balance) + total_settle;

                                $("#cusOutstand").html(accounting.formatMoney(outstanding));
                                $("#total_due").html(accounting.formatMoney(outstanding));

                                $("#availableCreditLimit").html(accounting.formatMoney(available_balance));
                                $("#chequeData").hide();
                                clearPaymentDetails();
                                total_settle = 0;
                                $("#pay").attr('disabled', false);
                            }
                            else {
                                $("#errPayment").show();
                                $("#errPayment").html('Payment not saved.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                                return false;
                            }
                        }
                    });
                }
                else {
                    return false;
                }
            }
        } else if (auto_payment == 2) {
            //pay manually
            if (invoiceNo == 0) {
                $("#errPayment").show();
                $("#errPayment").html('Please select an invoice.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                return false; 
            } else if (rid == 0) {
                $("#errPayment").show();
                $("#errPayment").html('Please select an invoice.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                return false; 
            } else if (pay_amount == 0) {
                $("#errPayment").show();
                $("#errPayment").html('Please enter pay amount.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                return false;
            } else {
                var r = confirm('Do you want to pay manually?');
                if (r === true) {
                    if (due_amount <= pay_amount) {
                        var q = confirm('Do you want to pay from full amount?');
                        if (q === true) {
                            total_settle = pay_amount;
                            settle_amount = settle_amount + pay_amount;

                            over_pay_amount = credit_amount - settle_amount;
                            over_pay_inv = invoiceNo;
                            change_amount = over_pay_amount;
                            due_amount = change_amount;

                        } else {
                            total_settle = due_amount;
                            settle_amount = settle_amount + due_amount;
                            change_amount = 0;
                            due_amount = change_amount;
                        }

                    } else if (due_amount > pay_amount) {
                        total_settle = pay_amount;
                        change_amount = due_amount - pay_amount;
                        settle_amount = settle_amount + pay_amount;
                        due_amount = change_amount;
                    }

                    if (settle_amount >= credit_amount) {
                        isInvoiceColse = 1;
                    } else {
                        isInvoiceColse = 0;
                    }

                    $("#" + rid + " .settleAmount").attr('invPay', (total_settle));

                    $("#tbl_payment tbody").find("[id='" + rid + "']").children('.dueAmount').html(accounting.formatMoney(change_amount));
                    $("#tbl_payment tbody").find("[id='" + rid + "']").children('.settleAmount').html(accounting.formatMoney(settle_amount));
                    $("#payAmount").val(0);
                    $("#totalPayment").html(accounting.formatMoney(total_settle));

                    var credit_invoice = new Array();
                    var cus_settle_amount = new Array();
                    var cus_credit_amount = new Array();
                    var cus_inv_payment = new Array();
                    var rowCounts = $("#tbl_payment tbody tr").length;
                    var k = rid;

                    credit_invoice.push($("#" + k + " .invoiceNo").html());  //pushing all the product_code listed in the table
                    cus_settle_amount.push(accounting.unformat($("#" + k + " .settleAmount").html()));   //pushing all the qty listed in the table
                    cus_credit_amount.push(accounting.unformat($("#" + k + " .creditAmount").html()));
                    cus_inv_payment.push(accounting.unformat($("#" + k + " .settleAmount").attr('invPay')));

                    var sendCredit_invoice = JSON.stringify(credit_invoice);
                    var sendCus_settle_amount = JSON.stringify(cus_settle_amount);
                    var sendCus_credit_amount = JSON.stringify(cus_credit_amount);
                    var sendCus_inv_payment = JSON.stringify(cus_inv_payment);

                    over_pay_amount = Math.abs(over_pay_amount);
                    $("#pay").attr('disabled', true);
                    $.ajax({
                        type: "POST",
                        url: "../../admin/Payment/supplierPayment",
                        data: {paymentNo: paymentNo, location: location, remark: remark, invUser: invUser, invNo: invoiceNo, SupCode: SupCode,outstanding:outstanding, payAmount: pay_amount, payType: payType, bank: bank, chequeReference: chequeReference, chequeRecivedDate: chequeReciveDate, chequeDate: chequeDate, payDate: payDate, settleAmount: settle_amount, isInvoiceColse: isInvoiceColse, chequeNo: chequeNo, credit_invoice: sendCredit_invoice, cus_credit_amount: sendCus_credit_amount, cus_settle_amount: sendCus_settle_amount, total_settle: total_settle, cus_inv_payment: sendCus_inv_payment, over_pay_amount: over_pay_amount, over_pay_inv: over_pay_inv},
                        success: function(data)
                        {
                            var resultData = JSON.parse(data);
                            var feedback = resultData['fb'];
                            var invNumber = resultData['InvNo'];
                            var invoicedate = resultData['InvDate'];
                            if (feedback == 1) {
                                $("#reset").attr('disabled', false);
                                $("#errPayment").show();
                                $("#errPayment").html('Payment successfully saved.').addClass('alert alert-success alert-dismissible alert-sm').delay(1500).fadeOut(600);
                                outstanding = outstanding - total_settle;
                                available_balance = parseFloat(available_balance) + total_settle;
                                invoicePrint(invNumber,invoicedate,'invfname',total_settle,disPrint,payType,chequeDate,chequeNo,bank_name);

                                rid = 0;
                                invoiceNo = 0;
                                clearPaymentDetails();

                                $("#cusOutstand").html(accounting.formatMoney(outstanding));
                                $("#total_due").html(accounting.formatMoney(outstanding));
                                $("#availableCreditLimit").html(accounting.formatMoney(available_balance));
                                $("#chequeData").hide();
                                total_settle = 0;
                                $("#pay").attr('disabled', false);
                                
//                            location.reload();
                            }
                            else {
                                $("#errPayment").show();
                                $("#errPayment").html('Payment not saved.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                                return false;
                            }
                        }
                    });

                } else {
                    return false;
                }
            }
        }

    });
    
    $("#reset").click(function(){
        location.reload();
        $("#customer_id").focus();
    });

    function clearPaymentDetails() {
        $("#payAmount").val('');
        $("#payType").val(1);
        $("#chequeNo").val('');
        $("#chequeDate").val('');
        $("#chequeReference").val('');
        $("#tbl_payment tbody tr").removeClass('rowselected');
    }



    function clear_data_after_save() {
        $("input[name=isLot][value='0']").prop('checked', true);
        getLastBatchNo();
        $('#tbl_item tbody').html("");
        $('#table_expenses tbody').html("");
        $("#SupCode").html("");
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

    function invoicePrint(invNumber,invoicedate,invfname,total,disPrint,payType,chq_date,chq_no,bank_name){
        $("#tblData tbody").html('');
                        if(payType==1){
                           $("#tblData tbody").append("<tr><td colspan='3' style='border-left:#000 solid 1px;font-size:10px;border-right:#000 solid 1px;'>" + 'Cash' + "</td><td style='text-align:right;border-right:#000 solid 1px;'>" + accounting.formatMoney(total) + "</td></tr>");
                        }else if(payType==3){
                            $("#tblData tbody").append("<tr><td style='border-left:#000 solid 1px;font-size:10px;border-right:#000 solid 1px;'>" + chq_date + "</td><td style='border-right:#000 solid 1px;text-align:left;'>" + chq_no + "</td><td style='border-right:#000 solid 1px;text-align:left;'>" + bank_name + "</td><td style='text-align:right;border-right:#000 solid 1px;'>" + accounting.formatMoney(total) + "</td></tr>");
                        }

                        $("#invNumber").html(invNumber);
                        $("#invoiceDate").html(invoicedate);
                        $("#cusname").html(customer_name);
                        $("#outstand").html(accounting.formatMoney(outstanding));
                        $("#invTotal").html(accounting.formatMoney(total));
                        
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
    }
});

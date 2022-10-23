$(document).ready(function() {
    $('#invDate,#chequeReciveDate,#chequeDate').datetimepicker({ dateFormat: 'yy-mm-dd', timeFormat: "HH:mm:ss" });
    $('#invDate').datetimepicker().datetimepicker("setDate", new Date());

    $("#cusImage").hide();
    $("#lotPriceLable").hide();
    $('#costTable').hide();

    $("#lbl_polishWeight").hide();
    $("#lbl_buyAmount").hide();
    $("#lbl_cutWeight").hide();
    $("#chequeData").hide();
    $("#bankData").hide();
    $("#advanceData").hide();
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
    var cusCode = 0;
    var paymentNo = 0;
    var cusType = 2;
    var loc= $("#invlocation").val();

    var outstanding = 0;
    var available_balance = 0;
    var total_due_amount = 0;
    var total_over_payment = 0;

    var customer_name = '';
    var receiptType=0;
    var advance_payment_no='';
    var advance_amount=0;
    var return_payment_no='';
    var return_amount=0;


    $("#CustType").change(function() {
        $("#customer").val('');
        $("#tbl_payment tbody").html("");
    });
    cusCode =$("#customer").val();

    if(cusCode!=''){
        loadCustomerDatabyId(cusCode);
    }

    $("#advanceno").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../salesinvoice/loadadvancepaymentjson',
                dataType: "json",
                data: {
                    q: request.term,
                    cusCode:cusCode,
                    loc:loc
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
            advance_payment_no='';
            advance_amount = 0;
            advance_payment_no = ui.item.value;
            $("#payAmount").val(0);
            pay_amount=0;
            loadAdvanceData(advance_payment_no);
        }
    });

function loadAdvanceData(pay_no){
        $.ajax({
            type: "POST",
            url: "../Salesinvoice/getadvancepaymentbyid",
            data: { payid: pay_no },
            success: function(data) {
                var resultData = JSON.parse(data);

                if (resultData.advance){
                    advance_amount = parseFloat(resultData.advance.TotalPayment);
                    advance_payment_no = resultData.advance.CusPayNo;
                    pay_amount = parseFloat(advance_amount);
                    $("#payAmount").val(advance_amount);
                    //addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount);
                }
            }
        });
    }

    $("#returnInvoice").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../salesinvoice/loadreturnpaymentjson',
                dataType: "json",
                data: {
                    q: request.term,
                    cusCode:cusCode,
                    loc:loc
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
            return_payment_no='';
            return_amount = 0;
            return_payment_no = ui.item.value;
            $("#payAmount").val(0);
            pay_amount=0;
            loadReturnData(return_payment_no);
        }
    });

    function loadReturnData(pay_no){
        $.ajax({
            type: "POST",
            url: "../Salesinvoice/getreturnpaymentbyid",
            data: { payid: pay_no },
            success: function(data) {
                var resultData = JSON.parse(data);

                if (resultData.return){
                    return_amount = parseFloat(resultData.return.ReturnAmount);
                    return_payment_no = resultData.return.ReturnNo;
                    pay_amount = parseFloat(return_amount);
                    $("#payAmount").val(return_amount);
                    // addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount,return_amount);
                }
            }
        });
    }

    function loadCustomerDatabyId(cuscode){
        $("#tbl_payment tbody").html("");
            total_due_amount = 0;
            total_over_payment = 0;

            $.ajax({
                type: "POST",
                url: "../../admin/Payment/getCustomersDataById",
                data: { cusCode: cuscode},
                success: function(data)
                {
                    var resultData = JSON.parse(data);
                    var returnComplete = 0;

                    if (resultData.over_return__complete_payments === null) {
                        returnComplete = 0.00;
                    } else {
                        returnComplete = resultData.over_return__complete_payments;
                    }

                    cusCode = resultData.cus_data.CusCode;
                    outstanding = parseFloat(resultData.total_credit) - parseFloat(resultData.total_payment) - parseFloat(resultData.return_payment) + parseFloat(returnComplete);
                    available_balance = parseFloat(resultData.cus_data.CreditLimit) - parseFloat(outstanding);
                    customer_name=resultData.cus_data.CusName;
                    $("#cusCode").html(resultData.cus_data.CusName);
                    $("#customer").val(resultData.cus_data.CusCode);
                    $("#creditLimit").html(accounting.formatMoney(resultData.cus_data.CreditLimit));
                    $("#creditPeriod").html(resultData.cus_data.CreditPeriod);
                    $("#returnPyment").html(accounting.formatMoney(resultData.return_payment));
                    $("#returnAvailable").html(accounting.formatMoney(resultData.return_payments));
                    $("#creditAmount").html(accounting.formatMoney(resultData.total_credit));
                    $("#settledAmount").html(accounting.formatMoney(resultData.total_payment));
                    $("#cusOutstand").html(accounting.formatMoney(outstanding));
                    $("#availableCreditLimit").html(accounting.formatMoney(available_balance));
                    $("#city").html(resultData.cus_data.MobileNo);


                    var creditAmount = 0;
                    var settleAmount = 0;

                    var z = 1;
                    $.each(resultData.credit_data, function(key, value) {

                        var paymentNo = value.InvoiceNo;
                        var invDate = value.InvoiceDate;
                         var totalNetAmount = parseFloat(value.NetAmount);
                        var creditAmount = parseFloat(value.CreditAmount);
                        var settleAmount = parseFloat(value.SettledAmount);
                        var returnAmount = parseFloat(value.ReturnAmount);
                        var customerPayment = parseFloat(value.payAmount);

                        // var totalNetAmount = value.NetAmount;
                        // var creditAmount = value.CreditAmount;
                        // var settleAmount = value.SettledAmount;
                        // var customerPayment = value.payAmount;
                        var dueAmount = 0;
                        total_due_amount += (creditAmount - settleAmount-returnAmount);

                        var isdueZero = creditAmount - settleAmount-returnAmount;
                        var isclose = (settleAmount == creditAmount);
                        if (isdueZero !== 0 && isclose === false){
console.log('key',key);
                        $("#tbl_payment tbody").append("<tr id='" + z + "'>" +
                            "<td>" + z + "&nbsp;&nbsp;<input rowid='"+z+"' type='checkbox' name='rownum' class='prd_icheck rowcheck '></td>" +
                            "<td  class='invoiceNo'>" + paymentNo + "</td>" +
                            "<td>" + invDate + "</td><td class='text-right'>" + accounting.formatMoney(totalNetAmount) + "</td>" +
                            "<td class='text-right creditAmount'>" + accounting.formatMoney(creditAmount) + "</td>" +
                            "<td class='text-right settleAmount' invPay='0'>" + accounting.formatMoney(settleAmount) + "</td>" +
                            "<td class='text-right returnAmount' invPay='0'>" + accounting.formatMoney(returnAmount) + "</td>" +
                            "<td class='text-right dueAmount' isColse='0'>" + accounting.formatMoney(creditAmount - settleAmount-returnAmount) + "</td>" +
                            "<td></td></tr>");

                        z=z+1;
                        }
                        // $("#cusOutstand").html(accounting.formatMoney(total_due_amount));
                    });

                    //comment code start
                    // $.each(resultData.return_data, function(key, value) {
                    //
                    //     var paymentNo = value.InvoiceNo;
                    //     var invDate = value.InvoiceDate;
                    //      var totalNetAmount = parseFloat(value.NetAmount);
                    //     var creditAmount = parseFloat(value.CreditAmount);
                    //     var settleAmount = parseFloat(value.SettledAmount);
                    //     var returnAmount = parseFloat(0);
                    //     var customerPayment = parseFloat(value.payAmount);
                    //     // var totalNetAmount = value.NetAmount;
                    //     // var creditAmount = value.CreditAmount;
                    //     // var settleAmount = value.SettledAmount;
                    //     // var customerPayment = value.payAmount;
                    //     var dueAmount = 0;
                    //     total_due_amount += (creditAmount - settleAmount-returnAmount);
                    //
                    //     $("#over_payment_rows").append("<tr style='background-color:#fbb5b5;' >" +
                    //         "<td>" + (key + 1) + "&nbsp;&nbsp;</td>" +
                    //         "<td  class='invoiceNo'>" + paymentNo + " Return </td>" +
                    //         "<td>" + invDate + "</td><td class='text-right'>" + accounting.formatMoney(totalNetAmount) + "</td>" +
                    //         "<td class='text-right creditAmount'>" + accounting.formatMoney(creditAmount) + "</td>" +
                    //         "<td class='text-right settleAmount' invPay='0'>" + accounting.formatMoney(0) + "</td>" +
                    //         "<td class='text-right returnAmount' invPay='0'>" + accounting.formatMoney(settleAmount) + "</td>" +
                    //         "<td class='text-right dueAmount' isColse='0'>" + accounting.formatMoney(creditAmount - settleAmount-returnAmount) + "</td>" +
                    //         "<td></td></tr>");
                    //     // $("#cusOutstand").html(accounting.formatMoney(total_due_amount));
                    // });
                    //comment code end
                    // $("#tbl_payment").dataTable().fnDestroy();alert()
                }
            });


    }
    //customer autoload
    $("#customer").autocomplete({
        source: function(request, response) {
            cusType = $("#CustType option:selected").val();

            $.ajax({
                url: 'loadcustomersjson',
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
            cusCode = ui.item.value;
            $("#tbl_payment tbody").html("");
            total_due_amount = 0;
            total_over_payment = 0;

            $.ajax({
                type: "POST",
                url: "../../admin/Payment/getCustomersDataById",
                data: { cusCode: cusCode},
                success: function(data)
                {
                    var resultData = JSON.parse(data);

                    var returnComplete = 0;

                    if (resultData.over_return__complete_payments === null) {
                        returnComplete = 0.00;
                    } else {
                        returnComplete = resultData.over_return__complete_payments;
                    }

                    cusCode = resultData.cus_data.CusCode;
                    outstanding = parseFloat(resultData.total_credit) - parseFloat(resultData.total_payment) - parseFloat(resultData.return_payment) + parseFloat(returnComplete);
                    available_balance = parseFloat(resultData.cus_data.CreditLimit) - parseFloat(outstanding);
                    customer_name=resultData.cus_data.CusName+" "+resultData.cus_data.LastName;
                    $("#cusCode").html(resultData.cus_data.CusName+" "+resultData.cus_data.LastName);
                    $("#customer").val(resultData.cus_data.CusCode);
                    $("#creditLimit").html(accounting.formatMoney(resultData.cus_data.CreditLimit));
                    $("#creditPeriod").html(resultData.cus_data.CreditPeriod);
                    $("#returnPyment").html(resultData.return_payment);
                    $("#returnAvailable").html(accounting.formatMoney(resultData.return_payments));
                    $("#creditAmount").html(accounting.formatMoney(resultData.total_credit));
                    $("#settledAmount").html(accounting.formatMoney(resultData.total_payment));
                    $("#cusOutstand").html(accounting.formatMoney(outstanding));
                    $("#availableCreditLimit").html(accounting.formatMoney(available_balance));
                    $("#city").html(resultData.cus_data.MobileNo);


                    var creditAmount = 0;
                    var settleAmount = 0;
                    var z = 1;
                    $.each(resultData.credit_data, function(key, value) {

                        var paymentNo = value.InvoiceNo;
                        var invDate = value.InvoiceDate;
                        var totalNetAmount = parseFloat(value.NetAmount);
                        var creditAmount = parseFloat(value.CreditAmount);
                        var settleAmount = parseFloat(value.SettledAmount);
                        var returnAmount = parseFloat(value.ReturnAmount);
                        var customerPayment = parseFloat(value.payAmount);
                        var dueAmount = 0;
                        total_due_amount += (creditAmount - settleAmount-returnAmount);

                        var isdueZero = creditAmount - settleAmount-returnAmount;
                        var isclose = (settleAmount == creditAmount);
                        if (isdueZero !== 0 && isclose === false) {
                            $("#tbl_payment tbody").append("<tr id='" + z + "'>" +
                                "<td>" + z + "&nbsp;&nbsp;<input rowid='" + z + "' type='checkbox' name='rownum' class='prd_icheck rowcheck '></td>" +
                                "<td  class='invoiceNo'>" + paymentNo + "</td>" +
                                "<td>" + invDate + "</td>" +
                                "<td class='text-right'>" + accounting.formatMoney(totalNetAmount) + "</td>" +
                                "<td class='text-right creditAmount'>" + accounting.formatMoney(creditAmount) + "</td>" +
                                "<td class='text-right settleAmount' invPay='0'>" + accounting.formatMoney(settleAmount) + "</td>" +
                                "<td class='text-right returnAmount' invPay='0'>" + accounting.formatMoney(returnAmount) + "</td>" +
                                "<td class='text-right dueAmount' isColse='0'>" + accounting.formatMoney(creditAmount - (settleAmount + returnAmount)) + "</td>" +
                                "<td></td></tr>");
                             z=z+1;
                        }
                       // $("#cusOutstand").html(accounting.formatMoney(total_due_amount));
                    });


                    // $.each(resultData.return_data, function(key, value) {
                    //
                    //     var paymentNo = value.InvoiceNo;
                    //     var invDate = value.InvoiceDate;
                    //      var totalNetAmount = parseFloat(value.NetAmount);
                    //     var creditAmount = parseFloat(value.CreditAmount);
                    //     var settleAmount = parseFloat(value.SettledAmount);
                    //     var returnAmount = parseFloat(0);
                    //     var customerPayment = parseFloat(value.payAmount);
                    //     // var totalNetAmount = value.NetAmount;
                    //     // var creditAmount = value.CreditAmount;
                    //     // var settleAmount = value.SettledAmount;
                    //     // var customerPayment = value.payAmount;
                    //     var dueAmount = 0;
                    //     total_due_amount += (creditAmount - settleAmount-returnAmount);
                    //
                    //     $("#over_payment_rows").append("<tr style='background-color:#fbb5b5;' ><td>" + (key + 1) + "&nbsp;&nbsp;</td><td  class='invoiceNo'>" + paymentNo + " Return </td><td>" + invDate + "</td><td class='text-right'>" + accounting.formatMoney(totalNetAmount) + "</td><td class='text-right creditAmount'>" + accounting.formatMoney(creditAmount) + "</td><td class='text-right settleAmount' invPay='0'>" + accounting.formatMoney(0) + "</td><td class='text-right returnAmount' invPay='0'>" + accounting.formatMoney(settleAmount) + "</td><td class='text-right dueAmount' isColse='0'>" + accounting.formatMoney(creditAmount - settleAmount-returnAmount) + "</td><td></td></tr>");
                    //     // $("#cusOutstand").html(accounting.formatMoney(total_due_amount));
                    // });

                    // $("#tbl_payment").dataTable().fnDestroy();
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

//    if(cusCode!='' || cusCode!='0'){
//     $("#returnInvoice").autocomplete({
//         source: function(request, response) {
//
//             $.ajax({
//                 url: '.../../admin/Payment/getCustomersDataById',
//                 dataType: "json",
//                 data: {
//                     name_startsWith: request.term,
//                     type: 'getActiveReturnInvoicesByCustomer',
//                     row_num: 1,
//                     action: "getActiveReturnInvoicesByCustomer",
//                     cus_code: cusCode
//                 },
//                 success: function(data) {
//                     response($.map(data, function(item) {
//                         var code = item.split("|");
//                         return {
//                             label: code[0],
//                             value: code[0],
//                             data: item
//                         }
//                     }));
//                 }
//             });
//         },
//         autoFocus: true,
//         minLength: 0,
//         select: function(event, ui) {
//             var names = ui.item.data.split("|");
// //            $("#cusCode").html(names[1]);
//             $("#payAmount").val(names[1] - names[2]);
//             pay_amount = names[1] - names[2];
//             $("#returnPayment").show();
//             $("#returnPayment").html(accounting.formatMoney(names[1] - names[2]));
//
//         }
//     });

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
    var selectedRowArr=[];

    // $('#tbl_payment tbody').on('click', 'tr', function() {
    //     rid = $(this).attr('id');
    //     pay_amount = $("#payAmount").val();

    //     $(this).addClass("rowselected").siblings().removeClass("rowselected");

    //     due_amount = parseFloat(accounting.unformat($("#tbl_payment tbody").find("[id='" + rid + "']").children('.dueAmount').html()));
    //     credit_amount = parseFloat(accounting.unformat($("#tbl_payment tbody").find("[id='" + rid + "']").children('.creditAmount').html()));
    //     settle_amount = parseFloat(accounting.unformat($("#tbl_payment tbody").find("[id='" + rid + "']").children('.settleAmount').html()));
    //     invoiceNo = $("#tbl_payment tbody").find("[id='" + rid + "']").children('.invoiceNo').html();
    //     $("#payAmount").focus();

    // });

    $('#tbl_payment tbody').on('change', '.rowcheck', function() {
        selectedRowArr.length=0;
        var due_amountArr = 0;
        $("#tbl_payment tbody tr").removeClass('rowselected');
        $("input[name='rownum']:checked").each(function(){
            rid = $(this).attr('rowid');

            selectedRowArr.push($(this).attr('rowid'));
            $(this).parent().parent().addClass("rowselected");

            var due_amount = parseFloat(accounting.unformat($("#tbl_payment tbody").find("[id='" + rid + "']").children('.dueAmount').html()));
            due_amountArr = due_amountArr + due_amount;
        });
            // console.log(due_amountArr);
         $("#selectedAmount").val(due_amountArr);
        // $("input[name=payAuto]:checked").val(2);
        $("input[id='payAuto']").iCheck('uncheck');
        $("input[id='payAuto2']").iCheck('check');
        $("#payAmount").focus();
    });


    $("#payType").change(function() {
        var payType = ($(this).val());

        if (payType == 3) {
            $("#chequeDate").val('');
            $("#chequeReference").val('');
            $('#chequeReciveDate').datepicker().datepicker("setDate", new Date());
            $("#chequeData").show();
            $("#load_return").hide();
            $("#advanceData").hide();
            $("#bankData").hide();
            $("#payAmount").val(0);
        } else if (payType == 4) {
            $("#load_return").show();
            $("#chequeDate").val('');
            $("#chequeReference").val('');
            $("#advanceData").hide();
            $("#bankData").hide();
            $('#chequeReciveDate').datepicker().datepicker("setDate", new Date());
            $("#chequeData").hide();
        }
        else if (payType == 5) {
             $("#load_return").hide();
            $("#advanceData").show();
            $("#bankData").hide();
            $("#chequeDate").val('');
            $("#chequeReference").val('');
            $('#chequeReciveDate').datepicker().datepicker("setDate", new Date());
            $("#chequeData").hide();
        }else if (payType == 7) {
             $("#load_return").hide();
            $("#bankData").show();
            $("#advanceData").hide();
            $("#chequeDate").val('');
            $("#chequeReference").val('');
            $('#chequeReciveDate').datepicker().datepicker("setDate", new Date());
            $("#chequeData").hide();
        } else {
            $("#chequeDate").val('');
            $("#chequeReference").val('');
            $('#chequeReciveDate').datepicker().datepicker("setDate", new Date());
            $("#chequeData").hide();
            $("#advanceData").hide();
            $("#bankData").hide();
            $("#load_return").hide();
            $("#payAmount").val(0);
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

    $("#receiptType").change(function() {
        receiptType = $("#receiptType option:selected").val();
        if(receiptType==2){
        $("#payType option[value='5']").attr("disabled");
        }else{
        $("#payType option[value='5']").attr("disabled").removeAttr("disabled");
        }
    });




    $("#pay").click(function() {

        var payType = $("#payType option:selected").val();
        var paymentType = $("#payType option:selected").html();
        var payDate = $("#invDate").val();
        var chequeDate = $("#chequeDate").val();
        var chequeReference = $("#chequeReference").val();
        var chequeReciveDate = $('#chequeReciveDate').val();
        var chequeNo = $('#chequeNo').val();
        var auto_payment = $("input[name=payAuto]:checked").val();
        var location = $("#invlocation").val();
        var invUser = $("#invUser").val();
        var bank_acc = $("#bank_acc option:selected").val();
        var remark = $("#remark").val();
        var change_amount = 0;
        var pay_amount2 = 0;
        var over_pay_amount = 0;
        var over_pay_inv = '';
        var selectedAmount =  $("#selectedAmount").val();
        receiptType = $("#receiptType option:selected").val();
        //shalika
        var advanceno=$("#advanceno").val();
        var returnInvoice=$("#returnInvoice").val();

        if (payType== 5) {
            if (advanceno=='' || advanceno==0) {
                $.notify("Please select a Advance Payment No.", "danger");
                    return false;

            }

        }
        else if (payType== 4) {
            if (returnInvoice=='' || returnInvoice==0) {
                $.notify("Please select a Return Payment No.", "danger");
                return false;

            }

        }
       //shalika
       //receiptType
       if(receiptType==1){
            //pay autometically
            if (auto_payment == 1) {
                //shalika
                if ($("#tbl_payment tbody tr").length==0) {

                    $.notify("There is no invoice to pay.", "danger");
                    return false;

                }
                //shalika
                if (pay_amount == 0) {
                    $.notify("Please enter pay amount.", "danger");
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

                        console.log(return_payment_no);
                        $("#pay").attr('disabled', true);
                        $.ajax({
                            type: "POST",
                            url: "../../admin/Payment/customerPayment",
                            data: {receiptType:receiptType,advance_payment_no:advance_payment_no,return_payment_no:return_payment_no,bank_acc:bank_acc,paymentNo: paymentNo, location: location, remark: remark,
                                invUser: invUser, invNo: invoiceNo, cusCode: cusCode,outstanding:outstanding, payAmount: pay_amount2, payType: payType, bank: bank,
                                chequeReference: chequeReference, chequeRecivedDate: chequeReciveDate, chequeDate: chequeDate, payDate: payDate, settleAmount: settle_amount,
                                isInvoiceColse: isInvoiceColse, chequeNo: chequeNo, credit_invoice: sendCredit_invoice, cus_credit_amount: sendCus_credit_amount,
                                cus_settle_amount: sendCus_settle_amount, total_settle: total_settle, cus_inv_payment: sendCus_inv_payment, over_pay_amount: over_pay_amount,
                                over_pay_inv: over_pay_inv},
                            success: function(data)
                            {
                                var resultData = JSON.parse(data);
                                var feedback = resultData['fb'];
                                var invNumber = resultData['InvNo'];
                                var invoicedate = resultData['InvDate'];
                                if (feedback == 1) {
                                    $("#reset").attr('disabled', false);
                                    $.notify("Payment successfully saved.", "success");
                                    outstanding = outstanding - total_settle;
                                    printReceipt(invNumber,paymentType);
                                    invoicePrint(invNumber,invoicedate,'invfname',total_settle,disPrint,payType,chequeDate,chequeNo,bank_name,receiptType,remark,paymentType);
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
                                    $("#pay").attr('disabled', true);
                                }
                                else {
                                    $.notify("Payment not saved.", "danger");
                                    return false;
                                }
                            }
                        });
                    }
                    else {
                        return false;
                    }
                }
            }
            else if (auto_payment == 2) {
                //pay manually
                if (selectedRowArr.length  == 0) {
                    $.notify("Please select an invoice.", "danger");
                    return false; 
                }
                else if (pay_amount == 0) {
                    $.notify("Please enter pay amount.", "danger");
                    return false;
                } else {

                    if (selectedAmount < pay_amount) {

                        var final_due_amount = Array.from($("#tbl_payment tbody tr")).map(function(row){
                            return parseFloat($(row).find('.dueAmount').html().replace(',',''));
                        }).reduce(function(acc,it){return acc+it});

                        if (final_due_amount >  pay_amount) {

                            $.notify("Pay amount is more than selected amount. Please select next row", "danger");
                            return false;
                        }

                    }

                    var r = confirm('Do you want to pay manually?');
                    if (r === true) {
                        
                        for (var i = 0; i < selectedRowArr.length; i++) {
                             var itemCodeArrIndex = $.inArray(i, selectedRowArr);
                             var autorowid =selectedRowArr[i];
                            // if(itemCodeArrIndex > 0){
                            due_amount = parseFloat(accounting.unformat($("#tbl_payment tbody").find("[id='" + autorowid + "']").children('.dueAmount').html()));
                            credit_amount = parseFloat(accounting.unformat($("#tbl_payment tbody").find("[id='" + autorowid + "']").children('.creditAmount').html()));
                            settle_amount = parseFloat(accounting.unformat($("#tbl_payment tbody").find("[id='" + autorowid + "']").children('.settleAmount').html()));

                            if (due_amount <= pay_amount) {
                                var due_amount3 = due_amount;
                                var pay_amount3 = pay_amount;

                                $("#" + autorowid + " .settleAmount").attr('invPay', (due_amount));
                                total_settle += due_amount;
                                pay_amount -= due_amount;
                                settle_amount = settle_amount + due_amount;

                                change_amount = 0;
                                due_amount = change_amount;
                                //over payment for last invoice
                                if (autorowid == $("#tbl_payment tbody tr").length) {
                                    if (due_amount3 < pay_amount3) {
                                        var q = confirm('Your Payment greater than the due amount. Do you want to continue this over payment? *Cancel to pay only due amount');
                                        if (q === true) {

                                            total_settle = pay_amount;
                                            settle_amount = settle_amount + pay_amount;

                                            over_pay_amount = credit_amount - settle_amount;
                                            over_pay_inv = $("#" + autorowid + " .invoiceNo").html();
                                            change_amount = over_pay_amount;
                                            due_amount = change_amount;
                                            $("#" + autorowid + " .settleAmount").attr('invPay', settle_amount);
                                        } else {
                                            total_settle = due_amount;
                                            settle_amount = settle_amount + due_amount;
                                            change_amount = 0;
                                            due_amount = change_amount;
                                        }
                                    }
                                }

                            } else if (due_amount > pay_amount) {
                                $("#" + autorowid + " .settleAmount").attr('invPay', (pay_amount));
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

                            if ($("#" + autorowid + " .settleAmount").attr('invPay') > 0) {
                                $("#" + autorowid).addClass("rowselected").siblings();
                            }

                            $("#tbl_payment tbody").find("[id='" + autorowid + "']").children('.dueAmount').html(accounting.formatMoney(change_amount));
                            $("#tbl_payment tbody").find("[id='" + autorowid + "']").children('.settleAmount').html(accounting.formatMoney(settle_amount));
                        }
                    // }

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
                        console.log('row',rowCounts);

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
                            url: "../../admin/Payment/customerPayment",
                            data: {receiptType:receiptType,advance_payment_no:advance_payment_no,return_payment_no:return_payment_no,bank_acc:bank_acc,paymentNo: paymentNo, location: location,
                                remark: remark, invUser: invUser, invNo: invoiceNo, cusCode: cusCode,outstanding:outstanding, payAmount: pay_amount2, payType: payType,
                                bank: bank, chequeReference: chequeReference, chequeRecivedDate: chequeReciveDate, chequeDate: chequeDate, payDate: payDate,
                                settleAmount: settle_amount, isInvoiceColse: isInvoiceColse, chequeNo: chequeNo, credit_invoice: sendCredit_invoice,
                                cus_credit_amount: sendCus_credit_amount, cus_settle_amount: sendCus_settle_amount, total_settle: total_settle,
                                cus_inv_payment: sendCus_inv_payment, over_pay_amount: over_pay_amount, over_pay_inv: over_pay_inv},
                            success: function(data)
                            {
                                var resultData = JSON.parse(data);
                                var feedback = resultData['fb'];
                                var invNumber = resultData['InvNo'];
                                var invoicedate = resultData['InvDate'];
                                if (feedback == 1) {
                                    $("#reset").attr('disabled', false);
                                    $.notify("Payment successfully saved.", "success");
                                    outstanding = outstanding - total_settle;
                                    printReceipt(invNumber,paymentType);
                                    invoicePrint(invNumber,invoicedate,'invfname',total_settle,disPrint,payType,chequeDate,chequeNo,bank_name,receiptType,remark,paymentType);
                                    rid = 0;
                                    invoiceNo = 0;

                                    // outstanding = outstanding - total_settle;
                                    available_balance = parseFloat(available_balance) + total_settle;

                                    $("#cusOutstand").html(accounting.formatMoney(outstanding));
                                    $("#total_due").html(accounting.formatMoney(outstanding));

                                    $("#availableCreditLimit").html(accounting.formatMoney(available_balance));
                                    $("#chequeData").hide();
                                    clearPaymentDetails();
                                    total_settle = 0;
                                    $("#pay").attr('disabled', true);
                                }
                                else {
                                    $.notify("Payment not saved.", "danger");
                                    return false;
                                }
                            }
                        });
                    }
                    else {
                        return false;
                    }
                }
            }

       }else if(receiptType==2){


        //advance Payment
            if (pay_amount == 0) {
                    $.notify("Please enter pay amount.", "danger");
                    return false;
                } else {

                    var r = confirm('Do you want to pay advance?');
                    if (r === true) {

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

                        var sendCredit_invoice = JSON.stringify(credit_invoice);
                        var sendCus_settle_amount = JSON.stringify(cus_settle_amount);
                        var sendCus_credit_amount = JSON.stringify(cus_credit_amount);
                        var sendCus_inv_payment = JSON.stringify(cus_inv_payment);
                        over_pay_amount = 0;

                        $("#pay").attr('disabled', true);
                        $.ajax({
                            type: "POST",
                            url: "../../admin/Payment/customerPayment",
                            data: {receiptType:receiptType,advance_payment_no:advance_payment_no,return_payment_no:return_payment_no,bank_acc:bank_acc,paymentNo: paymentNo, location: location, remark: remark, invUser: invUser, invNo: invoiceNo, cusCode: cusCode,outstanding:outstanding, payAmount: pay_amount2, payType: payType, bank: bank, chequeReference: chequeReference, chequeRecivedDate: chequeReciveDate, chequeDate: chequeDate, payDate: payDate, settleAmount: settle_amount, isInvoiceColse: isInvoiceColse, chequeNo: chequeNo, credit_invoice: sendCredit_invoice, cus_credit_amount: sendCus_credit_amount, cus_settle_amount: sendCus_settle_amount, total_settle: total_settle, cus_inv_payment: sendCus_inv_payment, over_pay_amount: over_pay_amount, over_pay_inv: over_pay_inv},
                            success: function(data)
                            {
                                var resultData = JSON.parse(data);
                                var feedback = resultData['fb'];
                                var invNumber = resultData['InvNo'];
                                var invoicedate = resultData['InvDate'];
                                if (feedback == 1) {
                                    $("#reset").attr('disabled', false);
                                    $.notify("Advance Payment successfully saved.", "success");
                                    outstanding = outstanding - total_settle;
                                    printReceipt(invNumber,paymentType);
                                    invoicePrint(invNumber,invoicedate,'invfname',total_settle,disPrint,payType,chequeDate,chequeNo,bank_name,receiptType,remark,paymentType);
                                    rid = 0;
                                    invoiceNo = 0;

                                    // outstanding = outstanding - total_settle;
                                    // available_balance = parseFloat(available_balance) + total_settle;

                                    $("#cusOutstand").html(accounting.formatMoney(outstanding));
                                    $("#total_due").html(accounting.formatMoney(outstanding));

                                    $("#availableCreditLimit").html(accounting.formatMoney(available_balance));
                                    $("#chequeData").hide();
                                    clearPaymentDetails();
                                    total_settle = 0;
                                    $("#pay").attr('disabled', true);
                                }
                                else {
                                    $.notify("Payment not saved.", "danger");
                                    return false;
                                }
                            }
                        });
                    }
                    else {
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
        $("#payAmount").val(0);
        $("#payType").val(1);
       $("#remark,#bank_acc, #advanceno").val('');
       $("#receiptType").val(1);
       $("#returnInvoice").val('');
        $("#chequeNo").val('');
        $("#chequeDate").val('');
        $("#chequeReference").val('');

        $("#tbl_payment tbody tr").removeClass('rowselected');
        advance_payment_no='';
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

    function invoicePrint(invNumber,invoicedate,invfname,total,disPrint,payType,chq_date,chq_no,bank_name,receipType,remarks,paymenttype){
        $("#tblData tbody").html('');
        if(payType==1){
           $("#tblData tbody").append("<tr><td colspan='3' style='border-left:#000 solid 1px;font-size:10px;border-right:#000 solid 1px;'>" + paymenttype  + "-" + remarks  + "</td><td style='text-align:right;border-right:#000 solid 1px;'>" + accounting.formatMoney(total) + "</td></tr>");
        }else if(payType==3){
            $("#tblData tbody").append("<tr><td style='border-left:#000 solid 1px;font-size:10px;border-right:#000 solid 1px;'>" + chq_date + "</td><td style='border-right:#000 solid 1px;text-align:left;'>" + chq_no + "</td><td style='border-right:#000 solid 1px;text-align:left;'>" + bank_name + "</td><td style='text-align:right;border-right:#000 solid 1px;'>" + accounting.formatMoney(total) + "</td></tr>");
        }

        $("#invNumber").html(invNumber);
        $("#invoiceDate").html(invoicedate);
        $("#cusname").html(customer_name);
        $("#outstand").html(accounting.formatMoney(outstanding));
        $("#invTotal").html(accounting.formatMoney(total));

        if (disPrint != 1) {
            setTimeout(function(){$('#printArea').focus().print();},1000);
        }
    }

    function printReceipt(payNo,payType){
        $("#btnPrint").prop("disabled",false);
        $("#rcpinvno,#rcpinvno1").html('');
        $.ajax({
            type: "POST",
            url: "../../admin/Payment/getReceiptPaymentById",
            data: {payNo:payNo,payType:payType},
            success: function(data)
            {
                var resultData = JSON.parse(data);
                
                if(resultData.pay){
                    $("#rcpdate,#rcpdate1").html(resultData.pay.PayDate);
                    $("#rcpreceiptno,#rcpreceiptno1").html(resultData.pay.CusPayNo);
                    $("#rcpamountword,#rcpamountword1").html(resultData.pay_amount);
                    $("#rcpreason,#rcpreason1").html(resultData.pay.Remark);
                    $("#rcpcusname,#rcpcusname1").html(resultData.pay.RespectSign+" "+resultData.pay.CusName);
                    $("#rcpcusaddress,#rcpcusaddress1").html(nl2br(resultData.pay.Address01));
                    $("#rcpcuscode,#rcpcuscode1").html(resultData.pay.CusCode);
                    $("#rcpamount,#rcpamount1").html(accounting.formatMoney(resultData.pay.PayAmount));
                    $("#rcpchequeno,#rcpchequeno1").html(resultData.pay.ChequeNo);
                    $("#rcpbank,#rcpbank1").html(resultData.pay.BankName);
                     $("#rcpchequedate,#rcpchequedate1").html(resultData.pay.ChequeDate);
                     $("#rcppaytype,#rcppaytype1").html(resultData.pay.PayMethod+" Payment");
                }

                if(resultData.inv){
                    $.each(resultData.inv, function (key, value) {
                        $("#rcpinvno,#rcpinvno1").append(value.InvNo,',');
                    });
                    $("#rcpvno,#rcpvno1").html(resultData.inv.JRegNo);
                }
                 



            }
        });
    }

    $("#btnPrint").click(function(){
        $("#printArea2").print();
    });

    function nl2br (str, is_xhtml) {
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }
});

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
                            label: item.label + " - " + item.value,
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
                    var z = 1;
                    $.each(resultData.credit_data, function(key, value) {

                        var paymentNo = value.GRNNo;
                        var invNo = value.invNo ?? '';
                        var invDate = value.GRNDate;
                        var totalNetAmount = value.NetAmount;
                        var creditAmount = value.CreditAmount;
                        var settleAmount = value.SettledAmount;
                        var ReturnAmount = value.ReturnAmount ?? '0';
                        var customerPayment = value.payAmount;
                        var dueAmount = 0;
                        total_due_amount += (creditAmount - settleAmount);

                        // $("#tbl_payment tbody").append("<tr id='" + (key + 1) +
                        //  "'><td>" + (key + 1) +
                        //   "</td><td  class='invoiceNo'>" + paymentNo +
                        // "</td><td>" + invDate + 
                        // "</td><td class='text-right'>" + accounting.formatMoney(totalNetAmount) + 
                        // "</td><td class='text-right creditAmount'>" + accounting.formatMoney(creditAmount) + 
                        // "</td><td class='text-right settleAmount' invPay='0'>" + accounting.formatMoney(settleAmount) + 
                        // "</td><td class='text-right dueAmount' isColse='0'>" + accounting.formatMoney(creditAmount - settleAmount) + 
                        // "</td><td></td></tr>");


                        $("#tbl_payment tbody").append("<tr id='" + z + "'>" +
                            "<td>" + z + "&nbsp;&nbsp;<input rowid='"+z+"' type='checkbox' name='rownum' class='prd_icheck rowcheck '></td>" +
                            "<td  class='invoiceNo'>" + paymentNo + "</td>" +
                            "<td  class=''>" + invNo + "</td>" +
                            "<td>" + invDate + "</td><td class='text-right'>" + accounting.formatMoney(totalNetAmount) + "</td>" +
                            "<td class='text-right returnAmount' invPay='0'>" + accounting.formatMoney(ReturnAmount) + "</td>" +
                            "<td class='text-right creditAmount'>" + accounting.formatMoney(creditAmount) + "</td>" +
                            "<td class='text-right settleAmount' invPay='0'>" + accounting.formatMoney(settleAmount) + "</td>" +
                            "<td class='text-right dueAmount' isColse='0'>" + accounting.formatMoney(creditAmount - settleAmount) + "</td>" +
                            
                            "<td></td></tr>");

                        z=z+1;

                    });
                    $("#tbl_payment").dataTable().fnDestroy();
                }
            });


        }
    });
    
    var selectedRowArr = [];

    // $(document).on('click', '.rowcheck', function() {
       
    //     selectedRowArr.length = 0;
    //     var due_amountArr = 0;
        
    //     $("#tbl_payment tbody tr").removeClass('rowselected');

    //     $("input[name='rownum']:checked").each(function(){
    //         var rid = $(this).attr('rowid');
    //         var row = $("#tbl_payment tbody").find("[id='" + rid + "']");
            
          
    //         var invoiceNo = row.find('.invoiceNo').text().trim();
            
    //         selectedRowArr.push(invoiceNo); 
    //         row.addClass("rowselected");

    //         var due_amount = parseFloat(accounting.unformat(row.children('.dueAmount').html()));
    //         due_amountArr += due_amount;
    //     });

    //     $("#selectedAmount").val(due_amountArr);

    //     $("input[id='payAuto']").iCheck('uncheck');
    //     $("input[id='payAuto2']").iCheck('check');
    //     $("#payAmount").focus();

    //     console.log("Selected Invoices: " + selectedRowArr);
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
        console.log("Selected Invoices: " + selectedRowArr);
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
                url: 'getReturnAmountById',
                dataType: "json",
                data: {
                    name_startsWith: request.term,
                    type: 'getActiveReturnInvoicesBySupllier',
                    row_num: 1,
                    action: "getActiveReturnInvoicesBySupllier",
                    cus_code: SupCode
                },
                success: function(data) {
                    response($.map(data, function(item) {
                    
                        return {
                            label: item.label + " - " + item.value,
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
            $("#returnInvoice").val(ui.item.data.label);
            $("#payAmount").val(ui.item.value);
            return false;
           

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

        console.log(' invoiceNo', invoiceNo);

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
            $("#payAmount").prop("readonly",false);

        } else if (payType == 4) {
            $("#load_return").show();
            $("#chequeDate").val('');
            $("#chequeReference").val('');
            $('#chequeReciveDate').datetimepicker({ dateFormat: 'yy-mm-dd', timeFormat: "HH:mm:ss" });
            $("#chequeData").hide();
            $("#payAmount").prop("readonly",true);
        } else {
            $("#chequeDate").val('');
            $("#chequeReference").val('');
            $('#chequeReciveDate').datetimepicker({ dateFormat: 'yy-mm-dd', timeFormat: "HH:mm:ss" });
            $("#chequeData").hide();
            $("#load_return").hide();
            $("#payAmount").val(0);
            $("#returnInvoice").val('');
            $("#payAmount").prop("readonly",false);

        }
    });

    $("#payAmount").blur(function() {
        pay_amount = parseFloat($("#payAmount").val());
    });

$("input[name='disablePrint']").on('ifChanged', function() {
        disPrint = $("input[name='disablePrint']:checked").val();
       ;
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
       var dueAmount = $("#dueAmount").val();
       var selectedAmount = $("#selectedAmount").val();
       var payAmount = $("#payAmount").val();
       console.log(payAmount);
       var cashType =$("#cashType").val();
       var returnInvoice = $("#returnInvoice").val();

            //pay autometically
    //         if (auto_payment == 2) {
                
    //             if(payAmount>selectedAmount){
    //                 $("#errPayment").html('You Cant pay Over SettleAmount.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
    //                 return false;
    //             }else{
    //                  //pay manually
    //             if (invoiceNo == 0) {
    //                 $("#errPayment").show();
    //                 $("#errPayment").html('Please select an invoice.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
    //                 return false; 
    //             } else if (rid == 0) {
    //                 $("#errPayment").show();
    //                 $("#errPayment").html('Please select an invoice.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
    //                 return false; 
    //             } else if (pay_amount == 0) {
    //                 $("#errPayment").show();
    //                 $("#errPayment").html('Please enter pay amount.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
    //                 return false;
    //             } else {
    //                 var r = confirm('Do you want to pay manually?');
    //                 if (r === true) {
    //                     if (due_amount <= pay_amount) {
    //                         var q = confirm('Do you want to pay from full amount?');
    //                         if (q === true) {
    //                             total_settle = pay_amount;
    //                             settle_amount = settle_amount + pay_amount;
                                
    //                             over_pay_amount = credit_amount - settle_amount;
    //                             over_pay_inv = invoiceNo;
    //                             change_amount = over_pay_amount;
    //                             due_amount = change_amount;
                                
    //                         } else {
                                
    //                             total_settle = due_amount;
    //                             settle_amount = settle_amount + due_amount;
    //                             change_amount = 0;
    //                             due_amount = change_amount;
    //                         }
    
    //                     } else if (due_amount > pay_amount) {
    //                         total_settle = pay_amount;
    //                         change_amount = due_amount - pay_amount;
    //                         settle_amount = settle_amount + pay_amount;
    //                         due_amount = change_amount;
    //                     }
    
    //                     if (settle_amount >= credit_amount) {
    //                         isInvoiceColse = 1;
    //                     } else {
    //                         isInvoiceColse = 0;
    //                     }
    
    //                     $("#" + rid + " .settleAmount").attr('invPay', (total_settle));
    
    //                     $("#tbl_payment tbody").find("[id='" + rid + "']").children('.dueAmount').html(accounting.formatMoney(change_amount));
    //                     $("#tbl_payment tbody").find("[id='" + rid + "']").children('.settleAmount').html(accounting.formatMoney(settle_amount));
    //                     $("#payAmount").val(0);
    //                     $("#totalPayment").html(accounting.formatMoney(total_settle));
    
    //                     var credit_invoice = new Array();
    //                     var cus_settle_amount = new Array();
    //                     var cus_credit_amount = new Array();
    //                     var cus_inv_payment = new Array();
    //                     var remainingPayment = pay_amount;
    //                     var rowCounts = $("#tbl_payment tbody tr").length;
    //                     var k = rid;
    
    //                     credit_invoice.push($("#" + k + " .invoiceNo").html());  //pushing all the product_code listed in the table
    //                     cus_settle_amount.push(accounting.unformat($("#" + k + " .settleAmount").html()));   //pushing all the qty listed in the table
    //                     cus_credit_amount.push(accounting.unformat($("#" + k + " .creditAmount").html()));
    //                     cus_inv_payment.push(accounting.unformat($("#" + k + " .settleAmount").attr('invPay')));

                        
    
    //                     var sendCredit_invoice = JSON.stringify(selectedRowArr);
    //                     var sendCus_settle_amount = JSON.stringify(cus_settle_amount);
    //                     var sendCus_credit_amount = JSON.stringify(cus_credit_amount);
    //                     var sendCus_inv_payment = JSON.stringify(cus_inv_payment);
    
    //                     over_pay_amount = Math.abs(over_pay_amount);
    //                     $("#pay").attr('disabled', true);
    //                     $.ajax({
    //                         type: "POST",
    //                         url: "../../admin/Payment/supplierPayment",
    //                         data: {paymentNo: paymentNo, location: location, remark: remark, invUser: invUser, invNo: invoiceNo,
    //                              SupCode: SupCode,outstanding:outstanding, payAmount: pay_amount, payType: payType, bank: bank,
    //                               chequeReference: chequeReference, chequeRecivedDate: chequeReciveDate, chequeDate: chequeDate,
    //                                payDate: payDate, settleAmount: settle_amount, isInvoiceColse: isInvoiceColse, chequeNo: chequeNo,
    //                                 credit_invoice: sendCredit_invoice, cus_credit_amount: sendCus_credit_amount, cus_settle_amount: sendCus_settle_amount,
    //                                  total_settle: total_settle, cus_inv_payment: sendCus_inv_payment,
    //                                   over_pay_amount: over_pay_amount, over_pay_inv: over_pay_inv,cashType:cashType},
    //                         success: function(data)
    //                         {
    //                             var resultData = JSON.parse(data);
    //                             var feedback = resultData['fb'];
    //                             var invNumber = resultData['InvNo'];
    //                             var invoicedate = resultData['InvDate'];
    //                             if (feedback == 1) {
    //                                 $("#reset").attr('disabled', false);
    //                                 $("#errPayment").show();
    //                                 $("#errPayment").html('Payment successfully saved.').addClass('alert alert-success alert-dismissible alert-sm').delay(1500).fadeOut(600);
    //                                 outstanding = outstanding - total_settle;
    //                                 available_balance = parseFloat(available_balance) + total_settle;
    //                                 invoicePrint(invNumber,invoicedate,'invfname',total_settle,disPrint,payType,chequeDate,chequeNo,bank_name);
    
    //                                 rid = 0;
    //                                 invoiceNo = 0;
    //                                 clearPaymentDetails();
    
    //                                 $("#cusOutstand").html(accounting.formatMoney(outstanding));
                                  
    //                                 $("#total_due").html(accounting.formatMoney(outstanding));
    //                                 $("#availableCreditLimit").html(accounting.formatMoney(available_balance));
    //                                 $("#chequeData").hide();
    //                                 total_settle = 0;
    //                                 $("#pay").attr('disabled', false);
                                    
    // //                            location.reload();
    //                             }
    //                             else {
    //                                 $("#errPayment").show();
    //                                 $("#errPayment").html('Payment not saved.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
    //                                 return false;
    //                             }
    //                         }
    //                     });
    
    //                 } else {
    //                     return false;
    //                 }
    //             }
    //             }
               
    //         }


    if (auto_payment == 2) {
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
                    console.log(final_due_amount);
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
                            var due_amount3 = parseFloat(due_amount.toFixed(2));
                            var pay_amount3 = parseFloat(pay_amount.toFixed(2));
                            $("#" + autorowid + " .settleAmount").attr('invPay', (due_amount));
                            total_settle += due_amount;
                            pay_amount -= due_amount;
                            settle_amount = settle_amount + due_amount;
                            
                            change_amount = 0;
                            due_amount = change_amount;
                            //over payment for last invoice
                            if (autorowid == $("#tbl_payment tbody tr").length) {
                                if (due_amount3 < pay_amount3) {

                                    $.notify("Pay amount is more than selected amount. Please select next row", "danger");
                                    return false;
                                
                                // var q = confirm('Your Payment greater than the due amount. Do you want to continue this over payment? *Cancel to pay only due amount');

                                // if (!q) { 
                                //     return false;  
                                // }
                                // if (q === true) {

                                //     total_settle = pay_amount;
                                //     settle_amount = settle_amount + pay_amount;

                                //     over_pay_amount = credit_amount - settle_amount;
                                //     over_pay_inv = $("#" + autorowid + " .invoiceNo").html();
                                //     change_amount = over_pay_amount;
                                //     due_amount = change_amount;
                                //     $("#" + autorowid + " .settleAmount").attr('invPay', settle_amount);
                                // } else {
                                //     total_settle = due_amount;
                                //     settle_amount = settle_amount + due_amount;
                                //     change_amount = 0;
                                //     due_amount = change_amount;
                                // }
                            }else{
                                total_settle = pay_amount;
                                    settle_amount = settle_amount + pay_amount;

                                    over_pay_amount = credit_amount - settle_amount;
                                    over_pay_inv = $("#" + autorowid + " .invoiceNo").html();
                                    change_amount = over_pay_amount;
                                    due_amount = change_amount;
                                    $("#" + autorowid + " .settleAmount").attr('invPay', settle_amount);
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
                    url: "../../admin/Payment/supplierPayment",
                            data: {paymentNo: paymentNo, location: location, remark: remark, invUser: invUser, invNo: invoiceNo,
                                 SupCode: SupCode,outstanding:outstanding, payAmount: pay_amount, payType: payType, bank: bank,
                                  chequeReference: chequeReference, chequeRecivedDate: chequeReciveDate, chequeDate: chequeDate,
                                   payDate: payDate, settleAmount: settle_amount, isInvoiceColse: isInvoiceColse, chequeNo: chequeNo,
                                    credit_invoice: sendCredit_invoice, cus_credit_amount: sendCus_credit_amount, cus_settle_amount: sendCus_settle_amount,
                                     total_settle: total_settle, cus_inv_payment: sendCus_inv_payment,
                                      over_pay_amount: over_pay_amount, over_pay_inv: over_pay_inv,cashType:cashType,payAmount:payAmount,returnInvoice:returnInvoice},
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
                                                                      
                                                                      window.location.reload();
                                                                  }else if(feedback == 2){
                                                                    $("#errPayment").html('Return Payment successfully saved.').addClass('alert alert-success alert-dismissible alert-sm').delay(1500).fadeOut(600);
                                                                    window.location.reload();
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
                        
                        if (disPrint == 1) {
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

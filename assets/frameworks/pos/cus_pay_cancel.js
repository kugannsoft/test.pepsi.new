/*
 * point of sale java script goes here
 * author esanka
 */
$(document).ready(function() {
    var paymentId = 0;
    var paymentNo = 0;
    var invNo = 0;
    var cusCode = 0;
    var ItemCodeArr = [];
    var TotalAmount = 0;
    var TotalNetAmount = 0;
    var proDiscount = 0;
    var location = $("#location").val();
    var outstanding=0;
    var available_balance=0;
    var customer_name='';
    
    $("#customer").autocomplete({
        source: function(request, response) {


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
            $("#invoice").val('');
            $("#tbl_payment tbody").html("");
             $.ajax({
                type: "POST",
                url: "../../admin/Payment/getCustomersDataById",
                data: {cusCode: cusCode},
                success: function(data)
                {
                    var resultData = JSON.parse(data);

                    cusCode = resultData.cus_data.CusCode;
                    outstanding = (resultData.total_credit-resultData.total_payment-resultData.return_payment)+resultData.over_return__complete_payments;
                    available_balance = parseFloat(resultData.cus_data.CreditLimit) - parseFloat(outstanding);
                    customer_name=resultData.cus_data.CusName+" "+resultData.cus_data.LastName;
                    $("#cusCode").html(resultData.cus_data.CusName+" "+resultData.cus_data.LastName);
                    $("#customer").val(resultData.cus_data.CusCode);
                    $("#creditLimit").html(accounting.formatMoney(resultData.cus_data.CreditLimit));
                    $("#creditPeriod").html(resultData.cus_data.CreditPeriod);
                    $("#cusOutstand").html(accounting.formatMoney(outstanding));
                    $("#availableCreditLimit").html(accounting.formatMoney(available_balance));
                    $("#city").html(resultData.cus_data.MobileNo);
                }
            });
        }
    });

    //customer autoload
    $("#invoice").autocomplete({
        source: function(request, response) {

            $.ajax({
                url: 'getActiveCusPayment',
                dataType: "json",
                data: {
                    name_startsWith: request.term,
                    location: location,
                    cusCode: cusCode
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.label,
                            value: item.label,
                            data: item
                        }
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function(event, ui) {
            paymentId = (ui.item.label);
            $("#cusCode").html();
//                        invNo = 0;
            $("#tbl_payment tbody").html("");

            $.ajax({
                type: "POST",
                url: "getCusPaymentDataById",
                data: {invNo: paymentId},
                success: function(data)
                {
                    TotalAmount = 0;
                    TotalNetAmount = 0;
                    proDiscount = 0;
                    var bank = '';
                    var chequedate='';
                    var resultData = JSON.parse(data);

                    $.each(resultData, function(key, value) {
                        paymentNo = value.CusPayNo;
                        TotalAmount = parseFloat(value.totalAmount);
                        if(value.BankName=='' || value.BankName==='null'){
                            bank='-';
                        }else{
                             bank=value.BankName;
                        }
                        if(value.ChequeDate=='0000-00-00 00:00:00'){
                            chequedate='-';
                        }else{
                             chequedate=value.ChequeDate;
                        }
                        printReceipt(paymentNo,value.Mode);
                        invoicePrint(paymentNo,value.PayDate,'invfname',TotalAmount,0,value.Mode,chequedate,value.ChequeNo,bank,value.PaymentType,value.Remark,'');

                        $("#tbl_payment tbody").append("<tr id='" + (key + 1) + "'><td>" + (key + 1) + "</td><td>" + value.Mode + " - "+ value.Remark + "</td><td>" + chequedate + "</td><td>" + value.ChequeNo + "</td><td >" + (bank) + "</td><td class='text-right'>" + accounting.formatMoney(value.PayAmount) + "</td></tr>");
                        $("#totalAmount").html(accounting.formatMoney(value.totalAmount));
                        $("#totalDis").html(accounting.formatMoney(value.totalAmount));
                        $("#totalNet").html(accounting.formatMoney(value.totalAmount));
                        $("#outstand").html(accounting.formatMoney(value.AvailableOustanding));
                    });

                    $("#tbl_payment tbody").append("<tr ><td></td><td  class='invoiceNo'></td><td></td><td></td><td>Sub Total</td><td class='text-right'><b>" + accounting.formatMoney(TotalAmount) + "</b></td></tr>");
                }
            });
        }
    });

    $('#invDate').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });

    $("#pay").click(function() {
        var payDate = $("#invDate").val();
        var remark = $("#remark").val();
        var invUser = $("#invUser").val();
        location = $("#location").val();
        var sendItem_code = JSON.stringify(ItemCodeArr);

        var r = confirm("Do you want to cancel this invoice?");
        if (r == true) {
            if (paymentNo == '' || paymentNo == 0) {
                $("#errPayment").show();
                $("#errPayment").html('Please select an invoice.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                return false; 
            } else {
                $.ajax({
                    type: "POST",
                    url: "cancelCusPayment",
                    data: {paymentNo: paymentNo, remark: remark, payDate: payDate, invUser: invUser, cusCode: cusCode, invNo: paymentNo, Item_codeArr: sendItem_code, location: location},
                    success: function(data)
                    {
                        var resultData = JSON.parse(data);
                        var feedback = resultData['fb'];
                        var invNumber = resultData['InvNo'];
                        var cancelNo = resultData['CancelNo'];
                        if (feedback == 1) {
                            $("#reset").attr('disabled', false);
                            $("#errPayment").show();
                            $("#errPayment").html('Payment successfully canceled.').addClass('alert alert-success alert-dismissible alert-sm').delay(1500).fadeOut(600);
                            rid = 0;
                            paymentNo = 0;
                            clearPaymentDetails();
                            $("#customer").val('');
                            $("#remark").val('');
                            $("#lastTranaction").html("Last Cancel Invoice : " + invNumber + " <br> Last Cancel No : " + cancelNo);
                        } else {
                            $("#errPayment").show();
                            $("#errPayment").html('Payment not canceled.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                            return false;
//                                    $("#saveInvoice").prop('disabled', false);
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

    }
    
    function invoicePrint(invNumber,invoicedate,invfname,total,disPrint,payType,chq_date,chq_no,bank_name,receipType,remarks,paymenttype){
        $("#tblData tbody").html('');
        if(payType=='Cash' || payType=='CASH'){
           $("#tblData tbody").append("<tr><td colspan='3' style='border-left:#000 solid 1px;font-size:10px;border-right:#000 solid 1px;'>" + payType + " - "+ remarks + "</td><td style='text-align:right;border-right:#000 solid 1px;'>" + accounting.formatMoney(total) + "</td></tr>");
        }else if(payType=='Cheque' || payType=='CHEQUE'){
            $("#tblData tbody").append("<tr><td style='border-left:#000 solid 1px;font-size:10px;border-right:#000 solid 1px;'>" + chq_date + "</td><td style='border-right:#000 solid 1px;text-align:left;'>" + chq_no + "</td><td style='border-right:#000 solid 1px;text-align:left;'>" + bank_name + "</td><td style='text-align:right;border-right:#000 solid 1px;'>" + accounting.formatMoney(total) + "</td></tr>");
        }

        $("#invNumber").html(invNumber);
        $("#invoiceDate").html(invoicedate);
        $("#cusname").html(customer_name);
        
        $("#invTotal").html(accounting.formatMoney(total));               
    }
    
     $("#print").click(function(){
                   $("#printArea2").print({
        });
                        
    });

     function printReceipt(payNo,payType){
        $("#print").prop("disabled",false);
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

    // $("#btnPrint").click(function(){
    //     $("#printArea2").print();
    // });

    function nl2br (str, is_xhtml) {
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }
});
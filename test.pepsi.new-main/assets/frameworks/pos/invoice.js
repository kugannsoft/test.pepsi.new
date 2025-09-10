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
    var totalDiscount = 0;
    var location = $("#location").val();
    var dueAmount = 0;
    var creditAmount = 0;
    var cashAmount = 0;
    var serialPro = 0;
    var A5Print = 0;
    var totalNet = 0;
    
    A5Print =$("#a5print").val();
    //customer autoload
    $("#invoice").autocomplete({
        source: function(request, response) {

            $.ajax({
                url: 'getActiveInvoice',
                dataType: "json",
                data: {
                    name_startsWith: request.term,
                    type: 'getActiveInvoice',
                    location: location,
                    action: "getActiveInvoice"
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

            $("#tbl_payment tbody").html("");
            $("#tblData tbody").html('');
            serialPro=0;
            $.ajax({
                type: "POST",
                url: "getInvoiceDataById",
                data: {action: "getInvoiceDataById", invNo: paymentId},
                success: function(data)
                {
                    TotalAmount = 0;
                    TotalNetAmount = 0;
                    proDiscount = 0;
                    
                    var resultData = JSON.parse(data);

                    $.each(resultData, function(key, value) {
                        paymentNo = value.InvNo;
                        var ItemCode = value.InvProductCode;
                        TotalAmount += parseFloat(value.InvTotalAmount);
                        TotalNetAmount += parseFloat(value.InvNetAmount);
                        var Product = value.Prd_Description;
                        proDiscount += parseFloat(value.InvDisValue);
                        totalDiscount = parseFloat(value.InvDisAmount);
                        invNo = value.InvNo;
                        cusCode = value.InvCustomer;
                        ItemCodeArr.push(ItemCode);
                        if (value.InvSerialNo != '') {
                            serialPro = 1;
                        }

                        $("#tbl_payment tbody").append("<tr id='" + (key + 1) + "'><td>" + (key + 1) + "</td><td>" + ItemCode + "</td><td>" + Product + "</td><td>" + value.InvSerialNo + "</td><td>" + value.InvQty + "</td><td>" + value.InvFreeQty + "</td><td class='text-right'>" + accounting.formatMoney(value.InvUnitPrice) + "</td><td class='text-right'>" + accounting.formatMoney(value.InvDisValue) + "</td><td class='text-right'>" + accounting.formatMoney(value.InvNetAmount) + "</td></tr>");
                        $("#totalAmount").html(accounting.formatMoney(value.InvAmount));
                        $("#totalDis").html(accounting.formatMoney(totalDiscount));
                        $("#totalNet").html(accounting.formatMoney(value.totalNet));
                        creditAmount = parseFloat(value.InvCreditAmount);
                        cashAmount = parseFloat(value.InvCashAmount);
                        totalNet =parseFloat(value.totalNet);
                        dueAmount = cashAmount - parseFloat(value.totalNet);
                        if (serialPro == 1 && A5Print==1) {
                            $("#tblData tbody").append("<tr><td style='border-left:#000 solid 1px;border-left:#000 solid 1px;text-align:center;'>" + accounting.formatMoney(value.InvQty) + "</td><td style='border-left:#000 solid 1px;font-size:12px;border-right:#000 solid 1px;'>" + Product +"<br>"+ value.InvSerialNo+"</td><td style='border-right:#000 solid 1px;text-align:right;'>" + accounting.formatMoney(value.InvUnitPrice) + "</td><td style='text-align:right;border-right:#000 solid 1px;'>" + accounting.formatMoney(value.InvNetAmount) + "</td></tr>");
                            $("#invNumber2").html(value.InvNo);
                            var invoicedate = value.InvDate;
                            $("#invoiceDate2").html(invoicedate.substring(0, 11));
                            $("#invTotal2").html(accounting.formatMoney(value.totalNet));
                            $("#invTotalDis2").html(accounting.formatMoney(totalDiscount));
                            $("#invNet2").html(accounting.formatMoney(value.totalNet));
                            $("#invCusPay2").html(accounting.formatMoney(value.InvCashAmount));
                            $("#invBalance2").html(accounting.formatMoney(value.InvCashAmount-value.totalNet));
                            $("#invNoItem2").html(accounting.formatMoney(key + 1));

                            if (totalDiscount > 0) {
                                $("#discountRow2").show();
                            } else {
                                $("#discountRow2").hide();
                            }
                            if (dueAmount > 0) {
                                $("#balanceRow2").show();
                            } else {
                                $("#balanceRow2").hide();
                            }
                            if (creditAmount > 0) {
                                $("#crdLabel2").html('Credit Amount');
                            } else {
                                $("#crdLabel2").html('Balance Amount');
                            }

                            if (TotalAmount != totalNet) {
                                $("#netAmountRow2").show();
                            } else {
                                $("#netAmountRow2").hide();
                            }
                            if (cashAmount != totalNet) {
                                $("#cusPayRow2").show();
                            } else {
                                $("#cusPayRow2").hide();
                            }
                        } else {
                            $("#tblData tbody").append("<tr><td  valign='top' style='border-left:#000 solid 1px;text-align:center;'>" + accounting.formatMoney(value.InvQty) + "</td><td valign='top' style='border-left:#000 solid 1px;font-size:9px;border-right:#000 solid 1px;'>" + Product +"<br>"+ value.InvSerialNo+ "</td><td valign='top' style='border-right:#000 solid 1px;text-align:right;'>" + accounting.formatMoney(value.InvUnitPrice) + "</td><td valign='top' style='text-align:right;border-right:#000 solid 1px;'>" + accounting.formatMoney(value.InvNetAmount) + "</td></tr>");
                            $("#invNumber").html(value.InvNo);
                            $("#invoiceDate").html(value.InvDate);
                            $("#invCashier").html(value.first_name);
                            $("#invTotal").html(accounting.formatMoney(value.InvAmount));
                            $("#invTotalDis").html(accounting.formatMoney(totalDiscount));
                            $("#invNet").html(accounting.formatMoney(value.totalNet));
                            $("#invCusPay").html(accounting.formatMoney(0));
                            $("#invBalance").html(accounting.formatMoney(0));
                            $("#invNoItem").html(accounting.formatMoney(key + 1));
                        }
                    });

                    $("#tbl_payment tbody").append("<tr ><td></td><td  class='invoiceNo'></td><td></td><td></td><td></td><td></td><td></td><td>Sub Total</td><td class='text-right'><b>" + accounting.formatMoney(TotalAmount) + "</b></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>Product Discount</td><td class='text-right'><b>" + accounting.formatMoney(totalDiscount) + "</b></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>Total Net Amount</td><td class='text-right'><b>" + accounting.formatMoney(totalNet) + "</b></td></tr>");
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

                    if (TotalAmount != totalNet) {
                        $("#netAmountRow").show();
                    } else {
                        $("#netAmountRow").hide();
                    }
                    if (cashAmount != totalNet) {
                        $("#cusPayRow").show();
                    } else {
                        $("#cusPayRow").hide();
                    }
                }
            });
        }
    });

    $('#invDate,#chequeReciveDate,#chequeDate').datepicker({
        dateFormat: 'yy-mm-dd',
        startDate: '-3d'
    });

    $('#invDate,#chequeReciveDate').datepicker().datepicker("setDate", new Date());

    $("#pay").click(function() {
        var payDate = $("#invDate").val();
        var remark = $("#remark").val();
        var invUser = $("#invUser").val();
        location = $("#location").val();
        var sendItem_code = JSON.stringify(ItemCodeArr);

        var r = confirm("Do you want to cancel this invoice?");
        if (r == true) {
            if (paymentNo == '' || paymentNo == 0) {
                alert('Please select an invoice ');
                return false;
            } else {
                $.ajax({
                    type: "POST",
                    url: "cancelInvoice",
                    data: {action: "cancelInvoice", paymentNo: paymentNo, remark: remark, payDate: payDate, invUser: invUser, cusCode: cusCode, invNo: invNo, Item_codeArr: sendItem_code, location: location},
                    success: function(data)
                    {
                        var resultData = JSON.parse(data);
                        var feedback = resultData['fb'];
                        var invNumber = resultData['InvNo'];
                        var cancelNo = resultData['CancelNo'];
                        if (feedback == 1) {
                            alert('Invoice successfully canceled.');
                            rid = 0;
                            paymentNo = 0;
                            clearPaymentDetails();
                            $("#customer").val('');
                            $("#remark").val('');
                            $("#lastTranaction").html("Last Cancel Invoice : " + invNumber + " <br> Last Cancel No : " + cancelNo);
                        } else {
                            alert('Transaction not saved');
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

    $("#print").click(function() {
        if (serialPro == 1 && A5Print==1) {
            var divContents = $("#printArea2").html();
        } else {
            var divContents = $("#printArea").html();
        }

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
        clearPaymentDetails();
    });

    function s() {
        $("#tblData tbody").html('');
        var j = 0;
        for (j = 0; j < product_code.length; j++) {
            $("#tblData tbody").append("<tr><td style='border-left:#000 solid 1px;font-size:9px;border-right:#000 solid 1px;'>" + product_name[j] + "</td><td style='border-right:#000 solid 1px;text-align:right;'>" + accounting.formatMoney(qty[j]) + "</td><td style='border-right:#000 solid 1px;text-align:right;'>" + accounting.formatMoney(sell_price[j]) + "</td><td style='text-align:right;border-right:#000 solid 1px;'>" + accounting.formatMoney(total_net[j]) + "</td></tr>");
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
        $("#invoiceDate").html(invoicedate);
        $("#invCashier").html(invfname);
        $("#invTotal").html(accounting.formatMoney(total));
        $("#invTotalDis").html(accounting.formatMoney(totalDiscount));
        $("#invNet").html(accounting.formatMoney(toPay));
        $("#invCusPay").html(accounting.formatMoney(cusPayment));
        $("#invBalance").html(accounting.formatMoney(dueAmount));
        $("#invNoItem").html(accounting.formatMoney(product_code.length));
    }
});
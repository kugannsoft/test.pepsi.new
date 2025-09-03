/*
 * point of sale java script goes here
 * author esanka
 */
$(document).ready(function() {

    $('#invDate').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });

    var paymentId = 0;
    var paymentNo = 0;
    var invNo = 0;
    var cusCode = 0;
    var ItemCodeArr = [];
    var TotalAmount = 0;
    var TotalNetAmount = 0;
    var proDiscount = 0;
    var location = $("#location").val();
    var dueAmount = 0;
    var creditAmount = 0;
    var cashAmount = 0;
    var cash_type = 1;
    var cash_date = '';
    var totalExpens = 0;
    var totalEarn = 0;
    var startFloat=0;
    var balid=0;

    //load transaction types
    cash_date = $("#invDate").val();
    $("input[name='cash_type']").on('ifClicked', function() {
        cash_type = $(this).val();
        $("#trans_type").html('');
        $("#trans_type").append("<option value=''>-Select a Transaction Type-</option>");
        $.ajax({
            type: "POST",
            url: "getTransactionType",
            data: {cash_type: cash_type},
            success: function(data)
            {
                var resultData = JSON.parse(data);
                $.each(resultData, function(key, value) {
                    $("#trans_type").append("<option value='" + value.TransactionCode + "'>" + value.TransactionName + "</option>");
                });
            }
        });
    });
    
    //load cash flaot data
    loadFloatData();

    $('#invDate').datepicker().on('changeDate', function(e) {
        cash_date = $(this).val();
        loadFloatData();
        e.preventDefault();
    });

    //add cash in out
    var cashAmount = 0;
    $("#addCash").click(function() {
        var remark = $("#remark").val();
        cashAmount = parseFloat($("#cashAmount").val());
        var payDate = $('#invDate').val();
        var invUser = $("#invUser").val();
        var emp = $("#emp option:selected").val();
        var transCode =$("#trans_type option:selected").val();
        location = $("#location").val();
        var act = $("input[name='isAct']:checked").val();
        var oid = $("#oid").val();
        var cash = '';
        if (cash_type == '1') {
            cash = 'Out';
        } else if (cash_type == '0') {
            cash = 'In';
        }
//alert(act);return false;
        var r = confirm("Do you want to update your cash float?");
        if (r == true) {
            if (cash_type == '') {
                alert('Please select a cash type ');
                return false;
            } else if (cashAmount == '' || cashAmount == 0 || isNaN(cashAmount) == true) {
                alert('Please enter cash amount ');
                return false;
            } else {
                $.ajax({
                    type: "POST",
                    url: "saveCashInOut",
                    data: {cash: cash,transCode:transCode, id: oid, act: act,emp:emp, cashAmount: cashAmount, remark: remark, payDate: payDate, invUser: invUser, location: location},
                    success: function(data)
                    {
                        var resultData = JSON.parse(data);
                        var feedback = resultData['fb'];
                        var invNumber = resultData['InvNo'];
                        var cancelNo = resultData['CancelNo'];
                        if (feedback == 1) {
                            loadFloatData();
                            $("#remark").val('');
                            $("#emp").val(0);
                            $("#cashAmount").val('');
                            $("#oid").val('');
                        } else {
                            alert('Transaction not saved');
                        }
                    }
                });
            }
        }
    });

// add start float
    $("#addFloat").click(function() {
        var payDate = $("#invDate").val();
        var invUser = $("#invUser").val();
        var floatAmount = parseFloat($("#floatAmount").val());
        location = $("#location").val();

        var r = confirm("Do you want to save this amount?");
        if (r == true) {
            if (isNaN(floatAmount) == true) {
                alert('Please enter float amount ');
                return false;
            } else {
                if (isNaN(floatAmount) == true) {
                    floatAmount=0;
                }else if(floatAmount==''){
                    floatAmount=0;
                }else{
                    floatAmount=floatAmount;
                }

                $.ajax({
                    type: "POST",
                    url: "saveStartFloat",
                    data: {id: '', floatAmount: floatAmount, payDate: payDate, invUser: invUser, location: location},
                    success: function(data)
                    {
                        var resultData = JSON.parse(data);
                        var feedback = resultData['fb'];
                        var invNumber = resultData['InvNo'];
                        var cancelNo = resultData['CancelNo'];
                        if (feedback == 1) {
//                            alert('Invoice successfully canceled.');
                            loadFloatData();
                            $("#tblData tbody").append("<tr><td>" + paymentNo + "</td><td>" + floatAmount + "</td></tr>");
                            rid = 0;
                            floatAmount = 0;
                            transCode = 0;
                            paymentNo = 0;
                            clearPaymentDetails();
                            $("#customer").val('');
                            $("#remark").val('');
                            $("#lastTranaction").html("Last Cancel Invoice : " + invNumber + " <br> Last Cancel No : " + cancelNo);
                        } else {
                            alert('Transaction not saved');
                        }
                    }
                });
            }
        } else {
            return false;
        }
    });

//end float
    $("#tbl_payment tbody").on('click', '.endfloat', function() {
        var fid = $(this).attr('fid');
        var payDate = $("#invDate").val();
        var invUser = $("#invUser").val();
        location = $("#location").val();
        

        var endfloatAmount = prompt("Do you want to end this float.If you want please enter End Float", "0");
        if (endfloatAmount != null) {
            $.ajax({
                type: "POST",
                url: "saveEndFloat",
                data: {id: fid,balid:balid, floatAmount: endfloatAmount,startFloat:startFloat, payDate: payDate, invUser: invUser, location: location},
                success: function(data)
                {
                    var resultData = JSON.parse(data);
                    var feedback = resultData['fb'];
                    var invNumber = resultData['InvNo'];
                    var cancelNo = resultData['CancelNo'];
                    if (feedback == 1) {
                        loadFloatData();
                        $("#tblData tbody").append("<tr><td>" + paymentNo + "</td><td>" + floatAmount + "</td></tr>");
                        fid = 0;
                        endfloatAmount = 0;
                        transCode = 0;
                        paymentNo = 0;
                        clearPaymentDetails();
                        $("#customer").val('');
                        $("#remark").val('');
                        $("#lastTranaction").html("Last Cancel Invoice : " + invNumber + " <br> Last Cancel No : " + cancelNo);
                    } else {
                        alert('Transaction not saved');
                    }
                }
            });
        }
    });

    $("#cash_float tbody").on('click', 'tr', function() {
        var remark = $(this).attr('remark');
        var cash = $(this).attr('cash');
        var mode = $(this).attr('mode');
        var act = $(this).attr('act');
        var oid = $(this).attr('oid');
        var emp = $(this).attr('emp');
        var transCode = $(this).attr('transCode');
        $(this).addClass("selected").siblings().removeClass("selected");
        var modeid = 0;
        if (act == 1) {
            $('#isAct').iCheck('check');
        } else if (act == 0) {
            $('#isAct').iCheck('uncheck');
        }

        
        if (mode == 'In') {
            modeid = 0;
            $('#cash_type1').iCheck('uncheck');
            $('#cash_type2').iCheck('check');
            cash_type=0;
        } else if (mode == 'Out') {
            $('#cash_type2').iCheck('uncheck');
            $('#cash_type1').iCheck('check');
            cash_type=1;
        }

        $("#trans_type").html('');
        $("#trans_type").append("<option value=''>-Select a Transaction Type-</option>");
        $.ajax({
            type: "POST",
            url: "getTransactionType",
            data: {cash_type: cash_type},
            success: function(data)
            {
                var resultData = JSON.parse(data);
                $.each(resultData, function(key, value) {
                    $("#trans_type").append("<option value='" + value.TransactionCode + "'>" + value.TransactionName + "</option>");
                });
                $("#trans_type").val(transCode);
            }
        });
        
        $("#remark").val(remark);
        $("#cashAmount").val(cash);
        $("#oid").val(oid);
        $("#emp").val(emp);
        //

    });

    function clearPaymentDetails() {
        $("#remark").val('');
        ItemCodeArr.length = 0;
        $("#invoice").val('');
        $("#floatAmount").val('');
        $("#trans_type").select2('val', 'All');
        invNo = 0;
        TotalAmount = 0;
        TotalNetAmount = 0;
        proDiscount = 0;
        paymentId = 0;
        paymentNo = 0;
        cusCode = 0;
        $("#totalAmount").html(accounting.formatMoney(0));
        $("#totalDis").html(accounting.formatMoney(0));
        $("#totalNet").html(accounting.formatMoney(0));
    }
    
    $("#clearCash").click(function() {
        $("#remark").val('');
        $("#cashAmount").val('');
        $("#oid").val('');
        $('#isAct').iCheck('check');
        $('#cash_type1').iCheck('check');
        $('#cash_type2').iCheck('uncheck');
        $("#cash_float tbody tr").removeClass("selected");
    });

    $("#print").click(function() {
        $('#printArea').focus().print();
        var divContents = $("#printArea").html();

        // var divContents = $("#printArea").html();
        // var printWindow = window.open('', '', 'height=400,width=800');
        // printWindow.document.write('<html><head><title>DIV Contents</title>');
        // printWindow.document.write('</head><body >');
        // printWindow.document.write(divContents);
        // printWindow.document.write('</body></html>');
        // printWindow.document.close();
        // printWindow.print();
        // setTimeout(function() {
        //     printWindow.close();
        // }, 10);
        clearPaymentDetails();
    });
    
   
    // load cash float and in out
    function loadFloatData() {
        $("#tbl_payment tbody").html('');
        $("#cash_float tbody").html('');
        $("#tblData tbody").html('');
        totalExpens = 0;
        totalEarn = 0;
        startFloat=0;
        balid=0;
        $.ajax({
            type: "POST",
            url: "getCashFloatByDate",
            data: {cash_date: cash_date, location: location},
            success: function(data)
            {
                var resultData = JSON.parse(data);
                var exp = 0;
                var ern = 0;
                $.each(resultData, function(key, value) {
                    startFloat=parseFloat(value.START_FLOT);
                    balid=value.BALANCE_ID;
                    $("#tbl_payment tbody").append("<tr ><td>" + (key + 1) + "</td><td  class='invoiceNo'>" + value.START_TIME + "</td><td>" + accounting.formatMoney(value.START_FLOT) + "</td><td>" + value.END_TIME + "</td><td>" + accounting.formatMoney(value.END_FLOT) + "</td><td>" + accounting.formatMoney(value.CASH_SALES) + "</td><td>" + accounting.formatMoney(value.CREDIT_SALES) + "</td><td>" + accounting.formatMoney(value.CARD_SALES) + "</td><td class='text-right'><b>" + accounting.formatMoney(value.DISCOUNT) + "</b></td><td class='text-right'><b>" + accounting.formatMoney(value.NET_AMOUNT) + "</b></td><td class='text-right'>" + accounting.formatMoney(value.ADVANCE_PAYMENT) + "</td><td>" + accounting.formatMoney(value.CASH_IN) + "</td><td class='text-right'><b>" + accounting.formatMoney(value.CASH_OUT) + "</b></td><td class='text-right'><b>" + accounting.formatMoney(value.BALANCE_AMOUNT) + "</b></td><td><a href='#' class='btn btn-xs btn-primary endfloat' fid='" + value.BALANCE_ID + "'>End</a></td></tr>");
                    $("#totalAmount,#totExp").html(accounting.formatMoney(totalExpens));
                    $("#totalDis,#totErn").html(accounting.formatMoney(totalEarn));
                     
                    $("#tblData tbody").append("<tr><td colspan='5' style='border-top:1px solid #000'>&nbsp;</td></tr>");
                    $("#tblData tbody").append("<tr><td>Balance ID</td><td colspan='3'>"+value.BALANCE_ID+"</td></tr>");
                    $("#tblData tbody").append("<tr><td>Start Time</td><td>"+value.START_TIME+"</td><td>Start</td><td style='text-align:right'>"+accounting.formatMoney(value.START_FLOT)+"</td></tr>");
                    $("#tblData tbody").append("<tr><td>End Time</td><td>"+value.END_TIME+"</td><td>End</td><td style='text-align:right'>"+accounting.formatMoney(value.END_FLOT)+"</td></tr>");
                    $("#tblData tbody").append("<tr><td colspan='2'>Total Net Sale</td><td>:</td><td colspan='2' style='text-align:right'>"+accounting.formatMoney(value.NET_AMOUNT)+"</td></tr>");
                    $("#tblData tbody").append("<tr><td colspan='2'>Total Discount</td><td>:</td><td colspan='2' style='text-align:right'>"+accounting.formatMoney(value.DISCOUNT)+"</td></tr>");
                    $("#tblData tbody").append("<tr><td colspan='2'>Total Credit Sale</td><td>:</td><td colspan='2' style='text-align:right'>"+accounting.formatMoney(value.CREDIT_SALES)+"</td></tr>");
                    $("#tblData tbody").append("<tr><td colspan='2'>Total Card Sale</td><td>:</td><td colspan='2' style='text-align:right'>"+accounting.formatMoney(value.CARD_SALES)+"</td></tr>");
                    $("#tblData tbody").append("<tr><td colspan='2'>Total Cheque Sale</td><td>:</td><td colspan='2' style='text-align:right'>"+accounting.formatMoney(value.CHEQUE_SALES)+"</td></tr>");
                    $("#tblData tbody").append("<tr><td colspan='2'>Total Bank Sale</td><td>:</td><td colspan='2' style='text-align:right'>"+accounting.formatMoney(value.BANK_SALES)+"</td></tr>");
                    $("#tblData tbody").append("<tr><td colspan='2'>Total Returns</td><td>:</td><td colspan='2' style='text-align:right'>"+accounting.formatMoney(value.RETURN_AMOUNT)+"</td></tr>");
                    $("#tblData tbody").append("<tr><td colspan='2'>Total Cash Sale*</td><td>:</td><td colspan='2' style='text-align:right'>"+accounting.formatMoney(value.CASH_SALES)+"</td></tr>");
                    
                    $("#tblData tbody").append("<tr><td colspan='2'>Total Cus. Payments*</td><td>:</td><td colspan='2' style='text-align:right'>"+accounting.formatMoney(value.CUSTOMER_PAYMENT)+"</td></tr>");
                    $("#tblData tbody").append("<tr><td colspan='2'>Total Order Advance*</td><td>:</td><td colspan='2' style='text-align:right'>"+accounting.formatMoney(value.ORDER_ADVANCE_SALES)+"</td></tr>");
                    $("#tblData tbody").append("<tr><td colspan='2'>Total Advance*</td><td>:</td><td colspan='2' style='text-align:right'>"+accounting.formatMoney(value.ADVANCE_PAYMENT)+"</td></tr>");
                    $("#tblData tbody").append("<tr><td colspan='2'>Total Supplier Payments*</td><td>:</td><td colspan='2' style='text-align:right'>"+accounting.formatMoney(value.SUPPLIER_PAYMENT)+"</td></tr>");
                    $("#tblData tbody").append("<tr><td colspan='2'>&nbsp;</td><td>&nbsp;</td><td colspan='2'>&nbsp;</td></tr>");
                    $("#tblData tbody").append("<tr><td colspan='2'>Total Cash In</td><td>:</td><td colspan='2' style='text-align:right'>"+accounting.formatMoney(value.CASH_IN)+"</td></tr>");
                    $("#tblData tbody").append("<tr><td colspan='2'>Total Cash Out</td><td>:</td><td colspan='2' style='text-align:right'>"+accounting.formatMoney(value.CASH_OUT)+"</td></tr>");
                    $("#tblData tbody").append("<tr><td colspan='2'>Balance Amount</td><td>:</td><td colspan='2' style='text-align:right'>"+accounting.formatMoney(value.BALANCE_AMOUNT)+"</td></tr>");
                    $("#tblData tbody").append("<tr><td colspan='2'>&nbsp;</td><td>:</td><td colspan='2'>&nbsp;</td></tr>");
                    $("#tblData tbody").append("<tr><td colspan='2'>Cash Balance Difference</td><td>:</td><td colspan='2' style='text-align:right'>"+accounting.formatMoney(value.BALANCE_AMOUNT-value.END_FLOT)+"</td></tr>");
                });
            }
        });
        //ajax load cash in out
        $.ajax({
            type: "POST",
            url: "getCashInOutByDate",
            data: {cash_date: cash_date, location: location},
            success: function(data)
            {
                var resultData = JSON.parse(data);
                var exp = 0;
                var ern = 0;
                $.each(resultData, function(key, value2) {
                    var active = "<span class='label label-success'>Active</span>";
                    if (value2.IsActive == 1) {
                        totalExpens += parseFloat(value2.CashAmount);
                        active = "<span class='label label-success'>Active</span>";
                    }
                    else if (value2.IsActive == 0) {
                        active = "<span class='label label-danger'>Cancel</span>";
                        totalEarn += parseFloat(value2.CashAmount);
                    }
                    $("#cash_float tbody").append("<tr  transCode='"+value2.TransCode+"' emp='"+value2.Emp+"' mode='" + value2.Mode + "' cash='" + value2.CashAmount + "' remark='" + value2.Remark + "' act='" + value2.IsActive + "' oid='" + value2.InOutID + "'><td>" + (key + 1) + "</td><td  >" + value2.Mode + "</td><td>" + value2.TransactionName + " - " + value2.RepName + " - " + value2.Remark + "</td><td class='text-right' ><b>" + accounting.formatMoney(value2.CashAmount) + "</b></td><td>"+active+"</td></tr>");
                    $("#totalAmount,#totExp").html(accounting.formatMoney(totalExpens));
                    $("#totalDis,#totErn").html(accounting.formatMoney(totalEarn));
                });
            }
        });
    }

 

    $('#saveDep3').click(function(e) {
        var category = $("#dep3").val();
        $.ajax({
                type: "post",
                url: "../master/addTransType",
                data: {cash_type:cash_type,name:category,remark:category,isAct:1},
                success: function (json) {
                    var resultData = JSON.parse(json);
                    var feedback = resultData['fb'];
                    var val = resultData['TransactionCode'];
                    var dec = resultData['Description'];

                    if (feedback == true) {
                        $("#trans_type").append("<option value='"+val+"'>"+dec+"</option>");
                        $("#dep3").val('');
                        $("#panel_dep3").hide();
                     }
                },
                error: function () {
                    alert('Error while request..');
                }
            });
        e.preventDefault();
    });
    
    $('#delCat').click(function(e) {
        
        var r = confirm('Do you want to delete this category?');
            if (r === true) {
                var id =$("#trans_type option:selected").val();
                $.ajax({
                    type: "post",
                    url: "../master/deleteTransType",
                    data: {id:id},
                    success: function(json) {
                        var resultData = JSON.parse(json);
                        var feedback = resultData['fb'];

                        if (feedback != false) {
                            if (feedback == 3) {
                                $("#errProduct1").show();
                                $('html, body').animate({scrollTop: $('#errTop').offset().top}, 'slow');
                                $("#errProduct1").html('Can not delete this. This expenses type has linked with cash float.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                                return false;
                            } else if (feedback == 1) {
                                $("#trans_type").find("[value='" + id + "']").remove();
                            }
                        }
                    },
                    error: function() {
                        alert('Error while request..');
                    }
                });
            } else {

            }
        e.preventDefault();
    });
});
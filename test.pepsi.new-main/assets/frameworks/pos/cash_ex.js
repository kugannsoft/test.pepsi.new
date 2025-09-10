/*
 * point of sale java script goes here
 * author esanka
 */
$(document).ready(function() {

    $('#invDate,#chequeReciveDate,#chequeDate').datepicker({
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
    loadFloatData();
    function loadFloatData(){
$("#tbl_payment tbody").html('');
totalExpens = 0;totalEarn=0;
    $.ajax({
        type: "POST",
        url: "getTransactionByDate",
        data: {cash_date: cash_date, location: location},
        success: function(data)
        {
            var resultData = JSON.parse(data);
            var exp = 0;var ern=0;
            $.each(resultData, function(key, value) {
                if(value.IsExpenses==1){
                    totalExpens +=parseFloat(value.FlotAmount);
                    exp=parseFloat(value.FlotAmount);
                    ern=0;
                }
                else if(value.IsExpenses==0){
                    totalEarn+=parseFloat(value.FlotAmount);
                ern=parseFloat(value.FlotAmount);
                    exp=0;
                }
                $("#tbl_payment tbody").append("<tr ><td>" + (key + 1) + "</td><td  class='invoiceNo'>" + value.FlotNo + "</td><td>" + value.CounterNo + "</td><td>" + value.FlotDate + "</td><td>" + value.DateORG + "</td><td>" + value.TransactionCode + "</td><td>" + value.TransactionName + "</td><td>" + value.IsExpenses + "</td><td class='text-right'><b>" + accounting.formatMoney(ern) + "</b></td><td class='text-right'><b>" + accounting.formatMoney(exp) + "</b></td></tr>");
                $("#totalAmount,#totExp").html(accounting.formatMoney(totalExpens));
                $("#totalDis,#totErn").html(accounting.formatMoney(totalEarn));
            });
        }
    });
    }
    
$('#invDate').datepicker().on('changeDate', function(e) {
    cash_date = $(this).val();
    loadFloatData();
        e.preventDefault();
    });

  
    $("#pay").click(function() {
        var payDate = $("#invDate").val();
        var remark = $("#remark").val();
        var invUser = $("#invUser").val();
        var floatAmount = parseFloat($("#floatAmount").val());
        var transCode =$("#trans_type option:selected").val();
        location = $("#location").val();
        var sendItem_code = JSON.stringify(ItemCodeArr);

        var r = confirm("Do you want to save this amount?");
        if (r == true) {
            if (transCode == '' || transCode == 0) {
                alert('Please select a transaction type ');
                return false;
            } else if (floatAmount == '' || floatAmount == 0 || isNaN(floatAmount) == true) {
                alert('Please enter float amount ');
                return false;
            } else {
                $.ajax({
                    type: "POST",
                    url: "saveCashFloat",
                    data: {transCode:transCode,floatAmount:floatAmount, paymentNo: paymentNo, remark: remark, payDate: payDate, invUser: invUser, cusCode: cusCode, invNo: invNo, Item_codeArr: sendItem_code, location: location},
                    success: function(data)
                    {
                        var resultData = JSON.parse(data);
                        var feedback = resultData['fb'];
                        var invNumber = resultData['InvNo'];
                        var cancelNo = resultData['CancelNo'];
                        if (feedback == 1) {
                           loadFloatData();
                            $("#tblData tbody").append("<tr><td>"+paymentNo+"</td><td>"+floatAmount+"</td></tr>");
                            rid = 0;
                            floatAmount=0;
                            transCode=0;
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

    $("#print").click(function() {

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

        clearPaymentDetails();

    });
    
    
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
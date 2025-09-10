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
                //customer autoload
                $("#invoice").autocomplete({
                    source: function(request, response) {

                        $.ajax({
                            url: 'getActiveGRN',
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
                        paymentId =(ui.item.label);
                        $("#cusCode").html();
//                        invNo = 0;
                        $("#tbl_payment tbody").html("");

                        $.ajax({
                            type: "POST",
                            url: "getGRNDataById",
                            data: {action: "getGRNDataById", invNo: paymentId},
                            success: function(data)
                            {
                                TotalAmount = 0;TotalNetAmount = 0;proDiscount = 0;

                                var resultData = JSON.parse(data);

                                $.each(resultData, function(key, value) {
                                    paymentNo = value.GRN_No;
                                    var ItemCode = value.GRN_Product;
                                    TotalAmount += parseFloat(value.GRN_Amount);
                                    TotalNetAmount += parseFloat(value.GRN_NetAmount);
                                    var Product = value.Prd_Description;
                                    proDiscount +=parseFloat(value.GRN_DisAmount);
                                    invNo = value.GRN_No;
                                    cusCode = value.GRN_SupCode;
                                    ItemCodeArr.push(ItemCode);
                                    

                                    $("#tbl_payment tbody").append("<tr id='" + (key + 1) + "'><td>" + (key + 1) + "</td><td>" + ItemCode + "</td><td>" + Product + "</td><td>" + value.GRN_Qty + "</td><td>" + value.GRN_FreeQty + "</td><td class='text-right'>" + accounting.formatMoney(value.GRN_UnitCost) + "</td><td class='text-right'>" + accounting.formatMoney(value.GRN_DisAmount) + "</td><td class='text-right'>" + accounting.formatMoney(value.GRN_NetAmount) + "</td></tr>");
                                    $("#totalAmount").html(accounting.formatMoney(value.GRN_totalAmount));
                                    $("#totalDis").html(accounting.formatMoney(value.TotalDiscount));
                                    $("#totalNet").html(accounting.formatMoney(value.totalNet));
                                });

                                $("#tbl_payment tbody").append("<tr ><td></td><td  class='invoiceNo'></td><td></td><td></td><td></td><td></td><td>Sub Total</td><td class='text-right'><b>" + accounting.formatMoney(TotalAmount) + "</b></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td>Product Discount</td><td class='text-right'><b>" + accounting.formatMoney(proDiscount) + "</b></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td>Total Net Amount</td><td class='text-right'><b>" + accounting.formatMoney(TotalNetAmount) + "</b></td></tr>");

                            }
                        });


                    }
                });

//                $('#invDate,#chequeReciveDate,#chequeDate').datepicker({
//                    dateFormat: 'yy-mm-dd',
//                    startDate: '-3d'
//                });
                $('#invDate').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
                //$('#invDate,#chequeReciveDate').datepicker().datepicker("setDate", new Date());

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
                            url: "cancelGRN",
                            data: {action: "cancelGRN", paymentNo: paymentNo, remark: remark, payDate: payDate, invUser: invUser, supCode: cusCode, invNo: invNo, Item_codeArr: sendItem_code,location:location},
                            success: function(data)
                            {   var resultData = JSON.parse(data);
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
                                    $("#lastTranaction").html("Last Cancel Invoice : "+invNumber+" <br> Last Cancel No : "+cancelNo );
                                }else {
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
            });
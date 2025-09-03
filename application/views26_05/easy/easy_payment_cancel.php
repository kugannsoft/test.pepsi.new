<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
    <section class="content-header">
        <?php echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>
    <section class="content">
        <br>
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-success">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="customer" class="col-sm-5 control-label">Account No <span class="required">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" required="required"  name="accNo" id="accNo" placeholder="Enter Account number">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="customer" class="col-sm-5 control-label">Payment No <span class="required">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" required="required"  name="customer" id="customer" placeholder="Enter Payment number">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="invDate" class="col-sm-5 control-label">Cancel Date <span class="required">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" required="required"  name="invDate" id="invDate" placeholder="">
                                        <input type="hidden" class="form-control" required="required"  name="invUser" id="invUser" value="<?php echo $_SESSION['user_id'] ?>">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="invDate" class="col-sm-5 control-label">Remark <span class="required">*</span></label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control" name="remark" id="remark"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <table>
                                    <tr>
                                        <td>Account No</td>
                                        <td> : </td>
                                        <td><span id="cusCode"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Customer</td>
                                        <td> : </td>
                                        <td><span id="city"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Invoice No</td>
                                        <td> : </td>
                                        <td class="text-right"><span id="creditLimit"></span></td>
                                    </tr>
<!--                                    <tr>-->
<!--                                        <td>Outstanding</td>-->
<!--                                        <td> : </td>-->
<!--                                        <td class="text-right"><span id="cusOutstand"></span></td>-->
<!--                                    </tr>-->
<!--                                    <tr>-->
<!--                                        <td>Available Limit</td>-->
<!--                                        <td> : </td>-->
<!--                                        <td class="text-right"><span id="availableCreditLimit"></span> </td>-->
<!--                                    </tr>-->

                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td> </td>
                                    </tr>
                                </table>

                            </div>
                            <div class="col-lg-3">
                                <!--                                            <table>
                                                                                <tr>
                                                                                    <td>Total Gems</td>
                                                                                    <td> : </td>
                                                                                    <td><span id="creditPeriod"></span> </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Total Deals</td>
                                                                                    <td> : </td>
                                                                                    <td><span id="cusCode"></span></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td> Last Deal</td>
                                                                                    <td> : </td>
                                                                                    <td><span id="creditLimit"></span></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Since</td>
                                                                                    <td> : </td>
                                                                                    <td><span id="creditPeriod"></span></td>
                                                                                </tr>
                                                                            </table>-->
                            </div>
                            <div class="col-lg-2">
                                <!--<span class="img-thumbnail "  id="cusImage"><img  style="width: 100px;height: 100px;" src=""> </span>-->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><span id="lbl_batch_no"></span></b>
                                <br><button class="btn btn-info pull-right" id='pay'>Cancel Payment</button>
                            </div>
                            <div class="col-lg-8">

                            </div>
                        </div>



                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="tbl_payment" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Payment No</th>
                                    <th >Month Term</th>
                                    <th class="t">Invoice No</th>
                                    <th>Date</th>
                                    <th class="text-right">Pay Amount</th>
<!--                                    <th class="text-right">Customer</th>-->

                                    <th></th>

                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                <th></th>
                                <th></th>
                                <th ></th>
                                <th class="text-right"></th>
                                <th>Total Paid</th>
                                <th class="text-right" id="totalPaid">0.00</th>
<!--                                <th class="text-right"></th>-->
                                <th></th>
                                </tfoot>
                            </table>
                            <label class="alert alert-xs pull-center" id="error"></label>
                        </div>

                        <!--add category modal-->
                        <div class="modal fade bs-add-category-modal-lg" tabindex="-1" role="dialog" aria-hidden="false">
                            <div class="modal-dialog modal-sm">
                                <form role="form" id="form2" data-parsley-validate method="post" action="Controller/Option.php">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <h4 class="modal-title" id="myModalLabel2">Add Customer Payment</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="cateogry">Customer Payment Name</label>
                                                <input type="text" required="required" class="form-control" name="category" id="cateogry" placeholder="Enter customer type">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <input type="hidden" name="action" value="addCustomerType" >
                                            <button type="submit" id="submit" class="btn btn-primary">Add</button>
                                        </div>

                                    </div>
                                </form>


                            </div>
                        </div>
                        <!-- /modals -->

                        <!--edit category modal-->
                        <div class="modal fade bs-example2-modal-lg" tabindex="-1" role="dialog" aria-hidden="false">
                            <div class="modal-dialog modal-sm">
                                <form role="form" id="form2" data-parsley-validate method="post" action="Controller/Option.php">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <h4 class="modal-title" id="myModalLabel2">Edit Customer Payment</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="cateogry">Customer Payment Name</label>
                                                <input type="text" required="required" class="form-control" name="category" id="cateogry" placeholder="Enter category">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <input type="hidden" name="action" value="addCustomerType" >
                                            <button type="submit" id="submit" class="btn btn-primary">Add</button>
                                        </div>

                                    </div>
                                </form>


                            </div>
                        </div>
                        <!-- /modals -->
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
        <!-- /.box -->
    </section><!-- /.content -->
</div><!-- ./wrapper -->

<script>

    // $(document).ready(function() {
    //
    //
    //     $.listen('parsley:field:validate', function() {
    //         validateFront();
    //     });
    //     $('#form2 .btn').on('click', function() {
    //
    //         $('#form2').parsley().validate();
    //         validateFront();
    //     });
    //     var validateFront = function() {
    //         if (true === $('#form2').parsley().isValid()) {
    //             $('.bs-callout-info').removeClass('hidden');
    //             $('.bs-callout-warning').addClass('hidden');
    //         } else {
    //             $('.bs-callout-info').addClass('hidden');
    //             $('.bs-callout-warning').removeClass('hidden');
    //         }
    //     };
    // });

</script>

<script type="text/javascript">
    $(document).ready(function() {
        var paymentId = 0;
        var paymentNo = 0;
        var invNo = 0;
        var cusCode = 0;
        var AccNo='';

        $("#accNo").autocomplete({
            source: function(request, response) {

                $.ajax({
                    url: '../EasyPayment/loadAccounts',
                    dataType: "json",
                    data: {
                        name_startsWith: request.term,
                        type: 'loadAccounts',
                        row_num: 1,
                        action: "loadAccounts"
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                label: item.AccNo,
                                value: item.AccNo,
                                AccNo: item.AccNo
                            };
                        }));
                    }
                });
            },
            autoFocus: true,
            minLength: 0,
            select: function(event, ui) {
                AccNo = ui.item.AccNo;
                $("#tbl_payment tbody").html("");
                $("#customer").val();
                $("#totalPaid").html(accounting.formatMoney(0));

            }
        });

        $("#customer").autocomplete({
            source: function(request, response) {
                console.log('dddd',AccNo);
                $.ajax({
                    url: "../EasyPayment/getActiveEasyPayment",
                    dataType: "json",
                    data: {
                        name_startsWith: request.term,
                        AccNo: AccNo
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                label: item.PaymentId,
                                value: item.PaymentId,
                                data: item
                            }
                        }));
                    }
                });
            },
            autoFocus: true,
            minLength: 0,
            select: function(event, ui) {
                $("#cusCode").html(ui.item.data.AccNo);
                $("#customer").val(ui.item.data.PaymentId);
                $("#city").html(ui.item.data.DisplayName);
                $("#creditLimit").html(ui.item.data.InvNo);
                paymentId = ui.item.data.PaymentId;

                $("#tbl_payment tbody").html("");
                $("#totalPaid").html(accounting.formatMoney(0));

                $.ajax({
                    type: "POST",
                    url: "../EasyPayment/getEasyPaymentDataById",
                    data: {paymentId: paymentId},
                    success: function(data)
                    {
                        if(data!=''){
                            var resultData = JSON.parse(data);
                            var total_paid = 0;
                            $.each(resultData, function(key, value) {
                                paymentNo = value.PaymentId;
                                var invDate = value.PayDate;
                                var PayAmount = value.PayAmount;
                                var cusName = value.CusName;
                                var month = value.Month;
                                invNo = value.InvNo;
                                cusCode = value.CusCode;
                                var chequeDate = value.ChequeDate;
                                total_paid+=parseFloat(value.PayAmount);
                                $("#totalPaid").html(accounting.formatMoney(total_paid));
                                $("#tbl_payment tbody").append("<tr id='" + (key + 1) + "'>" +
                                    "<td>" + (key + 1) + "</td>" +
                                    "<td  >" + paymentNo + "</td>" +
                                    "<td class='month'>" + month + "</td>" +
                                    "<td class='invoiceNo'>" + invNo + "</td>" +
                                    "<td>" + invDate + "</td>" +
                                    "<td class='text-right payAmount'>" + accounting.formatMoney(PayAmount) + "</td>" +
                                    "<td><input type='hidden' name='selInvoice' id='selInvoice" + key + "' value='" + paymentNo + "'></td>" +
                                    "</tr>");
                            });

                            $("#tbl_payment").dataTable({

                            }).fnDestroy();
                        }else{
                            $("#error").html('Data not found');
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

            var credit_invoice = new Array();
            var cus_settle_amount = new Array();
            var month = new Array();

            var rowCounts = $("#tbl_payment tbody tr").length;

            for (var k = 1; k <= rowCounts; k++) {
                credit_invoice.push($("#" + k + " .invoiceNo").html());
                cus_settle_amount.push(accounting.unformat($("#" + k + " .payAmount").html()));
                month.push(($("#" + k + " .month").html()));
            }

            var sendCredit_invoice = JSON.stringify(credit_invoice);
            var sendCus_settle_amount = JSON.stringify(cus_settle_amount);
            var sendMonth = JSON.stringify(month);

            $.ajax({
                type: "POST",
                url: "../EasyPayment/cancelEasyPayment",
                data: {paymentNo: paymentNo, remark: remark, payDate: payDate, invUser: invUser, cusCode: cusCode, invNo: invNo,credit_invoice:sendCredit_invoice,cus_settle_amount:sendCus_settle_amount,month:sendMonth},
                success: function(data)
                {
                    var resultData = JSON.parse(data);
                    var feedback = resultData['fb'];
                    if (feedback != 1){
                        $.notify("Payment Cancel not saved.", "warning");
                    }
                    else {
                        $.notify("Payment Cancel successfully saved.", "success");
                        rid = 0;
                        paymentNo = 0;

                        $("#tbl_payment tbody").html('');
                        $("#remark").val('');
                        $("#customer").val('');
                    }
                }
            });

        });
    });

</script>
<script type="text/javascript">
    function deleteRecord(fid) {

        var check = confirm("Are you sure want to delete this...");
        if (check == true) {
            window.location.href = "../Admin/Controller/Option.php?action=deleteCustomerType&category_id=" + fid;
        }
        else {
            return  false;
        }
    }

</script>
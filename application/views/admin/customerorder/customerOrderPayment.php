<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
    <section class="content-header">
        <?php echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>
    <section class="content">
        <div class="box collapse cart-options" id="collapseExample">
            <div class="box-header">Filter Categories</div>
            <div class="box-body categories_dom_wrapper">
            </div>
            <div class="box-footer">
                <button class="btn btn-primary close-item-options pull-right">Hide options</button>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-success">
                    <div class="box-header">
                        <div class="pull-right">
<!--                            <button type="button" id="btnPrint" class="btn btn-primary btn-lg btn-block">Print</button>-->
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="row row-eq-height">
                                <div class="row" id="printArea" align="center" style='margin:5px;'>
                                    <!-- load comapny common header -->
<!--                                    --><?php //$this->load->view('admin/_templates/company_header.php',true); ?>
                                    <table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
                                        <tr style="text-align:left;font-size:13px;">
                                            <td> Delevery Date</td>
                                            <td> :</td>
                                            <td id="lblinvDate"><?php echo $po_hed->PO_DeleveryDate?></td>
                                            <td> &nbsp;</td>
                                            <td colspan="3" style="text-align:center;font-size:20px;"> <b></b></td>
                                        </tr>
                                        <tr style="text-align:left;font-size:13px;">
                                            <td> PO No</td>
                                            <td> :</td>
                                            <td id="lblPoNo1"><?php echo $po_hed->PO_No?></td>
                                            <td> &nbsp;</td>
                                            <td colspan="3"></td>
                                        </tr>
                                        <!--                                        <tr style="text-align:left;font-size:13px;">-->
                                        <!--                                            <td> Job No</td>-->
                                        <!--                                            <td> :</td>-->
                                        <!--                                            <td id="lblPoNo">--><?php //echo $po_hed->JobNo?><!--</td>-->
                                        <!--                                            <td> &nbsp;</td>-->
                                        <!--                                            <td colspan="3"></td>-->
                                        <!--                                        </tr>-->
                                        <!--                                        <tr style="text-align:left;font-size:13px;">-->
                                        <!--                                            <td> Customer</td>-->
                                        <!--                                            <td></td>-->
                                        <!--                                            <td> &nbsp;</td>-->
                                        <!--                                            <td> &nbsp;</td>-->
                                        <!--                                            <td colspan="3" rowspan="3" style="width:300px;font-size:14px;border: #000 solid 1px;padding:10px;">-->
                                        <!--                                                --><?php //echo $company['CompanyName'] ?><!-- --><?php //echo $company['CompanyName2'] ?><!--<br>-->
                                        <!--                                                --><?php //echo $company['AddressLine01'] ?><!--<br>--><?php //echo $company['AddressLine02'] ?><!----><?php //echo $company['AddressLine03'] ?><!--<br>-->
                                        <!--                                                Contact Us - --><?php //echo $company['LanLineNo'] ?>
                                        <!--                                            </td>-->
                                        <!--                                        </tr>-->
                                        <tr style="text-align:left;font-size:13px;">
                                            <td  id="lblSupplier" colspan="3"  style="width:300px;font-size:14px;border: #000 solid 1px;padding:5px;">
                                                <?php echo $po_hed->DisplayName."<br>".$po_hed->Address01." ".$po_hed->Address02."<br>".$po_hed->Address03; ?>
                                            </td>
                                            <td> &nbsp;</td>
                                            <td ></td>
                                        </tr>
                                    </table>
                                    <style type="text/css" media="screen">
                                        #tbl_est_data tbody tr td{
                                            padding: 13px;
                                        }
                                    </style><br>
                                    <table id="tbl_po_data" style="border-collapse:collapse;width:700px;padding:5px;font-size:13px;" border="1">
                                        <thead>
                                        <tr>
                                            <th style='padding: 3px;'>#</th>
                                            <th style='padding: 3px;width:300px;'>Description</th>
                                            <th style='padding: 3px;width:100px;'>Status</th>
                                            <th style='padding: 3px;'>Qty</th>
                                            <!-- <th style='padding: 3px;'>Unit</th> -->
                                            <th style='padding: 3px;text-align: center;'>Unit Price</th>
                                            <th style='padding: 3px;text-align: center;'>Total Price</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i=1;$total=0; foreach ($po AS $dtl) {
                                            ?>
                                            <tr style="font-size:13px;">
                                                <td style="padding: 5px"><?php echo $i;?></td>
                                                <td style="padding: 5px"><?php echo $dtl->PO_ProName?></td>
                                                <td style="padding: 5px"><?php if ($dtl->PO_IsComplete) { echo 'Canceled By Customer';}?></td>
                                                <td style="padding: 5px"><?php echo $dtl->PO_Qty/$dtl->PO_UPC?></td>
                                                <!-- <td style="padding: 5px"><?php echo $dtl->PO_Type?></td> -->
                                                <td class="text-right"  style="padding: 5px"><?php echo number_format($dtl->PO_UnitPrice,2)?></td>
                                                <td class="text-right" style="padding: 5px"><?php echo number_format($dtl->PO_NetAmount,2); ?></td>
                                            </tr>
                                            <?php  $i++; } ?>
                                        </tbody>
                                        <tfoot>
                                        <tr><th colspan="4" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></th><th style="text-align:right">Total Amount  </th><th id="lbltotalEsAmount"   style='text-align:right'><?php echo number_format($po_hed->PO_Amount,2)?></th></tr>
                                        <?php if($po_hed->PO_TDisAmount>0){?>
                                            <tr id="rowVat"><th colspan="4" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></th><th style="text-align:right">Discount  </th><th id="lbltotalVat"   style='text-align:right'><?php echo number_format($po_hed->PO_TDisAmount,2)?></th></tr><?php } ?>
                                        <?php if($po_hed->POVatAmount>0){?>
                                            <tr id="rowVat"><th colspan="4" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></th><th style="text-align:right">VAT Amount  </th><th id="lbltotalVat"   style='text-align:right'><?php echo number_format($po_hed->POVatAmount,2)?></th></tr><?php } ?>
                                        <?php if($po_hed->PONbtAmount>0){?><tr id="rowNbt"><th colspan="4" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></th><th style="text-align:right">NBT Amount  </th><th id="lbltotalNbt"   style='text-align:right'><?php echo number_format($po_hed->PONbtAmount,2)?></th></tr><?php } ?>
                                        <?php if($po_hed->PONbtAmount>0 || $po_hed->POVatAmount>0 || $po_hed->PO_TDisAmount>0){?>
                                            <tr id="rowNet"><th colspan="4" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></th><th style="text-align:right">Net Amount  </th><th id="lbltotalNet"   style='text-align:right'><?php echo number_format($po_hed->PO_NetAmount,2)?></th></tr>
                                        <?php } ?>

                                        </tfoot>
                                    </table>
                                    <hr>
                                    <div style="text-align: center">
                                        <span style="text-align: left"><b>Payment Details</b></span>
                                    </div>
                                    <table style="width:700px;" border="1" id="paymentDtl">
                                        <tr>
                                            <th style='padding: 3px;'>#</th>
                                            <th style='padding: 3px;'>Rcp: No</th>
                                            <th style='padding: 3px;width:300px;'>Date</th>
                                            <th style='padding: 3px;'>Payment Type</th>
                                            <th style='padding: 3px;text-align: center;'>Amount</th>
                                            <?php if ($po_hed->IsComplate == 0) {
                                                ?>
                                            <th style='padding: 3px;text-align: center;'>Delete</th>
                                            <?php }?>
                                            <th style='padding: 3px;text-align: center;'>View</th>
                                        </tr>
                                        <tbody>
                                        <?php $i=1;$total=0; foreach ($pay_dtl AS $dtl) {
                                        ?>
                                        <tr>
                                            <td style=""><?php echo $i;?></td>
                                            <td style=""><?php echo $dtl->Rcp_No?></td>
                                            <td style=""><?php echo $dtl->payDate?></td>
                                            <td style=""><?php echo $dtl->payType?></td>
                                            <td style="text-align: right"><?php echo $dtl->PayAmount?></td>
                                            <?php if ($po_hed->IsComplate == 0) {
                                                ?>
                                            <td style="text-align: center"><?php if ($i == 1) {?> <button class="btn btn-xs btn-danger btnRemove" wid="<?php echo $dtl->Id; ?>">Delete</button> <?php } ?></td>
                                            <?php }?>
                                            <td style="text-align: center">
                                                <button class="btn btn-xs btn-primary btnview" vid="<?php echo $dtl->Id; ?>">View</button>
                                            </td>
                                        </tr>
                                            <?php $total += $dtl->PayAmount; $i++; } ?>
                                        </tbody>
                                        <tfoot>
                                        <tr><th colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></th><th style="text-align:right">Total Amount  </th><th id="lbltotalEsAmount"   style='text-align:right'><?php echo number_format($total,2)?></th></tr>
                                        </tfoot>
                                    </table>
                                    <input type="Hidden" name="estNo" id="estNo" value="<?php //echo $QuotationNo;?>">
                                </div>
                            </div>
                            <hr>
                        </div>
                        <?php if ($po_hed->IsComplate == 0) { ?>
                                                <div class="" >
                                <form class="form-horizontal" id="formPayment">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="grnremark"class="col-sm-3 control-label">Date<span class="required">*</span></label>
                                            <div class="col-sm-8">
                                                 <input disabled="disabled" type="text" name="payDate" value="<?php echo date("Y-m-d H:i:s");?>" id="payDate" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="grnremark"class="col-sm-5 control-label">Payment Type<span class="required">*</span></label>
                                            <div class="col-sm-6">
                                                <select class="form-control" id="payType" name="payType">
                                                    <option value="1">Cash</option>
                                                    <option value="3">Cheque</option>
<!--                                                    <option value="5">Advance</option>-->
                                                    <option value="8">Bank</option>
                                                    <option value="4">Card</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="grnremark"class="col-sm-4 control-label">Amount<span class="required">*</span></label>
                                            <div class="col-sm-7">
                                                <input type="number" step="any" name="payAmount" id="payAmount" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <input type="hidden" id="coNo" name="coNo" value="<?php echo $po_hed->PO_No?>">
                                        <button type="submit"  class="btn btn-success" id="saveOderPayment">Save</button>
                                    </div>
                                </form>
                            </div>
                        <?php  } ?>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section>
    <div class="modal fade bs-payment-modal-lg" id="modelInvoice" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <form role="form" id="addDep" data-parsley-validate method="post" action="#">
                <div class="modal-content">
                    <div class="modal-body" >
                        <?php //receipt print
                        $this->load->view('admin/customerorder/customer_order_recipt.php',true); ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button>
                        <button type="button" id="printInvoice" class="btn btn-primary btn-lg">Print</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="customermodal" class="modal fade bs-add-category-modal-lg" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="cusModal">
                <!-- load data -->
            </div>
        </div>
    </div>

</div>
<style>

    .shop-items:hover{
        background-color: #00ca6d;
        color: #fff;
    }

    .form-group {
        margin-bottom: 5px;
    }

    div.ui-datepicker{
        font-size:10px;
    }

    #cus_details{
        font-size: 18px;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {


    $("#btnPrint").click(function(){
        $('#printArea').focus().print();
    });

        $('#formPayment').submit(function (e) {
            e.preventDefault();
            var paytype =$("#payType option:selected").val();
            var balanaceAmount =$("#payAmount").val();
            var balanceDate =$("#payDate").val();
            var orderNo =$("#coNo").val();

            if (paytype=='') {
                $.notify("Please enter Payment Type.", "warning");
            }else if (balanaceAmount=='') {
                $.notify("Please enter valid Amount.", "warning");
            }else if (balanceDate=='' ) {
                $.notify("Please enter Date", "warning");
            }else{
                $("#saveOderPayment").prop("disabled",true);

                $.ajax({
                    url: "<?php echo base_url('admin/Customerorder/saveCustomerOrderPayment/') ?>",
                    type: "POST",
                    dataType: 'json',
                    data: $(this).serializeArray(),
                    success: function (status) {

                        if (status){
                            $.notify("Customer Added Successfully..!", "success");
                            printCustomerOrderReceipt(orderNo);
                        }else{
                            $.notify("Error..!", "warning");
                        }
                    }
                });
            }
        });

        function printCustomerOrderReceipt(orderNo) {

            $.ajax({
                type: "POST",
                url: "<?php echo base_url('admin/Customerorder/getCustomerOrderReceiptDtl/') ?>",
                data: { orderNo: orderNo },
                success: function(data) {
                    var resultData = JSON.parse(data);

                    loadReceptToPrint(resultData);
                }
            });

        }

        function loadReceptToPrint(resultData) {

            if(resultData.receipt_hed){
                $("#rcpdate,#rcpdate1").html(resultData.receipt_hed.payDate);
                $("#rcpreceiptno,#rcpreceiptno1").html(resultData.receipt_hed.Rcp_No);
                $("#rcpamountword,#rcpamountword1").html(resultData.pay_amount_word);
                $("#rcpcusname,#rcpcusname1").html(resultData.receipt_hed.DisplayName);
                $("#rcpcusaddress,#rcpcusaddress1").html(nl2br(resultData.receipt_hed.Address01));
                $("#rcpcuscode,#rcpcuscode1").html(resultData.receipt_hed.CusCode);
                $("#rcpamount,#rcpamount1").html(accounting.formatMoney(resultData.receipt_hed.PayAmount));
                $("#rcpinvno,#rcpinvno1").html(resultData.receipt_hed.OrderNo);
                $("#rcpvno,#rcpvno1").html(resultData.receipt_hed.OrderNo);
                $("#rcppaytype,#rcppaytype1").html(resultData.receipt_hed.PayType+" Payment");
            }

            $("#rdPay").prop("disabled", true);
            $('#printArea2').focus().print();

        }

        $("#paymentDtl tr").on('click','.btnRemove',function(){
            var wid=0;
            wid=($(this).attr('wid'));
            $confirm = confirm("Are you want to Delete this record ?");

            if ($confirm == true){
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('admin/Customerorder/deleteRecode/') ?>",
                    data: { id:wid},
                    success: function(data)
                    {
                        var resultData = JSON.parse(data);

                        if (feedback != 1) {
                            $.notify("Recode has not Deleted.", "warning");
                            return false;
                        } else {
                            $.notify("Recode has Successfully Deleted.", "success");
                            location.reload();
                            return false;
                        }
                    }
                });
            } else {
                return false;
            }
        });

        $("#paymentDtl tr").on('click','.btnview',function(){
            var vid=0;
            vid=($(this).attr('vid'));
            $confirm = confirm("Are you want to Print this record ?");

            if ($confirm == true){
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('admin/Customerorder/getCustomerOrderReceiptDtlById/') ?>",
                    data: { id:vid},
                    success: function(data)
                    {
                        var resultData = JSON.parse(data);

                        loadReceptToPrint(resultData);
                    }
                });
            } else {
                return false;
            }
        });

        function nl2br (str, is_xhtml) {
            var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
            return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
        }
    });
</script>


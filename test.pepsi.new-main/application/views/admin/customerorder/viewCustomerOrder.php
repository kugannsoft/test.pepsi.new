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
                            <button type="button" id="btnPrint" class="btn btn-primary btn-lg btn-block">Print</button>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="row row-eq-height">
                                <div class="row" id="printArea" align="center" style='margin:5px;'>
                                    <!-- load comapny common header -->
                                    <?php $this->load->view('admin/_templates/company_header.php',true); ?>
                                    <table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
                                        <tr style="text-align:left;font-size:13px;">
                                            <td> Delevery Date</td>
                                            <td> :</td>
                                            <td id="lblinvDate"><?php echo $po_hed->PO_DeleveryDate?></td>
                                            <td> &nbsp;</td>
                                            <td colspan="3" style="text-align:center;font-size:20px;"> <b>ORDER FORM</b></td>
                                        </tr>
                                        <tr style="text-align:left;font-size:13px;">
                                            <td> PO No</td>
                                            <td> :</td>
                                            <td id="lblPoNo"><?php echo $po_hed->PO_No?></td>
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
                                            <!-- <th style='padding: 3px;'></th> -->
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
<!--                                    <table style="width:700px;" border="0">-->
<!--                                        <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>-->
<!--                                        <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>-->
<!--                                        <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>-->
<!--                                        <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>-->
<!--                                        <tr>-->
<!--                                            <td style="border-bottom:1px dashed #000;width:100px" >&nbsp;</td>-->
<!--                                            <td style="">&nbsp;</td>-->
<!--                                            <td style="border-bottom:1px dashed #000;width:200px">&nbsp;</td>-->
<!--                                            <td style="">&nbsp;</td>-->
<!--                                            <td style="">&nbsp;</td>-->
<!--                                        </tr>-->
<!--                                        <tr>-->
<!--                                            <td style="width:100px;text-align: center">Prepared By</td>-->
<!--                                            <td style="">&nbsp;</td>-->
<!--                                            <td style="width:200px;text-align: center">Authorised Signature</td>-->
<!--                                            <td style="">&nbsp;</td>-->
<!--                                            <td style="">&nbsp;</td>-->
<!--                                        </tr>-->
<!--                                        <tr>-->
<!--                                            <td style="width:100px;text-align: center">( --><?php //echo $po_hed->first_name; ?><!-- )</td>-->
<!--                                            <td style="">&nbsp;</td>-->
<!--                                            <td style="width:200px;text-align: center"></td>-->
<!--                                            <td style="">&nbsp;</td>-->
<!--                                            <td style="text-align: center"></td>-->
<!--                                        </tr>-->

<!--                                        <tr>-->
<!--                                            <td colspan="6">-->
                                                <table style="width:700px;" border="0">
                                                    <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>
                                                    <tr><td colspan="5" style="text-align:left;"><b>Remarks&nbsp;&nbsp;:&nbsp;&nbsp;</b><?php echo $invHed->salesInvRemark; ?></td></tr>

                                                    <tr><td colspan="5" style="text-align:left;">&nbsp;&nbsp;<b>Term & Conditions</b></td></tr>
                                                    <tr><td colspan="5" style="text-align:left;">
                                                            <ul>
                                                                <!-- <li>No cash refunds.</li>
                                                                <li>If supplied part is faulty has to be tested at Avinda workshop before returned.</li>
<!--                                                                <li>Returns accepted only within a week of transaction date.</li> -->
<!--                                                                --><?php // if($invHed->SalesInvType == 3){?>
<!--                                                                    <li>Returns accepted only within a week of transaction date - Used and electrical items returns not accepted unless approved at point of sale by management</li>-->
<!--                                                                    <li>No cash refunds</li>-->
<!--                                                                    <!--                                      <li>Any supplied faulty parts have to be tested at Avinda workshop to confirm failure</li>-->
<!--                                                                    <li>Payment to be made within 30 days of transaction date</li>-->

<!--                                                                --><?php //}else{ ?>
                                                                    <?php foreach ($term as $val) { ?>
                                                                        <li><?php echo $val->InvCondition; ?></li>
                                                                    <?php } ?>
<!--                                                                --><?php //}  ?>

                                                            </ul>
                                                        </td></tr>
                                                    <tr><td colspan="5" style="text-align:right;width:550px;">&nbsp;</td></tr>
                                                    <tr>
                                                        <td style="width:150px;text-align: left">&nbsp;</td>
                                                        <td style="width:100px;">&nbsp;</td>
                                                        <td style="width:150px;text-align: center">&nbsp;</td>
                                                        <td style="width:100px;">&nbsp;</td>
                                                        <td style="width:200px;text-align: left">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border-bottom:1px dashed #000;" >&nbsp;</td>
                                                        <td style="">&nbsp;</td>
                                                        <td style="border-bottom:1px dashed #000;">&nbsp;</td>
                                                        <td style="">&nbsp;</td>
                                                        <td style="border-bottom:1px dashed #000;">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: center">Prepared By</td>
                                                        <td style="">&nbsp;</td>
                                                        <td style="text-align: center">Authorised Signature</td>
                                                        <td style="">&nbsp;</td>
                                                        <td style="text-align: center"><?php if($invHed->SalesReceiver!=''){ ?>On behalf of <?php } ?>Customer Signature</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: center"> <?php //echo $invHed->first_name; ?> </td>
                                                        <td style="">&nbsp;</td>
                                                        <td style="text-align: center"></td>
                                                        <td style="">&nbsp;</td>
                                                        <td style="text-align: center">I have received mentioned items.</td>
                                                    </tr>
                                                    <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>
                                                    <tr><td colspan="5" style="text-align:center;font-size: 18px;"><i></i></td></tr>
<!--                                                </table>-->
<!--                                            </td>-->
<!--                                        </tr>-->
                                    </table>
                                    <input type="Hidden" name="estNo" id="estNo" value="<?php //echo $QuotationNo;?>">
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section>
    <div id="customermodal" class="modal fade bs-add-category-modal-lg" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="cusModal">
                <!-- load data -->
            </div>
        </div>
    </div>

    <!--invoice print-->
    <div class="modal fade bs-payment-modal-lg" id="modelInvoice" tabindex="-1" role="dialog" aria-hidden="false">

        <div class="modal-dialog modal-lg">

            <div class="row"  id="printArea2" align="center" style='margin:5px;'>

                <!-- load comapny common header -->

                <?php $this->load->view('admin/_templates/company_header.php',true); ?>

                <table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
                    <tr style="text-align:left;font-size:13px;">
                        <td> Delevery Date</td>
                        <td> :</td>
                        <td id="lblinvDate"><?php echo $po_hed->PO_DeleveryDate?></td>
                        <td> &nbsp;</td>
                        <td colspan="3" style="text-align:center;font-size:20px;"> <b>Purchase Order</b></td>
                    </tr>
                    <tr style="text-align:left;font-size:13px;">
                        <td> PO No</td>
                        <td> :</td>
                        <td id="lblPoNo"><?php echo $po_hed->PO_No?></td>
                        <td> &nbsp;</td>
                        <td colspan="3"></td>
                    </tr>
<!--                    <tr style="text-align:left;font-size:13px;">-->
<!--                        <td> Customer</td>-->
<!--                        <td></td>-->
<!--                        <td> &nbsp;</td>-->
<!--                        <td> &nbsp;</td>-->
<!--                        <td colspan="3" rowspan="3" style="font-size:14px;border: #000 solid 1px;padding:10px;">-->
<!--                            --><?php //echo $company['CompanyName'] ?><!-- --><?php //echo $company['CompanyName2'] ?><!--<br>-->
<!--                            --><?php //echo $company['AddressLine01'] ?><!--<br>--><?php //echo $company['AddressLine02'] ?><!----><?php //echo $company['AddressLine03'] ?><!--<br>-->
<!--                            Contact Us - --><?php //echo $company['LanLineNo'] ?>
<!--                        </td>-->
<!--                    </tr>-->
                    <tr style="text-align:left;font-size:13px;">
                        <td  id="lblSupplier" colspan="3"  style="font-size:14px;border: #000 solid 1px;padding:5px;">
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
                        <th style='padding: 3px;'>Description</th>
                        <!-- <th style='padding: 3px;'></th> -->
                        <th style='padding: 3px;'>Qty</th>
                        <th style='padding: 3px;'>Unit</th>
<!--                        <th style='padding: 3px;'>Unit Price</th>-->
                        <th style='padding: 3px;'>Total Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i=1;$total=0; foreach ($po AS $dtl) {
                        ?>
                        <tr style="font-size:13px;">
                            <td style="padding: 5px"><?php echo $i;?></td>
                            <td style="padding: 5px"><?php echo $dtl->Prd_AppearName?></td>
                            <td style="padding: 5px"><?php echo $dtl->PO_Qty/$dtl->PO_UPC?></td>
<!--                            <td style="padding: 5px">--><?php //echo $dtl->PO_Type?><!--</td>-->
                            <td style="padding: 5px"><?php echo $dtl->PO_UnitCost?></td>
                            <td class="text-right" style="padding: 5px"><?php echo $dtl->PO_NetAmount; ?></td>
                        </tr>
                        <?php  $i++; } ?>
                    </tbody>
                    <tfoot>
                    <tr><th colspan="4" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></th><th style="text-align:right">Total Amount  </th><th id="lbltotalEsAmount"   style='text-align:right'><?php echo $po_hed->PO_Amount?></th></tr>
                    <?php if($po_hed->POVatAmount>0){?>
                        <tr id="rowVat"><th colspan="4" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></th><th style="text-align:right">VAT Amount  </th><th id="lbltotalVat"   style='text-align:right'><?php echo $po_hed->POVatAmount?></th></tr><?php } ?>
                    <?php if($po_hed->PONbtAmount>0){?><tr id="rowNbt"><th colspan="4" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></th><th style="text-align:right">NBT Amount  </th><th id="lbltotalNbt"   style='text-align:right'><?php echo $po_hed->PONbtAmount?></th></tr><?php } ?>
                    <?php if($po_hed->PONbtAmount>0 || $po_hed->POVatAmount>0){?>
                        <tr id="rowNet"><th colspan="4" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></th><th style="text-align:right">Net Amount  </th><th id="lbltotalNet"   style='text-align:right'><?php echo $po_hed->PO_NetAmount?></th></tr>
                    <?php } ?>
                    </tfoot>
                </table>
                <table style="width:700px;" border="0">
                    <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>
                    <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>
                    <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>
                    <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>
                    <tr>
                        <td style="border-bottom:1px dashed #000;width:100px" >&nbsp;</td>
                        <td style="">&nbsp;</td>
                        <td style="border-bottom:1px dashed #000;width:200px">&nbsp;</td>
                        <td style="">&nbsp;</td>
                        <td style="">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="width:100px;text-align: center">Prepared By</td>
                        <td style="">&nbsp;</td>
                        <td style="width:200px;text-align: center">Authorised Signature</td>
                        <td style="">&nbsp;</td>
                        <td style="">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="width:100px;text-align: center">( <?php echo $po_hed->first_name; ?> )</td>
                        <td style="">&nbsp;</td>
                        <td style="width:200px;text-align: center"></td>
                        <td style="">&nbsp;</td>
                        <td style="text-align: center"></td>
                    </tr>
                </table>

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
    $("#btnPrint").click(function(){
        $('#printArea').focus().print();
    });
</script>


<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// echo $prnNo;die;
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
            <div class="col-lg-12">
                <div class="box box-success">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-4">
                                <table class="table">
                                    <tr><td></td><td></td><td class="text-right"><?php if($prn_hed->PRN_No==0){
                                    echo '<label class="label label-success">Active</label>';
                                }else if($prn_hed->PRN_No==1){
                                    echo '<label class="label label-danger">Canceled</label>';
                                } ?></td></tr>
                                    <tr><td>PRN No</td><td>:</td><td class="text-right" id="totalAmount"><?php echo $prn_hed->PRN_No;?></td></tr>
                                    <tr><td>GRN No</td><td>:</td><td class="text-right" id="totalAmount"><?php echo $prn_hed->GRN_No;?></td></tr>
                                    <tr><td>Date</td><td>:</td><td class="text-right"  id="totalDis"><?php echo $prn_hed->PRN_Date;?></td></tr>
                                <tr><td>Supplier</td><td>:</td><td class="text-right"  id="totalNet"><?php echo $prn_hed->SupName;?></td></tr>
                                    
                                </table>
                                
                            </div>
                            <div class="col-md-4">

                                <table class="table">
                                    <tr><td></td><td></td><td class="text-right"></td></tr>
                                    <tr><td>Total Amount</td><td>:</td><td class="text-right" id="totalAmount"><?php echo number_format($prn_hed->PRN_Cost_Amount,2);?></td></tr>
                                </table>
                            </div>
                            <div class="col-md-4"> <div class="pull-right">
                     <button type="button" id="btnPrint" class="btn btn-default btn-lg btn-block">Print</button>
                    </div> </div>
                        </div>

                      



                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">


                            <table id="tbl_payment" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Code</th>
                                        <th>Product Name</th>
                                        <th>Serial No</th>
                                        <th>Total Quantity</th>
                                        <th>Unit/Case</th>
                                        <th>Unit Cost</th>
                                        <th>Selling Price</th>
                                        <th  class="text-right">Total Net Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i=1;
                                 foreach ($prn AS $prndata) { ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo $prndata->PRN_Product ?></td>
                                    <td ><?php echo $prndata->Prd_Description ?></td>
                                    <td ><?php echo $prndata->Serial ?></td>
                                    <td class="text-right"><?php echo number_format($prndata->PRN_Qty,2) ?></td>
                                    <td class="text-right"><?php echo ($prndata->PRN_UPCType) ?></td>
                                    <td class="text-right"><?php echo number_format($prndata->PRN_UnitCost,2) ?></td>
                                    <td class="text-right"><?php echo number_format($prndata->PRN_Selling,2) ?></td>
                                    <td class="text-right"><?php echo number_format($prndata->PRN_Amount,2) ?></td>
                                </tr>
                                <?php $i++; } ?>
                                </tbody>
                                <thead>
                                    <tr>
                                        
                                        <th colspan="8" class="text-right">Total</th>
                                        <th  class="text-right"><?php echo number_format($prn_hed->PRN_Cost_Amount,2);?></th>
                                    </tr>
                                </thead>

                            </table>
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
        <div class="row"  id="printArea" align="center" style='margin:5px;'>
            <!-- load comapny common header -->
            <?php $this->load->view('admin/_templates/company_header.php',true); ?>  

            <table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
                <tr style="text-align:left;font-size:13px;">
                    <td> PRN No</td>
                    <td> :</td>
                    <td id="lblPRNno"><?php echo $prn_hed->PRN_No;?></td>
                    <td colspan="3" style="text-align:center;font-size:20px;"> <b>Purchase Return Note</b></td>
                </tr>
                <tr style="text-align:left;font-size:13px;">
                    <td> Date</td>
                    <td> :</td>
                    <td id="lblinvDate"><?php echo $prn_hed->PRN_Date?></td>
                    <td colspan="3" style="text-align:center;font-size:20px;"></td>
                </tr>
                <tr style="text-align:left;font-size:13px;">
                    <td> Supplier</td>
                    <td> :</td>
                    <td id="lblcusName" colspan="4"><?php echo $prn_hed->SupName;?></td>
                </tr>
                <tr style="text-align:left;font-size:13px;">
                    <td> Address</td>
                    <td> :</td>
                    <td rowspan="2" id="lblAddress" valign="top"><?php echo ($prn_hed->Address01)." ".$prn_hed->Address02."<br>".$prn_hed->Address03;?></td>
                    <td class="text-right">GRN No</td>
                    <td>: </td>
                    <td  id="lblinvNo"> <?php echo $prn_hed->GRN_No?></td>
                </tr>
                <tr style="text-align:left;font-size:13px;">
                    <td> </td>
                    <td></td>
                    <td class="text-right">Invoice No </td>
                    <td> :</td>
                    <td  id="lblAddCharge">  <?php echo ($prn_hed->GRN_InvoiceNo)?></td>
                </tr>
                
                 <tr style="text-align:left;font-size:13px;">
                    <td colspan="6">&nbsp;</td>
                </tr>
            </table>
            <style type="text/css" media="screen">
                #tbl_est_data tbody tr td{
                padding: 13px;
            }
            </style>
                <table id="tbl_est_data" style="border-collapse:collapse;width:700px;padding:5px;font-size:13px;" border="1">
                    <thead>
                        
                        <tr>
                            <th style='padding: 3px;'>#</th>
                            <th style='padding: 3px;'>Code</th>
                            <th style='padding: 3px;'>Description</th>
                            <th style='padding: 3px;'>Qty</th>
                            <th style='padding: 3px;'>Cost Price</th>
                            <!-- <th style='padding: 3px;'>Unit Price</th> -->
                            <th style='padding: 3px;'>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i=1;$total=0; foreach ($prn AS $dtl) { ?>
                    
                    <tr style="font-size:13px;">
                       <td style="padding: 5px"><?php echo $i;?></td>
                       <td style="padding: 5px"><?php echo $dtl->PRN_Product?></td>
                       <td style="padding: 5px"><?php echo $dtl->Prd_Description."<br>".$dtl->Serial;?></td>
                       <td style="padding: 5px"><?php echo number_format($dtl->PRN_Qty,2)?></td>
                       <td class="text-right" style="padding: 5px"><?php echo number_format($dtl->PRN_UnitCost,2); ?></td>
                       <!-- <td class="text-right" style="padding: 5px"><?php echo number_format($dtl->PRN_Selling,2); ?></td> -->
                      <!--  <td class="text-right" style="padding: 5px"><?php echo number_format($dtl->PRN_DisAmount,2); ?></td>
                       <td class="text-right" style="padding: 5px"><?php echo number_format($dtl->PRN_VatAmount,2); ?></td>
                       <td class="text-right" style="padding: 5px"><?php echo number_format($dtl->PRN_NbtAmount,2); ?></td> -->
                       <td class="text-right" style="padding: 5px"><?php echo number_format($dtl->PRN_Amount,2); ?></td>
                       </tr>                      
                      
                       <?php $i++; $total+=$dtl->PRN_Amount;
                       } ?>
                    </tbody>
                    <tfoot>
                        <tr><th colspan="4" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></th><th style="text-align:right">Total Amount  </th><th id="lbltotalAmount"   style='text-align:right'><?php echo number_format($prn_hed->PRN_Cost_Amount,2)?></th></tr>
                      
                        </tfoot>
                </table>
                <table style="width:700px;" border="0">
                        <tr><td colspan="5" style="text-align:left;">&nbsp;</td></tr>
                        <tr>
                            <td colspan="5" style="text-align:right;">&nbsp;</td></tr>
                        <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>
                        <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>
                        <tr><td style="border-bottom:1px dashed #000;width:100px" >&nbsp;</td><td style="">&nbsp;</td>
                            <td style="border-bottom:0px dashed #000;width:200px">&nbsp;</td>
                            <td style="">&nbsp;</td>
                           <td style="border-bottom:1px dashed #000;width:200px">&nbsp;</td>
                       </tr>
                       <tr>
                            <td style="width:100px;text-align: center">Approved By</td>
                            <td style="">&nbsp;</td>
                            <td style="width:200px;text-align: center"></td>
                            <td style="">&nbsp;</td>
                            <td style="width:200px;text-align: center">Signature</td>
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
</style>
<script type="text/javascript">
    $("#btnPrint").click(function(){
        $('#printArea').focus().print();
    });
</script>
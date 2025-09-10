Pdf</a><?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style type="text/css">
    #gridarea {
        display: flex;
        overflow:scroll;
        background: rgba(136, 153, 119, 0.23);
        height: 400px;
        padding: 2px;
    }

    #tbl_est_data tbody tr td{
        padding: 13px;
    }

    .editrowClass {
      background-color: #f1b9b9;
    }

    .fullpad div {
      padding-left: 0px;
      padding-right: 0px;
    }
</style>
<div class="content-wrapper" id="app">
    <div class="box-header" style="background: #b4f3c8">
                    <div class="col-sm-4"><span><b><?php echo $pagetitle; ?></b></span>
                            
                    </div>
                    <div class="col-sm-8">
                        <div class="row">
                            <?php if($invHed->InvIsCancel==1){$disabled='disabled'; }else{$disabled='';}?>
                            
                            <div class="col-sm-2"></div>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-1"></div>
                            <div class="col-sm-2"><button type="button" id="btnPrint" class="btn btn-primary btn-sm btn-block">Print</button></div>
                            <!--div class="col-sm-1"><a href="<?php echo base_url('admin/Salesinvoice/view_sales_invoice_pdf/').base64_encode($invNo); ?>" target="blank_" class="btn btn-primary btn-sm">Pdf</a></div-->
                            <div class="col-sm-1"><a href="<?php echo base_url('admin/Salesinvoice/addSalesInvoice?action=1&id=').base64_encode($invNo); ?>" target="blank_" class="btn btn-info btn-sm">Clone</a></div>
                            <div class="col-sm-1"><a href="<?php echo base_url('admin/Salesinvoice/addSalesInvoice?action=2&id=').base64_encode($invNo); ?>" target="blank_" class="btn btn-info btn-sm">Edit</a></div>
                            <div class="col-sm-2"><?php if($invHed->InvIsCancel==0){?>
                            <button type="button" <?php echo $disabled;?>  id="btnCancel" class="btn btn-danger btn-sm btn-block">Cancel</button><?php } ?></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                            </div>
                        </div>       
                    </div>
                        <!-- </div> -->
                    </div><!-- /.box-header -->
 
    <section class="content">
      <div class="row">
        <div class="col-lg-8">
          <input type="hidden" name="inv" id="inv" value="<?php echo $invNo;?>">
        <div class="row"  align="center" style='margin:5px;'>
                                <!-- load comapny common header -->
    <?php $this->load->view('admin/_templates/company_header_new.php',true); ?>
<table style="border-collapse:collapse;width:90%;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
    <tr style="text-align:left;font-size:13px;">
        <td></td>
        <td> </td>
        <td > &nbsp;</td>
        <td> &nbsp;</td>
        <td colspan="3" style="text-align:center;font-size:20px;font-weight: bold;" ><span id="lblInvType">
        <?php if($invHed->SalesInvType==2){?>
        <!-- Tax Invoice -->
        <?php }elseif($invHed->SalesInvType==1) { ?>
        <!-- Invoice -->
        <?php } ?></span> </td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
      <td colspan="2">Bill To :</td>
      <td> &nbsp;</td>
      <td>Invoice Date</td>
      <td></td>
      <td colspan="2"> <?php echo $invHed->SalesDate;?></td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
    <td colspan="2" rowspan="4" style="font-size:14px;width:350px;">
            <span id="lblcusName"><a href="<?php echo base_url('admin/payment/view_customer/').$invCus->CusCode ?>"><?php echo $invCus->DisplayName;?></a></span><br>
            <span id="lbladdress1"><?php echo nl2br($invCus->Address01)."<br>".$invCus->Address02." ".$invCus->Address03;?></span><br>
            Tel : <?php echo $invCus->LanLineNo;?> <?php echo $invCus->MobileNo;?>
            <!-- <span id="lbladdress2"><?php echo $invCus->Address03;?></span><br> -->
        </td>
        <td> &nbsp;</td>
        <td>PO Number</td>
        <td></td>
        <td colspan="2" id="lblPoNo"><?php echo $invHed->SalesPONumber;?></td>
    </tr>
    
    <tr style="text-align:left;font-size:13px;">
    <td> &nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="2" > &nbsp;</td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
    <td> &nbsp;</td>
        <td>Vehicle  Number</td>
        <td>:</td>
        <td colspan="2" id="lblinvDate"><?php echo $invHed->SalesVehicle;?></td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td> &nbsp;</td>
        <td>VIN Number</td>
        <td>:</td>
        <td colspan="2" id="lblinvDate"><?php if(isset($invVehi)){ echo $invVehi->ChassisNo;}?></td>
    </tr>
   <tr style="text-align:right;font-size:13px;">
        <td style="text-align:left;font-size:13px;" colspan="2">Bill Issued By : <?php if(isset($invHed)){echo $invHed->first_name; } ?></td><td></td><td style="text-align:left;font-size:13px;">Insurer</td><td></td><td colspan="2" style="text-align:left;font-size:13px;"><?php echo $invHed->VComName; ?></td>
    </tr>
    <?php if($invHed->SalesInvType==2){?>
     <tr style="text-align:right;font-size:13px;">
        <td colspan="2" ></td><td colspan="5" style="text-align: right;padding-top: 13px;">VAT Reg. No : <?php echo $company['Email02'] ?></td>
    </tr><?php }else{ ?><tr style="text-align:right;font-size:13px;">
        <td colspan="2" ></td><td colspan="5" style="text-align: right;padding-top: 13px;"></td>
    </tr><?php } ?>
</table>
<style type="text/css" media="screen">

    #tbl_po_data2 tbody tr td{
    padding: 5px  !important;
    border-bottom:1px solid #fff !important;
}
</style>
<table id="tbl_po_data" style="border-collapse:collapse;width:700px;padding:5px;font-size:13px;" border="0">
                <?php if($invHed->SalesInvType==2 || $invHed->SalesInvType==3){?>
                    <thead id="taxHead">
                        <tr><td colspan="5" style="border-top:1px solid #fff;border-left:1px solid #fff;border-right:1px solid #fff;text-align: right;"></td></tr>
                        <tr style="background-color:#5d5858 !important;color:#fff !important;line-height:20px;">
                            <th style='padding: 3px;color:#fff !important;'>#</th>
                            <th style='padding: 3px;color:#fff !important;'>Item & Description</th>
                            <!-- <th style='padding: 3px;'></th> -->
                            <th style='padding: 3px;color:#fff !important;'>Qty</th>
                            
                            <th style='padding: 3px;color:#fff !important;text-align:right;' >Rate</th>
                            <th style='padding: 3px;color:#fff !important;text-align:right;'>Amount</th>
                        </tr>
                    </thead>
                  <?php }elseif($invHed->SalesInvType==1){?>
                    <thead  id="invHead">
                        <tr style="background-color:#5d5858 !important;color:#fff !important;line-height:20px;">
                            <th style='padding: 3px;color:#fff !important;'>#</th>
                            <th style='padding: 3px;color:#fff !important;'>Item & Description</th>
                            <!-- <th style='padding: 3px;'></th> -->
                            <th style='padding: 3px;color:#fff !important;'>Qty</th>
                            
                            <th style='padding: 3px;color:#fff !important;text-align:right;'>Rate</th>
                            <th style='padding: 3px;color:#fff !important;text-align:right;'>Amount</th>
                        </tr>
                    </thead>
                    <?php } ?>
                    <tbody>
                    <?php 
 $i=1;
                     //var_dump($invDtlArr);
                    foreach ($invDtl AS $invdata) {

                      if($invHed->SalesInvType==1 || $invHed->SalesInvType==3){
                      //normal invoice
                       
                         ?>
                        <tr style="line-height:20px;">
                          <td style="border-bottom:1px solid #e4dbdb;"><?php echo $i;?></td>
        
                          <td style="border-bottom:1px solid #e4dbdb;" ><?php echo $invdata->SalesProductName."<br>".$invdata->SalesSerialNo;?></td>
                         <td style="border-bottom:1px solid #e4dbdb;"><?php echo number_format(($invdata->SalesQty),2)?></td>
                          <td style="border-bottom:1px solid #e4dbdb;" class='text-right'><?php echo number_format(($invdata->SalesUnitPrice),2)?></td>
                          <td style="border-bottom:1px solid #e4dbdb;" class='text-right'><?php echo number_format(($invdata->SalesInvNetAmount),2)?></td>
                        </tr>
                    <?php $i++; 
                         
                      }elseif($invHed->SalesInvType==2){
                      //Tax Invoice
                        
                         ?>
                        <tr style="line-height:20px;">
                          <td style="border-bottom:1px solid #e4dbdb;"><?php echo $i;?></td>
                          <td style="border-bottom:1px solid #e4dbdb;" ><?php echo $invdata->SalesProductName."<br>".$invdata->SalesSerialNo;?></td>
                          <td style="border-bottom:1px solid #e4dbdb;"><?php echo number_format(($invdata->SalesQty),2)?></td>
                          <td style="border-bottom:1px solid #e4dbdb;" class='text-right'><?php echo number_format(($invdata->SalesUnitPrice),2)?></td>
                          <td style="border-bottom:1px solid #e4dbdb;" class='text-right'><?php echo number_format(($invdata->SalesTotalAmount),2)?></td>
                        </tr>
                    <?php $i++; 
                        
                      }
                    }//foreach end
                       ?>                    
                    </tbody>
                    <tfoot>
                    <?php
                    $payment_term ='';
                     if($invHed->SalesInvType==2){ ?>
                        <tr style="line-height:25px;" id="rowTotal"><td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right;padding: 3px;">Sub Total </td><td id="lbltotalPOAmount"   style='text-align:right;padding: 3px;'><?php echo number_format($invHed->SalesInvAmount,2);?></td></tr><?php }else{ ?> 
                        <tr style="line-height:25px;" id="rowTotal"><td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right;padding: 3px;">Sub Total </td><td id="lbltotalPOAmount"   style='text-align:right;padding: 3px;'><?php echo number_format($invHed->SalesInvAmount,2);?></td></tr>
                        <?php } ?>
                        <?php if($invHed->SalesDisAmount>0){?>
                         <tr style="line-height:25px;" id="rowDiscount">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Discount  </td><td id="lbltotalDicount"   style='text-align:right'><?php echo number_format($invHed->SalesDisAmount,2);?></td>
                         </tr>
                          <?php }?>
                         <?php if($invHed->SalesVatAmount>0 && $invHed->SalesInvType==2){?>
                         <tr style="line-height:25px;" id="rowVAT">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">VAT Amount  </td><td id="lbltotalVat"   style='text-align:right'><?php echo number_format($invHed->SalesVatAmount,2);?></td>
                         </tr><?php } ?>
                          <?php if($invHed->SalesNbtAmount>0 && $invHed->SalesInvType==2){?>
                        <tr style="line-height:25px;" id="rowNBT">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">NBT Amount  </td><td id="lbltotalNbt"   style='text-align:right'><?php echo number_format($invHed->SalesNbtAmount,2);?></td>
                        </tr>
                         <?php } ?>
                         <?php if($invHed->SalesShipping>0){?>
                         <tr style="line-height:25px;" id="rowDiscount">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right"><?php echo $invHed->SalesShippingLabel; ?>  </td><td id="lbltotalDicount"   style='text-align:right'><?php echo number_format($invHed->SalesShipping,2);?></td>
                         </tr>
                          <?php }?>
                         <?php if($invHed->SalesVatAmount>0 || $invHed->SalesNbtAmount>0 || $invHed->SalesShipping>0 || $invHed->SalesDisAmount>0){?>
                        <tr style="line-height:25px;" id="rowNET">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="font-weight:bold;text-align:right">Total  </td><td id="lbltotalNet"   style='font-weight:bold;text-align:right'><?php echo number_format($invHed->SalesNetAmount,2);?></td>
                        </tr>
                        <?php } ?>
                        <?php if($invHed->SalesAdvancePayment>0){
                            $payment_term="Advance";
                          ?>
                         <tr style="line-height:25px;" id="rowDiscount">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Advance Amount  </td><td id="lbltotalDicount"   style='text-align:right'><?php echo number_format($invHed->SalesAdvancePayment,2);?></td>
                         </tr>
                          <?php }?>
                        <?php if($invHed->SalesCashAmount>0){
                          $payment_term="Cash";
                          ?>
                         <tr style="line-height:25px;" id="rowDiscount">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Cash Amount  </td><td id="lbltotalDicount"   style='text-align:right'><?php echo number_format($invHed->SalesCashAmount,2);?></td>
                         </tr>
                          <?php }?>
                          <?php if($invHed->SalesBankAmount>0){
                          $payment_term="Bank";
                          ?>
                        <tr style="line-height:25px;" id="rowNBT">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Bank Transfer  </td><td id="lbltotalNbt"   style='text-align:right'><?php echo number_format($invHed->SalesBankAmount,2);?></td>
                        </tr>
                         <?php } ?>
                          <?php if($invHed->SalesChequeAmount>0){
                            $payment_term="Cheque";
                            ?>
                        <tr style="line-height:25px;" id="rowNBT">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Cheque  Amount  </td><td id="lbltotalNbt"   style='text-align:right'><?php echo number_format($invHed->SalesChequeAmount,2);?></td>
                        </tr>
                         <?php } ?>
                         <?php if($invHed->SalesCCardAmount>0){
                          $payment_term="Card";
                          ?>
                        <tr style="line-height:25px;" id="rowNBT">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Card Amount  </td><td id="lbltotalNbt"   style='text-align:right'><?php echo number_format($invHed->SalesCCardAmount,2);?></td>
                        </tr>
                         <?php } ?>
                         

                         <?php if($invHed->SalesCreditAmount>0){
                          $payment_term="Credit";
                          ?>
                         <tr style="line-height:25px;" id="rowVAT">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right;font-weight:bold;background-color:#e4dbdb !important;">TOTAL PAYABLE  </td><td id="lbltotalVat"   style='font-weight:bold;text-align:right;background-color:#e4dbdb !important;'><?php echo number_format($invHed->SalesCreditAmount,2);?></td>
                         </tr><?php } ?>
                          
                    </tfoot>
                </table>
                <table style="width:700px;" border="0">
                        <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>
                         <tr><td colspan="5" style="text-align:left;">&nbsp;&nbsp;<b>Term & Conditions</b></td></tr>
                         <tr><td colspan="5" style="text-align:left;">
                           <ul>
                             <li>No cash refunds.</li>
                             <li>If supplied part is faulty has to be tested at Avinda workshop before returned.</li>
                             <li>Returns accepted only within a week of transaction date.</li>
                             <?php if($invHed->SalesCreditAmount>0){ ?>
                             <li>Payment to be made within 1 month of transaction date</li>
                             <?php } ?>
                           </ul>
                         </td></tr>
                           <tr><td colspan="5" style="text-align:right;width:690px;">&nbsp;</td></tr> 
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
                            <td style="text-align: center">Issued By</td>
                            <td style="">&nbsp;</td>
                            <td style="text-align: center">Checked By</td>
                            <td style="">&nbsp;</td>
                            <td style="text-align: center">Customer Signature</td>
                        </tr>
                        <tr>
                            <td style="text-align: center"> <?php //echo $invHed->first_name; ?> </td>
                            <td style="">&nbsp;</td>
                            <td style="text-align: center"></td>
                            <td style="">&nbsp;</td>
                            <td style="text-align: center">I have received mentioned items.</td>
                        </tr>
                        <?php if($invHed->SalesCreditAmount>0){ ?>
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
                            <td style="text-align: center">On behalf of Customer Signature
                            </td>
                            <td style="">&nbsp;</td>
                            <td style="text-align: center">Name</td>
                            <td style="">&nbsp;</td>
                            <td style="text-align: center">NIC</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;"></td>
                            <td style="">&nbsp;</td>
                            <td style="text-align: center"></td>
                            <td style="">&nbsp;</td>
                            <td style="text-align: center"></td>
                        </tr>
                        <?php } ?>
                        <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr> 
                        <tr><td colspan="5" style="text-align:center;font-size: 18px;"><i>Avinda Enterprises Your Trusted Partner For Mercedes-Benz Solutions</i></td></tr>
                    </table>
    <style type="text/css" media="screen">
    #tbl_po_data tbody tr td{
        padding: 13px;
    }
</style>
</div>
        </div>
        <div class="col-lg-4">
          <table class="table">
            <tr><td>Create by</td><td>:</td><td><?php echo $invHed->first_name." ".$invHed->last_name ?></td></tr>
            <tr><td>Create Date</td><td>:</td><td><?php echo $invHed->SalesDate ?></td></tr>
            <?php if($invCancel): ?>
            <tr><td>Cancel By</td><td>:</td><td><?php echo $invCancel->first_name." ".$invHed->last_name ?></td></tr>
            <tr><td>Cancel Date</td><td>:</td><td><?php echo $invCancel->CancelDate ?></td></tr>
            <tr><td>Remark</td><td>:</td><td><?php echo $invCancel->Remark ?></td></tr>
          <?php endif; ?>
          <?php if($invUpdate):  ?>
          <tr><td colspan="3">Last Updates</td></tr>
          <?php  foreach ($invUpdate AS $up) { ?>
            <tr><td><?php echo $up->UpdateDate ?></td><td>:</td><td><?php echo $up->first_name." ".$up->last_name ?></td></tr>
          <?php }
          endif; ?>
          </table>
        </div>
      </div>
    
</section>
    <div>
    </div>
</div>
 <!-- print parts goes here -->
        <div class="modal fade bs-payment-modal-lg" id="modelInvoice" tabindex="-1" role="dialog" aria-hidden="false">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content"><div class="modal-body" >
                    <div class="row" id="printArea" align="center" style='margin:5px;'>
                                <!-- load comapny common header -->
    <?php $this->load->view('admin/_templates/company_header_new.php',true); ?>
<table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
    <tr style="text-align:left;font-size:13px;">
        <td></td>
        <td> </td>
        <td > &nbsp;</td>
        <td> &nbsp;</td>
        <td colspan="3" style="text-align:center;font-size:20px;font-weight: bold;" ><span id="lblInvType">
        <?php if($invHed->SalesInvType==2){?>
        Tax Invoice
        <?php }elseif($invHed->SalesInvType==1) { ?>
        Invoice
        <?php } ?></span> </td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
    <td colspan="2">Bill To :</td>
<td> &nbsp;</td>
        <td>Invoice Date</td>
      <td></td>
      <td colspan="2"> <?php echo $invHed->SalesDate;?></td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
    <td colspan="2" rowspan="4" style="font-size:14px;width:250px;">
            <span id="lblcusName"><?php echo $invCus->DisplayName;?></span><br>
            <span id="lbladdress1"><?php echo nl2br($invCus->Address01)."<br>".$invCus->Address02." ".$invCus->Address03;?></span><br>
            Tel : <?php echo $invCus->LanLineNo;?> <?php echo $invCus->MobileNo;?>
            <!-- <span id="lbladdress2"><?php echo $invCus->Address03;?></span><br> -->
        </td>
        <td> &nbsp;</td>
        <td>PO Number</td>
        <td></td>
        <td colspan="2" id="lblPoNo"><?php echo $invHed->SalesPONumber;?></td>
    </tr>
    
    <tr style="text-align:left;font-size:13px;">
    <td> &nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="2" > &nbsp;</td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
    <td> &nbsp;</td>
        <td>Vehicle Number</td>
        <td>:</td>
        <td colspan="2" id="lblinvDate"><?php echo $invHed->SalesVehicle;?></td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td> &nbsp;</td>
        <td>VIN Number</td>
        <td>:</td>
        <td colspan="2" id="lblinvDate"><?php if(isset($invVehi)){ echo $invVehi->ChassisNo;}?></td>
    </tr>
   <tr style="text-align:right;font-size:13px;">
        <td style="text-align:left;font-size:13px;" colspan="2">Bill Issued By : <?php //if(isset($invSales)){echo $invSales->RepName; } ?></td><td></td><td style="text-align:left;font-size:13px;"></td><td>:</td><td colspan="2"></td>
    </tr>
    <?php if($invHed->SalesInvType==2){?>
     <tr style="text-align:right;font-size:13px;">
        <td colspan="2" ></td><td colspan="5" style="text-align: right;padding-top: 13px;">VAT Reg. No : <?php echo $company['Email02'] ?></td>
    </tr><?php }else{ ?><tr style="text-align:right;font-size:13px;">
        <td colspan="2" ></td><td colspan="5" style="text-align: right;padding-top: 13px;"></td>
    </tr><?php } ?>
</table>
<style type="text/css" media="screen">

    #tbl_po_data2 tbody tr td{
    padding: 5px  !important;
    border-bottom:1px solid #fff !important;
}
</style>
<table id="tbl_po_data2" style="border-collapse:collapse;width:700px;padding:5px;font-size:15px;" border="0">
                <?php if($invHed->SalesInvType==2 || $invHed->SalesInvType==3){?>
                    <thead id="taxHead">
                        <tr><td colspan="5" style="border-top:1px solid #fff;border-left:1px solid #fff;border-right:1px solid #fff;text-align: right;"></td></tr>
                        <tr style="background-color:#5d5858 !important;color:#fff !important;line-height:25px;">
                            <th style='padding: 3px;width:20px;color:#fff !important;'>#</th>
                            <th style='padding: 3px;width:200px;color:#fff !important;'>Item & Description</th>
                            <!-- <th style='padding: 3px;'></th> -->
                            <th style='padding: 3px;width:30px;color:#fff !important;'>Qty</th>
                            
                            <th style='padding: 3px;width:80px;color:#fff !important;text-align:right;' >Rate</th>
                            <th style='padding: 3px;width:80px;color:#fff !important;text-align:right;'>Amount</th>
                        </tr>
                    </thead>
                  <?php }elseif($invHed->SalesInvType==1){?>
                    <thead  id="invHead">
                        <tr style="background-color:#5d5858 !important;color:#fff !important;line-height:25px;">
                            <th style='padding: 3px;width:20px;color:#fff !important;'>#</th>
                            <th style='padding: 3px;width:200px;color:#fff !important;'>Item & Description</th>
                            <!-- <th style='padding: 3px;'></th> -->
                            <th style='padding: 3px;width:30px;color:#fff !important;'>Qty</th>
                            
                            <th style='padding: 3px;width:80px;color:#fff !important;text-align:right;'>Rate</th>
                            <th style='padding: 3px;width:80px;color:#fff !important;text-align:right;'>Amount</th>
                        </tr>
                    </thead>
                    <?php } ?>
                    <tbody>
                    <?php 
 $i=1;
                     //var_dump($invDtlArr);
                    foreach ($invDtl AS $invdata) {

                      if($invHed->SalesInvType==1 || $invHed->SalesInvType==3){
                      //normal invoice
                       
                         ?>
                        <tr style="line-height:25px;">
                          <td style="border-bottom:1px solid #e4dbdb;"><?php echo $i;?></td>
        
                          <td style="border-bottom:1px solid #e4dbdb;" ><?php echo $invdata->SalesProductName."<br>".$invdata->SalesSerialNo;?></td>
                         <td style="border-bottom:1px solid #e4dbdb;"><?php echo number_format(($invdata->SalesQty),2)?></td>
                          <td style="border-bottom:1px solid #e4dbdb;" class='text-right'><?php echo number_format(($invdata->SalesUnitPrice),2)?></td>
                          <td style="border-bottom:1px solid #e4dbdb;" class='text-right'><?php echo number_format(($invdata->SalesInvNetAmount),2)?></td>
                        </tr>
                    <?php $i++; 
                         
                      }elseif($invHed->SalesInvType==2){
                      //Tax Invoice
                        
                         ?>
                        <tr style="line-height:25px;">
                          <td style="border-bottom:1px solid #e4dbdb;"><?php echo $i;?></td>
                          <td style="border-bottom:1px solid #e4dbdb;" ><?php echo $invdata->SalesProductName."<br>".$invdata->SalesSerialNo;?></td>
                          <td style="border-bottom:1px solid #e4dbdb;"><?php echo number_format(($invdata->SalesQty),2)?></td>
                          <td style="border-bottom:1px solid #e4dbdb;" class='text-right'><?php echo number_format(($invdata->SalesUnitPrice),2)?></td>
                          <td style="border-bottom:1px solid #e4dbdb;" class='text-right'><?php echo number_format(($invdata->SalesTotalAmount),2)?></td>
                        </tr>
                    <?php $i++; 
                        
                      }
                    }//foreach end
                       ?>                    
                    </tbody>
                    <tfoot>
                    <?php
                    $payment_term ='';
                     if($invHed->SalesInvType==2){ ?>
                        <tr style="line-height:25px;" id="rowTotal"><td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right;padding: 3px;">Sub Total </td><td id="lbltotalPOAmount"   style='text-align:right;padding: 3px;'><?php echo number_format($invHed->SalesInvAmount,2);?></td></tr><?php }else{ ?> 
                        <tr style="line-height:25px;" id="rowTotal"><td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right;padding: 3px;">Sub Total </td><td id="lbltotalPOAmount"   style='text-align:right;padding: 3px;'><?php echo number_format($invHed->SalesInvAmount,2);?></td></tr>
                        <?php } ?>
                        <?php if($invHed->SalesDisAmount>0){?>
                         <tr style="line-height:25px;" id="rowDiscount">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Discount  </td><td id="lbltotalDicount"   style='text-align:right'><?php echo number_format($invHed->SalesDisAmount,2);?></td>
                         </tr>
                          <?php }?>
                         <?php if($invHed->SalesVatAmount>0 && $invHed->SalesInvType==2){?>
                         <tr style="line-height:25px;" id="rowVAT">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">VAT Amount  </td><td id="lbltotalVat"   style='text-align:right'><?php echo number_format($invHed->SalesVatAmount,2);?></td>
                         </tr><?php } ?>
                          <?php if($invHed->SalesNbtAmount>0 && $invHed->SalesInvType==2){?>
                        <tr style="line-height:25px;" id="rowNBT">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">NBT Amount  </td><td id="lbltotalNbt"   style='text-align:right'><?php echo number_format($invHed->SalesNbtAmount,2);?></td>
                        </tr>
                         <?php } ?>
                         <?php if($invHed->SalesShipping>0){?>
                         <tr style="line-height:25px;" id="rowDiscount">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right"><?php echo $invHed->SalesShippingLabel; ?>  </td><td id="lbltotalDicount"   style='text-align:right'><?php echo number_format($invHed->SalesShipping,2);?></td>
                         </tr>
                          <?php }?>
                         <?php if($invHed->SalesVatAmount>0 || $invHed->SalesShipping>0 || $invHed->SalesNbtAmount>0 || $invHed->SalesDisAmount>0){?>
                        <tr style="line-height:25px;" id="rowNET">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="font-weight:bold;text-align:right">Total  </td><td id="lbltotalNet"   style='font-weight:bold;text-align:right'><?php echo number_format($invHed->SalesNetAmount,2);?></td>
                        </tr>
                        <?php } ?>
                        <?php if($invHed->SalesAdvancePayment>0){
                            $payment_term="Advance";
                          ?>
                         <tr style="line-height:25px;" id="rowDiscount">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Advance Amount  </td><td id="lbltotalDicount"   style='text-align:right'><?php echo number_format($invHed->SalesAdvancePayment,2);?></td>
                         </tr>
                          <?php }?>
                        <?php if($invHed->SalesCashAmount>0){
                          $payment_term="Cash";
                          ?>
                         <tr style="line-height:25px;" id="rowDiscount">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Cash Amount  </td><td id="lbltotalDicount"   style='text-align:right'><?php echo number_format($invHed->SalesCashAmount,2);?></td>
                         </tr>
                          <?php }?>
                          <?php if($invHed->SalesBankAmount>0){
                          $payment_term="Bank";
                          ?>
                        <tr style="line-height:25px;" id="rowNBT">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Bank Transfer  </td><td id="lbltotalNbt"   style='text-align:right'><?php echo number_format($invHed->SalesBankAmount,2);?></td>
                        </tr>
                         <?php } ?>
                         <?php if($invHed->SalesChequeAmount>0){
                            $payment_term="Cheque";
                            ?>
                        <tr style="line-height:25px;" id="rowNBT">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Cheque  Amount  </td><td id="lbltotalNbt"   style='text-align:right'><?php echo number_format($invHed->SalesChequeAmount,2);?></td>
                        </tr>
                         <?php } ?>
                         <?php if($invHed->SalesCCardAmount>0){
                          $payment_term="Card";
                          ?>
                        <tr style="line-height:25px;" id="rowNBT">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Card Amount  </td><td id="lbltotalNbt"   style='text-align:right'><?php echo number_format($invHed->SalesCCardAmount,2);?></td>
                        </tr>
                         <?php } ?>
                         <?php if($invHed->SalesCreditAmount>0){
                          $payment_term="Credit";
                          ?>
                         <tr style="line-height:25px;" id="rowVAT">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right;font-weight:bold;background-color:#e4dbdb !important;">TOTAL PAYABLE  </td><td id="lbltotalVat"   style='font-weight:bold;text-align:right;background-color:#e4dbdb !important;'><?php echo number_format($invHed->SalesCreditAmount,2);?></td>
                         </tr><?php } ?>
                          
                    </tfoot>
                </table>
                <table style="width:700px;" border="0">
                        <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>
                         <tr><td colspan="5" style="text-align:left;">&nbsp;&nbsp;<b>Term & Conditions</b></td></tr>
                         <tr><td colspan="5" style="text-align:left;">
                           <ul>
                             <li>No cash refunds.</li>
                             <li>If supplied part is faulty has to be tested at Avinda workshop before returned.</li>
                             <li>Returns accepted only within a week of transaction date.</li>
                             <?php if($invHed->SalesCreditAmount>0){ ?>
                             <li>Payment to be made within 1 month of transaction date</li>
                             <?php } ?>
                           </ul>
                         </td></tr>
                           <tr><td colspan="5" style="text-align:right;width:690px;">&nbsp;</td></tr> 
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
                            <td style="text-align: center">Issued By</td>
                            <td style="">&nbsp;</td>
                            <td style="text-align: center">Checked By</td>
                            <td style="">&nbsp;</td>
                            <td style="text-align: center">Customer Signature</td>
                        </tr>
                        <tr>
                            <td style="text-align: center"> <?php //echo $invHed->first_name; ?> </td>
                            <td style="">&nbsp;</td>
                            <td style="text-align: center"></td>
                            <td style="">&nbsp;</td>
                            <td style="text-align: center">I have received mentioned items.</td>
                        </tr>
                        <?php if($invHed->SalesCreditAmount>0){ ?>
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
                            <td style="text-align: center">On behalf of Customer Signature
                            </td>
                            <td style="">&nbsp;</td>
                            <td style="text-align: center">Name</td>
                            <td style="">&nbsp;</td>
                            <td style="text-align: center">NIC</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;"></td>
                            <td style="">&nbsp;</td>
                            <td style="text-align: center"></td>
                            <td style="">&nbsp;</td>
                            <td style="text-align: center"></td>
                        </tr>
                        <?php } ?>
                        <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr> 
                        <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr> 
                        <tr><td colspan="5" style="text-align:center;font-size: 18px;"><i>Avinda Enterprises Your Trusted Partner For Mercedes-Benz Solutions</i></td></tr>
                    </table>
                    </div>
                </div>
              </div>
            </div>
        </div>
<!-- print 2 -->
        
<script type="text/javascript">

var inv =$("#inv").val();

$("#btnPrint").click(function(){
$('#printArea').focus().print();
});

$("#btnPrint2").click(function(){
$('#printArea2').focus().print();
});


$("#btnCancel").click(function(){

  var r = prompt('Do you really want to cancel this invoice? Please enter a remark.');

    if (r == null || r=='') {
      return false; 
    }else{
      cancelInvoice(inv,r);
      return false;
    }
});

  var bottom = 0;
  var pagNum = 2; /* First sequence - Second number */

  $(document).ready(function() {
    /* For each 10 paragraphs, this function: clones the h3 with a new page number */

    $("table:nth-child(10n)").each(function() {
      bottom -= 100;
      botString = bottom.toString();
      var $counter = $('h3.pag1').clone().removeClass('pag1');
      $counter.css("bottom", botString + "vh");
      numString = pagNum.toString();
      $counter.addClass("pag" + numString);
      ($counter).insertBefore('.insert');
      pagNum = parseInt(numString);
      pagNum++; /* Next number */
    });

    var pagTotal = $('.pag').length; /* Gets the total amount of pages by total classes of paragraphs */

    pagTotalString = pagTotal.toString();
    $("h3[class^=pag]").each(function() {
      /* Gets the numbers of each classes and pages */
      var numId = this.className.match(/\d+/)[0];
      document.styleSheets[0].addRule('h3.pag' + numId + '::before', 'content: "Page ' + numId + ' of ' + pagTotalString + '";');
    });
  });

function cancelInvoice(invoice,remark) {
  $.ajax({
        url:'../../salesinvoice/cancelSalesInvoice',
        dataType:'json',
        type:'POST',
        data:{salesinvno:invoice,remark:remark},
        success:function(data) {
            if(data==1){
              $.notify("Invoice canceled successfully.", "success");
              $("#btnCancel").attr('disabled', true);
            }else if(data==2){
              $.notify("Error. Customer has done payment for this invoice. If you want to cancel this invoice please cancel the payment", "danger");
              $("#btnCancel").attr('disabled', false);
            }else if(data==3){
              $.notify("Error. Invoice has already canceled.", "danger");
              $("#btnCancel").attr('disabled', false);
            }else{
              $.notify("Error. Invoice not canceled successfully.", "danger");
              $("#btnCancel").attr('disabled', false);
            }
        }
      });
}



var Base64 = {
                _keyStr: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",

               

                encode: function(input) {

                    var output = "";

                    var chr1, chr2, chr3, enc1, enc2, enc3, enc4;

                    var i = 0;



                    input = Base64._utf8_encode(input);



                    while (i < input.length) {



                        chr1 = input.charCodeAt(i++);

                        chr2 = input.charCodeAt(i++);

                        chr3 = input.charCodeAt(i++);



                        enc1 = chr1 >> 2;

                        enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);

                        enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);

                        enc4 = chr3 & 63;



                        if (isNaN(chr2)) {

                            enc3 = enc4 = 64;

                        } else if (isNaN(chr3)) {

                            enc4 = 64;

                        }



                        output = output +

                                this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +

                                this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);



                    }



                    return output;

                },

               

                decode: function(input) {

                    var output = "";

                    var chr1, chr2, chr3;

                    var enc1, enc2, enc3, enc4;

                    var i = 0;



                    input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");



                    while (i < input.length) {



                        enc1 = this._keyStr.indexOf(input.charAt(i++));

                        enc2 = this._keyStr.indexOf(input.charAt(i++));

                        enc3 = this._keyStr.indexOf(input.charAt(i++));

                        enc4 = this._keyStr.indexOf(input.charAt(i++));



                        chr1 = (enc1 << 2) | (enc2 >> 4);

                        chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);

                        chr3 = ((enc3 & 3) << 6) | enc4;



                        output = output + String.fromCharCode(chr1);



                        if (enc3 != 64) {

                            output = output + String.fromCharCode(chr2);

                        }

                        if (enc4 != 64) {

                            output = output + String.fromCharCode(chr3);

                        }



                    }



                    output = Base64._utf8_decode(output);



                    return output;



                },

               

                _utf8_encode: function(string) {

                    string = string.replace(/\r\n/g, "\n");

                    var utftext = "";



                    for (var n = 0; n < string.length; n++) {



                        var c = string.charCodeAt(n);



                        if (c < 128) {

                            utftext += String.fromCharCode(c);

                        }

                        else if ((c > 127) && (c < 2048)) {

                            utftext += String.fromCharCode((c >> 6) | 192);

                            utftext += String.fromCharCode((c & 63) | 128);

                        }

                        else {

                            utftext += String.fromCharCode((c >> 12) | 224);

                            utftext += String.fromCharCode(((c >> 6) & 63) | 128);

                            utftext += String.fromCharCode((c & 63) | 128);

                        }



                    }



                    return utftext;

                },

           

                _utf8_decode: function(utftext) {

                    var string = "";

                    var i = 0;

                    var c = c1 = c2 = 0;



                    while (i < utftext.length) {



                        c = utftext.charCodeAt(i);



                        if (c < 128) {

                            string += String.fromCharCode(c);

                            i++;

                        }

                        else if ((c > 191) && (c < 224)) {

                            c2 = utftext.charCodeAt(i + 1);

                            string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));

                            i += 2;

                        }

                        else {

                            c2 = utftext.charCodeAt(i + 1);

                            c3 = utftext.charCodeAt(i + 2);

                            string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));

                            i += 3;

                        }



                    }



                    return string;

                }



            }

</script>
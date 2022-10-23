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
        <style>
            .rowselected{background-color: #f0ad4e;}
        </style>
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-success">

            <form role="form" id="addDep" data-parsley-validate method="post" action="#">
                <div class="modal-content">

                    <div class="modal-header">
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-remove"></i></span></button> -->
                        <!-- <h4 class="modal-title" id="myModalLabel2">Payment Details <span id="errPayment"></span></h4> -->
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            
                                <div class="col-md-4">
                                    
                                    <table class="table table-hover">
                                        <tbody>
                                        <tr><td>Supplier Code</td><td>:</td><td  id='mcash'  class='text-right'><?php echo $cus->SupCode?></td></tr>
                                            <tr><td>Supplier Name</td><td>:</td><td  id='mcash'  class='text-right'><?php echo $cus->SupName?></td></tr>
                                            <tr><td>Contact Person</td><td>:</td><td  id='mcash'  class='text-right'><?php echo $cus->TitleName.".".$cus->ContactPerson?></td></tr>
                                            <tr><td>Address</td><td>:</td><td  id='mcard'  class='text-right'><?php echo $cus->Address01?></td></tr>
                                            <tr><td>Mobile</td><td>:</td><td  id='mcheque'  class='text-right'>0<?php echo $cus->MobileNo?></td></tr>
                                            <tr><td>Phone</td><td>:</td><td  id='mcredit'  class='text-right'><?php echo $cus->LanLineNo?></td></tr>
                                            <tr><td>Email</td><td>:</td><td  id='mcompany'  class='text-right'><?php echo $cus->Email?></td></tr>
                                            <tr><td>Remarks</td><td>:</td><td  id='mcompany'  class='text-right'><?php echo $cus->Remark?></td></tr>
                                        </tbody>
                                    </table>
                                    <!--</div>-->
                                </div>
                                <div class="col-md-4">
                                    
                                    <table class="table table-hover">
                                        <tbody>
                                            <tr><td>Open Oustanding</td><td>:</td><td  id='mtotal'  class='text-right'><?php echo number_format($credit->OpenOustanding,2) ?></td></tr>
                                            <tr><td>Oustanding Amount</td><td>:</td><td  id='mdiscount'  class='text-right'><?php echo number_format($credit->SupOustandingAmount,2) ?></td></tr>
                                            <tr><td>Settlement Amount</td><td>:</td><td  id='madvance'  class='text-right'><?php echo number_format($credit->SupSettlementAmount,2) ?></td></tr>
                                            <tr><td>Oustanding Due Amount</td><td>:</td><td  id='mnetpay'  class='text-right'><?php echo number_format($credit->SupOustandingAmount,2)?></td></tr>
                                            <!-- <tr><td id='changeLable'>Change/Refund</td><td>:</td><td id='mchange' class='text-right'>0.00</td></tr> -->
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-4">
                                    
                                </div>

                                <div class="row" id='chequeData'>
                            
                        </div>
                           
                        </div> 
                        <div class="row">
                            <div class="col-md-12">
                            <h3>Credit Details</h3>
                                <table class="table table-hover">
                                <thead>
                                    <th>Invoice Date</th>
                                    <th>Invoice No</th>
                                    <th>Credit Amount</th>
                                    <th>Settled Amount</th>
                                    <th>Due Amount</th>
                                    <th>Is Settled</th>
                                    <th>Status</th>
                                </thead>
                                        <tbody>
                                        <?php foreach($credit_inv as $v){?>
                                        <tr>
                                           <td><?php echo $v->GRNDate;?></td>
                                           <td><?php echo $v->GRNNo;?></td>
                                           <td><?php echo number_format($v->CreditAmount,2);?></td>
                                           <td><?php echo number_format($v->SettledAmount,2);?></td>
                                          <td><?php echo number_format($v->CreditAmount-$v->SettledAmount,2);?></td>
                                           <td><?php echo printStats($v->IsCloseGRN,'Closed','success','Pending','warning','warning');?></td>
                                          <td><?php echo printStats($v->IsCancel,'Canceled','danger','Active','success','Active');?></td>
                                           </tr>
                                           <?php }?>
                                        </tbody>
                                    </table>
                                    <h3>Cheque Details</h3>
                                <table class="table table-hover">
                                    <thead>
                                        <th>Recived Date</th>
                                        <th>Cheque Owner</th>
                                        <th>Invoice Reference</th>
                                        <th>Bank</th>
                                        <th>Cheque No</th>
                                        <th>Cheque Date</th>
                                        <th>Cheque Amount</th>
                                        <th>Mode</th>
                                        <th>Is Release</th>
                                        <th>Status</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach($cheque as $v){?>
                                            <tr>
                                               <td><?php echo $v->ReceivedDate;?></td>
                                               <td><?php echo $v->ChequeOwner;?></td>
                                               <td><?php echo $v->ReferenceNo;?></td>
                                               <td><?php echo $v->BankName;?></td>
                                               <td><?php echo $v->ChequeNo;?></td>
                                               <td><?php echo $v->ChequeDate;?></td>
                                               <td><?php echo number_format($v->ChequeAmount,2);?></td>
                                               <td><?php echo ($v->Mode);?></td>
                                               <td><?php echo printStats($v->IsRelease,'Received','success','Pending','warning','warning');?></td>
                                              <td><?php echo printStats($v->IsCancel,'Canceld','danger','Active','success','success');?></td>
                                           </tr>
                                       <?php }?>
                                    </tbody>
                                    </table>
                                    <?php 
                                        function printStats($status,$success,$scolor,$err,$ecolor,$default){
                                            if($status==1){
                                                return "<label class='label label-".$scolor."'>".$success."</label>";
                                            }else if ($status==0) {
                                                return "<label class='label label-".$ecolor."'>".$err."</label>";
                                            }else{
                                                return "<label class='label label-".$scolor."'>".$default."</label>";
                                            }
                                        }
                                    ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                      
                    </div>

                </div>
            </form>
       
                </div>

            </div>
        </div>
    </section>
    <!--invoice print-->
    <div class="modal fade bs-payment-modal-lg" id="modelInvoice" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <form role="form" id="addDep" data-parsley-validate method="post" action="#">
                <div class="modal-content"><div class="modal-body" >
                        <div class="row"  id="printArea" align="center" style='margin:5px;'>

                            <table style="border-collapse:collapse;width:290px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
                                <?php //foreach ($company as $com) {  ?>
                                <tr style="text-align:center;font-size:35px;font-family: Arial, Helvetica, sans-serif;">
                                    <td colspan="4" style="font-size:40px;font-family: Arial, Helvetica, sans-serif;"><b> <?php echo $company['CompanyName'] ?></b></td>
                                </tr> <?php //}  ?>
                                <tr style="text-align:center;font-size:25px;font-family: Arial, Helvetica, sans-serif;">
                                    <td colspan="4"><b><?php echo $company['CompanyName2'] ?></b></td>
                                </tr>
                                <tr style="text-align:center;font-size:15px;font-family: Arial, Helvetica, sans-serif;">
                                    <td colspan="4"> <?php echo $company['AddressLine01'] ?><?php echo $company['AddressLine02'] ?></td>
                                </tr><tr style="text-align:center;font-size:15px;font-family: Arial, Helvetica, sans-serif;">
                                    <td colspan="4"><?php echo $company['AddressLine03'] ?></td>
                                </tr>
                                <tr style="text-align:center;font-size:25px;">
                                    <td colspan="4">
                                        <!--<img valign="bottom" src="/upload/phone.png" style="height:28px;">--> 
                                        &nbsp;<?php echo $company['LanLineNo'] ?></td>
                                </tr>
                                <tr style="text-align:center;font-size:14px;border-bottom: #000 solid 1px;padding-bottom:5px;">
                                    <td colspan="4">Customer Payment</td>
                                </tr>
                                <tr style="text-align:center;">
                                    <td colspan="4">&nbsp;</td>
                                </tr>
                                <tr style="text-align:left;font-size:13px;">
                                    <td colspan="2">Payment Number</td>
                                    <td>:</td>
                                    <td id="invNumber"></td>
                                </tr>
                                <tr style="text-align:left;font-size:13px;">
                                    <td colspan="2">Payment Date</td>
                                    <td>:</td>
                                    <td id="invoiceDate"></td>
                                </tr>
                                <tr style="text-align:left;font-size:13px;">
                                    <td colspan="2">Customer Name</td>
                                    <td>:</td>
                                    <td id="cusname"></td>
                                </tr>
                                <tr style="text-align:left;font-size:13px;">
                                    <td colspan="2">Outstanding Balance</td>
                                    <td>:</td>
                                    <td id="outstand"></td>
                                </tr>
                            </table>
                            <style>#tblData td{padding: 2px;}</style>
                            <table id="tblData"  style="border-collapse:collapse;width:290px;font-size:14px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
                                <thead>
                                    <tr style="text-align:center;border:#000 solid 1px;">
                                        <td style="text-align:center;border:#000 solid 1px;">Cheque Date</td>
                                        <td style="text-align:center;border:#000 solid 1px;"> Cheque No</td>
                                        <td style="text-align:center;border:#000 solid 1px;">Bank Name</td>
                                        <td style="text-align:center;border:#000 solid 1px;">T. Amount</td>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot style='border:#000 solid 1px;'>
                                    <tr >
                                        <td colspan="3" style="text-align: right;">Total Payment Amount</td>
                                    <!--<td></td>-->
                                        <td style="text-align:right"  id="invTotal">0.00</td>
                                    </tr>

                                </tfoot>
                            </table>
                            <table  style="border-collapse:collapse;width:290px;font-size:14px;margin:5px 5px 30px 5px;font-family: Arial, Helvetica, sans-serif;" border="0">


                                <tr style="text-align:center;font-size:25px;">
                                    <td colspan="4"><b>Thank You Come Again</b></td>
                                </tr>
                                <tr style="text-align:center">
                                    <td colspan="4">&nbsp;</td>
                                </tr>

                                <tr style="text-align:center;font-size:12px;">
                                    <td colspan="4"><i>Software By NSOFT &nbsp;&nbsp;&nbsp;&nbsp;www.nsoft.lk</i></td>
                                </tr>
                                <tr style="text-align:center">
                                    <td colspan="4" style="height:30px;">&nbsp;</td>
                                </tr>
                                <tr style="text-align:center">
                                    <td colspan="4">-</td>
                                </tr>
                            </table>

                        </div> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button>
                        <button type="button" id="printInvoice" class="btn btn-primary btn-lg">Print</button>
                    </div>

                </div>
            </form>
        </div>
    </div>


</div>
<style>
    .shop-items:hover{
        background-color: #00ca6d;
        color: #fff;
    }
</style>

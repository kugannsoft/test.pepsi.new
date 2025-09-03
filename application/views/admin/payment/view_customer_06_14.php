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

                    <!-- <form role="form" id="addDep" data-parsley-validate method="post" action="#"> -->
                    <div class="row">

                        <div class="modal-header">
                            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-remove"></i></span></button> -->
                            <!-- <h4 class="modal-title" id="myModalLabel2">Payment Details <span id="errPayment"></span></h4> -->
                        </div>

                        <div class="modal-body">
                            <div class="row">

                                <div class="col-md-4">

                                    <table class="table table-hover">
                                        <tbody>
                                        <tr><td> Code</td><td>:</td><td  id='mcash'  class='text-right'><?php echo $cus->CusCode?></td></tr>
                                        <tr><td> Name</td><td>:</td><td  id='mcash'  class='text-right'><?php echo $cus->RespectSign.".".$cus->CusName." ".$cus->LastName?></td></tr>
                                        <tr><td> Display Name</td><td>:</td><td  id='mcash'  class='text-right'><?php echo $cus->DisplayName?></td></tr>
                                        <tr><td>Address</td><td>:</td><td  id='mcard'  class='text-right'><?php echo $cus->Address01."<br>".$cus->Address02." ".$cus->Address03?></td></tr>
                                        <tr><td> Company Name</td><td>:</td><td  id='mcash'  class='text-right'><?php echo $cus->CusCompany?></td></tr>
                                        <tr><td>Address</td><td>:</td><td  id='mcard'  class='text-right'><?php echo $cus->ComAddress?></td></tr>
                                        <tr><td>Mobile</td><td>:</td><td  id='mcheque'  class='text-right'><?php echo $cus->MobileNo?></td></tr>
                                        <tr><td>Phone</td><td>:</td><td  id='mcredit'  class='text-right'><?php echo $cus->LanLineNo?></td></tr>
                                        <tr><td>Work Phone</td><td>:</td><td  id='mcredit'  class='text-right'><?php echo $cus->WorkNo?></td></tr>
                                        <tr><td>Email</td><td>:</td><td  id='mcompany'  class='text-right'><?php echo $cus->Email?></td></tr>
                                        <tr><td>Remarks</td><td>:</td><td  id='mcompany'  class='text-right'><?php echo $cus->remark?></td></tr>
                                        </tbody>
                                    </table>
                                    <!--</div>-->
                                </div>
                                <div class="col-md-3"><table class="table table-hover">
                                        <tbody>
                                        <tr><td>Customer No</td><td>:</td><td  id='mcash'  class='text-right'><?php echo $cus->CusBookNo?></td></tr>
                                        <tr><td>Category</td><td>:</td><td  id='mcash'  class='text-right'><?php echo $cus->CusCategory?></td></tr>
                                        <tr><td>Handel By</td><td>:</td><td  id='mcard'  class='text-right'><?php echo $cus->RepName?></td></tr>
                                        <tr><td>Payment</td><td>:</td><td  id='mcheque'  class='text-right'><?php echo $cus->payType?></td></tr>
                                        <tr><td>Credit Period</td><td>:</td><td  id='mcredit'  class='text-right'><?php echo $cus->CreditPeriod?></td></tr>
                                        <tr><td>Credit Limit</td><td>:</td><td  id='mcompany'  class='text-right'><?php echo $cus->CreditLimit?></td></tr>
                                        <tr><td>Vat No</td><td>:</td><td  id='mcompany'  class='text-right'><?php echo $cus->VatNumber?></td></tr>
                                        </tbody>
                                    </table>
                                    <!--</div>-->
                                </div>
                                <div class="col-md-3">

                                    <table class="table table-hover">
                                        <tbody>
                                        <tr><td>Open Oustanding</td><td>:</td><td  id='mtotal'  class='text-right'><?php echo number_format($credit->OpenOustanding,2) ?></td></tr>
                                        <tr><td>Total Credit Invoice Amount</td><td>:</td><td  id='mdiscount'  class='text-right'><?php echo number_format($total_credit,2) ?></td></tr>
                                        <tr><td>Settlement Amount</td><td>:</td><td  id='madvance'  class='text-right'><?php echo number_format($total_payment,2) ?></td></tr>
                                        <tr><td>Return Amount</td><td>:</td><td  id='madvance'  class='text-right'><?php echo number_format($return_payment,2) ?></td></tr>
                                        <tr><td>Oustanding Amount</td><td>:</td><td  id='mnetpay'  class='text-right'><?php echo number_format($total_credit- $total_payment - $return_payment + $return__complete_payments,2)?></td></tr>
                                        <!--tr><td>Advance Payment</td><td>:</td><td  id='adv'  class='text-right'><?php echo number_format($total_add_payment,2) ?></td></tr-->
                                        <tr><td>Advance Payment</td><td>:</td><td  id='adv'  class='text-right'><?php echo number_format($total_advance_payment,2) ?></td></tr>

                                        <!-- <tr><td id='changeLable'>Change/Refund</td><td>:</td><td id='mchange' class='text-right'>0.00</td></tr> -->
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <?php echo form_open_multipart('admin/payment/cus_upload');?>
                                        <div class="form-group" >
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text">Attachment</label>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="hidden" name="cusCode" id="cusCode" value="<?php echo $cus->CusCode ?>">
                                                    <input type="file" class="custom-file-input" name="userfile" size="20" />
                                                </div>
                                                <div class="input-group" >
                                                    <input type="submit" class="btn btn-primary" value="upload" />
                                                </div>
                                            </div>

                                        </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button onclick="editm(<?php echo $cus->CusCode?>);" class="btn btn-sm btn-primary" >Edit Customer</button><br><br>
                                    <!--<button onclick="editm(<?php echo $cus->CusCode?>)" class="btn btn-s btn-primary" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Edit Customer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button> -->
                                    <ul  class="list-group">

                                        <?php if ($cus->IsActive == 1) { ?>
                                            <a class="list-group-item" href="<?php echo base_url('admin/Salesinvoice/addSalesInvoice?cus=').$cus->CusCode; ?>" class="btn btn-xs btn-default"><b>Sales Invoice</b> <span class="pull-right"><i class="fa fa-plus "></i></span></a>

                                            <a class="list-group-item" href="<?php echo base_url('admin/payment/cus_payment?cus=').$cus->CusCode; ?>" class="btn btn-xs btn-default">Payment <span class="pull-right"><i class="fa fa-plus "></i></span></a>
                                            <a class="list-group-item" href="<?php echo base_url('admin/payment/customer_statement?CusCode=').$cus->CusCode; ?>" class="btn btn-xs btn-default">Statement <span class="pull-right"><i class="glyphicon glyphicon-eye-open"></i></span></a>
                                            <!-- <a class="list-group-item" href="#" class="btn btn-xs btn-default"  data-target="#vehiclemodal"  id="addNewVehicle" >New Vehicle <span class="pull-right"><i class="fa fa-car"></i></span></a> -->
                                        <?php } ?>

                                    </ul>
                                    <div class="row">
                                        <?php foreach ($cus_doc as $doc) { ?>
                                            <div class="col-sm-12">
                                                <label>Attachments : <a target="_blank" class="pull-right" href="<?php echo base_url("upload/cus_doc/$doc->doc_name");?>" >
                                                        <img src="<?php echo base_url("upload/pdf.jpg");?>" width="20">
                                                    </a></label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row" id='chequeData'>


                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
<!--                                    <h4>Vehicle Details</h4>-->
<!--                                    <table class="table table-hover">-->
<!--                                        <thead>-->
<!--                                        <th>Reg No</th>-->
<!--                                        <th>Contact Person</th>-->
<!--                                        <th>Make</th>-->
<!--                                        <th>Model</th>-->
<!--                                        <!-- <th>Year</th> -->
<!--                                        <th>Chassis No</th>-->
<!--                                        <!-- <th>Engine No</th> -->
<!--                                        <th>####</th>-->
<!--                                        <th>####</th>-->
<!--                                        </thead>-->
<!--                                        <tbody>-->
<!--                                        --><?php //foreach($vehicle as $v){?>
<!--                                            <tr>-->
<!--                                                <td>--><?php //echo $v->RegNo;?><!--</td>-->
<!--                                                <td>--><?php //echo $v->contactName;?><!--</td>-->
<!--                                                <td>--><?php //echo $v->make;?><!--</td>-->
<!--                                                <td>--><?php //echo $v->model;?><!--</td>-->
<!--                                                <!-- <td>--><?php //echo $v->ManufactureYear;?><!--</td> -->
<!--                                                <td>--><?php //echo $v->ChassisNo;?><!--</td>-->
<!--                                                <!-- <td>--><?php //echo $v->EngineNo;?><!--</td> -->
<!--                                                <!-- <td>--><?php //echo $v->body_color;?><!--</td> -->
<!--                                                <td><a href="--><?php //echo base_url('admin/job/estimate_job?type=cus&ccode=').base64_encode($cus->CusCode); ?><!--&regno=--><?php //echo base64_encode($v->RegNo);?><!--" class="btn btn-xs btn-success" ><span class="pull-left"><i class="fa fa-plus "></i></span> Estimate</a>-->
<!--                                                </td>-->
<!--                                                <td><a href="--><?php //echo base_url('admin/job/index?type=cus&ccode=').base64_encode($cus->CusCode); ?><!--&regno=--><?php //echo base64_encode($v->RegNo);?><!--" class="btn btn-xs btn-success" ><span class="pull-left"><i class="fa fa-plus "></i></span> Job</a>-->
<!--                                                </td>-->
<!--                                            </tr>-->
<!--                                        --><?php //}?>
<!--                                        </tbody>-->
<!--                                    </table>-->
<!--                                    <hr>-->

<!--                                    <h4>Easy Payment - Product</h4>-->
<!--                                    <table class="table table-hover">-->
<!--                                        <thead>-->
<!--                                        <th>Invoice Date</th>-->
<!--                                        <th>Invoice No</th>-->
<!--                                        <th>Account No</th>-->
<!--                                        <th>Invoice Amount</th>-->
<!--                                        <th>Credit Amount</th>-->
<!--                                        <th></th>-->
<!--                                        <th></th>-->
<!--                                        </thead>-->
<!--                                        <tbody>-->
<!--                                        --><?php //foreach($easyProduct as $v){?>
<!--                                            <tr>-->
<!--                                                <td>--><?php //echo $v->InvDate;?><!--</td>-->
<!--<!--                                                <td><a href="--><?php ////echo base_url('admin/Salesinvoice/view_invoice/').base64_encode($v->JobInvNo); ?><!--<!--"><?php ////echo $v->JobInvNo;?><!--<!--</a></td>-->
<!--                                                <td>--><?php //echo ($v->InvNo);?><!--</td>-->
<!--                                                <td>--><?php //echo ($v->AccNo);?><!--</td>-->
<!--                                                <td>--><?php //echo number_format($v->FinalAmount,2);?><!--</td>-->
<!--                                                <td>--><?php //echo number_format($v->TotalDue,2);?><!--</td>-->
<!--                                                <td>--><?php //echo printStats($v->IsCompelte,'Closed','success','Pending','warning','warning');?><!--</td>-->
<!--                                                <td>--><?php //echo printStats($v->IsCancel,'Canceld','danger','Active','success','success');?><!--</td>-->
<!--                                            </tr>-->
<!--                                        --><?php //}?>
<!--                                        </tbody>-->
<!--                                    </table>-->

<!--                                    <hr>-->
<!--                                    <h4>Easy Payment - Cash</h4>-->
<!--                                    <table class="table table-hover">-->
<!--                                        <thead>-->
<!--                                        <th>Invoice Date</th>-->
<!--                                        <th>Invoice No</th>-->
<!--                                        <th>Account No</th>-->
<!--                                        <th>Invoice Amount</th>-->
<!--                                        <th>Credit Amount</th>-->
<!--                                        <th></th>-->
<!--                                        <th></th>-->
<!--                                        </thead>-->
<!--                                        <tbody>-->
<!--                                        --><?php //foreach($easyCash as $v){?>
<!--                                            <tr>-->
<!--                                                <td>--><?php //echo $v->InvDate;?><!--</td>-->
<!--                                                <!--                                                <td><a href="--><?php ////echo base_url('admin/Salesinvoice/view_invoice/').base64_encode($v->JobInvNo); ?><!--<!--">--><?php ////echo $v->JobInvNo;?><!--<!--</a></td>
<!--                                                <td>--><?php //echo ($v->InvNo);?><!--</td>-->
<!--                                                <td>--><?php //echo ($v->AccNo);?><!--</td>-->
<!--                                                <td>--><?php //echo number_format($v->FinalAmount,2);?><!--</td>-->
<!--                                                <td>--><?php //echo number_format($v->TotalDue,2);?><!--</td>-->
<!--                                                <td>--><?php //echo printStats($v->IsCompelte,'Closed','success','Pending','warning','warning');?><!--</td>-->
<!--                                                <td>--><?php //echo printStats($v->IsCancel,'Canceld','danger','Active','success','success');?><!--</td>-->
<!--                                            </tr>-->
<!--                                        --><?php //}?>
<!--                                        </tbody>-->
<!--                                    </table>-->
<!---->
<!--                                    <hr>-->
<!--                                    <h4>Temporary Invoice Details</h4>-->
<!--                                    <table class="table table-hover">-->
<!--                                        <thead>-->
<!--                                        <th>Invoice Date</th>-->
<!--                                        <th>Tem Invoice No</th>-->
<!--                                        <th>Vehicle</th>-->
<!--                                        <th>Total Amount</th>-->
<!--                                        <th>Action</th>-->
<!--                                        </thead>-->
<!--                                        <tbody>-->
<!--                                        --><?php //foreach($temp_inv as $v){?>
<!--                                            <tr>-->
<!--                                                <td>--><?php //echo $v->JobInvoiceDate;?><!--</td>-->
<!--                                                <td><a href="--><?php //echo base_url('admin/Salesinvoice/view_temp_invoice/').base64_encode($v->JobInvNo); ?><!--">--><?php //echo $v->JobInvNo;?><!--</a></td>-->
<!--                                                <td>--><?php //echo ($v->JRegNo);?><!--</td>-->
<!--                                                <td>--><?php //echo number_format($v->JobTotalAmount,2);?><!--</td>-->
<!--                                                <td>--><?php //if ($v->IsInvoice == 0 && $v->IsCancel == 0) { ?><!-- <a href="--><?php //echo base_url('admin/Salesinvoice/job_invoice?type=tempinv&id=').base64_encode($v->JobInvNo); ?><!--" class="btn btn-xs btn-warning" >EDIT</a> --><?php //}
//                                                    else {?><!-- <a href="" class="btn btn-xs btn-warning" disabled>EDIT</a> --><?php //} ?><!--</td>-->
<!--                                            </tr>-->
<!--                                        --><?php //}?>
<!--                                        </tbody>-->
<!--                                    </table>-->
                                    <hr>
                                    <h3>Sales Details</h3>
                                    <table class="table table-hover">
                                        <thead>
                                        <th>Invoice Date</th>
                                        <th>Invoice No</th>
<!--                                        <th>Vehicle</th>-->
                                        <th>Invoice Amount</th>
                                        <th>Credit Amount</th>
                                        <th>Payment Type</th>
                                        <th></th>
                                        <th></th>
                                        </thead>
                                        <tbody>
                                        <?php foreach($sale as $v){?>
                                            <tr>
                                                <td><?php echo $v->SalesDate;?></td>
                                                <td><a href="<?php echo base_url('admin/Salesinvoice/view_sales_invoice/').base64_encode($v->SalesInvNo); ?>"><?php echo $v->SalesInvNo;?></a></td>

<!--                                                <td>--><?php //echo ($v->SalesVehicle);?><!--</td>-->
                                                <td><?php echo number_format($v->SalesNetAmount,2);?></td>
                                                <td><?php echo number_format($v->SalesCreditAmount,2);?></td>
                                                <td>

                                                    <?php if ($v->SalesInvPayType=='Cash') {
                                                        echo 'Cash';
                                                    }elseif($v->SalesInvPayType=='Cheque'){
                                                        echo 'Cheque';
                                                    }elseif($v->SalesInvPayType=='Credit'){
                                                        echo 'Credit';
                                                    }elseif($v->SalesInvPayType=='Bank'){
                                                        echo 'Bank transfer';
                                                    }?>
                                                </td>
                                                <td><?php echo printStats($v->IsComplete,'Closed','success','Pending','warning','warning');?></td>
                                                <td><?php echo printStats($v->InvIsCancel,'Canceld','danger','Active','success','success');?></td>
                                            </tr>
                                        <?php }?>
                                        </tbody>
                                    </table>




<!--                                    <hr>-->
<!--                                    <h4>Job Details</h4>-->
<!--                                    <table class="table table-hover">-->
<!--                                        <thead>-->
<!--                                        <th>Invoice Date</th>-->
<!--                                        <th>Invoice No</th>-->
<!--<!--                                        <th>Vehicle</th>-->
<!--                                        <th>Invoice Amount</th>-->
<!--                                        <th>Credit Amount</th>-->
<!--                                        <th></th>-->
<!--                                        <th></th>-->
<!--                                        </thead>-->
<!--                                        <tbody>-->
<!--                                        --><?php //foreach($job as $v){?>
<!--                                            <tr>-->
<!--                                                <td>--><?php //echo $v->JobInvoiceDate;?><!--</td>-->
<!--                                                <td><a href="--><?php //echo base_url('admin/Salesinvoice/view_invoice/').base64_encode($v->JobInvNo); ?><!--">--><?php //echo $v->JobInvNo;?><!--</a></td>-->
<!--<!--                                                <td>--><?php ////echo ($v->JRegNo);?><!--<!--</td>-->
<!--                                                <td>--><?php //echo number_format($v->JobNetAmount,2);?><!--</td>-->
<!--                                                <td>--><?php //echo number_format($v->JobCreditAmount,2);?><!--</td>-->
<!--                                                <td>--><?php //echo printStats($v->IsCompelte,'Closed','success','Pending','warning','warning');?><!--</td>-->
<!--                                                <td>--><?php //echo printStats($v->IsCancel,'Canceld','danger','Active','success','success');?><!--</td>-->
<!--                                            </tr>-->
<!--                                        --><?php //}?>
<!--                                        </tbody>-->
<!--                                    </table>-->
<!---->
<!--                                    <hr>-->
<!--                                    <h4>Job Card Details</h4>-->
<!--                                    <table class="table table-hover">-->
<!--                                        <thead>-->
<!--                                        <th>Appointment Date</th>-->
<!--                                        <th>JobCardNo No</th>-->
<!--<!--                                        <th>Vehicle</th>-->
<!--                                        <th>OdoIn</th>-->
<!--                                        <th>End Date</th>-->
<!--                                        <th></th>-->
<!--                                        <th></th>-->
<!--                                        <th>Action</th>-->
<!--                                        </thead>-->
<!--                                        <tbody>-->
<!--                                        --><?php //foreach($job_card as $v){?>
<!--                                            <tr>-->
<!--                                                <td>--><?php //echo $v->appoimnetDate;?><!--</td>-->
<!--                                                <td><a href="--><?php //echo base_url('admin/job/view_job_card/').base64_encode($v->JobCardNo); ?><!--">--><?php //echo $v->JobCardNo;?><!--</a></td>-->
<!--<!--                                                <td>--><?php ////echo ($v->JRegNo);?><!--<!--</td>-->
<!--                                                <td>--><?php //echo ($v->OdoIn);?><!--</td>-->
<!--                                                <td>--><?php //echo ($v->endDate);?><!--</td>-->
<!--                                                <td>--><?php //echo printStats($v->IsCompelte,'Closed','success','Pending','warning','warning');?><!--</td>-->
<!--                                                <td>--><?php //echo printStats($v->IsCancel,'Canceld','danger','Active','success','success');?><!--</td>-->
<!--                                                <td>--><?php //if ($v->IsCompelte == 0 && $v->IsCancel == 0) { ?><!-- <a href="--><?php //echo base_url('admin/job/edit_job/').base64_encode($v->JobCardNo); ?><!--" class="btn btn-xs btn-warning" >EDIT</a> --><?php //}
//                                                    else {?><!-- <a href="" class="btn btn-xs btn-warning" disabled>EDIT</a> --><?php //} ?><!--</td>-->
<!--                                            </tr>-->
<!--                                        --><?php //}?>
<!--                                        </tbody>-->
<!--                                    </table>-->
<!--                                    <hr>-->

<!--                                    <h4>Advanced Payment Details</h4>-->
<!--                                    <table class="table table-hover">-->
<!--                                        <thead>-->
<!--                                        <th>Payment Date</th>-->
<!--                                        <th>Payment Type</th>-->
<!--                                        <th>Payment No</th>-->
<!--                                        <th>Amount</th>-->
<!--                                        <th>Reference</th>-->
<!--                                        <th></th>-->
<!--                                        <th></th>-->
<!--                                        </thead>-->
<!--                                        <tbody>-->
<!--                                        --><?php //foreach($payadd as $v){?>
<!--                                            <tr>-->
<!--                                                <td>--><?php //echo $v->PayDate;?><!--</td>-->
<!--                                                <td>--><?php //if ($v->PaymentType==1) {
//                                                        echo 'Credit';
//                                                    }elseif($v->PaymentType==2){
//                                                        echo 'Advance';
//                                                    }?><!--</td>-->
<!--                                                --><?php ////if(substr($v->CusPayNo,0,3)=='COB'){?>
<!--                                                <!-- <td>--><?php //echo $v->CusPayNo;?><!--</td> -->
<!--                                                --><?php //// }elseif ($v->CusPayNo==1) { ?>
<!--                                                <td><a href="--><?php //echo base_url('admin/payment/view_customer_receipt?payNo=').base64_encode($v->CusPayNo); ?><!--">--><?php //echo $v->CusPayNo;?><!--</a></td>-->
<!--                                                --><?php ////} ?>
<!--                                                <td>--><?php //echo number_format($v->PayAmount,2);?><!--</td>-->
<!--                                                <td>--><?php //echo ($v->Remark);?><!--</td>-->
<!--                                                <td>--><?php //echo printStats($v->IsCancel,'Canceld','danger','Active','success','success');?><!--</td>-->
<!--                                            </tr>-->
<!--                                        --><?php //}?>
<!--                                        </tbody>-->
<!--                                    </table>-->
<!--                                    <hr>-->


                                    <h3>Payment Details</h3>
                                    <table class="table table-hover">
                                        <thead>
                                        <th>Payment Date</th>
                                        <th>Payment Type</th>
                                        <th>Payment No</th>
                                        <th> Amount</th>
                                        <th>Payment Method</th>
                                        <th>Reference</th>
                                        <th></th>
                                        <th></th>
                                        </thead>
                                        <tbody>
                                        <?php foreach($pay as $v){?>
                                            <tr>
                                                <td><?php echo $v->PayDate;?></td>
                                                <td><?php if ($v->PaymentType==1) {
                                                        echo 'Credit';
                                                    }elseif($v->PaymentType==2){
                                                        echo 'Advance';
                                                    }?></td>
                                                <?php //if(substr($v->CusPayNo,0,3)=='COB'){?>
                                                <!-- <td><?php echo $v->CusPayNo;?></td> -->
                                                <?php // }elseif ($v->CusPayNo==1) { ?>
                                                <td><a href="<?php echo base_url('admin/payment/view_customer_receipt?payNo=').base64_encode($v->CusPayNo); ?>"><?php echo $v->CusPayNo;?></a></td>
                                                <?php //} ?>
                                                <td><?php echo number_format($v->PayAmount,2);?></td>
                                                <td><?php echo ($v->Mode);?></td>
                                                <td><?php echo ($v->Reference);?></td>
                                                <td><?php echo printStats($v->IsCancel,'Canceld','danger','Active','success','success');?></td>
                                            </tr>
                                        <?php }?>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <h3>Credit Details</h3>
                                    <table class="table table-hover">
                                        <thead>
                                        <th>Invoice Date</th>
                                        <th>Invoice No</th>
                                        <th>Credit Amount</th>
                                        <th>Settled Amount</th>
                                        <th>Due Amount</th>
                                        <th></th>
                                        <th></th>
                                        </thead>
                                        <tbody>
                                        <?php foreach($credit_inv as $v){?>
                                            <tr>
                                                <td><?php echo $v->InvoiceDate;?></td>
                                                <?php if(substr($v->InvoiceNo,0,3)=='COB'){?>
                                                    <td><?php echo $v->InvoiceNo;?></td>
                                                <?php  }elseif ($v->Type==1) { ?>
                                                    <td><a href="<?php echo base_url('admin/Salesinvoice/view_sales_invoice/').base64_encode($v->InvoiceNo); ?>"><?php echo $v->InvoiceNo;?></a></td>
                                                <?php }elseif ($v->Type==2) { ?>
                                                    <td><a href="<?php echo base_url('admin/Salesinvoice/view_sales_invoice/').base64_encode($v->InvoiceNo); ?>"><?php echo $v->InvoiceNo;?> Return</a></td>
                                                <?php }elseif ($v->Type==0) { ?>
                                                    <td><a href="<?php echo base_url('admin/Salesinvoice/view_invoice/').base64_encode($v->InvoiceNo); ?>"><?php echo $v->InvoiceNo;?></a></td>
                                                <?php } ?>
                                                <td><?php echo number_format($v->CreditAmount,2);?></td>
                                                <td><?php echo number_format($v->SettledAmount,2);?></td>
                                                <td><?php echo number_format($v->CreditAmount-$v->SettledAmount,2);?></td>
                                                <td><?php
                                                    //shalika
                                                    $return=$this->CI->loadreturninvbyid($v->CusCode,$v->InvoiceNo);
                                                    $settle=$this->CI->loadreturnsettlbyid($v->CusCode,$v->InvoiceNo);

                                                    if ($return=='') {
                                                        $salesreturn=$this->CI->loadreturninvbyidsales($v->CusCode,$v->InvoiceNo);
                                                        $salesreturninv=$this->CI->loadsalesinvbyid($v->CusCode,$salesreturn->InvoiceNo);
                                                        $invoicestrin=$salesreturninv->SalesCashAmount.''.$salesreturn->ReturnNo;
                                                    }else{
                                                        $invoicestrin=$return->CreditAmount.''.$return->InvoiceNo;
                                                    }

                                                    $returnstrin=$settle->SettledAmount.''.$settle->InvoiceNo;

                                                    if (($v->Type==2) && $invoicestrin==$returnstrin && $invoicestrin!='' && $returnstrin!='') {

                                                        echo printStats($v->IsCloseInvoice,'Closed','success','Returned','danger','warning');
                                                    }elseif (($v->Type==2 ) && $returnstrin!='') {

                                                        echo printStats($v->IsCloseInvoice,'Closed','success','Partial Return','warning','warning');
                                                    }else{
                                                        echo printStats($v->IsCloseInvoice,'Closed','success','Pending','warning','warning');
                                                    }
                                                    //shalika
                                                    ?></td>
                                                <td><?php echo printStats($v->IsCancel,'Canceld','danger','Active','success','success');?></td>
                                            </tr>
                                        <?php }?>
                                        </tbody>
                                    </table>
                                    <hr>
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
                                        <th></th>
                                        <th></th>
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

                                    <hr>
<!--                                    <h3>Commission</h3>-->
<!--                                    <table class="table table-hover">-->
<!--                                        <thead>-->
<!--                                        <th>Date</th>-->
<!--                                        <th>Invoice</th>-->
<!--                                        <th>Amount</th>-->
<!--                                        <th>Commission Amount</th>-->
<!--                                        </thead>-->
<!--                                        <tbody>-->
<!--                                        --><?php //$total_com =0;
//                                        foreach($job_com as $v){?>
<!--                                            <tr>-->
<!--                                                <td>--><?php //echo $v->JobInvoiceDate;?><!--</td>-->
<!--                                                <td>--><?php //echo $v->JobInvNo;?><!--</td>-->
<!--                                                <td>--><?php //echo number_format($v->JobNetAmount,2);?><!--</td>-->
<!--                                                <td>--><?php //echo number_format($v->JobCommsion,2);?><!--</td>-->
<!--                                            </tr>-->
<!--                                            --><?php //$total_com +=$v->JobCommsion; }?>
<!--                                        --><?php //foreach($sale_com as $v){?>
<!--                                            <tr>-->
<!--                                                <td>--><?php //echo $v->SalesDate;?><!--</td>-->
<!--                                                <td>--><?php //echo $v->SalesInvNo;?><!--</td>-->
<!--                                                <td>--><?php //echo number_format($v->SalesNetAmount,2);?><!--</td>-->
<!--                                                <td>--><?php //echo number_format($v->SalesCommsion,2);?><!--</td>-->
<!--                                            </tr>-->
<!--                                            --><?php //$total_com +=$v->SalesCommsion; }?>
<!--                                        <tr>-->
<!--                                            <td></td>-->
<!--                                            <td></td>-->
<!--                                            <td>Total</td>-->
<!--                                            <td>--><?php //echo number_format($total_com,2);?><!--</td>-->
<!--                                        </tr>-->
<!--                                        </tbody>-->
<!--                                    </table>-->


<!--                                    <hr>-->
<!--                                    <h3>Estimate Details</h3>-->
<!--                                    <table class="table table-hover">-->
<!--                                        <thead>-->
<!--                                        <th>Date</th>-->
<!--                                        <th>Job Type</th>-->
<!--                                        <th>Estimate Type</th>-->
<!--                                        <th>Estimate No</th>-->
<!--                                        <th>Vehicle No</th>-->
<!--                                        <th>Job No</th>-->
<!--                                        <th>Amount</th>-->
<!--                                        </thead>-->
<!--                                        <tbody>-->
<!--                                        --><?php //$total_com =0;
//                                        //display all estimates-shalika
//                                        foreach($job_estall as $v){
//                                            //var_dump($v);
//                                            ?>
<!--                                            <tr>-->
<!--                                                <td>--><?php //echo $v->EstDate;?><!--</td>-->
<!--                                                <td>--><?php //if ($v->EstInsCompany==0) {
//                                                        echo 'Gereral';
//                                                    } else {echo 'Insurance' ?>
<!---->
<!--                                                        --><?php
//                                                        foreach ($job_est as $value) {
//                                                            if ($v->EstimateNo==$value->EstimateNo) {
//                                                                echo ' : '.$value->VComName;
//                                                            }
//
//                                                        }
//
//                                                    }//display all estimates-shalika
//                                                    ?>
<!--                                                </td>-->
<!--                                                <td>--><?php //if ($v->EstType==1) {
//                                                        echo 'General ';
//                                                    }elseif($v->EstType==2){
//                                                        echo 'Supplimentery';
//                                                    }?><!--</td>-->
<!--                                                <td><a href="--><?php //echo base_url('admin/job/view_estimate?type=est&id=').base64_encode($v->EstimateNo);?><!--&sup=--><?php //echo ($v->Supplimentry); ?><!--">--><?php //echo $v->EstimateNo;?><!--</a></td>-->
<!--                                                <td>--><?php //echo $v->EstRegNo;?><!--</td>-->
<!--                                                <td>--><?php //echo $v->EstJobCardNo;?><!--</td>-->
<!--                                                <td>--><?php //echo number_format($v->EstimateAmount,2);?><!--</td>-->
<!--                                            </tr>-->
<!--                                        --><?php //}?>
<!--                                        </tbody>-->
<!--                                    </table>-->
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
                </div>
            </div>
        </div>
    </section>
</div>
<div id="customermodal" class="modal fade bs-addcustomer-modal-lg" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-lg" style="width: 95%;">
        <div class="modal-content">
            <!-- load data -->
        </div>
    </div>
</div>
<div id="vehiclemodal" class="modal fade bs-addcustomer-modal-lg" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-lg" style="width: 95%;">
        <div class="modal-content">
            <!-- load data -->
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
    $('#balanceDate').datepicker({
        format: 'yyyy-mm-dd'
    });
    function editms(d) {
        $('#customermodal .modal-content').load('<?php echo base_url() ?>admin/customer/loadmodal_customeredit/' + d, function (result) {
            $('#customermodal').modal({show: true, backdrop: 'static',keyboard: false});
        });
    }

    function editm(d) {
        $('.modal-content').load('<?php echo base_url() ?>admin/customer/loadmodal_customeredit/' + d, function (result) {
            $('#customermodal').modal({show: true});
        });
    }

    $("#addNewVehicle").click(function(){
        $('#vehiclemodal .modal-content').load('<?php echo base_url() ?>admin/customer/loadmodal_vehicleadd/<?php echo $cus->CusCode; ?>', function (result) {
            $('#vehiclemodal').modal({show: true, backdrop: 'static',keyboard: false});
        });
    });
</script>

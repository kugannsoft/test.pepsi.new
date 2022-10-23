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
                    <div class="box-header" style="background: #b4f3c8">
                        <div class="col-sm-4">
                        <form class="form-horizontal">
                        <div class="form-group">
                                <label for="cusCompany" class="col-sm-4 control-label">Branch <span class="required"></span></label>
                                <div class="col-sm-8">
                                     <select name="branch" required="required"  id="branch" class="form-control">
                                        <option value="">Select a branch</option>
                                         <?php foreach ($loc as $trns) { ?>
                                        <option value="<?php echo $trns->location_id; ?>" com="<?php echo $trns->location_id; ?>"  <?php if($trns->location_id==$_SESSION['location']){echo 'selected';}?> ><?php echo $trns->location; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        <div class="form-group">
                            <label for="cusCode" class="col-sm-4 control-label">Job Status <span class="required">*</span></label>
                            <div class="col-sm-8">
                                <select class="form-control" required="required"  name="jobStatus" id="jobStatus" >
                                    <option value="">Select a status</option>
                                     <?php foreach ($jobStatus as $trns) { ?>
                                    <option value="<?php echo $trns->status_id; ?>"  <?php if($jobHed->IsCompelte==$trns->status_id){?>selected<?php }?>><?php echo $trns->status_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="div_emp">
                            <label for="cusCode" class="col-sm-4 control-label">Job Assign to <span class="required">*</span></label>
                            <div class="col-sm-8">
                                <select class="form-control" required="required"  name="emp" id="emp" >
                                    <option value="">Select a employee</option>
                                     <?php foreach ($salesperson as $trns) { ?>
                                    <option value="<?php echo $trns->RepID; ?>" <?php //if($jobHed->assignTo==$trns->RepID){?><?php //}?>><?php echo $trns->RepName; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="div_emp">
                            <label for="cusCode" class="col-sm-4 control-label"><span class="required"></span></label>
                            <div class="col-sm-4">
                                <input type="button" name="btnSave" id="btnSave" value="Update" class="btn btn-success">
                            </div>
                            <div class="col-sm-4">
                                <?php if($jobHed->IsCancel==0 && $jobHed->IsCompelte==0){?>
                                <input type="button" name="btnSave" id="btnCancel" value="Cancel Job" class="btn btn-danger">
                                <?php } ?>
                            </div>
                        </div>
                        </form>
                        <hr>
                    </div>
                    <div class="col-sm-3">
                        <table style="font-size:10">
                            <tbody>
                                <!-- <tr><td>Assign To</td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td><td><?php //echo $jobHed->RepName?></td></tr> -->
                                <tr><td>Status</td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td><td><?php echo $jobHed->status_name?></td></tr>
                                <tr><td>Job No</td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td><td><?php echo $jobHed->JobCardNo?></td></tr>
                                <tr><td>Job Date</td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td><td><?php echo $jobHed->appoimnetDate?></td></tr>
                                <tr><td>Start Date</td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td><td><?php echo $jobHed->startDate?></td></tr>
                                <tr><td>End Date</td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td><td><?php echo $jobHed->endDate?></td></tr>
                                <tr><td>Close Date</td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td><td><?php echo $jobHed->closeDate?></td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-5">
                        <div class="row">
                            <div class="col-sm-2">
                                <!--  <span class="pull-right">Print Preview &nbsp;<input type="checkbox" class="prd_icheck" name="printPreview" id="printPreview" value="1"><br><br></span> -->
                            </div>
                            <?php if (in_array("SM161", $blockView) || $blockView == null) { ?>
                                <div class="col-sm-2">
                                    <button type="button" id="btnPrint" class="btn btn-primary btn-sm btn-block">Print
                                    </button>
                                </div>
                            <?php } ?>
                            <?php if (in_array("M3", $blockEdit) || $blockEdit == null) { ?>
                                <div class="col-sm-2"><a
                                            href="../../job/edit_job/<?php echo base64_encode($jobHed->JobCardNo); ?>"
                                            class="btn btn-info btn-sm btn-block">Edit</a></div>
                            <?php } ?>
                            <div class="col-sm-2"><a
                                        href="../../purchase/addpo?job=<?php echo base64_encode($jobHed->JobCardNo); ?>"
                                        class="btn btn-info btn-sm btn-block">PO</a></div>
                            <?php if (in_array("SM51", $blockAdd) || $blockAdd == null) { ?>
                                <div class="col-sm-2">
                                    <a href="../../job/estimate_job?type=job&id=<?php echo base64_encode($jobHed->JobCardNo); ?>"
                                       class="btn btn-info btn-sm ">Estimate</a>
                                    <!-- <?php if ($jobHed->IsCancel == 0) { ?><button type="button" id="btnPrint" class="btn btn-danger btn-sm btn-block">Cancel</button><?php } ?> -->
                                </div>
                            <?php } ?>
                            <?php if (in_array("M4", $blockAdd) || $blockAdd == null) { ?>
                                <div class="col-sm-2">
                                    <a href="../../Salesinvoice/job_invoice?type=job&id=<?php echo base64_encode($jobHed->JobCardNo); ?>"
                                       class="btn btn-info btn-sm ">Invoice</a>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table" id="tblEmp">
                                    <tr><td>Employee</td><td style="padding:2px;">Type</td><td style="padding:2px;">#</td></tr>
                                    <?php foreach ($workers as $trns) { ?>
                                    <tr><td><?php echo $trns->RepName; ?></td><td><?php echo $trns->EmpType; ?></td><td style="padding:2px;"><button wid="<?php echo $trns->jworkid; ?>" class=" btnRemove btn btn-danger btn-xs">Remove</button></td></tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>       
                    </div>
                        <!-- </div> -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="row" align="center" style='margin:5px;' id="printArea">
                                                                       <!-- load comapny common header -->
    <?php $this->load->view('admin/_templates/company_header.php',true); ?>

<table style="border-collapse:collapse;width:700px;margin:5px;font-family: times,Arial, Helvetica, sans-serif;" border="0">
                       
                        <tr style="text-align:left;font-size:15px;">
                            <td style="padding-left:5px;font-size:12px;"> Date  </td>
                            <td> :</td>
                            <td colspan="4" style="text-align:left;font-size:12px;"><?php echo $jobHed->appoimnetDate?></td>
                            <td>&nbsp;</td>
                            <td > <b>JOB NO</b></td>
                            <td > :</td>
                            <td><b><?php echo $jobHed->JobCardNo?></b></td>
                        </tr>
                        <tr style="text-align:left;font-size:12px;">
                            <td style="border-top: #000 solid 1px;border-left: #000 solid 1px;padding-left:5px;"> Code</td>
                            <td style="border-top: #000 solid 1px;"> :</td>
                            <td colspan="4" style="border-top: #000 solid 1px;border-right: #000 solid 1px;"><?php echo $jobHed->JCustomer?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contact Name : <?php echo $invVehi->contactName?></td>
                            <td>&nbsp;</td>
                            <td style="text-align:left;font-size:15px;"> <b>REG NO</b></td>
                            <td > :</td>
                            <td style="text-align:left;font-size:15px;"> <b><?php echo $jobHed->JRegNo?></b></td>
                        </tr>
                        <tr style="text-align:left;font-size:12px;">
                            <td style="border-left: #000 solid 1px;padding: 0 px5px;" valign="top">Customer Name </td>
                            <td> :</td>
                            <td rowspan="3" colspan="4" valign="top" style="border-right: #000 solid 1px;border-bottom: #000 solid 1px;"> <span><a href="<?php echo base_url('admin/payment/view_customer/').$invCus->CusCode ?>"><?php echo $invCus->DisplayName;?></a></span><br>
                <?php if ($invCus->DisType==4): ?>
                    <?php echo $invCus->ContactPerson;?><br>
                <?php endif ?>
            <span >
              <?php if ($invCus->DisType!=4){ ?>
                <?php echo nl2br($invCus->Address01)."<br>".$invCus->Address02;?> <?php echo $invCus->Address03;?>
              <?php }else{ ?> 
                <?php echo nl2br($invCus->ComAddress);?>
              <?php } ?>
            </span><br>    
            <span id="lbladdress2">Tel : <?php echo $invCus->LanLineNo;?> Mobile : <?php echo $invCus->MobileNo;?></span></td>
                            <td>&nbsp;</td>
                            <td colspan="3" rowspan="6" style="padding-left:20px;">
                            <table style="font-size: 11px">
                            <tbody>
                                    <tr>
                                        <td>No of Job Card</td><td>:</td><td><?php echo $job_count->noofjobs?></td>
                                    </tr>
                                    <tr>
                                        <td>Origin</td><td>:</td><td><?php echo $invVehi->body_color?></td>
                                    </tr>
                                    <tr>
                                        <td>Delivery Date</td><td>:</td><td><?php echo substr($jobHed->deliveryDate,0,10)?></td>
                                    </tr>
                                     <tr>
                                        <td>Delivery Time</td><td>:</td><td><?php echo substr($jobHed->deliveryDate,10,9)?></td>
                                    </tr>
                                     <tr>
                                        <td>Make</td><td>:</td><td><?php echo $invVehi->make?></td>
                                    </tr>
                                     <tr>
                                        <td>Model No</td><td>:</td><td><?php echo $invVehi->model?></td>
                                    </tr>
                                     <tr>
                                        <td>Odo Meter</td><td>:</td><td><?php echo $jobHed->OdoIn?></td>
                                    </tr>
                                    <tr>
                                        <td>Your Ref</td><td>:</td><td></td>
                                    </tr>
                                    <tr>
                                        <td>Next Service</td><td>:</td><td><?php if($jobHed->NextService>0){echo ($jobHed->OdoIn+$jobHed->NextService);}?></td>
                                    </tr>
                                </tbody>
                            </table>
                            </td>
                        </tr>
                        <tr style="text-align:left;font-size:12px;">
                            <td style="border-left: #000 solid 1px;" valign="top">Address </td>
                            <td></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr style="text-align:left;font-size:12px;">
                            <td style="border-left: #000 solid 1px;border-bottom: #000 solid 1px;"> </td>
                            <td  style="border-bottom: #000 solid 1px;"></td>
                            <td >&nbsp;</td>
                        </tr>
                        <tr style="text-align:left;font-size:12px;">
                            <td> Email Address</td>
                            <td> :</td>
                            <td > <?php echo $invCus->Email?></td>
                            <td colspan="3">Payment Type &nbsp;&nbsp;<?php echo $jobHed->payType?></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr style="text-align:left;font-size:12px;">
                            <td> S.A.Name</td>
                            <td> :</td>
                            <td><?php echo $jobSerAdv->first_name." ".$jobSerAdv->last_name?></td>
                            <td  colspan="4"></td>
                        </tr>
                        <tr style="text-align:left;font-size:12px;">
                            <td> Tel/ Mob/ Fax No : </td>
                            <td> :</td>
                            <td> <?php echo $jobSerAdv->phone?></td>
                            <td ></td>
                            <td > </td>
                            <td></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr style="text-align:left;font-size:12px;">
                            <td> V. I. No </td>
                            <td>:</td>
                            <td colspan="4"> <?php echo $invVehi->ChassisNo?></td>
                            <td>&nbsp;</td>
                            <td > </td>
                            <td> </td>
                            <td></td>
                        </tr>
                        <!-- <tr style="text-align:left;font-size:12px;">
                            <td colspan="10">&nbsp;</td>
                        </tr> -->
                    </table>
                <style type="text/css" media="screen">
                    #tbl_est_data tbody tr td{
                    padding: 13px;
                }
                </style>
                <table style="border-collapse:collapse;width:700px;padding:5px;font-size: 12px;" border="1">
                    <thead>
                        <tr>
                            <th style='padding: 3px;width:30px;'>No.</th>
                            <th style='padding: 3px;width:540px;text-align: center;'> Customer Request Notes </th>
                            <!-- <th style='padding: 3px;width:130px;text-align: center;' colspan="2">Estimate Cost</th> -->
                        </tr>
                        <tr>
                            <th style='padding: 3px;'>&nbsp;</th>
                            <th style='padding: 3px;'>&nbsp;</th>
                            <!-- <th style='padding: 3px;width:100px;'>Rs</th>
                            <th style='padding: 3px;width:30px;'>Cts.</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i=1;
                     foreach ($jobDtl as $dtl) { ?>
                       <tr><td style='text-align: center;'><?php echo $i;?></td>
                       <td style='padding-left: 5px;'><?php echo $dtl->JobDescription?></td></tr>
                   <?php $i++; 
                   } ?>
                   <tr><td style='height:150px;'></td><td style='height:150px;'></td></tr>
                    </tbody>
                    <tfoot>
                        <!-- <tr><th colspan="2" style='text-align:right'>Total Amount  </th><th colspan="2" style='text-align:right'></th></tr> -->
                        </tfoot>
                        </table><br>
                       <!--  <div id="foot" style='border: 1px #000 solid;width:700px;padding: 5px;' >
                        <table style="border-collapse:collapse;width:683px;padding:2px;font-size: 12px;">
                        <tr>
                            <td rowspan="9" style='padding:5px;padding-right:20px;border:1px solid #000; text-align:left;font-size: 12px;width:450px;'>
                                All things are done to the manufactured recommended standards - any work carried out,
                    outside the standards are based on customer request and No Gurantee will be given on this
                    type of work.<br>
                    After disassembling, if any defect found supplementary estimate would be submitted for
                    your approval.<br>
                    All charges for repairs and materials are payable in full upon completion of work. The
                    company reserves the right to retain to possession of the vehicle until such charges are
                    settled in full.The company disclaims all responsibility whatsoever for loss or damage to
                    vehicle or other property belonging to customers within the vehicle. However the usual
                    precautions are taken by the company against fire, theft.ect. To eliminate the risk of loss or
                    damage, the company kindly requested to remove as far as possible all personal belongs
                    before leaving the vehicle for repairs.<br>
                    I here by authorize the repair work listed above to be done with necessary materials an I
                    grant <?php echo $company['CompanyName'] ?> 's authority to drive the vehicle for purpose of road test.
                    Delivery subject to availability of parts and man power.<br>
                            </td><td style='width: 5px' ></td>
                            <td colspan="2" style='border:1px solid #000;'>&nbsp;</td>
                        </tr>
                        <tr><td colspan="3" style='height: 4px;'>&nbsp;</td></tr>
                        <tr><td></td><td colspan="2" style='border:1px solid #000;text-align: center;'>I Certify that there are no
valubles in the car</td></tr>
                        <tr><td colspan="3" style='height: 4px;'>&nbsp;</td></tr>
                         <tr><td colspan="3" >&nbsp;</td></tr>
                        <tr><td></td><td colspan="2" style='border-top:1px dashed #000;text-align: center;'>Customer Authorisation</td></tr>
                        <tr><td colspan="3" style='height: 4px;'>&nbsp;</td></tr>
                        <tr><td></td><td colspan="2" style='border-top:1px dashed #000;text-align: center;'>Name</td></tr>
                         <tr><td colspan="3" >&nbsp;</td></tr>
                </table>
                </div>
                <table border="1" style="border-collapse:collapse;width:700px;margin-top:4px; ">
                    <tbody>
                        <tr>
                            <td style="width:500px">FURTHER WORK REQUIR</td><td  style="width:200px">Spare Part Card No &nbsp;:&nbsp;<?php echo $jobHed->SparePartJobNo?></td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                    </tbody>
                </table> -->
            </div>
                            </div>
                             <div class="col-lg-1"></div>
                            <div class="col-lg-4">
                                <div class="row"> 
                                <div class="col-lg-11">
                                <table class="table" style="font-size:11px;">
                                    <tr><td>Create by</td><td>:</td><td><?php echo $jobHed->first_name; ?></td></tr>
                                    <tr><td>Create Date</td><td>:</td><td><?php echo $jobHed->appoimnetDate ?></td></tr>
                                   
                                  <?php if($invUpdate):  ?>
                                  <tr><td colspan="3">Last Updates</td></tr>
                                  <?php  foreach ($invUpdate AS $up) { ?>
                                    <tr><td><?php echo $up->UpdateDate ?></td><td>:</td><td><?php echo $up->Remark." by ".$up->first_name." ".$up->last_name ?></td></tr>
                                  <?php }
                                  endif; ?>
                                  </table>
                                  <?php if($estimate){ ?>
                                    <table class="table"  style="font-size:11px;">
                                            <tr><td colspan="4"><h4>Estimates</h4></td></tr>
                                            <tr><td>Date</td><td>Estimate NO</td><td>:</td><td>Net Amount</td></tr>
                                            <?php $totalEst=0;
                                              foreach ($estimate as $po) { ?>
                                               <tr><td><?php  echo $po->EstDate;   ?></td><td><a target="_blank" href="../../job/view_estimate?type=est&id=<?php echo base64_encode($po->EstimateNo);?>&sup=<?php echo $po->Supplimentry; ?>"><?php  echo $po->EstimateNo;   ?></a></td><td><?php  echo $po->Supplimentry;   ?></td><td><?php  echo number_format($po->EstNetAmount,2);   ?></td></tr>
                                           <?php $totalEst+=$po->EstNetAmount; } ?>
                                           <tr><td></td><td>Total</td><td></td><td><?php  echo number_format($totalEst,2);   ?></td></tr>
                                    </table>
                                    <?php } ?>
                                    <?php if($jobpo){ ?>
                                    <table class="table"  style="font-size:11px;">
                                            <tr><td colspan="4"><h4>Purchase Orders</h4></td></tr>
                                            <tr><td>Date</td><td>PO NO</td><td>:</td><td>PO Amount</td></tr>
                                            <?php $totalPO=0;
                                              foreach ($jobpo as $po) { ?>
                                               <tr><td><?php  echo $po->PO_Date;   ?></td><td><a target="_blank" href="../../purchase/view_po/<?php echo base64_encode($po->PO_No);?>"><?php  echo $po->PO_No;   ?></a></td><td>:</td><td><?php  echo number_format($po->PO_NetAmount,2);   ?></td></tr>
                                           <?php $totalPO+=$po->PO_NetAmount; } ?>
                                           <tr><td></td><td>Total</td><td></td><td><?php  echo number_format($totalPO,2);   ?></td></tr>
                                    </table>
                                    <?php } ?>
                                </div></div>
                            </div>
                           <!-- <div class="row row-eq-height"> -->
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <!-- <form action="admin/job/do_upload" method="post" enctype="multipart-fomdata"> -->
                <?php echo form_open_multipart('admin/job/do_upload');?>
                    <div class="form-group" role="group">
                        <label>Document Image</label>
                        <input type="Hidden" name="jNo" id="jNo" value="<?php echo $JobNo;?>">
                        <?php echo $error;?>
                        <input type="Hidden" name="jobNo" id="jobNo" value="<?php echo $JobNo;?>">
                        <input type="file" name="userfile" size="20" />
                    </div>
                    <div class="form-group" role="group">
                        <input type="submit" class="btn btn-primary" value="upload" />
                    </div>
                </form>
            </div>
            <div class="col-sm-8">
            <div class="row">
                <?php foreach ($job_doc as $doc) { ?>
                <div class="col-sm-3">
                    <a href="<?php echo base_url("upload/job_doc/$doc->doc_name");?>" rel="facebox">
                        <img src="<?php echo base_url("upload/job_doc/$doc->doc_name");?>" class="thumbnail" width="150">
                    </a>
                </div>
                <?php } ?>
            </div>
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
        <?php //jobcard print 
                    //$this->load->view('admin/job/jobcard-print.php',true); ?>
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
$('a[rel*=facebox]').facebox(); 
$("#div_emp").hide();

$("#jobStatus").change(function(){
    var job_status = $(this).val();

    if(job_status==1){
        $("#div_emp").show();
    }else{
        $("#div_emp").hide();
    }
});

$("#tblEmp tr").on('click','.btnRemove',function(){
    var wid=0;
    wid=($(this).attr('wid'));
    $.ajax({
        type: "POST",
        url: "../../job/removeEmployee",
        data: { emp:wid},
        success: function(data)
        {
            var resultData = JSON.parse(data);
            var feedback = resultData['fb'];
            var invNumber = resultData['InvNo'];

            if (feedback != 1) {
                $.notify("Employee has not deleted.", "warning");
                return false;
            } else {
                $.notify("Employee has Successfully deleted.", "success");
                location.reload();
                return false;
            }
        }
    });
});


    $("#btnCancel").click(function(){

        var r = confirm("Do you want to cancel this job card.?");
        if (r == true) {
            var jobdata = $("#jobArr").val();
            $("#btnCancel").attr('disabled', true);
                $.ajax({
                    url: "../../job/cancelJob",
                    type: "POST",
                    data: {jobNo:jobNo},
                    success: function(data) {
                        var newdata = JSON.parse(data);
                        var fb = newdata.fb;
                        var lastproduct_code = newdata.JobCardNo;

                        if (fb) {
                            $.notify(lastproduct_code+" Job card  successfully canceled.", "success");
                            $("#btnCancel").attr('disabled', false);
                        } else {
                             $.notify(" Opps Error.", "danger");
                            $("#btnCancel").attr('disabled', false);
                        }
                    }
            });
        }else{

        }
    });

$("#btnSave").click(function(){
    $("#btnSave").prop("disabled",true);
    var jobStatus = $("#jobStatus option:selected").val();
    var emp = $("#emp option:selected").val();
    var branch= $("#branch option:selected").val();
     $.ajax({
        type: "POST",
        url: "../../job/updateJobStatus",
        data: { jobStatus: jobStatus,emp:emp,jobNo:jobNo,branch:branch},
        success: function(data)
        {
            var resultData = JSON.parse(data);
            var feedback = resultData['fb'];
            var invNumber = resultData['InvNo'];
            var iswork = resultData['work'];

            if (feedback != 1) {
                if(iswork==2){
                    $.notify("Employee has already assigned.", "warning");
                    $("#btnSave").attr('disabled', false);
                    return false;
                }else{
                    $.notify("Job Status Not Updated.", "warning");
                    $("#btnSave").attr('disabled', false);
                    return false;
                }
                
            } else {
                if(iswork==2){
                    $.notify("Employee has already assigned.", "warning");
                    $("#btnSave").attr('disabled', false);
                    return false;
                }else{
                    $.notify("Job Status Successfully Updated.", "success");
                    $("#btnSave").prop('disabled',false);
                    location.reload();
                    return false;
                }
                
            }
        }
    });
});
        var jobNo='';
        jobNo=$("#jNo").val();
        loadInvoicetoPrint(jobNo);
        $("#btnPrint").click(function(){

            
$('#printArea').focus().print();
});

        function loadInvoicetoPrint(JobNo){

        $("#tbl_jobcard_data tbody").html('');
        $.ajax({
                type: "POST",
                url: "../../job/getJobDataById",
                data: { jobNo: JobNo},
                success: function(data)
                {
                    var resultData = JSON.parse(data);

                    $("#lblcusCode").html(resultData.cus_data.CusCode);
                    $("#lblAddress").html(nl2br(resultData.cus_data.Address01)+",<br><br> ");
                    $("#lblCusName").html(resultData.cus_data.RespectSign+". "+resultData.cus_data.CusName);
                    $("#lblpaymentType").html(resultData.cus_data.payType);
                    $("#lblemail").html(resultData.cus_data.Email);
                    
                    $("#lblcusName").html(resultData.vehicle_data.contactName);
                   
                    $("#lblmake").html(resultData.vehicle_data.make);
                    $("#lblmodel").html(resultData.vehicle_data.model);
                    $("#lblFuelType").html(resultData.vehicle_data.fuel_type);
                    $("#lblviNo").html(resultData.vehicle_data.ChassisNo);
                    
                    $("#lblcountry").html(resultData.vehicle_data.body_color);

                    $("#lblcusCode").html(resultData.cus_data.CusCode);
                    $("#lblJobNo").html(resultData.job_data.JobCardNo);
                    $("#lblregNo").html(resultData.job_data.JRegNo);
                    $("#lblnoofjobs").html(resultData.job_count.noofjobs);
                   
                    $("#lblOdo").html(resultData.job_data.OdoIn);
                    $("#lblNextService").html(parseFloat(resultData.job_data.OdoIn)+parseFloat(resultData.job_data.NextService));
                    
                    $("#lblSAName").html(resultData.job_data.serviceAdvisor);
                    $("#lblTel").html(resultData.job_data.advisorContact);
                    $("#lbldate").html(resultData.job_data.appoimnetDate); 
                    $("#lbldelveryDate").html((resultData.job_data.deliveryDate).substring(0, 10)); 
                    $("#lbldelveryTime").html((resultData.job_data.deliveryDate).substring(10, 19)); 

                    for (var i =  0; i < resultData.job_desc.length; i++) {
                         k=(i+1);
                     $("#tbl_jobcard_data tbody").append("<tr><td style='text-align: center;'>" + (k) + "</td><td style='padding-left: 5px;'>" + resultData.job_desc[i].JobDescription + "</td><td>&nbsp;</td><td>&nbsp;</td></tr>");
            
                    }
                    $("#tbl_jobcard_data tbody").append("<tr><td style='height:150px;'></td><td style='height:150px;'></td><td style='height:150px;'></td><td style='height:150px;'></td></tr>");
                    $("#btnPrint").prop('disabled',false);
                }
            });
    }

     function nl2br (str, is_xhtml) {
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }
 
</script>
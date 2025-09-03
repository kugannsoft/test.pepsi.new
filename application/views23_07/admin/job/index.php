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
            <div class="col-sm-8">
                <div class="box box-success">
                    <form action="" method="post" id="saveJobform" class="form-horizontal" accept-charset="utf-8">
                    <div class="box-header">
                        <div class="row row-eq-height">
                            <div class="col-sm-6">
                            
                                <div class="form-group" style="display:none;">
                                    <label for="companyCode" class="col-sm-5 control-label">Company Code <span class="required"></span></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control"  name="companyCode" id="companyCode" placeholder="Enter Company Code">
                                         <input type="hidden" class="form-control" required="required"  name="location" id="invlocation" value="<?php echo $_SESSION['location'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="cusCode" class="col-sm-5 control-label">Customer <span class="required">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="cusCode" id="cusCode" value="<?php echo ($cuscode);?>" placeholder="">
                                    </div>
                                    <div class="col-sm-1">
                                    <button data-target="#customermodal"  id="newCustomer" class="btn btn-flat btn-primary pull-right" title="New Customer"><i class="fa fa-user-plus"></i></button>
                                    </div>
                                </div>
<!--                                <div class="form-group">-->
<!--                                    <label for="regNo" class="col-sm-5 control-label">Vehicle Number <span class="required">*</span></label>-->
<!--                                    <div class="col-sm-7">-->
                                        <input type="hidden" class="form-control" required="required"  name="regNo" id="vehicleNo" value="<?php echo ($regno);?>" placeholder="Ex: WP AAA-2312">
<!--                                    </div>-->
<!--                                </div>-->
                                <div class="form-group">
                                    <label for="cusType" class="col-sm-5 control-label">Payment Type <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                     <input type="hidden" name="cusType" id="cusType" value="0">
                                        <select name="payType" required="required"  id="payType" class="form-control">
                                            <option value="">Select a payment type</option>
                                             <?php foreach ($paytype as $trns) { ?>
                                            <option value="<?php echo $trns->payTypeId; ?>" ><?php echo $trns->payType; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" style="display:none;">
                                    <label for="cusType" class="col-sm-5 control-label">Customer Type <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                     <input type="hidden" name="cusType" id="cusType" value="0">
<!--                                        <select name="cusType" required="required"  id="cusType" class="form-control">-->
<!--                                            <option value="">Select a customer type</option>-->
<!--                                             --><?php //foreach ($custype as $trns) { ?>
<!--                                            <option value="--><?php //echo $trns->CusTypeId; ?><!--" >--><?php //echo $trns->CusType; ?><!--</option>-->
<!--                                            --><?php //} ?>
<!--                                        </select>-->
                                    </div>
                                </div>
<!--                                <div class="form-group" id="vcompany">-->
<!--                                <div class="form-group">-->
<!--                                    <label for="cusCompany" class="col-sm-5 control-label">Insurance Company<span class="required"></span></label>-->
<!--                                    <div class="col-sm-7">-->
                                    <!-- <input type="hidden" name="vehicleCompany" id="vehicleCompany" value="0"> -->
<!--                                         <select name="vehicleCompany" id="vehicleCompany2" class="form-control">-->
<!--                                            <option value="">Select a company</option>-->
<!--                                            --><?php //foreach ($vehicle_company as $trns) { ?>
<!--                                            <option value="--><?php //echo $trns->VComId; ?><!--" >--><?php //echo $trns->VComName; ?><!--</option>-->
<!--                                            --><?php //} ?>
<!--                                        </select>-->
<!--                                    </div>-->
<!--                                    </div>-->
<!--                                    <div class="form-group">-->
<!--                                    <label for="cusCompany" class="col-sm-5 control-label">Insurance Document<span class="required"></span></label>-->
<!--                                    <div class="col-sm-7">-->
                                    <!-- <input type="tet" name="insdoc"  class="form-control" id="insdoc" value=""> -->
<!--                                    Yes <input type="radio" class="prd_icheck" name="insdoc" id="insdoc1" value="1">&nbsp;&nbsp;-->
<!--                                    No <input type="radio" class="prd_icheck" name="insdoc" id="insdoc2" value="0" checked="checked">-->
                                         <!-- <select name="vehicleCompany" id="vehicleCompany" class="form-control">
                                            <option value="">Select a company</option>
                                            <?php foreach ($vehicle_company as $trns) { ?>
                                            <option value="<?php echo $trns->VComId; ?>" ><?php echo $trns->VComName; ?></option>
                                            <?php } ?>
                                        </select> -->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                </div>-->
<!--                                    <div class="form-group">-->
<!--                                        <label for="odoIn" class="col-sm-5 control-label">Odo meter In <span class="required">*</span></label>-->
<!--                                        <div class="col-sm-4">-->
<!--                                            <input type="number" class="form-control" name="odoIn" id="odoIn" placeholder="">-->
<!--                                        </div>-->
<!--                                        <div class="col-sm-3">-->
<!--                                            <select  class="form-control" name="odoInUnit" id="odoInUnit" >-->
<!--                                                <option value="1">km</option>-->
<!--                                                <option value="2">miles</option>-->
<!--                                            </select>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="form-group">-->
<!--                                        <label for="odoOut" class="col-sm-5 control-label">Odo meter Out <span class="required"></span></label>-->
<!--                                        <div class="col-sm-4">-->
<!--                                            <input type="number" class="form-control" name="odoOut" id="odoOut" placeholder="">-->
<!--                                        </div>-->
<!--                                        <div class="col-sm-3">-->
<!--                                            <select  class="form-control" name="odoOutUnit" id="odoOutUnit" >-->
<!--                                                <option value="1">km</option>-->
<!--                                                <option value="2">miles</option>-->
<!--                                            </select>-->
<!--                                        </div>-->
<!--                                    </div>-->
                                <div class="form-group">
                                        <label for="advance" class="col-sm-5 control-label">Estimate No<span class="required"></span></label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control"  name="estimateNo" id="estimateNo" placeholder="">
                                        </div>
                                    </div>

                                <div class="form-group">
                                    <label for="advisorName" class="col-sm-5 control-label">Service Advisor <span class="required"></span></label>
                                    <div class="col-sm-7">
                                        <select name="advisorName" id="advisorName" class="form-control">
                                            <option value="">Select an advisor</option>
                                            <?php foreach ($advisor as $trns) { ?>
                                                <option value="<?php echo $trns->id; ?>" ><?php echo $trns->first_name." ".$trns->last_name; ?></option>
                                            <?php } ?>
                                        </select>
                                        <!-- <input type="text" class="form-control" required="required"  name="advisorName" id="advisorName" placeholder="Service Advisor Name" value="<?php echo $company['SAdvisorName'];?>"> -->
                                    </div>
                                </div>
                                <div class="form-group"  style="display:none;">
                                    <label for="advisorPhone" class="col-sm-5 control-label">S.A. Contact <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="advisorPhone" id="advisorPhone" placeholder="Service Advisor Contact" value="<?php echo $company['SAdvisorContact'];?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="appoDate" class="col-sm-5 control-label">Appoiment Date <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" required="required"  name="appoDate" id="appoDate" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="deliveryDate" class="col-sm-5 control-label">Delivery Date <span class="required"></span></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="deliveryDate" id="deliveryDate" placeholder="">
                                    </div>
                                </div>
<!--                                    <div class="form-group">-->
<!--                                        <label for="sparePartCNo" class="col-sm-5 control-label">Spare Part Card No <span class="required"></span></label>-->
<!--                                        <div class="col-sm-7">-->
                                            <input type="hidden" class="form-control"  name="sparePartCNo" id="sparePartCNo" placeholder="">
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="form-group">-->
<!--                                        <label for="nextService" class="col-sm-5 control-label">Next Service (Km) <span class="required"></span></label>-->
<!--                                        <div class="col-sm-7">-->
                                            <input type="hidden" class="form-control" onfocus="this.select();"  name="nextService" id="nextService" placeholder="" value="0">
<!--                                        </div>-->
<!--                                    </div>-->
                                <!-- </form> -->
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group" >
                                    <label for="jobSection" class="col-sm-5 control-label">Job Type <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <?php foreach ($jobsection as $trns) { ?>
                                        <div class="input-group">
                                            <input type="checkbox" class="prd_icheck input-group-text"  name="jobSection[]" id="jobSection<?php echo $trns->JobSecNo; ?>" value="<?php echo $trns->JobSecNo; ?>">&nbsp;&nbsp;-&nbsp;<label class="input-group-text"><?php echo $trns->JobSection; ?>&nbsp;</label>&nbsp;<br>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                 <!-- <form action=""  class="form-horizontal" accept-charset="utf-8"> -->

                                <div class="form-group" style="display:none;">
                                    <label for="jobtype" class="col-sm-5 control-label">Job Type <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <select name="jobtype" id="jobtype" class="form-control">
                                            <!-- <option value="">Select a job type</option> -->
                                            <?php foreach ($jobcondtion as $trns) { ?>
                                            <option value="<?php echo $trns->JobConId; ?>" ><?php echo $trns->JobCondition; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="divprevjob">
                                    <label for="prevJobNum" class="col-sm-5 control-label">Previous Job No <span class="required"></span></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="prevJobNum" id="prevJobNum" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="advance" class="col-sm-5 control-label">Advance<span class="required"></span></label>
                                    <div class="col-sm-7">
                                        <div class="input-group">
                                            <span class="input-group">
                                                <input type="text" class="form-control" onfocus="this.select();"   name="advance" id="advance" placeholder="" value="0">
                                            </span>
                                            <span class="input-group-btn">
                                                <a href="#" target="_blank" id="addadvance" class="btn btn-primary" title="Add advance"><i class="fa fa-plus"></i></a>
                                            </span>
                                            <span class="input-group-btn">
                                                <button class="btn btn-danger" id="removeadv" title="Remove advance"><i class="fa fa-close"></i></button>
                                            </span>
                                            <input type="hidden" class="form-control" onfocus="this.select();"   name="advanceno" id="advanceno" placeholder="" value="0">
                                        </div>
                                        <span id="lbladvanceno"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                           
                            <div class="form-group" style="display:none;">
                                <label for="invDate" class="col-sm-3 control-label">Job Category <span class="required">*</span></label>
                                <div class="col-sm-5">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <select class="form-control" name="jobcategory" id="jobcategory">
                                                    <!-- <option value="">Select a Category</option> -->
                                                     <?php foreach ($jobcategory as $trns) { ?>
                                                    <option value="<?php echo $trns->jobcategory_id; ?>" ><?php echo $trns->job_category; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </span>
                                            <span class="input-group-btn">
                                            </span>
                                    </div>
                                    <div class="input-group">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="invDate" class="col-sm-3 control-label">Customer Request Notes<span class="required">*</span></label>
                                <div class="col-sm-9">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <input type="text" class="form-control" name="jobdesc" id="jobdesc" placeholder=""></span>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-warning" id="addDesc" title="Save this option"><i class="fa fa-plus"></i></button>
                                                </span>
                                    </div>
                                    <div class="input-group">
                                        <!-- <select name="jobdesc2" id="jobdesc2" class="form-control">
                                            <option value="">Select a job description</option>
                                            <?php foreach ($jobdesc as $trns) { ?>
                                            <option value="<?php echo $trns->JobDescNo; ?>" ><?php echo $trns->JobDescription; ?></option>
                                            <?php } ?>
                                        </select> -->
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="invDate" class="col-sm-3 control-label"><span class="required"></span></label>
                                <div class="col-sm-5">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                               <input type="button" class="btn btn-success" value="Add"  id="btnAdd">
                                            </span>
                                    </div>
                                    <div class="input-group"></div>
                                </div>
                            </div>
                        
                    </div>
                    <div class="row"><hr>
                        <div class="table-responsive">
                            <table id="tbl_payment" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>#</th>
                                        <th>Customer Request Notes</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div></div>
                        <div class="row"><hr>
                            <div class="form-group">
                                    <!-- <label for="invDate" class="col-sm-5 control-label"><span class="required"></span></label> -->
                                    <div class="col-sm-6"></div><div class="col-sm-2">
                                        <input type="hidden" class="form-control" name="jobArr"  id="jobArr">
                                        <input type="hidden" class="form-control" name="jobNumArr" id="jobNumArr">
                                        <input type="hidden" class="form-control" name="jobCatArr" id="jobCatArr">
                                        <input type="submit" class="btn btn-info pull-left" id='saveJob' value="Save Job">
                                    </div>
                                    <div class="col-sm-2">
                                        <!-- <input type="button" class="btn btn-info pull-left" id='btnPrint' value="Print"> -->
                                        <a href="#" id="jobLink" disabled class="btn btn-flat btn-primary pull-right">Print</a>
                                    </div>
                                    <div class="col-sm-2">
                                        <!-- <input type="button" class="btn btn-info pull-left" id='btnLabourPrint' value="Labour Print"> -->
                                    </div>
                                </div>
                                <span class="label label-success" id="modelNotifi"></span>
                                <span class='pull-left' id="lastJob"></span>
                        </div>
                    </div><!-- /.box-body -->
                </form>
                </div><!-- /.box -->
            </div>
            <div class="col-sm-4">
            <div class="box box-success">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="cus_details">
                                    
                                   <tbody>
                                   <tr>
                                            <th colspan="3"><b>Customer Details</b>
<!--                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button id="NewVehicle" class="btn btn-sm btn-success pull-right">New Vehicle <i class="fa fa-plus"></i></button>-->
                                            </th>
                                        </tr>
                                        <tr><td colspan="3" >&nbsp;</td></tr>
                                        <tr>
                                            <td>Customer Name</td>
                                            <td>:</td>
                                            <td id="customerName">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>Customer Address</td>
                                            <td>:</td>
                                            <td id="cusAddress">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td id="cusAddress2">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>Phone Number</td>
                                            <td>:</td>
                                            <td id="cusPhone"></td>
                                        </tr>
                                        <tr>
                                            <td>Outstanding</td>
                                            <td>:</td>
                                            <td id="cusOutstand"></td>
                                        </tr> <tr><td colspan="3" >&nbsp;</td></tr>
                                        <tr>
<!--                                            <th colspan="3"><b>Vehicle details</b></th>-->
<!--                                        </tr> <tr><td colspan="3" >&nbsp;</td></tr>-->
<!--                                        <tr>-->
<!--                                            <td>Contact Name</td>-->
<!--                                            <td>:</td>-->
<!--                                            <td id="contactName"></td>-->
<!--                                        </tr>-->
<!--                                        <tr>-->
<!--                                            <td>Register No</td>-->
<!--                                            <td>:</td>-->
<!--                                            <td id="registerNo"></td>-->
<!--                                        </tr>-->
<!--                                        <tr>-->
<!--                                            <td>Make</td>-->
<!--                                            <td>:</td>-->
<!--                                            <td id="lblmake"></td>-->
<!--                                        </tr>-->
<!--                                        <tr>-->
<!--                                            <td>Model</td>-->
<!--                                            <td>:</td>-->
<!--                                            <td id="lblmodel"></td>-->
<!--                                        </tr>-->
<!--                                        <tr>-->
<!--                                            <td>Chassis No</td>-->
<!--                                            <td>:</td>-->
<!--                                            <td id="chassi"></td>-->
<!--                                        </tr>-->
                                    </tbody>
                                </table>
                                <div class="form-group">
<!--                                    <div class="col-sm-12" style="font-size: 20px">-->
<!--                                        Next Service Mileage - -->
<!--                                        <b><span   name="nextMileage" id="nextMileage"></span> Km</b>-->
<!--                                    </div>-->
                                    <div class="col-sm-12"><br></div>
                                    <div class="col-sm-6">
                                        <a href="<?php echo base_url('admin/job/view_job'); ?>" class="btn btn-success">View All Jobs</a>
                                    </div>
                                    <div class="col-sm-6">
                                        <a href="#" id="invLink" disabled class="btn btn-flat btn-primary pull-right">Add Invoice</a>&nbsp;
                                    </div>
<!--                                    <div class="col-sm-4">-->
<!--                                        <a href="#" id="estLink" disabled class="btn btn-flat btn-primary pull-right">Add Estimate</a>&nbsp;-->
<!--                                    </div>-->
                                </div>
                                
                                &nbsp;
                                
                                
                            </div></div></div></div>
            </div>
        </div>
    </section>
    <div id="customermodal" class="modal fade bs-add-category-modal-lg" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-lg" style="width: 95%;">
        <div class="modal-content">
            <!-- load data -->
        </div>
    </div>
</div>
    <!--invoice print-->
    <div class="modal fade bs-payment-modal-lg" id="modelInvoice" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"><div class="modal-body" >
            <?php //jobcard print 
                    $this->load->view('admin/job/jobcard-print.php',true); ?>
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

</script>
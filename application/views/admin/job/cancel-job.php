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
                    <div class="box-header">
                        <div class="row row-eq-height"><form action="" method="post" id="cancelJobform" class="form-horizontal" accept-charset="utf-8">
                            <div class="col-sm-6">
                            
                                <div class="form-group">
                                    <label for="companyCode" class="col-sm-5 control-label">Job No<span class="required"></span></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control"  name="jobNo" id="jobNo" value="<?php echo ($JobNo);?>" placeholder="Enter Job no">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="cusCode" class="col-sm-5 control-label">Customer <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <input type="text" disabled class="form-control" required="required"  name="cusCode" id="cusCode" value="" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="regNo" class="col-sm-5 control-label">Reg No <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <input type="text" disabled class="form-control" required="required"  name="regNo" id="regNo" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="cusType" class="col-sm-5 control-label">Customer Type <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <select name="cusType" disabled required="required"  id="cusType" class="form-control">
                                            <option value="">Select a customer type</option>
                                             <?php foreach ($custype as $trns) { ?>
                                            <option value="<?php echo $trns->CusTypeId; ?>" ><?php echo $trns->CusType; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="cusCompany" class="col-sm-5 control-label"> <span class="required"></span></label>
                                    <div class="col-sm-7">
                                        <select name="vehicleCompany" disabled id="vehicleCompany" class="form-control">
                                            <option value="">Select a company</option>
                                            <?php foreach ($vehicle_company as $trns) { ?>
                                            <option value="<?php echo $trns->VComId; ?>" ><?php echo $trns->VComName; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                    <div class="form-group">
                                        <label for="odoIn" class="col-sm-5 control-label">Odo meter In <span class="required">*</span></label>
                                        <div class="col-sm-7">
                                            <input type="text" disabled class="form-control" required="required"  name="odoIn" id="odoIn" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="odoOut" class="col-sm-5 control-label">Odo meter Out <span class="required">*</span></label>
                                        <div class="col-sm-7">
                                            <input type="text" disabled class="form-control"  name="odoOut" id="odoOut" placeholder="">
                                        </div>
                                    </div>                                   
                                <div class="form-group">
                                        <label for="advance" class="col-sm-5 control-label">Estimate No<span class="required"></span></label>
                                        <div class="col-sm-7">
                                            <input type="text" disabled class="form-control"  name="estimateNo" id="estimateNo" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sparePartCNo" class="col-sm-5 control-label">Spare Part Card No <span class="required"></span></label>
                                        <div class="col-sm-7">
                                            <input type="text" disabled class="form-control"  name="sparePartCNo" id="sparePartCNo" placeholder="">
                                        </div>
                                    </div>
                                <!-- </form> -->
                            </div>
                            <div class="col-sm-6">
                                 <!-- <form action=""  class="form-horizontal" accept-charset="utf-8"> -->
                                <div class="form-group">
                                    <label for="advisorName" class="col-sm-5 control-label">Service Advisor <span class="required"></span></label>
                                    <div class="col-sm-7">
                                        <input type="text" disabled class="form-control" required="required"  name="advisorName" id="advisorName" placeholder="Service Advisor Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="advisorPhone" class="col-sm-5 control-label">S.A. Contact <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <input type="text" disabled class="form-control" required="required"  name="advisorPhone" id="advisorPhone" placeholder="Service Advisor Contact">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="appoDate" class="col-sm-5 control-label">Appoiment Date <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <input type="text" disabled class="form-control" required="required"  name="appoDate" id="appoDate" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="deliveryDate" class="col-sm-5 control-label">Delivery Date <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <input type="text" disabled class="form-control" required="required"  name="deliveryDate" id="deliveryDate" placeholder="">
                                    </div>
                                </div>
                                    <div class="form-group">
                                    <label for="jobtype" class="col-sm-5 control-label">Job Type <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <select name="jobtype" disabled id="jobtype" class="form-control">
                                            <option value="">Select a job type</option>
                                            <?php foreach ($jobcondtion as $trns) { ?>
                                            <option value="<?php echo $trns->JobConId; ?>" ><?php echo $trns->JobCondition; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                        <label for="prevJobNum" class="col-sm-5 control-label">Previous Job No <span class="required"></span></label>
                                        <div class="col-sm-7">
                                            <input type="text" disabled class="form-control" name="prevJobNum" id="prevJobNum" placeholder="">
                                        </div>
                                    </div>
                                <div class="form-group">
                                        <label for="jobSection" class="col-sm-5 control-label">Section <span class="required">*</span></label>
                                        <div class="col-sm-7">
                                            <select name="jobSection" disabled id="jobSection" required="required" class="form-control">
                                                <option value="">Select a section</option>
                                                <?php foreach ($jobsection as $trns) { ?>
                                            <option value="<?php echo $trns->JobSecNo; ?>" ><?php echo $trns->JobSection; ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="advance" class="col-sm-5 control-label">Advance<span class="required">*</span></label>
                                        <div class="col-sm-7">
                                            <input type="text" disabled class="form-control"   name="advance" id="advance" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="invDate" class="col-sm-5 control-label"><span class="required"></span></label>
                                        <div class="col-sm-7">
                                            <input type="hidden" class="form-control" name="jobArr"  id="jobArr">
                                            <input type="hidden" class="form-control" name="jobNumArr" id="jobNumArr">
                                            <input type="submit" class="btn btn-info pull-left" id='cancelJob' value="Cancel Job">
                                        </div>
                                    </div>
                                    <span class="label label-success" id="modelNotifi"></span>
                                    <span class='pull-left' id="lastJob"></span>
                                    
                            </div></form>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                           <form action=""  class="form-horizontal" accept-charset="utf-8">
                            <label for="invDate" class="col-sm-3 control-label">Job Description <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <div class="input-group">
    <!--   <span class="input-group-btn">
        <button class="btn btn-secondary" type="button">Hate it</button>
      </span> -->
      
                                        <span class="input-group-btn">
       <input type="text" class="form-control" required="required" disabled  name="jobdesc" id="jobdesc" placeholder=""></span>
      <span class="input-group-btn">

        <input disabled type="button" class="btn btn-success" value="Add"  id="btnAdd">
      </span>
    </div>
                            <div class="input-group">
                            <select name="jobdesc2" disabled id="jobdesc2" class="form-control">
                                            <option value="">Select a job description</option>
                                            <?php foreach ($jobdesc as $trns) { ?>
                                            <option value="<?php echo $trns->JobDescNo; ?>" ><?php echo $trns->JobDescription; ?></option>
                                            <?php } ?>
                                        </select>
                                        <!-- <input type="text" class="form-control" required="required"  name="jobdesc" id="jobdesc" placeholder=""> -->
                            </div>
                                        
                                    </div>
                                   <!--   <div class="col-sm-2">
                                        <input type="button" class="btn btn-success" value="Add"  id="btnAdd">
                                    </div> -->
                                    </form>
                        </div>
<div class="row">
                        <div class="table-responsive">
                            <table id="tbl_payment" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Job Discription</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div></div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
            <div class="col-sm-4">
            <div class="box box-success">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="cus_details">
                                   <tbody>
                                   <tr><tr>
                                            <th colspan="3"><b>Customer Details</b></th>
                                        </tr><td colspan="3" >&nbsp;</td></tr>
                                        <tr>
                                            <td>Customer Name</td>
                                            <td>:</td>
                                            <td id="cusName"></td>
                                        </tr>
                                        <tr>
                                            <td>Customer Address</td>
                                            <td>:</td>
                                            <td id="cusAddress"></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td id="cusAddress2"></td>
                                        </tr>
                                        <tr>
                                            <td>Phone Number</td>
                                            <td>:</td>
                                            <td id="cusPhone"></td>
                                        </tr> <tr><td colspan="3" >&nbsp;</td></tr>
                                        <tr>
                                            <th colspan="3"><b>Vehicle details</b></th>
                                        </tr> <tr><td colspan="3" >&nbsp;</td></tr>

                                        <tr>
                                            <td>Contact Name</td>
                                            <td>:</td>
                                            <td id="contactName"></td>
                                        </tr>
                                        <tr>
                                            <td>Register No</td>
                                            <td>:</td>
                                            <td id="registerNo"></td>
                                        </tr>
                                        <tr>
                                            <td>Make</td>
                                            <td>:</td>
                                            <td id="make"></td>
                                        </tr>
                                        <tr>
                                            <td>Model</td>
                                            <td>:</td>
                                            <td id="model"></td>
                                        </tr>
                                        <tr>
                                            <td>YOM</td>
                                            <td>:</td>
                                            <td id="yom"></td>
                                        </tr>
                                        <tr>
                                            <td>Fuel</td>
                                            <td>:</td>
                                            <td id="fuel"></td>
                                        </tr>
                                        <tr>
                                            <td>Chassis No</td>
                                            <td>:</td>
                                            <td id="chassi"></td>
                                        </tr>
                                        <tr>
                                            <td>Engine No</td>
                                            <td>:</td>
                                            <td id="engNo"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div></div></div></div>
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
            <form role="form" id="addDep" data-parsley-validate method="post" action="#">
            </form>
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
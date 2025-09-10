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
                    <div class="row">
                        <div class="col-sm-2">
                            <div  class="form-group">
                                <input type="text" class="form-control" required="required"  name="invoiceNo" id="invoiceNo" placeholder="Package No"  value="<?php if(isset($JobInvoiceNo)){echo $JobInvoiceNo;}?>" >
                            <input type="hidden" class="form-control" required="required"  name="appoDate" id="appoDate" placeholder="Date">
                            <input type="hidden" class="form-control" required="required"  name="jobType" id="jobType" placeholder="Date">
                                <!-- <select name="jobType" required="required"  id="jobType" class="form-control">
                                            <option value="">Select a job type</option>
                                             <?php foreach ($jobtype as $trns) { ?>
                                            <option value="<?php echo $trns->EstimateJobNo; ?>"  value="<?php echo $trns->EstimateJobNo; ?>"  ><?php echo $trns->EstimateJobType; ?></option>
                                            <?php } ?>
                                        </select> -->
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div  class="form-group">
                                <input  class="form-control" type="text" placeholder="Package Name" name="packageName" id="packageName" value="<?php if(isset($EstimateNo)){echo $EstimateNo;}?>">
                                <input type="hidden" name="location" id="location" value="<?php echo $_SESSION['location'] ?>"><input type="hidden" name="estimateNo" id="estimateNo" value="">
                                <input type="hidden" name="vatRate" id="vatRate" value="<?php echo $company['VAT']; ?>">
                                <input type="hidden" name="nbtRate" id="nbtRate" value="<?php echo $company['NBT']; ?>">
                                <input type="hidden" name="nbtRatioRate" id="nbtRatioRate" value="<?php echo $company['NBT_Ratio']; ?>">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div  class="form-group  pull-right">
                            Discout Type
                            <input type="hidden" class="form-control" required="required"  name="vehicleCompany" id="vehicleCompany" value="0">
                               <!--  <select name="vehicleCompany" id="vehicleCompany" class="form-control">
                                            <option value="">Select a company</option>
                                            <?php foreach ($vehicle_company as $trns) { ?>
                                            <option value="<?php echo $trns->VComId; ?>" ><?php echo $trns->VComName; ?></option>
                                            <?php } ?>
                                        </select> -->
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group input-group">
                                <span class="input-group-addon">
                                    <input tabindex="16"  type="radio" class="prd_icheck" name="discount_type" id="productWise" checked value="1">
                                </span>
                                <span class="input-group-addon">Job Wise</span>
                            </div>
                        </div>
                        <div class="col-sm-2">
                        <input type="hidden" class="form-control" required="required"  name="estimateType" id="estimateType" placeholder="Date" value="0">
                            <!-- <div  class="form-group">
                             <input type="hidden" class="form-control" required="required"  name="estimateType" id="estimateType" placeholder="Date">
                                <select name="estimateType" id="estimateType" class="form-control">
                                    <option value="">Select an estimate type</option>
                                    <?php foreach ($estimate_type as $trns) { ?>
                                    <option value="<?php echo $trns->EstimateTypeNo; ?>" ><?php echo $trns->EstimateType; ?></option>
                                    <?php } ?>
                                </select>

                            </div> -->
                             <div class="form-group input-group">
                            <!--  <input type="hidden" class="form-control" required="required"  name="estimateType" id="estimateType" placeholder="Date"> -->
                                <span class="input-group-addon">
                                    <input tabindex="16"  type="radio" class="prd_icheck" name="discount_type" id="totalItemWise"  value="2">
                                </span>
                                <span class="input-group-addon text-left">Total Package</span>
                            </div>
                        </div>
                    <hr>

                    </div>
                    <!-- <div class="row">
                                         
                        <span class='pull-left' id="lastJob"></span>
                    </div> -->
                    <div class="row row-eq-height">
                        <div class="col-sm-2">
                            <div  class="form-group">
                                <select name="workType" required="required"  id="workType" class="form-control">
                                    <option value="">Select a work type</option>
                                     <?php foreach ($worktype as $trns) { ?>
                                    <option value="<?php echo $trns->jobtype_id; ?>" jobOrder="<?php echo $trns->jobtype_order; ?>"  isVat="<?php echo $trns->isVat; ?>"  isNbt="<?php echo $trns->isNbt; ?>"   nbtRatio="<?php echo $trns->nbtRatio; ?>"><?php echo $trns->jobtype_code; ?> - <?php echo $trns->jobtype_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div  class="form-group" id="jobDescDiv">
                                <input type="text" class="form-control" required="required"  name="jobdesc" id="jobdesc" value="" placeholder=" Job Description">
                            </div>
                            <div  class="form-group" id="spartDiv">
                                <input type="text" class="form-control" required="required"  name="product" id="product" value="" placeholder="Spart Part">
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div  class="form-group">
                                <input type="number" class="form-control" required="required"  name="qty" id="qty" min="0" value="" placeholder="Qty">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div  class="form-group">
                                <input type="number" class="form-control" required="required"  name="sellPrice" min="0" id="sellPrice" value="" placeholder="Unit Price">
                                <input type="hidden" name="prdName" id="prdName">
                                <input type="hidden" name="timestamp" id="timestamp" value="">
                                <input type="hidden" name="estPrice" id="estPrice" value="0">
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div  class="form-group">
                                <input type="button" class="btn btn-success" required="required"  name="addJob" id="addJob" value="Add">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group input-group">
                                <span class="input-group-addon">
                                    <input tabindex="16"  type="radio" class="prd_icheck" name="discount" checked value="1">
                                </span>
                                <input type="text" min="0"  tabindex="16" onfocus="this.select();" onmouseup="return false;" step="5" pattern="[0-9]*" class="form-control" required="required"  name="disPercent" id="disPercent" placeholder="Enter Discount Percentage" value="0">
                                <span class="input-group-addon">%</span>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group input-group">
                                <span class="input-group-addon">
                                    <input type="radio" class="prd_icheck" name="discount" value="2">
                                </span>
                                <input type="text" min="0"  tabindex="16"  step="5" pattern="[0-9]*" class="form-control" required="required"  name="disAmount" onfocus="this.select();" onmouseup="return false;" id="disAmount" placeholder="Enter discount amount" value="0">
                                <input type="hidden" min="0" step="50" pattern="[0-9]*" class="form-control" required="required"  name="totalWithOutDiscount" id="totalWithOutDiscount" placeholder="Enter sold amount" value="0">
                                <span class="input-group-addon"><i class="fa fa-money"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <div  class="form-group">
                                
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div  class="form-group">
                                <input class="prd_icheck" type="checkbox" name="isProVat"  id="isProVat" value="1"> VAT
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div  class="form-group">
                                <input class="prd_icheck" type="checkbox" name="isProNbt" id="isProNbt" value='1'> NBT
                                <input class="" type="hidden" name="proNbtRatio" id="proNbtRatio" value='1'>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div  class="form-group">
                               <input type="number" class="form-control" required="required"  name="costPrice" min="0" id="costPrice" value="" placeholder="Cost Price">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div  class="form-group">
                               
                            </div>
                        </div>
                        
                        <div class="col-sm-1">
                            <div  class="form-group text-right">
                               
                            </div><br>
                        </div>
                       <!--  <div class="col-sm-1">
                            <div  class="form-group">
                                <input class="prd_icheck" type="checkbox" name="isTotalVat"  id="isTotalVat" value='1'> VAT
                            </div>
                        </div> -->
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-2">
                            <div  class="form-group">
                               
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-sm-1">
                            <div  class="form-group">
                                
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div  class="form-group">
                                 <span>Job Description</span>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div  class="form-group">
                                
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div  class="form-group">
                               <span class="label label-success pull-right" id="modelNotifi"></span>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div  class="form-group text-right">
                               
                            </div><br>
                        </div>
                       <!--  <div class="col-sm-1">
                            <div  class="form-group">
                                <input class="prd_icheck" type="checkbox" name="isTotalVat"  id="isTotalVat" value='1'> VAT
                            </div>
                        </div> -->
                        <div class="col-sm-2">
                            <div  class="form-group text-right">
                                <!-- <b>Total Invoice VAT/NBT</b> -->
                            </div><br>
                        </div>
                        <div class="col-sm-1">
                            <div  class="form-group">
                                <!-- <input class="prd_icheck" type="checkbox" name="isTotalVat"  id="isTotalVat" value='1'> VAT -->
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div  class="form-group">
                                <!-- <input class="prd_icheck" type="checkbox" name="isTotalNbt" id="isTotalNbt" value='1'> NBT
                                <input class="" type="hidden" name="totalNbtRatio" id="totalNbtRatio" value='1'> -->
                            </div>
                        </div>
                        
                    </div>
                             <div class="row"> 
                            <div class="col-sm-9">
                             <div class="fixheader">
                                <table id="tbl_job" class="table table-bordered table-hover table-striped">
                                    <!-- <caption>Job Description</caption> -->
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Job</th>
                                            <th>Description</th>
                                            <th>Qty</th>
                                            <th>Price</th>
                                            <th>Discount(%)</th>
                                            <th>Quoted Amount</th>
                                            <th>Invoice Amount</th>
                                            <th></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table></div>
                                <!-- <button class="btn btn-primary" type="button" id="btnSave">Save</button>&nbsp;
                                <button  class="btn btn-primary"  type="button" id="btnPrint">Print</button> -->
                                <input type="hidden" value="1" name="action" id="action">
                                <input type="hidden" value="1" name="actionTemp" id="actionTemp">

                            </div>
                            <div class="col-sm-3">
                             <hr>
                                <table>
                                    <tr><td>Total Amount </td><td>&nbsp;:&nbsp;</td><td id="totalAmount" class="text-right" style="color:#000000;font-size:18px;"></td></tr>
                                    <tr><td>- Discount </td><td>&nbsp;:&nbsp;</td><td id="totalDiscount" style="color:#149034;font-size:18px;" class="text-right"></td></tr>
                                    <tr><td>+ VAT Amount</td><td>&nbsp;:&nbsp;</td><td id="totalVat" style="color:#c54f41;font-size:18px;" class="text-right"></td></tr>
                                    <tr><td>+ NBT Amount</td><td>&nbsp;:&nbsp;</td><td id="totalNbt"  class="text-right" style="color:#c54f41;font-size:18px;"></td></tr>
                                    <tr><td>Net Amount</td><td>&nbsp;:&nbsp;</td><td id="totalNet" class="text-right" style="font-weight: bold;font-size:25px;color:#3c8dbc;"></td></tr>
                                </table>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-1">&nbsp;</div>
                                    <div class="col-sm-10">
                                        <!-- <button class="btn btn-primary btn-lg btn-block" type="button" id="btnSaveTemp">Temparary Save</button>&nbsp; -->
                                    </div>
                                    <div class="col-sm-1">&nbsp;</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-1">&nbsp;</div>
                                    <div class="col-sm-10">
                                        <button class="btn btn-success btn-lg btn-block" type="button" id="btnSave">Save Pacakge</button>&nbsp;
                                    </div>
                                    <div class="col-sm-1">&nbsp;</div>
                                </div>
                                <!-- <div class="row">
                                    <div class="col-sm-1">&nbsp;</div>
                                    <div class="col-sm-10">
                                        <button  class="btn btn-primary btn-lg btn-block"  type="button" id="btnPrint">Print</button>&nbsp;
                                    </div>
                                    <div class="col-sm-1">&nbsp;</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-1">&nbsp;</div>
                                    <div class="col-sm-10">
                                        <a href="<?php echo ('../../../admin/payment/job_payment/'); ?>" id="invLink" class="btn btn-primary btn-lg btn-block" >Payment</a>
                
                                    </div>
                                    <div class="col-sm-1">&nbsp;</div>
                                </div> -->
                                
                            </div>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                          
                        </div>
                        <div class="row">
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>      
        </div>
    </section>
    <!--add product modal-->
    <div id="productmodal" class="modal fade bs-add-category-modal-lg"  role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg" style="width: 95%;">
            <div class="modal-content">
                <!-- load data -->
            </div>
        </div>
    </div>
    <!--invoice print-->
    <div class="modal fade bs-payment-modal-lg" id="modelInvoice" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body" >
                 <?php //invoice print 
                        $this->load->view('admin/sales/job-invoice-print.php',true); ?>  
                </div>
            </div>
        </div>
    </div>
    
</div>
<style>
.fixheader {
    height: 400px !important;
    overflow: scroll;
}

    .col-sm-2,.col-sm-1{
        padding-right: 1px;
        padding-left: 5px;
    }
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

    #tbl_est_data table tbody td{
        padding: 3px;
    }
</style>

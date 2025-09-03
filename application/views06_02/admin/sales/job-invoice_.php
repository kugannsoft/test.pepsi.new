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
                    <div class="row row-eq-height">
                        <div class="col-sm-2">
                            <label for="companyCode" class="control-label">&nbsp;&nbsp;Job Number <span class="required"></span></label>
                        </div>
                        <div class="col-sm-2">
                            <label for="companyCode" class="control-label">Estimate No. <span class="required"></span></label>
                        </div>
                        <div class="col-sm-1">
                            <label for="companyCode" class="control-label">Suppl. No. <span class="required"></span></label>
                        </div>
                        <div class="col-sm-1">
                            <label for="companyCode" class="control-label">Temp. Inv. No. <span class="required"></span></label>
                        </div>
                        <div class="col-sm-1">
                            <label for="companyCode" class="control-label">Invoice No. <span class="required"></span></label>
                        </div>
                        <div class="col-sm-3">
                            <label for="cusName" class="control-label"><i class="fa fa-user"></i>&nbsp;<span id="cusName"></span>&nbsp;&nbsp;&nbsp;<i class="fa fa-phone"></i>&nbsp;<span id="cusPhone"></span></label>
                        </div>
                        <div class="col-sm-2">
                            <label for="companyCode" class="control-label">Outstanding : <span id="cusOutstand"></span></label>
                        </div>
                        
                    </div>
                    <div class="row row-eq-height">
                        <div class="col-sm-2">
                            <div  class="form-group">
                            <input type="text" class="form-control"  name="jobNo" id="jobNo" value="<?php if(isset($JobNo)){echo $JobNo;}?>" placeholder="Job Number">                             
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div  class="form-group">
                            <input  class="form-control" type="text" placeholder="Estimate No" name="estimateNo" id="estimateNo" value="<?php if(isset($EstimateNo)){echo $EstimateNo;}?>">
                                <input type="hidden" name="location" id="location" value="<?php echo $_SESSION['location'] ?>"><input type="hidden" name="estimateNo" id="estimateNo" value="">
                                <input type="hidden" name="vatRate" id="vatRate" value="<?php echo $company['VAT']; ?>">
                                <input type="hidden" name="nbtRate" id="nbtRate" value="<?php echo $company['NBT']; ?>">
                                <input type="hidden" name="nbtRatioRate" id="nbtRatioRate" value="<?php echo $company['NBT_Ratio']; ?>">
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div  class="form-group">
                                 <input type="text" class="form-control" required="required"  name="supplemetNo" id="supplemetNo" placeholder="Supplementary No" value="<?php if(isset($supNo)){echo $supNo;}else{echo 0;}?>">
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div  class="form-group">
                                <input type="text" class="form-control" required="required"  name="tempNo" id="tempNo" placeholder="Temp. No"  value="<?php if(isset($TempNo)){echo $TempNo;}?>" >
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div  class="form-group">
                                <input type="text" class="form-control" required="required"  name="invoiceNo" id="invoiceNo" placeholder="Invoice No (Autogenerate)"  value="<?php if(isset($JobInvoiceNo)){echo $JobInvoiceNo;}?>" >
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div  class="form-group">
                                <input type="text" class="form-control" disabled required="required"  name="cusCode" id="cusCode" value="" placeholder="Customer">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div  class="form-group">
                                <input type="text" class="form-control" disabled required="required"  name="regNo" id="regNo" placeholder="Register Number">
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div  class="form-group">
                                 <button id="addProduct" class="btn btn-flat btn-primary pull-right">Add Product</button>
                            </div>
                        </div>
                        <!-- <div class="col-sm-2">
                            <div  class="form-group">
                                <button  class="btn btn-success pull-right" data-toggle="modal" data-target="#customermodal" id="btnViewJob" type="button">View Job Card Details</button>
                            </div>
                        </div> -->
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <div  class="form-group">
                            <input type="text" class="form-control" required="required"  name="appoDate" id="appoDate" placeholder="Date">
                            <input type="hidden" class="form-control" required="required"  name="jobType" id="jobType" placeholder="Date">
                                <!-- <select name="jobType" required="required"  id="jobType" class="form-control">
                                            <option value="">Select a job type</option>
                                             <?php foreach ($jobtype as $trns) { ?>
                                            <option value="<?php echo $trns->EstimateJobNo; ?>"  value="<?php echo $trns->EstimateJobNo; ?>"  ><?php echo $trns->EstimateJobType; ?></option>
                                            <?php } ?>
                                        </select> -->
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div  class="form-group">
                                <select name="invoiceType" required="required"  id="invoiceType" class="form-control">
                                    <!-- <option value="">Select a Invoice type</option> -->
                                    <option value="1">General</option>
                                    <option value="2">Tax</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div  class="form-group">
                                <select name="partInvType" required="required"  id="partInvType" class="form-control">
                                    <!-- <option value="">Select a Invoice type</option> -->
                                    <option value="1">Labour and Part Invoice</option>
                                    <option value="2">Part Separate Invoice</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div  class="form-group">
                                <select name="vehicleCompany" id="vehicleCompany" class="form-control">
                                            <option value="">Select a company</option>
                                            <?php foreach ($vehicle_company as $trns) { ?>
                                            <option value="<?php echo $trns->VComId; ?>" ><?php echo $trns->VComName; ?></option>
                                            <?php } ?>
                                        </select>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div  class="form-group  pull-right">
                            Discout Type
                          <!--   <input type="hidden" class="form-control" required="required"  name="vehicleCompany" id="vehicleCompany" value="0"> -->
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
                                <span class="input-group-addon text-left">Total Invoice</span>
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
                                <input type="text" class="form-control" required="required" onfocus="this.select();" name="jobdesc" id="jobdesc" value="" placeholder=" Job Description">
                            </div>
                            <div  class="form-group" id="spartDiv">
                                <input type="text" class="form-control" required="required" onfocus="this.select();" name="product" id="product" value="" placeholder="Spart Part">
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div  class="form-group">
                                <input type="number" class="form-control" required="required" onfocus="this.select();" name="qty" id="qty" min="0" value="" placeholder="Qty">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div  class="form-group">
                                <input type="number" class="form-control" required="required" onfocus="this.select();" name="sellPrice" min="0" id="sellPrice" value="" placeholder="Unit Price">
                                <input type="hidden" name="prdName" id="prdName">
                                <input type="hidden" name="timestamp" id="timestamp" value="">
                                <input type="hidden" name="estlineno" id="estlineno" value="0">
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
                        <div class="col-sm-5">
                            <div class="form-group">
                                        <div class="col-sm-4">

                                            <input type="number" class="form-control"  name="mileageout" id="mileageout" placeholder="Odo Meter Out" value="">
                                        </div>
                                        <div class="col-sm-2">
                                            <select  class="form-control" name="mileageoutUnit"  id="mileageoutUnit" >
                                                <option value="1">Km</option>
                                                <option value="2">Miles</option>
                                            </select>
                                        </div>
                                    </div>


                           <!--  <div  class="form-group">
                                <input type="number" class="form-control"  name="mileageout" id="mileageout"  value="" placeholder="Mileage Out">
                            </div> -->
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
                               <input type="number" class="form-control" required="required" onfocus="this.select();" name="costPrice" min="0" id="costPrice" value="0" placeholder="Cost Price">
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
                                <b>Total Invoice VAT/NBT</b>
                            </div><br>
                        </div>
                        <div class="col-sm-1">
                            <div  class="form-group">
                                <input class="prd_icheck" type="checkbox" name="isTotalVat"  id="isTotalVat" value='1'> VAT
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div  class="form-group">
                                <input class="prd_icheck" type="checkbox" name="isTotalNbt" id="isTotalNbt" value='1'> NBT
                                <input class="" type="hidden" name="totalNbtRatio" id="totalNbtRatio" value='1'>
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
                                            <th> ####### </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table></div>
                                <!-- <button class="btn btn-primary" type="button" id="btnSave">Save</button>&nbsp;
                                <button  class="btn btn-primary"  type="button" id="btnPrint">Print</button> -->
                                <input type="hidden" value="1" name="action" id="action">
                                <input type="hidden" value="1" name="actionTemp" id="actionTemp">
<!-- <a href="<?php echo ('../../../admin/Salesinvoice?type=job&id='); ?>" id="invLink" class="btn btn-flat btn-primary pull-right">Add Invoice</a> -->
                                 <div  class="form-group">
                                        <label> Remarks</label>
                                     <textarea class="form-control" name="remark" id="remark" ></textarea>
                                 </div>
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
                                        <button class="btn btn-primary btn-lg btn-block" type="button" id="btnSaveTemp">Temparary Save</button>&nbsp;
                                    </div>
                                    <div class="col-sm-1">&nbsp;</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-1">&nbsp;</div>
                                    <div class="col-sm-10">
                                        <button class="btn btn-success btn-lg btn-block" type="button" id="btnSave">Generate Invoice</button>&nbsp;
                                    </div>
                                    <div class="col-sm-1">&nbsp;</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-1">&nbsp;</div>
                                    <div class="col-sm-10">
                                    <a href="#" class="btn btn-primary btn-lg btn-block"  type="button" id="invLink">Print</a>
                                        <!-- <button  class="btn btn-primary btn-lg btn-block"  type="button" id="btnPrint">Print</button> -->
                                    </div>
                                    <div class="col-sm-1">&nbsp;</div>
                                </div>
                                
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

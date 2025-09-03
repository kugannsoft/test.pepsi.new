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
                            <label for="companyCode" class="control-label">&nbsp;&nbsp;Estimate No. <span class="required"></span></label>
                        </div>
<!--                        <div class="col-sm-1">-->
<!--                            <label for="companyCode" class="control-label">Suppl. No. <span class="required"></span></label>-->
<!--                        </div>-->
<!--                        <div class="col-sm-2">-->
<!--                            <label for="companyCode" class="control-label">Job Number <span class="required"></span></label>-->
<!--                        </div>-->
                        <div class="col-sm-1">
                            <label for="companyCode" class="control-label">Customer <span class="required"></span></label>
                        </div>
                        <div class="col-sm-5">
                            <label for="cusName" class="control-label"><i class="fa fa-user"></i>&nbsp;<span id="cusName"></span>&nbsp;&nbsp;&nbsp;<i class="fa fa-phone"></i>&nbsp;<span id="cusPhone"></span></label>
                        </div>
                        <div class="col-sm-2">
                            <label for="companyCode" class="control-label">Outstanding : <span id="cusOutstand"></span></label>
                        </div>
                        
                    </div>
                    <div class="row row-eq-height">
                        <div class="col-sm-2">
                            <div  class="form-group">
                                <input  class="form-control" type="text" onfocus="this.select();" placeholder="Estimate Auto Generate" name="estimateNo" id="estimateNo" value="<?php echo $EstimateNo;?>">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div  class="form-group">
                                <input type="text" class="form-control" onfocus="this.select();" required="required"  name="cusCode" id="cusCode" value="<?php echo $cusCode;?>" placeholder="Customer" >
                                <input type="hidden" class="form-control" onfocus="this.select();" required="required"  name="supplemetNo" id="supplemetNo" placeholder="Supplementary No" value="<?php echo $supNo;?>">
                                <input type="hidden" name="location" id="location" value="<?php echo $_SESSION['location'] ?>">
                                <input type="hidden" name="estimateNo" id="estimateNo" value="">
                                <input type="hidden" name="vatRate" id="vatRate" value="<?php echo $company['VAT']; ?>">
                                <input type="hidden" name="nbtRate" id="nbtRate" value="<?php echo $company['NBT']; ?>">
                                <input type="hidden" name="nbtRatioRate" id="nbtRatioRate" value="<?php echo $company['NBT_Ratio']; ?>">
                                <input type="hidden" class="form-control" onfocus="this.select();"  name="jobNo" id="jobNo" value="<?php echo $JobNo;?>" placeholder="Job Number">
                                <input type="hidden" class="form-control"  name="regNo" id="regNo" placeholder="Register Number" value="<?php echo $regNo;?>">
                                <input type="hidden" class="form-control"  name="jobType" id="jobType" placeholder="Register Number" value="2">
                                <input type="hidden" class="form-control"  name="vehicleCompany" id="vehicleCompany" placeholder="Register Number" value="">
                                <input type="hidden" class="form-control"  name="estimateType" id="estimateType" placeholder="Register Number" value="1">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div  class="form-group">
                                <input type="text" class="form-control" onfocus="this.select();" required="required"  name="appoDate" id="appoDate" placeholder="Date">
                            </div>
                        </div>
<!--                        <div class="col-sm-2">-->
<!--                            <div  class="form-group">-->
<!--                                <button  class="btn btn-success pull-right" data-toggle="modal" data-target="#customermodal" id="btnViewJob" type="button">View Job Card Details</button>-->
<!--                            </div>-->
<!--                        </div>-->
                        <div class="col-sm-3">
                            <div  class="form-group">
                                 <button id="addProduct" class="btn btn-flat btn-primary pull-right">Add Product</button>
                            </div>
                        </div>
                    </div>
<!--                    <div class="row">-->
<!--                        <div class="col-sm-2">-->
<!--                            <div  class="form-group">-->
<!--                                <select name="jobType"  id="jobType" class="form-control" required="required" >-->
<!--                                            <option value="" >Select a job type</option>-->
<!--                                             --><?php //foreach ($jobtype as $trns) { ?>
<!--                                            <option value="--><?php //echo $trns->EstimateJobNo; ?><!--"> --><?php //echo $trns->EstimateJobType; ?><!--</option>-->
<!--                                            --><?php //} ?>
<!--                                        </select>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="col-sm-2">-->
<!--                            <div  class="form-group">-->
<!--                                <select name="vehicleCompany" id="vehicleCompany" class="form-control">-->
<!--                                            <option value="">Select a company</option>-->
<!--                                            --><?php //foreach ($vehicle_company as $trns) { ?>
<!--                                            <option value="--><?php //echo $trns->VComId; ?><!--" >--><?php //echo $trns->VComName; ?><!--</option>-->
<!--                                            --><?php //} ?>
<!--                                        </select>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="col-sm-2">-->
<!--                            <div  class="form-group">-->
<!--                                <select name="estimateType" id="estimateType" class="form-control">-->
<!--                                    <option value="">Select an estimate type</option>-->
<!--                                    --><?php //foreach ($estimate_type as $trns) { ?>
<!--                                    <option value="--><?php //echo $trns->EstimateTypeNo; ?><!--" >--><?php //echo $trns->EstimateType; ?><!--</option>-->
<!--                                    --><?php //} ?>
<!--                                </select>-->
<!--                            </div>-->
<!--                        </div>-->





<!--                        <div class="col-sm-4">-->
<!--                            <div  class="form-group">-->
<!--                                -->
<!--                            </div><br>-->
<!--                        </div>-->
<!--                    </div>-->
                    <div class="row row-eq-height">
                        <div class="col-sm-2">
                            <div  class="form-group">
                                <select name="workType" required="required"  id="workType" class="form-control">
                                    <option value="">Select a work type</option>
                                     <?php foreach ($worktype as $trns) { ?>
                                    <option value="<?php echo $trns->jobtype_id; ?>" jobOrder="<?php echo $trns->jobtype_order; ?>"  isVat="<?php echo $trns->isVat; ?>"  isNbt="<?php echo $trns->isNbt; ?>"   nbtRatio="<?php echo $trns->nbtRatio; ?>"><?php echo $trns->jobhead_name; ?> - <?php echo $trns->jobtype_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div  class="form-group" id="jobDescDiv">
                                <input type="text" class="form-control" required="required"  onfocus="this.select();" name="jobdesc" id="jobdesc" value="" placeholder=" Job Description">
                            </div>
                            <div  class="form-group" id="spartDiv">
                                <input type="text" class="form-control" required="required"  onfocus="this.select();" name="product" id="product" value="" placeholder="Spart Part">
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div  class="form-group">
                                <input type="number" class="form-control" required="required"  onfocus="this.select();" name="qty" id="qty" min="0" value="" placeholder="Qty">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div  class="form-group">
                                <input type="number" class="form-control" required="required"  onfocus="this.select();" name="sellPrice" min="0" id="sellPrice" value="" placeholder="Unit Price">
                                <input type="hidden" name="prdName" id="prdName">
                                <input type="hidden" name="timestamp" id="timestamp" value="">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div  class="form-group">
                                <select name="partType" id="partType" class="form-control" disabled>
                                    <option value="">Select a part type</option>
                                    <?php foreach ($parttype as $trns) { ?>
                                    <option value="<?php echo $trns->parttype_code; ?>" ><?php echo $trns->parttype_code; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div  class="form-group">
                                <input type="button" class="btn btn-success" required="required"  name="addJob" id="addJob" value="Add">
                            </div>
                            <div  class="form-group input-group"  id="dvInsurance" class="display:none;">
                                 <span class="input-group-addon">
                                        <input type="checkbox" name="isInsurance" id="isInsurance" class="prd_icheck" value="1" >
                                    </span>
                                    <select name="insurancer" id="insurancer" class="form-control">
                                    <option value="">Select a Remark</option>
                                    <option value="MP" >MP</option>
                                    <option value="AP" >AP</option>
                                    <option value="MR" >MR</option>
                                    
                                </select>
                                    <!-- <input type="text" class="form-control" required="required"  name="insurance" id="insurance" value="" placeholder="Insurance Remarks"> -->
                            </div>
                        </div>
                        
                        <div class="col-sm-1">
                            
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
                        <div class="col-sm-2">
                            <div  class="form-group">
                               
                            </div>
                        </div>
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
                        <div class="col-sm-2">
                               <span id="lblCustomer"></span>
                        </div>
                        
                    </div>
                             <div class="row"> 
                            <div class="col-sm-9">
                            <span>Job Description</span>
                            <span class="label label-success pull-right" id="modelNotifi"></span>
                            <div class="fixheader">
                                <table id="tbl_job" class="table table-fixed table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Job</th>
                                            <th>Description</th>
                                            <th>Qty</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                            <th>Insurance</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                    </tbody>
                                </table></div>
                                
                                <!-- <button class="btn btn-primary" type="button" id="btnSave">Save</button>&nbsp;
                                <button  class="btn btn-primary"  type="button" id="btnPrint">Print</button> -->
                                <input type="hidden" value="1" name="action" id="action">
<a href="#<?php //echo ('../../../admin/Salesinvoice/job_invoice?type=job&id='); ?>" id="invLink" class="btn btn-flat btn-primary pull-right">Add Invoice</a>
                            </div>


                            

                                 




                            <div class="col-sm-3">
                                <hr>
                                <table>
                                    <tr><td>Estimate Amount </td><td>&nbsp;:&nbsp;</td><td id="totalAmount" class="text-right"></td></tr>
                                    <tr><td>VAT Amount</td><td>&nbsp;:&nbsp;</td><td id="totalVat"  class="text-right"></td></tr>
                                    <tr><td>NBT Amount</td><td>&nbsp;:&nbsp;</td><td id="totalNbt"  class="text-right"></td></tr>
                                    <tr><td>NET Amount</td><td>&nbsp;:&nbsp;</td><td id="totalNet" class="text-right" style="font-weight: bold;font-size:20px;"></td></tr>
                                </table>
                                 <hr>
                                 <div class="row">
                                    <div class="col-sm-12">
                                        <div  class="form-group">
                                           <textarea style="min-height:100px;" name="remark" required="required"  id="remark" class="form-control pull-left" placeholder="Remarks"></textarea>
                                        </div>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-sm-1">&nbsp;</div>
                                    <div class="col-sm-10">
                                        <button class="btn btn-primary btn-lg btn-block" type="button" id="btnSave">Save</button>
                                    </div>
                                    <div class="col-sm-1">&nbsp;</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-1">&nbsp;</div>
                                    <div class="col-sm-10">
                                        <!-- <button  class="btn btn-primary btn-lg btn-block"  type="button" id="btnPrint">Print</button> -->
                                        <a href="#" class="btn btn-primary btn-lg btn-block"  type="button" id="printLink">Print</a>
                                    </div>
                                    <div class="col-sm-1">&nbsp;</div>
                                </div>

                                 <!-- Attachment -->
                              <?php echo form_open_multipart('admin/job/est_upload');?> 
                                    <div class="form-group" >
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">Attachment</label>
                                        </div>
                                        <div class="custom-file">
                                            <input type="hidden" name="cusCode2" id="cusCode2" value="<?php echo $cusCode;?>">

                                            <input type="hidden" name="EstNoPdf" id="EstNoPdf">

                                            <input type="file" class="custom-file-input" name="userfile" size="20" />
                                        </div>
                                         <div class="input-group" >
                                        <input type="submit" class="btn btn-primary" value="upload" />
                                    </div>
                                    </div>
                                    </div>
                         <!-- Attachment -->
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
    <div id="productmodal" class="modal fade bs-add-product-modal-lg"  role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg" style="width: 95%;">
            <div class="modal-content">
                <!-- load data -->
            </div>
        </div>
    </div>
    <div id="customermodal" class="modal fade bs-add-category-modal-sm" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <!-- load data -->
                 <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h3>Job Card Details</h3>
                </div>
                <div class="modal-body">
                <caption><span id="jNo"></span></caption>
                <table id="jobCardData" class="table-striped table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Job Descriptions</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
    <!--invoice print-->
    <div class="modal fade bs-payment-modal-lg" id="modelInvoice" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-body" id="estimate_head" >
             <?php //invoice print 
                    $this->load->view('admin/job/estimate_print.php',true); ?>  
            </div>
            <div class="modal-body"  id="general_head">
             <?php //invoice print 
                    $this->load->view('admin/job/general_estimate_print.php',true); ?>  
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
.table-fixed{
  width: 100%;
  tbody{
    height:200px;
    overflow-y:auto;
    width: 100%;
    }
  thead,tbody,tr,td,th{
    display:block;
  }
  tbody{
    td{
      float:left;
    }
  }
  thead {
    tr{
      th{
        float:left;
      }
    }
  }
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
<script type="text/javascript">
        
        
 
</script>
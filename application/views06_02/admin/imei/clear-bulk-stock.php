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
                            <div class="col-sm-12">
                                <div class="form-group">
                                        <label class="col-sm-2 control-label"> Location <span class="required">*</span></label>  
                                        <div class="col-sm-10">
                                            <select tabindex="3" class="form-control" id="sel_location">
                                                <option value="">Select a location</option>
                                                <?php foreach ($location as $loc) { ?>
                                            <option value="<?php echo $loc->location_id; ?>"><?php echo $loc->location; ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                </div><br><br>
                                <div class="form-group">
                                        <label class="col-sm-2 control-label">Department <span class="required">*</span></label>  
                                        <div class="col-sm-10">
                                            
<!--                                            <select tabindex="3" class="form-control" id="dep">
                                                <option value="">Select a department</option>-->
                                                <?php foreach ($department as $dep) { ?>
                                            <span style="padding-top:2px;"><input type="checkbox" class="dep_icheck" name="dep" <?php if($dep->DepCode==1 || $dep->DepCode==31){?> disabled <?php }?> value="<?php echo $dep->DepCode; ?>"> <?php echo $dep->Description; ?>,   </span><br> &nbsp; &nbsp;
 &nbsp;                                            <!--<option value="<?php echo $dep->DepCode; ?>"><?php echo $dep->Description; ?></option>-->
                                            <?php } ?>
<!--                                            </select>-->
                                        </div>
                                        <input type="hidden" name="dep_ar" id="dep_ar"> 
                                </div><br><br>
                                
<!--                                <div class="form-group">
                                    <label for="customer" class="col-sm-5 control-label">Enter Product Code <span class="required">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" required="required"  name="itemCode" id="itemCode" placeholder="Enter Product Code">
                                    </div>
                                </div>-->
                                
                                <div class="form-group">
                                    <!--<label for="invDate" class="col-sm-5 control-label">Cancel Date <span class="required">*</span></label>-->
                                    <div class="col-sm-6">
                                        <!--<input type="text" class="form-control" required="required"  name="invDate" id="invDate" value="<?php echo date('Y-m-d')?>" placeholder="">-->
                                        <input type="hidden" class="form-control" required="required"  name="invUser" id="invUser" value="<?php echo $_SESSION['user_id'] ?>">
                                        <input type="hidden" class="form-control" required="required"  name="location" id="location" value="<?php echo $_SESSION['location'] ?>">
                                    </div>
                                </div>
<!--                                <div class="form-group">
                                    <label for="invDate" class="col-sm-5 control-label">Remark <span class="required">*</span></label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control" name="remark" id="remark"></textarea>
                                    </div>
                                </div>-->
<!--<span id="errGrid"></span>-->
                            </div>
                            <div class="col-sm-6">
                                <table class="table">
                                    <tr><td></td><td></td><td class="text-right"></td></tr>
                                    <tr><td> Stock</td><td>:</td><td class="text-right" id="totalAmount"></td></tr>
<!--                                    <tr><td>Total Discount</td><td>:</td><td class="text-right"  id="totalDis"></td></tr>
                                <tr><td>Total Net Amount</td><td>:</td><td class="text-right"  id="totalNet"></td></tr>-->
                                    
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><span id="errGrid" class="pull-right"></span></b>
                                <button class="btn btn-success" id='pay'>Clear Stock</button>
                            </div>
                            <div class="col-lg-8">

                            </div>
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
                                        <!--<th>Serial No</th>-->
                                        <th>Total Quantity</th>
                                        <!--<th >GRN No</th>/-->
                                       
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>

                            </table>
                        </div>
                        <span id="lastTranaction"><i>Last stock cleared product</i> : </span>
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


</div>
<style>
    .shop-items:hover{
        background-color: #00ca6d;
        color: #fff;
    }
</style>
<script type="text/javascript">
$('.dep_icheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '50%'
    });

</script>
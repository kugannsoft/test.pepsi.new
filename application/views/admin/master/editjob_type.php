<form id="addproductform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-power-off myclose"></i></button>
        <h4>Edit Job Type</h4>
    </div>
    <div class="modal-body">
        <?php // print_r($alldepartment); ?>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="productCode" class="control-label">Code <span class="required">*</span></label>
                    <input type="text" class="form-control" required="required" value="<?php echo $trans->jobtype_code?>"  name="cash_type" id="cash_type">
                    
                </div>
                <div class="form-group">
                    <label for="productCode" class="control-label">Category <span class="required">*</span></label>

                    <select name="jobCategory" id="jobCategory" class="form-control">
                        <option value="0">--Select--</option>
                        <?php foreach ($transHead as $trns) { ?>
                        <option <?php if($trans->jobhead==$trns->jobhead_id){echo 'selected';} ?> value="<?php echo $trns->jobhead_id; ?>"><?php echo $trns->jobhead_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="productCode" class="control-label">Type Name <span class="required">*</span></label>
                    <input type="text" class="form-control" required="required" value="<?php echo $trans->jobtype_name?>"  name="name" id="name">
                </div>
                <div class="form-group">
                    <label for="product" class="control-label">Type Order <span class="required"></span></label>
                    <input type="text" class="form-control" required="required" value="<?php echo $trans->jobtype_order?>" name="remark" id="remark">
                </div>
                <div class="form-group">
                    <label for="isfreeissue" class="control-label">
                        Is VAT
                        <input class="prd_icheck" type="checkbox" name="isVat" id="isVat" value="1" <?php echo ($trans->isVat == 1) ? 'checked' : '' ?>>  
                        &nbsp;&nbsp;&nbsp;
                    </label>
                    <label for="isfreeissue" class="control-label"> 
                        Is NBT
                        <input class="prd_icheck" type="checkbox" name="isNbt" id="isNbt" value="1" <?php echo ($trans->isNbt == 1) ? 'checked' : '' ?>> 
                        &nbsp;&nbsp;&nbsp;
                    </label>
                    <label for="isfreeissue" class="control-label">
                        &nbsp;&nbsp;&nbsp;NBT Ratio
                        <input class="control-label input-sm" type="text" name="nbtRatio" id="nbtRatio" value="<?php echo ($trans->nbtRatio) ?>"> 
                    </label>
                </div>
                <div class="form-group">
                    <input type="hidden" value="<?php echo $trans->jobtype_id?>" name="id" id="id">
                </div>

            </div>

        </div>
    </div>
    <div class="modal-footer">
        <span id="errProduct1" class="pull-left"></span>
        <button class="btn btn-success btn-flat" id="savepro" type="submit">Save</button>
    </div>
</form>
<script>
    $('.prd_icheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '50%'
    });

    var isNbt = $("input[name='isNbt']:checked").val();
        if(isNbt){
            $("#nbtRatio").prop('disabled',false);
        }else{
            $("#nbtRatio").prop('disabled',true);
        }
    $("input[name='isNbt']").on('ifChanged', function(event){
        isNbt = $("input[name='isNbt']:checked").val();
        if(isNbt){
            $("#nbtRatio").prop('disabled',false);
        }else{
            $("#nbtRatio").prop('disabled',true);
        }
    });

    $('#addproductform').submit(function(e) {
        $('#savepro').attr('disabled', true);
        e.preventDefault();
        $.ajax({
            url: "<?php echo base_url('admin/master/editJobType/') ?>",
            type: "POST",
            data: $(this).serializeArray(),
            success: function(data) {
                var newdata = JSON.parse(data);
                var fb = newdata.fb;
                var lastproduct_code = newdata.ProductCode;

                if (fb) {
                    $('#productmodal').modal('hide');
                    $("#lastProduct").html('');
                    $("#lastProduct").html(lastproduct_code);
                    $('#savepro').attr('disabled', false);
                } else {
                    $("#lastProduct").html('');
                    $('#savepro').attr('disabled', false);
                }
            }
        });
    });
    
</script>
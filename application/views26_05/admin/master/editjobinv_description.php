<form id="addproductform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-power-off myclose"></i></button>
        <h4>Edit Work Type Description</h4>
    </div>
    <div class="modal-body">
        <?php // print_r($alldepartment); ?>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="productCode" class="control-label">Job Type <span class="required">*</span></label>
                    <select name="cash_type" id="cash_type" class="form-control">
                    <?php foreach ($jobtype as $jtype) { ?>
                        <option value="<?php echo $jtype->jobtype_id; ?>" <?php if($jtype->jobtype_id==2){echo 'disabled';} ?> <?php if($jtype->jobtype_id==$trans->jobtype){echo 'selected';} ?>   isVat="<?php echo $jtype->isVat; ?>"  isNbt="<?php echo $jtype->isNbt; ?>" nbtRatio="<?php echo $jtype->nbtRatio; ?>"><?php echo $jtype->jobtype_code."-".$jtype->jobtype_name?></option>
                         <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="productCode" class="control-label">Transaction Name <span class="required">*</span></label>
                    <input type="text" class="form-control" required="required" value="<?php echo $trans->JobDescription?>"  name="name" id="name">
                </div>
                <div class="form-group">
                    <label for="product" class="control-label">Job Cost <span class="required"></span></label>
                    <input type="text" class="form-control" required="required" value="<?php echo $trans->JobCost?>" name="remark" id="remark">
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
                        <input class="control-label input-sm" type="text" name="nbtRatio" id="nbtRatio" value="<?php echo ($trans->nbtRatio);?>"> 
                    </label>
                </div>
                <div class="form-group">
                    
                    <input type="hidden" value="<?php echo $trans->JobDescNo?>" name="id" id="id">
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

    var isVat=0;
    var isNbt=0;
    var nbtRatio=0;
    
    $("#cash_type").change(function(){
        isVat=$("#cash_type option:selected").attr('isVat');
        isNbt=$("#cash_type option:selected").attr('isNbt');
        nbtRatio=$("#cash_type option:selected").attr('nbtRatio');
        setVat(isVat,isNbt,nbtRatio);
    });
    
    $('#addproductform').submit(function(e) {
        $('#savepro').attr('disabled', true);
        e.preventDefault();
        $.ajax({
            url: "<?php echo base_url('admin/master/editJobInvDescription/') ?>",
            type: "POST",
            data: $(this).serializeArray(),
            success: function(data) {
                var newdata = JSON.parse(data);
                var fb = newdata.fb;
                var lastproduct_code = newdata.JobDescNo;

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
    
    $("input[name='isNbt']").on('ifChanged', function(event){
       var isNbt = $("input[name='isNbt']:checked").val();

        if(isNbt){
            $("#nbtRatio").prop('disabled',false);
        }else{
            $("#nbtRatio").prop('disabled',true);
        }
    });

    function setVat(vat,nbt,nbtratio){
        if(vat==1){
            $("input[name='isVat']").iCheck('check');
        }else{
            $("input[name='isVat']").iCheck('uncheck');
        }

        if(nbt==1){
            $("input[name='isNbt']").iCheck('check');
        }else{
            $("input[name='isNbt']").iCheck('uncheck');
            $("#nbtRatio").prop('disabled',true);
        }
        $("#nbtRatio").val(nbtratio);
    }

</script>
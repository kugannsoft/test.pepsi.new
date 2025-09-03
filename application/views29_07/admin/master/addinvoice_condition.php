<form id="addproductform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-power-off myclose"></i></button>
        <h4>Add Invoice Condition</h4>
    </div>
    <div class="modal-body">
        <?php // print_r($alldepartment); ?>
        <div class="row">
            <div class="col-md-8">

                <div class="form-group">
                    <label for="InvType" class="control-label">Invoice Type <span class="required">*</span></label>

                    <select name="InvType" id="InvType" class="form-control">
                        <option value="0">--Select--</option>
                        <?php foreach ($inv_type as $trns) { ?>
                        <option value="<?php echo $trns->invtype_id; ?>"><?php echo $trns->invtype; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="InvCondition" class="control-label">Invoice Condition <span class="required">*</span></label>
                    <input type="text" class="form-control" required="required"   name="InvCondition" id="InvCondition">
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

     $("#nbtRatio").prop('disabled',true);
    
    $("input[name='isNbt']").on('ifChanged', function(event){
       var isNbt = $("input[name='isNbt']:checked").val();

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
            url: "<?php echo base_url('admin/master/addInvoiceCondition/') ?>",
            type: "POST",
            data: $(this).serializeArray(),
            success: function(data) {
                var newdata = JSON.parse(data);
                var fb = newdata.fb;
                var lastproduct_code = newdata.ProductCode;

                if (fb) {
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
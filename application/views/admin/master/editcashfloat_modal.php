<form id="addproductform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-power-off myclose"></i></button>
        <h4>Edit Transaction Type</h4>
    </div>
    <div class="modal-body">
        <?php // print_r($alldepartment); ?>
        <div class="row">
            <div class="col-md-8">

                <div class="form-group">
                    <label for="productCode" class="control-label">Transaction Name <span class="required">*</span></label>
                    <input type="text" class="form-control" required="required" value="<?php echo $trans->TransactionName?>"  name="name" id="name">
                </div>
                <div class="form-group">
                    <div class="col-sm-6">
                        Expenses &nbsp;&nbsp; <input class="prd_icheck" <?php if($trans->IsExpenses==1){?> checked<?php }?> type="radio" value="1" checked required="required"  name="cash_type" id="cash_type">
                    </div>
                    <div class="col-sm-6">
                        Earning &nbsp;&nbsp;<input  class="prd_icheck" <?php if($trans->IsExpenses==0){?> checked<?php }?> type="radio" value="0"  required="required"  name="cash_type" id="cash_type">
                    </div>
                </div>
                <div class="form-group">
                    <label for="product" class="control-label">Remark <span class="required">*</span></label>
                    <textarea class="form-control" required="required"  name="remark" id="remark"><?php echo $trans->Remark?></textarea>
                </div>
                <div class="form-group">
                    <label for="remark" class="control-label">Is Active</label>
                    <input  class="prd_icheck"  type="checkbox" value="1" <?php if($trans->IsActive==1){?> checked<?php }?> name="isAct" id="isAct">
                    <input type="hidden" value="<?php echo $trans->TransactionCode?>" name="id" id="id">
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
    
    $('#addproductform').submit(function(e) {
        $('#savepro').attr('disabled', true);
        e.preventDefault();
        $.ajax({
            url: "<?php echo base_url('admin/master/editTransType/') ?>",
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
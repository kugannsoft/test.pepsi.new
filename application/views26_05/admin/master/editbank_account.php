<form id="addproductform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-power-off myclose"></i></button>
        <h4>Edit Product Brand</h4>
    </div>
    <div class="modal-body">
        <?php // print_r($alldepartment); ?>
        <div class="row">
             <div class="col-md-8">
                
                <div class="form-group">
                    <label for="bank" class="control-label">Bank<span class="required">*</span></label>
                    <select name="bank" id="bank" class="form-control">
                        <option value="0">-Select Bank-</option>
                        <?php foreach ($bankdetails as $bank) { ?>
                            <option value="<?php echo $bank->BankCode; ?>" <?php if($bank->BankCode==$trans->acc_bank){echo 'selected';} ?>><?php echo $bank->BankName ?></option>
                        <?php } ?>


                    </select>
                    <label for="accountname" class="control-label"> Account Name<span class="required">*</span></label>
                    <input type="text" class="form-control" required="required"  name="accname" id="accname" value="<?php echo $trans->acc_name?>">
                    <label for="accountno" class="control-label"> Account No<span class="required">*</span></label>
                    <input type="text" class="form-control" required="required"  name="accno" id="accno" value="<?php echo $trans->acc_no?>">
                    <label for="activestatus" class="control-label"> 
                         Is Active
                        <input  class="activestatus"  type="checkbox" value="1" <?php if($trans->acc_active==1){?> checked<?php }?> name="bankActive" id="bankActive">
                    </label>
                    <input type="hidden" value="<?php echo $trans->acc_id?>" name="id" id="id">
                </div>
                <div class="form-group">
                    
                   
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
            url: "<?php echo base_url('admin/master/editBankAccount/') ?>",
            type: "POST",
            data: $(this).serializeArray(),
            success: function(data) {
                var newdata = JSON.parse(data);
                var fb = newdata.fb;
                var lastproduct_code = newdata.JobSecNo;

                if (fb) {

                    $('#productmodal').modal('hide');
                    $("#lastProduct").html('');
                    $("#lastProduct").html(lastproduct_code);
                    $('#savepro').attr('disabled', false);
                location.reload();
                } else {
                    $("#lastProduct").html('');
                    $('#savepro').attr('disabled', false);
                 location.reload();
             }
            }
        });
    });
    
</script>
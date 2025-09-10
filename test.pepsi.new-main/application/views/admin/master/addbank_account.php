<form id="addproductform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-power-off myclose"></i></button>
        <h4>Add Bank Account</h4>
    </div>
    <div class="modal-body">
        <?php // print_r($alldepartment); ?>
        <div class="row">
            <div class="col-md-8">
                
                <div class="form-group">
                    <label for="bank" class="control-label">Bank<span class="required">*</span></label>
                    <select name="bank" id="bank" class="form-control">
                        <option value="0">--Select--</option>
                        <?php foreach ($bankdetails as $trns) { ?>
                        <option value="<?php echo $trns->BankCode; ?>"><?php echo $trns->BankName; ?></option>
                        <?php } ?>
                    </select>
                    <label for="accountname" class="control-label"> Account Name<span class="required">*</span></label>
                    <input type="text" class="form-control" required="required"  name="accname" id="accname">
                    <label for="accountno" class="control-label"> Account No<span class="required">*</span></label>
                    <input type="text" class="form-control" required="required"  name="accno" id="accno">
                    <label for="activestatus" class="control-label"> 
                         Is Active
                        <input class="activestatus" type="checkbox" name="bankActive" id="bankActive" value="1">
                    </label>
                   
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
            url: "<?php echo base_url('admin/master/addBankAccount/') ?>",
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
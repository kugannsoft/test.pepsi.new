<form id="addproductform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-power-off myclose"></i></button>
        <h4>Add Company</h4>
    </div>
    <div class="modal-body">
        <?php // print_r($alldepartment); ?>
        <div class="row">
            <div class="col-md-8">

                <div class="form-group">
                    <label for="productCode" class="control-label">Company Type <span class="required">*</span></label>
                    <select name="cash_type" id="cash_type" class="form-control">
                    <?php foreach ($jobtype as $trns) { ?>
                        <option value="<?php echo $trns->CusTypeId; ?>" <?php if($trns->CusTypeId==1){echo 'disabled';} ?>><?php echo $trns->CusType?></option>
                         <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="productCode" class="control-label">Company Name<span class="required">*</span></label>
                    <input type="text" class="form-control" required="required"  name="name" id="name">
                </div>
                <!-- <div class="form-group">
                    <label for="product" class="control-label">Job Cost <span class="required"></span></label>
                    <input type="text" class="form-control" required="required"  name="remark" id="remark">
                </div> -->

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
            url: "<?php echo base_url('admin/master/addInsCompany/') ?>",
            type: "POST",
            data: $(this).serializeArray(),
            success: function(data) {
                var newdata = JSON.parse(data);
                var fb = newdata.fb;
                var lastproduct_code = newdata.JobDescNo;

                if (fb) {
                    $("#lastProduct").html('');
                    $("#lastProduct").html(lastproduct_code);
                    $('#savepro').attr('disabled', false);
                    $("#name").val('');
                    $("#remark").val('');
                } else {
                    $("#lastProduct").html('');
                    $('#savepro').attr('disabled', false);
                }
            }
        });
    });
    
</script>
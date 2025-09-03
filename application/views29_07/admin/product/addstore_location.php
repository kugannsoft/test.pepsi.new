<form id="addproductform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-power-off myclose"></i></button>
        <h4>Add BIN No</h4>
    </div>
    <div class="modal-body">
        <?php // print_r($alldepartment); ?>
        <div class="row">
            <div class="col-md-8">
                    <label for="productCode" class="control-label">Rack No<span class="required">*</span></label>
                    <select name="jobCardCategory" id="jobCardCategory" class="form-control">
                        <option value="0">--Select--</option>
                        <?php foreach ($jobcardcategory as $trns) { ?>
                        <option value="<?php echo $trns->rack_id; ?>"><?php echo $trns->rack_no; ?></option>
                        <?php } ?>
                    </select>
                </div>
            <div class="col-md-8">

                <div class="form-group">
                    <label for="productCode" class="control-label">BIN No <span class="required">*</span></label>
                    <input type="text" class="form-control" required="required"  name="name" id="name">
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
            url: "<?php echo base_url('admin/master/addBinNo/') ?>",
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
                } else {
                    $("#lastProduct").html('');
                    $('#savepro').attr('disabled', false);
                }
            }
        });
    });
    
</script>
<form id="addproductform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-power-off myclose"></i></button>
        <h4>Edit Job Card Description</h4>
    </div>
    <div class="modal-body">
        <?php // print_r($alldepartment); ?>
        <div class="row">
             <div class="col-md-8">
                    <label for="productCode" class="control-label">Job Card Category<span class="required">*</span></label>
                    <select name="jobCardCategory" id="jobCardCategory" class="form-control">
                        <?php foreach ($jobcategory as $trns) { ?>
                        <option value="<?php echo $trns->jobcategory_id; ?>"><?php echo $trns->job_category; ?></option>
                        <?php } ?>
                    </select>
                </div>
            <div class="col-md-8">

                <div class="form-group">
                    <label for="productCode" class="control-label">Job Description <span class="required">*</span></label>
                    <input type="text" class="form-control" required="required" value="<?php echo $trans->JobDescription?>"  name="name" id="name">
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
    
    $('#addproductform').submit(function(e) {
        $('#savepro').attr('disabled', true);
        e.preventDefault();
        $.ajax({
            url: "<?php echo base_url('admin/master/editJobCardDescription/') ?>",
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
                location.reload();
            }
        });
    });
    
</script>
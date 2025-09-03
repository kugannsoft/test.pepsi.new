<form id="addHolidayform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-power-off myclose"></i></button>
        <h4>Add Holiday Schedule</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <label for="productCode" class="control-label">Holiday Name<span class="required">*</span></label>
                <input type="text" class="form-control" required="required" value="<?php echo $trans->name; ?>"  name="name" id="name">
            </div>
            <div class="col-md-12">
                <label for="cateogry">Date</label>
                <input type="date" class="form-control" required="required" value="<?php echo $trans->date; ?>"  name="date" id="date">
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="productCode" class="control-label">Remark<span class="required">*</span></label>
                    <textarea rows="3" class="form-control" id="remark" name="remark"><?php echo $trans->remark; ?></textarea>
                </div>
            </div>
            <input type="hidden" id="id" name="id" value="<?php echo $trans->id; ?>">
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

    $('#addHolidayform').submit(function(e) {
        $('#savepro').attr('disabled', true);
        e.preventDefault();
        $.ajax({
            url: "<?php echo base_url('admin/master/editHoliday/') ?>",
            type: "POST",
            data: $(this).serializeArray(),
            success: function(data) {
                var newdata = JSON.parse(data);
                var fb = newdata.fb;

                if (fb) {
                    $('#productmodal').modal('hide');
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
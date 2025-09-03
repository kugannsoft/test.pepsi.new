<form id="addInterestform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-power-off myclose"></i></button>
        <h4>Add Interest</h4>
    </div>
    <div class="modal-body">
        <?php // print_r($alldepartment); ?>
        <div class="row">
            <div class="col-md-12">
                <label for="productCode" class="control-label">Easy Payment Category<span class="required">*</span></label>
                <select name="category" id="category" class="form-control">
                    <option value="0">--Select a Category--</option>
                    <?php foreach ($getCusAccountTypes as $trns) { ?>
                        <option value="<?php echo $trns->DepNo; ?>"><?php echo $trns->Description; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-12">
                <label for="cateogry">Interest Term</label>
                <select autofocus class="form-control select2" name="interestterm" id="interestterm">
                    <option value="0">-Select a Term-</option>
                    <?php for ($i = 0; $i <= 60; $i++) { ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="productCode" class="control-label">Interest Rate<span class="required">*</span></label>
                    <input type="text" class="form-control" required="required"  name="rate" id="rate">
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

    $('#addInterestform').submit(function(e) {
        $('#savepro').attr('disabled', true);
        e.preventDefault();
        $.ajax({
            url: "<?php echo base_url('admin/master/addInterest/') ?>",
            type: "POST",
            data: $(this).serializeArray(),
            success: function(data) {
                var newdata = JSON.parse(data);
                var fb = newdata.fb;

                if (fb) {
                    $('#savepro').attr('disabled', false);
                    $("#rate").val('');
                    $("#interestterm").val('');
                    $("#category").val('');
                } else {
                    $("#lastProduct").html('');
                    $('#savepro').attr('disabled', false);
                }
            }
        });
    });

</script>
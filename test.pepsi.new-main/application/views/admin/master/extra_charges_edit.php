<form id="editExtraChargesform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-power-off myclose"></i></button>
        <h4>Edit Extra Charges</h4>
    </div>
    <div class="modal-body">
        <?php // print_r($alldepartment); ?>
        <div class="row">
            <div class="col-md-12">
                <label for="productCode" class="control-label">Easy Payment Category<span class="required">*</span></label>
                <select name="category" id="category" class="form-control">
                    <option value="0">--Select a Category--</option>
                    <?php foreach ($getCusAccountTypes as $trns) { ?>
                        <option value="<?php echo $trns->DepNo; ?>" <?php if($trns->DepNo==$trans->ItemType){echo 'selected';} ?>><?php echo $trns->Description; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-12">
                <label for="cateogry">Charge Type</label>
                <select name="chargeType" id="chargeType" class="form-control">
                    <option value="0">--Select a Type--</option>
                    <?php foreach ($getExtraChargesTypes as $trns) { ?>
                        <option value="<?php echo $trns->charge_id; ?>" <?php if($trns->charge_id==$trans->ChargeType){echo 'selected';} ?>><?php echo $trns->charge_type; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="productCode" class="control-label">Amount<span class="required">*</span></label>
                    <input type="text" class="form-control" required="required" value="<?php echo $trans->ChargeAmount	?>"  name="amount" id="amount">
                </div>
            </div>
            <input type="hidden" value="<?php echo $trans->ChargeId?>" name="id" id="id">

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

    $('#editExtraChargesform').submit(function(e) {
        $('#savepro').attr('disabled', true);
        e.preventDefault();
        $.ajax({
            url: "<?php echo base_url('admin/master/editExtraCharges/') ?>",
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
<form id="addsupplierform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-power-off myclose"></i></button>
        <h4>Add Supplier</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="supname">Supplier Name </label>
                    <input type="text" required="required" class="form-control" name="supname" id="supname" placeholder="Enter customer name">
                </div>
                <div class="form-group">
                    <label for="respectSign" >Title</label>
                    <select class="form-control" name="respectSign" id="respectSign">
                        <option value="0">-Select-</option>
                        <?php foreach ($title AS $t) { ?>
                            <option value="<?php echo $t->TitleId ?>"><?php echo $t->TitleName ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="contactperson">Contact Person</label>
                    <input type="text" class="form-control" name="contactperson" id="contactperson" placeholder="Enter customer nic">
                </div>
                <div class="form-group">
                    <label for="address"> Supplier Remark </label>
                    <textarea  class="form-control" name="remark" id="remark"></textarea>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="address1">Address Line 1</label>
                    <input type="text"  class="form-control" name="address1" id="address1" placeholder="Address Line 1">
                </div>
                <div class="form-group">
                    <label for="address2">Address Line 2</label>
                    <input type="text"  class="form-control" name="address2" id="address2" placeholder="Address Line 2">
                </div>
                <div class="form-group">
                    <label for="address3">Address Line 3</label>
                    <input type="text"  class="form-control" name="address3" id="address3" placeholder="Address Line 3">
                </div>
                <div class="form-group">
                    <label for="email">Supplier Email </label>
                    <input type="email"  class="form-control" name="email" id="email" placeholder="Supplier Email">
                </div>
                <div class="form-group">
                    <label for="mobile">Mobile No</label>
                    <input type="text"  class="form-control" name="mobile" id="mobile" >
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="office">Office No</label>
                    <input type="text"  class="form-control" name="office" id="office" >
                </div>
                <div class="form-group">
                    <label for="fax">Fax No</label>
                    <input type="text"  class="form-control" name="fax" id="fax" >
                </div>

                <div class="form-group">
                    <label for="creditperiod">Credit Period </label>
                    <input type="number" step="1" min="0" class="form-control" name="creditperiod" id="creditperiod" placeholder="Enter credit period">
                </div>
                <div class="form-group">
                    <label for="creditperiod">Opening Balance </label>
                    <input type="number" step="1" min="0" class="form-control" name="openbalance" id="openbalance" placeholder="Enter Opening Outstandig">
                </div>
                <div class="form-group">
                    <label for="isactive">Is Active </label>
                    <input type="checkbox" class="sup_icheck"  name="isactive" id="isactive" value="1">
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success btn-flat" type="submit">Create Supplier</button>
    </div>
</form>

<script>
    $('.sup_icheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '50%'
    });
    $('#addsupplierform').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo base_url('admin/supplier/savesupplier/') ?>",
            type: "POST",
            data: $(this).serializeArray(),
            success: function (data) {
                if (data == 1) {
                    $('#suppliermodal').modal('hide');
                }
            }
        });
    });
</script>
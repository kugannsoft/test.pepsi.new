<form id="addsupplierform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-power-off myclose"></i></button>
        <h4>Edit Supplier</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="supname">Supplier Name </label>
                    <input type="text" required="required" class="form-control" name="supname" value="<?php echo $supplier->SupName ?>" id="supname" placeholder="Enter customer name">
                </div>
                <div class="form-group">
                    <label for="respectSign" >Title</label>
                    <select class="form-control" name="respectSign" id="respectSign">
                        <option value="0">-Select-</option>
                        <?php foreach ($title AS $t) { ?>
                            <option <?php if($t->TitleId==$supplier->SupTitle){echo 'selected';}?> value="<?php echo $t->TitleId ?>"><?php echo $t->TitleName ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="contactperson">Contact Person</label>
                    <input type="text" class="form-control" name="contactperson" id="contactperson" value="<?php echo $supplier->ContactPerson; ?>" placeholder="Enter customer nic">
                </div>
                <div class="form-group">
                    <label for="address"> Supplier Remark </label>
                    <textarea  class="form-control" name="remark" id="remark"><?php echo $supplier->Remark; ?></textarea>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="address1">Address Line 1</label>
                    <input type="text"  class="form-control" name="address1" id="address1" value="<?php echo $supplier->Address01 ?>" placeholder="Address Line 1">
                </div>
                <div class="form-group">
                    <label for="address2">Address Line 2</label>
                    <input type="text"  class="form-control" name="address2" id="address2" value="<?php echo $supplier->Address02 ?>" placeholder="Address Line 2">
                </div>
                <div class="form-group">
                    <label for="address3">Address Line 3</label>
                    <input type="text"  class="form-control" name="address3" id="address3" value="<?php echo $supplier->Address03 ?>" placeholder="Address Line 3">
                </div>
                <div class="form-group">
                    <label for="email">Supplier Email </label>
                    <input type="email"  class="form-control" name="email" value="<?php echo $supplier->Email ?>" id="email" placeholder="Supplier Email">
                </div>
                <div class="form-group">
                    <label for="mobile">Mobile No</label>
                    <input type="text"  class="form-control" name="mobile" value="<?php echo $supplier->MobileNo ?>" id="mobile" >
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="office">Office No</label>
                    <input type="text"  class="form-control" name="office" value="<?php echo $supplier->LanLineNo ?>" id="office" >
                </div>
                <div class="form-group">
                    <label for="fax">Fax No</label>
                    <input type="text"  class="form-control" value="<?php echo $supplier->Fax ?>" name="fax" id="fax" >
                </div>
                <div class="form-group">
                    <label for="creditperiod">Credit Period </label>
                    <input type="number" step="1" min="0" class="form-control" name="creditperiod" value="<?php echo $supplier->CreditPeriod ?>" id="creditperiod" placeholder="Enter credit period">
                </div>
                <div class="form-group">
                    <label for="isactive">Is Active </label>
                    <input type="checkbox" class="sup_icheck" <?php echo ($supplier->IsActive == 1) ? 'CHECKED' : '' ?> name="isactive" id="isactive" value="1">
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success btn-flat" type="submit">Edit Supplier</button>
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
            url: "<?php echo base_url('admin/supplier/editsupplier/').$supplier->SupCode ?>",
            type: "POST",
            data: $(this).serializeArray(),
            success: function (data) {
                if (data == 1) {
                    $.notify("Supplier Edited Successfully..!", "success");
                    $('#suppliermodal').modal('hide');
                }else{
                    $.notify("Error..!", "warning");
                }
            }
        });
    });


    const mobileInput = document.getElementById('mobile');

    mobileInput.addEventListener('input', function () {

        if (!this.value.startsWith('+94')) {
            this.value = '+94';
        } else {

            let digitsOnly = this.value.substring(3).replace(/\D/g, '');
            this.value = '+94' + digitsOnly.substring(0, 9);
        }
    });

    const officeInput = document.getElementById('office');

    officeInput.addEventListener('input', function () {

        if (!this.value.startsWith('+94')) {
            this.value = '+94';
        } else {

            let digitsOnly = this.value.substring(3).replace(/\D/g, '');
            this.value = '+94' + digitsOnly.substring(0, 9);
        }
    });

    const faxInput = document.getElementById('fax');

    faxInput.addEventListener('input', function () {

        if (!this.value.startsWith('+94')) {
            this.value = '+94';
        } else {

            let digitsOnly = this.value.substring(3).replace(/\D/g, '');
            this.value = '+94' + digitsOnly.substring(0, 9);
        }
    });

</script>
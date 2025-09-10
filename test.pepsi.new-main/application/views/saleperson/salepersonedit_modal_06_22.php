<form id="addsupplierform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-power-off myclose"></i></button>
        <h4>Edit Employee</h4>
    </div>
    <div class="modal-body">
        <div class="row">
           <div class="col-md-4">
                <!-- <div class="form-group">
                    <label for="respectSign" >Title</label>
                    <select class="form-control" name="respectSign" id="respectSign">
                        <option value="0">-Select-</option>
                        <?php foreach ($title AS $t) { ?>
                            <option value="<?php echo $t->TitleId ?>"><?php echo $t->TitleName ?></option>
                        <?php } ?>
                    </select>
                </div> -->
                <div class="form-group">
                    <label for="supname">Employee Name </label>
                    <input type="text" required="required" class="form-control" value="<?php echo $saleperson->RepName;?>" name="name" id="name" placeholder="Enter customer name">
                </div>

                <div class="form-group">
                    <label for="contactperson">Location</label>
                    <select class="form-control" name="location" id="location">
                        <option value="0">-Select-</option>
                        <?php foreach ($locations AS $t) { ?>
                            <option <?php if($t->location_id==$saleperson->LocationCode){ ?> selected <?php } ?> value="<?php echo $t->location_id ?>"><?php echo $t->location ?></option>
                        <?php } ?>
                    </select>
                    <!-- <input type="text" class="form-control" name="contactperson" id="contactperson" placeholder="Enter customer nic"> -->
                </div>
                <div class="form-group">
                    <label for="contactperson">Skill</label>
                    <select class="form-control" name="skill" id="skill">
                        <option value="0">-Select-</option>
                        <?php foreach ($skill AS $t) { ?>
                            <option <?php if($t->skill_id==$saleperson->Skill){ ?> selected <?php } ?> value="<?php echo $t->skill_id ?>"><?php echo $t->skill_level ?></option>
                        <?php } ?>
                    </select>
                    <!-- <input type="text" class="form-control" name="contactperson" id="contactperson" placeholder="Enter customer nic"> -->
                </div>
                
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="contactperson">Employee Type</label>
                    <select class="form-control" name="emp_type" id="emp_type">
                        <option value="0">-Select-</option>
                        <?php foreach ($type AS $t) { ?>
                            <option <?php if($t->EmpTypeNo==$saleperson->RepType){ ?> selected <?php } ?> value="<?php echo $t->EmpTypeNo ?>"><?php echo $t->EmpType ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email"> Email </label>
                    <input type="email"  class="form-control" value="<?php echo $saleperson->Email;?>"  name="email" id="email" placeholder=" Email">
                </div>
                <div class="form-group">
                    <label for="mobile">Mobile No</label>
                    <input type="text"  class="form-control" value="<?php echo $saleperson->ContactNo;?>"  name="mobile" id="mobile" >
                </div>
               <!--  <div class="form-group">
                    <label for="office">Office No</label>
                    <input type="text"  class="form-control" name="office" id="office" >
                </div>
                <div class="form-group">
                    <label for="fax">Fax No</label>
                    <input type="text"  class="form-control" name="fax" id="fax" >
                </div> -->
            </div>
            <div class="col-md-4">
            <div class="form-group">
                    <label for="address"> Remark </label>
                    <textarea  class="form-control" name="remark" id="remark"><?php echo $saleperson->Remark;?></textarea>
                </div>
                <div class="form-group">
                    <label for="address1">Emp No</label>
                    <input type="text"  class="form-control" name="empno" id="empno" value="<?php echo $saleperson->EmpNo;?>"  placeholder="Employee No">
                     <input type="hidden"  class="form-control" name="rep_id" id="rep_id" value="<?php echo $saleperson->RepID;?>"  placeholder="Employee No">
                </div>
               <!-- <div class="form-group">
                    <label for="address2">Address Line 2</label>
                    <input type="text"  class="form-control" name="address2" id="address2" placeholder="Address Line 2">
                </div>
                <div class="form-group">
                    <label for="address3">Address Line 3</label>
                    <input type="text"  class="form-control" name="address3" id="address3" placeholder="Address Line 3">
                </div>
                <div class="form-group">
                    <label for="creditperiod">Credit Period </label>
                    <input type="number" step="1" min="0" class="form-control" name="creditperiod" id="creditperiod" placeholder="Enter credit period">
                </div> -->
                <div class="form-group">
                    <label for="isactive">Is Active </label>
                    <input type="checkbox" class="sup_icheck"  <?php if($saleperson->IsActive==1){?> checked  <?php } ?> name="isactive" id="isactive" value="1">
                </div>
            </div>
            <div class="row">
            <div class="col-md-3">
            <div class="form-group">
                    <label for="isactive">Is Sales </label>
                    <input type="checkbox" class="sup_icheck" <?php if($saleperson->IsSalesPerson==1){?> checked  <?php } ?>  name="issale" id="issale" value="1">
                </div>
                 </div>
                <div class="col-md-3">
                <div class="form-group">
                    <label for="isactive">Is Technician </label>
                    <input type="checkbox" class="sup_icheck" <?php if($saleperson->IsTec==1){?> checked  <?php } ?>  name="istec" id="istec" value="1">
                </div>
                 </div>
                <div class="col-md-3">
                <div class="form-group">
                   <label for="isactive">Is Account </label>
                    <input type="checkbox" class="sup_icheck"  <?php if($saleperson->IsAccount==1){?> checked  <?php } ?> name="isacc" id="isacc" value="1">
                </div>
                 </div>
                </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success btn-flat" type="submit">Update</button>
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
            url: "<?php echo base_url('admin/sales/editsaleperson/').$saleperson->RepID ?>",
            type: "POST",
            data: $(this).serializeArray(),
            success: function (data) {
                if (data == 1) {
                    $.notify("Employee Edited Successfully..!", "success");
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
</script>
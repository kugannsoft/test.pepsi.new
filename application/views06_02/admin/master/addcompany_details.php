<form id="addCompanyDetailsform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-power-off myclose"></i></button>
        <h4>Add Company Details</h4>
    </div>
    <div class="modal-body">
    <div class="row" style="background: rgba(148, 167, 187, 0.45);">
            <div class="col-md-12">
            <div class="row">
            <div class="col-md-12">
                 <div class="row">
                    <div class="col-md-4"><div class="form-group">
                    <label for="CompanyName">Company Name 01 </label>
                    <input type="text" required="required" class="form-control" name="CompanyName" id="CompanyName" placeholder="Enter Company Name 01">
                    </div></div>
                    <div class="col-md-4"><div class="form-group">
                    <label for="CompanyName2">Company Name 02 </label>
                    <input type="text" class="form-control" name="CompanyName2" id="CompanyName2" placeholder="Enter Company Name 02">
                    </div></div>
                    <div class="col-md-4"><div class="form-group">
                    <label for="RegNo">Register No </label>
                    <input type="text" class="form-control" name="RegNo" id="RegNo" placeholder="Enter Register No">
                    </div></div>
                </div>
                <!-- ----------------------------------------------------------------------------------------------------------- -->
                  <div class="row">
                    <div class="col-md-4"><div class="form-group">
                    <label for="AddressLine01">Address Line 01 </label>
                    <input type="text" required="required" class="form-control" name="AddressLine01" id="AddressLine01" placeholder="Enter Address Line 01">
                    </div></div>
                    <div class="col-md-4"><div class="form-group">
                    <label for="AddressLine02">Address Line 02 </label>
                    <input type="text" class="form-control" name="AddressLine02" id="AddressLine02" placeholder="Enter Address Line 02">
                    </div></div>
                    <div class="col-md-4"><div class="form-group">
                    <label for="AddressLine03">Address Line 03 </label>
                    <input type="text" class="form-control" name="AddressLine03" id="AddressLine03" placeholder="Enter Address Line 03">
                    </div></div>
                </div>  
                <!-- ----------------------------------------------------------------------------------------------------------- -->
                <div class="row">
                    <div class="col-md-4"><div class="form-group">
                    <label for="MobileNo">Mobile No </label>
                    <input type="text" required="required" class="form-control" name="MobileNo" id="MobileNo" placeholder="Enter MobileNo" maxlength="10">
                    </div></div>
                    <div class="col-md-4"><div class="form-group">
                    <label for="LanLineNo">Landline No </label>
                    <input type="text" class="form-control" name="LanLineNo" id="LanLineNo" placeholder="Enter Landline No" maxlength="10">
                    </div></div>
                    <div class="col-md-4"><div class="form-group">
                    <label for="Fax">Fax No </label>
                    <input type="text" class="form-control" name="Fax" id="Fax" placeholder="Enter Fax No" maxlength="10">
                    </div></div>
                </div>
                <!-- ----------------------------------------------------------------------------------------------------------- -->
                  <div class="row">
                    <div class="col-md-3"><div class="form-group">
                    <label for="Email01"> Email 01 </label>
                    <input type="email" class="form-control" name="Email01" id="Email01" placeholder="Enter Email 01">
                    </div></div>
                    <div class="col-md-3"><div class="form-group">
                    <label for="Email02">VAT No </label>
                    <input type="text" class="form-control" name="Email02" id="Email02" placeholder="Enter VAT No">
                    </div></div>
                    <div class="col-md-2"><div class="form-group">
                    <label for="VAT">VAT </label>
                    &nbsp;&nbsp;<input type="text"   class="form-control" name="VAT" id="VAT" placeholder="Enter VAT ">
                    </div></div>
                    <div class="col-md-2"><div class="form-group">
                    <label for="NBT">NBT </label>
                    &nbsp;&nbsp;<input type="text"   class="form-control" name="NBT" id="NBT" placeholder="Enter NBT ">
                    </div></div>
                    <div class="col-md-2"><div class="form-group">
                    <label for="NBT_Ratio">NBT Ratio </label>
                    &nbsp;&nbsp;<input type="text"   class="form-control" name="NBT_Ratio" id="NBT_Ratio" placeholder="Enter NBT Ratio">
                    </div></div>
                </div> 
                 <!-- ----------------------------------------------------------------------------------------------------------- -->
                <div class="row">
                    <div class="col-md-5"><div class="form-group">
                    <label for="SAdvisorName">Advisor Name </label>
                    <input type="text" required="required" class="form-control" name="SAdvisorName" id="SAdvisorName" placeholder="Enter Advisor Name">
                    </div></div>
                    <div class="col-md-5"><div class="form-group">
                    <label for="SAdvisorContact">Advisor Contact  </label>
                    <input type="text" class="form-control" name="SAdvisorContact" id="SAdvisorContact" placeholder="Enter Advisor Contact" maxlength="10">
                    </div></div>
                    <div class="col-md-2"><div class="form-group">
                        <br>
                    <label for="IsActive">Is Active </label>
                    &nbsp;&nbsp;<input type="checkbox"   name="IsActive" id="IsActive" value="1">
                    &nbsp;&nbsp;&nbsp;</div>
                </div>
               
               
            </div>
            </div>
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
    
    $('#addCompanyDetailsform').submit(function(e) {
        $('#savepro').attr('disabled', true);
        e.preventDefault();
        $.ajax({
            url: "<?php echo base_url('admin/master/addcompany_details/') ?>",
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
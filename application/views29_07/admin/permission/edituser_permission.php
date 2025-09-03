<form id="addproductform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-power-off myclose"></i></button>
        <h4>Edit Function</h4>
    </div>
    <div class="modal-body">
        <?php // print_r($alldepartment); ?>
        <div class="row">
        <div class="col-md-8">
                    <label for="productCode" class="control-label">User Group<span class="required">*</span></label>
                    <select name="user" required="required" id="user" class="form-control">
                        <option value="0">--Select--</option>
                        <?php foreach ($role as $trns) { ?>
                        <option value="<?php echo $trns->role_id; ?>" <?php if($per->per_user==$trns->role_id){echo 'selected';} ?>><?php echo $trns->role; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-8">
                    <label for="productCode" class="control-label">Class<span class="required">*</span></label>
                    <select name="class" id="class" class="form-control">
                        <option value="0">--Select--</option>
                        <?php foreach ($class as $trns) { ?>
                        <option value="<?php echo $trns->class_name; ?>" <?php if($per->permission_class==$trns->class_name){echo 'selected';} ?>><?php echo $trns->class_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-8">
                    <label for="productCode" class="control-label">Functions<span class="required">*</span></label>
                    <select name="function" id="function" multiple class="form-control">
                        <option value="0">--Select--</option>
                        
                    </select>
                </div>
            <div class="col-md-8">

                <div class="form-group">
                    <label for="productCode" class="control-label">Function Name <span class="required">*</span></label>
                    <input type="text" class="form-control" required="required" value='<?php echo $per->permission_function; ?>'  name="name" id="name">
                </div>
            </div>
            <div class="col-md-8">

                <div class="form-group">
                    <label for="isfreeissue" class="control-label">
                        Is All functions
                        <input class="prd_icheck" type="checkbox" name="isAllClass" id="isAllClass" value="1" <?php echo ($per->isClass == 1) ? 'checked' : '' ?>>  
                        &nbsp;&nbsp;&nbsp;
                    </label>
                </div>
                <div class="form-group">
                    
                    <input type="hidden" value="<?php echo $per->permission_id?>" name="id" id="id">
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

    $.ajax({
            url: "<?php echo base_url('admin/permission/getFunctionsByClass/') ?>",
            type: 'POST',
            data: {class: '<?php echo $per->permission_class; ?>'},
            success: function(resp) {
                resp = JSON.parse(resp);
                $('#function').empty().append("<option value=''>--select--</option>");

                $.each(resp, function(k, v) {
                    $('<option>').val(v.function_name).text(v.function_name).appendTo('#function');
                });
            }
        });


     $("#function").select2({
        placeholder: "Select a model"
    });

       var fun =[];
 $("#function").change(function(){
    fun.length=0;

    $("#function :selected").each(function(){
        fun.push($(this).val()); 
    });
    $("#name").val(JSON.stringify(fun));
 });
    
    $('#class').change(function() {
   var s_class = $("#class option:selected").val();
    
        $.ajax({
            url: "<?php echo base_url('admin/permission/getFunctionsByClass/') ?>",
            type: 'POST',
            data: {class: $(this).val()},
            success: function(resp) {
                resp = JSON.parse(resp);
                $('#function').empty().append("<option value=''>--select--</option>");

                $.each(resp, function(k, v) {
                    $('<option>').val(v.function_name).text(v.function_name).appendTo('#function');
                });
            }
        });
    });
    
    $('#addproductform').submit(function(e) {
        $('#savepro').attr('disabled', true);
        e.preventDefault();
        $.ajax({
            url: "<?php echo base_url('admin/permission/editUserPermission/') ?>",
            type: "POST",
            data: $(this).serializeArray(),
            success: function(data) {
                var newdata = JSON.parse(data);
                var fb = newdata.fb;
                var lastproduct_code = newdata.permission_id;

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
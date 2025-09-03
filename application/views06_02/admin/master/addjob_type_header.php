<form id="addproductform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-power-off myclose"></i></button>
        <h4>Add Job Type Header</h4>
    </div>
    <div class="modal-body">
        <?php // print_r($alldepartment); ?>
        <div class="row">
            <div class="col-md-8">
               
                <div class="form-group">
                    <label for="name" class="control-label">Type Header Name <span class="required">*</span></label>
                    <input type="text" class="form-control" required="required"   name="name" id="name">
                </div>
                
                <div class="form-group">
                    <label for="order" class="control-label">Type Header Order <span class="required"></span></label>
                    <input type="text" class="form-control" required="required" name="order" id="order">
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

     $("#nbtRatio").prop('disabled',true);
    
    $("input[name='isNbt']").on('ifChanged', function(event){
       var isNbt = $("input[name='isNbt']:checked").val();

        if(isNbt){
            $("#nbtRatio").prop('disabled',false);
        }else{
            $("#nbtRatio").prop('disabled',true);
        }
    });

    $('#addproductform').submit(function(e) {
        $('#savepro').attr('disabled', true);
        e.preventDefault();
        $.ajax({
            url: "<?php echo base_url('admin/master/addJobTypeHeader/') ?>",
            type: "POST",
            data: $(this).serializeArray(),
            success: function(data) {
                var newdata = JSON.parse(data);
                var fb = newdata.fb;
                var lastproduct_code = newdata.ProductCode;

                if (fb) {
                    $("#lastProduct").html('');
                    $("#lastProduct").html(lastproduct_code);
                    $('#savepro').attr('disabled', false);
                } else {
                    $("#lastProduct").html('');
                    $('#savepro').attr('disabled', false);
                }
            }
        });
    });
    
</script>
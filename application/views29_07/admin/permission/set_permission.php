<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
    <section class="content-header">
        <?php echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <b><span class="alert alert-success pull-left" id=""></span></b>
                    </div>
                </div>
            </div>
        </div>
<form id="setPermissionToUser" data-parsley-validate method="post">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="col-md-8">
                            <label for="productCode" class="control-label">User Role<span
                                        class="required">*</span></label>
                            <select name="user" required="required" id="user" class="form-control">
                                <option value="0">--Select--</option>
                                <?php foreach ($role as $trns) { ?>
                                    <option value="<?php echo $trns->role_id; ?>"><?php echo $trns->role; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Role Permission</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-bordered">
                            <tr><td style="text-align: center;"></td>
                                 <td><span>Check All </span><span class="badge bg-maroon"><input type="checkbox" id="checkAll" class="checkAll"></span></td>
                            </tr>
                            <tr>
<!--                                <th style="width: 10px">#</th>-->
                                <th style="text-align: center;">Permission Module</th>
                                <th style="width: 100px; text-align: center;">VIEW OR PRINT</th>
                                <th style="width: 100px; text-align: center;">ADD</th>
                                <th style="width: 100px; text-align: center;">EDIT</th>
                                <th style="width: 100px; text-align: center;">CANCEL</th>
                            </tr>
                                <?php foreach ($per_data AS $key=>$invdata) { ?>
                            <tr><input type="hidden" name="moduleid" value="<?php echo $invdata[0]->module_id?>">
                                <td style="background-color:#254a8d; color: white; font-style: oblique; font-size: medium"><?php echo $key ?></td>
                                <td style="background-color:#5ca1a7; text-align: center;"><span class="badge bg-blue">
                  <input type="checkbox" class="viewall mainchk" value="" val2="<?php echo $invdata[0]->module_id?>" id="viewall<?php echo $invdata[0]->module_id?>"></span>
                                </td>
                                <td style="background-color:#5ca1a7; text-align: center;"><span class="badge bg-green">
                  <input type="checkbox" class="addall mainchk" value="" val2="<?php echo $invdata[0]->module_id?>" id="addall<?php echo $invdata[0]->module_id?>"></span>
                                </td>
                                <td style="background-color:#5ca1a7; text-align: center;"><span class="badge bg-orange">
                  <input type="checkbox" class="editall mainchk" value="" val2="<?php echo $invdata[0]->module_id?>" id="editall<?php echo $invdata[0]->module_id?>"></span>
                                </td>
                                <td style="background-color:#5ca1a7; text-align: center;"><span class="badge bg-red">
                  <input type="checkbox" class="deleteall mainchk" value="" val2="<?php echo $invdata[0]->module_id?>" id="deleteall<?php echo $invdata[0]->module_id?>"></span>
                                </td>
                            </tr>
                                    <?php foreach ($invdata as $item) {?>
                                    <tr>
                                        <td>
<!--                                            <input type="hidden" name="model[--><?php //echo $item->module_id;?><!--]" value="--><?php //echo $item->module_id?><!--">-->
                                            <input type="hidden" name="class[<?php echo $item->per_code;?>]" value="<?php echo $item->per_class?>">
                                            <input type="hidden" name="module[<?php echo $item->per_code;?>]" value="<?php echo $item->module_id?>">
                                            <?php echo $item->per_class?>
                                        </td>
                                        <td style="text-align: center;"><span class="">
                  <input type="checkbox" name="chk_view[<?php echo $item->per_code;?>]" value="0" val2="<?php echo $item->module_id?>" class="view<?php echo $item->module_id?> viewsub subchk" id="view<?php echo $item->per_code;?>" ></span>
                                        </td>
                                        <td style="text-align: center;"><span class="">
                  <input type="checkbox" name="chk_add[<?php echo $item->per_code;?>]" value="0" val2="<?php echo $item->module_id?>" class="add<?php echo $item->module_id?> addsub subchk" id="add<?php echo $item->per_code;?>"></span>
                                        </td>
                                        <td style="text-align: center;"><span class="">
                  <input type="checkbox" name="chk_edit[<?php echo $item->per_code;?>]" value="0" val2="<?php echo $item->module_id?>" class="edit<?php echo $item->module_id?> editsub subchk" id="edit<?php echo $item->per_code;?>"></span>
                                        </td>
                                        <td style="text-align: center;"><span class="">
                  <input type="checkbox" name="chk_delete[<?php echo $item->per_code;?>]" value="0" val2="<?php echo $item->module_id?>" class="delete<?php echo $item->module_id?> deletesub subchk" id="delete<?php echo $item->per_code;?>"></span>
                                        </td>
                                    </tr>
                                        <?php } ?>
                            <?php } ?>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
<!--                <span id="errProduct1" class="pull-right"></span>-->
                <button class="btn btn-success btn-flat pull-right col-md-2"  type="submit">Save</button>
                <button class="btn btn-primary btn-flat pull-right col-md-2"  type="reset">Clear</button>
            </div>
        </div>
</form>
    </section>
</div>

<script type="text/javascript">
    $(document).ready(function () {
    

    });
    
/*checkAll*/
    $("#checkAll").click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
    $('.mainchk').change(function () {    
        var check = ($('.mainchk').filter(":checked").length == $('.mainchk').length);
        $('#checkAll').prop("checked", check);
    });

      
/*view*/
    $('.viewall').on('click', function() {
        var i = $(this).attr('val2');                
        $('.view'+i).not(this).prop('checked', this.checked);              
    });            
    $('.viewsub').change(function () {
        var i = $(this).attr('val2');    
        var check = ($('.view'+i).filter(":checked").length == $('.view'+i).length);
        $('#viewall'+i).prop("checked", check);
    });              
    
/*add*/
    $('.addall').on('click', function() {
        var i = $(this).attr('val2');     
            $('.add'+i).not(this).prop('checked', this.checked);                
    });
    $('.addsub').change(function () {
        var i = $(this).attr('val2');
        var check = ($('.add'+i).filter(":checked").length == $('.add'+i).length);
        $('#addall'+i).prop("checked", check);
    });

/*edit*/
    $('.editall').on('click', function() {
        var i = $(this).attr('val2');  
            $('.edit'+i).not(this).prop('checked', this.checked);      
    });
    $('.editsub').change(function () {
        var i = $(this).attr('val2');
        var check = ($('.edit'+i).filter(":checked").length == $('.edit'+i).length);
        $('#editall'+i).prop("checked", check);
    });

/*delete*/
    $('.deleteall').on('click', function() {
        var i = $(this).attr('val2');      
            $('.delete'+i).not(this).prop('checked', this.checked);
    });
    $('.deletesub').change(function () {
        var i = $(this).attr('val2'); 
        var check = ($('.delete'+i).filter(":checked").length == $('.delete'+i).length);
        $('#deleteall'+i).prop("checked", check);
    });

    

    $('#setPermissionToUser').submit(function (e) {        
        $(this).find('input[type=checkbox]:checked').prop('checked', true).val(1);
        
        e.preventDefault();
        $.ajax({
            url: "<?php echo base_url('admin/setPermission/savePermission/') ?>",
            type: "POST",
            data: $(this).serializeArray(),
            success: function (data) {
                if (data==1) {
                    $.notify('Successfully Added Permission', "success");
                }
                if (data==2) {
                    $.notify('Successfully Updated Permission', "success");
                }
                location.reload(true);
                /*setTimeout(function(){
                       location.reload(true); 
                }, 2000); */
            }
        });        
    });

    $('#user').on('change', function() {
        var roleid = $(this).val();
        
        $.ajax({
            url: "<?php echo base_url('admin/setPermission/loadPermission/') ?>",
            type: "POST",
            data:{roleid:roleid},
            dataType:'json',
            success: function (data) {
                /*$('#M1').prop('checked', true);*/
                $('input:checkbox').removeAttr('checked');
                for (var i =  0; i < data.permission_data.length; i++) {
                    var x=data.permission_data[i].module_id;
                    if (data.permission_data[i].is_view==1) {
                        $('#view'+data.permission_data[i].per_code).prop('checked', true);
                    }else{
                        $('#view'+data.permission_data[i].per_code).prop('checked', false);
                    }

                    if (data.permission_data[i].is_add==1) {
                        $('#add'+data.permission_data[i].per_code).prop('checked', true);
                    }else{
                        $('#add'+data.permission_data[i].per_code).prop('checked', false);
                    }

                    if (data.permission_data[i].is_edit==1) {
                        $('#edit'+data.permission_data[i].per_code).prop('checked', true);
                    }else{
                        $('#edit'+data.permission_data[i].per_code).prop('checked', false);
                    }

                    if (data.permission_data[i].is_delete==1) {
                        $('#delete'+data.permission_data[i].per_code).prop('checked', true);
                    }else{
                        $('#delete'+data.permission_data[i].per_code).prop('checked', false);
                    }

        var checkv = ($('.view'+x).filter(":checked").length == $('.view'+x).length);
        $('#viewall'+x).prop("checked", checkv);
        var checka = ($('.add'+x).filter(":checked").length == $('.add'+x).length);
        $('#addall'+x).prop("checked", checka);
        var checke = ($('.edit'+x).filter(":checked").length == $('.edit'+x).length);
        $('#editall'+x).prop("checked", checke);
        var checkd = ($('.delete'+x).filter(":checked").length == $('.delete'+x).length);
        $('#deleteall'+x).prop("checked", checkd);

        var checkall = ($('.mainchk').filter(":checked").length == $('.mainchk').length);
        $('#checkAll').prop("checked", checkall);
    
        
                    
                }
            }
        });
    });



</script>

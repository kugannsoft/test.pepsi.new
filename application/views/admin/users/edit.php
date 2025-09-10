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
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?php echo lang('users_edit_user'); ?></h3>
                                </div>
                                <div class="box-body">
                                    <?php echo $message;?>

                                    <?php echo form_open(uri_string(), array('class' => 'form-horizontal', 'id' => 'form-edit_user')); ?>
                                        <div class="form-group">
                                            <?php echo lang('users_firstname', 'first_name', array('class' => 'col-sm-2 control-label')); ?>
                                            <div class="col-sm-10">
                                                <?php echo form_input($first_name);?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php echo lang('users_lastname', 'last_name', array('class' => 'col-sm-2 control-label')); ?>
                                            <div class="col-sm-10">
                                                <?php echo form_input($last_name);?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php echo lang('users_company', 'company', array('class' => 'col-sm-2 control-label')); ?>
                                            <div class="col-sm-10">
                                                <?php echo form_input($company);?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php if($role['value']==1){ ?>
                                                <?php echo lang('users_com', 'com', array('class' => 'col-sm-2 control-label')); ?>
                                                <div class="col-sm-10">
                                                    <select <?php echo form_input($com);?>>
                                                        <option value="0" selected="selected">Select Company</option>
                                                        <?php foreach ($coms as $trns) { ?>
                                                            <option <?php if($trns->CompanyID==$com['value']){ ?> selected <?php } ?> value="<?php echo $trns->CompanyID; ?>" ><?php echo $trns->CompanyName." ".$trns->CompanyName2; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>  
                                            <?php }else{ ?>
                                                <?php //echo lang('users_role', 'role', array('class' => 'col-sm-2 control-label')); ?>
                                                <div class="col-sm-10">
                                                    <?php echo form_input($com);?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="form-group">
                                            <?php if($role['value']==1){ ?>
                                                <?php echo lang('users_location', 'location', array('class' => 'col-sm-2 control-label')); ?>
                                                <div class="col-sm-10"><select <?php echo form_input($location);?>>
                                                        <option value="0" selected="selected">Select Location</option>
                                                        <?php foreach ($locations as $trns) { ?>
                                                            <option <?php if($trns->location_id==$location['value']){ ?> selected <?php } ?> value="<?php echo $trns->location_id; ?>" ><?php echo $trns->location; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            <?php }else{ ?>
                                                <?php //echo lang('users_role', 'role', array('class' => 'col-sm-2 control-label')); ?>
                                                <div class="col-sm-10">
                                                    <?php echo form_input($location);?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="form-group">
                                            <?php if($role['value']==1){ ?>
                                                <?php echo lang('users_role', 'role', array('class' => 'col-sm-2 control-label')); ?>
                                                <div class="col-sm-10">
                                                    <select <?php echo form_input($role);?> >
                                                        <option value="0" selected="selected">Select Role</option>
                                                        <?php foreach ($roles as $trns) { ?>
                                                            <option <?php if($trns->role_id==$role['value']){ ?> selected <?php } ?> value="<?php echo $trns->role_id; ?>" ><?php echo $trns->role; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            <?php }else{ ?>
                                                <?php //echo lang('users_role', 'role', array('class' => 'col-sm-2 control-label')); ?>
                                                <div class="col-sm-10">
                                                    <?php echo form_input($role);?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="form-group">
                                            <?php echo lang('users_phone', 'phone', array('class' => 'col-sm-2 control-label')); ?>
                                            <div class="col-sm-10">
                                                <?php echo form_input($phone);?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php echo lang('users_password', 'password', array('class' => 'col-sm-2 control-label')); ?>
                                            <div class="col-sm-10">
                                                <?php echo form_input($password);?>
                                                <div class="progress" style="margin:0">
                                                    <div class="pwstrength_viewport_progress"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php echo lang('users_password_confirm', 'password_confirm', array('class' => 'col-sm-2 control-label')); ?>
                                            <div class="col-sm-10">
                                                <?php echo form_input($password_confirm);?>
                                            </div>
                                        </div>

<?php if ($this->ion_auth->is_admin() && $_SESSION['user_id']==1): ?>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label"><?php echo lang('users_member_of_groups');?></label>
                                            <div class="col-sm-10">
<?php foreach ($groups as $group):?>
<?php
    $gID     = $group['id'];
    $checked = NULL;
    $item    = NULL;

    foreach($currentGroups as $grp) {
        if ($gID == $grp->id) {
            $checked = ' checked="checked"';
            break;
        }
    }
?>
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked; ?>>
                                                        <?php echo htmlspecialchars($group['name'], ENT_QUOTES, 'UTF-8'); ?>
                                                    </label>
                                                </div>
<?php endforeach?>
                                            </div>
                                        </div>
<?php endif ?>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <?php echo form_hidden('id', $user->id);?>
                                                <?php echo form_hidden($csrf); ?>
                                                <div class="btn-group">
                                                    <?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-primary btn-flat', 'content' => lang('actions_submit'))); ?>
                                                    <?php echo form_button(array('type' => 'reset', 'class' => 'btn btn-warning btn-flat', 'content' => lang('actions_reset'))); ?>
                                                    <?php echo anchor('admin/users', lang('actions_cancel'), array('class' => 'btn btn-default btn-flat')); ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php echo form_close();?>
                                </div>
                            </div>
                         </div>
                    </div>
                </section>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $("#com").change(function(){
                            var com = $("#com option:selected").html();
                            $("#company").val(com);
                        });
                    });
                </script>
            </div>

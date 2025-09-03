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
                    <div class="box-header with-border col-md-2">
                    <button type="button" onclick="addRole()" class="btn btn-primary" data-toggle="modal" id="roleModelOne" >
                        Add User Role
                    </button>
<!--                        --><?php //echo anchor('admin/setPermission/roleCreate/', '<span class="btn btn-block btn-primary btn-flat box-title"><i class="fa fa-plus"></i>Edit</span>'); ?><!--&nbsp;-->
                    </div>
                    <div class="box-body">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Role ID</th>
                                <th>Role Name</th>
                                <th>Role Description</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($role as $roleData):?>
                                <tr>
                                    <td><?php echo $roleData->role_id; ?></td>
                                    <td><?php echo $roleData->role; ?></td>
                                    <td><?php echo $roleData->role_description ?></td>
                                    <td>
                                        <button onclick="editRole(<?php echo $roleData->role_id ?>)" id=""
                                                class="btn  btn-success btn-sm mr-1 card-outline">Edit
                                        </button>
<!--                                        --><?php //echo anchor('admin/setPermission/roleEdit/'.$roleData->role_id, '<span class="btn btn-primary btn-sm">Edit</span>'); ?><!--&nbsp;-->
                                    </td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Modal -->
<div class="modal fade" id="roleModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div id="editDive">
                <h5 class="modal-title" id="exampleModalLabel">Add User Roles</h5>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="saveRole">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Role:</label>
                        <input type="text" id="role" name="role" class="form-control" id="recipient-name">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Role Description:</label>
                        <textarea name="description" class="form-control" id="description"></textarea>
                    </div>
                    <input type="hidden" id="role_id" name="role_id">
                </form>
            </div>
            <div class="modal-footer">
                <span id="updateButton">
                <button type="submit" id="roleSubmit" class="btn btn-primary">Save changes</button>
                </span>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function addRole() {
        $('#roleModel').modal('show')
    }

    $('#roleSubmit').click(function (e) {
        e.preventDefault();

        if ($('#role').val() === "") {
            alert('Please Select a Role.')
        }

        $.ajax({
            url: "roleCreate",
            type: "POST",
            data: $('#saveRole').serializeArray(),
            success: function () {
                $("#roleModel").modal("hide");
                location.reload();
            }
        });
    });

    function editRole(id) {
        $.ajax({
            url: "roleEdit",
            type: "POST",
            data: {id: id},
            success: function (data) {
                $('#id').val(data.role_id);
                $('#role').val(data.role);
                $('#description').val(data.description);
                $('#editDive').html("<h3 class='card-title'>Update Role</h3>");
                $('#updateButton').html("<button type='submit' onclick='updateRole()' id='updateFloor' class='btn btn-success'>Update</button>");
                $('#roleModel').modal({
                    backdrop: "static",
                    keyboard: false
                });
            }
        })
    }
</script>


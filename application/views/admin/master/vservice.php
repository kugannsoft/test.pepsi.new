<div class="content-wrapper">
	<div class="row">
		<div class="col-md-3">
			<div class="box-primary">
			<span id="errTop1" class="pull-right"></span>
				<div class="box-header">
	                <h4>Make <a type="button" class="btn btn-primary pull-right" data-toggle="modal"  data-target="#modelDep">Add</a></h4><br>
	                <span id="errProduct1" class="pull-right"></span>
	            </div>
	            <div class="box-body">
                        <div class="list-group" id="dep">
                            <?php foreach ($make as $row) { ?>
                                <li lvl="1" depCode="<?php echo $row->make_id; ?>" desc="<?php echo $row->make; ?>" class="list-group-item "><?php echo $row->make; ?> <a class="delete btn btn-default btn-xs pull-right"><i class="fa fa-close"></i></a> <a class="edit btn btn-default btn-xs pull-right"  data-toggle="modal"  data-target="#modelEditDep"><i class="fa fa-pencil"></i></a></li>
                            <?php } ?>

                        </div>
                    </div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="box-default">
                <span id="errTop2" class="pull-right"></span>
                <div class="box-header">
                    <h4>Model<a type="button" id="btnAddSubDep" class="btn btn-primary pull-right" data-toggle="modal"  data-target="#modelSubDep">Add</a></h4><br>
                    <span id="errProduct2" class="pull-right"></span></div>
                <div class="box-body">
                    <div class="list-group" id="subDep"></div>
                </div>
            </div>
		</div>
	</div>
</div>
<!--add department modal-->
<div class="modal fade bs-add-department-modal-lg" id="modelDep" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-sm">
        <form role="form" id="addDep" data-parsley-validate method="post" action="#">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel2">Add Make</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="cateogry">Make Name</label>
                        <input type="text" required="required" class="form-control" name="department" id="department" placeholder="Enter make">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="submitDep" class="btn btn-primary">Add</button>
                </div>

            </div>
        </form>
    </div>
</div>
<!--add subdepartment modal-->
        <div class="modal fade subdepartment-modal-lg" id="modelSubDep" tabindex="-2" role="dialog" aria-hidden="false">
            <div class="modal-dialog modal-sm">
                <form role="form" id="addSubDep" data-parsley-validate method="post" action="#">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel2">Add Model</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group" id="errormsg">
                                
                            </div>
                            <div class="form-group">
                                <label for="cateogry">Model Name</label>
                                <input type="hidden" required="required" class="form-control" name="department1" id="department1" placeholder="Enter model">
                                <input type="text" required="required" class="form-control" name="subdepartment" id="subdepartment" placeholder="Enter modal">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="submitSubDep" class="btn btn-primary">Add</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
 <!--add edit category modal-->
        <div class="modal fade editdepartment-modal-lg" id="modelEditDep" tabindex="-2" role="dialog" aria-hidden="false">
            <div class="modal-dialog modal-sm">
                <form role="form" id="editDep" data-parsley-validate method="post" action="#">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel2">Edit Category</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <span class="lab_dep"></span>
                            </div>
                            <div class="form-group">
                                <label for="cateogry"> Name</label>
                                <input type="hidden" required="required" class="form-control" name="edepartment" id="edepartment" value="0">
                                <input type="hidden" required="required" class="form-control" name="esubdepartment" id="esubdepartment" value="0">
                                <input type="hidden" required="required" class="form-control" name="ecategory" id="ecategory" value="0">
                                <input type="hidden" required="required" class="form-control" name="esubcategory" id="esubcategory" value="0">
                                <input type="text" required="required" class="form-control" name="edesc" id="edesc" placeholder="Enter name">
                                <input type="hidden" required="required" class="form-control" name="level" id="level" value="0">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="updateDep" class="btn btn-primary">Update</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
<script type="text/javascript">
      var depcode;
	$("#addDep").submit(function(e) {
            $.ajax({
                type: "post",
                dataType: 'json',
                url: "<?php echo base_url(); ?>" + "admin/master/addMake",
                data: $("#addDep").serialize(),
                success: function(data) {
                    if (data.result == true) {
                        $("#dep").append("<li depCode='" + data.make_id + "' lvl='1' desc='" + data.make + "' class='list-group-item'>" + data.make + " <a class='delete btn btn-default btn-xs pull-right'><i class='fa fa-close'></i></a> <a class='edit btn btn-default btn-xs pull-right'  data-toggle='modal'  data-target='#modelEditDep'><i class='fa fa-pencil'></i></a></li>");
                        $("#department").val('');
                        $("#modelDep").modal('toggle');
                    }
                },
                error: function() {
                    alert('Error while request..');
                }
            });
            e.preventDefault();
        });

    $("#addSubDep").submit(function(e) {
            $.ajax({
                type: "post",
                dataType: 'json',
                url: "<?php echo base_url(); ?>" + "admin/master/addModel",
                data: $(this).serialize(),
                success: function(data) {
                    if (data.result == true) {
                        $("#subDep").append("<li depCode='" + data.makeid + "' lvl='1' desc='" + data.model + "' class='list-group-item'>" + data.model + " <a class='delete btn btn-default btn-xs pull-right'><i class='fa fa-close'></i></a> <a class='edit btn btn-default btn-xs pull-right'  data-toggle='modal'  data-target='#modelEditDep'><i class='fa fa-pencil'></i></a></li>");
                        $("#subdepartment").val('');
                        $("#modelSubDep").modal('toggle');
                    } else if(data.result == 'error'){
                        alert('please select make item first');
                    }
                },
                error: function() {
                    alert('Error while request..');
                }
            });
            e.preventDefault();
        });

$("#dep").on('click', '.edit', function() {
            $("#edepartment").val($(this).parent().attr('depCode'));
            $("#edesc").val($(this).parent().attr('desc'));
            $("#level").val($(this).parent().attr('lvl'));
        });

$("#subDep").on('click', '.edit', function() {
            $("#esubdepartment").val($(this).parent().attr('subDepCode'));
            $("#edesc").val($(this).parent().attr('desc'));
            $("#level").val($(this).parent().attr('lvl'));
            $("#edepartment").val(depcode);
            $("#esubcategory").val(subCatCode);
            $("#ecategory").val(catCode);
        });


var btn = " <a class='delete btn btn-default btn-xs pull-right'><i class='fa fa-close'></i></a><a class='edit btn btn-default btn-xs pull-right'  data-toggle='modal'  data-target='#modelEditDep'><i class='fa fa-pencil'></i></a>";
        $("#editDep").submit(function(e) {
            e.preventDefault();
            var lev = $("#level").val();
                
                $.ajax({
                    type: "post",
                    dataType: 'json',
                    url: "<?php echo base_url(); ?>" + "admin/master/editMake",
                    data: $("#editDep").serialize(),
                    success: function(data) {
                        if (data.result == true) {
                            if (data.level == 1) {
                                $("#dep li[depCode='" + data.id + "']").html(data.value + btn);
                                $("#dep li[depCode='" + data.id + "']").attr('desc', data.value);
                            } else if (data.level == 2) {
                                $("#subDep li[subDepCode='" + data.id + "']").html(data.value + btn);
                                $("#subDep li[subDepCode='" + data.id + "']").attr('desc', data.value);
                            } 
                            $("#modelEditDep").modal('toggle');
                        }
                    },
                    error: function() {
                        alert('Error while request..');
                    }
                });
        });

        $("#dep li").click(function() {
            depcode = ($(this).attr('depCode'));
            $('#department1').val(depcode);
            subDepcode = 0;
            catCode = 0;
            subCatCode = 0;
            $("#dep li").removeClass("active");
            $(this).addClass("active");
            depLbl = $(this).attr('desc');
            $("#subDep").html('');
            $("#cat").html('');
            $("#subCat").html('');
            $.ajax({
                type: "post",
                dataType: 'json',
                url: "<?php echo base_url(); ?>" + "admin/master/getModelMyMake",
                data: {dep: depcode},
                success: function(data) {
                    $.each(data.result, function(key, value) {
                        $("#subDep").append("<li subDepCode='" + value.model_id + "' lvl='2' desc='" + value.model + "' class='list-group-item '>" + value.model + " <a class='delete btn btn-default btn-xs pull-right'><i class='fa fa-close'></i></a> <a class='edit btn btn-default btn-xs pull-right'  data-toggle='modal'  data-target='#modelEditDep'><i class='fa fa-pencil'></i></a></li>");
                    });
                    $('html, body').animate({scrollTop: $('#btnAddSubDep').offset().top}, 'slow');
                },
                error: function() {
                    alert('Error while request..');
                }
            });
        });


</script>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
    <section class="content-header">
        <?php echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
        <span id="location"></span>
    </section>

    <section class="content">
        <div class="box collapse cart-options" id="collapseExample">
            <div class="box-header">Filter Categories</div>
            <div class="box-body categories_dom_wrapper">
            </div>
            <div class="box-footer">
                <button class="btn btn-primary close-item-options pull-right">Hide options</button>
            </div>
        </div>   

        <div class="row">
            <div class="box col-lg-12">

            </div>
            <div class="box col-lg-12" id="catDiv">

                <div class="box-primary col-lg-3">
                    <span id="errTop1" class="pull-right"></span>
                    <div class="box-header">
                        <h4>Department <a type="button" class="btn btn-primary pull-right" data-toggle="modal"  data-target="#modelDep">Add</a></h4><br>
                        <span id="errProduct1" class="pull-right"></span></div>
                    <div class="box-body">
                        <div class="list-group" id="dep">
                            <?php foreach ($department->result() as $row) { ?>
                                <li lvl="1" depCode="<?php echo $row->DepCode; ?>" desc="<?php echo $row->Description; ?>" class="list-group-item "><?php echo $row->Description; ?> <a class="delete btn btn-default btn-xs pull-right"><i class="fa fa-close"></i></a> <a class="edit btn btn-default btn-xs pull-right"  data-toggle="modal"  data-target="#modelEditDep"><i class="fa fa-pencil"></i></a></li>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="box-default col-lg-3">
                    <span id="errTop2" class="pull-right"></span>
                    <div class="box-header">
                        <h4>Sub Department<a type="button" id="btnAddSubDep" class="btn btn-primary pull-right" data-toggle="modal"  data-target="#modelSubDep">Add</a></h4><br>
                        <span id="errProduct2" class="pull-right"></span></div>
                    <div class="box-body">
                        <div class="list-group" id="subDep"></div>
                    </div>
                </div>
                <div class="box-default col-lg-3">
                    <span id="errTop3" class="pull-right"></span>
                    <div class="box-header"> <h4>Category<a type="button"  id="btnAddCat" class="btn btn-primary pull-right" data-toggle="modal"  data-target="#modelCat">Add</a></h4><br>
                        <span id="errProduct3" class="pull-right"></span></div>
                    <div class="box-body"><div class="list-group" id="cat"></div>
                    </div>
                </div>
                <div class="box-default col-lg-3">
                    <span id="errTop4" class="pull-right"></span>
                    <div class="box-header">

                        <h4>Sub Categories<a type="button"  id="btnAddSubCat" class="btn btn-primary pull-right" data-toggle="modal"  data-target="#modelSubCat">Add</a></h4><br>
                        <span id="errProduct4" class="pull-right"></span>
                    </div>
                    <div class="box-body">
                        <div class="list-group" id="subCat"></div>
                    </div>
                </div>

                <style>
                    #dep .list-group-item.active, #dep .list-group-item.active:focus, #dep .list-group-item.active:hover {background-color: #00a65a;}
                    #subDep .list-group-item.active, #dep .list-group-item.active:focus, #dep .list-group-item.active:hover {background-color: #f39c12;}
                    #cat .list-group-item.active, #dep .list-group-item.active:focus, #dep .list-group-item.active:hover {background-color: #dd4b39;}
                    #subCat .list-group-item.active, #dep .list-group-item.active:focus, #dep .list-group-item.active:hover {background-color: #337ab7;}

                </style>


            </div>
        </div>

        <!--add department modal-->
        <div class="modal fade bs-add-department-modal-lg" id="modelDep" tabindex="-1" role="dialog" aria-hidden="false">
            <div class="modal-dialog modal-sm">
                <form role="form" id="addDep" data-parsley-validate method="post" action="#">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel2">Add Department</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="cateogry">Department Name</label>
                                <input type="text" required="required" class="form-control" name="department" id="department" placeholder="Enter department">
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
                            <h4 class="modal-title" id="myModalLabel2">Add Sub Department</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <span class="lab_dep"></span>
                            </div>
                            <div class="form-group">
                                <label for="cateogry">Sub Department Name</label>
                                <input type="hidden" required="required" class="form-control" name="department1" id="department1" placeholder="Enter department">
                                <input type="text" required="required" class="form-control" name="subdepartment" id="subdepartment" placeholder="Enter department">
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
        <!--add category modal-->
        <div class="modal fade category-modal-lg" id="modelCat" tabindex="-2" role="dialog" aria-hidden="false">
            <div class="modal-dialog modal-sm">
                <form role="form" id="addCat" data-parsley-validate method="post" action="#">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel2">Add Category</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <span class="lab_dep"></span>
                            </div>
                            <div class="form-group">
                                <label for="cateogry">Category Name</label>
                                <input type="hidden" required="required" class="form-control" name="department2" id="department2" placeholder="Enter department">
                                <input type="hidden" required="required" class="form-control" name="subdepartment1" id="subdepartment1" placeholder="Enter department">
                                <input type="text" required="required" class="form-control" name="category" id="category" placeholder="Enter category">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="submitCat" class="btn btn-primary">Add</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <!--add sub category modal-->
        <div class="modal fade subcategory-modal-lg" id="modelSubCat" tabindex="-2" role="dialog" aria-hidden="false">
            <div class="modal-dialog modal-sm">
                <form role="form" id="addSubCat" data-parsley-validate method="post" action="#">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel2">Add Sub Category</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <span class="lab_dep"></span>
                            </div>
                            <div class="form-group">
                                <label for="cateogry">Sub Category Name</label>
                                <input type="hidden" required="required" class="form-control" name="department3" id="department3" placeholder="Enter department">
                                <input type="hidden" required="required" class="form-control" name="subdepartment2" id="subdepartment2" placeholder="Enter department">
                                <input type="hidden" required="required" class="form-control" name="category1" id="category1" placeholder="Enter category">
                                <input type="text" required="required" class="form-control" name="subcategory" id="subcategory" placeholder="Enter Sub category">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="submitSubCat" class="btn btn-primary">Add</button>
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
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function() {

        var depcode = 0;
        var subDepcode = 0;
        var catCode = 0;
        var depLbl = '';
        var subDepLbl = '';
        var catLbl = '';
        var subCatCode = 0;



        $("#dep li").click(function() {
            depcode = ($(this).attr('depCode'));
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
                url: "<?php echo base_url(); ?>" + "admin/master/getSubDepByDep",
                data: {dep: depcode},
                success: function(json) {
                    var resultData = JSON.parse(json);
                    $.each(resultData, function(key, value) {
                        $("#subDep").append("<li subDepCode='" + value.SubDepCode + "' lvl='2' desc='" + value.Description + "' class='list-group-item '>" + value.Description + " <a class='delete btn btn-default btn-xs pull-right'><i class='fa fa-close'></i></a> <a class='edit btn btn-default btn-xs pull-right'  data-toggle='modal'  data-target='#modelEditDep'><i class='fa fa-pencil'></i></a></li>");
                    });
                    $('html, body').animate({scrollTop: $('#btnAddSubDep').offset().top}, 'slow');
                },
                error: function() {
                    alert('Error while request..');
                }
            });
        });

        $("#subDep").on('click', 'li', function() {
            subDepcode = ($(this).attr('subDepCode'));
            catCode = 0;
            subCatCode = 0;
            $("#subDep li").removeClass("active");
            $(this).addClass("active");
            subDepLbl = $(this).attr('desc');
            $("#cat").html('');
            $("#subCat").html('');

            $.ajax({
                type: "post",
                url: "<?php echo base_url(); ?>" + "admin/master/getCatByDep",
                data: {dep: depcode, subDep: subDepcode},
                success: function(json) {
                    var resultData = JSON.parse(json);
                    $.each(resultData, function(key, value) {
                        $("#cat").append("<li catCode='" + value.CategoryCode + "' lvl='3' desc='" + value.Description + "' class='list-group-item'>" + value.Description + " <a class='delete btn btn-default btn-xs pull-right'><i class='fa fa-close'></i></a> <a class='edit btn btn-default btn-xs pull-right'  data-toggle='modal'  data-target='#modelEditDep'><i class='fa fa-pencil'></i></a></li>");
                    });
                    $('html, body').animate({scrollTop: $('#btnAddCat').offset().top}, 'slow');
                },
                error: function() {
                    alert('Error while request..');
                }
            });
        });

        $("#cat").on('click', 'li', function() {
            catCode = ($(this).attr('catCode'));
            subCatCode = 0;
            $("#cat li").removeClass("active");
            $(this).addClass("active");
            catLbl = $(this).attr('desc');
            $("#subCat").html('');
            $.ajax({
                type: "post",
                url: "<?php echo base_url(); ?>" + "admin/master/getSubCatByDep",
                data: {dep: depcode, subDep: subDepcode, cat: catCode},
                success: function(json) {
                    var resultData = JSON.parse(json);
                    $.each(resultData, function(key, value) {
                        $("#subCat").append("<li subCatCode='" + value.SubCategoryCode + "' lvl='4' desc='" + value.Description + "' class='list-group-item'>" + value.Description + " <a class='delete btn btn-default btn-xs pull-right'><i class='fa fa-close'></i></a> <a class='edit btn btn-default btn-xs pull-right'  data-toggle='modal'  data-target='#modelEditDep'><i class='fa fa-pencil'></i></a></li>");
                    });
                    $('html, body').animate({scrollTop: $('#btnAddSubCat').offset().top}, 'slow');
                },
                error: function() {
                    alert('Error while request..');
                }
            });
        });

        $("#subCat").on('click', 'li', function() {
            subCatCode = ($(this).attr('subCatCode'));

            $("#subCat li").removeClass("active");
            $(this).addClass("active");
        });

        $("#addDep").submit(function(e) {
            $.ajax({
                type: "post",
                url: "<?php echo base_url(); ?>" + "admin/master/addDep",
                data: $("#addDep").serialize(),
                success: function(json) {
                    var resultData = JSON.parse(json);
                    var feedback = resultData['fb'];
                    var val = resultData['DepCode'];
                    var dec = resultData['Description'];

                    if (feedback == true) {
                        $("#dep").append("<li depCode='" + val + "' lvl='1' desc='" + dec + "' class='list-group-item'>" + dec + " <a class='delete btn btn-default btn-xs pull-right'><i class='fa fa-close'></i></a> <a class='edit btn btn-default btn-xs pull-right'  data-toggle='modal'  data-target='#modelEditDep'><i class='fa fa-pencil'></i></a></li>");
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

        $("#btnAddSubDep").click(function() {
            $(".lab_dep").html(depLbl);
            $("#department1").val(depcode);

        });

        $("#btnAddCat").click(function() {
            $(".lab_dep").html(depLbl + ' > ' + subDepLbl);
            $("#department2").val(depcode);
            $("#subdepartment1").val(subDepcode);
        });

        $("#btnAddSubCat").click(function() {
            $(".lab_dep").html(depLbl + ' > ' + subDepLbl + ' > ' + catLbl);
            $("#department3").val(depcode);
            $("#subdepartment2").val(subDepcode);
            $("#category1").val(catCode);
        });

        $("#addSubDep").submit(function(e) {
            if (depcode == '0' || depcode == '') {
                alert("Please select a department");
            } else {
                $.ajax({
                    type: "post",
                    url: "<?php echo base_url(); ?>" + "admin/master/addSubDep",
                    data: $("#addSubDep").serialize(),
                    success: function(json) {
                        var resultData = JSON.parse(json);
                        var feedback = resultData['fb'];
                        var val = resultData['SubDepCode'];
                        var dec = resultData['Description'];

                        if (feedback == true) {
                            $("#subDep").append("<li subDepCode='" + val + "' lvl='2' desc='" + dec + "' class='list-group-item'>" + dec + " <a class='delete btn btn-default btn-xs pull-right'><i class='fa fa-close'></i></a> <a class='edit btn btn-default btn-xs pull-right'  data-toggle='modal'  data-target='#modelEditDep'><i class='fa fa-pencil'></i></a></li>");
                            $("#subdepartment").val('');
                            $("#modelSubDep").modal('toggle');
                        }
                    },
                    error: function() {
                        alert('Error while request..');
                    }
                });
            }
            e.preventDefault();
        });


        $("#addCat").submit(function(e) {
            if (depcode == '0' || depcode == '') {
                alert("Please select a department");
            } else if (subDepcode == '0' || subDepcode == '') {
                alert("Please select a sub department");
            } else {
                $.ajax({
                    type: "post",
                    url: "<?php echo base_url(); ?>" + "admin/master/addCat",
                    data: $("#addCat").serialize(),
                    success: function(json) {
                        var resultData = JSON.parse(json);
                        var feedback = resultData['fb'];
                        var val = resultData['CategoryCode'];
                        var dec = resultData['Description'];

                        if (feedback == true) {
                            $("#cat").append("<li catCode='" + val + "' lvl='3' desc='" + dec + "'class='list-group-item'>" + dec + " <a class='delete btn btn-default btn-xs pull-right'><i class='fa fa-close'></i></a> <a class='edit btn btn-default btn-xs pull-right'  data-toggle='modal'  data-target='#modelEditDep'><i class='fa fa-pencil'></i></a></li>");
                            $("#category").val('');
                            $("#modelCat").modal('toggle');
                        }
                    },
                    error: function() {
                        alert('Error while request..');
                    }
                });
            }
            e.preventDefault();
        });

        $("#addSubCat").submit(function(e) {
            if (depcode == '0' || depcode == '') {
                alert("Please select a department");
            } else if (subDepcode == '0' || subDepcode == '') {
                alert("Please select a sub department");
            } else if (catCode == '0' || catCode == '') {
                alert("Please select a category");
            } else {
                $.ajax({
                    type: "post",
                    url: "<?php echo base_url(); ?>" + "admin/master/addSubCat",
                    data: $("#addSubCat").serialize(),
                    success: function(json) {
                        var resultData = JSON.parse(json);
                        var feedback = resultData['fb'];
                        var val = resultData['SubCategoryCode'];
                        var dec = resultData['Description'];

                        if (feedback == true) {
                            $("#subCat").append("<li subCatCode='" + val + "' lvl='4' desc='" + dec + "' class='list-group-item'>" + dec + " <a class='delete btn btn-default btn-xs pull-right'><i class='fa fa-close'></i></a> <a class='edit btn btn-default btn-xs pull-right'  data-toggle='modal'  data-target='#modelEditDep'><i class='fa fa-pencil'></i></a></li>");
                            $("#subcategory").val('');
                            $("#modelSubCat").modal('toggle');
                        }
                    },
                    error: function() {
                        alert('Error while request..');
                    }
                });
            }
            e.preventDefault();
        });

        $("#dep").on('click', '.edit', function() {
            $("#edepartment").val($(this).parent().attr('depCode'));
            $("#edesc").val($(this).parent().attr('desc'));
            $("#level").val($(this).parent().attr('lvl'));
            $("#esubdepartment").val(subDepcode);
            $("#esubcategory").val(subCatCode);
            $("#ecategory").val(catCode);
        });

        $("#subDep").on('click', '.edit', function() {
            $("#esubdepartment").val($(this).parent().attr('subDepCode'));
            $("#edesc").val($(this).parent().attr('desc'));
            $("#level").val($(this).parent().attr('lvl'));
            $("#edepartment").val(depcode);
            $("#esubcategory").val(subCatCode);
            $("#ecategory").val(catCode);
        });

        $("#cat").on('click', '.edit', function() {
            $("#ecategory").val($(this).parent().attr('catCode'));
            $("#edesc").val($(this).parent().attr('desc'));
            $("#level").val($(this).parent().attr('lvl'));
            $("#edepartment").val(depcode);
            $("#esubcategory").val(subCatCode);
            $("#esubdepartment").val(subDepcode);
        });

        $("#subCat").on('click', '.edit', function() {
            $("#esubcategory").val($(this).parent().attr('subCatCode'));
            $("#edesc").val($(this).parent().attr('desc'));
            $("#level").val($(this).parent().attr('lvl'));
            $("#edepartment").val(depcode);
            $("#ecategory").val(catCode);
            $("#esubdepartment").val(subDepcode);
        });

        $("#dep").on('click', '.delete', function(e) {
            $("#edepartment").val($(this).parent().attr('depCode'));
            $("#edesc").val($(this).parent().attr('desc'));
            $("#level").val($(this).parent().attr('lvl'));
            $("#esubdepartment").val(subDepcode);
            $("#esubcategory").val(subCatCode);
            $("#ecategory").val(catCode);
            var dep = $(this).parent().attr('depCode');
            var r = confirm('Do you want to delete this sub category?');
            if (r === true) {

                $.ajax({
                    type: "post",
                    url: "<?php echo base_url(); ?>" + "admin/master/deleteDep",
                    data: $("#editDep").serialize(),
                    success: function(json) {
                        var resultData = JSON.parse(json);
                        var feedback = resultData['fb'];
                        var dec = resultData['Description'];
                        var lvl = resultData['level'];

                        if (feedback != false) {
                            if (feedback == 2) {
                                $("#errProduct1").show();
                                $('html, body').animate({scrollTop: $('#errTop1').offset().top}, 'slow');
                                $("#errProduct1").html('Can not delete this. This sub category has sub category.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                                return false;
                            } else if (feedback == 3) {
                                $("#errProduct1").show();
                                $('html, body').animate({scrollTop: $('#errTop1').offset().top}, 'slow');
                                $("#errProduct1").html('Can not delete this. This sub category has linked with product.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                                return false;
                            } else if (feedback == 1) {
                                $("#dep").find("[depcode='" + dep + "']").remove();
                            }

                        }
                    },
                    error: function() {
                        alert('Error while request..');
                    }
                });
            } else {

            }
            e.preventDefault();
        });

        $("#subDep").on('click', '.delete', function(e) {
            $("#esubdepartment").val($(this).parent().attr('subDepCode'));
            $("#edesc").val($(this).parent().attr('desc'));
            $("#level").val($(this).parent().attr('lvl'));
            $("#edepartment").val(depcode);
            $("#esubcategory").val(subCatCode);
            $("#ecategory").val(catCode);
            var subdep = $(this).parent().attr('subDepCode');
            var r = confirm('Do you want to delete this sub category?');
            if (r === true) {

                $.ajax({
                    type: "post",
                    url: "<?php echo base_url(); ?>" + "admin/master/deleteDep",
                    data: $("#editDep").serialize(),
                    success: function(json) {
                        var resultData = JSON.parse(json);
                        var feedback = resultData['fb'];
                        var dec = resultData['Description'];
                        var lvl = resultData['level'];

                        if (feedback != false) {
                            if (feedback == 2) {
                                $("#errProduct2").show();
                                $('html, body').animate({scrollTop: $('#errTop2').offset().top}, 'slow');
                                $("#errProduct2").html('Can not delete this. This sub category has sub category.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                                return false;
                            } else if (feedback == 3) {
                                $("#errProduct2").show();
                                $('html, body').animate({scrollTop: $('#errTop2').offset().top}, 'slow');
                                $("#errProduct2").html('Can not delete this. This sub category has linked with product.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                                return false;
                            } else if (feedback == 1) {
                                $("#subDep").find("[subdepcode='" + subdep + "']").remove();
                            }
                        }
                    },
                    error: function() {
                        alert('Error while request..');
                    }
                });
            } else {

            }
            e.preventDefault();
        });

        $("#cat").on('click', '.delete', function(e) {
            $("#ecategory").val($(this).parent().attr('catCode'));
            $("#edesc").val($(this).parent().attr('desc'));
            $("#level").val($(this).parent().attr('lvl'));
            $("#edepartment").val(depcode);
            $("#esubcategory").val(subCatCode);
            $("#esubdepartment").val(subDepcode);
            var cat = $(this).parent().attr('catCode');
            var r = confirm('Do you want to delete this sub category?');
            if (r === true) {

                $.ajax({
                    type: "post",
                    url: "<?php echo base_url(); ?>" + "admin/master/deleteDep",
                    data: $("#editDep").serialize(),
                    success: function(json) {
                        var resultData = JSON.parse(json);
                        var feedback = resultData['fb'];
                        var dec = resultData['Description'];
                        var lvl = resultData['level'];

                        if (feedback != false) {
                            if (feedback == 2) {
                                $("#errProduct3").show();
                                $('html, body').animate({scrollTop: $('#errTop3').offset().top}, 'slow');
                                $("#errProduct3").html('Can not delete this. This sub category has sub category.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                                return false;
                            } else if (feedback == 3) {
                                $("#errProduct3").show();
                                $('html, body').animate({scrollTop: $('#errTop3').offset().top}, 'slow');
                                $("#errProduct3").html('Can not delete this. This sub category has linked with product.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                                return false;
                            } else if (feedback == 1) {
                                $("#cat").find("[catcode='" + cat + "']").remove();
                            }
                        }
                    },
                    error: function() {
                        alert('Error while request..');
                    }
                });
            } else {

            }
            e.preventDefault();
        });

        $("#subCat").on('click', '.delete', function(e) {
            $("#esubcategory").val($(this).parent().attr('subCatCode'));
            $("#edesc").val($(this).parent().attr('desc'));
            $("#level").val($(this).parent().attr('lvl'));
            $("#edepartment").val(depcode);
            $("#ecategory").val(catCode);
            $("#esubdepartment").val(subDepcode);
            var subcat = $(this).parent().attr('subCatCode');
            var r = confirm('Do you want to delete this sub category?');
            if (r === true) {

                $.ajax({
                    type: "post",
                    url: "<?php echo base_url(); ?>" + "admin/master/deleteDep",
                    data: $("#editDep").serialize(),
                    success: function(json) {
                        var resultData = JSON.parse(json);
                        var feedback = resultData['fb'];
                        var dec = resultData['Description'];
                        var lvl = resultData['level'];

                        if (feedback != false) {
                            if (feedback == 2) {
                                $("#errProduct4").show();
                                $('html, body').animate({scrollTop: $('#errTop4').offset().top}, 'slow');
                                $("#errProduct4").html('Can not delete this. This sub category has sub category.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                                return false;
                            } else if (feedback == 3) {
                                $("#errProduct4").show();
                                $('html, body').animate({scrollTop: $('#errTop4').offset().top}, 'slow');
                                $("#errProduct4").html('Can not delete this. This sub category has linked with product.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                                return false;
                            } else if (feedback == 1) {
                                $("#subCat").find("[subcatcode='" + subcat + "']").remove();
                            }
                        }
                    },
                    error: function() {
                        alert('Error while request..');
                    }
                });
            } else {
            }
            e.preventDefault();
        });

        var btn = "<a class='edit btn btn-default btn-xs pull-right'  data-toggle='modal'  data-target='#modelEditDep'><i class='fa fa-pencil'></i></a>";
        $("#editDep").submit(function(e) {
            var lev = $("#level").val();
            if (lev == 1 && (depcode == '0' || depcode == '')) {
                alert("Please select a department");
            } else { 
                $.ajax({
                    type: "post",
                    url: "<?php echo base_url(); ?>" + "admin/master/editDep",
                    data: $("#editDep").serialize(),
                    success: function(json) {
                        var resultData = JSON.parse(json);
                        var feedback = resultData['fb'];
                        var dec = resultData['Description'];
                        var lvl = resultData['level'];

                        if (feedback == true) {
                            if (lvl == 1) {
                                $("#dep li[depCode='" + depcode + "']").html(dec + btn);
                                $("#dep li[depCode='" + depcode + "']").attr('desc', dec);
                            } else if (lvl == 2) {
                                $("#subDep li[subDepCode='" + subDepcode + "']").html(dec + btn);
                                $("#subDep li[subDepCode='" + subDepcode + "']").attr('desc', dec);
                            } else if (lvl == 3) {
                                $("#cat li[catCode='" + catCode + "']").html(dec + btn);
                                $("#cat li[catCode='" + catCode + "']").attr('desc', dec);
                            } else if (lvl == 4) {
                                $("#subCat li[subCatCode='" + subCatCode + "']").html(dec + btn);
                                $("#subCat li[subCatCode='" + subCatCode + "']").attr('desc', dec);
                            }
                            $("#modelEditDep").modal('toggle');
                        }
                    },
                    error: function() {
                        alert('Error while request..');
                    }
                });
            }
            e.preventDefault();
        });

    });
</script>

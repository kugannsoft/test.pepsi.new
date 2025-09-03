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
                <div class="box box-default">
                    <div class="box-body">
                     <form id="filterform">
                        <div class="row">
                                <div class="col-md-4">
                                    <select class="form-control" name="productsearch" id="productsearch">
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="isall" class="control-label">
                                            <input class="rpt_icheck" type="checkbox" name="isall"> 
                                            All
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" name="route" id="route">
                                        <option value="">--select location--</option>
                                        <?php foreach ($locations AS $loc) { ?>
                                            <option value="<?php echo $loc->location_id ?>"><?php echo $loc->location ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-flat btn-success">Show</button>
                                </div>
                            
                            <div class="col-md-1">
                                <button onclick="printdiv()" class="btn btn-flat btn-default">Print</button>
                            </div>
                        </div>
                        <div class="row">
                            
                                <div class="col-md-3">
                                    <select class="form-control" name="department" id="department">
                                        <option value="">--select a department--</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select class="form-control" name="subdepartment" id="subdepartment">
                                            <option value="">--select a sub department--</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-md-3" >
                                    <select class="form-control" style="display:none;" name="supplier" id="supplier">
                                        <option value="">--select a supplier--</option>
                                    </select>
                                    <!--<button type="reset" class="btn btn-flat btn-danger">Reset</button>-->
                                </div>
                            <div class="col-md-3">
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-body table-responsive">
                        <table id="saletable" class="table table-bordered table-hover">
                            <thead>
                                <tr style="font-size: large">
                                    <td>id</td>
                                    <td>Product Code</td>
                                    <td>Product Name</td>
                                    <td>Location</td>
                                    <td>Stock</td>
                                    <td>Cost Price</td>
                                    <td>Price</td>
                                    <td>Supplier</td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>


                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--print view modal-->
        <div id="salesbydateprint" class="modal fade bs-add-category-modal-lg" tabindex="-1" role="dialog" aria-hidden="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- load data -->
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $('.rpt_icheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '50%'
    });
    $("#productsearch").select2({
        ajax: {
            url: "productjson",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        minimumInputLength: 2
    });

$("#supplier").select2({
        placeholder: "Select a supplier",
        allowClear: true,
        ajax: {
            url: "supplierjson",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        minimumInputLength: 2
    });
    
    $("#department").select2({
        placeholder: "Select a Department",
        allowClear: true,
        ajax: {
            url: "departmentjson",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        minimumInputLength: 2
    });
     $("#department").change(function(){
         dep = $("#department option:selected").val();
         $("#subdepartment").select2('val','');

     });
    
    $("#subdepartment").select2({
        placeholder: "Select a Sub Department",
        allowClear: true,
        ajax: {
            url: "subdepartmentjson",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    dep :dep
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        minimumInputLength: 2
    });


    $('#filterform').submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: "loadreport5",
            data: $(this).serialize(),
            success: function (data) {
                $('#saletable tbody').empty();
                drawTable(JSON.parse(data));
            }
        });
    });
    function drawTable(data) {
       $.each(data, function(key, value) {
            $("#saletable").append("<tr style='background-color:#00a678;color:#fff;'><td colspan='9'><b>"+key+"</b></td></tr>");

            for (var i = 0; i < value.length; i++) {
                drawRow(value,i);
            }
        });
    }
    function drawRow(rowData, index) {
        if(rowData[index].Stock < 1){
            var row = $("<tr class='stockout'>");
        }else{
            var row = $("<tr>");
        }
        $("#saletable").append(row);
        row.append($("<td>" + (index + 1) + "</td>"));
        row.append($("<td>" + rowData[index].ProductCode + "</td>"));
        row.append($("<td>" + rowData[index].Prd_Description + "</td>"));
        row.append($("<td>" + rowData[index].location + "</td>"));
        row.append($("<td>" + rowData[index].Stock + "</td>"));
        row.append($("<td>" + rowData[index].Prd_CostPrice + "</td>"));
        row.append($("<td>" + rowData[index].Price + "</td>"));
        row.append($("<td>" + rowData[index].SupName + "</td>"));

    }
    function printdiv() {
        $("#saletable").print({
            prepend: "<h3 style='text-align:center'>Product Detail Report</h3><hr/>",
            title: 'Date vise Sales Report'
        });
    }
</script>
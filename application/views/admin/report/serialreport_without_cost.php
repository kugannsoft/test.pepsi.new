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
                        <div class="row">
                            <form id="filterform">
                                <div class="row">

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="transfer" class="control-label">
                                                <input class="rpt_icheck" type="checkbox" name="transfer" value="transfer">
                                                Transfer
                                            </label>
                                        </div>

                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="form-control" name="productsearch" id="productsearch">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="isall" class="control-label">
                                                <input class="rpt_icheck" type="radio" name="isall" value="all" checked>
                                                All
                                            </label>&nbsp;&nbsp;&nbsp;<label for="isall" class="control-label">
                                                <input class="rpt_icheck" type="radio" name="isall" value="1">
                                                Plus
                                            </label>&nbsp;&nbsp;&nbsp;<label for="isall" class="control-label">
                                                <input class="rpt_icheck" type="radio" name="isall" value="0">
                                                Zero Stock
                                            </label>
                                        </div>

                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select class="form-control" name="route" id="route" multiple>
                                                <option value="">--select location--</option>
                                                <?php foreach ($locations AS $loc) { ?>
                                                    <option value="<?php echo $loc->location_id ?>"><?php echo $loc->location ?></option>
                                                <?php } ?>
                                            </select>
                                            <input type="hidden" name="route_ar" id="route_ar">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-flat btn-success">Show</button>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <button onclick="printdiv()" class="btn btn-flat btn-default">Print</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="form-control" name="department" id="department" multiple>
                                                <option value="">--select a department--</option>
                                            </select>
                                            <input type="hidden" name="dep_ar" id="dep_ar">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="form-control" name="subdepartment" id="subdepartment" multiple>
                                                <option value="">--select a sub department--</option>
                                            </select>
                                            <input type="hidden" name="subdep_ar" id="subdep_ar">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="form-control" name="subcategory" id="subcategory" multiple>
                                                <option value="">--select a sub category--</option>
                                            </select>
                                            <input type="hidden" name="subcategory_ar" id="subcategory_ar">
                                        </div>
                                    </div>
                                    <div class="col-md-3" >
                                        <select class="form-control" style="display:none;" name="supplier" id="supplier">
                                            <option value="">--select a supplier--</option>
                                        </select>
                                        <!--<button type="reset" class="btn btn-flat btn-danger">Reset</button>-->
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-body">
                        <table id="saletable" class="table table-bordered">
                            <thead>
                            <tr style="font-size: large">
                                <td>id</td>
                                <td>GRN Date</td>
                                <td>Product Code</td>
                                <td>Product Name</td>
                                <td>Serial</td>
                                <td>Location</td>
                                <td>Stock</td>
<!--                                <td>Cost Price</td>-->
                                <td>Supplier</td>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td ></td>
                                <td><b>Total</b></td>
                                <td></td>
                                <td id="totalstock"></td>
<!--                                <td id="totalcost"></td>-->
                                <td></td>

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
    $("#subcategory").select2({
        placeholder: "Select a model"
    });

    $("#department").select2({
        placeholder: "Select a department"
    });
    $("#subdepartment").select2({
        placeholder: "Select a sub department"
    });

    $("#route").select2({
        placeholder: "Select a location"
    });

    var loc =[];
    $("#route").change(function(){
        loc.length=0;

        $("#route :selected").each(function(){
            loc.push($(this).val());
        });
        $("#route_ar").val(JSON.stringify(loc));
    });


    var sub =[];
    var depArr =[];
    var subdepArr =[];
    $("#subcategory").change(function(){
        sub.length=0;

        $("#subcategory :selected").each(function(){
            sub.push($(this).val());
        });
        $("#subcategory_ar").val(JSON.stringify(sub));
    });

    $('.rpt_icheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '50%'
    });
    var dep = 0;
    var subdep = 0;
    $("#productsearch").select2({
        placeholder: "Select a product",
        allowClear: true,
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
        depArr.length=0;

        $("#department :selected").each(function(){
            depArr.push($(this).val());
        });
        if(depArr.length==0){
            $("#dep_ar").val('');
        }else{
            $("#dep_ar").val(JSON.stringify(depArr));
        }

    });

    $("#subdepartment").change(function(){
        subdep = $("#subdepartment option:selected").val();
        $("#subcategory").select2('val','');
        subdepArr.length=0;

        $("#subdepartment :selected").each(function(){
            subdepArr.push($(this).val());
        });

        if(subdepArr.length==0){
            $("#subdep_ar").val('');
        }else{
            $("#subdep_ar").val(JSON.stringify(subdepArr));
        }
    });




    $("#subdepartment").select2({
        placeholder: "Select a Sub Department",
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

    $("#subcategory").select2({
        placeholder: "Select a sub Category",
        allowClear: true,
        ajax: {
            url: "subcategoryjson",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    dep :dep,
                    subdep :subdep
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
            url: "loadreport4",
            data: $(this).serialize(),
            success: function (data) {
                $('#saletable tbody').empty();
                drawTable(JSON.parse(data));
            }
        });
    });
    var totalCostValue=0;
    var totalStock=0;

    function drawTable(data) {
        totalCostValue = 0;
        totalStock=0;
        $("#totalcost").html(0);
        $("#totalstock").html(0);

        $.each(data, function(key, value) {
            var t=0;
            $("#saletable").append("<tr style='background-color:#00a678;color:#fff;'><td colspan='13'><b>"+key+"</b></td></tr>");

            for (var i = 0; i < value.length; i++) {

                drawRow(value,i);
                totalStock+=(parseFloat(value[i].Quantity));
                totalCostValue+=parseFloat((value[i].Prd_CostPrice)*(value[i].Quantity));
                $("#totalcost").html(accounting.formatMoney(totalCostValue));
                $("#totalstock").html(accounting.formatMoney(totalStock));

            }
        });
    }
    function drawRow(rowData,index) {
        var row = $("<tr/>");
        $("#saletable").append(row);
        var date = new Date(rowData[index].GRN_DateORG);
        row.append($("<td>" + (index+1) + "</td>"));
        row.append($("<td>" + formatDate(date) + "</td>"));
        row.append($("<td>" + rowData[index].ProductCode + "</td>"));
        row.append($("<td>" + rowData[index].Prd_Description + "</td>"));
        row.append($("<td>" + rowData[index].SerialNo + "</td>"));
        row.append($("<td>" + rowData[index].location + "</td>"));
        row.append($("<td>" + rowData[index].Quantity + "</td>"));
        row.append($("<td>" + rowData[index].SupName + "</td>"));

    }
    function printdiv() {
        $("#saletable").print({
            prepend: "<h3 style='text-align:center'>Product Detail Report</h3><hr/>",
            title: 'Date vise Sales Report'
        });
    }

    function formatDate(date) {
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var day = date.getDate();
        var month = (date.getMonth()+1);
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12;
        hours = hours <10 ? '0'+hours : hours;
        day = day <10 ? '0'+day : day;
        month = month <10 ? '0'+month : month;
        minutes = minutes < 10 ? '0'+minutes : minutes;
        var strTime = hours + ':' + minutes + ' ' + ampm;
        return  date.getFullYear()+"-"+ month + "-" + day + " " + strTime;
    }
</script>
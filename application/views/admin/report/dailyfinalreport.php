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
                        <form id="filterform"><div class="row">
                            
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <div class="input-daterange input-group" id="datepicker">
                                        <input type="text" class="form-control" name="startdate" />
                                        <span class="input-group-addon">to</span>
                                        <input type="text" class="form-control" name="enddate" />
                                    </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                    <select class="form-control" name="route" id="route">
                                        <option value="">--select location--</option>
                                        <?php foreach ($locations AS $loc) { ?>
                                            <option value="<?php echo $loc->location_id ?>"><?php echo $loc->location ?></option>
                                        <?php } ?>
                                    </select></div>
                                </div>
                                <div class="col-md-3" >
                                    <div class="form-group">
                                    <select class="form-control" name="product" id="product" >
                                        <option value="">--select product--</option>
                                        <?php foreach ($products AS $prd) { ?>
                                        <option value="<?php echo $prd->ProductCode ?>"><?php echo $prd->Prd_Description; ?></option>
                                        <?php } ?>
                                    </select></div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-flat btn-success">Show</button></div>
                                </div>
                            
                            <div class="col-md-1">
                                <div class="form-group">
                                    <button onclick="printdiv()" class="btn btn-flat btn-default">Print</button></div>
                            </div>
                        </div>
                        <div class="row">
                            
                                <div class="col-md-3">
                                    <div class="form-group">
                                    <select class="form-control" name="department" id="department">
                                        <option value="">--select a department--</option>
                                    </select></div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select class="form-control" name="subdepartment" id="subdepartment">
                                            <option value="">--select a sub department--</option>
                                    </select>
                                    </div>
                                </div>
                             <div class="col-md-3">
                                    <div class="form-group">
                                        <select class="form-control" name="subcategory" id="subcategory">
                                            <option value="">--select a sub category--</option>
                                    </select>
                                    </div>
                                </div>
                            <div class="col-md-3" style="display: none;" >
                                <div class="form-group">
                                    <select class="form-control"  name="supplier" id="supplier">
                                        <option value="">--select a supplier--</option>
                                    </select>
                                </div>
                                    <!--<button type="reset" class="btn btn-flat btn-danger">Reset</button>-->
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
                        <table id="saletable" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <td>Date</td>
                                    <td>Prd</td>
                                    <td>Name</td>
                                    <td>S IN</td>
                                    <td>V IN</td>
                                    <td>N IN</td>
                                    <td>P IN</td>
                                    <td>H IN</td>
                                    <td>S Out</td>
                                    <td>V Out</td>
                                    <td>N Out</td>
                                    <td>P Out</td>
                                    <td>H Out</td>
                                    <td>Sales</td>
                                    <td>GRN</td>
                                    <td>Stock</td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th id="costpr" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="unitpr" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="qty" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="qty2" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="qty3" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="qty4" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="qty5" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="qty6" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="qty7" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="qty8" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="freeqty" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="costval" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="discount" style="text-align: right;color: #00aaf1;"></th>
<!--                                    <th id="netamount" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="returnqty" style="text-align: right;color: #00aaf1;"></th>-->
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
    $('.input-daterange').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    
    $('#product').select2();
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
    
     $("#subdepartment").change(function(){
         subdep = $("#subdepartment option:selected").val();
         $("#subcategory").select2('val','');

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
            url: "loadreport6",
            data: $(this).serialize(),
            success: function (data) {
                $('#saletable tbody').empty();
                drawTable(JSON.parse(data));
                $('#costpr').html(accounting.formatMoney(sumcolumn('invcostpr')));
                $('#unitpr').html(accounting.formatMoney(sumcolumn('invunitpr')));
                $('#qty').html(accounting.formatMoney(sumcolumn('qty')));
                $('#qty2').html(accounting.formatMoney(sumcolumn('qty2')));
                $('#qty3').html(accounting.formatMoney(sumcolumn('qty3')));
                $('#qty4').html(accounting.formatMoney(sumcolumn('qty4')));
                $('#qty5').html(accounting.formatMoney(sumcolumn('qty5')));
                $('#qty6').html(accounting.formatMoney(sumcolumn('qty6')));
                $('#qty7').html(accounting.formatMoney(sumcolumn('qty7')));
                $('#qty8').html(accounting.formatMoney(sumcolumn('qty8')));
                $('#freeqty').html(accounting.formatMoney(sumcolumn('freeqty')));
                $('#costval').html(accounting.formatMoney(sumcolumn('grn_qty')));
                $('#discount').html(accounting.formatMoney(sumcolumn('returnamount')));
                
            }
        })
    });

    function drawTable(data) {

        $.each(data, function(key, value) {
$("#saletable").append("<tr style='background-color:#00a678;color:#fff;'><td colspan='16'><b>"+key+"</b></td></tr>");
        for (var i = 0; i < value.length; i++) {
            drawRow(value[i]);
        
    }
    
        });
    }
    function drawRow(rowData) {
        var row = $("<tr/>");
        $("#saletable").append(row);
        row.append($("<td>" + rowData.RDate + "</td>"));
        row.append($("<td>" + rowData.ProductCode + "</td>"));
        row.append($("<td>" + rowData.ProductName + "</td>"));
        row.append($("<td class='invcostpr' align='right'>" + accounting.formatMoney(rowData.L1IN) + "</td>"));
        row.append($("<td class='invunitpr' align='right'>" + accounting.formatMoney(rowData.L2IN) + "</td>"));
        row.append($("<td class='qty' align='right'>" + accounting.formatMoney(rowData.L3IN) + "</td>"));
        row.append($("<td class='qty2' align='right'>" + accounting.formatMoney(rowData.L4IN) + "</td>"));
        row.append($("<td class='qty3' align='right'>" + accounting.formatMoney(rowData.L5IN) + "</td>"));
        row.append($("<td class='qty4' align='right'>" + accounting.formatMoney(rowData.L1OUT) + "</td>"));
        row.append($("<td class='qty5' align='right'>" + accounting.formatMoney(rowData.L2OUT) + "</td>"));
        row.append($("<td class='qty6' align='right'>" + accounting.formatMoney(rowData.L3OUT) + "</td>"));
        row.append($("<td class='qty7' align='right'>" + accounting.formatMoney(rowData.L4OUT) + "</td>"));
        row.append($("<td class='qty8' align='right'>" + accounting.formatMoney(rowData.L5OUT) + "</td>"));
        row.append($("<td class='freeqty' align='right'>" + accounting.formatMoney(rowData.SALES_QTY) + "</td>"));
        row.append($("<td class='grn_qty' align='right'>" + accounting.formatMoney(rowData.GRN_QTY) + "</td>"));
        row.append($("<td class='returnamount' align='right'>" + accounting.formatMoney(rowData.STOCK) + "</td>"));
    }
    function sumcolumn(rclass) {
        var sum = 0;
        var elemnt = document.getElementsByClassName(rclass);
        $(elemnt).each(function () {
            var value = accounting.unformat($(this).text());

            if (!isNaN(value) && value.length != 0) {
                sum += parseFloat(value);
            }
        });
        return sum;
    }

    function loadprint() {
        $('.modal-content').load('<?php echo base_url() ?>admin/report/', function (result) {
            $('#salesbydateprint').modal({show: true});
        });
    }
    function printdiv() {
        $("#saletable").print({
            prepend: "<h3 style='text-align:center'>Product vise Sales Report</h3><hr/>",
            title: 'Date vise Sales Report'
        });
    }
    
    
</script>
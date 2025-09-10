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
                                    <div class="form-group">
                                    <select class="form-control" name="productsearch" id="productsearch">
                                    </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="isall" class="control-label">
                                            <input class="rpt_icheck" type="checkbox" name="isall"> 
                                            All
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
                                <div class="col-md-2">
                                     <div class="form-group">
                                    <button type="submit" class="btn btn-flat btn-success">Show</button>
                                     </div>
                                </div>
                               <div class="col-md-2">
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
                               
                        </div></form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-body  table-responsive">
                        <table id="saletable" class="table table-bordered  table-hover table-fixed">
                            <thead>
                                <tr style="font-size: large">
                                    <td>id</td>
                                    <td>Product Code</td>
                                    <td>Product Name</td>
                                    <td>Location</td>
                                    <td>Stock</td>
                                    <td>ROL</td>
                                    <td>ROQ</td>
                                    <td>Cost Price</td>
                                    <td>Selling Price</td>
                                    <td>Total Value</td>
                                    <td>Cost Value</td>
                                    <td>Estimate Profit</td>
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
                                    <td><b>Total</b></td>
                                    <td id="totalstock"></td>
                                    <td></td>
                                    <td></td>
                                    <td colspan="2"></td>
                                    <td id="totalvalue"></td>
                                    <td id="totalcost"></td>
                                    <td id="totalprofit"></td>
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
            url: "loadreport3",
            data: $(this).serialize(),
            success: function (data) {
                $('#saletable tbody').empty();
                drawTable(JSON.parse(data));
               
            }
        });
    });
     var totalCostValue=0;
     var totalValue=0;
     var totalProfit=0;
    function drawTable(data) {
        totalCostValue = 0;
        totalValue=0;
      totalProfit=0;
       totalStock=0;
        $("#totalcost").html(0);
        $("#totalvalue").html(0);
        $("#totalprofit").html(0);
        $("#totalstock").html(0);
        $.each(data, function(key, value) {
            $("#saletable").append("<tr style='background-color:#00a678;color:#fff;'><td colspan='13'><b>"+key+"</b></td></tr>");

            for (var i = 0; i < value.length; i++) {
                drawRow(value,i);
                 totalStock+=(parseFloat(value[i].Stock));
                 totalCostValue+=((value[i].Prd_CostPrice)*(value[i].Stock));
                 totalValue+=((value[i].ProductPrice)*(value[i].Stock));
                 totalProfit+=((value[i].ProductPrice)*(value[i].Stock))-((value[i].Prd_CostPrice)*(value[i].Stock));
                 $("#totalcost").html(accounting.formatMoney(totalCostValue));
                 $("#totalvalue").html(accounting.formatMoney(totalValue));
                 $("#totalprofit").html(accounting.formatMoney(totalProfit));
                 $("#totalstock").html(accounting.formatMoney(totalStock));
            }         
        });
    }
    
    
    function drawRow(rowData,index) {
    
       if(parseFloat(rowData[index].Stock) < rowData[index].Prd_ROL){
           var row = $("<tr class='stockout'>");
        }else{
            var row = $("<tr>");
        }

        $("#saletable").append(row);
        row.append($("<td>" + (index+1) + "</td>"));
        row.append($("<td>" + rowData[index].ProductCode + "</td>"));
        row.append($("<td>" + rowData[index].Prd_Description + "</td>"));
        row.append($("<td>" + rowData[index].location + "</td>"));
        row.append($("<td>" + rowData[index].Stock + "</td>"));
        row.append($("<td>" + rowData[index].Prd_ROL + "</td>"));
        row.append($("<td>" + rowData[index].Prd_ROQ + "</td>"));
        row.append($("<td>" + rowData[index].Prd_CostPrice + "</td>"));
        row.append($("<td>" + rowData[index].ProductPrice + "</td>"));
        row.append($("<td>" + accounting.formatMoney(rowData[index].ProductPrice*rowData[index].Stock) + "</td>"));
        row.append($("<td>" + accounting.formatMoney(rowData[index].Prd_CostPrice*rowData[index].Stock) + "</td>"));
        row.append($("<td>" + accounting.formatMoney((rowData[index].ProductPrice*rowData[index].Stock)-(rowData[index].Prd_CostPrice*rowData[index].Stock)) + "</td>"));
        row.append($("<td>" + rowData[index].SupName + "</td>"));
    }
    function printdiv() {
        $("#saletable").print({
            prepend: "<h3 style='text-align:center'>Product Detail Report</h3><hr/>",
            title: 'Date vise Sales Report'
        });
    }
    
</script>

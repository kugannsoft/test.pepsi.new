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
                                <div class="row" style="margin-left: 300px;">

                                    <div class="col-md-4">
                                        <div class="input-daterange input-group" id="datepicker">
                                            <input type="text" class="form-control" name="startdate"  value="<?php echo date("Y-m-d") ?>"/>
                                            <span class="input-group-addon">to</span>
                                            <input type="text" class="form-control" name="enddate"  value="<?php echo date("Y-m-d") ?>"/>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-md-1">
                                        <button type="submit" class="btn btn-flat btn-success">Show</button>
                                    </div>
                                     <div class="col-md-1">
                                        <button onclick="printdiv()" class="btn btn-flat btn-default">Print</button>
                                    </div>
                                </div>
                                <div class="row">

                                    
                                   
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
                    <div class="box-body table-responsive">
                        <table id="saletable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <td>Date</td>
                                    <td>Inv. No</td>
                                    <td>Prd. Code</td>
                                    <td>Name</td>
                                    <!-- <td>Cost Price</td> -->
                                    <td>Unit Price</td>
                                    <td>Qty</td>
                                    <td>Free Qty</td>
                                    <td>Cost Value</td>
                                    <td>Discount</td>
                                    <td>net Amount</td>
                                    <td>Profit</td>
                                    <!--<td>Return Qty</td>-->
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <!-- <th id="costpr" style="text-align: right;color: #00aaf1;"></th> -->
                                    <th id="unitpr" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="qty" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="freeqty" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="costval" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="discount" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="netamount" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="profit" style="text-align: right;color: #00aaf1;"></th>
                                    <!--<th id="returnqty" style="text-align: right;color: #00aaf1;"></th>-->
                                </tr>

                                <!-- <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th colspan="2" style="text-align: right;">Cash Balance</th>
                                    <th id="cash" style="text-align: right;color: #00aaf1;"></th>
                                    <th style="text-align: right;color: #00aaf1;"></th>
                                </tr> -->
                               
                                <tr>
                                    <!-- <th></th>
                                    <th></th>-->
                                    <th></th> 
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th  colspan="2" style="text-align: right;">Total Sale</th>
                                    <th id="nsale" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="nprofit" style="text-align: right;color: #00aaf1;"></th>
                                </tr>
                                 <tr>
                                    <!-- <th></th>
                                    <th></th>-->
                                    <th></th> 
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                   <th colspan="2" style="text-align: right;">Total Item Discount</th>
                                    <th id="toDis" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="toDis2" style="text-align: right;color: #00aaf1;"></th>
                                </tr>
                                <tr>
                                   
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th  colspan="2" style="text-align: right;">Expenses(-)</th>
                                    <th id="expense" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="expense2"  style="text-align: right;color: #00aaf1;"></th>
                                </tr>
                                <tr>
                              
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th  colspan="2" style="text-align: right;">Earning(+)</th>
                                    <th id="earning" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="earning2" style="text-align: right;color: #00aaf1;"></th>
                                </tr>
                                <tr>
                                    <!-- <th></th>
                                    <th></th>-->
                                    <th></th> 
                                    <th></th>
                                    <th></th><th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th  colspan="2" style="text-align: right;">Net Sale</th>
                                    <th id="ntsale" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="ntprofit" style="text-align: right;color: #00aaf1;"></th>
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
    var dep = 0;
    var subdep = 0;
    $("#subcategory").select2({
        placeholder: "Select a model"
    });

    var sub = [];
    $("#subcategory").change(function() {
        sub.length = 0;

        $("#subcategory :selected").each(function() {
            sub.push($(this).val());
        });
        $("#subcategory_ar").val(JSON.stringify(sub));
    });

    $("#route").select2({
        placeholder: "Select a location"
    });
    var loc = [];
    $("#route").change(function() {
        loc.length = 0;

        $("#route :selected").each(function() {
            loc.push($(this).val());
        });
        $("#route_ar").val(JSON.stringify(loc));
    });

    $('#product').select2();

    $('#filterform').submit(function(e) {
        e.preventDefault();
        $('#cash').html(accounting.formatMoney(0));
        $('#nsale').html(accounting.formatMoney(0));
        cash_bal = 0;
        totalDis = 0;
        toatl_discount=0;
        proDisount=0;
        var totalExp = 0;
        var totalErn = 0;
        $.ajax({
            type: 'POST',
            url: "loadtestingjobcards",
            data: $(this).serialize(),
            success: function(data) {
                $('#saletable tbody').empty();
               var d= JSON.parse(data);
                drawTable(d);
                toatl_discount =d.dis;
                totalExp=(d.expenses);
                totalErn=(d.earn);
                $('#unitpr').html(accounting.formatMoney(sumcolumn('invunitpr')));
                $('#qty').html(accounting.formatMoney(sumcolumn('qty')));
                $('#freeqty').html(accounting.formatMoney(sumcolumn('freeqty')));
                $('#costval').html(accounting.formatMoney(sumcolumn('cost')));
                $('#discount').html(accounting.formatMoney(sumcolumn('disamount')));
                $('#netamount').html(accounting.formatMoney(sumcolumn('netamount')));
                $('#profit').html(accounting.formatMoney(sumcolumn('profit')));
                $('#cash').html(accounting.formatMoney(cash_bal));
                $('#toDis,#toDis2').html(accounting.formatMoney(toatl_discount));
                $('#ntsale').html(accounting.formatMoney(sumcolumn('netamount') - cash_bal +proDisount-toatl_discount-totalExp+totalErn));
                $('#nprofit').html(accounting.formatMoney(sumcolumn('profit')));
                $('#ntprofit').html(accounting.formatMoney(sumcolumn('profit')+proDisount-toatl_discount-totalExp+totalErn));
                $('#expense,#expense2').html(accounting.formatMoney(totalExp));
                $('#earning,#earning2').html(accounting.formatMoney(totalErn));
                 $('#nsale').html(accounting.formatMoney(sumcolumn('netamount')));
            }
        });
    });
var toatl_discount =0;
    function drawTable(data) {
        var gr_qty = 0;
        var gr_net = 0;
        var gr_pro = 0;
        var gr_cost = 0;
        
        
        
        
        $.each(data.pro, function(key, value) {

            $("#saletable").append("<tr style='background-color:#00a678;color:#fff;'><td colspan='11'><b>" + key + "</b></td></tr>");
            total2 = 0;
            for (var i = 0; i < value.length; i++) {
                drawRow(value, i);
                gr_qty += parseFloat(value[i].Qty);
                var gr_cost = 0;
                gr_net += parseFloat(value[i].NetAmount);
                gr_cost += parseFloat(value[i].Qty*value[i].JobCost);
                gr_pro += parseFloat(value[i].NetAmount-(value[i].Qty*value[i].JobCost));
                if (i == (value.length - 1)) {
                    $("#saletable").append("<tr style='background-color:#3c8dbc;color:#fff;'><td colspan='4' >Total</td><td><b></b></td><td class='cos'>" + accounting.formatMoney(gr_qty) + "</td><td><b></b></td><td><b>" + accounting.formatMoney(gr_cost) + "</b></td><td><b></b></td><td><b>" + accounting.formatMoney(gr_net) + "</b></td><td><b>" + accounting.formatMoney(gr_pro) + "</b></td></tr>");
                    $("#saletable").append("<tr><td colspan='13'>&nbsp;</td></tr>");
                    gr_qty = 0;
                    gr_net = 0;
                    gr_pro = 0;
                    gr_cost = 0;
                }
            }
        });
    }
    var cash_bal = 0;
    var totalDis = 0;
    var proDisount = 0;
    function drawRow(rowData, index) {
        var row = $("<tr/>");
        $("#saletable").append(row);
        var profit = 0;
        var cost = 0;

            if(rowData[index].JobType==2){
                cost = parseFloat(rowData[index].Qty*rowData[index].JobCost);
            }else{
                cost = parseFloat((rowData[index].NetAmount)*((100-rowData[index].JobProfitMargin)/100));
            }
            


            profit = parseFloat(rowData[index].NetAmount - cost);


        
        proDisount+=parseFloat(rowData[index].DisAmount);
        var date = new Date(rowData[index].JobInvoiceDate);
        row.append($("<td>" + formatDate(date) + "</td>"));
        row.append($("<td>" + rowData[index].JobInvNo + "</td>"));
        row.append($("<td>" + rowData[index].JobCode + "</td>"));
        row.append($("<td>" + rowData[index].AppearName + "</td>"));
        row.append($("<td class='invunitpr' align='right'>" + accounting.formatMoney(rowData[index].JobPrice) + "</td>"));
        row.append($("<td class='qty' align='right'>" + accounting.formatMoney(rowData[index].Qty) + "</td>"));
        row.append($("<td class='freeqty' align='right'>" + accounting.formatMoney(0) + "</td>"));
        row.append($("<td class='cost' align='right'>" + accounting.formatMoney(cost) + "</td>"));
        row.append($("<td class='disamount' align='right'>" + accounting.formatMoney(parseFloat(rowData[index].DisAmount)) + "</td>"));
        row.append($("<td class='netamount' align='right'>" + accounting.formatMoney(rowData[index].NetAmount) + "</td>"));
        row.append($("<td class='profit' align='right'>" + accounting.formatMoney(profit) + "</td>"));
    }
    function sumcolumn(rclass) {
        var sum = 0;
        var elemnt = document.getElementsByClassName(rclass);
        $(elemnt).each(function() {
            var value = accounting.unformat($(this).text());

            if (!isNaN(value) && value.length != 0) {
                sum += parseFloat(value);
            }
        });
        return sum;
    }

    function loadprint() {
        $('.modal-content').load('<?php echo base_url() ?>admin/report/', function(result) {
            $('#salesbydateprint').modal({show: true});
        });
    }
    function printdiv() {
        $("#saletable").print({
            prepend: "<h3 style='text-align:center'>Product vise Sales Report</h3><hr/>",
            title: 'Date vise Sales Report'
        });
    }

    function formatDate(date) {
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var day = date.getDate();
        var month = (date.getMonth() + 1);
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12;
        hours = hours < 10 ? '0' + hours : hours;
        day = day < 10 ? '0' + day : day;
        month = month < 10 ? '0' + month : month;
        minutes = minutes < 10 ? '0' + minutes : minutes;
        var strTime = hours + ':' + minutes + ' ' + ampm;
        return  date.getFullYear() + "-" + month + "-" + day + " " + strTime;
    }

    

</script>
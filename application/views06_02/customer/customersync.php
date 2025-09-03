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
                        <?php if (in_array("SM21", $blockAdd) || $blockAdd == null) { ?>
                        <button onclick="addm()" class="btn btn-flat btn-primary pull-right">Create Customer</button>
                            <?php
                        } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-2">
                     <div class="form-group">
                        <label for="cusName">Customer From </label>
                    </div>
                </div>
                <div class="col-md-2">
                     <div class="form-group">
                        <input type="text" required="required" class="form-control" name="cusFrom" id="cusFrom" placeholder="Enter customer name">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="cusName">Customer To </label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <input type="text" required="required" class="form-control" name="cusTo" id="cusTo" placeholder="Enter customer name">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="cusName">&nbsp;</label>
                        <input type="button" required="required" class="btn btn-success" name="btnSync" id="btnSync" value="Sync">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-4">
                    <table class="table">
                        <tr><td>Cus Code</td><td>:</td><td id="cusCode"></td></tr>
                        <tr><td>Customer</td><td>:</td><td id="cusName"></td></tr>
                        <tr><td>Outstand</td><td>:</td><td id="cusOutstand"></td></tr>
                        <tr><td>Mobile</td><td>:</td><td id="cusPhone"></td></tr>
                        <tr><td>Address</td><td>:</td><td id="cusAddress"></td></tr>
                        <tr><td>Join</td><td>:</td><td id="JoinDate"></td></tr>
                        
                    </table>
                </div>
                <div class="col-md-4">
                    <table class="table">
                        <tr><td>Cus Code</td><td>:</td><td id="cusCode1"></td></tr>
                        <tr><td>Customer</td><td>:</td><td id="cusName1"></td></tr>
                        <tr><td>Outstand</td><td>:</td><td id="cusOutstand1"></td></tr>
                        <tr><td>Mobile</td><td>:</td><td id="cusPhone1"></td></tr>
                        <tr><td>Address</td><td>:</td><td id="cusAddress1"></td></tr>
                        <tr><td>Join</td><td>:</td><td id="JoinDate1"></td></tr>
                    </table>
                </div>
                <div class="col-md-2">
                    
                </div>
                <div class="col-md-4">
                    
                </div>
            </div>
        </div>
    </section>
</div>
<div id="customermodal" class="modal fade bs-add-category-modal-lg" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-lg" style="width: 95%;">
        <div class="modal-content">
            <!-- load data -->
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
     var fromcustomer =0;
    var tocustomer =0;

    $("#btnSync").click(function(){
         var r = confirm('Do you want to sync  this customers ?');
        if (r === true) {
        $("#btnSync").prop('disabled',true);
        if(fromcustomer=='' || tocustomer==''){
            $.notify("Select customers .", "danger");
        }else{
            $.ajax({
                type: "POST",
                url: "../Customer/saveCustomerSync",
                data: { fromcustomer: fromcustomer,tocustomer:tocustomer},
                success: function(data)
                {
                    var resultData = JSON.parse(data);
                    if(data==1){
                         $.notify("Customer synced successfully.", "success");
                         fromcustomer=0;tocustomer=0;
                    }else{
                         $.notify("Error Please try again .", "danger");
                          fromcustomer=0;tocustomer=0;
                    }

                    $("#btnSync").prop('disabled',true);
                }
            });
        }
        }
    });
    
    $("#cusFrom").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../customer/loadacustomersjson',
                dataType: "json",
                data: {
                    q: request.term
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.text,value: item.id,data: item
                        }
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function(event, ui) {
            fromcustomer = ui.item.value;
            clearCustomerData();
            loadCustomerDatabyId(fromcustomer);
        }
    });

    $("#cusTo").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../Customer/loadtocustomersjson',
                dataType: "json",
                data: {
                    q: request.term,
                    from: fromcustomer
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.text,value: item.id,data: item
                        }
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function(event, ui) {
            tocustomer = ui.item.value;
            clearCustomerData2();

            loadCustomerDatabyId2(tocustomer);
             $("#btnSync").prop('disabled',false);
        }
    });

     function loadCustomerDatabyId(customer){
        clearCustomerData();
        clearCustomerData2();
        $.ajax({
                type: "POST",
                url: "../Payment/getCustomersDataById",
                data: { cusCode: customer},
                success: function(data)
                {
                    var resultData = JSON.parse(data);

                    outstanding = resultData.cus_data.CusOustandingAmount;
                    available_balance = parseFloat(resultData.cus_data.CreditLimit) - parseFloat(outstanding);
                    customer_name=resultData.cus_data.CusName;
                    $("#cusName").html(resultData.cus_data.CusName);
                    $("#cusCode").html(resultData.cus_data.CusCode);
                    $("#creditLimit").html(accounting.formatMoney(resultData.cus_data.CreditLimit));
                    $("#creditPeriod").html(resultData.cus_data.CreditPeriod);
                    $("#cusOutstand").html(accounting.formatMoney(outstanding));
                    $("#availableCreditLimit").html(accounting.formatMoney(available_balance));
                    $("#cusAddress").html(nl2br(resultData.cus_data.Address01)+"<br>");
                    $("#cusAddress2").html(resultData.cus_data.Address03);
                    $("#cusPhone").html(resultData.cus_data.MobileNo);
                    $("#JoinDate").html(resultData.cus_data.JoinDate);
                    $("#cusType2").val(resultData.cus_data.CusType);
                    if(resultData.cus_data.CusCompany>0){
                         $("#vehicleCompany").show();
                    }
                    $("#vehicleCompany").val(resultData.cus_data.CusCompany);
                }
            });
    }

    function loadCustomerDatabyId2(customer){
        clearCustomerData2();
        $.ajax({
                type: "POST",
                url: "../Payment/getCustomersDataById",
                data: { cusCode: customer},
                success: function(data)
                {
                    var resultData = JSON.parse(data);

                    outstanding = resultData.cus_data.CusOustandingAmount;
                    available_balance = parseFloat(resultData.cus_data.CreditLimit) - parseFloat(outstanding);
                    customer_name=resultData.cus_data.CusName;
                    $("#cusName1").html(resultData.cus_data.CusName);
                    $("#cusCode1").html(resultData.cus_data.CusCode);
                    $("#creditLimit1").html(accounting.formatMoney(resultData.cus_data.CreditLimit));
                    $("#creditPeriod1").html(resultData.cus_data.CreditPeriod);
                    $("#cusOutstand1").html(accounting.formatMoney(outstanding));
                    $("#availableCreditLimit1").html(accounting.formatMoney(available_balance));
                    $("#cusAddress1").html(nl2br(resultData.cus_data.Address01)+"<br>");
                    $("#cusAddress2").html(resultData.cus_data.Address03);
                    $("#cusPhone1").html(resultData.cus_data.MobileNo);
                    $("#JoinDate1").html(resultData.cus_data.JoinDate);
                    $("#cusType2").val(resultData.cus_data.CusType);
                    if(resultData.cus_data.CusCompany>0){
                         $("#vehicleCompany").show();
                    }
                    $("#vehicleCompany").val(resultData.cus_data.CusCompany);
                }
            });
    }

    function clearCustomerData(){
        $("#cusName").html('');
        $("#cusCode").html('');
        $("#creditLimit").html(accounting.formatMoney(0));
        $("#creditPeriod").html(0);
        $("#cusOutstand").html(accounting.formatMoney(0));
        $("#availableCreditLimit").html(accounting.formatMoney(0));
        $("#cusAddress").html("");
        $("#cusAddress2").html('');
        $("#cusPhone").html('');
        $("#JoinDate").val('');
        $("#cusType2").val('');
        $("#vehicleCompany").val('');
    }

     function clearCustomerData2(){
        $("#cusName1").html('');
        $("#cusCode1").html('');
        $("#creditLimit1").html(accounting.formatMoney(0));
        $("#creditPeriod1").html(0);
        $("#cusOutstand1").html(accounting.formatMoney(0));
        $("#availableCreditLimit1").html(accounting.formatMoney(0));
        $("#cusAddress1").html("");
        $("#cusAddress2").html('');
        $("#cusPhone1").html('');
        $("#JoinDate1").val('');
        $("#cusType2").val('');
        $("#vehicleCompany").val('');
    }

    function nl2br (str, is_xhtml) {
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }
});

</script>
    <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-power-off myclose"></i></button>
        <h4>Edit Customer  <span style="color: #0089db" class="pull-right"> <?php echo $cusdata->CusCode ?></span></h4>
    </div>
    
    <div class="modal-body">
    <form id="editcustomerform">
    <input type="hidden" name="userid" value="<?php echo $cusdata->CusCode; ?>" />
        <div class="row" style="background: rgba(148, 167, 187, 0.45);">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group" style="display: none;">
                            <label for="respectSign" >Customer Type</label>
                            <select class="form-control" name="cusType" id="cusType">
                                <option value="0">-Select-</option>
                                <?php foreach ($custype AS $t) { ?>
                                    <option <?php if($t->CusTypeId==$cusdata->CusType){echo 'selected';} ?> value="<?php echo $t->CusTypeId ?>"><?php echo $t->CusType ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="vehicleCompany" id="vehicleCompany" class="form-control">
                                <option value="">Select a company</option>
                                <?php foreach ($vehicle_company as $trns) { ?>
                                <option value="<?php echo $trns->VComId; ?>"  <?php if($trns->VComId==$cusdata->CusCompany){echo 'selected';} ?> ><?php echo $trns->VComName; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="respectSign" >Title</label>
                                    <select class="form-control" name="respectSign" id="respectSign">
                                        <option value="0">-Select-</option>
                                        <?php foreach ($title AS $t) { ?>
                                            <option <?php echo ($t->TitleName == $cusdata->RespectSign) ? 'SELECTED' : '' ?> value="<?php echo $t->TitleName ?>"><?php echo $t->TitleName ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                <label for="cusName">Customer Name </label>
                                <input type="text" required="required" value="<?php echo $cusdata->CusName; ?>" class="form-control" name="cusName" id="cusName" placeholder="First name">
                                </div>
                            </div>
                            
                        </div>
                        <div class="row" style="display: none;">
                            <div class="col-md-12">
                                <div class="form-group">
                                <label for="LastName">Last Name </label>
                                <input type="text" value="<?php echo $cusdata->LastName; ?>" class="form-control" name="LastName" id="LastName" placeholder="Last name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="companyName">Company Name </label>
                                    <input type="text" class="form-control" value="<?php echo $cusdata->CusCompany; ?>" name="companyName" id="companyName" placeholder="Enter Company Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="displayName" >Display Type</label>
                                <select class="form-control" name="displayType" id="displayType">
                                    <option value="">-Select-</option>
                                    <option value='1' <?php echo ($cusdata->DisType==1) ? 'SELECTED' : '' ?> ><?php echo $cusdata->RespectSign.". ".$cusdata->CusName ?></option>
                                    
                                    <option value='4' <?php echo ($cusdata->DisType==4) ? 'SELECTED' : '' ?>><?php echo "Ms. ".$cusdata->CusCompany ?></option>")                   
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="displayName" >Display Name</label>
                            <input type="text" required="required" class="form-control" value="<?php echo $cusdata->DisplayName; ?>" name="displayName" id="displayName" placeholder="Display Name">
                        </div>
                        <div class="form-group">
                            <label for="nic" >NIC / Passport</label>
                            <input type="text" required="required" class="form-control" value="<?php echo $cusdata->Nic; ?>" name="nic" id="nic" placeholder="NIC No Or Passport No">
                        </div>
                        <div class="form-group">
                            <label for="respectSign" >Handle By</label>
                            <select class="form-control" name="salesperson" id="salesperson">
                                <option value="0">-Select-</option>
                                <?php foreach ($emp AS $t) { ?>
                                    <option <?php echo ($t->RepID == $cusdata->HandelBy) ? 'SELECTED' : '' ?> value="<?php echo $t->RepID ?>"><?php echo $t->RepName ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6"><div class="form-group">
                        <label for="cusName">Customer No </label>
                        <input type="text"  class="form-control" name="cusNo" id="cusNo" placeholder="Enter customer number"  value="<?php echo $cusdata->CusBookNo; ?>">
                    </div></div>
                    <div class="col-md-6"><div class="form-group">
                        <label for="cusName">Category </label>
                        <select class="form-control" name="category" id="category">
                            <option value="0">-Select-</option>
                            <?php foreach ($cat AS $t) { ?>
                                <option <?php echo ($t->CusCategory == $cusdata->CusCategory) ? 'SELECTED' : '' ?> value="<?php echo $t->CusCategory ?>"><?php echo $t->CusCategory ?></option>
                            <?php } ?>
                        </select>
                    </div></div>
                </div> 
                
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="address"> Address </label>
                    <textarea  class="form-control" name="address" id="address" placeholder="Enter customer address"><?php echo $cusdata->Address01 ?></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mobileNo">Customer Mobile </label>
                            <div class="input-group">
                                <input type="text"  class="form-control" value="<?php echo $cusdata->MobileNo; ?>"  name="mobileNo" id="mobileNo" placeholder="Enter customer mobile " maxlength="12" value="+94">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phoneNo">Customer Phone </label>
                            <input type="text"  class="form-control" value="<?php echo $cusdata->LanLineNo; ?>" name="phoneNo" id="phoneNo" placeholder="Enter customer phone" maxlength="12" value="+94">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mobileNo">Work Phone</label>
                            <div class="input-group">
                                <input type="text"  class="form-control" value="<?php echo $cusdata->WorkNo; ?>" name="workPhone" id="workPhone" placeholder="Enter Work Phone " maxlength="12" value="+94">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Customer Email </label>
                            <input type="text"  class="form-control" value="<?php echo $cusdata->Email; ?>"  name="email" id="email" placeholder="Enter customer email">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address">Company Address </label>
                    <textarea  class="form-control" name="companyaddress" id="companyaddress" placeholder="Enter company address"><?php echo $cusdata->ComAddress; ?></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mobileNo">Contact Person</label>
                            <div class="input-group">
                                <input type="text"  class="form-control" name="contactName" value="<?php echo $cusdata->ContactPerson; ?>" id="contactName" placeholder="Enter Contact Person ">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mobileNo">Contact Phone</label>
                            <div class="input-group">
                                <input type="text"  class="form-control" name="contactPhone"  value="<?php echo $cusdata->ContactNo; ?>" id="contactPhone" placeholder="Enter Work Phone " maxlength="12" value="+94">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
     <!--            <div class="form-group">
                    <label for="isCredit">Is Credit Customer</label>
                    <input type="checkbox" <?php echo ($cusdata->IsAllowCredit==1)?'checked':'' ?>  name="isCredit" id="isCredit" value="1">
                </div> -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="payMethod">Payment</label>
                            <select  class="form-control" name="payMethod" id="payMethod">
                                <option value="">--select--</option>
                                <option <?php if($cusdata->payMethod==1){?> SELECTED <?php } ?> value="1">Cash</option>
                                <option <?php if($cusdata->payMethod==2){?> SELECTED <?php } ?> value="2" >Credit</option>
                            </select>
                        </div>
                    </div>  
                </div>
                <div class="row" id="creditDiv">
                <div class="col-md-6">
                        <div class="form-group">
                            <label for="creditLimit">Balance Date</label>
                            <input type="text"  class="form-control" name="balanceDate" value="<?php echo $cusdata->BalanceDate; ?>" id="balanceDate" placeholder="Enter Balance Date" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="balanaceAmount">Balance Amount</label>
                            <input type="text"  class="form-control" value="<?php echo $cusdata->BalanaceAmount; ?>" name="balanaceAmount" id="balanaceAmount" placeholder="Enter Balanace Amount" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="creditLimit">Credit Limit</label>
                            <input type="text"  class="form-control" value="<?php echo $cusdata->CreditLimit; ?>" name="creditLimit" id="creditLimit" placeholder="Enter Credit Limit" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="balanaceAmount">VAT Number</label>
                            <input class="form-control" type="text" value="<?php echo $cusdata->DocNo; ?>" name="docNo" id="docNo"  placeholder="VAT Number">
                        </div>
                    </div> 
                </div>
                <div class="form-group">
                    <label for="remark">Remark</label>
                    <textarea class="form-control" name="remark" id="remark"><?php echo $cusdata->remark; ?></textarea>
                </div>

                <div class="form-group">
                    <?php foreach ($getCusTypes as $getCusType) { ?>
                        <label for="cusType<?php echo $getCusType->CusTypeId; ?>"><?php echo $getCusType->CusType; ?> </label>&nbsp;
                        <input type="radio" <?php if ($cusdata->CusType_easy == $getCusType->CusTypeId) {echo 'checked';} ?> required="required"name="cusType" id="cusType<?php echo $getCusType->CusTypeId; ?>" value="<?php echo $getCusType->CusTypeId; ?>">&nbsp;

                    <?php } ?>
                </div>
                <div class="form-group">
                    <label for="isCredit">Is Easy Customer &nbsp;&nbsp;&nbsp;</label>
                    <input type="checkbox" <?php echo ($cusdata->IsEasy==1)?'checked':'' ?>    name="IsEasy" id="IsEasy" value="1" >
                </div>
                <div class="form-group">
                    <?php  if  (in_array("SM25", $blockView) || $blockView == null) { ?>
                        <label for="isCredit">Is Active &nbsp;&nbsp;&nbsp;</label>
                        <input type="checkbox" <?php echo ($cusdata->IsActive==1)?'checked':'' ?>  name="IsActive" id="IsActive" value="1">
                    <?php } ?>
                </div>
            </div>
        </div>
            <button class="btn btn-success btn-flat pull-right" type="submit">Update Customer</button>
        </form>
        <div class="row-container" style="padding-top: 10px;">
        <?php if(count($vdata) > 0): ?>
            <div class="col-md-3">
                <select  class="form-control" name="vehicleno" id="vehicleno">
                    <option value="">--select a vehicle no--</option>
                    <?php foreach ($vdata as $key => $value) { ?>
                        <option value="<?php echo $value->VehicleId ?>"><?php echo $value->RegNo ?></option>
                    <?php } ?>
                </select>
            </div>
            <!-- dynemic part======================================= -->
            <form id="editvehicleform">
            <div class="col-md-9" id="vdatapart" style="display: none;">
                <div class="row" style="background: rgba(121, 191, 130, 0.37);">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="contactName">Contact Name </label>
                            <input type="text" class="form-control" name="contactName" id="contactName" placeholder="Enter Contact name">
                        </div>
                        <div class="form-group">
                            <label for="regNo">Reg No </label>
                            <input type="text" required class="form-control" name="regNo" id="regNo" placeholder="Enter Registration No">
                        </div>
                       <!--  <div class="form-group">
                            <label for="chassisNo">Chassis No </label>
                            <input type="text" required class="form-control" name="chassisNo" id="chassisNo" placeholder="Enter Chassis No">
                        </div> -->
                        <div class="form-group" >
                            <label for="engineNo">Service Interval(Km)</label>
                            <input type="number"  class="form-control" name="engineNo" id="engineNo" placeholder="km">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="chassisNo">Chassis No </label>
                                    <input type="text" required class="form-control" maxlength="17" name="chassisNo" id="chassisNo" placeholder="Enter Chassis No">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="make">Make</label>
                                    <select class="form-control" required name="make" id="make">
                                        <option value="">-select-</option>
                                        <?php foreach ($make as $mkval) { ?>
                                            <option value="<?php echo $mkval->make_id ?>"><?php echo $mkval->make ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="model">Model</label>
                                    <select class="form-control" required name="model" id="model"></select>
                                </div>
                            </div>
                            <div class="col-md-6" style="display:none;">
                                <div class="form-group">
                                    <label for="fuel">Fuel</label>
                                    <select class="form-control" name="fuel" id="fuel">
                                        <option value="">-select-</option>
                                        <?php foreach ($fuel as $fval) { ?>
                                            <option value="<?php echo $fval->fuel_typeid ?>"><?php echo $fval->fuel_type ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6" style="display:none;">
                                <div class="form-group">
                                    <label for="codeColor">Code Color</label>
                                    <input type="text" class="form-control" name="codeColor" id="codeColor" placeholder="Enter Code color">
                                    <!-- <select class="form-control" name="codeColor" id="codeColor">
                                        <option value="">-select-</option>
                                        <?php foreach ($color as $cval) { ?>
                                            <option value="<?php echo $cval->bodycolor_id ?>"><?php echo $cval->body_color ?></option>
                                        <?php } ?>
                                    </select> -->
                                </div>
                            </div>
                            <div class="col-md-6" style="display:none;">
                                <div class="form-group">
                                    <label for="manufactureYear">Manufacture Year</label>
                                    <input type="text" class="form-control" name="manufactureYear" id="manufactureYear" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="vehicleId" id="vehicleId" />
            <button class="btn btn-success btn-flat pull-right" type="submit">Update Vehicle Data</button>
            </form>
            <!-- ===end dynamic part ============================== -->
        <?php endif; ?>
        </div>
    </div>
    <div class="modal-footer">
        
    </div>
</form>
<script> 
/*shalika*/
/*var userid =$("input[name=userid]").val();
check_is_invoice(userid);

function check_is_invoice(userid){
    $.ajax({
        url: "<?php echo base_url('admin/customer/check_isinvoice/') ?>",
        type: 'POST',
        data: {userid: userid},
        success: function(resp) {
            resp = JSON.parse(resp);
            if(resp==1){
                
                $("#balanaceAmount").prop('disabled', true);
            }
        }
    });
}*/
/*shalika*/
$('#balanceDate').datepicker({
        format: 'yyyy-mm-dd'
});

    $('#vehicleno').on('change',function(){
        var vregno = $(this).val();
        if(vregno =='' ){
            $('#vdatapart').hide();
        } else {
            $('#vdatapart').show();
            $.ajax({
                url:"<?php echo base_url('admin/customer/selectVehicledatajson/') ?>",
                type: "POST",
                data:{vno:vregno},
                dataType:'json',
                success: function(data) {
                    $.each(data.makedata,function(k,v) {
                        $('#model').append('<option value="'+v.model_id+'">'+v.model+'</option>');
                    });
                    $('#vehicleId').val(data.vehicledata.VehicleId);
                    $('#contactName').val(data.vehicledata.contactName);
                    $('#regNo').val(data.vehicledata.RegNo);
                    $('#chassisNo').val(data.vehicledata.ChassisNo);
                    $('#engineNo').val(data.vehicledata.EngineNo);
                    $('#make').val(data.vehicledata.Make);
                    $('#model').val(data.vehicledata.Model);
                    $('#fuel').val(data.vehicledata.FuelType);
                    $('#codeColor').val(data.vehicledata.Color);
                    $('#manufactureYear').val(data.vehicledata.ManufactureYear);
                }
        });
        }
        
    });
    $('#make').on('change', function() {
        $('#model').empty().append('<option value="">-select-</option>');
        modelid = $(this).val();
        $.ajax({
            url:'<?php echo base_url('admin/customer/loadmodelbymake') ?>/'+modelid,
            type:'GET',
            dataType: 'json',
            success: function (data) {
                $.each(data,function(k,v) {
                   $('#model').append('<option value="'+v.model_id+'">'+v.model+'</option>');
                });
            }
        });
    });
    $('#editcustomerform').submit(function (e) {
        e.preventDefault();
        var balanaceAmount =$("#balanaceAmount").val();
        var balanceDate =$("#balanceDate").val();
        
        if ((balanaceAmount>0 ) && (balanceDate=='' || balanceDate=='0000-00-00')) {
            $.notify("Please enter balance Date", "warn");
            return false;
        }
        $.ajax({
            url: "<?php echo base_url('admin/customer/editsavecustomer/') ?>",
            type: "POST",
            data: $(this).serializeArray(),
            success: function (data) {
                if (data == 'success') {
                    $.notify("Customer Edited Successfully..!", "success");
                    $('#customermodal').modal('hide');
                }else if (data == 'balance0success') {
                    
                    $.notify("Can not update customer Open Balance to 0..!", "warning");

                }else{
                    $.notify("Error..!", "warning");
                }
            }
        });
    });
    $('#editvehicleform').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url:'<?php echo base_url('admin/customer/editsavevehicle/') ?>',
            type:'POST',
            data: $(this).serializeArray(),
            success: function (data) {
                if(data == 'success') {
                     $('#customermodal').modal('hide');
                }
            }
        });
    });

    var companyShowArr=['3','4'];
var custype = 0;
    $("#cusType").change(function() {
        if($.inArray($(this).val(), companyShowArr )>-1){
            $("#vehicleCompany").show();
        }else{ 
            $("#vehicleCompany").hide(); 
        }
        $("#vehicleCompany").html("");
        $("#vehicleCompany").append("<option value=''>Select a company</option>");
         custype = $("#cusType option:selected").val();
        $.ajax({
            type: "POST",
            url: "../Job/loadCompanyByCusType",
            data: { custype: custype },
            success: function(data) {
                var resultData = JSON.parse(data);
                if (resultData) {
                    $.each(resultData, function(key, value) {
                        $("#vehicleCompany").append("<option value='" + value.VComId + "'>" + value.VComName + "</option>");
                    });
                }
            }
        });
    });

 $("#vehicleCompany").change(function() {
    $("#cusName").val($("#vehicleCompany option:selected").html());
    $("#respectSign").val(6);
 });

var paymethods =0;
$("#payMethod").change(function() {
 paymethods =($("#payMethod option:selected").val());
    if(paymethods==2){
        $("#creditDiv").show();
    }else{
        $("#creditDiv").show();
    }
 }); 

paymethods =($("#payMethod option:selected").val());
if(paymethods==2){
        $("#creditDiv").show();
    }else{
        $("#creditDiv").show();
    }
    custype = $("#cusType option:selected").val();

if($.inArray(custype, companyShowArr )>-1){
            $("#vehicleCompany").show();
        }else{ 
            $("#vehicleCompany").hide(); 
        }
$('#chassisNo').keyup(function(){
    var chassisNo =$(this).val();
    chassino_validate(chassisNo);
});

    function chassino_validate(chassino){

         var chassi =chassino.trim();
        chassi= chassi.toUpperCase();
    var model  = chassi.substr(3,4);
    var getmake = chassi.substr(1,1);
    var make=0;
    $("#model").val(model);

    switch (getmake) {
      case 'A':
        make = 2;
         $("#make").val(make);
        break;
      case 'B':
        make =4; $("#make").val(make);
        break;
     case 'H':
        make = 5; $("#make").val(make);
        break;
     case 'D':
        make = 1; $("#make").val(make);
        break;
     case 'N':
        make = 9; $("#make").val(make);
        break;
     case 'T':
        make = 3; $("#make").val(make);
        break;
     case 'V':
        make = 11; $("#make").val(make);
        break;
    }

    }


    
$('#cusName,#LastName,#companyName').keyup(function(){
    setDisplayType();
});

$('#respectSign').change(function(){
    setDisplayType();
});

$('#displayType').change(function(){
    var name= $("#displayType option:selected").html();
    $("#displayName").val(name);
});

function setDisplayType(){
    var respectSign =$("#respectSign").val();
    var cusName =$("#cusName").val();
    var LastName =$("#LastName").val();
    var companyName =$("#companyName").val();
    $("#displayType").empty();
    $("#displayType").append("<option value='1'>"+respectSign+". "+cusName+"</option>");
    $("#displayType").append("<option value='4'>Ms. "+companyName+"</option>");
    $("#displayName").val(respectSign+". "+cusName);
}
</script>
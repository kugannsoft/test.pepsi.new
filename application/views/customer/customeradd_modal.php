<form id="addcustomerform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-power-off myclose"></i></button>
        <h4>Add Customer</h4>
    </div>
    <div class="modal-body">
    <div class="row" style="background: rgba(148, 167, 187, 0.45);">
            <div class="col-md-4">
            <div class="row">
            <div class="col-md-12">
                <div class="form-group" style="display: none;">
                    <label for="respectSign" >Customer Type</label>
                    <select class="form-control" name="cusType" id="cusType">
                        <option value="0">-Select-</option>
                        <?php foreach ($custype AS $t) { ?>
                            <option > <?php if($t->CusTypeId==1){echo 'selected';} ?> value="<?php echo $t->CusTypeId ?>"><?php echo $t->CusType ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <select name="vehicleCompany" id="vehicleCompany" class="form-control">
                        <option value="">Select a company</option>
                        <?php foreach ($vehicle_company as $trns) { ?>
                        <option value="<?php echo $trns->VComId; ?>" ><?php echo $trns->VComName; ?></option>
                        <?php } ?>
                    </select>
                </div>
                 <div class="row">
                 <div class="col-md-3"><div class="form-group">
                    <label for="respectSign" >Title</label>
                    <select class="form-control" required="required" name="respectSign" id="respectSign">
                        <option value="">-Select-</option>
                        <?php foreach ($title AS $t) { ?>
                            <option value="<?php echo $t->TitleName ?>"><?php echo $t->TitleName ?></option>
                        <?php } ?>
                    </select>
                    </div></div>
                    <div class="col-md-9"><div class="form-group">
                    <label for="cusName">Customer Name </label>
                    <input type="text" onkeydown="return /[a-zA-Z0\s]/i.test(event.key)" required="required" value="<?php echo urldecode($q); ?>" class="form-control" name="cusName" id="cusName" placeholder="Ex: Kamal Jayasinghe">
                    </div></div>
                    
                </div>
                  <div class="row" style="display: none;">
                    
                    <div class="col-md-12"><div class="form-group">
                    <label for="LastName">Last Name </label>
                    <input type="text" class="form-control" name="LastName" id="LastName" placeholder="Ex: Jayasinghe">
                    </div></div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="companyName">Company Name </label>
                            <input type="text"  class="form-control" name="companyName" id="companyName" placeholder="Enter Company Name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="displayName" >Display Type</label>
                        <select class="form-control" name="displayType" id="displayType">
                            <option value="">-Select-</option>
                           </option>                      
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="displayName" >Display Name</label>
                    <input type="text" required="required" class="form-control" name="displayName" id="displayName" placeholder="Display Name">
                </div>
                <div class="form-group">
                    <label for="nic" >NIC / Passport</label>
                    <input type="text" required="required" class="form-control" name="nic" id="nic" placeholder="NIC No Or Passport No">
                </div>
                <div class="form-group">
                    <label for="respectSign" >Handle By</label>
                    <select class="form-control" name="salesperson" id="salesperson">
                        <option value="0">-Select-</option>
                        <?php foreach ($emp AS $t) { ?>
                            <option value="<?php echo $t->RepID ?>"><?php echo $t->RepName ?></option>
                        <?php } ?>
                    </select>
                </div></div>
            </div>
            <div class="row">
                <div class="col-md-6"><div class="form-group">
                    <label for="cusName">Customer No </label>
                    <input type="text" class="form-control" name="cusNo" id="cusNo" placeholder="Enter customer number">
                </div></div>
                <div class="col-md-6" style="display:none;"><div class="form-group">
                    <label for="cusName">Category </label>
                    <select class="form-control" name="category" id="category">
                        <option value="0">-Select-</option>
                        <?php foreach ($cat AS $t) { ?>
                            <option value="<?php echo $t->CusCategory ?>"><?php echo $t->CusCategory ?></option>
                        <?php } ?>
                    </select>
                </div></div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cusName">Routes</label>
                        <select class="form-control" name="route" id="route">
                            <option value="0">-Select-</option>
                        </select>
                    </div>
                </div>
            </div>

<!--                --><?php //if (in_array("SM22", $blockAdd) || $blockAdd == null) { ?>
<!--                <div class="form-group">-->
<!--                <label for="isCredit">Is New Vehicle </label>-->
<!--                <input type="checkbox"   name="Isvehicle" id="Isvehicle" value="1">-->
<!--                </div>-->
<!--                --><?php //} ?>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="address">Primary Address </label>
                    <textarea  class="form-control" name="address" id="address" placeholder="Enter customer address"></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mobileNo">Customer Mobile </label>
                            <div class="input-group">
                                <input type="text"  class="form-control" name="mobileNo" id="mobileNo" placeholder="Enter customer mobile " maxlength="12" value="+94">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phoneNo">Customer Phone </label>
                            <input type="text"  class="form-control" name="phoneNo" id="phoneNo" placeholder="Enter customer phone" maxlength="12" value="+94">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mobileNo">Work Phone</label>
                            <div class="input-group">
                                <input type="text"  class="form-control" name="workPhone" id="workPhone" placeholder="Enter Work Phone " maxlength="12" value="+94">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Customer Email </label>
                            <input type="text"  class="form-control" name="email" id="email" placeholder="Enter customer email">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address">Company Address </label>
                    <textarea  class="form-control" name="companyaddress" id="companyaddress" placeholder="Enter company address"></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mobileNo">Contact Person</label>
                            <div class="input-group">
                                <input type="text"  class="form-control" name="contactName" id="contactName" placeholder="Enter Contact Person ">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mobileNo">Contact Phone</label>
                            <div class="input-group">
                                <input type="text"  class="form-control" name="contactPhone" id="contactPhone" placeholder="Enter Work Phone " maxlength="12" value="+94">
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
                                <!-- <option value="">--select--</option> -->
                                <option value="1">Cash</option>
                                <option value="2">Credit</option>
                            </select>
                        </div>
                    </div>  
                </div>
                <div class="row" id="creditDiv">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="creditLimit">Balance Date</label>
                            <input type="text"  class="form-control" name="balanceDate" id="balanceDate" placeholder="Enter Balance Date" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="balanaceAmount">Balance Amount</label>
                            <input type="text"  class="form-control" name="balanaceAmount" id="balanaceAmount" placeholder="Enter Balanace Amount" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="creditLimit">Credit Limit</label>
                            <input type="text"  class="form-control" name="creditLimit" id="creditLimit" placeholder="Enter Credit Limit" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="balanaceAmount">VAT Number</label>
                            <input class="form-control" type="text" name="docNo" id="docNo"  placeholder="VAT Number">
                        </div>
                    </div>
                </div>
                
                    <div class="form-group">
                        <label for="remark">Remark</label>
                        <textarea class="form-control" name="remark" id="remark"></textarea>
                    </div>
                    <div class="form-group">
                        <?php foreach ($getCusTypes as $getCusType) { ?>
                            <label for="cusType<?php echo $getCusType->CusTypeId; ?>"><?php echo $getCusType->CusType; ?> </label>&nbsp;
                            <input type="radio" checked required="required" name="cusType" id="cusType<?php echo $getCusType->CusTypeId; ?>" value="<?php echo $getCusType->CusTypeId; ?>">&nbsp;

                        <?php } ?>
                    </div>
                <div class="form-group">
                    <label for="isCredit">Is Easy Customer &nbsp;&nbsp;&nbsp;</label>
                    <input type="checkbox"   name="IsEasy" id="IsEasy" value="1" >
                </div>
                <?php  if  (in_array("SM25", $blockView) || $blockView == null) { ?>
                    <div class="form-group">
                        <label for="isCredit">Is Active &nbsp;&nbsp;&nbsp;</label>
                        <input type="checkbox" checked   name="IsActive" id="IsActive" value="1" >
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="row" style="background: rgba(121, 191, 130, 0.37);" id="vehicle_div">
            <h5>&nbsp;&nbsp;&nbsp;&nbsp;Vehicle Details</h5>
            
            <div class="col-md-3">
                <div class="form-group" style="display:none;">
                    <label for="contactName">Contact Name </label>
                    <!-- <input type="text" class="form-control" name="contactName" id="contactName" placeholder="Enter Contact name"> -->
                </div>
                <div class="form-group">
                    <label for="regNo">Vehicle Number </label>
                    <input type="text"  class="form-control" name="regNo" id="regNo" placeholder="Enter Vehicle Number">
                </div>
                <div class="form-group">
                    <label for="engineNo">Service Interval (Km)</label>
                    <input type="number" class="form-control" name="engineNo" id="engineNo" placeholder="km">
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="chassisNo">Chassis No </label>
                            <input type="text" class="form-control" name="chassisNo" id="chassisNo" placeholder="Enter Chassis No" maxlength="17">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="make">Make</label>
                            <div class="input-group">
                                <select class="form-control" name="make" id="make">
                                    <!-- <option value="">-select-</option> -->
                                    <?php foreach ($make as $mkval) { ?>
                                        <option value="<?php echo $mkval->make_id ?>"><?php echo $mkval->make ?></option>
                                    <?php } ?>
                                </select>
                                <div class="input-group-btn">
                                    <button class="btn btn-warning" id="addMake"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="input-group" id="panel_make">
                            <input type="text" class="form-control pull-right" name="makeName" id="makeName">
                            <span class="input-group-btn"><button class="btn btn-primary" id="saveMake">Add</button></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                            <label for="model">Model</label>
                            <div class="input-group">
                                 <input type="text" class="form-control pull-right" name="model" id="model">
                                 <input type="hidden" class="form-control pull-right" name="modelcode" id="modelcode">
                                <!-- <select class="form-control" required name="model" id="model">
                                    
                                </select> -->
                                <div class="input-group-btn">
                                    <button class="btn btn-warning" id="addModel"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="input-group" id="panel_model">
                            <input type="text" class="form-control pull-right" name="modelName" id="modelName">
                            <span class="input-group-btn"><button class="btn btn-primary" id="saveModel">Add</button></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" style="display:none;">
                            <label for="fuel">Fuel</label>
                            <div class="input-group">
                                <select class="form-control" name="fuel" id="fuel">
                                    <option value="">-select-</option>
                                    <?php foreach ($fuel as $fval) { ?>
                                        <option value="<?php echo $fval->fuel_typeid ?>"><?php echo $fval->fuel_type ?></option>
                                    <?php } ?>
                                </select>
                                <div class="input-group-btn">
                                    <button class="btn btn-warning" id="addFuel"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="input-group" id="panel_fuel">
                            <input type="text" class="form-control pull-right" name="fuelName" id="fuelName">
                            <span class="input-group-btn"><button class="btn btn-primary" id="saveFuel">Add</button></span>
                        </div>
                    </div>
                    <div class="col-md-6" >
                        <div class="form-group">
                            <label id="modelNames"></label>
                            </div></div>
                    <div class="col-md-6"  style="display:none;">
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
                    <div class="col-md-6"  style="display:none;">
                        <div class="form-group">
                            <label for="manufactureYear">Manufacture Year</label>
                            <input type="text" class="form-control" name="manufactureYear" id="manufactureYear" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class="modal-footer">
        <span id="lastCustomerNo" class="pull-right" hidden="true"></span>
        <span id="lastRegNo" class="pull-right" hidden="true"></span>
        &nbsp;&nbsp;&nbsp;
        <button class="btn btn-success btn-flat" id="btnsave" type="submit">Create Customer</button>
<!--        <a href="#" id="jobLink" disabled class="btn btn-flat btn-primary pull-right">Add Job Card</a>-->
<!--        <a href="#" id="estLink" disabled class="btn btn-flat btn-primary pull-right">Add Estimate</a>-->


       
    </div>
</form>

<script>

    $(document).ready(function() {

$("#vehicleCompany").hide();
$("#panel_make").hide();
$("#panel_model").hide();
$("#panel_fuel").hide();
$("#saveModel").prop('disabled',false);
$("#addModel").prop('disabled',false);
$("#vehicle_div").hide();
$("#estLink").attr('disabled',true);
$("#jobLink").attr('disabled',true);


$('#balanceDate').datepicker({
        format: 'yyyy-mm-dd'
});

var cusNameDuplicate=0;
var proCodeDuplicate=0;

$("#btnAddJob").prop("disabled",true);
$("#btnAddEst").prop("disabled",true);
    
$("#cusName").blur(function(){
    cusNameDuplicate=0;
    var cusname=$(this).val();
    check_customer_name(cusname);
});

function check_customer_name(cusname){
    $.ajax({
        url: "<?php echo base_url('admin/customer/check_cusname/') ?>",
        type: 'POST',
        data: {fname: cusname},
        success: function(resp) {
            resp = JSON.parse(resp);
            if(resp==1){
                cusNameDuplicate=1;
                $.notify("Customer name already exist.", "warn");
               return false;
            }else{
                cusNameDuplicate=0;
            }
        }
    });
}

$('#chassisNo').keyup(function(){
    var chassisNo =$(this).val();
    chassino_validate(chassisNo);
    var chassi_length = chassisNo.length;

    if(chassi_length==9){

        getModelName(chassisNo.substr(3,6));
    }

});

$('#chassisNo').blur(function(){
    var chassisNo =$(this).val();
    var chassi_length = chassisNo.length;

    if(chassi_length>17 || chassi_length<17){
        $.notify("Invalid Chassis Number", "warning");
        $('#chassisNo').attr('background-color','#f00');
        return false;
    }else{
        $('#chassisNo').attr('background-color','#fff');
    }

    check_chassis(chassisNo);
});
var regNo ='';
$('#regNo').blur(function(){
     regNo =$(this).val();
    check_regno(regNo);
});



    function getModelName(code){
        $.ajax({
            type: "post",
            url: "<?php echo base_url(); ?>" + "admin/master/getModelByName",
            data: {chassi:code},
            success: function (json) {
                if(json!=0){
                    $("#model").val(json);
                    $("#modelNames").html(json);
                } 
            },
            error: function () {
                $.notify("Model not available.", "warn");
            }
        });
    }

    function check_chassis(ch){
        $.ajax({
            type: "post",
            url: "<?php echo base_url(); ?>" + "admin/customer/check_chassi",
            data: {chassis:ch},
            success: function (json) {
                if(json==1){
                    $.notify("Chassis no already exist.", "warn");
                    $("#btnsave").prop('disabled', true);
                    var r = confirm('Chassis no already exist. Do you want to save this vehicle for new customer ?');
                     if (r === true) {
                        $("#btnsave").prop('disabled', false);
                     }else{
                        $("#btnsave").prop('disabled', true);
                     }
                } else{

                }
            },
            error: function () {
                $.notify("Chassis no not available.", "warn");
            }
        });
    }

    function check_regno(regno){
        $.ajax({
            type: "post",
            url: "<?php echo base_url(); ?>" + "admin/customer/check_regno",
            data: {regno:regno},
            success: function (json) {
                if(json==1){
                    $.notify("Vehicle no already exist.", "warn");
                    $("#btnsave").prop('disabled', true);
                    var r = confirm('Vehicle No already exist. Do you want to save this vehicle for new customer ?');
                     if (r === true) {
                        $("#btnsave").prop('disabled', false);
                     }else{
                        $("#btnsave").prop('disabled', true);
                     }
                } else{
                    $("#btnsave").prop('disabled', false);
                }
            },
            error: function () {
                $.notify("Vehicle not available.", "warn");
            }
        });
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
var newVehicle=0;
$("input[name='Isvehicle']").click(function(){
    var isvehi = $("input[name='Isvehicle']:checked").val();
    if(isvehi==1){
        newVehicle=1;
        $("#contactName,#make,#chassisNo,#regNo").attr('required',true);
        $("#vehicle_div").show();
    }else{
        newVehicle=0;
        $("#contactName,#make,#chassisNo,#regNo").attr('required',false);
        $("#vehicle_div").hide();
    }
});

    $('#addcustomerform').submit(function (e) {
        e.preventDefault();
        var paytype =$("#payMethod option:selected").val();
		var address =$("#address").val();
		var mobileNo =$("#mobileNo").val();
		var balanaceAmount =$("#balanaceAmount").val();
        var balanceDate =$("#balanceDate").val();
		if (paytype==2 && address=='') {
		    $.notify("Please enter primary address.", "warn");
		}else if (paytype==2 && mobileNo.length<10) {
		    $.notify("Please enter valid mobile  no.", "warn");
		}else if ((balanaceAmount>0 ) && (balanceDate=='' || balanceDate==0)) {
            $.notify("Please enter balance Date", "warn");
        }else{
		     $("#btnsave").prop("disabled",true);
             
		    $.ajax({
		            url: "<?php echo base_url('admin/customer/savecustomer/') ?>",
		            type: "POST",
		            dataType: 'json',
		            data: $(this).serializeArray(),
		            success: function (status) {

		                
		                if (status){
		                    $.notify("Customer Added Successfully..!", "success");
		                    $("#lastCustomerNo").html("<a href=''>Last Cus - "+cusNo+"</a>");
		                    $("#lastRegNo").html("<a href=''>Reg_no - "+regNo+"</a>");
		                    $("#btnAddJob").prop("disabled",false);
		                    $("#btnAddEst").prop("disabled",false);
		                     genarateEstLink(status);
		                     genarateJobLink(status);
		                }else{
		                    $.notify("Error..!", "warning");
		                }
		            }
		        });
		}
        
    });
    
    $('#make').on('change', function() {
        $('#model').empty().append('<option value="">-select-</option>');
        makeid = $(this).val();
        $.ajax({
            url:'<?php echo base_url('admin/customer/loadmodelbymake') ?>/'+makeid,
            type:'GET',
            dataType: 'json',
            success: function (data) {
                $.each(data,function(k,v) {
                   $('#model').append('<option value="'+v.model_id+'">'+v.model+'</option>');
                });
                $("#saveModel").prop('disabled',false);
                $("#addModel").prop('disabled',false);
            }
        });
    });

    var companyShowArr=['3','4'];

    $("#cusType").change(function() {
        if($.inArray($(this).val(), companyShowArr )>-1){
            $("#vehicleCompany").show();
        }else{ 
            $("#vehicleCompany").hide(); 
        }
        $("#vehicleCompany").html("");
        $("#vehicleCompany").append("<option value=''>Select a company</option>");
        var custype = $("#cusType option:selected").val();
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
   
  $("#payMethod").change(function() {
    var val =($("#payMethod option:selected").val());
    if(val==2){
        $("#creditDiv").show();
    }else{
        $("#creditDiv").hide();
    }
    
 }); 
    

    $('#addMake').click(function(e) {
        $("#panel_make").show();
        $("#makeName").focus();
        e.preventDefault();
    });

    $('#saveMake').click(function(e) {
        var make = $("#makeName").val();
        $.ajax({
                type: "post",
                url: "<?php echo base_url(); ?>" + "admin/master/addMake",
                data: {department:make},
                success: function (json) {
                    var resultData = JSON.parse(json);
                    var feedback = resultData['result'];
                    var val = resultData['make_id'];
                    var dec = resultData['make'];

                    if (feedback == true) {
                        $("#make").append("<option value='"+val+"'>"+dec+"</option>");
                        $("#makeName").val('');
                        $("#panel_make").hide();
                     }
                },
                error: function () {
                    alert('Error while request..');
                }
            });
        e.preventDefault();
    });

    $('#addModel').click(function(e) {
        $("#panel_model").show();
        $("#modelName").focus();
        e.preventDefault();
    });

    $('#saveModel').click(function(e) {
        makeid = $("#make option:selected").val();
        var model = $("#modelName").val();
       var modelcode = $("#modelcode").val();
        if(makeid!='' || makeid!=0){
            $.ajax({
                type: "post",
                url: "<?php echo base_url(); ?>" + "admin/master/addModel",
                data: {department1:makeid,subdepartment:model, modelcode:modelcode},
                success: function (json) {
                    var resultData = JSON.parse(json);
                    var feedback = resultData['result'];
                    var val = resultData['id'];
                    var dec = resultData['model'];

                    if (feedback == true) {
                        $("#model").append("<option value='"+val+"'>"+dec+"</option>");
                        $("#modelName").val('');
                        $("#panel_model").hide();
                        $("#model").val(model);
                     }
                },
                error: function () {
                    alert('Error while request..');
                }
            });
            }else{
                $.notify("Please select a make...", "warning");
            }
        
        e.preventDefault();
    });


    $('#addFuel').click(function(e) {
        $("#panel_fuel").show();
        $("#fuelName").focus();
        e.preventDefault();
    });

    $('#saveFuel').click(function(e) {
        var fuel = $("#fuelName").val();
        $.ajax({
                type: "post",
                url: "<?php echo base_url(); ?>" + "admin/master/addFuel",
                data: {department:fuel},
                success: function (json) {
                    var resultData = JSON.parse(json);
                    var feedback = resultData['result'];
                    var val = resultData['fuel_id'];
                    var dec = resultData['fuel_type'];

                    if (feedback == true) {
                        $("#fuel").append("<option value='"+val+"'>"+dec+"</option>");
                        $("#fuelName").val('');
                        $("#panel_fuel").hide();
                     }
                },
                error: function () {
                    alert('Error while request..');
                }
            });
        e.preventDefault();
    });


    function chassino_validate(chassino){

    var chassi =chassino.trim();
        chassi= chassi.toUpperCase();
    var model  = chassi.substr(3,6);
    var getmake = chassi.substr(1,1);
    var make=0;
    $("#modelcode").val(model);


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

    var Base64 = {
                _keyStr: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
                encode: function(input) {
                    var output = "";
                    var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
                    var i = 0;

                    input = Base64._utf8_encode(input);

                    while (i < input.length) {

                        chr1 = input.charCodeAt(i++);
                        chr2 = input.charCodeAt(i++);
                        chr3 = input.charCodeAt(i++);

                        enc1 = chr1 >> 2;
                        enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
                        enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
                        enc4 = chr3 & 63;

                        if (isNaN(chr2)) {
                            enc3 = enc4 = 64;
                        } else if (isNaN(chr3)) {
                            enc4 = 64;
                        }

                        output = output +
                                this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
                                this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);

                    }

                    return output;
                },
               
                decode: function(input) {
                    var output = "";
                    var chr1, chr2, chr3;
                    var enc1, enc2, enc3, enc4;
                    var i = 0;

                    input = input.toString().replace(/[^A-Za-z0-9\+\/\=]/g, "");

                    while (i < input.length) {

                        enc1 = this._keyStr.indexOf(input.charAt(i++));
                        enc2 = this._keyStr.indexOf(input.charAt(i++));
                        enc3 = this._keyStr.indexOf(input.charAt(i++));
                        enc4 = this._keyStr.indexOf(input.charAt(i++));

                        chr1 = (enc1 << 2) | (enc2 >> 4);
                        chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
                        chr3 = ((enc3 & 3) << 6) | enc4;

                        output = output + String.fromCharCode(chr1);

                        if (enc3 != 64) {
                            output = output + String.fromCharCode(chr2);
                        }
                        if (enc4 != 64) {
                            output = output + String.fromCharCode(chr3);
                        }

                    }

                    output = Base64._utf8_decode(output);

                    return output;

                },

                _utf8_encode: function(string) {
                    string = string.toString().replace(/\r\n/g, "\n");
                    var utftext = "";

                    for (var n = 0; n < string.length; n++) {

                        var c = string.charCodeAt(n);

                        if (c < 128) {
                            utftext += String.fromCharCode(c);
                        }
                        else if ((c > 127) && (c < 2048)) {
                            utftext += String.fromCharCode((c >> 6) | 192);
                            utftext += String.fromCharCode((c & 63) | 128);
                        }
                        else {
                            utftext += String.fromCharCode((c >> 12) | 224);
                            utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                            utftext += String.fromCharCode((c & 63) | 128);
                        }

                    }

                    return utftext;
                },
    
                _utf8_decode: function(utftext) {
                    var string = "";
                    var i = 0;
                    var c = c1 = c2 = 0;

                    while (i < utftext.length) {

                        c = utftext.charCodeAt(i);

                        if (c < 128) {
                            string += String.fromCharCode(c);
                            i++;
                        }
                        else if ((c > 191) && (c < 224)) {
                            c2 = utftext.charCodeAt(i + 1);
                            string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                            i += 2;
                        }
                        else {
                            c2 = utftext.charCodeAt(i + 1);
                            c3 = utftext.charCodeAt(i + 2);
                            string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                            i += 3;
                        }

                    }

                    return string;
                }

            };

    function genarateEstLink(job_no){
        $("#estLink").attr('disabled',false);
        if(job_no!=''){
            $("#estLink").attr("href","../../admin/job/estimate_job?type=cus&ccode="+Base64.encode(job_no));  
        }
    }

    function genarateJobLink(job_no){
        $("#jobLink").attr('disabled',false);
        if(job_no!=''){
            $("#jobLink").attr("href","../../admin/job/index?type=cus&ccode="+Base64.encode(job_no)); 

        }
    }

});

$('#salesperson').on('change', function() {
        var salespersonID = $(this).val();
        if (salespersonID != "0") {
           
            $.ajax({
                url: "<?php echo base_url(); ?>" + "admin/customer/findemploeeroute",
                method: 'POST',
                data: { salespersonID: salespersonID },
                dataType: 'json',
                success: function(response) {
                    
                    $('#route').empty();
                    $('#route').append('<option value="0">-Select-</option>');
                    
                    $.each(response, function(index, routeID) {
                    console.log(routeID);
                    $('#route').append('<option value="'+ routeID.route_id +'">'+ routeID.route_name +'</option>');
                });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching routes:', error);
                }
            });
        } else {
            $('#route').empty();
            $('#route').append('<option value="0">-Select-</option>');
        }
});
    
</script>
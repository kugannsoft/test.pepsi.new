$(document).ready(function() {

    $('#appoDate,#deliveryDate').datetimepicker({ dateFormat: 'yy-mm-dd',timeFormat: "HH:mm:ss"});
    $('#appoDate').datetimepicker().datetimepicker("setDate", new Date());
    // $("#vehicleCompany").hide();

    $('.prd_icheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '50%'
    });

    var cusCode = 0;
    var jobNo = 0;
    var paymentNo = 0;
    var cusType = 2;
    var k = 0;
    //show hide company by customer type
    var companyShowArr=['3','4'];

    //load companies by customer type
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
            url: "../../Job/loadCompanyByCusType",
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

    //job no autoload
    $("#jobNo").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../../job/loadjobjson',
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
            jobNo = ui.item.value;
            clearCustomerData();
            clearVehicleData();
            $("#tbl_payment tbody").html("");
            total_due_amount = 0;
            total_over_payment = 0;
            clearCustomerData();
            clearVehicleData();
            $.ajax({
                type: "POST",
                url: "../../job/getJobDataById",
                data: { jobNo: jobNo},
                success: function(data)
                {
                    var resultData = JSON.parse(data);

                    cusCode = resultData.cus_data.CusCode;
                    outstanding = resultData.cus_data.CusOustandingAmount;
                    available_balance = parseFloat(resultData.cus_data.CreditLimit) - parseFloat(outstanding);
                    customer_name=resultData.cus_data.CusName;
                    $("#cusName").html(resultData.cus_data.CusName);
                    $("#customer").val(resultData.cus_data.CusCode);
                    $("#creditLimit").html(accounting.formatMoney(resultData.cus_data.CreditLimit));
                    $("#creditPeriod").html(resultData.cus_data.CreditPeriod);
                    $("#cusOutstand").html(accounting.formatMoney(outstanding));
                    $("#availableCreditLimit").html(accounting.formatMoney(available_balance));
                    $("#cusAddress").html(resultData.cus_data.Address01+", "+resultData.cus_data.Address02);
                    $("#cusAddress2").html(resultData.cus_data.Address03);
                    $("#cusPhone").html(resultData.cus_data.MobileNo);

                    $("#contactName").html(resultData.vehicle_data.contactName);
                    $("#registerNo").html(resultData.vehicle_data.RegNo);
                    $("#make").html(resultData.vehicle_data.make);
                    $("#model").html(resultData.vehicle_data.model);
                    $("#fuel").html(resultData.vehicle_data.fuel_type);
                    $("#chassi").html(resultData.vehicle_data.ChassisNo);
                    $("#engNo").html(resultData.vehicle_data.EngineNo);
                    $("#yom").html(resultData.vehicle_data.ManufactureYear);
                    $("#color").html(resultData.vehicle_data.body_color);

                    $("#cusCode").val(resultData.cus_data.CusCode);
                    $("#regNo").val(resultData.job_data.JRegNo);
                    $("#cusType").val(resultData.job_data.JCusType);
                    $("#vehicleCompany").val(resultData.job_data.JCusCompany);
                    $("#odoIn").val(resultData.job_data.OdoIn);
                    $("#odoOut").val(resultData.job_data.OdoOut);
                    $("#prevJobNum").val(resultData.job_data.PrevJobNo);
                    $("#sparePartCNo").val(resultData.job_data.SparePartJobNo);
                    $("#advisorName").val(resultData.job_data.serviceAdvisor);
                    $("#advisorPhone").val(resultData.job_data.advisorContact);
                    $("#appoDate").val(resultData.job_data.appoimnetDate);
                    $("#deliveryDate").val(resultData.job_data.deliveryDate);
                    $("#estimateNo").val(resultData.job_data.JestimateNo);
                    $("#jobtype").val(resultData.job_data.JJobType);
                    $("#jobSection").val(resultData.job_data.Jsection);
                    $("#advance").val(resultData.job_data.Advance);     

                    if($.inArray(resultData.job_data.JCusType, companyShowArr )>-1){
                        $("#vehicleCompany").show();
                    }else{ 
                        $("#vehicleCompany").hide(); 
                    }            

                    for (var i =  0; i < resultData.job_desc.length; i++) {
                         k=(i+1);
                        jobArr.push(resultData.job_desc[i].JobDescription);
                        jobNumArr.push(resultData.job_desc[i].JobDescId);
                        $("#jobArr").val(JSON.stringify(jobArr));
                        $("#jobNumArr").val(JSON.stringify(jobNumArr));
                     $("#tbl_payment tbody").append("<tr job='" + resultData.job_desc[i].JobDescription + "'  jobid='" + resultData.job_desc[i].JobDescId + "' ><td>" + (k) + "</td><td>" + resultData.job_desc[i].JobDescription + "</td><td><span  class='remove btn btn-danger btn-xs'>Remove</span></td></tr>");
            
                    }
                    
                }
            });
        }
    });

    //customer autoload
    $("#cusCode").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../../job/loadcustomersjson',
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
            cusCode = ui.item.value;
            clearCustomerData();
            clearVehicleData();
            $("#tbl_payment tbody").html("");

            $.ajax({
                type: "POST",
                url: "../../Payment/getCustomersDataById",
                data: { cusCode: cusCode},
                success: function(data)
                {
                    var resultData = JSON.parse(data);

                    cusCode = resultData.cus_data.CusCode;
                    outstanding = resultData.cus_data.CusOustandingAmount;
                    available_balance = parseFloat(resultData.cus_data.CreditLimit) - parseFloat(outstanding);
                    customer_name=resultData.cus_data.CusName;
                    $("#cusName").html(resultData.cus_data.CusName);
                    $("#customer").val(resultData.cus_data.CusCode);
                    $("#creditLimit").html(accounting.formatMoney(resultData.cus_data.CreditLimit));
                    $("#creditPeriod").html(resultData.cus_data.CreditPeriod);
                    $("#cusOutstand").html(accounting.formatMoney(outstanding));
                    $("#availableCreditLimit").html(accounting.formatMoney(available_balance));
                    $("#cusAddress").html(resultData.cus_data.Address01+", "+resultData.cus_data.Address02);
                    $("#cusAddress2").html(resultData.cus_data.Address03);
                    $("#cusPhone").html(resultData.cus_data.MobileNo);
                }
            });
        }
    });

    //vehicle autoload
    $("#regNo").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../../job/loadvehiclesjson',
                dataType: "json",
                data: {
                    q: request.term,cusCode:cusCode
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
            var regNo = ui.item.value;
             clearVehicleData();
            $.ajax({
                type: "POST",
                url: "../../Job/getVehicleDetailsById",
                data: { id: regNo},
                success: function(data)
                {
                    var resultData = JSON.parse(data);
                    if(resultData){
                    $("#contactName").html(resultData.contactName);
                    $("#registerNo").html(resultData.RegNo);
                    $("#make").html(resultData.make);
                    $("#model").html(resultData.model);
                    $("#fuel").html(resultData.fuel_type);
                    $("#chassi").html(resultData.ChassisNo);
                    $("#engNo").html(resultData.EngineNo);
                    $("#yom").html(resultData.ManufactureYear);
                    $("#color").html(resultData.body_color);
                    }
                }
            });
        }
    });

    
    var jobArr = [];
    var jobNumArr = [];
    var removeJob = 0;

    $("#jobdesc2").change(function() {
      var val = $("#jobdesc2 option:selected").html();
      $("#jobdesc").val(val);
    });
    // ADD job descriptions
    $("#btnAdd").click(function() {
      var jobdesc = $("#jobdesc").val();
      var val2 = $("#jobdesc2 option:selected").val();
        if (jobdesc) {
          jobArr.push(jobdesc);
          jobNumArr.push(val2);
          $("#jobArr").val(JSON.stringify(jobArr));
          $("#jobNumArr").val(JSON.stringify(jobNumArr));
          $("#tbl_payment tbody").append("<tr job='" + jobdesc + "'  jobid='" + val2 + "' ><td>" + k + "</td><td>" + jobdesc + "</td><td><span  class='remove btn btn-danger btn-xs'>Remove</span></td></tr>");
          k++;
          $("#jobdesc").val('');$("#jobdesc2").val('');
        }
    });

    //remove job description by table
    $('#tbl_payment tbody').on('click', 'tr', function() {
        removeJob = $(this).attr('job');
        removeJobId = $(this).attr('jobid');
        jobArr.splice( $.inArray(removeJob,jobArr) ,1 );
        jobNumArr.splice( $.inArray(removeJobId,jobNumArr) ,1 );
        $("#jobArr").val(JSON.stringify(jobArr));$("#jobNumArr").val(JSON.stringify(jobNumArr));
        $(this).remove();
    });

    //save job card
    $('#saveJobform').submit(function(e) {
        e.preventDefault();
        var jobdata = $("#jobArr").val();
        $("#modelNotifi").html('');
        if (jobArr.length > 0) {
            $('#updateJob').attr('disabled', true);
            $.ajax({
                url: "../../job/updateJob",
                type: "POST",
                data: $(this).serializeArray(),
                success: function(data) {
                    var newdata = JSON.parse(data);
                    var fb = newdata.fb;
                    var lastproduct_code = newdata.JobCardNo;

                    if (fb) {

                        $("#lastJob").html('');
                        $("#lastJob").html(lastproduct_code);
                        $("#modelNotifi").html(lastproduct_code + " Job card successfully saved.");
                        $('#saveJob').attr('disabled', false);
                    } else {
                        $("#lastJob").html('');
                        $('#saveJob').attr('disabled', false);
                    }
                }
            });
        } else {
            $("#modelNotifi").html("Please add job descriptions.");
        }
    });

    //cancel job card
    $('#cancelJobform').submit(function(e) {
        e.preventDefault();
        var jobdata = $("#jobArr").val();
        $("#modelNotifi").html('');
            $('#cancelJob').attr('disabled', true);
            $.ajax({
                url: "../../job/cancelJob",
                type: "POST",
                data: $(this).serializeArray(),
                success: function(data) {
                    var newdata = JSON.parse(data);
                    var fb = newdata.fb;
                    var lastproduct_code = newdata.JobCardNo;

                    if (fb) {
                        $("#lastJob").html('');
                        $("#lastJob").html(lastproduct_code);
                        $("#modelNotifi").html(lastproduct_code + " Job card  successfully canceled.");
                        $('#cancelJob').attr('disabled', false);
                    } else {
                        $("#lastJob").html('');
                        $('#cancelJob').attr('disabled', false);
                    }
                }
            });
    });


    function clearCustomerData(){
        $("#cusName").html('');
            $("#cusAddress").html('');
            $("#cusAddress2").html('');
            $("#cusPhone").html('');
    }
    function clearVehicleData(){
        $("#contactName").html('');
            $("#registerNo").html('');
            $("#make").html('');
            $("#model").html('');
            $("#fuel").html('');
            $("#chassi").html('');
            $("#engNo").html('');
            $("#yom").html('');
            $("#color").html('');
    }
    function invoicePrint(invNumber,invoicedate,invfname,total,disPrint,payType,chq_date,chq_no,bank_name){
        $("#tblData tbody").html('');
        if (payType == 1) {
            $("#tblData tbody").append("<tr><td colspan='3' style='border-left:#000 solid 1px;font-size:10px;border-right:#000 solid 1px;'>" + 'Cash' + "</td><td style='text-align:right;border-right:#000 solid 1px;'>" + accounting.formatMoney(total) + "</td></tr>");
        } else if (payType == 3) {
            $("#tblData tbody").append("<tr><td style='border-left:#000 solid 1px;font-size:10px;border-right:#000 solid 1px;'>" + chq_date + "</td><td style='border-right:#000 solid 1px;text-align:left;'>" + chq_no + "</td><td style='border-right:#000 solid 1px;text-align:left;'>" + bank_name + "</td><td style='text-align:right;border-right:#000 solid 1px;'>" + accounting.formatMoney(total) + "</td></tr>");
        }

        $("#invNumber").html(invNumber);
        $("#invoiceDate").html(invoicedate);
        $("#cusname").html(customer_name);
        $("#outstand").html(accounting.formatMoney(outstanding));
        $("#invTotal").html(accounting.formatMoney(total));

        if (disPrint != 1) {
            $('#printArea').focus().print();
            // var divContents = $("#printArea").html();
            // var printWindow = window.open('', '', 'height=400,width=800');
            // printWindow.document.write('<html><head><title>DIV Contents</title>');
            // printWindow.document.write('</head><body >');
            // printWindow.document.write(divContents);
            // printWindow.document.write('</body></html>');
            // printWindow.document.close();
            // printWindow.print();
            // setTimeout(function() {
            //     printWindow.close();
            // }, 10);
        }
    }
jobNo = $("#jobNo").val();

if(jobNo!=''){
    loadJobData();
}
    function loadJobData(){
         jobNo = $("#jobNo").val();
            clearCustomerData();
            clearVehicleData();
            $("#tbl_payment tbody").html("");
            total_due_amount = 0;
            total_over_payment = 0;
            clearCustomerData();
            clearVehicleData();
            $.ajax({
                type: "POST",
                url: "../../job/getJobDataById",
                data: { jobNo: jobNo},
                success: function(data)
                {
                    var resultData = JSON.parse(data);

                    cusCode = resultData.cus_data.CusCode;
                    outstanding = resultData.cus_data.CusOustandingAmount;
                    available_balance = parseFloat(resultData.cus_data.CreditLimit) - parseFloat(outstanding);
                    customer_name=resultData.cus_data.CusName;
                    $("#cusName").html(resultData.cus_data.CusName);
                    $("#customer").val(resultData.cus_data.CusCode);
                    $("#creditLimit").html(accounting.formatMoney(resultData.cus_data.CreditLimit));
                    $("#creditPeriod").html(resultData.cus_data.CreditPeriod);
                    $("#cusOutstand").html(accounting.formatMoney(outstanding));
                    $("#availableCreditLimit").html(accounting.formatMoney(available_balance));
                    $("#cusAddress").html(resultData.cus_data.Address01+", "+resultData.cus_data.Address02);
                    $("#cusAddress2").html(resultData.cus_data.Address03);
                    $("#cusPhone").html(resultData.cus_data.MobileNo);

                    $("#contactName").html(resultData.vehicle_data.contactName);
                    $("#registerNo").html(resultData.vehicle_data.RegNo);
                    $("#make").html(resultData.vehicle_data.make);
                    $("#model").html(resultData.vehicle_data.model);
                    $("#fuel").html(resultData.vehicle_data.fuel_type);
                    $("#chassi").html(resultData.vehicle_data.ChassisNo);
                    $("#engNo").html(resultData.vehicle_data.EngineNo);
                    $("#yom").html(resultData.vehicle_data.ManufactureYear);
                    $("#color").html(resultData.vehicle_data.body_color);

                    $("#cusCode").val(resultData.cus_data.CusCode);
                    $("#regNo").val(resultData.job_data.JRegNo);
                    $("#cusType").val(resultData.job_data.JCusType);
                    $("#vehicleCompany").val(resultData.job_data.JCusCompany);
                    $("#odoIn").val(resultData.job_data.OdoIn);
                    $("#odoOut").val(resultData.job_data.OdoOut);
                    $("#prevJobNum").val(resultData.job_data.PrevJobNo);
                    $("#sparePartCNo").val(resultData.job_data.SparePartJobNo);
                    $("#advisorName").val(resultData.job_data.serviceAdvisor);
                    $("#advisorPhone").val(resultData.job_data.advisorContact);
                    $("#appoDate").val(resultData.job_data.appoimnetDate);
                    $("#deliveryDate").val(resultData.job_data.deliveryDate);
                    $("#estimateNo").val(resultData.job_data.JestimateNo);
                    $("#jobtype").val(resultData.job_data.JJobType);
                    $("#jobSection").val(resultData.job_data.Jsection);
                    $("#advance").val(resultData.job_data.Advance);     

                    if($.inArray(resultData.job_data.JCusType, companyShowArr )>-1){
                        $("#vehicleCompany").show();
                    }else{ 
                        $("#vehicleCompany").hide(); 
                    }            

                    for (var i =  0; i < resultData.job_desc.length; i++) {
                         k=(i+1);
                        jobArr.push(resultData.job_desc[i].JobDescription);
                        jobNumArr.push(resultData.job_desc[i].JobDescId);
                        $("#jobArr").val(JSON.stringify(jobArr));
                        $("#jobNumArr").val(JSON.stringify(jobNumArr));
                     $("#tbl_payment tbody").append("<tr job='" + resultData.job_desc[i].JobDescription + "'  jobid='" + resultData.job_desc[i].JobDescId + "' ><td>" + (k) + "</td><td>" + resultData.job_desc[i].JobDescription + "</td><td><span  class='remove btn btn-danger btn-xs'>Remove</span></td></tr>");
            
                    }
                    
                }
            });
    }
});

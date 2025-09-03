$(document).ready(function() {

    $('#appoDate,#deliveryDate').datetimepicker({ dateFormat: 'yy-mm-dd',timeFormat: "HH:mm:ss"});
    $('#appoDate').datetimepicker().datetimepicker("setDate", new Date());
    // $("#vehicleCompany").hide();
    $("#NewVehicle").prop('disabled',true);

    $('.prd_icheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '50%'
    });

    $("#btnPrint").prop('disabled',true);

    var cusCode = 0;
    var jobNo = 0;
    var paymentNo = 0;
    var cusType = 2;
    var k = 0;
    //show hide company by customer type
    var companyShowArr=['3','4'];

     $("#NewVehicle").click(function(){
        if(cusCode!=0){
            addvehiclem(cusCode);
        }
    });

    function addvehiclem(v) {
        $('.modal-content').load('../../customer/loadmodal_vehicleadd/'+ v, function (result) {
            $('#customermodal').modal({show: true});
        });
    }

    var jobtypes =[];

     $("input[name='jobSection[]']").on('ifChanged', function() {
        jobtypes.length=0;
        var check = $("input[name='jobSection[]']:checked").val();

        $("input[name='jobSection[]']:checked").each(function(){
            jobtypes.push($(this).val()); 
        });
        var sel=jobtypes.includes('5');//check insurance job type=5
        var sel4=jobtypes.includes('4');//check warrnaty job type=4

        if(sel==true){
            $("#vcompany").show(); 
            $("#vehicleCompany").show();
        }else{
            $("#vcompany").hide(); 
            $("#vehicleCompany").hide(); 
        }


        if(sel4==true){
            $("#divprevjob").show();
        }else{
            $("#divprevjob").hide(); 
        }

        $("#vehicleCompany").html("");
        $("#vehicleCompany").append("<option value=''>Select a company</option>");
        $("#cusType").val(3);
        var custype = $("#cusType option:selected").val();
        $.ajax({
            type: "POST",
            url: "../../job/loadCompanyByCusType",
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

    //load companies by customer type
    $("#cusType").change(function() {
        // if($.inArray($(this).val(), companyShowArr )>-1){
        //     $("#vehicleCompany").show();
        // }else{ 
        //     $("#vehicleCompany").hide(); 
        // }
        // $("#vehicleCompany").html("");
        // $("#vehicleCompany").append("<option value=''>Select a company</option>");
        // var custype = $("#cusType option:selected").val();
        // $.ajax({
        //     type: "POST",
        //     url: "../../Job/loadCompanyByCusType",
        //     data: { custype: custype },
        //     success: function(data) {
        //         var resultData = JSON.parse(data);
        //         if (resultData) {
        //             $.each(resultData, function(key, value) {
        //                 $("#vehicleCompany").append("<option value='" + value.VComId + "'>" + value.VComName + "</option>");
        //             });
        //         }
        //     }
        // });
    });

    var advance_payment_no=0;
    var advance_amount=0;
    var loc = $("#invlocation").val();

    $("#advance").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../../salesinvoice/loadadvancepaymentjson',
                dataType: "json",
                data: {
                    q: request.term,
                    cusCode:cusCode,
                    loc:loc
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.text,
                            value: item.id,
                            data: item
                        }
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function(event, ui) {
            advance_payment_no = ui.item.value;            
            $("#advance_amount").val(0);
            $("#advanceno").val(0);
            $("#lbladvanceno").html('');
            loadAdvanceData(advance_payment_no);
        }
    });

 function loadAdvanceData(pay_no){
        $.ajax({
            type: "POST",
            url: "../../Salesinvoice/getadvancepaymentbyid",
            data: { payid: pay_no },
            success: function(data) {
                var resultData = JSON.parse(data);
                
                if (resultData.advance){
                    advance_amount = parseFloat(resultData.advance.TotalPayment);
                    advance_payment_no = resultData.advance.CusPayNo;
                    $("#advance").val(advance_amount);
                    $("#advanceno").val(advance_payment_no);
                    $("#lbladvanceno").html(advance_payment_no);
                }
            }
        });
    }

    //remove advance
    $("#removeadv").click(function(e){
        e.preventDefault();
        alert();
        advance_amount = parseFloat(0);
        advance_payment_no = '';
        $("#advance").val(0);
        $("#advanceno").val('');
        $("#lbladvanceno").html('');
    });

    // load previous job number
    $("#prevJobNum").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../../job/loadadvancepaymentjson',
                dataType: "json",
                data: {
                    q: request.term,
                    cusCode:cusCode,
                    loc:loc
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.text,
                            value: item.id,
                            data: item
                        }
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function(event, ui) {
            advance_payment_no = ui.item.value;            
            $("#advance_amount").val(0);
            $("#advanceno").val(0);
            loadAdvanceData(advance_payment_no);
        }
    });

    var odoin =0;
    var nextMeter = 0;
    var nextMileage =0;
    // next mileage
    odoin = parseFloat($("#odoIn").val());

    $("#odoIn").keyup(function(){
        odoin =parseFloat($("#odoIn").val());
        nextMeter=parseFloat($("#nextService").val());
        calNextMileage(odoin, nextMeter)
    });

    $("#nextService").keyup(function(){
        odoin =parseFloat($("#odoIn").val());
        nextMeter=parseFloat($("#nextService").val());
        calNextMileage(odoin, nextMeter)
    });

    $("#odoIn").blur(function(){
        odoin =parseFloat($("#odoIn").val());
        nextMeter=parseFloat($("#nextService").val());
        calNextMileage(odoin, nextMeter)
    });

    $("#nextService").blur(function(){
        odoin =parseFloat($("#odoIn").val());
        nextMeter=parseFloat($("#nextService").val());
        calNextMileage(odoin, nextMeter)
    });

    function calNextMileage(meterin, next){
        nextMileage = parseFloat(meterin) + parseFloat(next);
        $("#nextMileage").html(nextMileage);
    }

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
            $("#NewVehicle").prop('disabled',false);
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
                    $("#payType").val(resultData.job_data.JPayType);
                    $("#vehicleCompany").val(resultData.job_data.JCusCompany);
                    $("#insdoc").val(resultData.job_data.JIsInsDoc);
                    $("#odoIn").val(resultData.job_data.OdoIn);
                    $("#odoOut").val(resultData.job_data.OdoOut);
                    $("#odoInUnit").val(resultData.job_data.OdoInUnit);
                    $("#odoOutUnit").val(resultData.job_data.OdoOutUnit);
                    $("#nextService").val(resultData.job_data.NextService);
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
                        jobcatArr.push(resultData.job_desc[i].JobCategory);
                        $("#jobArr").val(JSON.stringify(jobArr));
                        $("#jobNumArr").val(JSON.stringify(jobNumArr));
                        $("#jobCatArr").val(JSON.stringify(jobcatArr));
                     $("#tbl_payment tbody").append("<tr job='" + resultData.job_desc[i].JobDescription + "' jobcat='" + resultData.job_desc[i].JobCategory + "'  jobid='" + resultData.job_desc[i].JobDescId + "' jobcategory='" + resultData.job_desc[i].job_category + "'><td>" + (k) + "</td><td></td><td>" + resultData.job_desc[i].JobDescription + "</td><td><span  class='remove btn btn-danger btn-xs'>Remove</span></td></tr>");
            
                    }
                    
                }
            });
loadInvoicetoPrint(jobNo);
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
            $("#NewVehicle").prop('disabled',false);
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

    $("#estimateNo").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../../job/loadestimatejsonbycustomer',
                dataType: "json",
                data: {
                    q: request.term,
                    cusCode:cusCode,
                    regNo:regNo
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.text,
                            value: item.id,
                            data: item
                        }
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function(event, ui) {
            estimateNo = ui.item.value;
            $("#estimateNo").val(ui.item.value);
        }
    });



    
    var k = 1;
    var jobArr = [];
    var jobcatArr = [];
    var jobNumArr = [];
    var removeJob = 0;
    var removeCat = 0;
    var val2 =0;
    var jobcat =0;
    // ADD job descriptions
    $("#btnAdd").click(function() {
      var jobdesc = $("#jobdesc").val();
      jobcat = $("#jobcategory option:selected").val();
      var jobcategory = $("#jobcategory option:selected").html();
       
        if (jobdesc) {
            jobArr.push(jobdesc);
            jobNumArr.push(val2);
            jobcatArr.push(jobcat);
            $("#jobArr").val(JSON.stringify(jobArr));
            $("#jobNumArr").val(JSON.stringify(jobNumArr));
            $("#jobCatArr").val(JSON.stringify(jobcatArr));
            $("#tbl_payment tbody").append("<tr job='" + jobdesc + "'  jobid='" + val2 + "' jobcat='" + jobcat + "'  jobcategory='" + jobcategory + "'><td>" + k + "</td><td></td><td>" + jobdesc + "</td><td><span  class='remove btn btn-danger btn-xs'>Remove</span></td></tr>");
            k++;
            $("#jobdesc").val('');$("#jobdesc2").val('');
            val2=0;
        }
    });

    //load companies by customer type
    $("#jobcategory").change(function() {
        jobcat = $("#jobcategory option:selected").val();
        $("#jobdesc").val('');
        $('#addDesc').prop('disabled',false);
        val2=0;
    });

     //job descriptions
    $("#jobdesc").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../../job/loadJobDescJson',
                dataType: "json",
                data: {
                    q: request.term,
                    jobcat:jobcat
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.text,value: item.text,descId:item.id,data: item
                        }
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function(event, ui) {
            val2=0;val2=ui.item.descId;
            $('#addDesc').prop('disabled',true);
        }
    });

    $("#jobdesc").keyup(function(){
        if($(this).val()=='' && jobcat!=''){
            $('#addDesc').prop('disabled',false);
        }
     });

   
    //remove job description by table
    $("#tbl_payment tbody").on('click', '.remove', function() {
    // $('#tbl_payment tbody').on('click', 'tr', function() {
        removeJob = $(this).attr('job');
        removeJobId = $(this).attr('jobid');
        removeCat = $(this).attr('jobcat');
        jobArr.splice( $.inArray(removeJob,jobArr) ,1 );
        jobNumArr.splice( $.inArray(removeJobId,jobNumArr) ,1 );
        jobcatArr.splice( $.inArray(removeCat,jobcatArr) ,1 );
        $("#jobArr").val(JSON.stringify(jobArr));$("#jobNumArr").val(JSON.stringify(jobNumArr));
        $("#jobCatArr").val(JSON.stringify(jobcatArr));
        $(this).parent().parent().remove();
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
                        loadInvoicetoPrint(lastproduct_code);
                        $("#modelNotifi").html(lastproduct_code + " Job card successfully saved.");
                        $.notify("Job card updated successfully.", "success");
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
        $("#NewVehicle").prop('disabled',false);
         jobNo = $("#jobNo").val();
            clearCustomerData();
            clearVehicleData();
            $("#tbl_payment tbody").html("");
            total_due_amount = 0;
            total_over_payment = 0;
            clearCustomerData();
            clearVehicleData();
            loadInvoicetoPrint(jobNo);
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
                    loc = resultData.job_data.JLocation;
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
                    regNo = resultData.vehicle_data.RegNo;
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
                    $("#nextService").val(resultData.job_data.NextService);
                    $("#payType").val(resultData.job_data.JPayType);
                    // $("#insdoc").val(resultData.job_data.JIsInsDoc);
                    $("#odoInUnit").val(resultData.job_data.OdoInUnit);
                    $("#odoOutUnit").val(resultData.job_data.OdoOutUnit);
                    $("#nextMileage").html(parseFloat(resultData.job_data.OdoIn)+parseFloat(resultData.job_data.NextService));
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
                    $("#advanceno").val(resultData.job_data.JAdvanceNo);



                    if($.inArray(resultData.job_data.JCusType, companyShowArr )>-1){
                        $("#vehicleCompany").show();
                    }else{ 
                        $("#vehicleCompany").hide(); 
                    }            

                    for (var i =  0; i < resultData.job_desc.length; i++) {
                         k=(i+1);
                        jobArr.push(resultData.job_desc[i].JobDescription);
                        jobNumArr.push(resultData.job_desc[i].JobDescId);
                        jobcatArr.push(resultData.job_desc[i].JobCategory);
                        $("#jobArr").val(JSON.stringify(jobArr));
                        $("#jobNumArr").val(JSON.stringify(jobNumArr));
                        $("#jobCatArr").val(JSON.stringify(jobcatArr));
                     $("#tbl_payment tbody").append("<tr job='" + resultData.job_desc[i].JobDescription + "' jobcat='" + resultData.job_desc[i].JobCategory + "'  jobid='" + resultData.job_desc[i].JobDescId + "' jobcategory='" + resultData.job_desc[i].job_category + "'><td>" + (k) + "</td><td></td><td>" + resultData.job_desc[i].JobDescription + "</td><td><span  class='remove btn btn-danger btn-xs'>Remove</span></td></tr>");
            
                    }
                    
                }
            });
    }

 $("#btnPrint").click(function() {
         setTimeout(function(){$('#printArea').focus().print();},1000);
    });

    function loadInvoicetoPrint(JobNo){

        $("#tbl_jobcard_data tbody").html('');
        $.ajax({
                type: "POST",
                url: "../../job/getJobDataById",
                data: { jobNo: JobNo},
                success: function(data)
                {
                    var resultData = JSON.parse(data);

                    // $("#lblcusName").html(resultData.cus_data.CusName);
                    $("#lblcusCode").html(resultData.cus_data.CusCode);
                    $("#lblAddress").html(nl2br(resultData.cus_data.Address01)+"<br>"+resultData.cus_data.Address02+" "+resultData.cus_data.Address03);
                    // $("#cusPhone").html(resultData.cus_data.MobileNo);
                    $("#lblpaymentType").html(resultData.cus_data.payType);
                    $("#lblemail").html(resultData.cus_data.Email);
                    $("#lblCusName").html(resultData.cus_data.CusName);
                    
                    $("#lblcusName").html(resultData.vehicle_data.contactName);
                    
                    // $("#registerNo").html(resultData.vehicle_data.RegNo);
                    $("#lblmake").html(resultData.vehicle_data.make);
                    $("#lblmodel").html(resultData.vehicle_data.model);
                    $("#lblFuelType").html(resultData.vehicle_data.fuel_type);
                    $("#lblviNo").html(resultData.vehicle_data.ChassisNo);
                    // $("#engNo").html(resultData.vehicle_data.EngineNo);
                    // $("#yom").html(resultData.vehicle_data.ManufactureYear);
                    $("#lblcountry").html(resultData.vehicle_data.body_color);

                    $("#lblcusCode").html(resultData.cus_data.CusCode);
                    $("#lblJobNo").html(resultData.job_data.JobCardNo);
                    $("#lblregNo").html(resultData.job_data.JRegNo);
                    $("#lblnoofjobs").html(resultData.job_count.noofjobs);
                    // $("#vehicleCompany").html(resultData.job_data.JCusCompany);
                    $("#lblOdo").html(resultData.job_data.OdoOut);
                    if(resultData.job_data.NextService>0){
                        $("#lblNextService").html(parseFloat(resultData.job_data.OdoIn)+parseFloat(resultData.job_data.NextService));
                    }// $("#odoOut").html(resultData.job_data.OdoOut);
                    // $("#prevJobNum").html(resultData.job_data.PrevJobNo);
                    $("#partNo").html(resultData.job_data.SparePartJobNo);
                    $("#lblSAName").html(resultData.job_data.serviceAdvisor);
                    $("#lblTel").html(resultData.job_data.advisorContact);
                    $("#lbldate").html(resultData.job_data.appoimnetDate);
                    $("#lbldelveryDate").html((resultData.job_data.deliveryDate).substring(0, 10)); 
                    $("#lbldelveryTime").html((resultData.job_data.deliveryDate).substring(10, 19)); 
                    
                            
                    for (var i =  0; i < resultData.job_desc.length; i++) {
                         k=(i+1);
                     $("#tbl_jobcard_data tbody").append("<tr><td>" + (k) + "</td><td>" + resultData.job_desc[i].JobDescription + "</td><td>&nbsp;</td><td>&nbsp;</td></tr>");
            
                    }
                    $("#tbl_jobcard_data tbody").append("<tr><td></td><td></td><td>&nbsp;</td><td>&nbsp;</td></tr>");
                    $("#tbl_jobcard_data tbody").append("<tr><td></td><td></td><td>&nbsp;</td><td>&nbsp;</td></tr>");
                    $("#tbl_jobcard_data tbody").append("<tr><td></td><td></td><td>&nbsp;</td><td>&nbsp;</td></tr>");
                    $("#btnPrint").prop('disabled',false);

            
                }
            });
    }

      // add job decription
    $('#addDesc').click(function(e) {


        var jobcat = $("#jobcategory option:selected").val();
        var jobdesc = $("#jobdesc").val();

        if(jobcat=='' || jobcat==0){
            $.notify("Please select a job category", "danger");
        }else if(jobdesc=='' || jobdesc==0){
            $.notify("Please enter  a descriptions", "danger");
        }else{
            $.ajax({
                type: "post",
                url: "../../master/addJobCardDescription",
                data: {name:jobdesc,jobCardCategory:jobcat},
                success: function (json) {
                    var resultData = JSON.parse(json);
                    var feedback = resultData['fb'];
                    var val = resultData['JobDescNo'];
                    var dec = resultData['JobDescription'];

                    if (feedback == true) {
                        val2=val;
                        $.notify("Job Description saved successfully.", "success");
                        $('#addDesc').prop('disabled',true);
                     }
                },
                error: function () {
                    $.notify("Error while request...", "danger");
                }
            });
        }
        
        e.preventDefault();
    });

     function nl2br (str, is_xhtml) {
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }
});

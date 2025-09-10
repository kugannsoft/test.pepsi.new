$(document).ready(function() {

    $('#appoDate,#deliveryDate').datetimepicker({ dateFormat: 'yy-mm-dd',timeFormat: "HH:mm:ss"});
    $('#appoDate').datetimepicker().datetimepicker("setDate", new Date());
    $("#vehicleCompany,#vcompany").hide();
    $("#invLink").prop('disabled',true);
    $("#estLink").prop('disabled',true);
    $("#NewVehicle").prop('disabled',true);
    $("#divprevjob").hide(); 

    $('.prd_icheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '50%'
    });

    var cusCode = 0;
    var paymentNo = 0;
    var cusType = 2;
    var regNo =0;
    //show hide company by customer type
    var companyShowArr=['5'];
    $("#btnPrint").prop('disabled',true);
    $("#btnLabourPrint").prop('disabled',true);

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
    $("#removeadv").click(function(){
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
            total_due_amount = 0;
            total_over_payment = 0;
            loadCustomerDatabyId(cusCode);
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
             regNo = ui.item.value;
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
                        $("#lblmake").html(resultData.make);
                        $("#lblmodel").html(resultData.model);
                        $("#fuel").html(resultData.fuel_type);
                        $("#chassi").html(resultData.ChassisNo);
                        $("#engNo").html(resultData.EngineNo);
                        $("#yom").html(resultData.ManufactureYear);
                        $("#color").html(resultData.body_color);

                        loadCustomerDatabyId(resultData.CusCode);
                    }
                }
            });
        }
    });

    var regnum=0;

    regnum =$("#regNo").val();

    if (regnum != '') {
        $.ajax({
                type: "POST",
                url: "../../Job/getVehicleDetailsById",
                data: { id: regnum},
                success: function(data)
                {
                    var resultData = JSON.parse(data);
                    if(resultData){
                        regNo=resultData.RegNo;
                        cusCode=resultData.CusCode;
                        $("#contactName").html(resultData.contactName);
                        $("#registerNo").html(resultData.RegNo);
                        $("#lblmake").html(resultData.make);
                        $("#lblmodel").html(resultData.model);
                        $("#fuel").html(resultData.fuel_type);
                        $("#chassi").html(resultData.ChassisNo);
                        $("#engNo").html(resultData.EngineNo);
                        $("#yom").html(resultData.ManufactureYear);
                        $("#color").html(resultData.body_color);
                        loadCustomerDatabyId(resultData.CusCode);
                    }
                }
            });
    } 

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

    //load companies by customer type
    // $("#cusType").change(function() {
    //     if ($.inArray($(this).val(), companyShowArr) > -1) {
    //         $("#vehicleCompany").show();
    //     } else {
    //         $("#vehicleCompany").hide();
    //     }
    //     $("#vehicleCompany").html("");
    //     $("#vehicleCompany").append("<option value=''>Select a company</option>");
    //     var custype = $("#cusType option:selected").val();
    //     $.ajax({
    //         type: "POST",
    //         url: "../job/loadCompanyByCusType",
    //         data: { custype: custype },
    //         success: function(data) {
    //             var resultData = JSON.parse(data);
    //             if (resultData) {
    //                 $.each(resultData, function(key, value) {
    //                     $("#vehicleCompany").append("<option value='" + value.VComId + "'>" + value.VComName + "</option>");
    //                 });
    //             }
    //         }
    //     });
    // });

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
        
        var odo = $("#odoIn").val();
        var jobtype = $("#jobtype option:selected").val();
        var jobSection = $("#jobSection option:selected").val();
        var jobCat = $("#jobcategory option:selected").val();
        var jobCategory = $("#jobcategory option:selected").html();
        e.preventDefault();
        var jobdata = $("#jobArr").val();
        $("#modelNotifi").html('');
        if(regNo=='' || regNo==0){
            $.notify("Please select a vehicle.", "danger");
        }else if(cusCode=='' || cusCode==0){
            $.notify("Please select a customer..", "danger");
        }else if(odo=='' || odo==0) {
            $.notify("Please add Odo meter In.", "danger");
        }else if(jobtype=='' || jobtype==0) {
            $.notify("Please select a job type.", "danger");
        }else if(jobSection=='' || jobSection==0) {
            $.notify("Please select a job section.", "danger");
        }else if(jobArr.length == 0) {
            $.notify("Please add job descriptions.", "danger");
        }else if(jobtypes.length == 0) {
            $.notify("Please select a job type.", "danger");
        }
        else{
            $('#saveJob').attr('disabled', true);
            $.ajax({
                url: "../../job/saveJob",
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
                        $.notify("Job card saved successfully.", "success");
                        $("#modelNotifi").html(" Last Job No- "+lastproduct_code);
                        $('#saveJob').attr('disabled', true);
                        genarateInvLink(lastproduct_code);
                        genarateEstLink(lastproduct_code);
                        genarateJobView(lastproduct_code);
                    } else {
                        $("#lastJob").html('');
                        $('#saveJob').attr('disabled', false);
                    }
                }
            });
        } 
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
            $("#lblmake").html('');
            $("#lblmodel").html('');
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
        }
    }

    $("#btnPrint").click(function() {
        $("#foot").show();
        setTimeout(function(){$('#printArea').focus().print();},1000);
    });

    $("#btnLabourPrint").click(function() {
        $("#foot").hide();
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
                    

                    $("#lblCusName").html(resultData.cus_data.CusName);
                    $("#lblcusCode").html(resultData.cus_data.CusCode);
                    $("#lblAddress").html(nl2br(resultData.cus_data.Address01)+"<br>"+resultData.cus_data.Address02+" "+resultData.cus_data.Address03);
                    // $("#cusPhone").html(resultData.cus_data.MobileNo);
                    $("#lblpaymentType").html(resultData.cus_data.payType);
                    $("#lblemail").html(resultData.cus_data.Email);
                    
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
                    }
                    // $("#odoOut").html(resultData.job_data.OdoOut);
                    // $("#prevJobNum").html(resultData.job_data.PrevJobNo);
                    $("#partNo").html(resultData.job_data.SparePartJobNo);
                    $("#lblSAName").html(resultData.job_data.serviceAdvisor);
                    $("#lblTel").html(resultData.job_data.advisorContact);
                    $("#lbldate").html(resultData.job_data.appoimnetDate);
                     $("#lbldelveryDate").html((resultData.job_data.deliveryDate).substring(0, 10)); 
                    $("#lbldelveryTime").html((resultData.job_data.deliveryDate).substring(10, 19));  

                    for (var i =  0; i < resultData.job_desc.length; i++) {
                         k=(i+1);
                     $("#tbl_jobcard_data tbody").append("<tr><td style='text-align: center;'>" + (k) + "</td><td style='padding-left: 5px;'>" + resultData.job_desc[i].JobDescription + "</td><td>&nbsp;</td><td>&nbsp;</td></tr>");
            
                    }
                    $("#tbl_jobcard_data tbody").append("<tr><td style='height:150px;'></td><td style='height:150px;'></td><td style='height:150px;'></td><td style='height:150px;'></td></tr>");

                    $("#btnPrint").prop('disabled',false);
                    $("#btnLabourPrint").prop('disabled',false);
                }
            });
    }

    function loadCustomerDatabyId(customer){
        clearCustomerData();
        $("#NewVehicle").prop('disabled',false);
        $.ajax({
                type: "POST",
                url: "../../Payment/getCustomersDataById",
                data: { cusCode: customer},
                success: function(data)
                {
                    var resultData = JSON.parse(data);

                    cusCode = resultData.cus_data.CusCode;
                    outstanding = resultData.cus_data.CusOustandingAmount;
                    available_balance = parseFloat(resultData.cus_data.CreditLimit) - parseFloat(outstanding);
                    customer_name=resultData.cus_data.CusName;
                    var encode_url = "../../Payment/view_customer/"+(cusCode);

                    $("#cusName").html("<a href='"+encode_url+"'>"+resultData.cus_data.CusName+"</a>");
                    $("#customer,#cusCode").val(resultData.cus_data.CusCode);
                    $("#creditLimit").html(accounting.formatMoney(resultData.cus_data.CreditLimit));
                    $("#creditPeriod").html(resultData.cus_data.CreditPeriod);
                    $("#cusOutstand").html(accounting.formatMoney(outstanding));
                    $("#availableCreditLimit").html(accounting.formatMoney(available_balance));
                    $("#cusAddress").html(nl2br(resultData.cus_data.Address01)+"<br>");
                    $("#cusAddress2").html(resultData.cus_data.Address03);
                    $("#cusPhone").html(resultData.cus_data.MobileNo);
                    $("#cusType").val(resultData.cus_data.CusType);
                    $("#cusType2").val(resultData.cus_data.CusType);
                    if(resultData.cus_data.CusCompany>0){
                         $("#vehicleCompany").show();
                    }
                    $("#vehicleCompany").val(resultData.cus_data.CusCompany);
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


    function genarateJobView(job_no){
        $("#jobLink").attr('disabled',false);
        if(job_no!=''){
            $("#jobLink").attr("href","../../../admin/job/view_job_card/"+Base64.encode(job_no));    
        }
    }


    function genarateInvLink(job_no){
        $("#invLink").attr('disabled',false);
        if(job_no!=''){
            $("#invLink").attr("href","../../../admin/Salesinvoice/job_invoice?type=job&id="+Base64.encode(job_no));    
        }
    }

    function genarateEstLink(job_no){
        $("#estLink").attr('disabled',false);
        if(job_no!=''){
            $("#estLink").attr("href","../../../admin/job/estimate_job/"+Base64.encode(job_no));    
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

                    input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

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
                    string = string.replace(/\r\n/g, "\n");
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

    function nl2br (str, is_xhtml) {
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }

});

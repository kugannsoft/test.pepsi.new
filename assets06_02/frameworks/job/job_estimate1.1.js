$(document).ready(function() {

    $('#appoDate,#deliveryDate').datetimepicker({ dateFormat: 'yy-mm-dd', timeFormat: "HH:mm:ss" });
    $('#appoDate').datetimepicker().datetimepicker("setDate", new Date());
    // $("#vehicleCompany").hide();
    $("#action").val(1);
    $('.prd_icheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '50%'
    });
    $("#invLink").attr('disabled',true);
    $("#vehicleCompany").hide();
    $("#dvInsurance").hide();
    $("#spartDiv").hide();
    $("#estimate_head").hide();
    $("#general_head").hide();
    var cusCode = 0;
    var jobNo = 0;
    var paymentNo = 0;
    var cusType = 2;
    var k = 1;
    var workType = 0;
    //show hide company by customer type
    var companyShowArr = ['3', '4'];
    var loc = $("#location").val();
    var price_level = 1;
    var totalAmount = 0;
    var isInsurance = 0;
    var action = 1;
    var SupNumber = 0;
    var estimateNo = 0;
    var itemCode =0;

    $("#addProduct").click(function(){
            $('.modal-content').load('../product/loadmodal_addproduct/', function (result) {
                $('#productmodal').modal({show: true,backdrop: 'static', keyboard: false});
            });
        });

    //load companies by customer type
    $("#cusType").change(function() {
        if ($.inArray($(this).val(), companyShowArr) > -1) {
            $("#vehicleCompany").show();
        } else {
            $("#vehicleCompany").hide();
        }
        $("#vehicleCompany").html("");
        $("#vehicleCompany").append("<option value=''>Select a company</option>");
        var custype = $("#cusType option:selected").val();
        $.ajax({
            type: "POST",
            url: "../job/loadCompanyByCusType",
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
                url: '../job/loadjobjson',
                dataType: "json",
                data: {
                    q: request.term
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
            clearCustomerData();
            clearVehicleData();
            clearInvoiceData();
            clearEstimateData();
            jobNo = ui.item.value;
            
            $("#tbl_payment tbody").html("");
            $("#tbl_job tbody").html('');
            total_due_amount = 0;
            total_over_payment = 0;
            $("#btnViewJob").attr('disabled', false);
            $.ajax({
                type: "POST",
                url: "../job/getEstimateDataByJobNo",
                data: { jobNo: jobNo },
                success: function(data) {
                    var resultData = JSON.parse(data);

                    setGridandLabelData(resultData);

                    loadEstimateDatatoGrid(resultData);
                    genarateInvLink(estimateNo,SupNumber);
                }
            });
        }
    });

    //estimate no autoload
    $("#estimateNo").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../job/loadestimatejson',
                dataType: "json",
                data: {
                    q: request.term
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
            clearCustomerData();
            clearVehicleData();
            clearInvoiceData();
            estimateNo = ui.item.value;
            
            $("#tbl_payment tbody").html("");
            $("#tbl_job tbody").html('');
            total_due_amount = 0;
            total_over_payment = 0;
            $("#btnViewJob").attr('disabled', false);
            SupNumber = 0;
            $.ajax({
                type: "POST",
                url: "../job/getEstimateDataByEstimateNo",
                data: { estimateNo: estimateNo, supplimentNo: SupNumber },
                success: function(data) {
                    var resultData = JSON.parse(data);

                    setGridandLabelData(resultData);

                    loadEstimateDatatoGrid(resultData);
                    genarateInvLink(estimateNo,SupNumber);
                }
            });
        }
    });

    //estimate no autoload
    $("#supplemetNo").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../job/loadsupplemetnojson',
                dataType: "json",
                data: {
                    q: request.term,
                    estimateNo: estimateNo
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

            clearCustomerData();
            clearVehicleData();
            clearInvoiceData();
            SupNumber = ui.item.value;
            
            $("#tbl_payment tbody").html("");
            $("#tbl_job tbody").html('');
            total_due_amount = 0;
            total_over_payment = 0;
            $("#btnViewJob").attr('disabled', false);
            $.ajax({
                type: "POST",
                url: "../job/getEstimateDataByEstimateNo",
                data: { estimateNo: estimateNo, supplimentNo: SupNumber },
                success: function(data) {
                    var resultData = JSON.parse(data);

                    setGridandLabelData(resultData);

                    loadEstimateDatatoGrid(resultData);
                    genarateInvLink(estimateNo,SupNumber);
                }
            });
        }
    });

    // autoload estimate by est number
    estimateNo = $("#estimateNo").val();
    SupNumber = $("#supplemetNo").val();

    if(estimateNo!=''){
        getEstByEstNoAndSupNo(estimateNo,SupNumber);
    }


    function getEstByEstNoAndSupNo(est,sup){
        clearCustomerData();
            clearVehicleData();
            clearInvoiceData();
        
            $("#tbl_payment tbody").html("");
            $("#tbl_job tbody").html('');
            total_due_amount = 0;
            total_over_payment = 0;
            $("#btnViewJob").attr('disabled', false);
            $.ajax({
                type: "POST",
                url: "../job/getEstimateDataByEstimateNo",
                data: { estimateNo: est, supplimentNo: sup },
                success: function(data) {
                    var resultData = JSON.parse(data);

                    setGridandLabelData(resultData);

                    loadEstimateDatatoGrid(resultData);
                    genarateInvLink(est,sup);
                }
            });
    }

    function setGridandLabelData(data) {
        if (data.cus_data) {
            cusCode = data.cus_data.CusCode;
            outstanding = data.cus_data.CusOustandingAmount;
            available_balance = parseFloat(data.cus_data.CreditLimit) - parseFloat(outstanding);
            customer_name = data.cus_data.CusName;
            $("#cusName,#lblCustomer").html(data.cus_data.CusName);
            $("#customer").val(data.cus_data.CusCode);
            $("#creditLimit").html(accounting.formatMoney(data.cus_data.CreditLimit));
            $("#creditPeriod").html(data.cus_data.CreditPeriod);
            $("#cusOutstand").html(accounting.formatMoney(outstanding));
            $("#availableCreditLimit").html(accounting.formatMoney(available_balance));
            $("#cusAddress").html(data.cus_data.Address01 + ", " + data.cus_data.Address02);
            $("#cusAddress2").html(data.cus_data.Address03);
            $("#cusPhone").html(data.cus_data.MobileNo);
            $("#cusCode").val(data.cus_data.CusCode);
        }

        if (data.vehicle_data) {
            regNo = data.vehicle_data.RegNo
            $("#contactName").html(data.vehicle_data.contactName);
            $("#regNo").val(data.vehicle_data.RegNo);
            $("#make").html(data.vehicle_data.make);
            $("#model").html(data.vehicle_data.model);
            $("#fuel").html(data.vehicle_data.fuel_type);
            $("#chassi").html(data.vehicle_data.ChassisNo);
            $("#engNo").html(data.vehicle_data.EngineNo);
            $("#yom").html(data.vehicle_data.ManufactureYear);
            $("#color").html(data.vehicle_data.body_color);
        }

        if (data.job_data) {
            // $("#regNo").val(data.job_data.JRegNo);
            $("#cusType").val(data.job_data.JCusType);
            $("#vehicleCompany").val(data.job_data.JCusCompany);
            $("#odoIn").val(data.job_data.OdoIn);
            $("#odoOut").val(data.job_data.OdoOut);
            $("#prevJobNum").val(data.job_data.PrevJobNo);
            $("#sparePartCNo").val(data.job_data.SparePartJobNo);
            $("#advisorName").val(data.job_data.serviceAdvisor);
            $("#advisorPhone").val(data.job_data.advisorContact);
            $("#appoDate").val(data.job_data.appoimnetDate);
            $("#deliveryDate").val(data.job_data.deliveryDate);
            $("#estimateNo").val(data.job_data.JestimateNo);
            
            $("#jobSection").val(data.job_data.Jsection);
            $("#advance").val(data.job_data.Advance);
            if (data.job_data.JCusType == 3) {
                $("#vehicleCompany").show();
                $("#dvInsurance").show();
                $("#jobType").val(1);
            }else if (data.job_data.JCusType == 1) {
                $("#vehicleCompany").hide();
                $("#dvInsurance").hide();
                $("#jobType").val(2);
            } else {
                $("#vehicleCompany").hide();
                $("#dvInsurance").hide();
                $("#jobType").val(data.job_data.JCusType);
            }

        }
    }

    $("#jobType").change(function() {
        if ($(this).val() == 1) {
            $("#vehicleCompany").show();
            $("#dvInsurance").show();
            $("#estimate_head").show();
            $("#general_head").hide();
        } else {
            $("#vehicleCompany").hide();
            $("#dvInsurance").hide();
            $("#estimate_head").hide();
            $("#general_head").show();
        }
    });

var isJobVat=0;
var isJobNbt=0;
var isJobNbtRatio=0;
// var partType = 0;
    $("#workType").change(function() {
        workType = 0;
        workType = $("#workType").val();
        isJobVat = parseFloat($("#workType option:selected").attr('isVat'));
        isJobNbt = parseFloat($("#workType option:selected").attr('isNbt'));
        isJobNbtRatio = parseFloat($("#workType option:selected").attr('nbtRatio'));

        if (workType == 1) {
            $("#spartDiv").hide();
            $("#jobDescDiv").show();
            $("#partType").prop("disabled",true);
        } else if (workType == 2) {
            $("#spartDiv").show();
            $("#jobDescDiv").hide();
            $("#partType").prop("disabled",false);
        } else if (workType == 3) {
            $("#spartDiv").hide();
            $("#jobDescDiv").show();
            $("#partType").prop("disabled",false);
        }else if (workType == 9) {
            $("#spartDiv").hide();
            $("#jobDescDiv").show();
            $("#partType").prop("disabled",false);
        } else {
            $("#jobDescDiv").show();
            $("#spartDiv").hide();
            $("#partType").prop("disabled",true);
        }
    });

    var jobArr = [];
    var jobNumArr = [];
    var removeJob = 0;
    var jobRef = 0;
    var proCodeArr = [];
    var paintsArr = [];
    var parts2Arr = [];
    var parts3Arr = [];
    var totalNet=0;
    var totalPrice=0;
    var totalNetAmount=0;
    var totalProVAT=0;
    var totalProNBT=0;
    var finalVat=0;
    var finalNbt=0;

    $("#jobdesc2").change(function() {
        var val = $("#jobdesc2 option:selected").html();
        $("#jobdesc").val(val);
    });
var partType = '';
    // var k=0;
    // ADD job descriptions
    $("#addJob").click(function() {
        var jobdesc = $("#jobdesc").val();
        // var val2 = $("#jobdesc2 option:selected").val();
        var workTypes = $("#workType option:selected").html();
        partType = $("#partType option:selected").val();
        var workId = $("#workType option:selected").val();
        var workOrder = $("#workType option:selected").attr('jobOrder');
        var no = $("#no").val();
        var qty = parseFloat($("#qty").val());
        var insurance = $("#insurancer option:selected").val();
        var sellPrice = parseFloat($("#sellPrice").val());
        var proCode = $("#product").val();
        var proName = $("#prdName").val();
        var timestamp = $("#timestamp").val();
        isInsurance = $("input[name='isInsurance']:checked").val();
        var isNewVat = $("input[name='isProVat']:checked").val();
        var isNewNbt = $("input[name='isProNbt']:checked").val();
        var newNbtRatio = parseFloat($("#proNbtRatio").val());

        if(isNaN(qty) == true){
            $.notify("Qty can not be empty.", "warning");return false;
        }else if(isNaN(sellPrice) == true){
            $.notify("Unit Price can not be empty.", "warning");return false;
        }else{

            if (workId == 1 && jobdesc != '') {
                var jobArrIndex = $.inArray(jobRef, jobNumArr);

                if (jobArrIndex < 0) {
                    netprice = qty * sellPrice;
                    totalPrice= qty * sellPrice;
                    proVat=addProductVat((totalPrice),isNewVat,isNewNbt,newNbtRatio);
                    proNbt=addProductNbt((totalPrice),isNewVat,isNewNbt,newNbtRatio) ;
                    netprice +=proVat ;
                    netprice +=proNbt ;
                    $("#tbl_job tbody").append("<tr partType='"+partType+"' totalPrice='"+totalPrice+"' isvat='"+isNewVat+"' isnbt='"+isNewNbt+"' nbtRatio='"+newNbtRatio+"' proVat='"+proVat+"' proNbt='"+proNbt+"' job='" + jobdesc + "' jobid='" + workId + "' qty='" + qty + "' jobOrder='" + workOrder + "'  netprice='" + netprice + "' sellprice='" + sellPrice + "' isIns='" + isInsurance + "' insurance='" + insurance + "' work_id='" + jobRef + "' timestamp='" + timestamp + "'><td>" + k + "</td><td work_id='" + workId + "'>" + workTypes + "</td><td>" + jobdesc + "</td><td>" + accounting.formatNumber(qty) + "</td><td>" + accounting.formatNumber(sellPrice) + "</td><td>" + accounting.formatNumber(netprice) + "</td><td>" + insurance + "</td><td>&nbsp;<i class='glyphicon glyphicon-edit edit btn btn-info btn-xs'></i>&nbsp;<i class='remove btn btn-danger btn-xs glyphicon glyphicon-remove-circle'></i></td></tr>");
                    if (jobRef != 0 || jobRef != '') { jobNumArr.push(jobRef); }
                    $("#jobdesc").val('');
                    $("#jobdesc2").val('');
                   totalAmount += parseFloat(totalPrice);
                    totalNetAmount +=parseFloat(netprice);
                    totalProVAT+=parseFloat(proVat);
                    totalProNBT+=parseFloat(proNbt);
                    clearProductData();
                    k++;
                } else {
                    //alert("Job Already exists");
                    $.notify("Job Already exists.", "warning");
                }
            } else if (workId == 2 && proCode) {

                if (workId == 2 && itemCode!='') {
                    var productArrIndex = $.inArray(proCode, proCodeArr);

                    if (productArrIndex < 0) {
                        netprice = qty * sellPrice;
                        totalPrice= qty * sellPrice;
                        proVat=addProductVat((totalPrice),isNewVat,isNewNbt,newNbtRatio);
                        proNbt=addProductNbt((totalPrice),isNewVat,isNewNbt,newNbtRatio) ;
                        netprice +=proVat ;
                        netprice +=proNbt ;
                        $("#tbl_job tbody").append("<tr partType='"+partType+"' totalPrice='"+totalPrice+"' isvat='"+isNewVat+"' isnbt='"+isNewNbt+"' nbtRatio='"+newNbtRatio+"' proVat='"+proVat+"' proNbt='"+proNbt+"' job='" + proName + "' jobid='" + workId + "' qty='" + qty + "' jobOrder='" + workOrder + "' netprice='" + netprice + "'  sellprice='" + sellPrice + "'  isIns='" + isInsurance + "' insurance='" + insurance + "' work_id='" + proCode + "' timestamp='" + timestamp + "'><td>" + k + "</td><td work_id='" + workId + "'>" + workTypes + "</td><td>" + proName + "</td><td>" + accounting.formatNumber(qty) + "</td><td>" + accounting.formatNumber(sellPrice) + "</td><td>" + accounting.formatNumber(netprice) + "</td><td>" + insurance + "</td><td>&nbsp;<i class='glyphicon glyphicon-edit edit btn btn-info btn-xs'></i>&nbsp;<i class='remove btn btn-danger btn-xs glyphicon glyphicon-remove-circle'></i></td></tr>");
                        if (proCode != 0 || proCode != '') { proCodeArr.push(proCode); }
                        $("#prdName").val('');
                        $("#product").val('');
                        if (isInsurance == 1) {

                        } else {
                            totalAmount += parseFloat(totalPrice);
                            totalNetAmount +=parseFloat(netprice);
                            totalProVAT+=parseFloat(proVat);
                            totalProNBT+=parseFloat(proNbt);
                        }
                        k++;
                        clearProductData();
                    } else {
                        //alert("Product Already exists");
                        $.notify("Job Already exists.", "warning");

                    }
                }else {
                    $.notify("Please Select a product. This is not in system", "warning");
                }
            } else if (workId == 3 && jobdesc != '') {
                //paints
                var paintArrIndex = $.inArray(jobRef, paintsArr);

                if (paintArrIndex < 0) {
                    netprice = qty * sellPrice;
                  totalPrice= qty * sellPrice;
                    proVat=addProductVat((totalPrice),isNewVat,isNewNbt,newNbtRatio);
                    proNbt=addProductNbt((totalPrice),isNewVat,isNewNbt,newNbtRatio) ;
                    netprice +=proVat ;
                    netprice +=proNbt ;
                    $("#tbl_job tbody").append("<tr partType='"+partType+"' totalPrice='"+totalPrice+"' isvat='"+isNewVat+"' isnbt='"+isNewNbt+"' nbtRatio='"+newNbtRatio+"' proVat='"+proVat+"' proNbt='"+proNbt+"' job='" + jobdesc + "' jobid='" + workId + "' qty='" + qty + "' jobOrder='" + workOrder + "'  netprice='" + netprice + "' sellprice='" + sellPrice + "' isIns='" + isInsurance + "' insurance='" + insurance + "' work_id='" + jobRef + "' timestamp='" + timestamp + "'><td>" + k + "</td><td work_id='" + workId + "'>" + workTypes + "</td><td>" + jobdesc + "</td><td>" + accounting.formatNumber(qty) + "</td><td>" + accounting.formatNumber(sellPrice) + "</td><td>" + accounting.formatNumber(netprice) + "</td><td>" + insurance + "</td><td>&nbsp;<i class='glyphicon glyphicon-edit edit btn btn-info btn-xs'></i>&nbsp;<i class='remove btn btn-danger btn-xs glyphicon glyphicon-remove-circle'></i></td></tr>");
                    if (jobRef != 0 || jobRef != '') { paintsArr.push(jobRef); }
                    $("#jobdesc").val('');
                    $("#jobdesc2").val('');
                   totalAmount += parseFloat(totalPrice);
                    totalNetAmount +=parseFloat(netprice);
                    totalProVAT+=parseFloat(proVat);
                    totalProNBT+=parseFloat(proNbt);
                    clearProductData();
                    k++;
                } else {
                    //alert("Job Already exists");
                    $.notify("Job Already exists.", "warning");
                }
            } else if (workId == 4 && jobdesc != '') {
                //paints
                var parts2ArrIndex = $.inArray(jobRef, parts2Arr);

                if (parts2ArrIndex < 0) {
                    netprice = qty * sellPrice;
                    totalPrice= qty * sellPrice;
                    proVat=addProductVat((totalPrice),isNewVat,isNewNbt,newNbtRatio);
                    proNbt=addProductNbt((totalPrice),isNewVat,isNewNbt,newNbtRatio) ;
                    netprice +=proVat ;
                    netprice +=proNbt ;
                    $("#tbl_job tbody").append("<tr partType='"+partType+"' totalPrice='"+totalPrice+"' isvat='"+isNewVat+"' isnbt='"+isNewNbt+"' nbtRatio='"+newNbtRatio+"' proVat='"+proVat+"' proNbt='"+proNbt+"' job='" + jobdesc + "' jobid='" + workId + "' qty='" + qty + "' jobOrder='" + workOrder + "'  netprice='" + netprice + "' sellprice='" + sellPrice + "' isIns='" + isInsurance + "' insurance='" + insurance + "' work_id='" + jobRef + "' timestamp='" + timestamp + "'><td>" + k + "</td><td work_id='" + workId + "'>" + workTypes + "</td><td>" + jobdesc + "</td><td>" + accounting.formatNumber(qty) + "</td><td>" + accounting.formatNumber(sellPrice) + "</td><td>" + accounting.formatNumber(netprice) + "</td><td>" + insurance + "</td><td>&nbsp;<i class='glyphicon glyphicon-edit edit btn btn-info btn-xs'></i>&nbsp;<i class='remove btn btn-danger btn-xs glyphicon glyphicon-remove-circle'></i></td></tr>");
                    if (jobRef != 0 || jobRef != '') { parts2Arr.push(jobRef); }
                    $("#jobdesc").val('');
                    $("#jobdesc2").val('');
                   totalAmount += parseFloat(totalPrice);
                    totalNetAmount +=parseFloat(netprice);
                    totalProVAT+=parseFloat(proVat);
                    totalProNBT+=parseFloat(proNbt);
                    clearProductData();
                    k++;
                } else {
                    //alert("Job Already exists");
                    $.notify("Job Already exists.", "warning");
                }
            } else if (workId == 5 && jobdesc != '') {
                //paints
                var parts3ArrIndex = $.inArray(jobRef, parts3Arr);

                if (parts3ArrIndex < 0) {
                    netprice = qty * sellPrice;
                    totalPrice= qty * sellPrice;
                    proVat=addProductVat((totalPrice),isNewVat,isNewNbt,newNbtRatio);
                    proNbt=addProductNbt((totalPrice),isNewVat,isNewNbt,newNbtRatio) ;
                    netprice +=proVat ;
                    netprice +=proNbt ;
                    $("#tbl_job tbody").append("<tr partType='"+partType+"' totalPrice='"+totalPrice+"' isvat='"+isNewVat+"' isnbt='"+isNewNbt+"' nbtRatio='"+newNbtRatio+"' proVat='"+proVat+"' proNbt='"+proNbt+"' job='" + jobdesc + "' jobid='" + workId + "' qty='" + qty + "' jobOrder='" + workOrder + "'  netprice='" + netprice + "' sellprice='" + sellPrice + "' isIns='" + isInsurance + "' insurance='" + insurance + "' work_id='" + jobRef + "' timestamp='" + timestamp + "'><td>" + k + "</td><td work_id='" + workId + "'>" + workTypes + "</td><td>" + jobdesc + "</td><td>" + accounting.formatNumber(qty) + "</td><td>" + accounting.formatNumber(sellPrice) + "</td><td>" + accounting.formatNumber(netprice) + "</td><td>" + insurance + "</td><td>&nbsp;<i class='glyphicon glyphicon-edit edit btn btn-info btn-xs'></i>&nbsp;<i class='remove btn btn-danger btn-xs glyphicon glyphicon-remove-circle'></i></td></tr>");
                    if (jobRef != 0 || jobRef != '') { parts3Arr.push(jobRef); }
                    $("#jobdesc").val('');
                    $("#jobdesc2").val('');
                    totalAmount += parseFloat(totalPrice);
                    totalNetAmount +=parseFloat(netprice);
                    totalProVAT+=parseFloat(proVat);
                    totalProNBT+=parseFloat(proNbt);
                    clearProductData();
                    k++;
                } else {
                    //alert("Job Already exists");
                    $.notify("Job Already exists.", "warning");
                }
            }else{
                if (workId !=''  && jobdesc != ''){
                    netprice = qty * sellPrice;
                    totalPrice= qty * sellPrice;
                    proVat=addProductVat((totalPrice),isNewVat,isNewNbt,newNbtRatio);
                    proNbt=addProductNbt((totalPrice),isNewVat,isNewNbt,newNbtRatio) ;
                    netprice +=proVat ;
                    netprice +=proNbt ;
                    $("#tbl_job tbody").append("<tr partType='"+partType+"' totalPrice='"+totalPrice+"' isvat='"+isNewVat+"' isnbt='"+isNewNbt+"' nbtRatio='"+newNbtRatio+"' proVat='"+proVat+"' proNbt='"+proNbt+"' job='" + jobdesc + "' jobid='" + workId + "' qty='" + qty + "' jobOrder='" + workOrder + "'  netprice='" + netprice + "' sellprice='" + sellPrice + "' isIns='" + isInsurance + "' insurance='" + insurance + "' work_id='" + jobRef + "' timestamp='" + timestamp + "'><td>" + k + "</td><td work_id='" + workId + "'>" + workTypes + "</td><td>" + jobdesc + "</td><td>" + accounting.formatNumber(qty) + "</td><td>" + accounting.formatNumber(sellPrice) + "</td><td>" + accounting.formatNumber(netprice) + "</td><td>" + insurance + "</td><td>&nbsp;<i class='glyphicon glyphicon-edit edit btn btn-info btn-xs'></i>&nbsp;<i class='remove btn btn-danger btn-xs glyphicon glyphicon-remove-circle'></i></td></tr>");
                    if (jobRef != 0 || jobRef != '') { parts3Arr.push(jobRef); }
                    $("#jobdesc").val('');
                    $("#jobdesc2").val('');
                    totalAmount += parseFloat(totalPrice);
                    totalNetAmount +=parseFloat(netprice);
                    totalProVAT+=parseFloat(proVat);
                    totalProNBT+=parseFloat(proNbt);
                    clearProductData();
                    k++;
                }
            }

    }

        totalVat=addTotalVat(totalAmount,isTotalVat,isTotalNbt,nbtRatio);
        totalNbt=addTotalNbt(totalAmount,isTotalVat,isTotalNbt,nbtRatio);

        totalNet=parseFloat(totalNetAmount+totalVat+totalNbt);
        $("#totalAmount").html(accounting.formatNumber(totalAmount));
        $("#totalNet").html(accounting.formatNumber(totalNet));
        $("#totalVat").html(accounting.formatNumber(totalVat+totalProVAT));
        $("#totalNbt").html(accounting.formatNumber(totalNbt+totalProNBT));
        finalVat=totalVat+totalProVAT;
        finalNbt=totalNbt+totalProNBT;
    });
 
    //job descriptions
    $("#jobdesc").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../job/loadJobDescJsonByType',
                dataType: "json",
                data: {
                    q: request.term,
                    workType: workType
                },
                success: function(data) {
                    if (data) {
                        response($.map(data, function(item) {
                            return {
                                label: item.text,
                                value: item.text,
                                descId: item.id,
                                jobCost: item.jobCost,
                                isVat: item.isVat,
                                isNbt: item.isNbt,
                                nbtRatioo: item.nbtRatio,
                                data: item
                            }
                        }));
                    } else {
                        jobRef = 0;
                        jobCost = 0;
                        $("#qty").val(1);
                        $("#sellPrice").val(jobCost);
                    }
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function(event, ui) {
            if (ui) {
                //loadVATNBT(ui.item.isVat,ui.item.isNbt,ui.item.nbtRatioo);
                loadVATNBT(isJobVat,isJobNbt,isJobNbtRatio);
                jobRef = 0;
                jobRef = ui.item.descId;
                jobCost = ui.item.jobCost;
                $("#qty").val(1);
                $("#sellPrice").val(jobCost);
            } else {
                jobRef = 0;
                jobCost = 0;
                $("#qty").val(1);
                $("#sellPrice").val(jobCost);
            }
        }
    });

    $("#product").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../job/loadproductjson',
                dataType: "json",
                data: {
                    q: request.term,
                    type: 'getActiveProductCodes',
                    row_num: 1,
                    action: "getActiveProductCodes",
                    price_level: 1
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.label,
                            value: item.value,
                            data: item
                        }
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function(event, ui) {
            itemCode = ui.item.value;
            $.ajax({
                type: "post",
                url: "../Product/getProductByIdforGrn",
                data: { proCode: itemCode, prlevel: price_level, location: loc },
                success: function(json) {
                    var resultData = JSON.parse(json);
                    if (resultData) {
                        // $.each(resultData.serial, function(key, value) {
                        //     var serialNoArrIndex1 = $.inArray(value, serialnoarr);
                        //     if (serialNoArrIndex1 < 0) {
                        //         serialnoarr.push(value);
                        //     }
                        // });
                        // autoSerial = resultData.product.IsRawMaterial;
                        loadVATNBT(isJobVat,isJobNbt,isJobNbtRatio);
                        // loadVATNBT(resultData.product.IsTax,resultData.product.IsNbt,resultData.product.NbtRatio);
                        loadProModal(resultData.product.Prd_Description, resultData.product.ProductCode, resultData.product.ProductPrice, resultData.product.Prd_CostPrice, 0, resultData.product.IsSerial, resultData.product.IsFreeIssue, resultData.product.IsOpenPrice, resultData.product.IsMultiPrice, resultData.product.Prd_UPC, resultData.product.WarrantyPeriod, resultData.product.IsRawMaterial);
                    } else {
                        $("#errGrid").show();
                        $("#errGrid").html('Product not found ').addClass('alert alert-danger alert-dismissible alert-sm').fadeOut(2000);
                        $("#itemCode").val('');
                        $("#itemCode").focus();
                        return false;
                    }
                },
                error: function() {
                    alert('Error while request..');
                }
            });
        }
    });

    //barcode read
    $('#product').on('keydown', function(e) {
        if (e.which == 13) {
            proCode = $(this).val();
            $.ajax({
                type: "post",
                url: "../Product/getProductByBarCode",
                data: {proCode: proCode, prlevel: price_level, location: loc},
                success: function(json) {
                    var resultData = JSON.parse(json);
                    if (resultData) {
                        // $.each(resultData.serial, function(key, value) {
                        //     var serialNoArrIndex1 = $.inArray(value, serialnoarr);
                        //     if (serialNoArrIndex1 < 0) {
                        //         serialnoarr.push(value);
                        //     }
                        // });
                        // autoSerial = resultData.product.IsRawMaterial;
                        loadVATNBT(isJobVat,isJobNbt,isJobNbtRatio);
                        // loadVATNBT(resultData.product.IsTax,resultData.product.IsNbt,resultData.product.NbtRatio);
                        loadProModal(resultData.product.Prd_Description, resultData.product.ProductCode, resultData.product.ProductPrice, resultData.product.Prd_CostPrice, 0, resultData.product.IsSerial, resultData.product.IsFreeIssue, resultData.product.IsOpenPrice, resultData.product.IsMultiPrice, resultData.product.Prd_UPC, resultData.product.WarrantyPeriod, resultData.product.IsRawMaterial);
                    } else {
                        $("#errGrid").show();
                        $("#errGrid").html('Product not found ').addClass('alert alert-danger alert-dismissible alert-sm').fadeOut(2000);
                        $("#itemCode").val('');
                        $("#itemCode").focus();
                        return false;
                    }
                },
                error: function() {
                    alert('Error while request..');
                }
            });
            e.preventDefault();

        }
    });

    $("#tbl_job tbody").on('click', '.remove', function() {

        var jobtype = $(this).parent().parent().attr('jobid')

        var workid = $(this).parent().parent().attr('work_id');
        var r = confirm('Do you want to remove this row ?');
        if (r === true) {
            if (jobtype == 1) {
                jobNumArr.splice($.inArray(workid, jobNumArr), 1);
            } else if (jobtype == 2) {
                proCodeArr.splice($.inArray(workid, proCodeArr), 1);
            } else if (jobtype == 3) {
                paintsArr.splice($.inArray(workid, paintsArr), 1);
            } else if (jobtype == 4) {
                parts2Arr.splice($.inArray(workid, parts2Arr), 1);
            } else if (jobtype == 5) {
                parts3Arr.splice($.inArray(workid, parts3Arr), 1);
            }

            totalAmount -= parseFloat($(this).parent().parent().attr('totalPrice'));
            totalNetAmount -= parseFloat($(this).parent().parent().attr('netprice'));
            totalProVAT -= parseFloat($(this).parent().parent().attr('proVat'));
            totalProNBT -= parseFloat($(this).parent().parent().attr('proNbt'));
            totalVat=addTotalVat(totalAmount,isTotalVat,isTotalNbt,nbtRatio);
            totalNbt=addTotalNbt(totalAmount,isTotalVat,isTotalNbt,nbtRatio);

            $(this).parent().parent().remove();
            totalNet=parseFloat(totalNetAmount+totalVat+totalNbt);
            $("#totalAmount").html(accounting.formatNumber(totalAmount));
            $("#totalNet").html(accounting.formatNumber(totalNet));
            $("#totalVat").html(accounting.formatNumber(totalVat+totalProVAT));
            $("#totalNbt").html(accounting.formatNumber(totalNbt+totalProNBT));
            finalVat=totalVat+totalProVAT;
            finalNbt=totalNbt+totalProNBT;
        }
    });

    $("#btnSave").click(function() {
        var rows = $("#tbl_job tbody tr");
        var qty = [];
        var net_price = [];
        var sell_price = [];
        var is_ins = [];
        var insurance = [];
        var desc = [];
        var job_id = [];
        var job_order = [];
        var work_id = [];
        var timestamp = [];
        var isVat = [];
        var isNbt = [];
        var nbtRatio = [];
        var proVat = [];
        var proNbt = [];
        var totalPrice=[];
        var partType = [];

        $('#tbl_job tbody tr').each(function(rowIndex, element) {
            net_price.push($(this).attr('netprice'));
            qty.push($(this).attr('qty'));
            sell_price.push($(this).attr('sellprice'));
            is_ins.push($(this).attr('isIns'));
            insurance.push($(this).attr('insurance'));
            desc.push($(this).attr('job'));
            job_id.push($(this).attr('jobid'));
            job_order.push($(this).attr('jobOrder'));
            work_id.push($(this).attr('work_id')); //product code item code
            timestamp.push($(this).attr('timestamp'));
            isVat.push($(this).attr('isVat'));
            isNbt.push($(this).attr('isNbt'));
            nbtRatio.push($(this).attr('nbtRatio'));
            proVat.push($(this).attr('proVat'));
            proNbt.push($(this).attr('proNbt'));
            totalPrice.push($(this).attr('totalPrice'));
            partType.push($(this).attr('partType'));
        });

        var net_priceArr = JSON.stringify(net_price);
        var qtyArr = JSON.stringify(qty);
        var sell_priceArr = JSON.stringify(sell_price);
        var is_insArr = JSON.stringify(is_ins);
        var insuranceArr = JSON.stringify(insurance);
        var descArr = JSON.stringify(desc);
        var job_idArr = JSON.stringify(job_id);
        var job_orderArr = JSON.stringify(job_order);
        var work_idArr = JSON.stringify(work_id);
        var timestampArr = JSON.stringify(timestamp);
        var isVatArr = JSON.stringify(isVat);
        var isNbtArr = JSON.stringify(isNbt);
        var nbtRatioArr = JSON.stringify(nbtRatio);
        var proVatArr = JSON.stringify(proVat);
        var proNbtArr = JSON.stringify(proNbt);
        var totalPriceArr = JSON.stringify(totalPrice);
        var partTypeArr = JSON.stringify(partType);


        var supNum = $("#supplemetNo").val();
        estimateNo = $("#estimateNo").val();
        var esdate = $("#appoDate").val();
        var insCompany = $("#vehicleCompany").val();
        var estimate_type = $("#estimateType").val();
        var job_type = $("#jobType").val();
        var regNo = $("#regNo").val();
        var action = $("#action").val();
        var remark = $("#remark").val();
        var nbtRatioRate=$("#nbtRatioRate").val();

        $("#modelNotifi").html('');
        if(cusCode=='' || cusCode==0){
            $.notify("Customer can not be empty.Please select a customer.", "danger");
            return false;
        }else if(regNo=='' || regNo==0){
            $.notify("Vehicle's register number can not be empty.Please select a vehicle.", "danger");
            return false;
        }else if(estimate_type=='' || estimate_type==0){
            $.notify("Please select a estimate Type.", "danger");
            return false;
        }else if (desc.length > 0) {
            $('#btnSave').attr('disabled', true);
            $.ajax({
                url: "../job/saveEstimate",
                type: "POST",
                data: { action: action, date: esdate, estimateNo: estimateNo, remark: remark, estimateAmount: totalAmount, insCompany: insCompany, cusCode: cusCode, regNo: regNo, sup_no: supNum, jobNo: jobNo, job_type: job_type, estimate_type: estimate_type, net_price: net_priceArr, qty: qtyArr, sell_price: sell_priceArr, is_ins: is_insArr, insurance: insuranceArr, desc: descArr, job_id: job_idArr, job_order: job_orderArr, work_id: work_idArr, timestamp: timestampArr,isVat:isVatArr,isNbt:isNbtArr,nbtRatio:nbtRatioArr,proVat:proVatArr,proNbt:proNbtArr,totalPrice:totalPriceArr,partType:partTypeArr,
                nbtRatioRate: nbtRatioRate,isTotalVat:isTotalVat,isTotalNbt:isTotalNbt,totalNet:totalNet,totalAmount:totalAmount,totalVat:finalVat,totalNbt:finalNbt},
                success: function(data) {
                    var newdata = JSON.parse(data);
                    var fb = newdata.fb;
                    var lastproduct_code = newdata.EstimateNo;

                    if (fb) {
                        $("#lastJob").html('');
                        // $("#lastJob").html(lastproduct_code);
                        $.notify("Job estimate successfully saved.", "success");
                        $("#modelNotifi").html(lastproduct_code);
                        // $('#btnSave').attr('disabled', false);
                        loadEstimateData(lastproduct_code, newdata.SupplimentryNo);
                        genarateInvLink(lastproduct_code,newdata.SupplimentryNo);
                        SupNumber = 0;
                    } else {
                        $("#lastJob").html('');
                        $('#btnSave').attr('disabled', false);
                    }
                }
            });
        } else {
            // $("#modelNotifi").html("Please add job descriptions.");
            $.notify("Please add job descriptions..", "danger");
        }

    });

    function loadVATNBT(vat,nbt,nratio){

        if(vat==1 && isTotalVat!=1 && isTotalNbt!=1){
            $("input[name='isProVat']").iCheck('check');
        }else{
            $("input[name='isProVat']").iCheck('uncheck');
        }

        if(nbt==1 && isTotalVat!=1 && isTotalNbt!=1){
            $("input[name='isProNbt']").iCheck('check');
        }else{
            $("input[name='isProNbt']").iCheck('uncheck');
        }
        $("#proNbtRatio").val(nratio);

    }

    function loadTotalVATNBT(vat,nbt,nratio){

        if(vat==1){
            $("input[name='isTotalVat']").iCheck('check');
        }else{
            $("input[name='isTotalVat']").iCheck('uncheck');
        }

        if(nbt==1){
            $("input[name='isTotalNbt']").iCheck('check');
        }else{
            $("input[name='isTotalNbt']").iCheck('uncheck');
        }
    }


var totalNbt=0;
var totalVat=0;
var proVat=0;
var proNbt=0;
    function addProductVat(amount,vat,nbt,nratio){
        if(vat==1 && isTotalVat!=1 && isTotalNbt!=1){
            proVat=amount*vatRate/100;
        }else{
            proVat=0;
        }
        return proVat;
    }

    function addProductNbt(amount,vat,nbt,nratio){
        if(nbt==1 && isTotalVat!=1 && isTotalNbt!=1){
            proNbt=amount*nbtRate/100*nratio;
        }else{
            proNbt=0;
        }
        return proNbt;
    }

    function addTotalVat(amount,vat,nbt,nratio){
        
        if(vat==1 && isProVat!=1 && isProNbt!=1){
            totalVat=amount*vatRate/100;
        }else{
            totalVat=0;
        }
        return totalVat;
    }

    function addTotalNbt(amount,vat,nbt,nratio){
        if(nbt==1 && isProVat!=1 && isProNbt!=1){
            totalNbt=amount*nbtRate/100*nbtRatio;
        }else{
            totalNbt=0;
        }
        return totalNbt;
    }

    //load model
    function loadProModal(mname, mcode, msellPrice, mcostPrice, mserial, misSerial, misFree, isOP, isMP, upc, waranty, isautoSerial) {
        $("#qty").focus();
        if (misSerial == 1 || isautoSerial == 1) {
            $("#dv_SN").show();
            $("#qty").focus();
        } else {
            $("#qty").attr('disabled', false);
            $("#dv_SN").hide();
        }
        $("#qty").val(1);
        $("#prdName").val(mname);
        $("#itemCode").val(mcode);
        $("#sellPrice").val(msellPrice);
        $("#unitcost").val(mcostPrice);
        $("#isSerial").val(misSerial);
        $("#upc").val(upc);

        if (misSerial == 1) {

        } else {
            $("#dv_SN").hide();
        }
        if (misFree == 1) {
            $("#dv_FreeQty").show();
        } else {
            $("#dv_FreeQty").hide();
        }
    }

    function clearProductData() {
        $("#prdName").val('');
        $("#qty").val('');
        $("#sellPrice").val('');
        $("#product").val('');
        $('#isInsurance').iCheck('uncheck');
        $("#insurancer").val('');
        $("#partType").val('');

        proName = 0;
        proCode = 0;
        netprice = 0;
        isInsurance = 0;
        jobRef = 0;
        jobCost = 0;
        timestamp = 0;
        proVat=0;
        proNbt=0;
        itemCode=0;
        partType='';
    }

    function clearCustomerData() {
        $("#cusName").html('');
        $("#cusAddress").html('');
        $("#cusAddress2").html('');
        $("#cusPhone").html('');
    }

    function clearVehicleData() {
        $("#contactName").html('');
        $("#registerNo").html('');
        $("#make").html('');
        $("#model").html('');
        $("#fuel").html('');
        $("#chassi").html('');
        $("#engNo").html('');
        $("#yom").html('');
        $("#color").html('');
        $("#jobType").val('');
        $("#estimateType").val('');
    }

    function clearMetaData(){
        totalVat=0;
        totalNbt=0;
        totalProNBT=0;
        totalProVAT=0;

        totalNet=0;
        totalAmount = 0;
        totalNetAmount = 0;

        $("#totalAmount").html(accounting.formatNumber(0));
        $("#totalNet").html(accounting.formatNumber(0));
        $("#totalVat").html(accounting.formatNumber(0));
        $("#totalNbt").html(accounting.formatNumber(0));
        finalVat=0;
        finalNbt=0;

         jobNumArr.length=0;
         proCodeArr.length=0;
         paintsArr.length=0;
         parts2Arr.length=0;
         parts3Arr.length=0;
    }

    $("#btnPrint").click(function() {
        $('#printArea').focus().print();
        var divContents = $("#printArea").html();
    });

    jobNo = $("#jobNo").val();

    if (jobNo != '') {
        loadJobData();
        $("#btnViewJob").attr('disabled', false);
    } else {
        $("#btnViewJob").attr('disabled', true);
    }
    

    $("#estimateType").change(function() {
        var action = $("#action").val();
        var estType = $(this).val();
        var lastSup = 0;
        if((estimateNo=='' || estimateNo==0) && estType==2){
            $.notify("Please select an estimate number.", "warning");
            return false;
        }else{
            $.ajax({
            type: "POST",
            url: "../job/getMaxSupNumberByEstimateNo",
            data: { estimateNo: estimateNo },
            success: function(data) {
                lastSup = parseFloat(data);
                SupNumber = parseFloat(data) + 1;

                if (estType == 2 && jobNo != '' && (estimateNo == '' || estimateNo == 0)) {
                    $("#supplemetNo").val(SupNumber);
                    $("#action").val(1);
                    $("#btnSave").html('Save');
                    clearProductData();
                    clearMetaData();
                    $("#tbl_job tbody").html("");
                } else if (estType == 2 && jobNo != '' && (estimateNo != '' || estimateNo != 0) && SupNumber > lastSup) {
                    $("#supplemetNo").val(SupNumber);
                    $("#action").val(1);
                    $("#btnSave").html('Save');
                    clearProductData();
                    clearMetaData();
                    $("#tbl_job tbody").html("");
                } else if (estType == 1 && jobNo != '' && (estimateNo != '' || estimateNo != 0)) {
                    getEstByEstNoAndSupNo(estimateNo,lastSup);
                    $("#supplemetNo").val(lastSup);
                    $("#action").val(2);
                    $("#btnSave").html('Update');
                    
                }else if (estType == 2 && jobNo == '' && (estimateNo != '' || estimateNo != 0)) {
                    $("#supplemetNo").val(SupNumber);
                    $("#action").val(1);
                    $("#btnSave").html('Save');
                    clearProductData();
                    clearMetaData();
                    $("#tbl_job tbody").html("");
                }else if (estType == 1 && jobNo == '' && (estimateNo != '' || estimateNo != 0)) {
                    
                    getEstByEstNoAndSupNo(estimateNo,lastSup);
                    $("#supplemetNo").val(lastSup);
                    $("#action").val(2);
                    $("#btnSave").html('Update');
                }


            }
        });
        }
        
    });

var newEstNo = 0;

function getKey(txt){
    var text ='';
    if(txt=='Outside Parts'){
        text='SUPPLY';
    }else if(txt=='PARTS'){
        text='SUPPLY';
    }else{
        text=txt;
    }
    return text;
}

//load estimate to print view
    function loadEstimateData(estNo, supNo) {
        clearInvoiceData();
        var totalEstAmount = 0;
        $.ajax({
            type: "POST",
            url: "../job/getEstimateDataById",
            data: { estNo: estNo, supNo: supNo },
            success: function(data) {
                var resultData = JSON.parse(data);

                cusCode = resultData.cus_data.CusCode;
                outstanding = resultData.cus_data.CusOustandingAmount;
                available_balance = parseFloat(resultData.cus_data.CreditLimit) - parseFloat(outstanding);
                customer_name = resultData.cus_data.CusName;
                $("#lblcusName").html(resultData.cus_data.RespectSign + ". " + resultData.cus_data.CusName+"<br>"+nl2br(resultData.cus_data.Address01));
                $("#lblcusCode").html(resultData.cus_data.CusCode);
                $("#creditLimit").html(accounting.formatMoney(resultData.cus_data.CreditLimit));
                $("#creditPeriod").html(resultData.cus_data.CreditPeriod);
                $("#cusOutstand").html(accounting.formatMoney(outstanding));
                $("#availableCreditLimit").html(accounting.formatMoney(available_balance));
                $("#lblAddress").html(nl2br(resultData.cus_data.Address01) + "<br>");
                // $("#lblAddress").html(resultData.cus_data.Address01 + ", " + resultData.cus_data.Address02);
                $("#cusAddress2").html(resultData.cus_data.Address03);
                $("#lbltel").html(resultData.cus_data.MobileNo);

                $("#lblConName").html(resultData.vehicle_data.contactName);
                $("#lblregNo").html(resultData.vehicle_data.RegNo);
                $("#lblmake").html(resultData.vehicle_data.make);
                $("#lblmodel").html(resultData.vehicle_data.model);
                $("#lblviNo").html(resultData.vehicle_data.ChassisNo);

                $("#lblestimateNo").html(resultData.est_hed.EstimateNo);

                if(resultData.est_hed.Supplimentry>0){
                    $("#lblsupNo").html(resultData.est_hed.Supplimentry);
                 }

                $("#lblInsCompany").html(resultData.est_hed.VComName);
                $("#lblinvDate").html(resultData.est_hed.EstDate);
                $("#lblremark").html(resultData.est_hed.remark);
                $("#lbltotalEsAmount").html(accounting.formatMoney(resultData.est_hed.EstNetAmount));
                $("#lbltotalVat").html(accounting.formatMoney(resultData.est_hed.EstVatAmount));
                $("#lbltotalNbt").html(accounting.formatMoney(resultData.est_hed.EstNbtAmount));
                $("#lbltotalNet").html(accounting.formatMoney(resultData.est_hed.EstNetAmount));

                if(resultData.est_hed.EstJobType==1){
                        $("#lblesttype").html("INSURANCE");
                    }else if(resultData.est_hed.EstJobType==2){
                        $("#lblesttype").html("GENERAL");
                    }

                var k = 1;
                if(supNo>0){
                    k=parseFloat(resultData.estlastNo)+1;
                }else if(supNo==0){
                    k=1;
                }else{
                    k=1;
                }
                totalEstAmount = 0;

                if(resultData.est_hed.EstJobType==1){
                    $.each(resultData.est_dtl, function(key, value) {
                        $("#tbl_est_data").append("<tr><td class='bordertopbottom'></td><td class='bordertopbottom' style='padding: 1px 3px 1px 50px;'><b>" + getKey(key) + "</b></td><td class='bordertopbottom'></td><td class='bordertopbottom'></td><td class='bordertopbottom'></td></tr>");

                        for (var i = 0; i < value.length; i++) {
                            if (value[i].EstIsInsurance == 1) {
                                $("#tbl_est_data").append("<tr><td class='borderdot' style='text-align:center;padding: 1px 3px;'>" + (k) + "</td><td class='borderdot' style='padding:  1px 3px;'>" + value[i].EstJobDescription + "</td><td class='borderdot' style='text-align:right;padding:  1px 3px;'>" + (value[i].EstQty) + "</td><td class='borderdot'  style='text-align:right;padding:  1px 3px;'>" + (value[i].EstInsurance) + "</td><td class='borderdot'  style='text-align:right;padding: 1px 3px;'></td></tr>");
                            } else {
                                totalEstAmount += parseFloat(value[i].EstNetAmount);
                                $("#tbl_est_data").append("<tr><td class='borderdot' style='text-align:center;padding:  1px 3px;'>" + (k) + "</td><td class='borderdot' style='padding:  1px 3px;'>" + value[i].EstJobDescription + "</td><td class='borderdot' style='text-align:right;padding:  1px 3px;'>" + (value[i].EstQty) + "</td><td class='borderdot' style='text-align:right;padding:  1px 3px;'>" + accounting.formatMoney(value[i].EstNetAmount) + "</td><td class='borderdot' style='text-align:right;padding:  1px 3px;'></td></tr>")
                            }
                            k++;
                        }
                        
                    });
                }else if(resultData.est_hed.EstJobType==2){
                    $.each(resultData.est_dtl, function(key, value) {
                        $("#tbl_est_data").append("<tr><td class='bordertopbottom'></td><td class='bordertopbottom' style='padding: 1px 3px 1px 50px;'><b>" + getKey(key) + "</b></td><td class='bordertopbottom'></td><td class='bordertopbottom'></td><td class='bordertopbottom'></td></tr>");

                        for (var i = 0; i < value.length; i++) {
                            if (value[i].EstIsInsurance == 1) {
                                $("#tbl_est_data").append("<tr><td class='borderdot' style='text-align:center;padding:  1px 3px;'>" + (k) + "</td><td class='borderdot' style='padding:  1px 3px;'>" + value[i].EstJobDescription + "</td><td class='borderdot' style='text-align:right;padding:  1px 3px;'>" + (value[i].EstQty) + "</td><td class='borderdot'  style='text-align:right;padding: 1px 3px;'>" + (value[i].EstInsurance) + "</td><td class='borderdot'  style='text-align:right;padding: 1px 3px;'></td></tr>");
                            } else {
                                totalEstAmount += parseFloat(value[i].EstNetAmount);
                                $("#tbl_est_data").append("<tr><td class='borderdot' style='text-align:center;padding:  1px 3px;'>" + (k) + "</td><td class='borderdot' style='padding:  1px 3px;'>" + value[i].EstJobDescription + "</td><td class='borderdot' style='text-align:right;padding:  1px 3px;'>" + (value[i].EstQty) + "</td><td class='borderdot' style='text-align:right;padding:  1px 3px;'>" + accounting.formatMoney(value[i].EstNetAmount) + "</td><td class='borderdot' style='text-align:right;padding:  1px 3px;'></td></tr>")
                            }
                            k++;
                        }
                        
                    });
                }
                genaratePrintLink(resultData.est_hed.EstimateNo,resultData.est_hed.Supplimentry);
            }
        });
    }
    var totalEstAmount2 = 0;

    function loadJobData() {
        
        $("#btnViewJob").attr('disabled', false);
        clearCustomerData();
        clearVehicleData();
        clearEstimateData();
        $("#tbl_payment tbody").html("");
        total_due_amount = 0;
        total_over_payment = 0;
        clearCustomerData();
        clearVehicleData();
        totalEstAmount2 = 0;
        jobNo = $("#jobNo").val();
        
        $.ajax({
            type: "POST",
            url: "../job/getEstimateDataByJobNo",
            data: { jobNo: jobNo },
            success: function(data) {
                var resultData = JSON.parse(data);

                cusCode = resultData.cus_data.CusCode;
                outstanding = resultData.cus_data.CusOustandingAmount;
                available_balance = parseFloat(resultData.cus_data.CreditLimit) - parseFloat(outstanding);
                customer_name = resultData.cus_data.CusName;
                $("#cusName,#lblCustomer").html(resultData.cus_data.CusName);
                $("#customer").val(resultData.cus_data.CusCode);
                $("#creditLimit").html(accounting.formatMoney(resultData.cus_data.CreditLimit));
                $("#creditPeriod").html(resultData.cus_data.CreditPeriod);
                $("#cusOutstand").html(accounting.formatMoney(outstanding));
                $("#availableCreditLimit").html(accounting.formatMoney(available_balance));
                $("#cusAddress").html(nl2br(resultData.cus_data.Address01) + "<br>");
                // $("#cusAddress").html(resultData.cus_data.Address01 + ", " + resultData.cus_data.Address02);
                $("#cusAddress2").html(resultData.cus_data.Address03);
                $("#cusPhone").html(resultData.cus_data.MobileNo);
                $("#cusCode").val(resultData.cus_data.CusCode);

                if (resultData.vehicle_data) {
                    $("#contactName").html(resultData.vehicle_data.contactName);
                    $("#registerNo").html(resultData.vehicle_data.RegNo);
                    $("#make").html(resultData.vehicle_data.make);
                    $("#model").html(resultData.vehicle_data.model);
                    $("#fuel").html(resultData.vehicle_data.fuel_type);
                    $("#chassi").html(resultData.vehicle_data.ChassisNo);
                    $("#engNo").html(resultData.vehicle_data.EngineNo);
                    $("#yom").html(resultData.vehicle_data.ManufactureYear);
                    $("#color").html(resultData.vehicle_data.body_color);
                }

                if (resultData.job_data) {
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
                    // $("#jobType").val(resultData.job_data.JCusType);
                    $("#jobSection").val(resultData.job_data.Jsection);
                    $("#advance").val(resultData.job_data.Advance);
                    jobNo =resultData.job_data.JobCardNo;

                    if (resultData.job_data.JCusType == 3) {
                $("#vehicleCompany").show();
                $("#dvInsurance").show();
                $("#jobType").val(1);
            }else if (resultData.job_data.JCusType == 1) {
                $("#vehicleCompany").hide();
                $("#dvInsurance").hide();
                $("#jobType").val(2);
            } else {
                $("#vehicleCompany").hide();
                $("#dvInsurance").hide();
                $("#jobType").val(data.job_data.JCusType);
            }
                }

                var b = 0;
                totalEstAmount2 = 0;
                //loadEstimateDatatoGrid(resultData);
            }
        });
    }

     $("#tbl_job tbody").on('dblclick', 'tr', function() {
        var jobtype = $(this).attr('jobid');
        var workid = $(this).attr('work_id');
        var jobdesc = $(this).attr('job');
        var qty = $(this).attr('qty');
        var selprice = $(this).attr('sellprice');
        var netprice = $(this).attr('netprice');
        var isIns = $(this).attr('isIns');
        var insurance = $(this).attr('insurance');
        var partType = $(this).attr('parttype');
        var jobOrder = $(this).attr('jobOrder');
        var totalPrice = $(this).attr('totalPrice');
        var isvat = $(this).attr('isvat');
        var isnbt = $(this).attr('isnbt');
        var nbtratio = $(this).attr('nbtRatio');

        loadVATNBT(isvat,isnbt,nbtratio);
            $("#jobdesc").val(jobdesc);
            $("#workType").val(jobtype);
            $("#qty").val(qty);
            $("#insurancer").val(insurance);
            $("#sellPrice").val(selprice);
            $("#product").val(workid);
            $("#prdName").val(jobdesc);
            $("#proNbtRatio").val(nbtratio);
            $("#partType").val(partType);
            
            itemCode=workid;

            var jobType  = $("#jobType").val();

            if(jobType==1){
                $("#dvInsurance").show();
            }else{
                $("#dvInsurance").hide();
            }
            isInsurance=isIns;

            if(isIns==1){
                $("input[name='isInsurance']").iCheck('check');
                
            }else{
                $("input[name='isInsurance']").iCheck('uncheck');
            }

            if (jobtype == 1) {
                $("#spartDiv").hide();
                $("#jobDescDiv").show();
            } else if (jobtype == 2) {
                $("#spartDiv").show();
                $("#jobDescDiv").hide();
            } else if (jobtype == 3) {
                $("#spartDiv").hide();
                $("#jobDescDiv").show();
            } else if (jobtype == 4) {
                $("#spartDiv").hide();
                $("#jobDescDiv").show();
            } else if (jobtype == 5) {
                $("#spartDiv").hide();
                $("#jobDescDiv").show();
            }else{
                 $("#spartDiv").hide();
                $("#jobDescDiv").show();
            }

     });

//load edit grid data
    $("#tbl_job tbody").on('click', '.edit', function() {

        var jobtype = $(this).parent().parent().attr('jobid')
        var workid = $(this).parent().parent().attr('work_id');
        var jobdesc = $(this).parent().parent().attr('job');
        var qty = $(this).parent().parent().attr('qty');
        var selprice = $(this).parent().parent().attr('sellprice');
        var netprice = $(this).parent().parent().attr('netprice');
        var partType = $(this).parent().parent().attr('parttype');
        var isIns = $(this).parent().parent().attr('isIns');
        var insurance = $(this).parent().parent().attr('insurance');
        var timestamp = $(this).parent().parent().attr('timestamp');
        var jobOrder = $(this).parent().parent().attr('jobOrder');
        var totalPrice = $(this).parent().parent().attr('totalPrice');
        var isvat = $(this).parent().parent().attr('isvat');
        var isnbt = $(this).parent().parent().attr('isnbt');
        var nbtratio = $(this).parent().parent().attr('nbtRatio');
        var proVat = $(this).parent().parent().attr('proVat');
        var proNbt = $(this).parent().parent().attr('proNbt');

        var r = confirm('Do you want to edit this row ?');
        if (r === true) {

            loadVATNBT(isvat,isnbt,nbtratio);
            $("#jobdesc").val(jobdesc);
            $("#workType").val(jobtype);
            $("#qty").val(qty);
            $("#insurancer").val(insurance);
            $("#sellPrice").val(selprice);
            $("#product").val(workid);
            $("#prdName").val(jobdesc);
            $("#timestamp").val(timestamp);
            $("#proNbtRatio").val(nbtratio);
            $("#partType").val(partType);
            itemCode=workid;

            var jobType  = $("#jobType").val();

            if(jobType==1){
                $("#dvInsurance").show();
            }else{
                $("#dvInsurance").hide();
            }

            if (jobtype == 1) {
                $("#spartDiv").hide();
                $("#jobDescDiv").show();
                $("#partType").prop("disabled",true);
            } else if (jobtype == 2) {
                $("#spartDiv").show();
                $("#jobDescDiv").hide();
                $("#partType").prop("disabled",false);
            } else if (jobtype == 9) {
                $("#spartDiv").hide();
                $("#jobDescDiv").show();
                $("#partType").prop("disabled",false);
            } else {
                $("#jobDescDiv").show();
                $("#spartDiv").hide();
                $("#partType").prop("disabled",true);
            }
            isInsurance=isIns;
            if(isIns==1){
                $("input[name='isInsurance']").iCheck('check');
            }else{
                $("input[name='isInsurance']").iCheck('uncheck');
                totalAmount -= parseFloat(totalPrice);
                totalNetAmount -= parseFloat(netprice);
                totalProVAT -= parseFloat(proVat);
                totalProNBT -= parseFloat(proNbt);
            }
        
            if (jobtype == 1) {
                jobNumArr.splice($.inArray(workid, jobNumArr), 1);
                $("#spartDiv").hide();
                $("#jobDescDiv").show();
            } else if (jobtype == 2) {
                proCodeArr.splice($.inArray(workid, proCodeArr), 1);
                $("#spartDiv").show();
                $("#jobDescDiv").hide();
            } else if (jobtype == 3) {
                paintsArr.splice($.inArray(workid, paintsArr), 1);
                $("#spartDiv").hide();
                $("#jobDescDiv").show();
            } else if (jobtype == 4) {
                parts2Arr.splice($.inArray(workid, parts2Arr), 1);
                $("#spartDiv").hide();
                $("#jobDescDiv").show();
            } else if (jobtype == 5) {
                parts3Arr.splice($.inArray(workid, parts3Arr), 1);
                $("#spartDiv").hide();
                $("#jobDescDiv").show();
            }

            $(this).parent().parent().remove();
            totalVat=addTotalVat(totalAmount,isTotalVat,isTotalNbt,nbtRatio);
            totalNbt=addTotalNbt(totalAmount,isTotalVat,isTotalNbt,nbtRatio);

            totalNet=parseFloat(totalNetAmount+totalVat+totalNbt);
            $("#totalAmount").html(accounting.formatNumber(totalAmount));
            $("#totalNet").html(accounting.formatNumber(totalNet));
            $("#totalVat").html(accounting.formatNumber(totalVat+totalProVAT));
            $("#totalNbt").html(accounting.formatNumber(totalNbt+totalProNBT));
            finalVat=totalVat+totalProVAT;
            finalNbt=totalNbt+totalProNBT;
        }
    });

// load grid data
    function loadEstimateDatatoGrid(resultData) {
        totalAmount = 0;
        totalNetAmount = 0;
        totalProVAT = 0;
        totalProNBT = 0;
        totalVat = 0;
        totalNbt = 0;
        $("#tbl_job tbody").html('');
        if (resultData.est_dtl){
            jobNo = resultData.est_hed.EstJobCardNo;
            cusCode = resultData.est_hed.EstJobCardNo;
            $("#jobNo").val(jobNo);
            $("#jobType").val(resultData.est_hed.EstJobType);
            $("#estimateType").val(resultData.est_hed.EstType);
            $("#supplemetNo").val(resultData.est_hed.Supplimentry);
            $("#remark").val(resultData.est_hed.remark);

            if (resultData.est_hed.EstJobType == 1) {
                $("#vehicleCompany").show();
                $("#dvInsurance").show();
                $("#estimate_head").show();
                $("#general_head").hide();
            } else {
                $("#vehicleCompany").hide();
                $("#dvInsurance").hide();
                $("#estimate_head").hide();
                $("#general_head").show();
            }
            $("#vehicleCompany").val(resultData.est_hed.EstInsCompany);
            
            SupNumber = resultData.est_hed.Supplimentry;
            jobNumArr.length = 0;
            proCodeArr.length = 0;
            paintsArr.length = 0;
            parts2Arr.length = 0;
            parts3Arr.length = 0;
            for (var i = 0; i < resultData.est_dtl.length; i++) {
                if (resultData.est_dtl[i].EstJobType == 1) {
                    if (resultData.est_dtl[i].EstJobId > 0) { jobNumArr.push(resultData.est_dtl[i].EstJobId); }
                } else if (resultData.est_dtl[i].EstJobType == 2) {
                    if (resultData.est_dtl[i].EstJobId > 0) { proCodeArr.push(resultData.est_dtl[i].EstJobId) }
                } else if (resultData.est_dtl[i].EstJobType == 3) {
                    if (resultData.est_dtl[i].EstJobId > 0) { paintsArr.push(resultData.est_dtl[i].EstJobId); }
                } else if (resultData.est_dtl[i].EstJobType == 4) {
                    if (resultData.est_dtl[i].EstJobId > 0) { parts2Arr.push(resultData.est_dtl[i].EstJobId); }
                } else if (resultData.est_dtl[i].EstJobType == 5) {
                    if (resultData.est_dtl[i].EstJobId > 0) { parts3Arr.push(resultData.est_dtl[i].EstJobId); }
                }
                if (resultData.est_dtl[i].EstIsInsurance == 1) {} else {
                    totalAmount += parseFloat(resultData.est_dtl[i].EstTotalAmount);
                    totalNetAmount += parseFloat(resultData.est_dtl[i].EstNetAmount);
                    totalProVAT += parseFloat(resultData.est_dtl[i].EstVatAmount);
                    totalProNBT += parseFloat(resultData.est_dtl[i].EstNbtAmount);
                }
                $("#tbl_job tbody").append("<tr partType='"+resultData.est_dtl[i].EstPartType+"'  totalPrice='"+resultData.est_dtl[i].EstTotalAmount+"' isvat='"+resultData.est_dtl[i].EstIsVat+"' isnbt='"+resultData.est_dtl[i].EstIsNbt+"' nbtRatio='"+resultData.est_dtl[i].EstNbtRatio+"' proVat='"+resultData.est_dtl[i].EstVatAmount+"' proNbt='"+resultData.est_dtl[i].EstNbtAmount+"'  job='" + resultData.est_dtl[i].EstJobDescription + "' jobid='" + resultData.est_dtl[i].EstJobType + "' qty='" + resultData.est_dtl[i].EstQty + "' jobOrder='" + resultData.est_dtl[i].EstJobOrder + "' netprice='" + resultData.est_dtl[i].EstNetAmount + "'  sellprice='" + resultData.est_dtl[i].EstPrice + "'  isIns='" + resultData.est_dtl[i].EstIsInsurance + "' insurance='" + resultData.est_dtl[i].EstInsurance + "' work_id='" + resultData.est_dtl[i].EstJobId + "'  timestamp='" + resultData.est_dtl[i].EstinvoiceTimestamp + "'><td>" + (i + 1) + "</td><td work_id='" + resultData.est_dtl[i].EstJobId + "'>" + resultData.est_dtl[i].jobtype_name + "</td><td>" + resultData.est_dtl[i].EstJobDescription + "</td><td>" + accounting.formatNumber(resultData.est_dtl[i].EstQty) + "</td><td>" + accounting.formatNumber(resultData.est_dtl[i].EstPrice) + "</td><td>" + accounting.formatNumber(resultData.est_dtl[i].EstNetAmount) + "</td><td>" + resultData.est_dtl[i].EstInsurance + "</td><td>&nbsp;&nbsp;<i class='glyphicon glyphicon-edit edit btn btn-info btn-xs'></i>&nbsp;<i class='remove btn btn-danger btn-xs glyphicon glyphicon-remove-circle'></i></td></tr>");

            }

            totalVat=addTotalVat(resultData.est_hed.EstimateAmount,resultData.est_hed.EstIsVatTotal,resultData.est_hed.EstIsNbtTotal,resultData.est_hed.EstNbtRatioTotal);
            totalNbt=addTotalNbt(resultData.est_hed.EstimateAmount,resultData.est_hed.EstIsVatTotal,resultData.est_hed.EstIsNbtTotal,resultData.est_hed.EstNbtRatioTotal);

            totalNet=parseFloat(totalNetAmount+totalVat+totalNbt);
            $("#totalAmount").html(accounting.formatNumber(totalAmount));
            $("#totalNet").html(accounting.formatNumber(totalNet));
            $("#totalVat").html(accounting.formatNumber(totalVat+totalProVAT));
            $("#totalNbt").html(accounting.formatNumber(totalNbt+totalProNBT));
            finalVat=totalVat+totalProVAT;
            finalNbt=totalNbt+totalProNBT;

            estimateNo = resultData.est_hed.EstimateNo;
            loadEstimateData(resultData.est_hed.EstimateNo, resultData.est_hed.Supplimentry);
            $("#estimateNo").val(resultData.est_hed.EstimateNo);
            $("#btnSave").html('Update');
            $("#action").val(2);
            isTotalVat=resultData.est_hed.EstIsVatTotal;
            isTotalNbt=resultData.est_hed.EstIsNbtTotal;
            totalNbtRatio=resultData.est_hed.EstNbtRatioTotal;
            loadTotalVATNBT(isTotalVat,isTotalNbt,totalNbtRatio);

        } else {
            $("#btnSave").html('Save');
            $("#action").val(1);
            estimateNo = 0;
        }
        $("#jobCardData tbody").html('');
        if(resultData.job_desc){
            $("#jNo").empty().html(" Job Number : " + resultData.job_desc[0].JobCardNo);
            for (var i = 0; i < resultData.job_desc.length; i++) {
                $("#jobCardData tbody").append("<tr><td>" + (i + 1) + "</td><td>" + resultData.job_desc[i].JobDescription + "</td></tr>");
            }
        }
        
    }

    // VAT
var isProVat =0;
var isProNbt =0;
var proNbtRatio =0;
var isTotalVat =0;
var isTotalNbt =0;
var totalNbtRatio =0;
var vatRate=parseFloat($("#vatRate").val());
var nbtRate=parseFloat($("#nbtRate").val());
var nbtRatio=parseFloat($("#nbtRatioRate").val());

$("input[name='isProVat']").on('ifChanged', function(event){
     isProVat = $("input[name='isProVat']:checked").val();
    if(isProVat){
        $("#isTotalVat").prop('disabled',true);
        $("#isTotalNbt").prop('disabled',true);
        isTotalVat=0;isTotalNbt=0;totalVat=0;
    }else{
        $("#isTotalVat").prop('disabled',false);
        $("#isTotalNbt").prop('disabled',false);
        isProVat=0;
    }
});
    
$("input[name='isProNbt']").on('ifChanged', function(event){
     isProNbt = $("input[name='isProNbt']:checked").val();
    if(isProNbt){
        $("#isTotalVat").prop('disabled',true);
        $("#isTotalNbt").prop('disabled',true);
         isTotalVat=0;isTotalNbt=0;totalNbt=0;
    }else{
        $("#isTotalVat").prop('disabled',false);
        $("#isTotalNbt").prop('disabled',false);
        isProNbt=0;
    }
});

$("input[name='isTotalVat']").on('ifChanged', function(event){
     isTotalVat = $("input[name='isTotalVat']:checked").val();
    if(isTotalVat){
        $("#isProVat").prop('disabled',true);
        $("#isProNbt").prop('disabled',true);
        isProVat=0;isProNbt=0;totalProVAT=0;
    }else{
        $("#isProVat").prop('disabled',false);
        $("#isProNbt").prop('disabled',false);
        isTotalVat=0;
    }
});
    
$("input[name='isTotalNbt']").on('ifChanged', function(event){
     isTotalNbt = $("input[name='isTotalNbt']:checked").val();
    if(isTotalNbt){
        $("#isProVat").prop('disabled',true);
        $("#isProNbt").prop('disabled',true);
         isProVat=0;isProNbt=0;totalProNBT=0;
    }else{
        $("#isProVat").prop('disabled',false);
        $("#isProNbt").prop('disabled',false);
        isTotalNbt=0;
    }
});

    function clearInvoiceData() {
        $("#tbl_est_data tbody").html('');
        $("#lblcusName").html('');
        $("#lblcusCode").html('');
        $("#creditLimit").html('');
        $("#creditPeriod").html('');
        $("#cusOutstand").html('');
        $("#availableCreditLimit").html('');
        $("#lblAddress").html('');
        $("#cusAddress2").html('');
        $("#lbltel").html('');

        $("#lblConName").html('');
        $("#lblregNo").html('');
        $("#lblmake").html('');
        $("#lblmodel").html('');
        $("#lblviNo").html('');

        $("#lblestimateNo").html('');
        $("#lblinvDate").html('');
    }

    function clearEstimateData() {
        cusCode = 0;
        jobNo = 0;
        paymentNo = 0;
        cusType = 2;
        k = 1;
        workType = 0;
        price_level = 1;
        totalAmount = 0;isInsurance = 0;action = 1;SupNumber = 0;estimateNo = 0;
        $("#supplemetNo").val(SupNumber);
    }

    //customer autoload
    $("#cusCode").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../job/loadcustomersjson',
                dataType: "json",
                data: {
                    q: request.term
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
        minLength: 3,
        select: function(event, ui) {
            cusCode = ui.item.value;
            clearCustomerData();
            clearVehicleData();
            $("#tbl_payment tbody").html("");
            loadCustomerDatabyId(cusCode);
        }
    });

    //vehicle autoload
    $("#regNo").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../job/loadvehiclesjson',
                dataType: "json",
                data: {
                    q: request.term,
                    cusCode: cusCode
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
            var regNo = ui.item.value;
            clearVehicleData();
            $.ajax({
                type: "POST",
                url: "../job/getVehicleDetailsById",
                data: { id: regNo },
                success: function(data) {
                    var resultData = JSON.parse(data);
                    if (resultData) {
                        $("#contactName").html(resultData.contactName);
                        $("#registerNo").html(resultData.RegNo);
                        $("#make").html(resultData.make);
                        $("#model").html(resultData.model);
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

    // autoload by customer and vehicle notify
    regNo = $("#regNo").val();
    customer = $("#cusCode").val();

    if (regNo != '' && customer != '') {
            clearVehicleData();
            $.ajax({
                type: "POST",
                url: "../job/getVehicleDetailsByIdandCus",
                data: { id: regNo,cuscode:customer },
                success: function(data) {
                    var resultData = JSON.parse(data);
                    if (resultData) {
                        $("#contactName").html(resultData.contactName);
                        $("#registerNo").html(resultData.RegNo);
                        $("#make").html(resultData.make);
                        $("#model").html(resultData.model);
                        $("#fuel").html(resultData.fuel_type);
                        $("#chassi").html(resultData.ChassisNo);
                        $("#engNo").html(resultData.EngineNo);
                        $("#yom").html(resultData.ManufactureYear);
                        $("#color").html(resultData.body_color);

                        loadCustomerDatabyId(resultData.CusCode);
                    }
                }
            });

        $("#btnViewJob").attr('disabled', false);
    } else {
        $("#btnViewJob").attr('disabled', true);
    }

    function loadCustomerDatabyId(customer) {
        clearCustomerData();
        $.ajax({
            type: "POST",
            url: "../Payment/getCustomersDataById",
            data: { cusCode: customer },
            success: function(data) {
                var resultData = JSON.parse(data);

                cusCode = resultData.cus_data.CusCode;
                outstanding = resultData.cus_data.CusOustandingAmount;
                available_balance = parseFloat(resultData.cus_data.CreditLimit) - parseFloat(outstanding);
                customer_name = resultData.cus_data.CusName;
                $("#cusName,#lblCustomer").html(resultData.cus_data.CusName);
                $("#customer,#cusCode").val(resultData.cus_data.CusCode);
                $("#creditLimit").html(accounting.formatMoney(resultData.cus_data.CreditLimit));
                $("#creditPeriod").html(resultData.cus_data.CreditPeriod);
                $("#cusOutstand").html(accounting.formatMoney(outstanding));
                $("#availableCreditLimit").html(accounting.formatMoney(available_balance));
                $("#cusAddress").html(nl2br(resultData.cus_data.Address01) + "<br>");
                $("#cusAddress2").html(resultData.cus_data.Address03);
                $("#cusPhone").html(resultData.cus_data.MobileNo);
            }
        });
    }

    function genarateInvLink(est,sup){
        $("#invLink").attr('disabled',false);
        if(est!=''){
            $("#invLink").attr("href","../../admin/Salesinvoice/job_invoice?type=est&id="+Base64.encode(est)+"&sup="+sup);    
        }
    }

    function genaratePrintLink(est, sup){
        $("#printLink").attr('disabled',false);
        if(est!=''){
            $("#printLink").attr("href","../../admin/job/view_estimate?type=est&id="+Base64.encode(est)+"&sup="+sup);    
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
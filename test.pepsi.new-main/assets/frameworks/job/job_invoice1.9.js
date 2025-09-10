$(document).ready(function() {

    $('#appoDate,#deliveryDate').datetimepicker({ dateFormat: 'yy-mm-dd', timeFormat: "HH:mm:ss" });
    $('#appoDate').datetimepicker().datetimepicker("setDate", new Date());

    $('#chequeReciveDate,#chequeDate,#chequeReciveDate2,#chequeDate2').datepicker({ format: 'yy-mm-dd'});
// $('#appoDate').datepicker().datepicker("setDate", new Date());

    // $("#vehicleCompany").hide();
    $("#action").val(1);
    $('.prd_icheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '50%'
    });
    $("#invLink").attr('disabled',true);
    $("#vehicleCompany").show();
    $("#dvInsurance").hide();
    $("#spartDiv").hide();
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

    var discount_precent = 0;
    var discount_amount = 0;
    var product_discount = 0;
    var total_discount = 0;
    var total_item_discount = 0;
    var discount = 0;
    var discount_type = 0;
    var totalProWiseDiscount = 0;
    var totalInvDiscount = 0;
    var prodiscount_precent=0;
    var isProVatEnabled=0;

    var cashAmount = 0;
    var chequeAmount = 0;
    var creditAmount = 0;
    var dueAmount = 0;
    var lotPrice = 0;
    var returnAmount = 0;
    var refundAmount = 0;
    var returnPayment = 0;
     var advance_payment_no=0;
    var advance_amount=0;
    var return_payment_no=0;
    var return_amount=0;
    var bank_amount=0;
    // com_amount:com_amount, compayto:compayto,receiver_name:receiver_name,receiver_nic:receiver_nic,

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

    $("#advance_payment_no").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../salesinvoice/loadadvancepaymentjson',
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
            $("#madvance").html(0);
            loadAdvanceData(advance_payment_no);
        }
    });

     function loadAdvanceData(pay_no){
        $.ajax({
            type: "POST",
            url: "../Salesinvoice/getadvancepaymentbyid",
            data: { payid: pay_no },
            success: function(data) {
                var resultData = JSON.parse(data);
                
                if (resultData.advance){
                    advance_amount = parseFloat(resultData.advance.TotalPayment);
                    advance_payment_no = resultData.advance.CusPayNo;
                    $("#advance_amount").val(advance_amount);
                    $("#madvance").html(advance_amount);
                    addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount,return_amount);
                }
            }
        });
    }

    $("#return_payment_no").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../salesinvoice/loadreturnpaymentjson',
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
            return_payment_no = ui.item.value;
            $("#return_amount").val(0);
            $("#mareturn").html(0);
            loadReturnData(return_payment_no);
        }
    });

    function loadReturnData(pay_no){
        $.ajax({
            type: "POST",
            url: "../Salesinvoice/getreturnpaymentbyid",
            data: { payid: pay_no },
            success: function(data) {
                var resultData = JSON.parse(data);

                if (resultData.return){
                    return_amount = parseFloat(resultData.return.ReturnAmount);
                    return_payment_no = resultData.return.ReturnNo;
                    $("#return_amount").val(return_amount);
                    $("#mareturn").html(return_amount);
                    addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount,return_amount);
                }
            }
        });
    }

    $("#invoiceType").change(function() {
        if ($(this).val()==2) {
            $("#totalItemWise").prop('disabled',true);
        } else {
            $("#totalItemWise").prop('disabled',false);
        }
    });

    var partInvType = 1;
    //load part invoice type
    $("#partInvType").change(function() {
        partInvType = $(this).val();
        if(partInvType==2){
            $("#isTotalVat").prop('disabled',true);
            $("#isTotalNbt").prop('disabled',true);
            $("#totalItemWise").prop('disabled',true);
            
            isTotalVat=0;isTotalNbt=0;totalVat=0;
        }else{
            $("#isTotalVat").prop('disabled',false);
            $("#isTotalNbt").prop('disabled',false);
            $("#totalItemWise").prop('disabled',false);
        }
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
            jobNo = ui.item.value;
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
                url: "../salesinvoice/getInvoiceDataByJobNo",
                data: { jobNo: jobNo },
                success: function(data) {
                    var resultData = JSON.parse(data);
                    setGridandLabelData(resultData);
                    if(resultData.inv_hed){
                         loadInvoiceDatatoGrid(resultData);
                    }else{
                        $.ajax({
                            type: "POST",
                            url: "../salesinvoice/getTempInvoiceDataByJobNo",
                            data: { jobNo: jobNo },
                            success: function(data) {
                                var resultData = JSON.parse(data);

                                if(resultData.inv_hed){
                                     loadTempInvoiceDatatoGrid(resultData);
                                }else{
                                    $.ajax({
                                        type: "POST",
                                        url: "../salesinvoice/getIssueNoteDataByJobNo",
                                        data: { jobNo: jobNo },
                                        success: function(data) {
                                            var resultData = JSON.parse(data);
                                            loadEstimateDatatoGrid(resultData);
                                        }
                                    });
                                }
                            }
                        });
                    }
                }
            });
        }
    });

    //estimate no autoload
    $("#estimateNo").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../job/loadestimatejsonbyjob',
                dataType: "json",
                data: {
                    q: request.term,
                    jobNo:jobNo
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
            // genarateInvLink(estimateNo,0);
            clearCustomerData();
            clearVehicleData();
            clearInvoiceData();
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

                    if(resultData.isInv==0 && resultData.istempInv==1){
                        jobNo= resultData.job_data.JobCardNo;
                        $.ajax({
                            type: "POST",
                            url: "../salesinvoice/getTempInvoiceDataByJobNo",
                            data: { jobNo: jobNo },
                            success: function(data) {
                                var resultData = JSON.parse(data);

                                setGridandLabelData(resultData);

                                loadTempInvoiceDatatoGrid(resultData);
                            }
                        });

                    }else if(resultData.isInv==1 && resultData.istempInv==1){
                         setGridandLabelData(resultData);

                        loadEstimateDatatoGrid(resultData);
                    }else{
                         setGridandLabelData(resultData);

                        loadEstimateDatatoGrid(resultData);
                    }

                   
                }
            });
        }
    });

    var tempInvoiceNo=0;
    //invoice no autoload
    // $("#tempNo").autocomplete({
    //     source: function(request, response) {
    //         $.ajax({
    //             url: '../salesinvoice/loadtempinvoicejson',
    //             dataType: "json",
    //             data: {
    //                 q: request.term,
    //                 jobNo:jobNo
    //             },
    //             success: function(data) {
    //                 response($.map(data, function(item) {
    //                     return {
    //                         label: item.text,
    //                         value: item.id,
    //                         data: item
    //                     }
    //                 }));
    //             }
    //         });
    //     },
    //     autoFocus: true,
    //     minLength: 0,
    //     select: function(event, ui) {
    //         tempInvoiceNo = ui.item.value;
    //         // genarateInvLink(tempInvoiceNo,0);
    //         clearCustomerData();
    //         clearVehicleData();
    //         clearInvoiceData();
    //         $("#tbl_payment tbody").html("");
    //         $("#tbl_job tbody").html('');
    //         total_due_amount = 0;
    //         total_over_payment = 0;
    //         $("#btnViewJob").attr('disabled', false);
    //         SupNumber = 0;
    //         $.ajax({
    //             type: "POST",
    //             url: "../salesinvoice/getTempInvoiceDataByInvoiceNo",
    //             data: { invoiceNo: tempInvoiceNo },
    //             success: function(data) {
    //                 var resultData = JSON.parse(data);
    //
    //                 setGridandLabelData(resultData);
    //
    //                 loadTempInvoiceDatatoGrid(resultData);
    //             }
    //         });
    //     }
    // });
    
    var invoiceNo=0;
    //invoice no autoload
    $("#invoiceNo").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../salesinvoice/loadinvoicejsonbyjob',
                dataType: "json",
                data: {
                    q: request.term,
                    jobNo:jobNo
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
            invoiceNo = ui.item.value;
            // genarateInvLink(invoiceNo,0);
            clearCustomerData();
            clearVehicleData();
            clearInvoiceData();
            $("#tbl_payment tbody").html("");
            $("#tbl_job tbody").html('');
            total_due_amount = 0;
            total_over_payment = 0;
            $("#btnViewJob").attr('disabled', false);
            SupNumber = 0;
            $.ajax({
                type: "POST",
                url: "../salesinvoice/getInvoiceDataByInvoiceNo",
                data: { invoiceNo: invoiceNo },
                success: function(data) {
                    var resultData = JSON.parse(data);

                    setGridandLabelData(resultData);

                    loadInvoiceDatatoGrid(resultData);
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

            SupNumber = ui.item.value;
            // genarateInvLink(estimateNo,SupNumber);
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
                data: { estimateNo: estimateNo, supplimentNo: SupNumber },
                success: function(data) {
                    var resultData = JSON.parse(data);

                    setGridandLabelData(resultData);

                    loadEstimateDatatoGrid(resultData);
                }
            });
        }
    });


    discount_precent = parseFloat($("#disPercent").val());
    discount_amount = parseFloat($("#disAmount").val());
    discount = $("input[name='discount']:checked").val();
    discount_type = $("input[name='discount_type']:checked").val();

//===========discount types===========================
    $("input[name='discount']").on('ifChanged', function() {
        var check = ($(this).val());

        if (check == 1) {
            $("#disAmount").val(0);
        } else if (check == 2) {
            $("#disPercent").val(0);
        }
    });

    $("input[name='discount_type']").on('ifChanged', function() {
        var check = ($(this).val());

        if (check == 1) {
            $("#disAmount").val(0);
        } else if (check == 2) {
            $("#disPercent").val(0);
        }
    });

    function setGridandLabelData(data) {
        if (data.cus_data) {
            cusCode = data.cus_data.CusCode;
            outstanding = data.cus_data.CusOustandingAmount;
            available_balance = parseFloat(data.cus_data.CreditLimit) - parseFloat(outstanding);
            customer_name = data.cus_data.CusName;
            var encode_url = "../payment/view_customer/"+(cusCode);

            $("#cusName").html("<a href='"+encode_url+"'>"+data.cus_data.CusName+"</a>");
            // $("#cusName").html(data.cus_data.CusName);
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

        // if (data.vehicle_data) {
        //     regNo = data.vehicle_data.RegNo
        //     $("#contactName").html(data.vehicle_data.contactName);
        //     $("#regNo").val(data.vehicle_data.RegNo);
        //     $("#make").html(data.vehicle_data.make);
        //     $("#model").html(data.vehicle_data.model);
        //     $("#fuel").html(data.vehicle_data.fuel_type);
        //     $("#chassi").html(data.vehicle_data.ChassisNo);
        //     $("#engNo").html(data.vehicle_data.EngineNo);
        //     $("#yom").html(data.vehicle_data.ManufactureYear);
        //     $("#color").html(data.vehicle_data.body_color);
        // }

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
            $("#deliveryDate").val(data.job_data.deliveryDate);
            $("#estimateNo").val(data.job_data.JestimateNo);
            $("#jobtype").val(data.job_data.JJobType);
            $("#jobSection").val(data.job_data.Jsection);
            $("#advance").val(data.job_data.Advance);
        }
    }

    $("#jobType").change(function() {
        if ($(this).val() == 1) {
            $("#vehicleCompany").show();
            $("#dvInsurance").show();
        } else {
            $("#vehicleCompany").hide();
            $("#dvInsurance").hide();
        }
    });

    var isJobVat=0;
    var isJobNbt=0;
    var isJobNbtRatio=0;
    
    $("#workType").change(function(){
        workType = 0;
        workType = $("#workType").val();
        isJobVat = parseFloat($("#workType option:selected").attr('isVat'));
        isJobNbt = parseFloat($("#workType option:selected").attr('isNbt'));
        isJobNbtRatio = parseFloat($("#workType option:selected").attr('nbtRatio'));

        if (workType == 1) {
            $("#spartDiv").hide();
            $("#jobDescDiv").show();
            $("#addJob").attr('disabled', false);
        } else if (workType == 2) {
            $("#spartDiv").show();
            $("#jobDescDiv").hide();
            $("#addJob").attr('disabled', true);
        } else {
            $("#jobDescDiv").show();
            $("#spartDiv").hide();
            $("#addJob").attr('disabled', false);
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
    var totalPriceWithDiscount=0;
    var itemCode=0;
    var estlineno=1;

    $("#jobdesc2").change(function() {
        var val = $("#jobdesc2 option:selected").html();
        $("#jobdesc").val(val);
    });

    // var k=0;
    // ADD job descriptions
    $("#addJob").click(function() {
        var jobdesc = $("#jobdesc").val();
        // var val2 = $("#jobdesc2 option:selected").val();
        var workTypes = $("#workType option:selected").html();
        var workId = $("#workType option:selected").val();
        var workOrder = $("#workType option:selected").attr('jobOrder');
        var no = $("#no").val();
        var qty = parseFloat($("#qty").val());
        var insurance = $("#insurance").val();
        var sellPrice = parseFloat($("#sellPrice").val());
        var proCode = $("#product").val();
        var proName = $("#prdName").val();
        var timestamp = $("#timestamp").val();
        var estLine = $("#estlineno").val();
        isInsurance = $("input[name='isInsurance']:checked").val();
        var isNewVat = $("input[name='isProVat']:checked").val();
        var isNewNbt = $("input[name='isProNbt']:checked").val();
        var newNbtRatio = parseFloat($("#proNbtRatio").val());
        var estprice = parseFloat($("#estPrice").val());
        var costprice = parseFloat($("#costPrice").val());
        var serial = $("#serial").val();

         if(isNaN(costprice) == true){
            costprice=0;
         }else{
            costprice=costprice;
         }

        if(qty=='' || isNaN(qty) == true){
            $.notify("Qty can not be empty.", "warning");return false;
        }else if(sellPrice=='' || isNaN(sellPrice) == true){
            $.notify("Unit Price can not be empty.", "warning");return false;
        }else if(sellPrice<costprice){
            $.notify("Cost Price can not be greater than selling price.", "warning");return false;
        }else{
            if (workId == 1 && jobdesc != '') {
                var jobArrIndex = $.inArray(jobRef, jobNumArr);

                if (jobArrIndex < 0) {
                    netprice = qty * sellPrice;
                    totalPrice= qty * sellPrice;
                    calculateProductWiseDiscount(netprice, discount, discount_type, discount_precent, discount_amount, 0);
                    totalPriceWithDiscount=parseFloat(totalPrice-product_discount);
                    proVat=addProductVat((totalPriceWithDiscount),isNewVat,isNewNbt,newNbtRatio);
                    proNbt=addProductNbt((totalPriceWithDiscount),isNewVat,isNewNbt,newNbtRatio) ;
                    netprice +=proVat ;
                    netprice +=proNbt ;
                    $("#tbl_job tbody").append("<tr serial='' estlineno='"+estLine+"' cost_price='"+costprice+"' est_price='"+estprice+"' discount_type='"+discount_type+"' proDiscount='"+product_discount+"' disPrecent='"+prodiscount_precent+"' totalPrice='"+totalPrice+"' isvat='"+isNewVat+"' isnbt='"+isNewNbt+"' nbtRatio='"+newNbtRatio+"' proVat='"+proVat+"' proNbt='"+proNbt+"' job='" + jobdesc + "' jobid='" + workId + "' qty='" + qty + "' jobOrder='" + workOrder + "'  netprice='" + netprice + "' sellprice='" + sellPrice + "' isIns='" + isInsurance + "' insurance='" + insurance + "' work_id='" + jobRef + "' timestamp='" + timestamp + "'>" +
                        "<td>" + k + "</td>" +
                        "<td work_id='" + workId + "'>" + workTypes + "</td>" +
                        "<td>" + jobdesc + "</td>" +
                        "<td> </td>" +
                        "<td class='text-right'>" + accounting.formatNumber(qty) + "</td>" +
                        "<td class='text-right'>" + accounting.formatNumber(sellPrice) + "</td>" +
                        "<td class='text-right'>" + accounting.formatNumber(prodiscount_precent) + "</td>" +
                        "<td class='text-right'>" + accounting.formatNumber(estprice) + "</td>" +
                        "<td class='text-right'>" + accounting.formatNumber(netprice) + "</td>" +
                        "<td>&nbsp;<i class='glyphicon glyphicon-edit edit btn btn-info btn-xs'></i>&nbsp;<i class='remove btn btn-danger btn-xs glyphicon glyphicon-remove-circle'></i></td>" +
                        "</tr>");
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
                if (workId == 2 && proCode!='') {

                    var productArrIndex = $.inArray(proCode, proCodeArr);

                    // if (productArrIndex < 0) {
                        netprice = qty * sellPrice;
                        totalPrice= qty * sellPrice;
                        calculateProductWiseDiscount(netprice, discount, discount_type, discount_precent, discount_amount, 0);
                        totalPriceWithDiscount=parseFloat(totalPrice-product_discount);
                        proVat=addProductVat((totalPriceWithDiscount),isNewVat,isNewNbt,newNbtRatio);
                        proNbt=addProductNbt((totalPriceWithDiscount),isNewVat,isNewNbt,newNbtRatio) ;
                        netprice +=proVat ;
                        netprice +=proNbt ;
                        $("#tbl_job tbody").append("<tr serial='"+serial+"' estlineno='"+estLine+"' cost_price='"+costprice+"' est_price='"+estprice+"' discount_type='"+discount_type+"' proDiscount='"+product_discount+"' disPrecent='"+prodiscount_precent+"' totalPrice='"+totalPrice+"' isvat='"+isNewVat+"' isnbt='"+isNewNbt+"' nbtRatio='"+newNbtRatio+"' proVat='"+proVat+"' proNbt='"+proNbt+"' job='" + proName + "' jobid='" + workId + "' qty='" + qty + "' jobOrder='" + workOrder + "' netprice='" + netprice + "'  sellprice='" + sellPrice + "'  isIns='" + isInsurance + "' insurance='" + insurance + "' work_id='" + proCode + "' timestamp='" + timestamp + "'>" +
                            "<td>" + k + "</td>" +
                            "<td work_id='" + workId + "'>" + workTypes + "</td>" +
                            "<td>" + proName + "</td>" +
                            "<td>" + serial + "</td>" +
                            "<td class='text-right'>" + accounting.formatNumber(qty) + "</td>" +
                            "<td class='text-right'>" + accounting.formatNumber(sellPrice) + "</td>" +
                            "<td class='text-right'>" + accounting.formatNumber(prodiscount_precent) + "</td>" +
                            "<td class='text-right'>" + accounting.formatNumber(estprice) + "</td>" +
                            "<td class='text-right'>" + accounting.formatNumber(netprice) + "</td>" +
                            "<td>&nbsp;<i class='glyphicon glyphicon-edit edit btn btn-info btn-xs'></i>" +
                            // "&nbsp;<i class='remove btn btn-danger btn-xs glyphicon glyphicon-remove-circle'></i>" +
                            "</td>" +
                            "</tr>");
                        if (proCode != 0 || proCode != '') { proCodeArr.push(proCode); }
                        $("#prdName").val('');
                        $("#product").val('');
                        if (isInsurance == 1) {} else {
                            totalAmount += parseFloat(totalPrice);
                            totalNetAmount +=parseFloat(netprice);
                            totalProVAT+=parseFloat(proVat);
                            totalProNBT+=parseFloat(proNbt);
                        }
                        k++;
                        clearProductData();
                    $("#addJob").attr('disabled', true);
                    // } else {
                    //     //alert("Product Already exists");
                    //     $.notify("Job Already exists.", "warning");
                    //
                    // }
                }else {
                    $.notify("Please Select a product. This is not in system", "warning");
                }
            }
            // else if (workId == 3 && jobdesc != '') {
            //     //paints
            //     var paintArrIndex = $.inArray(jobRef, paintsArr);
            //
            //     if (paintArrIndex < 0) {
            //         netprice = qty * sellPrice;
            //       totalPrice= qty * sellPrice;
            //         calculateProductWiseDiscount(netprice, discount, discount_type, discount_precent, discount_amount, 0);
            //         totalPriceWithDiscount=parseFloat(totalPrice-product_discount);
            //         proVat=addProductVat((totalPriceWithDiscount),isNewVat,isNewNbt,newNbtRatio);
            //         proNbt=addProductNbt((totalPriceWithDiscount),isNewVat,isNewNbt,newNbtRatio) ;
            //         netprice +=proVat ;
            //         netprice +=proNbt ;
            //         $("#tbl_job tbody").append("<tr estlineno='"+estLine+"' cost_price='"+costprice+"' est_price='"+estprice+"' discount_type='"+discount_type+"'  proDiscount='"+product_discount+"' disPrecent='"+prodiscount_precent+"' totalPrice='"+totalPrice+"' isvat='"+isNewVat+"' isnbt='"+isNewNbt+"' nbtRatio='"+newNbtRatio+"' proVat='"+proVat+"' proNbt='"+proNbt+"' job='" + jobdesc + "' jobid='" + workId + "' qty='" + qty + "' jobOrder='" + workOrder + "'  netprice='" + netprice + "' sellprice='" + sellPrice + "' isIns='" + isInsurance + "' insurance='" + insurance + "' work_id='" + jobRef + "' timestamp='" + timestamp + "'><td>" + k + "</td><td work_id='" + workId + "'>" + workTypes + "</td><td>" + jobdesc + "</td><td class='text-right'>" + accounting.formatNumber(qty) + "</td><td class='text-right'>" + accounting.formatNumber(sellPrice) + "</td><td class='text-right'>" + accounting.formatNumber(prodiscount_precent) + "</td><td class='text-right'>" + accounting.formatNumber(estprice) + "</td><td class='text-right'>" + accounting.formatNumber(netprice) + "</td><td>&nbsp;<i class='glyphicon glyphicon-edit edit btn btn-info btn-xs'></i>&nbsp;<i class='remove btn btn-danger btn-xs glyphicon glyphicon-remove-circle'></i></td></tr>");
            //         if (jobRef != 0 || jobRef != '') { paintsArr.push(jobRef); }
            //         $("#jobdesc").val('');
            //         $("#jobdesc2").val('');
            //        totalAmount += parseFloat(totalPrice);
            //         totalNetAmount +=parseFloat(netprice);
            //         totalProVAT+=parseFloat(proVat);
            //         totalProNBT+=parseFloat(proNbt);
            //         clearProductData();
            //         k++;
            //     } else {
            //         //alert("Job Already exists");
            //         $.notify("Job Already exists.", "warning");
            //     }
            // }
            // else if (workId == 4 && jobdesc != '') {
            //     //paints
            //     var parts2ArrIndex = $.inArray(jobRef, parts2Arr);
            //
            //     if (parts2ArrIndex < 0) {
            //         netprice = qty * sellPrice;
            //         totalPrice= qty * sellPrice;
            //         calculateProductWiseDiscount(netprice, discount, discount_type, discount_precent, discount_amount, 0);
            //         totalPriceWithDiscount=parseFloat(totalPrice-product_discount);
            //         proVat=addProductVat((totalPriceWithDiscount),isNewVat,isNewNbt,newNbtRatio);
            //         proNbt=addProductNbt((totalPriceWithDiscount),isNewVat,isNewNbt,newNbtRatio) ;
            //         netprice +=proVat ;
            //         netprice +=proNbt ;
            //         $("#tbl_job tbody").append("<tr estlineno='"+estLine+"' cost_price='"+costprice+"' est_price='"+estprice+"' discount_type='"+discount_type+"'  proDiscount='"+product_discount+"' disPrecent='"+prodiscount_precent+"' totalPrice='"+totalPrice+"' isvat='"+isNewVat+"' isnbt='"+isNewNbt+"' nbtRatio='"+newNbtRatio+"' proVat='"+proVat+"' proNbt='"+proNbt+"' job='" + jobdesc + "' jobid='" + workId + "' qty='" + qty + "' jobOrder='" + workOrder + "'  netprice='" + netprice + "' sellprice='" + sellPrice + "' isIns='" + isInsurance + "' insurance='" + insurance + "' work_id='" + jobRef + "' timestamp='" + timestamp + "'><td>" + k + "</td><td work_id='" + workId + "'>" + workTypes + "</td><td>" + jobdesc + "</td><td class='text-right'>" + accounting.formatNumber(qty) + "</td><td class='text-right'>" + accounting.formatNumber(sellPrice) + "</td><td class='text-right'>" + accounting.formatNumber(prodiscount_precent) + "</td><td class='text-right'>" + accounting.formatNumber(estprice) + "</td><td class='text-right'>" + accounting.formatNumber(netprice) + "</td><td>&nbsp;<i class='glyphicon glyphicon-edit edit btn btn-info btn-xs'></i>&nbsp;<i class='remove btn btn-danger btn-xs glyphicon glyphicon-remove-circle'></i></td></tr>");
            //         if (jobRef != 0 || jobRef != '') { parts2Arr.push(jobRef); }
            //         $("#jobdesc").val('');
            //         $("#jobdesc2").val('');
            //        totalAmount += parseFloat(totalPrice);
            //         totalNetAmount +=parseFloat(netprice);
            //         totalProVAT+=parseFloat(proVat);
            //         totalProNBT+=parseFloat(proNbt);
            //         clearProductData();
            //         k++;
            //     } else {
            //         //alert("Job Already exists");
            //         $.notify("Job Already exists.", "warning");
            //     }
            // }
            // else if (workId == 5 && jobdesc != '') {
            //     //paints
            //     var parts3ArrIndex = $.inArray(jobRef, parts3Arr);
            //
            //     if (parts3ArrIndex < 0) {
            //         netprice = qty * sellPrice;
            //         totalPrice= qty * sellPrice;
            //         calculateProductWiseDiscount(netprice, discount, discount_type, discount_precent, discount_amount, 0);
            //         totalPriceWithDiscount=parseFloat(totalPrice-product_discount);
            //         proVat=addProductVat((totalPriceWithDiscount),isNewVat,isNewNbt,newNbtRatio);
            //         proNbt=addProductNbt((totalPriceWithDiscount),isNewVat,isNewNbt,newNbtRatio) ;
            //         netprice +=proVat ;
            //         netprice +=proNbt ;
            //         $("#tbl_job tbody").append("<tr estlineno='"+estLine+"' cost_price='"+costprice+"' est_price='"+estprice+"' discount_type='"+discount_type+"'  proDiscount='"+product_discount+"' disPrecent='"+prodiscount_precent+"' totalPrice='"+totalPrice+"' isvat='"+isNewVat+"' isnbt='"+isNewNbt+"' nbtRatio='"+newNbtRatio+"' proVat='"+proVat+"' proNbt='"+proNbt+"' job='" + jobdesc + "' jobid='" + workId + "' qty='" + qty + "' jobOrder='" + workOrder + "'  netprice='" + netprice + "' sellprice='" + sellPrice + "' isIns='" + isInsurance + "' insurance='" + insurance + "' work_id='" + jobRef + "' timestamp='" + timestamp + "'><td>" + k + "-"+this.rowIndex+"</td><td work_id='" + workId + "'>" + workTypes + "</td><td>" + jobdesc + "</td><td class='text-right'>" + accounting.formatNumber(qty) + "</td><td class='text-right'>" + accounting.formatNumber(sellPrice) + "</td><td class='text-right'>" + accounting.formatNumber(prodiscount_precent) + "</td><td class='text-right'>" + accounting.formatNumber(estprice) + "</td><td class='text-right'>" + accounting.formatNumber(netprice) + "</td><td>&nbsp;<i class='glyphicon glyphicon-edit edit btn btn-info btn-xs'></i>&nbsp;<i class='remove btn btn-danger btn-xs glyphicon glyphicon-remove-circle'></i></td></tr>");
            //         if (jobRef != 0 || jobRef != '') { parts3Arr.push(jobRef); }
            //         $("#jobdesc").val('');
            //         $("#jobdesc2").val('');
            //         totalAmount += parseFloat(totalPrice);
            //         totalNetAmount +=parseFloat(netprice);
            //         totalProVAT+=parseFloat(proVat);
            //         totalProNBT+=parseFloat(proNbt);
            //         clearProductData();
            //         k++;
            //     } else {
            //         //alert("Job Already exists");
            //         $.notify("Job Already exists.", "warning");
            //     }
            // }
            else{
                if (workId !=''  && jobdesc != ''){
                    netprice = qty * sellPrice;
                    totalPrice= qty * sellPrice;
                    calculateProductWiseDiscount(netprice, discount, discount_type, discount_precent, discount_amount, 0);
                    totalPriceWithDiscount=parseFloat(totalPrice-product_discount);
                    proVat=addProductVat((totalPriceWithDiscount),isNewVat,isNewNbt,newNbtRatio);
                    proNbt=addProductNbt((totalPriceWithDiscount),isNewVat,isNewNbt,newNbtRatio) ;
                    netprice +=proVat ;
                    netprice +=proNbt ;
                    $("#tbl_job tbody").append("<tr serial='' estlineno='"+estLine+"' cost_price='"+costprice+"' est_price='"+estprice+"' discount_type='"+discount_type+"'  proDiscount='"+product_discount+"' disPrecent='"+prodiscount_precent+"' totalPrice='"+totalPrice+"' isvat='"+isNewVat+"' isnbt='"+isNewNbt+"' nbtRatio='"+newNbtRatio+"' proVat='"+proVat+"' proNbt='"+proNbt+"' job='" + jobdesc + "' jobid='" + workId + "' qty='" + qty + "' jobOrder='" + workOrder + "'  netprice='" + netprice + "' sellprice='" + sellPrice + "' isIns='" + isInsurance + "' insurance='" + insurance + "' work_id='" + jobRef + "' timestamp='" + timestamp + "'>" +
                        "<td>" + k + "</td>" +
                        "<td work_id='" + workId + "'>" + workTypes + "</td>" +
                        "<td>" + jobdesc + "</td>" +
                        "<td> </td>" +
                        "<td class='text-right'>" + accounting.formatNumber(qty) + "</td>" +
                        "<td class='text-right'>" + accounting.formatNumber(sellPrice) + "</td>" +
                        "<td class='text-right'>" + accounting.formatNumber(prodiscount_precent) + "</td>" +
                        "<td class='text-right'>" + accounting.formatNumber(estprice) + "</td>" +
                        "<td class='text-right'>" + accounting.formatNumber(netprice) + "</td>" +
                        "<td>&nbsp;<i class='glyphicon glyphicon-edit edit btn btn-info btn-xs'></i>&nbsp;<i class='remove btn btn-danger btn-xs glyphicon glyphicon-remove-circle'></i></td>" +
                        "</tr>");
                    if (jobRef != 0 || jobRef != '') { parts3Arr.push(jobRef); }
                    $("#jobdesc").val('');
                    $("#jobdesc2").val('');
                    totalAmount += parseFloat(totalPrice);
                    totalNetAmount +=parseFloat(netprice);
                    totalProVAT+=parseFloat(proVat);
                    totalProNBT+=parseFloat(proNbt);
                    clearProductData();
                    k++;
                }else{
                    $.notify("Unit Price can not be empty.", "warning");
                }
            }
        }

        

        $("#totalWithOutDiscount").val(totalAmount);

        totalVat=addTotalVat(totalAmount,isTotalVat,isTotalNbt,nbtRatio);
        totalNbt=addTotalNbt(totalAmount,isTotalVat,isTotalNbt,nbtRatio);

        totalNet=parseFloat(totalNetAmount+totalVat+totalNbt);
        total_discount-=totalInvDiscount;
        $("#totalAmount,#mtotal").html(accounting.formatNumber(totalAmount));
        $("#totalDiscount,#mdiscount").html(accounting.formatNumber(total_discount));
        $("#totalNet,#mnetpay").html(accounting.formatNumber(totalNet));
        $("#totalVat,#mvat").html(accounting.formatNumber(totalVat+totalProVAT));
        $("#totalNbt,#mnbt").html(accounting.formatNumber(totalNbt+totalProNBT));
        finalVat=totalVat+totalProVAT;
        finalNbt=totalNbt+totalProNBT;
        totalInvDiscount=0;
    });
 
 //=========calculate total item wise discount by precentage=============================
    $("#disPercent").blur(function() {
        totalInvDiscount=0;
        discount_precent = parseFloat($("#disPercent").val());
        discount_amount = parseFloat($("#disAmount").val());
        discount = $("input[name='discount']:checked").val();
        discount_type = $("input[name='discount_type']:checked").val();
        var total_amount3 = parseFloat($("#totalWithOutDiscount").val());

        if (discount_type == 2) {
            calculateTotalItemWiseDiscount(discount, discount_type, discount_precent, discount_amount, totalAmount);
        }
        totalNet=parseFloat(totalAmount-totalInvDiscount-totalProWiseDiscount+totalVat+totalProVAT+totalNbt+totalProNBT);
        $("#totalNet,#mnetpay").html(accounting.formatNumber(totalNet));
        $("#totalDiscount,#mdiscount").html(accounting.formatNumber(total_discount));
    });

//=========calculate total item wise discount by amount=============================
    $("#disAmount").blur(function() { 
        totalInvDiscount=0;
        discount_precent = parseFloat($("#disPercent").val());
        discount_amount = parseFloat($("#disAmount").val());
        discount = $("input[name='discount']:checked").val();
        discount_type = $("input[name='discount_type']:checked").val();
        var total_amount3 = parseFloat($("#totalWithOutDiscount").val());
        if (discount_type == 2) {
            calculateTotalItemWiseDiscount(discount, discount_type, discount_precent, discount_amount, totalAmount);
        }
        totalNet=parseFloat(totalAmount-totalInvDiscount-totalProWiseDiscount+totalVat+totalProVAT+totalNbt+totalProNBT);
        $("#totalNet,#mnetpay").html(accounting.formatNumber(totalNet));
        $("#totalDiscount,#mdiscount").html(accounting.formatNumber(total_discount));
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
                $("#costPrice").val(jobCost);
            } else {
                jobRef = 0;
                jobCost = 0;
                $("#qty").val(1);
                $("#sellPrice").val(jobCost);
                $("#costPrice").val(jobCost);
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

//remove row from table
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
            product_discount= parseFloat($(this).parent().parent().attr('proDiscount'));
            totalProWiseDiscount -= product_discount;
            total_discount-= product_discount;
            totalVat=addTotalVat(totalAmount,isTotalVat,isTotalNbt,nbtRatio);
            totalNbt=addTotalNbt(totalAmount,isTotalVat,isTotalNbt,nbtRatio);
            $("#totalDiscount").html(accounting.formatNumber(total_discount));

            $(this).parent().parent().remove();
            totalNet=parseFloat(totalNetAmount+totalVat+totalNbt);
            $("#totalAmount,#mtotal").html(accounting.formatNumber(totalAmount));
            $("#totalNet,#mnetpay").html(accounting.formatNumber(totalNet));
            $("#totalVat,#mvat").html(accounting.formatNumber(totalVat+totalProVAT));
            $("#totalNbt,#mnbt").html(accounting.formatNumber(totalNbt+totalProNBT));
            finalVat=totalVat+totalProVAT;
            finalNbt=totalNbt+totalProNBT;
             product_discount=0;
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
        var proDiscount=[];
        var disPercent=[];
        var disType=[];
        var estimatePrice=[];
        var costPrice =[];
        var estLineNo=[];
        var serialArr=[];

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
            proDiscount.push($(this).attr('proDiscount'));
            disPercent.push($(this).attr('disPrecent'));
            disType.push($(this).attr('discount_type'));
            estimatePrice.push($(this).attr('estprice'));
            costPrice.push($(this).attr('cost_price'));
            estLineNo.push($(this).attr('estlineno'));
            serialArr.push($(this).attr('serial'));
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
        var proDiscountArr = JSON.stringify(proDiscount);
        var disPercentArr = JSON.stringify(disPercent);
        var disTypeArr = JSON.stringify(disType);
        var estimatePriceArr = JSON.stringify(estimatePrice);
        var costPriceArr = JSON.stringify(costPrice);
        var estLineNoArr = JSON.stringify(estLineNo);
        var serialArray = JSON.stringify(serialArr);

        var supNum = $("#supplemetNo").val();
        estimateNo = $("#estimateNo").val();
        var esdate = $("#appoDate").val();
        var insCompany = $("#vehicleCompany").val();
        var estimate_type = $("#estimateType").val();
        var job_type = $("#jobType").val();
        // var regNo = $("#regNo").val();
        var action = $("#action").val();
        var remark = $("#remark").val();
        var nbtRatioRate=$("#nbtRatioRate").val();
        var InvoiceType=$("#invoiceType option:selected").val();
        var partType = $("#partInvType option:selected").html();

        var bankacc    = $("#bank_acc").val();
        var ccRef = new Array();
        var ccAmount = new Array();
        var ccType = new Array();
        var ccName = new Array();

        var chequeDate = $("#chequeDate").val();
        var chequeReference = $("#chequeReference").val();
        var chequeReciveDate = $('#chequeReciveDate').val();
        var chequeNo = $('#chequeNo').val();
        var bank = $("#bank option:selected").val();


        $('#tblCard tbody tr').each(function(rowIndex, element) {
            ccAmount.push($(this).attr('camount'));
            ccRef.push($(this).attr('cref'));
            ccType.push($(this).attr('ctype'));
            ccName.push($(this).attr('cname'));
        });

        var ccAmountArr = JSON.stringify(ccAmount);
        var ccRefArr  = JSON.stringify(ccRef);
        var ccTypeArr = JSON.stringify(ccType);
        var ccNameArr = JSON.stringify(ccName);

        var pay_remark = $("#pay_remark").val();
        var com_amount = $('#com_amount').val();
        var compayto = $('#compayto').val();
        var receiver_name = $('#receiver_name').val();
        var receiver_nic = $('#receiver_nic').val();
        var mileageout = $('#mileageout').val();
        var mileageoutUnit = $("#mileageoutUnit option:selected").val();

        var r = confirm('Are you sure, Do you want to generate final '+partType+' ?');
                    if (r === true) {

        $("#modelNotifi").html('');
        if((jobNo=='' || jobNo==0) && (cusCode==''  && regNo=='')){
            $.notify("Please select a job card number..", "danger");
            return false;
        }else if(cusCode=='' || cusCode==0){
            $.notify("Customer can not be empty.Please select a customer.", "danger");
            return false;
        }else if(desc.length > 0) {
            $('#btnSave,#btnSaveInv').attr('disabled', true);
            $.ajax({
                url: "../salesinvoice/saveInvoices",
                type: "POST",
                data: { action: action,remark:remark ,mileageout:mileageout,mileageoutUnit:mileageoutUnit,com_amount:com_amount, compayto:compayto,receiver_name:receiver_name,
                    receiver_nic:receiver_nic,InvoiceType:InvoiceType,partInvType:partInvType, date: esdate, estimateNo: estimateNo,invoiceNo: invoiceNo,
                    tempInvoiceNo:tempInvoiceNo, remark: remark, estimateAmount: totalAmount, insCompany: insCompany, cusCode: cusCode, serialArray: serialArray,
                    jobNo: jobNo, job_type: job_type, estimate_type: estimate_type, net_price: net_priceArr, qty: qtyArr, sell_price: sell_priceArr, is_ins: is_insArr,
                    insurance: insuranceArr, desc: descArr, job_id: job_idArr, job_order: job_orderArr, work_id: work_idArr, estLineNo:estLineNoArr, timestamp: timestampArr,
                    isVat:isVatArr,isNbt:isNbtArr,nbtRatio:nbtRatioArr,proVat:proVatArr,proNbt:proNbtArr,totalPrice:totalPriceArr,proDiscount:proDiscountArr,
                    disPercent:disPercentArr,discountType:disTypeArr,estPrice:estimatePriceArr,costPrice:costPriceArr,nbtRatioRate: nbtRatioRate,isTotalVat:isTotalVat,
                    isTotalNbt:isTotalNbt,totalNet:totalNet,totalAmount:totalAmount,totalVat:finalVat,totalNbt:finalNbt,total_discount:total_discount,bankacc:bankacc,
                    bank_amount:bank_amount,cashAmount:cashAmount,creditAmount:creditAmount,chequeAmount:chequeAmount,cardAmount:cardAmount,advance_amount:advance_amount,
                    advance_pay_no:advance_payment_no,return_payment_no:return_payment_no,return_amount:return_amount,ccAmount: ccAmountArr, ccRef: ccRefArr, ccType: ccTypeArr,
                    ccName: ccNameArr,chequeNo:chequeNo,bank: bank,chequeReference: chequeReference, chequeRecivedDate: chequeReciveDate, chequeDate: chequeDate,pay_remark:pay_remark},
                success: function(data) {
                    var newdata = JSON.parse(data);
                    var fb = newdata.fb;
                    var lastproduct_code = newdata.JobInvNo;

                    if (fb) {
                        $("#lastJob").html('');
                        $("#btnSave,#btnSaveInv").prop('disabled',true);
                        // $("#lastJob").html(lastproduct_code);
                        $.notify("Job Invoice successfully saved.", "success");
                        $("#modelNotifi").html(" Last Job Invoice NUmber = "+lastproduct_code);
                        
                        loadInvoiceData(lastproduct_code);
                        $("#btnSave,#btnSaveInv").prop('disabled',true);
                        total_amount = 0;
                            total_discount = 0;
                            totalNetAmount = 0;
                            supcode = 0;
                            creditAmount = 0;
                            dueAmount = 0;
                            advance_amount=0;
                            advance_payment_no=0;
                            totalProWiseDiscount = 0;
                            totalGrnDiscount = 0;
                            shipping = 0;
                             cashAmount=0;
                            chequeAmount=0;cardAmount=0;
                            return_payment_no=0;return_amount=0;
                            bank_amount=0;

                            $("#cash_amount").val(0);
                            $("#cheque_amount").val(0);
                            $("#credit_amount").val(0);
                            $("#advance_amount").val(0);
                            $("#bank_amount").val(0);
                            $("#card_amount").val(0);
                        isProVatEnabled=0;
                        SupNumber = 0;
                    } else {
                        $("#lastJob").html('');
                        $('#btnSave,#btnSaveInv').attr('disabled', false);
                    }
                }
            });
        } else {
            // $("#modelNotifi").html("Please add job descriptions.");
            $.notify("Please add job descriptions..", "danger");
        }

        }else{
            return false;
        }

    });

$("#btnSaveTemp").click(function() {
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
        var proDiscount=[];
        var disPercent=[];
        var disType=[];
        var estimatePrice=[];
        var costPrice =[];
        var estLineNo=[];

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
            proDiscount.push($(this).attr('proDiscount'));
            disPercent.push($(this).attr('disPrecent'));
            disType.push($(this).attr('discount_type'));
            estimatePrice.push($(this).attr('estprice'));
            costPrice.push($(this).attr('cost_price'));
            estLineNo.push($(this).attr('estlineno'));
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
        var proDiscountArr = JSON.stringify(proDiscount);
        var disPercentArr = JSON.stringify(disPercent);
        var disTypeArr = JSON.stringify(disType);
        var estimatePriceArr = JSON.stringify(estimatePrice);
        var costPriceArr = JSON.stringify(costPrice);
        var estLineNoArr = JSON.stringify(estLineNo);

         var ccRef = new Array();
        var ccAmount = new Array();
        var ccType = new Array();
        var ccName = new Array();

        var chequeDate = $("#chequeDate").val();
        var chequeReference = $("#chequeReference").val();
        var chequeReciveDate = $('#chequeReciveDate').val();
        var chequeNo = $('#chequeNo').val();
        var bank = $("#bank option:selected").val();


        $('#tblCard tbody tr').each(function(rowIndex, element) {
            ccAmount.push($(this).attr('camount'));
            ccRef.push($(this).attr('cref'));
            ccType.push($(this).attr('ctype'));
            ccName.push($(this).attr('cname'));
        });

        var ccAmountArr = JSON.stringify(ccAmount);
        var ccRefArr  = JSON.stringify(ccRef);
        var ccTypeArr = JSON.stringify(ccType);
        var ccNameArr = JSON.stringify(ccName);

        var bankacc    = $("#bank_acc").val();

        var com_amount = $('#com_amount').val();
        var compayto = $('#compayto').val();
        var receiver_name = $('#receiver_name').val();
        var receiver_nic = $('#receiver_nic').val();

        var supNum = $("#supplemetNo").val();
        estimateNo = $("#estimateNo").val();
        var esdate = $("#appoDate").val();
        var insCompany = $("#vehicleCompany").val();
        var estimate_type = $("#estimateType").val();
        var job_type = $("#jobType").val();
        // var regNo = $("#regNo").val();
        var action = $("#actionTemp").val();
        var remark = $("#remark").val();
        var nbtRatioRate=$("#nbtRatioRate").val();
        var InvoiceType=$("#invoiceType option:selected").val();
        var mileageout = $('#mileageout').val();
        var mileageoutUnit = $("#mileageoutUnit option:selected").val();

         var r = confirm('Are you sure, Do you want to save Temparary Invoice ?');
                    if (r === true) {


        $("#modelNotifi").html('');
        if((jobNo=='' || jobNo==0) && (cusCode==''  && regNo=='')){
            $.notify("Please select a job card number..", "danger");
            return false;
        }else if(cusCode=='' || cusCode==0){

            $.notify("Customer can not be empty.Please select a customer.", "danger");
            return false;
        }else if(regNo=='' || regNo==0){
            $.notify("Vehicle's register number can not be empty.Please select a vehicle.", "danger");
            return false;
        }else if(desc.length > 0) {
            $('#btnSave').attr('disabled', true);
            $.ajax({
                url: "../salesinvoice/saveTempInvoices",
                type: "POST",
                data: { action: action, InvoiceType:InvoiceType,remark:remark ,mileageout:mileageout,mileageoutUnit:mileageoutUnit, date: esdate, estimateNo: estimateNo,invoiceNo: tempInvoiceNo, remark: remark, estimateAmount: totalAmount, insCompany: insCompany, cusCode: cusCode, regNo: regNo, sup_no: supNum, jobNo: jobNo, job_type: job_type, estimate_type: estimate_type, net_price: net_priceArr, qty: qtyArr, sell_price: sell_priceArr, is_ins: is_insArr, insurance: insuranceArr, desc: descArr, job_id: job_idArr, job_order: job_orderArr, work_id: work_idArr,estLineNo:estLineNoArr,  timestamp: timestampArr,isVat:isVatArr,isNbt:isNbtArr,nbtRatio:nbtRatioArr,proVat:proVatArr,proNbt:proNbtArr,totalPrice:totalPriceArr,proDiscount:proDiscountArr,disPercent:disPercentArr,discountType:disTypeArr,estPrice:estimatePriceArr,costPrice:costPriceArr,
                nbtRatioRate: nbtRatioRate,isTotalVat:isTotalVat,isTotalNbt:isTotalNbt,totalNet:totalNet,totalAmount:totalAmount,totalVat:finalVat,totalNbt:finalNbt,total_discount:total_discount},
                success: function(data) {
                    var newdata = JSON.parse(data);
                    var fb = newdata.fb;
                    var lastproduct_code = newdata.JobInvNo;

                    if (fb) {
                        $('#btnSaveTemp').attr('disabled', true);
                        $("#lastJob").html('');
                        // $("#lastJob").html(lastproduct_code);
                        $.notify("Job Invoice successfully saved.", "success");
                        $("#modelNotifi").html(" Last Job Invoice NUmber = "+lastproduct_code);
                        
                        // loadnewtempinvoice(lastproduct_code);
                        isProVatEnabled=0;
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

        }else{
            return false;
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

if(totalProVAT>0 || totalProNBT>0 ||  isProVatEnabled==1){
    $("input[name='isTotalVat']").iCheck('uncheck');
    $("input[name='isTotalNbt']").iCheck('uncheck');
    $("#isTotalVat").prop('disabled',true);
    $("#isTotalNbt").prop('disabled',true);
    isTotalVat=0;
    isTotalNbt=0;
}

if(totalVat>0 || totalNbt>0  || isProVatEnabled==1){
    $("input[name='isProVat']").iCheck('uncheck');
    $("input[name='isProNbt']").iCheck('uncheck');
    $("#isProVat").prop('disabled',true);
    $("#isProNbt").prop('disabled',true);
    isProVat=0;
    isProNbt=0;
}

var totalNbt=0;
var totalVat=0;
var proVat=0;
var proNbt=0;
    function addProductVat(amount,vat,nbt,nratio){
        if(vat==1 && isTotalVat!=1 && isTotalNbt!=1){
            proVat=amount*vatRate/100;
            isProVatEnabled=1;
        }else{
            proVat=0;
        }
        
        return proVat;
    }

    function addProductNbt(amount,vat,nbt,nratio){
        if(nbt==1 && isTotalVat!=1 && isTotalNbt!=1){
            proNbt=amount*nbtRate/100*nratio;
             isProVatEnabled=1;
        }else{
            proNbt=0;
        }
       
        return proNbt;
    }

    function addTotalVat(amount,vat,nbt,nratio){
        if(vat==1 && isProVat!=1 && isProNbt!=1 && isProVatEnabled!=1){
            totalVat=amount*vatRate/100;
        }else{
            totalVat=0;
        }
        return totalVat;
    }

    function addTotalNbt(amount,vat,nbt,nratio){
        if(nbt==1 && isProVat!=1 && isProNbt!=1 && isProVatEnabled!=1){
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
        $("#costPrice").val(mcostPrice);
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
        $("#costPrice").val('');
        $("#product").val('');
        $('#isInsurance').iCheck('uncheck');
        $("#insurance").val('');
        $('#disPercent').val(0);
        $('#disAmount').val(0);
        $("#estlineno").val('');
        $("#jobdesc").val('');

        proName = 0;
        proCode = 0;
        netprice = 0;
        isInsurance = 0;
        jobRef = 0;
        jobCost = 0;
        costprice=0;
        timestamp = 0;
        proVat=0;
        proNbt=0;
        totalPriceWithDiscount=0;
        prodiscount_precent=0;
        discount=0;
        discount_type=0;
        discount_precent=0;
        discount_amount=0;
        product_discount=0;
        itemCode=0;

        $("#qty").attr('disabled', false);
        $("#product").attr('disabled', false);
        $("#workType").attr('disabled', false);
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

//print invocie
    $("#btnPrint").click(function() {
        $('#printArea').focus().print();
    });

    var compayto='';

//commsionpayto
$("#compayto").autocomplete({
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
        minLength: 0,
        select: function(event, ui) {
            compayto = ui.item.value;
            $("#compayto").html(ui.item.label);
            $("#compaytoid").html(compayto);
        }
    });

//auto load invoice ifset jobno 
    jobNo = $("#jobNo").val();
    if (jobNo != '') {
        loadJobData();
        $("#btnViewJob").attr('disabled', false);
    } else {
        $("#btnViewJob").attr('disabled', true);
    }

//auto load invoice ifset estimate No
estimateNo = $("#estimateNo").val();
SupNumber = $("#supplemetNo").val();

    if (estimateNo != '') {
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
                data: { estimateNo: estimateNo, supplimentNo: SupNumber },
                success: function(data) {
                    var resultData = JSON.parse(data);

                    setGridandLabelData(resultData);
                    loadEstimateDatatoGrid(resultData);
                }
            });     
}
//auto load invoice ifset invoiceno 
    invoiceNo = $("#invoiceNo").val();
    if (invoiceNo != '') {
            clearCustomerData();
            clearVehicleData();
            clearInvoiceData();
            $("#tbl_payment tbody").html("");
            $("#tbl_job tbody").html('');
            total_due_amount = 0;
            total_over_payment = 0;
            $("#btnViewJob").attr('disabled', false);
            SupNumber = 0;
            $.ajax({
                type: "POST",
                url: "../salesinvoice/getInvoiceDataByInvoiceNo",
                data: { invoiceNo: invoiceNo },
                success: function(data) {
                    var resultData = JSON.parse(data);

                    setGridandLabelData(resultData);

                    loadInvoiceDatatoGrid(resultData);
                }
            });
    }

    //auto load invoice ifset invoiceno 
    tempInvoiceNo = $("#tempNo").val();
    // if (tempInvoiceNo != '') {
    //         clearCustomerData();
    //         clearVehicleData();
    //         clearInvoiceData();
    //         $("#tbl_payment tbody").html("");
    //         $("#tbl_job tbody").html('');
    //         total_due_amount = 0;
    //         total_over_payment = 0;
    //         $("#btnViewJob").attr('disabled', false);
    //         SupNumber = 0;
    //         $.ajax({
    //             type: "POST",
    //             url: "../salesinvoice/getTempInvoiceDataByInvoiceNo",
    //             data: { invoiceNo: tempInvoiceNo },
    //             success: function(data) {
    //                 var resultData = JSON.parse(data);
    //
    //                 setGridandLabelData(resultData);
    //
    //                 loadTempInvoiceDatatoGrid(resultData);
    //             }
    //         });
    // }

    // function loadnewtempinvoice(tempinv){
    //     clearCustomerData();
    //         clearVehicleData();
    //         clearInvoiceData();
    //         $("#tbl_payment tbody").html("");
    //         $("#tbl_job tbody").html('');
    //         total_due_amount = 0;
    //         total_over_payment = 0;
    //         $("#btnViewJob").attr('disabled', false);
    //         SupNumber = 0;
    //         $.ajax({
    //             type: "POST",
    //             url: "../salesinvoice/getTempInvoiceDataByInvoiceNo",
    //             data: { invoiceNo: tempinv },
    //             success: function(data) {
    //                 var resultData = JSON.parse(data);
    //
    //                 setGridandLabelData(resultData);
    //
    //                 loadTempInvoiceDatatoGrid(resultData);
    //             }
    //         });
    // }

    $("#estimateType").change(function() {
        var action = $("#action").val();
        var estType = $(this).val();
        var lastSup = 0;
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
                    $("#btnSave").html('Generate Invoice');
                } else if (estType == 2 && jobNo != '' && (estimateNo != '' || estimateNo != 0) && SupNumber > lastSup) {
                    $("#supplemetNo").val(SupNumber);
                    $("#action").val(1);
                    $("#btnSave").html('Generate Invoice');
                } else if (estType == 1 && jobNo != '' && (estimateNo != '' || estimateNo != 0)) {
                    $("#supplemetNo").val(lastSup);
                    $("#action").val(2);
                    $("#btnSave").html('Generate Invoice');
                    $("#btnSave").prop("disabled",true);
                }else if (estType == 2 && jobNo == '' && (estimateNo != '' || estimateNo != 0)) {
                    $("#supplemetNo").val(SupNumber);
                    $("#action").val(1);
                    $("#btnSave").html('Generate Invoice');
                }else if (estType == 1 && jobNo == '' && (estimateNo != '' || estimateNo != 0)) {
                    $("#supplemetNo").val(lastSup);
                    $("#action").val(2);
                    $("#btnSave").html('Generate Invoice');
                    $("#btnSave").prop("disabled",true);
                }
            }
        });
    });

    //load invoice to print view
    function loadInvoiceData(invNo) {
        clearInvoiceData();
        var totalEstAmount = 0;
        $.ajax({
            type: "POST",
            url: "../salesinvoice/getInvoiceDataById",
            data: { invNo: invNo },
            success: function(data) {
                var resultData = JSON.parse(data);
                genarateInvLink(invNo);
                cusCode = resultData.cus_data.CusCode;
                outstanding = resultData.cus_data.CusOustandingAmount;
                available_balance = parseFloat(resultData.cus_data.CreditLimit) - parseFloat(outstanding);
                customer_name = resultData.cus_data.CusName;
                $("#lblcusName").html(resultData.cus_data.RespectSign + ". " + resultData.cus_data.CusName+"<br>"+nl2br(resultData.cus_data.Address01) + "<br>");
                $("#lblcusCode").html(resultData.cus_data.CusCode);
                $("#creditLimit").html(accounting.formatMoney(resultData.cus_data.CreditLimit));
                $("#creditPeriod").html(resultData.cus_data.CreditPeriod);
                $("#cusOutstand").html(accounting.formatMoney(outstanding));
                $("#availableCreditLimit").html(accounting.formatMoney(available_balance));
                $("#lblAddress").html(nl2br(resultData.cus_data.Address01) + ", " + resultData.cus_data.Address02);
                $("#cusAddress2").html(resultData.cus_data.Address03);
                $("#lbltel").html(resultData.cus_data.MobileNo);

                // $("#lblConName").html(resultData.vehicle_data.contactName);
                // $("#lblregNo").html(resultData.vehicle_data.RegNo);
                // $("#lblmake").html(resultData.vehicle_data.make);
                // $("#lblmodel").html(resultData.vehicle_data.model);
                // $("#lblviNo").html(resultData.vehicle_data.ChassisNo);
                if(resultData.invjob){
                    $("#lblodo").html(resultData.invjob.OdoIn);
                    $("#lblTypeOfJob").html(resultData.invjob.CusType);
                }

                $("#lblestimateNo").html(resultData.inv_hed.JobEstimateNo);
                $("#lblinvoiceNo").html(resultData.inv_hed.JobInvNo);
                $("#lbljobNo").html(resultData.inv_hed.JobCardNo);
                $("#lblinvDate").html(resultData.inv_hed.JobInvoiceDate);
                $("#lblremark").html(resultData.inv_hed.InvRemark);
                $("#lbltotalEsAmount").html(accounting.formatMoney(resultData.inv_hed.JobTotalAmount));
                $("#lbltotalVat").html(accounting.formatMoney(resultData.inv_hed.JobVatAmount));
                $("#lbltotalNbt").html(accounting.formatMoney(resultData.inv_hed.JobNbtAmount));
                $("#lbltotalNet").html(accounting.formatMoney(resultData.inv_hed.JobNetAmount));
                $("#lbltotalDicount").html(accounting.formatMoney(resultData.inv_hed.JobTotalDiscount));
                $("#lblAdvance").html(accounting.formatMoney(resultData.inv_hed.JobAdvance));

                if(resultData.inv_hed.InvoiceType==1){
                    $("#lblinvoiceType").html('CASH');
                    $("#lbltotalEsAmount").html(accounting.formatMoney(resultData.inv_hed.JobNetAmount));
                    $("#lbltotalVat").html(accounting.formatMoney(0));
                }else if(resultData.inv_hed.InvoiceType==2){
                    $("#lblinvoiceType").html('TAX');
                }

                if(resultData.inv_hed.JobTotalDiscount>0){
                    $("#rowDis").show();
                }else{
                    $("#rowDis").hide();
                }

                if(resultData.inv_hed.JobNbtAmount>0){
                    $("#rowNbt").show();
                }else{
                    $("#rowNbt").hide();
                }

                if(resultData.inv_hed.JobAdvance>0){
                    $("#rowAdvance").show();
                }else{
                    $("#rowAdvance").hide();
                }

                
                var k = 1;
                totalEstAmount = 0;
                $.each(resultData.inv_dtl, function(key, value) {
                    $("#tbl_est_data").append("<tr><td colspan='7' style='padding: 4px 3px 4px 50px;'><b>" + key + "</b></td></tr>");

                    for (var i = 0; i < value.length; i++) {
                            totalEstAmount += parseFloat(value[i].JobNetAmount);
                            $("#tbl_est_data").append("<tr><td style='text-align:center;padding: 3px;'>" + (k) + "</td><td style='padding: 3px;' colspan='2'>" + value[i].JobDescription + "</td><td style='text-align:right;padding: 3px;'>" + accounting.formatMoney(value[i].JobQty) + "</td><td  style='text-align:right;padding: 3px;'>" + accounting.formatMoney(value[i].JobPrice) + "</td><td  style='text-align:right;padding: 3px;' colspan='2'>" + accounting.formatMoney(value[i].JobTotalAmount) + "</td></tr>");
                        k++;
                    }
                    
                });
            }
        });
    }

    //load invoice to print view
    function loadTempInvoiceData(invNo) {
        clearInvoiceData();
        var totalEstAmount = 0;
        $.ajax({
            type: "POST",
            url: "../salesinvoice/getTempInvoiceDataById",
            data: { invNo: invNo },
            success: function(data) {
                var resultData = JSON.parse(data);
                genarateTempInvLink(invNo);
                cusCode = resultData.cus_data.CusCode;
                outstanding = resultData.cus_data.CusOustandingAmount;
                available_balance = parseFloat(resultData.cus_data.CreditLimit) - parseFloat(outstanding);
                customer_name = resultData.cus_data.CusName;
                $("#lblcusName").html(resultData.cus_data.RespectSign + ". " + resultData.cus_data.CusName+"<br>"+nl2br(resultData.cus_data.Address01) + "<br>");
                $("#lblcusCode").html(resultData.cus_data.CusCode);
                $("#creditLimit").html(accounting.formatMoney(resultData.cus_data.CreditLimit));
                $("#creditPeriod").html(resultData.cus_data.CreditPeriod);
                $("#cusOutstand").html(accounting.formatMoney(outstanding));
                $("#availableCreditLimit").html(accounting.formatMoney(available_balance));
                $("#lblAddress").html(nl2br(resultData.cus_data.Address01) + ", " + resultData.cus_data.Address02);
                $("#cusAddress2").html(resultData.cus_data.Address03);
                $("#lbltel").html(resultData.cus_data.MobileNo);

                // $("#lblConName").html(resultData.vehicle_data.contactName);
                // $("#lblregNo").html(resultData.vehicle_data.RegNo);
                // $("#lblmake").html(resultData.vehicle_data.make);
                // $("#lblmodel").html(resultData.vehicle_data.model);
                // $("#lblviNo").html(resultData.vehicle_data.ChassisNo);
                if(resultData.invjob){
                    $("#lblodo").html(resultData.invjob.OdoIn);
                    $("#lblTypeOfJob").html(resultData.invjob.CusType);
                }
                
                $("#lblestimateNo").html(resultData.inv_hed.JobEstimateNo);
                $("#lblinvoiceNo").html(resultData.inv_hed.JobInvNo);
                $("#lbljobNo").html(resultData.inv_hed.JobCardNo);
                $("#lblinvDate").html(resultData.inv_hed.JobInvoiceDate);
                $("#lblremark").html(resultData.inv_hed.InvRemark);
                $("#lbltotalEsAmount").html(accounting.formatMoney(resultData.inv_hed.JobTotalAmount));
                $("#lbltotalVat").html(accounting.formatMoney(resultData.inv_hed.JobVatAmount));
                $("#lbltotalNbt").html(accounting.formatMoney(resultData.inv_hed.JobNbtAmount));
                $("#lbltotalNet").html(accounting.formatMoney(resultData.inv_hed.JobNetAmount));
                $("#lbltotalDicount").html(accounting.formatMoney(resultData.inv_hed.JobTotalDiscount));
                $("#lblAdvance").html(accounting.formatMoney(resultData.inv_hed.JobAdvance));

                if(resultData.inv_hed.InvoiceType==1){
                    $("#lblinvoiceType").html('TEMP. CASH');
                    $("#lbltotalEsAmount").html(accounting.formatMoney(resultData.inv_hed.JobNetAmount));
                    $("#lbltotalVat").html(accounting.formatMoney(0));
                }else if(resultData.inv_hed.InvoiceType==2){
                    $("#lblinvoiceType").html('TEMP. TAX');
                }

                if(resultData.inv_hed.JobTotalDiscount>0){
                    $("#rowDis").show();
                }else{
                    $("#rowDis").hide();
                }

                if(resultData.inv_hed.JobNbtAmount>0){
                    $("#rowNbt").show();
                }else{
                    $("#rowNbt").hide();
                }

                if(resultData.inv_hed.JobAdvance>0){
                    $("#rowAdvance").show();
                }else{
                    $("#rowAdvance").hide();
                }

                
                var k = 1;
                totalEstAmount = 0;
                $.each(resultData.inv_dtl, function(key, value) {
                    $("#tbl_est_data").append("<tr><td colspan='7' style='padding: 4px 3px 4px 50px;'><b>" + key + "</b></td></tr>");

                    for (var i = 0; i < value.length; i++) {
                            totalEstAmount += parseFloat(value[i].JobNetAmount);
                            $("#tbl_est_data").append("<tr><td style='text-align:center;padding: 3px;'>" + (k) + "</td><td style='padding: 3px;' colspan='2'>" + value[i].JobDescription + "</td><td style='text-align:right;padding: 3px;'>" + accounting.formatMoney(value[i].JobQty) + "</td><td  style='text-align:right;padding: 3px;'>" + accounting.formatMoney(value[i].JobPrice) + "</td><td  style='text-align:right;padding: 3px;' colspan='2'>" + accounting.formatMoney(value[i].JobNetAmount) + "</td></tr>");
                        k++;
                    }
                    
                });
            }
        });
    }

    var totalEstAmount2 = 0;

    function loadJobData() {
        
        $("#btnViewJob").attr('disabled', false);
        clearCustomerData();
        clearVehicleData();
        $("#tbl_payment tbody").html("");
        total_due_amount = 0;
        total_over_payment = 0;
        totalEstAmount2 = 0;
        $.ajax({
            type: "POST",
            url: "../salesinvoice/getIssueNoteDataByJobNo",
            data: { jobNo: jobNo },
            success: function(data) {
                var resultData = JSON.parse(data);

                cusCode = resultData.cus_data.CusCode;
                outstanding = resultData.cus_data.CusOustandingAmount;
                available_balance = parseFloat(resultData.cus_data.CreditLimit) - parseFloat(outstanding);
                customer_name = resultData.cus_data.CusName;
                setGridandLabelData(resultData);

                var b = 0;
                totalEstAmount2 = 0;
                if(resultData.est_hed){
                    loadEstimateDatatoGrid(resultData);
                }
                
            }
        });
    }

//load edit grid data
    $("#tbl_job tbody").on('click', '.edit', function() {

        var jobtype = $(this).parent().parent().attr('jobid')
        var workid = $(this).parent().parent().attr('work_id');
        var jobdesc = $(this).parent().parent().attr('job');
        var qty = $(this).parent().parent().attr('qty');
        var selprice = $(this).parent().parent().attr('sellprice');
        var costprice = $(this).parent().parent().attr('cost_price');
        var netprice = $(this).parent().parent().attr('netprice');
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
        var proDiscount = $(this).parent().parent().attr('proDiscount');
        var disPrecent = $(this).parent().parent().attr('disPrecent');
        var estPrice = $(this).parent().parent().attr('est_price');
        var estLine = $(this).parent().parent().attr('estlineno');
        var serial = $(this).parent().parent().attr('serial');

        $("#addJob").attr('disabled', false);

        if(workid != 0){
            $("#qty").attr('disabled', true);
            $("#product").attr('disabled', true);
            $("#workType").attr('disabled', true);
        } else {
            $("#qty").attr('disabled', false);
            $("#product").attr('disabled', false);
            $("#workType").attr('disabled', false);
        }
       
            loadVATNBT(isvat,isnbt,nbtratio);
            $("#jobdesc").val(jobdesc);
            $("#workType").val(jobtype);
            $("#qty").val(qty);
            $("#insurance").val(insurance);
            $("#sellPrice").val(selprice);
            $("#product").val(workid);
            $("#prdName").val(jobdesc);
            $("#timestamp").val(timestamp);
            $("#proNbtRatio").val(nbtratio);
            $("#estPrice").val(estPrice);
            $("#costPrice").val(costprice);
            $("#estlineno").val(estLine);
            $("#serial").val(serial);

            $("input[name='isInsurance']:checked").val();

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
            totalAmount -= parseFloat(totalPrice);
            totalNetAmount -= parseFloat(netprice);
            totalProVAT -= parseFloat(proVat);
            totalProNBT -= parseFloat(proNbt);
            product_discount= parseFloat($(this).parent().parent().attr('proDiscount'));
            totalProWiseDiscount -= product_discount;
            total_discount-= product_discount;
           
            $(this).parent().parent().remove();
            totalVat=addTotalVat(totalAmount,isTotalVat,isTotalNbt,nbtRatio);
            totalNbt=addTotalNbt(totalAmount,isTotalVat,isTotalNbt,nbtRatio);

            totalNet=parseFloat(totalNetAmount+totalVat+totalNbt);
            $("#totalDiscount,#mdiscount").html(accounting.formatNumber(total_discount));
            $("#totalAmount,#mtotal").html(accounting.formatNumber(totalAmount));
            $("#totalNet,#mnetpay").html(accounting.formatNumber(totalNet));
            $("#totalVat,#mvat").html(accounting.formatNumber(totalVat+totalProVAT));
            $("#totalNbt,#mnbt").html(accounting.formatNumber(totalNbt+totalProNBT));
            finalVat=totalVat+totalProVAT;
            finalNbt=totalNbt+totalProNBT;
            product_discount=0;
        
    });

// load grid data
    function loadEstimateDatatoGrid(resultData) {
        totalAmount = 0;
        totalNetAmount = 0;
        totalProVAT = 0;
        totalProNBT = 0;
        totalVat = 0;
        totalNbt = 0;
        totalNet=0;
        total_discount=0;
        isProVatEnabled=0;
        $("#totalAmount,#mtotal").html(accounting.formatNumber(0));
        $("#totalNet,#mnetpay").html(accounting.formatNumber(0));
        $("#totalVat,#mvat").html(accounting.formatNumber(0));
        $("#totalNbt,#mnbt").html(accounting.formatNumber(0));

        invoiceNo = '';
        $("#invoiceNo").val('');
        if(resultData.isInv>0){
            $.notify("Invoice has already generated for this job card.", "danger");
            $("#btnSave").prop('disabled',true);
            $("#btnSaveInv").prop('disabled',true);
            $("#btnSaveTemp").prop('disabled',true);
        }else{
            $("#btnSave").prop('disabled',false);
            $("#btnSaveTemp").prop('disabled',false);
        }

        $("#tbl_job tbody").html('');
        if (resultData.est_dtl){
            // $("#vehicleCompany").val(resultData.est_hed.EstInsCompany);
            jobNo = resultData.est_hed.SalesPONumber;
            cusCode = resultData.est_hed.SalesCustomer;
            // regNo= resultData.est_hed.EstRegNo;
            $("#jobNo").val(jobNo);
            // $("#jobType").val(resultData.est_hed.EstJobType);
            // $("#estimateType").val(resultData.est_hed.EstType);
            // $("#supplemetNo").val(resultData.est_hed.Supplimentry);
            // $("#remark").val(resultData.est_hed.remark);
            SupNumber = resultData.est_hed.Supplimentry;
            jobNumArr.length = 0;
            proCodeArr.length = 0;
            paintsArr.length = 0;
            parts2Arr.length = 0;
            parts3Arr.length = 0;

            isTotalVat=resultData.est_hed.SalesVatAmount;
            isTotalNbt=resultData.est_hed.SalesNbtAmount;
            totalNbtRatio=resultData.est_hed.SalesNbtRatio;
            loadTotalVATNBT(isTotalVat,isTotalNbt,totalNbtRatio);
            for (var i = 0; i < resultData.est_dtl.length; i++) {
                if (resultData.est_dtl[i].JobType == 1) {
                    if (resultData.est_dtl[i].SalesProductCode > 0) { jobNumArr.push(resultData.est_dtl[i].SalesProductCode); }
                } else if (resultData.est_dtl[i].JobType == 2) {
                    if (resultData.est_dtl[i].SalesProductCode > 0) { proCodeArr.push(resultData.est_dtl[i].SalesProductCode) }
                } else if (resultData.est_dtl[i].JobType == 3) {
                    if (resultData.est_dtl[i].SalesProductCode > 0) { paintsArr.push(resultData.est_dtl[i].SalesProductCode); }
                } else if (resultData.est_dtl[i].JobType == 4) {
                    if (resultData.est_dtl[i].SalesProductCode > 0) { parts2Arr.push(resultData.est_dtl[i].SalesProductCode); }
                } else if (resultData.est_dtl[i].JobType == 5) {
                    if (resultData.est_dtl[i].SalesProductCode > 0) { parts3Arr.push(resultData.est_dtl[i].SalesProductCode); }
                }

                if(resultData.est_dtl[i].SalesVatAmount>0 || resultData.est_dtl[i].SalesNbtAmount>0){
                    isProVatEnabled=1;
                }
                // if (resultData.est_dtl[i].EstIsInsurance == 1) {
                //
                // } else {
                    totalProVAT += parseFloat(resultData.est_dtl[i].SalesVatAmount);
                    totalProNBT += parseFloat(resultData.est_dtl[i].SalesNbtAmount);
                    totalNetAmount += parseFloat(resultData.est_dtl[i].SalesInvNetAmount);
                // }
                $("#tbl_job tbody").append("<tr serial='"+resultData.est_dtl[i].SalesSerialNo+"' estlineno='"+(i + 1)+"' cost_price='"+resultData.est_dtl[i].SalesCostPrice+"' est_price='"+resultData.est_dtl[i].SalesInvNetAmount+"' discount_type='0'  proDiscount='0' disPrecent='0'  totalPrice='"+resultData.est_dtl[i].SalesTotalAmount+"' isvat='"+resultData.est_dtl[i].SalesIsVat+"' isnbt='"+resultData.est_dtl[i].SalesIsNbt+"' nbtRatio='"+resultData.est_dtl[i].SalesNbtRatio+"' proVat='"+resultData.est_dtl[i].SalesVatAmount+"' proNbt='"+resultData.est_dtl[i].SalesNbtAmount+"'  job='" + resultData.est_dtl[i].SalesProductName + "' jobid='" + 2 + "' qty='" + resultData.est_dtl[i].SalesQty + "' jobOrder='" + resultData.est_dtl[i].EstJobOrder + "' netprice='" + resultData.est_dtl[i].SalesInvNetAmount + "'  sellprice='" + resultData.est_dtl[i].SalesUnitPrice + "'  isIns='" + resultData.est_dtl[i].EstIsInsurance + "' insurance='" + resultData.est_dtl[i].EstInsurance + "' work_id='" + resultData.est_dtl[i].SalesProductCode + "'  timestamp='" + resultData.est_dtl[i].SalesInvDate + "'>" +
                    "<td>" + (i + 1) + "</td>" +
                    "<td work_id='" + 2 + "'> STOCK PARTS </td>" +
                    "<td>" + resultData.est_dtl[i].SalesProductName + " </td>" +
                    "<td>" + resultData.est_dtl[i].SalesSerialNo + "</td>" +
                    "<td class='text-right'>" + accounting.formatNumber(resultData.est_dtl[i].SalesQty) + "</td>" +
                    "<td class='text-right'>" + accounting.formatNumber(resultData.est_dtl[i].SalesUnitPrice) + "</td>" +
                    "<td  class='text-right'>"+accounting.formatNumber(0)+"</td>" +
                    "<td class='text-right'>" + accounting.formatNumber(resultData.est_dtl[i].SalesInvNetAmount) + "</td>" +
                    "<td class='text-right'>" + accounting.formatNumber(resultData.est_dtl[i].SalesInvNetAmount) + "</td>" +
                    "<td>&nbsp;&nbsp;<i class='glyphicon glyphicon-edit edit btn btn-info btn-xs'></i>" +
                    // "&nbsp;<i class='remove btn btn-danger btn-xs glyphicon glyphicon-remove-circle'></i>" +
                    "</td>" +
                    "</tr>");
                    totalAmount += parseFloat(resultData.est_dtl[i].SalesTotalAmount);
                    totalNet+=parseFloat(resultData.est_dtl[i].SalesInvNetAmount);
                    totalVat=addTotalVat(totalAmount,isTotalVat,isTotalNbt,totalNbtRatio);
                    totalNbt=addTotalNbt(totalAmount,isTotalVat,isTotalNbt,totalNbtRatio);
            }

            // totalVat=parseFloat(resultData.est_hed.EstVatAmount);
            // totalNbt=parseFloat(resultData.est_hed.EstNbtAmount);
            // totalAmount = parseFloat(resultData.est_hed.EstimateAmount);
            total_discount=0;
            // totalNet=parseFloat(resultData.est_hed.EstNetAmount);

            $("#totalAmount,#mtotal").html(accounting.formatNumber(totalAmount));
            $("#totalNet,#mnetpay").html(accounting.formatNumber(totalNet));
            $("#totalVat,#mvat").html(accounting.formatNumber(totalVat));
            $("#totalNbt,#mnbt").html(accounting.formatNumber(totalNbt));
            $("#totalDiscount,#mdiscount").html(accounting.formatNumber(total_discount));
            finalVat=totalVat+totalProVAT;
            finalNbt=totalNbt+totalProNBT;
            estimateNo = resultData.est_hed.EstimateNo;
            // loadEstimateData(resultData.est_hed.EstimateNo, resultData.est_hed.Supplimentry);
            $("#estimateNo").val(resultData.est_hed.EstimateNo);
            $("#btnSave").html('Generate Invoice');
            $("#action").val(1);

        } else {
           $("#btnSave").html('Generate Invoice');
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

//load invoice data to grid
    function loadInvoiceDatatoGrid(resultData) {
        totalAmount = 0;
        totalNetAmount = 0;
        totalProVAT = 0;
        totalProNBT = 0;
        totalVat = 0;
        totalNbt = 0;
        totalNet=0;
        total_discount=0;
        isProVatEnabled=0;
        SupNumber = 0;
        estimateNo = 0;
        invoiceNo = 0;

        $("#totalAmount,#mtotal").html(accounting.formatNumber(0));
        $("#totalNet,#mnetpay").html(accounting.formatNumber(0));
        $("#totalVat,#mvat").html(accounting.formatNumber(0));
        $("#totalNbt,#mnbt").html(accounting.formatNumber(0));
        $("#estimateNo").val('');
        $("#invoiceNo").val('');
        $("#supplemetNo").val('');

        if (resultData.inv_hed!=null || resultData.inv_dtl!=''){

            if(resultData.inv_hed.IsPayment==1){
                $("#btnSave").prop('disabled',true);
                $("#btnSaveTemp").prop('disabled',true);
            }else{
                $("#btnSave").prop('disabled',false);
                $("#btnSaveTemp").prop('disabled',true);
            } 
        }

        

        $("#tbl_job tbody").html('');

        if (resultData.inv_dtl!=null || resultData.inv_dtl!=''){
            jobNo = resultData.inv_hed.JobCardNo;
            $("#jobNo").val(jobNo);
            $("#jobType").val(resultData.inv_hed.JJobType);
            $("#estimateType").val(resultData.inv_hed.EstType);
            $("#supplemetNo").val(resultData.inv_hed.JobSupplimentry);
            $("#remark").val(resultData.inv_hed.InvRemark);
            // $("#remark").val(resultData.inv_hed.remark);
            SupNumber = resultData.inv_hed.JobSupplimentry;
            jobNumArr.length = 0;
            proCodeArr.length = 0;
            paintsArr.length = 0;
            parts2Arr.length = 0;
            parts3Arr.length = 0;
            for (var i = 0; i < resultData.inv_dtl.length; i++) {
                if (resultData.inv_dtl[i].JobType == 1) {
                    if (resultData.inv_dtl[i].JobCode > 0) { jobNumArr.push(resultData.inv_dtl[i].JobCode); }
                } else if (resultData.inv_dtl[i].JobType == 2) {
                    if (resultData.inv_dtl[i].JobCode > 0) { proCodeArr.push(resultData.inv_dtl[i].JobCode) }
                } else if (resultData.inv_dtl[i].JobType == 3) {
                    if (resultData.inv_dtl[i].JobCode > 0) { paintsArr.push(resultData.inv_dtl[i].JobCode); }
                } else if (resultData.inv_dtl[i].JobType == 4) {
                    if (resultData.inv_dtl[i].JobCode > 0) { parts2Arr.push(resultData.inv_dtl[i].JobCode); }
                } else if (resultData.inv_dtl[i].JobType == 5) {
                    if (resultData.inv_dtl[i].JobCode > 0) { parts3Arr.push(resultData.inv_dtl[i].JobCode); }
                }
                // if (resultData.inv_dtl[i].EstIsInsurance == 1) {} else {
                    totalAmount += parseFloat(resultData.inv_dtl[i].JobTotalAmount);
                    totalNetAmount += parseFloat(resultData.inv_dtl[i].JobNetAmount);
                    totalProVAT += parseFloat(resultData.inv_dtl[i].JobVatAmount);
                    totalProNBT += parseFloat(resultData.inv_dtl[i].JobNbtAmount);
                    product_discount=parseFloat(resultData.inv_dtl[i].JobDiscount);
                    totalProWiseDiscount += product_discount;
                // }
                $("#tbl_job tbody").append("<tr  estlineno='"+(resultData.inv_dtl[i].EstLineNo)+"'   cost_price='"+resultData.inv_dtl[i].JobCost+"'  est_price='0' discount_type='"+resultData.inv_dtl[i].JobDiscountType+"'  proDiscount='"+resultData.inv_dtl[i].JobDisValue+"' disPrecent='"+resultData.inv_dtl[i].JobDisPercentage+"'  totalPrice='"+resultData.inv_dtl[i].JobTotalAmount+"' isvat='"+resultData.inv_dtl[i].JobIsVat+"' isnbt='"+resultData.inv_dtl[i].JobIsNbt+"' nbtRatio='"+resultData.inv_dtl[i].JobNbtRatio+"' proVat='"+resultData.inv_dtl[i].JobVatAmount+"' proNbt='"+resultData.inv_dtl[i].JobNbtAmount+"'  job='" + resultData.inv_dtl[i].JobDescription + "' jobid='" + resultData.inv_dtl[i].JobType + "' qty='" + resultData.inv_dtl[i].JobQty + "' jobOrder='" + resultData.inv_dtl[i].JobOrder + "' netprice='" + resultData.inv_dtl[i].JobNetAmount + "'  sellprice='" + resultData.inv_dtl[i].JobPrice + "'  isIns='" + resultData.inv_dtl[i].JobPrice + "' insurance='" + resultData.inv_dtl[i].JobPrice + "' work_id='" + resultData.inv_dtl[i].JobCode + "'  timestamp='" + resultData.inv_dtl[i].JobinvoiceTimestamp + "'><td>" + (i + 1) + "</td><td work_id='" + resultData.inv_dtl[i].JobCode + "'>" + resultData.inv_dtl[i].jobtype_name + "</td><td class='text-right'>" + resultData.inv_dtl[i].JobDescription + "</td><td class='text-right'>" + accounting.formatNumber(resultData.inv_dtl[i].JobQty) + "</td><td class='text-right'>" + accounting.formatNumber(resultData.inv_dtl[i].JobPrice) + "</td><td class='text-right'>" + accounting.formatNumber(resultData.inv_dtl[i].JobDisPercentage) + "</td><td class='text-right'>" + accounting.formatNumber(0) + "</td><td class='text-right'>" + accounting.formatNumber(resultData.inv_dtl[i].JobNetAmount) + "</td><td>&nbsp;&nbsp;<i class='glyphicon glyphicon-edit edit btn btn-info btn-xs'></i>&nbsp;<i class='remove btn btn-danger btn-xs glyphicon glyphicon-remove-circle'></i></td></tr>");
            }

            totalVat=addTotalVat(resultData.inv_hed.JobTotalAmount,resultData.inv_hed.JobIsVatTotal,resultData.inv_hed.JobIsNbtTotal,resultData.inv_hed.JobNbtRatioTotal);
            totalNbt=addTotalNbt(resultData.inv_hed.JobTotalAmount,resultData.inv_hed.JobIsVatTotal,resultData.inv_hed.JobIsNbtTotal,resultData.inv_hed.JobNbtRatioTotal);
            
            total_discount= parseFloat(resultData.inv_hed.JobTotalDiscount);
            totalNet=parseFloat(totalAmount+totalVat+totalNbt-total_discount);
            $("#totalAmount,#mtotal").html(accounting.formatNumber(totalAmount));
            $("#totalDiscount,#mdiscount").html(accounting.formatNumber(total_discount));
            $("#totalNet,#mnetpay").html(accounting.formatNumber(totalNet));
            $("#totalVat,#mvat").html(accounting.formatNumber(totalVat+totalProVAT));
            $("#totalNbt,#mnbt").html(accounting.formatNumber(totalNbt+totalProNBT));
            finalVat=totalVat+totalProVAT;
            finalNbt=totalNbt+totalProNBT;

            estimateNo = resultData.inv_hed.JobEstimateNo;
            invoiceNo = resultData.inv_hed.JobInvNo;
            loadInvoiceData(resultData.inv_hed.JobInvNo);
            $("#estimateNo").val(resultData.inv_hed.JobEstimateNo);
            $("#invoiceNo").val(resultData.inv_hed.JobInvNo);
            $("#invoiceType").val(resultData.inv_hed.InvoiceType);
            genarateInvLink(invoiceNo);
            
            $("#btnSave").html('Update Invoice');
            $("#action").val(2);
            isTotalVat=resultData.inv_hed.JobIsVatTotal;
            isTotalNbt=resultData.inv_hed.JobIsNbtTotal;
            totalNbtRatio=resultData.inv_hed.JobNbtRatioTotal;
            loadTotalVATNBT(isTotalVat,isTotalNbt,totalNbtRatio);

        } else {
            $("#btnSave").html('Generate Invoice');
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

    //
    function loadTempInvoiceDatatoGrid(resultData) {
        // $("#jobNo").val('');
        $("#invoiceNo").val('');
        $("#supplemetNo").val('');
        $("#estimateNo").val('');
        
        $("#btnSaveTemp").prop('disabled',false);
        totalAmount = 0;
        totalNetAmount = 0;
        totalProVAT = 0;
        totalProNBT = 0;
        totalVat = 0;
        totalNbt = 0;
        totalNet=0;
        total_discount=0;
        isProVatEnabled=0;
        $("#totalAmount,#mtotal").html(accounting.formatNumber(0));
        $("#totalNet,#mnetpay").html(accounting.formatNumber(0));
        $("#totalVat,#mvat").html(accounting.formatNumber(0));
        $("#totalNbt,#mnbt").html(accounting.formatNumber(0));

        if(resultData.inv_hed){
            if(resultData.inv_hed.IsPayment==1){
                $("#btnSave").prop('disabled',true);
            }else{
                $("#btnSave").prop('disabled',false);
            } 

            $("#tbl_job tbody").html('');

        if (resultData.inv_dtl!=null || resultData.inv_dtl!=''){
            jobNo = resultData.inv_hed.JobCardNo;
            $("#jobNo").val(jobNo);
            $("#jobType").val(resultData.inv_hed.JJobType);
            $("#estimateType").val(resultData.inv_hed.EstType);
            $("#supplemetNo").val(resultData.inv_hed.JobSupplimentry);
            $("#remark").val(resultData.inv_hed.InvRemark);
            SupNumber = resultData.inv_hed.JobSupplimentry;
            jobNumArr.length = 0;
            proCodeArr.length = 0;
            paintsArr.length = 0;
            parts2Arr.length = 0;
            parts3Arr.length = 0;
            for (var i = 0; i < resultData.inv_dtl.length; i++) {
                if (resultData.inv_dtl[i].JobType == 1) {
                    if (resultData.inv_dtl[i].JobCode > 0) { jobNumArr.push(resultData.inv_dtl[i].JobCode); }
                } else if (resultData.inv_dtl[i].JobType == 2) {
                    if (resultData.inv_dtl[i].JobCode > 0) { proCodeArr.push(resultData.inv_dtl[i].JobCode) }
                } else if (resultData.inv_dtl[i].JobType == 3) {
                    if (resultData.inv_dtl[i].JobCode > 0) { paintsArr.push(resultData.inv_dtl[i].JobCode); }
                } else if (resultData.inv_dtl[i].JobType == 4) {
                    if (resultData.inv_dtl[i].JobCode > 0) { parts2Arr.push(resultData.inv_dtl[i].JobCode); }
                } else if (resultData.inv_dtl[i].JobType == 5) {
                    if (resultData.inv_dtl[i].JobCode > 0) { parts3Arr.push(resultData.inv_dtl[i].JobCode); }
                }
                // if (resultData.inv_dtl[i].EstIsInsurance == 1) {} else {
                    totalAmount += parseFloat(resultData.inv_dtl[i].JobTotalAmount);
                    totalNetAmount += parseFloat(resultData.inv_dtl[i].JobNetAmount);
                    totalProVAT += parseFloat(resultData.inv_dtl[i].JobVatAmount);
                    totalProNBT += parseFloat(resultData.inv_dtl[i].JobNbtAmount);
                    product_discount=parseFloat(resultData.inv_dtl[i].JobDiscount);
                    totalProWiseDiscount += parseFloat(product_discount);
                // }
                $("#tbl_job tbody").append("<tr  estlineno='"+(resultData.inv_dtl[i].EstLineNo)+"'  cost_price='"+resultData.inv_dtl[i].JobCost+"'  est_price='0' discount_type='"+resultData.inv_dtl[i].JobDiscountType+"'  proDiscount='"+resultData.inv_dtl[i].JobDisValue+"' disPrecent='"+resultData.inv_dtl[i].JobDisPercentage+"'  totalPrice='"+resultData.inv_dtl[i].JobTotalAmount+"' isvat='"+resultData.inv_dtl[i].JobIsVat+"' isnbt='"+resultData.inv_dtl[i].JobIsNbt+"' nbtRatio='"+resultData.inv_dtl[i].JobNbtRatio+"' proVat='"+resultData.inv_dtl[i].JobVatAmount+"' proNbt='"+resultData.inv_dtl[i].JobNbtAmount+"'  job='" + resultData.inv_dtl[i].JobDescription + "' jobid='" + resultData.inv_dtl[i].JobType + "' qty='" + resultData.inv_dtl[i].JobQty + "' jobOrder='" + resultData.inv_dtl[i].JobOrder + "' netprice='" + resultData.inv_dtl[i].JobNetAmount + "'  sellprice='" + resultData.inv_dtl[i].JobPrice + "'  isIns='" + resultData.inv_dtl[i].JobPrice + "' insurance='" + resultData.inv_dtl[i].JobPrice + "' work_id='" + resultData.inv_dtl[i].JobCode + "'  timestamp='" + resultData.inv_dtl[i].JobinvoiceTimestamp + "'><td>" + (i + 1) + "</td><td work_id='" + resultData.inv_dtl[i].JobCode + "'>" + resultData.inv_dtl[i].jobtype_name + "</td><td class='text-right'>" + resultData.inv_dtl[i].JobDescription + "</td><td class='text-right'>" + accounting.formatNumber(resultData.inv_dtl[i].JobQty) + "</td><td class='text-right'>" + accounting.formatNumber(resultData.inv_dtl[i].JobPrice) + "</td><td class='text-right'>" + accounting.formatNumber(resultData.inv_dtl[i].JobDisPercentage) + "</td><td class='text-right'>" + accounting.formatNumber(0) + "</td><td class='text-right'>" + accounting.formatNumber(resultData.inv_dtl[i].JobNetAmount) + "</td><td>&nbsp;&nbsp;<i class='glyphicon glyphicon-edit edit btn btn-info btn-xs'></i>&nbsp;<i class='remove btn btn-danger btn-xs glyphicon glyphicon-remove-circle'></i></td></tr>");
            }

            totalVat=addTotalVat(resultData.inv_hed.JobTotalAmount,resultData.inv_hed.JobIsVatTotal,resultData.inv_hed.JobIsNbtTotal,resultData.inv_hed.JobNbtRatioTotal);
            totalNbt=addTotalNbt(resultData.inv_hed.JobTotalAmount,resultData.inv_hed.JobIsVatTotal,resultData.inv_hed.JobIsNbtTotal,resultData.inv_hed.JobNbtRatioTotal);
            
            total_discount= parseFloat(resultData.inv_hed.JobTotalDiscount);
            
            totalNet=parseFloat(totalAmount+totalVat+totalNbt-total_discount);
         
            $("#totalAmount,#mtotal").html(accounting.formatNumber(totalAmount));
            $("#totalDiscount,#mdiscount").html(accounting.formatNumber(total_discount));
            $("#totalNet,#mnetpay").html(accounting.formatNumber(totalNet));
            $("#totalVat,#mvat").html(accounting.formatNumber(totalVat+totalProVAT));
            $("#totalNbt,#mnbt").html(accounting.formatNumber(totalNbt+totalProNBT));
            finalVat=totalVat+totalProVAT;
            finalNbt=totalNbt+totalProNBT;

            estimateNo = resultData.inv_hed.JobEstimateNo;
            invoiceNo = resultData.inv_hed.JobInvNo;
            loadTempInvoiceData(resultData.inv_hed.JobInvNo);
            $("#estimateNo").val(resultData.inv_hed.JobEstimateNo);
            $("#tempNo").val(resultData.inv_hed.JobInvNo);
            $("#invoiceType").val(resultData.inv_hed.InvoiceType);
             genarateTempInvLink(invoiceNo);
            
            $("#btnSaveTemp").html('Update');
            $("#actionTemp").val(2);
            isTotalVat=resultData.inv_hed.JobIsVatTotal;
            isTotalNbt=resultData.inv_hed.JobIsNbtTotal;
            totalNbtRatio=resultData.inv_hed.JobNbtRatioTotal;
            loadTotalVATNBT(isTotalVat,isTotalNbt,totalNbtRatio);

        } else {
            $("#btnSaveTemp").html('Temparary Save');
            $("#actionTemp").val(1);
            estimateNo = 0;
        }
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
    if(isTotalVat==1){
        $("#isProVat").prop('disabled',true);
        $("#isProNbt").prop('disabled',true);
        isProVat=0;isProNbt=0;totalProVAT=0;
        // totalVat=addTotalVat(totalAmount,isTotalVat,isTotalNbt,nbtRatio);
        // totalNbt=addTotalNbt(totalAmount,isTotalVat,isTotalNbt,nbtRatio);

        // totalNet=parseFloat(totalNetAmount+totalVat+totalNbt);
        // $("#totalAmount").html(accounting.formatNumber(totalAmount));
        // $("#totalDiscount").html(accounting.formatNumber(total_discount));
        // $("#totalNet").html(accounting.formatNumber(totalNet));
        // $("#totalVat").html(accounting.formatNumber(totalVat+totalProVAT));
        // $("#totalNbt").html(accounting.formatNumber(totalNbt+totalProNBT));
        // finalVat=totalVat+totalProVAT;
        // finalNbt=totalNbt+totalProNBT;
    }else{
        $.notify("Item wise VAT/NBT has already enabled.", "warning");
        $("#isProVat").prop('disabled',false);
        $("#isProNbt").prop('disabled',false);
        isTotalVat=0;
        // totalVat=addTotalVat(totalAmount,isTotalVat,isTotalNbt,nbtRatio);
        // totalNbt=addTotalNbt(totalAmount,isTotalVat,isTotalNbt,nbtRatio);

        // totalNet=parseFloat(totalNetAmount-totalVat-totalNbt);
        // $("#totalAmount").html(accounting.formatNumber(totalAmount));
        // $("#totalDiscount").html(accounting.formatNumber(total_discount));
        // $("#totalNet").html(accounting.formatNumber(totalNet));
        // $("#totalVat").html(accounting.formatNumber(totalVat+totalProVAT));
        // $("#totalNbt").html(accounting.formatNumber(totalNbt+totalProNBT));
        // finalVat=totalVat+totalProVAT;
        // finalNbt=totalNbt+totalProNBT;
    }

});
    
$("input[name='isTotalNbt']").on('ifChanged', function(event){
     isTotalNbt = $("input[name='isTotalNbt']:checked").val();
    if(isTotalNbt){
        $("#isProVat").prop('disabled',true);
        $("#isProNbt").prop('disabled',true);
        isProVat=0;isProNbt=0;totalProNBT=0;
        // totalVat=addTotalVat(totalAmount,isTotalVat,isTotalNbt,nbtRatio);
        // totalNbt=addTotalNbt(totalAmount,isTotalVat,isTotalNbt,nbtRatio);

        // totalNet=parseFloat(totalNetAmount+totalVat+totalNbt);
        // $("#totalAmount").html(accounting.formatNumber(totalAmount));
        // $("#totalDiscount").html(accounting.formatNumber(total_discount));
        // $("#totalNet").html(accounting.formatNumber(totalNet));
        // $("#totalVat").html(accounting.formatNumber(totalVat+totalProVAT));
        // $("#totalNbt").html(accounting.formatNumber(totalNbt+totalProNBT));
        // finalVat=totalVat+totalProVAT;
        // finalNbt=totalNbt+totalProNBT;
    }else{
        $("#isProVat").prop('disabled',false);
        $("#isProNbt").prop('disabled',false);
        isTotalNbt=0;
        // totalVat=addTotalVat(totalAmount,isTotalVat,isTotalNbt,nbtRatio);
        // totalNbt=addTotalNbt(totalAmount,isTotalVat,isTotalNbt,nbtRatio);

        // totalNet=parseFloat(totalNetAmount-totalVat-totalNbt);
        // $("#totalAmount").html(accounting.formatNumber(totalAmount));
        // $("#totalDiscount").html(accounting.formatNumber(total_discount));
        // $("#totalNet").html(accounting.formatNumber(totalNet));
        // $("#totalVat").html(accounting.formatNumber(totalVat+totalProVAT));
        // $("#totalNbt").html(accounting.formatNumber(totalNbt+totalProNBT));
        // finalVat=totalVat+totalProVAT;
        // finalNbt=totalNbt+totalProNBT;
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
        minLength: 0,
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
                url: "../Job/getVehicleDetailsById",
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
                $("#cusName").html(resultData.cus_data.CusName);
                $("#customer,#cusCode").val(resultData.cus_data.CusCode);
                $("#creditLimit").html(accounting.formatMoney(resultData.cus_data.CreditLimit));
                $("#creditPeriod").html(resultData.cus_data.CreditPeriod);
                $("#cusOutstand").html(accounting.formatMoney(outstanding));
                $("#availableCreditLimit").html(accounting.formatMoney(available_balance));
                $("#cusAddress").html(resultData.cus_data.Address01 + ", " + resultData.cus_data.Address02);
                $("#cusAddress2").html(resultData.cus_data.Address03);
                $("#cusPhone").html(resultData.cus_data.MobileNo);
            }
        });
    }

    //===============calculate product wise discount================================
    function calculateProductWiseDiscount(totalNet3, discount, discount_type, disPercent, disAmount, total_amount4) {
        //product wise discount 
        if (discount_type == 1) {
            if (discount == 1) {
                //discount by percent
                product_discount = totalNet3 * (disPercent / 100);
                disAmount = 0;
            } else if (discount == 2) {
                //discount by amount
                product_discount = disAmount;
                disPercent = product_discount * 100 / totalNet3;
            }
            total_item_discount = 0;
        } else if (discount_type == 2) {
            //total item wise discount
            total_discount = 0;
            product_discount = 0;
            disPercent = 0;
        }
        prodiscount_precent=disPercent;
        netprice-=product_discount;
        totalProWiseDiscount += product_discount;
        total_discount = totalProWiseDiscount + totalInvDiscount;
    }

    //=============calculate total item wise discount================================
    function calculateTotalItemWiseDiscount(discount, discount_type, disPercent, disAmount, total_amount4) {

        //product wise discount 
        if (discount_type == 1) {
            product_discount = 0;
        } else if (discount_type == 2) {
            //total item wise discount
            total_discount = 0;
            product_discount = 0;
            if (discount == 1) {
                //discount by percent
                product_discount = total_amount4 * (disPercent / 100);

                disAmount = 0;
                disPercent = 0;
            } else if (discount == 2) {
                //discount by amount

                product_discount = disAmount;
                disPercent = 0;
            }
        }

        totalInvDiscount = product_discount;

        total_discount = totalProWiseDiscount + totalInvDiscount;
        discount_precent = 0;
    }


    var creditAmount = 0;
var cashAmount = 0;
 chequeAmount = 0;
var cardAmount =0;
var companyAmount =0;
var toPay=totalNet;
var dueAmount=0;
var cusPayment=0;
var cusType=0;

$("#saveItems").attr('disabled', true);
$("#chequeData").hide();


function addPayment(pcash, pcredit, pcard,pcheque,pcusType,padvance,pbank,preturn) {

    dueAmount = totalNet - parseFloat(pcash + pcard+pcheque+pcredit+padvance+pbank+preturn);

           if (dueAmount > 0 && pcusType==2) {
                $("#credit_amount").val((pcredit));
                $("#changeLable").html('Due');
                $("#changeLable").css({"color": "red", "font-size": "100%"});
                $("#mchange").css({"color": "red", "font-size": "150%"});
                $("input[name='allowThirdPay']").prop('disabled',false);
            }else if (dueAmount > 0 && pcusType!=2) {
                $("#credit_amount").val((0));
                $("#changeLable").html('Due');
                $("#changeLable").css({"color": "red", "font-size": "100%"});
                $("#mchange").css({"color": "red", "font-size": "150%"});
                $("input[name='allowThirdPay']").prop('disabled',false);
            } else {
                dueAmount = Math.abs(dueAmount);
                $("#changeLable").html('Change/Refund');
                $("#changeLable").css({"color": "green", "font-size": "100%"});
                $("#mchange").css({"color": "green", "font-size": "150%"});
                $("input[name='allowThirdPay']").prop('disabled',true);
            }

        cusTotal=parseFloat(pcash + pcard+pcheque+pcredit+padvance+pbank+preturn);
        
        $("#mcash").html(accounting.formatMoney(pcash));
        $("#mcard").html(accounting.formatMoney(pcard));
        $("#madvance").html(accounting.formatMoney(padvance));
        $("#mbank").html(accounting.formatMoney(pbank));
        $("#mcredit").html(accounting.formatMoney(pcredit));
        $("#mcheque").html(accounting.formatMoney(pcheque));
        $("#mcompany").html(accounting.formatMoney(cusTotal));
        $("#mchange").html(accounting.formatMoney(dueAmount));
        var bankacc =$("#bank_acc option:selected").val();
        if(bank_amount>0 && bankacc==''){
             $.notify("Please select a bank account.", "warning");
             return false;
        }

        if((cusTotal)>=toPay){
            $("#saveItems").attr('disabled', false);
        }else{
            $("#saveItems").attr('disabled', false);
        }
    }

var ccard = [];

    $("#addCard").click(function() {

        var cref = $("#card_ref").val();
        var ctype = $("#card_type option:selected").val();
        var cname = $("#card_type option:selected").html();
        var camount = parseFloat($("#ccard_amount").val());
        var ccTypeArrIndex = $.inArray(ctype, ccard);

        if (ctype == '' || ctype == 0) {
            $("#errCard").show();
            $("#errCard").html('Please select a card type').addClass('alert alert-danger alert-sm');
            $("#errCard").fadeOut(1500);
            return false;

        } else if (camount == '' || camount == 0) {
            $("#errCard").show();
            $("#errCard").html('Please enter card amount').addClass('alert alert-danger alert-xs');
            $("#errCard").fadeOut(1500);
            return false;
        } else {
            if (ccTypeArrIndex < 0) {
                $("#tblCard tbody").append("<tr ctype='" + ctype + "'  cref='" + cref + "'  camount='" + camount + "' cname='" + cname + "' ><td>" + cname + "</td><td>" + cref + "</td><td class='text-right'>" + accounting.formatMoney(camount) + "</td><td><a href='#' class='btn btn-danger removeCard' ><i class='fa fa-close'></i></a></td></tr>");
                ccard.push(ctype);
                cardAmount += camount;
               addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount,return_amount);
                $("#card_amount").val((cardAmount));
                $("#card_ref").val('');
                $("#card_type").val(0);
                $("#ccard_amount").val(0);
            } else {
                $("#errCard").show();
                $("#errCard").html('Card type already exist').addClass('alert alert-danger alert-sm');
                $("#errCard").fadeOut(1500);
            }
        }
    });



    $("#addCredit").click(function() {
     addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount,return_amount);

        if (dueAmount > 0) {
            creditAmount+=dueAmount;
            $("#credit_amount").val((creditAmount));
        }else if(dueAmount>toPay){
            creditAmount-=dueAmount;
            $("#credit_amount2").val((creditAmount));
        }

     addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount,return_amount);
       return false;
    });



    $("#tblCard tbody").on('click', '.removeCard', function() {
        $(this).parent().parent().remove();
        var removeItem = $(this).parent().parent().attr('ctype');
        ccard = jQuery.grep(ccard, function(value) {
            return value != removeItem;
        });

        cardAmount -= parseFloat($(this).parent().parent().attr('camount'));
        addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount,return_amount);
        $("#card_amount").val((cardAmount));

    });

    $("#cheque_amount").keyup(function() {
        chequeAmount = parseFloat($(this).val());
        cashAmount = parseFloat($("#cash_amount").val());
        creditAmount = parseFloat($("#credit_amount").val());
        cardAmount = parseFloat($("#card_amount").val());
        advance_amount = parseFloat($("#advance_amount").val());
        bank_amount = parseFloat($("#bank_amount").val());
        return_amount = parseFloat($("#return_amount").val());

        creditAmount=0;
       $("#credit_amount").val(0);
        addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount,return_amount);

        if(chequeAmount>0){
            $("#chequeData").show();
        }else{
            $("#chequeData").hide();
        }
    });

    $("#bank_amount").keyup(function() {
        bank_amount = parseFloat($(this).val());
        cashAmount = parseFloat($("#cash_amount").val());
        creditAmount = parseFloat($("#credit_amount").val());
        cardAmount = parseFloat($("#card_amount").val());
        advance_amount = parseFloat($("#advance_amount").val());
        chequeAmount = parseFloat($("#cheque_amount").val());
        return_amount = parseFloat($("#return_amount").val());

        creditAmount=0;
       $("#credit_amount").val(0);
        addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount,return_amount);

        if(bank_amount>0){
            $("#bankData").show();
        }else{
            $("#bankData").hide();
        }
    });

    $("#cash_amount").keyup(function() {
        cashAmount = parseFloat($(this).val());
        creditAmount = parseFloat($("#credit_amount").val());
        cardAmount = parseFloat($("#card_amount").val());
        chequeAmount = parseFloat($("#cheque_amount").val());
        advance_amount = parseFloat($("#advance_amount").val());
        bank_amount = parseFloat($("#bank_amount").val());
        return_amount = parseFloat($("#return_amount").val());

       creditAmount=0;
       $("#credit_amount").val(0);
        addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount,return_amount);
    });

    $("#credit_amount").keyup(function() {
        creditAmount = parseFloat($(this).val());
        cashAmount = parseFloat($("#cash_amount").val());
        cardAmount = parseFloat($("#card_amount").val());
        chequeAmount = parseFloat($("#cheque_amount").val());
        advance_amount = parseFloat($("#advance_amount").val());
        bank_amount = parseFloat($("#bank_amount").val());
        return_amount = parseFloat($("#return_amount").val());

        addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount,return_amount);
    });

    $("#cash_amount").blur(function() {
        cashAmount = parseFloat($(this).val());
        creditAmount = parseFloat($("#credit_amount").val());
        cardAmount = parseFloat($("#card_amount").val());
        chequeAmount = parseFloat($("#cheque_amount").val());
        advance_amount = parseFloat($("#advance_amount").val());
        bank_amount = parseFloat($("#bank_amount").val());
        return_amount = parseFloat($("#return_amount").val());

        creditAmount=0;
       $("#credit_amount").val(0);
        addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount,return_amount);
    });

    $("#credit_amount").blur(function() {
        creditAmount = parseFloat($(this).val());
        cashAmount = parseFloat($("#cash_amount").val());
        cardAmount = parseFloat($("#card_amount").val());
        chequeAmount = parseFloat($("#cheque_amount").val());
        advance_amount = parseFloat($("#advance_amount").val());
        bank_amount = parseFloat($("#bank_amount").val());
        return_amount = parseFloat($("#return_amount").val());

        addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount,return_amount);
    });

    $("#advance_amount").blur(function() {
        advance_amount = parseFloat($(this).val());
        cashAmount = parseFloat($("#cash_amount").val());
        cardAmount = parseFloat($("#card_amount").val());
        chequeAmount = parseFloat($("#cheque_amount").val());
        creditAmount = parseFloat($("#credit_amount").val());
        bank_amount = parseFloat($("#bank_amount").val());
        return_amount = parseFloat($("#return_amount").val());

        addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount,return_amount);
    });

    $("#advance_amount").keyup(function() {
        advance_amount = parseFloat($(this).val());
        cashAmount = parseFloat($("#cash_amount").val());
        cardAmount = parseFloat($("#card_amount").val());
        chequeAmount = parseFloat($("#cheque_amount").val());
        creditAmount = parseFloat($("#credit_amount").val());
        bank_amount = parseFloat($("#bank_amount").val());
        return_amount = parseFloat($("#return_amount").val());

        addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount,return_amount);
    });

    $("#return_Amount").blur(function() {
        return_amount = parseFloat($(this).val());
        advance_amount = parseFloat($("#advance_amount").val());
        cashAmount = parseFloat($("#cash_amount").val());
        cardAmount = parseFloat($("#card_amount").val());
        chequeAmount = parseFloat($("#cheque_amount").val());
        creditAmount = parseFloat($("#credit_amount").val());
        bank_amount = parseFloat($("#bank_amount").val());

        addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount,return_amount);
    });

    $("#return_Amount").keyup(function() {
        return_amount = parseFloat($(this).val());
        advance_amount = parseFloat($("#advance_amount").val());
        cashAmount = parseFloat($("#cash_amount").val());
        cardAmount = parseFloat($("#card_amount").val());
        chequeAmount = parseFloat($("#cheque_amount").val());
        creditAmount = parseFloat($("#credit_amount").val());
        bank_amount = parseFloat($("#bank_amount").val());

        addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount,return_amount);
    });

function genarateInvLink(est){
        $("#invLink").attr('disabled',false);
        if(est!=''){
            $("#invLink").attr("href","../../admin/Salesinvoice/view_invoice/"+Base64.encode(est));    
        }
    }

    function genarateTempInvLink(est){
        $("#invLink").attr('disabled',false);
        if(est!=''){
            $("#invLink").attr("href","../../admin/Salesinvoice/view_temp_invoice/"+Base64.encode(est));    
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
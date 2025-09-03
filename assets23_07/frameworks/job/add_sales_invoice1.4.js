$(document).ready(function() {

    var supcode;
    var customProCode='100001';

    $("#addNewCustomer").click(function(){
        var customer_search = $("#customer").val();
        var url = encodeURI('../customer/loadmodal_customeradd/'+customer_search);
        $('#customermodal .modal-content').load(url, function (result) {
            $('#customermodal').modal({show: true, backdrop: 'static',keyboard: false});
        });
    });

    $("#addNewVehicle").click(function(){
        if(cusCode!=''){
            $('#vehiclemodal .modal-content').load('../customer/loadmodal_vehicleadd/'+cusCode, function (result) {
                $('#vehiclemodal').modal({show: true, backdrop: 'static',keyboard: false});
            });
        }else{
             $.notify("Please select a customer.", "warning");
        }
    });

    

    $('#grnDate').datetimepicker({ dateFormat: 'yy-mm-dd', timeFormat: "HH:mm:ss" });
    $('#grnDate').datetimepicker().datetimepicker("setDate", new Date());

    // $('#grnDate,#chequeReciveDate,#expenses_date,#quartPayDate,#downPayDate1,#downPayDate2,#downPayDate3,#downPayDate4,#downPayDate5,#downPayDate6').datepicker().datepicker("setDate", new Date());
    $("#dv_FreeQty").hide();
    $("#cusImage").hide();
    $("#lotPriceLable").hide();
    $('#costTable').hide();
    $('#paymentTable').hide();
    $('#payView').hide();
    $("#dv_SN").hide();
    $("#dwnLink").hide();
    $("#loadBarCode").hide();
    $("#bankData").hide();

    $("#lbl_lotNo").hide();
    $("#lbl_polishWeight").hide();
    $("#lbl_buyAmount").hide();
    $("#lbl_cutWeight").hide();
    $("#chequeData").hide();
    $("#refundAmountLable").hide();
    $("#returnAmountLable").hide();
    $("#tbl_payment_schedule").hide();

    $("#btnPrint").prop('disabled',true);

//    $("#panel_down_payments").hide();
//    $("#panel_quarter").hide();
    var item_ref = 0;
    var itemImagesArr = [];
    var gemOption = [];
    var cusCode = 0;
    var acc_no = 0;
    var invNo = 0;
    var batchNo = 0;
    var cusType = 2;
    var customer_payment = 0;
    var accType = 0;
    var accCategory = 0;
    var totalExtraChrages = 0;
    var downPayment = 0;
    var totalIterest = 0;
    var finalAmount = 0;
    var Interest = 0;
    var dwnInt = 0;
    var bank_amount = 0;
    var itemCode = '';

    var i = 0;
    var itemcode = [];
    var isBuy = 0;
    var isCut = 0;
    var isPolish = 0;
    var total_amount = 0;
    var total_amount2 = 0;
    var totalCost = 0;
    var cashAmount = 0;
    var chequeAmount = 0;
    var creditAmount = 0;
    var dueAmount = 0;
    var lotPrice = 0;
    var returnAmount = 0;
    var refundAmount = 0;
    var returnPayment = 0;


    var discount_precent = 0;
    var discount_amount = 0;
    var product_discount = 0;
    var totalNet2 = 0;
    var totalNet = 0;
    var totalNetAmount = 0;
    var total_discount = 0;
    var total_item_discount = 0;
    var discount = 0;
    var discount_type = 0;
    var total_dwn_interest = 0;
    var total_qur_interest = 0;
    var totalExtraAmount = 0;
    var totalProWiseDiscount = 0;
    var totalGrnDiscount = 0;

    var accType2 = 1;
    var price_level = 1;
    var priceLevel = 1;
    var supcode = 0;
    var isSup = 0;
    
    var sinput = 0;
    var fsinput = 0;
    var maxSerialQty = 0;
    var serialAutoGen = 0;
    var maxSerialQty2=0;

    var poNo = 0;
    var totalProVAT=0;
    var totalProNBT=0;
    var finalVat=0;
    var finalNbt=0;

    var availableCredit=0;
    var serialBatch=1;
    var advance_payment_no=0;
    var advance_amount=0;
    var return_payment_no=0;
    var bank_amount=0;
    var loc = $("#location").val();

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
            $("#bank_amount").val(0);
            $("#mreturn").html(0);
            loadReturnData(return_payment_no);
        }
    });

    poNo = $("#grn_no").val();

    if(poNo!=''){
        $("#tbl_item tbody").html("");
            total_due_amount = 0;
            total_over_payment = 0;
            loadSAlesInvoice(poNo);
    }

    $("#grn_no").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../salesinvoice/loadsalesinvoicejson',
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
            poNo = ui.item.value;            
            $("#tbl_item tbody").html("");
            total_due_amount = 0;
            total_over_payment = 0;
            loadSAlesInvoice(poNo);
        }
    });    

    $("#soNo").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../salesinvoice/loadsalesorderjson',
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
            soNo = ui.item.value;
            
            // $("#tbl_item tbody").html("");
            // total_due_amount = 0;
            // total_over_payment = 0;/
            loadSalesOrder(soNo);
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
                    addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount);
                }
            }
        });
    }

    function loadReturnData(pay_no){
        $.ajax({
            type: "POST",
            url: "../Salesinvoice/getreturnpaymentbyid",
            data: { payid: pay_no },
            success: function(data) {
                var resultData = JSON.parse(data);
                
                if (resultData.return){
                   bank_amount = parseFloat(resultData.return.ReturnAmount);
                    return_payment_no = resultData.return.ReturnNo;
                    $("#bank_amount").val(bank_amount);
                    $("#mreturn").html(bank_amount);
                    addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount);
                }
            }
        });
    }


    function loadSAlesInvoice(po_no){
        $.ajax({
            type: "POST",
            url: "../Salesinvoice/getSalesInvoiceById",
            data: { saleInvoiceNo: po_no },
            success: function(data) {
                var resultData = JSON.parse(data);
                loadSalesInvoiceDatatoGrid(resultData);
            }
        });
    }

    function loadSalesOrder(so_no){
        $.ajax({
            type: "POST",
            url: "../Salesinvoice/getSalesOrderById",
            data: { soNo: so_no },
            success: function(data) {
                var resultData = JSON.parse(data);
                loadSalesOrderDatatoGrid(resultData);
            }
        });
    }

    //======= set price levels ==========
    $("#priceLevel").change(function() {
        price_level = $("#priceLevel option:selected").val();
    });

    $("#supplier").change(function() {
        supcode = $("#supplier option:selected").val();
    });



    $('#itemCode').on('keydown', function(e) {
        if (e.which == 13) {
            $("#errGrid").hide();
//            $("#cart-table-notice").remove();
            var barCode = $(this).val();
            price_level = 1;
            //var loc = $("#location").val();
//            alert(price_level);
            $.ajax({
                type: "post",
                url: "../../admin/Product/getProductByBarCodeforSTO",
                data: {proCode: barCode, prlevel: price_level, location: loc},
                success: function(json) {

                    var resultData = JSON.parse(json);
                    if (resultData) {
                         if(resultData.serial){
                        $.each(resultData.serial, function(key, value) {
                            var serialNoArrIndex2 = $.inArray(value, stockSerialnoArr);
                            if (serialNoArrIndex2 < 0) {
                                stockSerialnoArr.push(value);
                            }
                        });
                    }

                        if(resultData.product){
                            itemCode = resultData.product.ProductCode;

                            // autoSerial = resultData.product.IsRawMaterial;
                            // loadVATNBT(isJobVat,isJobNbt,isJobNbtRatio);

                            loadVATNBT(resultData.product.IsTax,resultData.product.IsNbt,resultData.product.NbtRatio);
                            loadProModal(resultData.product.Prd_Description, resultData.product.ProductCode, resultData.product.ProductPrice, resultData.product.Prd_CostPrice, 0, resultData.product.IsSerial, resultData.product.IsFreeIssue, resultData.product.IsOpenPrice, resultData.product.IsMultiPrice, resultData.product.Prd_UPC, resultData.product.WarrantyPeriod, resultData.product.IsRawMaterial,resultData.product.UOM_Name, resultData.product.ProductVatPrice);
                        }

                        $("#proStock").html('');

                         if(resultData.pro_stock){
                            $("#proStock").html(resultData.pro_stock);
                         }else{
                            $("#proStock").html(0);
                         }
//                        itemCode = resultData.ProductCode;
//                        loadProModal(resultData.Prd_Description, resultData.ProductCode, resultData.ProductPrice, resultData.Prd_CostPrice, resultData.SerialNo, resultData.IsSerial, resultData.IsFreeIssue, resultData.IsOpenPrice, resultData.IsMultiPrice, resultData.Prd_UPC, resultData.WarrantyPeriod);
//                        $('html, body').animate({scrollTop: $('#cart-table-body').offset().top}, 'slow');
                    } else {
                        $.notify("Product not found.", "warning");
                        $("#itemCode").val('');
                        $("#itemCode").focus();
                        return false;
                    }
                },
                error: function() {
                    $.notify("Error while request.", "warning");
                }
            });
           e.preventDefault();
        }
    });

    $("#addpro").click(function(e){
        itemCode=customProCode;
        setCustomProduct();
        e.preventDefault();
        
    });

    function setCustomProduct(){
         var mname = $("#itemCode").val();
        $("#prdName").val(mname);
        $("#productName").html(mname);
        
        $("#qty").val(1);
        $("#qty").focus();
        $("#itemCode").val(itemCode);
        // $("#sellingPrice").val(0);
        // $("#orgSellPrice").val(0);
        // $("#proVatPrice").val(0);
        

        $("#unitcost").val(1);
        $("#isSerial").val(0);
        $("#upc").val(1);
        $("#upm").html(1);

            $("#dv_SN").hide();
        
            $("#dv_FreeQty").hide();
    }

//isSup =  $("[name='suppliercheck']:checked").val();

    $("input[name='suppliercheck']").on('ifChanged', function() {
        isSup = $("input[name='suppliercheck']:checked").val();

        if (!isSup) {
           isSup = 0;
        }
    });

    var autoSerial = 0;

//==============load products========================
    $("#itemCode").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: 'loadproductjson',
                dataType: "json",
                data: {
                    q: request.term,
                    type: 'getActiveProductCodes',
                    sup: isSup,
                    supcode: supcode,
                    row_num: 1,
                    action: "getActiveProductCodes",
                    price_level: price_level,
                    isGrn:0
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
//            var names = (ui.item.label);
            itemCode = ui.item.value;
//        alert(itemCode);
            $.ajax({
                type: "post",
                url: "../../admin/Product/getProductByIdforSTO",
                data: {proCode: itemCode, prlevel: price_level, location: loc},
                success: function(json) {
                    var resultData = JSON.parse(json);
//                    alert(resultData.serial);
                    if (resultData) {
                         if(resultData.serial){
                            $.each(resultData.serial, function(key, value) {
                                var serialNoArrIndex1 = $.inArray(value, stockSerialnoArr);

                                if (serialNoArrIndex1 < 0) {
                                    stockSerialnoArr.push(value);
                                }
                            });
                        }

                         if(resultData.product){
                        autoSerial = resultData.product.IsRawMaterial;
                        // loadVATNBT(isJobVat,isJobNbt,isJobNbtRatio);

                        loadVATNBT(resultData.product.IsTax,resultData.product.IsNbt,resultData.product.NbtRatio);
                        loadProModal(resultData.product.Prd_Description, resultData.product.ProductCode, resultData.product.ProductPrice, resultData.product.Prd_CostPrice, 0, resultData.product.IsSerial, resultData.product.IsFreeIssue, resultData.product.IsOpenPrice, resultData.product.IsMultiPrice, resultData.product.Prd_UPC, resultData.product.WarrantyPeriod, resultData.product.IsRawMaterial,resultData.product.UOM_Name, resultData.product.ProductVatPrice);
                        //  loadProModal(resultData.Prd_Description, resultData.ProductCode, resultData.ProductPrice, resultData.Prd_CostPrice, 0, resultData.IsSerial, resultData.IsFreeIssue, resultData.IsOpenPrice, resultData.IsMultiPrice, resultData.Prd_UPC, resultData.WarrantyPeriod);
                    }

                    $("#proStock").html('');

                    if(resultData.pro_stock){
                        $("#proStock").html(resultData.pro_stock);
                     }else{
                        $("#proStock").html(0);
                     }

                    } else {

                        $.notify("Product not found.", "warning");
                        $("#itemCode").val('');
                        $("#itemCode").focus();
                        return false;
                    }
                },
                error: function() {
                    $.notify("Error while request.", "warning");
                 }
            });
        }
    });

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
            proVat=parseFloat(amount*vatRate/100);
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
    function loadProModal(mname, mcode, msellPrice, mcostPrice, mserial, misSerial, misFree, isOP, isMP, upc, waranty, isautoSerial,upm,vatSell) {
//        clearProModal();
$("#productName").html('');
        $("#qty").focus();
//       alert(misSerial);
        if (misSerial == 1 || isautoSerial == 1) {
//            $("#serialNo").val(mserial);
//            $("#qty").val(1);
//            $("#qty").attr('disabled', true);
            // $("#dv_SN").show();
            $("#qty").focus();
        } else {
//            $("#mSerial").val('');
            // $("#qty").attr('disabled', false);
            // $("#dv_SN").hide();
        }
        $("#qty").val(1);
//        $("#mLProCode").html(mcode);
        $("#prdName").val(mname);
        $("#productName").html(mname);
        $("#itemCode").val(mcode);
        $("#sellingPrice").val(msellPrice);
        $("#orgSellPrice").val(msellPrice);

        if(vatSell==0 || vatSell==null){
            $("#proVatPrice").val(msellPrice);
        }else{
            $("#proVatPrice").val(vatSell);
        }

        $("#unitcost").val(mcostPrice);
        $("#isSerial").val(misSerial);
        $("#upc").val(upc);
        $("#upm").html(upm);

        if (misSerial == 1) {
            $("#dv_SN").hide();
        } else {
            $("#dv_SN").hide();
        }

        if (misFree == 1) {
            $("#dv_FreeQty").show();
        } else {
            $("#dv_FreeQty").hide();
        }
    }

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

    var sellingPrice = 0;
    var orgSellingPrice=0;
    var costPrice = 0;
    var casecost = 0;

    $("#sellingPrice").blur(function() {
        sellingPrice = parseFloat($(this).val());
        costPrice = parseFloat($("#unitcost").val());

        var isNewVat = $("input[name='isProVat']:checked").val();
        var isNewNbt = $("input[name='isProNbt']:checked").val();
        var newNbtRatio = parseFloat($("#proNbtRatio").val());
        var newproVat=0;
        var newproNbt=0;

        if(isNewVat){
            isNewVat=1;
        }else{
            isNewVat=0;
        }

        if(isNewNbt){
            isNewNbt=1;
        }else{
            isNewNbt=0;
        }

        if(isNewVat==1 || isTotalVat==1){
            newproVat=0;
            newproNbt=0 ;
        }else{
            newproVat=addProductVat((sellingPrice),1,0,newNbtRatio);
        }
        // sellingPrice=Math.round((vatSellingPrice-newproVat-newproNbt).toFixed(2));
        vatSellingPrice=Math.round((sellingPrice));
        $("#proVatPrice").val(vatSellingPrice);
        if (costPrice > sellingPrice && isSellZero !=1) {
            $.notify("Selling price can not be less than cost price.", "warning");
            return false;
        }
    });
var shipping=0;
$("#shipping").keyup(function() {
    shipping = parseFloat($(this).val());

    if(isNaN(shipping) == true){
        shipping=0;
    }else{
        shipping=shipping;
    }
    cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount);
});

$("#shipping").blur(function() {
    shipping = parseFloat($(this).val());

    if(isNaN(shipping) == true){
        shipping=0;
    }else{
        shipping=shipping;
    }
    cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount);
});

    $("#proVatPrice").keyup(function() {
        vatSellingPrice = parseFloat($(this).val());
        costPrice = parseFloat($("#unitcost").val());

        var isNewVat = $("input[name='isProVat']:checked").val();
        var isNewNbt = $("input[name='isProNbt']:checked").val();
        var newNbtRatio = parseFloat($("#proNbtRatio").val());
        var newproVat=0;
        var newproNbt=0;

        if(isNewVat){
            isNewVat=1;
        }else{
            isNewVat=0;
        }

        if(isNewNbt){
            isNewNbt=1;
        }else{
            isNewNbt=0;
        }

        if(isNewVat==1 || isTotalVat==1){
            sellingPrice=Math.round((vatSellingPrice));
        }else{
            sellingPrice=Math.round((vatSellingPrice));
        }
        
        // sellingPrice=Math.round((vatSellingPrice-newproVat-newproNbt));
        $("#sellingPrice").val(sellingPrice);
        if (costPrice > sellingPrice && isSellZero !=1) {
            $.notify("Selling price can not be less than cost price.", "warning");
            return false;
        }
    });

    $("#proVatPrice").blur(function() {
        vatSellingPrice = parseFloat($(this).val());
        costPrice = parseFloat($("#unitcost").val());

        var isNewVat = $("input[name='isProVat']:checked").val();
        var isNewNbt = $("input[name='isProNbt']:checked").val();
        var newNbtRatio = parseFloat($("#proNbtRatio").val());
        var newproVat=0;
        var newproNbt=0;

        if(isNewVat){
            isNewVat=1;
        }else{
            isNewVat=0;
        }

        if(isNewNbt){
            isNewNbt=1;
        }else{
            isNewNbt=0;
        }

        if(isNewVat==1 || isTotalVat==1){
            sellingPrice=Math.round((vatSellingPrice));
        }else{
            sellingPrice=Math.round((vatSellingPrice));
        }
        // alert(newproVat);
        // sellingPrice=Math.round((vatSellingPrice-newproVat-newproNbt));
        $("#sellingPrice").val(sellingPrice);
        if (costPrice > sellingPrice && isSellZero !=1) {
            $.notify("Selling price can not be less than cost price.", "warning");
            return false;
        }
    });

    // $("#sellingPrice").blur(function() {
    //     sellingPrice = parseFloat($(this).val());
    //     costPrice = parseFloat($("#unitcost").val());

    //     var isNewVat = $("input[name='isProVat']:checked").val();
    //     var isNewNbt = $("input[name='isProNbt']:checked").val();
    //     var newNbtRatio = parseFloat($("#proNbtRatio").val());
    //     var newproVat=0;
    //     var newproNbt=0;

    //     if(isNewVat){
    //         isNewVat=1;
    //     }else{
    //         isNewVat=0;
    //     }

    //     if(isNewNbt){
    //         isNewNbt=1;
    //     }else{
    //         isNewNbt=0;
    //     }

    //     if(isNewVat==1 || isTotalVat==1){
    //         newproVat=0;
    //         newproNbt=0 ;
    //     }else{
    //         newproVat=addProductVat((sellingPrice),1,1,newNbtRatio);
    //     }
        
    //     vatSellingPrice=sellingPrice+newproVat+newproNbt;
    //     $("#proVatPrice").val(vatSellingPrice);
    //     if (costPrice > sellingPrice && isSellZero !=1) {
    //         $.notify("Selling price can not be less than cost price.", "warning");
    //         return false;
    //     }
    // });

    $("#unitcost").blur(function() {
        costPrice = parseFloat($(this).val());
        sellingPrice = parseFloat($("#sellingPrice").val());

        if (costPrice > sellingPrice && isSellZero !=1) {
            $.notify("Selling price can not be less than cost price.", "warning");
            return false;
        }
    });

    $("#qty").blur(function() {
        $("#serialQty").val($(this).val());
    });

    var serialQty = 0;
    var newSerialQty = 0;
    var serialnoarr = [];
    var stockSerialnoArr = [];
//=========Add products===============================
    $("#addItem").click(function() {
        add_products();
    });

    $('#serialNo').on('keydown', function(e) {
        if (e.which == 13) {
            add_products();
        }
    });

    $('#sellingPrice').on('keydown', function(e) {
        if (e.which == 13) {
            add_products();
        }
    });

    $('#itemCode').on('keydown', function(e) {
        if (e.which == 107) {
            itemCode=customProCode;
            setCustomProduct();
            e.preventDefault();
        }
    });

var isSellZero =0;
var vatSellingPrice = 0;
    function add_products() {
        var serialQty = 0;
        sellingPrice = parseFloat($("#sellingPrice").val());
        orgSellingPrice= parseFloat($("#orgSellPrice").val());
        var unit = $("#mUnit option:selected").val();
        var prdName = $("#prdName").val();
        var serialNo = $("#serialNo").val();
        var is_serail = $("#isSerial").val();
         priceLevel = $("#priceLevel option:selected").val();
        var qty = parseFloat($("#qty").val());
        var upc = parseFloat($("#upc").val());
        costPrice = parseFloat($("#unitcost").val());
        var freeQty = parseFloat($("#freeqty").val());
        var case1 = $("#mUnit option:selected").val();
        var salesperson = $("#salesperson option:selected").val();
        var salespname = $("#salesperson option:selected").html();
        // vatSellingPrice = parseFloat($("#proVatPrice").val());
        vatSellingPrice = sellingPrice;

        if(salesperson==''){
            salespname='';
        }else{
            salespname=salespname;
        }
        newSerialQty = parseFloat($("#serialQty").val());

        var isNewVat = $("input[name='isProVat']:checked").val();
        var isNewNbt = $("input[name='isProNbt']:checked").val();
        var newNbtRatio = parseFloat($("#proNbtRatio").val());

        isSellZero = $("input[name='isZero']:checked").val();

        if(isNewVat){
            isNewVat=1;
        }else{
            isNewVat=0;
        }

        if(isNewNbt){
            isNewNbt=1;
        }else{
            isNewNbt=0;
        }

        if(isSellZero){
            isSellZero=1;
        }else{
            isSellZero=0;
        }

        maxSerialQty = qty;
        maxSerialQty2 = qty;

        if (is_serail == 1 && autoSerial == 0) {
            serialQty = newSerialQty;
            qty = qty;
        } else {
            qty = qty;
        }

        if (case1 == 'Unit' || case1 == 'UNIT') {
            qty = qty;
        } else if (case1 == 'Case' || case1 == 'CASE') {
            qty = upc * qty;
            casecost = costPrice * qty;
        }

        var itemCodeArrIndex = $.inArray(itemCode, itemcode);
        autoSerial=0;

        if (itemCode == '' || itemCode == 0) {
            $.notify("Please select a item.", "warning");
            return false;
        } else if ((sellingPrice == '' || sellingPrice == 0 || isNaN(sellingPrice) == true) && isSellZero==0) {
            $.notify("Selling price can not be 0.", "warning");
           return false;
        } else if (costPrice == '' || costPrice == 0 || isNaN(costPrice) == true) {
            $.notify("Cost price can not be 0.", "warning");
            return false;
        } else if (qty == '' || qty == 0 || isNaN(qty) == true) {
            $.notify("Please enter a qty.", "warning");
            return false;
        } else if (costPrice > sellingPrice && isSellZero==0) {
            $.notify("Selling price can not be less than cost price.", "warning");
            return false;
        } else {
            // if (is_serail == 0) {
                if ((itemCodeArrIndex < 0)) {

                    if(isNewVat==1 || isTotalVat==1){
                        totalNet2 = (sellingPrice * qty);
                    }else{
                        totalNet2 = (vatSellingPrice * qty);
                        sellingPrice = vatSellingPrice;
                    }
                    
                    if(itemCode!=customProCode){
                        itemcode.push(itemCode);
                    }

                    total_amount2 += totalNet2;
                    totalCost += (costPrice * qty);

                    $("#totalWithOutDiscount").val(total_amount2);
                    calculateProductWiseDiscount(totalNet2, discount, discount_type, discount_precent, discount_amount, total_amount2);

                    proVat=addProductVat((totalNet),isNewVat,isNewNbt,newNbtRatio);
                    proNbt=addProductNbt((totalNet),isNewVat,isNewNbt,newNbtRatio) ;

                    totalNet +=proVat ;
                    totalNet +=proNbt ;
                    totalProVAT+=parseFloat(proVat);
                    totalProNBT+=parseFloat(proNbt);
                    cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount);
                    i++;
                    if (is_serail == 1) {
                        serialQty--;
                        $("#serialQty").val(serialQty);
                    }

                    $("#tbl_item tbody").append("<tr serial_batch='0'  ri=" + i + " id=" + i + " isZero='"+isSellZero+"' proCode='" + itemCode + "' uc='" + unit + "' qty='" + qty + "' unit_price='" + sellingPrice + "'  vatunit_price='" + vatSellingPrice + "'  org_unit_price='" + orgSellingPrice + "' upc='" + upc + "' caseCost='" + casecost + "' isSerial='" + is_serail + "' serial='" + serialNo + "' discount_percent='" + discount_precent + "' cPrice='" + costPrice + "' pL='" + priceLevel + "' fQ='" + freeQty + "' nonDisTotalNet='" + totalNet2 + "' netAmount='" + totalNet + "' proDiscount='" + product_discount + "' proName='" + prdName + "'  isvat='"+isNewVat+"' isnbt='"+isNewNbt+"' nbtRatio='"+newNbtRatio+"' proVat='"+proVat+"' proNbt='"+proNbt+"'  salesPerson='"+salesperson+"'  isbatchSerial='0'><td class='text-center'>" + i + "</td><td class='text-left'>" + itemCode + "</td><td>" + prdName + "</td><td>" + unit + "</td><td class='qty" + i + "'>" + accounting.formatNumber(qty) + "</td><td class='text-right'>" + accounting.formatNumber(sellingPrice) + "</td><td class='text-center'>" + discount_precent + "</td><td class='text-right' >" + accounting.formatMoney(totalNet) + "</td><td>" + serialNo + "</td><td>"+salespname+"</td><td><i class='glyphicon glyphicon-edit edit btn btn-info btn-xs'></i></td><td class='rem" + i + "'><a href='#' class='remove btn btn-xs btn-danger'><i class='fa fa-remove'></i></a></td></tr>");
                    clear_gem_data();
                    // if (is_serail != 1) {
                    //     clear_gem_data();
                    // } else {
                    //     if (serialQty == 0) {
                    //         clear_gem_data();
                    //     } else {
                    //         $("#serialNo").val('');
                    //        $("#serialNo").focus();
                    //     }
                    // }
                    setProductTable();
                } else {
                    $.notify("Item already exists.", "warning");
                    return false;
                }
            // } 
            // else if (is_serail == 1) {


            //     var serialNoArrIndex = $.inArray(serialNo, serialnoarr);
            //     var StockserialNoArrIndex = $.inArray(serialNo, stockSerialnoArr);
            //         if (serialNo == '' || serialNo == 0) {
            //             $.notify("Serial Number can not be empty.", "warning");
            //             $("#serialNo").focus();
            //             return false;
            //         }
            //         else if (((serialNoArrIndex >= 0 && is_serail == 1))) {
            //             $.notify("Serial Number already exists.", "warning");
            //             $("#serialNo").val('');
            //             return false;
            //         } else if (((StockserialNoArrIndex < 0 && is_serail == 1))) {
            //             $.notify("Serial Number product not in  stock..", "warning");
            //             $("#serialNo").val('');
            //             return false;
            //         }
            //         else if (((itemCodeArrIndex >= 0 && is_serail == 1) || (itemCodeArrIndex < 0 && is_serail == 1))) {

            //             if(isNewVat==1 || isTotalVat==1){
            //                 totalNet2 = (sellingPrice * qty);
            //             }else{
            //                 totalNet2 = (vatSellingPrice * qty);
            //                 sellingPrice = vatSellingPrice;
            //             }
            //             itemcode.push(itemCode);
            //             serialnoarr.push(serialNo);
            //             total_amount2 += totalNet2;
            //             totalCost += (costPrice * qty);

            //             $("#totalWithOutDiscount").val(total_amount2);

            //             calculateProductWiseDiscount(totalNet2, discount, discount_type, discount_precent, discount_amount, total_amount2);

            //             proVat=addProductVat((totalNet),isNewVat,isNewNbt,newNbtRatio);
            //             proNbt=addProductNbt((totalNet),isNewVat,isNewNbt,newNbtRatio) ;

            //             totalNet +=proVat ;
            //             totalNet +=proNbt ;
            //             totalProVAT+=parseFloat(proVat);
            //             totalProNBT+=parseFloat(proNbt);

            //             cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount);
            //             i++;
            //             if (is_serail == 1) {
            //                 serialQty--;
            //                 $("#serialQty").val(serialQty);
            //             }

            //             $("#tbl_item tbody").append("<tr serial_batch='"+serialBatch+"' ri=" + i + " id=" + i + "  isZero='"+isSellZero+"'  proCode='" + itemCode + "' uc='" + unit + "' qty='" + qty + "' unit_price='" + sellingPrice + "'  vatunit_price='" + vatSellingPrice + "'   org_unit_price='" + orgSellingPrice + "'  upc='" + upc + "' caseCost='" + casecost + "' isSerial='" + is_serail + "' serial='" + serialNo + "' discount_percent='" + discount_precent + "' cPrice='" + costPrice + "' pL='" + priceLevel + "' fQ='" + freeQty + "' nonDisTotalNet='" + totalNet2 + "' netAmount='" + totalNet + "' proDiscount='" + product_discount + "' proName='" + prdName + "'  isvat='"+isNewVat+"' isnbt='"+isNewNbt+"' nbtRatio='"+newNbtRatio+"' proVat='"+proVat+"' proNbt='"+proNbt+"' salesPerson='"+salesperson+"' isbatchSerial='1'><td class='text-center'>" + i + "</td><td class='text-left'>" + itemCode + "</td><td>" + prdName + "</td><td>" + unit + "</td><td class='qty" + i + "'>" + accounting.formatNumber(qty) + "</td><td class='text-right'>" + accounting.formatNumber(sellingPrice) + "</td><td class='text-center'>" + discount_precent + "</td><td class='text-right' >" + accounting.formatMoney(totalNet) + "</td><td>" + serialNo + "</td><td>"+salespname+"</td><td class='rem" + i + "'><a href='#' class='remove btn btn-xs btn-danger'><i class='fa fa-remove'></i></a></td></tr>");

            //             if (is_serail != 1) {
            //                 clear_gem_data();
            //             } else {
            //                 if (serialQty == 0) {
            //                     clear_gem_data();
            //                     serialBatch++;
            //                 } else {
            //                     $("#serialNo").val('');
            //                     $("#serialNo").focus();
            //                 }
            //             }
            //             setProductTable();
            //         } else {
            //             $.notify("Item already exists.", "warning");
            //             $("#serialNo").val('');
            //             return false;
            //         }
            // }
        }
    }

// edit grid
     $("#tbl_item tbody").on('click', '.edit', function() {
        var proname = $(this).parent().parent().attr('proName')
        var proCode = $(this).parent().parent().attr('proCode');
        var isZero = $(this).parent().parent().attr('isZero');
        // var jobdesc = $(this).parent().parent().attr('job');
        var qty = parseFloat($(this).parent().parent().attr('qty'));
        var freeqty = parseFloat($(this).parent().parent().attr('fQ'));
        var selprice = parseFloat($(this).parent().parent().attr('unit_price'));
        var costprice = parseFloat($(this).parent().parent().attr('cPrice'));
        var netprice = parseFloat($(this).parent().parent().attr('netAmount'));
        var uc = $(this).parent().parent().attr('uc');
        var upc = parseFloat($(this).parent().parent().attr('upc'));
        var isSerial = $(this).parent().parent().attr('isSerial');
        var serialNo = $(this).parent().parent().attr('serialNo');
        var salesPerson = $(this).parent().parent().attr('salesPerson');
        var pricelevel = $(this).parent().parent().attr('pL');
        var totalPrice = parseFloat($(this).parent().parent().attr('nonDisTotalNet'));
        var isvat = $(this).parent().parent().attr('isvat');
        var isnbt = $(this).parent().parent().attr('isnbt');
        var nbtratio = $(this).parent().parent().attr('nbtRatio');
        var proVat = parseFloat($(this).parent().parent().attr('proVat'));
        var proNbt = parseFloat($(this).parent().parent().attr('proNbt'));
        var proDiscount = parseFloat($(this).parent().parent().attr('proDiscount'));
        var disPrecent = parseFloat($(this).parent().parent().attr('discount_percent'));

        if(disPrecent>0){
            discount_type=1;
            discount_precent=disPrecent;
        }
        // var totalprice = $(this).parent().parent().attr('nonDisTotalNet');

        var r = confirm('Do you want to edit this row ?');
        if (r === true) {
            loadVATNBT(isvat,isnbt,nbtratio);
            itemCode=proCode;
            $("#prdName").val(proname);
            $("#productName").html(proname);
            $("#upc").val(upc);
            $("#qty").val(qty);
            $("#mUnit").val(uc);
            $("#sellingPrice,#proVatPrice,#orgSellPrice").val(selprice);
            $("#itemCode").val(proname);
            $("#freeqty").val(freeqty);
            $("#isSerial").val(isSerial);
            $("#serialNo").val(serialNo);
            $("#proNbtRatio").val(nbtratio);
            // $("#estPrice").val(estPrice);
            $("#unitcost").val(costprice);
            $("#salesperson").val(salesPerson);
            // $("#disPercent").val(disPrecent);
            
            $("input[name='isZero']:checked").val();

            if(itemCode!=customProCode){
                itemcode.splice($.inArray(itemCode, itemcode), 1);
            }

            total_amount -= totalPrice;
            total_amount2 -= totalPrice;
            totalProVAT -= parseFloat(proVat);
            totalProNBT -= parseFloat(proNbt);
//            total_discount -= proDiscount;
            totalCost -= costprice;
            totalProWiseDiscount -= proDiscount;
            total_discount = totalProWiseDiscount + totalGrnDiscount;

            $("#totalWithOutDiscount").val(total_amount2);
            $("#totalAmount").html(accounting.formatMoney(total_amount2));
            $('#totalprodiscount').html(accounting.formatMoney(totalProWiseDiscount));

            cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount);
            $(this).parent().parent().remove();

            setProductTable();
            return false;
        }
    });

//=========calculate total item wise discount by precentage=============================
    $("#disPercent").blur(function() {
        discount_precent = parseFloat($("#disPercent").val());
        discount_amount = parseFloat($("#disAmount").val());
        discount = $("input[name='discount']:checked").val();
        discount_type = $("input[name='discount_type']:checked").val();
        var total_amount3 = $("#totalWithOutDiscount").val();

        if (discount_type == 2) {
            calculateTotalItemWiseDiscount(discount, discount_type, discount_precent, discount_amount, total_amount3);
        }
    });

//=========calculate total item wise discount by amount=============================
    $("#disAmount").blur(function() {
        discount_precent = parseFloat($("#disPercent").val());
        discount_amount = parseFloat($("#disAmount").val());
        discount = $("input[name='discount']:checked").val();
        discount_type = $("input[name='discount_type']:checked").val();
        var total_amount3 = $("#totalWithOutDiscount").val();
        if (discount_type == 2) {
            calculateTotalItemWiseDiscount(discount, discount_type, discount_precent, discount_amount, total_amount3);
        }
    });

    //================remove row from grid subtraction total amount and discount==============================================
    $("#tbl_item").on('click', '.remove', function() {
        var rid = $(this).parent().parent().attr('ri');

        var r = confirm('Do you want to remove row no ' + rid + ' ?');
        if (r === true) {
            var totalNets = parseFloat(($(this).parent().parent().attr("nonDisTotalNet")));
            var proDiscount = parseFloat(($(this).parent().parent().attr("proDiscount")));
            var proCost = parseFloat(($(this).parent().parent().attr("cPrice")));

            total_amount -= totalNets;
            total_amount2 -= totalNets;
            totalProVAT -= parseFloat($(this).parent().parent().attr('proVat'));
            totalProNBT -= parseFloat($(this).parent().parent().attr('proNbt'));
//            total_discount -= proDiscount;
            totalCost -= proCost;
            totalProWiseDiscount -= proDiscount;
            total_discount = totalProWiseDiscount + totalGrnDiscount;

            $("#totalWithOutDiscount").val(total_amount2);
            $("#totalAmount").html(accounting.formatMoney(total_amount2));
            $('#totalprodiscount').html(accounting.formatMoney(totalProWiseDiscount));

            cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount);

            //remove product code from array
            var removeItem = $(this).parent().parent().attr("proCode");
            var removeSerial = $(this).parent().parent().attr("serial");

            if(itemcode!=customProCode){
               itemcode = jQuery.grep(itemcode, function(value) {
                    return value != removeItem;
                });
            }
            
            serialnoarr = jQuery.grep(serialnoarr, function(value) {
                return value != removeSerial;
            });

            $(this).parent().parent().remove();

            setProductTable();
            return false;
        } else {
            return false;
        }
    });

var action=0;

//===============save products ==============================
    $("#saveItems").click(function() {
        setProductTable();
        var rowCount = $('#tbl_item tr').length;
        var product_code = new Array();
        var item_code = new Array();
        var serial_no = new Array();
        var pro_name = new Array();
        var qty = new Array();
        var unit_price = new Array();
        var org_unit_price = new Array();
        var unit_type = new Array();
        var unitPC = new Array();
        var caseCost = new Array();
        var discount_precent = new Array();
        var pro_discount = new Array();
        var total_net = new Array();
        var isSerial = new Array();
        var price_level = new Array();
        var fee_qty = new Array();
        var cost_price = new Array();
        var pro_total = new Array();
        var pro_total = new Array();
        var isVat =  new Array();
        var isNbt =  new Array();
        var nbtRatio =  new Array();
        var proVat =  new Array();
        var proNbt = new Array();
        var salePerson = new Array();

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

        var grnDate    = $("#grnDate").val();
        var invUser    = $("#invUser").val();
        var location   = $("#location option:selected").val();
        var invType    = $("#invType option:selected").val();
        var insCompany = $("#insCompany option:selected").val();
        var registerNo= $("#regNo option:selected").val();
        var salesorder = $("#soNo").val();
        var po_number  = $("#po_number").val();
        var bankacc    = $("#bank_acc").val();
        var shippingLabel  = $("#shippingLabel").val();
        var newsalesperson = $("#newsalesperson").val();

        var com_amount = $('#com_amount').val();
        var compayto = $('#compayto').val();
        var receiver_name = $('#receiver_name').val();
        var receiver_nic = $('#receiver_nic').val();

        
         var remark = $("#remark").val();
        action = $("#action").val();
        var nbtRatioRate=$("#nbtRatioRate").val();

        $('#tbl_item tbody tr').each(function(rowIndex, element) {
            product_code.push($(this).attr('proCode'));
            serial_no.push($(this).attr('serial'));
            qty.push(($(this).attr('qty')));
            unit_price.push(($(this).attr('unit_price')));
            org_unit_price.push(($(this).attr('org_unit_price')));
            discount_precent.push(($(this).attr('discount_percent')));
            pro_discount.push($(this).attr('proDiscount'));
            total_net.push(($(this).attr('netAmount')));
            price_level.push($(this).attr("pL"));
            unit_type.push($(this).attr("uc"));
            fee_qty.push($(this).attr("fQ"));
            cost_price.push(($(this).attr("cPrice")));
            unitPC.push(($(this).attr("upc")));
            caseCost.push(($(this).attr("caseCost")));
            pro_total.push($(this).attr("nonDisTotalNet"));
            isSerial.push($(this).attr("isSerial"));
            pro_name.push($(this).attr("proName"));
            isVat.push($(this).attr('isVat'));
            isNbt.push($(this).attr('isNbt'));
            nbtRatio.push($(this).attr('nbtRatio'));
            proVat.push($(this).attr('proVat'));
            proNbt.push($(this).attr('proNbt'));
            salePerson.push($(this).attr('salesperson'));
        });

        var sendProduct_code = JSON.stringify(product_code);
        var sendPro_name = JSON.stringify(pro_name);
        var sendSerial_no = JSON.stringify(serial_no);
        var sendQty = JSON.stringify(qty);
        var sendUnit_price = JSON.stringify(unit_price);
        var sendOrgUnit_price = JSON.stringify(org_unit_price);
        var sendDiscount_precent = JSON.stringify(discount_precent);
        var sendPro_discount = JSON.stringify(pro_discount);
        var sendTotal_net = JSON.stringify(total_net);
        var sendPrice_level = JSON.stringify(price_level);
        var sendUnit_type = JSON.stringify(unit_type);
        var sendFree_qty = JSON.stringify(fee_qty);
        var sendCost_price = JSON.stringify(cost_price);
        var sendUpc = JSON.stringify(unitPC);
        var sendCaseCost = JSON.stringify(caseCost);
        var sendPro_total = JSON.stringify(pro_total);
        var sendIsSerial = JSON.stringify(isSerial);
        var isVatArr = JSON.stringify(isVat);
        var isNbtArr = JSON.stringify(isNbt);
        var nbtRatioArr = JSON.stringify(nbtRatio);
        var proVatArr = JSON.stringify(proVat);
        var proNbtArr = JSON.stringify(proNbt);
        var salePersonArr = JSON.stringify(salePerson);

        var r = confirm("Do you want to save this invoice.?");
        if (r == true) {
            if (cusCode == '' || cusCode == '0') {
                $.notify("Please select a customer.", "warning");
                return false;
            } else if ((rowCount - 1) == '0' || (rowCount - 1) == '') {
                $.notify("Please add products.", "warning");
                return false;
            }  else if(totalNetAmount>(cashAmount+cardAmount+chequeAmount+advance_amount+bank_amount+creditAmount)){
                 $.notify("Please enter payments.", "warning");
                  $("#saveItems").attr('disabled', true);
                return false;
            }else {
                maxSerialQty += parseFloat($("#maxSerial").val());
                $("#saveItems").attr('disabled', true);
                $.ajax({
                    type: "post",
                    url: "saveNewSalesInvoice",
                    data: {remark:remark,com_amount:com_amount, compayto:compayto,receiver_name:receiver_name,receiver_nic:receiver_nic, regNo:registerNo,cusCode:cusCode,grn_no:poNo,po_number:po_number,insCompany:insCompany,shippingLabel:shippingLabel,shipping:shipping,newsalesperson:newsalesperson,action:action,salesorder: salesorder, invType:invType, product_code: sendProduct_code, serial_no: sendSerial_no, qty: sendQty, unit_price: sendUnit_price,org_unit_price:sendOrgUnit_price,
                        discount_precent: sendDiscount_precent, pro_discount: sendPro_discount, total_net: sendTotal_net, unit_type: sendUnit_type, price_level: sendPrice_level, upc: sendUpc,
                        case_cost: sendCaseCost, freeQty: sendFree_qty, cost_price: sendCost_price, pro_total: sendPro_total, isSerial: sendIsSerial, proName: sendPro_name,isVat:isVatArr,isNbt:isNbtArr,nbtRatio:nbtRatioArr,proVat:proVatArr,proNbt:proNbtArr,salePerson:salePersonArr, total_cost: totalCost, totalProDiscount: totalProWiseDiscount, totalGrnDiscount: totalGrnDiscount,
                        grnDate: grnDate, invUser: invUser, total_amount: total_amount, total_discount: total_discount, total_net_amount: totalNetAmount, location: location, supcode: supcode, maxSerialQty: maxSerialQty, serialAutoGen: serialAutoGen,nbtRatioRate: nbtRatioRate,isTotalVat:isTotalVat,isTotalNbt:isTotalNbt,totalVat:finalVat,totalNbt:finalNbt,bankacc:bankacc,bank_amount:bank_amount,cashAmount:cashAmount,creditAmount:creditAmount,chequeAmount:chequeAmount,cardAmount:cardAmount,advance_amount:advance_amount,advance_pay_no:advance_payment_no,return_payment_no:return_payment_no,return_amount:returnAmount,
                    ccAmount: ccAmountArr, ccRef: ccRefArr, ccType: ccTypeArr, ccName: ccNameArr,chequeNo:chequeNo,bank: bank, chequeReference: chequeReference, chequeRecivedDate: chequeReciveDate, chequeDate: chequeDate},
                    success: function(data) {
                        var resultData = JSON.parse(data);
                        var feedback = resultData['fb'];
                        var invNumber = resultData['InvNo'];

                        if (feedback != 1) {
                            $.notify("Sales Invoice not saved successfully.", "warning");
                            $("#saveItems").attr('disabled', true);
                           
                           // loadSAlesInvoice(invNumber);
                            return false;
                        } else {
                             var invlink = "../Salesinvoice/view_sales_invoice/"+Base64.encode(invNumber);
                            $("#lastInvoice").html("<a href='"+invlink+"'>Last Invoice - "+invNumber+"</a>");
                            $("#btnPrint").attr('link',invlink);
                            $.notify("Sales Invoice saved successfully.", "warning");
                            $("#tbl_item tbody").html('');
                             loadSAlesInvoice(invNumber);
                            $("input[name=suppliercheck][value='1']").prop('checked', false);
                            $("#invoicenumber").val("");
                            $("#supplier").val("");
                            $("#totalgrn").html('0.00');
                            $("#grndiscount").html('0.00');
                            $("#netgrnamount").html('0.00');
                            $("#grnremark").val('');

                            serialAutoGen = 0;
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
                            return_payment_no=0;returnAmount=0;
                            bank_amount=0;

                            $("#cash_amount").val(0);
                            $("#cheque_amount").val(0);
                            $("#credit_amount").val(0);
                            $("#advance_amount").val(0);
                            $("#bank_amount").val(0);
                            $("#card_amount").val(0);
                            $("#totalExpenses").html(0);
                            $('#itemTable').show();
                            $('#costTable').hide();
                            $('#totalAmount').html('0.00');
                            $('#totalgrndiscount').html('0.00');
                            $('#totalprodiscount').html('0.00');
                            $('#dueAmount2').html('0.00');
                            $("#loadBarCode").hide();
                            $("#saveItems").attr('disabled', true);
                            $("#modelPayment").modal('hide');
                             $("#cart-pay-button").prop('disabled',true);
                        }
                    }
                });
            }
        } else {
            return false;
        }
    });

    $("#resetItems").click(function() {
        var r = confirm("Do you want to Reset.?");
        if (r == true) {
            location.reload();
        } else {
            return false;
        }
    });

    var p = 0;
    //add expenses
    var expensesArr = [];
    var total_expenses = 0;

    //================Common Functions====================//
var finalVat=0;
var finalNbt=0;

    //===========calculate total summery======================================
    function cal_total(total, discount, extra, downPay, downPayInt, qurPayInt, totalInt, totalExtra) {

        var total_net2 = parseFloat(total) - parseFloat(discount);

     
        totalVat=addTotalVat(total_net2,isTotalVat,isTotalNbt,nbtRatio);
        totalNbt=addTotalNbt(total_net2,isTotalVat,isTotalNbt,nbtRatio);
        finalAmount = parseFloat(total_net2+totalVat+totalNbt+totalProVAT+totalProNBT+shipping);
        total_net2=parseFloat(total_net2+totalVat+totalNbt+shipping);

        $("#netgrnamount").html(accounting.formatMoney(finalAmount));
        $("#grndiscount").html(accounting.formatMoney(discount));
        $("#shippingcharges,#mshipping").html(accounting.formatMoney(shipping));
        $("#totalgrn").html(accounting.formatMoney(total));
        $("#totalVat").html(accounting.formatNumber(totalVat+totalProVAT));
        $("#totalNbt").html(accounting.formatNumber(totalNbt+totalProNBT));

        $('#mtotal').html(accounting.formatMoney(total));
        $('#mdiscount').html(accounting.formatMoney(discount));
        $('#mnetpay').html(accounting.formatMoney(finalAmount));
        $('#mvat').html(accounting.formatMoney(totalVat+totalProVAT));
        $('#mnbt').html(accounting.formatMoney(totalNbt+totalProNBT));
        
        total_discount = discount;
        total_amount  = total;
        total_amount2  = total;
        totalNetAmount  = finalAmount;
        finalVat=totalVat + totalProVAT;
        finalNbt=totalNbt + totalProNBT;
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

        totalProWiseDiscount += parseFloat(product_discount);
       
        total_discount = totalProWiseDiscount + parseFloat(totalGrnDiscount);
        total_amount += totalNet3;

        totalNet = totalNet3 - parseFloat(product_discount);
        discount_precent = accounting.formatNumber(disPercent);
        totalNetAmount = total_amount - parseFloat(total_discount);

        cal_total(total_amount, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest);

        $('#discountAmount').html(accounting.formatMoney(total_discount));
        $('#totalprodiscount').html(accounting.formatMoney(totalProWiseDiscount));
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

        totalGrnDiscount = product_discount;

        total_discount = totalProWiseDiscount + totalGrnDiscount;
        discount_precent = 0;

        total_amount2 += parseFloat(total_amount4) - parseFloat(product_discount);
        total_amount = parseFloat(total_amount4);
        totalNetAmount = total_amount - parseFloat(total_discount);

        cal_total(total_amount, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest);

        $('#discountAmount').html(accounting.formatMoney(total_discount));
        $('#netgrnamount').html(accounting.formatMoney(totalNetAmount));
        $('#totalgrndiscount').html(accounting.formatMoney(totalGrnDiscount));
    }

    function clear_data_after_save() {

        $("input[name=isLot][value='0']").prop('checked', true);
        getLastBatchNo();

        $('#tbl_item tbody').html("");
        $('#table_expenses tbody').html("");
        $("#cusCode").html("");
        $("#customer").val("");
        $("#creditLimit").html('0.00');
        $("#creditPeriod").html('0');
        $("#cusOutstand").html('0.00');
        $("#availableCreditLimit").html('0.00');
        $("#city").html('');
        $("#cusImage").hide();

        expensesArr.length = 0;
        pcode.length = 0;
        total_expenses = 0;
        $("#totalExpenses").html(0);
    }

    function setProductTable() {
        $('#tbl_item tbody tr').each(function(rowIndex, element) {
            var row = rowIndex + 1;

            $(this).find("[class]").eq(0).html(row);
            $(this).find("[class]").eq(0).parent().attr("ri", row);
            $(this).find("[class]").eq(0).parent().attr("id", row);
        });
    }

    function clear_gem_data() {
        $("#sellingPrice").val('');
        $("#proVatPrice").val('');
        $("#serialNo").val('');
        $("#dv_SN").hide();
        $("#itemCode").val('');
        $("#batchCode").val('');
        $("#unitcost").val(0);
        $("#remark").val('');
        $("#guessAmount").val(0);
        $("#qty").val(0);
        $("#cutWeight").val(0);
        $("#polishWeight").val(0);
        $("#totalNet").val(0);
        $("#buyAmount").val(0);
        $("#isCut").val(1);
        $("#isPolish").val(1);
        $("#isBuy").val(1);
        $(".gemoption").prop('checked', false);

        $('.rank').val(0);
        $("#disPercent").val(0);
        $("#disAmount").val(0);
        $("#salesperson").val('');
        $("#upm").html('');
        $("#proStock").html('');
        $("#productName").html('');

        $("#totalAmount").html(accounting.formatMoney(total_amount));
        $("#netAmount").html(accounting.formatMoney(totalNetAmount));

        $("input[name=isCut][value='1']").prop('checked', false);
        $("input[name=isPolish][value='1']").prop('checked', false);
        $("input[name=isBuy][value='1']").prop('checked', false);
        $("#isZero").iCheck('uncheck');

        totalNet2 = 0;
        discount = 0;
        discount_type = 0;
        discount_precent = 0;
        discount_amount = 0;
        product_discount = 0;
        itemCode = 0;
        casecost = 0;
        costPrice = 0;
        sellingPrice = 0;
        orgSellingPrice=0;
        vatSellingPrice=0;
        isSellZero=0;
        $("#itemCode").focus();
        
    }

    function deleteImg(imgid) {
        $.ajax({
            type: 'POST',
            url: "../Admin/Controller/Product.php",
            data: {action: 'deleteimagedata', pid: pid, imgid: imgid},
            success: function(data) {
                if (data == 'success') {
                    $("div[imgdata='" + imgid + "']").parent().hide();
                }
            }
        });
    }

$('.supplier_icheck').iCheck({
    checkboxClass: 'icheckbox_square-green',
    radioClass: 'iradio_square-blue',
    increaseArea: '50%' // optional
});


$("#cart-pay-button").click(function(){
    $("#saveItems").prop('disabled',true);
});

function strPad(input, length, string, code) {
    string = string || '0';
    input = input + '';
    return input.length >= length ? code + input : code + (new Array(length - input.length + 1).join(string)) + input;
}

    // load grid data
    function loadSalesInvoiceDatatoGrid(resultData) {

        total_discount = 0;
        total_amount = 0;
        total_amount2 = 0;
        totalNetAmount = 0;
        totalProWiseDiscount = 0;
        itemcode.length=0;

        $("#cart-pay-button").prop('disabled',false);
        $("#tbl_job tbody").html('');

        if (resultData.si_hed){
            poNo = resultData.si_hed.SalesInvNo;
            regNo = resultData.si_hed.SalesVehicle;
            cusCode = resultData.si_hed.SalesCustomer;
            isTotalVat =parseFloat(resultData.si_hed.SalesIsVat);
            isTotalNbt =parseFloat(resultData.si_hed.SalesIsNbt);
            totalNbtRatio =parseFloat(resultData.si_hed.SalesNbtRatio);
            loadTotalVATNBT(isTotalVat,isTotalNbt,totalNbtRatio);
            var invlink = "../Salesinvoice/view_sales_invoice/"+Base64.encode(poNo);
            $("#lastInvoice").html("<a href='"+invlink+"'>Last Invoice - "+poNo+"</a>");
            $("#btnPrint").attr('link',invlink);

            $("#grn_no").val(poNo);
            $("#customer").val(resultData.si_hed.SalesCustomer);
            $("#invType").val(resultData.si_hed.SalesInvType);
            $("#salesorder").val(resultData.si_hed.SalesOrderNo);
            $("#grnDate").val(resultData.si_hed.SalesDate);
            $("#shipping").val(resultData.si_hed.SalesShipping);
             $("#receiver_name").val(resultData.si_hed.SalesReceiver);
              $("#receiver_nic").val(resultData.si_hed.SalesRecNic);
              $("#com_amount").val(resultData.si_hed.SalesCommsion);
              $("#compayto").val(resultData.si_hed.SalesComCus);

            if(resultData.si_hed.SalesShippingLabel==null){
                $("#shippingLabel").val('Shipping');
            }else{
                
                 $("#shippingLabel").val(resultData.si_hed.SalesShippingLabel);
            }
            
            $("#newsalesperson").val(resultData.si_hed.SalesPerson);
            shipping=parseFloat(resultData.si_hed.SalesShipping);
            loadCustomerDatabyId(resultData.si_hed.SalesCustomer);
            getVehiclesByCustomer(resultData.si_hed.SalesCustomer);

            for (var i = 0; i < resultData.si_dtl.length; i++) {

                if(resultData.si_dtl[i].ProductCode!=customProCode){
                    itemcode.push(resultData.si_dtl[i].ProductCode);
                }
                
                serialnoarr.push(resultData.si_dtl[i].ProductCode);

                $("#tbl_item tbody").append("<tr ri=" + i + " id=" + i + " proCode='" + resultData.si_dtl[i].ProductCode + "' uc='" + resultData.si_dtl[i].SalesCaseOrUnit + "' qty='" + resultData.si_dtl[i].SalesQty + "' vatunit_price='" + resultData.si_dtl[i].SalesUnitPrice + "'  org_unit_price='" + resultData.si_dtl[i].SalesUnitPrice + "' unit_price='" + resultData.si_dtl[i].SalesUnitPrice + "' upc='" + resultData.si_dtl[i].SalesUnitPerCase + "' caseCost='" + (resultData.si_dtl[i].SalesCostPrice*resultData.si_dtl[i].SalesQty) + "' isSerial='" + resultData.si_dtl[i].SalesSerialNo + "' serial='" + resultData.si_dtl[i].SalesSerialNo + "' discount_percent='" + resultData.si_dtl[i].SalesDisPercentage + "' cPrice='" + resultData.si_dtl[i].SalesCostPrice + "' pL='" + resultData.si_dtl[i].SalesPriceLevel + "' fQ='" + resultData.si_dtl[i].SalesFreeQty + "' nonDisTotalNet='" + resultData.si_dtl[i].SalesTotalAmount + "' netAmount='" + resultData.si_dtl[i].SalesInvNetAmount + "' proDiscount='" + resultData.si_dtl[i].SalesDisValue + "' proName='" + resultData.si_dtl[i].SalesProductName  + "'   isvat='"+resultData.si_dtl[i].SalesIsVat+"' isnbt='"+resultData.si_dtl[i].SalesIsNbt+"' nbtRatio='"+resultData.si_dtl[i].SalesNbtRatio+"' proVat='"+resultData.si_dtl[i].SalesVatAmount+"' proNbt='"+resultData.si_dtl[i].SalesNbtAmount+"'  salesPerson='"+resultData.si_dtl[i].SalesPerson+"' ><td class='text-center'>" + (i+1) + "</td><td class='text-left'>" + resultData.si_dtl[i].ProductCode + "</td><td>" + resultData.si_dtl[i].SalesProductName + "</td><td>" + resultData.si_dtl[i].SalesCaseOrUnit + "</td><td class='qty" + i + "'>" + accounting.formatNumber(resultData.si_dtl[i].SalesQty) + "</td><td class='text-right'>" + accounting.formatNumber(resultData.si_dtl[i].SalesUnitPrice) + "</td><td class='text-center'>" + resultData.si_dtl[i].SalesDisPercentage + "</td><td class='text-right' >" + accounting.formatMoney(resultData.si_dtl[i].SalesInvNetAmount) + "</td><td class='text-right' >" + (resultData.si_dtl[i].SalesSerialNo) + "</td><td></td><td><i class='glyphicon glyphicon-edit edit btn btn-info btn-xs'></i></td><td class='rem" + i + "'><a href='#' class='remove btn btn-xs btn-danger'><i class='fa fa-remove'></i></a></td></tr>");
                totalProWiseDiscount += parseFloat(resultData.si_dtl[i].SalesDisValue);
            }
        
            // $("#totalprodiscount").html(accounting.formatMoney(totalProWiseDiscount));
            $("#regNo").val((resultData.si_hed.SalesVehicle));
            $("#netgrnamount").html(accounting.formatMoney(resultData.si_hed.SalesNetAmount));
            $("#grndiscount").html(accounting.formatMoney(resultData.si_hed.SalesDisAmount));
            $("#totalgrn").html(accounting.formatMoney(total_amount));
            $("#totalVat").html(accounting.formatMoney(resultData.si_hed.SalesVatAmount));
            $("#totalNbt").html(accounting.formatMoney(resultData.si_hed.SalesNbtAmount));
            $("#shipping").html(accounting.formatMoney(resultData.si_hed.SalesShipping));
            total_discount = parseFloat(resultData.si_hed.SalesDisAmount);
            total_amount = parseFloat(resultData.si_hed.SalesInvAmount);
            total_amount2 = parseFloat(resultData.si_hed.SalesInvAmount);
            totalNetAmount = parseFloat(resultData.si_hed.SalesNetAmount);
            $("#totalWithOutDiscount").val(total_amount2);
            cal_total(total_amount, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest);

            setPrintLabelData(resultData);

            $("#saveItems").html('Confirm Payment');
            $("#saveItems").prop('disabled',true);
            // $("#action").val(2);
        } else {
            $("#saveItems").html('Confirm Payment');
            $("#saveItems").prop('disabled',false);
            // $("#action").val(0);
            estimateNo = 0;
        }

        //po print data
        $("#lblinvDate").html(resultData.si_hed.SalesDate);
        $("#lblPoNo").html(resultData.si_hed.SalesInvNo);

        if(resultData.si_hed.SalesInvType==1){
           $("#taxHead").hide();
           $("#invHead").show();
            $("#lblInvType").html('Invoice');
            $("#vatno").hide();
        }else if(resultData.si_hed.SalesInvType==2){
            $("#lblInvType").html('Tax Invoice');
            $("#taxHead").show();
            $("#invHead").hide();
            $("#vatno").show();
        }

        // $("#lblSupplier").html(resultData.si_hed.SupName);
        $("#lbltotalPOAmount").html(accounting.formatMoney(resultData.si_hed.SalesInvAmount));
        $("#lbltotalDiscount").html(accounting.formatMoney(resultData.si_hed.SalesDisAmount));
        $("#lbltotalVatAmount").html(accounting.formatMoney(resultData.si_hed.SalesVatAmount));
        $("#lbltotalNbtAmount").html(accounting.formatMoney(resultData.si_hed.SalesNbtAmount));
        $("#lbltotalPONetAmount").html(accounting.formatMoney(resultData.si_hed.SalesNetAmount));
        $("#lbltotalPOAdvanceAmount").html(accounting.formatMoney(resultData.si_hed.SalesAdvancePayment));


        if(resultData.si_hed.SalesCashAmount>0){
            $("#rowCash").show();
            $("#lbltotalCashAmount").html(accounting.formatMoney(resultData.si_hed.SalesCashAmount));
        }else{
            $("#rowCash").hide();
        }

        if(resultData.si_hed.SalesAdvancePayment>0){
            $("#rowAdvance").show();
            $("#lbltotalPOAdvanceAmount").html(accounting.formatMoney(resultData.si_hed.SalesAdvancePayment));
        }else{
            $("#rowAdvance").hide();
        }

        if(resultData.si_hed.SalesCCardAmount>0){
            $("#rowCard").show();
            $("#lbltotalCardAmount").html(accounting.formatMoney(resultData.si_hed.SalesCCardAmount));
        }else{
            $("#rowCard").hide();
        }

        if(resultData.si_hed.SalesCreditAmount>0){
            $("#rowCredit").show();
            $("#lbltotalCreditAmount").html(accounting.formatMoney(resultData.si_hed.SalesCreditAmount));
        }else{
            $("#rowCredit").hide();
        }

        if(resultData.si_hed.SalesChequeAmount>0){
            $("#rowCheque").show();
            $("#lbltotalChequeAmount").html(accounting.formatMoney(resultData.si_hed.SalesChequeAmount));
        }else{
            $("#rowCheque").hide();
        }

         if(resultData.si_hed.SalesDisAmount>0){
            $("#rowDiscount").show();
         }else{
            $("#rowDiscount").hide();
         }

         if(resultData.si_hed.SalesVatAmount>0){
            $("#rowVat").show();
         }else{
            $("#rowVat").hide();
         }

         if(resultData.si_hed.SalesNbtAmount>0){
            $("#rowNbt").show();
         }else{
            $("#rowNbt").hide();
         }

         if(resultData.si_hed.SalesDisAmount>0 || resultData.si_hed.SalesNbtAmount>0 || resultData.si_hed.SalesVatAmount>0){
            $("#rowNet").show();
         }else{
            $("#rowNet").hide();
         }

        $("#tbl_po_data tbody").html('');
        if(resultData.si_dtl){
            // if()
// if(resultData.si_hed.SalesInvType==1){
//             for (var i = 0; i < resultData.si_dtl.length; i++) {
//                 $("#tbl_po_data tbody").append("<tr><td style='padding: 3px;'>" + resultData.si_dtl[i].SalesQty + "</td><td style='padding: 3px;'>" + resultData.si_dtl[i].Prd_Description + "<br>"+resultData.si_dtl[i].SalesSerialNo+"</td><td style='text-align:right;padding: 3px;'>" + resultData.si_dtl[i].WarrantyMonth+ "</td><td style='text-align:right;padding: 3px;' colspan='2'>" + accounting.formatMoney(resultData.si_dtl[i].SalesInvNetAmount) + "</td></tr>");
//             }
//             $("#rowNbt").hide();
//             $("#rowVat").hide();
//             $("#rowTotal").hide();
//              $("#rowNet").show();
// }else if(resultData.si_hed.SalesInvType==2){
//      for (var i = 0; i < resultData.si_dtl.length; i++) {
//                 $("#tbl_po_data tbody").append("<tr><td style='padding: 3px;'>" + resultData.si_dtl[i].SalesQty + "</td><td style='padding: 3px;'>" + resultData.si_dtl[i].Prd_Description + "<br>"+resultData.si_dtl[i].SalesSerialNo+"</td><td style='text-align:right;padding: 3px;'>" + resultData.si_dtl[i].WarrantyMonth+ "</td><td style='text-align:right;padding: 3px;'>" + resultData.si_dtl[i].SalesUnitPrice+ "</td><td style='text-align:right;padding: 3px;'>" + accounting.formatMoney(resultData.si_dtl[i].SalesTotalAmount) + "</td></tr>");
//             }
// }
        }

         if(resultData.si_dtl_arr){

            $.each(resultData.si_dtl_arr, function(key, value) {
                //general invoice 

                if(resultData.si_hed.SalesInvType==1){
                    var i=0;
                    while(i < value.length){
                        //serial product
                        if(value.length>1 && value[i].SalesSerialNo!=''){
                            var serial_no='';
                            for (var k = 0; k < value.length; k++) {
                                serial_no+=value[k].SalesSerialNo+" ";
                            }

                            $("#tbl_po_data tbody").append("<tr><td style='padding: 3px;'>" +value[0].SalesQty*value.length + "</td><td style='padding: 3px;'>" + value[0].SalesProductName + "<br>"+serial_no+"</td><td style='text-align:right;padding: 3px;'>" + value[0].WarrantyMonth+ " Month(s) </td><td style='text-align:right;padding: 3px;'>" + accounting.formatMoney(parseFloat(value[0].SalesInvNetAmount)) + "</td><td style='text-align:right;padding: 3px;'>" + accounting.formatMoney(parseFloat(value[0].SalesInvNetAmount)*value.length) + "</td></tr>");
                            i+=value.length;
                        }else{
                            //noramal product
                            $("#tbl_po_data tbody").append("<tr><td style='padding: 3px;'>" + value[i].SalesQty + "</td><td style='padding: 3px;'>" + value[i].SalesProductName + "<br>"+value[i].SalesSerialNo+"</td><td style='text-align:right;padding: 3px;'>" + value[i].WarrantyMonth+ "  Month(s) </td><td style='text-align:right;padding: 3px;'>" + accounting.formatMoney(value[i].SalesUnitPrice) + "</td><td style='text-align:right;padding: 3px;'>" + accounting.formatMoney(value[i].SalesInvNetAmount) + "</td></tr>");
                            i++;
                        }      
                    }

                    $("#rowNbt").hide();
                    $("#rowVat").hide();
                    $("#rowTotal").hide();
                    $("#rowNet").show();

                }else if(resultData.si_hed.SalesInvType==2){
                    $("#rowTotal").show();
                    // tax invoice
                    var i=0;
                    while(i < value.length){

                        //serial product
                        if(value.length>1 && value[i].SalesSerialNo!=''){
                            var serial_no='';
                            for (var k = 0; k < value.length; k++) {
                                serial_no+=value[k].SalesSerialNo+" ";
                            }

                            $("#tbl_po_data tbody").append("<tr><td style='padding: 3px;'>" +value[0].SalesQty*value.length + "</td><td style='padding: 3px;'>" + value[0].SalesProductName + "<br>"+serial_no+"</td><td style='text-align:right;padding: 3px;'>" + value[0].WarrantyMonth+ "  Month(s) </td><td style='text-align:right;padding: 3px;'>" + value[0].SalesUnitPrice+ "</td><td style='text-align:right;padding: 3px;'>" + accounting.formatMoney(parseFloat(value[0].SalesTotalAmount)*value.length) + "</td></tr>");
                        i+=value.length;

                        }else{

                            //noramal product
                            $("#tbl_po_data tbody").append("<tr><td style='padding: 3px;'>" + value[i].SalesQty + "</td><td style='padding: 3px;'>" + value[i].SalesProductName + "<br>"+value[i].SalesSerialNo+"</td><td style='text-align:right;padding: 3px;'>" + value[i].WarrantyMonth+ " Month(s) </td><td style='text-align:right;padding: 3px;'>" + value[i].SalesUnitPrice+ "</td><td style='text-align:right;padding: 3px;'>" + accounting.formatMoney(value[i].SalesTotalAmount) + "</td></tr>");
                            i++;
                       }      
                    }
                }
            });
        }

        $("#saveItems").prop('disabled',false);
        $("#btnPrint").prop('disabled',false);
    }

    // print invoice
     $("#btnPrint").click(function() {
        // $('#printArea').focus().print();
        // var divContents = $("#printArea").html();
        var link = $(this).attr('link');
        window.location=link;
    });

     function setGridandLabelData(data) {
        if (data.cus_data) {
            cusCode = data.cus_data.CusCode;
            outstanding = data.cus_data.CusOustandingAmount;
            available_balance = parseFloat(data.cus_data.CreditLimit) - parseFloat(outstanding);
            customer_name = data.cus_data.CusName;

            $("#cusName1").html(data.cus_data.CusName);
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
    }

    function setPrintLabelData(data) {
        if (data.cus_data) {
            cusCode = data.cus_data.CusCode;
            outstanding = data.cus_data.CusOustandingAmount;
            available_balance = parseFloat(data.cus_data.CreditLimit) - parseFloat(outstanding);
            customer_name = data.cus_data.CusName;
            $("#lblcusName").html(data.cus_data.RespectSign + ", " +data.cus_data.CusName);
            $("#lbladdress1").html(nl2br(data.cus_data.Address01) + ", " + data.cus_data.Address02);
            $("#lbladdress2").html(data.cus_data.Address03);
        }
    }

var cusCode=0;
cusCode =$("#customer").val();

if(cusCode!=''){
    loadCustomerDatabyId(cusCode);
    getVehiclesByCustomer(cusCode);
}

//customer autoload
    $("#customer").autocomplete({
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
            $("#tbl_payment tbody").html("");
            loadCustomerDatabyId(cusCode);
            getVehiclesByCustomer(cusCode);
        }
    });

    function getVehiclesByCustomer(cus){
        if(cus!=''){
            $('#regNo').html('');
            $.ajax({
                url: '../job/loadvehiclesjson',
                dataType: "json",
                data: {
                    cusCode: cus
                },
                success: function(data) {
                    $.each(data,function(k,v) {
                       $('#regNo').append('<option value="'+v.id+'">'+v.text+'</option>');
                    });
                }
            });
        }
    }

    $("#regNo").select2({
        placeholder: "Select a vehicle",
        allowClear: true,
        ajax: {
            url: "../job/loadvehiclesjson",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term,
                    cusCode: cusCode
                };
            },
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        minimumInputLength: 0
    });

$('#regNo').on('select2:select', function (e) {
     regNo = $(this).val();
  // Do something
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
                $("#modelno").html(resultData.model);
                $("#fuel").html(resultData.fuel_type);
                $("#vinno").html(resultData.ChassisNo);
                $("#engNo").html(resultData.EngineNo);
                $("#yom").html(resultData.ManufactureYear);
                $("#color").html(resultData.body_color);

                loadCustomerDatabyId(resultData.CusCode);
            }
        }
    });
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

    // $("#regNo").select2();
 var regNo ='';
    //vehicle autoload
    // $("#regNo").autocomplete({
    //     source: function(request, response) {
    //         $.ajax({
    //             url: '../job/loadvehiclesjson',
    //             dataType: "json",
    //             data: {
    //                 q: request.term,
    //                 cusCode: cusCode
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
    //          regNo = ui.item.value;
            
    //         $.ajax({
    //             type: "POST",
    //             url: "../Job/getVehicleDetailsById",
    //             data: { id: regNo },
    //             success: function(data) {
    //                 var resultData = JSON.parse(data);
    //                 if (resultData) {
    //                     $("#contactName").html(resultData.contactName);
    //                     $("#registerNo").html(resultData.RegNo);
    //                     $("#make").html(resultData.make);
    //                     $("#modelno").html(resultData.model);
    //                     $("#fuel").html(resultData.fuel_type);
    //                     $("#vinno").html(resultData.ChassisNo);
    //                     $("#engNo").html(resultData.EngineNo);
    //                     $("#yom").html(resultData.ManufactureYear);
    //                     $("#color").html(resultData.body_color);

    //                     loadCustomerDatabyId(resultData.CusCode);
    //                 }
    //             }
    //         });
    //     }
    // });

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
                var encode_url = "../Payment/view_customer/"+(cusCode);

                $("#cusName1").html("<a href='"+encode_url+"'>"+resultData.cus_data.CusName+" "+resultData.cus_data.LastName+"</a>");
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

     function clearCustomerData() {
        $("#cusName1").html('');
        $("#cusAddress").html('');
        $("#cusAddress2").html('');
        $("#cusPhone").html('');
    }

    $("#serialNo").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: 'loadproductSerial',
                dataType: "json",
                data: {
                    q: request.term,
                    location: loc,
                    row_num: 1,
                    proCode: itemCode
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
            serialNo = ui.item.value;
        }
    });

//payment
// $('#chequeReciveDate,#chequeDate,#chequeReciveDate2,#chequeDate2').datepicker({ format: 'yyyy-mm-dd'});
// $('#appoDate').datepicker().datepicker("setDate", new Date());

var creditAmount = 0;
var cashAmount = 0;
 chequeAmount = 0;
var cardAmount =0;
var companyAmount =0;
var toPay=totalNetAmount;
var dueAmount=0;
var cusPayment=0;
var cusType=0;

$("#saveItems").attr('disabled', true);
$("#chequeData").hide();


function addPayment(pcash, pcredit, pcard,pcheque,pcusType,padvance,pbank) {

    dueAmount = totalNetAmount - parseFloat(pcash + pcard+pcheque+pcredit+padvance+pbank);

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

        cusTotal=parseFloat(pcash + pcard+pcheque+pcredit+padvance+pbank);
        
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
               addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount);
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
     addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount);

        if (dueAmount > 0) {
            creditAmount+=dueAmount;
            $("#credit_amount").val((creditAmount));
        }else if(dueAmount>toPay){
            creditAmount-=dueAmount;
            $("#credit_amount2").val((creditAmount));
        }

     addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount);
       return false;
    });



    $("#tblCard tbody").on('click', '.removeCard', function() {
        $(this).parent().parent().remove();
        var removeItem = $(this).parent().parent().attr('ctype');
        ccard = jQuery.grep(ccard, function(value) {
            return value != removeItem;
        });

        cardAmount -= parseFloat($(this).parent().parent().attr('camount'));
        addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount);
        $("#card_amount").val((cardAmount));

    });

    $("#cheque_amount").keyup(function() {
        chequeAmount = parseFloat($(this).val());
        cashAmount = parseFloat($("#cash_amount").val());
        creditAmount = parseFloat($("#credit_amount").val());
        cardAmount = parseFloat($("#card_amount").val());
        advance_amount = parseFloat($("#advance_amount").val());
        bank_amount = parseFloat($("#bank_amount").val());
        creditAmount=0;
       $("#credit_amount").val(0);
        addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount);

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
        creditAmount=0;
       $("#credit_amount").val(0);
        addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount);

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

       creditAmount=0;
       $("#credit_amount").val(0);
        addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount);
    });

    $("#credit_amount").keyup(function() {
        creditAmount = parseFloat($(this).val());
        cashAmount = parseFloat($("#cash_amount").val());
        cardAmount = parseFloat($("#card_amount").val());
        chequeAmount = parseFloat($("#cheque_amount").val());
        advance_amount = parseFloat($("#advance_amount").val());
        bank_amount = parseFloat($("#bank_amount").val());

        addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount);
    });

    $("#cash_amount").blur(function() {
        cashAmount = parseFloat($(this).val());
        creditAmount = parseFloat($("#credit_amount").val());
        cardAmount = parseFloat($("#card_amount").val());
        chequeAmount = parseFloat($("#cheque_amount").val());
        advance_amount = parseFloat($("#advance_amount").val());
        bank_amount = parseFloat($("#bank_amount").val());
        creditAmount=0;
       $("#credit_amount").val(0);
        addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount);
    });

    $("#credit_amount").blur(function() {
        creditAmount = parseFloat($(this).val());
        cashAmount = parseFloat($("#cash_amount").val());
        cardAmount = parseFloat($("#card_amount").val());
        chequeAmount = parseFloat($("#cheque_amount").val());
        advance_amount = parseFloat($("#advance_amount").val());
        bank_amount = parseFloat($("#bank_amount").val());
        addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount);
    });

    $("#advance_amount").blur(function() {
        advance_amount = parseFloat($(this).val());
        cashAmount = parseFloat($("#cash_amount").val());
        cardAmount = parseFloat($("#card_amount").val());
        chequeAmount = parseFloat($("#cheque_amount").val());
        creditAmount = parseFloat($("#credit_amount").val());
        bank_amount = parseFloat($("#bank_amount").val());
        addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount);
    });

    $("#advance_amount").keyup(function() {
        advance_amount = parseFloat($(this).val());
        cashAmount = parseFloat($("#cash_amount").val());
        cardAmount = parseFloat($("#card_amount").val());
        chequeAmount = parseFloat($("#cheque_amount").val());
        creditAmount = parseFloat($("#credit_amount").val());
        bank_amount = parseFloat($("#bank_amount").val());
        addPayment(cashAmount, creditAmount, cardAmount,chequeAmount,cusType,advance_amount,bank_amount);
    });

//load invoice data to grid
    function loadSalesOrderDatatoGrid(resultData) {
        totalAmount = 0;
        totalNetAmount = 0;
        totalProVAT = 0;
        totalProNBT = 0;
        totalVat = 0;
        totalNbt = 0;
        totalNet=0;
        total_discount=0;
        isProVatEnabled=0;

        $("#totalAmount").html(accounting.formatNumber(0));
        $("#customTotal").val(accounting.formatNumber(0));
        $("#totalNet").html(accounting.formatNumber(0));
        $("#totalVat").html(accounting.formatNumber(0));
        $("#totalNbt").html(accounting.formatNumber(0));

         loadCustomerDatabyId(resultData.so_hed.SalesCustomer);
return false;
        // if(resultData.so_hed.IsCusNet==1){
        //         $("#isCustomTotal").iCheck('check');
        //     }else{
        //          $('#isCustomTotal').iCheck('uncheck');
        //     }

        // if(resultData.so_hed.IsEdit==1){
            $("#saveItems").prop('disabled',true);
        // }else{
        //     $("#saveItems").prop('disabled',false);
        // } 
        // $("#tbl_job tbody").html('');
        if (resultData.so_dtl!=null || resultData.so_dtl!=''){

            soNo = resultData.so_hed.SalesOrderNo;
            $("#soNo").val(soNo);
            loadCustomerDatabyId(resultData.so_hed.SalesCustomer);
            return false;

            $("#payType").val(resultData.so_hed.PayType);
            $("#salesperson").val(resultData.so_hed.SalesPerson);
            // $("#supplemetNo").val(resultData.so_hed.JobSupplimentry);
            // $("#remark").val(resultData.so_hed.remark);
            // SupNumber = resultData.so_hed.JobSupplimentry;

            jobNumArr.length = 0;
            proCodeArr.length = 0;
            paintsArr.length = 0;
            parts2Arr.length = 0;
            parts3Arr.length = 0;

            for (var i = 0; i < resultData.so_dtl.length; i++) {
                if (resultData.so_dtl[i].ProType == 1) {
                    if (resultData.so_dtl[i].ProCode > 0) { jobNumArr.push(resultData.so_dtl[i].ProCode); }
                } else if (resultData.so_dtl[i].ProType == 2) {
                    if (resultData.so_dtl[i].ProCode > 0) { proCodeArr.push(resultData.so_dtl[i].ProCode) }
                } else if (resultData.so_dtl[i].ProType == 3) {
                    if (resultData.so_dtl[i].ProCode > 0) { paintsArr.push(resultData.so_dtl[i].ProCode); }
                } else if (resultData.so_dtl[i].ProType == 4) {
                    if (resultData.so_dtl[i].ProCode > 0) { parts2Arr.push(resultData.so_dtl[i].ProCode); }
                } else if (resultData.so_dtl[i].ProType == 5) {
                    if (resultData.so_dtl[i].ProCode > 0) { parts3Arr.push(resultData.so_dtl[i].ProCode); }
                }

                // if (resultData.so_dtl[i].EstIsInsurance == 1) {} else {
                    totalProVAT += parseFloat(resultData.so_dtl[i].SalesVatAmount);
                    totalProNBT += parseFloat(resultData.so_dtl[i].SalesNbtAmount);
                    product_discount=parseFloat(resultData.so_dtl[i].SalesDiscount);
                    totalProWiseDiscount += product_discount;
                // }
                $("#tbl_job tbody").append("<tr est_price='0' discount_type='"+resultData.so_dtl[i].SalesDiscountType+"'  proDiscount='"+resultData.so_dtl[i].SalesDisValue+"' disPrecent='"+resultData.so_dtl[i].SalesDisPercentage+"'  totalPrice='"+resultData.so_dtl[i].SalesTotalAmount+"' isvat='"+resultData.so_dtl[i].SalesIsVat+"' isnbt='"+resultData.so_dtl[i].SalesIsNbt+"' nbtRatio='"+resultData.so_dtl[i].SalesNbtRatio+"' proVat='"+resultData.so_dtl[i].SalesVatAmount+"' proNbt='"+resultData.so_dtl[i].SalesNbtAmount+"'  job='" + resultData.so_dtl[i].SalesDescription + "' jobid='" + resultData.so_dtl[i].ProType + "' qty='" + resultData.so_dtl[i].SalesQty + "' jobOrder='" + resultData.so_dtl[i].SalesOrder + "' netprice='" + resultData.so_dtl[i].SalesNetAmount + "'  sellprice='" + resultData.so_dtl[i].SalesPrice + "'  isIns='" + resultData.so_dtl[i].SalesIsShow + "' insurance='" + resultData.so_dtl[i].SalesPrice + "' work_id='" + resultData.so_dtl[i].ProCode + "'  timestamp='" + resultData.so_dtl[i].SalesOrderTimestamp + "'><td>" + (i + 1) + "</td><td work_id='" + resultData.so_dtl[i].ProCode + "'>" + resultData.so_dtl[i].jobtype_name + "</td><td class='text-right'>" + resultData.so_dtl[i].SalesDescription + "</td><td class='text-right'>" + accounting.formatNumber(resultData.so_dtl[i].SalesQty) + "</td><td class='text-right'>" + accounting.formatNumber(resultData.so_dtl[i].SalesPrice) + "</td><td class='text-right'>" + accounting.formatNumber(resultData.so_dtl[i].SalesDisPercentage) + "</td><td class='text-right'>" + accounting.formatNumber(0) + "</td><td class='text-right'>" + accounting.formatNumber(resultData.so_dtl[i].SalesNetAmount) + "</td><td>&nbsp;&nbsp;<i class='glyphicon glyphicon-edit edit btn btn-info btn-xs'></i>&nbsp;<i class='remove btn btn-danger btn-xs glyphicon glyphicon-remove-circle'></i></td></tr>");
            }

            totalAmount = parseFloat(resultData.so_hed.SOTotalAmount);
            totalNetAmount = parseFloat(resultData.so_hed.SONetAmount);
            totalVat=addTotalVat(resultData.so_hed.SOTotalAmount,resultData.so_hed.SOIsVatTotal,resultData.so_hed.SOIsNbtTotal,resultData.so_hed.SONbtRatioTotal);
            totalNbt=addTotalNbt(resultData.so_hed.SOTotalAmount,resultData.so_hed.SOIsVatTotal,resultData.so_hed.SOIsNbtTotal,resultData.so_hed.SONbtRatioTotal);

            total_discount= parseFloat(resultData.so_hed.SOSTotalDiscount);
            totalNet=parseFloat(resultData.so_hed.SONetAmount);

            $("#totalAmount").html(accounting.formatNumber(totalAmount));
            $("#customTotal").val((totalAmount));
            $("#totalDiscount").html(accounting.formatNumber(total_discount));
            $("#totalNet").html(accounting.formatNumber(totalNet));
            $("#totalVat").html(accounting.formatNumber(totalVat+totalProVAT));
            $("#totalNbt").html(accounting.formatNumber(totalNbt+totalProNBT));
            finalVat=totalVat+totalProVAT;
            finalNbt=totalNbt+totalProNBT;

            // estimateNo = resultData.so_hed.JobEstimateNo;
            soNo = resultData.so_hed.SalesOrderNo;

            // invoiceNo = resultData.so_hed.JobInvNo;
           // loadInvoiceData(resultData.so_hed.SalesOrderNo);
            // $("#estimateNo").val(resultData.so_hed.JobEstimateNo);
            $("#soNo").val(resultData.so_hed.SalesOrderNo);
            $("#btnSave").html('Update');
            $("#action").val(2);

            isTotalVat=resultData.so_hed.SOIsVatTotal;
            isTotalNbt=resultData.so_hed.SOIsNbtTotal;
            totalNbtRatio=resultData.so_hed.SONbtRatioTotal;
            loadTotalVATNBT(isTotalVat,isTotalNbt,totalNbtRatio);
        } else {
            $("#btnSave").html('Save');
            $("#action").val(1);
            estimateNo = 0;
        }   
    }

    function nl2br (str, is_xhtml) {
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
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
});
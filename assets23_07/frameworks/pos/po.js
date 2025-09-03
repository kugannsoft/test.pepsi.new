$(document).ready(function() {
    var supcode;
    var customProCode='100001';

    $('#grnDate,#deliverydate,#chequeReciveDate,#expenses_date,#quartPayDate,#chequeDate,#downPayDate1,#downPayDate2,#downPayDate3,#downPayDate4,#downPayDate5,#downPayDate6').datepicker({
        dateFormat: 'yy-mm-dd',
        startDate: '-3d'
    });

    $('#grnDate,#chequeReciveDate,#expenses_date,#quartPayDate,#downPayDate1,#downPayDate2,#downPayDate3,#downPayDate4,#downPayDate5,#downPayDate6').datepicker().datepicker("setDate", new Date());
    $("#dv_FreeQty").hide();
    $("#cusImage").hide();
    $("#lotPriceLable").hide();
    $('#costTable').hide();
    $('#paymentTable').hide();
    $('#payView').hide();
    $("#dv_SN").hide();
    $("#dwnLink").hide();
    $("#loadBarCode").hide();

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
    var return_amount = 0;
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
    var jobNo ='';

    //job no autoload
    $("#jobno").autocomplete({
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
            $("#jobno").val(jobNo);
            
        }
    });

    $("#grn_no").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../purchase/loadpojson',
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
            loadPO(poNo);
        }
    });
    
    function loadPO(po_no){
        $.ajax({
            type: "POST",
            url: "../purchase/getPoDataById",
            data: { poNo: po_no },
            success: function(data) {
                var resultData = JSON.parse(data);
                loadPoDatatoGrid(resultData);
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

    var loc = $("#location").val();
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
                url: "../../admin/Product/getProductByBarCodeforGrn",
                data: {proCode: barCode, prlevel: price_level, location: loc},
                success: function(json) {

                    var resultData = JSON.parse(json);
                    if (resultData) {
                        itemCode = resultData.product.ProductCode;
                        $.each(resultData.serial, function(key, value) {
                            var serialNoArrIndex2 = $.inArray(value, serialnoarr);
                            if (serialNoArrIndex2 < 0) {
                                serialnoarr.push(value);
                            }
                        });
                        autoSerial = resultData.product.IsRawMaterial;
                        // loadVATNBT(isJobVat,isJobNbt,isJobNbtRatio);
                        loadVATNBT(resultData.product.IsTax,resultData.product.IsNbt,resultData.product.NbtRatio);
                        
                        loadProModal(resultData.product.Prd_Description, resultData.product.ProductCode, resultData.product.ProductPrice, resultData.product.Prd_CostPrice, 0, resultData.product.IsSerial, resultData.product.IsFreeIssue, resultData.product.IsOpenPrice, resultData.product.IsMultiPrice, resultData.product.Prd_UPC, resultData.product.WarrantyPeriod, resultData.product.IsRawMaterial,resultData.product.UOM_Name);

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
                url: "../../admin/Product/getProductByIdforGrn",
                data: {proCode: itemCode, prlevel: price_level, location: loc},
                success: function(json) {
                    var resultData = JSON.parse(json);
//                    alert(resultData.serial);
                    if (resultData) {

                        $.each(resultData.serial, function(key, value) {
                            var serialNoArrIndex1 = $.inArray(value, serialnoarr);
                            if (serialNoArrIndex1 < 0) {
                                serialnoarr.push(value);
                            }
                        });
                        autoSerial = resultData.product.IsRawMaterial;
                        // loadVATNBT(isJobVat,isJobNbt,isJobNbtRatio);
                        loadVATNBT(resultData.product.IsTax,resultData.product.IsNbt,resultData.product.NbtRatio);
                        
                        loadProModal(resultData.product.Prd_Description, resultData.product.ProductCode, resultData.product.ProductPrice, resultData.product.Prd_CostPrice, 0, resultData.product.IsSerial, resultData.product.IsFreeIssue, resultData.product.IsOpenPrice, resultData.product.IsMultiPrice, resultData.product.Prd_UPC, resultData.product.WarrantyPeriod, resultData.product.IsRawMaterial,resultData.product.UOM_Name);
                        //  loadProModal(resultData.Prd_Description, resultData.ProductCode, resultData.ProductPrice, resultData.Prd_CostPrice, 0, resultData.IsSerial, resultData.IsFreeIssue, resultData.IsOpenPrice, resultData.IsMultiPrice, resultData.Prd_UPC, resultData.WarrantyPeriod);

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
    function loadProModal(mname, mcode, msellPrice, mcostPrice, mserial, misSerial, misFree, isOP, isMP, upc, waranty, isautoSerial,upm) {
//        clearProModal();
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
        $("#itemCode").val(mcode);
        $("#sellingPrice").val(msellPrice);
        $("#unitcost").val(mcostPrice);
        $("#isSerial").val(misSerial);
        $("#upc").val(upc);
        $("#upm").html(upm);

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
    var costPrice = 0;
    var casecost = 0;
    $("#sellingPrice").blur(function() {
        sellingPrice = parseFloat($(this).val());
        costPrice = parseFloat($("#unitcost").val());

        if (costPrice > sellingPrice) {
            $.notify("Selling price can not be less than cost price.", "warning");
            return false;
        }
    });

    $("#unitcost").blur(function() {
        costPrice = parseFloat($(this).val());
        sellingPrice = parseFloat($("#sellingPrice").val());

        if (costPrice > sellingPrice) {
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
    

    function add_products() {
        var serialQty = 0;
        sellingPrice = parseFloat($("#sellingPrice").val());
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
        newSerialQty = parseFloat($("#serialQty").val());

        var isNewVat = $("input[name='isProVat']:checked").val();
        var isNewNbt = $("input[name='isProNbt']:checked").val();
        var newNbtRatio = parseFloat($("#proNbtRatio").val());
        
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

        maxSerialQty = qty;
        maxSerialQty2 = qty;
        if (is_serail == 1 && autoSerial == 0) {
            serialQty = newSerialQty;
            // qty = 1;
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

        if (itemCode == '' || itemCode == 0) {
            $.notify("Please select a item.", "warning");
            return false;
        } else if (sellingPrice == '' || sellingPrice == 0 || isNaN(sellingPrice) == true) {
            $.notify("Selling price can not be 0.", "warning");
           return false;
        } else if (costPrice == '' || costPrice == 0 || isNaN(costPrice) == true) {
            $.notify("Cost price can not be 0.", "warning");
            return false;
        } else if (qty == '' || qty == 0 || isNaN(qty) == true) {
            $.notify("Please enter a qty.", "warning");
            return false;
        } else if (costPrice > sellingPrice) {
            $.notify("Selling price can not be less than cost price.", "warning");
            return false;
        } else {
            is_serail = 0;
            if (is_serail == 0) {
                if ((itemCodeArrIndex < 0 && is_serail == 0)) {

                    totalNet2 = (sellingPrice * qty);
                    itemcode.push(itemCode);
   
                    total_amount2 += totalNet2;
                    totalCost += sellingPrice;

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

                    $("#tbl_item tbody").append("<tr ri=" + i + " id=" + i + " proCode='" + itemCode + "' uc='" + unit + "' qty='" + qty + "' unit_price='" + sellingPrice + "' upc='" + upc + "' caseCost='" + casecost + "' isSerial='" + is_serail + "' serial='" + serialNo + "' discount_percent='" + discount_precent + "' cPrice='" + costPrice + "' pL='" + priceLevel + "' fQ='" + freeQty + "' nonDisTotalNet='" + totalNet2 + "' netAmount='" + totalNet + "' proDiscount='" + product_discount + "' proName='" + prdName + "'  isvat='"+isNewVat+"' isnbt='"+isNewNbt+"' nbtRatio='"+newNbtRatio+"' proVat='"+proVat+"' proNbt='"+proNbt+"'>\n\
                <td class='text-center'>" + i + "</td><td class='text-left'>" + itemCode + "</td><td>" + prdName + "</td><td>" + unit + "</td><td class='qty" + i + "'>" + accounting.formatNumber(qty) + "</td><td class='text-right'>" + accounting.formatNumber(sellingPrice) + "</td><td class='text-center'>" + discount_precent + "</td><td class='text-right' >" + accounting.formatMoney(totalNet) + "</td><td>" + serialNo + "</td><td class='rem" + i + "'><a href='#' class='remove btn btn-xs btn-danger'><i class='fa fa-remove'></i></a></td></tr>");

                    if (is_serail != 1) {
                        clear_gem_data();
                    } else {
                        if (serialQty == 0) {
                            clear_gem_data();
                        } else {
                            $("#serialNo").val('');
                            $("#serialNo").focus();
                        }
                    }
                    setProductTable();
                } else {
                    $.notify("Item already exists.", "warning");
                    return false;
                }

            }
        }
    }

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

            itemcode = jQuery.grep(itemcode, function(value) {
                return value != removeItem;
            });

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

        var grnDate = $("#grnDate").val();
        var invUser = $("#invUser").val();
        var location = $("#location option:selected").val();
        

        var invoicenumber = $("#invoicenumber").val();
        var additional = $("#additional").val();
        var grnremark = $("#grnremark").val();
        action = $("#action").val();
        var nbtRatioRate=$("#nbtRatioRate").val();

        $('#tbl_item tbody tr').each(function(rowIndex, element) {
            product_code.push($(this).attr('proCode'));
            serial_no.push($(this).attr('serial'));
            qty.push(($(this).attr('qty')));
            unit_price.push(($(this).attr('unit_price')));
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
        });

        var sendProduct_code = JSON.stringify(product_code);
        var sendPro_name = JSON.stringify(pro_name);
        var sendSerial_no = JSON.stringify(serial_no);
        var sendQty = JSON.stringify(qty);
        var sendUnit_price = JSON.stringify(unit_price);
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


        var r = confirm("Do you want to save this PO.?");
        if (r == true) {
            if (supcode == '' || supcode == '0') {
                $.notify("Please select a supplier.", "warning");
                return false;
            } else if ((rowCount - 1) == '0' || (rowCount - 1) == '') {
                $.notify("Please add products.", "warning");
                return false;
            } else {
                maxSerialQty += parseFloat($("#maxSerial").val());
                $("#saveItems").attr('disabled', true);
                $.ajax({
                    type: "post",
                    url: "savePO",
                    data: {grn_no:poNo,action:action,invoicenumber: invoicenumber, additional: additional, grnremark: grnremark, product_code: sendProduct_code, serial_no: sendSerial_no, qty: sendQty, unit_price: sendUnit_price,
                        discount_precent: sendDiscount_precent, pro_discount: sendPro_discount, total_net: sendTotal_net, unit_type: sendUnit_type, price_level: sendPrice_level, upc: sendUpc,
                        case_cost: sendCaseCost, freeQty: sendFree_qty, cost_price: sendCost_price, pro_total: sendPro_total, isSerial: sendIsSerial, proName: sendPro_name,isVat:isVatArr,isNbt:isNbtArr,nbtRatio:nbtRatioArr,proVat:proVatArr,proNbt:proNbtArr, total_cost: totalCost, totalProDiscount: totalProWiseDiscount, totalGrnDiscount: totalGrnDiscount,
                        grnDate: grnDate, invUser: invUser, total_amount: total_amount, total_discount: total_discount, total_net_amount: totalNetAmount, location: location, supcode: supcode, maxSerialQty: maxSerialQty, serialAutoGen: serialAutoGen,nbtRatioRate: nbtRatioRate,isTotalVat:isTotalVat,isTotalNbt:isTotalNbt,totalVat:finalVat,totalNbt:finalNbt},
                    success: function(data) {
                        var resultData = JSON.parse(data);
                        var feedback = resultData['fb'];
                        var invNumber = resultData['InvNo'];
                        if (feedback != 1) {
                            $.notify("PO not saved successfully.", "warning");
                            $("#saveItems").attr('disabled', true);
                            loadPO(invNumber);
                            return false;
                        } else {
                            $.notify("PO saved successfully.", "warning");
                            $("#tbl_item tbody").html('');
                             loadPO(invNumber);
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
                            totalProWiseDiscount = 0;
                            totalGrnDiscount = 0;
                            $("#cashAmount").val(0);
                            $("#chequeAmount").val(0);
                            $("#creditAmount").val(0);

                            $("#totalExpenses").html(0);
                            $('#itemTable').show();
                            $('#costTable').hide();
                            $('#totalAmount').html('0.00');
                            $('#totalgrndiscount').html('0.00');
                            $('#totalprodiscount').html('0.00');
                            $('#dueAmount2').html('0.00');
                            $("#loadBarCode").hide();
                            $("#saveItems").attr('disabled', false);
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
        finalAmount = parseFloat(total_net2+totalVat+totalNbt+totalProVAT+totalProNBT);
        total_net2=parseFloat(total_net2+totalVat+totalNbt);
        $("#netgrnamount").html(accounting.formatMoney(finalAmount));
        $("#grndiscount").html(accounting.formatMoney(discount));
        $("#totalgrn").html(accounting.formatMoney(total));
        $("#totalVat").html(accounting.formatNumber(totalVat+totalProVAT));
        $("#totalNbt").html(accounting.formatNumber(totalNbt+totalProNBT));
        
        total_discount = discount;
        total_amount = total;
        total_amount2 = total;
        totalNetAmount = finalAmount;
        finalVat=totalVat+totalProVAT;
        finalNbt=totalNbt+totalProNBT;
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
        totalProWiseDiscount += product_discount;
        total_discount = totalProWiseDiscount + totalGrnDiscount;
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
     $("#addpro").click(function(e){
        itemCode=customProCode;
        setCustomProduct();
        e.preventDefault();
        
    });

    function clear_gem_data() {
        $("#sellingPrice").val('');
        $("#serialNo").val('');
        $("#dv_SN").hide();
        $("#itemCode").val('');
        $("#itemCode").focus();
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
        $("#upm").html('');

        $("#totalAmount").html(accounting.formatMoney(total_amount));
        $("#netAmount").html(accounting.formatMoney(totalNetAmount));

        $("input[name=isCut][value='1']").prop('checked', false);
        $("input[name=isPolish][value='1']").prop('checked', false);
        $("input[name=isBuy][value='1']").prop('checked', false);
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

function strPad(input, length, string, code) {
    string = string || '0';
    input = input + '';
    return input.length >= length ? code + input : code + (new Array(length - input.length + 1).join(string)) + input;
}


    // load grid data
    function loadPoDatatoGrid(resultData) {
        total_discount = 0;
        total_amount = 0;
        total_amount2 = 0;
        totalNetAmount = 0;
        totalProWiseDiscount = 0;
        itemcode.length=0;

        $("#tbl_job tbody").html('');
        if (resultData.po_data){
            poNo = resultData.po_data.PO_No;
            supCode = resultData.po_data.SupCode;
            $("#grn_no").val(poNo);
            $("#supplier").val(resultData.po_data.SupCode).trigger("change");
            $("#remark").val(resultData.po_data.Remark);
            $("#grnDate").val(resultData.po_data.delivery_date);

            for (var i = 0; i < resultData.po_desc.length; i++) {
                itemcode.push(resultData.po_desc[i].ProductCode);
                $("#tbl_item tbody").append("<tr ri=" + i + " id=" + i + " proCode='" + resultData.po_desc[i].ProductCode + "' uc='" + resultData.po_desc[i].PO_Type + "' qty='" + resultData.po_desc[i].PO_Qty + "' unit_price='" + resultData.po_desc[i].PO_UnitPrice + "' upc='" + resultData.po_desc[i].PO_UPC + "' caseCost='" + resultData.po_desc[i].PO_CaseCost + "' isSerial='" + resultData.po_desc[i].PO_UnitCost + "' serial='" + resultData.po_desc[i].PO_UnitCost + "' discount_percent='" + resultData.po_desc[i].PO_DisPercentage + "' cPrice='" + resultData.po_desc[i].PO_UnitCost + "' pL='1' fQ='0' nonDisTotalNet='" + resultData.po_desc[i].PO_TotalAmount + "' netAmount='" + resultData.po_desc[i].PO_NetAmount + "' proDiscount='" + resultData.po_desc[i].PO_DisAmount + "' proName='" + prdName + "'>\n\
                <td class='text-center'>" + (i+1) + "</td><td class='text-left'>" + resultData.po_desc[i].ProductCode + "</td><td>" + resultData.po_desc[i].PO_ProName + "</td><td>" + resultData.po_desc[i].PO_Type + "</td><td class='qty" + i + "'>" + accounting.formatNumber(resultData.po_desc[i].PO_Qty) + "</td><td class='text-right'>" + accounting.formatNumber(resultData.po_desc[i].PO_UnitPrice) + "</td><td class='text-center'>" + resultData.po_desc[i].PO_DisPercentage + "</td><td class='text-right' >" + accounting.formatMoney(resultData.po_desc[i].PO_NetAmount) + "</td><td></td><td class='rem" + i + "'><a href='#' class='remove btn btn-xs btn-danger'><i class='fa fa-remove'></i></a></td></tr>");
                totalProWiseDiscount += parseFloat(resultData.po_desc[i].PO_DisAmount);
            }

            $("#netgrnamount").html(accounting.formatMoney(resultData.po_data.PO_NetAmount));
            $("#grndiscount").html(accounting.formatMoney(resultData.po_data.PO_TDisAmount));
            $("#totalgrn").html(accounting.formatMoney(resultData.po_data.PO_Amount));
            $("#totalprodiscount").html(accounting.formatMoney(totalProWiseDiscount));
            total_discount = parseFloat(resultData.po_data.PO_TDisAmount);
            total_amount = parseFloat(resultData.po_data.PO_Amount);
            total_amount2 = parseFloat(resultData.po_data.PO_Amount);
            totalNetAmount = parseFloat(resultData.po_data.PO_NetAmount);
            $("#saveItems").html('Update');
            $("#action").val(2);
        } else {
            $("#saveItems").html('Save');
            $("#action").val(1);
            estimateNo = 0;
        }

        //po print data
        $("#lblinvDate").html(resultData.po_data.delivery_date);
        $("#lblPoNo").html(resultData.po_data.PO_No);
        $("#lblPoNo").html(resultData.po_data.PO_No);
        $("#lblSupplier").html(resultData.po_data.SupName+'<br>'+resultData.po_data.Address01+' '+resultData.po_data.Address02+'<br>'+resultData.po_data.Address03);
        $("#lbltotalPOAmount").html(accounting.formatMoney(resultData.po_data.PO_Amount));
        $("#lbltotalDiscount").html(accounting.formatMoney(resultData.po_data.PO_TDisAmount));
        $("#lbltotalVatAmount").html(accounting.formatMoney(resultData.po_data.POVatAmount));
        $("#lbltotalNbtAmount").html(accounting.formatMoney(resultData.po_data.PONbtAmount));
        $("#lbltotalPONetAmount").html(accounting.formatMoney(resultData.po_data.PO_NetAmount));
         
         if(resultData.po_data.PO_TDisAmount>0){
            $("#rowDiscount").show();
         }else{
            $("#rowDiscount").hide();
         }

         if(resultData.po_data.POVatAmount>0){
            $("#rowVat").show();
         }else{
            $("#rowVat").hide();
         }

         if(resultData.po_data.PONbtAmount>0){
            $("#rowNbt").show();
         }else{
            $("#rowNbt").hide();
         }

         if(resultData.po_data.PO_TDisAmount>0 || resultData.po_data.PONbtAmount>0 || resultData.po_data.POVatAmount>0){
            $("#rowNet").show();
         }else{
            $("#rowNet").hide();
         }

        $("#tbl_po_data tbody").html('');
        if(resultData.po_desc){
            for (var i = 0; i < resultData.po_desc.length; i++) {
                $("#tbl_po_data tbody").append("<tr><td style='padding: 3px;'>" + (i + 1) + "</td><td style='padding: 3px;'>" + resultData.po_desc[i].Prd_AppearName + "</td><td style='text-align:right;padding: 3px;'>" + resultData.po_desc[i].PO_Qty/resultData.po_desc[i].PO_UPC+ "</td><td style='text-align:right;padding: 3px;'>" + resultData.po_desc[i].PO_Type+ "</td><td style='text-align:right;padding: 3px;'>" + accounting.formatMoney(resultData.po_desc[i].PO_UnitPrice) + "</td><td style='text-align:right;padding: 3px;'>" + accounting.formatMoney(resultData.po_desc[i].PO_NetAmount) + "</td></tr>");
            }
        }

        $("#saveItems").prop('disabled',false);
        $("#btnPrint").prop('disabled',false);
        
    }

    // print invoice
     $("#btnPrint").click(function() {
        $('#printArea').focus().print();
        var divContents = $("#printArea").html();
    });


});

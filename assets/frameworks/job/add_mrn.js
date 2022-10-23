$(document).ready(function() {
    var supcode;
     var customProCode='100001';
    var loc = 0;
    $('#grnDate,#deliverydate,#chequeReciveDate,#expenses_date,#quartPayDate,#chequeDate,#downPayDate1,#downPayDate2,#downPayDate3,#downPayDate4,#downPayDate5,#downPayDate6').datepicker({
        dateFormat: 'yy-mm-dd',
        startDate: '-3d'
    });

    $('#grnDate,#chequeReciveDate,#expenses_date,#quartPayDate,#downPayDate1,#downPayDate2,#downPayDate3,#downPayDate4,#downPayDate5,#downPayDate6').datepicker().datepicker("setDate", new Date());
    
    $("#customerDiv").show();
 
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

    var proCodeArr = [];
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
    var supcode = 0;

    var isSup = 0;
    var jobNumArr = [];

$("#job_no").autocomplete({
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
            // clearEstimateData();
            jobNo = ui.item.value;
            
            proCodeArr.length=0;
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

                    // setGridandLabelData(resultData);
                    loadEstimateDatatoGrid(resultData);
                }
            });
        }
    });

var estNo = 0;
var mrnNo = 0;

jobNo = $("#job_no").val();

//estimate autoload by job
if(jobNo!=''){
    proCodeArr.length=0;
    $("#tbl_payment tbody").html("");
    $("#tbl_job tbody").html('');
    total_due_amount = 0;
    total_over_payment = 0;
    $("#btnViewJob").attr('disabled', false);
    $.ajax({
        type: "POST",
        url: "../job/getQuotationDataByJobNo",
        data: { jobNo: jobNo },
        success: function(data) {
            var resultData = JSON.parse(data);

            // setGridandLabelData(resultData);
            loadEstimateDatatoGrid(resultData);
        }
    });
}

estNo = $("#est_no").val();

//estimate autoload by job
if(estNo!=''){
    proCodeArr.length=0;
    $("#tbl_payment tbody").html("");
    $("#tbl_job tbody").html('');
    total_due_amount = 0;
    total_over_payment = 0;
    $("#btnViewJob").attr('disabled', false);
    $.ajax({
        type: "POST",
        url: "../job/getQuotationDataByQuotationNo",
        data: { estimateNo: estNo, supplimentNo: 0 },
        success: function(data) {
            var resultData = JSON.parse(data);
            loadEstimateDatatoGrid(resultData);
        }
    });
}

mrnNo = $("#grn_no").val();

//estimate autoload by job
if(mrnNo!=''){
    $("#tbl_payment tbody").html("");
    $("#tbl_job tbody").html('');
    total_due_amount = 0;
    total_over_payment = 0;
    $("#btnViewJob").attr('disabled', false);
    $.ajax({
        type: "POST",
        url: "../mrn/loadMrnById",
        data: { mrnNo: mrnNo },
        success: function(data) {
            var resultData = JSON.parse(data);

            // setGridandLabelData(resultData);
            loadMrnDatatoGrid(resultData);
        }
    });
}

$("#est_no").autocomplete({
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
            // clearEstimateData();
            estNo = ui.item.value;
            
            proCodeArr.length=0;
            $("#tbl_payment tbody").html("");
            $("#tbl_job tbody").html('');
            total_due_amount = 0;
            total_over_payment = 0;
            $("#btnViewJob").attr('disabled', false);
            $.ajax({
                type: "POST",
                url: "../job/getEstimateDataByEstimateNo",
                data: { estimateNo: estNo, supplimentNo: 0  },
                success: function(data) {
                    var resultData = JSON.parse(data);
                    loadEstimateDatatoGrid(resultData);
                    
                }
            });
            
        }
    });


// $("#est_no").autocomplete({
//         source: function(request, response) {
//             $.ajax({
//                 url: '../job/loadestimatejson',
//                 dataType: "json",
//                 data: {
//                     q: request.term
//                 },
//                 success: function(data) {
//                     response($.map(data, function(item) {
//                         return {
//                             label: item.text,
//                             value: item.id,
//                             data: item
//                         }
//                     }));
//                 }
//             });
//         },
//         autoFocus: true,
//         minLength: 0,
//         select: function(event, ui) {
//             // clearEstimateData();
//             estNo = ui.item.value;
            
//             proCodeArr.length=0;
//             $("#tbl_payment tbody").html("");
//             $("#tbl_job tbody").html('');
//             total_due_amount = 0;
//             total_over_payment = 0;
//             $("#btnViewJob").attr('disabled', false);
//             $.ajax({
//                 type: "POST",
//                 url: "../job/getEstimateDataByEstimateNo",
//                 data: { estimateNo: estNo, supplimentNo: 0 },
//                 success: function(data) {
//                     var resultData = JSON.parse(data);
//                     loadEstimateDatatoGrid(resultData);
                    
//                 }
//             });
            
//         }
//     });

$("#grn_no").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../mrn/loadmrnjson',
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
            // clearEstimateData();
            mrnNo = ui.item.value;
            
            $("#tbl_payment tbody").html("");
            $("#tbl_job tbody").html('');
            total_due_amount = 0;
            total_over_payment = 0;
            $("#btnViewJob").attr('disabled', false);
            $.ajax({
                type: "POST",
                url: "../mrn/loadMrnById",
                data: { mrnNo: mrnNo },
                success: function(data) {
                    var resultData = JSON.parse(data);

                    // setGridandLabelData(resultData);

                    loadMrnDatatoGrid(resultData);
                }
            });
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


    //======= set price levels ==========
    $("#priceLevel").change(function() {
        price_level = $("#priceLevel option:selected").val();
    });

    $("#supplier").change(function() {
        supcode = $("#supplier option:selected").val();
    });
     loc = $("#invlocation").val();
    
    $('#itemCode').on('keydown', function(e) {
        if (e.which == 13) {
            $("#errGrid").hide();
//            $("#cart-table-notice").remove();
            var barCode = $(this).val();
            price_level = $("#priceLevel option:selected").val();

            $.ajax({
                type: "post",
                url: "../../admin/Product/getProductByBarCodeforSTO",
                data: {proCode: barCode, prlevel: price_level, location: loc},
                success: function(json) {

                    var resultData = JSON.parse(json);
                    if (resultData) {
                        itemCode = resultData.product.ProductCode;
                        $.each(resultData.serial, function(key, value) {
                            var serialNoArrIndex2 = $.inArray(value, stockSerialnoArr);
                            if (serialNoArrIndex2 < 0) {
                                stockSerialnoArr.push(value);
                            }
                        });

                        loadProModal(resultData.product.Prd_Description, resultData.product.ProductCode, resultData.product.ProductPrice, resultData.product.Prd_CostPrice, 0, resultData.product.IsSerial, resultData.product.IsFreeIssue, resultData.product.IsOpenPrice, resultData.product.IsMultiPrice, resultData.product.Prd_UPC, resultData.product.WarrantyPeriod);
//                        $('html, body').animate({scrollTop: $('#cart-table-body').offset().top}, 'slow');
                    } else {
                        $.notify("Product not found.", "warning");
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

//isSup =  $("[name='suppliercheck']:checked").val();

    $("input[name='suppliercheck']").on('ifChanged', function() {
        isSup = $("input[name='suppliercheck']:checked").val();
        if (!isSup) {
            isSup = 0;
        }
    });

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
                    price_level: price_level
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
                url: "../../admin/Product/getProductByIdforSTO",
                data: {proCode: itemCode, prlevel: price_level, location: loc},
                success: function(json) {
                    var resultData = JSON.parse(json);
                    if (resultData) {
                        $.each(resultData.serial, function(key, value) {
                            var serialNoArrIndex1 = $.inArray(value, stockSerialnoArr);
                            if (serialNoArrIndex1 < 0) {
                                stockSerialnoArr.push(value);
                            }
                        });

                        loadProModal(resultData.product.Prd_Description, resultData.product.ProductCode, resultData.product.ProductPrice, resultData.product.Prd_CostPrice, 0, resultData.product.IsSerial, resultData.product.IsFreeIssue, resultData.product.IsOpenPrice, resultData.product.IsMultiPrice, resultData.product.Prd_UPC, resultData.product.WarrantyPeriod);
//                    $("#modelBilling").modal('toggle');
                        //loadProModal(resultData.Prd_Description, resultData.ProductCode, resultData.ProductPrice, resultData.Prd_CostPrice, 0, resultData.IsSerial, resultData.IsFreeIssue, resultData.IsOpenPrice, resultData.IsMultiPrice, resultData.Prd_UPC, resultData.WarrantyPeriod);
//                    $('html, body').animate({scrollTop: $('#cart-table-body').offset().top}, 'slow');
                    } else {
                        $.notify("Product not found.", "warning");
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

//load model
    function loadProModal(mname, mcode, msellPrice, mcostPrice, mserial, misSerial, misFree, isOP, isMP, upc, waranty) {
//        clearProModal();
        $("#qty").focus();
//       alert(misSerial);
        if (misSerial == 1) {
//            $("#serialNo").val(mserial);
//            $("#qty").val(1);
//            $("#qty").attr('disabled', true);
            // $("#dv_SN").show();
            $("#qty").focus();

        } else {
//            $("#mSerial").val('');
            $("#qty").attr('disabled', false);
            $("#dv_SN").hide();
        }
        $("#qty").val(1);
//        $("#mLProCode").html(mcode);
        $("#prdName").val(mname);
        $("#itemCode").val(mcode);
        $("#sellingPrice").val(msellPrice);
        $("#unitcost").val(mcostPrice);
        $("#isSerial").val(misSerial);
        $("#upc").val(upc);

        if (misSerial == 1) {

        } else {
            $("#dv_SN").hide();
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
            $.notify("Selling price can not be less than cost price", "warning");
            return false;
        }
    });

    $("#unitcost").blur(function() {
        costPrice = parseFloat($(this).val());
        sellingPrice = parseFloat($("#sellingPrice").val());

        if (costPrice > sellingPrice) {
            $.notify("Selling price can not be less than cost price", "warning");
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

     $('#qty').on('keydown', function(e) {
        if (e.which == 13) {
            add_products();
        }
    });

    $('#sellingPrice').on('keydown', function(e) {
        if (e.which == 13) {
            add_products();
        }
    });
    
     var serialNo ='';
     function add_products(){
       
        sellingPrice = parseFloat($("#sellingPrice").val());
        var unit = $("#mUnit option:selected").val();
        var prdName = $("#prdName").val();
        serialNo = $("#serialNo").val();
        var is_serail = $("#isSerial").val();
        var priceLevel = $("#priceLevel option:selected").val();
        var qty = parseFloat($("#qty").val());
        var upc = parseFloat($("#upc").val());
        costPrice = parseFloat($("#unitcost").val());
        var freeQty = parseFloat($("#freeqty").val());
        var brand = ($("#brand").val());
        var quality = ($("#quality").val());
        var case1 = $("#mUnit option:selected").val();
        var preturn = $("#mReturn option:selected").val();
        newSerialQty = parseFloat($("#serialQty").val());
        if (is_serail == 1) {
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

        var itemCodeArrIndex = $.inArray(itemCode, proCodeArr);

        if (itemCode == '' || itemCode == 0) {
            $.notify("Please select a item.", "warning");
            return false;
        } else if (qty == '' || qty == 0 || isNaN(qty) == true) {
            $.notify("Please enter a qty.", "warning");
            return false;
        } else {
            if (is_serail == 0) {
                if ((itemCodeArrIndex < 0 && is_serail == 0) || (itemCodeArrIndex >= 0 && is_serail == 1) || (itemCodeArrIndex < 0 && is_serail == 1)) {
                    totalNet2 = (sellingPrice * qty);

                    if(itemCode!=customProCode){
                        proCodeArr.push(itemCode);
                    }
                    total_amount2 += totalNet2;
                    totalCost += costPrice;
                    $("#totalWithOutDiscount").val(total_amount2);

                    calculateProductWiseDiscount(totalNet2, discount, discount_type, discount_precent, discount_amount, total_amount2);
                    cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount);
                    i++;
                    if (is_serail == 1) {
                        serialQty--;
                        $("#serialQty").val(serialQty);
                    }

                    $("#tbl_item tbody").append("<tr isreceive='" + 0 + "'  request_date='" + 0 + "' ri=" + i + " id=" + i + " proCode='" + itemCode + "' uc='" + unit + "' brand='" + brand + "' quality='" + quality + "' qty='" + qty + "' unit_price='" + sellingPrice + "' upc='" + upc + "' caseCost='" + casecost + "' isSerial='" + is_serail + "' serial='" + serialNo + "' discount_percent='" + discount_precent + "' cPrice='" + costPrice + "' pL='" + priceLevel + "' fQ='" + freeQty + "' nonDisTotalNet='" + totalNet2 + "' netAmount='" + totalNet + "' proDiscount='" + product_discount + "' proName='" + prdName + "' proReturn='" + preturn + "'  isVat='" + 0 + "' isNbt='" + 0 + "' nbtRatio='"+1+"' vat='"+0+"' nbt='"+0+"'>\n\
                <td class='text-center'>" + i + "</td><td class='text-left'>" + itemCode + "</td><td>" + prdName + "</td><td class='qty" + i + "'>" + accounting.formatNumber(qty) + "</td><td>" + brand + "</td><td>" + quality + "</td><td class='rem" + i + "'><a href='#' class='remove btn btn-xs btn-danger'><i class='fa fa-remove'></i></a></td></tr>");

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
            } else if (is_serail == 1) {
                var serialNoArrIndex = $.inArray(serialNo, serialnoarr);
                var StockserialNoArrIndex = $.inArray(serialNo, stockSerialnoArr);
                if (((itemCodeArrIndex >= 0 && is_serail == 1) || (itemCodeArrIndex < 0 && is_serail == 1))) {
                    totalNet2 = (sellingPrice * qty);
                    if(itemCode!=customProCode){
                        proCodeArr.push(itemCode);
                    }
                    serialnoarr.push(serialNo);
                    total_amount2 += totalNet2;
                    totalCost += costPrice;
                    $("#totalWithOutDiscount").val(total_amount2);

                    calculateProductWiseDiscount(totalNet2, discount, discount_type, discount_precent, discount_amount, total_amount2);
                    cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount);
                    i++;
                    if (is_serail == 1) {
                        serialQty--;
                        $("#serialQty").val(serialQty);
                    }

                    $("#tbl_item tbody").append("<tr isreceive='" + 0 + "'  request_date='" + 0 + "' ri=" + i + " id=" + i + " proCode='" + itemCode + "' uc='" + unit + "' brand='" + brand + "' quality='" + quality + "' qty='" + qty + "' unit_price='" + sellingPrice + "' upc='" + upc + "' caseCost='" + casecost + "' isSerial='" + is_serail + "' serial='" + serialNo + "' discount_percent='" + discount_precent + "' cPrice='" + costPrice + "' pL='" + priceLevel + "' fQ='" + freeQty + "' nonDisTotalNet='" + totalNet2 + "' netAmount='" + totalNet + "' proDiscount='" + product_discount + "' proName='" + prdName + "' proReturn='" + preturn + "'  isVat='" + 0 + "' isNbt='" + 0 + "' nbtRatio='"+1+"' vat='"+0+"' nbt='"+0+"'>\n\
                <td class='text-center'>" + i + "</td><td class='text-left'>" + itemCode + "</td><td>" + prdName + "</td><td class='qty" + i + "'>" + accounting.formatNumber(qty) + "</td><td>" + brand + "</td><td>" + quality + "</td><td class='rem" + i + "'><a href='#' class='remove btn btn-xs btn-danger'><i class='fa fa-remove'></i></a></td></tr>");

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
                    $("#serialNo").val('');
                } else {
                    $.notify("Item already exists.", "warning");
                    $("#serialNo").val('');
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

            proCodeArr = jQuery.grep(proCodeArr, function(value) {
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

//==========================================================

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
        var pro_return = new Array();
        var quality = new Array();
        var brand = new Array();
        var isVat = [];
        var isNbt = [];
        var nbtRatio = [];
        var proVat = [];
        var proNbt = [];
        var request_date = [];
        var isReceive = [];

        var grnDate = $("#grnDate").val();
        var invUser = $("#invUser").val();
        var location = $("#invlocation").val();
        var location_from = $("#location_from option:selected").val();
        var location_to = $("#location_to option:selected").val();
        var invoicenumber = $("#invoicenumber").val();
        var additional = $("#additional").val();
        var grnremark = $("#grnremark").val();
         var action = $("#action").val();

//        customer_payment = cash_amount + cheque_amount + credit_amount + return_amount;

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
            pro_return.push($(this).attr("proReturn"));
            isVat.push($(this).attr('isvat'));
            isNbt.push($(this).attr('isnbt'));
            nbtRatio.push($(this).attr('nbtratio'));
            proVat.push($(this).attr('vat'));
            proNbt.push($(this).attr('nbt'));
            request_date.push($(this).attr('request_date'));
            isReceive.push($(this).attr('isreceive'));
            brand.push($(this).attr('brand'));
            quality.push($(this).attr('quality'));

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
        var sendProReturn = JSON.stringify(pro_return);
        var isVatArr = JSON.stringify(isVat);
        var isNbtArr = JSON.stringify(isNbt);
        var nbtRatioArr = JSON.stringify(nbtRatio);
        var proVatArr = JSON.stringify(proVat);
        var proNbtArr = JSON.stringify(proNbt);
        var request_dateArr =JSON.stringify(request_date);
        var isReceiveArr =JSON.stringify(isReceive);
        var brandArr =JSON.stringify(brand);
        var qualityArr =JSON.stringify(quality);


        var r = confirm("Do you want to save this MRN.?");
        if (r == true) {
            if ((rowCount - 1) == '0' || (rowCount - 1) == '') {
                $.notify("Please add products.", "warning");
                return false;
            } else if ((location_from) == '0' || (location_from) == '') {
                $.notify("Please Select a request from location.", "warning");
                return false;
            } else if (((jobNo) == '0' || (jobNo) == '') && cusCode=='' ) {
                $.notify("Please Select a job no.", "warning");
                return false;
            }  else {
                $("#saveItems").attr('disabled', true);
//            return false;
                $.ajax({
                    type: "post",
                    url: "saveMrn",
                    data: {mrnNo:mrnNo,action:action,cusCode:cusCode,estNo:estNo, jobNo:jobNo, invoicenumber: invoicenumber, additional: additional, grnremark: grnremark, product_code: sendProduct_code, serial_no: sendSerial_no, qty: sendQty, unit_price: sendUnit_price,
                        discount_precent: sendDiscount_precent,brand:brandArr,  quality:qualityArr, pro_discount: sendPro_discount, total_net: sendTotal_net, unit_type: sendUnit_type, price_level: sendPrice_level, upc: sendUpc,request_date:request_dateArr,isReceive:isReceiveArr,
                        case_cost: sendCaseCost, freeQty: sendFree_qty, cost_price: sendCost_price, pro_total: sendPro_total, isSerial: sendIsSerial, proName: sendPro_name,proReturn:sendProReturn,isVat:isVatArr,isNbt:isNbtArr,nbtRatio:nbtRatioArr,proVat:proVatArr,proNbt:proNbtArr, total_cost: totalCost, totalProDiscount: totalProWiseDiscount, totalGrnDiscount: totalGrnDiscount,
                        grnDate: grnDate, invUser: invUser, total_amount: total_amount, total_discount: total_discount, total_net_amount: totalNetAmount, location: location, location_from: location_from, location_to: location_to},
                    success: function(data) {
                        var resultData = JSON.parse(data);
                        var feedback = resultData['fb'];
                        var invNumber = resultData['InvNo'];
                        if (feedback != 1) {
                            $.notify("MRN not saved successfully.", "warning");
                            $("#loadBarCode").hide();
                            $("#dwnLink").hide();
                            $("#saveItems").attr('disabled', false);
                            return false;
                        } else {
                            $.notify("MRN saved successfully.", "success");
                            $("input[name=suppliercheck][value='1']").prop('checked', false);
                            $("#invoicenumber").val("");
                            $("#supplier").val("");
                            $("#totalgrn").html('0.00');
                            $("#grndiscount").html('0.00');
                            $("#netgrnamount").html('0.00');
                            $("#grnremark").val('');

                            total_amount = 0;
                            total_discount = 0;
                            totalNetAmount = 0;
                            supcode = 0;
                            creditAmount = 0;
                            dueAmount = 0;
                            totalProWiseDiscount = 0;
                            totalGrnDiscount = 0;
                            jobNo=0;
                            $("#cashAmount").val(0);
                            $("#chequeAmount").val(0);
                            $("#creditAmount").val(0);

                            $("#totalExpenses").html(0);
//                        getLastBatchNo();
                            $('#itemTable').show();
                            $('#costTable').hide();
                            $('#totalAmount').html('0.00');
                            $('#totalgrndiscount').html('0.00');
                            $('#totalprodiscount').html('0.00');
                            $('#dueAmount2').html('0.00');
                            $("#loadBarCode").hide();
                            $("#dwnLink").show();
                            $("#saveItems").attr('disabled', true);
//                        location.reload();
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



    //===========calculate total summery======================================
    function cal_total(total, discount, extra, downPay, downPayInt, qurPayInt, totalInt, totalExtra) {

        var total_net2 = parseFloat(total) - parseFloat(discount);
        finalAmount = parseFloat(total_net2);
//        alert(total); alert(discount);
        $("#netgrnamount").html(accounting.formatMoney(total_net2));
        $("#grndiscount").html(accounting.formatMoney(discount));
        $("#totalgrn").html(accounting.formatMoney(total));
        total_discount = discount;
        total_amount = total;
        total_amount2 = total;
        totalNetAmount = total_net2;
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

//        total_discount = product_discount;
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
        $("#mReturn").val(0);
        $("#serialNo").val('');
        $("#quality").val('');
        $("#brand").val('');
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
        preturn=0;

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
            loadCustomerDatabyId(cusCode);
        }
    });

    function loadCustomerDatabyId(customer){
        clearCustomerData();
        $.ajax({
                type: "POST",
                url: "../Payment/getCustomersDataById",
                data: { cusCode: customer},
                success: function(data)
                {
                    var resultData = JSON.parse(data);

                    cusCode = resultData.cus_data.CusCode;
                    outstanding = resultData.cus_data.CusOustandingAmount;
                    available_balance = parseFloat(resultData.cus_data.CreditLimit) - parseFloat(outstanding);
                    customer_name=resultData.cus_data.CusName;
                    $("#cusName").html(resultData.cus_data.CusName);
                    $("#customer,#cusCode").val(resultData.cus_data.CusCode);
                    $("#creditLimit").html(accounting.formatMoney(resultData.cus_data.CreditLimit));
                    $("#creditPeriod").html(resultData.cus_data.CreditPeriod);
                    $("#cusOutstand").html(accounting.formatMoney(outstanding));
                    $("#availableCreditLimit").html(accounting.formatMoney(available_balance));
                    $("#cusAddress").html(nl2br(resultData.cus_data.Address01));
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

     function clearCustomerData(){
        $("#cusName").html('');
        $("#cusAddress").html('');
        $("#cusAddress2").html('');
        $("#cusPhone").html('');
    }

 function nl2br (str, is_xhtml) {
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }



$('.supplier_icheck').iCheck({
    checkboxClass: 'icheckbox_square-green',
    radioClass: 'iradio_square-blue',
    increaseArea: '50%' // optional
});



var jobNo=0;
//job no autoload
    // $("#grn_no").autocomplete({
    //     source: function(request, response) {
    //         $.ajax({
    //             url: '../loadjobjson',
    //             dataType: "json",
    //             data: {
    //                 q: request.term
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
    //         // clearEstimateData();
    //         jobNo = ui.item.value;
            
    //         $("#tbl_payment tbody").html("");
    //         $("#tbl_job tbody").html('');
    //         total_due_amount = 0;
    //         total_over_payment = 0;
    //         $("#btnViewJob").attr('disabled', false);
    //         $.ajax({
    //             type: "POST",
    //             url: "../../job/getEstimateDataByJobNo",
    //             data: { jobNo: jobNo },
    //             success: function(data) {
    //                 var resultData = JSON.parse(data);

    //                 // setGridandLabelData(resultData);

    //                 loadEstimateDatatoGrid(resultData);
    //             }
    //         });
    //     }
    // });


// load grid data
function loadEstimateDatatoGrid(resultData) {
    
    $("#tbl_item tbody").html('');
    
    var priceLevel = $("#priceLevel option:selected").val();
    if (resultData.est_dtl){
        jobNo = resultData.est_hed.EstJobCardNo;
        estNo =resultData.est_hed.EstimateNo;
        $("#job_no").val(jobNo);
        $("#est_no").val(resultData.est_hed.EstimateNo);

        if (resultData.est_hed.EstJobType == 1) {
            // $("#vehicleCompany").show();
            // $("#dvInsurance").show();
        } else {
            $("#vehicleCompany").hide();
            $("#dvInsurance").hide();
        }
        var k = 1;
        var estTotal = 0;
        for (var i = 0; i < resultData.est_dtl.length; i++) {
            if (resultData.est_dtl[i].jobhead == 2) {
                if (resultData.est_dtl[i].EstJobId > 0) { proCodeArr.push(resultData.est_dtl[i].EstJobId) }
                var itemCode = resultData.est_dtl[i].EstJobId;
                var prdName = resultData.est_dtl[i].EstJobDescription;
                var qty = resultData.est_dtl[i].EstQty;
                var unit = 'UNIT';var upc='';
                estTotal+=parseFloat(resultData.est_dtl[i].EstTotalAmount);
                var isvat = parseFloat(resultData.est_dtl[i].EstIsVat);
                var isnbt = parseFloat(resultData.est_dtl[i].EstIsNbt);
                var nbtratio = parseFloat(resultData.est_dtl[i].EstNbtRatio);
                var vat = parseFloat(resultData.est_dtl[i].EstVatAmount);
                var nbt = parseFloat(resultData.est_dtl[i].EstNbtAmount);
            
                 $("#tbl_item tbody").append("<tr ri=" + k + " id=" + k + " proCode='" + itemCode + "' uc='" + unit + "' qty='" + qty + "' unit_price='" + resultData.est_dtl[i].EstPrice + "' upc='" + upc + "'  caseCost='" + 0 + "' isSerial='" + 0 + "'  cPrice='" + resultData.est_dtl[i].Prd_CostPrice + "' pL='" + priceLevel + "' fQ='" + 0 + "' nonDisTotalNet='" + resultData.est_dtl[i].EstTotalAmount + "' netAmount='" + resultData.est_dtl[i].EstNetAmount + "' proDiscount='" + 0 + "' proName='" + prdName + "' proReturn='" + 0 + "' isVat='" + isvat + "' isNbt='" + isnbt + "' nbtRatio='"+nbtratio+"' vat='"+vat+"' nbt='"+nbt+"'>\n\
                <td class='text-center'>" + k + "</td><td class='text-left'>" + itemCode + "</td><td>" + prdName + "</td><td class='qty" + k+ "'>" + accounting.formatNumber(qty) + "</td><td>" + unit + "</td><td class='rem" + k + "'><a href='#' class='remove btn btn-xs btn-danger'><i class='fa fa-remove'></i></a></td></tr>");
                k++;
            }
        }
    } else {
        $("#btnSave").html('Save');
        $("#action").val(1);
        estimateNo = 0;
    }
}

function loadQuotationDatatoGrid(resultData) {

      
    $("#tbl_item tbody").html('');
    
    var priceLevel = $("#priceLevel option:selected").val();
    if (resultData.qut_dtl){
        proCodeArr.length=0;
        jobNo = resultData.qut_hed.QutJobCardNo;
        estNo =resultData.qut_hed.QuotationNo;
        $("#job_no").val(jobNo);
        $("#est_no").val(resultData.qut_hed.QuotationNo);

        if (resultData.qut_hed.QutJobType == 1) {
            // $("#vehicleCompany").show();
            // $("#dvInsurance").show();
        } else {
            $("#vehicleCompany").hide();
            $("#dvInsurance").hide();
        }

        var k = 1;
        var estTotal = 0;
        for (var i = 0; i < resultData.qut_dtl.length; i++) {
            if (resultData.qut_dtl[i].QutDescType == 2) {
                if (resultData.qut_dtl[i].QutId !=0) { proCodeArr.push(resultData.qut_dtl[i].QutId) }
                  
                var itemCode = resultData.qut_dtl[i].QutId;
                var prdName = resultData.qut_dtl[i].QutDescription;
                var qty = resultData.qut_dtl[i].QutQty;
                var unit = 'UNIT';var upc='';
                estTotal+=parseFloat(resultData.qut_dtl[i].QutTotalAmount);
                var isvat = parseFloat(resultData.qut_dtl[i].QutIsVat);
                var isnbt = parseFloat(resultData.qut_dtl[i].QutIsNbt);
                var nbtratio = parseFloat(resultData.qut_dtl[i].QutNbtRatio);
                var vat = parseFloat(resultData.qut_dtl[i].QutVatAmount);
                var nbt = parseFloat(resultData.qut_dtl[i].QutNbtAmount);
            
                 $("#tbl_item tbody").append("<tr isreceive='" + 0 + "' request_date='" + 0 + "' ri=" + k + " id=" + k + " proCode='" + itemCode + "' uc='" + unit + "' qty='" + qty + "' unit_price='" + resultData.qut_dtl[i].QutPrice + "' upc='" + upc + "'  caseCost='" + 0 + "' isSerial='" + 0 + "'  cPrice='" + resultData.qut_dtl[i].QutPrice + "' pL='" + priceLevel + "' fQ='" + 0 + "' nonDisTotalNet='" + resultData.qut_dtl[i].QutTotalAmount + "' netAmount='" + resultData.qut_dtl[i].QutNetAmount + "' proDiscount='" + 0 + "' proName='" + prdName + "' proReturn='" + 0 + "' isVat='" + isvat + "' isNbt='" + isnbt + "' nbtRatio='"+nbtratio+"' vat='"+vat+"' nbt='"+nbt+"'>\n\
                <td class='text-center'>" + k + "</td><td class='text-left'>" + itemCode + "</td><td>" + prdName + "</td><td class='qty" + k+ "'>" + accounting.formatNumber(qty) + "</td><td>" + unit + "</td><td class='rem" + k + "'><a href='#' class='remove btn btn-xs btn-danger'><i class='fa fa-remove'></i></a></td></tr>");
                k++;
            }
        }
    } else {
        $("#btnSave").html('Save');
        $("#action").val(1);
        estimateNo = 0;
    }
}

function loadMrnDatatoGrid(resultData) {
    $("#saveItems").prop('disabled',false);
    $("#tbl_item tbody").html('');
    if (resultData.mrn_dtl){
        jobNo = resultData.mrn_hed.MrnJobNo;
        cusCode = resultData.mrn_hed.ToCustomer;
        $("#customer").val(cusCode);
        $("#job_no").val(jobNo);
        $("#est_no").val(resultData.mrn_hed.MrnEstimateNo);
        $("#grnremark").val(resultData.mrn_hed.MrnRemark);
        $("#location_from").val(resultData.mrn_hed.FromLocation);
        estNo =resultData.mrn_hed.MrnEstimateNo;
        var k = 1;
        for (var i = 0; i < resultData.mrn_dtl.length; i++) {
            // if (resultData.mrn_dtl[i].EstJobType == 2) {
                if (resultData.mrn_dtl[i].ProductCode > 0) { 
                    if(resultData.mrn_dtl[i].ProductCode!=customProCode){
                        proCodeArr.push(resultData.mrn_dtl[i].ProductCode);
                    }
                }
                var itemCode = resultData.mrn_dtl[i].ProductCode;
                var prdName = resultData.mrn_dtl[i].ProName;
                var qty = resultData.mrn_dtl[i].RequestQty;
                var quality = resultData.mrn_dtl[i].ProQuality;
                var brand = resultData.mrn_dtl[i].ProBrand;
                var unit = resultData.mrn_dtl[i].CaseOrUnit;var upc=resultData.mrn_dtl[i].UnitPerCase;
                var isvat = parseFloat(resultData.mrn_dtl[i].MrnIsVat);
                var isnbt = parseFloat(resultData.mrn_dtl[i].MrnIsNbt);
                var nbtratio = parseFloat(resultData.mrn_dtl[i].MrnNbtRatio);
                var vat = parseFloat(resultData.mrn_dtl[i].MrnVatAmount);
                var nbt = parseFloat(resultData.mrn_dtl[i].MrnNbtAmount);


            $("#tbl_item tbody").append("<tr isreceive='" + resultData.mrn_dtl[i].Receive + "' request_date='" + resultData.mrn_dtl[i].MrnDate + "' ri=" + k + " id=" + k + " proCode='" + itemCode + "' uc='" + unit + "'  brand='" + brand + "' quality='" + quality + "' qty='" + qty + "' unit_price='" + resultData.mrn_dtl[i].sellingPrice + "' upc='" + upc + "' caseCost='" + 0 + "' isSerial='" + resultData.mrn_dtl[i].IsSerial + "'  cPrice='" + resultData.mrn_dtl[i].CostPrice + "' pL='" + resultData.mrn_dtl[i].PriceLevel + "' fQ='" + 0 + "' nonDisTotalNet='" + resultData.mrn_dtl[i].TotalAmount + "' netAmount='" + resultData.mrn_dtl[i].NetAmount + "' proDiscount='" + 0 + "' proName='" + prdName + "' proReturn='" + 0 + "' isVat='" + isvat + "' isNbt='" + isnbt + "' nbtRatio='"+nbtratio+"' vat='"+vat+"' nbt='"+nbt+"'>\n\
            <td class='text-center'>" + k + "</td><td class='text-left'>" + itemCode + "</td><td>" + prdName + "</td><td class='qty" + i + "'>" + accounting.formatNumber(qty) + "</td><td>" + brand + "</td><td>" + quality + "</td><td class='rem" + i + "'><a href='#' class='remove btn btn-xs btn-danger'><i class='fa fa-remove'></i></a></td></tr>");
            k++;
        }
        $("#saveItems").html('Update');
        if(resultData.mrn_hed.MrnIsReceive==1){
            $("#saveItems").prop('disabled',true);
            $("#action").val(1);
         }else if(resultData.mrn_hed.MrnIsReceive==0){
            $("#action").val(2);
            $("#saveItems").prop('disabled',false);
         }
    } else {
        $("#saveItems").html('Save');
        $("#action").val(1);
        estimateNo = 0;
    }
}

});
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style type="text/css">
    #gridarea {
        display: flex;
        overflow:scroll;
        background: rgba(136, 153, 119, 0.23);
        height: 400px;
        padding: 2px;
    }
    #tbl_est_data tbody tr td{
        padding: 13px;
    }
    .editrowClass {
      background-color: #f1b9b9;
    }
    .fullpad div {
      padding-left: 0px;
      padding-right: 0px;
    }
</style>
<div class="content-wrapper" id="app">
    <section class="content-header">
        <span style="font-size: 25px;"><?php echo $pagetitle; ?></span>
        <div class="pull-right">
          <span style="font-size: 25px;color: #337ab7;" v-if="totalcount">total: {{totalcount}}</span>
        </div>
    </section>
    <section class="content">
        <div class="row fullpad">
           <div class="col-md-2">
               <div class="form-group">
                    <input type="text" class="form-control"  name="jobNo" id="jobNo" placeholder="Job No" v-model='jobcardNo'>
                </div>
           </div>
           <div class="col-md-2">
               <div class="form-group">
                    <input type="text" class="form-control"  name="estimateNo" id="estimateNo" placeholder="Estimate No" v-model='estimateNo'>
                </div>
           </div>
           <div class="col-md-1"> 
             <div class="form-group">
               <input type="text" class="form-control" name="supplimentNo" id="supplimentNo" placeholder="SPL" v-model='supplimentNo'>
             </div>
           </div>
           <div class="col-md-2">
               <div class="form-group">
                    <input type="text" class="form-control"  name="invoiceNo" id="invoiceNo" placeholder="Invoice No" v-model='invoiceNo'>
                </div>
           </div>
           <div class="col-md-2">
               <div class="form-group">
                    <input type="text" class="form-control"  name="regNo" id="regNo" placeholder="Registration No" v-model='regNo'>
                </div>
           </div>
           <div class="col-md-2">
               <div class="form-group">
                    <input type="text" class="form-control"  name="customerCode" id="customerCode" placeholder="Customer No" v-model='customerCode'>
                </div>
           </div>
           <div class="col-md-1">
               <div class="form-group">
                    <input type="text" class="form-control"  name="date" id="date" placeholder="Date" v-model='date'>
                </div>
           </div> 
        </div>
        <div class="row fullpad">
        <form id="addform">
            <div class="col-md-2">
                <div class="form-group">
                    <select class="form-control" id="jobtype" v-model='vrow.jobtype'>
                        <option value="">--select--</option>
                        <?php foreach ($jobtypes as $k => $v) { ?>
                            <option value="<?php echo $v->jobtype_id ?>"><?php echo $v->jobtype_code." - ".$v->jobtype_name ?>
                            </option>
                       <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input class="form-control" type="text" name="description" id="description" v-model='vrow.description'>
                </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <input type="number" name="qty" id="qty" placeholder="Qty" class="form-control" v-model='vrow.qty' @keyup.enter='addrow' />
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <input type="number" name="price" id="price" placeholder="Price" class="form-control" v-model='vrow.price' @keyup.enter='addrow' />
              </div>
            </div>
            <div class="col-md-2">
                <div class="input-group" style=""> 
                  <input type="text" class="form-control" name="snpid" style="width:60%" v-model="vrow.discountval" @keyup.enter='addrow' />
                  <select id="lunch" class="form-control" style="width:40%" v-model="vrow.discountmethod">
                      <option value="1" style="font-weight: bold;">CSH</option>
                      <option value="2" style="font-weight: bold;">%</option>
                  </select> 
              </div>
            </div>
            <div class="col-md-1">
                <button @click='addrow' class="btn btn-flat btn-primary btn-block" type="button" v-show="!isUpdateRow">Add</button>
                <button @click='updaterow' class="btn btn-flat btn-primary btn-block" type="button" v-show="isUpdateRow">Update</button>
            </div>
          </form>
        </div>
        <div class="row">
            <div class="col-md-10">
                <div id="gridarea">
                    <table class="table table-bordered" style="table-layout: fixed;" >
                        <thead>
                            <tr>
                                <td width="10%"><b>##</b></td>
                                <td width="35%"><b>Description</b></td>
                                <td width="5%"><b>Qty</b></td>
                                <td width="10%"><b>Price</b></td>
                                <td width="10%"><b>Total</b></td>
                                <td width="10%"><b>Discount</b></td>
                                <td width="10%"><b>Net Total</b></td>
                                <td width="10%"><b>###</b></td>
                            </tr>
                        </thead>
                        <tbody>
                          <tr v-for="item,key in vgriddata" >

                            <td>{{key+1}}</td>
                            <td class="text-nowrap" style="overflow: hidden;">{{item.description}}</td>
                            <td>{{item.qty}}</td>
                            <td align="right">{{item.price | currency}}</td>
                            <td align="right">{{item.total | currency}}</td>
                            <td align="right">{{item.discountval | currency}}</td>
                            <td align="right">{{item.netamount | currency}}</td>
                            <td>
                              <button @click="removeitem(key)" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-remove-circle"></i></button>
                              <button @click="edititem(item,key)" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-edit"></i></button>
                            </td>
                          </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-2">
              <button type="button" class="btn btn-default btn-lg btn-block">Cancel</button>
              <button type="button" @click='printinvoice' class="btn btn-default btn-lg btn-block">Print</button>
              <button type="button" class="btn btn-default btn-lg btn-block" v-show="state==='save'" @click='saveinvoice' >Save</button>
              <button type="button" class="btn btn-default btn-lg btn-block" v-show="state==='update'" @click='updateinvoice'>Update</button>
              <!-- <button data-target="#modelPayment" type="button"  data-toggle="modal">Payment</button> -->
              <!-- <a href="payment/job_payment" type="button" id="btnPayment"  class="btn btn-default btn-lg btn-block" >Payment</a> -->
            </div>
        </div>
        <!-- print parts goes here -->
        <div class="modal fade bs-payment-modal-lg" id="modelInvoice" tabindex="-1" role="dialog" aria-hidden="false">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content"><div class="modal-body" >
                    <?php //invoice print 
                    $this->load->view('admin/sales/sale-invoce-print.php',true); ?>
          
                </div>
              </div>
            </div>
        </div>
        <!--  payment model -->
        <!--payment model-->
    <div class="modal fade bs-payment-modal-lg" id="modelPayment" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <form role="form" id="addDep" data-parsley-validate method="post" action="#">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-remove"></i></span></button>
                        <h4 class="modal-title" id="myModalLabel2">Payment Details <span id="errPayment"></span></h4>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <form class="form-horizontal">
                                <div class="col-md-4">

                                    <!--<div class="form-group">-->
                                        <!--<h4 class="text-center">Payment Type : <span class="discount_type">: <span class="label label-primary">percentage</span></span></h4>-->
                                    <div class="input-group">
                                        <span class="input-group-addon label-success">Cash Amount</span>
                                        <input type="number" name="cash_amount" id="cash_amount" min='0' value="0"  step="50"  class="form-control input-lg" placeholder="cash amount">
                                    </div><br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Card Amount</span>
                                        <input type="number" disabled name="card_amount" id="card_amount" min='0' value="0"  class="form-control input-lg" placeholder="card amount">
                                    </div><br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Credit Amount</span>
                                        <input type="number" name="credit_amount" id="credit_amount" min='0'  value="0"  step="50"  class="form-control input-lg" placeholder="credit amount">
                                    </div>
                                    <table class="table table-hover">
                                        <tbody>
                                            <tr><td>Cash</td><td>:</td><td  id='mcash'  class='text-right'>0.00</td></tr>
                                            <tr><td>Card</td><td>:</td><td  id='mcard'  class='text-right'>0.00</td></tr>
                                            <tr><td>Credit</td><td>:</td><td  id='mcredit'  class='text-right'>0.00</td></tr>
                                        </tbody>
                                    </table>
                                    <!--</div>-->
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">Card type</span>
                                        <select name="card_type" id="card_type" class="form-control input-lg">
                                            <option value="0">Select a type</option>
                                            <option value="1">Visa</option>
                                            <option value="2">Master</option>
                                            <option value="3">Amex</option>
                                        </select>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">Reference</span>
                                        <input type="text" name="card_ref" id="card_ref"   class="form-control input-lg" placeholder="Reference">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">Amount</span>
                                        <input type="number" name="ccard_amount" id="ccard_amount" min='0'  step="50"  value="0"  class="form-control input-lg" placeholder="card amount">
                                        <span class="input-group-btn"><button class="btn btn-primary btn-lg" id='addCard' type="button">Add</button></span>
                                    </div>
                                    <h4>Card details</h4>
                                    <label id="errCard"></label>
                                    <table class="table table-hover" id='tblCard'>
                                        <thead>
                                            <tr><th>Type</th><th>Ref</th><th>Amount</th><th></th></tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <div class="col-md-4">
                                    <table class="table table-hover">
                                        <tbody>
                                            <tr><td>Total</td><td>:</td><td  id='mtotal'  class='text-right'>0.00</td></tr>
                                            <tr><td>Discount</td><td>:</td><td  id='mdiscount'  class='text-right'>0.00</td></tr>
                                            <tr><td>Net Payable</td><td>:</td><td  id='mnetpay'  class='text-right'>0.00</td></tr>
                                            <tr><td id='changeLable'>Change/Refund</td><td>:</td><td id='mchange' class='text-right'>0.00</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div> 
                        <div class="row">
                            <div class="col-md-12"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button>
                        <button type="button" id="saveInvoice" class="btn btn-success btn-lg">Confirm Payment</button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    </section>
</div>

<script type="text/javascript">

Vue.filter('currency', function(val){
    return accounting.formatNumber(val)
});
var app = new Vue({
  el:'#app',
  data:{
      printdata:[],
      isUpdateRow:false,
      updateKey:null,
      state:'',
      vgriddata:[],
      vrow:{
        jobtype:null,
        description:'',
        qty:'',
        price:'',
        total:'',
        netamount:0,
        discountval:0,
        discountmethod:1,
        jobCode:'',
        timestamp:''
    },
    jobcardNo:'',
    estimateNo:'',
    supplimentNo:'',
    invoiceNo:'',
    regNo:'',
    customerCode:'',
    date:'',
    estimateJobType:'',
    estimateType:''
  },
  methods:{
    addrow: function() {
      if(this.vrow.description !='' && this.vrow.jobtype !='' && this.vrow.qty !='' && this.vrow.discountmethod !='' && this.vrow.discountmethod !=0){
          this.vrow.total = this.totalcount;
          this.vrow.netamount = this.adddiscount;

          this.vgriddata.push(this.vrow);
          this.vrow = {jobtype:'',jobCode:'',description:'',qty:'',price:'',total:0,discount:0,discountval:0,discountmethod:1,timestamp:''};
          $('#jobtype').focus();
      } else {
         $.notify("Please check input fields", "warn");
      }
    },
    updaterow() {
      return this.vgriddata.forEach(function(itm, index) {
          if(index == app.updateKey && app.vrow.discountmethod !=0){
            console.log(app.vrow.discountmethod);
            itm.description = app.vrow.description;
            itm.jobtype = app.vrow.jobtype;
            itm.discountmethod = app.vrow.discountmethod;
            itm.discountval = app.vrow.discountval;
            itm.netamount = app.adddiscount;
            itm.price = app.vrow.price;
            itm.qty = app.vrow.qty;
            itm.total = app.totalcount;
            itm.jobCode = app.vrow.jobCode;

            app.vrow = {jobtype:'',jobCode:'',description:'',qty:'',price:'',total:0,discount:0,discountval:0,discountmethod:1,timestamp:''};
          $('#jobtype').focus();

            app.state = 'update';
            app.isUpdateRow = false;
            app.updateKey = null;
          }
      });
    },
    removeitem: function(index) {
      if (index > -1) {
        this.vgriddata.splice(index, 1)
      }
    },
    edititem(item,key) {
      if(item.discountmethod ==0){
        this.vrow.discountmethod = 1;
      }else {
        this.vrow.discountmethod = item.discountmethod;
      }
      app.updateKey = key;
      this.vrow.jobtype = item.jobtype;
      this.vrow.description = item.description;
      this.vrow.qty = item.qty;
      this.vrow.price = item.price;
      this.vrow.timestamp = item.timestamp;
      this.vrow.netamount = item.netamount;
      this.vrow.discountval = item.discountval;
      this.vrow.jobCode = item.jobCode;

      this.state = '';
      this.isUpdateRow = true;

    },
    printinvoice: function() {
      if(app.invoiceNo !=''){
        printinv(app.invoiceNo);
      }else {
        $.notify("Please Select Invoice Number To Print", "warn");
      }
     
    },
    saveinvoice: function() {
      $(this).attr('disabled', true);
      if(app.vgriddata.length > 0){
        $.ajax({
        url:'salesinvoice/saveinvoice',
        dataType:'json',
        type:'POST',
        data:{
          data: app.vgriddata,
                jobcardno:this.jobcardNo,
                estimateNo:this.estimateNo,
                estimateJobType:this.estimateJobType,
                estimateType:this.estimateType,
                invoiceNo:this.invoiceNo,
                regNo:this.regNo,
                customerCode:this.customerCode,
                date:this.date,
                supplimentNo:this.supplimentNo
              },
        success:function(data) {
          if(data.status == 1) {
            $(this).attr('disabled', false);
            printinv(data.invoice);

            app.vgriddata = [];
            app.jobcardNo = '';
            app.estimateNo= '';
            app.invoiceNo = '';
            app.regNo = '';
            app.customerCode = '';
            app.date = '';
            app.state = '';
            app.supplimentNo='';
          }
        }
      });
     } else {
      $.notify("Please Check Grid!", "error");
     }
      
    },
    updateinvoice: function() {
      if(app.vgriddata.length > 0) {
        if(this.invoiceNo == ''){
          this.saveinvoice();
        }else{
          $.ajax({
          url:'<?php echo base_url('admin') ?>/salesinvoice/updateinvoice',
          dataType:'json',
          type:'POST',
          data:{data: app.vgriddata,
                  jobcardno:this.jobcardNo,
                  estimateNo:this.estimateNo,
                  invoiceNo:this.invoiceNo,
                  regNo:this.regNo,
                  customerCode:this.customerCode,
                  date:this.date,
                  supplimentNo:this.supplimentNo},
          success:function(data) {
            if(data==1) {
              app.printinvoice();
              app.vgriddata = [];
              app.jobcardNo = '';
              app.estimateNo= '';
              app.invoiceNo = '';
              app.regNo = '';
              app.customerCode = '';
              app.date = '';
              app.state = '';
              app.supplimentNo='';
            }
          }
        });
        }
        
      } else {
        $.notify("Please Check Grid!", "error");
      }
      
    }
  },
  computed:{
    totalcount(){
      return this.vrow.price*this.vrow.qty
    },
    adddiscount(){
      if(this.vrow.discountmethod == 1){
          return (this.vrow.price*this.vrow.qty) - this.vrow.discountval;
      } else if(this.vrow.discountmethod == 2) {
          return (this.vrow.price*this.vrow.qty) - (this.vrow.price*this.vrow.qty*this.vrow.discountval/100);
      } else {
          return 0;
      }
      
    }
  },
  mounted() {
      var type = '<?php echo $type ?>';
      var id = '<?php echo $id; ?>';
      var sup = '<?php echo $sup; ?>';

      if(type == 'inv') {
         $.ajax({
          url: '<?php echo base_url('admin') ?>/salesinvoice/loadinvoicedetail2/'+id,
          dataType: 'json',
          success: function(data) {
              app.state = 'update';
              app.invoiceNo = data.JobInvNo;
              app.jobcardNo = data.jobcardNo;
              app.date = data.date;
              app.regNo = data.regNo;
              app.customerCode = data.customerCode; 
              app.vgriddata = data.detail;
              if(data.IsPayment==0){
                $("#btnPayment").show();
                var url ="payment/job_payment/"+Base64.encode(app.invoiceNo);
                $("#btnPayment").prop("disabled", false);
                $("#btnPayment").attr("href",url);
              }else{
                 $("#btnPayment").hide();
              }
              
          }
        });
      } else if(type == 'job') {
          $.ajax({
          url:'<?php echo base_url('admin') ?>/salesinvoice/loadjobonload/'+ id,
          dataType:'json',
          success: function(data) {
              app.jobcardNo = data.JobCardNo;
              app.estimateNo = data.JestimateNo;
              app.regNo = data.JRegNo;
              app.customerCode = data.JCustomer;
              app.state = 'save';
              $('#date').datepicker().datepicker("setDate", new Date());

          }
        });
      } else if(type == 'est') {

          $.ajax({
            url:'<?php echo base_url('admin') ?>/salesinvoice/loadestimatedetail2',
            data:{estno:id,suppno: sup},
            dataType: 'json',
            success: function(data) {
              $('#date').datepicker().datepicker("setDate", new Date());

              app.supplimentNo = sup;
              app.invoiceNo = data.JobInvNo;
              app.estimateNo = data.EstimateNo;
              app.estimateType = data.EstType;
              app.estimateJobType = data.EstJobType;
              app.jobcardNo = data.EstJobCardNo;
              app.regNo = data.EstRegNo;
              app.customerCode = data.EstCustomer; 
              app.vgriddata = data.detail;
              app.state = 'save';
              app.isUpdateRow = false;
            }
        });
      }
}

});

$('#date').datepicker({ autoclose: true, format: 'yyyy-mm-dd',todayBtn: "linked", });

$('#date').datepicker().datepicker("setDate", new Date());
$('#date').on('changeDate', function(){
    app.date = $(this).val();
});

$('#jobNo').autocomplete({
  autoFocus: true,
  minLength: 2,
  maxLength:3,
  source:function(request,response) {
    $.ajax({
        url: '<?php echo base_url('admin') ?>/salesinvoice/loadjobjson',
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
   select: function(event, ui) {
    app.jobcardNo = ui.item.value;

    app.vgriddata = [];
      $.ajax({
        url:'<?php echo base_url('admin') ?>/salesinvoice/loadjob/'+ ui.item.value,
        dataType:'json',
        success: function(data) {
          if(data == ''){

          } else {
            $('#date').datepicker().datepicker("setDate", new Date());
            app.estimateNo = data.JestimateNo;
            app.regNo = data.JRegNo;
            app.customerCode = data.JCustomer;
            app.state = 'save';
            app.isUpdateRow = false;
            app.date=app.date;
          }
        }
      });
    }
});

$('#description').autocomplete({
  autoFocus: true,
   minLength: 0,
  source:function(request,response) {
    $.ajax({
        url: '<?php echo base_url('admin') ?>/salesinvoice/loaddescription',
        dataType: "json",
        data: {q: request.term, jtype: app.$data.vrow.jobtype},
        success: function(data) {
            response($.map(data, function(item) {
                app.vrow.description =  item.text;
                return {label: item.text,value: item.text,data: item}
            }));
        }
    });
  },
  select: function(event, ui) {
      console.log(ui.item.data.id);
      app.vrow.jobCode = ui.item.data.id;
      app.vrow.description = ui.item.label;
      app.vrow.price = ui.item.data.price;
    }
});

$('#estimateNo').autocomplete({
  autoFocus:true,
  minLength: 0,
  source: function(request, response) {
    $.ajax({
      url: '<?php echo base_url('admin') ?>/salesinvoice/loadestimate',
      dataType: 'json',
      data: {q: request.term},
      success: function(data) {
        response($.map(data, function(item) {
          return {label: item.text,value: item.text,data: item}
        }));
      }
    });
  },
  select: function(event, ui) {
    if(app.supplimentNo==''){app.supplimentNo=0}
    $.ajax({
      url:'<?php echo base_url('admin') ?>/salesinvoice/loadestimatedetail',
      data:{estno:ui.item.value,supplimentNo:app.supplimentNo},
      dataType: 'json',
      success: function(data) {
        $('#date').datepicker().datepicker("setDate", new Date());

        app.invoiceNo = data.JobInvNo;
        app.estimateNo = data.EstimateNo;
        app.estimateType = data.EstType;
        app.estimateJobType = data.EstJobType;
        app.jobcardNo = data.EstJobCardNo;
        app.regNo = data.EstRegNo;
        app.customerCode = data.EstCustomer; 
        app.vgriddata = data.detail;
        app.state = 'save';
        app.isUpdateRow = false;
      }
    });
  }
});
$('#supplimentNo').autocomplete({
  minLength: 0,
  source: function (request,response) {
    $.ajax({
      url: '<?php echo base_url('admin') ?>/salesinvoice/loadsupplimentno',
      dataType: 'json',
      data: {q:request.term,estimate:app.estimateNo},
      success: function(data) {
        response($.map(data,function(item) {
          return {label: item.text,value: item.text,data: item}
        }));
      }
    });
  },select: function(event,ui) {
    app.supplimentNo = ui.item.value;
    $.ajax({
      url:'<?php echo base_url('admin') ?>/salesinvoice/loadestimatedetail',
      data:{estno:app.estimateNo,supplimentNo:app.supplimentNo},
      dataType: 'json',
      success: function(data) {
        $('#date').datepicker().datepicker("setDate", new Date());

        app.invoiceNo = data.JobInvNo;
        app.estimateNo = data.EstimateNo;
        app.jobcardNo = data.EstJobCardNo;
        app.regNo = data.EstRegNo;
        app.customerCode = data.EstCustomer; 
        app.vgriddata = data.detail;
        app.state = 'save';
        app.isUpdateRow = false;
      }
    });
  }
});


$('#invoiceNo').autocomplete({
  autoFocus: true,
  minLength: 0,
  source: function (request,response) {
    $.ajax({
      url: '<?php echo base_url('admin') ?>/salesinvoice/loadinvoicejson',
      dataType: 'json',
      data: {q:request.term},
      success: function(data) {
        response($.map(data,function(item) {
          return {label: item.text,value: item.text,data: item}
        }));
      }
    });
  },select: function(event,ui) {
    console.log(ui.item.label);
    $.ajax({
      url: '<?php echo base_url('admin') ?>/salesinvoice/loadinvoicedetail/'+ui.item.label,
      dataType: 'json',
      success: function(data) {
          app.state = 'update';
          app.invoiceNo = ui.item.label;
          app.jobcardNo = data.jobcardNo;
          app.estimateNo = data.JobEstimateNo;
          app.supplimentNo = data.JobSupplimentry;
          app.date = data.date;
          app.regNo = data.regNo;
          app.customerCode = data.customerCode; 
          app.vgriddata = data.detail;
          if(data.IsPayment==0){
                $("#btnPayment").show();
                var url ="payment/job_payment/"+Base64.encode(app.invoiceNo);
                $("#btnPayment").prop("disabled", false);
                $("#btnPayment").attr("href",url);
              }else{
                 $("#btnPayment").hide();
              }
          app.isUpdateRow = false;
      }
    });
  }
});

function printinv(invoice) {
  $.ajax({
        url:'salesinvoice/printinvoicecreate',
        dataType:'json',
        type:'POST',
        data:{invno:invoice},
        success:function(data) {
          var resultData = data;
          $("#tbl_est_data tbody").empty();
          $('#lblcusCode').html(resultData.head.JCustomer);
          $('#lblcusName').html(resultData.head.CusName);
          $('#lblinvDate').html(resultData.head.Date);
          $('#lblAddress').html(resultData.head.Address01);
          $('#lbltel').html(resultData.head.MobileNo);
          $('#lblmake').html(resultData.head.Make);
          $('#lblmodel').html(resultData.head.Model);
          $('#lblConName').html(resultData.head.contactName);
          $('#lblestimateNo').html(resultData.head.JobEstimateNo);
          $('#lblInvNo').html(resultData.head.JobInvNo);
          $('#lblviNo').html(resultData.head.ChassisNo);
          $('#lblregNo').html(resultData.head.RegNo);
          $('#totalAmount').html(accounting.formatMoney(resultData.head.JobTotalAmount));
          $('#totalDiscount').html(accounting.formatMoney(resultData.head.JobTotalDiscount));
          $('#netAmount').html(accounting.formatMoney(resultData.head.JobNetAmount-resultData.head.JobAdvance));
          $('#totalAdvance').html(accounting.formatMoney(resultData.head.JobAdvance));
          if(resultData.head.IsPayment==0){
                $("#btnPayment").show();
                var url ="payment/job_payment/"+Base64.encode(resultData.head.JobInvNo);
                $("#btnPayment").prop("disabled", false);
                $("#btnPayment").attr("href",url);
              }else{
                 $("#btnPayment").hide();
              }
          var k = 1;
                $.each(resultData.list, function(key, value) {
                    $("#tbl_est_data").append("<tr><td colspan='6' style='padding: 4px 3px 4px 50px;'><b>" + key + "</b></td></tr>");
                    for (var i = 0; i < value.length; i++) {  
                            $("#tbl_est_data tbody").append("<tr><td style='text-align:center;padding: 3px;'>" + (k) + "</td><td style='padding: 3px;'>" + value[i].JobDescription + "</td><td style='padding: 3px;'> </td><td style='text-align:right;padding: 3px;'>" + accounting.formatMoney(value[i].JobQty) + "</td><td  style='text-align:right;padding: 3px;'>" + accounting.formatMoney(value[i].JobPrice) + "</td><td  style='text-align:right;padding: 3px;'>" + accounting.formatMoney(value[i].JobNetAmount) + "</td></tr>");
                        k++;
                    }
                });

           setTimeout(function(){$('#printArea').focus().print();},1000);
        }
      });
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

            }
</script>
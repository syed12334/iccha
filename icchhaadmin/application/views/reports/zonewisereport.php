<?php 
      //  echo "<pre>";print_r($totalRevenue);exit;
 $revenue =array();


        //echo "<pre>";print_r($revenue);exit;
?>
<?= $header;?>

<!-- The Modal -->
  <div class="modal" id="viewdetails">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <div id="viewContact"></div>
        </div>
        
     
        
      </div>
    </div>
  </div>
<div class="page has-sidebar-left bg-light height-full">
 <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12">
                    <div class="card my-3 no-b">
                    <div class="card-body">

                        <div class="card-title">Zone Wise Reports</div>
                          <?php 
                            if($this->session->flashdata('message')) {
                                echo $this->session->flashdata('message');
                            }
                        ?>

                         <button class="btn btn-primary" onclick="exportexcel();" style="float: right;margin-bottom: 20px;margin-right: 20px"><i class="fa fa-download"></i> Export to Excel</button>

                 

                        <br /><br /><br />
                         <form id="propertyReports">
                   
                       
                            <div class="row">
                               <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>From Date</label>
                                        <input type="date" name="fdate" id="fdate" class="form-control" placeholder="Select From Date" required>
                                    </div>
                                </div>
                                 <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>From Date</label>
                                        <input type="date" name="tdate" id="tdate" class="form-control" placeholder="Select To Date" required>
                                    </div>
                                </div>
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Package</label>
                                        <select name="ptype" id="ptype" class="form-control">
                                            <option value="">Select Package</option>
                                            <?php
                                                 if(count($reportstotal)) {
                                                     foreach ($reportstotal as $type) {
                                                         ?>
                                                          <option value="<?= $type->id;?>"><?= $type->title.(" Rs. ".$type->pprice);?></option> 
                                                         <?php
                                                     }
                                                 }
                                            ?>
                                        </select>
                                    </div>
                                </div> 

                                 <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Zone </label>
                                        <select id="state" class="form-control" name="state">
                                            <option value="">Select Zone</option>
                                            <?php
                                             if(count($state)) {
                                                 foreach ($state as $value) {
                                                    ?>
                                                    <option value="<?= $value->id;?>"><?= $value->name;?></option>
                                                    <?php
                                                 }
                                             }
                                            ?>
                                        </select>
                                    </div>
                                </div>                  
                              
                                <div class="clearfix"></div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                   <center>   <button type="button" id="excel" onclick="reinitialsedata();" class="btn btn-primary ">Submit</button></center>
                                </div>
                               
                            </div>
                        </form>
                        <br />
                            <table id="category_table" class="table display table-bordered table-striped no-wrap" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Sl. No.</th>
                                        <th>Username</th>
                                        <th>Package Name</th>
                                        <th>State</th>
                                        <th>Amount</th>
                                       
                                        <th>Created Date</th>
                                                                              
                                    </tr>
                                </thead>
                                <tbody>
        
                                </tbody>
                            </table>
                            <br />
                            <div style="float: right;padding:10px;border:1px solid #000">

                              <?php
                                $revenue =[];
                                if(count($totalRevenue)) {
                                  foreach ($totalRevenue as $key => $value) {
                                    $revenue[] = $value->pprice;
                                  }
                                }
                              ?>
                                <h4 style="font-weight: bold">Total Revenue: <i class="fa fa-rupee-sign"></i><span id="totalReve"><?= " ".number_format(array_sum($revenue)); ?></span></h4>
                            </div>
                            <div class="clearfix"></div>
                            <br /><br />
                            
                         <button class="btn btn-primary" onclick="exportexcel();"   style="float: right;margin-bottom: 20px;margin-right: 20px"><i class="fa fa-download"></i> Export to Excel</button>

                  

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash()); ?>
<input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
<?= $footer;?>
<script type="text/javascript">

        $(document).ready(function() {
                $("#excel").on("click",function() {

                      var fdate = $("#fdate").val();
                    var tdate = $("#state").val();
                    var ptype = $("#ptype").val();
                    var tdate = $("#tdate").val();
                    $.ajax({
                        url :"<?= base_url().'reports/getTotalzonewise'; ?>",
                        method:"post",
                        dataType:"json",
                        data :{
                          state :state,
                          ptype:ptype,
                          tdate :tdate,
                          fdate :fdate,
                          "<?= $this->security->get_csrf_hash();?>":$(".csrf_token").val()
                        },
                        success:function(data) {
                          console.log(data);
                          if(data.status ==true) {
                            $("#totalReve").html(data.total);
                          }
                        }
                    });
                });
            });
            var dataTable, edit_data;
            function initialiseData(){
                dataTable = $('#category_table').DataTable({  
                    "scrollX":true,
                    "processing":true,  
                    "serverSide":true,
                    "order":[],
                    "ajax":{  
                        url:"<?=base_url().'reports/getzonewiseports'?>",  
                        type:"POST",
                        data: function(d){
                             d.form = $("#propertyReports").serializeArray();
                            <?php echo "d.".$csrf['name'];?> = $(".csrf_token").val();
                        },
                        error: function(){  // error handling
                            $(".user_data-error").html("");
                            $("#user_data").append('<tbody class="user_data-error"><tr><th colspan="12">No data found in the server</th></tr></tbody>');
                            $("#user_data_processing").css("display","none");
                        }
                    },
                      columnDefs:[  
                  {  
                       "targets":[1,2,3,4],  
                       "orderable":true,  
                  },  
                  {  
                       "targets":[0,5],  
                       "orderable":false,  
                  },
            ], 
            "drawCallback": function (response) {               
                var res = response.json;
                $(".csrf_token").val(res.csrf_token);
                $("#totalReve").html(response.json.total);
                
            }               
    }); 
            }

            $(document).ready(function(){ 
                initialiseData();
            });

            function reinitialsedata(){
                var dt = $("#category_table").DataTable();
                dt.ajax.reload(null, false);


                  
            }

               function exportexcel(){
               var fdate = $('#fdate').val();
               var tdate = $('#tdate').val();
                var ptype = $('#ptype').val();
                var state = $('#state').val();
               var base_url = '<?php echo base_url();?>';
               document.location.href =base_url+"reports/exportzonewisereport?fdate="+fdate+"&tdate="+tdate+"&ptype="+ptype+"&state="+state;
          }
    
         
    function viewCustomer(id) {

      //alert(id);
     
      $.ajax({
          url :"<?= base_url().'reports/viewcontacts'; ?>",
          method:"post",
          dataType:"json",
          data:{
            id:id,
            "<?= $this->security->get_csrf_token_name();?>":$('.csrf_token').val()
          },
          success:function(data) {
            if(data.status ==true) {
               $("#viewdetails").modal('show');
              $('.csrf_token').val(data.csrf_token);
              $("#viewContact").html(data.res);
            }else {
              $('.csrf_token').val(data.csrf_token);
            }
          }
      });
    }


</script>

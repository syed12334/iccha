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

                        <div class="card-title">Expiry Reports</div>
                          <?php 
                            if($this->session->flashdata('message')) {
                                echo $this->session->flashdata('message');
                            }
                        ?>
    <button class="btn btn-primary" onclick="exportexcel();" style="float: right;margin-bottom: 20px;margin-right: 20px"><i class="fa fa-download"></i> Export to Excel</button>

                        <br /><br /><br />
                         <form id="propertyReports">
                   
                       
                            <div class="row">
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>From Date</label>
                                        <input type="date" name="fdate" id="fdate" class="form-control" placeholder="Select From Date" required>
                                    </div>
                                </div>
                                 <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>From Date</label>
                                        <input type="date" name="tdate" id="tdate" class="form-control" placeholder="Select To Date" required>
                                    </div>
                                </div>
                                 <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group" style="margin-top: 28px">
                                        <button type="button" onclick="reinitialsedata();" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </form>
                        <br />
                            <table id="category_table" class="table display table-bordered table-striped no-wrap" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Sl. No.</th>
                                        <th>Customer Name</th>
                                         <th>Package Name</th>
                                        <th>Expired Date</th>
                                                                              
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <br /><br />
                         <button class="btn btn-primary" onclick="exportexcel();" style="float: right;margin-bottom: 20px;margin-right: 20px"><i class="fa fa-download"></i> Export to Excel</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $footer;?>
<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash()); ?>
<input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
<script type="text/javascript">
    var dataTable, edit_data;
            function initialiseData(){
                var fdate = $("#fdate").val();
                var tdate = $("#tdate").val();
                dataTable = $('#category_table').DataTable({  
                    "processing":true,  
                    "serverSide":true,  
                    "searching": true,
                    "order":[],  
                    "ajax":{  
                        url:"<?=base_url().'reports/getexpiryreports'?>",  
                        type:"POST",
                        data: function(d){
                             d.form = $("#propertyReports").serializeArray();
                            <?php echo "d.".$csrf['name'];?> = $(".csrf_token").val();
                        },
                        error: function(){  // error handling
                            $(".user_data-error").html("");
                            $("#user_data").append('<tbody class="user_data-error"><tr><th colspan="5">No data found in the server</th></tr></tbody>');
                            $("#user_data_processing").css("display","none");
                        }
                    },
                         columnDefs:[  
                  {  
                       "targets":[1,2,3],  
                       "orderable":true,  
                  },  
                  {  
                       "targets":[0],  
                       "orderable":false,  
                  },
            ], 
            "drawCallback": function (response) {               
                var res = response.json;
                $(".csrf_token").val(res.csrf_token);
                
            }
                }); 
            }
            initialiseData();

            function reinitialsedata(){
                var dt = $("#category_table").DataTable();
                dt.ajax.reload(null, false);
            }
       
  function exportexcel(){
               var fdate = $('#fdate').val();
               var tdate = $('#tdate').val();
               var ptype = $('#ptype').val();
               
               var base_url = '<?php echo base_url();?>';
               document.location.href =base_url+"reports/exportexpirereport?fdate="+fdate+"&tdate="+tdate;
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
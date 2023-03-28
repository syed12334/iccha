<?= $header;?>
<div class="page has-sidebar-left bg-light height-full">
 <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12">
                    <div class="card my-3 no-b">
                    <div class="card-body">

                        <div class="card-title">Site Visitors</div>
                      
                                          <table id="category_table" class="table display table-bordered table-striped no-wrap" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Sl. No.</th>
                                        <th>IP Address</th>
                    <th>No of Time Visited</th>
                    <th>Visited On</th>
                                                                              
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            

                 

                      

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
                        url:"<?=base_url().'reports/getVisitors'?>",  
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
                    },     columnDefs:[  
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
               document.location.href =base_url+"reports/exportpropertyreport?fdate="+fdate+"&tdate="+tdate+"&ptype="+ptype+"";
          }
</script>
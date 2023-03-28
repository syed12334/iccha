<?= $header;?>
<div class="page has-sidebar-left bg-light height-full">
 <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12">
                    <div class="card my-3 no-b">
                    <div class="card-body">

                        <div class="card-title">Newsletter</div>
                      
                            <table id="category_table" class="table display table-bordered table-striped no-wrap" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Sl. No.</th>
                                        <th>Subscribed Email</th>
                                        <th>Created Date</th>                                       
                                                                            
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
<?= $footer;?>
<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash()); ?>
<input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
<script type="text/javascript">
 

                var dataTable;
    function initialiseData(){
        $("#category_table").dataTable().fnDestroy();
        dataTable = $('#category_table').DataTable( {
            "processing":true,  
            "serverSide":true,  
            "searching": true, 
            "ajax":{  
                  url:"<?=base_url().'master/getNewletter'?>",  
                  type:"POST",
                  data: function(d){
                      d.forPost    = 1;
                     <?php echo "d.".$csrf['name'];?> = $(".csrf_token").val();
                  },
                  error: function(){  
                        $(".tbl-error").html("");
                        $("#tbl").append('<tbody class="tbl-error"><tr class="row><th colspan="11">No data found in the server</th></tr></tbody>');
                  }
             },          
             columnDefs:[  
                  {  
                       "targets":[1,2],  
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
        } );
    }

    $(document).ready(function() {
        initialiseData();
    });
                function updateStatus(id,status){
                       var postdata = { id : id,status : status,"<?= $this->security->get_csrf_token_name();?>": $(".csrf_token").val() } ;
                        //console.log( postdata );
                        $.ajax({                        
                            url: "<?=base_url().'master/settestimonialStatus'?>",
                            type: "post",
                            data:  postdata ,
                            dataType : 'json',
                            success: function (response) {
                                $(".csrf_token").val(response.csrf_token);
                                if(response.status == 1){
                                    //reinitialsedata();
                                    $(".csrf_token").val(response.csrf_token);
                                    dataTable.ajax.reload( null, false ); 
                                }else{
                                    $(".csrf_token").val(response.csrf_token);
                                    dataTable.ajax.reload( null, false );
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                               console.log();
                            }
                        });
            }
</script>
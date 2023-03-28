<?= $header;?>
<style type="text/css">
    input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
input[type=number] {
  -moz-appearance: textfield;
}
</style>
<div class="page has-sidebar-left bg-light height-full">
 <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12">
                    <div class="card my-3 no-b">
                    <div class="card-body">

                        <div class="card-title">Products</div>
                          <?php 
                            if($this->session->flashdata('message')) {
                                echo $this->session->flashdata('message');
                            }
                        ?>
                         <button class="btn btn-default" style="float: right;margin-left: 10px;" onclick="exportproducts();"><i class="fas fa-download" style="margin-right: 5px"></i> Export Products</button>
                          <button class="btn btn-info" data-toggle="modal" data-target="#productModal" style="float: right;margin-left: 10px;"><i class="fas fa-upload" style="margin-right: 5px"></i> Upload Products</button>

                        <a class="btn btn-success" href="<?= base_url().'productsadd';?>" style="float: right;margin-bottom: 20px;margin-right: 20px"><i class="fa fa-plus"></i> Add Products</a>
                        <br /><br /><br />
                            <table id="category_table" class="table display table-bordered table-striped no-wrap" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Sl. No.</th>
                                        <th>Action</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Pcode</th>
                                        <th>Stock</th>
                   
                                                                            
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
                  url:"<?=base_url().'master/getProducts'?>",  
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
                            url: "<?=base_url().'master/setproductsStatus'?>",
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
  $(document).ready(function() {
            $("#productForm").on("submit",function(e) {
            e.preventDefault();
              var formdata =new FormData(this);
              $.ajax({
                  url :"<?= base_url().'excelimport/saveProducts';?>",
                  method :"post",
                  dataType:"json",
                  data :formdata,
                  contentType: false,
                    cache: false,
                    processData:false,
                    success:function(data) {
                    if(data.formerror ==false) {
                      $(".csrf_token").val(data.csrf_token);
                      if(data.type_error !='') {
                        $("#file_error").html(data.file_error);
                      }else {
                        $("#file_error").html('');
                      }
                      $("#brandSubmit").prop('disabled',false);
                    }
                    else if(data.status ==false) {
                      $(".csrf_token").val(data.csrf_token);
                      $("#processing").html('<div class="alert alert-danger alert-dismissible" style="font-size: 15px!important"><i class="fas fa-ban"></i> '+data.msg+'</div>').show();
                      $("#brandSubmit").prop('disabled',false);
                    }
                    else if(data.status ==true) {
                       $(".csrf_token").val(data.csrf_token);
                       $("#file_error").html('');
                       $("#processing").html('<div class="alert alert-success alert-dismissible"><i class="fas fa-circle-check"></i> '+data.msg+'</div>');
                        setTimeout(function() {window.location.href="<?= base_url().'products';?>";}, 1000);
                    }
                  }
              });
          });

            // $(document).on('click','#viewDetails',function(e) {
            //     e.preventDefault();
            //     var id = $(this).data('id');
            //     $.ajax({
            //         url:"<?= base_url().'master/productViewdetails'; ?>",
            //         method :"post",
            //         data:{
            //           id:id,"<?= $this->security->get_csrf_token_name();?>": $(".csrf_token").val()
            //         },
            //         dataType :"json",
            //         cache :false,
            //         success:function(data) {
            //           if(data.status =true) {
            //             $("#productDetails").modal('show');
            //             $("#productsViewpage").append(data.msg);
            //           }
            //         }
            //     });
            // });
        });
  
       function exportproducts(){
               var base_url = "<?= base_url();?>";
               document.location.href =base_url+"reports/exportproducts";
          }
</script>
<div class="modal fade" id="productModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Upload Products</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <div id="processing"></div>
          <form id="productForm" method="post" enctype="multipart/form-data">
            <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
              <div class="form-group">
                  <label>Select file <font style="color:red">* (Only .xlsx,.csv are allowed)</font></label>
                  <input type="file" name="products" id="products" class="form-control">
                  <span id="file_error" class="text-danger"></span>
              </div>
              <button type="submit" id="brandSubmit" class="btn btn-primary">Submit</button>
              <a href="<?= app_asset_url().'formats/products.xlsx';?>" class="btn btn-success" style="margin-left: 4px"><i class="fas fa-download" style="margin-right: 6px"></i> Download Products Format</a>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="productDetails">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Product Details</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
           <div id="productsViewpage"></div>
          
        </div>
      </div>
    </div>
  </div>
<?php 
        //echo "<pre>";print_r($reportstotal);exit;
 $revenue =array();
        if(count($reportstotal)) {
            foreach ($reportstotal as $row) {
                         $id = $row->id;
              $properties = $this->master_db->getRecords('properties',['pid'=>$id],'*');
              $owner = $this->master_db->getRecords('owner_address',['pid'=>$id],'*');
             // echo $this->db->last_query();

              $count = "";
           if(!empty($properties) && $properties !="0") {
              $count .=count($properties);
           }

           if(!empty($owner) && $owner !="0") {
            $count .=count($owner);
           }
           $revenueGen = (int)$row->pprice * (int)$count;
          
           if(!empty($revenueGen) && $revenueGen !="0") {
              $revenue[]=(int)$row->pprice * (int)$count;
           }


            }
        }

        //echo "<pre>";print_r($revenue);exit;
?>
<?= $header;?>

<div class="page has-sidebar-left bg-light height-full">
 <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12">
                    <div class="card my-3 no-b">
                    <div class="card-body">

                        <div class="card-title">Revenue Reports</div>
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
                                        <label>Package Type</label>
                                        <select name="ptype" id="ptype" class="form-control">
                                            <option value="">Select PackageType</option>
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
                                    <div class="form-group" style="margin-top: 28px">
                                        <button type="button" id="excel"  onclick="reinitialsedata();" class="btn btn-primary">Submit</button>
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
                                        <th>Package Name</th>
                                         <th>Total Customer Subscribed</th>
                                        <th>Revenue</th>
                                        <th>Package Created Date</th>
                                                                              
                                    </tr>
                                </thead>
                                <tbody>
        
                                </tbody>
                            </table>
                            <br />
                            <div style="float: right;padding:10px;border:1px solid #000">
                                <h4 style="font-weight: bold">Total Revenue: <i class="fa fa-rupee-sign"></i><span id="totalReve"><?= " ".number_format(array_sum($revenue)); ?></span></h4>
                            </div>
                            <div class="clearfix"></div>
                            <br /><br />
                            
                         <button class="btn btn-primary" onclick="exportexcel();"   style="float: right;margin-bottom: 20px;margin-right: 20px"><i class="fa fa-download"></i> Export to Excel</button>


                       <!--    <br />
                            <table id="category_table" class="table display table-bordered table-striped no-wrap" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Sl. No.</th>
                                        <th>Package Name</th>
                                         <th>Total Customer Subscribed</th>
                                        <th>Revenue</th>
                                        <th>Package Created Date</th>
                                                                              
                                    </tr>
                                </thead>
                                <tbody>
        
                                </tbody>
                            </table> -->

                  

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
                dataTable = $('#category_table').DataTable({  
                    "scrollX":true,
                    "processing":true,  
                    "serverSide":true,
                    "order":[],
                    "ajax":{  
                        url:"<?=base_url().'reports/getrevenuereports'?>",  
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
                       "targets":[1,2,3],  
                       "orderable":true,  
                  },  
                  {  
                       "targets":[0,4],  
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
               var base_url = '<?php echo base_url();?>';
               document.location.href =base_url+"reports/exportrevenuereport?fdate="+fdate+"&tdate="+tdate+"&ptype="+ptype;
          }
    
                function updateStatus(id,status){
                       var postdata = { id : id,status : status } ;
                        //console.log( postdata );
                        $.ajax({                        
                            url: "<?=base_url().'master/setSubscribeStatus'?>",
                            type: "post",
                            data:  postdata ,
                            dataType : 'json',
                            success: function (response) {
                                //console.log(response);
                                if(response == '1'){
                                    //reinitialsedata();
                                    dataTable.ajax.reload( null, false ); 
                                }else{
                                    
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                               console.log();
                            }
                        });
            }

            $(document).ready(function() {
                $("#excel").on("click",function(e) {
                    e.preventDefault();
                    var fdate = $("#fdate").val();
                    var tdate = $("#tdate").val();
                    var ptype = $("#ptype").val();
                    $.ajax({
                        url :"<?= base_url().'reports/getTotalrevenue'; ?>",
                        method:"post",
                        dataType:"json",
                        data :{
                          fdate :fdate,
                          tdate :tdate,
                          ptype:ptype,
                          "<?= $this->security->get_csrf_token_name();?>" :$(".csrf_token").val()
                        },
                        success:function(data) {
                          if(data.status ==true) {
                            $(".csrf_token").val(data.csrf_token);
                            $("#totalReve").html(data.total);
                          }
                        }
                    });

                });
            });


</script>
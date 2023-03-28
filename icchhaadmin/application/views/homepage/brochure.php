<?= $header;?>
<style type="text/css">
  #file-error {
    color:red;
  }
 
</style>
<div class="page has-sidebar-left bg-light height-full">
 <div class="container-fluid my-3">
        <div class="row">
         
                    <div class="card my-3 no-b" style="width:100%">
                    <div class="card-body">
                         <div class="card-title">Brochure PDF</div>
                        <?php
                              if($this->session->flashdata('message')) {
                                echo $this->session->flashdata('message');
                              }
                            ?>
                               <form id="subscription" action="<?= base_url().'master/brochuresave';?>" method="post" style="margin-top:40px" enctype="multipart/form-data">
                                  <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                                <div class="row">
     

<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
          <div class="form-group">
                            <label>PDF File <span style="color:red">*</span></label>
                               <input type="file" name="file" id="file" class="form-control"  required>
                           </div>    

                           <?php
                              if(count($brochure) >0 && is_array($brochure)) {
                                if(!empty($brochure[0]->pdf) && $brochure[0]->pdf !="") {
                                    ?>
                                    <a href="<?= app_asset_url().$brochure[0]->pdf;?>" download><img src="<?= app_asset_url().'images/pdf.png';?>" style="width:80px"></a>
                                  <?php
                                }
                                
                              }
                           ?>              
</div>
<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"></div>
<div class="clearfix"></div>

                           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            
                             <button class="btn btn-primary" type="submit" id="submit">Submit</button>
                           </div>
                           </div>
                       </form>
                      
                    </div>
                </div>
          
        </div>
    </div>
</div>
<?= $footer;?>


<script type="text/javascript">
  $(document).ready(function() {
     
      $("#subscription").validate({
            rules: {
                file: {
                     required: true,
                  
                },
  
            },
            messages: {
                file: "Please upload pdf file",
                
            },
              
        });
              
            });
</script>
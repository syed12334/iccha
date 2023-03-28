<?php //echo "<pre>";print_r($property);exit;?>
<?= $header;?>
<style type="text/css">
  #title-error {
    color:red;
  }
</style>
<div class="page has-sidebar-left bg-light height-full">
 <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12">
                    <div class="card my-3 no-b">
                    <div class="card-body">
                  <div class="card-title">Shipping Policy</div>
                           
                            <?php
                              if($this->session->flashdata('message')) {
                                echo $this->session->flashdata('message');
                              }
                            ?>    
                               <form action="<?= base_url().'master/shippingsave';?>" method="post" style="margin-top:40px">
<input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                         

                           <div class="form-group">
                               <textarea class="form-control commontexteditor" name="content" placeholder="Enter About us"><?php if(is_array($shippingpolicy)) {echo $shippingpolicy[0]->shippolicy;} ?></textarea>
                           </div>

                            

                           <center>
                             <button class="btn btn-primary" type="submit" id="submit">Submit</button>
                           </center>
                           
                       </form>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $footer;?>


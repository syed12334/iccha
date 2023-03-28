<?php //echo "<pre>";print_r($property);exit;?>
<?= $header;?>
<style type="text/css">
  #title-error {
    color:red;
  }
    #content-error {
    color:red;
  }
</style>
<div class="page has-sidebar-left bg-light height-full">
 <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12">
                    <div class="card my-3 no-b">
                    <div class="card-body">
                           <?php 
                        if(!empty($faq) && is_array($faq)) {
                            ?>
                            <div class="card-title">Edit FAQ</div>
                            <?php
                        }else {
                           ?>
                            <div class="card-title">Add FAQ</div>
                            <?php
                        }
                      ?>
                                    <?php
                               if(!empty($faq)) {
                            ?>
                                 <form action="" id="category" method="post" style="margin-top:40px">
                                  <input type="hidden" name="id" id="pid" value="<?= $faq[0]->id;?>">
                     <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                           <div class="form-group">
                            <label>Title <span style="color:red">*</span></label>
                               <input type="text" name="title" id="title" class="form-control" placeholder="Enter Title" value="<?= $faq[0]->title;?>">
                           </div>
</div>
<div class="col-xs-12 col-sm-6 col-lg-6 col-md-6"></div>
<div class="clearfix"></div>
                            
                         <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
                           <div class="form-group">
                             <label>Description</label>
                             <textarea class="form-control commontexteditor" name="content" id="content" placeholder="Enter Description"><?= $faq[0]->fdesc;?></textarea>
                           </div>
                         </div>
                         <div class="clearfix"></div>
                             <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                               <button class="btn btn-primary" type="submit" id="submit">Submit</button>
                             </div>
                             <div class="clearfix"></div>
                          </div> 
                       </form>
                            <?php
                          }else {
                            ?>
                               <form action="" id="category" method="post" style="margin-top:40px">
                                                                  <input type="hidden" name="id" id="pid" value="">
<input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                         
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                           <div class="form-group">
                            <label>Title <span style="color:red">*</span></label>
                               <input type="text" name="title" id="title" class="form-control" placeholder="Enter Title">
                           </div>
</div>
            <div class="col-xs-12 col-sm-6 col-lg-6 col-md-6"></div>
<div class="clearfix"></div>                
                         <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
                           <div class="form-group">
                             <label>Description</label>
                             <textarea class="form-control commontexteditor" name="content" id="content" placeholder="Enter Description"></textarea>
                           </div>
                         </div>
                         <div class="clearfix"></div>
                             <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                               <button class="btn btn-primary" type="submit" id="submit">Submit</button>
                             </div>
                             <div class="clearfix"></div>
                          </div> 
                       </form>
                            <?php
                          }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $footer;?>


<script type="text/javascript">
  $(document).ready(function() {
     
      $("#category").validate({
            rules: {
                title: {
                    required: true,
                    minlength: 3,
                     maxlength:100,
                     
                },
               
            },
            messages: {
                title: "Title must be 3 to 100 characters long",
            },
              submitHandler: function (form) {
                  var title = $("#title").val();
                  var content = $("#content").val();
                  var id = $("#pid").val();
                  //console.log(form);
                    $.ajax({
                        url :"<?= base_url().'master/faqsave';?>",
                        method:"post",
                        dataType:"json",
                        data :{
                          id:id,
                          title :title,
                          content:content,
                          "<?= $this->security->get_csrf_token_name();?>": $(".csrf_token").val()
                        },
                        beforeSend:function() {
                          $("#submit").prop('disabled',true);
                          $("#submit").text('Submitting please wait');
                        },
                        success:function(data) {
                            if(data.status ==true) {
                              $(".csrf_token").val(data.csrf_token);
                               window.location.href="<?= base_url().'faq';?>";
                            }else if(data.status ==false) {
                               $(".csrf_token").val(data.csrf_token);
                               $("#message").html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+'</div>');
                                
                            }
                        }   
                    });
         }
        });
              
            });
</script>
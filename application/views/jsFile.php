<script type="text/javascript">
	$(document).on("click",".btn-cart",function(e) {
		e.preventDefault();
		var id = $(this).data('pid');
		var datid = $(this).data('id');
    var colors = $("#colors").val();
    var sizes = $("#sizes").val();
		if(id !="") {
			$.ajax({
				url :"<?= base_url().'Cart/addtocart'; ?>",
				method :"post",
				cache:false,
				dataType:"json",
				data : {id :id,colors:colors,sizes :sizes},
				success:function(data) {
					if(data.status == true) {
						$(".csrf_token").val(data.csrf_token);
						$(".cart-dropdown").addClass('opened');
						$("#appendProducts").html(data.msg);
						$(".cart-count").html(data.count);
						$(".price").html('<i class="fas fa-rupee-sign" style="margin-right: 5px"></i>'+data.subtotal);
					}else if(data.status ==false) {
						$(".csrf_token").val(data.csrf_token);
					}
				}
			});
		}
	});

  $(document).on("click",".btn-cartbtn",function(e) {
    e.preventDefault();
    var id = $(this).data('pid');
    var datid = $(this).data('id');
    var size = $("#sizes").val();
    var colors = $("#colors").val();
    var sizes = $("#sizes").val();
    if(size =='') {
        $('#size_error').html('<p style="color:#ef3434;font-size:14px">Please select size</p>');
        return false;
    }else {
         if(id !="") {
          $.ajax({
            url :"<?= base_url().'Cart/addtocart'; ?>",
            method :"post",
            cache:false,
            dataType:"json",
            data : {id :id,colors:colors,sizes :sizes},
            success:function(data) {
              if(data.status == true) {
                $(".csrf_token").val(data.csrf_token);
                $(".cart-dropdown").addClass('opened');
                $("#appendProducts").html(data.msg);
                $(".cart-count").html(data.count);
                $(".price").html('<i class="fas fa-rupee-sign" style="margin-right: 5px"></i>'+data.subtotal);
                $('#size_error').html('');
              }else if(data.status ==false) {
                $(".csrf_token").val(data.csrf_token);
                $('#size_error').html('');
              }
            }
          });
        }
    }

   
  });
  $(document).on("click",".size",function(e) {
      e.preventDefault();
      var size = $(this).data('sid');
      $("#sizes").val(size);
  });
  $(document).on("click",".color",function(e) {
      e.preventDefault();
      var color = $(this).data('coid');
      $("#colors").val(color);
  });
 
	function removeCart(id,pre) {
		$.ajax({
			url :"<?= base_url().'Cart/removeCartitem';?>",
			method :"post",
			cache:false,
			dataType:"json",
			data : {
				id:id,
				pre:pre
			},
			success:function(data) {
				if(data.status ==true) {
					$("#appendProducts").html(data.msg);
          if(pre ==2) {
            location.reload();
          }
					$(".cart-count").html(data.count);
					$(".csrf_token").val(data.csrf_token);
					$(".price").html('<i class="fas fa-rupee-sign" style="margin-right: 5px"></i>'+data.subtotal);
				}
				else if(data.status ==false) {
					$("#appendProducts").html(data.msg);
					$(".csrf_token").val(data.csrf_token);
				}
			}
		});
	}
	function updateCart(id) {
		var qty = $("#qty"+id).val();
		$.ajax({
			url:"<?= base_url().'Cart/updateCart';?>",
			method:"post",
			cache:false,
			dataType:"json",
			data:{
				rowid :id,
				qty :qty
			},
			success:function(data) {
				if(data.status ==true) {
					$(".products").html(data.msg);
				}
			}
		});
	}
	function addqty(id) {
        var result = document.getElementById('qty' + id);
        var qty = result.value;
        if (!isNaN(qty)) {
            result.value++;
        }
        updateCart(id);
        return true;
    }
     function reduceqty(id) {
        var result = document.getElementById('qty' + id);
        var qty = result.value;
        if (!isNaN(qty) && qty > 1) {
            result.value--;
        }
        updateCart(id);
        return true;
    }
   $("#couponsubmit").on("submit",function(e) {
    e.preventDefault();
      var formdata =new FormData(this);
      $.ajax({
          url :"<?= base_url().'Cart/couponList';?>",
          method :"post",
          dataType:"json",
          data :formdata,
          contentType: false,
            cache: false,
            processData:false,
            success:function(data) {
            if(data.formerror ==false) {
              $(".csrf_token").val(data.csrf_token);
              if(data.coupon_error !='') {
                $("#coupon_error").html(data.coupon_error);
              }else {
                $("#coupon_error").html('');
              }
            }
            else if(data.status ==false) {
              $(".csrf_token").val(data.csrf_token);
              $("#processing").html('<div class="alert alert-danger alert-dismissible"><i class="fas fa-ban"></i> '+data.msg+'</div>').show().fadeOut(3000);
              $("#prosubmit").prop('disabled',false);
            }
            else if(data.status ==true) {
               $("#coupon_error").html('');
                $("#discount").show();
                $("#disamount").html('<p>Discount : '+data.discount+'%</p>');
                $("#totalAmount").html(data.total);
                 $("#couponsubmit")[0].reset();
                 $("#processing").html('<div class="alert alert-success alert-dismissible">Coupon applied</div>').show().fadeOut(2000);
            }
          }
      });
  });

$(document).ready(function(){
  $("#checkoutCoupon").on("click",function(e) {
      e.preventDefault();
      var formdata =$("#couponcode").val();
      $.ajax({
          url :"<?= base_url().'Cart/couponList';?>",
          method :"post",
          dataType:"json",
          data :{
            couponcode:formdata
          },
            success:function(data) {
            if(data.formerror ==false) {
              if(data.coupon_error !='') {
                $("#coupon_error").html(data.coupon_error);
              }else {
                $("#coupon_error").html('');
              }
            }
            else if(data.status ==false) {
              $("#coupon_error").html('<div class="alert alert-danger alert-dismissible"><i class="fas fa-ban"></i> '+data.msg+'</div>').show().fadeOut(3000);
            }
            else if(data.status ==true) {
               $("#coupon_error").html('');
                $("#discount").show();
                $("#disamount").html('<b>'+data.discount+'%</b>');
                $("#totalAmount").html(data.total);
                $("#couponcode").val('');
            }
          }
      });
  });
  $("#register").on("submit",function(e) {
    e.preventDefault();
      var formdata =new FormData(this);
      $.ajax({
          url :"<?= base_url().'Login/registerSave';?>",
          method :"post",
          dataType:"json",
          data :formdata,
          contentType: false,
            cache: false,
            processData:false,
            success:function(data) {
            if(data.formerror ==false) {
              $(".csrf_token").val(data.csrf_token);
              if(data.name_error !='') {
                $("#name_error").html(data.name_error);
                $("#name").addClass('inputborders');
              }else {
                $("#name_error").html('');
                $("#name").removeClass('inputborders');
              }
              if(data.email_error !='') {
                $("#email_error").html(data.email_error);
                $("#emailid").addClass('inputborders');
              }else {
                $("#email_error").html('');
                $("#emailid").removeClass('inputborders');
              }
               if(data.phone_error !='') {
                $("#phone_error").html(data.phone_error);
                $("#phone").addClass('inputborders');
              }else {
                $("#phone_error").html('');
                $("#phone").removeClass('inputborders');
              }
               if(data.password_error !='') {
                $("#password_error").html(data.password_error);
                $("#password").addClass('inputborders');
              }else {
                $("#password_error").html('');
                $("#password").removeClass('inputborders');
              }
               if(data.cpassword_error !='') {
                $("#cpassword_error").html(data.cpassword_error);
                $("#cpassword").addClass('inputborders');
              }else {
                $("#cpassword_error").html('');
                $("#cpassword").removeClass('inputborders');
              }
            }
            else if(data.status ==false) {
              $(".csrf_token").val(data.csrf_token);
              $("#processing").html('<div class="alert alert-danger alert-dismissible"><i class="fas fa-ban"></i> '+data.msg+'</div>').show().fadeOut(3500);
            }
            else if(data.status ==true) {
               $(".csrf_token").val(data.csrf_token);
               $("#name_error").html('');
               $("#email_error").html('');
               $("#phone_error").html('');
               $("#password_error").html('');
               $("#name").removeClass('inputborders');
               $("#password").removeClass('inputborders');
               $("#cpassword").removeClass('inputborders');
               $("#phone").removeClass('inputborders');
               $("#emailid").removeClass('inputborders');
               $("#cpassword_error").html('');
               $("#processing").html('<div class="alert alert-success alert-dismissible"><i class="fas fa-circle-check"></i> '+data.msg+'</div>').fadeOut(3000);
               $("#register")[0].reset();
               setTimeout(function() {window.location.href="<?= base_url().'otp';?>"}, 2400);
            }
          }
      });
  });


   $("#saveProfile").on("submit",function(e) {
    e.preventDefault();
      var formdata =new FormData(this);
      $.ajax({
          url :"<?= base_url().'Login/updateProfile';?>",
          method :"post",
          dataType:"json",
          data :formdata,
          contentType: false,
            cache: false,
            processData:false,
            success:function(data) {
            if(data.formerror ==false) {
              $(".csrf_token").val(data.csrf_token);
              if(data.name_error !='') {
                $("#name_error").html(data.name_error);
                $("#name").addClass('inputborders');
              }else {
                $("#name_error").html('');
                $("#name").removeClass('inputborders');
              }
              if(data.email_error !='') {
                $("#email_error").html(data.email_error);
                $("#emailid").addClass('inputborders');
              }else {
                $("#email_error").html('');
                $("#emailid").removeClass('inputborders');
              }
               if(data.phone_error !='') {
                $("#phone_error").html(data.phone_error);
                $("#phone").addClass('inputborders');
              }else {
                $("#phone_error").html('');
                $("#phone").removeClass('inputborders');
              }
               if(data.password_error !='') {
                $("#password_error").html(data.password_error);
                $("#password").addClass('inputborders');
              }else {
                $("#password_error").html('');
                $("#password").removeClass('inputborders');
              }
               if(data.cpassword_error !='') {
                $("#cpassword_error").html(data.cpassword_error);
                $("#cpassword").addClass('inputborders');
              }else {
                $("#cpassword_error").html('');
                $("#cpassword").removeClass('inputborders');
              }
            }
            else if(data.status ==false) {
              $(".csrf_token").val(data.csrf_token);
              $("#processing").html('<div class="alert alert-danger alert-dismissible"><i class="fas fa-ban"></i> '+data.msg+'</div>').show().fadeOut(3500);
            }
            else if(data.status ==true) {
               $(".csrf_token").val(data.csrf_token);
               $("#name_error").html('');
               $("#email_error").html('');
               $("#phone_error").html('');
               $("#password_error").html('');
               $("#name").removeClass('inputborders');
               $("#password").removeClass('inputborders');
               $("#cpassword").removeClass('inputborders');
               $("#phone").removeClass('inputborders');
               $("#emailid").removeClass('inputborders');
               $("#cpassword_error").html('');
               $("#processing").html('<div class="alert alert-success alert-dismissible"><i class="fas fa-circle-check"></i> '+data.msg+'</div>').fadeOut(3000);
            }
          }
      });
  });


  $(document).on("click","#removeWishlist",function(e) {
      e.preventDefault();
      var pid = $(this).data('pids');
      $.ajax({
        url :"<?= base_url().'My_account/removeWishlist';?>",
        method :"post",
        dataType :"json",
        cache :false,
        data :{
          pid :pid
        },
        success:function(data) {
          if(data.status==true) {
            $("#removeTable"+pid).fadeOut(500, function () { $("#removeTable"+pid).remove(); });
          }
          
        }
      })
  });

   $("#otp").on("submit",function(e) {
    e.preventDefault();
      var formdata =new FormData(this);
      $.ajax({
          url :"<?= base_url().'Login/verifyotp';?>",
          method :"post",
          dataType:"json",
          data :formdata,
          contentType: false,
            cache: false,
            processData:false,
            success:function(data) {
            if(data.formerror ==false) {
              $(".csrf_token").val(data.csrf_token);
              if(data.otp_error !='') {
                $("#otp_error").html(data.otp_error);
                $("#otpval").addClass('inputborders');
              }else {
                $("#otp_error").html('');
                $("#otpval").removeClass('inputborders');
              }
            }
            else if(data.status ==false) {
              $(".csrf_token").val(data.csrf_token);
              $("#processing").html('<div class="alert alert-danger alert-dismissible"><i class="fas fa-ban"></i> '+data.msg+'</div>').show().fadeOut(3500);
            }
            else if(data.status ==true) {
               $(".csrf_token").val(data.csrf_token);
               $("#name_error").html('');
               $("#otpval").removeClass('inputborders');
               $("#processing").html('<div class="alert alert-success alert-dismissible"><i class="fas fa-circle-check"></i> '+data.msg+'</div>').fadeOut(3000);
               $("#otp")[0].reset();
               <?php
                if($this->session->userdata('urlredirect')) {
                  ?>
                    setTimeout(function() {window.location.href="<?= base_url().$this->session->userdata('urlredirect');?>"}, 2400);
                  <?php
                }else {
                  ?>
                  setTimeout(function() {window.location.href="<?= base_url();?>"}, 2400);
                  <?php
                }
               ?>
               
            }
          }
      });
  });

   $("#login").on("submit",function(e) {
    e.preventDefault();
      var formdata =new FormData(this);
      $.ajax({
          url :"<?= base_url().'Login/loginsave';?>",
          method :"post",
          dataType:"json",
          data :formdata,
          contentType: false,
            cache: false,
            processData:false,
            success:function(data) {
            if(data.formerror ==false) {
              $(".csrf_token").val(data.csrf_token);
              if(data.email_error !='') {
                $("#emails_error").html(data.email_error);
                $("#email").addClass('inputborders');
              }else {
                $("#emails_error").html('');
                $("#email").removeClass('inputborders');
              }
            }
            else if(data.status ==false) {
              $(".csrf_token").val(data.csrf_token);
              $("#processing").html('<div class="alert alert-danger alert-dismissible"><i class="fas fa-ban"></i> '+data.msg+'</div>').show().fadeOut(3500);
            }
            else if(data.status ==true) {
               $(".csrf_token").val(data.csrf_token);
               $("#email_error").html('');
               $("#processing").html('<div class="alert alert-success alert-dismissible"><i class="fas fa-circle-check"></i> '+data.msg+'</div>').fadeOut(3000);
               $("#email").removeClass('inputborders');
               $("#login")[0].reset();
               setTimeout(function() {window.location.href="<?= base_url().'otp';?>"}, 2400);
            }
          }
      });
  });

   $("#cpincode").on("keyup",function(e) {
    e.preventDefault();
      $.ajax({
          url :"<?= base_url().'Home/checkpincode';?>",
          method :"post",
          dataType:"json",
          data :{
            cpincode : $(this).val()
          },
       
            success:function(data) {
            if(data.formerror ==false) {
              if(data.pincode_error !='') {
                $("#pincode_error").html(data.pincode_error).addClass('text-danger');
                $("#cpincode").addClass('inputborders');
                $("#showMsg").html('');
              }else {
                $("#pincode_error").html('');
                $("#cpincode").removeClass('inputborders');
              }
            }
            else if(data.status ==false) {
              $("#pincode_error").show().html(data.msg);
              $("#showMsg").html('');
            }
            else if(data.status ==true) {
                $("#pincode_error").html('');
               $("#showMsg").html('<i class="fas fa-circle-check"></i> '+data.msg+'');
               $("#cpincode").removeClass('inputborders');
              
            }
          }
      });
  });


$('.rating-stars a').on('click', function(event) {
  event.preventDefault();
  $('.rating-stars a').find('b').remove();
  var rate = $(this).attr("rel");
  $('#ratings').val(rate);
  $(this).append("<b></b>");
});

$("#review").on("submit",function(e) {
    e.preventDefault();
      var formdata =new FormData(this);
      $.ajax({
          url :"<?= base_url().'Home/reviews';?>",
          method :"post",
          dataType:"json",
          data :formdata,
          contentType: false,
            cache: false,
            processData:false,
            success:function(data) {
            if(data.formerror ==false) {
              $(".csrf_token").val(data.csrf_token);
              if(data.rating_error !='') {
                $("#rating_error").html(data.rating_error);
                $("#reviews").addClass('inputborders');
              }else {
                $("#rating_error").html('');
                $("#reviews").removeClass('inputborders');
              }
            }
            else if(data.status ==false) {
              $(".csrf_token").val(data.csrf_token);
              $("#processing").html('<div class="alert alert-danger alert-dismissible"><i class="fas fa-ban"></i> '+data.msg+'</div>').show().fadeOut(3500);
              $("#rating_error").show().html(data.msg);
            }
            else if(data.status ==-1) {
              window.location.href=data.url;
            }
            else if(data.status ==true) {
               $(".csrf_token").val(data.csrf_token);
               $("#rating_error").html('');
               $("#processing").html('<div class="alert alert-success alert-dismissible"><i class="fas fa-circle-check"></i> '+data.msg+'</div>').fadeOut(3000);
               $("#reviews").removeClass('inputborders');
               $("#review")[0].reset();
              
            }
          }
      });
});

$(document).on('click',"#cancelOrder",function(e) {
  e.preventDefault();
  var pid = $(this).data('pid');
  $.ajax({
      url :"<?= base_url().'Cart/cancelOrder'; ?>",
      method:"post",
      data: {
        pid:pid
      },
      cache:false,
      dataType:"json",
      success:function(data) {
        if(data.status ==true) {
          $(".cancel"+pid).hide();
          $("#processing").html('<div class="alert alert-success">'+data.msg+'</div>').fadeOut(1700);
        }
        if(data.status ==false) {
          $(".cancel"+pid).show();
          $("#processing").html('<div class="alert alert-danger">'+data.msg+'</div>').fadeOut(1700);
        }
      }
  });
});

});

function resendOtp() {
  var email = $("#email").val();
      $.ajax({
          url :"<?= base_url().'Login/resendOtp'?>",
          method :"post",
          data:{
            email:email,
            '<?= $this->security->get_csrf_token_name();?>':$(".csrf_token").val()
          },
          dataType:"json",
          success:function(data) {
            if(data.status ==true) {
              $(".csrf_token").val(data.csrf_token);
              $("#processing").html('<div class="alert alert-success alert-dismissible"><i class="fas fa-circle-check"></i> '+data.msg+'</div>').fadeOut(3000);
              setTimeout(function() {window.location.href="<?= base_url().'otp';?>"}, 2400);
            }
            else if(data.status ==false) {
              $(".csrf_token").val(data.csrf_token);
              $("#processing").html('<div class="alert alert-danger alert-dismissible"><i class="fas fa-circle-check"></i> '+data.msg+'</div>').fadeOut(3000);
            }
          }
      });
}



$(document).ready(function(){
  $("#checkout").on("submit",function(e) {
    e.preventDefault();
      var formdata =new FormData(this);
      $.ajax({
          url :"<?= base_url().'Checkout/confirmorder';?>",
          method :"post",
          dataType:"json",
          data :formdata,
          contentType: false,
            cache: false,
            processData:false,
            success:function(data) {
            if(data.formerror ==false) {
              $(".csrf_token").val(data.csrf_token);
              if(data.bfname_error !='') {
                $("#bfname_error").html(data.bfname_error);
                $("#bfname").addClass('inputborders');
              }else {
                $("#bfname_error").html('');
                $("#bfname").removeClass('inputborders');
              }
              // if(data.blname_error !='') {
              //   $("#blname_error").html(data.blname_error);
              //   $("#blname").addClass('inputborders');
              // }else {
              //   $("#blname_error").html('');
              //   $("#blname").removeClass('inputborders');
              // }
               if(data.bemail_error !='') {
                $("#bemail_error").html(data.bemail_error);
                $("#bemail").addClass('inputborders');
              }else {
                $("#bemail_error").html('');
                $("#bemail").removeClass('inputborders');
              }
               if(data.bphone_error !='') {
                $("#bphone_error").html(data.bphone_error);
                $("#bphone").addClass('inputborders');
              }else {
                $("#bphone_error").html('');
                $("#bphone").removeClass('inputborders');
              }
               if(data.bpincode_error !='') {
                $("#bpincode_error").html(data.bpincode_error);
                $("#bpincode").addClass('inputborders');
              }else {
                $("#bpincode_error").html('');
                $("#bpincode").removeClass('inputborders');
              }
              if(data.bstate_error !='') {
                $("#bstate_error").html(data.bstate_error);
                $("#bstate").addClass('inputborders');
              }else {
                $("#bstate_error").html('');
                $("#bstate").removeClass('inputborders');
              }
              if(data.bcity_error !='') {
                $("#bcity_error").html(data.bcity_error);
                $("#bcity").addClass('inputborders');
              }else {
                $("#bcity_error").html('');
                $("#bcity").removeClass('inputborders');
              }
              if(data.barea_error !='') {
                $("#barea_error").html(data.barea_error);
                $("#barea").addClass('inputborders');
              }else {
                $("#barea_error").html('');
                $("#barea").removeClass('inputborders');
              }
              if(data.baddress_error !='') {
                $("#baddress_error").html(data.baddress_error);
                $("#baddress").addClass('inputborders');
              }else {
                $("#baddress_error").html('');
                $("#baddress").removeClass('inputborders');
              }
              // if(data.sfname_error !='') {
              //   $("#sfname_error").html(data.sfname_error);
              //   $("#sfname").addClass('inputborders');
              // }else {
              //   $("#sfname_error").html('');
              //   $("#sfname").removeClass('inputborders');
              // }
              if(data.slname_error !='') {
                $("#slname_error").html(data.slname_error);
                $("#slname").addClass('inputborders');
              }else {
                $("#slname_error").html('');
                $("#slname").removeClass('inputborders');
              }
              if(data.semail_error !='') {
                $("#semail_error").html(data.semail_error);
                $("#semail").addClass('inputborders');
              }else {
                $("#semail_error").html('');
                $("#semail").removeClass('inputborders');
              }

              if(data.sphone_error !='') {
                $("#sphone_error").html(data.sphone_error);
                $("#sphone").addClass('inputborders');
              }else {
                $("#sphone_error").html('');
                $("#sphone").removeClass('inputborders');
              }
              if(data.spincode_error !='') {
                $("#spincode_error").html(data.spincode_error);
                $("#spincode").addClass('inputborders');
              }else {
                $("#spincode_error").html('');
                $("#spincode").removeClass('inputborders');
              }
              if(data.sstate_error !='') {
                $("#sstate_error").html(data.sstate_error);
                $("#sstate").addClass('inputborders');
              }else {
                $("#sstate_error").html('');
                $("#sstate").removeClass('inputborders');
              }
              if(data.scity_error !='') {
                $("#scity_error").html(data.scity_error);
                $("#scity").addClass('inputborders');
              }else {
                $("#scity_error").html('');
                $("#scity").removeClass('inputborders');
              }
              if(data.sarea_error !='') {
                $("#sarea_error").html(data.sarea_error);
                $("#sarea").addClass('inputborders');
              }else {
                $("#sarea_error").html('');
                $("#sarea").removeClass('inputborders');
              }

              if(data.saddress_error !='') {
                $("#saddress_error").html(data.saddress_error);
                $("#saddress").addClass('inputborders');
              }else {
                $("#saddress_error").html('');
                $("#saddress").removeClass('inputborders');
              }

              if(data.pmode_error !='') {
                $("#pmode_error").html(data.pmode_error);
                $("#pmode").addClass('inputborders');
              }else {
                $("#pmode_error").html('');
                $("#pmode").removeClass('inputborders');
              }
            }
            else if(data.status ==false) {
              $(".csrf_token").val(data.csrf_token);
              $("#processing").html('<div class="alert alert-danger alert-dismissible"><i class="fas fa-ban"></i> '+data.msg+'</div>').show().fadeOut(9000);
            }
            else if(data.status ==true) {
               $(".csrf_token").val(data.csrf_token);
               $("#bfname_error").html('');
               //$("#blname_error").html('');
               $("#bemail_error").html('');
               $("#bphone_error").html('');
               $("#bpincode_error").html('');
               $("#bstate_error").html('');
               $("#bcity_error").html('');
               $("#barea_error").html('');
               $("#baddress_error").html('');
               $("#sfname_error").html('');
               //$("#slname_error").html('');
               $("#semail_error").html('');
               $("#sphone_error").html('');
               $("#spincode_error").html('');
               $("#sstate_error").html('');
               $("#scity_error").html('');
               $("#sarea_error").html('');
               $("#pmode_error").html('');
               $("#saddress_error").html('');
               $("#bfname").removeClass('inputborders');
               $("#blname").removeClass('inputborders');
               $("#bemail").removeClass('inputborders');
               $("#bstate").removeClass('inputborders');
               $("#bphone").removeClass('inputborders');
               $("#bcity").removeClass('inputborders');
               $("#barea").removeClass('inputborders');
               $("#baddress").removeClass('inputborders');
               $("#pmode").removeClass('inputborders');
                $("#sfname").removeClass('inputborders');
               $("#slname").removeClass('inputborders');
               $("#semail").removeClass('inputborders');
               $("#sstate").removeClass('inputborders');
               $("#sphone").removeClass('inputborders');
               $("#scity").removeClass('inputborders');
               $("#sarea").removeClass('inputborders');
               $("#saddress").removeClass('inputborders');
               $("#processing").html('<div class="alert alert-success alert-dismissible"><i class="fas fa-circle-check"></i> '+data.msg+'</div>').fadeOut(300000);
               $("#checkout")[0].reset();
               setTimeout(function() {window.location.href=data.url}, 2400);
            }
          }
      });
  });
  

 $('input[type="checkbox"]').click(function(){
            if($(this).prop("checked") == true){
                $("#shipped-container").show();
            }
            else if($(this).prop("checked") == false){
              $("#shipped-container").hide();
            }
        });

 $(document).on("click","#wishlist",function(e) {
    e.preventDefault();
    var pid = $(this).data('pid');
    $.ajax({
        url :"<?= base_url().'Cart/wishlist';?>",
        method :"post",
        cache:false,
        data :{
          pid:pid
        },
        dataType :"json",
        success:function(data) {
          if(data.status ==true) {
            $(".btn-wishlist").addClass('wcolors');
          }
          else if(data.status ==false) {
            $(".btn-wishlist").removeClass('wcolors');
          }
          else if(data.status ==-1) {
            window.location.href=data.url;
          }
        }
    });
 });

    
});
function state(id) {
  $.ajax({
      url :"<?= base_url().'home/state';?>",
      method:"post",
      data: {
        id:id,
        sid :1
      },
      dataType:"json",
      cache:false,
      success:function(data) {
        if(data.status ==true) {
          $("#bcity").html(data.msg);
        }
        else if(data.status ==false) {
          $("#bcity").html(data.msg);
        }
      }
  });
}
function city(id) {
   $.ajax({
      url :"<?= base_url().'home/city';?>",
      method:"post",
      data: {
        id:id,
        sid :1
      },
      dataType:"json",
      cache:false,
      success:function(data) {
        if(data.status ==true) {
          $("#barea").html(data.msg);
        }
        else if(data.status ==false) {
          $("#barea").html(data.msg);
        }
      }
  });
}

function shippingstate(id) {
  $.ajax({
      url :"<?= base_url().'home/state';?>",
      method:"post",
      data: {
        id:id,
        sid :2
      },
      dataType:"json",
      cache:false,
      success:function(data) {
        if(data.status ==true) {
          $("#scity").html(data.msg);
        }
        else if(data.status ==false) {
          $("#scity").html(data.msg);
        }
      }
  });
}
function shippingcity(id) {
   $.ajax({
      url :"<?= base_url().'home/city';?>",
      method:"post",
      data: {
        id:id,
        sid :2
      },
      dataType:"json",
      cache:false,
      success:function(data) {
        if(data.status ==true) {
          $("#sarea").html(data.msg);
        }
        else if(data.status ==false) {
          $("#sarea").html(data.msg);
        }
      }
  });
}
function pincodeCheck(cpincode,pri) {
   $.ajax({
          url :"<?= base_url().'Home/pincodeCheck';?>",
          method :"post",
          dataType:"json",
          data :{
            cpincode :cpincode
          },
          cache: false,
            success:function(data) {
           
            if(data.status ==false) {
              if(pri ==1) {
                $("#pincode_error").show().html(data.msg).addClass('text-danger');
              }

              if(pri ==2) {
                $("#spincode_error").show().html(data.msg).removeClass('text-danger');
              }
              
            }
            else if(data.status ==true) {
              if(pri ==1) {
               $("#pincode_error").show().html(data.msg).removeClass('text-danger');
             }
             if(pri ==2) {
              $("#spincode_error").show().html(data.msg).removeClass('text-danger');
             }
               $("#totalAmount").html(data.totalamount);
               $("#charges").show();
               $("#delcharges").html(data.amount);
              
            }
          }
      });
}
</script>
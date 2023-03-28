<?php
	if(count($this->cart->contents()) >0) {
    $subtotal = [];
    ?>
      <div class="cart-header">
                                    <span>Shopping Cart</span>
                                    <a href="#" class="btn-close">Close<i class="w-icon-long-arrow-right"></i></a>
                                </div>
 <div class="products" style="border-bottom: 0px!important">
    <?php
		foreach ($this->cart->contents() as $cart) {
      $subtotal[] = $cart['subtotal'];
			?>
			 <div class="product product-cart">
                                               <div class="product-detail">
                                                 <a href="product-default.html" class="product-name"><?= ucfirst($cart['name']); ?></a>
                                                 <div class="price-box">
                                                    <span class="product-quantity"><?= $cart['qty'];?></span>
                                                    <span class="product-price"><i class="fas fa-rupee-sign" style="margin-right: 5px"></i><?= $cart['price'];?></span>
                                                 </div>
                                               </div>
                                               <figure class="product-media">
                                                 <a href="product-default.html">
                                                    <img src="<?= $cart['image'];?>" alt="product" height="84" width="94" />
                                                 </a>
                                                </figure>
                                                <button class="btn btn-link btn-close" aria-label="button" onClick="removeCart('<?= $cart['rowid'];?>',1)"><i class="fas fa-times"></i></button>
                                            </div>
			<?php
		}
    ?>
  </div>
       <div class="cart-total">
                                           <label>Subtotal:</label>
                                           <span class="price"><i class="fas fa-rupee-sign" style="margin-right: 5px"></i><?= number_format($this->cart->total());?></span>
                                        </div>
                                        <div class="cart-action">
                                          <a href="<?= base_url().'cart';?>" class="btn btn-dark btn-outline btn-rounded">View Cart</a>
                                          <a href="<?php if($this->session->userdata(CUSTOMER_SESSION)) {echo base_url().'checkout';}else {echo base_url().'login';}?>" class="btn btn-dark  btn-rounded">Checkout</a>
                                        </div>

    <?php
	}else {
    ?>
                                <div class="cart-header">
                                    <span>Shopping Cart</span>
                                    <a href="#" class="btn-close">Close<i class="w-icon-long-arrow-right"></i></a>
                                </div><br /><br /><br /><center><img src='<?= base_url()."assets/images/cart.png" ?>' style='width:230px' /><p style='font-size:16px;text-align:center;margin-top:10px;font-weight:bold'>Your Cart is empty</p></center>
    <?php
		
	}
?>
<?php
	if(count($products) >0) {
		foreach ($products as $key => $prod) {
			?>
			<div class="product-wrap">
                                    <div class="product text-center">
                                        <figure class="product-media">
                                            <a href="<?= base_url().'products/'.$prod->page_url;?>">
                                                <img src="<?= base_url().$prod->image;?>" alt="Product" width="300"
                                                    height="338" />
                                            </a>
                                            <div class="product-action-horizontal">
                                           <!--      <a href="#" data-pid="<?= encode($prod->pid);?>" class="btn-product-icon btn-cart w-icon-cart" data-id="2"
                                                    title="Add to cart" id="cartBack<?= encode($prod->pid);?> "></a> -->
                                                <a href="#" class="btn-product-icon  btn-wishlist w-icon-heart"
                                                    title="Wishlist" id="wishlist" data-pid="<?= encode($prod->pid);?>"></a>
                                                
                                                
                                            </div>
                                        </figure>
                                        <div class="product-details">
                                            <!-- <div class="product-cat">
                                                <a href="shop-banner-sidebar.html"><?= ucfirst($prod->title);?></a>
                                            </div> -->
                                            <h3 class="product-name">
                                                <a href="product_view.html"><?= ucfirst($prod->title);?></a>
                                            </h3>
                                            <div class="ratings-container">
                                                <div class="ratings-full">
                                                    <span class="ratings" style="width: 100%;"></span>
                                                    <span class="tooltiptext tooltip-top"></span>
                                                </div>
                                                <a href="product_view.html" class="rating-reviews">(3 reviews)</a>
                                            </div>
                                            <div class="product-pa-wrapper">
                                                <div class="product-price">
                                                  <i class="fas fa-sign-rupee"></i><?= number_format($prod->price);?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
			<?php
		}
	}else {
		echo "No data found";
	}
?>
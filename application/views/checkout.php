<?php //echo "<pre>";print_r($this->cart->contents()); exit; ?>
<?= $header;?>
<style type="text/css">
    #shipped-container {
        display: none;
    }
    #discount {
        display: none;
    }
    .checkout .form-control {
        margin-bottom: 10px!important
    }
    label {
        cursor: pointer!important
    }
    #charges {
        display: none;
    }
</style>
 <!-- Start of Main -->
        <main class="main checkout">
            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb shop-breadcrumb bb-no">
                        <li class="passed"><a href="cart.html">Shopping Cart</a></li>
                        <li class="active"><a href="checkout.html">Checkout</a></li>
                        <li><a href="order.html">Order Complete</a></li>
                    </ul>
                </div>
            </nav>
            <!-- End of Breadcrumb -->


            <!-- Start of PageContent -->
            <div class="page-content">
                <div class="container">


                    <div id="processing"></div>

                    <form id="checkout" method="post" enctype="multipart/form-data">
                        <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="row mb-9">
                            <div class="col-lg-7 pr-lg-4 mb-4">
                                <h3 class="title billing-title text-uppercase ls-10 pt-1 pb-3 mb-0">
                                    Billing Details
                                </h3>
                                <div class="row gutter-sm">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label>Billing Name <font style="color:red">*</font></label>
                                            <input type="text" class="form-control form-control-md" name="bfname"
                                                id="bfname" placeholder="Eg:John" value="<?php if($this->session->userdata(CUSTOMER_SESSION)) {echo $this->session->userdata(CUSTOMER_SESSION)['name'];}else {echo '';}?>">
                                                <span id="bfname_error" class="text-danger"></span>
                                        </div>
                                    </div>
                                   
                                    <div class="clearfix"></div>
                                     <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Billing Email <font style="color:red">*</font></label>
                                            <input type="email" class="form-control form-control-md" name="bemail"
                                                id="bemail" placeholder="Eg:johndoe@example.com" value="<?php if($this->session->userdata(CUSTOMER_SESSION)) {echo $this->session->userdata(CUSTOMER_SESSION)['email'];}else {echo '';}?>">
                                                 <span id="email_error" class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Billing Mobile Number <font style="color:red">*</font></label>
                                            <input type="number" class="form-control form-control-md" name="bphone"
                                                id="bphone" placeholder="Eg:9988776655" maxlength="10" minlength="10" pattern="/^-?\d+\.?\d*$/" onkeypress="if(this.value.length==10) return false;" value="<?php if($this->session->userdata(CUSTOMER_SESSION)) {echo $this->session->userdata(CUSTOMER_SESSION)['phone'];}else {echo '';}?>">
                                                 <span id="bphone_error" class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                     <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Billing Pincode <font style="color:red">*</font></label>
                                            <input type="number" class="form-control form-control-md" name="bpincode" id="bpincode" placeholder="Eg:560043" min="0" maxlength="6" minlength="6" pattern="/^-?\d+\.?\d*$/" onkeypress="if(this.value.length==6) return false;"  onkeyup="return pincodeCheck(this.value,1)">
                                                 <span id="bpincode_error" class="text-danger"></span>
                                                 <span id="pincode_error" class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Billing State <font style="color:red">*</font></label>
                                           <select name="bstate" id="bstate" class="form-control form-control-md" onchange="return state(this.value)">
                                               <option value="">Select State</option>
                                               <?php
                                                    if(count($states) >0) {
                                                        foreach ($states as $state) {
                                                            ?>
                                                            <option value="<?= $state->id;?>"><?= $state->name;?></option>
                                                            <?php
                                                        }
                                                    }
                                               ?>
                                           </select>
                                                 <span id="bstate_error" class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Billing City <font style="color:red">*</font></label>
                                           <select name="bcity" id="bcity" class="form-control form-control-md" onchange="return city(this.value)">
                                               <option value="">Select City</option>
                                               <?php
                                                    if(count($cities) >0) {
                                                        foreach ($cities as $city) {
                                                            ?>
                                                            <option value="<?= $city->id;?>"><?= $city->cname;?></option>
                                                            <?php
                                                        }
                                                    }
                                               ?>
                                           </select>
                                                 <span id="bcity_error" class="text-danger"></span>
                                        </div>
                                    </div>
                                     <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Billing Area <font style="color:red">*</font></label>
                                           <select name="barea" id="barea" class="form-control form-control-md">
                                               <option value="">Select Area</option>
                                               <?php
                                                    if(count($area) >0) {
                                                        foreach ($area as $are) {
                                                            ?>
                                                            <option value="<?= $are->id;?>"><?= $are->areaname;?></option>
                                                            <?php
                                                        }
                                                    }
                                               ?>
                                           </select>
                                                 <span id="barea_error" class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label>Billing Street Address <font style="color:red">*</font></label>
                                            <textarea cols="4" rows="4" class="form-control" name="baddress" id="baddress" placeholder="Eg: 29 Carol Ann Drive, Albany,ny, 12205  United States"></textarea>
                                        </div>
                                        <span id="baddress_error" class="text-danger" style="color:red"></span>
                                    </div>
                                     <div class="clearfix"></div>
                                </div>
                              
                                <div class="form-group pb-2">
                                    <input type="checkbox" 
                                        name="shipped" class="shipped" id="shipped" value="1">
                                     <label for="shipped" style="cursor: pointer">Ship to a different address?</label> 
                                </div>
                                <div id="shipped-container">
                                   <div class="row gutter-sm">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label>Shipping Name <font style="color:red">*</font></label>
                                            <input type="text" class="form-control form-control-md" name="sfname"
                                                id="sfname" placeholder="Eg:John">
                                                <span id="sfname_error" class="text-danger"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="clearfix"></div>
                                     <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Shipping Email <font style="color:red">*</font></label>
                                            <input type="email" class="form-control form-control-md" name="semail"
                                                id="semail" placeholder="Eg:johndoe@example.com">
                                                 <span id="semail_error" class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Shipping Mobile Number <font style="color:red">*</font></label>
                                            <input type="number" class="form-control form-control-md" name="sphone"
                                                id="sphone" placeholder="Eg:9988776655" maxlength="10" minlength="10" pattern="/^-?\d+\.?\d*$/" onkeypress="if(this.value.length==10) return false;">
                                                 <span id="sphone_error" class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                     <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Shipping Pincode <font style="color:red">*</font></label>
                                            <input type="number" class="form-control form-control-md" name="spincode" id="spincode" placeholder="Eg:560043" maxlength="6" minlength="6" pattern="/^-?\d+\.?\d*$/" onkeypress="if(this.value.length==6) return false;" onkeyup="return pincodeCheck(this.value,2)">
                                                 <span id="spincode_error" class="text-danger"></span>

                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Shipping State <font style="color:red">*</font></label>
                                           <select name="sstate" id="sstate" class="form-control form-control-md" onchange="return shippingstate(this.value)">
                                               <option value="">Select State</option>
                                               <?php
                                                    if(count($states) >0) {
                                                        foreach ($states as $state) {
                                                            ?>
                                                            <option value="<?= $state->id;?>"><?= $state->name;?></option>
                                                            <?php
                                                        }
                                                    }
                                               ?>
                                           </select>
                                                 <span id="sstate_error" class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Shipping City <font style="color:red">*</font></label>
                                           <select name="scity" id="scity" class="form-control form-control-md" onchange="return shippingcity(this.value)">
                                               <option value="">Select City</option>
                                               <?php
                                                    if(count($cities) >0) {
                                                        foreach ($cities as $city) {
                                                            ?>
                                                            <option value="<?= $city->id;?>"><?= $city->cname;?></option>
                                                            <?php
                                                        }
                                                    }
                                               ?>
                                           </select>
                                                 <span id="scity_error" class="text-danger"></span>
                                        </div>
                                    </div>
                                     <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Shipping Area <font style="color:red">*</font></label>
                                           <select name="sarea" id="sarea" class="form-control form-control-md">
                                               <option value="">Select Area</option>
                                               <?php
                                                    if(count($area) >0) {
                                                        foreach ($area as $are) {
                                                            ?>
                                                            <option value="<?= $are->id;?>"><?= $are->areaname;?></option>
                                                            <?php
                                                        }
                                                    }
                                               ?>
                                           </select>
                                                 <span id="sarea_error" class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label>Shipping Street Address <font style="color:red">*</font></label>
                                            <textarea cols="4" rows="4" class="form-control" name="saddress" id="saddress" placeholder="Eg: 29 Carol Ann Drive, Albany,ny, 12205  United States"></textarea>
                                            <span id="saddress_error" class="text-danger"></span>
                                        </div>
                                    </div>
                                     <div class="clearfix"></div>
                                </div>
                                </div>

                               
                            </div>
                            <div class="col-lg-5 mb-4 sticky-sidebar-wrapper">
                                <div class="order-summary-wrapper sticky-sidebar">
                                    <h3 class="title text-uppercase ls-10">Your Order</h3>
                                    <div class="order-summary">
                                        <table class="order-table">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">
                                                        <b>Product</b>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                if(is_array($this->cart->contents()) && !empty($this->cart->contents())) {
                                                          if(count($this->cart->contents()) >0) {
                                                        $subtotal =[];$tax = [];
                                                        foreach ($this->cart->contents() as $cart) {
                                                            $subtotal[] = $cart['subtotal'];
                                                            $tax[] = $cart['price'] *$cart['tax'] / 100;
                                                            ?>
                                                                <tr class="bb-no">
                                                                    <td class="product-name"><a href="<?= base_url().'products/'.$cart['purl'];?>"><?= ucfirst($cart['name']);?></a> <i
                                                                            class="fas fa-times"></i> <span
                                                                            class="product-quantity"><?= $cart['qty'];?></span></td>
                                                                    <td class="product-total"><i class="fas fa-rupee-sign"></i> <?= number_format($cart['subtotal']);?></td>
                                                                </tr>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                  
                                                ?>
                                                
                                             

                                                 <tr class="order-total">
                                                    <td style="text-align: left;">If you have a coupon code, please
                                                        apply it below.</td>
                                                </tr>
                                                <tr>
                                                    <td class="input-wrapper-inline">
                                                        <input type="text" name="couponcode"
                                                            class="form-control-md mr-1 mb-2"
                                                            placeholder="Coupon code" id="couponcode">
                                                        <button type="button" class="btn button btn-rounded btn-coupon mb-2"
                                                            value="Apply coupon" id="checkoutCoupon">Apply
                                                            Coupon</button>
                                                            <br />
                                                      <span id="coupon_error" class="text-danger" style="color:red;"></span>
                                                    </td>
                                                </tr>

                                                <tr class="cart-subtotal bb-no">
                                                    <td>
                                                        <b>Subtotal</b>
                                                    </td>
                                                    <td style="width: 50%">
                                                        <b> <?php if(is_array($this->cart->contents()) && !empty($this->cart->contents())) { echo '<i class="fas fa-rupee-sign"></i> '. sprintf("%.2f",array_sum($subtotal)); } ?></b>
                                                    </td>
                                                </tr>

                                                <tr class="cart-subtotal bb-no">
                                                    <td>
                                                        <b>Tax</b>
                                                    </td>
                                                    <td style="width: 50%">
                                                        <b> <?php if(is_array($this->cart->contents()) && !empty($this->cart->contents())) { echo '<i class="fas fa-rupee-sign"></i> '. sprintf("%.2f",array_sum($tax)); } ?></b>
                                                    </td>
                                                </tr>

                                                <tr id="discount" class="cart-subtotal bb-no" style="<?php if($this->session->userdata('discount')) {echo 'display: table-row!important';}?>">
                                                    <td><b>Discount </b></td>
                                                <td ><b id="disamount"><?= " ".$this->session->userdata('discount')."%";?></b></td>
                                            </tr>

                                             <tr id="charges" class="cart-subtotal bb-no" style="<?php if($this->session->userdata('pamount')) {echo 'display: table-row!important';}?>">
                                                    <td><b>Delivery Charges </b></td>
                                                <td ><b id="delcharges"><?= "<i class='fas fa-rupee-sign'></i> ".$this->session->userdata('pamount');?></b></td>
                                            </tr>




                                            </tbody>
                                            <tfoot>

                                                <tr class="order-total">
                                                    <th>
                                                        <b>Total</b>
                                                    </th>
                                                    <td>
                                                        <b> <?php if(is_array($this->cart->contents()) && !empty($this->cart->contents())) {$amount = floatval(array_sum($tax) + $this->cart->total() + $this->session->userdata('pamount')) * $this->session->userdata('discount') / 100; echo '<i class="fas fa-rupee-sign"></i><span id="totalAmount">'. sprintf("%.2f",array_sum($tax) + $this->cart->total() + $this->session->userdata('pamount') - $amount).'<div id="pincodeAm"></div></span>'; }  ?></b>
                                                    </td>
                                                </tr>



                                            </tfoot>
                                        </table>

                                        <div class="payment-methods" id="payment_method">
                                            <h4 class="title font-weight-bold ls-25 pb-0 mb-1">Payment Methods</h4>
                                            <div class="accordion payment-accordion">

                                                <div class="card p-relative">
                                                    <span id="pmode_error" class="text-danger"></span>
                                                    <div class="card-header">
                                                        <input type="radio" name="pmode" id="pmode" value="1">
                                                        <label for="pmode">Pay Online</label>
                                                    </div>
                                                    <div class="card-header">
                                                        <input type="radio" name="pmode" id="pmodes" value="2">
                                                        <label for="pmodes">COD</label>
                                                    </div>

                                                    <div id="paypal" class="card-body collapsed">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group place-order pt-6">
                                            <input type="submit" id="checksubmit"  class="btn btn-dark btn-block btn-rounded" value="Place
                                                Order">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- End of PageContent -->
        </main>
<?= $footer;?>
<?= $js;?>
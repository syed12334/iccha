
<?= $header;?>
 <main class="main">
            <!-- Start of Page Header -->
            <div class="page-header">
                <div class="container">
                    <h1 class="page-title mb-0">My Account</h1>
                </div>
            </div>
            <!-- End of Page Header -->

            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav mb-0">
                <div class="container">
                    <ul class="breadcrumb">
                        <li><a href="<?= base_url();?>">Home</a></li>
                    </ul>
                </div>
            </nav>
            <!-- End of Breadcrumb -->

            <!-- Start of PageContent -->
            <div class="page-content pt-2">
                <div class="container">
                    <div class="tab tab-vertical row gutter-lg">
                        

                        <div class=" mb-6">
                            
                            <div class="tab-pane active order">
                                <p class="mb-4">Order <?= $orders[0]->orderid;?> was placed on <?= date('M d, Y',strtotime($orders[0]->order_date));?> and is currently On hold.</p>
                                <div class="order-details-wrapper mb-5">
                                    <h4 class="title text-uppercase ls-25 mb-5">Order Details</h4>
                                    <table class="order-table">
                                        <thead>
                                            <tr>
                                                <th class="text-dark">Product</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<?php
                                        		if(count($orders_products) >0) {
                                        			foreach ($orders_products as $op) {
                                        				?>
                                        				<tr>
			                                                <td>
			                                                    <a href="<?= base_url().'products/'.$op->purl;?>"><?= $op->name;?></a>&nbsp;<strong>x <?= $op->qty;?></strong>
			                                                </td>
			                                                <td><i class="fas fa-rupee-sign"></i> <?= number_format($op->price,2);?></td>
			                                            </tr>
                                        				<?php
                                        			}
                                        		}
                                        	?>
                                           
                                          
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Subtotal:</th>
                                                <td><i class="fas fa-rupee-sign"></i> <?= number_format($orders[0]->subtotal,2);?></td>
                                            </tr>
                                            <?php
                                            	if(!empty($orders[0]->taxamount) && $orders[0]->taxamount !=0) {
                                            		?>
                                            		 <tr>
                                                <th>Tax:</th>
                                                <td><i class="fas fa-rupee-sign"></i> <?= number_format($orders[0]->taxamount,2);?></td>
                                            </tr>
                                            		<?php
                                            	} 
                                            ?>
                                            <?php
                                            	if(!empty($orders[0]->discount) && $orders[0]->discount !=0) {
                                            		?>
                                            		<tr>
		                                                <th>Discount:</th>
		                                                <td> <?= $orders[0]->discount."%";?></td>
		                                            </tr>
                                            		<?php
                                            	}
                                            ?>

                                            <?php
                                            	if(!empty($orders[0]->delivery_charges) && $orders[0]->delivery_charges !=0) {
                                            		?>
                                            		<tr>
		                                                <th>Delivery Charges:</th>
		                                                <td><i class="fas fa-rupee-sign"></i> <?= number_format($orders[0]->delivery_charges,2);?></td>
		                                            </tr>
                                            		<?php
                                            	}
                                            ?>
                                            
                                            <tr class="total">
                                                <th class="border-no">Total:</th>
                                                <td class="border-no"><i class="fas fa-rupee-sign"></i> <?= number_format($orders[0]->totalamount,2);?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- End of Order Details -->

                               

                                <div id="billing-account-addresses">
                                    <div class="row">
                                        <div class="col-sm-6 mb-8">
                                            <div class="ecommerce-address billing-address">
                                                <h4 class="title title-underline ls-25 font-weight-bold">Billing Address
                                                </h4>
                                                <address class="mb-4">
                                                    <table class="address-table">
                                                        <tbody>
                                                           <?php 
                                                    if(count($billing) >0) {
                                                        $billingstate = $this->master_db->sqlExecute('select s.name as sname,c.cname,a.areaname from order_bills ob left join states s on s.id = ob.bstate left join cities c on c.id = ob.bcity left join area a on a.id = ob.barea where ob.oid='.$orders[0]->oid.'');
                                                        ?>
                                                        <tr>
                                                    <td><?= $billing[0]->bfname;?></td>
                                                </tr>
                                                <tr>
                                                    <td><?= $billing[0]->bemail;?></td>
                                                </tr>
                                                <tr>
                                                    <td><?= $billingstate[0]->sname;?></td>
                                                </tr>
                                                <tr>
                                                    <td><?= $billingstate[0]->cname;?></td>
                                                </tr>
                                                <tr>
                                                    <td><?= $billingstate[0]->areaname;?></td>
                                                </tr>
                                                <tr>
                                                    <td><?= $billing[0]->baddress;?></td>
                                                </tr>
                                                <tr>
                                                    <td><?= $billing[0]->bpincode;?></td>
                                                </tr>
                                                        <?php
                                                    }
                                                ?>
                                                        </tbody>
                                                    </table>
                                                </address>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mb-8">
                                            <div class="ecommerce-address shipping-address">
                                                <h4 class="title title-underline ls-25 font-weight-bold">Shipping
                                                    Address</h4>
                                                <address class="mb-4">
                                                    <table class="address-table">
                                                        <tbody>
                                                               <?php 
                                                    if(count($billing) >0) {
                                                        $sstate = $this->master_db->sqlExecute('select s.name as sname,c.cname,a.areaname from order_bills ob left join states s on s.id = ob.sstate left join cities c on c.id = ob.scity left join area a on a.id = ob.sarea where ob.oid='.$orders[0]->oid.'');
                                                        ?>
                                                        <tr>
                                                    <td><?= $billing[0]->sfname;?></td>
                                                </tr>
                                                <tr>
                                                    <td><?= $billing[0]->semail;?></td>
                                                </tr>
                                                 <tr>
                                                    <td><?= $sstate[0]->sname;?></td>
                                                </tr>
                                                <tr>
                                                    <td><?= $sstate[0]->cname;?></td>
                                                </tr>
                                                <tr>
                                                    <td><?= $sstate[0]->areaname;?></td>
                                                </tr>
                                                <tr>
                                                    <td><?= $billing[0]->saddress;?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php if(!empty($billing[0]->spincode) && $billing[0]->spincode !=0) { echo $billing[0]->spincode; }?></td>
                                                </tr>
                                                        <?php
                                                    }
                                                ?>
                                                        </tbody>
                                                    </table>
                                                </address>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Account Address -->

                                <a href="<?= base_url().'my-account';?>" class="btn btn-dark btn-rounded btn-icon-left btn-back mt-6 mb-6"><i
                                        class="w-icon-long-arrow-left"></i>Back To List</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of PageContent -->
        </main>
<?= $footer;?>
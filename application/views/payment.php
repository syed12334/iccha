<?php $total = $orders[0]->totalamount; ?>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<form name="razorpayform" action="<?php echo base_url();?>checkout/paymentResponse" method="POST">
    <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
    <input type="hidden" name="paymentID" id="paymentID" >
    <input type="hidden" name="signature"  id="signature" >
    <input type="hidden" name="orderID"  id="orderID" >
    <input type="hidden" name="oid"  id="oid" value="<?= $orders[0]->oid; ?>" >
</form>
<button id="rzp-button1">Please wait Transaction is processing........Please do not refresh the page</button>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var options = {
        "key": "<?php echo TEST_MERCHANT_KEY;?>", // Enter the Key ID generated from the Dashboard
        "amount": "<?php echo $total;?>", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
        "currency": "<?php echo 'INR';?>",
        "name": "Oiishee",
        "order_id": "<?php echo $payment[0]->order_id;?>", //Pass the `id` obtained in the previous step
    };
    options.handler = function (response){
        document.getElementById('paymentID').value = response.razorpay_payment_id;
        document.getElementById('signature').value = response.razorpay_signature;
         document.getElementById('orderID').value = response.razorpay_order_id;
        document.razorpayform.submit();
    };



options.modal = {
    ondismiss: function() {
        console.log("This code runs when the popup is closed");
    },
    // Boolean indicating whether pressing escape key 
    // should close the checkout form. (default: true)
    escape: true,
    // Boolean indicating whether clicking translucent blank
    // space outside checkout form should close the form. (default: false)
    backdropclose: false
};

var rzp = new Razorpay(options);


    rzp.open();


</script>
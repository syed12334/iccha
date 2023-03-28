<?php
   // echo "<pre>";print_r($orders);exit;
?>
<!DOCTYPE html>
<html>
<head>
   <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
   <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0" name="viewport"><!--[if !mso]><!-->
   <meta content="IE=edge" http-equiv="X-UA-Compatible"><!--<![endif]-->
   <meta content="telephone=no" name="format-detection">
   <title>Order Confirmation</title><!--[if !mso]><!-->
   <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700,700i,900" rel="stylesheet">
   <style type="text/css">
        body {
            -webkit-text-size-adjust: 100% !important;
            -ms-text-size-adjust: 100% !important;
            -webkit-font-smoothing: antialiased !important;
            width: 100%;
            height: 100%;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        img {
            border: 0 !important;
            outline: none !important;
        }
        p {
            Margin: 0px !important;
            Padding: 0px !important;
        }
        table {
            border-collapse: collapse;
            mso-table-lspace: 0px;
            mso-table-rspace: 0px;
        }
        td,
        a,
        span {
            border-collapse: collapse;
            mso-line-height-rule: exactly;
        }
        .ExternalClass * {
            line-height: 100%;
        }
        span.MsoHyperlink {
            mso-style-priority: 99;
            color: inherit;
        }

        span.MsoHyperlinkFollowed {
            mso-style-priority: 99;
            color: inherit;
        }
        .em_defaultlink a {
            color: inherit !important;
            text-decoration: none !important;
        }
        .rw_phone_layout .em_full_img {
            width: 100%;
            height: auto !important;
        }
        .rw_tablet_layout .em_full_img {
            width: 100%;
            height: auto !important;
        }
   </style>
   <style type="text/css">
        @media only screen and (max-width: 640px) {
            td[class=em_h1] {
                height: 60px !important;
                font-size: 1px !important;
                line-height: 1px !important;
            }
            table[class=myfull] {
                width: 100% !important;
                max-width: 300px !important;
                text-align: center !important;
            }
            table[class=notify-5-wrap] {
                width: 100% !important;
                max-width: 400px;
            }
            table[class=full] {
                width: 100% !important;
            }
            td[class=fullCenter] {
                width: 100% !important;
                text-align: center !important
            }
            td[class=em_hide] {
                display: none !important;
            }
            table[class=em_hide] {
                display: none !important;
            }
            span[class=em_hide] {
                display: none !important;
            }
            br[class=em_hide] {
                display: none !important;
            }
            img[class=em_full_img] {
                width: 100% !important;
                height: auto !important;
            }
            img[class="em_logo"] {
                text-align: center;
            }
            td[class=em_center] {
                text-align: center !important;
            }
            table[class=em_center] {
                text-align: center !important;
            }
            td[class=em_h20] {
                height: 20px !important;
            }
            td[class=em_h30] {
                height: 30px !important;
            }
            td[class=em_h40] {
                height: 40px !important;
            }
            td[class=em_h50] {
                height: 50px !important;
            }
            td[class=em_pad] {
                padding-left: 15px !important;
                padding-right: 15px !important;
            }
            td[class=em_pad2] {
                padding-left: 25px !important;
                padding-right: 25px !important;
            }
            img[class=img125] {
                max-width: 125px;
            }
            table[class=small-center] {
                max-width: 350px !important;
                text-align: center !important;
            }
            td[class=em_autoHeight] {
                height: auto !important;
            }
            td[class=winebg] {
                background: #b92547;
                -webkit-border-top-right-radius: 5px !important;
                -moz-border-radius-topright: 5px !important;
                border-top-right-radius: 5px !important;
                -webkit-border-bottom-left-radius: 0 !important;
                -moz-border-radius-bottomleft: 0 !important;
                border-bottom-left-radius: 0 !important;
            }
            td[class=myHeading] {
                font-size: 24px !important;
                text-align: center !important;
            }
            td[class=heading] {
                font-size: 28px !important;
                text-align: center !important;
                line-height: 35px;
            }
        }
   </style>
   <style type="text/css">
        @media only screen and (max-width: 479px) {
            table[class=full] {
                width: 100% !important;
                max-width: 100% !important;
            }
            table[class=myfull] {
                width: 100% !important;
            }
            table[class=notify-5-wrap] {
                width: 100% !important;
            }
            table[class=em_wrapper] {
                width: 100% !important;
            }
            td[class=fullCenter] {
                width: 100% !important;
                text-align: center !important
            }
            td[class=em_aside] {
                width: 10px !important;
            }
            td[class=em_hide] {
                display: none !important;
            }
            table[class=em_hide] {
                display: none !important;
            }
            span[class=em_hide] {
                display: none !important;
            }
            br[class=em_hide] {
                display: none !important;
            }
            img[class=em_full_img] {
                width: 100% !important;
                height: auto !important;
            }
            img[class="em_logo"] {
                text-align: center;
            }
            td[class=em_center] {
                text-align: center !important;
            }
            table[class=em_center] {
                text-align: center !important;
            }
            td[class=em_h20] {
                height: 20px !important;
            }
            td[class=em_h30] {
                height: 30px !important;
            }
            td[class=em_h40] {
                height: 40px !important;
            }
            td[class=em_h50] {
                height: 50px !important;
            }
            td[class=em_pad] {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }
            td[class=em_pad2] {
                padding-left: 20px !important;
                padding-right: 20px !important;
            }
            table[class=em_btn] {
                width: 130px !important;
            }
            td[class=em_btn_text] {
                font-size: 10px !important;
                height: 26px !important;
            }
            a[class=em_btn_text] {
                line-height: 26px !important;
            }
            td[class=em_h1] {
                height: 60px !important;
                font-size: 1px !important;
                line-height: 1px !important;
            }
            td[class=em_bg] {
                background: none !important;
            }
            img[class=img125] {
                max-width: 110px;
                height: auto !important;
            }
            table[class=small-center] {
                max-width: 100% !important;
                text-align: center !important;
            }
            td[class=em_autoHeight] {
                height: auto !important;
            }
            td[class=myHeading] {
                font-size: 24px !important;
                text-align: center !important;
                color: #ff0000
            }
            td[class=heading] {
                font-size: 26px !important;
                text-align: center !important;
                line-height: 35px;
            }
            td[class=winebg] {
                background: #b92547;
                -webkit-border-top-right-radius: 5px !important;
                -moz-border-radius-topright: 5px !important;
                border-top-right-radius: 5px !important;
                -webkit-border-bottom-left-radius: 0 !important;
                -moz-border-radius-bottomleft: 0 !important;
                border-bottom-left-radius: 0 !important;
            }
        }
   </style>
</head>
<body>
   <!-- Notify 7-->
   <table align="center" border="0" cellpadding="0" cellspacing="0" class="full" width="100%">
      <tr>
         <td align="center" bgcolor="#F6F5F5">
            <!-- Mobile Wrapper -->
            <table align="center" border="0" cellpadding="0" cellspacing="0" class="full" width="100%">
               <tr>
                  <td align="center" width="100%">
                     <div class="sortable_inner">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                           <tr>
                              <td class="em_h1" height="60"></td>
                           </tr>
                        </table>
                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="full" width="100%">
                           <tr>
                              <td align="center" height="151" valign="middle" width="30%"><img alt="logo" height="151" src="<?php echo asset_url(); ?>images/logo.png" style="height:151px;"></td>
                           </tr>
                        </table>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                           <tr>
                              <td class="em_h40" height="40"></td>
                           </tr>
                        </table>
                     </div>
                  </td>
               </tr>
            </table>
            <table align="center" border="0" cellpadding="0" cellspacing="0" class="full" width="600">
               <tr>
                  <td align="center" class="em_pad2" valign="middle" width="100%">
                     <table align="center" border="0" cellpadding="0" cellspacing="0" class="full" style="border-top-right-radius: 5px; border-top-left-radius: 5px;" width="600">
                        <tr>
                           <td align="center" bgcolor="#FFFFFF" class="em_pad" style="-webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px;" valign="middle" width="100%">
                              <div class="sortable_inner">
                                 <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                       <td class="em_h40" height="45"></td>
                                    </tr>
                                 </table>
                                 <table align="center" border="0" cellpadding="0" cellspacing="0" class="full" width="100%">
                                    <tr>
                                       <td align="center" valign="middle" width="100%">
                                          <table align="center" border="0" cellpadding="0" cellspacing="0" class="fullCenter" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="100%">
                                             <tr>
                                                <td align="center" style="font-size:26px; color:#36628b; font-family:'Lato',Arial, sans-serif; font-weight:600; line-height:26px;" width="100%">Thank you for your order,</td>
                                             </tr>
                                          </table>
                                       </td>
                                    </tr>
                                 </table>
                                 <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                       <td height="35"></td>
                                    </tr>
                                 </table>
                                 <table align="center" border="0" cellpadding="0" cellspacing="0" class="full" width="100%">
                                    <tr>
                                       <td align="center" valign="middle" width="100%">
                                          <table align="center" border="0" cellpadding="0" cellspacing="0" class="fullCenter" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="100%">
                                             <tr>
                                                <td style="font-size:16px; color:#000000; padding:0 15px; text-align: left; font-family:'Lato',Arial, sans-serif; font-weight:400; line-height:26px;" width="50%">Order Id : <?php echo $orders[0]->orderid;?></td>
                                                <td style="font-size:16px; color:#000000; padding:0 15px; text-align: right; font-family:'Lato',Arial, sans-serif; font-weight:400; line-height:26px;" width="50%">Placed On : <?php $date=date_create($orders[0]->order_date);echo date_format($date,"d-m-Y");?></td>
                                             </tr>
                                          </table>
                                       </td>
                                    </tr>
                                 </table>
                                 <table align="center" border="0" cellpadding="0" cellspacing="0" class="full" width="570">
                                    <tr>
                                       <td bgcolor="#FAFAFA" height="15"></td>
                                    </tr>
                                   <?php if(is_array($orderproducts)){
                                            foreach ($orderproducts as $ord){
                                                $image = $ord->image;
                                                ?>
                                    <tr>
                                       <td align="center" bgcolor="#FAFAFA" class="em_pad" valign="top">
                                          <table align="center" border="0" cellpadding="0" cellspacing="0" class="full" width="500">
                                             <tr>
                                                <td><img alt="" border="0" src="<?php echo $image;?>" style="margin-right: 15px;" width="58"></td>
                                                <td align="left" style="font-size:13px; color:#aaaaaa; font-family:'Lato',Arial, sans-serif; font-weight:400;" valign="middle" width="63%"><span style="font-size:15px; color:#36628b; font-family:'Lato',Arial, sans-serif; font-weight:700;"><?php echo $ord->name;?></span><br>
                                                    Qty : <?= $ord->qty;?>
                                                </td>
                                                <td align="left" style="font-size:13px; color:#36628b; font-family:'Lato',Arial, sans-serif; font-weight:400;" width="25%">Price<br>
                                                <span style="font-size:15px; color:#000; font-family:'Lato',Arial, sans-serif; font-weight:700;">Rs.<?php echo number_format($ord->price);?></span></td>
                                             </tr>
                                          </table>
                                       </td>
                                    </tr>
                                                <?php
                                            }
                                        }
                                    ?>
                                    <tr>
                                       <td bgcolor="#FAFAFA" height="15"></td>
                                    </tr>
                                    <tr>
                                       <td bgcolor="#FFFFFF" height="3"></td>
                                    </tr>
                                    <tr>
                                       <td bgcolor="#FAFAFA" height="15"></td>
                                    </tr>
                                     <?php
                                if(!empty($orders[0]->taxamount) && $orders[0]->taxamount !=0) {
                                    ?>
                                    <tr>
                                       <td align="center" bgcolor="#FAFAFA" class="em_pad" valign="top">
                                          <table align="center" border="0" cellpadding="0" cellspacing="0" class="full" width="500">
                                             <tr>
                                                <td align="left" colspan="3" style="font-size:13px; text-align: right; color:#36628b; font-family:'Lato',Arial, sans-serif; font-weight:400;" width="25%">Tax <span style="font-size:15px; color:#000; font-family:'Lato',Arial, sans-serif; font-weight:700;">Rs.<?php echo number_format($orders[0]->taxamount,2);?></span></td>
                                             </tr>
                                          </table>
                                       </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                    <tr>
                                       <td bgcolor="#FAFAFA" height="15"></td>
                                    </tr>
                                    <tr>
                                       <td bgcolor="#FFFFFF" height="3"></td>
                                    </tr>
                                    <tr>
                                       <td bgcolor="#FAFAFA" height="15"></td>
                                    </tr>
                                    <tr>
                                       <td align="center" bgcolor="#FAFAFA" class="em_pad" valign="top">
                                          <table align="center" border="0" cellpadding="0" cellspacing="0" class="full" width="500">
                                             <tr>
                                                <td align="left" colspan="3" style="font-size:13px; text-align: right; color:#36628b; font-family:'Lato',Arial, sans-serif; font-weight:400;" width="25%">Delivery Charges <span style="font-size:15px; color:#000; font-family:'Lato',Arial, sans-serif; font-weight:700;">Rs.<?php echo number_format($orders[0]->delivery_charges,2);?></span></td>
                                             </tr>
                                          </table>
                                       </td>
                                    </tr>
                                    <?php
                                        if(!empty($orders[0]->discount) && $orders[0]->discount !=0) {
                                            ?>
                                             <tr>
                                               <td bgcolor="#FAFAFA" height="15"></td>
                                            </tr>
                                            <tr>
                                               <td bgcolor="#FFFFFF" height="3"></td>
                                            </tr>
                                            <tr>
                                               <td bgcolor="#FAFAFA" height="15"></td>
                                            </tr>
                                            <tr>
                                               <td align="center" bgcolor="#FAFAFA" class="em_pad" valign="top">
                                                  <table align="center" border="0" cellpadding="0" cellspacing="0" class="full" width="500">
                                                     <tr>
                                                        <td align="left" colspan="3" style="font-size:13px; text-align: right; color:#36628b; font-family:'Lato',Arial, sans-serif; font-weight:400;" width="25%">Discount <span style="font-size:15px; color:#000; font-family:'Lato',Arial, sans-serif; font-weight:700;"><?php echo $orders[0]->discount."%";?></span></td>
                                                     </tr>
                                                  </table>
                                               </td>
                                            </tr>
                                            <?php
                                        }
                                    ?>  
                                   
                                    <tr>
                                       <td bgcolor="#FAFAFA" height="15"></td>
                                    </tr>
                                    <tr>
                                       <td bgcolor="#FFFFFF" height="3"></td>
                                    </tr>
                                    <tr>
                                       <td bgcolor="#FAFAFA" height="15"></td>
                                    </tr>

                                    <tr>
                                       <td align="center" bgcolor="#FAFAFA" class="em_pad" valign="top">
                                          <table align="center" border="0" cellpadding="0" cellspacing="0" class="full" width="500">
                                             <tr>
                                                <td align="left" colspan="3" style="font-size:13px; text-align: right; color:#36628b; font-family:'Lato',Arial, sans-serif; font-weight:400;" width="25%">Total Amount <span style="font-size:15px; color:#000; font-family:'Lato',Arial, sans-serif; font-weight:700;">Rs.<?php echo number_format($orders[0]->totalamount,2);?></span></td>
                                             </tr>
                                          </table>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td bgcolor="#FAFAFA" height="15"></td>
                                    </tr>
                                    <tr>
                                       <td bgcolor="#FFFFFF" height="3"></td>
                                    </tr>
                                 </table>
                                 <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                       <td class="em_h30" height="32"></td>
                                    </tr>
                                 </table><!-- Centered Button -->
                                  <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="font-family: arial; line-height: 23px; border:1px solid #ccc;">
                                    <tr>
                                       <td class="em_h30" valign="top" style="padding:5px; border-right:1px solid #ccc;"><b>Billing Address</b> <br>
                                        <?php
                                            echo $order_bill[0]->bfname."<br />";
                                            echo $order_bill[0]->baddress."<br />";
                                            echo $order_bill[0]->bpincode."<br />";
                                            echo "Phone No.:". $order_bill[0]->bphone."<br />";
                                            echo "Email ID:". $order_bill[0]->bemail."<br />";
                                        ?>
                                       </td>
                                       <td class="em_h30" valign="top" style="padding:5px;"><b>Shipping Address</b><br>
                                        <?php
                                           if(!empty($order_bill[0]->sfname)) {echo $order_bill[0]->sfname."<br />";} 
                                            if(!empty($order_bill[0]->saddress)) {echo $order_bill[0]->saddress."<br />"; }
                                            if(!empty($order_bill[0]->spincode)) {echo $order_bill[0]->spincode."<br />"; }
                                           if(!empty($order_bill[0]->sphone)) { echo "Phone No.:".$order_bill[0]->sphone."<br />"; }
                                            if(!empty($order_bill[0]->semail)){echo "Email ID:".$order_bill[0]->semail."<br />"; }
                                        ?>
                                       </td>
                                    </tr>
                                 </table><!-- Centered Button -->
                                 <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                       <td class="em_h30" height="32"></td>
                                    </tr>
                                 </table><!-- Centered Button -->
                                 <table align="center" border="0" cellpadding="0" cellspacing="0" class="em_wrapper">
                                    <tr>
                                       <td align="center" width="100%">
                                          <table align="center" border="0" cellpadding="0" cellspacing="0" class="mcenter" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                                             <tr>
                                                <td align="center" width="100%">
                                                   <!-- SORTABLE -->
                                                   <div class="sortable_inner">
                                                      <table border="0" cellpadding="0" cellspacing="0" class="mcenter" width="100%">
                                                         <tr>
                                                            <td align="center" bgcolor="#36628B" height="40" style="font-size:14px; font-family:'Lato',Arial, sans-serif; font-weight:400; color:#ffffff; border-radius:5px; background:#36628b; padding-left:15px; padding-right:15px;" valign="middle">
                                                               <a href="<?= base_url().'login'; ?>" style="text-decoration:none; color:#ffffff; line-height:18px; display:block;" target="_blank">View your Account</a>
                                                            </td>
                                                         </tr>
                                                      </table>
                                                   </div>
                                                </td>
                                             </tr>
                                          </table>
                                       </td>
                                    </tr>
                                 </table><!-- End Button -->
                                 <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                       <td class="em_h30" height="38"></td>
                                    </tr>
                                 </table>
                                 <table align="left" border="0" cellpadding="0" cellspacing="0" style="font-size:13px; font-family:'Lato',Arial, sans-serif;" width="65%">
                                    <tr>
                                       <td style="color:#36628b; font-weight:600; font-size:14px; padding:0 15px 5px 15px;">For any query contact</td>
                                    </tr>
                                    <tr>
                                       <td style="padding:0 15px;">+91 9988666777<br>
                                       info@icchha.com</td>
                                    </tr>
                                 </table>
                                 <table align="right" border="0" cellpadding="0" cellspacing="0" style="font-size:13px; font-family:'Lato',Arial, sans-serif;" width="35%">
                                    <tr>
                                       <td style="color:#36628b; font-weight:600; font-size:14px; padding:0 15px 10px 0px;">Join Us</td>
                                    </tr>
                                    <tr>
                                       <td align="left" valign="middle">
                                        <?php
                                            if(count($social) >0) {
                                                $f = $social[0]->facebook; 
                                                $t = $social[0]->twitter; 
                                                $y = $social[0]->youtube; 
                                                $i = $social[0]->instagram; 
                                                $l = $social[0]->linkedin; 
                                                if(!empty($f)) {
                                                    ?>
                                                    <a href="<?= $f;?>" style="text-decoration:none; display: inline-table; margin-right: 5px;" target="_parent"><img alt="Fb" border="0" src="<?php echo asset_url(); ?>images/f.png" style="font-family:Arial, sans-serif; font-size:15px; color:#272727; display:block;" width="26"></a>
                                                    <?php
                                                }
                                                if(!empty($t)) {
                                                    ?>
                                                    <a href="<?= $t;?>" style="text-decoration:none; display: inline-table; margin-right: 5px;" target="_parent"><img alt="Tw" border="0" src="<?php echo asset_url(); ?>images/t.png" style="font-family:Arial, sans-serif; font-size:15px; color:#272727; display:block;" width="26"></a> 
                                                    <?php
                                                }
                                                if(!empty($y)) {
                                                    ?>
                                                     <a href="<?= $y; ?>" style="text-decoration:none; display: inline-table; margin-right: 5px;" target="_parent"><img alt="In" border="0" src="<?php echo asset_url(); ?>images/y.png" style="font-family:Arial, sans-serif; font-size:15px; color:#272727; display:block;" width="26"></a>
                                                    <?php
                                                }
                                                if(!empty($i)) {
                                                    ?>
                                                    <a href="<?= $i;?>" style="text-decoration:none; display: inline-table; margin-right: 5px;" target="_parent"><img alt="G+" border="0" src="<?php echo asset_url(); ?>images/i.png" style="font-family:Arial, sans-serif; font-size:15px; color:#272727; display:block;" width="26"></a>
                                                    <?php
                                                }
                                                if(!empty($l)) {
                                                    ?>
                                                     <a href="<?= $l;?>" style="text-decoration:none; display: inline-table; margin-right: 5px;" target="_parent"><img alt="In" border="0" src="<?php echo asset_url(); ?>images/l.png" style="font-family:Arial, sans-serif; font-size:15px; color:#272727; display:block;" width="26"></a> 
                                                    <?php
                                                }
                                            }
                                        ?>
                                       </td>
                                    </tr>
                                 </table>
                                 <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                       <td class="em_h30" height="38"></td>
                                    </tr>
                                 </table>
                              </div>
                           </td>
                        </tr>
                     </table>
                  </td>
               </tr>
            </table>
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
               <tr>
                  <td class="em_h40" height="40"></td>
               </tr>
            </table>
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
               <tr>
                  <td align="center" valign="top">
                     <!-- SORTABLE -->
                     <table align="center" border="0" cellpadding="0" cellspacing="0" class="full" style="table-layout:fixed;" width="400">
                        <tr>
                           <td>
                              <div class="sortable_inner">
                                 <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                       <td align="center" style="font-family:'Lato', Arial, sans-serif; font-weight:400; font-size:11px; color:#aaaaaa; line-height:22px;" valign="top">&copy; Copyright 2022. All Rights Reserved.</td>
                                    </tr>
                                 </table>
                                 <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                       <td class="em_h1" height="73"></td>
                                    </tr>
                                 </table>
                              </div>
                           </td>
                        </tr>
                     </table>
                  </td>
               </tr>
            </table>
         </td>
      </tr>
   </table><!-- End of Notify 7-->
</body>
</html>
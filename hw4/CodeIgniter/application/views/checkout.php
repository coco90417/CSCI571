<?php
    $bill = explode(",", $billaddress);
    if(isset($bill[0]) && isset($bill[1])  && isset($bill[2]) && isset($bill[3])  ){
        
        $street = $bill[0];
        $city = $bill[1];
        $state = $bill[2];
        $postcode = $bill[3];
    }else{
        $street = "";
        $city = "";
        $state = "";
        $postcode="";
    }
    $ship = explode(",", $shipaddress);
    if(isset($ship[0]) && isset($ship[1])  && isset($ship[2]) && isset($ship[3]) ){
        $shipstreet = $ship[0];
        $shipcity = $ship[1];
        $shipstate = $ship[2];
        $shippostcode = $ship[3];
        
    }else{
        $shipstreet = "";
        $shipcity = "";
        $shipstate = "";
        $shippostcode = "";
    }
    ?>

<div style="margin:0 auto; width:500px; z-index:1">
<fieldset style="display:inline-block; width:500px">
<legend>Update My Information</legend>
<form method="POST" action="<?php echo base_url('index.php/user/checkout');?>">
Email : <br>
<input id="update-email" name="update-email" placeholder="email" type="email" size="60" value="<?php echo $username; ?>" required/><br>
Password : <br>
<input id="update-password" name="update-password" placeholder="password" type="password" size="60" value="<?php echo $password; ?>" required /><br>
Firstname: <br>
<input id="update-firstname" name="update-firstname" placeholder="firstname" maxlength="60" size="60" type="text" value="<?php echo $firstname; ?>" required/><br>
Lastname :<br>
<input id="update-lastname" name="update-lastname" placeholder="lastname" maxlength="60" size="60" type="text" value="<?php echo $lastname; ?>" required/><br>
Billing Address :<br>
<input id="update-bill-street" name="update-bill-street" placeholder="street" maxlength="60" size="60" type="text" value="<?php echo $street; ?>" required />
<input id="update-bill-city" name="update-bill-city" placeholder="city" maxlength="60"  size="60" type="text" value="<?php echo $city; ?>" required />
<input id="update-bill-state" name="update-bill-state" placeholder="state" maxlength="2" size="60" pattern="AL|AK|AR|AZ|CA|CO|CT|DC|DE|FL|GA|HI|IA|ID|IL|IN|KS|KY|LA|MA|MD|ME|MI|MN|MO|MS|MT|NC|ND|NE|NH|NJ|NM|NV|NY|OH|OK|OR|PA|RI|SC|SD|TN|TX|UT|VA|VT|WA|WI|WV|WY|al|ak|ar|az|ca|co|ct|dc|de|fl|ga|hi|ia|id|il|in|ks|ky|la|ma|md|me|mi|mn|mo|ms|mt|nc|nd|ne|nh|nj|nm|nv|ny|oh|ok|or|pa|ri|sc|sd|tn|tx|ut|va|vt|wa|wi|wv|wy" title="Two letter state code" type="text" value="<?php echo $state; ?>"  required />
<input id="update-bill-postcode" name="update-bill-postcode" placeholder="postcode" type="text" maxlength="5" pattern="[0-9]{5}" value="<?php echo $postcode; ?>"  required title="Postcode" /><br>
Shipping Address: <br>
<input id="update-ship-street" name="update-ship-street" placeholder="street" maxlength="60" size="60" type="text" value="<?php echo $shipstreet; ?>"  required />
<input id="update-ship-city" name="update-ship-city" placeholder="city" maxlength="60"  size="60" type="text" value="<?php echo $shipcity; ?>"  required />
<input id="update-ship-state" name="update-ship-state" placeholder="state" maxlength="2" size="60" pattern="AL|AK|AR|AZ|CA|CO|CT|DC|DE|FL|GA|HI|IA|ID|IL|IN|KS|KY|LA|MA|MD|ME|MI|MN|MO|MS|MT|NC|ND|NE|NH|NJ|NM|NV|NY|OH|OK|OR|PA|RI|SC|SD|TN|TX|UT|VA|VT|WA|WI|WV|WY|al|ak|ar|az|ca|co|ct|dc|de|fl|ga|hi|ia|id|il|in|ks|ky|la|ma|md|me|mi|mn|mo|ms|mt|nc|nd|ne|nh|nj|nm|nv|ny|oh|ok|or|pa|ri|sc|sd|tn|tx|ut|va|vt|wa|wi|wv|wy" title="Two letter state code" type="text"  value="<?php echo $shipstate; ?>"  required />
<input id="update-ship-postcode" name="update-ship-postcode" placeholder="postcode" type="text" pattern="[0-9]{5}" maxlength="5" pattern="[0-9]{5}" title="Postcode"  value="<?php echo $shippostcode; ?>"  required /><br>
Credit Card Number: <br>
<input id="update-card" name="update-card" placeholder="card number" type="text" maxlength="16" pattern="[0-9]{16}" size="60"   title="16-digit credit card number"  value="<?php echo $creditcard; ?>"  required/><br>
Security Code: <br>
<input id="update-security" name="update-security" placeholder="security code" type="text" maxlength="3" pattern="[0-9]{3}"   title="3-digit security code" value="<?php echo $security; ?>"  size="60" required/><br>
Expiration Date: <br>
<input id="update-expire" name="update-expire" placeholder="expiration date" type="date"  value="<?php echo $expirationdate; ?>"  required/><br>
<input id="checkout-pay-submit" name="update-submit" class="checkout-pay-submit" value="Proceed To Checkout" type="submit" />
</form>
</fieldset>
</div>

<br>





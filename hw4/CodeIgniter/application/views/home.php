


<div id="please-login" style="color:red; font-weight:bold"></div>


<table border="1" style="border-collapse: separate; border-spacing: 10px 20px; display:inline; ">
<tr>
<td>Price</td>
<td>Order</td>
<td>Name</td>
<td>Description</td>


<?php
    if(isset($specials)){
    foreach($specials as $subject)
    {
       
            // | productid | productcategoryid | productname  | productdescription  | productprice | specialsalesid | productid | startdate  | enddate    | percentoff |
            ?>
 
<tr>
<div style='text-align: center'>
<td width="300" style="text-align:center">
<span style='text-decoration:line-through; color:gray'>$<?php echo $subject["productprice"]; ?></span><span style='color: red'>$<?php echo $subject["productprice"] * (1-$subject["percentoff"]/100) ; ?><br>You Will Save $<?php echo $subject["productprice"] * $subject["percentoff"]/100 ; ?> (<?php echo $subject["percentoff"] ; ?>%)</span></td>
<td width="300" style="text-align:center">
<form id="add-cart-form" method="post" action="" >

<input type="number" id="add-cart-special" name="add-cart-special" min="1" value="1" max="10000" style="width:40px"/>
<input type="hidden" id="productid-cart-special" name="productid-cart-special" value=<?php echo "'" . $subject['productid'] . "'" ;?> />
<input type="hidden" id="productprice-cart-special" name="productprice-cart-special" value=<?php echo "'" . $subject["productprice"] * (1-$subject["percentoff"]/100) . "'" ;?> />

<?php $productid=$subject['productid']; $orderprice= $subject["productprice"] * (1-$subject["percentoff"]/100); ?>

<input type="submit" id="button-cart-special" name="button-cart-special-name" class="button-cart-special" value="Add to My Cart" disabled/></td>
</form>
<td width="400"><?php echo $subject["productname"]; ?></td>
<td width="600"> <?php echo $subject["productdescription"]; ?> </td>
</div>
</tr>

<?php
    }
    }
    ?>


</table>


<br>

<div style="color:red; font-weight:bold; display:none;" id="myElem" >Successfully updated orderitems!</div>


<div id="similarProducts">
</div>







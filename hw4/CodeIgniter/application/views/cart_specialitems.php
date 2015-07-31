<tr>
<div class='one-product'  style='text-align: center'>
<td width="400" style="text-align:center">
<span style='text-decoration:line-through; color:gray'>$<?php echo $productprice; ?></span><span style='color: red'>$<?php echo $productprice * (1-$percentoff/100) ; ?><br>You Will Save $<?php echo $productprice * $percentoff/100 ; ?> (<?php echo $percentoff ; ?>%)
</span>
</td>
<td width="300" style="text-align:center">


<form id="add-cart-form" method="post" action="" >
<input type="number" id="add-cart" class="update-cart-number" name="add-cart" min="1" value="<?php echo $count; ?>" max="10000"  style="width:40px"/>
<input type="button" id="delete-product" class="delete-product"  name="delete-product" value="Delete" />
<input type="hidden" id="productid-cart" name="productid-cart" value=<?php echo "'" . $productid . "'" ;?> />
<input type="hidden" id="productprice-cart" name="productprice-cart" value=<?php echo "'" . $productprice * (1-$percentoff/100) . "'" ;?> />
<td width="400"><?php echo $productname; ?></td>
</form>
</div>
</tr>




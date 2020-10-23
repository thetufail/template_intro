<?php

session_start();
$totalPriceOfAllProduct = 0;

if (isset($_GET['delete_product'])) {
  unset($_SESSION["productInCart"][$_GET['delete_product']]);
  array_values($_SESSION["productInCart"]);
}

if (isset($_GET['update_cart'])) {
    foreach ($_SESSION["productInCart"] as $key => $value) {
        if (isset($_GET[$value["id"]])) {
            if (is_numeric($_GET[$value["id"]]) && $_GET[$value["id"]] > 0) {
                $_SESSION["productInCart"][$key]["quantity"] = (int)($_GET[$value["id"]]);
                $_SESSION["productInCart"][$key]["totalPrice"] = $_SESSION["productInCart"][$key]["quantity"] * $_SESSION["productInCart"][$key]["price"];
            }
        }    
    }
}

$cart_listed = '';
$cart_listed .= '<table class="table">
<thead>
  <tr>
    <th></th>
    <th></th>
    <th>Product</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Total</th>
  </tr>
</thead>
<tbody>';
foreach ($_SESSION["productInCart"] as $key => $value) {
    $cart_listed .= '<tr>
    <td><a class="remove" href="cart.php?delete_product='.$key.'"><fa class="fa fa-close"></fa></a></td>
    <td><a href="#"><img src="admin/product_images/'.$value["image"].'" alt="img"></a></td>
    <td><a class="aa-cart-title" href="#">'.$value["name"].'</a></td>
    <td>$'.$value["price"].'</td>
    <td><input class="aa-cart-quantity" type="number" name = '.$value["id"].' value="'.$value["quantity"].'"></td>
    <td>$'.$value["totalPrice"].'</td>
    </tr>';
    $totalPriceOfAllProduct += $value["totalPrice"];
}

$cart_listed .= '<tr><td colspan="6" class="aa-cart-view-bottom">
  <div class="aa-cart-coupon">
    <input class="aa-coupon-code" type="text" placeholder="Coupon">
    <input class="aa-cart-view-btn" type="submit" value="Apply Coupon">
  </div>
  <input class="aa-cart-view-btn" type="submit" name="update_cart" value="Update Cart">
  </td>
  </tr>
  </tbody>
</table>';

$_SESSION["total"] = $totalPriceOfAllProduct;

?>
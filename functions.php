<?php 

include('C:\xampp\htdocs\training\template_intro\admin\configdb.php');

$productId = $_POST['id'];

$check = "SELECT * FROM products";
// $product_in_cart = array();

$result = $conn->query($check);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row["product_id"] == $productId) {
                $productInfo = array("id" => $row["product_id"], "image" => $row["image"], "name" => $row["name"], "price" => $row['price'], "quantity" => 1, "totalPrice" => 0);
                $productInfo["totalPrice"] = $productInfo["quantity"] * $productInfo["price"];
                // $_SESSION["totalPriceOfAllProduct"] += $productInfo["price"];
                // array_push($product_in_cart, $productInfo);
            // } 
            // else {
            //     foreach ($product_in_cart as $key => $value) {
            //         if ($row["product_id"] != $value["id"]) {
            //             $c += 1;
            //         } else {
            //             $product_in_cart[$key]["quantity"] += 1;
            //             $product_in_cart[$key]["totalPrice"] = $product_in_cart[$key]["quantity"] * $row["price"];
            //             // $_SESSION["totalPriceOfAllProduct"] += $product_in_cart[$key]["price"];
            //             break;
            //         }
            //     }
            //     if ($c == count($product_in_cart)) {
            //         $productInfo = array("id" => $row["product_id"], "item" => $row["name"], "price" => $row["price"], "quantity" => 1, "totalPrice" => 0);
            //         $productInfo["totalPrice"] = $productInfo["quantity"] * $row["price"];
            //         // $_SESSION["totalPriceOfAllProduct"] += $productInfo["price"];
            //         array_push($product_in_cart, $productInfo);
            //     }
            // }
        }
    }
}

echo json_encode(array('product'=>$productInfo));

?>
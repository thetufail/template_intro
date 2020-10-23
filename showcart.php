<?php

session_start();
include('C:\xampp\htdocs\training\template_intro\admin\configdb.php');

$productId = $_POST['id'];
$check = "SELECT * FROM products";
$result = $conn->query($check);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row["product_id"] == $productId) {
            $c = 0;
            if ($c == count($_SESSION["productInCart"])) {
                $productInfo = array("id" => $row["product_id"], "image" => $row["image"], "name" => $row["name"], "price" => $row["price"], "quantity" => 1, "totalPrice" => 0);
                $productInfo["totalPrice"] = $productInfo["quantity"] * $productInfo["price"];
                array_push($_SESSION["productInCart"], $productInfo);
            } else {
                foreach ($_SESSION["productInCart"] as $key => $value) {
                    if ($productId != $value["id"]) {
                        $c += 1;
                    } else {
                        $_SESSION["productInCart"][$key]["quantity"] += 1;
                        $_SESSION["productInCart"][$key]["totalPrice"] = $_SESSION["productInCart"][$key]["quantity"] * $_SESSION["productInCart"][$key]["price"];
                        $_SESSION["totalPriceOfAllProduct"] += $_SESSION["productInCart"][$key]["price"];
                        break;
                    }
                }
                if ($c == count($_SESSION["productInCart"])) {
                    $productInfo = array("id" => $row["product_id"], "image" => $row["image"], "name" => $row["name"], "price" => $row["price"], "quantity" => 1, "totalPrice" => 0);
                    $productInfo["totalPrice"] = $productInfo["quantity"] * $productInfo["price"];
                    array_push($_SESSION["productInCart"], $productInfo);
                }
            }
        }
    }
}

// $_SESSION["productInCart"]=[];
echo json_encode(array('product'=>$_SESSION["productInCart"]));


?>
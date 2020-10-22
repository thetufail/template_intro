<?php

include('C:\xampp\htdocs\training\template_intro\admin\configdb.php');

if (!empty($_SESSION["productInCart"])) {
    $cartdata = json_encode($_SESSION["productInCart"]);
}
if (!empty($_SESSION["totalSum"])) {
    $carttotal = $_SESSION["total"];
}
$datetime = date("Y-m-d h:i:sa");
$status = "Yet to be shipped.";

if (isset($_GET['proceed_checkout'])) {
    $sql = "INSERT INTO orders (`user_id`, `cartdata`, `total`, `status`, `datetime`) 
    VALUES(NULL,'".$cartdata."','".$carttotal."','".$status."','".$datetime."')";
    $result = $conn->query($sql);
    if ($result === true) {
        header('Location: product.php');
    }
    $_SESSION["productInCart"]=[];
    $_SESSION["total"]=[];
}

$conn->close();

?>

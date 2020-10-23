<?php

include('C:\xampp\htdocs\training\template_intro\admin\configdb.php');
$viewId = $_POST['vid'];
$query = "SELECT *FROM products WHERE product_id=".$viewId;  

$view = array(
    "product_image"=>'',
    "product_name"=>'',
    "product_price"=>'',
    "product_short_desc"=>'',
    "product_color"=>'',
    "product_quantity"=>'',
    "product_category"=>''
);

$result = $conn->query($query);  
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories = "SELECT * FROM categories WHERE `category_id` = '".$row["category_id"]."'";
        $result_categories = $conn->query($categories);

        $view["product_image"] ='admin/product_images/'.$row["image"].' "alt="'.$row["name"].'';
        $view["product_name"] =''.$row["name"].'';
        $view["product_price"] =''.$row["price"].'';
        $view["product_short_desc"] =''.$row["short_desc"].'';

        while ($row_category = $result_categories->fetch_assoc()) {
            $view["product_category"] =''.$row_category["name"].'';
        }

        $colors = "SELECT * FROM colors WHERE `product_id` = '".$row["product_id"]."'";
        $result_color = $conn->query($colors);

        while ($row_color = $result_color->fetch_assoc()) {
            $view["product_color"] ='<a href="#">'.$row_color["color"].'</a>';
            $view["product_quantity"] =''.$row_color["quantity"].'';
        }
    }
}

echo json_encode(array('quickview'=>$view));

?>
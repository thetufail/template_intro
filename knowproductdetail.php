<?php

if (isset($_GET['product_detail'])) {
    $query = "SELECT *FROM products WHERE product_id=".$_GET['product_detail'];  
    $result = $conn->query($query);  

    $product_image='';
    $product_name='';
    $product_price='';
    $product_short_desc='';
    $product_color='';
    $product_quantity='';
    $product_category='';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categories = "SELECT * FROM categories WHERE `category_id` = '".$row["category_id"]."'";
            $result_categories = $conn->query($categories);

            $product_image.='admin/product_images/'.$row["image"].' "alt="'.$row["name"].'';
            $product_name.=''.$row["name"].'';
            $product_price.=''.$row["price"].'';
            $product_short_desc.=''.$row["short_desc"].'';

            while ($row_category = $result_categories->fetch_assoc()) {
                $product_category.=''.$row_category["name"].'';
            }

            $colors = "SELECT * FROM colors WHERE `product_id` = '".$row["product_id"]."'";
            $result_color = $conn->query($colors);

            while ($row_color = $result_color->fetch_assoc()) {
                $product_color.='<a href="#">'.$row_color["color"].'</a>';
                $product_quantity.=''.$row_color["quantity"].'';
            }
        }
    }   
}

?>
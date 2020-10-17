<?php

$products = "SELECT * FROM products";
$result = $conn->query($products);

$products_listed='';
$products_listed='<ul class="aa-product-catg">';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
            
        $products_listed.='<li>
        <figure>
            <a class="aa-product-img" href="#"><img src="admin/product_images/'.$row["image"].'" alt="'.$row["name"].'"></a>
            <a class="aa-add-card-btn"href="#"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
            <figcaption>
            <h4 class="aa-product-title"><a href="#">'.$row["name"].'</a></h4>
            <span class="aa-product-price">$'.$row["price"].'</span>
            <p class="aa-product-descrip">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Numquam accusamus facere iusto, autem soluta amet sapiente ratione inventore nesciunt a, maxime quasi consectetur, rerum illum.</p>
            </figcaption>
        </figure>                         
        <div class="aa-product-hvr-content">
            <a href="#" data-toggle2="tooltip" data-placement="top" title="Quick View" data-toggle="modal" data-target="#quick-view-modal"><span class="fa fa-search"></span></a>                            
        </div>
        <!-- product badge -->
        <span class="aa-badge aa-sale" href="#">SALE!</span>
        </li>';
    }
}                                        
$products_listed.='</ul>';

?>
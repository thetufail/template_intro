<?php

//define total number of results you want per page  
$results_per_page = 10;  
  
//find the total number of results stored in the database  
$products = "SELECT * FROM products";  
$result = $conn->query($products);
$number_of_result = $result->num_rows; 
  
//determine the total number of pages available  
$number_of_page = ceil($number_of_result / $results_per_page);  
  
//determine which page number visitor is currently on  
if (!isset($_GET['page']) ) {  
    $page = 1;  
} else {  
    $page = $_GET['page'];  
}

//determine the sql LIMIT starting number for the results on the displaying page  
$page_first_result = ($page-1) * $results_per_page;  

//retrieve the selected results from database   
$query = "SELECT *FROM products LIMIT " . $page_first_result . ',' . $results_per_page;  
$result = $conn->query($query);

$products_listed='';
$products_listed='<ul class="aa-product-catg">';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
            
        $products_listed.='<li>
        <figure>
            <a class="aa-product-img" href="product-detail.php?product_detail='.$row["product_id"].'"><img src="admin/product_images/'.$row["image"].'" alt="'.$row["name"].'"></a>
            <a class="aa-add-card-btn add-to-cart" href="#" data-pids='.$row["product_id"].'><span class="fa fa-shopping-cart"></span>Add To Cart</a>
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

if (isset($_GET['page']) ) {  
    if ($_GET['page']>1) {
        $prev = $_GET['page']-1;
    } else {
        $prev = $_GET['page'];
    }
    if ($_GET['page']<$number_of_page) {
        $next = $_GET['page']+1;
    } else {
        $next = $_GET['page'];
    }
} else {
    $prev=null;
    $next=null;
}

//display the link of the pages in URL
$pages_list='';
$pages_list.='<ul class="pagination"><li><a href="product.php?page='.$prev.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
for ($page = 1; $page<= $number_of_page; $page++) {  
    $pages_list.='<li><a href="product.php?page='.$page.'">'.$page.'</a></li>';
}
$pages_list.='<li><a href="product.php?page='.$next.'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li></ul>';

?>
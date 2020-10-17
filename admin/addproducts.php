<?php

$errors = array();
$sql = '';

if (isset($_POST['addProduct'])) {
    $name = isset($_POST['name']) ? $_POST['name']:'';
    $price = isset($_POST['price']) ? $_POST['price']:'';

    $image = $_FILES['image']['name']; 
    $tempname = $_FILES['image']['tmp_name'];
    $folder = "product_images/".$image;

    $category = isset($_POST['category']) ? $_POST['category']:'';
    $tags_checked = isset($_POST['checkedtags']) ? $_POST['checkedtags']:'';
    $color = isset($_POST['color']) ? $_POST['color']:'';
    $description = isset($_POST['description']) ? $_POST['description']:'';

    $short_desc = "";
    $long_desc = "";                                                            

    if (strlen($description) > 20) {
        $long_desc = $description;
    } else {
        $short_desc = $description;
    }

    if (move_uploaded_file($tempname, $folder)) {
        $sql = "INSERT INTO products (`category_id`, `name`, `price`, `image`, `short_desc`, `long_desc`) 
        VALUES('".$category."','".$name."','".$price."','".$image."','".$short_desc."','".$long_desc."')";
    }

    if ($conn->query($sql) === true) {
        if (move_uploaded_file($tempname, $folder)) { 
            $msg = "Image uploaded successfully"; 
        }
    }

    $max_pid = $conn->query("SELECT MAX(`product_id`) FROM template_intro.products");
    $max_product_id = $max_pid->fetch_array()[0] ?? '';

    for ($i=0; $i<sizeof($tags_checked); $i++) {  
        $sql="INSERT INTO products_tags (`product_id`, `tag_id`) 
        VALUES ('$max_product_id', '".$tags_checked[$i]."')";
        $result = $conn->query($sql);
    }

    $query="INSERT INTO colors (`color`, `quantity`) VALUES ('".$color."','1')";
    $result = $conn->query($query);
}

$categories = "SELECT * FROM categories";
$result = $conn->query($categories);
$category_html='';
$category_html.='<p><label>Category</label><select name="category" class="small-input">';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $category_html.='<option value="'.$row["category_id"].'">'.$row["name"].'</option>';
    }
}
$category_html.='</select></p>';

$tags = "SELECT * FROM tags";
$result = $conn->query($tags);
$tags_html='';
$tags_html.='<p><label>Tags</label>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tags_html.='<input type="checkbox" name="checkedtags[]" value="'.$row["tag_id"].'" />'.$row["name"];
    }
}
$tags_html.='</p>';

$products = "SELECT * FROM products";
$result = $conn->query($products);

$products_html = '';
$products_html.='<table>
                            
<thead>
    <tr>
       <th><input class="check-all" type="checkbox" /></th>
       <th>ID</th>
       <th>Item</th>
       <th>Price</th>
       <th>Category</th>
       <th>Tags</th>
       <th>Color</th>
       <th>Actions</th>
    </tr>
    
</thead>

<tfoot>
    <tr>
        <td colspan="8">
            <div class="bulk-actions align-left">
                <select name="dropdown">
                    <option value="option1">Choose an action...</option>
                    <option value="option2">Edit</option>
                    <option value="option3">Delete</option>
                </select>
                <a class="button" href="#">Apply to selected</a>
            </div>
            
            <div class="pagination">
                <a href="#" title="First Page">&laquo; First</a><a href="#" title="Previous Page">&laquo; Previous</a>
                <a href="#" class="number" title="1">1</a>
                <a href="#" class="number" title="2">2</a>
                <a href="#" class="number current" title="3">3</a>
                <a href="#" class="number" title="4">4</a>
                <a href="#" title="Next Page">Next &raquo;</a><a href="#" title="Last Page">Last &raquo;</a>
            </div> <!-- End .pagination -->
            <div class="clear"></div>
        </td>
    </tr>
</tfoot>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories = "SELECT * FROM categories WHERE `category_id` = '".$row["category_id"]."'";
        $result_categories = $conn->query($categories);

        $products_tags = "SELECT tag_id FROM products_tags WHERE `product_id` = '".$row["product_id"]."'";
        $result_products_tags = $conn->query($products_tags);
        
        $tags_in_a_line='';
        while ($row_tags = $result_products_tags->fetch_assoc()) {
            $tags = "SELECT * FROM tags WHERE `tag_id` = '".$row_tags["tag_id"]."'";
            $result_tags = $conn->query($tags);

            while ($row_tag_name = $result_tags->fetch_assoc()) {
                $tags_in_a_line.=$row_tag_name["name"].",";
            }
        }

        $colors = "SELECT * FROM colors WHERE `product_id` = '".$row["product_id"]."'";
        $result_color = $conn->query($colors);

        $products_html.='<tbody>
                    <tr>
                        <td><input type="checkbox" /></td>
                        <td>'.$row["product_id"].'</td>
                        <td>'.$row["name"].'</td>
                        <td>'.$row["price"].'</td>';
                        while ($row_category = $result_categories->fetch_assoc()) {
                            $products_html.='<td>'.$row_category["name"].'</td>';
                        }
                        $products_html.='<td>'.$tags_in_a_line.'</td>';
                        while ($row_color = $result_color->fetch_assoc()) {
                            $products_html.='<td>'.$row_color["color"].'</td>';
                        }
                        $products_html.='<td>
                            <!-- Icons -->
                            <a href="#" title="Edit"><img src="resources/images/icons/pencil.png" alt="Edit" /></a>
                            <a href="#" title="Delete"><img src="resources/images/icons/cross.png" alt="Delete" /></a> 
                            <a href="#" title="Edit Meta"><img src="resources/images/icons/hammer_screwdriver.png" alt="Edit Meta" /></a>
                        </td>
                    </tr>
                </tbody>';
    }
}            
$products_html.='</table>';

?>
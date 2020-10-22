<?php

$errors = array();
$orders = "SELECT * FROM orders";

if (isset($_GET['delete_order'])) {
    $conn->query("DELETE FROM orders WHERE order_id=".$_GET['delete_order']);
}

$result = $conn->query($orders);
$html = '';
$html.='<table>        
<thead>
  <tr>
  <th><input class="check-all" type="checkbox" /></th>
  <th>Order Id</th>
  <th>Products</th>
  <th>Total</th>
  <th>Status</th>
  <th>Datetime</th>
  <th>Actions</th>
  </tr>
</thead>
<tfoot>
  <tr>
    <td colspan="7">    
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
        $html.='<tbody>
                <tr>
                    <td><input type="checkbox" /></td>
                    <td>'.$row["order_id"].'</td>';
          if (!empty($row["cartdata"])) {
                        $products='';
                        $b = json_decode($row["cartdata"], true);
            foreach ($b as $key => $value) {
                if ($key < count($b)-1) {
                            $products.= $value["name"].', ';
                } else {
                            $products.= $value["name"].'.';
                }
            }
            $html.='<td>'.$products.'</td>';
      }
                    $html.=
                    '<td>'.$row["total"].'</td>
                    <td>'.$row["status"].'</td>
                    <td>'.$row["datetime"].'</td>
                    <td>
                        <!-- Icons -->
                        <a href="orders.php?edit_order='.$row["order_id"].'" title="Edit"><img src="resources/images/icons/pencil.png" alt="Edit" /></a>
                        <a href="orders.php?delete_order='.$row["order_id"].'" title="Delete"><img src="resources/images/icons/cross.png" alt="Delete" /></a> 
                    </td>
                </tr>
            </tbody>';
    }
}
$html.='</table>';

?>
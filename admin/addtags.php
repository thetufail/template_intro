<?php

$errors = array();
$sql = '';

if (isset($_POST['addTag'])) {
    $name = isset($_POST['tag']) ? $_POST['tag']:'';

    $sql = "INSERT INTO tags (`name`) VALUES('".$name."')";

    if ($conn->query($sql) === true) {
        $conn->close();
    }
}

$tags = "SELECT * FROM tags";
$result = $conn->query($tags);
$html = '';
$html.='<table>
            
<thead>
    <tr>
    <th><input class="check-all" type="checkbox" /></th>
    <th>ID</th>
    <th>Category</th>
    <th>Actions</th>
    </tr>
    
</thead>

<tfoot>
    <tr>
        <td colspan="4">
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
        
        $html.='<tbody>
                <tr>
                    <td><input type="checkbox" /></td>
                    <td>'.$row["tag_id"].'</td>
                    <td>'.$row["name"].'</td>
                    <td>
                        <!-- Icons -->
                        <a href="#" title="Edit"><img src="resources/images/icons/pencil.png" alt="Edit" /></a>
                        <a href="#" title="Delete"><img src="resources/images/icons/cross.png" alt="Delete" /></a> 
                        <a href="#" title="Edit Meta"><img src="resources/images/icons/hammer_screwdriver.png" alt="Edit Meta" /></a>
                    </td>
                </tr>
            </tbody>';
    }
}
$html.='</table>';

?>
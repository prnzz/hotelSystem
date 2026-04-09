<?php
include('../../conn/connection.php');
$db = mysqli_connect($host, $username, $password, $database);


$u_id = isset($_GET['unit_id']) ? mysqli_real_escape_string($db, $_GET['unit_id']) : null;

if ($u_id) {

    $query = mysqli_query($db, "SELECT * FROM roomlist WHERE unit_id = '$u_id'");
    $row = mysqli_fetch_array($query);

    if ($row) {
?>
<main style="text-align: center;">
    <div class="form-container">
        <button type="button" onclick="loadRooms()" style="float: left;">Back</button>
        <br>
        <h2>Edit Room Details</h2>
        <br>

        <label>Unit Name / Number</label><br>
        <input type="text" id="new_unit_name" value="<?php echo $row['unit_name']; ?>" placeholder="e.g. Room 101"><br><br>

        <label>Unit Type</label><br>
        <select id="new_unit_type">
            <?php 
            $types = mysqli_query($db, "SELECT * FROM unit_types");
            while($t = mysqli_fetch_array($types)) { 
                $selected = ($t['unit_type_id'] == $row['unit_type_id']) ? "selected" : "";
            ?>
                <option value="<?php echo $t['unit_type_id']; ?>" <?php echo $selected; ?>>
                    <?php echo $t['unit_type_name']; ?> (₱<?php echo $t['price_per_day']; ?>)
                </option>
            <?php } ?>
        </select><br><br>


        <input type="number" id="input_new_price_per_day" value="<?php echo $row['price_per_day']; ?>" placeholder="Price per Day" step="0.01"><br><br>
        
        <label>Floor</label><br>
        <input type="text" id="new_floor" value="<?php echo $row['floor']; ?>" readonly><br><br>

        <label>Category</label><br>
        <select id="new_category">
            <?php 
            $cats = mysqli_query($db, "SELECT * FROM categories");
            while($c = mysqli_fetch_array($cats)) { 
                $selected = ($c['category_id'] == $row['category_id']) ? "selected" : "";
            ?>
                <option value="<?php echo $c['category_id']; ?>" <?php echo $selected; ?>>
                    <?php echo $c['category_name']; ?>
                </option>
            <?php } ?>
        </select><br><br>

        <button type="button" id="<?php echo $u_id; ?>" onclick="updateRoomData(this.id)">Update Room</button>
    </div>
</main>
<?php 
    } else {
        echo "<p style='text-align:center; color:red;'>Room not found.</p>";
    }
} else {
    echo "<p style='text-align:center; color:red;'>Invalid room ID.</p>";
}
?>
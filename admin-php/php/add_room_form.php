<?php
include('../../conn/connection.php');
$db = mysqli_connect($host, $username, $password, $database);
?>
<main style="text-align: center;">
        <button type="button" onclick="loadRooms()" style="float: left;">Back</button>
        <h2>Add New Room</h2>
        <br>

        <label>Unit Name / Number</label><br>
        <input type="text" id="new_unit_name" placeholder="e.g. Room 101"><br><br>

        <label>Unit Type</label><br>
        <select id="new_unit_type">
            <option value="0">-- Select Type --</option>
            <?php 
            $types = mysqli_query($db, "SELECT * FROM unit_types");
            while($t = mysqli_fetch_array($types)) { ?>
                <option value="<?php echo $t['unit_type_id']; ?>">
                    <?php echo $t['unit_type_name']; ?> (₱<?php echo $t['price_per_day']; ?>)
                </option>
            <?php } ?>
        </select><br><br>

        <label>Category</label><br>
        <select id="new_category">
            <option value="0">-- Select Category --</option>
            <?php 
            $cats = mysqli_query($db, "SELECT * FROM categories");
            while($c = mysqli_fetch_array($cats)) { ?>
                <option value="<?php echo $c['category_id']; ?>">
                    <?php echo $c['category_name']; ?>
                </option>
            <?php } ?>
        </select><br><br>

        <button type="button" id="newRoomBtn" onclick="saveRoomData(this.id)">Save Room</button>
</main>
<?php
include('../../conn/connection.php');
$db = mysqli_connect($host, $username, $password, $database);

// Initialize ID from GET request
$u_id = isset($_GET['unit_id']) ? mysqli_real_escape_string($db, $_GET['unit_id']) : null;

if ($u_id) {
    // Fetch current details from the roomlist view
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

        <form id="editRoomForm">
            <input type="hidden" id="edit_unit_id" value="<?php echo $u_id; ?>">

            <label>Unit Name / Number</label><br>
            <input type="text" id="edit_unit_name" value="<?php echo $row['unit_name']; ?>">
            <br><br>

            <label>Unit Type & Category</label><br>
            <input type="text" value="<?php echo $row['unit_type_name']; ?> - <?php echo $row['category_name']; ?>" readonly>
            <br><br>
            <label>Status</label><br>
            <select id="edit_status">
                <option value="Available" <?php if($row['status'] == 'Available') echo 'selected'; ?>>Available</option>
                <option value="Occupied" <?php if($row['status'] == 'Occupied') echo 'selected'; ?>>Occupied</option>
                <option value="Maintenance" <?php if($row['status'] == 'Maintenance') echo 'selected'; ?>>Maintenance</option>
            </select>
            <br><br>

            <button type="button" id="<?php echo $u_id; ?>" onclick="updateRoomData(this.id)">Update Room</button>
        </form>
    </div>
</main>
<?php 
    } 
} 
?>
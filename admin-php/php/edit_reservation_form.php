<?php
include('../../conn/connection.php');
$db = mysqli_connect($host, $username, $password, $database);

$res_id = isset($_GET['reservation_id']) ? mysqli_real_escape_string($db, $_GET['reservation_id']) : null;

if ($res_id) {
    // Fetch current details from your view
    $query = mysqli_query($db, "SELECT * FROM current_reservation_in_customer WHERE reservation_id = '$res_id'");
    $row = mysqli_fetch_array($query);

    if ($row) {
?>
<main style="text-align: center;">
    <form id="editReservationForm">
        <button type="button" onclick="loadReservation()" style="float: left;">Back</button>
        <h2>Edit Reservation Form</h2>
        
        <input type="hidden" id="edit_res_id" value="<?php echo $res_id; ?>">

        <h4>Guest Information</h4>
        <input type="text" id="edit_guest_name" value="<?php echo $row['guest_name']; ?>" placeholder="Enter Guest Name"> <br><br>
        <input type="text" id="edit_contact" value="<?php echo $row['contact']; ?>" placeholder="Enter Contact Number"> <br><br>
        
        <input type="date" id="edit_check_in" value="<?php echo $row['check_in_date']; ?>">
        <input type="date" id="edit_check_out" value="<?php echo $row['expected_check_out']; ?>"> <br><br>

        <h4>Unit Details</h4>
        <select name="unit_id" id="edit_unit_id">
            <option value="<?php echo $row['unit_id']; ?>" data-price="<?php echo $row['price_per_day']; ?>" selected>
                <?php echo $row['unit_name']; ?> - <?php echo $row['unit_type_name']; ?> (Current)
            </option>
            
            <?php 
            // Also show other Available units in case they want to change rooms
            $unit_query = mysqli_query($db, "SELECT * FROM `roomlist` WHERE status = 'Available' AND unit_id != '".$row['unit_id']."'");
            while($res = mysqli_fetch_array($unit_query)) { 
            ?>
                <option value="<?php echo $res['unit_id']; ?>" data-price="<?php echo $res['price_per_day']; ?>">
                    <?php echo $res['unit_name']; ?> - <?php echo $res['unit_type_name']; ?>
                </option>
            <?php } ?>
        </select> 
        <br><br>

        <label>Price Per Day</label><br>
        <span class="currency-label">₱</span>
        <input type="number" id="edit_price" value="<?php echo $row['price_per_day']; ?>" readonly> <br><br>

        <label>Stay Duration (Days)</label><br>
        <input type="number" id="edit_duration" value="<?php echo $row['duration_days']; ?>" readonly> <br><br>

        <label>Total Amount</label><br>
        <span class="currency-label">₱</span>
        <input type="number" id="edit_total" value="<?php echo $row['total_bill']; ?>" readonly> <br><br>

        <button type="button" id="<?php echo $res_id; ?>" onclick="updateReservationData(this.id)">Update Reservation</button>
    </form>
</main>
<?php
    }
}
?>
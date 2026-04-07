<?php
include('../../conn/connection.php');
$db = mysqli_connect($host, $username, $password, $database);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reservation Entry Form</title>
    <style>
        .input-group { margin-bottom: 15px; }
        .currency-label { font-weight: bold; color: #2c3e50; }
    </style>
</head>
<body>
    <main style="text-align: center;">
        <form id="reservationForm">
            <h2>Reservation Entry Form</h2>
            
            <h4>Guest Information</h4>
            <input type="text" id="guest_name" placeholder="Enter Guest Name" required> <br><br>
            <input type="text" id="contact" placeholder="Enter Contact Number" required> <br><br>
            
            <label for="check_in_date">Check-in Date:</label><br>
            <input type="date" id="check_in_date" name="check_in_date" required><br>

            <label for="check_in_time">Check-in Time:</label><br>
            <input type="time" id="check_in_time" name="check_in_time" required><br><br>


            <label for="expected_check_out">Expected Check-out Date:</label><br>
            <input type="date" id="expected_check_out" name="check_out_date" required><br>

            <label for="check_out_time">Check-out Time:</label><br>
            <input type="time" id="check_out_time" name="check_out_time" required><br><br>

            <h4>Unit Details</h4>
            <select name="unit_id" id="unit_id" required>
                <option value="" data-price="0">Select Unit</option>
                <?php 
                $unit_query = mysqli_query($db, "SELECT * FROM `roomlist` WHERE status = 'Available'");
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
            <input type="number" id="price" name="price_per_day" value="0" readonly> <br><br>

            <label>Stay Duration (Days)</label><br>
            <input type="number" id="duration" name="duration_days" value="0" readonly> <br><br>

            <label>Total Amount</label><br>
            <span class="currency-label">₱</span>
            <input type="number" id="total" name="total_bill" value="0" readonly> <br><br>

            <button type="button" onclick="saveReservation()">Submit Reservation</button>
        </form>
    </main>
</body>
</html>
<?php
include('../../conn/connection.php');
$db = mysqli_connect($host, $username, $password, $database);

$res_id = isset($_GET['res_id']) ? mysqli_real_escape_string($db, $_GET['res_id']) : null;

if ($res_id) {
    $query = "SELECT * FROM current_reservation_in_customer WHERE reservation_id = '$res_id'";
    $result = mysqli_query($db, $query);
    $data = mysqli_fetch_array($result);

    if ($data) {
?>
<div class="user-information">
    <button onclick="loadReservation()">Back to List</button>
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2>Process Payment</h2>
    </div>

    <hr>

    <div class="information">
        <h3>Summary</h3>
        <p><strong>Guest:</strong> <?php echo $data['guest_name']; ?></p>
        <p><strong>Unit:</strong> <?php echo $data['unit_name']; ?> (<?php echo $data['unit_type_name']; ?>)</p>
        <p><strong>Total Bill:</strong> ₱<?php echo number_format($data['total_bill'], 2); ?></p>
    </div>

<div class="payment">
    <h3>Payment Entry</h3>
    <form id="payForm">
        <input type="hidden" id="res_id" name="res_id" value="<?php echo $res_id; ?>">
        
        <div style="margin-bottom: 10px;">
            <label>Amount to Pay:</label><br>
            <input type="number" id="amount_to_pay" value="<?php echo $data['total_bill']; ?>" step="0.01" readonly style="width: 100%; padding: 8px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Amount Paid:</label><br>
            <input type="number" id="amount_paid" placeholder="0.00" step="0.01"
                   style="width: 100%; padding: 8px;"
                   oninput="calculateChange()" required>
        </div>


        <div style="margin-bottom: 10px;">
            <label>Change (Sukli):</label><br>
            <input type="text" id="change_display" value="0.00" readonly
                   style="width: 100%; padding: 8px; background: #f1f1f1;">
        </div>

        <div id="payment_error" style="color: red; margin-bottom: 10px;"></div>

        <div style="margin-bottom: 15px;">
            <label>Payment Method:</label><br>
            <select id="payment_method" style="width: 100%; padding: 8px;">
                <option value="Cash">Cash</option>
                <option value="GCash">GCash</option>
                <option value="Card">Card</option>
            </select>
        </div>

        <button type="button" onclick="submitPayment()"
            style="background: #28a745; color: white; padding: 10px 20px; border: none; cursor: pointer;">
            Confirm & Post Payment
        </button>
    </form>
</div>
</div>
<?php
    }
}
?>
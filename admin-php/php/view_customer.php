<?php
include('../../conn/connection.php');
$db = mysqli_connect($host, $username, $password, $database);

$customer_id = isset($_GET['id']) ? mysqli_real_escape_string($db, $_GET['id']) : null;
$source = isset($_GET['source']) ? $_GET['source'] : 'res';

switch ($source) {
    case 'checkin': $back = "loadcheck_inCustomer()"; break;
    case 'checkout': $back = "loadcheck_outCustomer()"; break;
    default: $back = "loadReservation()"; break;
}

if ($customer_id) {

    $res = mysqli_query($db, "SELECT * FROM customers WHERE customer_id = '$customer_id'");
    $cust = mysqli_fetch_array($res);

    $uRes = mysqli_query($db, "SELECT * FROM check_in_out_master WHERE customer_id = '$customer_id' ORDER BY reservation_id DESC LIMIT 1");
    $unit = mysqli_fetch_array($uRes);

    if ($cust) {
?>
<div class="user-information">
    <button onclick="<?php echo $back; ?>">Back</button>
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2>Customer Information Details</h2>
    </div>

    <br>

    <div class="information">
        <h3>Personal Details</h3>
        <p><strong>Name:</strong> <?php echo $cust['guest_name']; ?></p>
        <p><strong>Contact:</strong> <?php echo $cust['contact']; ?></p>
        <p><strong>Customer ID:</strong> <?php echo $cust['customer_id']; ?></p>
    </div>

    <div class="unit">
        <h3>Unit/Room Assignment</h3>
        <?php if($unit): ?>
            <p><strong>Unit:</strong> <?php echo $unit['unit']; ?></p>
            <p><strong>Type:</strong> <?php echo $unit['unit_type']; ?></p>
            <p><strong>Status:</strong> <?php echo $unit['status']; ?></p>
            <p><strong>Stay Duration:</strong> <?php echo $unit['duration_days']; ?></p>
            <p><strong>Total Bill:</strong> ₱<?php echo number_format($unit['total_amount'], 2); ?></p>
        <?php else: ?>
            <p>No active unit assigned.</p>
        <?php endif; ?>
    </div>

    <div class="payment">
        <h3>Payment History</h3>
        <table border="1" width="100%" style="border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Method</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $pRes = mysqli_query($db, "SELECT p.* FROM payments p JOIN reservations r ON p.reservation_id = r.reservation_id 
                                        WHERE r.customer_id = '$customer_id'");
                if(mysqli_num_rows($pRes) > 0): 
                    while($pay = mysqli_fetch_array($pRes)): ?>
                        <tr>
                            <td><?php echo $pay['payment_date']; ?></td>
                            <td><?php echo $pay['payment_method']; ?></td>
                            <td>₱<?php echo number_format($pay['amount'], 2); ?></td>
                        </tr>
                    <?php endwhile; 
                else: ?>
                    <tr>
                        <td colspan="3" style="text-align: center; color: gray;">No payments found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
    } else {
        echo "Customer not found.";
    }
}
?>
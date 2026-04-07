<?php
include('../conn/connection.php');
$dbconn = mysqli_connect($host, $username, $password, $dbname);

if (!$dbconn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$query = mysqli_query($dbconn, "
    SELECT 
        p.payment_id,
        p.reservation_id,
        c.guest_name,
        c.contact,
        u.unit_name,
        ut.unit_type_name,
        cat.category_name,
        r.check_in_date,
        r.expected_check_out,
        r.duration_days,
        r.total_bill,
        r.payment_status,
        p.amount,
        p.payment_method,
        p.payment_date,
        r.status
    FROM payments p
    JOIN reservations r ON p.reservation_id = r.reservation_id
    JOIN customers c ON r.customer_id = c.customer_id
    JOIN units u ON r.unit_id = u.unit_id
    JOIN unit_types ut ON u.unit_type_id = ut.unit_type_id
    JOIN categories cat ON u.category_id = cat.category_id
    ORDER BY p.payment_date DESC
");

if (!$query) {
    die("Query failed: " . mysqli_error($dbconn));
}

$total_sales = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Sales Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            color: #000;
        }
        h2, h4, p {
            text-align: center;
            margin: 5px 0;
        }
        .report-info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 12px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        th {
            background: #f2f2f2;
        }
        .total-box {
            margin-top: 20px;
            text-align: right;
            font-weight: bold;
            font-size: 14px;
        }

        @media print {
            .no-print {
                display: none;
            }
            body {
                margin: 15px;
            }
        }
    </style>
</head>
<body>

    <div class="no-print" style="text-align:center; margin-bottom: 15px;">
        <button onclick="window.print();">Print / Save as PDF</button>
    </div>

    <h2>Financial Sales Report</h2>
    <h4>Hotel Management System</h4>
    <div class="report-info">
        <p>Generated Date: <?php echo date("F d, Y h:i A"); ?></p>
        <p>Report Type: Financial Sales Timeline</p>
        <p>Excluded Tables: Check-In and Check-Out</p>
    </div>

    <table>
        <tr>
            <th>#</th>
            <th>Payment Date</th>
            <th>Guest Name</th>
            <th>Contact</th>
            <th>Unit</th>
            <th>Type</th>
            <th>Category</th>
            <th>Check In</th>
            <th>Check Out</th>
            <th>Duration</th>
            <th>Total Bill</th>
            <th>Amount Paid</th>
            <th>Method</th>
            <th>Reservation Status</th>
            <th>Payment Status</th>
        </tr>

        <?php
        $count = 0;
        while ($row = mysqli_fetch_assoc($query)) {
            $count++;
            $total_sales += $row['amount'];
        ?>
        <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo date("Y-m-d h:i A", strtotime($row['payment_date'])); ?></td>
            <td><?php echo htmlspecialchars($row['guest_name']); ?></td>
            <td><?php echo htmlspecialchars($row['contact']); ?></td>
            <td><?php echo htmlspecialchars($row['unit_name']); ?></td>
            <td><?php echo htmlspecialchars($row['unit_type_name']); ?></td>
            <td><?php echo htmlspecialchars($row['category_name']); ?></td>
            <td><?php echo htmlspecialchars($row['check_in_date']); ?></td>
            <td><?php echo htmlspecialchars($row['expected_check_out']); ?></td>
            <td><?php echo htmlspecialchars($row['duration_days']); ?></td>
            <td>₱<?php echo number_format($row['total_bill'], 2); ?></td>
            <td>₱<?php echo number_format($row['amount'], 2); ?></td>
            <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
            <td><?php echo htmlspecialchars($row['status']); ?></td>
            <td><?php echo htmlspecialchars($row['payment_status']); ?></td>
        </tr>
        <?php } ?>
    </table>

    <div class="total-box">
        Total Financial Sales: ₱<?php echo number_format($total_sales, 2); ?>
    </div>

    <script>
        window.onload = function () {
            window.print();
        };
    </script>

</body>
</html>
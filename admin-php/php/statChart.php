<?php
header('Content-Type: application/json');
include('../../conn/connection.php');
$conn = mysqli_connect($host, $username, $password, $database);


if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed"]));
}

// --- 1. DAILY OCCUPANCY (Rooms vs Halls) ---
// Counts currently checked-in reservations split by category
$occupancy_query = $conn->query("
    SELECT 
        SUM(CASE WHEN c.category_name = 'ROOM' THEN 1 ELSE 0 END) as rooms_active,
        SUM(CASE WHEN c.category_name = 'FUNCTION HALL' THEN 1 ELSE 0 END) as halls_active
    FROM reservations r
    JOIN units u ON r.unit_id = u.unit_id
    JOIN categories dark_c ON u.category_id = dark_c.category_id
    WHERE r.status = 'Checked-In'
");
$occ_data = $occupancy_query->fetch_assoc();
$rooms_occ = $occ_data['rooms_active'] ?? 0;
$halls_occ = $occ_data['halls_active'] ?? 0;

// --- 2. INCOME MONITOR (Rooms vs Halls) ---
// Sums total_bill for confirmed reservations based on category
$income_query = $conn->query("
    SELECT 
        SUM(CASE WHEN cat.category_name = 'ROOM' THEN r.total_bill ELSE 0 END) as room_income,
        SUM(CASE WHEN cat.category_name = 'FUNCTION HALL' THEN r.total_bill ELSE 0 END) as hall_income
    FROM reservations r
    JOIN units u ON r.unit_id = u.unit_id
    JOIN categories cat ON u.category_id = cat.category_id
    WHERE r.status != 'Cancelled'
");
$inc_data = $income_query->fetch_assoc();
$room_total = $inc_data['room_income'] ?? 0;
$hall_total = $inc_data['hall_income'] ?? 0;

// --- 3. BEST SELLING (Frequency & Revenue) ---
// Finds the category that generates the most money and most bookings
$best_selling = $conn->query("
    SELECT cat.category_name, COUNT(r.reservation_id) as freq, SUM(r.total_bill) as rev
    FROM reservations r
    JOIN units u ON r.unit_id = u.unit_id
    JOIN categories cat ON u.category_id = cat.category_id
    GROUP BY cat.category_id
    ORDER BY freq DESC, rev DESC LIMIT 1
");
$best_data = $best_selling->fetch_assoc();
$best_name = $best_data['category_name'] ?? "--";

// --- 4. PAYMENTS (Paid vs Unpaid) ---
// Counts based on the payment table existence
$payment_status = $conn->query("
    SELECT 
        SUM(CASE WHEN p.payment_id IS NOT NULL THEN 1 ELSE 0 END) as paid_count,
        SUM(CASE WHEN p.payment_id IS NULL THEN 1 ELSE 0 END) as unpaid_count
    FROM reservations r
    LEFT JOIN payments p ON r.reservation_id = p.reservation_id
    WHERE r.status != 'Cancelled'
");
$pay_data = $payment_status->fetch_assoc();
$paid = $pay_data['paid_count'] ?? 0;
$unpaid = $pay_data['unpaid_count'] ?? 0;

// --- OUTPUT JSON ---
echo json_encode([
    "occupancy_stats" => "Rooms: $rooms_occ | Halls: $halls_occ",
    "room_income"     => "₱" . number_format($room_total, 2),
    "hall_income"     => "₱" . number_format($hall_total, 2),
    "best_seller"     => $best_name,
    "payment_summary" => "Paid: $paid | Unpaid: $unpaid"
]);

$conn->close();
?>
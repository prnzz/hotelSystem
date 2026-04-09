<?php
header('Content-Type: application/json');
include('../../conn/connection.php');
$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die(json_encode(["error" => "Connection failed: " . mysqli_connect_error()]));
}

mysqli_set_charset($conn, "utf8mb4");

// --- 1. DAILY OCCUPANCY (Rooms vs Halls) ---
// Counts currently checked-in reservations split by category
$occupancy_query = $conn->query("
    SELECT 
        COALESCE(SUM(CASE WHEN cat.category_name = 'ROOM' THEN 1 ELSE 0 END), 0) as rooms_active,
        COALESCE(SUM(CASE WHEN cat.category_name = 'FUNCTION HALL' THEN 1 ELSE 0 END), 0) as halls_active
    FROM reservations r
    JOIN units u ON r.unit_id = u.unit_id
    JOIN categories cat ON u.category_id = cat.category_id
    WHERE r.status = 'Checked-In'
");
$occ_data = $occupancy_query ? $occupancy_query->fetch_assoc() : [];
$rooms_occ = $occ_data['rooms_active'] ?? 0;
$halls_occ = $occ_data['halls_active'] ?? 0;

// --- 2. INCOME MONITOR (Rooms vs Halls) ---
// Sums total_bill for non-cancelled reservations based on category
$income_query = $conn->query("
    SELECT 
        COALESCE(SUM(CASE WHEN cat.category_name = 'ROOM' THEN r.total_bill ELSE 0 END), 0) as room_income,
        COALESCE(SUM(CASE WHEN cat.category_name = 'FUNCTION HALL' THEN r.total_bill ELSE 0 END), 0) as hall_income
    FROM reservations r
    JOIN units u ON r.unit_id = u.unit_id
    JOIN categories cat ON u.category_id = cat.category_id
    WHERE r.status != 'Cancelled'
");
$inc_data = $income_query ? $income_query->fetch_assoc() : [];
$room_total = $inc_data['room_income'] ?? 0;
$hall_total = $inc_data['hall_income'] ?? 0;

// --- 3. BEST SELLING (Frequency & Revenue) ---
// Finds the Unit_type that generates the most bookings and revenue
$best_selling = $conn->query("
    SELECT 
        ut.unit_type_name,
        COUNT(r.reservation_id) as freq,
        COALESCE(SUM(r.total_bill), 0) as rev
    FROM reservations r
    JOIN units u ON r.unit_id = u.unit_id
    JOIN unit_types ut ON u.unit_type_id = ut.unit_type_id
    WHERE r.status != 'Cancelled'
    GROUP BY ut.unit_type_id, ut.unit_type_name
    ORDER BY freq DESC, rev DESC
    LIMIT 1
");

$best_data = $best_selling ? $best_selling->fetch_assoc() : [];

$best_name = $best_data['unit_type_name'] ?? "--";

// --- 4. PAYMENTS (Paid vs Unpaid) ---
// Uses reservations.payment_status
$payment_status = $conn->query("
    SELECT 
        COALESCE(SUM(CASE WHEN r.payment_status = 'Paid' THEN 1 ELSE 0 END), 0) as paid_count,
        COALESCE(SUM(CASE WHEN r.payment_status = 'Unpaid' THEN 1 ELSE 0 END), 0) as unpaid_count
    FROM reservations r
    WHERE r.status != 'Cancelled'
");
$pay_data = $payment_status ? $payment_status->fetch_assoc() : [];
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
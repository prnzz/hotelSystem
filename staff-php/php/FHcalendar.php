<?php
include('../../conn/connection.php');
$conn = mysqli_connect($host, $username, $password, $database);

$month = isset($_GET['m']) ? (int)$_GET['m'] : (int)date('m');
$year = isset($_GET['y']) ? (int)$_GET['y'] : (int)date('Y');

$todayDate = date('Y-m-d');
$todayM = (int)date('m');
$todayY = (int)date('Y');

$prevMonth = ($month == 1) ? 12 : $month - 1;
$prevYear = ($month == 1) ? $year - 1 : $year;
$nextMonth = ($month == 12) ? 1 : $month + 1;
$nextYear = ($month == 12) ? $year + 1 : $year;

$firstOfMonth = "$year-" . sprintf("%02d", $month) . "-01";
$firstDayIdx = (int)date('w', strtotime($firstOfMonth));
$daysInMonth = (int)date('t', strtotime(sprintf('%04d-%02d-01', $year, $month)));

// FETCH ONLY FUNCTION HALL BOOKINGS
$stmt = $conn->prepare("
    SELECT r.*, u.unit_name 
    FROM reservations r 
    JOIN units u ON r.unit_id = u.unit_id 
    JOIN categories c ON u.category_id = c.category_id 
    WHERE c.category_name = 'FUNCTION HALL' 
    AND (r.check_in_date <= LAST_DAY(?)) 
    AND (r.expected_check_out >= ?)
    AND r.status != 'Cancelled'
");
$stmt->bind_param("ss", $firstOfMonth, $firstOfMonth);
$stmt->execute();
$result = $stmt->get_result();

$booked_ranges = [];
while($row = $result->fetch_assoc()) {
    $begin = new DateTime($row['check_in_date']);
    $end = new DateTime($row['expected_check_out']);
    $interval = new DateInterval('P1D');
    $period = new DatePeriod($begin, $interval, $end->modify('+1 day'));
    
    foreach ($period as $date) {
        $booked_ranges[$date->format("Y-m-d")][] = [
            'unit' => $row['unit_name'], 
            'status' => $row['status']
        ];
    }
}
?>

<div class="calendar-container">
    <div class="calendar-header">
        <div class="header-left">
            <button class="nav-btn" onclick="functionHallCalendar(<?php echo "$prevMonth, $prevYear"; ?>)">&laquo;</button>
            <button class="today-btn" onclick="functionHallCalendar(<?php echo "$todayM, $todayY"; ?>)">Today</button>
        </div>

        <div class="calendar-controls">
            <select id="select_month" onchange="jumpToDate()">
                <?php for ($m = 1; $m <= 12; $m++): ?>
                    <option value="<?= $m ?>" <?= ($m == $month) ? 'selected' : '' ?>>
                        <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                    </option>
                <?php endfor; ?>
            </select>

            <select id="select_year" onchange="jumpToDate()">
                <?php for ($y = date('Y') - 2; $y <= date('Y') + 5; $y++): ?>
                    <option value="<?= $y ?>" <?= ($y == $year) ? 'selected' : '' ?>><?= $y ?></option>
                <?php endfor; ?>
            </select>
        </div>

        <button class="nav-btn" onclick="functionHallCalendar(<?php echo "$nextMonth, $nextYear"; ?>)">&raquo;</button>
    </div>

    <div class="calendar-grid">
        <div class="day-name">Sun</div><div class="day-name">Mon</div><div class="day-name">Tue</div>
        <div class="day-name">Wed</div><div class="day-name">Thu</div><div class="day-name">Fri</div><div class="day-name">Sat</div>

        <?php
        for ($x = 0; $x < $firstDayIdx; $x++) {
            echo "<div class='day empty'></div>";
        }

        for ($i = 1; $i <= $daysInMonth; $i++):
            $currentDate = sprintf("%04d-%02d-%02d", $year, $month, $i);
            $dayBookings = $booked_ranges[$currentDate] ?? [];
            $isToday = ($currentDate == $todayDate) ? 'is-today' : '';
            
            $statusClass = '';
            if (!empty($dayBookings)) {
                $statusClass = 'booked ' . strtolower(str_replace([' ', '-'], '', $dayBookings[0]['status']));
            }
        ?>
            <div class="day <?= $statusClass ?> <?= $isToday ?>">
                <span class="date-num"><?= $i ?></span>
                <?php foreach ($dayBookings as $b): ?>
                    <div class="hall-label"><?= $b['unit'] ?></div>
                <?php endforeach; ?>
            </div>
        <?php endfor; ?>
    </div>
</div>
<?php
include('../../conn/connection.php');
$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$month = isset($_GET['m']) ? (int)$_GET['m'] : (int)date('m');
$year  = isset($_GET['y']) ? (int)$_GET['y'] : (int)date('Y');

$todayDate = date('Y-m-d');
$todayM = (int)date('m');
$todayY = (int)date('Y');

$prevMonth = ($month == 1) ? 12 : $month - 1;
$prevYear  = ($month == 1) ? $year - 1 : $year;
$nextMonth = ($month == 12) ? 1 : $month + 1;
$nextYear  = ($month == 12) ? $year + 1 : $year;

$firstOfMonth = sprintf('%04d-%02d-01', $year, $month);
$lastOfMonth  = date('Y-m-t', strtotime($firstOfMonth));

$firstDayIdx = (int)date('w', strtotime($firstOfMonth));
$daysInMonth = (int)date('t', strtotime($firstOfMonth));

$sql = "
    SELECT 
        reservation_id,
        check_in_date,
        expected_check_out,
        status,
        unit,
        unit_type,
        category_name
    FROM vw_all_transactions
    WHERE status IN ('Pending', 'Checked-In')
      AND category_name = 'FUNCTION HALL'
      AND unit_type = 'Function Hall'
      AND check_in_date <= ?
      AND expected_check_out >= ?
    ORDER BY check_in_date ASC, unit_type ASC, unit ASC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $lastOfMonth, $firstOfMonth);
$stmt->execute();
$result = $stmt->get_result();

$booked_ranges = [];

while ($row = $result->fetch_assoc()) {
    $begin = new DateTime($row['check_in_date']);
    $end   = new DateTime($row['expected_check_out']);
    $end->modify('+1 day'); // include checkout date in display

    $interval = new DateInterval('P1D');
    $period   = new DatePeriod($begin, $interval, $end);

    foreach ($period as $date) {
        $dateKey = $date->format('Y-m-d');

        // only store dates that belong to the selected month
        if ($dateKey >= $firstOfMonth && $dateKey <= $lastOfMonth) {
            $booked_ranges[$dateKey][] = [
                'unit'     => $row['unit_type'] . ' - ' . $row['unit'],
                'category' => $row['category_name'],
                'status'   => $row['status']
            ];
        }
    }
}
?>

<div class="calendar-container">
    <div class="ledger">
        <p>Green = Checked-In, Blue = Pending, Grey = No Booking</p>
    </div>
    <div class="calendar-header">
        <div class="header-left">
            <button class="nav-btn" onclick="functionHallCalendar(<?php echo $prevMonth; ?>, <?php echo $prevYear; ?>)">&laquo;</button>
            <button class="today-btn" onclick="functionHallCalendar(<?php echo $todayM; ?>, <?php echo $todayY; ?>)">Today</button>
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
                    <option value="<?= $y ?>" <?= ($y == $year) ? 'selected' : '' ?>>
                        <?= $y ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>

        <div class="header-right">
            <button class="nav-btn" onclick="functionHallCalendar(<?php echo $nextMonth; ?>, <?php echo $nextYear; ?>)">&raquo;</button>
        </div>
    </div>

    <div class="calendar-grid">
        <div class="day-name">Sun</div>
        <div class="day-name">Mon</div>
        <div class="day-name">Tue</div>
        <div class="day-name">Wed</div>
        <div class="day-name">Thu</div>
        <div class="day-name">Fri</div>
        <div class="day-name">Sat</div>

        <?php
        for ($x = 0; $x < $firstDayIdx; $x++) {
            echo "<div class='day empty'></div>";
        }

        for ($i = 1; $i <= $daysInMonth; $i++):
            $currentDate = sprintf("%04d-%02d-%02d", $year, $month, $i);
            $dayBookings = $booked_ranges[$currentDate] ?? [];
            $isToday = ($currentDate === $todayDate) ? 'is-today' : '';
            $statusClass = !empty($dayBookings) ? 'booked' : '';
        ?>
            <div class="day <?= $statusClass ?> <?= $isToday ?>">
                <span class="date-num"><?= $i ?></span>

                <?php if (!empty($dayBookings)): ?>
                    <?php foreach ($dayBookings as $b): ?>
                        <div class="unit-label <?= strtolower(str_replace([' ', '-'], '', $b['status'])) ?>">
                            <?= htmlspecialchars($b['unit']) ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-booking">No booking</div>
                <?php endif; ?>
            </div>
        <?php endfor; ?>
    </div>
</div>
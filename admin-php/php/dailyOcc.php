<div class="content-holder">
    <div>
        <h2>ROOMS And FUNCTION HALL Occupancy</h2>
    </div>
<body>        
<div class="table-wrapper">
    <div class="table-header">ROOMS</div>
    <div class="table-scroll">
    <table class="reservationTable">
             <thead>
                <tr>
                    <th>ROOM TYPE</th>
                    <th>CATEGORY</th>
                    <th>ROOM NUMBER | FLOOR</th>
                    <th>ROOM PRICE</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                include('../../conn/connection.php');
                $db = mysqli_connect($host, $username, $password, $database);
                $roomList = mysqli_query($db, "SELECT * FROM `roomlist` WHERE category_name = 'Room' AND STATUS = 'Occupied'");
                $counter = 0;
                while($row = mysqli_fetch_array($roomList)){
                    ?>
                    <tr>
                        <td><?php echo $row['unit_type_name']; ?></td>
                        <td><?php echo ($row['category_name']); ?></td>
                        <td><?php echo $row['unit_name']; ?> | <?php echo $row['floor']; ?></td>
                        <td><?php echo $row['price_per_day']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
    </table>
    </div>
</div>

<div class="table-wrapper">
    <div class="table-header">FUNCTION HALLS</div>
    <div class="table-scroll">
    <table class="reservationTable">
             <thead>
                <tr>
                    <th>ROOM TYPE</th>
                    <th>CATEGORY</th>
                    <th>ROOM NUMBER | FLOOR</th>
                    <th>ROOM PRICE</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                include('../../conn/connection.php');
                $db = mysqli_connect($host, $username, $password, $database);
                $roomList = mysqli_query($db, "SELECT * FROM `roomlist` WHERE category_name = 'Function Hall' AND STATUS = 'Occupied'");
                $counter = 0;
                while($row = mysqli_fetch_array($roomList)){
                    ?>
                    <tr>
                        <td><?php echo $row['unit_type_name']; ?></td>
                        <td><?php echo ($row['category_name']); ?></td>
                        <td><?php echo $row['unit_name']; ?> | <?php echo $row['floor']; ?></td>
                        <td><?php echo $row['price_per_day']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
    </table>
    </div>
</div>
</body>
</div>

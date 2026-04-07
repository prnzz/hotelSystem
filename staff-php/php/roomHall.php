<div class="content-holder">
    <div>
        <h2>ROOMS LIST</h2>
    </div>
    <body>
<div class="table-wrapper">
    <div class="table-header">ROOMS</div>
    <div class="table-scroll">
    <table class="reservationTable">
             <thead>
                <tr>
                    <th>UNIT TYPE</th>
                    <th>CATEGORY</th>
                    <th>ROOM NUMBER | FLOOR</th>
                    <th>ROOM PRICE</th>
                    <th>STATUS</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                include('../../conn/connection.php');
                $db = mysqli_connect($host, $username, $password, $database);
                $roomList = mysqli_query($db, "SELECT * FROM `roomlist`");
                while($row = mysqli_fetch_array($roomList)){
                ?>
                    <tr>
                        <td><?php echo $row['unit_type_name']; ?></td>
                        <td><?php echo $row['category_name']; ?></td>
                        <td><?php echo $row['unit_name']; ?> | <?php echo $row['floor']; ?></td>
                        <td>₱<?php echo number_format($row['price_per_day'], 2); ?></td>
                        <td>
                            <span <?php echo ($row['status'] == 'Maintenance') ?>>
                                <?php echo $row['status']; ?>
                            </span>
                        </td>
                        <td>
                            <?php if($row['status'] == 'Maintenance'): ?>
                                <button type="button" 
                                        class="btn btn-sm btn-success" 
                                        onclick="doneCleaning('<?php echo $row['unit_id']; ?>')">
                                    Done Cleaning
                                </button>
                            <?php else: ?>
                                <small style="color: gray;">No Action Needed</small>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
    </table>
    </div>
        </div>
</body>
</div>

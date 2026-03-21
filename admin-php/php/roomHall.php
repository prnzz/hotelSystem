<div class="content-holder">
    <button onclick="loadAddRoomForm()">ADD ROOM</button>
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
                    <th>UNIT # NAME</th>
                    <th>UNIT PRICE</th>
                    <th>STATUS</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                include('../../conn/connection.php');
                $db = mysqli_connect($host, $username, $password, $database);
                $roomList = mysqli_query($db, "SELECT * FROM `roomlist`");
                $counter = 0;
                while($row = mysqli_fetch_array($roomList)){
                    ?>
                    <tr>
                        <td><?php echo $row['unit_type_name']; ?></td>
                        <td><?php echo ($row['category_name']); ?></td>
                        <td><?php echo $row['unit_name']; ?></td>
                        <td><?php echo $row['price_per_day']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-secondary" onclick="editRoom('<?php echo $row['unit_id']; ?>')">Edit</button>
                                <button type="button" class="btn btn-secondary" onclick="deleteRoom('<?php echo $row['unit_id']; ?>')">Delete</button>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
    </table>
    </div>
        </div>
</body>
</div>

<div class="table-wrapper">
    <div class="table-header">BEST SELLING UNIT TYPE</div>
    <div class="table-scroll">
    <table class="reservationTable">
             <thead>
                <tr>
                    <th>ROOM TYPE</th>
                    <th>TOTAL RESERVATIONS</th>
                    <th>TOTAL REVENUE</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                include('../../conn/connection.php');
                $db = mysqli_connect($host, $username, $password, $database);
                $roomList = mysqli_query($db, "SELECT 
                                                    ut.unit_type_name,
                                                    COUNT(r.reservation_id) as freq,
                                                    COALESCE(SUM(r.total_bill), 0) as rev
                                                FROM reservations r
                                                JOIN units u ON r.unit_id = u.unit_id
                                                JOIN unit_types ut ON u.unit_type_id = ut.unit_type_id
                                                WHERE r.status != 'Cancelled'
                                                GROUP BY ut.unit_type_id, ut.unit_type_name
                                                ORDER BY freq DESC, rev DESC
                                                LIMIT 1");
                while($row = mysqli_fetch_array($roomList)){
                    ?>
                    <tr>
                        <td><?php echo $row['unit_type_name']; ?></td>
                        <td><?php echo $row['freq']; ?></td>
                        <td><?php echo $row['rev']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
    </table>
    </div>
</div>
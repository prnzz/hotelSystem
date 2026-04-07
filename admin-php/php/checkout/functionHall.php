<div class="content-holder">
    <link rel="stylesheet" href="style.css">
    <div>
        <h2>CUSTOMERS CHECK-OUT</h2>
    </div>
    <body>
        <div class="table-wrapper">
            <div class="table-header">ACTIVE CHECK-OUTS: FUNCTION HALL</div>
            <div class="table-scroll">
                    <table class="reservationTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>CUSTOMER NAME</th>      
                                <th>CONTACT</th>
                                <th>CHECK-IN || CHECK-IN TIME</th>
                                <th>CHECK-OUT || CHECK-OUT TIME</th>
                                <th>DURATION DAYS</th>
                                <th>ROOM NUMBER | FLOOR</th>
                                <th>ROOM TYPE</th>
                                <th>TOTAL AMOUNT</th>
                                <th>STATUS</th>
                                <th>PAYMENT</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include('../../../conn/connection.php');
                            $db = mysqli_connect($host, $username, $password, $database);
                            $customerList = mysqli_query($db, "SELECT * FROM `check_in_out_master` WHERE unit_type = 'Function Hall' AND status = 'Checked-Out'");
                            $counter = 0;
                            while($row = mysqli_fetch_array($customerList)){
                            $counter++;
                            ?>
                            <tr>
                                <td><?php echo $counter ?></td>
                                <td><?php echo ($row['guest_name']) ?></td>
                                <td><?php echo ($row['contact']) ?></td>
                                <td>
                                    <?php echo $row['check_in']; ?> || 
                                    <?php echo date("h:i A", strtotime($row['check_in_time'])); ?>
                                </td>
                                <td>
                                    <?php echo $row['check_out']; ?> || 
                                    <?php echo date("h:i A", strtotime($row['check_out_time'])); ?>
                                </td>
                                <td><?php echo ($row['duration_days']) ?></td>
                                <td><?php echo $row['unit']; ?> | <?php echo $row['floor']; ?></td>                   
                                <td><?php echo ($row['unit_type']) ?></td>
                                <td><?php echo ($row['total_amount']) ?></td>
                                <td><?php echo ($row['status']) ?></td>
                                <td>
                                    <span class="badge <?php 
                                        if($row['payment_status'] == 'Paid') echo 'badge-success'; 
                                        else if($row['payment_status'] == 'Partial') echo 'badge-warning'; 
                                        else echo 'badge-danger'; 
                                    ?>">
                                        <?php echo $row['payment_status']; ?>
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-secondary" 
                                        onclick="editReservation('<?php echo $row['reservation_id']; ?>')">
                                        Edit
                                    </button>
                                    
                                    <button type="button" class="btn btn-secondary" 
                                        onclick="deleteReservation('<?php echo $row['reservation_id']; ?>')">
                                        Delete
                                    </button>
                                    
                                    <button type="button" class="btn btn-secondary" 
                                        onclick="viewCustomerDetails('<?php echo $row['customer_id']; ?>', 'checkout')">
                                        View Details
                                    </button>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
            </div>
        </div>
</body>
</div>

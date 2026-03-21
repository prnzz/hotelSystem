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
                                <th>CHECK-IN</th>
                                <th>CHECK-OUT</th>
                                <th>DURATION DAYS</th>
                                <th>UNIT NAME</th>
                                <th>UNIT TYPE</th>
                                <th>TOTAL AMOUNT</th>
                                <th>STATUS</th>
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
                                <td><?php echo ($row['check_in']) ?></td>
                                <td><?php echo ($row['check_out']) ?></td>
                                <td><?php echo ($row['duration_days']) ?></td>
                                <td><?php echo ($row['unit']) ?></td>                     
                                <td><?php echo ($row['unit_type']) ?></td>
                                <td><?php echo ($row['total_amount']) ?></td>
                                <td><?php echo ($row['status']) ?></td>
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

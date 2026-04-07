<div class="content-holder">
    <div>
        <h2>PAID Function Halls</h2>
    </div>
    <button onclick="backToDashboard()">Back</button>
    <body>
        <div class="table-wrapper">
            <div class="table-header">Paid Function Halls</div>
            <div class="table-scroll">
                <table class="reservationTable">
                 <thead>
                    <tr>
                        <th>#</th>
                        <th>GUEST NAME</th>
                        <th>CONTACT</th>
                        <th>CHECK-IN || CHECK-IN TIME</th>
                        <th>CHECK-OUT || CHECK-OUT TIME</th>
                        <th>ROOM NUMBER | FLOOR</th>
                        <th>ROOM TYPE</th>
                        <th>ROOM PRICE</th>
                        <th>STAY DAYS</th>
                        <th>TOTAL AMOUNT</th>
                        <th>STATUS</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php
                    include('../../conn/connection.php');
                    $db = mysqli_connect($host, $username, $password, $database);
                    $customerList = mysqli_query($db, "SELECT * FROM `current_reservation_in_customer` WHERE unit_type_name = 'Function Hall' AND payment_status = 'Paid'");
                    $counter = 0;
                    
                    while($row = mysqli_fetch_array($customerList)){
                        $counter++;
                    ?>
                    <tr>
                        <td><?php echo $counter; ?></td>
                        <td><?php echo $row['guest_name']; ?></td>
                        <td><?php echo $row['contact']; ?></td>
                        <td>
                            <?php echo $row['check_in_date']; ?> || 
                            <?php echo date("h:i A", strtotime($row['check_in_time'])); ?>
                        </td>

                        <td>
                            <?php echo $row['expected_check_out']; ?> || 
                            <?php echo date("h:i A", strtotime($row['check_out_time'])); ?>
                        </td>
                        <td><?php echo $row['unit_name']; ?> | <?php echo $row['floor']; ?></td>
                        <td><?php echo $row['unit_type_name']; ?></td>
                        <td>₱<?php echo number_format($row['price_per_day'], 2); ?></td>
                        <td><?php echo $row['duration_days']; ?></td>
                        <td><strong>₱<?php echo number_format($row['total_bill'], 2); ?></strong></td>

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
                            <span class="badge <?php 
                                if($row['status'] == 'Pending') echo 'badge-warning'; 
                                else if($row['status'] == 'Confirmed') echo 'badge-success'; 
                                else echo 'badge-secondary'; 
                            ?>">
                                <?php echo $row['status']; ?>
                            </span>
                        </td>
                            <td>
                                <div class="btn-group" role="group">                                    
                                    <button type="button" class="btn btn-secondary" 
                                        onclick="viewCustomerDetails('<?php echo $row['customer_id']; ?>', 'res')">
                                        View Details
                                    </button>
                                </div>
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

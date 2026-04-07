<div class="content-holder">
    <div>
        <h2>CUSTOMERS IN RESERVATION</h2>
    </div>
    <div class="table-wrapper">
        <div class="table-header">RESERVATION</div>
        <div class="table-scroll">
            <table class="reservationTable table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>GUEST NAME</th>
                        <th>CONTACT</th>
                        <th>CHECK-IN</th>
                        <th>CHECK-OUT</th>
                        <th>UNIT</th>
                        <th>UNIT TYPE</th>
                        <th>UNIT PRICE</th>
                        <th>STAY DAYS</th>
                        <th>TOTAL AMOUNT</th>
                        <th>PAYMENT</th>
                        <th>STATUS</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php
                    include('../../conn/connection.php');
                    $db = mysqli_connect($host, $username, $password, $database);
                    $customerList = mysqli_query($db, "SELECT * FROM `current_reservation_in_customer` 
                                                    WHERE status = 'Pending'");
                    $counter = 0;
                    
                    while($row = mysqli_fetch_array($customerList)){
                        $counter++;
                    ?>
                    <tr>
                        <td><?php echo $counter; ?></td>
                        <td><?php echo $row['guest_name']; ?></td>
                        <td><?php echo $row['contact']; ?></td>
                        <td><?php echo $row['check_in_date']; ?></td>
                        <td><?php echo $row['expected_check_out']; ?></td>
                        <td><?php echo $row['unit_name']; ?></td>
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
                                if($row['status'] == 'Reserved') echo 'badge-warning'; 
                                else if($row['status'] == 'Confirmed') echo 'badge-success'; 
                                else echo 'badge-secondary'; 
                            ?>">
                                <?php echo $row['status']; ?>
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-info" 
                                onclick="openPayment('<?php echo $row['reservation_id']; ?>')">
                                Payment
                            </button>

                            <button type="button" class="btn btn-sm btn-success" 
                                onclick="confirmReservation('<?php echo $row['reservation_id']; ?>')">Confirm</button>

                            <button type="button" class="btn btn-sm btn-danger" 
                                onclick="cancelReservation('<?php echo $row['reservation_id']; ?>', '<?php echo $row['unit_id']; ?>')">Cancel</button>

                            <button type="button" class="btn btn-sm btn-info" 
                                onclick="viewCustomerDetails('<?php echo $row['customer_id']; ?>', 'res')">Details</button>
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
</div>
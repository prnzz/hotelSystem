<div class="content-holder">

    <div>
        <h2>CUSTOMERS IN RESERVATION</h2>
    </div>
    <body>
        <div class="table-wrapper">
            <div class="table-header">RESERVATION</div>
            <div class="table-scroll">
                <table class="reservationTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>GUESTNAME</th>
                            <th>CONTACT</th>
                            <th>UNIT NAME</th>
                            <th>UNIT TYPE</th>
                            <th>CHECK-IN</th>
                            <th>CHECK-OUT</th>
                            <th>DURATION DAYS</th>
                            <th>UNIT PRICE</th>
                            <th>TOTAL AMOUNT</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include('../../conn/connection.php');
                        $db = mysqli_connect($host, $username, $password, $database);
                        $customerList = mysqli_query($db, "SELECT * FROM `current_reservation_in_customer` 
                                                    WHERE status = 'Reserved'");
                        $counter = 0;
                        while($row = mysqli_fetch_array($customerList)){
                        $counter++;
                        ?>
                        <tr>
                            <td><?php echo $counter ?></td>
                            <td><?php echo ($row['guest_name']) ?></td>
                            <td><?php echo ($row['contact']) ?></td>
                            <td><?php echo ($row['unit_name']) ?></td>
                            <td><?php echo ($row['unit_type_name']) ?></td>
                            <td><?php echo ($row['check_in_date']) ?></td>
                            <td><?php echo ($row['expected_check_out']) ?></td>
                            <td><?php echo ($row['duration_days']) ?></td>
                            <td><?php echo ($row['price_per_day']) ?></td>
                            <td><?php echo ($row['total_bill']) ?></td>
                            <td><?php echo ($row['status']) ?></td>
                            <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-secondary" 
                                    onclick="editReservation('<?php echo $row['reservation_id']; ?>')">
                                    Edit
                                </button>
                                
                                <button type="button" class="btn btn-secondary" 
                                    onclick="deleteReservation('<?php echo $row['reservation_id']; ?>')">
                                    Delete
                                </button>
                                
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
        
        <br>
                <div class="table-wrapper">
            <div class="table-header">CANCELLED RESERVATION</div>
            <div class="table-scroll">
                <table class="reservationTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>GUESTNAME</th>
                            <th>CONTACT</th>
                            <th>UNIT NAME</th>
                            <th>UNIT TYPE</th>
                            <th>CHECK-IN</th>
                            <th>CHECK-OUT</th>
                            <th>DURATION DAYS</th>
                            <th>UNIT PRICE</th>
                            <th>TOTAL AMOUNT</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include('../../conn/connection.php');
                        $db = mysqli_connect($host, $username, $password, $database);
                        $customerList = mysqli_query($db, "SELECT * FROM `current_reservation_in_customer` 
                                                    WHERE status = 'Cancelled'");
                        $counter = 0;
                        while($row = mysqli_fetch_array($customerList)){
                        $counter++;
                        ?>
                        <tr>
                            <td><?php echo $counter ?></td>
                            <td><?php echo ($row['guest_name']) ?></td>
                            <td><?php echo ($row['contact']) ?></td>
                            <td><?php echo ($row['unit_name']) ?></td>
                            <td><?php echo ($row['unit_type_name']) ?></td>
                            <td><?php echo ($row['check_in_date']) ?></td>
                            <td><?php echo ($row['expected_check_out']) ?></td>
                            <td><?php echo ($row['duration_days']) ?></td>
                            <td><?php echo ($row['price_per_day']) ?></td>
                            <td><?php echo ($row['total_bill']) ?></td>
                            <td><?php echo ($row['status']) ?></td>
                            <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-secondary" 
                                    onclick="deleteReservation('<?php echo $row['reservation_id']; ?>')">
                                    Delete
                                </button>
                                
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

//verify log-in
function verifylog(){
    fetch("php/verifyLog.php")
    .then(response => response.text())
    .then(data => {
        var res = "";
        res = data;
        if(res == "0") {
            window.location.href = "login.html";
        }
    })
}
//LOGOUT
function logout(){
    var msg = confirm("Are you sure you want to logout?");
    if(msg == true){
        fetch("php/logout.php")
        .then(response => response.text())
        .then(data => {
            window.location.href = "login.html";
        });
    }
}
function loadRooms(){
    fetch('php/roomHall.php')
    .then(response => response.text())
    .then(data => {
    document.getElementById("Tblcontent").innerHTML = data; 
    });
}
//Customer Details
function viewCustomerDetails(customerId, source) {
    // Built using + instead of backticks to match your saveReservation style
    fetch("php/view_customer.php?id=" + customerId + "&source=" + source)
    .then(response => response.text())
    .then(data => {
        // Correctly targets your main content area
        document.getElementById("Tblcontent").innerHTML = data;
    });
}
function loadReservation() {
    fetch('php/staff_reservation.php')
    .then(response => response.text())
    .then(data => {
        document.getElementById("Tblcontent").innerHTML = data;
    });
}
//CHECK IN
function loadcheck_inCustomer(){
    fetch('../check_in_details.html')
    .then(responese=>responese.text())
    .then(data=> {
    document.getElementById("Tblcontent").innerHTML = data; 
    });
}
function loadStandard(){
    fetch('php/checkin/standard.php')
    .then(responese=>responese.text())
    .then(data=> {
    document.getElementById("Tblcontent").innerHTML = data; 
    });
}
function loadSuite(){
    fetch('php/checkin/suite.php')
    .then(responese=>responese.text())
    .then(data=> {
    document.getElementById("Tblcontent").innerHTML = data; 
    });
}
function loadDeluxe(){
    fetch('php/checkin/deluxe.php')
    .then(responese=>responese.text())
    .then(data=> {
    document.getElementById("Tblcontent").innerHTML = data; 
    });
}
function loadFuntionhall(){
    fetch('php/checkin/functionHall.php')
    .then(responese=>responese.text())
    .then(data=> {
    document.getElementById("Tblcontent").innerHTML = data; 
    });
}
//Checkout
function loadcheck_outCustomer(){
    fetch('../check_out_details.html')
    .then(responese=>responese.text())
    .then(data=> {
    document.getElementById("Tblcontent").innerHTML = data; 
    });
}
function loadCheckoutStandard(){
    fetch('php/checkout/standard.php')
    .then(responese=>responese.text())
    .then(data=> {
    document.getElementById("Tblcontent").innerHTML = data; 
    });
}
function loadCheckoutSuite(){
    fetch('php/checkout/suite.php')
    .then(responese=>responese.text())
    .then(data=> {
    document.getElementById("Tblcontent").innerHTML = data; 
    });
}
function loadCheckoutDeluxe(){
    fetch('php/checkout/deluxe.php')
    .then(responese=>responese.text())
    .then(data=> {
    document.getElementById("Tblcontent").innerHTML = data; 
    });
}
function loadCheckoutFuntionhall(){
    fetch('php/checkout/functionHall.php')
    .then(responese=>responese.text())
    .then(data=> {
    document.getElementById("Tblcontent").innerHTML = data; 
    });
}
// Function Hall Calendar
function functionHallCalendar(m = '', y = '') {
    let url = 'php/FHcalendar.php';
    if (m !== '' && y !== '') {
        url += `?m=${m}&y=${y}`;
    }

    fetch(url)
    .then(response => response.text())
    .then(data => {
        document.getElementById("Tblcontent").innerHTML = data; 
    })
    .catch(error => console.error('Error:', error));
}

function jumpToDate() {
    const m = document.getElementById('select_month').value;
    const y = document.getElementById('select_year').value;
    functionHallCalendar(m, y);
}

//Reservation Functions
function openPayment(resId) {
    fetch(`php/payment_form.php?res_id=${resId}`)
    .then(response => response.text())
    .then(data => {
        document.getElementById("Tblcontent").innerHTML = data;
    })
}


function addReservation() {
    fetch("php/entryformRes.php")
    .then(response => response.text())
    .then(data => {
        document.getElementById("Tblcontent").innerHTML = data;
        initReservationLogic();
    });
}

function saveReservation() {
    var guest_name = document.getElementById("guest_name");
    var contact = document.getElementById("contact");
    var unit_id = document.getElementById("unit_id");
    var check_in_date = document.getElementById("check_in_date");
    var expected_check_out = document.getElementById("expected_check_out");
    var duration = document.getElementById("duration");
    var total = document.getElementById("total");

    if (unit_id.value == "") {
        alert("Please select a unit.");
    } else {
        // Fetch keys must match the $_GET keys in save_reservation.php
        fetch("php/save_reservation.php?guest_name=" + guest_name.value + 
              "&contact=" + contact.value + 
              "&unit_id=" + unit_id.value + 
              "&check_in_date=" + check_in_date.value + 
              "&expected_check_out=" + expected_check_out.value + 
              "&duration_days=" + duration.value + 
              "&total_bill=" + total.value)
        .then(response => response.text());
        
        alert("Reservation Saved Successfully!");
        loadReservation(); // Refreshes the list
    }
}

function initReservationLogic() {
    var unitSelect = document.getElementById('unit_id');
    var checkInInput = document.getElementById('check_in_date');
    var checkOutInput = document.getElementById('expected_check_out');

    // If these aren't found, the code stops here to prevent errors
    if (!unitSelect || !checkInInput || !checkOutInput) return;

    function calculate() {
        var selectedOption = unitSelect.options[unitSelect.selectedIndex];
        var pricePerDay = parseFloat(selectedOption.getAttribute('data-price')) || 0;
        
        document.getElementById('price').value = pricePerDay;

        if (checkInInput.value && checkOutInput.value) {
            var start = new Date(checkInInput.value);
            var end = new Date(checkOutInput.value);
            var diffTime = end - start;
            var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            if (diffDays > 0) {
                document.getElementById('duration').value = diffDays;
                document.getElementById('total').value = diffDays * pricePerDay;
            } else {
                document.getElementById('duration').value = 0;
                document.getElementById('total').value = 0;
            }
        }
    }

    // Attach the triggers
    unitSelect.onchange = calculate;
    checkInInput.onchange = calculate;
    checkOutInput.onchange = calculate;
}


function confirmReservation(reservationId) {
    if (confirm("Are you sure you want to confirm this reservation?")) {
        // Build the URL exactly like your saveReservation style
        fetch("php/update_reservation.php?reservation_id=" + reservationId + 
              "&action=confirm")
        .then(response => response.text())
        .then(data => {
            if (data.trim() === "success") {
                alert("Reservation Confirmed!");
                loadReservation(); // Refresh the list
            } else {
                alert("Error: " + data);
            }
        });
    }
}

function cancelReservation(reservationId, unitId) {
    if (confirm("Are you sure you want to cancel this reservation?")) {
        // Built with multiple parameters using &
        fetch("php/update_reservation.php?reservation_id=" + reservationId + 
              "&unit_id=" + unitId + 
              "&action=cancel")
        .then(response => response.text())
        .then(data => {
            if (data.trim() === "success") {
                alert("Reservation Cancelled and Room is now Available.");
                loadReservation(); // Refresh the list
            } else {
                alert("Error: " + data);
            }
        });
    }
}

function submitPayment() {
    var res_id = document.getElementById('res_id');
    var amount_to_pay = document.getElementById('amount_to_pay');
    var amount_paid = document.getElementById('amount_paid');
    var payment_method = document.getElementById('payment_method');

    // Simple math check before sending
    var totalBill = parseFloat(amount_to_pay.value) || 0;
    var paid = parseFloat(amount_paid.value) || 0;

    if (paid < totalBill) {
        alert("Error: Amount paid is less than the total bill.");
    } else {
        if (confirm("Confirm payment of ₱" + paid.toFixed(2) + "?")) {
            // Same style: php/file.php?key=value&key2=value2
            fetch("php/save_payment.php?res_id=" + res_id.value + 
                  "&amount_paid=" + amount_paid.value + 
                  "&method=" + payment_method.value)
            .then(response => response.text())
            .then(result => {
                if (result.trim() === "success") {
                    alert("Payment Successful!");
                    loadReservation(); 
                } else {
                    alert("Error: " + result);
                }
            });
        }
    }
}
function checkOut(resId, unitId) {
    if (confirm("Are you sure you want to check out this guest? The room status will be set to 'Maintenance'.")) {
        // Built with ? and & to match your established style
        fetch("php/process_checkout.php?res_id=" + resId + "&unit_id=" + unitId)
        .then(response => response.text())
        .then(result => {
            if (result.trim() === "success") {
                alert("Check-out successful!");
                loadcheck_inCustomer(); // Refresh list
            } else {
                alert("Error: " + result);
            }
        });
    }
}

function doneCleaning(unitId) {
    if (confirm("Set this room back to 'Available'?")) {
        // Built with ? and & to match your established style
        fetch("php/done_cleaning.php?unit_id=" + unitId)
        .then(response => response.text())
        .then(result => {
            if (result.trim() === "success") {
                alert("Room is now ready for new guests!");
                loadRoomList(); // Refresh room list
            } else {
                alert("Error: " + result);
            }
        });
    }
}
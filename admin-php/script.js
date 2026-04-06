    //verify log-in
    function verifylog(){
        fetch("php/verifyLog.php")
        .then(response => response.text())
        .then(data => {
            var res = "";
            res = data;
            if(res == "1") {
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
    //RESERVATION CUSTOMERS
    function loadReservation(){
        fetch('php/reservation.php')
        .then(responese=>responese.text())
        .then(data=> {
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
    
function viewCustomerDetails(customerId, source) {
    fetch(`php/view_customer.php?id=${customerId}&source=${source}`)
    .then(response => response.text())
    .then(data => {
        document.getElementById("Tblcontent").innerHTML = data;
    });
}

function updateDashboardStats() {
    fetch('php/dashboard_stats.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('occ_data').innerText = data.occupancy_stats;
            document.getElementById('room_income').innerText = data.room_income;
            document.getElementById('hall_income').innerText = data.hall_income;
            document.getElementById('best_seller').innerText = data.best_seller;

            var paymentSummary = document.getElementById('payment_summary');
            paymentSummary.innerText = data.payment_summary;

            if (data.payment_summary.includes("Unpaid: 0")) {
                paymentSummary.style.color = "#35dc59";
            } else {
                paymentSummary.style.color = "#dc3545";
            }
        })
        .catch(error => console.error('Error loading stats:', error));
}

updateDashboardStats();
setInterval(updateDashboardStats, 30000);

function editReservation(resId) {
    fetch("php/edit_reservation_form.php?reservation_id=" + resId)
    .then(response => response.text())
    .then(data => {
        document.getElementById("Tblcontent").innerHTML = data;
        initReservationLogic("edit_"); 
    });
}

function deleteReservation(resId) {
    if (confirm("Are you sure you want to PERMANENTLY delete this reservation? This cannot be undone.")) {
        fetch("php/delete_reservation.php?reservation_id=" + resId)
        .then(response => response.text())
        .then(result => {
            if (result.trim() === "success") {
                alert("Reservation Deleted Successfully!");
                loadReservation(); 
            } else {
                alert("Error: " + result);
            }
        });
    }
}


// Function to update the data in the database
function updateReservationData(resId) {
    var name = document.getElementById('edit_guest_name').value;
    var contact = document.getElementById('edit_contact').value;
    var checkin = document.getElementById('edit_check_in').value;
    var checkout = document.getElementById('edit_check_out').value;
    var unit = document.getElementById('edit_unit_id').value;
    var total = document.getElementById('edit_total').value;

    if (confirm("Save changes to this reservation?")) {
        // The URL parameters (id, name, contact, etc.) must match the $_GET keys in PHP
        fetch("php/save_edit_reservation.php?id=" + resId + 
              "&name=" + encodeURIComponent(name) + 
              "&contact=" + contact + 
              "&checkin=" + checkin + 
              "&checkout=" + checkout + 
              "&unit=" + unit + 
              "&total=" + total)
        .then(response => response.text())
        .then(result => {
            if (result.trim() === "success") {
                alert("Reservation Updated Successfully!");
                loadReservation(); 
            } else {
                alert("Update Failed: " + result);
            }
        });
    }
}
function initReservationLogic(prefix = "") {
    var unitSelect = document.getElementById(prefix + 'unit_id');
    var checkInInput = document.getElementById(prefix + 'check_in'); 
    var checkOutInput = document.getElementById(prefix + 'check_out');

    if (!unitSelect || !checkInInput || !checkOutInput) {
        console.log("Inputs not found for prefix: " + prefix);
        return;
    }

    function calculate() {
        var selectedOption = unitSelect.options[unitSelect.selectedIndex];
        var pricePerDay = parseFloat(selectedOption.getAttribute('data-price')) || 0;
        
        // This will now correctly find 'edit_price' or just 'price'
        document.getElementById(prefix + 'price').value = pricePerDay.toFixed(2);

        if (checkInInput.value && checkOutInput.value) {
            var start = new Date(checkInInput.value);
            var end = new Date(checkOutInput.value);
            var diffTime = end - start;
            var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            if (diffDays > 0) {
                document.getElementById(prefix + 'duration').value = diffDays;
                document.getElementById(prefix + 'total').value = (diffDays * pricePerDay).toFixed(2);
            } else {
                document.getElementById(prefix + 'duration').value = 0;
                document.getElementById(prefix + 'total').value = "0.00";
            }
        }
    }

    unitSelect.onchange = calculate;
    checkInInput.onchange = calculate;
    checkOutInput.onchange = calculate;
    
    calculate(); 
}
//ROOMS
function loadAddRoomForm() {
    fetch("php/add_room_form.php")
    .then(response => response.text())
    .then(data => {
        document.getElementById("Tblcontent").innerHTML = data;
    });
}

function saveRoomData(btnId) {
    var name = document.getElementById('new_unit_name').value;
    var type = document.getElementById('new_unit_type').value;
    var category = document.getElementById('new_category').value;
    var new_unit_type = document.getElementById('input_new_unit_type').value;
    var new_price_per_day = document.getElementById('input_new_price_per_day').value;

    if (name == "" || category == "0") {
        alert("Please fill in all fields.");
        return;
    }

    if (type == "0" && new_unit_type == "") {
        alert("Please select a unit type or enter a new unit type.");
        return;
    }

    if (new_unit_type != "" && new_price_per_day == "") {
        alert("Please enter the price per day for the new unit type.");
        return;
    }

    if (confirm("Are you sure you want to add this room?")) {
        fetch("php/save_room.php?name=" + encodeURIComponent(name) + 
              "&type=" + encodeURIComponent(type) + 
              "&category=" + encodeURIComponent(category) +
              "&new_unit_type=" + encodeURIComponent(new_unit_type) +
              "&new_price_per_day=" + encodeURIComponent(new_price_per_day))
        .then(response => response.text())
        .then(result => {
            if (result.trim() === "success") {
                alert("Room Added Successfully!");
                loadRooms(); 
            } else {
                alert("Error: " + result);
            }
        });
    }
}

function editRoom(unitId) {
    fetch("php/edit_room_form.php?unit_id=" + unitId)
    .then(response => response.text())
    .then(data => {
        document.getElementById("Tblcontent").innerHTML = data;
    });
}

function updateRoomData(uId) {
    var uName = document.getElementById('edit_unit_name').value;
    var uStatus = document.getElementById('edit_status').value;

    if (confirm("Are you sure you want to save changes to this unit?")) {
        fetch("php/save_edit_room.php?id=" + uId + 
              "&name=" + encodeURIComponent(uName) + 
              "&status=" + uStatus)
        .then(response => response.text())
        .then(result => {
            if (result.trim() === "success") {
                alert("Room Updated Successfully!");
                loadRooms();
            } else {
                alert("Error: " + result);
            }
        });
    }
}
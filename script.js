document.addEventListener("DOMContentLoaded", function () {
  var busDetails = document.getElementById("bus_details");
  var serviceTypeSelect = document.getElementById("service_type");
  var ticketQuantityContainer = document.getElementById(
    "ticket_quantity_container"
  );
  var seatSelectionContainer = document.getElementById(
    "seat_selection_container"
  );
  var personalInfoContainer = document.getElementById(
    "personal_info_container"
  );
  var policyReviewContainer = document.getElementById(
    "policy_review_container"
  );

  var ticketQuantityInput = document.getElementById("ticket_quantity");
  var selectSeatsButton = document.getElementById("select_seats");
  var confirmSeatsButton = document.getElementById("confirm_seats");
  var nextPersonalInfoButton = document.getElementById("next_personal_info");
  var seatMap = document.getElementById("seat_map");

  // Ensure ticket quantity cannot go below 1
  ticketQuantityInput.addEventListener("input", function () {
    var quantity = parseInt(this.value);
    if (isNaN(quantity) || quantity < 1) {
      this.value = 1;
    }
  });

  // Show seat selection on "Select Seats" button click
  selectSeatsButton.addEventListener("click", function () {
    if (validateForm()) {
      showSeatSelection();
    } else {
      alert("Please fill out all required fields before proceeding.");
    }
  });

  // Confirm seats and show personal information and policy review
  confirmSeatsButton.addEventListener("click", function () {
    if (confirmSelection()) {
      showPersonalInfoAndPolicy();
    }
  });

  // Next button click to show policy review
  nextPersonalInfoButton.addEventListener("click", function () {
    if (validatePersonalInfo()) {
      showPolicyReview();
    } else {
      alert(
        "Please fill out all required fields in the Personal Information section."
      );
    }
  });

  // Function to validate personal information section
  function validatePersonalInfo() {
    var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var phone = document.getElementById("phone").value;

    // Check if any of the fields are empty
    if (name.trim() === "" || email.trim() === "" || phone.trim() === "") {
      return false;
    }
    return true;
  }

  // Function to show seat selection
  function showSeatSelection() {
    busDetails.style.display = "none";
    seatSelectionContainer.style.display = "block";
    personalInfoContainer.style.display = "none";
    policyReviewContainer.style.display = "none";
    generateSeatMap();
  }

  // Function to show personal info and policy review
  function showPersonalInfoAndPolicy() {
    seatSelectionContainer.style.display = "none";
    personalInfoContainer.style.display = "block";
    policyReviewContainer.style.display = "none";
  }

  // Function to show policy review section
  function showPolicyReview() {
    personalInfoContainer.style.display = "none";
    policyReviewContainer.style.display = "block";
  }

  // Generate seat map
  function generateSeatMap() {
    var rows = 11; // Number of rows for the seat map
    var cols = 5; // Number of columns for the seat map
    seatMap.innerHTML = ""; // Clear existing seats
    var seatNumber = 1; // Start seat numbering from 1
    var ticketQuantity = parseInt(ticketQuantityInput.value);
    for (var i = 0; i < rows; i++) {
      var row = document.createElement("div");
      row.classList.add("seat-row");
      for (var j = 0; j < cols; j++) {
        var seat = document.createElement("div");
        seat.classList.add("seat");
        // Check if last row and seat number is within valid range
        if (seatNumber <= 45) {
          if (i === rows - 1) {
            seat.textContent = seatNumber;
            seat.addEventListener("click", function () {
              if (!this.classList.contains("blank-seat")) {
                this.classList.toggle("selected");
              }
            });
            seatNumber++;
          } else {
            if ((j + 1) % 3 !== 0) {
              seat.textContent = seatNumber;
              seat.addEventListener("click", function () {
                if (!this.classList.contains("blank-seat")) {
                  this.classList.toggle("selected");
                }
              });
              seatNumber++;
            } else {
              seat.classList.add("blank-seat");
            }
          }
        } else {
          seat.classList.add("blank-seat");
        }
        row.appendChild(seat);
      }
      seatMap.appendChild(row);
    }
  }

  // Function to confirm seat selection
  function confirmSelection() {
    var selectedSeats = document.querySelectorAll(".seat.selected").length;
    var ticketQuantity = parseInt(ticketQuantityInput.value);
    if (selectedSeats < ticketQuantity) {
      alert("Please choose according to the ticket quantity you acquired.");
      return false;
    } else if (selectedSeats > ticketQuantity) {
      alert(
        "You have selected more seats than the ticket quantity you acquired."
      );
      return false;
    }
    return true;
  }

  serviceTypeSelect.dispatchEvent(new Event("change"));
});

$(document).ready(function () {
  const serviceTypeSelect = $("#service_type");
  const oneWayDestinationBlock = $("#one_way_destination_block");
  const roundTripDestinationBlock = $("#round_trip_destination_block");
  const returnDateTimeBlock = $("#return_date_time_block");

  oneWayDestinationBlock.hide();

  serviceTypeSelect.change(function () {
    if (serviceTypeSelect.val() === "one_way") {
      oneWayDestinationBlock.show();
      roundTripDestinationBlock.hide();
      returnDateTimeBlock.hide();
      $("#return_date").prop("required", false);
      $("#return_time").prop("required", false);
    } else if (serviceTypeSelect.val() === "round_trip") {
      oneWayDestinationBlock.hide();
      roundTripDestinationBlock.show();
      returnDateTimeBlock.show();
      $("#return_date").prop("required", true);
      $("#return_time").prop("required", true);
    } else {
      oneWayDestinationBlock.hide();
      roundTripDestinationBlock.hide();
      returnDateTimeBlock.hide();
    }
  });
});

function validateForm() {
  var serviceType = document.getElementById("service_type").value;
  if (serviceType === "") {
    alert("Please select a service type.");
    return false;
  }

  if (serviceType === "one_way") {
    var oneWayDestination = document.getElementById(
      "one_way_destination"
    ).value;
    if (oneWayDestination === "") {
      alert("Please select a destination for one-way trip.");
      return false;
    }
  } else if (serviceType === "round_trip") {
    var roundTripFrom = document.getElementById("round_trip_from").value;
    var roundTripTo = document.getElementById("round_trip_to").value;
    var returnDate = document.getElementById("return_date").value;
    var returnTime = document.getElementById("return_time").value;

    if (roundTripFrom === "" || roundTripTo === "") {
      alert(
        "Please select both departure and arrival locations for round-trip."
      );
      return false;
    }

    if (returnDate === "" || returnTime === "") {
      alert("Please select both return date and return time for round-trip.");
      return false;
    }
  }

  var departureDate = document.getElementById("departure_date").value;
  var departureTime = document.getElementById("departure_time").value;
  var ticketQuantity = document.getElementById("ticket_quantity").value;

  if (
    departureDate === "" ||
    departureTime === "" ||
    ticketQuantity === "" ||
    ticketQuantity < 1
  ) {
    alert("Please fill out all required fields.");
    return false;
  }

  return true;
}

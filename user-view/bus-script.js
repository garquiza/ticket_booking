document.addEventListener("DOMContentLoaded", function () {
  const serviceTypeSelect = document.getElementById("service_type");
  const oneWayDestinationBlock = document.getElementById(
    "one_way_destination_block"
  );
  const roundTripDestinationBlock = document.getElementById(
    "round_trip_destination_block"
  );
  const returnDateTimeBlock = document.getElementById("return_date_time_block");

  const ticketQuantityInput = document.getElementById("ticket_quantity");
  const selectSeatsButton = document.getElementById("select_seats");
  const confirmSeatsButton = document.getElementById("confirm_seats");
  const nextPersonalInfoButton = document.getElementById("next_personal_info");
  const nextTicketSummaryButton = document.getElementById(
    "next_ticket_summary"
  );
  const seatMap = document.getElementById("seat_map");

  // Initialize the display state of destination blocks
  oneWayDestinationBlock.style.display = "none";
  roundTripDestinationBlock.style.display = "none";
  if (returnDateTimeBlock) returnDateTimeBlock.style.display = "none";

  // Event listener for service type change
  serviceTypeSelect.addEventListener("change", function () {
    if (serviceTypeSelect.value === "one_way") {
      oneWayDestinationBlock.style.display = "block";
      roundTripDestinationBlock.style.display = "none";
      if (returnDateTimeBlock) returnDateTimeBlock.style.display = "none";
      document.getElementById("return_date").required = false;
      document.getElementById("return_time").required = false;
    } else if (serviceTypeSelect.value === "round_trip") {
      oneWayDestinationBlock.style.display = "none";
      roundTripDestinationBlock.style.display = "block";
      if (returnDateTimeBlock) returnDateTimeBlock.style.display = "block";
      document.getElementById("return_date").required = true;
      document.getElementById("return_time").required = true;
    } else {
      oneWayDestinationBlock.style.display = "none";
      roundTripDestinationBlock.style.display = "none";
      if (returnDateTimeBlock) returnDateTimeBlock.style.display = "none";
    }
  });

  // Ensure ticket quantity cannot go below 1
  ticketQuantityInput.addEventListener("input", function () {
    const quantity = parseInt(this.value);
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
      showPersonalInfo();
    }
  });

  // Next button click to show ticket summary
  nextPersonalInfoButton.addEventListener("click", function () {
    if (validatePersonalInfo()) {
      showTicketSummary();
    } else {
      alert(
        "Please fill out all required fields in the Personal Information section."
      );
    }
  });

  // Next button click to show policy review
  nextTicketSummaryButton.addEventListener("click", function () {
    showPolicyReview();
  });

  // Function to validate the form
  function validateForm() {
    const serviceType = document.getElementById("service_type").value;
    if (serviceType === "") {
      alert("Please select a service type.");
      return false;
    }

    if (serviceType === "one_way") {
      const oneWayDestination = document.getElementById(
        "one_way_destination"
      ).value;

      if (oneWayDestination === "") {
        alert("Please select a destination for one-way trip.");
        return false;
      }
    } else if (serviceType === "round_trip") {
      const roundTripDestination = document.getElementById(
        "round_trip_destination"
      ).value;
      const returnDate = document.getElementById("return_date").value;
      const returnTime = document.getElementById("return_time").value;

      if (roundTripDestination === "") {
        alert("Please select a destination for round-trip.");
        return false;
      }

      if (returnDate === "" || returnTime === "") {
        alert("Please select both return date and return time for round-trip.");
        return false;
      }
    }

    const departureDate = document.getElementById("departure_date").value;
    const departureTime = document.getElementById("departure_time").value;
    const ticketQuantity = document.getElementById("ticket_quantity").value;

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

  // Function to validate personal information section
  function validatePersonalInfo() {
    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const phone = document.getElementById("phone").value;

    // Check if any of the fields are empty
    if (name.trim() === "" || email.trim() === "" || phone.trim() === "") {
      return false;
    }
    return true;
  }

  // Function to show seat selection
  function showSeatSelection() {
    document.getElementById("bus_details").style.display = "none";
    document.getElementById("seat_selection_container").style.display = "block";
    document.getElementById("personal_info_container").style.display = "none";
    document.getElementById("ticket_summary_container").style.display = "none";
    document.getElementById("policy_review_container").style.display = "none";
    generateSeatMap();
  }

  // Function to show personal info and ticket summary
  function showPersonalInfo() {
    document.getElementById("seat_selection_container").style.display = "none";
    document.getElementById("personal_info_container").style.display = "block";
    document.getElementById("ticket_summary_container").style.display = "none";
    document.getElementById("policy_review_container").style.display = "none";
  }

  // Function to show ticket summary section
  async function showTicketSummary() {
    document.getElementById("personal_info_container").style.display = "none";
    document.getElementById("ticket_summary_container").style.display = "block";
    document.getElementById("policy_review_container").style.display = "none";

    try {
      let busInfo = await getBusInfo();
      populateTicketSummary(busInfo);
    } catch (error) {
      console.error(error); // Log any errors
    }
  }

  // Function to show policy review section
  function showPolicyReview() {
    document.getElementById("personal_info_container").style.display = "none";
    document.getElementById("ticket_summary_container").style.display = "none";
    document.getElementById("policy_review_container").style.display = "block";
  }

  // Generate seat map
  function generateSeatMap() {
    const rows = 11;
    const cols = 5;
    seatMap.innerHTML = "";
    let seatNumber = 1;

    for (let i = 0; i < rows; i++) {
      const row = document.createElement("div");
      row.classList.add("seat-row");

      for (let j = 0; j < cols; j++) {
        const seat = document.createElement("div");
        seat.classList.add("seat");

        // Check if the seat number is within the valid range
        if (seatNumber <= 45) {
          if (i === rows - 1 || (j + 1) % 3 !== 0) {
            seat.textContent = seatNumber;
            seat.addEventListener("click", function () {
              if (!this.classList.contains("blank-seat")) {
                this.classList.toggle("selected");
                updateSelectedSeats();
              }
            });
            seatNumber++;
          } else {
            seat.classList.add("blank-seat");
          }
        } else {
          seat.classList.add("blank-seat");
        }

        row.appendChild(seat);
      }

      seatMap.appendChild(row);
    }
  }

  // Update selected seats input
  function updateSelectedSeats() {
    const selectedSeats = [];
    const selectedElements = document.querySelectorAll(".seat.selected");

    selectedElements.forEach(function (seat) {
      selectedSeats.push(seat.textContent);
    });

    document.getElementById("selected_seats").value = selectedSeats.join(",");
  }

  // Function to confirm seat selection
  function confirmSelection() {
    const selectedSeats = document.querySelectorAll(".seat.selected").length;
    const ticketQuantity = parseInt(ticketQuantityInput.value);
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

  // Function to populate ticket summary
  function populateTicketSummary(busInfo) {
    const serviceType = document.getElementById("service_type").value;
    const oneWayDestination = document.getElementById("one_way_destination");
    const roundTripDestination = document.getElementById(
      "round_trip_destination"
    );
    const departureDate = document.getElementById("departure_date").value;
    const departureTime = document.getElementById("departure_time").value;
    const returnDate = document.getElementById("return_date").value;
    const returnTime = document.getElementById("return_time").value;
    const ticketQuantity = document.getElementById("ticket_quantity").value;
    const selectedSeats = document.getElementById("selected_seats").value;
    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const phone = document.getElementById("phone").value;

    const summaryHtml = `
      <p><strong>Bus Number:</strong> ${busInfo.busNumber}</p>
      <p><strong>Bus Driver:</strong> ${busInfo.busDriver}</p>
      <p><strong>Name:</strong> ${name}</p>
      <p><strong>Email:</strong> ${email}</p>
      <p><strong>Phone:</strong> ${phone}</p>
      <p><strong>Service Type:</strong> ${serviceType}</p>
      ${
        serviceType === "one_way"
          ? `<p><strong>Destination:</strong> ${
              oneWayDestination.options[oneWayDestination.selectedIndex].text
            }</p>`
          : ""
      }
      ${
        serviceType === "round_trip"
          ? `<p><strong>Destination:</strong> ${
              roundTripDestination.options[roundTripDestination.selectedIndex]
                .text
            }</p>`
          : ""
      }
      <p><strong>Departure Date:</strong> ${departureDate}</p>
      <p><strong>Departure Time:</strong> ${departureTime}</p>
      ${
        serviceType === "round_trip"
          ? `<p><strong>Return Date:</strong> ${returnDate}</p><p><strong>Return Time:</strong> ${returnTime}</p>`
          : ""
      }
      <p><strong>Ticket Quantity:</strong> ${ticketQuantity}</p>
      <p><strong>Selected Seats:</strong> ${selectedSeats}</p>
    `;

    // Append summaryHtml to the dedicated div
    document.getElementById("ticket_summary").innerHTML = summaryHtml;
  }

  async function getBusInfo() {
    try {
      let response = await $.ajax({
        url: "bus_controller.php",
        type: "GET",
        data: {
          location_name:
            document.getElementById("one_way_destination").value ||
            document.getElementById("round_trip_destination").value,
        },
      });

      if (response.status === "success") {
        return {
          busDriver: response.bus_driver,
          busNumber: response.bus_number,
        };
      } else {
        throw new Error("Error: " + response.message);
      }
    } catch (error) {
      throw new Error("AJAX error: " + error);
    }
  }
});

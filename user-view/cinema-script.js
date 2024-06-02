$(document).ready(function () {
  var movieDetails = $("#movie_details");
  var selectSeatsButton = $("#select_seats");
  var confirmSeatsButton = $("#confirm_seats");
  var nextPersonalInfoButton = $("#next_personal_info");
  var nextTicketSummaryButton = $("#next_ticket_summary");
  var personalInfoContainer = $("#personal_info_container");
  var ticketSummaryContainer = $("#ticket_summary_container");

  // Show seat selection once "Select Seats" button clicked
  selectSeatsButton.on("click", function () {
    if (validateForm()) {
      showSeatSelection();
    } else {
      alert("Please fill out all required fields before proceeding.");
    }
  });

  // Confirm seats and show personal information
  confirmSeatsButton.on("click", function () {
    if (confirmSelection()) {
      captureSelectedSeats();
      showPersonalInfo();
    }
  });

  // Click next button to show ticket summary
  nextPersonalInfoButton.on("click", function () {
    if (validatePersonalInfo()) {
      showTicketSummary();
    } else {
      alert(
        "Please fill out all required fields in the Personal Information section."
      );
    }
  });

  // Click next button to show policy review
  nextTicketSummaryButton.on("click", function () {
    showPolicyReview();
  });

  // Function to validate personal information
  function validatePersonalInfo() {
    var name = $("#name").val();
    var email = $("#email").val();
    var phone = $("#phone").val();

    return name.trim() !== "" && email.trim() !== "" && phone.trim() !== "";
  }

  // Show seat selection
  function showSeatSelection() {
    movieDetails.hide();
    $("#seat_selection_container").show();
    personalInfoContainer.hide();
    ticketSummaryContainer.hide();
    generateSeatMap();
  }

  // Show personal information
  function showPersonalInfo() {
    $("#seat_selection_container").hide();
    personalInfoContainer.show();
    ticketSummaryContainer.hide();
  }

  // Show ticket summary
  function showTicketSummary() {
    personalInfoContainer.hide();
    ticketSummaryContainer.show();
    generateTicketSummary();
  }

  // Show policy review section
  function showPolicyReview() {
    ticketSummaryContainer.hide();
    $("#policy_review_container").show();
  }

  // Generate seat map
  function generateSeatMap() {
    var seatMap = $("#seat_map");
    var rows = 6;
    var cols = 8;

    seatMap.empty();

    for (var i = 0; i < rows; i++) {
      var row = $('<div class="seat-row"></div>');
      var rowLabel = String.fromCharCode(65 + i);
      row.append('<div class="row-label">' + rowLabel + "</div>");

      for (var j = 1; j <= cols; j++) {
        var seat = $('<div class="seat">' + rowLabel + j + "</div>");
        seat.on("click", function () {
          $(this).toggleClass("selected");
        });
        row.append(seat);
      }
      seatMap.append(row);
    }
  }

  // Generate ticket summary
  function generateTicketSummary() {
    var movie = $("#select_movie").val();
    var movieDate = $("#movie_date").val();
    var movieTime = $("#movie_time").val();
    var ticketQuantity = $("#ticket_quantity").val();
    var selectedSeats = $("#seats").val().split(",");

    // Get personal information
    var name = $("#name").val();
    var email = $("#email").val();
    var phone = $("#phone").val();

    var summary = "<p><strong>Movie:</strong> " + movie + "</p>";
    summary += "<p><strong>Date:</strong> " + movieDate + "</p>";
    summary += "<p><strong>Time:</strong> " + movieTime + "</p>";
    summary +=
      "<p><strong>Ticket Quantity:</strong> " + ticketQuantity + "</p>";
    summary +=
      "<p><strong>Selected Seats:</strong> " +
      selectedSeats.join(", ") +
      "</p>";

    // Add personal information to summary
    summary += "<p><strong>Name:</strong> " + name + "</p>";
    summary += "<p><strong>Email:</strong> " + email + "</p>";
    summary += "<p><strong>Phone:</strong> " + phone + "</p>";

    $("#ticket_summary").html(summary);
  }

  // Validate form data
  function validateForm() {
    var movie = $("#select_movie").val();
    var movieDate = $("#movie_date").val();
    var movieTime = $("#movie_time").val();
    var ticketQuantity = $("#ticket_quantity").val();

    return (
      movie !== "" &&
      movieDate !== "" &&
      movieTime !== "" &&
      ticketQuantity !== ""
    );
  }

  // Confirm seat selection
  function confirmSelection() {
    var selectedSeats = $(".seat.selected");
    var ticketQuantity = $("#ticket_quantity").val();

    return selectedSeats.length === parseInt(ticketQuantity);
  }

  // Capture selected seats
  function captureSelectedSeats() {
    var selectedSeats = $(".seat.selected")
      .map(function () {
        return $(this).text();
      })
      .get();

    $("#seats").val(selectedSeats.join(","));
  }

  // Submit form asynchronously
  $("form").submit(function (event) {
    // Prevent default form submission
    event.preventDefault();

    // Serialize form data
    var formData = $(this).serialize();

    // Submit form using AJAX
    $.post("movie_controller.php", formData)
      .done(function (response) {
        // Parse JSON response
        var data = JSON.parse(response);

        // Display message
        if (data.status === "success") {
          alert(data.message);
        } else {
          alert(data.message);
        }
      })
      .fail(function () {
        alert("An error occurred while processing your request.");
      });
  });
});

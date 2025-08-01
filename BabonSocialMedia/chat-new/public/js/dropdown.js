// Add event listener to the button
document.getElementById("dropdownButton").addEventListener("click", function(event) {
    event.stopPropagation(); // Prevent event from propagating to parent elements
    downdown(); // Call the dropdown function
  });
// When the user clicks on the button, toggle between hiding and showing the dropdown content
function downdown() {
    $('#myDropdown').toggleClass('show');
    }

        // Close the dropdown menu if the user clicks outside of it
        $(document).on('click', function(event) {
        if (!$(event.target).hasClass('dropbtn')) {
            $('.dropdown-content.show').removeClass('show');
        }
        });
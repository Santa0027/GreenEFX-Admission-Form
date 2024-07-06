(function () {
    "use strict";
    
    const form = document.getElementById('myForm');
    form.forEach(function (e) {
      e.addEventListener('submit', function (event) {
        event.preventDefault();
        if (!isValidPhoneNumber(phoneInput.value)) {
          event.preventDefault(); // Prevent form submission
          phoneInput.classList.add('error'); // Add error class for styling (optional)
          alert('Invalid phone number. Please enter a valid 10-digit US number.');
        } else {
          phoneInput.classList.remove('error'); // Remove error class if present
        }  









        
        });
    });
});

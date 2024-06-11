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






// JavaScript validation
const phoneInput = document.getElementById('phone');
const form = document.getElementById('myForm');

form.addEventListener('submit', (event) => {
  if (!isValidPhoneNumber(phoneInput.value)) {
    event.preventDefault(); // Prevent form submission
    phoneInput.classList.add('error'); // Add error class for styling (optional)
    alert('Invalid phone number. Please enter a valid 10-digit US number.');
  } else {
    phoneInput.classList.remove('error'); // Remove error class if present
  }
});


//VALIDATION FOR THE PHONE  NUMBER


function isValidPhoneNumber(number) {
  const phoneUtil = require('libphonenumber-js');
  try {
    const parsedNumber = phoneUtil.parseAndKeepRawInput(number, 'US');
    return phoneUtil.isValidNumber(parsedNumber);
  } catch (error) {
    return false;
  }
}

// THE END

// THE VALIDATION FOR THE STATUS Option

const select = document.getElementById('status_select');
const statusInput = document.getElementById('status_input');

select.addEventListener('change', function(event) {
    // const selectedValue = this.value;
    const selectedValue = event.target.value; 
    console.log(selectedValue);

    if (selectedValue === 'other') {
      console.log("btn");
    statusInput.style.display = 'block'; // Show input if "Other" is selected
  } else {
    statusInput.style.display = 'none'; // Hide input otherwise
  }
});
 

// THE END

// THE VALIDATION FOR THE OTHER COURSE SELECTION Option


const other_course = document.getElementById('other_course');
const other_course_input = document.getElementById('other_course_input');

other_course.addEventListener('change', function(event) {
    // const selectedValue = this.value;
    const selectValue = event.target.value; 
    console.log(selectValue);

    if (selectValue === 'Yes') {
      console.log("btn");
    other_course_input.style.display = 'block'; // Show input if "Other" is selected
  } else {
    other_course_input.style.display = 'none'; // Hide input otherwise
  }
});

// THE END OF THE ......


// THE VALIDATION FOR THE OTHER COURSE SELECTION Option


const select_hearus = document.getElementById('select_hearus');
const hearus_input = document.getElementById('hearus_input');

select_hearus.addEventListener('change', function(event) {
    // const selectedValue = this.value;
    const selectValuefor_hearus = event.target.value; 
    console.log(selectValuefor_hearus);

    if (selectValuefor_hearus === 'other') {
      console.log("btn");
    hearus_input.style.display = 'block'; // Show input if "Other" is selected
  } else {
    hearus_input.style.display = 'none'; // Hide input otherwise
  }
});

// THE END OF THE ......

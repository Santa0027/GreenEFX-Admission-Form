<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GreenEFX Enquiry Form</title>
    <link rel="stylesheet" href="style.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
  </head>

  <body>
  <?php


if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  header("Location: ../../index.html");// Redirect to login page if not logged in
    exit();
}

?>


    <div class="container">
        <!-- Link styled as a button -->
        <a href="Login page/index.php" class="transparent-btn">manage</a>
      <div class="form">
        <div class="form_elements">
          <h1
            style="color: white; text-align: center; text-transform: uppercase"
          >
            Admission Form
          </h1>
          <!-- <div class="heading">
                <img class ="logo" src="assert/green_logo.png" alt="logo">
            </div> -->
          <form
            class="formdetails" method="post" id="myForm" action="index.php" enctype="multipart/form-data"
          >
            <div class="photo" style="color: white">
              <label for="image" class="texts">Select image : </label>
              <input
                type="file" id="image" name="image" accept="image"  class="addphoto" /><br /><br />
            </div>
            <div class="date"></div>
            <div class="irow">
              <div class="name">
                <div class="first_name form-control">
                  <input
                    type="text"
                    class="inputbox"
                    name="first_name"
                    onkeypress="return AlphabetsOnly(event) "
                    required
                  />
                  <label>
                    <span style="transition-delay: 0ms">F</span>
                    <span style="transition-delay: 50ms">i</span>
                    <span style="transition-delay: 100ms">r</span>
                    <span style="transition-delay: 150ms">s</span>
                    <span style="transition-delay: 200ms">t</span>
                    <span></span>
                    <span style="transition-delay: 250ms">n</span>
                    <span style="transition-delay: 300ms">a</span>
                    <span style="transition-delay: 350ms">m</span>
                    <span style="transition-delay: 400ms">e</span>
                  </label>
                </div>
                <div class="last_name form-control">
                  <input
                    type="text"
                    class="inputbox"
                    name="last_name"
                    onkeypress="return AlphabetsOnly(event) "
                    required
                  />
                  <label>
                    <span style="transition-delay: 0ms">L</span>
                    <span style="transition-delay: 50ms">a</span>
                    <span style="transition-delay: 100ms">s</span>
                    <span style="transition-delay: 150ms">t</span>
                    <span></span>
                    <span style="transition-delay: 250ms">n</span>
                    <span style="transition-delay: 300ms">a</span>
                    <span style="transition-delay: 350ms">m</span>
                    <span style="transition-delay: 400ms">e</span>
                  </label>
                </div>
              </div>
              <div class="email form-control">
                <input type="email" class="inputbox" name="email" />
                <label>
                  <span style="transition-delay: 0ms">E</span>
                  <span style="transition-delay: 50ms">m</span>
                  <span style="transition-delay: 100ms">a</span>
                  <span style="transition-delay: 150ms">i</span>
                  <span style="transition-delay: 200ms">l</span>
                </label>
              </div>
            </div>
            <div class="row2">
              <div class="phone form-control">
                <label style="position: relative" class="texts phone"
                  >DOB:</label
                >
                <div class="dobin">
                  <input
                    type="number"
                    min="1"
                    max="31"
                    class="inputbox"
                    placeholder="Date"
                    name="date"

                    required
                  />
                  <input
                    type="number"
                    min="1"
                    max="12"
                    class="inputbox"
                    placeholder="Month"
                    name="month"
                    required
                  />
                  <input
                    type="number"
                    min="1950"
                    max="2020"
                    class="inputbox"
                    placeholder="Year"
                    name="year"
                    required
                  />
                </div>
              </div>
              <div class="dob form-control" style="padding-top: 2rem">
                <input type="tel" class="inputbox" name="phone" onkeypress="return restrictAlphabets(event)" minlength="10" maxlength="10" required />
                <label style="top: 45px">
                  <span style="transition-delay: 0ms">P</span>
                  <span style="transition-delay: 50ms">h</span>
                  <span style="transition-delay: 100ms">o</span>
                  <span style="transition-delay: 150ms">n</span>
                  <span style="transition-delay: 200ms">e</span>
                </label>
              </div>
            </div>
            <div
              class="form-control"
              style="padding-top: 2rem; padding-bottom: 2rem; width: 45%"
            >
              <input type="tel" class="inputbox" name="secound_phone" onkeypress="return restrictAlphabets(event)" minlength="10" maxlength="10" />
              <label style="top: 45px">
                <span style="transition-delay: 0ms">A</span>
                <span style="transition-delay: 50ms">d</span>
                <span style="transition-delay: 100ms">d</span>
                <span style="transition-delay: 150ms">i</span>
                <span style="transition-delay: 200ms">t</span>
                <span style="transition-delay: 250ms">i</span>
                <span style="transition-delay: 300ms">o</span>
                <span style="transition-delay: 350ms">n</span>
                <span style="transition-delay: 400ms">a</span>
                <span style="transition-delay: 450ms">l</span>
                <span></span>
                <span style="transition-delay: 500ms">P</span>
                <span style="transition-delay: 550ms">h</span>
                <span style="transition-delay: 600ms">o</span>
                <span style="transition-delay: 650ms">n</span>
                <span style="transition-delay: 700ms">e</span>
                <span></span>
                <span style="transition-delay: 750ms">N</span>
                <span style="transition-delay: 800ms">o</span>
                <span style="transition-delay: 850ms">:</span>
              </label>
            </div>
            <div class="address">
              <label for="name" class="texts">Address:</label>
              <textarea
                id=""
                cols="130"
                rows="1"
                class="inputbox add"
                placeholder=" Address"
                name="address"
                required
              ></textarea>
            </div>
            <div class="parents">
              <div class="father form-control">
                <input
                  type="text"
                  class="inputbox"
                  name="father_name"
                  onkeypress="return AlphabetsOnly(event) "
                  required
                />
                <label>
                  <span style="transition-delay: 0ms">F</span>
                  <span style="transition-delay: 50ms">a</span>
                  <span style="transition-delay: 100ms">t</span>
                  <span style="transition-delay: 150ms">h</span>
                  <span style="transition-delay: 200ms">e</span>
                  <span style="transition-delay: 250ms">r</span>
                  <span></span>
                  <span style="transition-delay: 300ms">n</span>
                  <span style="transition-delay: 350ms">a</span>
                  <span style="transition-delay: 400ms">m</span>
                  <span style="transition-delay: 450ms">e</span>
                  <span style="transition-delay: 500ms">:</span>
                </label>
              </div>

              <div class="mother form-control">
                <input
                  type="text"
                  class="inputbox"
                  name="mother_name"
                  onkeypress="return AlphabetsOnly(event) "
                  required
                />
                <label>
                  <span style="transition-delay: 0ms">M</span>
                  <span style="transition-delay: 50ms">o</span>
                  <span style="transition-delay: 100ms">t</span>
                  <span style="transition-delay: 150ms">h</span>
                  <span style="transition-delay: 200ms">e</span>
                  <span style="transition-delay: 250ms">r</span>
                  <span></span>
                  <span style="transition-delay: 300ms">n</span>
                  <span style="transition-delay: 350ms">a</span>
                  <span style="transition-delay: 400ms">m</span>
                  <span style="transition-delay: 450ms">e</span>
                  <span style="transition-delay: 500ms">:</span>
                </label>
              </div>
            </div>
            <div class="row3">
              <div class="radio-container">
                <label style="padding-top: 0.7rem" for="text" class="texts"
                  >Gender :</label
                >
                <div class="radio">
                  <label class="radio-label">
                    <input type="radio" value="male" name="gender" required />
                    Male
                  </label>
                  <label class="radio-label">
                    <input type="radio" value="female" name="gender" required />
                    Female
                  </label>
                  <label class="radio-label">
                    <input type="radio" value="female" name="gender" required />
                    Others
                  </label>
                </div>
              </div>
              <div class="form-control Status">
                <input
                  type="text"
                  class="inputbox"
                  name="qualification"
                  required
                />
                <label for="options" class="texts form-control">
                  <span style="transition-delay: 0ms">Q</span>
                  <span style="transition-delay: 50ms">u</span>
                  <span style="transition-delay: 100ms">a</span>
                  <span style="transition-delay: 150ms">l</span>
                  <span style="transition-delay: 200ms">i</span>
                  <span style="transition-delay: 250ms">f</span>
                  <span style="transition-delay: 300ms">i</span>
                  <span style="transition-delay: 350ms">c</span>
                  <span style="transition-delay: 400ms">t</span>
                  <span style="transition-delay: 450ms">i</span>
                  <span style="transition-delay: 500ms">o</span>
                  <span style="transition-delay: 550ms">n</span>
                  <span style="transition-delay: 600ms">:</span>
                </label>
              </div>
              <div class="feild form-control">
                <input
                  type="text"
                  class="inputbox"
                  name="feild_status"
                 
                />
                <label>
                  <span style="transition-delay: 0ms">F</span>
                  <span style="transition-delay: 50ms">e</span>
                  <span style="transition-delay: 100ms">i</span>
                  <span style="transition-delay: 150ms">l</span>
                  <span style="transition-delay: 200ms">d</span>
                  <span></span>
                  <span style="transition-delay: 250ms">O</span>
                  <span style="transition-delay: 300ms">f</span>
                  <span></span>
                  <span style="transition-delay: 350ms">W</span>
                  <span style="transition-delay: 400ms">o</span>
                  <span style="transition-delay: 450ms">r</span>
                  <span style="transition-delay: 500ms">k</span>
                  <span style="transition-delay: 550ms">/</span>
                  <span style="transition-delay: 600ms">S</span>
                  <span style="transition-delay: 650ms">t</span>
                  <span style="transition-delay: 700ms">d</span>
                  <span style="transition-delay: 750ms">y</span>
                  <span></span>
                  <span style="transition-delay: 800ms">:</span>
                </label>
              </div>
            </div>

            <div class="flexing">
              <div class="row4">
                <div class="courese_interest">
                  <label for="options" class="texts">course:</label> <br />
                  <select
                    id="options"
                    name="course"
                    class="options inputbox"
                    required
                  >
                    <option value="DTP" class="optiontext" selected>
                      DTP 	
                    </option>
                    <option value="DCA" class="optiontext">
                      DCA	
                    </option>
                    <option value="PGDCA" class="optiontext">
                      PGDCA
                    </option>
                    <option value="DIPLOMA IN GRAPHICS DESIGNING" class="optiontext">
                      DIPLOMA IN GRAPHICS DESIGNING
                    </option>
                    <option value="DIPLOMA IN WEB DESIGNING" class="optiontext">
                      DIPLOMA IN WEB DESIGNING
                    </option>
                    <option value="DIPLOMA IN VIDEO EDITING" class="optiontext">
                     DIPLOMA IN VIDEO EDITING
                    </option>
                    <option value="DIPLOMA IN UI/UX DESIGNING" class="optiontext">
                      DIPLOMA IN UI/UX DESIGNING	
                    </option>
                     <option value="Graphics Crash Course" class="optiontext">
                      Graphics Crash Course	
                    </option>
                    <option value="Diploma in 3D & VFX" class="optiontext">
                      Diploma in 3D & VFX	
                    </option>
                    <option value="Advance Diploma in 3D & VFX" class="optiontext">
                      Advance Diploma in 3D & VFX	
                    </option>
                    <option value="Specialized in Advance Houdini Effects" class="optiontext">
                     Specialized in Advance Houdini Effects	
                    </option>
                    <option value="Specialized in Advance Digital Crowd" class="optiontext">
                      Specialized in Advance Digital Crowd 
                    </option>
                    <option value="Specialized in Advance Character Effects" class="optiontext">
                      Specialized in Advance Character Effects
                    </option>
                    <option value="Specialized in Advance Character Animation" class="optiontext">
                     Specialized in Advance Character Animation
                    </option>

                  </select>
                </div>
              </div>
            </div>

            <div id="response"
            style="
            color:aliceblue;
            "></div>
            <div class="loader" id="loading"
            style="display:none; width:7rem; margin:auto"
            >
              <span class="loader-text">loading</span>
              <span class="load"></span>
            </div>
            <div class="n1">
              <div class="n2">
                <div class="last">
                  <button
                    type="submit"
                    value="SUBMIT"
                    class="submit"
                    name="submit"
                  >
                    submit
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
<script>
    const form= document.getElementById('myForm').addEventListener('submit', function(event) {
        event.preventDefault();
        console.log(xhr);
        

        var formData = new FormData(this);

        // Create an AJAX request
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'index.php', true);
        console.log(xhr);
        var loading = document.getElementById('loading');
        xhr.onload = function() {
          loading.style.display = 'block';
            if (xhr.status === 200) {
                document.getElementById('response').textContent = this.response;
                loading.style.display = 'none';
                document.getElementById('myForm').reset(); 
            } else {
                loading.style.display = 'none';
                document.getElementById('response').textContent =  this.response;
            }
        };

        xhr.send(formData); // Send the form data
   
    });

            function restrictAlphabets(e) {
          console.log("function called");
          var x = e.which || e.keycode;
          if (x >= 48 && x <= 57) return true;
          else return false;
        }

        function AlphabetsOnly(e) {
          var x = e.which || e.keycode;
          if ((x >= 65 && x <= 90) || (x >= 97 && x <= 122) || x == 46) return true;
          else return false;
        }
</script>





  </body>
  <!-- <script defer src="script.js"></script> -->
</html>

<!-- 
BEGIN  
   IF OLD.PAID_FEE != NEW.PAID_FEE THEN 
       INSERT INTO fees_log (STUDENT_DETAILS_ID,FEES_UPDATE,BALANCE,F_DATE)
       VALUES (NEW.ID,NEW.PAID_FEE - OLD.PAID_FEE,NEW.BALANCE_FEE,NOW());
   END IF;

END -->
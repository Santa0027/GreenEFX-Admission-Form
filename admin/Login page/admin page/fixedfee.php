<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <style>
      .form {
        background-color: rgb(192, 255, 179);
        width: 30%;
        margin: auto;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 2rem;
        border-radius: 2rem;
      }

      h2 {
        text-align: center;
      }

      .box {
        margin: 2rem;
      }
      .idsapn {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        width: 40%;
      }

      .idsapn p {
        /* padding-left: 1rem; */
      }

      form button {
        background: none;
        border: none;
        cursor: pointer;
        box-shadow: 1px 2px 3px white;
        width: 5rem;
        margin: auto;
        color: black;
        background-color: greenyellow;
        font-weight: bolder;
        height: 2rem;
        border-radius: 1rem;
      }
      #feeform{
        position:absolute;
        z-index: 3;
      }
    </style>
  </head>
  <body>
<?php
echo ' <div id="feeform">
<form class="form"  action="">
      <h2>Edit Fees</h2>
      <div class="box">
        <span class="idsapn"
          ><p>student id</p>
          <p>: 432</p></span
        >
        <span class="idsapn"
          ><p>course name</p>
          <p>: vfx</p></span
        >
        <label for="fees">change fees price :</label>
        <input type="text" name="fees" />
      </div>
      <button name="update" type="submit" value="submit">Update</button>
    </form>
    </div>';


?>
   
  </body>
</html>

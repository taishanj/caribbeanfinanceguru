<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="finanalysis.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<!-- Email Modal -->
<button id="myBtn">Open Modal</button>

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">

    <span class="close">&times;</span>
    <!--
    <form method="post" action="email.php" class="form-container">
    <header>
        <h1>Email Financial Health Report</h1>
    </header>

    <!--  <label for="email"><b>Email</b></label>
      <input type="text" autocomplete="off" placeholder="Email" name="email" required>

    <!--  <label for="firstname"><b>Firstname</b></label>
      <input type="text" autocomplete="off" placeholder="First Name" name="firstname" required>

    <!--  <label for="lastname"><b>Lastname</b></label>
      <input type="text" autocomplete="off" placeholder="Enter Last Name" name="lastname" required>

      <input type="radio" name="wants_followup" value="yes">Yes
      <input type="radio" name="wants_followup" value="no">No
      <span class="error">* <?php //echo $genderErr;?></span>
      <!--<button type="submit" class="btn">Submit</button>

    </form>
!-->
    <p id="firstname"><?php echo "Raphael" ?></p>
    <div class="buttons">
      <button class="submit">Submit</button>
    </div> <!--end buttons div -->
  </div> <!--end modal_content div -->
</div> <!--end moddal div -->

<!--modal js -->
<script>
//clear the form on refresh
/*
window.onload = function(){
  document.getElementById("form-container").innerHTML = "";
}
*/
// Get the modal
var modal = document.getElementById("myModal");

var footer = document.getElementsByClassName("footer");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
btn.onclick = function() {
modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
if (event.target == modal) {
  modal.style.display = "none";
}
}

//const modal_content = document.querySelector(".buttons");
//const email_result = button.querySelector(".submit");
const email_result = document.querySelector(".submit");
const user_choice_array = [];
 user_choice_array[0] = document.getElementById("firstname").innerHTML;
 user_choice_array[1] = "Jones";
 user_choice_array[2] = "raphaeljones1984@gmail.com";
//if email report button is clicked
email_result.onclick = ()=>{
    sendAnalysisToDB(user_choice_array);
}
</script>
<script src="store_analysis_result.js"></script>
</body>
</html>

$(document).ready(function() {
  $width = $("#mySavingBar").data('width');
  $("#mySavingBar").css("width", $width + "%");

  $width2 = $("#myInsuranceBar").data('width');
  $("#myInsuranceBar").css("width", $width2 + "%");

  $width3 = $("#myIncomeBar").data('width');
  $("#myIncomeBar").css("width", $width3 + "%");
});//end document ready function

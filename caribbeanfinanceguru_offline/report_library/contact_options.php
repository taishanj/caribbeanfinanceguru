
  <?php
  function user_contact_request($fin_health_resp_country)
  {
    if($fin_health_resp_country == "Trinidad and Tobago")
    {
      $display_checkbox =
      "<input class='telephone' type='text' autocomplete='off' placeholder='Enter Phone Number' name='user_telephone'>
      <br><input class='contact' type='checkbox' name='user_resp_yes_contact' value='true' checked>
      <label for='myinput' class='indented-checkbox-text'>Yes. I would like to be contacted by a financial services professional.</label>";
    }
    else {
      $display_checkbox = "";
    }

    $contactable_user = array(
    $display_checkbox,
  );
  return $contactable_user;
  }
  ?>

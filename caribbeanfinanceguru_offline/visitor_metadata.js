//File that calls on geolocation api.
//Data required to build accurate models for site users and reports
var visit_ip_addr="";
var visit_country="";
let apiKey = '0a9a1b27fd9b45f2971fbbbd829ddeea';
$(document).ready(function(){
    $.ajax({
      url: "https://api.bigdatacloud.net/data/ip-geolocation?key=" + apiKey,
      type: "GET",
      success: function(result){
        visit_ip_addr = result.ip;
        visit_country = result.country.name;

        //Store returned JSON data to PHP HTML
        document.getElementById("visit_ip_addr").innerHTML = visit_ip_addr;
        document.getElementById("visit_country").innerHTML = visit_country;

        console.log(visit_ip_addr);
        console.log(visit_country);
        /*pass any site visitor metadata to server*/
        $.post( "metadat.php",{visit_ip_addr,visit_country});
        },//end success function
        error: function(error){
          console.log(error);
        }//end error log
    });//end ajax call
});//end document function

/*Record persons who choose quiz*/
function SendDataFinQuiz(){
  visit_ip_addr = document.getElementById("visit_ip_addr").innerHTML;
  visit_country = document.getElementById("visit_country").innerHTML;
  visit_user_name = document.getElementById("visit_user_name").innerHTML;
  visit_user_email = document.getElementById("visit_user_email").innerHTML;
  visit_site_section = "finance health quiz";

  var httpr = new XMLHttpRequest();

  httpr.open("POST", "post_metadata.php", true);
  httpr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  httpr.send("visit_ip_addr="+visit_ip_addr+"&visit_country="+visit_country+"&visit_user_name="+visit_user_name+"&visit_user_email="+visit_user_email+"&visit_site_section="+visit_site_section);

  httpr.onreadystatechange = function() { // listen for state changes
  if (httpr.readyState == 4 && httpr.status == 200) { // when completed we can move away
    window.location = "finhealth.php";
  }
}
};//end SendDataFinQuiz method

function SendDataTTTIIQuiz(){
  visit_ip_addr = document.getElementById("visit_ip_addr").innerHTML;
  visit_country = document.getElementById("visit_country").innerHTML;
  visit_user_name = document.getElementById("visit_user_name").innerHTML;
  visit_user_email = document.getElementById("visit_user_email").innerHTML;
  visit_site_section = "TTII Quiz";

  var httpr = new XMLHttpRequest();

  httpr.open("POST", "post_metadata.php", true);
  httpr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  httpr.send("visit_ip_addr="+visit_ip_addr+"&visit_country="+visit_country+"&visit_user_name="+visit_user_name+"&visit_user_email="+visit_user_email+"&visit_site_section="+visit_site_section);

  httpr.onreadystatechange = function() { // listen for state changes
  if (httpr.readyState == 4 && httpr.status == 200) { // when completed we can move away
    window.location = "ttii_quiz.php";
  }
}
};//end SendDataTTIIQuiz method

/*
function SendRegisteredUserData(){
  visit_ip_addr = document.getElementById("visit_ip_addr").innerHTML;
  visit_country = document.getElementById("visit_country").innerHTML;
  visit_user_name = document.getElementById("visit_user_name").innerHTML;
  visit_user_email = document.getElementById("visit_user_email").innerHTML;
  console.log("Name " + visit_user_name);

  var httpr = new XMLHttpRequest();

  httpr.open("POST", "post_registration_data.php", true);
  httpr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  httpr.send("visit_ip_addr="+visit_ip_addr+"&visit_country="+visit_country+"&visit_user_name="+visit_user_name+"&visit_user_email="+visit_user_email);

  httpr.onreadystatechange = function() { // listen for state changes
  if (httpr.readyState == 4 && httpr.status == 200) { // when completed we can move away
    window.location = "ttii_user_dashboard.php";
    //alert('We are here!');
  }
}
};//end SendRegisteredUserData method
*/

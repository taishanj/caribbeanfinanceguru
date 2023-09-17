//selecting all required elements
const start_btn = document.querySelector(".start_btn button");
const info_box = document.querySelector(".info_box");
const quiz_box = document.querySelector(".quiz_box");
const result_box = document.querySelector(".result_box");
const option_list = document.querySelector(".option_list");
const exit_btn = info_box.querySelector(".buttons .quit");
const continue_btn = info_box.querySelector(".buttons .restart");
const restart_quiz = result_box.querySelector(".buttons .restart");
const submit_quiz = result_box.querySelector(".buttons .quit");
const user_choice_array = []; //array to store user answers_array
let temp_user_ans = [];
let tickIconTag = '<div class="icon tick"><i class="fas fa-check"></i></div>';
let crossIconTag = '<div class="icon cross"><i class="fas fa-times"></i></div>';

// if startQuiz button clicked
start_btn.onclick = ()=>{
    info_box.classList.add("activeInfo"); //show info box
    start_btn.style.visibility = 'hidden';
}

// if exitQuiz button clicked
exit_btn.onclick = ()=>{
    info_box.classList.remove("activeInfo"); //hide info box
    start_btn.style.visibility = 'visible';
}

// if continueQuiz button clicked
continue_btn.onclick = ()=>{
    info_box.classList.remove("activeInfo"); //hide info box
    quiz_box.classList.add("activeQuiz"); //show quiz box
    showQuestions(0); //calling showQestions function
    queCounter(1); //passing 1 parameter to queCounter
}

let timeValue =  15;
let que_count = 0;
let que_attempt = 0;
let que_numb = 1;
let counter;
let counterLine;
let widthValue = 0;



// if restartQuiz button clicked
restart_quiz.onclick = ()=>{
    quiz_box.classList.add("activeQuiz"); //show quiz box
    result_box.classList.remove("activeResult"); //hide result box
    que_count = 0;
    que_numb = 1;
    widthValue = 0;
    showQuestions(que_count); //calling showQestions function
    queCounter(que_numb); //passing que_numb value to queCounter
    startTimerLine(widthValue); //calling startTimerLine function
    next_btn.classList.remove("show"); //hide the next button
}

// if quitQuiz button clicked
submit_quiz.onclick = ()=>{
    sendAnswerToDB(user_choice_array);
    //window.location.href = "post_quiz_response.php";
}

const next_btn = document.querySelector("footer .next_btn");
const bottom_ques_counter = document.querySelector("footer .total_que");


// if Next Que button clicked
next_btn.onclick = ()=>{
    if(que_count < questions.length - 1){ //if question count is less than total question length
        que_count++; //increment the que_count value
        que_numb++; //increment the que_numb value
        que_attempt = 0;
        temp_user_ans = [];
        showQuestions(que_count); //calling showQestions function
        queCounter(que_numb); //passing que_numb value to queCounter
        next_btn.classList.remove("show"); //hide the next button
    }else{
      clearInterval(counter); //clear counter
      clearInterval(counterLine); //clear counterLine
      showResult(); //calling showResult function
    }
}

//questions array is accessed here for showing on screen.
function showQuestions(index){
    const que_text = document.querySelector(".que_text");
    //Display quiz question
    let que_tag = '<span>'+ questions[index].fin_quest_quest+'</span>';
    let option_tag = "";
    //holds mcq options
    let option_container = [];
    option_container[0] = mcq_options[index].fin_quest_option_one;
    option_container[1] = mcq_options[index].fin_quest_option_two;
    option_container[2] = mcq_options[index].fin_quest_option_three;
    option_container[3] = mcq_options[index].fin_quest_option_four;
    option_container[4] = mcq_options[index].fin_quest_option_five;
    option_container[5] = mcq_options[index].fin_quest_option_six;

    //display only options which are not blank
    for(var opt = 0; opt< option_container.length; opt++)
    {
      (option_container[opt] == "") ? null : option_tag += '<div class="option"><span>'+  option_container[opt] +'</span></div>';
    }

      que_text.innerHTML = que_tag; //adding new span tag inside que_tag //was missing all along
      option_list.innerHTML = option_tag; //adding new div tag inside option_tag
      const option = option_list.querySelectorAll(".option");
      //console.log(option); //list of all the options for question
    for(i=0; i < option.length; i++)
    {
        option[i].setAttribute("onclick", "optionSelected(this); optionStore(this);");
    }//end for
}//showQuestions()

function optionStore(answer){
  que_attempt++;
  let user_choice = answer.textContent; //getting the user select option

 if(que_attempt > 1)
 {
    user_choice_array.pop();
    user_choice_array.push(user_choice);
 }
 else
 {
    user_choice_array.push(user_choice);
 }
 //console.log(user_choice_array);
}//end function optionStore


//if user clicked on option
function optionSelected(answer,option_tag){
    next_btn.classList.add("show"); //show the next button if user selected any option
    if(temp_user_ans.length == 1)
    {
      //console.log(temp_user_ans.length);
      //Remove prior answer
      temp_user_ans[0].classList.remove("correct");
      let element = document.querySelector('.icon');//gets the element
      element.remove(); //issue here..???
      temp_user_ans.shift(); //remove the second array element

      //Select new answer
      temp_user_ans.push(answer); //getting user selected option
      temp_user_ans[0].classList.add("correct");
      temp_user_ans[0].insertAdjacentHTML("beforeend", tickIconTag);
    }
    else{
      //Select first answer
      temp_user_ans.push(answer);
      temp_user_ans[0].classList.add("correct");
      temp_user_ans[0].insertAdjacentHTML("beforeend", tickIconTag);
    }
}//end optionSelected()

function showResult(){
    info_box.classList.remove("activeInfo"); //hide info box
    quiz_box.classList.remove("activeQuiz"); //hide quiz box
    result_box.classList.add("activeResult"); //show result box
    //const scoreText = result_box.querySelector(".score_text");
}//end function showResult

//store PHP array of responses to MySQL DB
function sendAnswerToDB(user_choice_array){
  let fin_health_resp_ip_addr = document.getElementById("fin_health_resp_ip_addr").innerHTML;
  let fin_health_resp_gender = user_choice_array[0];
  let fin_health_resp_age = user_choice_array[1];
  let fin_health_resp_getapi_country = document.getElementById("fin_health_resp_getapi_country").innerHTML;
  let fin_health_resp_country = user_choice_array[2];
  let fin_health_resp_married = user_choice_array[3];
  let fin_health_resp_children_count = user_choice_array[4];
  let fin_health_resp_youngest = user_choice_array[5];
  let fin_health_resp_profession = user_choice_array[6];
  let fin_health_resp_profession_time = user_choice_array[7];
  let fin_health_resp_salary = user_choice_array[8];
  let fin_health_resp_other_income = user_choice_array[9];
  let fin_health_resp_mortgage = user_choice_array[10];
  let fin_health_resp_savings = user_choice_array[11];
  let fin_health_resp_investment_ratio = user_choice_array[12];
  let fin_health_resp_credit_card_debt = user_choice_array[13];
  let fin_health_resp_other_debt = user_choice_array[14];
  let fin_health_resp_insurance = user_choice_array[15];

  //https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest/send
  var httpr2 = new XMLHttpRequest();
  httpr2.open("POST", "post_quiz_response.php", true);
  //var url = 'post_quiz_response.php';
  var params = 'fin_health_resp_ip_addr='+fin_health_resp_ip_addr
               +'&fin_health_resp_gender='+fin_health_resp_gender
               +'&fin_health_resp_age='+fin_health_resp_age
               +'&fin_health_resp_getapi_country='+fin_health_resp_getapi_country
               +'&fin_health_resp_country='+fin_health_resp_country
               +'&fin_health_resp_married='+fin_health_resp_married
               +'&fin_health_resp_children_count='+fin_health_resp_children_count
               +'&fin_health_resp_youngest='+fin_health_resp_youngest
               +'&fin_health_resp_profession='+fin_health_resp_profession
               +'&fin_health_resp_profession_time='+fin_health_resp_profession_time
               +'&fin_health_resp_salary='+fin_health_resp_salary
               +'&fin_health_resp_other_income='+fin_health_resp_other_income
               +'&fin_health_resp_mortgage='+fin_health_resp_mortgage
               +'&fin_health_resp_savings='+fin_health_resp_savings
               +'&fin_health_resp_investment_ratio='+fin_health_resp_investment_ratio
               +'&fin_health_resp_credit_card_debt='+fin_health_resp_credit_card_debt
               +'&fin_health_resp_other_debt='+fin_health_resp_other_debt
               +'&fin_health_resp_insurance='+fin_health_resp_insurance;
  //httpr2.open("POST", url, true);
  httpr2.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  httpr2.send(params);
  httpr2.onreadystatechange = function() {//Call a function when the state changes.
      if(httpr2.readyState == 4 && httpr2.status == 200) {
          //alert(params);
          window.location = "post_quiz_response.php";
      }
  }
}//end function sendAnswerToDB

function queCounter(index){
    //creating a new span tag and passing the question number and total question
    let totalQueCounTag = '<span><p>'+ index +'</p> of <p>'+ questions.length +'</p> Questions</span>';
    bottom_ques_counter.innerHTML = totalQueCounTag;  //adding new span tag inside bottom_ques_counter
}

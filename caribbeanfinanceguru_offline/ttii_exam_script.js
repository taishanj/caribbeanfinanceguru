
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
const timeText = document.querySelector(".timer .time_left_txt");
const timeCount = document.querySelector(".timer .timer_sec");
const user_choice_array = []; //array to store user answers_array
const all_chapters = []; //testing
const unique_chapter_num = [];
const quest_score_map = new Map();
const quest_array_size = Object.keys(questions).length;


let tickIconTag = '<div class="icon tick"><i class="fas fa-check"></i></div>';
let crossIconTag = '<div class="icon cross"><i class="fas fa-times"></i></div>';

// if startQuiz button clicked
start_btn.onclick = ()=>{
    info_box.classList.add("activeInfo"); //show info box
    start_btn.style.visibility = 'hidden';
    getChaptersSelectedArray();
    initializeChapterQuestMap(unique_chapter_num);
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
    //showQuestions(1); //calling showQestions function
    showQuestions(que_count); //calling showQestions function
    queCounter(1); //passing 1 parameter to queCounter
    startTimer(15); //calling startTimer function
    startTimerLine(0); //calling startTimerLine function
}
let found = false;
let x = 0;
let counter;
let counterLine;
let que_attempt = 0;
let que_count = 0;
let que_numb = 1;
let timeValue =  30;
let userScore = 0;
let widthValue = 0;
let quest_chapter_num = null;


// if restartQuiz button clicked
restart_quiz.onclick = ()=>{
    quiz_box.classList.add("activeQuiz"); //show quiz box
    result_box.classList.remove("activeResult"); //hide result box
    que_count = 0;
    que_numb = 1;
    userScore = 0;
    widthValue = 0;
    showQuestions(que_count); //calling showQestions function
    queCounter(que_numb); //passing que_numb value to queCounter
    startTimerLine(widthValue); //calling startTimerLine function
    next_btn.classList.remove("show"); //hide the next button
}

// if quitQuiz button clicked
submit_quiz.onclick = ()=>{
    sendAnswerToDB(quest_score_map);
    //window.location.href = "post_ttii_quiz.php";
}

const next_btn = document.querySelector("footer .next_btn");
const bottom_ques_counter = document.querySelector("footer .total_que");

// if Next Que button clicked
next_btn.onclick = ()=>{
    //if(que_count < questions.length - 1){ //if question count is less than total question length
    if(que_count < questions.length -1){
        que_count++; //increment the que_count value
        que_numb++; //increment the que_numb value
        que_attempt = 0;
        showQuestions(que_count); //calling showQestions function
        queCounter(que_numb); //passing que_numb value to queCounter
        clearInterval(counter); //clear counter
        clearInterval(counterLine); //clear counterLine
        startTimer(timeValue); //calling startTimer function
        startTimerLine(widthValue); //calling startTimerLine function
        timeText.textContent = "Time Left"; //change the timeText to Time Left
        next_btn.classList.remove("show"); //hide the next button
    }else{
      clearInterval(counter); //clear counter
      clearInterval(counterLine); //clear counterLine
      showResult(); //calling showResult function
    }
}

function getChaptersSelectedArray(){
  for(i = 0; i < quest_array_size; i++){
      for(j = 0; j <= i; j++){
          if(unique_chapter_num[j] == questions[i].life_ins_quest_chapter_num){
            break;
          }
          else if(unique_chapter_num[j] != questions[i].life_ins_quest_chapter_num && i == j){
            unique_chapter_num.push(questions[i].life_ins_quest_chapter_num);
          }//end else if
      }//end inner for
  }//end outer for
  //console.log(unique_chapter_num);
}
function initializeChapterQuestMap(unique_chapter_num){
  for(i = 0; i < chapters.length; i++){
    all_chapters[i] = chapters[i].life_ins_quest_chapter_num; //set chapters to keep scores on
    quest_score_map.set(all_chapters[i] , -1);
  }
  //set chapters selected to 0 and others to x
  unique_chapter_num.forEach((unique_chapter_num, index) => {
  //console.log('Index: ' + index + ' Value: ' + number);
    if(quest_score_map.has(unique_chapter_num)){
      quest_score_map.set(unique_chapter_num , 0);
    }
  });
  console.log( quest_score_map);
}

//Store the number of questions correct per chapter. Initially assume to be 6 for all
function getChapterQuestCorrectCount(question_chapter){
 if(quest_score_map.has(question_chapter)){
   quest_score_map.set(question_chapter , quest_score_map.get(question_chapter) + 1);
 }
}

//questions array is accessed here for showing on screen.
function showQuestions(index){
    const que_text = document.querySelector(".que_text");
    //Display quiz question
    let quest_tag = '<span>'+ questions[index].life_ins_quest_question+'</span>'; //temporary and ghetto
    let option_tag = "";
    //holds mcq options
    let option_container = [];
    option_container[0] = mcq_options[index].life_ins_quest_option_a;
    option_container[1] = mcq_options[index].life_ins_quest_option_b;
    option_container[2] = mcq_options[index].life_ins_quest_option_c;
    option_container[3] = mcq_options[index].life_ins_quest_option_d;

    //display only options which are not blank
    for(var opt = 0; opt< option_container.length; opt++)
    {
      (option_container[opt] == "") ? null : option_tag += '<div class="option"><span>'+  option_container[opt] +'</span></div>';
    }

      que_text.innerHTML = quest_tag; //adding new span tag inside quest_tag //was missing all along
      option_list.innerHTML = option_tag; //adding new div tag inside option_tag
      const option = option_list.querySelectorAll(".option");
      //console.log(option); //list of all the options for question
    for(i=0; i < option.length; i++)
    {
        option[i].setAttribute("onclick", "optionSelected(this);");
    }//end for
}//showQuestions()

//if user clicked on option
function optionSelected(answer,option_tag){
    next_btn.classList.add("show"); //show the next button if user selected any option
    let userAns = answer.textContent; //getting user selected option
    let correcAns = questions[que_count].life_ins_quest_answer; //getting correct answer from db
    const allOptions = option_list.children.length; //getting all option items
    quest_chapter_num = questions[que_count].life_ins_quest_chapter_num;
    scoreIncrement = 0;

    if(userAns == correcAns){ //if user selected option is equal to array's correct answer
        userScore ++; //upgrading score value with 1
        answer.classList.add("correct"); //adding green color to correct selected option
        answer.insertAdjacentHTML("beforeend", tickIconTag); //adding tick icon to correct selected option
        getChapterQuestCorrectCount(quest_chapter_num); //track score by chapter
    }else{
        answer.classList.add("incorrect"); //adding red color to correct selected option
        answer.insertAdjacentHTML("beforeend", crossIconTag); //adding cross icon to correct selected option
        //console.log("Wrong Answer");

        for(i=0; i < allOptions; i++){
            if(option_list.children[i].textContent == correcAns){ //if there is an option which is matched to an array answer
                option_list.children[i].setAttribute("class", "option correct"); //adding green color to matched option
                option_list.children[i].insertAdjacentHTML("beforeend", tickIconTag); //adding tick icon to matched option
                console.log("Auto selected correct answer.");
            }
        }
    }
    for(i=0; i <= allOptions; i++){
        option_list.children[i].classList.add("disabled"); //once user select an option then disabled all options
    }
}//end optionSelected()

function startTimer(time){
    counter = setInterval(timer, 1000);
    function timer(){
        timeCount.textContent = time; //changing the value of timeCount with time value
        time--; //decrement the time value
        if(time < 9){ //if timer is less than 9
            let addZero = timeCount.textContent;
            timeCount.textContent = "0" + addZero; //add a 0 before time value
        }
        if(time < 0){ //if timer is less than 0
            clearInterval(counter); //clear counter
            timeText.textContent = "Time Off"; //change the time text to time off
            const allOptions = option_list.children.length; //getting all option items
            let correcAns = questions[que_count].answer; //getting correct answer from array
            for(i=0; i < allOptions; i++){
                if(option_list.children[i].textContent == correcAns){ //if there is an option which is matched to an array answer
                    option_list.children[i].setAttribute("class", "option correct"); //adding green color to matched option
                    option_list.children[i].insertAdjacentHTML("beforeend", tickIconTag); //adding tick icon to matched option
                    console.log("Time Off: Auto selected correct answer.");
                }
            }
            for(i=0; i < allOptions; i++){
                option_list.children[i].classList.add("disabled"); //once user select an option then disabled all options
            }
            next_btn.classList.add("show"); //show the next button if user selected any option
        }
    }
}

function startTimerLine(time){
  counterLine = setInterval(timer, 29);
  function timer(){
      time += 1; //upgrading time value with 1
      if(time > 549){ //if time value is greater than 549
          clearInterval(counterLine); //clear counterLine
    }
  }
}

function showResult(){
    info_box.classList.remove("activeInfo"); //hide info box
    quiz_box.classList.remove("activeQuiz"); //hide quiz box
    result_box.classList.add("activeResult"); //show result box
    const scoreText = result_box.querySelector(".score_text");
    if (userScore > 3){ // if user scored more than 3
        //creating a new span tag and passing the user score number and total question number
        let scoreTag = '<span>and congrats! 🎉, You got <p>'+ userScore +'</p> out of <p>'+ questions.length +'</p></span>';
        scoreText.innerHTML = scoreTag;  //adding new span tag inside score_Text
    }
    else if(userScore > 1){ // if user scored more than 1
        let scoreTag = '<span>and nice 😎, You got <p>'+ userScore +'</p> out of <p>'+ questions.length +'</p></span>';
        scoreText.innerHTML = scoreTag;
    }
    else{ // if user scored less than 1
        let scoreTag = '<span>and sorry 😐, You got only <p>'+ userScore +'</p> out of <p>'+ questions.length +'</p></span>';
        scoreText.innerHTML = scoreTag;
    }
}

//store PHP array of responses to MySQL DB
function sendAnswerToDB(quest_score_map){
  //Get demographic data for users who are visiting/browsing before pay
  //let ttii_quiz_user_ip_addr = document.getElementById('ttii_quiz_user_ip_addr').innerHTML;
  let visit_user_name = document.getElementById('visit_user_name').innerHTML;
  let visit_user_email = document.getElementById('visit_user_email').innerHTML;
  let total_score = userScore;
  /*********************************************************************/
  const scoreObj = Object.fromEntries(quest_score_map);
  const scoreJSON = JSON.stringify(scoreObj);
  console.log("Score is" + scoreJSON);

//not going to fly on web server
const baseUrl = 'post_ttii_quiz_result.php';
const queryParams = new URLSearchParams();
queryParams.set('data', scoreJSON);
queryParams.set('visit_user_name', visit_user_name);
queryParams.set('visit_user_email', visit_user_email);
queryParams.set('total_score', total_score);
const url = `${baseUrl}?${queryParams.toString()}`;
// Redirect to the new URL here
window.location.href = url;

}//end function sendAnswerToDB

function queCounter(index){
    let totalQueCounTag = '<span><p>'+ index +'</p> of <p>'+ questions.length +'</p> Questions</span>';
    bottom_ques_counter.innerHTML = totalQueCounTag;  //adding new span tag inside bottom_ques_counter
}

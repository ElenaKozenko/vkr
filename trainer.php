<?php session_start();
include('header.php'); 
get_session();?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf8mb4">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Тренировка</title>
</head>
<body>
<?php get_header(); ?>
<div class="container">
<?php
    include 'db.php';
    include 'api.php';

    $tkt_id = $_GET['tkt_id'];
    $name = $_GET['name'];
    $n = 0; //номер вопроса
    echo "<h5>$name. Тренировка</h>"; //название билета

    $q_array = getQuestByTicket($db, $tkt_id); //из api.php
?>   

<h5><time>00:00</time></h5>
<script>
let time = document.getElementsByTagName('time')[0];
let sec = 0;
let min = 0;
let t;

function tick(){
    sec++;
    if (sec >= 60) {
        sec = 0;
        min++; }
}
function add() {
    tick();
    time.textContent = (min > 9 ? min : "0" + min) + ":" + (sec > 9 ? sec : "0" + sec);
    timer();
}
function timer() {
    t = setTimeout(add, 1000);
}
timer();
start.onclick = timer;
stop.onclick = function() {
    clearTimeout(t);
}
reset.onclick = function() {
    time.textContent = "00:00";
    seconds = 0; minutes = 0;
}
</script>


<form id="form" action="trainer_query.php" method="post">
<?php
    $true_ans = array(); //массив для записи верных ответов теста
    foreach ($q_array as $row) 
{
            $n++; //счетчик номера вопроса
?>
    <div class="test">
        <div ans="<?php echo $n; ?>" class="answer"><?php echo "Вопрос №$n<br>"; ?> <br/> 
        <?php   if (isset($row['q_id'])) {
                $pt = 'uploaded/' . $tkt_id . '_' . $row['q_id'] . '.jpg';
                if (file_exists($pt)) {
                    $pathImg = '/uploaded/' . $tkt_id . '_' . $row['q_id'] . '.jpg';
                } else $pathImg = '/pic/no_pic.png';
            }
            echo "<img height=\"150px\" src=\"$pathImg\"><br>"; // отображение картинки
            echo "<p><b>",$row['task'], "</b></p>"; //вывод вопроса
        ?>
            <div class="form-check">
            <!-- вариант ответа 1 -->
            <input type="radio" name="ans_<?php echo $n;?>" value="1" class="form-check-input"> <label class="form-check-label"> <?php echo $row['ans1'] ?> </label></div>
            <!-- вариант ответа 2 -->
            <div class="form-check">
            <input type="radio" name="ans_<?php echo $n;?>" value="2" class="form-check-input"> <label class="form-check-label"> <?php echo $row['ans2'] ?> </label></div>
            <!-- вариант ответа 3 -->
            <?php if ($row['ans3'] != null) {
                echo "<div class=\"form-check\"><input type=\"radio\" name=\"ans_$n\" value=\"3\" class=\"form-check-input\"> <label class=\"form-check-label\">", $row['ans3'], "</label></div>"; ?>
            <!-- вариант ответа 4 --> 
            <?php if ($row['ans4'] != null) {  
                echo "<div class=\"form-check\"><input type=\"radio\" name=\"ans_$n\" value=\"4\" class=\"form-check-input\"> <label class=\"form-check-label\">", $row['ans4'], "</label></div>"; ?>
            <!-- вариант ответа 5 -->  
            <?php if ($row['ans5'] != null) {  
                echo "<div class=\"form-check\"><input type=\"radio\" name=\"ans_$n\" value=\"5\" class=\"form-check-input\"> <label class=\"form-check-label\">", $row['ans5'], "</label></div>"; }}} ?>
           
           <div>
                <p id="first" onclick="first()">Показать подсказку</p>
                <p id="first_yelloy"; style="display:none" onclick="first_yelloy()">Скрыть подсказку </p>
                <div id="second_hide" style="display:none"><?php echo $row['description']; ?></div>

</div>
        </div>
    </div>
<?php
}?>
   <input type="hidden" name="body" id="body">
   <input type="hidden" name="body2" id="body2" value="<?php echo $tkt_id ?>">
</form>
    <br><button onclick="nextAns()" class="btn btn-secondary">Далее</button>
</div>
    <script>  
        let curAns = 0;
        let ans = document.querySelectorAll(".test .answer"); //массив карточек
        let count = ans.length;
        nextAns();
        function nextAns() {
            if(curAns < count){
                curAns++;
                for (let i = 0; i < ans.length; i++) { //если не конец теста, то переключение карточек
                    const element = ans[i];
                    if(element.getAttribute('ans') == curAns){
                        element.classList.toggle('_active', true);
                    }else{
                        element.classList.toggle('_active', false);
                    }
                }
            }
            else{ //конец теста - сбор ответов с формы
                let answers = [];
                for (let i = 0; i < ans.length; i++) {
                    const element = ans[i];
                    let lis = element.querySelectorAll('input');
                    let val = undefined;
                    for (let j = 0; j < lis.length; j++) {
                        const element = lis[j];
                        if(element.checked){
                            val = element.value;
                        }
                    }
                    answers.push(val); //запись ответов пользователя
                }
                const TestBody = document.getElementById('body');
                TestBody.value = JSON.stringify(answers);
                document.forms.form.submit();
            }
    }

    function first() {

document.getElementById("second_hide").setAttribute("style", "opacity:1; transition: 1s; height: 100%;");
document.getElementById("first").setAttribute("style", "display: none");
document.getElementById("first_yelloy").setAttribute("style", "display: block");

}

function first_yelloy() {
document.getElementById("second_hide").setAttribute("style", "display: none");
document.getElementById("first_yelloy").setAttribute("style", "display: none");
document.getElementById("first").setAttribute("style", "display: block");
}


    </script>
<style>
.test .answer{
    display: none;
}
.test .answer._active{
    display: block;
}

p#first {
cursor: pointer;
line-height: 13px;
text-indent: 22px;
line-height: 33px;
border: 1px solid #d2d2d2;
font-size: 18px;
}

p#first_yelloy {
cursor: pointer;
background: #f5f5f5;
font-size: 18px;
color: black;
text-indent: 22px;
line-height: 33px;
border: 1PX SOLID #d2d2d2;
}

</style>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>	
</body>
</html>
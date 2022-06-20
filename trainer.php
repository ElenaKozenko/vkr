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
    <link rel="shortcut icon" href="pic/logo1.png" type="image/png">
    <!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
   ym(88926432, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/88926432" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
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
    echo "<b>$name. Тренировка</b>"; //название билета
    $q_array = getQuestByTicket($db, $tkt_id); //из api.php
?>   
<br><b><time>00:00</time></b>
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
            echo "<img class= \"illustration\"  src=\"$pathImg\"><br>"; // отображение картинки
            echo "<p><b>",$row['task'], "</b></p>"; //вывод вопроса
        ?>
            <div class="form-check">
            <!-- вариант ответа 1 -->
            <input type="radio" name="ans_<?php echo $n;?>" id="1ans_<?php echo $n;?>" value="1" class="form-check-input"> <label for="1ans_<?php echo $n;?>" class="form-check-label"> <?php echo $row['ans1'] ?> </label></div>
            <!-- вариант ответа 2 -->
            <div class="form-check">
            <input type="radio" name="ans_<?php echo $n;?>" id="2ans_<?php echo $n;?>" value="2" class="form-check-input"> <label for="2ans_<?php echo $n;?>" class="form-check-label"> <?php echo $row['ans2'] ?> </label></div>
            <!-- вариант ответа 3 -->
            <?php if ($row['ans3'] != null) {
                echo "<div class=\"form-check\"><input type=\"radio\" name=\"ans_$n\" id=\"3ans_$n\" value=\"3\" class=\"form-check-input\"> <label for=\"3ans_$n\" class=\"form-check-label\">", $row['ans3'], "</label></div>"; ?>
            <!-- вариант ответа 4 --> 
            <?php if ($row['ans4'] != null) {  
                echo "<div class=\"form-check\"><input type=\"radio\" name=\"ans_$n\" id=\"4ans_$n\" value=\"4\" class=\"form-check-input\"> <label for=\"4ans_$n\" class=\"form-check-label\">", $row['ans4'], "</label></div>"; ?>
            <!-- вариант ответа 5 -->  
            <?php if ($row['ans5'] != null) {  
                echo "<div class=\"form-check\"><input type=\"radio\" name=\"ans_$n\" id=\"5ans_$n\" value=\"5\" class=\"form-check-input\"> <label for=\"5ans_$n\" class=\"form-check-label\">", $row['ans5'], "</label></div>"; }}} ?>
            <div class="btn-description">
                <button onclick="DescriptionToggle(event)">Подсказка</button>
            </div>
            <pre class="description"><?php echo $row['description'];  ?></pre>
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
        function nextAns() { //функция переключения вопросов по кнопке Далее
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
                    const element = ans[i]; //выбор текущей карточки
                    let lis = element.querySelectorAll('input'); //статический массив элементов input
                    let val = undefined;
                    for (let j = 0; j < lis.length; j++) {
                        const element = lis[j]; //текущий input
                        if(element.checked){ 
                            val = element.value;
                        }
                    }
                    answers.push(val); //запись ответов пользователя в массив
                }
                const TestBody = document.getElementById('body');
                TestBody.value = JSON.stringify(answers); //преобразование в строку JSON
                document.forms.form.submit();
            }
    }

    function DescriptionToggle(e){ //функция показа подсказки
        e.preventDefault();
        const descript = e.target.parentElement.parentElement.querySelector('.description');
        if(descript){
            let isAct = descript.classList.toggle('__active'); //переключение класса (remove и add)
            e.target.innerText = isAct ? "Подсказка [скрыть]" : "Подсказка"; //если active поставить скрыть
        } 
    }
</script>
<style>
.test .answer{
    display: none;
}
.test .answer._active{
    display: block;
}
.description{
    display: none;;
    font-size: 14px;
    background-color: #f7f7f7;
    padding: 6px;
    border-radius: 4px;
    border: 1px solid #e3e3e3;
    
}
.description.__active{
    display: block;
    animation: showdesc 0.2s;
    white-space: pre-wrap;
    font-family: inherit;
}
.btn-description button{
    outline: none;
    background-color: inherit;
    border: none;
    color: #4d94de;
   
   cursor: pointer;
}
@keyframes showdesc{
    from{
        padding-top: 0px;
        padding-bottom: 0px;
        opacity: 0;
    }
    to{
        padding-top: 6px;
        padding-bottom: 6px;
        opacity: 1;
    }
}
</style>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>	
</body>
</html>            
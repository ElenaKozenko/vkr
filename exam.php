<?php include('header.php'); 
  get_session();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Document</title>
</head>
<body>
<?php
    get_header(); 

    include 'db.php';
    include 'api.php';

    $tkt_id = $_GET['tkt_id'];
    $name = $_GET['name'];
    $n = 0; //номер вопроса
    echo $name; //название билета

    $q_array = getQuestByTicket($db, $tkt_id); //из api.php
    $a_id = addNewAnswer($db, $_SESSION['user'], $tkt_id); //из api.php - код текущего ответа
?>   
<h3><time>00:00</time></h3>
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

<form id="form" action="exam_query.php" method="post">
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
            echo $row['task'], "<br>"; //вывод вопроса
        ?>
            <!-- вариант ответа 1 -->
            <input type="radio" name="ans_<?php echo $n;?>" value="1"> <label> <?php echo $row['ans1'] ?> </label><br>
            <!-- вариант ответа 2 -->
            <input type="radio" name="ans_<?php echo $n;?>" value="2"> <label> <?php echo $row['ans2'] ?> </label><br>
            <!-- вариант ответа 3 -->
            <?php if ($row['ans3'] != null) {
                echo "<input type=\"radio\" name=\"ans_$n\" value=\"3\"> <label>", $row['ans3'], "</label><br>"; ?>
            <!-- вариант ответа 4 --> 
            <?php if ($row['ans4'] != null) {  
                echo "<input type=\"radio\" name=\"ans_$n\" value=\"4\"> <label>", $row['ans4'], "</label><br>"; ?>
            <!-- вариант ответа 5 -->  
            <?php if ($row['ans5'] != null) {  
                echo "<input type=\"radio\" name=\"ans_$n\" value=\"5\"> <label>", $row['ans5'], "</label><br>"; }}} ?>
        </div>
    </div>
<?php
}?>
   <input type="hidden" name="body" id="body">
   <input type="hidden" name="body2" id="body2" value="<?php echo $tkt_id ?>">
   <input type="hidden" name="body3" id="body3" value="<?php echo $a_id ?>">
</form>
    <button onclick="nextAns()">Далее</button>

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
    </script>
<style>
.test .answer{
    display: none;
}
.test .answer._active{
    display: block;
}

</style>

</body>
</html>

<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <title>Тренажер</title>
  <style>
form {
    width: 500px;
}
</style>
  </head>
<body>

<?php 
    include 'db.php';  
    include 'api.php';
    include 'trainer_query.php';

    $tkt_id = $_GET['tkt_id'];  
    $name = $_GET['name'];
    $n = 0; //номер вопроса
    echo $name; //название билета

    $q_array = getQuestionsByTicket($db, $tkt_id);
?>

<form name="trainer" action="" method="post">
    <?php 
    $true_ans = array();
    foreach ($q_array as $row)
    { 
        $n++;
        echo "Вопрос №$n<br>";
        if( isset($row['q_id']) ){
            $pt = 'uploaded/'.$tkt_id.'_'.$row['q_id'].'.jpg';
            if(file_exists($pt)){
                $pathImg = '/uploaded/'.$tkt_id.'_'.$row['q_id'].'.jpg';
            }
            else $pathImg = '/pic/no_pic.png';
        }

        echo "<img height=\"150px\" src=\"$pathImg\"><br>";

        echo "<form name=\"trainer", $row['q_id'], "\" method=\"post\">";
        echo $row['task'], "<br>"; ?>
    <!-- вариант ответа 1 -->
        <input type="radio" id="answerChoice1" name="answer" value="1">
        <label for="contactChoice1"><?php echo $row['ans1'] ?></label><br>
    <!-- вариант ответа 2 -->
        <input type="radio" id="answerChoice2" name="answer" value="2">
        <label for="contactChoice1"><?php echo $row['ans2'] ?></label><br>
    <!-- вариант ответа 3 -->
    <?php if($row['ans3'] != null) 
    {  
       echo"<input type=\"radio\" id=\"answerChoice3\" name=\"answer\" value=\"3\">
        <label for=\"contactChoice1\">", $row['ans3'], "</label><br>"; 
        if($row['ans4'] != null) 
        {  //вариант ответа 4
            echo"<input type=\"radio\" id=\"answerChoice4\" name=\"answer\" value=\"4\">
             <label for=\"contactChoice1\">", $row['ans4'], "</label><br>";
            if($row['ans5'] != null) 
            {  //вариант ответа 5
                echo"<input type=\"radio\" id=\"answerChoice5\" name=\"answer\" value=\"5\">
                 <label for=\"contactChoice1\">", $row['ans5'], "</label><br>"; 
            }
        }
    }
    
    $true_ans[$n-1] = $row['true_ans'];
    echo "<input type=\"submit\" name=\"answer",$row['q_id'],"\" value=\"Далее\">";
    echo "</form>";
    }
    ?>
    <a>Завершить</a>

    <?php
    
    ?>



</body>
</html>

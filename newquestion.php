<?php include('header.php'); 
  get_session();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Новый вопрос</title>
    <style>
    label,
    input {
        width: 450px;
        padding: 5px;
        margin: 20px;
    }

    *,
    *:before,
    *:after {
        box-sizing: border-box;
    }

    form {
        width: 500px;
    }
    </style>

<body>

    <?php 
    get_header(); 
    
    include 'db.php';  
    include 'api.php';
    include 'questions_query.php';
    $topic = getAllTopics($db);
    $tkt = getAllTickets($db);

    
    $tkt_id = $_GET['tkt_id'];
    $n = $_GET['n']; //порядковый номер билета

    $pathImg = '/pic/no_pic.png';
    if( isset($_GET['q']) ){
        $pt = 'uploaded/'.$tkt_id.'_'.$_GET['q_id'].'.jpg';
        if(file_exists($pt)){
            $pathImg = '/uploaded/'.$tkt_id.'_'.$_GET['q_id'].'.jpg';
        }
    }
    
?>
    <img height="100px" src="<?php echo $pathImg; ?>" alt="">
    <form onSubmit="(e) => e.preventDefault()" method="post" enctype="multipart/form-data">

        <!-- название билета и вопроса-->
        <?php echo "Cоздание вопроса №$n к билету №$tkt_id" ?>

        <br>
        <label for="theme">Тема билета*:</label> <!-- выбор темы билета -->
        <select id="theme" name="theme">
            <?php foreach ($topic as $row){
                $id = $row['tp_id'];
                $name = $row['name'];
                echo "<option value=\"$id\">$name</option>";}?>
        </select>


        <label for="upload_img">Загрузить изображение</label>
        <input type="file" id="upload_img" name="upload_img" accept=".jpg, .jpeg, .png">

        <label for="question">Вопрос*: </label> <!-- ввод вопроса -->
        <input type="text" id="question" name="question" placeholder="Введите вопрос здесь" maxlength="">

        <!-- ввод ответов -->
        <label for="answer1">Вариант ответа 1*: </label>
        <input type="text" id="answer1" name="answer1" placeholder="Введите ответ здесь" maxlength="">

        <label for="answer2">Вариант ответа 2*:</label>
        <input type="text" id="answer2" name="answer2" placeholder="Введите ответ здесь" maxlength="">

        <label for="answer3">Вариант ответа 3:</label>
        <input type="text" id="answer3" name="answer3" placeholder="Введите ответ здесь" maxlength="">

        <label for="answer4">Вариант ответа 4:</label>
        <input type="text" id="answer4" name="answer4" placeholder="Введите ответ здесь" maxlength="">

        <label for="answer5">Вариант ответа 5:</label>
        <input type="text" id="answer5" name="answer5" placeholder="Введите ответ здесь" maxlength="">

        <label for="answer">Номер верного ответа*:</label> <!-- номер верного ответа -->
        <input type="number" id="answer" name="answer" min="1" max="5">

        <label for="question">Описание ответа, подсказка:</label>
        <input type="text" id="description" name="description" placeholder="Введите подсказку здесь" maxlength="">

        <input type="reset" value="Очистить поля">

        <input type="submit" value="Добавить вопрос">
    </form>
<p>*-обязательные поля</p>
    <?php echo "<a href=\"questions.php?tkt_id=$tkt_id\">Вернутья к списку вопросов</a>" ?>
    <?php
    if($_POST['question'] != '')  
            {
            $n=0;
            $tp_id=$_POST['theme'];
            $task=$_POST['question'];
            if ($_POST['answer1'] == '') $ans1 = null; else {$ans1=$_POST['answer1']; $n++;}
            if ($_POST['answer2'] == '') $ans2 = null; else {$ans2=$_POST['answer2']; $n++;}
            if ($_POST['answer3'] == '') $ans3 = null; else {$ans3=$_POST['answer3']; $n++;}
            if ($_POST['answer4'] == '') $ans4 = null; else {$ans4=$_POST['answer4']; $n++;}
            if ($_POST['answer5'] == '') $ans5 = null; else {$ans5=$_POST['answer5']; $n++;}
            if ($_POST['description'] == '') $description = null; else $description=$_POST['description'];
            if ($_POST['answer'] == '') $true_ans = null; 
            else if($_POST['answer'] > $n) echo "(Вы ввели в качестве номера верного ответа ".$_POST['answer'].", но заполнили $n поля)";
            else {
                $true_ans=$_POST['answer'];
                $q_id = addQuestion($db, $tkt_id, $tp_id, $task, $true_ans, $ans1, $ans2, $ans3, $ans4, $ans5, $description);
                UploadImage($tkt_id, $q_id);}
}


if($_POST['question'] != '')  
{
$num=0;

$tp_id=$_POST['theme'];
$task=$_POST['question'];
if ($_POST['answer1'] == '') 
{
    $ans1 = null; echo "<script>alert('Не заполнено обязательное поле Ответ 1')</script>";} 
    else{
        $ans1=$_POST['answer1']; $num++;

        if ($_POST['answer2'] == '') { $ans2 = null; echo "<script>alert('Не заполнено обязательное поле Ответ 2')</script>";}
        else{
            $ans2=$_POST['answer2']; $num++;
        
            if ($_POST['answer3'] == '') $ans3 = null; else {$ans3=$_POST['answer3']; $num++;}
            if ($_POST['answer4'] == '') $ans4 = null; else {$ans4=$_POST['answer4']; $num++;}
            if ($_POST['answer5'] == '') $ans5 = null; else {$ans5=$_POST['answer5']; $num++;}

            if ($_POST['description'] == '') $description = null; else $description=$_POST['description'];

            if ($_POST['answer'] == '') {$true_ans = null;}
            elseif($_POST['answer'] > $num) echo '<script>alert("Вы ввели в качестве номера верного ответа '.$_POST['answer'].', но заполнили '.$num.' поля ответов")</script>';
            else{ 
                    $true_ans=$_POST['answer']; 
                    $q_id = addQuestion($db, $tkt_id, $tp_id, $task, $true_ans, $ans1, $ans2, $ans3, $ans4, $ans5, $description);
                    UploadImage($tkt_id, $q_id); 
                    echo "<script>alert('Вопрос успешно добавлен');</script> ";
                    $n = $_GET['n'];
                    settype($n, "integer");
                    $n++;
                    echo "<a href=\"newquestion.php?tkt_id=$tkt_id&n=$n\">Добавить новый вопрос к билету</a>";
            }
        }
    }  
}
?>
</body>
</html>
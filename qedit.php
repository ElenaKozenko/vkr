<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <title>Новый вопрос</title>
  <style>
    label, input {
        width: 450px;
        padding: 5px;
        margin: 20px;
    }
    *, *:before, *:after {
  box-sizing: border-box;
}
form {
    width: 500px;
}
</style>
  </head>
<body>

<?php 
    include 'db.php';  
    include 'api.php';
    include 'questions_query.php';

    $tkt_id = $_GET['tkt_id'];
    $q_id = $_GET['q_id'];
    $n = $_GET['n']; //порядковый номер билета

    $topic = getAllTopics($db);
    $tkt = getAllTickets($db);
    $qform = questionFormFill($db, $q_id);
    

    $pathImg = '/pic/no_pic.png';
    if( isset($_GET['q_id']) ){
        $pt = 'uploaded/'.$_GET['q_id'].'.jpg';
        if(file_exists($pt)){
            $pathImg = '/uploaded/'.$_GET['q_id'].'.jpg';
        }
    }
    
?>
<img height="200px" src="<?php echo $pathImg; ?>" alt="">
    <form name="" action="" method="post" enctype="multipart/form-data">
        
        <!-- название билета и вопроса-->
        <?php echo "Вопрос №$n к билету №$tkt_id" ?>

<br>
<?php foreach ($qform as $row1){ 
    $tp_id1 = $row1['tp_id'];
    questionTopic($db, $tp_id1);
 ?>

        <label for="theme">Выбор новой темы билета:</label> <!-- выбор темы билета -->
            <select id="theme" name="theme">
            <?php foreach ($topic as $row){
                $id = $row['tp_id'];
                $name = $row['name'];
                echo "<option value=\"$id\">$name</option>";}?>
            </select>

            
        <label for="upload_img">Загрузить изображение</label>
        <input type="file" id="upload_img" name="upload_img"
          accept=".jpg, .jpeg, .png">

        <br><input style="width: 20px;" type="checkbox" id="img_del" name="img_del">Удалить картинку<br>
      
       
        <label for="question">Вопрос: </label> <!-- ввод вопроса -->
        <input type="text" id="question" name="question" value="<?php echo $row1['task'];?>">
        
         <!-- ввод ответов -->
        <label for="answer1">Вариант ответа 1: </label>
        <input type="text" id="answer1" name="answer1" value="<?php echo $row1['ans1'];?>">

        <label for="answer2">Вариант ответа 2:</label>
        <input type="text" id="answer2" name="answer2" value="<?php echo $row1['ans2'];?>">

        <label for="answer3">Вариант ответа 3:</label>
        <input type="text" id="answer3" name="answer3" value="<?php echo $row1['ans3'];?>">

        <label for="answer4">Вариант ответа 4:</label>
        <input type="text" id="answer4" name="answer4" value="<?php echo $row1['ans4'];?>">

        <label for="answer5">Вариант ответа 5:</label>
        <input type="text" id="answer5" name="answer5" value="<?php echo $row1['ans5'];?>"> 

        <label for="answer">Номер верного ответа:</label> <!-- номер верного ответа -->
        <input type="number" id="answer" name="answer" value="<?php echo $row1['true_ans'];?>">

        <label for="question">Описание ответа, подсказка:</label>
        <input type="text" id="description" name="description" value="<?php echo $row1['description'];}?>">

        <input type="submit" value="Редактировать вопрос">
    </form>
    <!-- if(isset($_POST['question'])) -->
<?php
    if($_POST['question'] != '')  
            {
            
            if ($_POST['theme'] == $tpid1) $tp_id = $tp_id1;
            else $tp_id=$_POST['theme'];
            $task=$_POST['question'];
            if ($_POST['answer'] == '') $true_ans = null; else $true_ans=$_POST['answer'];
            if ($_POST['answer1'] == '') $ans1 = null; else $ans1=$_POST['answer1'];
            if ($_POST['answer2'] == '') $ans2 = null; else $ans2=$_POST['answer2'];
            if ($_POST['answer3'] == '') $ans3 = null; else $ans3=$_POST['answer3'];
            if ($_POST['answer4'] == '') $ans4 = null; else $ans4=$_POST['answer4'];
            if ($_POST['answer5'] == '') $ans5 = null; else $ans5=$_POST['answer5'];
            if ($_POST['description'] == '') $description = null; else $description=$_POST['description'];
        editQuestion($db, $q_id, $tkt_id, $tp_id, $task, $true_ans, $ans1, $ans2, $ans3, $ans4, $ans5, $description);
        UploadImage();
    }


?>

<?php echo "<a href=\"questions.php?tkt_id=$tkt_id\">Вернутья к списку вопросов</a>" ?>

</body>
</html>

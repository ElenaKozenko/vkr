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
    <title>Новый вопрос</title>
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
<div class="container">
    <img height="100px" src="<?php echo $pathImg; ?>" alt="">
    <form onSubmit="(e) => e.preventDefault()" method="post" enctype="multipart/form-data">
        <!-- название билета и вопроса-->
        <?php echo "<h4>Cоздание вопроса №$n к билету №$tkt_id</h4>" ?>

        <div class="form-group">
        <label for="upload_img">Загрузить изображение</label>
        <input type="file" id="upload_img" name="upload_img" accept=".jpg, .jpeg, .png"  class="form-control-file">
        </div>
        <p><span style="color: red;">*</span>-обязательные поля</p>
        <div class="form-group row">
        <label for="theme" class="col-sm-2 col-form-label">Тема билета<span style="color: red;">*</span>:</label> <!-- выбор темы билета -->
        <div class="col-sm-10">
        <select id="theme" name="theme" class="form-control">
            <?php foreach ($topic as $row){
                $id = $row['tp_id'];
                $name = $row['name'];
                echo "<option value=\"$id\">$name</option>";}?>
        </select>
        </div></div>

        
        <div class="form-group row">
        <label for="question" class="col-sm-2 col-form-label">Вопрос<span style="color: red;">*</span>: </label> <!-- ввод вопроса -->
        <div class="col-sm-10">
        <textarea  class="form-control" id="question" name="question" placeholder="Введите вопрос здесь"></textarea>
        </div></div>
        <!-- ввод ответов -->
        <div class="form-group row">
        <label for="answer1" class="col-sm-2 col-form-label">Вариант ответа 1<span style="color: red;">*</span>: </label>
        <div class="col-sm-10">
        <textarea  class="form-control" id="answer1" name="answer1" placeholder="Введите ответ здесь"></textarea>
        </div></div>
        <div class="form-group row">
        <label for="answer2" class="col-sm-2 col-form-label">Вариант ответа 2<span style="color: red;">*</span>:</label>
        <div class="col-sm-10">
        <textarea  class="form-control" id="answer2" name="answer2" placeholder="Введите ответ здесь"></textarea>
        </div></div>

        <div class="form-group row">
        <label for="answer3" class="col-sm-2 col-form-label">Вариант ответа 3:</label>
        <div class="col-sm-10">
        <textarea  class="form-control" id="answer3" name="answer3" placeholder="Введите ответ здесь"></textarea>
        </div></div>

        <div class="form-group row">
        <label for="answer4" class="col-sm-2 col-form-label">Вариант ответа 4:</label>
        <div class="col-sm-10">
        <textarea  class="form-control" id="answer4" name="answer4" placeholder="Введите ответ здесь"></textarea>
        </div></div>

        <div class="form-group row">
        <label for="answer5" class="col-sm-2 col-form-label">Вариант ответа 5:</label>
        <div class="col-sm-10">
        <textarea  class="form-control" id="answer5" name="answer5" placeholder="Введите ответ здесь"></textarea>
        </div></div>

        <div class="form-group row">
        <label for="answer" class="col-sm-2 col-form-label">Номер верного ответа<span style="color: red;">*</span>:</label> 
        <div class="col-sm-2"><!-- номер верного ответа -->
        <input type="number" id="answer" name="answer" min="1" max="5" class="form-control" >
        </div></div>

        <div class="form-group row">
        <label for="question" class="col-sm-2 col-form-label">Описание ответа, подсказка:</label>
        <div class="col-sm-10">
        <textarea  class="form-control" id="description" name="description" placeholder="Введите подсказку здесь" maxlength=""></textarea>
        </div></div>

        <input type="reset" value="Очистить поля" class="btn btn-secondary">

        <input type="submit" value="Добавить вопрос" class="btn btn-success">
    </form>

    <?php echo "<a href=\"questions.php?tkt_id=$tkt_id\">Вернутья к списку вопросов</a>" ?>
<?php


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
                    echo "<script>window.location = 'questions.php?tkt_id=$tkt_id';</script>
				";
            }
        }
    }  
}
?>
</body>
</html>
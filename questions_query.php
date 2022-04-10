<?php
//РАБОТА С ТАБЛИЦЕЙ "Вопросы"
//ВСТАВКА В "Вопросы""
function  addQuestion($db, $tkt_id, $tp_id, $task, $true_ans, $ans1, $ans2, $ans3, $ans4, $ans5, $description)
{
    try {
        $sql = "INSERT INTO questions (tkt_id, tp_id, task, true_ans, ans1, ans2, ans3, ans4, ans5, `description` )
            VALUES( :tkt_id, :tp_id, :task, :true_ans, :ans1, :ans2, :ans3, :ans4, :ans5, :description);";
        $stmt = $db->prepare($sql);
        $stmt->bindValue('tkt_id', $tkt_id, PDO::PARAM_INT);
        $stmt->bindValue('tp_id', $tp_id, PDO::PARAM_INT);
        $stmt->bindValue('task', $task, PDO::PARAM_STR);
        $stmt->bindValue('true_ans', $true_ans, PDO::PARAM_INT);
        $stmt->bindValue('ans1', $ans1, PDO::PARAM_STR);
        $stmt->bindValue('ans2', $ans2, PDO::PARAM_STR);
        $stmt->bindValue('ans3', $ans3, PDO::PARAM_STR);
        $stmt->bindValue('ans4', $ans4, PDO::PARAM_STR);
        $stmt->bindValue('ans5', $ans5, PDO::PARAM_STR);
        $stmt->bindValue('description', $description, PDO::PARAM_STR);
        $stmt->execute();
        echo "<br>Вопрос успешно добавлен<br>";
        
    } catch (PDOException $e) {
        echo "<br>Ошибка вставки. Проверьте заполнение полей (типы данных). Поля \"Вопрос\", \"Вариант ответа 1\", \"Вариант ответа 2\", \Номер верного ответаариант ответа 1\", не должны быть пустыми.<br>";
        echo "You have an error: " . $e->getMessage() . "<br>";
        echo "On line: " . $e->getLine() . "<br>";
    }

    echo var_dump($stmt->errorInfo());
}

//Вывод вопросов определенного билета
function getQuestionsByTicket($db, $tkt_id)
{
    $sql = "SELECT q_id, task FROM questions WHERE questions.tkt_id = $tkt_id";
    $result = array();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[$row['q_id']] = $row;
    }
    return $result;
}

//Вывод данных вопроса по его коду
function questionFormFill($db, $q_id)
{
    $sql = "SELECT * FROM questions WHERE q_id = $q_id";
    $result = array();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[$row['q_id']] = $row;
    }
    return $result;
}

//Вывод темы вопроса
function questionTopic($db, $tp_id)
{
    $stmt = $db->prepare("SELECT `name` FROM `topics` WHERE `tp_id` = ?");
    $stmt->execute(array($tp_id));
    $value = $stmt->fetch(PDO::FETCH_COLUMN);
    echo "Текущая тема вопроса: $value <br>";
}

//Редактирование вопроса
function editQuestion($db, $q_id, $tkt_id, $tp_id, $task, $true_ans, $ans1, $ans2, $ans3, $ans4, $ans5, $description)
{
    try {
        $sql = "UPDATE questions SET
        tkt_id = :tkt_id,
        tp_id = :tp_id,
        task = :task,
        true_ans = :true_ans,
        ans1 = :ans1,
        ans2 = :ans2,
        ans3 = :ans3,
        ans4 = :ans4,
        ans5 = :ans5,
        description = :description  
        WHERE q_id = :q_id";

        $stmt = $db->prepare($sql);
        $stmt->bindValue('tkt_id', $tkt_id, PDO::PARAM_INT);
        $stmt->bindValue('tp_id', $tp_id, PDO::PARAM_INT);
        $stmt->bindValue('task', $task, PDO::PARAM_STR);
        $stmt->bindValue('true_ans', $true_ans, PDO::PARAM_INT);
        $stmt->bindValue('ans1', $ans1, PDO::PARAM_STR);
        $stmt->bindValue('ans2', $ans2, PDO::PARAM_STR);
        $stmt->bindValue('ans3', $ans3, PDO::PARAM_STR);
        $stmt->bindValue('ans4', $ans4, PDO::PARAM_STR);
        $stmt->bindValue('ans5', $ans5, PDO::PARAM_STR);
        $stmt->bindValue('description', $description, PDO::PARAM_STR);
        $stmt->bindValue('q_id', $q_id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "<br>Возникла ошибка при редактировании :(. Проверьте заполнение полей (типы данных). Поля \"Вопрос\", \"Вариант ответа 1\", \"Вариант ответа 2\", \Номер верного ответа\", не должны быть пустыми.<br>";
        echo "You have an error: " . $e->getMessage() . "<br>";
        echo "On line: " . $e->getLine() . "<br>";
    }
}



function deleteQuestion($db, $q_id)
{
        $sql="DELETE FROM questions WHERE q_id=:q_id";
        $stmt=$db->prepare($sql);
        $stmt->bindValue('q_id', $q_id, PDO::PARAM_INT);
        $stmt->execute();   
}

?>
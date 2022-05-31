<?php
function get_session(){

      global $u_name;
      $u_name = $_SESSION['u_surname'].' '.$_SESSION['u_name'].' '.$_SESSION['u_patr'];
}
function get_header(){
      global $u_name;

/* echo '<div class="bg-dark" style="width: 100%; display: flex;
justify-content: flex-end;"><span style="color: rgba(255,255,255,.5)">'.$u_name.'</span></div> */
echo '<nav class="navbar navbar-expand-md bg-dark navbar-dark"> 
<!-- Brand -->
<a class="navbar-brand" href="pdd.php">
<img src="pic/logo2.png" alt="Logo" style="width:40px;">
</a>
<!-- Toggler/collapsibe Button -->
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
  <span class="navbar-toggler-icon"></span>
</button>
<!-- Navbar links -->
<div class="collapse navbar-collapse" id="collapsibleNavbar">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="pdd.php">Главная</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="exam_tkt.php">Экзамен</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="trainer_tkt.php">Тренажер</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="myresults.php">Мои результаты</a>
    </li>';

      if($_SESSION['status'] === 'admin' || $_SESSION['status'] === 'instructor'  ) 
      echo '      <li class="nav-item">
      <a class="nav-link" href="student_results.php">Результаты студентов</a>
    </li>';
      echo '      <li class="nav-item">
      <a class="nav-link" href="change_password.php">Сменить пароль</a>
    </li>';
      if($_SESSION['status'] === 'admin') echo '      <li class="nav-item">
      <a class="nav-link" href="tickets.php">Редактор билетов</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="users.php">Пользователи</a>
    </li>'; 
      echo '      <li class="nav-item">
      <a class="nav-link" href="logout.php">Выйти</a>
    </li>
    
  </ul>
</div>
</nav>
      ';
}
?>
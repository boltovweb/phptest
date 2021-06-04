<?

include "config.php";
ob_start();

session_start();
if(!isset($_SESSION["session_username"])) {
  header("location: ../login");
  exit();
}else{
  $userlogin1 = $_SESSION["session_username"];
  $result1 = mysqli_query($conn, "SELECT * FROM `user` WHERE `login` = '${userlogin1}'");
  while($row13 = mysqli_fetch_array($result1))
  {
    $dostupsql= $row13['dostup'];

  }
  if ($dostupsql != 5) {
   header("location: ../login");
   exit();
 } 
}
$acc = mysqli_query($conn, "SELECT * FROM `user` WHERE `login` = '${userlogin1}'"); 
while($row = mysqli_fetch_array($acc))
{
  $userlogin = $row['login'];
  $userid = $row['id'];
  $useremail = $row['email'];
  $userbalance= $row['balance'];
  $useravatar= $row['avatar'];
  $userreg= $row['regdata'];
  $userpassword= $row['password'];
  $dostupsqls= $row['dostup'];


}

$today = date("H:i d.m.y");
if ($dostupsqls == 0) {
  $userdostup = "Пользователь";
}else if ($dostupsqls == 1) {
  $userdostup = "Бустер";
}else if ($dostupsqls == 2) {
  $userdostup = "TBD Работник";
}else if ($dostupsqls == 3) {
  $userdostup = "Администрация";
}
?>
<?
$resban = mysqli_query($conn, "SELECT * FROM `user` WHERE `login` = '${userlogin1}'"); 
while($ban = mysqli_fetch_array($resban))
{
  $ban1 = $ban['ban'];
  $ban2 = $ban['reasonban'];
} 
if ($ban1 != 0) {
  echo "Доступ на сайт заблокирован администрацией. <br>Причина блокинровки вашего аккаунта:".$ban2;
  $todaylogiasdasd = date("H:i d.m.y");
  mysqli_query($conn, "INSERT INTO `logi` (`id`, `user`, `desct`, `dtime`, `secret`) VALUES ('', '$userlogin', 'Ошибка: попытка войти если бан', '$todaylogiasdasd', '0');");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><? echo $title; ?></title>

  <!-- Favicon -->
  <link rel="shortcut icon" href="assets/images/logo/favicon.png">

  <!-- page css -->

  <!-- Core css -->
  <link href="assets/css/app.min.css" rel="stylesheet">

</head>

<body>
  <div class="app">
    <div class="layout">
      <!-- Header START -->
      <div class="header">
        <div class="logo logo-dark">
          <a href="index">
            <img src="https://cdmdoto.com/upload/601e669b544b7.png" alt="Logo">

          </a>
        </div>
        <div class="logo logo-white">
          <a href="index">
            <img src="https://cdmdoto.com/upload/601e669b544b7.png" alt="Logo">

          </a>
        </div>
        <div class="nav-wrap">
          <ul class="nav-left">
            <li class="desktop-toggle">
              <a href="javascript:void(0);">
                <i class="anticon"></i>
              </a>
            </li>
            <li class="mobile-toggle">
              <a href="javascript:void(0);">
                <i class="anticon"></i>
              </a>
            </li>
            <li>
              <a href="../account">
                Аккаунт на сайте
              </a>
            </li>
          </ul>
          <ul class="nav-right">

            <li class="dropdown dropdown-animated scale-left">
              <div class="pointer" data-toggle="dropdown">
                <div class="avatar avatar-image  m-h-10 m-r-15">
                  <img src="../upload/<? echo $useravatar; ?>" alt="">
                </div>
              </div>
              <div class="p-b-15 p-t-20 dropdown-menu pop-profile">
                <div class="p-h-20 p-b-15 m-b-10 border-bottom">
                  <div class="d-flex m-r-50">
                    <div class="avatar avatar-lg avatar-image">
                      <img src="../upload/<? echo $useravatar; ?>" alt="">
                    </div>
                    <div class="m-l-10">
                      <p class="m-b-0 text-dark font-weight-semibold"><? echo $userlogin; ?></p>
                      <p class="m-b-0 opacity-07"><? echo $userdostup; ?></p>
                    </div>
                  </div>
                </div>



                <a href="../logout" class="dropdown-item d-block p-h-15 p-v-10">
                  <div class="d-flex align-items-center justify-content-between">
                    <div>
                      <i class="anticon opacity-04 font-size-16 anticon-logout"></i>
                      <span class="m-l-10">Выйти</span>
                    </div>
                    <i class="anticon font-size-10 anticon-right"></i>
                  </div>
                </a>
              </div>
            </li>

          </ul>
        </div>
      </div>    
      <!-- Header END -->

      <!-- Side Nav START -->
      <? include "menu.php"; ?>
      <!-- Side Nav END -->
      <? 
      if (isset($_GET['account'])) {
        $result_seacr_cabinetss = mysqli_query($conn, "SELECT * FROM `traning_account` WHERE `username` = '$userlogin1'");
        if (mysqli_num_rows($result_seacr_cabinetss) == 0) {
          mysqli_query($conn, "INSERT INTO `traning_account` (`id`, `username`, `date`) VALUES (NULL, '$userlogin1', '$today');");
          mysqli_query($conn, "INSERT INTO `t_nof` (`id`, `user`, `text`, `dtime`) VALUES ('', '$userlogin1', 'Вы успешно создали свой аккаунт тренера, можете приступить к его настройке. gl & hf', '$today');");
          header("location:index");
          exit();
        }
      }
      ?>
      <!-- Page Container START -->
      <div class="page-container">
        <?
        $oborot = mysqli_query($conn, "SELECT SUM(`summ`) AS summaru FROM `traing_order` WHERE username = '$userlogin1'");
        $row = mysqli_fetch_array($oborot);
        if ($row['summaru'] == "") {
          $sum = "0";
        }else{
          $sum = $row['summaru'];
        }

        

        // $c = mysqli_query($conn, "SELECT COUNT(1) AS usersf FROM user WHERE activated = 0");
        // $d = mysqli_fetch_array($c);
        // $usersf = $d['usersf'];

        // $e = mysqli_query($conn, "SELECT COUNT(1) AS acc FROM accounts ");
        // $g = mysqli_fetch_array($e);
        // $acc = $g['acc'];
        ?> 
        <? 
        $a = mysqli_query($conn, "SELECT COUNT(1) AS users FROM traing_order WHERE status = 1 AND username = '$userlogin1'");
        $b = mysqli_fetch_array($a);
        $users = $b['users'];
        ?>
        <? 
        $accs = mysqli_query($conn, "SELECT * FROM `traning_account` WHERE `username` = '${userlogin1}'"); 
        while($rows = mysqli_fetch_array($accs))
        {
          $status_trainer = $rows['status'];
          $discord_trainer = $rows['discord'];
        }
        if(isset($_POST["UPD"])){




          $upd_disscord = $_POST['upd_disscord'];
          $upd_status = $_POST['upd_status'];



          $sqlupdate = "UPDATE `traning_account` 
          SET `status` = '$upd_status', 
          `discord` = '$upd_disscord'

          WHERE `username` = '$userlogin1'";
          mysqli_query($conn, $sqlupdate);

          header("Location: cabinet-settings");

        }
        ?>
        <!-- Content Wrapper START -->
        <div class="main-content">
          <?php
          if(isset($_POST["create_tablesa"])){



            $sqldeleted = "INSERT INTO `traing_table` (`id`, `username`, `dtime`, `value0`, `value1`, `value2`, `value3`, `value4`, `value5`, `value6`, `value7`, `value8`, `value9`, `value10`, `value11`, `value12`, `value13`, `value14`, `value15`, `value16`, `value17`, `value18`, `value19`, `value20`, `value21`, `value22`, `value23`, `value24`) VALUES (NULL, '$userlogin1', NOW(), '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');";
            mysqli_query($conn, $sqldeleted);
            header("Location: cabinet-table");

          }
          ?>
          <?php
          
          if(isset($_POST["updateDOP"])){

            $id_sects = $_POST['id_sect'];
            $date_newsa = $_POST['date_new'];


            if ($_POST['value0'] == "Не заполнено") {$v_0 = "";}elseif ($_POST['value0'] == "Время отключено") {$v_0 = 0;}else {$v_0 = "Заказано";}
            if ($_POST['value1'] == "Не заполнено") {$v_1 = "";}elseif ($_POST['value1'] == "Время отключено") {$v_1 = 0;}else {$v_1 = "Заказано";}
            if ($_POST['value2'] == "Не заполнено") {$v_2 = "";}elseif ($_POST['value2'] == "Время отключено") {$v_2 = 0;}else {$v_2 = "Заказано";}
            if ($_POST['value3'] == "Не заполнено") {$v_3 = "";}elseif ($_POST['value3'] == "Время отключено") {$v_3 = 0;}else {$v_3 = "Заказано";}
            if ($_POST['value4'] == "Не заполнено") {$v_4 = "";}elseif ($_POST['value4'] == "Время отключено") {$v_4 = 0;}else {$v_4 = "Заказано";}
            if ($_POST['value5'] == "Не заполнено") {$v_5 = "";}elseif ($_POST['value5'] == "Время отключено") {$v_5 = 0;}else {$v_5 = "Заказано";}
            if ($_POST['value6'] == "Не заполнено") {$v_6 = "";}elseif ($_POST['value6'] == "Время отключено") {$v_6 = 0;}else {$v_6 = "Заказано";}
            if ($_POST['value7'] == "Не заполнено") {$v_7 = "";}elseif ($_POST['value7'] == "Время отключено") {$v_7 = 0;}else {$v_7 = "Заказано";}
            if ($_POST['value8'] == "Не заполнено") {$v_8 = "";}elseif ($_POST['value8'] == "Время отключено") {$v_8 = 0;}else {$v_8 = "Заказано";}
            if ($_POST['value9'] == "Не заполнено") {$v_9 = "";}elseif ($_POST['value9'] == "Время отключено") {$v_9 = 0;}else {$v_9 = "Заказано";}
        if ($_POST['value10'] == "Не заполнено") {$v_10 = "";}elseif ($_POST['value10'] == "Время отключено") {$v_10 = 0;}else {$v_10 = "Заказано";}
            if ($_POST['value11'] == "Не заполнено") {$v_11 = "";}elseif ($_POST['value11'] == "Время отключено") {$v_11 = 0;}else {$v_11 = "Заказано";}
            if ($_POST['value12'] == "Не заполнено") {$v_12 = "";}elseif ($_POST['value12'] == "Время отключено") {$v_12 = 0;}else {$v_12 = "Заказано";}
            if ($_POST['value13'] == "Не заполнено") {$v_13 = "";}elseif ($_POST['value13'] == "Время отключено") {$v_13 = 0;}else {$v_13 = "Заказано";}
            if ($_POST['value14'] == "Не заполнено") {$v_14 = "";}elseif ($_POST['value14'] == "Время отключено") {$v_14 = 0;}else {$v_14 = "Заказано";}
            if ($_POST['value15'] == "Не заполнено") {$v_15 = "";}elseif ($_POST['value15'] == "Время отключено") {$v_15 = 0;}else {$v_15 = "Заказано";}
            if ($_POST['value16'] == "Не заполнено") {$v_16 = "";}elseif ($_POST['value16'] == "Время отключено") {$v_16 = 0;}else {$v_16 = "Заказано";}
            if ($_POST['value17'] == "Не заполнено") {$v_17 = "";}elseif ($_POST['value17'] == "Время отключено") {$v_17 = 0;}else {$v_17 = "Заказано";}
            if ($_POST['value18'] == "Не заполнено") {$v_18 = "";}elseif ($_POST['value18'] == "Время отключено") {$v_18 = 0;}else {$v_18 = "Заказано";}
            if ($_POST['value19'] == "Не заполнено") {$v_19 = "";}elseif ($_POST['value19'] == "Время отключено") {$v_19 = 0;}else {$v_19 = "Заказано";}
            if ($_POST['value20'] == "Не заполнено") {$v_20 = "";}elseif ($_POST['value20'] == "Время отключено") {$v_20 = 0;}else {$v_20 = "Заказано";}
            if ($_POST['value21'] == "Не заполнено") {$v_21 = "";}elseif ($_POST['value21'] == "Время отключено") {$v_21 = 0;}else {$v_21 = "Заказано";}
            if ($_POST['value22'] == "Не заполнено") {$v_22 = "";}elseif ($_POST['value22'] == "Время отключено") {$v_22 = 0;}else {$v_22 = "Заказано";}
            if ($_POST['value23'] == "Не заполнено") {$v_23 = "";}elseif ($_POST['value23'] == "Время отключено") {$v_23 = 0;}else {$v_23 = "Заказано";}
           

            $sqldeleted = "UPDATE `traing_table` SET `dtime` = '$date_newsa', `value0` = '$v_0', `value1` = '$v_1', `value2` = '$v_2', `value3` = '$v_3', `value4` = '$v_4', `value5` = '$v_5', `value6` = '$v_6',`value7` = '$v_7', `value8` = '$v_8', `value9` = '$v_9', `value10` = '$v_10', `value11` = '$v_11', `value12` = '$v_12', `value13` = '$v_13',`value14` = '$v_14', `value15` = '$v_15', `value16` = '$v_16', `value17` = '$v_17', `value18` = '$v_18', `value19` = '$v_19', `value20` = '$v_20', `value21` = '$v_21', `value22` = '$v_22', `value23` = '$v_23' WHERE `id` = '${id_sects}';";
            mysqli_query($conn, $sqldeleted);
            header("Location: cabinet-table");

          }
          ?>

          <div class="row">
           <div class="col-md-12 col-lg-4">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                  <h5 class="m-b-0">Расписание тренерства</h5>

                </div>
                <? 
                $traning_search_table = mysqli_query($conn, "SELECT * FROM `traing_table` WHERE `username` = '${userlogin1}'"); 
                if (mysqli_num_rows($traning_search_table) == 0) {
                  echo "Расписаний не найдено<br><br>";
                }
                ?><br>
                <form enctype="multipart/form-data" name="create_tablesa" role="form" method="post">
                  <br>

                  <button name="create_tablesa" type="submit" class="btn btn-danger m-r-5">Получить сетку</button><br>
                </form>
                <br><br>
                Обратите внимание: Если значение = Не заполнено, это значит что сетка времени пустая и пользователь может её заказать,<br>
                Если вы поставите значение 0 = сетка отключена и пользователь не сможет её заказать,<br>
                Если в сетке стоит Заказано = Место на данное время было выкуплено, вы можете увидеть заказ в вкладке "Мои заказы".



              </div>
            </div>
          </div>



        </div>

        <? 
        $traning_search_table = mysqli_query($conn, "SELECT * FROM `traing_table` WHERE `username` = '${userlogin1}'"); 
        if (mysqli_num_rows($traning_search_table) != 0) {
          while ($acc = mysqli_fetch_assoc($traning_search_table)) 
          {
            $new_date = date_create($acc['dtime']);
            $old_date = $acc['dtime'];
            $id_statu = $acc['id'];
            $value0 = $acc['value0'];
            $value1 = $acc['value1'];
            $value2 = $acc['value2'];
            $value3 = $acc['value3'];
            $value4 = $acc['value4'];
            $value5 = $acc['value5'];
            $value6 = $acc['value6'];
            $value7 = $acc['value7'];
            $value8 = $acc['value8'];
            $value9 = $acc['value9'];
            $value10 = $acc['value10'];
            $value11 = $acc['value11'];
            $value12 = $acc['value12'];
            $value13 = $acc['value13'];
            $value14 = $acc['value14'];
            $value15 = $acc['value15'];
            $value16 = $acc['value16'];
            $value17 = $acc['value17'];
            $value18 = $acc['value18'];
            $value19 = $acc['value19'];
            $value20 = $acc['value20'];
            $value21 = $acc['value21'];
            $value22 = $acc['value22'];
            $value23 = $acc['value23'];
            $value24 = $acc['value24'];
            ?>
            <div class="row">
             <div class="col-md-12 col-lg-4">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                    <h5 class="m-b-0">Расписание тренерства на <? echo date_format($new_date, 'd.m'); ?></h5>

                  </div>
                  <form enctype="multipart/form-data" name="updateDOP" role="form" method="post"><br>
                   <div class="m-t-30">
                    <div>
                      <label for="basic-url">Дата (менять сторого по формату)</label>
                      <div class="input-group mb-3">
                       <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Значение:</span>
                      </div>
                      <input type="text" name="date_new" class="form-control" id="basic-url" value="<? echo $old_date; ?>" aria-describedby="basic-addon3">
                    </div>
                  </div>
                </div>
                <br>
                <div class="m-t-30">
                  <div>
                    <label for="basic-url">Время: 00:00</label>
                    <div class="input-group mb-3">
                     <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">Значение:</span>
                    </div>
                    <input type="text" name="value0" class="form-control" id="basic-url" value="<? if($value0 == ""){
                      echo "Не заполнено";
                      }elseif($value0  == 0){
                        echo "Время отключено";
                        }else{
                          echo "Заказано";
                        } ?>" aria-describedby="basic-addon3">
                      </div>
                    </div>
                  </div>

                  <div class="m-t-30">
                    <div>
                      <label for="basic-url">Время: 01:00</label>
                      <div class="input-group mb-3">
                       <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Значение:</span>
                      </div>
                      <input type="text" name="value1" class="form-control" id="basic-url" value="<? if($value1 == ""){
                        echo "Не заполнено";
                        }elseif($value1  == 0){
                          echo "Время отключено";
                          }else{
                            echo "Заказано";
                          } ?>" aria-describedby="basic-addon3">
                        </div>
                      </div>
                    </div>

                    <div class="m-t-30">
                      <div>
                        <label for="basic-url">Время: 02:00</label>
                        <div class="input-group mb-3">
                         <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">Значение:</span>
                        </div>
                        <input type="text" name="value2" class="form-control" id="basic-url" value="<? if($value2 == ""){
                          echo "Не заполнено";
                          }elseif($value2  == 0){
                            echo "Время отключено";
                            }else{
                              echo "Заказано";
                            } ?>" aria-describedby="basic-addon3">
                          </div>
                        </div>
                      </div>
                      <div class="m-t-30">
                        <div>
                          <label for="basic-url">Время: 03:00</label>
                          <div class="input-group mb-3">
                           <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Значение:</span>
                          </div>
                          <input type="text" name="value3" class="form-control" id="basic-url" value="<? if($value3 == ""){
                            echo "Не заполнено";
                            }elseif($value3  == 0){
                              echo "Время отключено";
                              }else{
                                echo "Заказано";
                              } ?>" aria-describedby="basic-addon3">
                            </div>
                          </div>
                        </div>

                        <div class="m-t-30">
                          <div>
                            <label for="basic-url">Время: 04:00</label>
                            <div class="input-group mb-3">
                             <div class="input-group-prepend">
                              <span class="input-group-text" id="basic-addon1">Значение:</span>
                            </div>
                            <input type="text" name="value4" class="form-control" id="basic-url" value="<? if($value4 == ""){
                              echo "Не заполнено";
                              }elseif($value4  == 0){
                                echo "Время отключено";
                                }else{
                                  echo "Заказано";
                                } ?>" aria-describedby="basic-addon3">
                              </div>
                            </div>
                          </div>

                          <div class="m-t-30">
                            <div>
                              <label for="basic-url">Время: 05:00</label>
                              <div class="input-group mb-3">
                               <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Значение:</span>
                              </div>
                              <input type="text" name="value5" class="form-control" id="basic-url" value="<? if($value5 == ""){
                                echo "Не заполнено";
                                }elseif($value5  == 0){
                                  echo "Время отключено";
                                  }else{
                                   echo "Заказано";
                                  } ?>" aria-describedby="basic-addon3">
                                </div>
                              </div>
                            </div>

                            <div class="m-t-30">
                              <div>
                                <label for="basic-url">Время: 06:00</label>
                                <div class="input-group mb-3">
                                 <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon1">Значение:</span>
                                </div>
                                <input type="text" name="value6" class="form-control" id="basic-url" value="<? if($value6 == ""){
                                  echo "Не заполнено";
                                  }elseif($value6  == 0){
                                    echo "Время отключено";
                                    }else{
                                      echo "Заказано";
                                    } ?>" aria-describedby="basic-addon3">
                                  </div>
                                </div>
                              </div>

                              <div class="m-t-30">
                                <div>
                                  <label for="basic-url">Время: 07:00</label>
                                  <div class="input-group mb-3">
                                   <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Значение:</span>
                                  </div>
                                  <input type="text" name="value7" class="form-control" id="basic-url" value="<? if($value7 == ""){
                                    echo "Не заполнено";
                                    }elseif($value7  == 0){
                                      echo "Время отключено";
                                      }else{
                                        echo "Заказано";
                                      } ?>" aria-describedby="basic-addon3">
                                    </div>
                                  </div>
                                </div>

                                <div class="m-t-30">
                                  <div>
                                    <label for="basic-url">Время: 08:00</label>
                                    <div class="input-group mb-3">
                                     <div class="input-group-prepend">
                                      <span class="input-group-text" id="basic-addon1">Значение:</span>
                                    </div>
                                    <input type="text" name="value8" class="form-control" id="basic-url" value="<? if($value8 == ""){
                                      echo "Не заполнено";
                                      }elseif($value8  == 0){
                                        echo "Время отключено";
                                        }else{
                                          echo "Заказано";
                                        } ?>" aria-describedby="basic-addon3">
                                      </div>
                                    </div>
                                  </div>

                                  <div class="m-t-30">
                                    <div>
                                      <label for="basic-url">Время: 09:00</label>
                                      <div class="input-group mb-3">
                                       <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Значение:</span>
                                      </div>
                                      <input type="text" name="value9" class="form-control" id="basic-url" value="<? if($value9 == ""){
                                        echo "Не заполнено";
                                        }elseif($value9  == 0){
                                          echo "Время отключено";
                                          }else{
                                            echo "Заказано";
                                          } ?>" aria-describedby="basic-addon3">
                                        </div>
                                      </div>
                                    </div>

                                    <div class="m-t-30">
                                      <div>
                                        <label for="basic-url">Время: 10:00</label>
                                        <div class="input-group mb-3">
                                         <div class="input-group-prepend">
                                          <span class="input-group-text" id="basic-addon1">Значение:</span>
                                        </div>
                                        <input type="text" name="value10" class="form-control" id="basic-url" value="<? if($value10 == ""){
                                          echo "Не заполнено";
                                          }elseif($value10  == 0){
                                            echo "Время отключено";
                                            }else{
                                              echo "Заказано";
                                            } ?>" aria-describedby="basic-addon3">
                                          </div>
                                        </div>
                                      </div>

                                      <div class="m-t-30">
                                        <div>
                                          <label for="basic-url">Время: 11:00</label>
                                          <div class="input-group mb-3">
                                           <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">Значение:</span>
                                          </div>
                                          <input type="text" name="value11" class="form-control" id="basic-url" value="<? if($value11 == ""){
                                            echo "Не заполнено";
                                            }elseif($value11  == 0){
                                              echo "Время отключено";
                                              }else{
                                               echo "Заказано";
                                              } ?>" aria-describedby="basic-addon3">
                                            </div>
                                          </div>
                                        </div>

                                        <div class="m-t-30">
                                          <div>
                                            <label for="basic-url">Время: 12:00</label>
                                            <div class="input-group mb-3">
                                             <div class="input-group-prepend">
                                              <span class="input-group-text" id="basic-addon1">Значение:</span>
                                            </div>
                                            <input type="text" name="value12" class="form-control" id="basic-url" value="<? if($value12 == ""){
                                              echo "Не заполнено";
                                              }elseif($value12  == 0){
                                                echo "Время отключено";
                                                }else{
                                                  echo "Заказано";
                                                } ?>" aria-describedby="basic-addon3">
                                              </div>
                                            </div>
                                          </div>

                                          <div class="m-t-30">
                                            <div>
                                              <label for="basic-url">Время: 13:00</label>
                                              <div class="input-group mb-3">
                                               <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">Значение:</span>
                                              </div>
                                              <input type="text" name="value13" class="form-control" id="basic-url" value="<? if($value13 == ""){
                                                echo "Не заполнено";
                                                }elseif($value13  == 0){
                                                  echo "Время отключено";
                                                  }else{
                                                   echo "Заказано";
                                                  } ?>" aria-describedby="basic-addon3">
                                                </div>
                                              </div>
                                            </div>

                                            <div class="m-t-30">
                                              <div>
                                                <label for="basic-url">Время: 14:00</label>
                                                <div class="input-group mb-3">
                                                 <div class="input-group-prepend">
                                                  <span class="input-group-text" id="basic-addon1">Значение:</span>
                                                </div>
                                                <input type="text" name="value14" class="form-control" id="basic-url" value="<? if($value14 == ""){
                                                  echo "Не заполнено";
                                                  }elseif($value14  == 0){
                                                    echo "Время отключено";
                                                    }else{
                                                     echo "Заказано";
                                                    } ?>" aria-describedby="basic-addon3">
                                                  </div>
                                                </div>
                                              </div>

                                              <div class="m-t-30">
                                                <div>
                                                  <label for="basic-url">Время: 15:00</label>
                                                  <div class="input-group mb-3">
                                                   <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">Значение:</span>
                                                  </div>
                                                  <input type="text" name="value15" class="form-control" id="basic-url" value="<? if($value15 == ""){
                                                    echo "Не заполнено";
                                                    }elseif($value15  == 0){
                                                      echo "Время отключено";
                                                      }else{
                                                        echo "Заказано";
                                                      } ?>" aria-describedby="basic-addon3">
                                                    </div>
                                                  </div>
                                                </div>

                                                <div class="m-t-30">
                                                  <div>
                                                    <label for="basic-url">Время: 16:00</label>
                                                    <div class="input-group mb-3">
                                                     <div class="input-group-prepend">
                                                      <span class="input-group-text" id="basic-addon1">Значение:</span>
                                                    </div>
                                                    <input type="text" name="value16" class="form-control" id="basic-url" value="<? if($value16 == ""){
                                                      echo "Не заполнено";
                                                      }elseif($value16  == 0){
                                                        echo "Время отключено";
                                                        }else{
                                                          echo "Заказано";
                                                        } ?>" aria-describedby="basic-addon3">
                                                      </div>
                                                    </div>
                                                  </div>

                                                  <div class="m-t-30">
                                                    <div>
                                                      <label for="basic-url">Время: 17:00</label>
                                                      <div class="input-group mb-3">
                                                       <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">Значение:</span>
                                                      </div>
                                                      <input type="text" name="value17" class="form-control" id="basic-url" value="<? if($value17 == ""){
                                                        echo "Не заполнено";
                                                        }elseif($value17  == 0){
                                                          echo "Время отключено";
                                                          }else{
                                                            echo "Заказано";
                                                          } ?>" aria-describedby="basic-addon3">
                                                        </div>
                                                      </div>
                                                    </div>

                                                    <div class="m-t-30">
                                                      <div>
                                                        <label for="basic-url">Время: 18:00</label>
                                                        <div class="input-group mb-3">
                                                         <div class="input-group-prepend">
                                                          <span class="input-group-text" id="basic-addon1">Значение:</span>
                                                        </div>
                                                        <input type="text" name="value18" class="form-control" id="basic-url" value="<? if($value18 == ""){
                                                          echo "Не заполнено";
                                                          }elseif($value18  == 0){
                                                            echo "Время отключено";
                                                            }else{
                                                              echo "Заказано";
                                                            } ?>" aria-describedby="basic-addon3">
                                                          </div>
                                                        </div>
                                                      </div>

                                                      <div class="m-t-30">
                                                        <div>
                                                          <label for="basic-url">Время: 19:00</label>
                                                          <div class="input-group mb-3">
                                                           <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1">Значение:</span>
                                                          </div>
                                                          <input type="text" name="value19" class="form-control" id="basic-url" value="<? if($value19 == ""){
                                                            echo "Не заполнено";
                                                            }elseif($value19  == 0){
                                                              echo "Время отключено";
                                                              }else{
                                                                echo "Заказано";
                                                              } ?>" aria-describedby="basic-addon3">
                                                            </div>
                                                          </div>
                                                        </div>

                                                        <div class="m-t-30">
                                                          <div>
                                                            <label for="basic-url">Время: 20:00</label>
                                                            <div class="input-group mb-3">
                                                             <div class="input-group-prepend">
                                                              <span class="input-group-text" id="basic-addon1">Значение:</span>
                                                            </div>
                                                            <input type="text" name="value20" class="form-control" id="basic-url" value="<? if($value20 == ""){
                                                              echo "Не заполнено";
                                                              }elseif($value20  == 0){
                                                                echo "Время отключено";
                                                                }else{
                                                                  echo "Заказано";
                                                                } ?>" aria-describedby="basic-addon3">
                                                              </div>
                                                            </div>
                                                          </div>

                                                          <div class="m-t-30">
                                                            <div>
                                                              <label for="basic-url">Время: 21:00</label>
                                                              <div class="input-group mb-3">
                                                               <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon1">Значение:</span>
                                                              </div>
                                                              <input type="text" name="value21" class="form-control" id="basic-url" value="<? if($value21 == ""){
                                                                echo "Не заполнено";
                                                                }elseif($value21  == 0){
                                                                  echo "Время отключено";
                                                                  }else{
                                                                    echo "Заказано";
                                                                  } ?>" aria-describedby="basic-addon3">
                                                                </div>
                                                              </div>
                                                            </div>

                                                            <div class="m-t-30">
                                                              <div>
                                                                <label for="basic-url">Время: 22:00</label>
                                                                <div class="input-group mb-3">
                                                                 <div class="input-group-prepend">
                                                                  <span class="input-group-text" id="basic-addon1">Значение:</span>
                                                                </div>
                                                                <input type="text" name="value22" class="form-control" id="basic-url" value="<? if($value22 == ""){
                                                                  echo "Не заполнено";
                                                                  }elseif($value22  == 0){
                                                                    echo "Время отключено";
                                                                    }else{
                                                                      echo "Заказано";
                                                                    } ?>" aria-describedby="basic-addon3">
                                                                  </div>
                                                                </div>
                                                              </div>

                                                              <div class="m-t-30">
                                                                <div>
                                                                  <label for="basic-url">Время: 23:00</label>
                                                                  <div class="input-group mb-3">
                                                                   <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon1">Значение:</span>
                                                                  </div>
                                                                  <input type="text" name="value23" class="form-control" id="basic-url" value="<? if($value23 == ""){
                                                                    echo "Не заполнено";
                                                                    }elseif($value23  == 0){
                                                                      echo "Время отключено";
                                                                      }else{
                                                                        echo "Заказано";
                                                                      } ?>" aria-describedby="basic-addon3"
                                                                      <? if($value23 == ""){
                                                                    
                                                                    }elseif($value23  == 0){
                                                                     
                                                                      }else{
                                                                        echo "disabled";
                                                                      } ?>
                                                                      >
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                                <input type="hidden" name="id_sect"  value="<? echo $id_statu; ?>" >
                                                                <button name="updateDOP" type="submit" class="btn btn-success m-r-5">Сохранить</button>
                                                              <!--   <font color="red"><br>Внимание! После первого сохранения, необходимо сохранить еще раз!</font> -->

                                                              </form>
                                                              <?php
                                                              if(isset($_POST["UPD_DELETED"])){

                                                                $UPD_login = $_POST['DEL_ID'];


                                                                $sqldeleted = "DELETE FROM `traing_table` WHERE `id` = '$UPD_login'";
                                                                mysqli_query($conn, $sqldeleted);
                                                                header("Location: cabinet-table");

                                                              }
                                                              ?>
                                                              <form enctype="multipart/form-data" name="UPD_DELETED" role="form" method="post">
                                                                <br>
                                                                <input type="hidden" name="id_sect"  value="<? echo $id_statu; ?>" >
                                                                <button name="UPD_DELETED" type="submit" class="btn btn-danger m-r-5">Удалить сетку</button><br>
                                                              </form>
                                                            </div>
                                                          </div>
                                                        </div>

                                                        <?
                                                      }
                                                    }
                                                    ?>








                                                  </div>
                                                </div>
                                                <!-- Content Wrapper END -->

                                                <!-- Footer START -->
                                                <? include "footer.php"; ?>
                                                <!-- Footer END -->

                                              </div>
                                              <!-- Modal -->
                                              <!-- Modal -->

                                              <!-- Page Container END -->

                                              <!-- Search Start-->
                                              <div class="modal modal-left fade search" id="search-drawer">
                                                <div class="modal-dialog">
                                                  <div class="modal-content">
                                                    <div class="modal-header justify-content-between align-items-center">
                                                      <h5 class="modal-title">Search</h5>
                                                      <button type="button" class="close" data-dismiss="modal">
                                                        <i class="anticon anticon-close"></i>
                                                      </button>
                                                    </div>
                                                    <div class="modal-body scrollable">
                                                      <div class="input-affix">
                                                        <i class="prefix-icon anticon anticon-search"></i>
                                                        <input type="text" class="form-control" placeholder="Search">
                                                      </div>
                                                      <div class="m-t-30">
                                                        <h5 class="m-b-20">Files</h5>
                                                        <div class="d-flex m-b-30">
                                                          <div class="avatar avatar-cyan avatar-icon">
                                                            <i class="anticon anticon-file-excel"></i>
                                                          </div>
                                                          <div class="m-l-15">
                                                            <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">Quater Report.exl</a>
                                                            <p class="m-b-0 text-muted font-size-13">by Finance</p>
                                                          </div>
                                                        </div>
                                                        <div class="d-flex m-b-30">
                                                          <div class="avatar avatar-blue avatar-icon">
                                                            <i class="anticon anticon-file-word"></i>
                                                          </div>
                                                          <div class="m-l-15">
                                                            <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">Documentaion.docx</a>
                                                            <p class="m-b-0 text-muted font-size-13">by Developers</p>
                                                          </div>
                                                        </div>
                                                        <div class="d-flex m-b-30">
                                                          <div class="avatar avatar-purple avatar-icon">
                                                            <i class="anticon anticon-file-text"></i>
                                                          </div>
                                                          <div class="m-l-15">
                                                            <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">Recipe.txt</a>
                                                            <p class="m-b-0 text-muted font-size-13">by The Chef</p>
                                                          </div>
                                                        </div>
                                                        <div class="d-flex m-b-30">
                                                          <div class="avatar avatar-red avatar-icon">
                                                            <i class="anticon anticon-file-pdf"></i>
                                                          </div>
                                                          <div class="m-l-15">
                                                            <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">Project Requirement.pdf</a>
                                                            <p class="m-b-0 text-muted font-size-13">by Project Manager</p>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <div class="m-t-30">
                                                        <h5 class="m-b-20">Members</h5>
                                                        <div class="d-flex m-b-30">
                                                          <div class="avatar avatar-image">
                                                            <img src="assets/images/avatars/thumb-1.jpg" alt="">
                                                          </div>
                                                          <div class="m-l-15">
                                                            <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">Erin Gonzales</a>
                                                            <p class="m-b-0 text-muted font-size-13">UI/UX Designer</p>
                                                          </div>
                                                        </div>
                                                        <div class="d-flex m-b-30">
                                                          <div class="avatar avatar-image">
                                                            <img src="assets/images/avatars/thumb-2.jpg" alt="">
                                                          </div>
                                                          <div class="m-l-15">
                                                            <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">Darryl Day</a>
                                                            <p class="m-b-0 text-muted font-size-13">Software Engineer</p>
                                                          </div>
                                                        </div>
                                                        <div class="d-flex m-b-30">
                                                          <div class="avatar avatar-image">
                                                            <img src="assets/images/avatars/thumb-3.jpg" alt="">
                                                          </div>
                                                          <div class="m-l-15">
                                                            <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">Marshall Nichols</a>
                                                            <p class="m-b-0 text-muted font-size-13">Data Analyst</p>
                                                          </div>
                                                        </div>
                                                      </div>   
                                                      <div class="m-t-30">
                                                        <h5 class="m-b-20">News</h5> 
                                                        <div class="d-flex m-b-30">
                                                          <div class="avatar avatar-image">
                                                            <img src="assets/images/others/img-1.jpg" alt="">
                                                          </div>
                                                          <div class="m-l-15">
                                                            <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">5 Best Handwriting Fonts</a>
                                                            <p class="m-b-0 text-muted font-size-13">
                                                              <i class="anticon anticon-clock-circle"></i>
                                                              <span class="m-l-5">25 Nov 2018</span>
                                                            </p>
                                                          </div>
                                                        </div>
                                                      </div>    
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                              <!-- Search End-->

                                              <!-- Quick View START -->
                                              <div class="modal modal-right fade quick-view" id="quick-view">
                                                <div class="modal-dialog">
                                                  <div class="modal-content">
                                                    <div class="modal-header justify-content-between align-items-center">
                                                      <h5 class="modal-title">Theme Config</h5>
                                                    </div>
                                                    <div class="modal-body scrollable">
                                                      <div class="m-b-30">
                                                        <h5 class="m-b-0">Header Color</h5>
                                                        <p>Config header background color</p>
                                                        <div class="theme-configurator d-flex m-t-10">
                                                          <div class="radio">
                                                            <input id="header-default" name="header-theme" type="radio" checked value="default">
                                                            <label for="header-default"></label>
                                                          </div>
                                                          <div class="radio">
                                                            <input id="header-primary" name="header-theme" type="radio" value="primary">
                                                            <label for="header-primary"></label>
                                                          </div>
                                                          <div class="radio">
                                                            <input id="header-success" name="header-theme" type="radio" value="success">
                                                            <label for="header-success"></label>
                                                          </div>
                                                          <div class="radio">
                                                            <input id="header-secondary" name="header-theme" type="radio" value="secondary">
                                                            <label for="header-secondary"></label>
                                                          </div>
                                                          <div class="radio">
                                                            <input id="header-danger" name="header-theme" type="radio" value="danger">
                                                            <label for="header-danger"></label>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <hr>
                                                      <div>
                                                        <h5 class="m-b-0">Side Nav Dark</h5>
                                                        <p>Change Side Nav to dark</p>
                                                        <div class="switch d-inline">
                                                          <input type="checkbox" name="side-nav-theme-toogle" id="side-nav-theme-toogle">
                                                          <label for="side-nav-theme-toogle"></label>
                                                        </div>
                                                      </div>
                                                      <hr>
                                                      <div>
                                                        <h5 class="m-b-0">Folded Menu</h5>
                                                        <p>Toggle Folded Menu</p>
                                                        <div class="switch d-inline">
                                                          <input type="checkbox" name="side-nav-fold-toogle" id="side-nav-fold-toogle">
                                                          <label for="side-nav-fold-toogle"></label>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>            
                                              </div>
                                              <!-- Quick View END -->
                                            </div>
                                          </div>


                                          <!-- Core Vendors JS -->
                                          <script src="assets/js/vendors.min.js"></script>

                                          <!-- page js -->
                                          <script src="assets/vendors/chartjs/Chart.min.js"></script>
                                          <script src="assets/js/pages/dashboard-default.js"></script>

                                          <!-- Core JS -->
                                          <script src="assets/js/app.min.js"></script>

                                          <script>
                                            buttonAnswerUser();
                                            function buttonAnswerUser () {
                                              $('.button-answer_user').click(answerUserId);
                                            }
                                            function answerUserId () {
                                              $('.modal-user_name').html(this.value);
                                            }

                                          </script>

                                        </body>

                                        </html>
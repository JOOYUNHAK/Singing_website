<?php

  $find_id = $_POST['UserId'];
  $find_name = $_POST['UserName'];
  $find_no1 = $_POST['UserNo'];//주민번호 앞
  $find_no2 = $_POST['UserNo2'];//주민번호 뒤
  $userno = $find_no1."-".$find_no2;
  $con = mysqli_connect("localhost", "joo", "3797", "board");

  $sql = "select * from UserInfo where Username = '$find_name' and UserNo = '$userno' and UserId = '$find_id'";
  $result = mysqli_query($con, $sql);
  $id = mysqli_num_rows($result);

  ?>

  <html>
  <head>
    <meta charset="utf-8">
  </head>
  <style>
  a{
    text-decoration: none;
  }
  </style>
  <body>
  <h1><center><a href="main.php"> Haggis </a></center></h1>

   <center><fieldset style="width:500; background:skyblue;">
      <legend align=center>***비밀번호 재설정***</legend>
      <form method="post" action="pwd_update.php">

<?php
      if($id == 0) {  // 회원정보가 없으면?>
        <p align=center><font color=white>검색결과: <?php echo "일치하는 회원 정보가 없습니다";  ?></font></p>
        <center>
        <a href="main.php"><input type="button" value="홈으로">
        <a href="id_find.html"><input type="button" value="아이디찾기">
        <a href="pwd_find.html"><input type="button" value="다시시도">
        </center>
<?php } else { ?>
        <p align=center><font color=white>새로운 비밀번호:
        <input type="password" name="UserPwd"  maxlength="8"
              placeholder="8자리이하 비밀번호를 입력하세요" required></font></p>

        <p align=center><font color=white>새로운 비밀번호 재입력:
        <input type="password" name="UserPwd2"  maxlength="8"
              placeholder="비밀번호를 재입력해주세요" required> </font></p>

        <input type="hidden" name="UserId" value="<?=$find_id?>">
        <input type="hidden" name="UserName" value="<?=$find_name?>">
        <input type="hidden" name="UserNo" value="<?=$userno?>">

        <center>
        <a href="main.php"><input type="button" value="홈으로">
        <input type="submit" value="변경하기">
        </center>
<?php } ?>


</fieldset></center>
</body>
</html>

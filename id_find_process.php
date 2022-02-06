<?php

  $find_name = $_POST['UserName'];
  $find_no1 = $_POST['UserNo'];//주민번호 앞
  $find_no2 = $_POST['UserNo2'];//주민번호 뒤
  $userno = $find_no1."-".$find_no2;
  $con = mysqli_connect("localhost", "joo", "3797", "board");

  $sql = "select * from UserInfo where Username = '$find_name' and UserNo = '$userno'";
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
      <legend align=center>***아이디 검색 결과***</legend>

<?php
      if($id == 0) {  // 아이디가 없으면?>
        <p align=center><font color=white>검색결과: <?php echo "아이디를 찾지 못하였습니다";  ?></font></p>
        <center>
        <a href="main.php"><input type="button" value="홈으로">
        <a href="id_find.html"><input type="button" value="다시시도">
        <a href="pwd_find.html"><input type="button" value="비밀번호찾기">
        </center>
<?php } else {
        while($id_result = mysqli_fetch_array($result)) {
              $id1 = $id_result['UserId']; ?>
        <p align=center><font color=white>검색결과: <?php echo "$id1"; ?></font></p>
        <center>
        <a href="login.html"><input type="button" value="로그인">
        <a href="pwd_find.html"><input type="button" value="비밀번호찾기">
        </center>
<?php } }?>


</fieldset></center>
</body>
</html>

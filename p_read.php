<!doctype html>
<head>
  <meta charset = "utf-8"> <link rel="stylesheet" href="style.css" />
</head>
<body>

<?php
  session_start();
  if(isset($_SESSION['UserId'])){ //아이디가 로그인되어있으면
      if(!isset($_SESSION['timestamp']))  //시간 입력이 안되어있으면
      {
          $_SESSION['timestamp'] = time(); }
      else {
              if(time() - $_SESSION['timestamp'] > 600){
                    $result = session_destroy();
                    if($result){
                          echo "<script>alert('장시간 움직임이 없어 로그아웃되었습니다');
                          location.href='main.php';</script>";}
      }             else {
                          $_SESSION['timestamp'] = time();
      }
  }
}
  $bno = $_GET['list_nu'];
  $con = mysqli_connect("localhost", "joo", "3797", "board");

  $sql = "select * from pop where list_nu =".$bno;
  $h_sql = "select hit from pop where list_nu =".$bno;

  $h_result = mysqli_query($con, $h_sql);

  while($h_row = mysqli_fetch_array($h_result)){
        $u_hit = $h_row['hit'] + 1;
        $update = "update pop set hit = '".$u_hit."' where list_nu = '".$bno."'";
        $u_result = mysqli_query($con, $update);
        $u_sql = "select hit pop hiphop where list_nu =".$bno;
        $u_result2 = mysqli_query($con, $u_sql);
      }

  $result = mysqli_query($con, $sql);
  while($row = mysqli_fetch_array($result))
  {
  ?>
  <div id = "board">
    <h1 align=center>***팝송게시판***</h1><br><br>
    <hr size="3" width="900" align=center color="skyblue"><br>
    <h2>제목:<?php echo $row['title']; ?></h2>
    <div id = "info">
      작성자: <?php echo $row['id']; ?> 작성일: <?php echo $row['w_date']; ?>
      조회수:<?php echo $row['hit']; ?> 추천수: <?php echo $row['up']; ?> 신고수: <?php echo $row['error']; ?>
  </div>
  <div id = "bar_line"> </div>
  <br>
    <?php echo nl2br("$row[content]"); ?>
  <div id="bar">
    <ul>
      <li><a href="pop.php?list_nu=<?php echo $row['list_nu']; ?>">[목록으로]</a></li>
      <li><a href="p_modify.php?list_nu=<?php echo $row['list_nu']; ?>">[수정하기]</a></li>
      <li><a href="p_delete.php?list_nu=<?php echo $row['list_nu']; ?>">[삭제하기]</a></li>
      <li><a href="p_up.php?list_nu=<?php echo $row['list_nu']; ?>">[추천하기]</a></li>
      <li><a href="p_error.php?list_nu=<?php echo $row['list_nu']; ?>">[신고하기]</a></li>
    </ul>
  </div>
</div>
<?php } ?>
</body>

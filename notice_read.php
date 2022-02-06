<!doctype html>
<head>
  <meta charset = "utf-8"> <link rel="stylesheet" href="style.css" />
</head>
<body>

<?php
  $bno = $_GET['list_nu'];
  $con = mysqli_connect("localhost", "joo", "3797", "board");

  $sql = "select * from noticeboard where list_nu =".$bno;
  $h_sql = "select hit from noticeboard where list_nu =".$bno;

  $result = mysqli_query($con, $sql);
  $h_result = mysqli_query($con, $h_sql);

  //조회수증가
  while($h_row = mysqli_fetch_array($h_result)){
        $u_hit = $h_row['hit'] + 1;
        $update = "update noticeboard set hit = '".$u_hit."' where list_nu = '".$bno."'";
        $u_result = mysqli_query($con, $update);
        $u_sql = "select hit from noticeboard where list_nu =".$bno;
        $u_result2 = mysqli_query($con, $u_sql);
      }

  while($row = mysqli_fetch_array($result))
  {
  ?>
    <div id = "board">
      <h1 align=center>***공지사항***</h1><br><br>
      <hr size="3" width="900" align=center color="skyblue"><br>
      <h2>제목:<?php echo $row['title']; ?></h2>
      <div id = "info">
        작성자: <?php echo "관리자"; ?> 작성일: <?php echo $row['w_date']; ?>
        조회수:<?php echo $row['hit']; ?> 추천수: <?php echo $row['up']; ?>
    </div>
    <div id = "bar_line"> </div>
    <br>
      <?php echo nl2br("$row[content]"); ?>
    <div id="bar">
      <ul>
        <li><a href="main.php?list_nu=<?php echo $row['list_nu']; ?>">[홈으로]</a></li>
        <li><a href="notice_modify.php?list_nu=<?php echo $row['list_nu']; ?>">[수정하기]</a></li>
        <li><a href="notice_delete.php?list_nu=<?php echo $row['list_nu']; ?>">[삭제하기]</a></li>
        <li><a href="notice_up.php?list_nu=<?php echo $row['list_nu']; ?>">[추천하기]</a></li>
      </ul>
    </div>
  </div>
<?php } ?>
 </body>
 </html>

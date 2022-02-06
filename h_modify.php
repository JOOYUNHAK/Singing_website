  <?php
  $con = mysqli_connect("localhost", "joo", "3797", "board");
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

  $list_nu = $_GET['list_nu'];
  $sql = "select title, content, w_date, id, category from hiphop where list_nu = $list_nu";
  $result = mysqli_query($con, $sql);
  $rows = mysqli_fetch_array($result);

  $title = $rows['title'];
  $content = $rows['content'];
  $userid = $rows['id'];
          if(!isset($_SESSION['UserId'])) {
  ?>         <script>
                alert("로그인을 해주세요.");
                location.replace("login.html");
              </script>
  <?php     } else if($_SESSION['UserId'] == $userid) {
  ?>
  <!doctypehtml>
  <meta charset="utf-8">
  <form method = "post" action = "h_modify_process.php">
  <h1 align = center>글수정</h1>
  <table border=4 cellpadding="30" cellspacing="2" bgcolor="white" bordercolor="skyblue" style="margin:0 auto;" >

  <tr>
      <td>제목</td>
      <td><input type = text name = title size=50 value="<?=$title?>"></td>
  </tr>

  <tr>
      <td>작성자</td>
      <td><input type="hidden" name="id" value="<?=$_SESSION['UserId']?>"><?=$_SESSION['UserId']?></td>
  </tr>

  <tr>
      <td>내용</td>
      <td><textarea name = content cols=50 rows=10><?=$content?></textarea></td>
  </tr>

  <tr>
      <td> &emsp; ★</td>
      <input type="hidden" name="list_nu" value="<?=$list_nu?>">
      <td align=center><input type = "submit" value="수정하기"></td>
  </tr>
</table>
</form>
        <?php   }
                else {
        ?>        <script>
                    alert("권한이 없습니다.");
                    history.back();
                  </script>
        <?php   }
        ?>

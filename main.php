<?php
    $con2 = mysqli_connect("localhost", "joo", "3797", "board");
    //$con = mysqli_connect("localhost", "joo", "3797", "board");
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

?>
<!doctypehtml>
<link rel="stylesheet" href="main.css"/>
<head>
  <title>
    *****환영합니다*****
  </title>
  <meta charset="utf-8">
</head>
  <body bgcolor='skyblue';>
        <div id = "page">

          <header>
            <div id = "home">
            <h1><a href="main.php">Haggis</a></h1>
          </div>
              <div id = "id">
                현재 사용자 아이디->
<?php             if(isset($_SESSION['UserId'])) {
                      if(strcmp($_SESSION['UserId'], 'root')==0){
                        echo "관리자"; }
                      else{
                      echo $_SESSION['UserId']; }
                  } else { ?>
                <button type = "button" onclick = "location.href='login.html'">로그인</button>
              <?php } ?>
              </div>



<?php
            if(isset($_SESSION['UserId'])){
                if(strcmp($_SESSION['UserId'], 'root')==0) {?>
            <div id = "menu">
            <a href="member.php">MEMBER</a> |&emsp;
            <a href="logout.php">LOGOUT</a> |&emsp;
            <a href="bestboard.php">BESTBOARD</a>&emsp;
            </div>
<?php       }   else if(strcmp($_SESSION['UserId'], 'root')!=0) { ?>
           <div id = "menu">
            <a href="logout.php">LOGOUT</a> &emsp; |
            <a href="bestboard.php">BESTBOARD</a>&emsp; | 
            <a href="QA.php">Q&A</a>&emsp;
          </div>
<?php       }} else { ?>
            <div id = "menu">
            <a href="login.html">LOGIN</a> |&emsp;
            <a href="join.html">JOIN</a> |&emsp;
            <a href="bestboard.php">BESTBOARD</a>&emsp;
            </div>
<?php       } ?>
            <nav>
              <ul>
                <li><a href="hiphop.php">힙합존</a></li>
                <li><a href="ballad.php">발라드존</a></li>
                <li><a href="pop.php">팝존</a></li>
                <li><a href="k_pop.php">K-POP</a></li>
              </ul>
            </nav>

          </header>

          <hr size="5px" style="background-color:gray;border-color:skyblue">

          <h1 align=center style="margin-top:20px;"><font color=red>***각 부문 실시간 1위 달리는 곡정보***</font></h1>
          <br><center>↓↓<center>

<?php
      $h_sql = "select * from hiphop where up != 0 order by up desc, error, hit desc limit 1"; //베스트게시판에서 힙합
      $h_result = mysqli_query($con2, $h_sql);
      $h_rownu = mysqli_num_rows($h_result);
      if($h_rownu != 0)
      {
        $h_row=mysqli_fetch_array($h_result);
        $title = $h_row['title'];
        $list_nu = $h_row['list_nu']; ?>
        <p align=center style="margin-top:30px;">
                        <font size=6 color=purple>힙합부문: &emsp;<?php echo $title ?>☞
                        <a href = "h_read.php?list_nu=<?php echo $list_nu?>" style="color:red">글 구경가기</a></font></p>
      <?php }

      $b_sql = "select * from ballad where up != 0 order by up desc, error, hit desc limit 1"; //베스트게시판에서 발라드
      $b_result = mysqli_query($con2, $b_sql);
      $b_rownu = mysqli_num_rows($b_result);
      if($b_rownu != 0)
      {
        $b_row=mysqli_fetch_array($b_result);
        $title = $b_row['title'];
        $list_nu = $b_row['list_nu']; ?>
        <p align=center style="margin-top:5px;">
                      <font size=6 color=purple>발라드부문: &emsp;<?php echo $title ?>☞
                      <a href = "b_read.php?list_nu=<?php echo $list_nu?>" style="color:red">글 구경가기</a></font></p>
      <?php }

      $p_sql = "select * from pop where up != 0 order by up desc, error, hit desc limit 1";
      $p_result = mysqli_query($con2, $p_sql);
      $p_rownu = mysqli_num_rows($p_result);
      if($p_rownu != 0)
      {
        $p_row=mysqli_fetch_array($p_result);
        $title = $p_row['title'];
        $list_nu = $p_row['list_nu']; ?>
        <p align=center style="margin-top:5px;">
                      <font size=6 color=purple>팝송부문 : &emsp;<?php echo $title ?> ☞
                      <a href = "p_read.php?list_nu=<?php echo $list_nu?>" style="color:red">글 구경가기</a></font></p>
      <?php }

      $k_sql = "select * from k_pop where up != 0 order by up desc, error, hit desc limit 1";
      $k_result = mysqli_query($con2, $k_sql);
      $k_rownu = mysqli_num_rows($k_result);
      if($k_rownu != 0)
      {
        $k_row=mysqli_fetch_array($k_result);
        $title = $k_row['title'];
        $list_nu =$k_row['list_nu']; ?>
        <p align=center style="margin-top:5px;">
                    <font size=6 color=purple>K-POP부문: &emsp;<?php echo $title ?>☞
                    <a href = "k_read.php?list_nu=<?php echo $list_nu?>" style="color:red">글 구경가기</a></font></p>
      <?php }?>
      <hr size="3px" style="background-color:gray;border-color:skyblue">

      <footer style="margin-top:50px;">
        <address>
        대표자: 주윤학 |  소속: 건국대학교 글로컬캠퍼스 컴퓨터공학과
        <br>
        주소:인천시 연수구 송도동 | Tel:(010)-2489-3797 | Email: wndbsgkr@naver.com
      </address>
      </footer>




  </body>
  </html>

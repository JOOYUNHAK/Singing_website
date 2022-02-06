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

    if(isset($_SESSION['UserId'])){
    $now_id = $_SESSION['UserId'];}
    //$sql = "SELECT * from hiphop order by up desc, list_nu desc";
    //$result = mysqli_query($con, $sql);
?>
<!doctypehtml>
  <head>
    <meta charset="utf-8">
    <link rel = "stylesheet" href = "style.css" />
  </head>

  <body>

    <div id="board">
    <ul><a href="main.php"> Haggis </a></ul>
    <h1 align=center>팝송존 자유게시판</h1>
    <h2 align=center>팝송만 추천해주세요!</h2>

  <table class = "table_list">
    <thead>
      <tr>
      <th width = "70">번호</th>
      <th width = "500">제목</th>
      <th width = "120">작성자</th>
      <th width = "100">날짜</th>
      <th width = "70">조회수</th>
      <th width = "70">추천수</th>
      <th width = "70">신고수</th>
    </tr>
    </thead>

    <tbody>
    <?php
        if(isset($_GET['start'])){
            $page = $_GET['start'];
            } else {
                $page = 1;
            }
        $total_sql = "select * from pop";
        $total_result = mysqli_query($con, $total_sql);
        $total_row = mysqli_num_rows($total_result);
        $list = 5;
        $block_ct = 5;

        $block_num = ceil($page/$block_ct);
        $block_start = (($block_num - 1) * $block_ct) + 1;
        $block_end= $block_start + $block_ct - 1;

        $total_page = ceil($total_row / $list);
        if($block_end > $total_page) $block_end = $total_page;
        $total_block = ceil($total_page/$block_ct);
        $start_num = ($page-1) * $list;

        //공지사항
        $n_sql = "select * from noticeboard order by list_nu desc";
        $n_result = mysqli_query($con, $n_sql);
        while($notice = mysqli_fetch_array($n_result)){
          $n_title = $notice['title'];
          if(strlen($n_title) > 40)
          {
            $n_title=str_replace($notice["title"],mb_substr($notice["title"],0,20,"utf-8")."...",$notice["title"]);
          }
          $n_time = $notice['w_date'];
          $timenow = date("Y-m-d");
          if($n_time == $timenow){
              $img = "<img src='new.png'/>";
            }else{
                  $img = "";
            }
         ?>
        <tr>
          <td width = "70"><font size=3 style="color:white"><span style="background:red";>
                                                <?php echo $notice['notice']; ?></font></span></td>
          <td width = "500"><a href = "notice_read.php?list_nu=<?php echo $notice["list_nu"]?>">
                                  <?php echo $n_title;?><?php echo $img; ?></td>
          <td width = "120"><?php echo "관리자"; ?></td>
          <td width = "120"><?php echo $notice['w_date']; ?></td>
          <td width = "100"><?php echo $notice['hit']; ?></td>
          <td width = "100"><?php echo $notice['up']; ?></td>
          <td width = "100"><?php echo "*"; ?></td>
          </tr>
        <?php } ?>

<?php   $total_sql2 = "select * from pop order by up desc, list_nu desc limit $start_num, $list";
        $total_result2 = mysqli_query($con, $total_sql2);
        while($board = mysqli_fetch_array($total_result2)) {
        $title = $board['title'];
        if(strlen($title) > 40)
        {
          $title=str_replace($board["title"],mb_substr($board["title"],0,20,"utf-8")."...",$board["title"]);
        }
        $boardtime = $board['w_date'];
        $timenow = date("Y-m-d");
        if($boardtime == $timenow){
            $img = "<img src='new.png' />";
          }else{
                $img = "";
          }
       ?>
      <tr>
        <td width = "70"><?php echo $board['list_nu']; ?></td>
        <td width = "500"><a href = "p_read.php?list_nu=<?php echo $board["list_nu"]?>">
                                              <?php echo $title;?><?php echo $img; ?></td>
        <td width = "120"><?php echo $board['id']; ?></td>
        <td width = "120"><?php echo $board['w_date']; ?></td>
        <td width = "100"><?php echo $board['hit']; ?></td>
        <td width = "100"><?php echo $board['up']; ?></td>
        <td width = "100"><?php echo $board['error']; ?></td>
        </tr>

      <?php } ?>
      </tbody>
</table>

      <div id = "button">
      <?php if(isset($_SESSION['UserId'])){
                    if(strcmp($now_id, 'root') == 0){ //아이디가 관리자인경우?>
                        <a href="notice_write.php"><button>공지작성</button></a>
      <?php    }else { //일반 회원일경우?>
                        <a href="p_write.php"><button>글쓰기</button></a>
      <?php    } }
                else  { //비로그인일 경우?>
                <a href="p_write.php"><button>글쓰기</button></a>
      <?php }  ?>
      </div>

  <div id="search">
  <form action="p_result.php" method="get">
    <select name="menu">
      <option value="title">제목</option>
      <option value="id">작성자</option>
      <option value="content">내용</option>
    </select>
    <input type="text" name="search" size="30" required="required" /> <button>검색</button>
  </form>
  </div>

  <div id="paging">
    <ul>
<?php
  if($page <= 1)
  {
    //첫페이지
  }else{
          $pre = $page -1;
          echo "<li><a href='?start=$pre'>이전</a></li>";
  }
  for($i=$block_start; $i<=$block_end; $i++){
            if($page == $i){
              echo "<li class='fo_re'>[$i]</li>";
            }else{
              echo "<li><a href='?start=$i'>[$i]</a></li>";
            }
          }
          if($block_num >= $total_block){
          }else{
            $next = $page + 1;
            echo "<li><a href='?start=$next'>다음</a></li>";
          }
    ?>
  </ul>
</div>
</body>
</html>

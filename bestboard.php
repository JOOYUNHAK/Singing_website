<?php
    session_start();
    $con = mysqli_connect("localhost", "joo", "3797", "board");
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
} else {
    echo"<script>alert('이 게시판은 회원만 이용 가능합니다');
          history.back();</script>";
    goto label;
}

    $timenow = date("Y-m-d");
    // 힙합장르 베스트 뽑아오
    $h_sql = "select * from hiphop order by up desc, error, hit desc limit 3";
    $h_result = mysqli_query($con, $h_sql);
    $auto = "alter table bestboard auto_increment = 1";
    $auto_result = mysqli_query($con, $auto);
    global $rank; //순위 매기기 위해
    while($h_row = mysqli_fetch_array($h_result))
    {
      $list_nu = $h_row['list_nu'];
      $id = $h_row["id"];
      $pwd = $h_row['pwd'];
      $title = $h_row['title'];
      $content = $h_row['content'];
      $w_date = $h_row['w_date'];
      $hit = $h_row['hit'];
      $up = $h_row['up'];
      $error = $h_row['error'];
      $h_sql2 = "insert ignore into bestboard(list_nu, id, pwd, title, content, w_date, hit, up, error, category)
                      values('$list_nu', '$id', '$pwd', '$title', '$content', '$w_date', '$hit', '$up', '$error', 'hiphop')";
      $h_result2 = mysqli_query($con, $h_sql2);

    }
    //발라드 베스트 뽑아오기
    $b_sql = "select * from ballad order by up desc, error, hit desc limit 3";
    $b_result = mysqli_query($con, $b_sql);
    while($b_row = mysqli_fetch_array($b_result))
    {
      $list_nu = $b_row['list_nu'];
      $id = $b_row["id"];
      $pwd = $b_row['pwd'];
      $title = $b_row['title'];
      $content = $b_row['content'];
      $w_date = $b_row['w_date'];
      $hit = $b_row['hit'];
      $up = $b_row['up'];
      $error = $b_row['error'];
      $b_sql2 = "insert ignore into bestboard(list_nu, id, pwd, title, content, w_date, hit, up, error, category)
                      values('$list_nu', '$id', '$pwd', '$title', '$content', '$w_date', '$hit', '$up', '$error', 'ballad')";
      $b_result2 = mysqli_query($con, $b_sql2);

    }
    //팝송 베스트 뽑아오기
    $p_sql = "select * from pop order by up desc, error, hit desc limit 3";
    $p_result = mysqli_query($con, $p_sql);
    while($p_row = mysqli_fetch_array($p_result))
    {
      $list_nu = $p_row['list_nu'];
      $id = $p_row["id"];
      $pwd = $p_row['pwd'];
      $title = $p_row['title'];
      $content = $p_row['content'];
      $w_date = $p_row['w_date'];
      $hit = $p_row['hit'];
      $up = $p_row['up'];
      $error = $p_row['error'];
      $p_sql2 = "insert ignore into bestboard(list_nu, id, pwd, title, content, w_date, hit, up, error, category)
                      values('$list_nu', '$id', '$pwd', '$title', '$content', '$w_date', '$hit', '$up', '$error', 'pop')";
      $p_result2 = mysqli_query($con, $p_sql2);

    }
    //K-POP 베스트 뽑아오기
    $k_sql = "select * from k_pop order by up desc, error, hit desc limit 3";
    $k_result = mysqli_query($con, $k_sql);
    while($k_row = mysqli_fetch_array($k_result))
    {
      $list_nu = $k_row['list_nu'];
      $id = $k_row["id"];
      $pwd = $k_row['pwd'];
      $title = $k_row['title'];
      $content = $k_row['content'];
      $w_date = $k_row['w_date'];
      $hit = $k_row['hit'];
      $up = $k_row['up'];
      $error = $k_row['error'];
      $k_sql2 = "insert ignore into bestboard(list_nu, id, pwd, title, content, w_date, hit, up, error, category)
                      values('$list_nu', '$id', '$pwd', '$title', '$content', '$w_date', '$hit', '$up', '$error', 'k-pop')";
      $k_result2 = mysqli_query($con, $k_sql2);
    }
?>
    <!doctypehtml>
      <head>
        <meta charset="utf-8">
        <link rel = "stylesheet" href = "style.css" />
      </head>

      <body>

        <div id="board">
          <ul><a href="main.php"> Haggis </a></ul>
        <h1 align=center>베스트게시판</h1>
        <h2 align=center>실시간으로 추천수가 많은 베스트 곡들을 만나보세요!</h2>
      <table class = "table_list">
        <thead>
          <tr>
          <th width = "70">순위</th>
          <th width = "90">장르</th>
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
            $total_sql = "select * from bestboard where up!= 0";
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
                $n_title=str_replace($notice["title"],mb_substr($notice["title"],0,40,"utf-8")."...",$notice["title"]);
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
              <td width = "70"><?php echo "*"; ?></td>
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

<?php       $total_sql2 = "select * from bestboard where up != 0 order by up desc, error limit $start_num, $list";
            //추천수 0인 게시물은 베스트게시판에 포함안시킴
            $total_result2 = mysqli_query($con, $total_sql2);

            while($board = mysqli_fetch_array($total_result2)) {

            $no = $board['up'];
            $board['ranked'] = ++$rank;
            $title = $board['title'];
            $category = $board['category'];
            if(strlen($title) > 40)
            {
              $title=str_replace($board["title"],mb_substr($board["title"],0,40,"utf-8")."...",$board["title"]);
            }
            $boardtime = $board['w_date'];
            $timenow = date("Y-m-d");
            if($boardtime == $timenow){
                $img = "<img src='new.png'/>";
              }else{
                    $img = "";
              }
           ?>
          <tr>
            <td width = "70">
  <?php

            if($no != 0){ //게시물 처음 등록하면 추천수가 0이므로 이런 글들은 베스트게시판에 포함x
            if($rank <= 3 && $page == 1) //1페이지만 3위까지 순위 나타내기
                    echo $board['ranked'];
            else     echo "*" ?></td>
            <td width = "90"><?php echo $category; ?></td>
            <td width = "500">
  <?php     switch($category) {  //카테고리별 읽기 하면으로 이동하기 위하여
            case "hiphop": ?>
            <a href = "h_read.php?list_nu=<?php echo $board["list_nu"]?>">
                                                  <?php echo $title;?><?php echo $img; break; ?></td>
  <?php     case "ballad": ?>
            <a href = "b_read.php?list_nu=<?php echo $board["list_nu"]?>">
                                            <?php echo $title;?><?php echo $img; break; ?></td>
  <?php     case "pop": ?>
            <a href = "p_read.php?list_nu=<?php echo $board["list_nu"]?>">
                                            <?php echo $title;?><?php echo $img; break; ?></td>
  <?php     case "k-pop" ?>
            <a href = "k_read.php?list_nu=<?php echo $board["list_nu"]?>">
                                            <?php echo $title;?><?php echo $img; break; ?></td>
  <?php } ?>
            <td width = "120"><?php echo $board['id']; ?></td>
            <td width = "120"><?php echo $board['w_date']; ?></td>
            <td width = "100"><?php echo $board['hit']; ?></td>
            <td width = "100"><?php echo $board['up']; ?></td>
            <td width = "100"><?php echo $board['error']; ?></td>
            </tr>

          <?php }} ?>
          </tbody>
    </table>

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
              } label: //회원만 이용가능
        ?>
      </ul>
    </div>
    </body>
    </html>

<?php
  $con = mysqli_connect("localhost", "joo", "3797", "board");
  session_start();
  if(isset($_SESSION['UserId'])) {
      if(!isset($_SESSION['timestamp'])) {
          $_SESSION['timestamp'] = time();
        }
  else {
      if(time() - $_SESSION['timestamp'] > 600) {
          $result = session_destroy();
          if($result) {
              echo "<script>alert('장시간 움직임이 없어 로그아웃되었습니다.');
              location.href='main.php'; </script>";
          }
      }
          else {
            $_SESSION['timestamp'] = time();
          }
    }
  }

  if(isset($_SESSION['UserId']))
      $now_id = $_SESSION['UserId'];
?>

<!doctypehtml>
  <head>
    <meta charset = "utf-8">
    <link rel = "stylesheet" href = "style.css" />
  </head>

  <body>

    <div id="board">
    <ul><a href="main.php"> Haggis </a></ul>
    <h1 align=center>Q&A게시판</h1>
    <h2 align=center>질문사항을 올려주세요!</h2>
  <table class = "table_list">
    <thead>
      <tr>
      <th width = "70">번호</th>
      <th width = "100">분류</th>
      <th width = "500">제목</th>
      <th width = "120">작성자</th>
      <th width = "100">처리상태</th>
      <th width = "100">날짜</th>
      <th width = "70">조회수</th>
    </tr>
    </thead>

    <tbody>
      <?php
          if(isset($_GET['start'])){
              $page = $_GET['start'];
              } else {
                  $page = 1;
              }
          $total_sql = "select * from QA";
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

          $sql = "select * from QA limit $start_num, $list";
          $s_result= mysqli_query($con, $sql);

          while($board = mysqli_fetch_array($s_result))
          {
              $title = $board['title'];
              if(strlen($title) > 20)
              {
                  $title=str_replace($board["title"],mb_substr($board["title"],0,20,"utf-8")."...",$board["title"]);
              }
              $id = $board['id'];
              //아이디 방지
              $id = str_replace($board['id'], mb_substr($board['id'], 0, 3, "utf-8")."***", $board['id']);

              $boardtime = $board['w_date'];
              $timenow = date("Y-m-d");

              if($boardtime == $timenow)
              {
                  $img = "<img src='new.png'/>";
              } else {
                         $img = "";
                    }
                ?>
         <tr>
            <td width = "70"><?php echo $board['list_nu']; ?></td>
            <td width = "100"><?php switch($board['category']) {
                                    case 'id' :
                                              echo "계정문의";
                                              break;
                                    case 'vio' :
                                              echo "폭력/글신고";
                                              break;
                                    case 'question' :
                                              echo "질의응답";
                                              break;
                                    case 'etc' :
                                              echo "기타";
                                              break;  }?></td>
            <td width = "500"><a href = "Q_read.php?list_nu=<?php echo $board["list_nu"]?>">
                                                       <?php echo $title;?><?php echo $img; ?></td>
            <td width = "120"><?php echo $id; ?></td>
            <td width = "100"><?php if(strcmp($board['state'], 'false') == 0) echo "답변대기";
                                                                  else echo "답변완료";?></td>
            <td width = "100"><?php echo $board['w_date']; ?></td>
            <td width = "70"><?php echo $board['hit']; ?></td>
         </tr>
               <?php } ?>
               </tbody>
         </table>

        <div id = "button">
         <?php if(isset($_SESSION['UserId'])){
                   if(strcmp($now_id, 'root') == 0){ //아이디가 관리자인경우?>
                       <a href="Q_notice_write.php"><button>공지작성</button></a>
         <?php    }else { //일반 회원일경우?>
                       <a href="Q_write.php"><button>글쓰기</button></a>
         <?php    } }
               else  { //비로그인일 경우?>
               <a href="Q_write.php"><button>글쓰기</button></a>
         <?php }  ?>

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

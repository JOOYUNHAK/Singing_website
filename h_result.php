<!doctypehtml>
<head>
<meta charset="UTF-8">
<title>게시판</title>
<link rel="stylesheet" href="style.css" />
</head>
<body>
<div id="board">
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
                          location.href='main.php';</script>";
                          goto label;}
      }             else {
                          $_SESSION['timestamp'] = time();
      }
  }
  }

  $menu = $_GET['menu'];
  $search_result = $_GET['search'];
?>
  <u1><a href="main.php">Haggis</a></u1>
    <table class="table_list">
      <thead>
          <tr>
              <th width="70">번호</th>
                <th width="500">제목</th>
                <th width="120">작성자</th>
                <th width="100">작성일</th>
                <th width="100">조회수</th>
                <th width="100">추천수</th>
                <th width="100">신고수</th>
            </tr>
        </thead>
<?php
          $con = mysqli_connect("localhost", "joo", "3797", "board");
          if(isset($_GET['start'])){
              $page = $_GET['start'];
              } else {
                  $page = 1;
              }
          $total_sql = "select * from hiphop where $menu like '%$search_result%' order by list_nu desc";
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

          $sql = "select * from hiphop where $menu like '%$search_result%' order by list_nu desc";
          $result = mysqli_query($con, $sql);
          while($board = mysqli_fetch_array($result)) {
          $title=$board["title"];
            if(strlen($title)>20)
              {
                $title=str_replace($board["title"],
                    mb_substr($board["title"],0,20,"utf-8")."...",$board["title"]);
              }
        ?>
      <tbody>
        <tr>
          <td width="70"><?php echo $board['list_nu']; ?></td>
          <?php
          $boardtime = $board['w_date'];
          $timenow = date("Y-m-d");
          if($boardtime==$timenow){
            $img = "<img src='new.png' />";
          }else{
            $img ="";
          }
          ?>
          <td width="500"><a href='h_read.php?list_nu=<?php echo $board["list_nu"];?>'>
                  <span style="background:skyblue;"><?php echo $title;?></span><?php echo $img;?></a></td>
          <td width="120"><?php echo $board['id']?></td>
          <td width="100"><?php echo $board['w_date']?></td>
          <td width="100"><?php echo $board['hit']; ?></td>
          <td width="100"><?php echo $board['up']; ?></td>
          <td width="100"><?php echo $board['error']; ?></td>
        </tr>
      </tbody>
      <?php } ?>
    </table>
    <div id="search">
      <form action="h_result.php" method="get">
      <select name="menu">
        <option value="title">제목</option>
        <option value="id">글쓴이</option>
        <option value="content">내용</option>
      </select>
      <input type="text" name="search" size="30" required="required"/> <button>검색</button>
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
        label:
  ?>
</ul>
</div>
</div>
</body>
</html>

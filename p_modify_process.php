<?php
    $con = mysqli_connect("localhost", "joo", "3797", "board") or die ("fail");
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

    $list_nu = $_POST['list_nu'];
    $title = $_POST['title'];
    $date = date('Y-m-d H:i');
    $content = $_POST['content'];
    $sql = "update pop set title='$title', content='$content',
                          w_date='$date' where list_nu=$list_nu";
    $result = mysqli_query($con, $sql);

    //베스트 게시판 수정
    $b_sql = "select * from bestboard where list_nu = $list_nu and category = 'pop'";
    $b_result = mysqli_query($con, $b_sql);
    //수정되면 베스트 게시판 삭제 후 다시 삽입
    if($b_result){ //만약 베스트 게시판에 있는 글이면 삭제
        while($b_row = mysqli_fetch_array($b_result)){
        $b_id = $b_row['id'];
        $b_pwd = $b_row['pwd'];
        $b_up = $b_row['up'];
        $b_hit = $b_row['hit'];
        $b_error = $b_row['error'];
        $b_delete = "delete from bestboard where list_nu = $list_nu and category = 'pop'";
        $delete_result = mysqli_query($con, $b_delete);
        $b_insert = " insert into bestboard(list_nu, id, pwd, title, content, w_date, hit, up, error, category)
                        values('$list_nu', '$b_id', '$b_pwd', '$title', '$content', '$date', '$b_hit', '$b_up', '$b_error', 'pop')";
        $b_insert_result = mysqli_query($con, $b_insert);
    }//
}
    if($result) {
?>
        <script>
            alert("수정되었습니다.");
            location.replace("p_read.php?list_nu=<?=$list_nu?>");</script>
<?php    }
    else {
        echo "수정에 실패하였습니다";
    }
    label:
?>

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
                            goto label2;}
        }             else {
                            $_SESSION['timestamp'] = time();
        }
    }
  }
    $con = mysqli_connect("localhost", "joo", "3797", "board");
    $list_nu = $_GET['list_nu'];
    if(isset($_SESSION['UserId']))
        $now_id = $_SESSION['UserId'];
    $id_sql = "select * from hiphop where list_nu = $list_nu";
    $id_result = mysqli_query($con, $id_sql);
    $id_row = mysqli_fetch_array($id_result);

    if(!isset($_SESSION['UserId'])) { ?>
          <script>alert('로그인을 해주세요');
          location.replace("login.html");</script>
        <?php }
    else if(strcmp($now_id, $id_row['id']) != 0){
              if(strcmp($now_id, 'root') ==0){
                goto label;
              }?>
              <script>alert('본인 게시물만 삭제 가능합니다');
              history.back();</script>
    <?php }
    else if(strcmp($now_id,$id_row['id']) == 0){
              label: //관리자인경우 삭제가능
              $sql = "delete from hiphop where list_nu = $list_nu";
              $result = mysqli_query($con, $sql);

               //베스트게시판
              $b_sql = "select * from bestboard where list_nu= $list_nu and category= 'hiphop'";
              $b_result=mysqli_query($con, $b_sql);
              if($b_result){
              $d_sql = "delete from bestboard where list_nu=$list_nu and category = 'hiphop'";
              $d_result = mysqli_query($con, $d_sql);
            }//

              if($result){ ?>
                  <script>alert('삭제를 성공하였습니다');
                  location.replace("hiphop.php");</script>
    <?php  }
    }

   label2:
  ?>

<?php
    session_start();
    $con = mysqli_connect("localhost", "joo", "3797", "board");
    $list_nu = $_GET['list_nu'];
    $now_id = $_SESSION['UserId'];
    $id_sql = "select * from noticeboard where list_nu = $list_nu";
    $id_result = mysqli_query($con, $id_sql);
    $id_row = mysqli_fetch_array($id_result);

    if(!isset($_SESSION['UserId'])) { ?>
          <script>alert('로그인을 해주세요');
          location.replace("login.html");</script>
        <?php }
    else if(strcmp($now_id, $id_row['id']) != 0){ ?>
              <script>alert('관리자에게만 권한이 있습니다');
              history.back();</script>
    <?php }
    else if(strcmp($now_id,$id_row['id']) == 0){
              $sql = "delete from noticeboard where list_nu = $list_nu";
              $result = mysqli_query($con, $sql);

               //베스트게시판
              $b_sql = "select * from bestboard where list_nu= $list_nu and id = 'root'";
              $b_result=mysqli_query($con, $b_sql);
              if($b_result){
              $d_sql = "delete from bestboard where list_nu=$list_nu and id = 'root'";
              $d_result = mysqli_query($con, $d_sql);
            }//

              if($result){ ?>
                  <script>alert('삭제를 성공하였습니다');
                  location.replace("main.php");</script>
    <?php  }
    }
  ?>

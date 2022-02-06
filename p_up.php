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
                            location.href='main.php';</script>";
                            goto label;}
        }             else {
                            $_SESSION['timestamp'] = time();
        }
    }
    }

    $bno = $_GET['list_nu'];

  if(!isset($_SESSION['UserId']))
    {
        echo "<script>alert('로그인을 해주세요.');
        location.href='login.html'; </script>";
    }
    else{
      $now_id = $_SESSION['UserId'];
      $member = $now_id.","; //추천 중복을 위해
      $thumb = "select * from pop where list_nu=".$bno;
      $result = mysqli_query($con, $thumb);

      while($row = mysqli_fetch_array($result)){

      $exist_member = $row['up_member']; //기존에 추천한 아이디 명단
      $mem_sql = "select up_member from pop where list_nu=$bno";
      $mem_result = mysqli_query($con, $mem_sql);
      $mem_list = mysqli_fetch_array($mem_result);
      $list = $mem_list[0];
      $find_sql = "select FIND_IN_SET('$now_id', '$list')";//현재 로그인한 아이디가 추천한 명단에 있는지
      $find_result = mysqli_query($con, $find_sql);
      $find = mysqli_fetch_array($find_result);
      if($find[0] != 0){
        echo "<script> alert('추천은 한번만 가능합니다.');
              location.href='pop.php'; </script>";
      }

      else{
      $update_member = $exist_member.$member; //추천이 처음이라면 기존 추천 명단에 추가
      $add = "update pop set up_member = '$update_member' where list_nu = $bno";
      $a_result = mysqli_query($con, $add);

      $u_up = $row['up'] + 1;
      $update = "update pop set up = '".$u_up."' where list_nu = '".$bno."'";
      $u_result = mysqli_query($con, $update);
      //베스트게시판
      $b_sql = "select * from bestboard where list_nu= $bno and category = 'pop'";
      $b_result = mysqli_query($con, $b_sql);
      if($b_result){
        $b_update = "update bestboard set up = $u_up where list_nu = $bno and category ='pop'";
        $b_result2 = mysqli_query($con, $b_update);
      }//

      echo "<script> alert('추천이 완료되었습니다.');
            location.href='pop.php'; </script>";
          }
        }
      }
      label:
?>

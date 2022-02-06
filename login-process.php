<?php

        session_start();
        $ip = $_SERVER['REMOTE_ADDR'].",";
        $con = mysqli_connect("localhost", "joo", "3797", "board") or die("fail");
        $id=$_POST['UserId'];
        $pwd=$_POST['UserPwd'];


        $sql = "select * from UserInfo where UserId='$id'";
        $result = mysqli_query($con, $sql);


        if(mysqli_num_rows($result)==1) {
                $row=mysqli_fetch_array($result);
                $login_attemp = $row['login_attemp']; //로그인 시도 횟수

                if($login_attemp == 5){ //로그인 시도횟수 ip차단
                     $login_ip = "update userinfo set ip = '$ip' where UserId = '$id'";
                       $ip_result = mysqli_query($con, $login_ip);}

                if($row['UserPwd']==$pwd && $login_attemp<5){
                        if(isset($_SESSION['UserId']))
                            $_SESSION['UserId2'] = $id;
                        else
                            $_SESSION['UserId']=$id; //수정
                        $login_attemp = "update userinfo set login_attemp = 0 where UserId = '$id'";//로그인
                        $l_result = mysqli_query($con, $login_attemp);
                        //if(isset($_SESSION['UserId'])){
                        $_SESSION['timestamp'] = time();
                         ?>
                                <script>
                                alert("로그인 되었습니다.");
                                location.replace("main.php");
                             </script>
<?php  //}               else{
                        //    echo "세션 실패";
                        //}
            } else {
                  $login_fail = "update userinfo set login_attemp = $login_attemp+1 where UserId = '$id'"; //로그인 시도횟수
                  $fail_result = mysqli_query($con, $login_fail);
                  $total_login = $login_attemp + 1;

                  if($total_login <5){
                  echo "<script>
                    alert('아이디 혹은 비밀번호가 잘못되었습니다.\\n로그인 시도: 총 5회 중  $total_login 회 시도');
                    location.href='login.html';
                  </script>"; }

                  else if($total_login >= 5){
                      echo "<script> alert('로그인 가능횟수를 초과하였습니다.');
                            location.href='login.html'; </script>";
                  }

                }  } else{ //아이디가 없을경우
?>              <script>
                  alert("아이디 혹은 비밀번호가 잘못되었습니다.");
                  history.back();
                </script>
<?php
        }
?>

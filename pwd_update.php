<?php
 $con = mysqli_connect("localhost", "joo", "3797", "board");

 $new_pwd=$_POST['UserPwd'];
 $new_pwd2=$_POST['UserPwd2'];
 $id= $_POST['UserId'];
 $username = $_POST['UserName'];
 $userno = $_POST['UserNo'];

if($new_pwd == $new_pwd2){
      $sql = "delete UserPwd, UserPwd2 from UserInfo where UserId = '$id' and UserName = '$username' and UserNo = '$userno'";
      $result = mysqli_query($con, $sql);

      $update = "update UserInfo set UserPwd = '$new_pwd', UserPwd2 = '$new_pwd2'
                where UserId = '$id' and UserName = '$username' and UserNo = '$userno'";
      $u_result = mysqli_query($con, $update);
            if($u_result){
              echo "<script> alert('비밀번호가 성공적으로 변경되었습니다.');
                    location.href='main.php';</script>";
              }
}
else {
  echo "<script> alert('비밀번호가 일치하지 않습니다');
        history.back(); </script>";
}

 ?>

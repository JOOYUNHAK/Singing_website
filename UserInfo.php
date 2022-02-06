<?php
  $userid = $_POST["UserId"];
  $userpwd = $_POST["UserPwd"];
  $userpwd2 = $_POST["UserPwd2"];
  $username = $_POST["UserName"];
  $userage = $_POST["UserAge"];
  $usergender = $_POST["UserGender"];
  $F_userno = $_POST["UserNo"]; /*주민번호 앞자리*/
  $B_userno = $_POST["UserNo2"]; /*주민번호 뒷자리*/
  $domain = $_POST["domain"];
  $useremail = $_POST["UserEmail"]."@".$domain; /* .은 문자를 더해준다 완성된 이메일주소*/
  $userno = $F_userno."-".$B_userno; /*완성된 주민번호*/


  $con = mysqli_connect("localhost", "joo", "3797", "board") or die("MySQL 접속 실패!!");

  $id_sql = "select UserId from UserInfo where UserId = '$userid'"; //아이디 중복검사하기위해
  $id_result = mysqli_query($con, $id_sql);
  $id_row = mysqli_num_rows($id_result); //아이디가 있어서 반환값이 있으면

  $mem_find = "select * from UserInfo where UserName = '$username' and UserNo = '$userno'"; //기존회원인지 검사
  $mem_result = mysqli_query($con, $mem_find);
  $mem_row = mysqli_num_rows($mem_result);


  if($id_row != 0){
    echo "<script>alert(\"이미 아이디가 존재합니다\");
          history.back();</script>";
  }
  //오류상황일때 데이터베이스에 입력하지 않기 위해
  elseif(strcmp($domain,"error")==0){
      echo "<script>alert(\"이메일을 선택하세요\");
            history.back(); </script>";
       }
  elseif(strcmp($userpwd,$userpwd2)!=0){
     echo "<script>alert(\"비밀번호가 일치하지 않습니다\");
            history.back(); </script>";
       }
  elseif((strlen($F_userno)!=6) || (strlen($B_userno)!=7)){
     echo "<script>alert(\"주민번호 자릿수를 확인하세요\");
            history.back(); </script>";
       }
  elseif($mem_row != 0){
      echo "<script>alert(\"이미 가입한 회원 정보입니다\");
            history.back(); </script>";
        }
  else {
    $sql = "insert into UserInfo(UserNo, UserId, UserPwd, UserPwd2, UserName, UserAge, UserGender, UserEmail)
                values('$userno', '$userid', '$userpwd', '$userpwd2','$username', $userage, '$usergender', '$useremail')";

    $ret = mysqli_query($con, $sql);
  if($ret) {
    echo "<script> alert('회원가입이 완료되었습니다.');
          location.href='main.php'; </script>";
    }
  else {
    echo "실패 원인:".mysqli_error($con);
    echo "<script>alert(\"회원가입에 실패하였습니다.\");
          histroy.back();</script>";

  } }

  mysqli_close($con);
  ?> <?php /*
  <?= ' <br><a href="main.php"><input type="button" value="메인화면으로"></a>' ?>
*/ ?>

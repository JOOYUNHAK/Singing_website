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

if(isset($_SESSION['UserId']))
            $now_id = $_SESSION['UserId'];

$con = mysqli_connect("localhost", "joo", "3797", "board");
//$con2 = mysqli_connect("localhost", "joo", "3797", "midterm"); //아이디, 비밀번호 검사
$title = $_POST["title"];
$id = $_POST["id"];
$pwd = $_POST['pwd'];
$content = $_POST["content"];
$date = date('Y-m-d H:i');

$p_result = "select UserId, UserPwd from UserInfo where UserId = '$id'";
$p_sql = mysqli_query($con, $p_result);
$auto = "alter table ballad auto_increment = 1"; //글 번호 초기화
$auto_result = mysqli_query($con, $auto);

if(strcmp($now_id, $id) != 0){ ?>
        <script>alert("본인아이디로 작성해주세요"); //본인아이디 확인
        history.back();</script> <?php
      }

      while($p_row = mysqli_fetch_array($p_sql)){
                $p_check = $p_row['UserPwd']; //사용자  비밀번호를 받아와서 저장
                if(strcmp($p_check, $pwd) != 0) { ?>
                      <script> alert("비밀번호를 확인해주세요");
                      history.back(); </script>
            <?php }
            else{
                $sql = "insert into ballad(title, pwd, id, content, w_date, category) values
                        ('$title', '$pwd', '$id', '$content', '$date', 'ballad')";
                $result = mysqli_query($con, $sql);
                    if($result){ ?>
                          <script> alert("글 쓰기 성공");
                          location.replace("ballad.php"); </script>
            <?php
                   }
                }
          }
        label:
?>

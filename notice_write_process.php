<?php
session_start();
if(isset($_SESSION['UserId']))
            $now_id = $_SESSION['UserId'];

$con = mysqli_connect("localhost", "joo", "3797", "board");
//$con2 = mysqli_connect("localhost", "joo", "3797", "midterm"); //아이디, 비밀번호 검사
$title = $_POST["title"];
$id = $_POST["id"];
$pwd = $_POST['pwd'];
$content = $_POST["content"];
$date = date('Y-m-d');

$p_result = "select UserId, UserPwd from UserInfo where UserId = '$id'";
$p_sql = mysqli_query($con, $p_result);
$auto = "alter table noticeboard auto_increment = 1"; //글 번호 초기화
$auto_result = mysqli_query($con, $auto);

while($p_row = mysqli_fetch_array($p_sql)){
          $p_check = $p_row['UserPwd']; //비밀번호를 받아와서 저장
          if(strcmp($p_check, $pwd) != 0) { ?>
                <script> alert("비밀번호를 확인해주세요");
                history.back(); </script>
            <?php }
          else {
          $sql = "insert into noticeboard(notice, title, pwd, id, content, w_date) values
                        ('공지', '$title', '$pwd', '$id', '$content', '$date')";
          $result = mysqli_query($con, $sql);
          if($result){ ?>
                  <script> alert("글 쓰기 성공");
                  location.replace("main.php"); </script>
            <?php
              }
          }
        }
?>

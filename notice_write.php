<!doctypehtml>
<meta charset="utf-8">
<form method="post" action="notice_write_process.php">
	<h1 align = center>***공지작성***</h1>
	<table border=4 cellpadding="30" cellspacing="2" bgcolor="white" bordercolor="skyblue" style="margin:0 auto;" >

<tr>
	<td>제목 </td>
	<td><input type="text" name="title" size="50"></td>
</tr>

<tr>
	<td>작성자 </td>
	<td><input type="hidden" name="id" value="root">관리자</td>
</tr>

<tr>
	<td>내용 </td>
	<td><textarea name="content" cols="50" rows="10"></textarea></td>
</tr>

<tr>
	<td>비밀번호 </td>
	<td><input type="password" name="pwd" size="20"></td>
</tr>

<tr>
	<td> &emsp; ★</td>
	<td align = center><input type="submit" value="공지작성"></td>
</tr>

	</table>
</form>

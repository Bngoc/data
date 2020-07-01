<?PHP
///////////////////// TEMPLATE Default /////////////////////
$template_active = <<<HTML
<li style="height:20px; vertical-align:top;">
	<span class="w_text">[link]{title}[/link]</span>
	<span class="w_date">{date}</span>
</li>
HTML;

$template_full = <<<HTML
<div class="sub_guide">
<div align="center" style="font-weight:bold; font-size:18px; padding: 10px;">{title}</div>
<div style="text-align:justify; padding:10px; margin-top:3px; margin-bottom:5px; border-top:1px solid #D3D3D3;">{short-story}</div>
<div style="text-align:justify; padding:10px; margin-top:3px; margin-bottom:5px;">{full-story}</div>
<div align="right" padding:10px;><em>Gửi lúc {date}</em></div>
<div  align="right"><a href="index.php"> << Quay lại </a></div>
</div>
HTML;

$template_comment = <<<HTML
<br>
<table align="center" width="95%">
<div style="border-bottom:1px solid black;"><strong>{author-name}</strong> {date}</div>
<div style="padding:2px;>{comment}</div>
</table>
HTML;

$template_form = <<<HTML
<br>
<table align="center">
    <tr>
		<td width="60">Tên:</td>
		<td><input type="text" name="name"></td>
    </tr>
    <tr>
		<td>E-mail:</td>
		<td><input type="text" name="mail"> (optional)</td>
    </tr>
    <tr>
		<td>Smile:</td>
		<td>{smilies}</td>
    </tr>
    <tr>
      <td colspan="2">
		<textarea cols="90" rows="6" id=commentsbox name="comments"></textarea><br />
      </td>
    </tr>
</table>
<center>
	<input type="submit" name="submit" value="Thêm bình luận">
	<input type=checkbox name=CNremember  id=CNremember value=1><label for=CNremember> Ghi nhớ</label> |
	<a href="javascript:CNforget();">Bỏ ghi nhớ</a>
</center>
HTML;

$template_prev_next = <<<HTML
<p align="center">[prev-link]<< Trang trước[/prev-link] {pages} [next-link]Trang sau >>[/next-link]</p>
HTML;

$template_comments_prev_next = <<<HTML
<p align="center">[prev-link]<< Cũ nhất[/prev-link] ({pages}) [next-link]Mới nhất >>[/next-link]</p>
HTML;
?>
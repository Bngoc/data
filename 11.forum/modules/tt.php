<?php // init
echo dirname(dirname(__FILE__).'.html');

require_once dirname(dirname(__FILE__).'.html').'/admin/core/init.php';

require_once '../config.php';

//$deld ="SELECT topics.id AS topicid, (SELECT name FROM `forums` WHERE topics.forum_id = forums.id) AS nameforum,(SELECT count(*) FROM `messages` WHERE messages.topic_id = topics.id) AS com, topics.*, users.username, messages.id AS messagesid, messages.date AS messagesdate, messages.user_id AS messagesuser_id FROM messages, topics, users WHERE messages.topic_id = topics.id AND topics.user_id = users.id AND (topics.forum_id = '1') AND (users.id = '2') GROUP BY messages.topic_id ORDER BY topics.date ASC limit 0,2;";
$deld ="SELECT topics.id AS topicid, (SELECT name FROM `forums` WHERE topics.forum_id = forums.id) AS nameforum,(SELECT count(*) FROM `messages` WHERE messages.topic_id = topics.id) AS com, topics.*, users.username, users.email, users.avatar, messages.id AS messagesid, messages.date AS messagesdate, messages.user_id AS messagesuser_id FROM messages, topics, users WHERE messages.topic_id = topics.id AND topics.user_id = users.id AND (topics.forum_id = '1') AND (users.id = '2') GROUP BY messages.topic_id ORDER BY topics.date ASC limit 0,3";
$result =$db->query($deld);

$catsql = "SELECT * FROM topics limit 0,2;";
	$catresult =$db->query($catsql);
// ------------------------------------------------------------------------

cn_template_list();
		
?>
<table>
<tr>
									<th title="Subject">ID</th>
									<th width="1" align="center" title="Comments number">Date</th>
									<th align="center" title="Name forums">User_id</th>
									<th width="50" align="center"title="Date">Subject</th>
									<th align="center" title="Author">Bodytopics</th>
									
								</tr>
								
								<?php if($catresult ->num_rows!=0){
		while($catrow = $catresult ->fetch_assoc()){?>
						<tr>
									<?php //echo hook('template/editnews/list_header_before'); ?>
									<td ><?php echo $catrow['id'] ?></td>
									<td><?php echo $catrow['date'] ?></td>
									<td><?php echo $catrow['user_id'] ?></td>
									<td><?php echo $catrow['subject'] ?></td>
								<td><?php echo $catrow['bodytopics'] ?></td>
									<?php //echo hook('template/editnews/list_header_after'); ?>
									
								</tr>		



<?php
$entry = array();
$rowdata = $result ->fetch_assoc();
	$entry['id'] = $rowdata['topicid']; // id
	$entry['t'] = $rowdata['subject']; // tieu de
	$entry['c'] = $rowdata['nameforum']; // ten forum
	$entry['u'] = $rowdata['username']; // tac gia
	$entry['e'] = $rowdata['email']; // email
	$entry['av'] = $rowdata['avatar']; // avatar
	
	$entry['s'] = $rowdata['bodytopics']; //hiem thi ngan
	$entry['f'] = 'ffffffffffffffffffffffffffffffffff'; //hien thi full
	$entry['d'] = $rowdata['date']; // ngay thang viet bai
	
	$entry['ht'] = '';
	$entry['st'] = '';
	$entry['co'] = $rowdata['com']; // so tin tra loi
	$entry['cc'] = ''; // ???????
	$entry['tg'] = ''; //???????

	//if (!$template)
{
    $template = 'Default';
}
//if(!$translate)
{
	$translate = array();
}
foreach ($entry as $ent =>$ko)
{
	//print "lllllllllllllllllll: " . $entries . "<br>";
		
    //cn_translate_active_news($entries, $translate);   
	//------------------------------------------------
	print "----------------------------------- <br>";
	//foreach ($entry as $te => $gd)
	{
		print "Arr : $ent => " . $ko . "<br>";
	}
	print "----------------------------------- <br>";
	//--------------------------------------------
	//$echo[] = entry_make($entries, 'active', $template);
	//foreach ($echo as $hg)
	{
		//print "F_active new 128 sau tag: " . $hg . "<br>";
	}
}
//foreach ($entry as $entries){
	//cn_translate_active_news($entries, $translate);   
	$echo[] = entry_make($entry, 'active', $template);
//}

	}
}
?>
</table>
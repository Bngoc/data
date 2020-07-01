<?php
include('config.php');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Fix AccountCharacter</title>
</head>
<body>
<?php
$query = "SELECT Id FROM AccountCharacter";
$result = $db->Execute($query);

while($row = $result->fetchrow()) 	{
	
	$query_char = "SELECT Name FROM Character WHERE AccountID='$row[0]'";
	$rs_char = $db->Execute($query_char);
	
	$i = $rs_char->numrows();
	
	if ( $i == 1 ) {
		$query_update_empty = "UPDATE AccountCharacter SET GameID2=NULL, GameID3=NULL, GameID4=NULL, GameID5=NULL WHERE Id='$row[0]'";
		$rs_update_empty = $db->Execute($query_update_empty);
	}
	if ( $i == 2 ) {
		$query_update_empty = "UPDATE AccountCharacter SET GameID3=NULL, GameID4=NULL, GameID5=NULL WHERE Id='$row[0]'";
		$rs_update_empty = $db->Execute($query_update_empty);
	}
	if ( $i == 3 ) {
		$query_update_empty = "UPDATE AccountCharacter SET GameID4=NULL, GameID5=NULL WHERE Id='$row[0]'";
		$rs_update_empty = $db->Execute($query_update_empty);
	}
	if ( $i == 4 ) {
		$query_update_empty = "UPDATE AccountCharacter SET GameID5=NULL WHERE Id='$row[0]'";
		$rs_update_empty = $db->Execute($query_update_empty);
	}
	
	/*
	$i=0;
	while($char = $rs_char->fetchrow()) 	{
		$i++;
		if ( $i == 1 ) {
			$query_update = "UPDATE AccountCharacter SET GameID1='$char[0]' WHERE Id='$row[0]'";
			$result_update = $db->Execute($query_update);
		}
		if ( $i == 2 ) {
			$query_update = "UPDATE AccountCharacter SET GameID2='$char[0]' WHERE Id='$row[0]'";
			$result_update = $db->Execute($query_update);
		}
		if ( $i == 3 ) {
			$query_update = "UPDATE AccountCharacter SET GameID3='$char[0]' WHERE Id='$row[0]'";
			$result_update = $db->Execute($query_update);
		}
		if ( $i == 4 ) {
			$query_update = "UPDATE AccountCharacter SET GameID4='$char[0]' WHERE Id='$row[0]'";
			$result_update = $db->Execute($query_update);
		}
		if ( $i == 5 ) {
			$query_update = "UPDATE AccountCharacter SET GameID5='$char[0]' WHERE Id='$row[0]'";
			$result_update = $db->Execute($query_update);
		}
	}
	*/
}
?>
<center>FIX AccountCharacter thành công</center>
</body>
</html>
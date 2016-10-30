<?php

define('ROOT', $_SERVER['DOCUMENT_ROOT']);
include_once(ROOT . "/forum/admin/security.php");
include_once(ROOT . '/forum/config.php');

if ($_REQUEST) {
    $forum_id = $_REQUEST['id'];
    ?>
    <option value="">--Show all--</option>
    <?php
    if ($forum_id == 0) {
        $forsql = "SELECT id, name FROM forums;";
        //}

        //echo "v1 " . $forsql . "<br>";	
        $forresult = $db->query($forsql);
        if ($forresult->num_rows != 0) {
            while ($forrow = $forresult->fetch_assoc()) {
                $temp = $forrow['id'];
                ?>
                <optgroup label="<?php echo $forrow['name']; ?>" style="font:bold;">
                <?php
                //echo "temp " . $temp . "<br>";
                //exit();

                $nuusr = "SELECT DISTINCT user_id FROM topics WHERE forum_id=" . $temp . ";";
                $nuresult = $db->query($nuusr);
                //echo "v2 " . $nuusr . "<br>";
                //exit();
                if ($nuresult->num_rows != 0) {
                    while ($forrownuuser = $nuresult->fetch_assoc()) {
                        $coutusersql = "SELECT count(user_id) as mynum, username, user_id FROM topics, users WHERE topics.user_id = users.id and topics.forum_id =" . $temp . " and topics.user_id=" . $forrownuuser['user_id'] . " ORDER BY mynum DESC;"; //so bai viet cua author
                        //echo "v3 " . $coutusersql . "<br>";
                        //exit();
                        $getnumtopicsuser = $db->query($coutusersql);
                        $numenewtopicuser = $getnumtopicsuser->fetch_assoc();
                        //}
                        ?>
                        <option id="<?php echo $numenewtopicuser['user_id']; ?>"
                                value="<?php echo $numenewtopicuser['user_id']; ?>"><?php echo $numenewtopicuser['username'] ?>
                            (<?php echo $numenewtopicuser['mynum'] ?>)
                        </option>
                        <?php
                    }//exit();
                }//exit();
            }
            ?>
            </optgroup>
            <?php
        }
    } else {
        $forsql = "SELECT DISTINCT user_id FROM topics where forum_id=" . $forum_id . ";";
        $nuresult = $db->query($forsql);
        //echo "velse1 " . $nuusr . "<br>";
        //exit();
        if ($nuresult->num_rows != 0) {
            while ($forrownuuser = $nuresult->fetch_assoc()) {
                $coutusersql = "SELECT count(user_id) as mynum, username,user_id FROM topics, users WHERE topics.user_id = users.id and topics.forum_id =" . $forum_id . " and topics.user_id=" . $forrownuuser['user_id'] . " ORDER BY mynum DESC;"; //so bai viet cua author
                //echo "velse1 " . $coutusersql . "<br>";
                //exit();
                $getnumtopicsuser = $db->query($coutusersql);
                $numenewtopicuser = $getnumtopicsuser->fetch_assoc();
                //}
                ?>
                <option id="<?php echo $numenewtopicuser['user_id']; ?>"
                        value="<?php echo $numenewtopicuser['user_id']; ?>"><?php echo $numenewtopicuser['username'] ?>
                    (<?php echo $numenewtopicuser['mynum'] ?>)
                </option>
                <?php
            }//exit();
        }//e
    }

}
?>

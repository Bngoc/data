<?php if (!defined('BQN_MU')) { die('Access restricted'); }
require_once('./config.php');
//session_start();

// Khai báo biến toàn cục kết nối
global $db;
/*
// Hàm kết nối database
function connect(){
    //global $db;
    $db = mysqli_connect('localhost', 'root', '', 'forum') or die ('{error:"bad_request"}');
}

// Hàm đóng kết nối
function disconnect(){
    //global $db;
    if ($db){
        mysqli_close($db);
    }
}
*/
// Hàm đếm tổng số thành viên
function count_all_member()
{
    global $db;
    $query =$db-> query('select count(*) as total from topics');
    if ($query){
        $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
        return $row['total'];
    }
    return 0;
}

// Lấy danh sách thành viên
function get_all_member($limit, $start)
{
    global $db;
    $sql = 'select * from topics limit '.(int)$start . ','.(int)$limit;
    $query = mysqli_query($db, $sql);
    
    $result = array();
    
    if ($query)
    {
        while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            $result[] = $row;
        }
    }
    
    return $result;
}

?>

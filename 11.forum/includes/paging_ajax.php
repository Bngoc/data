<?php //if (!defined('BQN_MU')) { die('Access restricted'); }

class paging_ajax
{
    public $data; // DATA
    public $per_page = 10; // SỐ RECORD TRÊN 1 TRANG
    public $page; // SỐ PAGE 
    public $text_sql =""; // CÂU TRUY VẤN
    
    //	THÔNG SỐ SHOW HAY HIDE 
    public $show_pagination = true;
    public $show_goto = true;
    public $show_total = true;
    
    // TÊN CÁC CLASS
    public $class_pagination; 
    public $class_active;
    public $class_inactive;
    public $class_go_button;
    public $class_text_total;
    public $class_txt_goto;    
    
    private $cur_page;	// PAGE HIỆN TẠI
    private $num_row; // SỐ RECORD
    public $result;
	
    // PHƯƠNG THỨC LẤY KẾT QUẢ CỦA TRANG 
    public function GetResult()
    {
        global $db; // BIỀN $db TOÀN CỤC
        
        // TÌNH TOÁN THÔNG SỐ LẤY KẾT QUẢ
        $this->cur_page = $this->page;
        $this->page -= 1;
        $this->per_page = $this->per_page;
        $start = $this->page * $this->per_page;
        
        // TÍNH TỔNG RECORD TRONG BẢNG
		$result = $db->query($this->text_sql);// or die("Error: ".mysqli_error($db));
        $this->num_row = $result->num_rows;
		//print "stat :" . $start;
		//print " per_page " . $this -> per_page;
        //print "so dong " . $this->num_row;
		//print "sql " . $this->text_sql." LIMIT $start, $this->per_page";
        // LẤY KẾT QUẢ TRANG HIỆN TẠI
        return mysqli_query($db,$this->text_sql." LIMIT $start, $this->per_page");
    }
    
    // PHƯƠNG THỨC XỬ LÝ KẾT QUẢ VÀ HIỂN THỊ PHÂN TRANG
    public function Load()
    {
        // KHÔNG PHÂN TRANG THÌ TRẢ KẾT QUẢ VỀ
        if(!$this->show_pagination)
            return $this->data;
        
        // SHOW CÁC NÚT NEXT, PREVIOUS, FIRST & LAST
        $previous_btn = true;
        $next_btn = true;
        $first_btn = true;
        $last_btn = true;    
        
        // GÁN DATA CHO CHUỖI KẾT QUẢ TRẢ VỀ 
        $msg = $this->data;
		
        // TÍNH SỐ TRANG
        $count = $this->num_row;
        $no_of_paginations = ceil($count / $this->per_page);
        
        // TÍNH TOÁN GIÁ TRỊ BẮT ĐẦU & KẾT THÚC VÒNG LẶP
        if ($this->cur_page >= 7) {
            $start_loop = $this->cur_page - 3;
            if ($no_of_paginations > $this->cur_page + 3)
                $end_loop = $this->cur_page + 3;
            else if ($this->cur_page <= $no_of_paginations && $this->cur_page > $no_of_paginations - 6) {
                $start_loop = $no_of_paginations - 6;
                $end_loop = $no_of_paginations;
            } else {
                $end_loop = $no_of_paginations;
            }
        } else {
            $start_loop = 1;
            if ($no_of_paginations > 7)
                $end_loop = 7;
            else
                $end_loop = $no_of_paginations;
        }
		
		$msg .="</div><div class='$this->class_pagination'>";//"<ul class style='float:right'>";
        // SHOW TEXTBOX ĐỂ NHẬP PAGE KO ? 
		if($this->show_total)
            //$total_string
			$msg .="<span id='total' class='$this->class_text_total' a='$no_of_paginations'>Page <b>" . $this->cur_page . "</b>/<b>$no_of_paginations</b></span>";
      
        if($this->show_goto)
            //$goto
			$msg .="<span class='gotopage'><input type='text' id='goto' class='$this->class_txt_goto' title='Page number' size='1' style='margin-top:-1px;margin-left:40px;margin-right:10px'/><input type='button' id='go_btn' class='$this->class_go_button' title ='Go' value='Go'/> </span>";
       
		
        // NỐI THÊM VÀO CHUỖI KẾT QUẢ & HIỂN THỊ NÚT FIRST 
        //$msg .="</div><div class='$this->class_pagination'>
		$msg .="<ul class style='float:right'>";
        if ($first_btn && $this->cur_page > 1) {
            $msg .= "<li p='1' class='active' title ='First'>First</li>";
        } else if ($first_btn) {
            $msg .= "<li p='1' class='$this->class_inactive' title ='First'>First</li>";
        }
    
        // HIỂN THỊ NÚT PREVIOUS
        if ($previous_btn && $this->cur_page > 1) {
            $pre = $this->cur_page - 1;
            $msg .= "<li p='$pre' class='active' title ='Pre'><</li>"; //Trước
        } else if ($previous_btn) {
            $msg .= "<li class='$this->class_inactive' title ='Pre'><</li>";
        }
        for ($i = $start_loop; $i <= $end_loop; $i++) {
        
            if ($this->cur_page == $i)
                $msg .= "<li p='$i' class='actived'>{$i}</li>";
            else
                $msg .= "<li p='$i' class='active'>{$i}</li>";
        }
        
        // HIỂN THỊ NÚT NEXT
        if ($next_btn && $this->cur_page < $no_of_paginations) {
            $nex = $this->cur_page + 1;
            $msg .= "<li p='$nex' class='active' title ='Next'>></li>";//Sau
        } else if ($next_btn) {
            $msg .= "<li class='$this->class_inactive' title ='Next'>></li>";
        }
        
        // HIỂN THỊ NÚT LAST
        if ($last_btn && $this->cur_page < $no_of_paginations) {
            $msg .= "<li p='$no_of_paginations' class='$this->class_active' title ='Last'>Last</li>";
        } else if ($last_btn) {
            $msg .= "<li p='$no_of_paginations' class='$this->class_inactive' title ='Last'>Last</li>";
        }
        
		
		//if($this->show_goto){
			//$stradd = $total_string.$goto;
			// TRẢ KẾT QUẢ TRỞ VỀ
			//return  $stradd . $msg . "</ul></div>";  // Content for pagination
		//}
		// TRẢ KẾT QUẢ TRỞ VỀ
        return $msg . "</ul></div>";  // Content for pagination
    }     
            
}

?>
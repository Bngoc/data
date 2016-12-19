<?php global $callback; print " Golball_back: " . PHP_SELF . "<br>"; ?>
<a href="#" title="Bold" onclick="return(bb_wrap('<?php echo $callback; ?>', 'b'));"><img src="<?php echo getoption('http_script_dir'); ?>/skins/images/format-bold.png" /></a>
<a href="#" title="Italic" onclick="return(bb_wrap('<?php echo $callback; ?>', 'i'));"><img src="<?php echo getoption('http_script_dir'); ?>/skins/images/format-italic.png" /></a>
<a href="#" title="Underline" onclick="return(bb_wrap('<?php echo $callback; ?>', 'u'));"><img src="<?php echo getoption('http_script_dir'); ?>/skins/images/format-underline.png" /></a>
<a href="#" title="Quote" onclick="return(bb_wrap('<?php echo $callback; ?>', 'quote'));"><img src="<?php echo getoption('http_script_dir'); ?>/skins/images/format-quote.png" /></a>
&nbsp;&nbsp;
<a href="#" title="Insert image" onclick="<?php echo cn_snippet_open_win(PHP_SELF.'?mod=media&opt=inline&imgopts=yes&callback='.$callback.'&style=add', array('w'=>1000, 'h'=>640, 'l' => 'auto')); ?>" target="_blank"><img src="<?php echo getoption('http_script_dir'); ?>/skins/images/format-insert_image.png" /> Image</a>
&nbsp;
<a href="#" title="BB-code" onclick="<?php echo cn_snippet_open_win(PHP_SELF.'?mod=help&action=code&target_id='.$callback, array('w'=>480, 'h'=>320, 't'=>240, 'l'=>'auto')); ?>" target="_blank"><img src="<?php echo getoption('http_script_dir'); ?>/skins/images/format-bb.png" /> bb-code</a>
&nbsp;&nbsp;
<?php echo insert_smilies($callback, 40, true); ?>

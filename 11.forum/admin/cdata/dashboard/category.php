<?php

list($category_id, $categories, $category_name, $category_memo, $category_icon, $category_description, $category_acl, $category_parent, $groups) = _GL('category_id, categories, category_name, category_memo, category_icon, category_description, category_acl, category_parent, groups');

cn_snippet_messages();
cn_snippet_bc();

?>
<div style="text-align: right;">
    <img border="0" src="admin/skins/images/help_small.gif" style="vertical-align: middle;">
    <a  href="#"onclick="<?php echo cn_snippet_open_win(PHP_SELF.'?mod=help&section=categories'); ?>">What are categories and How to use them</a>
</div>
<br/>

<!-- show categories -->
<form action="<?php echo PHP_SELF; ?>" method="POST" accept-charset="utf-8">

    <?php cn_form_open('mod, opt'); ?>
    <input type="hidden" name="category_id" value="<?php echo $category_id; ?>" />

    <table class="std-table wide">
        <tr><th>ID</th> <th>Name</th> <th>Memo</th>  <th>Icon</th> <th>Description</th> <th>Restriction</th></tr>

        <?php if ($categories) {

        foreach ($categories as $id => $category)
        {
            $acl_message = array();
            $acls = spsep($category['acl_forum']);

            foreach ($acls as $grp) $acl_message[] = ucfirst($groups[$grp]['N']);
            $acl_message = join(', ', $acl_message);
			$id_vl = $category['id'];

        ?>
            <tr <?php if ($id_vl == $category_id) echo ' class="row_selected"'; ?>>
                <td align="center"><?php echo intval($id_vl); ?></td>
                <td><?php echo str_repeat('&ndash;&nbsp;', $category['level_forum']); ?> <a href="<?php echo cn_url_modify("category_id=$id_vl"); ?>"><?php echo htmlspecialchars($category['name_forum'], ENT_NOQUOTES, "UTF-8"); ?></a></td>
                <td><?php echo ($category['memo_forum']); ?></td>
                <td align="center"><?php if ($category['icon_forum']) echo '<img style="max-width: 128px; max-height: 128px;" src="'.($category['icon_forum']).'" />'; else echo '---'; //cn_htmlspecialchars?></td>
                <td align="left"><?php echo cn_htmlspecialchars($category['description_forum']); ?></td>
				<td align="center"><?php echo $acl_message ? $acl_message : '---'; ?></td>
            </tr>
			
        <?php } } else { ?>

            <tr><td colspan="5" style="text-align: center;">No one category exists</td> </tr>

        <?php } ?>

    </table>

    <br/>
    <table class="panel wide">
        <tr>
            <td align="right" style="width: 10%;">Name <span class="required">*</span></td>
            <td><input style="width: 55%;" type="text" name="category_name" value="<?php echo ($category_name); ?>"/></td>
        </tr>

        <tr>
            <td align="right" valign="top" style="/*padding: 8px 0 0 0;*/">Memo</td>
            <td><input style="width: 55%;" type="text" name="category_memo" value="<?php echo ($category_memo); ?>"/>
                <div style="color: #888; margin: 0 0 8px 0;">alternative for name (visual)</div>
            </td>
        </tr>

        <tr>
            <td align="right" valign="top" style="/*padding: 8px 0 0 0;*/">Parent</td>
            <td><select name="category_parent" style="width: 55%;">
                    <option value="0">-- None --</option>
                    <?php if ($categories) {
						foreach ($categories as $id => $category) {
							if ($category_id != $category['id']) { ?>
							<option <?php if ($category_parent == $category['id']) { echo 'selected'; } ?> value="<?php echo $category['id']; ?>">
								<?php echo str_repeat('&nbsp;&nbsp;', $category['level_forum']).($category['name_forum']); ?>
							</option>
						<?php }                     
						}
					}?>                        
                </select>
            </td>
        </tr>

        <tr>
            <td align="right">Icon</td>
            <td><input style="width: 55%;" type="text" id="category_icon" name="category_icon" value="<?php echo ($category_icon); ?>"/> 
                <a class="external" href="#" onclick="<?php echo cn_snippet_open_win(cn_url_modify('mod=media','opt=inline','faddm=C','callback=category_icon'), array('w' => 640)); ?>">
                    Media manager
                </a> 
            </td>
        </tr>
		<tr>
            <td align="right" valign="top" style = "vertical-align: top;">Description</td>
            <td>
                <textarea style="width: 100%;" rows="6" cols="24" id="category_description" name="category_description" tabindex=""><?php echo ($category_description); ?></textarea>
            </td>
        </tr>

        <tr >
            <td align="right">Groups</td>
            <td>
                <?php foreach ($groups as $id => $name) { ?>
                <input type="checkbox" name="category_acl[]" <?php if ($category_acl&& in_array($id, $category_acl)) echo 'checked'; ?> value="<?php echo $id; ?>"/> <?php echo cn_htmlspecialchars($name['N']); ?>
                <?php } ?>
            </td>
        </tr>

        <tr><td></td><td><hr/></td></tr>

        <tr><td>&nbsp;</td>
            <td>
                <div style="float:left;">
                    <?php if(!$category_id){ ?>
                        <input type="submit" onclick="actionClick('a');" value="Add category" />&nbsp;       
                    <?php } else {
							if (array_key_exists($category_id,$categories)){?> 
								<input type="submit" onclick="actionClick('e');" value="Edit category" />                                    
									&nbsp;
							<input type="submit" onclick="actionClick('c');" value="Cancel edit" />&nbsp;
							<?php }else {?>
								<input type="submit" onclick="actionClick('c');" value="Cancel edit" />&nbsp;
							<?php }
						}?>                    
                </div>
                <div style="width:100%;text-align:right;">
                    <?php if($category_id && array_key_exists($category_id,$categories)){ ?>
                        <input type="submit" onclick="actionClick('d');" value="Delete category" />
                    <?php } ?> 
                </div>               
                <input type="hidden" id="mode" name="mode" value=""/>                
            </td></tr>

    </table>
    <script type="text/javascript">
        function actionClick(m)
        {
            var input=document.getElementById('mode');
            input.setAttribute('value',m);
        }
    </script>
</form>

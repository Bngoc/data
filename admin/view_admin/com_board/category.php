<?php

list($category_id, $categories, $category_name, $category_memo, $category_icon, $category_acl, $category_parent, $groups) = _GL('category_id, categories, category_name, category_memo, category_icon, category_acl, category_parent, groups');

cn_snippet_messages();
cn_snippet_bc();

?>

<!-- show categories -->
<form action="<?php echo REQUEST_URI; ?>" method="POST">

    <?php cn_form_open('mod, opt'); ?>
    <input type="hidden" name="category_id" value="<?php echo $category_id; ?>"/>

    <table class="std-table wide">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Memo</th>
            <th>Icon</th>
            <th>Restriction</th>
        </tr>

        <?php if ($categories) {

            foreach ($categories as $id => $category) {
                $acl_message = array();
                $acls = separateString($category['acl']);

                foreach ($acls as $grp) $acl_message[] = ucfirst($groups[$grp]['N']);
                $acl_message = join(', ', $acl_message);

                ?>
                <tr<?php if ($id == $category_id) echo ' class="row_selected"'; ?>>
                    <td align="center"><?php echo intval($id); ?></td>
                    <td><?php echo str_repeat('&ndash;', $category['level']); ?> <a
                            href="<?php echo cn_url_modify("category_id=$id"); ?>"><?php echo cnHtmlSpecialChars($category['name']); ?></a>
                    </td>
                    <td><?php echo cnHtmlSpecialChars($category['memo']); ?></td>
                    <td align="center"><?php if ($category['icon']) echo '<img style="max-width: 128px; max-height: 128px;" src="' . cnHtmlSpecialChars($category['icon']) . '" />'; else echo '---'; ?></td>
                    <td align="center"><?php echo $acl_message ? $acl_message : '---'; ?></td>
                </tr>
            <?php }
        } else { ?>

            <tr>
                <td colspan="5" style="text-align: center;">No one category exists</td>
            </tr>

        <?php } ?>

    </table>

    <br/>
    <table class="panel">

        <?php if ($category_name) { ?>
            <tr>
                <td align="right"><input type="checkbox" name="new_cat" value="Y"/></td>
                <td>Add new category</td>
            </tr>
        <?php } ?>

        <tr>
            <td align="right">Name <span class="required">*</span></td>
            <td><input style="width: 350px;" type="text" name="category_name"
                       value="<?php echo cnHtmlSpecialChars($category_name); ?>"/></td>
        </tr>

        <tr>
            <td align="right" valign="top" style="padding: 8px 0 0 0;">Memo</td>
            <td><input style="width: 350px;" type="text" name="category_memo"
                       value="<?php echo cnHtmlSpecialChars($category_memo); ?>"/>
                <div style="color: #888; margin: 0 0 8px 0;">alternative for name (visual)</div>
            </td>
        </tr>

        <tr>
            <td align="right" valign="top" style="padding: 8px 0 0 0;">Parent</td>
            <td><select name="category_parent">
                    <option value="0">-- None --</option>
                    <?php foreach ($categories as $id => $category) if ($category_id != $id) { ?>
                        <option <?php if ($category_parent == $id) echo 'selected'; ?>
                        value="<?php echo $id; ?>"><?php echo cnHtmlSpecialChars($category['name']); ?></option><?php } ?>
                </select>
            </td>
        </tr>

        <tr>
            <td align="right">Icon</td>
            <td><input style="width: 350px;" type="text" id="category_icon" name="category_icon"
                       value="<?php echo cnHtmlSpecialChars($category_icon); ?>"/> <a class="external" href="#"
                                                                                      onclick="<?php echo cn_snippet_open_win(cn_url_modify('mod=media', 'opt=inline', 'faddm=C', 'callback=category_icon'), array('w' => 640)); ?>">Media
                    manager</a></td>
        </tr>

        <tr>
            <td>Groups</td>
            <td>
                <?php foreach ($groups as $id => $name) { ?>
                    <input type="checkbox"
                           name="category_acl[]" <?php if ($category_acl && in_array($id, $category_acl)) echo 'checked'; ?>
                           value="<?php echo $id; ?>"/> <?php echo cnHtmlSpecialChars($name['N']); ?>
                <?php } ?>
            </td>
        </tr>

        <tr>
            <td></td>
            <td>
                <hr/>
            </td>
        </tr>
        <tr>
            <td align="right"><input type="checkbox" name="delete_cat" value="Y"/></td>
            <td>Delete this category</td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" value="Add or Edit category"/></td>
        </tr>

    </table>

</form>

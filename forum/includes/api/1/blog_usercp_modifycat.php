<?php
/*======================================================================*\
|| #################################################################### ||
|| # vBulletin 4.2.0 
|| # ---------------------------------------------------------------- # ||
|| # Copyright �2000-2012 vBulletin Solutions Inc. All Rights Reserved. ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- VBULLETIN IS NOT FREE SOFTWARE ---------------- # ||
|| # http://www.vbulletin.com | http://www.vbulletin.com/license.html # ||
|| #################################################################### ||
\*======================================================================*/
if (!VB_API) die;

loadCommonWhiteList();

$VB_API_WHITELIST = array(
    'response' => array(
        'content' => array(
            'categoryinfo' => array(
                'blogcategoryid', 'title', 'description', 'parentid'
            ),
            'errorlist', 'selectbits',
            'userinfo' => array(
                'userid', 'username', 'blog_title'
            )
        )
    )
);

/*======================================================================*\
|| ####################################################################
|| # 
|| # CVS: $RCSfile$ - $Revision: 35584 $
|| ####################################################################
\*======================================================================*/
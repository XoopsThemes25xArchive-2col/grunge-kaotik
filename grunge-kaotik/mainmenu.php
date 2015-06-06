<?php

    global $xoopsUser,$xoopsModule,$xoopsTpl;
    $blockM = array();
    $blockM['lang_home'] = _MB_SYSTEM_HOME;
    $blockM['lang_close'] = _CLOSE;
    $module_handler =& xoops_gethandler('module');
    $criteria = new CriteriaCompo(new Criteria('hasmain', 1));
    $criteria->add(new Criteria('isactive', 1));
    $criteria->add(new Criteria('weight', 0, '>'));
    $modules = $module_handler->getObjects($criteria, true);
    $moduleperm_handler =& xoops_gethandler('groupperm');
    $groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
    $read_allowed = $moduleperm_handler->getItemIds('module_read', $groups);
    foreach (array_keys($modules) as $i) {
        if (in_array($i, $read_allowed)) {
            $blockM['modules'][$i]['name'] = $modules[$i]->getVar('name');
            $blockM['modules'][$i]['directory'] = $modules[$i]->getVar('dirname');
            $sublinks = $modules[$i]->subLink();
            if ((count($sublinks) > 0) && (!empty($xoopsModule)) && ($i == $xoopsModule->getVar('mid'))) {
                foreach($sublinks as $sublink){
                    $blockM['modules'][$i]['sublinks'][] = array('name' => $sublink['name'], 'url' => XOOPS_URL.'/modules/'.$modules[$i]->getVar('dirname').'/'.$sublink['url']);
                }
            } else {
                $blockM['modules'][$i]['sublinks'] = array();
            }
        }
    }
	$xoopsTpl->assign('blockM', $blockM);
	/*
	foreach ($blockM as $mod){
	echo '<a href="'.XOOPS_URL.'/modules/'.$mod['directory'].'/">'.$mod['name'].'</a><br />';
	}
	*/
?>
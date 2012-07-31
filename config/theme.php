<?php
/****************
 * Theme config
 *
 */

//This is the physical path to the themes (Thanks Marcus Reinhardt & Kristories, for the Mac and Linux fix)
$config['theme']['path'] = FCPATH . '/themes/';

//This is the url to the themes path
$config['theme']['url'] = trim(config_item('base_url'), '/ ') . '/themes/';

//This is the default theme (subfolder in the themes folder)
$config['theme']['theme'] = 'default';

//This is the default layout (index: a mapping to index.php)
$config['theme']['layout'] = 'index';
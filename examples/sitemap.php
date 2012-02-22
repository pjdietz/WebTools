<?php

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Sitemap.inc.php');

$sitemap = new Sitemap('http://www.mysite.com');
$sitemap->addUrl('/cats.html');

print $sitemap->xml();
exit;


?>

<?php 
$txt='RewriteEngine On



RewriteRule ^('.$lngstring.')/(shop|blog|menu)/(categorys)/(page)/(a-z)/ index.php?lng=$1&state=$2&cat=$3&static=$4&page=$5
RewriteRule ^('.$lngstring.')/(shop|blog|menu)/(categorys)/(c-b-t-sname)/ index.php?lng=$1&state=$2&cat=$3&cname=$4
RewriteRule ^('.$lngstring.')/(shop|blog|menu)/(about|whoweare|mission)/ index.php?lng=$1&state=$2&pagename=$3
RewriteRule ^('.$lngstring.')/(shop|blog|menu)/(categorys)/ index.php?lng=$1&state=$2&cat=$3
RewriteRule ^('.$lngstring.')/(shop|blog|menu)/ index.php?lng=$1&state=$2';
$f = fopen('../../.htaccess', 'w+');
fwrite($f, $txt);
fclose($f);
?>
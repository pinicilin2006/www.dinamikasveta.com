<?php
$page = $HTTP_GET_VARS['link_page'];
$cat = $HTTP_GET_VARS['link_cat'];
$url = "http://" . $HTTP_SERVER_VARS['HTTP_HOST'] . $HTTP_SERVER_VARS['REQUEST_URI'];
ini_set('error_reporting','E_ERROR');
include("http://dmitry-portal.ru/cgi-bin/index3/answer.cgi?login=pinicilin2006&password=406232140&url=".urlencode($url)."&page=$page&cat=$cat&ua=".urlencode($HTTP_SERVER_VARS['HTTP_USER_AGENT']));
?>


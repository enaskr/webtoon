<?php
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT+9");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Connection: close");
	header('Content-Type: text/html; charset=UTF-8');

	$SERVER_PATH = $_POST['server_path'];
	$HTTP_PATH = $_POST['http_path'];

	$file_handle = fopen("config.php", "w");

	$filecont = "<?php \n";
	$filecont = $filecont."\t"."header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT+9'); \n";
	$filecont = $filecont."\t"."header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0'); \n";
	$filecont = $filecont."\t"."header('Cache-Control: post-check=0, pre-check=0', false); \n";
	$filecont = $filecont."\t"."header('Content-Type: text/html; charset=UTF-8'); \n";
	$filecont = $filecont."\t"."header('Pragma: no-cache'); \n";
	$filecont = $filecont."\t"."header('Connection: close'); \n";
	$filecont = $filecont."\t$"."keywordstr = ''; \n";
	$filecont = $filecont."\t"."if (isset($"."_GET['keyword']) ) { \n";
	$filecont = $filecont."\t"."	$"."keywordstr = $"."_GET['keyword'];  \n";
	$filecont = $filecont."\t"."} \n";
	$filecont = $filecont."\t$"."end = ''; \n";
	$filecont = $filecont."\t"."if (isset($"."_GET['end']) ) { \n";
	$filecont = $filecont."\t"."	$"."end = $"."_GET['end'];  \n";
	$filecont = $filecont."\t"."} \n";
	$filecont = $filecont."\t$"."cookieMBRID = ''; \n";
	$filecont = $filecont."\t"."if (isset($"."_COOKIE['MBRID']) ) { \n";
	$filecont = $filecont."\t"."	$"."cookieMBRID = $"."_COOKIE['MBRID'];  \n";
	$filecont = $filecont."\t"."} \n";
	$filecont = $filecont."\t"." \n";
	$filecont = $filecont."\t$"."server_path = str_replace("."basename(__"."FILE__), '', str_replace("."basename(__"."FILE__), '', "."realpath(__"."FILE__))); \n";
	$filecont = $filecont."\t$"."http_path = str_replace("."basename($"."_SERVER['"."PHP_SELF']),'',$"."_SERVER['"."PHP_SELF']); \n";
	$filecont = $filecont."\t$"."homepath = '".$SERVER_PATH."'; \n";
	$filecont = $filecont."\t$"."homeurl = '".$HTTP_PATH."'; \n";
	$filecont = $filecont."\t"." \n";
	$filecont = $filecont."\t"."include($"."homepath.'lib/simple_html_dom.php'); \n";
	$filecont = $filecont."\t"." \n";
	$filecont = $filecont."\t"."if ( lastIndexOf($"."http_path, '/') > 0 ) $"."newpath = substr($"."http_path, 0, strlen($"."http_path)-1); \n";
	$filecont = $filecont."\t"."else $"."newpath = $"."http_path; \n";
	$filecont = $filecont."\t"."$"."newpos = explode('/', $"."newpath); \n";
	$filecont = $filecont."\t"."$"."pathcnt = sizeof($"."newpos); \n";
	$filecont = $filecont."\t"."$"."lastpath = $"."newpos[$"."pathcnt-1]; \n";
	$filecont = $filecont."\t"."$"."lastpath2 = $"."newpos[$"."pathcnt-2]; \n";
	$filecont = $filecont."\t"."$"."filepath = basename($"."_SERVER['PHP_SELF']); \n";
	$filecont = $filecont."\t"." \n";
	$filecont = $filecont."\t"."$"."req_uri = urldecode($"."_SERVER['REQUEST_URI']); \n";
	$filecont = $filecont."\t"."$"."php_name = basename($"."_SERVER['PHP_SELF']); \n";
	$filecont = $filecont."\t"."$"."req_query = urldecode(getenv('QUERY_STRING')); \n";
	$filecont = $filecont."\t"."$"."this_url = $"."php_name.'?'.$"."req_query; \n";
	$filecont = $filecont."\t"."$"."loopcnt = 0; \n";
	$filecont = $filecont."\t"." \n";
	$filecont = $filecont."\t"."$"."thisTime = date('Y.m.d H:i:s', time());  \n";
	$filecont = $filecont."\t"."$"."thisDate = date('Ymd', time());  \n";
	$filecont = $filecont."\t"." \n";
	$filecont = $filecont."\t"."include($"."homepath.'lib/dbconn.php'); \n";
	$filecont = $filecont."\t"."$"."login_view = $"."config['login_view']; \n?>\n";


	fwrite($file_handle, $filecont);
	fclose($file_handle);

	$dbcopy = "N";
	if(!file_exists("webtoon.db")) {
		if(copy("webtoon_init.db", "webtoon.db")) {
			$dbcopy = "Y";
		}
	}
	$fileSize = filesize("./webtoon.db");
	if ( $fileSize < 1000 ) {
		unlink("./webtoon.db");
		$dbcopy = "N";
		if(copy("webtoon_init.db", "webtoon.db")) {
			$dbcopy = "Y";
		}
		$fileSize = filesize("./webtoon.db");
		if ( $fileSize < 1000 ) {  $dbcopy = "F"; }
	}

	if(file_exists("../install/install_save.php")) { unlink("../install/install_save.php"); }
	if(file_exists("../install/install_delete.php")) { unlink("../install/install_delete.php"); }
	if(file_exists("../install/install_dbreset.php")) { unlink("../install/install_dbreset.php"); }
	if(file_exists("../install/install_dbmake.php")) { unlink("../install/install_dbmake.php"); }
	copy("install_save.php", "../install/install_save.php");
	copy("install_delete.php", "../install/install_delete.php");
	copy("install_dbreset.php", "../install/install_dbreset.php");
	copy("install_dbmake.php", "../install/install_dbmake.php");
	if(file_exists("../install/install_save.php")) { unlink("install_save.php"); }
	if(file_exists("../install/install_delete.php")) { unlink("install_delete.php"); }
	if(file_exists("../install/install_dbreset.php")) { unlink("install_dbreset.php"); }
	if(file_exists("../install/install_dbmake.php")) { unlink("install_dbmake.php"); }

?><!DOCTYPE html>
<html lang='ko'>
<head>
<meta charset='utf-8'>
<meta name='viewport' id='viewport' content='width=device-width,user-scalable=no,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0'>
<meta name='mobile-web-app-capable' content='yes'>
<meta http-equiv="expires" content="Sun, 01 Jan 2014 00:00:00 GMT"/>
<meta http-equiv="pragma" content="no-cache" />
<?php echo $favicon; ?>
<link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="//fonts.googleapis.com/css2?family=Nanum+Gothic&amp;subset=korean">
<title>:::WEBTOON::??????:::</title>
<link rel='stylesheet' href='./css/ui.css' type='text/css'>
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]> <script src='http://html5shim.googlecode.com/svn/trunk/html5.js'></script> <![endif]-->
<script  src="//code.jquery.com/jquery-latest.min.js"></script>
</head>
<body style="padding:5px 5px 5px 5px;">
<div id='container'>
	<div class='item'>
		<dl>
			<dt>?????? ?????? ??????</dt>
			<dd>
				<div class='group' style='padding:0px;font-size:20px;line-height:50px'>
					?????? ?????? ????????? ?????????????????????<br><br>
					??? ?????? : <?php echo $HTTP_PATH; ?><br>
					?????? ?????? : <?php echo $SERVER_PATH; ?><br>
					<?php if ($dbcopy=="Y") { echo "?????? Database ????????? ?????????????????????.<br><br>"; } ?>
					<?php if ($dbcopy=="F") { echo "?????? Database ????????? ?????????????????????.<br>????????????/lib/webtoon_init.db ?????????<br>????????????/lib/webtoon.db??? ??????????????????.<br><br>"; } ?>
					????????? ????????? ????????? <br>
					????????????????????? ?????????????????????.<br><br>
					???????????? ????????? ?????? <br>
					install/install_*.php ????????? lib ?????????<br>
					?????? ??? install.php??? ??????????????????.
				</div>
				<div class='group' style='padding:0px;font-size:20px;line-height:50px'>
					<table style="line-height:1.5;border-color:#ffffff;" border=1 width="100%" cellspacing=0 cellpadding=0><tr><td align="center" style='font-size:20px;color:#000000;width:25%;background-color:#e3e3e3;line-height:50px;'><input type="button" value='????????? ??????' style='border:none;line-height:50px;width:100%;background-color:#e3e3e3;' onClick='location.href="<?php echo $HTTP_PATH; ?>";'></td></tr></table>
				</div>
			</dd>
		</dl>
	</div>
</body>
</html>
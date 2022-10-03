<!DOCTYPE html>
	<html lang="ja">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel ="stylesheet" href="expand.css" type="text/css" />
		<title>Expand shortened URL</title>
	</head>
<?php
// ini_set('display_errors', 1);
	$expanded = "";

	if ( array_key_exists('shorturl', $_POST) && $_POST['shorturl'] != ""
	&&   array_key_exists('expand',   $_POST) && $_POST['expand']   != "" ) {
		$shorturl = htmlspecialchars($_POST['shorturl']);
		$header = get_headers($shorturl);

		// 展開できなかったら、元のURLにする
		$expanded = $shorturl;
		for ( $i = 0; $i < sizeof($header); ++$i ) {
			if ( strstr($header[$i], "location:") ) {
				$expanded = trim(explode("location:", $header[$i])[1]);
				$bareURL = explode("?", $expanded)[0];

				if ( !preg_match('/https?:\/{2}[\w\/:%#\$&\?\(\)~\.=\+\-]+/', $bareURL) ) {
					$bareURL = "";
				}
				break;
			}
		}
	}
	else
	if ( array_key_exists('decodeurl', $_POST) && $_POST['decodeurl'] != ""
	&&   array_key_exists('decode',    $_POST) && $_POST['decode']    != "" ) {
		$shorturl = htmlspecialchars($_POST['decodeurl']);
		$expanded = urldecode(urldecode($_POST['decodeurl']));
		$bareURL = "";
	}

	if ( $expanded != "" ) {
		if ( $bareURL != "" ) {
			printf( '展開前:%s<br />展開後:%s<br />', $shorturl, $expanded );
			printf( '(<a href="%s" target="_blank" rel="noopener noreferrer">参考サイト</a>)<br /><hr />', $bareURL );
		}
		else // urldecodeは、どこにURLがあるかわからないのでリンクにしない
		{
			printf( '展開前:%s<br />展開後:%s<br /><hr />', $shorturl, $expanded );
		}
	}
?>

<body>
	<form action="expand.php" method = "POST">
		短縮URL→<input type="text" name="shorturl" />
		<input type="submit" name="expand" value="URL展開" /> <br />
		エンコード済みURL→<input type="text" name="decodeurl" />
		<input type="submit" name="decode" value="URLデコード" />
	</form>
</body>
</html>

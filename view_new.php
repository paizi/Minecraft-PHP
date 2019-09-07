<?php
	use xPaw\MinecraftPing;
	use xPaw\MinecraftPingException;

	define( 'MQ_SERVER_ADDR', 'play.craft.moe' );
	define( 'MQ_SERVER_PORT', 25565 );
	define( 'MQ_TIMEOUT', 3 );

	// Display everything in browser, because some people can't look in logs for errors
	Error_Reporting( E_ALL | E_STRICT );
	Ini_Set( 'display_errors', true );

	require __DIR__ . '/src/MinecraftPing.php';
	require __DIR__ . '/src/MinecraftPingException.php';

	$Timer = MicroTime( true );

	$Info = false;
	$Query = null;
	$count =0;
	$online =true;
	try
	{
		$Query = new MinecraftPing( MQ_SERVER_ADDR, MQ_SERVER_PORT, MQ_TIMEOUT );
		
		$Info = $Query->Query( );
		while ( $Info === false )
		{
			if( $Query !== null )
			{
				$Query->Close( );
			}
			$count++;
			if($count >10)
			{
				$online=false;
				break;
			}
			$Query = new MinecraftPing( MQ_SERVER_ADDR, MQ_SERVER_PORT, MQ_TIMEOUT );
			$Info = $Query->Query( );
		}
		
		// if( $Info === false )
		// {
			// /*
			 // * If this server is older than 1.7, we can try querying it again using older protocol
			 // * This function returns data in a different format, you will have to manually map
			 // * things yourself if you want to match 1.7's output
			 // *
			 // * If you know for sure that this server is using an older version,
			 // * you then can directly call QueryOldPre17 and avoid Query() and then reconnection part
			 // */

			// $Query->Close( );
			// $Query->Connect( );

			// $Info = $Query->QueryOldPre17( );
		// }
	}
	catch( MinecraftPingException $e )
	{
		$Exception = $e;
	}

	if( $Query !== null )
	{
		$Query->Close( );
	}

	$Timer = Number_Format( MicroTime( true ) - $Timer, 4, '.', '' );
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui-flag@2.4.0/flag.min.css">
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>
	<meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0, minimum-scale=1.0,user-scalable=no, minimal-ui">
	<title>Kedama Online Player Stats</title>
</head>
<?php
//$address = 'https://api.ipfinder.io/v1/';
//$ip = 'input ip here';
//$token = 'input token here';
//$ip = file_get_contents($address.$ip.'?token='.$token);
//$deip = json_decode($ip);
?>
<body>
<?php if( isset( $Exception ) ): ?>
<?php echo htmlspecialchars( $Exception->getMessage( ) ); ?>
<?php echo nl2br( $e->getTraceAsString(), false ); ?>
<?php else: ?>
	<?php if($online): ?>
	<?php if( $Info !== false ): ?>
	<?php 
	$players='';
	foreach( $Info['players']['sample'] as $samkey => $samvalue): 
		$players.=$samvalue['name'].'<br>';
	endforeach; 
	?>
	<div class="ui container">
	<br>
	<div class="ui success message">
	<div class="header">服务器在线</div>
	<p>响应时间:<?php echo $Timer; ?>s</p>
	</div>
	<table class="ui celled table">
	<tr>
		<td>服务器名称</td>
		<td><i class="jp<?php //echo strtolower($deip->country_code); ?> flag"></i>毛玉线圈物语</td>
	</tr>
	<tr>
		<td>最大人数</td>
		<td><?php echo $Info['players']['max']; ?></td>
	</tr>
	<tr>
		<td>在线人数</td>
		<td><?php echo $Info['players']['online']; ?></td>
	</tr>
	<tr>
	<td>部分在线玩家</td>
	<td><?php echo $players ; ?></td>
	</tr>
	</table>
			<?php else: ?>
		<div class="ui container">
			<br>
			<div class="ui warning message">
			<div class="header">服务器在线，但无法获取详细信息</div>
			<p>响应时间:<?php echo $Timer; ?>s</p>
			</div></div>
			<?php endif; ?>
		<?php else: ?>
		<div class="ui container">
			<br>
			<div class="ui negative message">
			<div class="header">服务器离线</div>
			<p>响应时间:<?php echo $Timer; ?>s</p>
			</div></div><br>
		<?php endif; ?>
		<?php endif; ?>
</div>
</body>
</html>
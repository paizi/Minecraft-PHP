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
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Kedama Online Player Stats</title>

   <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<style type="text/css">
		.jumbotron {
			margin-top: 30px;
			border-radius: 0;
		}

		.table thead th {
			background-color: #428BCA;
			border-color: #428BCA !important;
			color: #FFF;
		}
	</style>
</head>

<body>
    <div class="container">
    	<div class="jumbotron">
			<h2>毛玉线圈物语</h2>
			<br>
			<h3>在线玩家查询</h3>
			<br>
			<h5>显示的id比在线人数少的原因是Mojang限制，并非网站bug。</h5>

		</div>
<div class="container">
<?php if( isset( $Exception ) ): ?>
		<div class="panel panel-primary">
			<div class="panel-heading"><?php echo htmlspecialchars( $Exception->getMessage( ) ); ?></div>
			<div class="panel-body"><?php echo nl2br( $e->getTraceAsString(), false ); ?></div>
		</div>
<?php else: ?>
		<div class="row">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th colspan="2">服务器响应 <em>(<?php echo $Timer; ?>s)</em></th>
						</tr>
					</thead>
					<tbody>					
		<?php if($online): ?>
			<?php if( $Info !== false ): ?>
				<tr>
					<td>服务器状态</td>
					<td>在线</td>
				</tr>
				<tr>
					<td>最大人数</td>
					<td><?php echo $Info['players']['max']; ?></td>
				</tr>
				<tr>
					<td>在线人数</td>
					<td><?php echo $Info['players']['online']; ?></td>
				</tr>
				<?php 
				$players='';
				foreach( $Info['players']['sample'] as $samkey => $samvalue): 
					$players.=$samvalue['name'].'<br>';
				endforeach; 
				?>
				<tr>
					<td>在线玩家</td>
					<td><?php echo $players ; ?></td>
				</tr>
			<?php else: ?>
				<tr>
					<td colspan="2">No information received</td>
				</tr>
				</div>
			<?php endif; ?>
		<?php else: ?>
			<tr>
				<td>服务器状态</td>
				<td>离线</td>
			</tr>
		<?php endif; ?>
			
							</tbody>
						</table>
				</div>
		<?php endif; ?>
	</div>
<p> <a href="https://github.com/xPaw/PHP-Minecraft-Query/blob/master/LICENSE">MIT协议</a></p>
	<p>本项目由<a href="https://github.com/xPaw/PHP-Minecraft-Query">PHP-Minecraft-Query</a>修改而成。</p>
 <p>Modified by <a href="https://wxserver.cn/">Maggienorth</a> & <a href="https://blingwang.cn/">BlingWang</a>.</p>
</body>
</html>

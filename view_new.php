<?php
	use xPaw\MinecraftPing;
	use xPaw\MinecraftPingException;

	// 请在此修改服务器信息 ->
	define( 'MQ_SERVER_ADDR', 'play.craft.moe' );
	define( 'MQ_SERVER_PORT', 25565 );
	define( 'MQ_TIMEOUT', 3 );
	// 请在此修改服务器信息 <-

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
    <html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>毛线今天炸了吗</title>
        <link rel="icon" href="data:image/x-icon;base64,AAABAAEAEBAAAAAAIABoBAAAFgAAACgAAAAQAAAAIAAAAAEAIAAAAAAAQAQAAAAAAAAAAAAAAAAAAAAAAAD///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wEtLS2XKysr7SgoKO0nJyftJSUl7SMjI+kiIiKTIiIikSIiIukiIiLtIiIi7SIiIu0iIiLtIiIin////wEyMjI1MDAw/y0tLf8rKyv/KSkp/ycnJ/8mJiaP////Af///wEiIiKFIiIi/yIiIv8iIiL/IiIi/yIiIv8iIiI9NTU1kTMzM/8wMDD/Li4u/ywsLP8qKir/KCgoYf///wH///8BIyMjWSIiIv8iIiL/IiIi/yIiIv8iIiL/IiIimzg4OM01NTX9MzMz5TExMf8uLi7/LCws/yoqKtcpKSk7JycnCyUlJdMjIyP/IiIi/yIiIv8iIiLnIiIi/SIiItM7OzvzOTk5hzY2NgU0NDS5MjIy/y8vL/8tLS3/Kysr+SkpKScnJyfNJSUl/yQkJP8iIiLBIiIiByIiIn0iIiL1Pj4+7Tw8PKU6Ojo1Nzc3zTU1Nf8yMjL/MDAw/y4uLv8rKytZKSkpfSgoKP8mJib/JCQk1SMjIzUiIiKdIiIi70FBQcU/Pz//PDw8/zo6Ov84ODj/NTU1/zMzM/8wMDD/Li4unywsLDsqKir/KCgo/yYmJv8lJSX/IyMj/yIiIs1DQ0OBQUFB/z8/P/89PT3vOjo66zg4OP82Njb/NDQ0/zExMd8vLy8fLS0t7SsrK/EpKSnvJycn/yUlJf8jIyOLRUVFIURERPVCQkL9QEBAKz09PRs7OzvxOTk5/zc3N/80NDT/MjIywzAwMO8tLS0nKysrIykpKfknJyf7JiYmKf///wFGRkZ1RERE/0NDQ19AQEBPPj4+9zw8PP85OTmxNzc3rTU1Nf8zMzP7MTExVy4uLlUsLCz/Kioqf////wH///8B////AUZGRpVFRUX/Q0ND/0FBQf8/Pz/3PT09Cf///wE4ODjxNjY2/zMzM/8xMTH/Li4unf///wH///8B////Af///wH///8BR0dHb0VFRelERET/QUFB/0BAQLE+Pj6tOzs7/zk5Of82NjbtNDQ0d////wH///8B////Af///wH///8B////Af///wFGRkYZRkZGcURERK9CQkLjQEBA5T4+PrE7OztzODg4Hf///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8BAAD//wAA//8AAP//AAD//wAA//8AAP//AAD//wAA//8AAP//AAD//wAA//8AAP//AAD//wAA//8AAP//AAD//w==">
        <link rel="shortcut icon" href="data:image/x-icon;base64,AAABAAEAEBAAAAAAIABoBAAAFgAAACgAAAAQAAAAIAAAAAEAIAAAAAAAQAQAAAAAAAAAAAAAAAAAAAAAAAD///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wEtLS2XKysr7SgoKO0nJyftJSUl7SMjI+kiIiKTIiIikSIiIukiIiLtIiIi7SIiIu0iIiLtIiIin////wEyMjI1MDAw/y0tLf8rKyv/KSkp/ycnJ/8mJiaP////Af///wEiIiKFIiIi/yIiIv8iIiL/IiIi/yIiIv8iIiI9NTU1kTMzM/8wMDD/Li4u/ywsLP8qKir/KCgoYf///wH///8BIyMjWSIiIv8iIiL/IiIi/yIiIv8iIiL/IiIimzg4OM01NTX9MzMz5TExMf8uLi7/LCws/yoqKtcpKSk7JycnCyUlJdMjIyP/IiIi/yIiIv8iIiLnIiIi/SIiItM7OzvzOTk5hzY2NgU0NDS5MjIy/y8vL/8tLS3/Kysr+SkpKScnJyfNJSUl/yQkJP8iIiLBIiIiByIiIn0iIiL1Pj4+7Tw8PKU6Ojo1Nzc3zTU1Nf8yMjL/MDAw/y4uLv8rKytZKSkpfSgoKP8mJib/JCQk1SMjIzUiIiKdIiIi70FBQcU/Pz//PDw8/zo6Ov84ODj/NTU1/zMzM/8wMDD/Li4unywsLDsqKir/KCgo/yYmJv8lJSX/IyMj/yIiIs1DQ0OBQUFB/z8/P/89PT3vOjo66zg4OP82Njb/NDQ0/zExMd8vLy8fLS0t7SsrK/EpKSnvJycn/yUlJf8jIyOLRUVFIURERPVCQkL9QEBAKz09PRs7OzvxOTk5/zc3N/80NDT/MjIywzAwMO8tLS0nKysrIykpKfknJyf7JiYmKf///wFGRkZ1RERE/0NDQ19AQEBPPj4+9zw8PP85OTmxNzc3rTU1Nf8zMzP7MTExVy4uLlUsLCz/Kioqf////wH///8B////AUZGRpVFRUX/Q0ND/0FBQf8/Pz/3PT09Cf///wE4ODjxNjY2/zMzM/8xMTH/Li4unf///wH///8B////Af///wH///8BR0dHb0VFRelERET/QUFB/0BAQLE+Pj6tOzs7/zk5Of82NjbtNDQ0d////wH///8B////Af///wH///8B////Af///wFGRkYZRkZGcURERK9CQkLjQEBA5T4+PrE7OztzODg4Hf///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8BAAD//wAA//8AAP//AAD//wAA//8AAP//AAD//wAA//8AAP//AAD//wAA//8AAP//AAD//wAA//8AAP//AAD//w==">
        <link rel="stylesheet" href="app.css">
        <style>
            p {
                margin-block-end: unset;
                margin-block-start: unset;
            }
        </style>
    </head>
    <body>
    <div id="app">
        <section class="header">
            <div class="container">
                <h1 class="header-title">毛线今天炸了吗</h1>
               	<?php if($online): ?>
		            	<?php if( $Info !== false ): ?>
                <div class="card">
                    <div class="summary">
                        <div class="icon icon-status-sum up"></div><div style="letter-spacing:-0.5px;"><div class="summary-detail">好耶，没有炸。 </div>
                    <div class="summary-checktime">响应时间：<?php echo $Timer; ?>s
                </div>
            </div>
    </div>
    </div>
    </section>
    <section class="content">
        <div class="container"><div class="card monitors has-children"><div class="monitors-header"><div class="monitors-header-title">在线人数：<?php echo $Info['players']['online']; ?></div></div>
				  	 <div class="monitors-header"><div class="monitors-header-title">最大人数：<?php echo $Info['players']['max']; ?></div></div></div></div>
				            </section>
				     <?php else: ?>
                  		<div class="card">
                    <div class="summary">
                        <div class="icon icon-status-sum down"></div><div style="letter-spacing:-0.5px;"><div class="summary-detail">坏耶，炸了。 </div>
                    <div class="summary-checktime">响应时间：<?php echo $Timer; ?>s</div>
                </div>
                </section>
			<?php endif; ?>
		<?php else: ?>
		<?php endif; ?>
    <section class="footer">
        <div class="container">
            <div class="footer-content">
                <nav class="links">
                    <a href="https://blingwang.cn">Home</a><a href="https://blog.blingwang.cn">Blog</a><a href="https://status.blingwang.cn">Status</a>                </nav>
                <div class="copyright">
                    &copy; BlingWang                </div>
            </div>
        </div>
    </section>
  </div>
    </body>
    </html>
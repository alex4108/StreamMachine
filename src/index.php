<?php
require_once('../api_auth.php');

    if (isset($_GET['stream'])) { 
        $streamTag = $_GET['stream'];
    }
    else {
        $streamTag = '';
    }

    require_once('../streamers.php')
?>
</div><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php if (isset($streamTag) && $streamTag != '') { echo $streamTag . " | "; } ?> StreamingThing </title>

    <!-- using online links -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="//malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.min.css">

    <!-- using local links -->
    <!-- <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../node_modules/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css"> -->
    
      <link href="https://vjs.zencdn.net/7.8.4/video-js.css" rel="stylesheet" />
      <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
		  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/sidebar-themes.css">
    <link rel="shortcut icon" type="image/png" href="img/favicon.png" />
</head>

<body>
    <div class="page-wrapper default-theme sidebar-bg bg4 toggled">
        <nav id="sidebar" class="sidebar-wrapper">
            <div class="sidebar-content">
                <!-- sidebar-brand  -->
                <div class="sidebar-item sidebar-brand">
                    <a href="#">StreamingThing</a>
                </div>
                <!-- sidebar-menu  -->
                <div class=" sidebar-item sidebar-menu">
                    <ul>
                        <li class="header-menu">
                            <span>Online Streams</span>
                        </li>
                        <?php
$streamData = json_decode(shell_exec("curl http://localhost:8000/api/streams --user admin:admin"));
$live = 0;
$liveStreams = array();
foreach($streamData->live as $k => $stream) { 
    $streamers[$k]['online'] = true;
}

foreach($streamers as $k => $streamer) { 
    if ($streamer['online'] == true) { 
        ?><div class=" online"><li class="online">
                            <a href="?stream=<?php echo $k; ?>">
                                <i class="fa fa-circle"></i>
                                <span class="menu-text"><?php echo $k; ?></span>
                            </a>
                        </li></div>
    <?php }
}

?>

                        <li class="header-menu">
                            <span>Offline Streams</span>
                        </li>
<?php

foreach($streamers as $k => $streamer) { 
    if ($streamer['online'] == false) { 
        ?><div class="offline"><li>
                            <a href="#">
                                <i class="offline fa fa-circle"></i>
                                <span class="menu-text"><?php echo $k; ?></span>
                            </a>
                        </li></div>
    <?php }
}

?>

                    <li class="header-menu"><span>Join us on Discord</span></li>
                    
<?php

foreach($streamers as $k => $streamer) { 
    if (isset($streamer['discord']['url']) && $streamer['discord']['url'] != '') { 
     ?><div class="offline"><li>
                            <a href="<?php echo $streamer['discord']['url']; ?>" target="_blank">
                                <i class="fab fa-discord"></i>
                                <span class="menu-text"><?php echo $k; ?></span>
                            </a>
                        </li></div>
    <?php
}
}

?>

<li>
<?php
	if (isset ($streamTag)) { 
		$streamer = $streamers[$streamTag];
	}
	if (isset($streamer['discord']['titanEmbedId']) && $streamer['discord']['titanEmbedId'] != '') { 
		if (!isset($streamer['discord']['titanChannel'])) { 
			$channel = '';
		}
		else {
			$channel = '&defaultchannel=' . $streamer['discord']['titanChannel'];
		}
		echo('<iframe src="https://titanembeds.com/embed/' . $streamer['discord']['titanEmbedId'] . '?theme=DiscordDark' . $channel . '" width="300px" height="800px" frameborder="0"></iframe>');
	}
?>
</li>
                        
                    </ul>
                </div>
                <!-- sidebar-menu  -->
            </div>
            <!-- sidebar-footer  -->
        </nav>
        <!-- page-content  -->
        <main class="page-content pt-2">
            <div id="overlay" class="overlay"></div>
            <div class="container-fluid p-5">
                <div class="row">
                    <div class="form-group col-md-12">
                        <?php
                        if ($streamTag == "") { 
                            echo "<p>Choose a stream from the left</p>";
                        }
                        else {
                                                        
                            $streamData = json_decode(shell_exec("curl http://localhost:8000/api/streams --user admin:admin"));
                            //print_r($streamData);
                            $width = null;
                            $height = null;
                            if ($streamData != null) { 
                                foreach($streamData->live as $k => $stream) { 
                                    if ($k == $streamTag) { 
                                        $width = $stream->publisher->video->width;
                                        $height = $stream->publisher->video->height;
                                    }
                                }
                            ?>
                            <script src="https://vjs.zencdn.net/7.8.4/video.js"></script>
                            <script src="https://cdn.dashjs.org/latest/dash.all.min.js"></script>
                            <script src="videojs-dash.min.js"></script>

                                <video-js id=<?php echo $streamTag; ?> width=<?php echo $width; ?> height=<?php echo $height; ?> class="vjs-default-skin" controls>
                                    <source src="live/<?php echo $streamTag; ?>/index.m3u8">
                                </video-js>
                            <script>
                                var player = videojs('<?php echo $streamTag; ?> ');
                                player.fluid(true);
                                player.play();
                            </script>
                        <?php
                            }
                        }
						?>
                    </div>
                </div>
            </div>
        </main>
        <!-- page-content" -->
    </div>
    <!-- page-wrapper -->

    <!-- using online scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous">
    </script>
    <script src="//malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>

    <!-- using local scripts -->
    <!-- <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../node_modules/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script> -->


    <script src="js/main.js"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">
<?php
  $config = include('config.php');
  include ("common.php");
  $bingKey = $config['bingAPIKey'];
  $ipinfoKey = $config['ipinfoKey'];
  $mapType = $config['defaultMapType'];
  $mapSize = $config['defaultMapSize'];
  $zoomLevel = $config['defaultZoomLevel'];
?>
<?php
  //App Details
  $title = "Retro Maps";
  $subtitle = "";
  $description = "Lightweight maps for retro devices.";
  $github = "https://github.com/webosarchive/maplite-service";
  $museumLink = "https://appcatalog.webosarchive.org/app/MapLite";
  $icon = "icon.png";

  //Figure out what protocol the client wanted
  if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $PROTOCOL = "https";
  } else {
    $PROTOCOL = "http";
  }

  //Figure out map query
  $useLoc = geolocateByIP(getVisitorIP($config['hostname']), $ipinfoKey);
  if (isset($_POST['query'])) {
    $useLoc = $_POST['query'];
  }

  if (isset($_POST['zoom'])) {
    $zoomLevel = $_POST['zoom'];
  }

  if (isset($_POST['screenSize']) && $_POST['screenSize'] != "") {
    $mapSize = round((int)$_POST['screenSize'] * 0.7);
    $mapSize = $mapSize . "," . $mapSize;
  }
?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

  <meta name="description" content="<?php echo $description; ?>">
  <meta name="keywords" content="webos, firefoxos, pwa, rss">
  <meta name="author" content="webOS Archive">
  <meta property="og:title" content="<?php echo $title; ?>">
  <meta property="og:description" content="<?php echo $description; ?>">
  <meta property="og:image" content="https://<?php echo $_SERVER['SERVER_NAME'] ?>/tracker/hero.png">

  <meta name="twitter:card" content="app">
  <meta name="twitter:site" content="@webOSArchive">
  <meta name="twitter:title" content="<?php echo $title; ?>">
  <meta name="twitter:description" content="<?php echo $description; ?>">
  <meta name="twitter:app:id:googleplay" content="<?php echo $playId?>">

  <title><?php echo $title . $subtitle; ?></title>
  <script>
    function findScreenSize() {
      document.getElementById("screenSize").value = window.innerWidth;
    }
  </script>
  <link id="favicon" rel="icon" type="image/png" sizes="64x64" href="<?php echo $icon;?>">
  <link href="<?php echo $PROTOCOL . "://www.webosarchive.org/app-template/"?>web.css" rel="stylesheet" type="text/css" >
</head>
<body>
<?php

$docRoot = "./";
echo file_get_contents("https://www.webosarchive.org/menu.php?docRoot=" . $docRoot . "&protocol=" . $PROTOCOL);
?>

  <table width="100%" border=0 style="width:100%;border:0px"><tr><td align="center" style="width:100%;height:100%;border:0px">
  <div id="row">
    <div id="content" align="left">
      <h1><img src="<?php echo $icon;?>" width="60" height="60" alt=""/><?php echo $title; ?></h1>
      <p><b><?php echo $description; ?></b></p>
      <p>A Project of webOS Archive. Location provided by <a href='https://ipinfo.io'>IPInfo</a>, Maps provided by <a href='https://docs.microsoft.com/en-us/bingmaps/articles/accessing-the-bing-maps-rest-services-using-php'>Bing</a>.
      <p>Host your own maps, or contribute on <a href="<?php echo $github;?>">GitHub.</a></p>
      <form method="post">
        <table border="0" cellpadding="0" cellspacing="0" class="content" style="margin: 0 auto;">
            <tr><td>Address: </td><td><input type="text" style="width:200px" name="query" value="<?php echo $useLoc ?>"></td></tr>
            <tr><td>Zoom Level: </td><td>&nbsp;<select name="zoom">
            <option value="<?php echo $zoomLevel; ?>">[<?php echo $zoomLevel; ?>]</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
          </select>&nbsp;&nbsp;
          Map Type: <select name="maptype">
            <option value="Road">Road</option>
            <option value="Aerial">Aerial</option>
          </select></td></tr>
          <!--
                <tr><td>Custom API Key: </td><td><input type="text" name="key" value=""> <i>Leave blank to use test key</i></td></tr> 
          -->
          <tr><td colspan="3" align="center"><input type="submit" value="Update Map"></td></tr>
        </table> 
        <input type="hidden" name="screenSize" id="screenSize" style="display:none"/> 
    </form> 
      <p class="center">
        <?php if (isset($museumLink)) { ?>
        <a class="download-link" href="<?php echo $museumLink; ?>">
          <img src="<?php echo $PROTOCOL . "://www.webosarchive.org/app-template/"?>museum-badge.png" width="200" height="59" alt="Get it on Google play" />
        </a>
        <?php } ?>
      </p>
    </div>
    <div id="hero">
    <?php  
    if(isset($useLoc))  
      {  
        if (isset($_POST['key']) && $_POST['key'] != "") {
          $bingKey = $_POST['key'];
        }
  
        if (isset($_POST['maptype'])) {
          $mapType = $_POST['maptype'];
        }
  
        if (isset($_POST['mapsize'])) {
          $mapSize = $_POST['mapsize'];
        }
  
        $mapInfo = getDataForLocation($useLoc, $mapType, $mapSize, ";36", $zoomLevel, $bingKey);
        echo "<p align='middle'><img src='" . $mapInfo->img . "' style='margin: 0 auto; border-radius:2%; -webkit-border-radius:10px '></p>";
        echo "<!--";
        print_r($mapInfo);
        echo "-->";
    }  
    ?> 
    </div>
  </div>
  <div id="footer">
    &copy;  webOSArchive
  </div>
  </td></tr></table>
</body>
</html>
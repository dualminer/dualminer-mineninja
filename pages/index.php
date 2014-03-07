<?php
require("auth.inc.php");
require("config.inc.php");
require("func.inc.php");


$dbh = anubis_db_connect();

$config = get_config_data();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DualMiner - a cgminer web frontend</title>

<?php require('stylesheets.inc.php'); ?>

<script type="text/javascript" src="scripts/jquery.min.js"></script>
<script type="text/javascript" src="scripts/ddsmoothmenu.js">


/***********************************************
* Smooth Navigational Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>
<script type="text/javascript" src="scripts/gauge.min.js"></script>

<script type="text/javascript">

ddsmoothmenu.init({
	mainmenuid: "templatemo_menu", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})


</script>

</head>
<body>

<div id="templatemo_wrapper">


    <div id="templatemo_main">
    	<div class="col_fw">
        	<div class="templatemo_megacontent">
                <div class="cleaner h20">
 

    </div>




<?php include ('header.inc.php'); ?>
    <?php

$cmd="/sbin/ifconfig eth0|grep \"inet addr:\"|awk -F' ' '{print$2}'|awk -F':' '{print$2}'"; 
exec($cmd,$ip); 
exec("hostname",$host);
                     
//echo "Hostname".":".$host[0]." "."ip".":".$ip[0];
?>
   		<script>
	function save() {
		var mydata = "host="+$("#host").val();
		$.ajax({
	         url: "index_server.php",  
	         type: "post",
	         data:mydata,
	         //dataType: "json",
	         error: function(){  
	             alert('Error loading XML document');  
	         },  
	         success: function(data){   
	         	alert(data);
	         }
	     });
	}

</script>
<div id="host-ip"> 
	<table>
		<tr>
			<td>HostName:&emsp;<?= $host[0]?> &emsp; ip: &emsp;<?= $ip[0]?></td>
			<td>hostName: <input type="text" id="host"  value="<?=$host[0]?>"/></td>
		
			<td><button id="modify" onclick="save();">change</button></td>
		</tr>
	</table>
</div>




<?php
$result = $dbh->query("SELECT * FROM hosts");
if ($result)
{
  echo "<table id='hostsum' class='acuity' summary='Hostsummary'>";
  echo create_host_header();

	while ($host_data = $result->fetch(PDO::FETCH_ASSOC))
	{
      $host_alive = get_host_status($host_data);

      echo get_host_summary($host_data);
      if ($host_alive)
      {
        $privileged = get_privileged_status($host_data);
        echo "<tr><td colspan='14'>";
           // Pool summary off for now
#          echo "<table id='poolsum' class='acuity' summary='PoolSummary' align='center'>";
#          echo create_pool_header();
#          echo process_pools_disp($host_data);
#          echo "</table>";
        
          echo "<table id='devsum' class='acuity' summary='DevsSummary' align='center'>";
          echo create_devs_header();
          echo process_devs_disp($host_data);
          echo "</table>";
        echo "</td></tr>";
      }
    }

   echo create_btc_totals();
    echo create_ltc_totals();
 
	echo "</table>";
}
else 
{
	echo "No Hosts found, you might like to <a href=\"addhost.php\">add a host</a> ?<BR>";
}


?>

                <div align=center><a href="addhost.php"><span class="button">Add Host</span></a></div>
                
                
                <div class="cleaner h20"></div>
<!--                 <a href="#" class="more float_r"></a> -->
            </div>

            <div class="cleaner"></div>
		</div>

        <div class="cleaner"></div>
        </div>
    </div>
    
    <div class="cleaner"></div>

<div id="templatemo_footer_wrapper">
    <div id="templatemo_footer">
        <?php include("footer.inc.php"); ?>
        <div class="cleaner"></div>
    </div>
</div> 

<script>
$(function() {
  setInterval(update, 500* <?php echo $config->updatetime ?>);
});
function update() {
	$('#hostsum').load('allgpus.php?id=<?php echo $id?> #hostsum');
	$('#devsum').load('allgpus.php?id=<?php echo $id?> #devsum');
/*	$('#poolsum').load('allgpus.php?id=<?php echo $id?> #poolsum'); */
}
</script>
  
</body>
</html>

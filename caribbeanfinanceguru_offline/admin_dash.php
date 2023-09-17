<?php
/*Database connection*/
require_once(dirname(__FILE__) . '/db_connection/dbconn.php');
//require_once('header.php');
$from_date = "";
$to_date = "";
$queryCondition = "";

if(!empty($_POST["search"]["from_date"])) {
  //$from_date = date('Y-m-d');
  $from_date = $_POST["search"]["from_date"];
  $from_date = strtotime($from_date);
  $from_date = date('Y-m-d',$from_date);
  //$from_date = date('Y-m-d');
  //list($fid,$fim,$fiy) = explode("-",$from_date);


if(!empty($_POST["search"]["to_date"])) {
  //$to_date = date('Y-m-d');
  $to_date = $_POST["search"]["to_date"];
  $to_date = strtotime($to_date);
  $to_date = date('Y-m-d',$to_date);
  //$to_date = date('Y-m-d');
  //list($tid,$tim,$tiy) = explode("-",$_POST["search"]["to_date"]);
  //$to_date = "$tiy-$tim-$tid";
}
//$queryCondition .= " WHERE CONVERT(visit_date,date) BETWEEN CONVERT($from_date,date) AND CONVERT($to_date,date)";
// $queryCondition .= " WHERE visit_date BETWEEN CAST($from_date AS DATETIME)  AND CAST($to_date AS DATETIME) AND visit_ip_addr NOT IN ('')";
$queryCondition .= " WHERE visit_date > $from_date";
}
/*
$date_range_search = $conn->prepare(
  "SELECT distinct(visit_country), visit_date, count(*) AS count
   FROM quiz_visitor
   ". $queryCondition . "
   GROUP BY visit_country,visit_date
   ORDER BY visit_date DESC");
$date_range_search->execute(); //problem here
$date_range_result = $date_range_search->fetchAll(PDO::FETCH_ASSOC);
var_dump($from_date);
var_dump($to_date);
var_dump($date_range_result);
*/

/*Site visitors by location**/
$site_visitor_data = $conn->prepare("SELECT DISTINCT(visit_country),SUM(visit_count) AS count FROM site_visitor GROUP BY visit_country ORDER BY count(*) DESC");
$site_visitor_data->execute();
$site_visitor_list = $site_visitor_data->fetchAll(PDO::FETCH_ASSOC);
?>
<head>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="admin.css">
<style>
.table-content{border-top:#CCCCCC 4px solid; width:50%;}
.table-content th {padding:5px 20px; background: #F0F0F0;vertical-align:top;}
.table-content td {padding:5px 20px; border-bottom: #F0F0F0 1px solid;vertical-align:top;}
</style>
</head>


<body>
<div class="stat_table">
<?php
//Site Demographic header
echo "<h2>Unique Country Visitor Stats</h2>";
echo "<table style='border: 1px solid black; width: 40%;'>";
foreach($site_visitor_list as $row => $demographic){
  echo "<tr class='border_bottom'><td>" .$demographic['visit_country'].
       "</td><td>" .$demographic['count']. "</td></tr>";
}
echo "</table>";
?>
</div>
<div class="stat_table">
<?php
//unique quiz visitor
$quiz_visitor_data = $conn->prepare(
  "SELECT distinct(visit_ip_addr),visit_country, sum(visit_count) as visit_count
  FROM quiz_visitor WHERE visit_ip_addr NOT IN ('')
  GROUP BY visit_ip_addr, visit_country
  ORDER BY visit_count DESC" );
$quiz_visitor_data->execute();
$quiz_visitor_list = $quiz_visitor_data->fetchAll(PDO::FETCH_ASSOC);

//Site Demographic header
echo "<h2>Quiz Taker Stats</h2>";
echo "<table style='border: 1px solid black; width: 40%;'>";
foreach($quiz_visitor_list as $row => $demographic){
  echo "<tr class='border_bottom'><td>" . $demographic['visit_ip_addr'].
       "</td><td>" .$demographic['visit_country'].
       "</td><td>" .$demographic['visit_count']. "</td></tr>";
}
echo "</table>";
?>

    <div class="demo-content">
		<h3 class="title_with_link">Custom Date Range Search</h3>
  <form action="" method="post" >
	 <p class="search_input">
		  <input type="text" placeholder="From Date" id="from_date" name="search[from_date]"  value="<?php echo $from_date; ?>" class="input-control" />
	    <input type="text" placeholder="To Date" id="to_date" name="search[to_date]" style="margin-left:10px"  value="<?php echo $to_date; ?>" class="input-control"  />
		<input type="submit" name="go" value="Search" >
	</p>

<?php if(!empty($date_range_result))	 { ?>
<table class="table-content">
          <thead>
        <tr>

          <th width="30%"><span>visit_country</span></th>
          <th width="50%"><span>Visits</span></th>
        </tr>
      </thead>
    <tbody>
	<?php
   foreach($date_range_result as $row => $demographic){
	?>
        <tr>
			<td><?php echo $demographic["visit_country"]; ?></td>
			<td><?php echo $demographic["count"]; ?></td>
      <td><?php echo $demographic["visit_date"]; ?></td>
		</tr>
   <?php
		}
   ?>
 <tbody>
  </table>
<?php } ?>
</form>
</div>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script>
$.datepicker.setDefaults({
showOn: "button",
buttonImage: "datepicker.png",
buttonText: "Date Picker",
buttonImageOnly: true,
dateFormat: 'dd-mm-yy'
});
$(function() {
$("#post_at").datepicker();
$("#post_at_to_date").datepicker();
});
</script>
</body>
<?php $conn = null;?>

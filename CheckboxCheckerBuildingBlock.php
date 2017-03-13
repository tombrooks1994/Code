<?php
include_once('global_config.php');
include "functions/include_fns.php";

$page_title = "Welcome";
$description = "";
$kewords = "";

show_header($page_title, $description, $keywords);


echo 'Tester: '; print_r($_POST);
error_reporting(-1);
$servername = "";
$username = "";
$password = "";
$dbname= "";
print_r($_POST);
print_r($_SESSION);

	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = '
SELECT id, name, franchise_id
FROM
solicitors
WHERE 
(
 id IN (SELECT solicitor_id_parent FROM solicitors_link)
 OR
 id NOT IN (SELECT solicitor_id_child FROM solicitors_link)
)
AND solicitors.type="solicitor" AND franchise_id=""
ORDER BY name
';

$res = $conn->query($sql);

//print_r($res);
?>

<script type="text/javascript">
function DeleteRowFunction(o) {
    //no clue what to put here?
    var p=o.parentNode.parentNode;
        p.parentNode.removeChild(p);
   }
</script>
<style>
body {font-family:arial;}
.deleteLink {color:white;background:#22a4fa;border:2px solid red; padding:2px;margin-bottom:10px;}
.deleteLink:hover {color:white;background:#22a4fa;border:2px solid blue; padding:2px;margin-bottom:10px;}
</style>
<form action="sdltuser.php" method="post" id="sdlt_table">
<table id="favoriteFoodTable">
<?php foreach ($res as $i => $item) { echo '
<tr><td style="margin-top:5px;" id="'.$i.'name">'.$item['name'].'</td>
<td style="margin-top:5px;" id="'.$i.'type">'.$item['type'].'</td>
<td style="margin-top:5px;" id="'.$i.'checked"><input id="checkbox" type="checkbox" name="checkbox[]" value="'.$item['id'].'"/></td>
<td style="margin-top:5px;"><a class="deleteLink" name="check" type="button" onclick="DeleteRowFunction(this)" style="">Remove</a></td></tr>
';
}
//print_r($_POST);
?>
</table>
<input type="submit" value="submit"/>
</form>

<?php
	
	$servername = "";
	$username = "";
	$password = "";
	$dbname= "";
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	foreach ($_POST['checkbox'] as $checkbox){
	$sql2 = 'UPDATE
		solicitors
		SET checked = 1
		WHERE id = "'.$checkbox.'"
		;';
	}
	
	$row = $conn->query($sql2);
	
	print_r($_POST['checkbox']);
	
	show_footer();

<script type="text/javascript">
<!--//<![CDATA[
function dynamicSelect(id1, id2) {
	if (document.getElementById && document.getElementsByTagName) {
		var sel1 = document.getElementById(id1);
		var sel2 = document.getElementById(id2);
		var clone = sel2.cloneNode(true);
		var clonedOptions = clone.getElementsByTagName("option");
		refreshDynamicSelectOptions(sel1, sel2, clonedOptions);
		sel1.onchange = function() {
			refreshDynamicSelectOptions(sel1, sel2, clonedOptions);
			$('#hide').show();
			refresh_comp_list();
			}
		sel2.onchange = function() {			
			$('#hide2').show();
			$('#hide3').show();
		}
	}
}

function refreshDynamicSelectOptions(sel1, sel2, clonedOptions) {
	while (sel2.options.length) {
		sel2.remove(0);
	}
	var pattern1 = /( |^)(select)( |$)/;
	var pattern2 = new RegExp("( |^)(" + sel1.options[sel1.selectedIndex].value + ")( |$)");
	var pattern3 =/( |^)(show_option)( |$)/;
	for (var i = 0; i < clonedOptions.length; i++) {
		if (clonedOptions[i].className.match(pattern3) ||clonedOptions[i].className.match(pattern1) || clonedOptions[i].className.match(pattern2) ) {
				sel2.appendChild(clonedOptions[i].cloneNode(true));
			
		}
	 }
}

window.onload = function() {
	dynamicSelect("list_otdel", "list_comp");
	<?php 	if (!isset($_GET["list_comp"])){ ?>
	$('#hide').hide();
	$('#hide2').hide();	
	<?php }	?>
}
//]]>-->
</script>
<?php
if (($_GET[list_comp])=="info") 
{require("../include/connect.php");} 
else {require_once("include/connect.php");}
$result =  mysql_query("SELECT DISTINCT otdel From computers;");
$result2 = mysql_query("SELECT otdel,computer_name From computers;");	
?>
	
<form id="comp_delete" method="GET">
	<select name='list_otdel' id="list_otdel" <?php if ($_GET["content"]=="menu") {?>onfocus="refresh_otdel_list()"<?php }?>>
		<option  selected disabled >Выберите подразделение</option>
		<?php	while($row = mysql_fetch_array($result)) {
		echo "<option value='".$row['otdel']."'  ".((($_GET['list_otdel'])&&($_GET['list_otdel']==$row['otdel']))?" selected":"")."> ".$row['otdel']."</option>";
		}	?>	
	</select>

	<span id="hide">
		<select name='list_comp' id="list_comp">
			<option  class="show_option" selected disabled >Выберите компьютер</option>
			<?php	while($row = mysql_fetch_array($result2))
			{
			echo "<option class='".$row['otdel']."' value='".$row['computer_name']."' ".((($_GET['list_comp'])&&($_GET['list_comp']==$row['computer_name']))?" selected":"").">".$row['computer_name']."</option>";
			}	?>	
		</select>
	</span>
<input type="hidden" name="content" value=<?php echo $_GET["content"]; ?>> 
<input type="hidden" name="option" value=<?php echo $_GET["option"]; ?>> 
<?php echo '<input type="hidden" name="URL" value="'.$_SERVER["HTTP_HOST"].''.$_SERVER['REQUEST_URI'].'" />' ?>
<?php if ($_GET["content"]<>"menu" OR $k=="info") {?>
			<input id="hide2" type="submit" class="inputSubmit" value="Показать" name="Show"> 
<?php } else { ?>
			<div id="hide2" class="inputSubmit but_delete" name="Delete" onclick="delete_comp_button()"> Удалить</div>
<?php } ?>
</form>
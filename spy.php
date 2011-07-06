<?php 
require_once("include/connect.php");
echo "<table align=center border=1 cellpadding=2 cellspacing=0>";
echo "<tr>
<td>Дата</td>
<td>Кто</td>
<td>Что</td>
<td>Что</td>
<td>Как</td>
<td>Как</td>
<td>Как</td>
</tr>";

$query = mysql_query("select * from `Spy`") or die (mysql_error());
while ($query2=mysql_fetch_array($query)){
echo "<tr>";
echo "<td>";
echo $query2["Date"];
echo "</td>";
echo "<td>";
echo $query2["Name_User"];
echo "</td>";
echo "<td>";
echo $query2["User_comp"];
echo "</td>";
echo "<td>";
echo $query2["Comp_record"];
echo "</td>";
echo "<td>";
echo $query2["Action"];
echo "</td>";
echo "<td>";
echo $query2["f_Table"];
echo "</td>";
echo "<td>";
echo $query2["f_Record"];
echo "</td>";
echo "</tr>";

}
echo "</table>";
?>

<?php 

    $fso = new COM('Scripting.FileSystemObject'); 
    $D = $fso->Drives; 
    $type = array("Unknown","Removable","Fixed","Network","CD-ROM","RAM Disk"); 
    foreach($D as $d ){ 
       $dO = $fso->GetDrive($d); 
       $s = ""; 
       if($dO->DriveType == 3){ 
           $n = $dO->Sharename; 
       }else if($dO->IsReady){ 
           $n = $dO->VolumeName; 
           $s = file_size($dO->FreeSpace) . " free of: " . file_size($dO->TotalSize); 
       }else{ 
           $n = "[Drive not ready]"; 
       } 
   echo "Drive " . $dO->DriveLetter . ": - " . $type[$dO->DriveType] . " - " . $n . " - " . $s . "<br>"; 

    } 
    
      function file_size($size) 
      { 
      $filesizename = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB"); 
      return $size ? round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $filesizename[$i] : '0 Bytes'; 
      } 

?> 
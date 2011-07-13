<title> Harvester </title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<meta charset="UTF-8">
<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script> 
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/nav.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.13.custom.min.js"></script>

<script type="text/javascript">
<!--//<![CDATA[
$(document).ready( function () {
				var oTable = $('#example').dataTable( {
					<?php if ( $_GET['content']<>"Service" && $_GET['content']<>"Process") { ?>
					"fnDrawCallback": function ( oSettings ) {
						if ( oSettings.aiDisplay.length == 0 )
						{
						return;
						}

						var nTrs = $('#example tbody tr');
						var iColspan = nTrs[0].getElementsByTagName('td').length;
						var sLastGroup = "";
						for ( var i=0 ; i<nTrs.length ; i++ )
						{
							var iDisplayIndex = oSettings._iDisplayStart + i;
							var sGroup = oSettings.aoData[ oSettings.aiDisplay[iDisplayIndex] ]._aData[0];
							if ( sGroup != sLastGroup )
							{
								var nGroup = document.createElement( 'tr' );
								var nCell = document.createElement( 'td' );
								nCell.colSpan = iColspan;
								nCell.className = "group";
								nCell.innerHTML = sGroup;
								nGroup.appendChild( nCell );
								nTrs[i].parentNode.insertBefore( nGroup, nTrs[i] );
								sLastGroup = sGroup;
						}
					}
					},					
					"aoColumnDefs": [
					{ "bVisible": false, "aTargets": [ 0 ] }
					],
					
					"aaSortingFixed": [[ 0, 'asc' ]],
					"aaSorting": [[ 1, 'asc' ]],
					<?php } ?>
					"sPaginationType": "full_numbers",
					"sDom": 'C <Rlfrtip>'			
				} );
			} );		
			//]]>-->
</script> 
<style type="text/css" title="currentStyle"> 
@import "css/demo_table.css";
@import "css/ColReorder.css";
@import "css/ColVis.css";
@import "css/main.css";
</style> 
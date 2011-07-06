$.ajaxSetup ({
// Disable caching of AJAX responses */
cache: false
});
function message_window (text) {
 window_mes.innerHTML=text;
 $(".window").show(500);
 $('.window').click(function () {		
		$('.window').hide(400);		
		return false;
	});
}

var id_num=1;
function modal_show(content,title) {
$('body').append("<div id="+id_num+" class='modal"+id_num+" modal'></div>");
$('.modal'+id_num).append("<div class=title_modal><div class=title_text>"+title+"</div><a href=# class=title_modal_icon id=close_a onClick=\"javascript:  $('.modal"+id_num+"').remove();\"></a></div><div id=modal_window class=window2>"+content+"</div>");
var maskHeight = $(document).height();  
var maskWidth = $(document).width()-960;
var dialogTop = 80;  
var dialogLeft = (maskWidth/2); 
$('.modal'+id_num).css({width:960}).show();
$('.modal'+id_num).css({top:dialogTop, left:dialogLeft,margin:0,padding:0}).show();	
$('#modal_window').css({margin:15}).show();	
$('.modal'+id_num).draggable({handle:'.title_modal',zIndex:2700,stack: '.modal'+id_num}); 
id_num+=1;
}

function create_comp_button() {
var str = $(comp_create).serialize()
$("#loading").show();
$('#sm').hide();	
$.ajax({
	type: "POST",
	url: "include/checks.php",
	data: str+"&Create=1",
	success: function(msg){
		$("#loading").hide();
		message_window(msg);
		if (msg!="Учётная запись создана.") {
			sm.className="message_error";
		} else {
			sm.className="message";
			comp_name.value='';
			ip_adr.value='';
			otdel.value='';
			refresh_otdel_list();
		}
	}	
});
}

function refresh_comp_list() {
var sel_opt=$("select#list_otdel").val();
$.ajax({
	type: "GET",
	url: "include/checks.php",
	data: "Refresh=2&otdel="+sel_opt,
	dataType: "json",
	success: function (data) {
		$('#list_comp').find('option').remove() .end()
		$('#list_comp').append($("<option disabled></option>").text("Выберите компьютер")); 
        $.each(data, function(num,val) {
				$('#list_comp').
				append($("<option></option>").
				attr("value",val).
				text(val)); 
        });
    }  
});
}

function refresh_otdel_list() {
$.ajax({
	type: "GET",
	url: "include/checks.php",
	data: "Refresh=1",
	dataType: "json",
	success: function (data) {
		refresh_comp_list();		
		$('#list_otdel').find('option').remove() .end()
		$('#list_otdel').append($("<option disabled></option>").text("Выберите подразделение")); 
        $.each(data, function(num,val) {
				$('#list_otdel').
				append($("<option></option>").
				attr("value",val).
				text(val));
				$('#list_comp').show()	
        });		
    }  
});
}

function delete_comp_button() {
var str = $(comp_delete).serialize()
$("#loading").show();
$.ajax({
	type: "GET",
	url: "include/checks.php",
	data: str+"&Delete=1",
	success: function(msg){
		$("#loading").hide();
		message_window(msg);
		if (msg!="Учётная запись удалена") {
			sm.className="message_error";
		} else {
			refresh_otdel_list();
			sm.className="message";	
			$('#hide').hide();
			$('#hide2').hide();	
			$("#list_otdel :nth-child(1)").attr("selected", "selected");
		}		
	}  
});
}

function reboot_comp_button() {
var ip=$(management_form).serialize()
$("#loading").show();
$.ajax({
	type: "GET",
	url: "include/Shutdown.php",
	data: ip+"&Reboot=1",
	success: function(msg) {
		$("#loading").hide();
		message_window(msg);	
	}
});
}

function shutdown_comp_button() {
var ip=$(management_form).serialize()
$("#loading").show();
$.ajax({
	type: "GET",
	url: "include/Shutdown.php",
	data: ip+"&Shutdown=1",
	success: function(msg) {
		$("#loading").hide();
		message_window(msg);	
	}	
});
}

function service_button () {
	var ip=$(management_form).serialize()
	$("#loading").show();
	$.ajax({
		type: "GET",
		url: "include/service_show.php",
		data: ip+"&service_refresh=1",
		datatype: "html",
		success: function(msg) {
			$("#loading").hide();
			if (msg=="IP не указан" || msg=="Неправильный формат IP" ) {
				message_window(msg);	
			}
			else {
				modal_show(msg,"Диспетчер служб "+ip);
				$(document).ready( function () {
						var oTable = $('#example').dataTable( {
							"sPaginationType": "full_numbers",
							"sDom": 'C <Rlfrtip>'			
						} );						
				}); 
			}
		}	
	});
}

function service_do_button (text) {
	var ip=$(service_form).serialize()
	$("#loading").show();
	$.ajax({
		type: "GET",
		url: "include/service_query.php",
		data: ip+"&service_do=1&"+text+"=1",
		datatype: "html",
		success: function(msg) {
			if (msg=="IP не указан" || msg=="Неправильный формат IP" || msg=="Имя службы не указано" ) {
				message_window(msg);
				$("#loading").hide();				
			}
			else {
				$.ajax({
					type: "GET",
					url: "include/service_show.php",
					data: ip+"&service_refresh=1&",
					datatype: "html",
					success: function(msg2) {
						$("#loading").hide();
						if (msg2=="IP не указан" || msg2=="Неправильный формат IP") {
							message_window(msg2);	
						}
						else {
							modal_show(msg2,"Диспетчер служб "+ip);
							$(document).ready( function () {
									var oTable = $('#example').dataTable( {
										"sPaginationType": "full_numbers",
										"sDom": 'C <Rlfrtip>'			
									} );						
							}); 
						}
					} 				
				});
				message_window(msg);
			}
		} 				
	});
	
}

function process_button () {
	var ip=$(management_form).serialize()
	$("#loading").show();
	$.ajax({
		type: "GET",
		url: "include/Process_show.php",
		data: ip+"&process=1",
		datatype: "html",
		success: function(msg) {
			$("#loading").hide();
			if (msg=="IP не указан" || msg=="Неправильный формат IP" ) {
				message_window(msg);	
			}
			else {
				modal_show(msg,"Диспетчер процессов "+ip);
				$(document).ready( function () {
						var oTable = $('#example').dataTable( {
							"sPaginationType": "full_numbers",
							"sDom": 'C <Rlfrtip>'			
						} );						
				}); 
			}
		}	
	});
}

function process_do_button (text,process_processid) {
	var ip_process=$(process_form).serialize()
	$("#loading").show();
	$.ajax({
		type: "GET",
		url: "include/Process_query.php",
		data: ip_process+"&process_do=1&"+text+"=1&process_processid="+process_processid,
		datatype: "html",
		success: function(msg) {
			if (msg=="IP не указан" || msg=="Неправильный формат IP" || msg=="Имя процесса не указано" ) {
				message_window(msg);
				$("#loading").hide();				
			}
			else {
				$.ajax({
					type: "GET",
					url: "include/Process_show.php",
					data: ip_process+"&process=1",
					datatype: "html",
					success: function(msg2) {
						$("#loading").hide();
						if (msg2=="IP не указан" || msg2=="Неправильный формат IP") {
							message_window(msg2);	
						}
						else {
							modal_show(msg2,"Диспетчер процессов "+ip_process);
							$(document).ready( function () {
									var oTable = $('#example').dataTable( {
										"sPaginationType": "full_numbers",
										"sDom": 'C <Rlfrtip>'			
									} );						
							}); 
						}
					} 				
				});
				message_window(msg);
			}
		} 				
	});
	
}

function share_button () {
	var ip=$(management_form).serialize()
	$("#loading").show();
	$.ajax({
		type: "GET",
		url: "include/share.php",
		data: ip+"&share_view=1",
		datatype: "html",
		success: function(msg) {
			$("#loading").hide();
			if (msg=="Неправильный формат IP" ) {
				message_window(msg);	
			}
			else {
				modal_show(msg,"Общий доступ - "+ip);				
			}
		}	
	});
}

function share_do_button (share_name,ip) {
	$("#loading").show();
	$.ajax({
		type: "GET",
		url: "include/share.php",
		data: "share_view=1&disable=1&ip="+ip+"&share_name="+share_name,
		datatype: "html",
		success: function(msg) {
			if (msg=="Путь не указан" || msg=="Неправильный формат IP" ) {
				message_window(msg);
				$("#loading").hide();
			}
			else {
				message_window(msg);
				$.ajax({
					type: "GET",
					url: "include/share.php",
					data: "share_view=1&ip="+ip,
					datatype: "html",
					success: function(msg) {
						$("#loading").hide();
						if (msg=="Неправильный формат IP" ) {
							message_window(msg);	
						}
						else {
							$("#"+id_num).remove();
							modal_show(msg,"Общий доступ - "+ip);				
						}
					}	
				});
			}
		}	
	});
}


function online_button(val) {
	$("#loading").show();
	$.ajax({
		type: "GET",
		data: "online="+val,
		url: "include/online.php",
		datatype: "html",
		success: function(msg) {
			$("#loading").hide();
			modal_show(msg,"Выберите компьютер");		
		}	
	});
}

function show_computer_button(name_comp,Last_Updated) {
	$("#loading").show();
	var id_modal=id_num;
	$.ajax({
		type: "GET",
		data: "list_comp="+name_comp+"&id_modal="+id_modal,
		url: "page/edit.php",
		success: function(msg) {
			$("#loading").hide();
			modal_show(msg,"Информация о "+name_comp+", последниее обновление "+Last_Updated);
		}	
	});
}

function scan_comp_wmi(mas_comp) {
	var status_obj = document.getElementById(mas_comp);
	message_window("Подключение к "+mas_comp);
	$("#loading").show();
	$.ajax({
		type: "POST",
		data: "name_comp="+mas_comp,
		url: "include/access_ch.php",
		datatype: "html",
		success: function(msg) {				
			if (msg=="Connect") {
				message_window("Сбор сведений об "+mas_comp);
				$.ajax({
					type: "GET",
					data: "wmi=1&list_comp="+mas_comp,
					url: "page/edit.php",
					datatype: "html",
					success: function(msg) {
						$("#loading").hide();
						modal_show(msg,"Обновлённая информация о "+mas_comp);
						message_window("Данные успешно получены");
					}	
				});
			} else {
				message_window("Невозможно подключится к "+mas_comp)
				$("#loading").hide();				
			}
		}
    });
}

function refresh_wmi_button(name_comp, id_modal) {
	$("#loading").show();
	$('.modal'+(id_modal)).remove();
	$.ajax({
		type: "GET",
		data: "wmi=1&list_comp="+name_comp,
		url: "page/edit.php",
		datatype: "html",
		success: function(msg) {
			$("#loading").hide();
			modal_show(msg,"Обновлённая информация о "+name_comp);		
		}	
	});
}

function save_comp_edit_button(name_comp,notmsg) {
	var form_data=$(data_comp).serialize()
	if (!notmsg) {$("#loading").show();}
	$.ajax({
		type: "POST",
		data: form_data+"&save_changes=1&list_comp="+name_comp,
		url: "page/edit.php",
		datatype: "html",
		success: function(msg) {
			if (!notmsg) {
			$("#loading").hide();
			message_window(msg);
			}
		}	
	});
}



function scan_group_show() {
$('.online_scan').show();
}


function scan_group_wmi(mas_group) {
	
	$("#loading").show();
	var streams = 10;
	var mas=eval(mas_group)
	
	var finishCount = 0;
    finishCallback = function(){$("#loading").hide();}
	
	function go(){         
   		if(mas.length) {
		$("#loading").show();
		var elem=mas.shift()
		var status_obj = document.getElementById(elem);
		status_obj.innerHTML="Подключение к "+elem;
		$.ajax({
				type: "POST",
				data: "name_comp="+elem,
				url: "include/access_ch.php",
				datatype: "html",
				success: function(msg) {				
					if (msg=="Connect") {
						status_obj.innerHTML="Сбор сведений об "+elem;
						$.ajax({
							type: "GET",
							data: "wmi=1&list_comp="+elem,
							url: "page/edit.php",
							datatype: "html",
							success: function(msg) {
								$("#loading").hide();									
								modal_show(msg,"Обновлённая информация о "+elem);
								$('.modal'+(id_num-1)).hide();
								save_comp_edit_button(elem,'nomsg') 
								status_obj.innerHTML=("Сохранено "+elem)
								$('.modal'+(id_num-1)).remove();
								$('.'+elem).css({color: 'green'}).show();
							}	
						});
					} else {
						status_obj.innerHTML=("Невозможно подключится к "+elem)
						$('.'+elem).css({color: 'red'}).show();
					}
				}
		});
		go();
		}
         
        else {
            finishCount++;
            if(finishCount==streams) {finishCallback();}
        }
    }   
         
    for (i=0; i<streams; i++) {
        go();
    }	
}
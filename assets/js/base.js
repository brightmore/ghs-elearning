var apiUrl = "http://localhost:3001/";


$(function (){

	$('.subnavbar').find ('li').each (function (i) {
	
		var mod = i % 3;
		
		if (mod === 2) {
			$(this).addClass ('subnavbar-open-right');
		}
	});
});

   $(function (){
   	
   	$('#send').on('click',function(event){
   		event.preventDefault();
   		var title = $('#title').val();
   		var message = $("#message").val();
   		var start_date = $("#startDate").val();
   		var end_date = $("#endDate").val();
   		var endTime = $("#endTime").val();
   		var startTime = $("#startTime").val();
   		
   		var areas = [];
   	//	var areas = $('.area:checked');
   		$('.area:checked').each(function() {
   		    areas.push($(this).attr("value"));
   		});
   			
   		var data = {
   				"title":title,
   				"message_body":message,
   				"start_date":start_date,
   				"end_date":end_date,
   				"startTime":startTime,
   				"endTime":endTime,
   				"mediaType":"text",
   				"date_added":new Date().getTime(),
   				"message_id":"msg-"+new Date().getTime(),
   				"areas":areas
   		}
   		
   		socket.emit("send message",{data:"----ok---"});
   		console.log(areas);
   		console.log(end_date);
   		alert(JSON.stringify(data));
   		return;
   		
   		$.ajax({
   		    url: 'http://localhost:3000/postMessages',
   		    type: 'POST',
                    dataType : "json",
   		    data: data
   		});
   		//push.publish(data);
   	});
   	
   }); 
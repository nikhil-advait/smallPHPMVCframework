$(document).ready(function(){
	console.log("ready");
	$(".delete_form").submit(function(){
		console.log(".delete-form clicked");
		var bool = confirm("Are you sure you want to delete?");
		if(bool){

		}else{
			return false;
		}
	});

	$("#trialNewAjax").click(function() {
		/*alert($('#edit_post_12').serializeArray());*/
		$.ajax({
			type: 'POST',
			data:  /*{name: 'nikhil', city: 'pune'},*//*'name=nikhil&email=yeole',*/ $('#new_post').serialize(),
			url: "/mvc/posts",
			success: function(data){
				$('html').html(data);
			}
		});
	});

	$("#trialPutAjax").click(function() {
		/*alert($('#edit_post_12').serializeArray());*/
		$.ajax({
			type: 'PUT',
			data:  /*{name: 'nikhil', city: 'pune'},*//*'name=nikhil&email=yeole',*/ $('#edit_post').serialize(),
			url: "/mvc/posts/2",
			success: function(data){
				$('body').html(data);
			}
		});	
	});	


	$("#trialDeleteAjax").click(function() {
		alert("delete");
		$.ajax({
			type: 'DELETE',
			url: "/mvc/posts/2",
			success: function(data){
				$('body').html(data);
			}
		});
	});


	$("#goBack").click(function(){
		$('html').load("/mvc/posts");
	});
});
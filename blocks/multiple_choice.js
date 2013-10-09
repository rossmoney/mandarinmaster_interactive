$(function() {
	$(".choice").click(function(){
		var choiceCount = $('#mc' + $(this).parent().attr('mcSnippetBlock') + '_' + $(this).parent().attr('insID')).attr('choiceCount');
		for(var i = 1; i <= choiceCount; i++)
		{
			$('#choice' + i).css('border', '2px orange solid');
		}
		var id = $(this).attr('id');
		$('#answer').load("includes/process.php?process=checkMultiChoiceAnswer&choice=" + $(this).attr('choice') + 
			'&mcBlock=' + $(this).parent().attr('mcSnippetBlock') , function() {
	  		if($('#answer').html() == 'correct')
	  		{
	  			$('#' + id).css('border', '2px green solid');
	  			inProgress = false;
	  			if((attempts + 1) < choiceCount) allocateActivityPoints(1, choiceCount, attempts);
	  			alert('You are correct!');
	  			nextLevel();
	  		} else {
	  			$('#' + id).css('border', '2px red solid');
	  			if(attempts < choiceCount) attempts++;
	  		}
		} );
	});
});
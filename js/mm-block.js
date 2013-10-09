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
function translatorUpdateLevel() {
	inProgress = false;
	currentLevelPoints = currentLevelPoints + pointsPerLevel[curLevel-1][curSubLevel-1];
}

$(function() {
	$(".trans_input").click(function() {
		if($(".trans_input").val() == 'Enter your name here')
		{
			$(".trans_input").val('');
		}
	});
	$(".trans_input").focusout(function() {
		if($(".trans_input").val() == '')
		{
			$(".trans_input").val('Enter your name here');
		}
	});
	$(".trans_input").keypress(function( e ) {
		var code = (e.keyCode ? e.keyCode : e.which);
	 	if(code == 13) { //Enter keycode
	   		$(".trans_convert").trigger('click');
	 	}
	});
	$(".trans_convert").click(function() {
		var json = $('#' + $(this).attr('sb') + '_' + $(this).attr('insID') + 'trans_vocab').html();
		var vocab = jQuery.parseJSON(json);
		var found = false;
		for(var i = 0; i < vocab.english.length; i++)
		{
			//alert($('#' + $(this).attr('sb') + '_' + $(this).attr('insID') + 'trans_input').val().toLowerCase() + '_' + vocab.english[i].toLowerCase());

			if(vocab.english[i].toLowerCase()  == $('#' + $(this).attr('sb') + '_' + $(this).attr('insID') + 'trans_input').val().toLowerCase() )
			{
				$('#' + $(this).attr('sb') + '_' + $(this).attr('insID') + 'pronoun').html(vocab.pinyin[i]);
				$('#' + $(this).attr('sb') + '_' + $(this).attr('insID') + 'chinese').html(vocab.chinese[i]);
				$('#sb_file2_0').attr('href', "sounds/dict/" + vocab.dict_name + "/" + vocab.english[i].toLowerCase() + ".mp3" );
				found = true;
			}
		}
		if(!found)
		{
			alert('Your name was not found, sorry!');
		}
		try{
    		if(framework) translatorUpdateLevel();
  		}catch(e){
  		}
	});
});

$(function() {
    $( ".dragdrop" ).draggable();
    $( ".dropslot" ).droppable({
      drop: function( event, ui ) {
      	var found = false;
      	if($(this).attr('word') == ui.draggable.attr('word'))
      	{
      		found = true;
      	}
      	if(found)
      	{
      		$( this ).css('background-color', 'green');
      		ui.draggable.css('background-color', 'green');
      		$( this ).html(ui.draggable.html());
      		ui.draggable.hide();
      		var correct = 0;
      		for(i = 0; i < ui.draggable.attr('count'); i++)
      		{
      			if($('#' + ui.draggable.attr('sBlock') + '_' + i + 'dragdrop').css('background-color') == 'rgb(0, 128, 0)')
      			{
      				correct++;
      			}
      		}
      		if(correct == ui.draggable.attr('count'))
      		{
      			if((attempts + 1) < ui.draggable.attr('count')) allocateActivityPoints(1, ui.draggable.attr('count'), attempts);
                        alert('You got them all correct!');
                        inProgress = false;
                        nextLevel();
      		}
      	} else {
                  if(attempts < ui.draggable.attr('count')) attempts++;
            }
      }
    });
 });
var correctQuestions = [];
var questionAttempts = [];
var clicked = false;
$(function() {
	$('.answer').click(function() {
		var questionDiv = $('#question' + $(this).attr('sb') + '_' + $(this).attr('questionNum'));
		var questionNum = $(this).attr('questionNum');
		var answerNum = $(this).attr('answerNum');
		var answerCount = questionDiv.attr('answerCount');
		if(!clicked)
		{
			questionAttempts = [];
			for(i = 0; i < questionDiv.attr('questionCount'); i++)
			{
				questionAttempts[i] = 0;
			}
			clicked = true;
		}
		for(var i = 0; i < questionDiv.attr('answerCount'); i++)
		{
			$('#answer' + $(this).attr('sb') + '_' + $(this).attr('questionNum') + '_' + i).css('border', 'none');
		}
		var id = $(this);
		$('#qs_answer').load("includes/process.php?process=checkQuestionAnswer&answer=" + answerNum + 
			'&qsBlock=' + $(this).attr('sb') + '&qsNum=' + questionNum, function() {
	  		if($('#qs_answer').html() == 'correct')
	  		{
	  			$(id).css('border', '2px green solid');
	  			var alreadyAnswered = false;
	  			for(var i = 0; i < correctQuestions.length; i++)
	  			{
	  				if(correctQuestions[i] == questionNum) alreadyAnswered = true;
	  			}
	  			if(!alreadyAnswered) correctQuestions.push(questionNum);
	  			var questionCount = questionDiv.attr('questionCount');
	  			if(correctQuestions.length == questionCount)
	  			{
	  				var displayMsg = false;
	  				for(var i = 0; i < questionCount; i++)
	  				{
	  					var qsDiv = $('#question' + $(id).attr('sb') + '_' + i);
	  					if((questionAttempts[i] + 1) < qsDiv.attr('answerCount') ) 
	  					{
	  						allocateActivityPoints( qsDiv.attr('questionCount'), qsDiv.attr('answerCount')  , questionAttempts[i]);
	  						displayMsg =true;
	  					} 
	  				}
	  				if(displayMsg) alert('All correct! Well done!');
	  				questionAttempts = [];
	  				correctQuestions = [];
	  				inProgress = false;
	  				nextLevel();
	  			}
	  		} else {
	  			$(id).css('border', '2px red solid');
	  			if(questionAttempts[questionNum] < answerCount ) 
	  			{
	  				questionAttempts[questionNum]++;
	  			}
	  			for(var i = 0; i < correctQuestions.length; i++)
	  			{
	  				if(correctQuestions[i] == questionNum) correctQuestions.splice(i, 1);
	  			}
	  			inProgress = true;
	  		}
		} );
	});
});
function getRandomInt (min, max) {
    var int = Math.floor(Math.random() * (max - min + 1)) + min;
    if((startingTotal - int) < 0 )
    {
    	int = getRandomInt(min, max);
	}
	return int;
}

$(function() {
	$('.randomizer-button').click(function() {
		attempts++;
		var rand = getRandomInt(1, 10);

		for(var i = 1; i <= 10; i++)
		{
			$('#randomizer1_' + i).hide();
		}
		$('#randomizer1_' + rand).show();

		rand_bowlingGame(1, rand);
	});
});

var startingTotal = 10;
var completions = 0;
var scores = [];

function rand_bowlingGame(block_id, rand) {
	if($('#randomizer' + block_id + '_' + rand).find('.audioButton').attr('href') != undefined)
	{
		$('#randomizer' + block_id + '_' + rand).find('.audioButton').trigger('click');
	}
	scores.push(rand);
	startingTotal = startingTotal - rand;
	$('#bowling_score').html('Pins left: ' + startingTotal );
	$('#randomizer_button_' + block_id).html('Roll the ball!');
	if(startingTotal == 0) 
	{
		completions++;
		inProgress = false;
		startingTotal = 10;
		$('#randomizer_button_' + block_id).html('Play again?');
		if(completions == 1)
		{
			if(attempts == 1)
			{
				currentLevelPoints = currentLevelPoints + pointsPerLevel[curLevel-1][curSubLevel-1];
				$('#current-points').html('Current Level Points: ' + currentLevelPoints);
				alert('You got a strike! You have been rewarded maximum level points!');
			} else {
				currentLevelPoints = currentLevelPoints + scores[0];
				$('#current-points').html('Current Level Points: ' + currentLevelPoints);
				alert('You have been rewarded your first score of ' + scores[0] + '!');
			}
		}
		alert('Thankyou for playing! Play again? Subsequent plays don\'t add to your score, but the practice is good!');
	}
}


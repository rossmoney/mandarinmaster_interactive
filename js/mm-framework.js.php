<?php
header("content-type: application/javascript");
chdir("..");
require("includes/bootstrap.php");
bootstrap();
?>

var curLevel = 1;
var curSubLevel = 1;
var oldSubLevel = 1;
var inProgress = false;
var currentLevelPoints = 0;
var attempts = 0;
var framework = true;
<?php
	echo 'var maxSubLevels = [';
	for($i = 0; $i < $_SESSION['level_setup']['total_levels']; $i++)
	{
		echo "'" . $_SESSION['level_setup']['level_structure'][$i] . "'";
		if($i != ($_SESSION['level_setup']['total_levels'] - 1)) echo ',';
	}
	echo '];';
	echo 'var subLevelNeedsCompletion = [];' . "\n";
	for($i = 0; $i < $_SESSION['level_setup']['total_levels']; $i++)
	{
		echo 'subLevelNeedsCompletion[' . $i . '] = [];' . "\n";
		for($i2 = 0; $i2 < count($_SESSION['level_setup']['level_requires_completion'][$i]); $i2++)
		{
			echo 'subLevelNeedsCompletion[' . $i . '][' . $i2 . '] = ' . $_SESSION['level_setup']['level_requires_completion'][$i][$i2] . ";\n";
		}
	}
	echo 'var pointsPerLevel = [];' . "\n";
	for($i = 0; $i < $_SESSION['level_setup']['total_levels']; $i++)
	{
		echo 'pointsPerLevel[' . $i . '] = [];' . "\n";
		for($i2 = 0; $i2 < count($_SESSION['level_setup']['points_per_level'][$i]); $i2++)
		{
			echo 'pointsPerLevel[' . $i . '][' . $i2 . '] = ' . $_SESSION['level_setup']['points_per_level'][$i][$i2] . ";\n";
		}
	}
?>

$(document).ready(function() {

	$(".knob").knob({
                'width':130
                });

 	if($('#levels').attr('currentlevel') == curLevel && $('#levels').attr('currentsublevel') == curSubLevel)
 	{} else {
 		changeLevel($('#levels').attr('currentlevel'));
 		changeSubLevel($('#levels').attr('currentsublevel'));
 	}
});

function changeLevel(num)
{
	if(num != curLevel)
	{
		curLevel = num;
		$('#sublevels').load("includes/process.php?process=getAvailableSubLevels&level=" + curLevel);
	}
	inProgress = false;
	oldSubLevel = 1;
	curSubLevel = 1;
	currentLevelPoints = 0;
	percentProgress = Math.floor(0);
	$('.knob').val(percentProgress).trigger('change');
	$('#level-progress').val(0+'%');
	$('#curLevel').html(curLevel);
	changeSubLevel(curSubLevel);
}

function nextLevel()
{
	if(!inProgress)
	{
		curSubLevel++;
		if(curSubLevel > maxSubLevels[curLevel-1])
		{
			curSubLevel = 1;
			if(parseInt(curLevel)+1 <= maxSubLevels.length) changeLevel(parseInt(curLevel)+1);
		}
		changeSubLevel(curSubLevel);
	} else {
		alert('You must finish the current exercise first!');
	}
}

function prevLevel()
{
	if(curSubLevel > 1)
	{
		curSubLevel--;
		changeSubLevel(curSubLevel);
	}
}

function allocateActivityPoints(questionNum, possibleAnswerNum, numberOfAttempts)
{
	var percentageOfPoints = (100 / (questionNum * possibleAnswerNum));
	var pointsPerAnswer = Math.floor(pointsPerLevel[curLevel-1][curSubLevel-1] * (percentageOfPoints / 100)) ;
	var maxPointsPerAnswer = pointsPerAnswer * possibleAnswerNum;
	//alert(percentageOfPoints + ' ' + questionNum + ' ' + possibleAnswerNum + ' ' + numberOfAttempts );
	currentLevelPoints = currentLevelPoints + (maxPointsPerAnswer - (pointsPerAnswer * numberOfAttempts));
	$('#current-points').html('Current Level Points: ' + currentLevelPoints);
}

function changeSubLevel(num)
{
	if(num > maxSubLevels[curLevel-1])
	{
		alert('No such sublevel exists, max sublevel for level ' + curLevel + ' is ' + maxSubLevels[curLevel-1] + '!');
	} else {
		if(curSubLevel > oldSubLevel) 
		{
			oldSubLevel = curSubLevel;
			percentProgress = Math.floor((100/(maxSubLevels[curLevel-1]-1))*(oldSubLevel-1));
			$('.knob').val(percentProgress).trigger('change');
			$('#level-progress').val(percentProgress+'%');
		}
		if(num > (oldSubLevel + 1) )
		{
			alert('You haven\'t completed up to here yet!');
		} else {
			if(!inProgress || num <= oldSubLevel )
			{
				for(var i = 1; i <= <?php echo $_SESSION['level_setup']['total_levels']; ?>; i++)
				{
					for(var i2 = 1; i2 <= maxSubLevels[i-1]; i2++)
					{
						$('#level' + i + '_' + i2).hide();
						$('#level' + i + '_' + i2 + '_objective').hide();
						$('#subLevelLink_' + i2).parent().css('border', 'none');
						$('#subLevelLink_' + i2).attr('href', 'javascript:changeSubLevel(\'' + i2 + '\');');
					}
				}
				$('#level' + curLevel + '_' + num).show();
				$('#level' + curLevel + '_' + num + '_objective').show();
				$('#subLevelLink_' + num).parent().css('border', '1px dashed black');
				$('#subLevelLink_' + num).attr('href', '#');

				curSubLevel = num;
				attempts = 0;

				if(subLevelNeedsCompletion[curLevel-1][curSubLevel-1] && num > (oldSubLevel-1))
				{
					inProgress = true;
				} else {
					currentLevelPoints = currentLevelPoints + pointsPerLevel[curLevel-1][curSubLevel-1];
					$('#current-points').html('Current Level Points: ' + currentLevelPoints);
					inProgress = false;
					$('#curLevel').html(curLevel);
				}
			}
		}
	}
}

<?php if(!$cache) block_js(false, true); ?>
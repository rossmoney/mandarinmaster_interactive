<?php

function normalLogin()
{
	require('header.php');
	$usercheck = mysql_query("SELECT * FROM users WHERE email = '". $_POST['email'] . "' AND password = '" . md5($_POST['password']) . "'");
	$user_data = mysql_fetch_object($usercheck);
	if(mysql_num_rows($usercheck) == 1 && $user_data->verified )
	{
		
		$_SESSION['socialIdentifier'] = $user_data->socialIdentifier;
		$_SESSION['displayName'] = $user_data->firstname . " " . $user_data->lastname;
		$_SESSION['user_data'] = $user_data;
		$_SESSION['provider'] = $provider = 'form';
		?>
		<script>
			self.parent.location.replace("<?php echo $_SESSION['CURRENT_URL']; ?>");
		</script>
	<?php
	} else {
		$_SESSION['verification'] = array("errortext" => "invalid login");
		if(!$user_data->verified) $_SESSION['verification'] = array("errortext" => "please check your email");
		$location = "http://memshape.com/widget/?_ts=" . time() . "&return_to=". urlencode( $_SESSION['CURRENT_URL'] );
		header("Location: $location");
	}
}

function register()
{
	require('header.php');
	$usercheck = mysql_query("SELECT id FROM users WHERE email = '". $_POST['email'] . "' AND password = '" . md5($_POST['password']) . "'");
	if(mysql_num_rows($usercheck) == 1)
	{
		$_SESSION['verification'] = array("errortext" => "account already exists!");

	} else {

		if($_POST['firstName'] == "" || $_POST['lastName'] == "" )
		{
			$_SESSION['verification'] = array("errortext" => "form not filled out");	

		} else {

			if(md5($_POST['password']) != md5($_POST['confirmPassword']))
			{
				$_SESSION['verification'] = array("errortext" => "passwords don't match");

			} else {

	$_SESSION['socialIdentifier'] = $socID = time();
	mysql_query("INSERT INTO users (email, password, firstname, lastname, socialIdentifier, photoURL)
	 VALUES ('". $_POST['email'] . "','". md5($_POST['password']) . "','". $_POST['firstName'] . "','". $_POST['lastName'] . "',
	 	'" . $socID . "', '')");

	$message = "Click on this link to activate your account.\n 
	<a href=\"http://memshape.com/includes/process.php?process=approveRegistration&socID=". $socID ."\"></a>";
	mail($_POST['email'], 'Your new memshape.com account!', $message);
	$_SESSION['verification'] = array("errortext" => "check your email");

			}

		}

	}

	$location = "http://memshape.com/widget/?_ts=" . time() . "&return_to=". urlencode( $_SESSION['CURRENT_URL'] );
	header("Location: $location");
}

function approveRegistration()
{
	require('header.php');
	$usercheck = mysql_query("SELECT id FROM users WHERE socialIdentifier = '". $_GET['socID'] . "'");
	if(mysql_num_rows($usercheck) == 1)
	{
		mysql_query("UPDATE users SET verified = '1' WHERE socialIdentifier = '". $_GET['socID'] . "'");
		$_SESSION['verification'] = array("errortext" => "account is now active!");
	}
	header("Location: http://memshape.com");
}

function checkMultiChoiceAnswer()
{
	require('bootstrap.php');
	$answer = block_config_val('multiple_choice', $_GET['mcBlock'], 'correct_answer', -1);
	if($answer == $_GET['choice'])
	{
		echo "correct";
	}
}

function checkQuestionAnswer()
{
	require('bootstrap.php');
	$answer = block_config_val('question', $_GET['qsBlock'], 'correct_answers', $_GET['qsNum']);
	$answer = $answer - 1;
	if($answer == $_GET['answer'])
	{
		echo "correct";
	}
}

if(isset($_REQUEST['submit']))
{
	$func = $_REQUEST['submit'];
	call_user_func($_REQUEST[$func]);
} else if(isset($_REQUEST['process'])) {
	call_user_func($_REQUEST['process']);
} else {
	echo "Nothing to do!";
}

function getAvailableSubLevels()
{
	require('header.php');
	$current_levels[0] = $_GET['level'];
	for ($i = 1; $i <= $_SESSION['level_setup']['level_structure'][$_GET['level']-1]; $i++) {
		echo "<div class=\"sublevel\"><a id=\"subLevelLink_".$i."\" href=\"javascript:changeSubLevel('" .  $i . "');\">" . $i . "</a></div>";
	}
}
?>
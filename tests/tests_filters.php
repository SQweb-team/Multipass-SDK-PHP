<?php

include_once "../src/init.php";
?>

<!DOCTYPE html>
<html>
<head>
	<title>Testing multipass buttons</title>
</head>
<body>
	<h1>Here is a test page, it can serve as an example of how to filter or lock your content.</h1>
	<span style="color: #4491ff; float: left; width: 100%;">To check our buttons tests, <a style="color: #4491ff" href="./tests_buttons.php">click here</a></span>
	<span style="color: red">WARNING: All of these functions can only work properly if you used the function $sqweb->script() right before your &#60;/body&#61; tag </span>
	<h2>Here you should see locked content with a multipass block. If you sign up with the button below, the content should appear.</h2>
	<?php $sqweb->button(); ?>
	<h3>1) Hide / display your content.</h3>
	<pre>
if ($sqweb->checkCredits() == 0) {
	echo 'ADS - - Put your ads code here. - - ADS';
} else {
	echo 'PREMIUM - - Put premium content here or let it empty if you want only to hide ads. - - PREMIUM';
}
	</pre>
	<span style="float: left; width:100%; margin-bottom: 40px;">If you login, the text below will change.</span>
	<?php
	if ($sqweb->checkCredits() == 0) {
		echo 'ADS - - Put your ads code here. - - ADS';
	} else {
		echo 'PREMIUM - - Put premium content here or let it empty if you want only to hide ads. - - PREMIUM';
	}
	?>
	<h3>2) Display only a part of your article.</h3>
	Use the function above to combine the subscription check with locking functions:
	<pre>
	echo $sqweb->transparent('Only 75% of this article will be displayed, the second argument of this function being the % of the article non subscribers will see', 75);
	if ($sqweb->checkCredits() == 0) {
		$sqweb->lockingblock();
	}
	//We recommend the usage of this function: $sqweb->lockingblock();. It will display a multipass button to register and unlock the content.
	</pre>
	<?php
			echo '<div style="margin-top:30px; margin-bottom: 30px;">' . $sqweb->transparent('Only 75% of this article will be displayed, the second argument of this function being the % of the article non subscribers will see', 75) . '</div>';
			if ($sqweb->checkCredits() == 0) {
				$sqweb->lockingblock();
			}
			// We recommend the usage of this function: $sqweb->lockingblock();. It will display a multipass button to register and unlock the content.
	?>

	<h3 style="margin-top: 40px; float:left; width:100%;">3) Lock your content for XX days.</h3>
	<pre style="float: left">
	if ($sqweb->waitToDisplay('2017-07-18', 4) {
		//Le premier argument de la fonction est la date de publication de l'article au format YYYY-mm-dd'
		//Le deuxieme argument est le nombre de jour à attendre avant de publier l'article. Pour cet exemple, l'article sera visible par tous le 2017-07-22


		echo 'Mettez votre article ici';
	}
	</pre>
	<?php
		if ($sqweb->waitToDisplay('2017-07-18', 4)) {
			//Le premier argument de la fonction est la date de publication de l'article au format YYYY-mm-dd'
			//Le deuxieme argument est le nombre de jour à attendre avant de publier l'article. Pour cet exemple, l'article sera visible par tous le 2017-07-22


			echo 'Mettez votre article ici';
		}
	?>
<!-- 	<h3 style="float: left; width: 100%; margin-top: 40px;">4) Limit the number of article a free user can see a day</h3>
	<pre style="float: left;">
	if ($sqweb->limitArticle(3)) {
		//L'argument de la fonction étant le nombre d'article qu'un utilisateur peut lire par jour.
		echo 'Mettez votre article ici';
	}
	</pre> -->
	<?php $sqweb->script(); ?>
</body>
</html>
<?php

include_once "../src/init.php";
?>

<!DOCTYPE html>
<html>
<head>
	<title>Testing multipass buttons</title>
</head>
<body>
	<h1>Here is a test page, it can serve as an example of how to display our buttons.</h1>
	<span style="color: #4491ff; float: left; width: 100%;">To check our filter tests, <a style="color: #4491ff" href="./tests_filters.php">click here</a></span>
	<span style="color: red">WARNING: All of these functions can only work properly if you used the function $sqweb->script() right before your &#60;/body&#61; tag </span>
	<h2>Here you should see the 4 buttons displayed from tiny to large with the corresponding function to display them.</h2>
	<div>
		<div style="display: inline-block;margin-right: 40px; margin-bottom: 20px; margin-top: 40px; width: 180px;"><pre>$sqweb->button('tiny');</pre></div>
		<div style="display: inline-block;"><?php $sqweb->button('tiny') ?></div>
	</div>
	<div>
		<div style="display: inline-block;margin-right: 40px; margin-bottom: 20px; width: 180px;"><pre>$sqweb->button('slim');</pre></div>
		<div style="display: inline-block;"><?php $sqweb->button('slim') ?></div>
	</div>
	<div>
		<div style="display: inline-block;margin-right: 40px; margin-bottom: 20px; width: 180px;"><pre>$sqweb->button('medium');</pre></div>
		<div style="display: inline-block;"><?php $sqweb->button('medium') ?></div>
	</div>
	<div>
		<div style="display: inline-block;margin-right: 40px; margin-bottom: 20px; width: 180px;"><pre>$sqweb->button('large');</pre></div>
		<div style="display: inline-block;"><?php $sqweb->button('large') ?></div>
	</div>
	<h2 style="margin-top: 50px;">Here you should see a "Support us" message with the corresponding function to display it.</h2>
	<div style="margin-top: 40px;"><pre>$sqweb->supportBlock();</pre></div>
	<div style="max-width: 1024px; padding: 60px; float:left;"><?php $sqweb->supportBlock(); ?></div>
	<?php $sqweb->script(); ?>
</body>
</html>
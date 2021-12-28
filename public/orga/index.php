<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="noindex">
	<title>La Flèche d'Or - Agenda</title>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
</head>

<body>
	<div id="container">
		<h1><strong>La Flèche d'Or</strong> - Agenda</h1>
		<div id="agenda">
			<iframe id="agendaFrame" src="agenda.php" style="border-width:0" frameborder="0" scrolling="no"></iframe>
		</div>
	</div>
</body>

</html>
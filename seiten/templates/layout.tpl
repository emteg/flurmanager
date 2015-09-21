<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>{block name=title}Flurmanager{/block}</title>
		<link rel="stylesheet" type="text/css" href="/{$rootDir}style.css" media="screen">
		<link rel="stylesheet" type="text/css" href="/{$rootDir}style_print.css" media="print">
	</head>
	<body>
		<header>
			<h1><a href="/{$rootDir}">{block name=headerCaption}Flurmanager {$flurName}{/block}</a></h1>
			{load_login symbol='SMARTY' assign='session'}
			{if !$session->istAngemeldet()}
			<span class="headerBox" id="headerLoginBox">
				<form method="post" action="/{$rootDir}login/index.php?target={$smarty.server.REQUEST_URI}">
					<input type="text" class="formInput100" name="name" placeholder="Benutzername" autocomplete="off"/>
					<input type="password" class="formInput100" name="passwort" placeholder="Passwort"/>
					<input type="submit" value="Anmelden"/>
				</form>
			</span>
			{else}
			<a class="headerLink" href="/{$rootDir}logout/">Abmelden</a>
			<a class="headerLink" href="/{$rootDir}user/index.php?id={$session->getUserId()}">{$session->getUserName()}</a>
			{/if}
			<a class="headerLink" href="/{$rootDir}geld/">Flurkasse</a>
		</header>
		<div id="bodyContent">
		{block name=body}{/block}
		</div>
		{block name=bodyScript}{/block}
	</body>
</html>
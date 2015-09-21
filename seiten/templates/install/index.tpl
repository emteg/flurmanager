{extends file="../layout.tpl"}
{block name=title}{$flurName} - Installation{/block}
{block name=body}
		<div class="contentBox">
			<h2>Flurmanager Installation</h2>
			<ul class="actions">
				<h3>Datenbankverbindung</h3>
{if $datenbank->istVerbunden()}
				<li>Verbindung zur Datenbank wurde hergestellt.</li>
	{if $datenbank->istBereit()}
				<li>Datenbank "{$datenbank->name()}" wurde ausgewählt und kann verwendet werden.</li>
	{else}
				<li>Die Datenbank "{$datenbank->name()}" konnte nicht ausgewählt werden.</li>
	{/if}
{else}
				<li>Es konnte keine Verbindung zur Datenbank hergestellt werden.</li>
{/if}
				<h3>Tabellen</h3>
{foreach $tabellen as $zeile}	
	{if is_array($zeile)}
				<li>Tabelle "{$zeile["table_name"]}" ist vorhanden.</li>
	{else if (count($tabellen) == 1)}
				<li>Keine der notwendigen Tabellen ist vorhanden.</li>
	{/if}
{/foreach}
			</ul><br/>
			<form action="speichern.php" method="post">
				<ul  class="formUl">
					<li>
						<label for="datenbank" class="formCaption">Datenbank</label>
						<input type="text" name="datenbank" class="formInput" value="{$datenbank->name()}">
					</li>
					<li>
						<label for="benutzer" class="formCaption">Beutzername</label>
						<input type="text" name="benutzer" class="formInput" value="{$datenbankBenutzer}">
					</li>
					<li>
						<label for="passwort" class="formCaption">Passwort</label>
						<input type="text" name="passwort" class="formInput" value="{$datenbankPasswort}">
					</li>
					<li>
						<label for="flurname" class="formCaption">Flurname</label>
						<input type="text" name="flurname" class="formInput" value="{$flurName}">
					</li>
					<li>
						<label for="zimmerAnzahl" class="formCaption">Zimmeranzahl</label>
						<input type="text" name="zimmerAnzahl" class="formInput" value="{$zimmerAnzahl}">
					</li>
					<li>
						<input type="submit" value="Speichern"/>
					</li>
				</ul>
			</form>
		</div>
{/block}
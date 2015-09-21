{extends file="../../layout.tpl"}
{block name=title}{$flurName} - Belegung bearbeiten{/block}
{block name=body}
		<div class="contentBox">
			<h2>Belegung von {$belegung->bewohner->vorname} {$belegung->bewohner->nachname}, {$belegung->getZimmerNummer()}</h2>
			<form action="speichern.php" method="post">
				<ul class="formUl">
					<li>
						<label for="zimmer" class="formCaption">Zimmer</label>
						<select name="zimmer" class="formInputSmall">
{for $i = 1 to $zimmerAnzahl}
  {if $i < 10}
		{if $i == $belegung->zimmer}
							<option value="{$i}" selected>{$flurName}0{$i}</option>
		{else}
							<option value="{$i}">{$flurName}0{$i}</option>
		{/if}
	{else}
		{if $i == $belegung->zimmer}
							<option value="{$i}" selected>{$flurName}{$i}</option>
		{else}
							<option value="{$i}">{$flurName}{$i}</option>
		{/if}
	{/if}
{/for}						
						</select>
					</li>
					<li>
						<label for="start" class="formCaption">Einzugsdatum</label>
						<input type="text" name="start" class="formInputSmall" value="{$belegung->start}">
					</li>
					<li>
						<label for="ende" class="formCaption">Auszugsdatum</label>
						<input type="text" name="ende" class="formInputSmall" value="{$belegung->ende}">
					</li>
					<li>
						<p><strong>Vorsicht:</strong> die Änderungen werden nicht auf Plausibilität überprüft!</p>
						<input type="submit" value="Änderungen speichern"/>
					</li>
				</ul>
				<input type="hidden" name="id" value="{$belegung->id}">
			</form>		
		</div>
{/block}
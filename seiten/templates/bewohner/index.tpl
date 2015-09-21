{extends file="../layout.tpl"}
{block name=title}{$flurName} - {$bewohner->vorname} {$bewohner->nachname}{/block}
{block name=body}
		<div class="contentBox">
			<h2>{$bewohner->vorname} {$bewohner->nachname}</h2>
			<a href="/{$rootDir}geld/guthaben/index.php?id={$bewohner->id}">Guthaben:
{if ($guthaben < 0)}
				<span class="geldNegativ">{str_replace(".", ",", $guthaben)} €</span>
{else}
				{str_replace(".", ",", $guthaben)} €
{/if}
			</a>
			<h3>Bearbeiten</h3>
			<form action="speichern.php" method="post">
				<ul class="formUl">
					<li>
						<label for="vorname" class="formCaption">Vorname</label>
						<input type="text" name="vorname" class="formInput" value="{$bewohner->vorname}">
					</li>
					<li>
						<label for="nachname" class="formCaption">Nachname</label>
						<input type="text" name="nachname" class="formInput" value="{$bewohner->nachname}">
					</li>
					<li>
						<label for="geschlecht" class="formCaption">Geschlecht</label>
						<select name="geschlecht" class="formInputSmall">
							<option {if $bewohner->geschlecht == "Unbekannt"}selected{/if} value="Unbekannt">Unbekannt</option>
							<option {if $bewohner->geschlecht == "Maennlich"}selected{/if} value="Maennlich">Männlich</option>
							<option {if $bewohner->geschlecht == "Weiblich"}selected{/if} value="Weiblich">Weiblich</option>
						</select>
					</li>
					<li>
						<label for="geburtstag" class="formCaption">Geburtstag</label>
						<input type="text" name="geburtstag" class="formInputSmall" value="{$bewohner->geburtstag}" placeholder="JJJJ-MM-TT">
						<span class="formHint">{$bewohner->alter()} Jahre.</span>
					</li>
					<li>
						<label for="hochschule" class="formCaption">Hochschule</label>
						<input type="text" name="hochschule" class="formInputSmall" value="{$bewohner->hochschule}" placeholder="Hochschule" list="hochschulen">
						<datalist id="hochschulen">
{foreach $hochschulen as $hochschule}
							<option>{$hochschule["Name"]}</option>
{/foreach}						
						</datalist>
					</li>
					<li>
						<label for="studienfach" class="formCaption">Studienfach</label>
						<input type="text" name="studienfach" class="formInput" value="{$bewohner->studienfach}" placeholder="Studienfach" list="studienfacher">
						<datalist id="studienfacher">
{foreach $studien as $fach}
							<option>{$fach["Name"]}</option>
{/foreach}						
						</datalist>
					</li>
					<li>
						<label for="nationalitaet" class="formCaption">Nationalität</label>
						<input type="text" name="nationalitaet" class="formInput" value="{$bewohner->nationalitaet}" placeholder="Nationalität" list="nationen">
						<datalist id="nationen">
{foreach $nationen as $nation}
							<option>{$nation["Name"]}</option>
{/foreach}						
						</datalist>
					</li>
					<li>
						<label for="istBildungsInlaender" class="formCaption">Bildungsinländer</label>
						<input type="checkbox" name="istBildungsInlaender" {if $bewohner->istBildungsInlaender}checked{/if}> ist Bildungsinländer
					</li>
					<li>
						<input type="submit" value="Änderungen speichern"/>
					</li>
				</ul>
				<input type="hidden" name="id" value="{$bewohner->id}">
			</form>
			<p><strong>Hinweis zu Hochschule, Studienfach und Nationalität:</strong> In der Datenbank vorhandene Einträge werden als Autovervollständigung angezeigt. Groß-/Kleinschreibung ist in diesem Fall egal. Neue Einträge werden automatisch zur Datenbank hinzugefügt und dann für immer in genau der verwendeten Schreibweise verwendet.</p>
			<ul class="actions">
				<h3>Aktionen</h3>
				<li><a href="../umzug/index.php?id={$bewohner->id}">Umzug</a></li>
				<li><a href="../auszug/index.php?id={$belegungen[0]->id}">Auszug</a></li>
				<li><a href="loeschen.php?id={$bewohner->id}">Löschen</a></li>
			</ul>
		</div>
		
		<div class="contentBox">
			<h2>Belegungsgeschichte</h2>
			{$bewohner->vorname} {$bewohner->nachname} hat bisher in den folgenden Zimmern gewohnt:
			<table>
				<thead>
					<tr>
						<th>Zimmer</th>
						<th>Von</th>
						<th>Bis</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
{foreach $belegungen as $zeile}
					<tr {cycle values=',class="tableRowDark"'}>
	{if $zeile->zimmer < 10}
						<td><a href="../zimmer/index.php?nummer={$zeile->zimmer}">{$flurName}0{$zeile->zimmer}</a></td>
	{else}
						<td><a href="../zimmer/index.php?nummer={$zeile->zimmer}">{$flurName}{$zeile->zimmer}</a></td>
	{/if}
						<td>{$zeile->start}</td>
						<td>{$zeile->ende}</td>
						<td><a href="../belegung/index.php?id={$zeile->id}" title="Bearbeiten"><img src="../edit.png" height="14"></a></td>
					</tr>
{/foreach}
				</tbody>
			</table>
		</div>
{/block}
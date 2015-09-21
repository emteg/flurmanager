{extends file="../../../layout.tpl"}
{block name=title}{$flurName} - Mehrfachbuchung durchführen{/block}
{block name=body}
		<div class="contentBox">
			<h2>Mehrfachbuchung durchführen</h2>
			<p>Führt gleiche oder ähnliche Buchungen für mehrere Bewohner auf einmal aus.</p>
			<form action="speichern.php" method="post">
				<ul class="formUl">
					<li>
						<label for="datum" class="formCaption">Datum</label>
						<input type="text" name="datum" class="formInputSmall" value="{$today}" placeholder="JJJJ-MM-TT">
					</li>
					<li>
						<label for="betreff" class="formCaption">Betreff</label>
						<input type="text" name="betreff" class="formInput" placeholder="Betreff">
					</li>
					<li>
						<label for="betrag" class="formCaption">Betrag</label>
						<input type="text" name="betrag" class="formInputSmall" placeholder="0,00">
					</li>
					<li>
						<label for="methode" class="formCaption">Diesen Betrag</label>
						<input type="radio" name="methode" value="0" checked>von jedem ausgewählten Bewohner abbuchen<br/>
						<input type="radio" name="methode" value="1">unter den ausgewählten Bewohnern aufteilen<br/>
					</li>
					<li style="vertical-align: top">
						<label for="bewohner[]" class="formCaption">Bewohner</label>
						<select name="bewohner[]" size="{count($belegungen)}" class="formInput" multiple>
						{foreach $belegungen as $belegung}
							<option value="{$belegung->bewohner->id}" selected>{$belegung->getZimmerNummer()} {$belegung->bewohner->vorname} {$belegung->bewohner->nachname}</option>
						{/foreach}
						</select>
						<span class="formHint">Mehrere Bewohner durch gedrückthalten der STRG-Taste bzw. Control-Taste auswählen.</span>
					</li>
					<li>
						<input type="submit" value="Weiter &gt; &gt;"/>
					</li>
				</ul>
			</form>
		</div>
{/block}
{block name=bodyScript}
		<script>
		
		</script>
{/block}
{extends file="../layout.tpl"}
{block name=title}{$flurName} - Neueinzug{/block}
{block name=body}
		<div class="contentBox">
			<h2>Neueinzug</h2>
			<form action="speichern.php" method="post">
				<ul  class="formUl">
					<li>
						<label for="zimmer" class="formCaption">Zimmernummer</label>
						<select name="zimmer" class="formInput">
{foreach $zimmer as $aktuell}
	{if $aktuell["istBelegt"]}
		{if $aktuell["freiAb"]}
							<option value="{$aktuell["nummer"]};{$aktuell["belegung"]->id}">
								{$aktuell["bezeichnung"]} - Frei nach dem {$aktuell["freiAb"]} - {$aktuell["belegung"]->bewohner->vorname} {$aktuell["belegung"]->bewohner->nachname}
							</option>
		{else}
							<option value="{$aktuell["nummer"]};{$aktuell["belegung"]->id}">
								{$aktuell["bezeichnung"]} - {$aktuell["belegung"]->bewohner->vorname} {$aktuell["belegung"]->bewohner->nachname}
							</option>
		{/if}
	{else}
							<option value="{$aktuell["nummer"]};0" selected>
								{$aktuell["bezeichnung"]} - Frei
							</option>
	{/if}
{/foreach}
						</select>
						<span class="formHint">Bitte das Zimmer auswählen, in das der neue Mitbewohner einziehen soll.</span>
					</li>
					<li>
						<label for="vorname" class="formCaption">Vorname</label>
						<input type="text" name="vorname" class="formInput">
					</li>
					<li>
						<label for="nachname" class="formCaption">Nachname</label>
						<input type="text" name="nachname" class="formInput">
					</li>
					<li>
						<label for="einzug" class="formCaption">Einzugsdatum</label>
						<input type="text" name="einzug" class="formInputSmall" placeholder="JJJJ-MM-TT" value="{$einzugsDatum}">
						<span class="formHint">Datum, zu dem der neue Mitbewohner einzieht.</span>
					</li>
					<li>
						<label for="auszug" class="formCaption">Auszugsdatum</label>
						<input type="text" name="auszug" class="formInputSmall" placeholder="JJJJ-MM-TT">
						<span class="formHint">Datum, zu dem der aktuelle Mitbewohner ausziehen soll (falls das Zimmer belegt ist).</span>
					</li>
					<li>
						<input type="submit" value="Weiter &gt;&gt;"/>
					</li>
				</ul>
			</form>
		</div>
{/block}
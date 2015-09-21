{extends file="../layout.tpl"}
{block name=title}{$flurName} - Umzug{/block}
{block name=body}
		<div class="contentBox">
			<h2>Umzug von {$bewohner->vorname} {$bewohner->nachname}, {$bewohnerBelegungen[0]->getZimmerNummer()}</h2>
			<form action="speichern.php" method="post">
				<ul class="formUl">
					<li>
						<label for="belegung" class="formCaption">Aktuelles Zimmer</label>
						<select name="belegung" class="formInput">
{foreach $bewohnerBelegungen as $belegung}
							<option value="{$belegung->id}">{$belegung->getZimmerNummer()} - {$belegung->start} bis {$belegung->ende}</option>
{/foreach}
						</select>
						<span class="formHint">Das Zimmer, in dem der Bewohner zur Zeit wohnt.</span>
					</li>
					<li>
						<label for="umzugsdatum" class="formCaption">Umzugsdatum</label>
						<input type="text" name="auszugsdatum" placeholder="JJJJ-MM-TT" class="formInput">
						<span class="formHint">In der Form JJJJ-MM-TT. Zu diesem Datum wird die Belegung des Bewohners in seinem aktuellen Zimmer beendet.</span>
					</li>
					<li>
						<label for="zimmer" class="formCaption">Neues Zimmer</label>
						<select name="zimmer" class="formInput">
{foreach $zimmer as $aktuell}
	{if $aktuell["istBelegt"]}
		{if $aktuell["freiAb"]}
							<option value="{$aktuell["nummer"]};{$aktuell["belegung"]->id}" {if $aktuell["selected"]}selected{/if}>
								{$aktuell["bezeichnung"]} - Frei nach dem {$aktuell["freiAb"]} - {$aktuell["belegung"]->bewohner->vorname} {$aktuell["belegung"]->bewohner->nachname}
							</option>
		{else}
							<option value="{$aktuell["nummer"]};{$aktuell["belegung"]->id}" {if $aktuell["selected"]}selected{/if}>
								{$aktuell["bezeichnung"]} - {$aktuell["belegung"]->bewohner->vorname} {$aktuell["belegung"]->bewohner->nachname}
							</option>
		{/if}
	{else}
							<option value="{$aktuell["nummer"]};0" {if $aktuell["selected"]}selected{/if}>
								{$aktuell["bezeichnung"]} - Frei
							</option>
	{/if}
{/foreach}						
						</select>
						<span class="formHint">Das Zimmer, in das der Bewohner umziehen soll. Eine zum Umzugsdatum noch vorhandene Belegung wird beendet ("Auszug").</span>
					</li>
					<li>
						<input type="submit" value="Weiter &gt; &gt;">
					</li>
				</ul>
			</form>
			<p><strong>Anmerkung:</strong> das Umzugsdatum gibt eigentlich das <em>Auszugsdatum</em> aus dem aktuellen Zimmer an. Die aktuelle Belegung wird zu diesem Datum beendet. Das <em>Einzugsdatum</em> im neuen Zimmer ist automatisch einen Tag später. Falls das Zielzimmer zum <em>Einzugsdatum</em> noch belegt ist, wird die vorhandene Belegung zum <em>Auszugsdatum</em> beendet.</p>
		</div>
{/block}
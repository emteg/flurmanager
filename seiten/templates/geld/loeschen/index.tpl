{extends file="../../layout.tpl"}
{block name=title}{$flurName} - Buchung löschen{/block}
{block name=body}
		<div class="contentBox">
			<h2>Soll die Buchung von {$buchung->bewohner->vorname} {$buchung->bewohner->nachname} wirlich löschen?</h2>
			<ul class="invisibleUl">
				<li><strong>Betreff:</strong> {$buchung->betreff}</li>
				<li><strong>Betrag:</strong> {str_replace(".", ",", $buchung->betrag)} €</li>
				<li><strong>Datum:</strong> {$buchung->datum}</li>
				<li><strong>Typ:</strong> 
{if $buchung->istGuthaben && $buchung->istGeld}
					Barzahlung mit Gutschrift
{else if $buchung->istGuthaben}
					Guthaben
{else if $buchung->istGeld}
					Barzahlung
{/if}
				</li>
			</ul>
			<p>Soll diese Buchung jetzt wirklich gelöscht werden? Das kann nicht rückgängig gemacht werden.</p>
			<a href="javascript:history.back()">Abbrechen</a><br><br>
			<a href="./loeschen_ausfuehren.php?id={$buchung->id}">Löschen</a>
		</div>
{/block}
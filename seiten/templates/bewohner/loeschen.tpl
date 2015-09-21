{extends file="../layout.tpl"}
{block name=title}{$flurName} - Bewohner {$bewohner->vorname} {$bewohner->nachname} löschen{/block}
{block name=body}
		<div class="contentBox">
			<h2>Bewohner {$bewohner->vorname} {$bewohner->nachname} wirklich löschen?</h2>
			<p>Soll der Bewohner {$bewohner->vorname} {$bewohner->nachname} und alle mit ihr/ihm verbundene Belegungen und Zahlungen jetzt wirklich gelöscht werden? Das kann nicht rückgängig gemacht werden.</p>
			<a href="./index.php?id={$bewohner->id}">Abbrechen</a><br/><br/>
			<a href="loeschen_ausfuehren.php?id={$bewohner->id}">Löschen</a>
		</div>
{/block}
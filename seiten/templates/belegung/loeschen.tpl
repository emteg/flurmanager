{extends file="../layout.tpl"}
{block name=title}{$flurName} - Belegungvon {$belegung->bewohner->vorname} {$belegung->bewohner->nachname} löschen{/block}
{block name=body}
		<div class="contentBox">
			<h2>Belegung von {$belegung->bewohner->vorname} {$belegung->bewohner->nachname} wirklich löschen?</h2>
			<p>Soll die Belegung von {$belegung->bewohner->vorname} {$belegung->bewohner->nachname} in Zimmer {$belegung->getZimmerNummer()} jetzt wirklich gelöscht werden? Das kann nicht rückgängig gemacht werden.</p>
			<p>Der Bewohner selbst und sein Guthaben werden <em>nicht</em> gelöscht.</p>
			<a href="./index.php?id={$belegung->id}">Abbrechen</a><br/><br/>
			<a href="loeschen_ausfuehren.php?id={$belegung->id}">Löschen</a>
		</div>
{/block}
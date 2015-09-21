{extends file="../layout.tpl"}
{block name=title}{$flurName} - Belegungsdetails{/block}
{block name=body}
		<div class="contentBox">
			<h2>Belegungsdetails</h2>
			<ul class="invisibleUl">
				<li>
					<span class="width100"><b>Bewohner:</b></span>
					<a href="../bewohner/index.php?id={$belegung->bewohner->id}">
						{$belegung->bewohner->vorname} {$belegung->bewohner->nachname}
					</a>
				</li>
				<li><span class="width100"><b>Zimmer:</b></span><a href="../zimmer/index.php?nummer={$belegung->zimmer}">{$belegung->getZimmerNummer()}</a></li>
				<li><span class="width100"><b>Einzug:</b></span>{$belegung->start}</li>
				<li><span class="width100"><b>Auszug:</b></span>{$belegung->ende}&nbsp;</li>
			</ul>
			
			<ul class="actions">
				<h3>Aktionen</h3>
				<li><a href="../umzug/index.php?id={$belegung->bewohner->id}">Umzug</a></li>
				<li><a href="../auszug/index.php?id={$belegung->bewohner->id}">Auszug</a></li>
				<li><a href="./loeschen.php?id={$belegung->id}">Löschen</a></li>
				<li><a href="./bearbeiten/index.php?id={$belegung->id}">Bearbeiten</a></li>
			</ul>
		</div>
{/block}
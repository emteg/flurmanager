{extends file="layout.tpl"}
{block name=title}{$flurName} - Aktuelle Belegung{/block}
{block name=body}
		<div class="contentBox">
			<h2>Aktuelle Belegung</h2>			
			<table>
				<thead>
					<tr>
						<th></th>
						<th>Name</th>
						<th>Guthaben</th>
						<th class="bigScreenOnly">Belegung</th>
						<th class="bigScreenOnly">Details</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
{$i = 1}
{foreach $daten as $zeile}
	{if $i != $zeile->zimmer}
					<tr {cycle values=',class="tableRowDark"'}>
						<th><a href="./zimmer/index.php?nummer={$i}">{$flurName}{if $i < 10}0{$i}{else}{$i}{/if}</a></th>
						<td colspan="7">- Leer -</td>
					</tr>
		{$i = $i + 1}
	{/if}
					<tr {cycle values=',class="tableRowDark"'}>
						<th><a href="./zimmer/index.php?nummer={$zeile->zimmer}">{$zeile->getZimmerNummer()}</a></th>
						<td>
							<p class="newline"><a href="./bewohner/index.php?id={$zeile->bewohnerId}">{$zeile->bewohner->vorname} {$zeile->bewohner->nachname}</a></p>
							<span class="info">
								{if $zeile->bewohner->studienfach}{$zeile->bewohner->studienfach}/{/if}{$zeile->bewohner->hochschule}, {if $zeile->bewohner->alter()}{$zeile->bewohner->alter()} Jahre{/if}
							</span>
						</td>
		{if $guthaben[$zeile->bewohnerId] < 0}
						<td class="geldNegativ">
		{else}
						<td class="geld">
		{/if}
							{str_replace(".", ",", $guthaben[$zeile->bewohnerId])} €
						</td>
						<td class="bigScreenOnly"><p class="info">{date("d.m.Y", strtotime($zeile->start))}{if $zeile->ende}<br/>bis<br/>{date("d.m.Y", strtotime($zeile->ende))}{/if}</p></td>
						<td class="bigScreenOnly"><p class="info">{$zeile->bewohner->nationalitaet}{if $zeile->bewohner->istBildungsInlaender}, Bildungsinländer{/if}</td>
						<td>
							<a href="./belegung/index.php?id={$zeile->id}">Belegung</a>, 
							<a href="./auszug/index.php?id={$zeile->id}">Auszug</a>, 
							<a href="./umzug/index.php?id={$zeile->id}">Umzug</a>
						</td>
					</tr>
	{$i = $i + 1}
{foreachelse}
					<tr class="tableRowEmpty">
						<td colspan="8">- Keine Einträge vorhanden -</td>
					</tr>
{/foreach}
				</tbody>
			</table>
			<ul class="actions">
				<h3>Aktionen</h3>
				<li><a href="./neueinzug">Neueinzug</a></li>
				<li><a href="./wiedereinzug">Wiedereinzug von ehemaligem Mitbewohner</a></li>
				<li><a href="./belegung/alle/">Alle Belegungen ansehen</a></li>
				<li><a href="./bewohner/alle/">Alle Bewohner ansehen</a></li>
			</ul>
			<ul class="actions">
				<h3>Statistik</h3>
				<li>
					<span class="width120">Hochschulen: </span>
					<img src="statistikHochschulen.png">
				</li>
				<li>
					<span class="width120">Studiengänge: </span>
					<img src="statistikStudien.png">
				</li>
				<li>
					<span class="width120">Frauenanteil: </span>
					<img src="statistikFrauen.png">
				</li>
				<li>
					<span class="width120">Ausländer: </span>
					<img src="statistikAuslaender.png">
				</li>
				<li>
					<span class="width120">ø-Alter:</span>
					{$durchschnittsalter} Jahre
				</li>
			</ul>
		</div>
		<div class="contentBox">
		<h2><a href="./geld">Flurkasse</a></h2>
		<span class="width100right">
{if $kassenstand < 0}
			<span class="geldNegativ">{str_replace(".", ",", $kassenstand)} €</span>
{else}
			{str_replace(".", ",", $kassenstand)} €
{/if}
		</span>Bargeld in der Flurkasse<br/>
		<span class="width100right">
{if $summeGuthaben < 0}
			<span class="geldNegativ">{str_replace(".", ",", $summeGuthaben)} €</span>
{else}
			{str_replace(".", ",", $summeGuthaben)} €
{/if}
		</span>Summe aller Guthaben und Schulden von Mitbewohnern<br/>
		<span class="width100right">
{if $kassenstand - $summeGuthaben < 0}
			<span class="geldNegativ">{str_replace(".", ",", $kassenstand - $summeGuthaben)} €</span>
{else}
			{str_replace(".", ",", $kassenstand - $summeGuthaben)} €
{/if}
		</span>Saldo der Flurkasse<br/>
		<ul class="actions">
			<h3>Aktionen</h3>
			<li><a href="./geld/neu">Neue Zahlung(en) eintragen</a></li>
		</ul>
		</div>
		<div class="contentBox">
			<h2>Verwaltung</h2>
			<ul class="actions">
				<li><a href="./user/alle/">Benutzer</a></li>
			</ul>
		</div>
{/block}
{extends file="../layout.tpl"}
{block name=title}{$flurName} - Flurkasse{/block}
{block name=body}
		{if $neueZahlungen >= 0}
		<div class="contentBoxHinweis">
		{if $neueZahlungen > 1}
			{$neueZahlungen} neue Zahlungen wurden gebucht.
		{else}
			1 neue Zahlung wurde gebucht.
		{/if}
		</div>
		{/if}
		<div class="contentBox">
			<h2>Flurkasse</h2>
			<span class="width100right"> 
{if $kassenstand < 0}
				<span class="geldNegativ">{str_replace(".", ",", $kassenstand)} €</span>
{else}
				{str_replace(".", ",", $kassenstand)} €
{/if}
			</span>Bargeld in der Flurkasse.<br/>
		
			<span class="width100right">  
{if $ausgaben < 0}
				<span class="geldNegativ">{str_replace(".", ",", $ausgaben)} €</span>
{else}
				{str_replace(".", ",", $ausgaben)} €
{/if}
			</span>Ausgaben dieses Semester.<br/>
		
			<span class="width100right">  
{if $einnahmen < 0}
				<span class="geldNegativ">{str_replace(".", ",", $einnahmen)} €</span>
{else}
				{str_replace(".", ",", $einnahmen)} €
{/if}
			</span>Einnahmen dieses Semester.<br/>

			<span class="width100right"> 
{if $kassenstand - $summeGuthaben < 0}
				<span class="geldNegativ">{str_replace(".", ",", $kassenstand - $summeGuthaben)} €</span>
{else}
				{str_replace(".", ",", $kassenstand - $summeGuthaben)} €
{/if}
			</span>Aktuelles Saldo der Flurkasse.
		
			<h3>Letzte Kassenbewegungen</h3>
			<table>
				<thead>
					<tr>
						<th class="bigScreenOnly">Datum</th>
						<th>Betrag</th>
						<th>Betreff</th>
						<th>Bewohner</th>
						<th>Saldo</th>
						<th></th>
					</tr>
				</thead>

				<tbody>
{foreach $zahlungen as $zahlung}
					<tr {cycle values=',class="tableRowDark"'}>
						<td class="bigScreenOnly">{$zahlung["datum"]}</td>
	{if $zahlung["negativ"]}
						<td class="geldNegativ">{$zahlung["betrag"]}</td>
	{else}
						<td class="geld">{$zahlung["betrag"]}</td>
	{/if}
						<td>{$zahlung["betreff"]}</td>
	{if $zahlung["zimmer"] != ""}
						<td>{$zahlung["vorname"]} {$zahlung["nachname"]}<span class="bigScreenOnly">, {$zahlung["zimmer"]}</span></td>
	{else}
						<td></td>
	{/if}
	{if $zahlung["saldo-negativ"]}
						<td class="geldNegativ">{$zahlung["saldo"]}</td>
	{else}
						<td class="geld">{$zahlung["saldo"]}</td>
	{/if}
						<td><a href="./bearbeiten/index.php?id={$zahlung["id"]}" title="Bearbeiten"><img src="../edit.png" height="14"></a></td>
					</tr>
{foreachelse}
					<tr class="tableRowEmpty">
						<td colspan="6">- Keine Einträge vorhanden -</td>
					</tr>
{/foreach}
				</tbody>
			</table>
			<ul class="actions">
				<h3>Aktionen</h3>
				<li><a href="./neu">Neue Zahlung(en) buchen</a></li>
				<li><a href="./neu/mehrfach">Mehrfachbuchung durchführen</a></li>
				<li><a href="./buchungen">Alle Buchungen</a></li>
			</ul>
		</div>
		<div class="contentBox">
			<h2>Flurbeitrag {$semester}</h2>
			<table>
				<thead>
					<tr>
						<th>Zimmer</th>
						<th>Name</th>
						<th>Guthaben</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
{foreach $belegungen as $key => $belegung name=loop}
					<tr {cycle values=',class="tableRowDark"'}>
						<td>{$belegung->getZimmerNummer()}</td>
						<td>{$belegung->bewohner->vorname} {$belegung->bewohner->nachname}</td>
	{if $guthaben[$key]["istNegativ"]}
						<td class="geldNegativ">{$guthaben[$key]["guthaben"]}</td>
	{else}
						<td class="geld">{$guthaben[$key]["guthaben"]}</td>
	{/if}
						<td><a href="./guthaben/index.php?id={$belegung->bewohnerId}" title="Übersicht"><img src="../eye_inv.png" height="14"></a></td>
					</tr>
	{if $smarty.foreach.loop.last}
					<tr>
						<td colspan="2" class="geld">Summe</td>
		{if $summeGuthaben < 0}
						<td class="geldNegativ">{str_replace(".", ",", $summeGuthaben)} €</td>
		{else}
						<td class="geld">{str_replace(".", ",", $summeGuthaben)} €</td>
		{/if}
						<td></td>
					</tr>
	{/if}
{foreachelse}
					<tr class="tableRowEmpty">
						<td colspan="4">- Keine Daten vorhanden -</td>
					</tr>
{/foreach}		
				</tbody>
			</table>
			<ul class="actions">
				<h3>Aktionen</h3>
				<li><a href="./beitrag/drucken.php">Druckansicht</a></li>
			</ul>	
		</div>
{/block}
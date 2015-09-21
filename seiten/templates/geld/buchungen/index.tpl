{extends file="../../layout.tpl"}
{block name=title}{$flurName} - Alle Buchungen{/block}
{block name=body}
		<div class="contentBox">
			<h2>Alle Buchungen</h2>
			<table>
				<thead>
					<tr>
						<th>Datum</th>
						<th>Betrag</th>
						<th>Betreff</th>
						<th>Bewohner</th>
						<th>Typ</th>
						<th>Saldo</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
{foreach $buchungen as $buchung}				
					<tr {cycle values=',class="tableRowDark"'}>
						<td>{$buchung->datum}</td>
	{if $buchung->betrag < 0}
						<td class="geldNegativ">{str_replace(".", ",", $buchung->betrag)} €</td>
	{else}
						<td class="geld">{str_replace(".", ",", $buchung->betrag)} €</td>
	{/if}
						<td>{$buchung->betreff}</td>
						<td>{$buchung->bewohner->vorname} {$buchung->bewohner->nachname}</td>
						
	{if $buchung->istGeld && $buchung->istGuthaben}
						<td>Gut-/Lastschrift</td>
						<td class="geld">{str_replace(".", ",", $kassenstand)} €</td>
		{$kassenstand = $kassenstand - $buchung->betrag}
						
	{else if $buchung->istGeld}
						<td>Bargeld</td>
						<td class="geld">{str_replace(".", ",", $kassenstand)} €</td>
		{$kassenstand = $kassenstand - $buchung->betrag}
	{else if $buchung->istGuthaben}
						<td>Guthaben</td>
						<td></td>
	{/if}
						<td>
							<a href="../bearbeiten/index.php?id={$buchung->id}" title="Bearbeiten"><img src="../../edit.png" height="14"></a> 
							<a href="../loeschen/index.php?id={$buchung->id}" title="Löschen"><img src="../../delete.png" height="14"></a>
						</td>
					</tr>
{foreachelse}
					<tr><td colspan="7">- Keine Daten vorhanden -</td></tr>
{/foreach}
					<tr>
						<td colspan="7">
							{include "pagination.tpl"}
						</td>
					</tr>
				</tbody>
			</table>
		</div>
{/block}
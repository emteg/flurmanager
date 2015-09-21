{extends file="../../layout.tpl"}
{block name=title}{$flurName} - Guthaben von {$bewohner->vorname} {$bewohner->nachname}{/block}
{block name=body}
		<div class="contentBox">
			<h2>Buchungen für <a href="../../bewohner/index.php?id={$bewohner->id}">{$bewohner->vorname} {$bewohner->nachname}</a></h2>
{if $guthaben < 0}
			<p>Guthaben: <span class="geldNegativ">{str_replace(".", ",", $guthaben)} €</span></p>
{else}
			<p>Guthaben: {str_replace(".", ",", $guthaben)} €</p>
{/if}
			<table>
				<thead>
					<tr>
						<th>Datum</th>
						<th>Betrag</th>
						<th>Betreff</th>
						<th class="bigScreenOnly">Typ</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
{foreach $zahlungen as $zahlung}				
					<tr {cycle values=',class="tableRowDark"'}>
						<td>{$zahlung->datum}</td>
	{if $zahlung->betrag < 0}
						<td class="geldNegativ">{str_replace(".", ",", $zahlung->betrag)} €</td>
	{else}
						<td class="geld">{str_replace(".", ",", $zahlung->betrag)} €</td>
	{/if}
						<td>{$zahlung->betreff}</td>
	{if $zahlung->istGeld}
						<td class="bigScreenOnly">Bargeld</td>
	{else}
						<td class="bigScreenOnly">Guthaben</td>
	{/if}
						<td><a href="../bearbeiten/index.php?id={$zahlung->id}" title="Bearbeiten"><img src="../../edit.png" height="14"></a> <a href="../loeschen/index.php?id={$zahlung->id}" title="Löschen"><img src="../../delete.png" height="14"></a></td>
					</tr>
{foreachelse}
					<tr><td colspan="5">- Keine Einträge vorhanden -</td></tr>
{/foreach}
				</tbody>
			</table>
		</div>
{/block}
{extends file="../../layout.tpl"}
{block name=title}{$flurName} - Alle Belegungen{/block}
{block name=body}
		<div class="contentBox">
			<h2>Alle Belegungen</h2>
			<table>
				<thead>
					<tr>
						<th>Zimmer</th>
						<th>Einzug</th>
						<th>Name</th>
						<th>Auszug</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
{foreach $belegungen as $belegung}
					<tr {cycle values=',class="tableRowDark"'}>
						<td>{$belegung->getZimmerNummer()}</td>
						<td>{$belegung->start}</td>
						<td>{$belegung->bewohner->vorname} {$belegung->bewohner->nachname}</td>
						<td>{$belegung->ende}</td>
						<td><a href="../../bewohner/index.php?id={$belegung->bewohnerId}" title="Details"><img src="../../eye_inv.png" height="14"></a></td>
					</tr>
{foreachelse}
					<tr><td colspan="5">- Keine Daten vorhanden -</td></tr>
{/foreach}
					<tr>
						<td colspan="5">
							{include "pagination.tpl"}
						</td>
					</tr>
				</tbody>
			</table>
		</div>
{/block}
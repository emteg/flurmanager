{extends file="../../layout.tpl"}
{block name=title}{$flurName} - Alle Bewohner{/block}
{block name=body}
		<div class="contentBox">
			<h2>Alle Bewohner</h2>
			<table>
				<thead>
					<tr>
						<th>Vorname</th>
						<th>Nachname</th>
						<th>Geburtstag</th>
						<th>Hochschule</th>
						<th>Studienfach</th>
						<th>Nationalität</th>
						<th>B.I.</th>
						<th>Geschlecht</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
{foreach $bewohner as $aktuell}
					<tr {cycle values=',class="tableRowDark"'}>
						<td>{$aktuell->vorname}</td>
						<td>{$aktuell->nachname}</td>
						<td>{$aktuell->geburtstag}</td>
						<td>{$aktuell->hochschule}</td>
						<td>{$aktuell->studienfach}</td>
						<td>{$aktuell->nationalitaet}</td>
						<td>{if $aktuell->istBildungsInlaender}Ja{else}Nein{/if}</td>
						<td>{$aktuell->getGeschlecht()}</td>
						<td><a href="../../bewohner/index.php?id={$aktuell->id}" title="Details"><img src="../../eye_inv.png" height="14"></a></td>
					</tr>
{foreachelse}
					<tr><td colspan="9">- Keine Daten vorhanden -</td></tr>
{/foreach}
					<tr>
						<td colspan="9">
							{include "pagination.tpl"}
						</td>
					</tr>
				</tbody>
			</table>
		</div>
{/block}
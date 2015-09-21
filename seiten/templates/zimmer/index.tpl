{extends file="../layout.tpl"}
{block name=title}{$flurName} - Zimmer {$zimmerBezeichnung}{/block}
{block name=body}
		<div class="contentBox">
			<h2>Belegungen von Zimmer {$zimmerBezeichnung}</h2>
			<table>
				<thead>
					<tr>
						<th>Bewohner</th>
						<th>Von</th>
						<th>Bis</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
{foreach $belegungen as $belegung}
					<tr {cycle values=',class="tableRowDark"'}>
						<td><a href="../bewohner/index.php?id={$belegung->bewohner->id}">{$belegung->bewohner->vorname} {$belegung->bewohner->nachname}</a></td>
						<td>{$belegung->start}</td>
						<td>{$belegung->ende}</td>
						<td><a href="../belegung/index.php?id={$belegung->id}">Bearbeiten</a>, <a href="../auszug/index.php?id={$belegung->id}">Auszug</a></td>
					</tr>
{foreachelse}
					<tr class="tableRowEmpty">
						<td colspan="4">- Keine Einträge vorhanden -</td>
					</tr>
{/foreach}
				</tbody>
			</table>
			<ul class="actions">
				<h3>Aktionen</h3>
				<li><a href="../neueinzug/index.php?zimmer={$belegung->zimmer}">Neueinzug</a></li>
			</ul>
		</div>
{/block}
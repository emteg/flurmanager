{extends file="../../layout.tpl"}
{block name=title}{$flurName} - Alle Benutzer{/block}
{block name=body}
		<div class="contentBox">
			<h2>Alle Benutzer</h2>
			<table>
				<thead>
					<tr>
						<th>Benutzer</th>
						<th>Bewohner</th>
						<th>Aktiviert</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
{foreach key=k item=user from=$users}
					<tr {cycle values=',class="tableRowDark"'}>
						<td>{$user->name}</td>
						<td>{$belegungen[$k]->bewohner->vorname} {$belegungen[$k]->bewohner->nachname}, {$belegungen[$k]->getZimmerNummer()}</td>
						<td>
							{if $user->istAktiviert}
							Ja
							{else}
							Nein
							{/if}
						</td>
						<td><a href="../index.php?id={$user->id}">Bearbeiten</a></td>
					</tr>
{foreachelse}
					<tr>
						<td colspan="4">- Keine Benutzer vorhanden -</td>
					</tr>
{/foreach}			
				</tbody>
			</table>
			
			<ul class="actions">
				<h3>Aktionen</h3>
				<li><a href="../../registrieren/">Benutzer registrieren</a></li>
			</ul>
		</div>
{/block}
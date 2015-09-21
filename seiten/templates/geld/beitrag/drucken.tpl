<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Flurbeitrag {$semester}</title>
		<style>
			body {
				font-family: sans-serif;
			}
			table {
				border-collapse: collapse;
			}
			
			table, th, td {
				border: 1px solid #000000;
				padding: 2px;
			}
			
			.tableRowDark {
				background-color: #DDDDDD;
			}
			
			.tableRowEmpty {
				text-align: center;
			}
			
			.geld {
				text-align: right;
			}
			
			.width250 {
				float: left;
				width: 250px;
			}
			
			.width70right {
				width: 70px;
				float: left;
				text-align: right;
			}
			
			.centered {
				text-align: center;
			}
		</style>
	</head>
	<body>
		<h1>Flurbeitrag {$semester}</h1>
		<table>
			<thead>
				<tr>
					<th>Zimmer</th>
					<th>Name</th>
					<th>Guthaben</th>
				</tr>
			</thead>
			<tbody>
{foreach $belegungen as $key => $belegung name=loop}
				<tr {cycle values=',class="tableRowDark"'}>
					<td>{$belegung->getZimmerNummer()}</td>
					<td>{$belegung->bewohner->vorname} {$belegung->bewohner->nachname}</td>
					{if $guthaben[$key]["istNegativ"]}
					<td class="geld"><b>{$guthaben[$key]["guthaben"]}</b></td>
					{else}
					<td class="geld">{$guthaben[$key]["guthaben"]}</td>
					{/if}
				</tr>
	{if $smarty.foreach.loop.last}
				<tr {cycle values=',class="tableRowDark"'}>
					<td colspan="2" class="geld">Summe</td>
					<td class="geld">{str_replace(".", ",", $summeGuthaben)} €</td>
				</tr>
	{/if}
{foreachelse}
				<tr class="tableRowEmpty">
					<td colspan="3">- Keine Daten vorhanden-</td>
				</tr>
{/foreach}
			</tbody>
		</table>
		<p>
			<span class="width250">Bargeld in der Flurkasse:</span><span class="width70right">{str_replace(".", ",", $kassenstand)} €</span><br/>
			<span class="width250">Saldo der Flurkasse:</span><span class="width70right">{str_replace(".", ",", $kassenstand - $summeGuthaben)} €</span><br/>
			<span class="width250">Einnahmen dieses Semester:</span><span class="width70right">{str_replace(".", ",", $einnahmen)} €</span><br/>
			<span class="width250">Ausgaben dieses Semester:</span><span class="width70right">{str_replace(".", ",", $ausgaben)} €</span><br/>
		</p>
		<p>Stand: {$heute}</p>
	</body>
</html>

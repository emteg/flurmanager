{extends file="../../layout.tpl"}
{block name=title}{$flurName} - Buchung bearbeiten{/block}
{block name=body}
		<div class="contentBox">
			<h2>Buchung von <a href="../guthaben/index.php?id={$buchung->bewohner->id}">{$buchung->bewohner->vorname} {$buchung->bewohner->nachname}</a> bearbeiten</h2>
			<form action="speichern.php" method="post">
				<ul class="formUl">
					<li>
						<label for="datum" class="formCaption">Datum</label>
						<input type="text" name="datum" class="formInputSmall" value="{$buchung->datum}" placeholder="JJJJ-MM-TT">
					</li>
					<li>
						<label for="betreff" class="formCaption">Betreff</label>
						<input type="text" name="betreff" class="formInput" value="{$buchung->betreff}" placeholder="Betreff">
					</li>
					<li>
						<label for="betrag" class="formCaption">Betrag</label>
						<input type="text" name="betrag" class="formInputSmall" value="{str_replace(".", ",", $buchung->betrag)}" placeholder="Betrag">
					</li>
					<li>
						<label for="typ" class="formCaption">Typ</label>
						<select class="formInputSmall" name="typ">
							<option value="0" {if $buchung->istGeld && !$buchung->istGuthaben}selected{/if}>Bargeld</option>
							<option value="1" {if $buchung->istGuthaben && !$buchung->istGeld}selected{/if}>Guthaben</option>
							<option value="2" {if $buchung->istGeld && $buchung->istGuthaben}selected{/if}>Beides</option>
						</select>
					</li>
					<li>
						<input type="hidden" name="bewohnerId" value="{$buchung->bewohner->id}">
						<input type="submit" value="Änderungen speichern"/>
					</li>
				</ul>
				<p><strong>Hinweis zu "Typ":</strong> <em>Bargeld</em> bedeutet, dass Geld aus der Flurkasse genommen oder hineingelegt wird. <em>Guthaben</em> bedeutet, dass der Betrag mit dem Flurbeitrag eines Bewohners verrechnet wird. <em>Beides</em> bedeutet, dass einem Mitbewohner Geld ausgezahlt wird bzw. das ein Mitbewohner Geld einzahlt.</p>
				<input type="hidden" name="id" value="{$buchung->id}">
			</form>
			<ul class="actions">
				<h3>Aktionen</h3>
				<li><a href="../loeschen/index.php?id={$buchung->id}">Löschen</a></li>
			</ul>
		</div>
{/block}
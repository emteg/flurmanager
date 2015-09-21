{extends file="../../layout.tpl"}
{block name=title}{$flurName} - Flurbeitrag abbuchen{/block}
{block name=body}
		<div class="contentBox">
			<h2>Flurbeitrag abbuchen</h2>
			<p>{$semester}</p>
			<form action="abbuchen_ausfuehren.php" method="post">
			<ul  class="formUl">
				<li>
					<label for="grundbetrag" class="formCaption">Grundbetrag</label>
						<input type="text" name="grundbetrag" class="formInputSmall" placeholder="0,00" onkeyup="grundbetragKeyUp(this.value);">
						<span class="formHint">Monatlich fälliger Flurbeitrag von allen Mitbewohnern.</span> Bis zu <span id="summeGrundbetrag">0,00</span> €.
				</li>
				<li>
					<label for="zusatzbetrag" class="formCaption">Optional</label>
					<input type="text" name="zusatzbetrag" class="formInputSmall" placeholder="0,00" onkeyup="zusatzbetragKeyUp(this.value);">
					<span class="formHint">Optionaler zusätzlicher Beitrag.</span> Bis zu <span id="summeZusatzbetrag">0,00</span> €.
				</li>
				<li>
				</li>
			</ul>
{foreach $belegungen as $belegung}
			<div class="formTableRow">
				<span class="formTableCell75">
					<label for="id[]" class="formLabel75">Buchen</label>
					<input  type="checkbox" name="id[]" value="{$belegung->bewohner->id}" checked/>
				</span>
				<span class="formTableCell200">
					<label class="formLabel200">Belegung</label>
					{$belegung->bewohner->vorname} {$belegung->bewohner->nachname}, {$belegung->getZimmerNummer()}
				</span>
				<span class="formTableCell75">
					<label for="monate[{$belegung->bewohner->id}]" class="formLabel75">Monate</label>
					<select class="formInput75" name="monate[{$belegung->bewohner->id}]">
	{for $i = 1 to 5}
						<option value="{$i}">{$i}</option>
	{/for}
						<option value="6" selected>6</option>
					</select>
				</span>
				<span class="formTableCell75">
					<label for="zusatz[{$belegung->bewohner->id}]" class="formLabel75">Zusatz</label>
					<input  type="checkbox" name="zusatz[{$belegung->bewohner->id}]" checked/>
				</span>
			</div>
{/foreach}
			<div style="margin-top: 5px" id="submitDiv">
				<input type="submit" value="Weiter &gt; &gt;">
			</div>
			<input type="hidden" name="semester" value="{$semester}" />
			</form>
		</div>
{/block}
{block name=bodyScript}
		<script>
			var zimmerAnzahl = {$zimmerAnzahl};
			
			function grundbetragKeyUp(value) {
				berechnen(value, "summeGrundbetrag");
			}
			
			function zusatzbetragKeyUp(value) {
				berechnen(value, "summeZusatzbetrag");
			}
			
			function berechnen(value, id) {
				var betrag = value.replace(",", ".");
				var summe = zimmerAnzahl * 6 * betrag;
				
				var span = document.getElementById(id);
				span.innerHTML = summe;
			}
		</script>
{/block}
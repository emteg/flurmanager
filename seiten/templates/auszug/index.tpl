{extends file="../layout.tpl"}
{block name=title}{$flurName} - Auszug{/block}
{block name=body}
		<div class="contentBox">
			<h2>Auszug von {$belegung->bewohner->vorname} {$belegung->bewohner->nachname}, {$belegung->getZimmerNummer()}</h2>
			<form action="speichern.php" method="post">
				<ul  class="formUl">
					<li>
						<label for="auszugsdatum"  class="formCaption">Auszugsdatum</label>
						<input type="text" name="auszugsdatum" value="{$auszugsDatum}" placeholder="JJJJ-MM-TT" class="formInputSmall">
						<span class="formHint">Datum, zu dem der Bewohner auszieht, in der Form JJJJ-MM-TT.</span>
					</li>
					<li>
						<input type="submit" value="Weiter &gt; &gt;">
					</li>
				</ul>
				<input type="hidden" name="id" value="{$belegung->id}">
			</form>
		</div>
{/block}
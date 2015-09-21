{extends file="../layout.tpl"}
{block name=title}{$flurName} - Registrieren{/block}
{block name=body}
		<div class="contentBox">
			<h2>Registrieren</h2>
			<form method="post" action="./registrieren.php">
			{if isset($fehler)}
			<p>{$fehler}</p>
			{/if}
				<p>Der Account muss nach der Registrierung noch freigeschaltet werden.</p>
				<ul class="formUl">
					<li>
						<label for="bewohner" class="formCaption">Bewohner</label>
						<select name="bewohnerId" class="formInput">
						{foreach $belegungen as $belegung}
							<option value="{$belegung->bewohnerId}">{$belegung->getZimmerNummer()} - {$belegung->bewohner->vorname} {$belegung->bewohner->nachname}</option>
						{foreachelse}
							<option value="-1">Es sind keine Bewohner vorhanden.</option>
						{/foreach}
						</select>
					</li>
					<li>
						<label for="name" class="formCaption">Benutzername</label>
						<input type="text" name="name" class="formInput" placeholder="3 bis 50 Zeichen">
						<span class="formHint">Muss einzigartig sein.</span>
					</li>
					<li>
						<label for="passwort1" class="formCaption">Passwort</label>
						<input type="password" name="passwort1" class="formInput" placeholder="3 bis 50 Zeichen">
					</li>
					<li>
						<label for="passwort2" class="formCaption">Wiederholen</label>
						<input type="password" name="passwort2" class="formInput" placeholder="Passwort wiederholen">
					</li>
					<li>
						<input type="submit" value="Registrieren"/>
					</li>
				</ul>
			</form>
		</div>
{/block}
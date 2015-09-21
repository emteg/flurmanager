{extends file="../layout.tpl"}
{block name=title}{$flurName} - Benutzer {$user->name}{/block}
{block name=body}
		<div class="contentBox">
			<h2>Benutzer {$user->name}</h2>
			<form action="speichern.php" method="post">
				<ul class="formUl">
					<li>
						<label class="formCaption">Bewohner</label>
						{$belegung->bewohner->vorname} {$belegung->bewohner->nachname}, {$belegung->getZimmerNummer()}
					</li>
					<li>
						<label for="istAktiviert" class="formCaption">Ist aktiviert</label>
						<input type="checkbox" name="istAktiviert" {if $user->istAktiviert}checked{/if}>
					</li>
					<li>
						<label for="passwort1" class="formCaption">Passwort ändern</label>
						<input type="password" name="passwort1" class="formInput" placeholder="Neues Passwort eingeben">
						<span class="formHint">3 bis 50 Zeichen.</span>
					</li>
					<li>
						<label for="passwort2" class="formCaption">Wiederholen</label>
						<input type="password" name="passwort2" class="formInput" placeholder="Neues Passwort wiederholen">
					</li>
					<li>
			   <input type="hidden" name="id" value="{$user->id}">
						<input type="submit" value="Änderungen speichern"/>
					</li>
				</ul>
			</form>
			<ul class="actions">
				<h3>Aktionen</h3>
				<li><a href="./alle/">Alle Benutzer ansehen</a></li>
			</ul>
		</div>
{/block}
{extends file="../layout.tpl"}
{block name=title}{$flurName} - Login{/block}
{block name=body}
		<div class="loginBox">
			<h2>Login</h2>
			<div class="loginBoxBackground">
			<p>{$message}</p>
			<form action="index.php?target={$target}" method="post">
				<ul class="formUl">
					<li>
						<label for="name" class="formCaption">Benutzername</label>
						<input type="text" class="formInput100" name="name" placeholder="Benutzername"/>
					</li>
					<li>
						<label for="passwort" class="formCaption">Passwort</label>
						<input type="password" class="formInput100" name="passwort" placeholder="Passwort"/>
					</li>
					<li>
						<input type="submit" value="Anmelden"/>
					</li>
				</ul>
			</form>
			<p><a href="../registrieren/">Registrieren</a></p>
			</div>
		</div>
{/block}
{extends file="../layout.tpl"}
{block name=title}{$flurName} - Wiedereinzug{/block}
{block name=body}
		<div class="contentBox">
			<h2>Wiedereinzug</h2>
			<form action="speichern.php" method="post">
				<ul class="formUl">
					<li>
						<label for="bewohnerName" class="formCaption">Mitbewohner</label>
						<input type="text" name="bewohnerName" class="formInput" placeholder="Vor- und/oder Nachname eingeben" onkeyup="suchen(this.value)" list="datalist" onblur="ausgewaehlt(this.value)">
						<datalist id="datalist">
						
						</datalist>
						<span class="formHint">Den ehemaligen Mitbewohner auswählen, der wieder einziehen soll.</span>
					</li>
					<li>
						<label for="zimmer" class="formCaption">Zimmer</label>
						<select name="zimmer" class="formInput">
{foreach $zimmer as $aktuell}
	{if $aktuell["istBelegt"]}
		{if $aktuell["freiAb"]}
							<option value="{$aktuell["nummer"]};{$aktuell["belegung"]->id}">
								{$aktuell["bezeichnung"]} - Frei nach dem {$aktuell["freiAb"]} - {$aktuell["belegung"]->bewohner->vorname} {$aktuell["belegung"]->bewohner->nachname}
							</option>
		{else}
							<option value="{$aktuell["nummer"]};{$aktuell["belegung"]->id}">
								{$aktuell["bezeichnung"]} - {$aktuell["belegung"]->bewohner->vorname} {$aktuell["belegung"]->bewohner->nachname}
							</option>
		{/if}
	{else}
							<option value="{$aktuell["nummer"]};0" selected>
								{$aktuell["bezeichnung"]} - Frei
							</option>
	{/if}
{/foreach}						
						</select>
						<span>Das Zimmer, in das der ehemalige Mitbewohner einziehen soll.</span>
					</li>
					<li>
						<label for="einzugsdatum" class="formCaption">Einzugsdatum</label>
						<input type="text" name="einzugsdatum" class="formInput" placeholder="JJJJ-MM-TT" value="{$einzugsDatum}"/>
						<span class="formHint">Falls das Zimmer zum angegebenen Einzugsdatum noch belegt ist, wird die Belegung beendet ("auszug").</span>
					</li>
					<li>
						<input type="hidden" name="bewohnerId" value="" id="bewohnerIdInput"/>
						<input type="submit" value="Weiter &gt; &gt;">
					</li>
				</ul>
			</form>
		</div>
{/block}
{block name=bodyScript}
		<script>		
			var ids = new Array();
			var list;
			var selectedId = 0;
		
			function suchen(value) {
				var params = value.split(" ");
				var url = "search.php?";
				
				for (var i = 0; i < params.length; i++) {
					if (params[i].length > 1) {
						url = url + "values[]=" + params[i];
						if (i < params.length - 1) {
							url = url + "&";
						}
					}
				}
				
				loadDoc(url);
			}
			
			function loadDoc(url) {
				if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp = new XMLHttpRequest();
        } else { // code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }

				xmlhttp.onreadystatechange = function() { handleServerResponse(xmlhttp); }			
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
			}
			
			function handleServerResponse(xmlhttp) {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					var answer = xmlhttp.responseText;
					ids = answer.substring(0, answer.indexOf(" ")).split(";");
					
					list = document.getElementById("datalist");
					list.innerHTML = answer.substring(answer.indexOf(" ") + 1, answer.length);
				}
			}
			
			function ausgewaehlt(wert) {
				selectedId = 0;
				for (var i = 0; i < list.options.length; i++) {
					if (list.options[i].value == wert) {
						selectedId = ids[i];	
						break;
					}
				}
				var input = document.getElementById("bewohnerIdInput");
				input.value = selectedId;
			}
		</script>
{/block}
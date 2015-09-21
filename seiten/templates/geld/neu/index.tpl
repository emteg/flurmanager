{extends file="../../layout.tpl"}
{block name=title}{$flurName} - Neue Zahlung(en) eintragen{/block}
{block name=body}
		<div class="contentBox">
			<h2>Neue Zahlung(en) eintragen</h2>
			<form action="speichern.php" method="post">
				<div class="formTableRow">
					<span class="formTableCell100">
						<label for="datum[0]" class="formLabel100">Datum</label>
						<input class="formInput100" type="text" name="datum[0]" placeholder="JJJJ-MM-TT" value="{$today}"/>
					</span>
					<span class="formTableCell100">
						<label for="typ[0]" class="formLabel100">Typ</label>
						<select class="formInput100" name="typ[0]" onkeyup="typGewaehlt(this)" onchange="typGewaehlt(this)" id="typ0">
							<option value="0">Bargeld</option>
							<option value="1">Guthaben</option>
							<option value="2">Beides</option>
						</select>
					</span>
					<span class="formTableCell200">
						<label for="bewohnerName[0]" class="formLabel200">Bewohner</label>
						<input type="text" class="formInput200" name="bewohnerName[0]" placeholder="Vor- und/oder Nachname" id="bewohnerName0" onkeyup="suchen(this)" list="list0" onblur="ausgewaehlt(this.value)" disabled>
						<datalist id="list0">
						
						</datalist>
						<input type="hidden" name="bewohnerId[0]" value="0" id="bewohnerId0">
					</span>
					<span class="formTableCell200">
						<label for="betreff[0]" class="formLabel200">Betreff</label>
						<input class="formInput200" type="text" name="betreff[0]" placeholder="Betreff" autocomplete="off"/>
					</span>
					<span class="formTableCell75">
						<label for="betrag[0]" class="formLabel75">Betrag</label>
						<input class="formInput75" type="text" name="betrag[0]" placeholder="0,00" autocomplete="off"/>
					</span>
					<span class="formTableCell150" id="addRowsButtons">
						<label class="formLabel150">Zeile(n)</label>
						<button type="button" id="oneMoreBtn" onclick="addRow(); return false;">+1</button>
						<button type="button" id="fiveMoreBtn" onclick="addFiveRows(); return false;">+5</button>
						<button type="button" id="tenMoreBtn" onclick="addTenRows(); return false;">+10</button>
					</span>
				</div>
				<div style="margin-top: 5px" id="submitDiv">
					<input type="submit" value="Weiter &gt; &gt;">
				</div>
				<p><strong>Hinweis zu "Betrag":</strong> positiv: Einzahlung und/oder Gutschrift, negativ: Auszahlung und/oder Lastschrift.
				<p><strong>Hinweis zu "Typ":</strong> <em>Bargeld</em> bedeutet, dass Geld aus der Flurkasse genommen oder hineingelegt wird. <em>Guthaben</em> bedeutet, dass der Betrag mit dem Flurbeitrag eines Bewohners verrechnet wird. <em>Beides</em> bedeutet, dass einem Mitbewohner Geld ausgezahlt wird bzw. das ein Mitbewohner Geld einzahlt.</p>
				<p><strong>Hinweis zu "Bewohner":</strong> Muss nur ausgefüllt werden, wenn der Typ <em>Guthaben</em> oder <em>Beides</em> ist.
			</form>
		</div>
{/block}
{block name=bodyScript}
		<script>
			var today = "{$today}";
			var rowCounter = 1;
			var vorschlaege;
			var ids;
			var zielListeName;
			var list;
			
			function typGewaehlt(sender) {
				var nummer = sender.id.substr(3, sender.id.length);
				var target = document.getElementById("bewohnerName" + nummer);
				if (sender.value > 0) {
					target.disabled = false;
				} else {
					target.disabled = true;
				}
			}
			
			function suchen(sender) {
				var params = sender.value.split(" ");
				zielListeName = sender.list.id;
				var url = "search.php?";
				
				for (var i = 0; i < params.length; i++) {
					if (params[i].length > 1) {
						if (i > 0) {
							url = url + "&";
						}
						url = url + "values[]=" + params[i];
					}
				}
				
				if (url != "search.php?") {
					loadDoc(url);
				}
			}
			
			function ausgewaehlt(wert) {
				var selectedId = 0;
				for (var i = 0; i < list.options.length; i++) {
					if (list.options[i].value == wert) {
						selectedId = ids[i];	
						break;
					}
				}
				var inputNummer = zielListeName.substr(4, zielListeName.length);
				var input = document.getElementById("bewohnerId" + inputNummer);
				input.value = selectedId;
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
					
					list = document.getElementById(zielListeName);
					list.innerHTML = answer.substring(answer.indexOf(" ") + 1, answer.length);
				}
			}
			
			function addTextCell(parent, name, label, size, placeholder, value, autocomplete) {
				var newSpan = document.createElement("span");
				newSpan.setAttribute("class", "formTableCell" + size);
				
				var newLabel = document.createElement("label");
				newLabel.setAttribute("for", name);
				newLabel.innerHTML = label;
				
				var newInput = document.createElement("input");
				newInput.setAttribute("class", "formInput" + size);
				newInput.setAttribute("type", "text");
				newInput.setAttribute("name", name);
				newInput.setAttribute("placeholder", placeholder);
				newInput.setAttribute("value", value);
				newInput.setAttribute("autocomplete", autocomplete);
				
				newSpan.appendChild(newLabel);
				newSpan.appendChild(newInput);
				parent.appendChild(newSpan);
				
				return newSpan;
			}
			
			function addTypCell(parent, name, label, size) {
				var newSpan = document.createElement("span");
				newSpan.setAttribute("class", "formTableCell" + size);
				
				var newLabel = document.createElement("label");
				newLabel.setAttribute("for", name);
				newLabel.innerHTML = label;
				
				var newSelect = document.createElement("select");
				newSelect.setAttribute("class", "formInput" + size);
				newSelect.setAttribute("name", name);
				newSelect.setAttribute("id", "typ" + rowCounter);
				newSelect.onkeyup = function() { typGewaehlt(this); }
				newSelect.onchange = function() { typGewaehlt(this); }
				
				var newOption = document.createElement("option");
				newOption.setAttribute("value", "0");
				newOption.innerHTML = "Bargeld";				
				newSelect.appendChild(newOption);
				
				newOption = document.createElement("option");
				newOption.setAttribute("value", "1");
				newOption.innerHTML = "Guthaben";				
				newSelect.appendChild(newOption);
				
				newOption = document.createElement("option");
				newOption.setAttribute("value", "2");
				newOption.innerHTML = "Beides";				
				newSelect.appendChild(newOption);
				
				newSpan.appendChild(newLabel);
				newSpan.appendChild(newSelect);
				parent.appendChild(newSpan);
				
				return newSpan;
			}
			
			function addBewohnerCell(parent) {
				var newSpan = document.createElement("span");
				newSpan.setAttribute("class", "formTableCell200");
				
				var newLabel = document.createElement("label");
				newLabel.setAttribute("for", "bewohnerName["+ rowCounter +"]");
				newLabel.innerHTML = "Bewohner";
				
				var newInput = document.createElement("input");
				newInput.setAttribute("class", "formInput200");
				newInput.setAttribute("type", "text");
				newInput.setAttribute("name", "bewohnerName["+ rowCounter +"]");
				newInput.setAttribute("placeholder", "Vor- und/oder Nachname");
				newInput.setAttribute("id", "bewohnerName" + rowCounter);
				newInput.setAttribute("list", "list" + rowCounter);
				newInput.disabled = true;
				newInput.onkeyup = function() { suchen(this) };
				newInput.onblur = function() { ausgewaehlt(this.value) }
				
				var newDataList = document.createElement("datalist");
				newDataList.setAttribute("id", "list" + rowCounter);
				
				var newHiddenInput = document.createElement("input");
				newHiddenInput.setAttribute("type", "hidden");
				newHiddenInput.setAttribute("name", "bewohnerId["+ rowCounter +"]");
				newHiddenInput.setAttribute("value", "0");
				newHiddenInput.setAttribute("id", "bewohnerId" + rowCounter);
				
				newSpan.appendChild(newLabel);
				newSpan.appendChild(newInput);
				newSpan.appendChild(newDataList);
				newSpan.appendChild(newHiddenInput);
				parent.appendChild(newSpan);
				
				return newSpan;
			}
			
			function addRow() {
				var lastRow = document.getElementById("submitDiv");
				var newRow = document.createElement("div");
				newRow.setAttribute("class", "formTableRow");
				
				addTextCell(newRow, "datum["+ rowCounter +"]", "Datum", "100", "JJJJ-MM-TT", today, "off");
				addTypCell(newRow, "typ["+ rowCounter +"]", "Typ", "100");
				addBewohnerCell(newRow);
				addTextCell(newRow, "betreff["+ rowCounter +"]", "Betreff", "200", "Betreff", "", "off");
				addTextCell(newRow, "betrag["+ rowCounter +"]", "Betrag", "75", "0,00", "", "off");
				
				rowCounter++;
				
				var addRowsButtonsSpan = document.getElementById("addRowsButtons");
				newRow.appendChild(addRowsButtonsSpan);
				
				lastRow.parentNode.insertBefore(newRow, lastRow);
			}
			
			function addTenRows() {
				for (var i = 0; i < 10; i++) {
					addRow();
				}
			}
			
			function addFiveRows() {
				for (var i = 0; i < 5; i++) {
					addRow();
				}
			}
		</script>
{/block}
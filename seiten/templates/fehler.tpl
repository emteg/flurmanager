{extends file="layout.tpl"}
{block name=title}Finanzen - Fehler{/block}
{block name=body}
		<div class="fehlerbox">
			<h2>Fehler: {$fehlerTitel}</h2>
			<p>{$fehlerText}</p>
		</div>
{/block}
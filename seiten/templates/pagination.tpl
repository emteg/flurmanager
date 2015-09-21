Seiten:
{if $pagination->getAktuelleSeite() == 0}
			<span class="pagination active">Erste</span>
{else}
			<a href="{$filename}?start=0&anzahl={$pagination->anzahl}" class="pagination">Erste</a>
{/if}
{if $pagination->getAnzahlSeiten() > 1}
	{for $i=2 to $pagination->getAnzahlSeiten() - 1}
		{if $pagination->getAktuelleSeite() == $i - 1}
			<span class="pagination active">{$i}</span>
		{else}
			<a href="{$filename}?start={($i - 1) * $pagination->anzahl}&anzahl={$pagination->anzahl}" class="pagination">{$i}</a>
		{/if}
	{/for}
{/if}
{if $pagination->getAktuelleSeite() == $pagination->getAnzahlSeiten() - 1}
			<span class="pagination active">Letzte</span>
{else}
			<a href="{$filename}?start={($pagination->getAnzahlSeiten() - 1) * $pagination->anzahl}&anzahl={$pagination->anzahl}" class="pagination">Letzte</a>
{/if}
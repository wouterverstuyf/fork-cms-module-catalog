{*
	variables that are available:
	- {$productsInShoppingCart}: contains data about the products
	- {$totalPrice}: total price of products
	- {$overviewUrl}: url to catalog page
*}

{option:cookiesEnabled}
<div id="CatalogShoppingCartWidget">
	{option:productsInShoppingCart}
		<p><strong>{$amountOfProducts} {$msgProductsInShoppingCart}</strong></p>
		<p class="txt-big">{$lblTotal|ucfirst}: {$totalPrice|formatcurrency}</p>
		<p class="btn-blue"><a href="{$overviewUrl}">{$lblGoToShoppingCartOverview|ucfirst}</a></p>
	{/option:productsInShoppingCart}

	{option:!productsInShoppingCart}
			<p>{$msgNoProductsInShoppingCart}</p>
	{/option:!productsInShoppingCart}
</div>
{/option:cookiesEnabled}

{option:!cookiesEnabled}
<div class="cookies">
		<p>{$msgEnableCookies}.</p>
</div>
{/option:!cookiesEnabled}


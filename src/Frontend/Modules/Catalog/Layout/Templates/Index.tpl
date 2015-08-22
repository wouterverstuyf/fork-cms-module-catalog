{*
	variables that are available:
	- {$products}: contains all products
*}

{option:products}
<ul class="overview">
  {iteration:products}
  <li>
    <h4><a href="{$products.full_url}" title="{$products.title}">{$products.title}</a></h4>
    <p class="image"><a href="{$products.full_url}" title="{$products.title}"><img src="{$products.image_thumb}" alt="{$products.title}" title="{$products.title}" /></a></p>
    <p class="price txt-big">{$products.price|formatcurrency}</p>
    <p class="addtocart addProductToShoppingCart btn-blue"><a href="#" id="{$products.id}">{$lblAddProductToShoppingCart|ucfirst}</a></p>
    <p class="more"><a href="{$products.full_url}" title="{$products.title}">{$lblReadMore|ucfirst}</a></p>
  </li>
  {/iteration:products}
</ul>
{/option:products}

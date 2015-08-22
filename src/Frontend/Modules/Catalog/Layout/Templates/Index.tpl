{*
	variables that are available:
	- {$categoriesFlat}: contains a flat array of all categories
	- {$categoriesTree}: multidimensional array of categories/subcategories
	- {$categoriesHTML} : contains the categories in html list
	- {$products}: contains all products
*}

{option:!categoriesHTML}
<div class="no-categories">
 {$msgNoCategories|ucfirst}
</div>
{/option:!categoriesHTML}

{option:categoriesHTML}
 <h4>{$lblCategories|ucfirst}</h4>
 <div class="bd content">
	{$categoriesHTML}
 </div>
{/option:categoriesHTML}

{option:products}
  <h4>{$lblProducts|ucfirst}</h4>
  <ul class="overview">
    {iteration:products}
    <li>
      <h4><a href="{$products.full_url}" title="{$products.title}">{$products.title}</a></h4>
      <p class="image"><img src="{$products.image_thumb}" alt="{$products.title}" title="{$products.title}" /></p>
      <p class="price txt-big">{$products.price|formatcurrency}</p>
      <p class="addtocart addProductToShoppingCart btn-blue"><a href="#" id="{$products.id}">{$lblAddProductToShoppingCart|ucfirst}</a></p>
      <p class="more"><a href="{$products.full_url}" title="{$products.title}">{$lblReadMore|ucfirst}</a></p>
    </li>
    {/iteration:products}
  </ul>
{/option:products}

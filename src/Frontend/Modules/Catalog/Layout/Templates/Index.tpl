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
 <h3>{$lblCategories|ucfirst}</h3>
 <div class="bd content">
	{$categoriesHTML}
 </div>
{/option:categoriesHTML}

{option:products}
  <h3>{$lblProducts|ucfirst}</h3>
  <ul>
    {iteration:products}
    <li>{$products.title}</li>
    {/iteration:products}
  </ul>
{/option:products}

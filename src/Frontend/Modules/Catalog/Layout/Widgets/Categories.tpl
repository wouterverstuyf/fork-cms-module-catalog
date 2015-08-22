{*
  NOTE: To add more levels

	variables that are available:
	- {$widgetCatalogCategoriesFlat}: Flat array of all categories
	- {$widgetCatalogCategoriesTree}: Tree array of all categories
*}

{* FLAT VIEW
{option:widgetCatalogCategoriesFlat}
<div id="CatalogCategoriesWidget" class="mdd">
	<h3>{$lblCategories|ucfirst}</h3>
	<ul>
		{iteration:widgetCatalogCategoriesFlat}
		<li>
			<a href="{$widgetCatalogCategoriesFlat.url}">
				{$widgetCatalogCategoriesFlat.title}&nbsp;({$widgetCatalogCategoriesFlat.total})
			</a>
		</li>
		{/iteration:widgetCatalogCategoriesFlat}
	</ul>
</div>
{/option:widgetCatalogCategoriesFlat}
*}

{* TREE VIEW *}
{option:widgetCatalogCategoriesTree}
<div id="CatalogCategoriesTreeWidget" class="mod">
  <h3>{$lblCategories|ucfirst}</h3>
  <ul>
 {iteration:widgetCatalogCategoriesTree}
    <li><a href="{$widgetCatalogCategoriesTree.full_url}" title="{$widgetCatalogCategoriesTree.title}">{$widgetCatalogCategoriesTree.title|ucfirst}&nbsp;({$widgetCatalogCategoriesTree.total})</a>
  {option:widgetCatalogCategoriesTree.children}
      <ul>
   {iteration:widgetCatalogCategoriesTree.children}
        <li><a href="{$widgetCatalogCategoriesTree.children.full_url}" title="{$widgetCatalogCategoriesTree.children.title}">{$widgetCatalogCategoriesTree.children.title|ucfirst}&nbsp;({$widgetCatalogCategoriesTree.children.total})</a>
    {option:widgetCatalogCategoriesTree.children.children}
          <ul>
     {iteration:widgetCatalogCategoriesTree.children.children}
            <li><a href="{$widgetCatalogCategoriesTree.children.children.full_url}" title="{$widgetCatalogCategoriesTree.children.children.title}">{$widgetCatalogCategoriesTree.children.children.title|ucfirst}&nbsp;({$widgetCatalogCategoriesTree.children.children.total})</a>
     {/iteration:widgetCatalogCategoriesTree.children.children}
            </li>
          </ul>
    {/option:widgetCatalogCategoriesTree.children.children}
   {/iteration:widgetCatalogCategoriesTree.children}
        </li>
      </ul>
  {/option:widgetCatalogCategoriesTree.children}
 {/iteration:widgetCatalogCategoriesTree}
    </li>
  </ul>
</div>
{/option:widgetCatalogCategoriesTree}

{include:{$BACKEND_CORE_PATH}/Layout/Templates/Head.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureStartModule.tpl}

<div class="pageTitle">
	<h2>
		{$lblCatalog|ucfirst}:

		{option:!filterCategory}{$lblProducts}{/option:!filterCategory}
		{option:filterCategory}{$msgProductsFor|sprintf:{$filterCategory.title}}{/option:filterCategory}
	</h2>

	<div class="buttonHolderRight">
		{option:filterCategory}<a href="{$var|geturl:'add':null:'&category={$filterCategory.id}'}" class="button icon iconAdd" title="{$lblAdd|ucfirst}">{/option:filterCategory}
		{option:!filterCategory}<a href="{$var|geturl:'add'}" class="button icon iconAdd" title="{$lblAdd|ucfirst}">{/option:!filterCategory}
			<span>{$lblAddProduct|ucfirst}</span>
		</a>
	</div>
</div>

{form:filter}
<div class="dataFilter">
	<table>
		<tbody>
			<tr>
				<td>
					<div class="options">
						<p>
							<label for="name">{$lblName|ucfirst}</label>
							{$txtName} {$txtNameError}
						</p>
					</div>
				</td>
				<td>
					<div class="options">
						<p>
							<label for="category">{$lblCategory|ucfirst}</label>
							{$ddmCategory} {$ddmCategoryError}
						</p>
					</div>
				</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="99">
					<div class="options">
						<div class="buttonHolder">
							<input id="search" class="inputButton button mainButton" type="submit" name="search" value="{$lblUpdateFilter|ucfirst}" />
						</div>
					</div>
				</td>
			</tr>
		</tfoot>
	</table>
</div>
{/form:filter}

{option:dgProducts}
	<div class="dataGridHolder">
		<div class="tableHeading">
			<h3>{$lblProducts|ucfirst}</h3>
		</div>
		{$dgProducts}
	</div>
{/option:dgProducts}

{option:!dgProducts}
	{option:filterCategory}<p>{$msgNoProducts|sprintf:{$var|geturl:'add':null:'&category={$filterCategory.id}'}}</p>{/option:filterCategory}
	{option:!filterCategory}<p>{$msgNoProducts|sprintf:{$var|geturl:'add'}}</p>{/option:!filterCategory}
{/option:!dgProducts}

{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureEndModule.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/Footer.tpl}

<?php

namespace Backend\Modules\Catalog\Actions;

/*
 * This file is part of Fork CMS.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

use Backend\Core\Engine\Base\ActionIndex as BackendBaseActionIndex;
use Backend\Core\Engine\Language as BL;
use Backend\Core\Engine\Authentication as BackendAuthentication;
use Backend\Core\Engine\Form as BackendForm;
use Backend\Core\Engine\Model as BackendModel;
use Backend\Core\Engine\DataGridDB as BackendDataGridDB;
use Backend\Core\Engine\DataGridFunctions as BackendDataGridFunctions;
use Backend\Modules\Catalog\Engine\Model as BackendCatalogModel;

/**
 * This is the index-action (default), it will display the overview of products
 *
 * @author Tim van Wolfswinkel <tim@webleads.nl>
 */
class Index extends BackendBaseActionIndex
{
  /**
   * Filter variables.
   *
   * @var    array
   */
  private $filter;

  /**
   * Form.
   *
   * @var BackendForm
   */
  private $frm;

	/**
	 * DataGrids
	 *
	 * @var	SpoonDataGrid
	 */
	private $dgProducts;

  /**
   * Builds the query for this datagrid.
   *
   * @return array  An array with two arguments containing the query and its parameters.
   */
  private function buildQuery()
  {
      // init var
      $parameters = array();

      // construct the query in the controller instead of the model as an allowed exception for data grid usage
      $query = '
      	SELECT i.id, i.title AS title, i.spotlight, pc.sequence
		 		FROM catalog_products_categories AS pc
		 		INNER JOIN catalog_categories AS c ON pc.category_id = c.id
		 		LEFT JOIN catalog_products AS i ON pc.product_id = i.id';

      $where = array();

      $where[] = 'i.language = ?';
      $parameters[] = BL::getWorkingLanguage();

      // add category
      if (isset($this->filter['category'])) {
        $where[] = 'pc.category_id = ?';
        $parameters[] = $this->filter['category'];
      }

      // add category
      if (isset($this->filter['name'])) {
        $where[] = 'i.title LIKE ?';
        $parameters[] = '%' . $this->filter['name'] . '%';
      }

      // query
      if (!empty($where)) {
        $query .= ' WHERE ' . implode(' AND ', $where);
      }

      $query .= ' GROUP BY pc.product_id ORDER BY pc.sequence ASC';

      // query with matching parameters
      return array($query, $parameters);
  }


	/**
	 * Execute the action
	 */
	public function execute()
	{
		parent::execute();
    $this->setFilter();
    $this->loadForm();
		$this->loadDataGrid();
		$this->parse();
		$this->display();
	}

	/**
	 * Load the dataGrid
	 */
	private function loadDataGrid()
	{
    // fetch query and parameters
    list($query, $parameters) = $this->buildQuery();

    // create datagrid
    $this->dgProducts = new BackendDataGridDB($query, $parameters);

		// // filter category
		if($this->filter['category'] != null ) {
			// sequence
			$this->dgProducts->enableSequenceByDragAndDrop();
			$this->dgProducts->setAttributes(array('data-action' => 'SequenceProducts'));

		}

		// our JS needs to know an id, so we can highlight it
		$this->dgProducts->setRowAttributes(array('id' => 'row-[id]', 'data-id' => '[id]-'.$this->filter['category']));

		// hide columns
 		$this->dgProducts->setColumnsHidden('sequence');

		// check if this action is allowed
		if(BackendAuthentication::isAllowedAction('Edit')) {
			// set column URLs
			$this->dgProducts->setColumnURL('title', BackendModel::createURLForAction('edit') . '&amp;id=[id]');

			// add edit and media column
			$this->dgProducts->addColumn('media', null, BL::lbl('Media'), BackendModel::createURLForAction('media') . '&amp;id=[id]', BL::lbl('Media'));
			$this->dgProducts->addColumn('edit', null, BL::lbl('Edit'), BackendModel::createURLForAction('edit') . '&amp;id=[id]', BL::lbl('Edit'));

			// set media column function
			$this->dgProducts->setColumnFunction(array(__CLASS__, 'setMediaLink'), array('[id]'), 'media');
		}
	}

  /**
   * Load the form.
   */
  private function loadForm()
  {
      // create form
      $this->frm = new BackendForm('filter', BackendModel::createURLForAction(), 'get');

      // values for dropdowns
      $categories = BackendCatalogModel::getCategoriesAsPairs();

			// add fields
			$this->frm->addText('name', $this->filter['name']);
			$this->frm->addDropdown('category', $categories, $this->filter['category']);
			$this->frm->getField('category')->setDefaultElement('');

      // manually parse fields
      $this->frm->parse($this->tpl);
  }

	/**
	 * Parse the page
	 */
	protected function parse()
	{
		// parse the datagrid for all products
		$this->tpl->assign('dgProducts', ($this->dgProducts->getNumResults() != 0) ? $this->dgProducts->getContent() : false);

    // parse filter
    $this->tpl->assign($this->filter);
	}

  /**
   * Sets the filter based on the $_GET array.
   */
  private function setFilter()
  {
    $this->filter['category'] = $this->getParameter('category');
    $this->filter['name'] = $this->getParameter('name');
  }

	/**
	 * Sets a link to the media overview
	 *
	 * @param int $productId The specific id of the product
	 * @return string
	 */
	public static function setMediaLink($productId)
	{
		return '<a class="button icon iconEdit linkButton" href="' . BackendModel::createURLForAction('media') . '&product_id=' . $productId . '">
					<span>' . BL::lbl('ManageMedia') . '</span>
				</a>';
	}
}

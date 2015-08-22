<?php

namespace Frontend\Modules\Catalog\Actions;

/*
 * This file is part of Fork CMS.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

use Frontend\Core\Engine\Base\Block as FrontendBaseBlock;
use Frontend\Core\Engine\Navigation as FrontendNavigation;
use Frontend\Core\Engine\Model as FrontendModel;
use Frontend\Modules\Catalog\Engine\Model as FrontendCatalogModel;

/**
 * This is the overview-action
 *
 * @author Tim van Wolfswinkel <tim@webleads.nl>
 */
class Index extends FrontendBaseBlock
{
    /**
     * The items
     *
     * @var    array
     */
    private $products;

    /**
     * The pagination array
     * It will hold all needed parameters, some of them need initialization.
     *
     * @var    array
     */
    protected $pagination = array('limit' => 10, 'offset' => 0, 'requested_page' => 1, 'num_items' => null, 'num_pages' => null);

    /**
     * Execute the action
     */
    public function execute()
    {
        parent::execute();
        $this->loadTemplate();
        $this->getData();
        $this->parse();
    }

    /**
     * Load the data, don't forget to validate the incoming data
     */
    private function getData()
    {
        // requested page
        $requestedPage = $this->URL->getParameter('page', 'int', 1);

        // set URL and limit
        $this->pagination['url'] = FrontendNavigation::getURLForBlock('catalog');
        $this->pagination['limit'] = FrontendModel::getModuleSetting('catalog', 'overview_num_items', 10);

        // populate count fields in pagination
        $this->pagination['num_items'] = FrontendCatalogModel::getAllCount();
        $this->pagination['num_pages'] = (int)ceil($this->pagination['num_items'] / $this->pagination['limit']);

        // num pages is always equal to at least 1
        if ($this->pagination['num_pages'] == 0) $this->pagination['num_pages'] = 1;

        // redirect if the request page doesn't exist
        if ($requestedPage > $this->pagination['num_pages'] || $requestedPage < 1) $this->redirect(FrontendNavigation::getURL(404));

        // populate calculated fields in pagination
        $this->pagination['requested_page'] = $requestedPage;
        $this->pagination['offset'] = ($this->pagination['requested_page'] * $this->pagination['limit']) - $this->pagination['limit'];

        // get tree of all categories
        $this->categoriesTree = FrontendCatalogModel::getCategoriesTree();

        // get all products
        $this->products = FrontendCatalogModel::getAll($this->pagination['limit'], $this->pagination['offset']);
    }

    /**
     * Parse the page
     */
    protected function parse()
    {
        // add css
        $this->header->addCSS('/src/Frontend/Modules/' . $this->getModule() . '/Layout/Css/catalog.css');

        // add noty js
        $this->header->addJS('/src/Frontend/Modules/' . $this->getModule() . '/Js/noty/packaged/jquery.noty.packaged.min.js');

        // assign items
        $this->tpl->assign('products', $this->products);

        // parse the pagination
        $this->parsePagination();
    }
}

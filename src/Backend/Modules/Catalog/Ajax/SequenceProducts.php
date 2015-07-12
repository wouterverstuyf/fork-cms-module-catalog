<?php

namespace Backend\Modules\Catalog\Ajax;

/*
 * This file is part of Fork CMS.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

use Backend\Core\Engine\Base\AjaxAction as BackendBaseAJAXAction;
use Backend\Core\Engine\Language as BL;
use Backend\Modules\Catalog\Engine\Model as BackendCatalogModel;

/**
 * Alters the sequence of Catalog categories
 *
 * @author Wouter Verstuyf <wouter@webflow.be>
 */
class SequenceProducts extends BackendBaseAJAXAction
{
  public function execute()
  {
    parent::execute();

    // get parameters
    $newIdSequence = trim(\SpoonFilter::getPostValue('new_id_sequence', null, '', 'string'));

    // list id
    $ids = (array) explode(',', rtrim($newIdSequence, ','));

    // loop id's and set new sequence
    foreach($ids as $i => $id) {

      $temp = explode('-', $id);
      $product = $temp[0];
      $category = $temp[1];

      $item['sequence'] = $i + 1;

      // update sequence
      BackendCatalogModel::updateProductCategorySequence($product, $category, $item);
    }

    // success output
    $this->output(self::OK, null, 'sequence updated');
  }
}

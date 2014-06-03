<?php

namespace Harp\MP;

use Harp\Harp\Rel;
use Harp\Core\Model\AbstractModel;
use Harp\Core\Repo\LinkOne;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class BelongsTo extends Rel\BelongsTo
{
    /**
     * @param  AbstractModel $model
     * @param  LinkOne       $link
     */
    public function update(AbstractModel $model, LinkOne $link)
    {
        parent::update($model, $link);

        if ($link->isChanged()) {
            $path = $link->get()->getChildrenPath();

            return $model->setPathAndUpdateDescendants($path);
        }
    }
}

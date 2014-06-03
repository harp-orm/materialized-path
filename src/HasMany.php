<?php

namespace Harp\MP;

use Harp\Harp\Rel;
use Harp\Core\Model\AbstractModel;
use Harp\Core\Model\Models;
use Harp\Core\Repo\LinkMany;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class HasMany extends Rel\HasMany
{
    /**
     * @param  AbstractModel $model
     * @param  LinkMany       $link
     */
    public function update(AbstractModel $model, LinkMany $link)
    {
        parent::update($model, $link);

        $affected = new Models();

        foreach ($link->getRemoved() as $removed) {
            $affected->addAll(
                $removed->setPathAndUpdateDescendants('')
            );
        }

        foreach ($link->getAdded() as $added) {
            $affected->addAll(
                $added->setPathAndUpdateDescendants(
                    $model->getChildrenPath()
                )
            );
        }

        return $affected;
    }
}

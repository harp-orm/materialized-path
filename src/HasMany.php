<?php

namespace Harp\MP;

use Harp\Harp\Rel;
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
     * @param  LinkMany       $link
     */
    public function update(LinkMany $link)
    {
        parent::update($link);

        $affected = new Models();

        foreach ($link->getRemoved() as $removed) {
            $affected->addAll(
                $removed->setPathAndUpdateDescendants('')
            );
        }

        foreach ($link->getAdded() as $added) {
            $affected->addAll(
                $added->setPathAndUpdateDescendants(
                    $link->getModel()->getChildrenPath()
                )
            );
        }

        return $affected;
    }
}

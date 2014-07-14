<?php

namespace Harp\MP;

use Harp\Harp\Rel;
use Harp\Harp\Repo\LinkOne;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class BelongsTo extends Rel\BelongsTo
{
    /**
     * @param  LinkOne       $link
     */
    public function update(LinkOne $link)
    {
        parent::update($link);

        if ($link->isChanged()) {
            $path = $link->get()->getChildrenPath();

            return $link->getModel()->setPathAndUpdateDescendants($path);
        }
    }
}

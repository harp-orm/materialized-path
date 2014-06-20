<?php

namespace Harp\MP;

use Harp\Core\Rel\AbstractRel;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
trait MPRepoTrait
{
    abstract public function addRel(AbstractRel $rel);

    public function initializeMaterializedPath()
    {
        return $this
            ->addRel(new BelongsTo('parent', $this, $this))
            ->addRel(new HasMany('children', $this, $this, ['foreignKey' => 'parentId']));
    }
}

<?php

namespace Harp\MP;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
trait MPRepoTrait
{
    public function initializeMaterializedPath()
    {
        $this
            ->addRel(new BelongsTo('parent', $this, $this))
            ->addRel(new HasMany('children', $this, $this, ['foreignKey' => 'parentId']));
    }
}

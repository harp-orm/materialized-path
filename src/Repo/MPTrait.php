<?php

namespace Harp\MP\Repo;

use Harp\Core\Rel\AbstractRel;
use Harp\MP\HasMany;
use Harp\MP\BelongsTo;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
trait MPTrait
{
    abstract public function addRel(AbstractRel $rel);

    public function initializeMaterializedPath()
    {
        return $this
            ->addRel(new BelongsTo('parent', $this, $this))
            ->addRel(new HasMany('children', $this, $this, ['foreignKey' => 'parentId']));
    }
}

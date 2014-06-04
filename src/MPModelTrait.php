<?php

namespace Harp\MP;

use Harp\Harp\AbstractModel;
use Harp\Core\Model\Models;
use Harp\Query\SQL\SQL;
use InvalidArgumentException;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
trait MPModelTrait
{
    public $path;
    public $parentId;

    /**
     * @return AbstractModel
     */
    public function getParent()
    {
        return $this->getRepo()->loadLink($this, 'parent')->get();
    }

    /**
     * @return AbstractModel $this
     */
    public function setParent(AbstractModel $model)
    {
        $this->assertNestedModel($model);

        $this->getRepo()->loadLink($this, 'parent')->set($model);

        return $this;
    }

    /**
     * @return \Harp\Core\Repo\LinkMany
     */
    public function getChildren()
    {
        return $this->getRepo()->loadLink($this, 'children');
    }

    /**
     * @return Models
     */
    public function getDescendants()
    {
        $path = $this->getChildrenPath();

        return $this->getRepo()->findAll()->whereLike('path', "{$path}%")->load();
    }

    /**
     * @param  AbstractModel $model
     * @throws InvalidArgumentException If model not part of the repo
     */
    public function assertNestedModel(AbstractModel $model)
    {
        if (! $this->getRepo()->getMpRepo()->isModel($model)) {
            throw new InvalidArgumentException('Model must be of same repo');
        }
    }

    /**
     * @param  AbstractModel $model
     * @throws InvalidArgumentException If model not part of the repo
     * @return boolean
     */
    public function isDescendantOf(AbstractModel $model)
    {
        $this->assertNestedModel($model);

        return in_array($model->getId(), $this->getPathIds());
    }

    /**
     * @param  AbstractModel $model
     * @throws InvalidArgumentException If model not part of the repo
     * @return boolean
     */
    public function isAnsestorOf(AbstractModel $model)
    {
        $this->assertNestedModel($model);

        return $model->isDescendantOf($this);
    }

    /**
     * @return boolean
     */
    public function isRoot()
    {
        return empty($this->parentId);
    }

    /**
     * @return array
     */
    public function getPathIds()
    {
        return $this->path ? explode('/', $this->path) : [];
    }

    /**
     * @return string
     */
    public function getChildrenPath()
    {
        return $this->path ? $this->path.'/'.$this->getId() : $this->getId();
    }

    /**
     * @return Models
     */
    public function updateDescendants($path)
    {
        $descendants = $this->getDescendants();

        foreach ($descendants as $item) {
            $item->path = trim(str_replace($this->path, $path, $item->path), '/');
        }

        return $descendants;
    }

    /**
     * @return Models
     */
    public function setPathAndUpdateDescendants($path)
    {
        $descendants = $this->updateDescendants($path);

        $this->path = $path;

        return $descendants;
    }

    /**
     * @return Models
     */
    public function getAnsestors()
    {
        $pathIds =  $this->getPathIds();

        if (empty($pathIds)) {
            return new Models();
        } else {
            $repo = $this->getRepo();

            return $repo->findAll()
                ->whereIn($repo->getPrimaryKey(), $pathIds)
                ->load();
        }
    }
}

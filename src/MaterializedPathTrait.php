<?php

namespace Harp\MP;

use Harp\Harp\AbstractModel;
use Harp\Harp\Repo;
use Harp\Core\Model\Models;
use Harp\Core\Repo\AbstractLink;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
trait MaterializedPathTrait
{
    public static function initialize(Repo $repo)
    {
        return $repo
            ->addRel(new BelongsTo('parent', $repo, $repo))
            ->addRel(new HasMany('children', $repo, $repo, ['foreignKey' => 'parentId']));
    }

    public $path;
    public $parentId;

    /**
     * @param  string $name
     * @return AbstractLink
     */
    abstract public function getLink($name);

    abstract public function getId();

    /**
     * @param  string $name
     * @return AbstractModel
     */
    abstract public function get($name);

    /**
     * @param  string $name
     * @return \Harp\Core\Models\AbstractModel
     */
    abstract public function set($name, \Harp\Core\Models\AbstractModel $Model);

    /**
     * @param  string $name
     * @return \Harp\Core\Repo\LinkMany
     */
    abstract public function all($name);

    /**
     * @return AbstractModel
     */
    public function getParent()
    {
        return $this->get('parent');
    }

    /**
     * @param  AbstractModel $model
     * @return AbstractModel $this
     */
    public function setParent(AbstractModel $model)
    {
        static::getRepo()->assertModel($model);

        $this->set('parent', $model);

        return $this;
    }

    /**
     * @return \Harp\Core\Repo\LinkMany
     */
    public function getChildren()
    {
        return $this->all('children');
    }

    /**
     * @return Models
     */
    public function getDescendants()
    {
        $path = $this->getChildrenPath();

        return static::whereLike('path', "{$path}%")->load();
    }

    /**
     * @param  AbstractModel $model
     * @return boolean
     */
    public function isDescendantOf(AbstractModel $model)
    {
        static::getRepo()->assertModel($model);

        return in_array($model->getId(), $this->getPathIds());
    }

    /**
     * @param  AbstractModel $model
     * @return boolean
     */
    public function isAnsestorOf(AbstractModel $model)
    {
        static::getRepo()->assertModel($model);

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
            return static::whereIn(static::getPrimaryKey(), $pathIds)->load();
        }
    }
}
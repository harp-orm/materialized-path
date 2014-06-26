Materialized Path
=================

[![Build Status](https://travis-ci.org/harp-orm/materialized-path.svg?branch=master)](https://travis-ci.org/harp-orm/materialized-path)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/harp-orm/materialized-path/badges/quality-score.png)](https://scrutinizer-ci.com/g/harp-orm/materialized-path/)
[![Code Coverage](https://scrutinizer-ci.com/g/harp-orm/materialized-path/badges/coverage.png)](https://scrutinizer-ci.com/g/harp-orm/materialized-path/)
[![Latest Stable Version](https://poser.pugx.org/harp-orm/materialized-path/v/stable.svg)](https://packagist.org/packages/harp-orm/materialized-path)

Materialized path nesting for Harp ORM models.

What is Materialized path? Here's a great explanation: http://bojanz.wordpress.com/2014/04/25/storing-hierarchical-data-materialized-path/
This package does not implement the most advanced implementation, but it works quite well as is.

Usage
-----

Add the Traits to your Model / Repo

```php
// Model Class
use Harp\MP\MPTrait;

class Category extends AbstractModel
{
    use MPTrait;
    // ...
}

// Repo Class
use Harp\MP\MPTrait;

class Category extends AbstractRepo
{
    use MPRepoTrait;

    public function initialize()
    {
        $this->initializeMaterializedPath();

        // Other initializations
        // ...
    }
}

```

__Database Table:__

```
┌─────────────────────────┐
│ Table: Category         │
├─────────────┬───────────┤
│ id          │ ingeter   │
│ name        │ string    │
│ parentId*   │ integer   │
│ path*       │ string    │
└─────────────┴───────────┘
* Required fields
```

Methods
-------

It will add "parent" and "children" Rels to the repo. The model will get the convenience methods:

Method                                    | Description
------------------------------------------|--------------------------------------------------
__getParent__()                           | Return the immidiate parent model
__setParent__(AbstractModel $parent)      | Set the immidiate parent model, after save the changes are propogated to all the children
__getChildren__()                         | Get immidiate children. Returns a Models object
__isRoot__()                              | Boolean check if it is root (has parent) or not
__getDescendants__()                      | Returns all the children and the children's children. Models object
__getAnsestors__()                        | Return all the parents, including root. Models object
__isDescendantOf__(AbstractModel $parent) | Chech if a model is descendant
__isAnsestorOf__(AbstractModel $parent)   | Chech if model is ansestor

License
-------

Copyright (c) 2014, Clippings Ltd. Developed by Ivan Kerin

Under BSD-3-Clause license, read LICENSE file.

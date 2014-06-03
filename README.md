Materialized Path
=================

[![Build Status](https://travis-ci.org/harp-orm/materialized-path.svg?branch=master)](https://travis-ci.org/harp-orm/materialized-path)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/harp-orm/materialized-path/badges/quality-score.png)](https://scrutinizer-ci.com/g/harp-orm/materialized-path/)
[![Code Coverage](https://scrutinizer-ci.com/g/harp-orm/materialized-path/badges/coverage.png)](https://scrutinizer-ci.com/g/harp-orm/materialized-path/)
[![Latest Stable Version](https://poser.pugx.org/harp-orm/materialized-path/v/stable.svg)](https://packagist.org/packages/harp-orm/materialized-path)

Materialized path nesting for Harp ORM models


Usage
-----

Add the Traits to your models / Repos

```php
// Model Class
use Harp\Nested\NestedModelTrait;

class Category extends AbstractModel
{
    use NestedModelTrait;
}

// Repo Class
use Harp\Nested\NestedRepoTrait;

class Category extends AbstractRepo
{
    use NestedRepoTrait;

    public function initialize()
    {
        $this->initializeNested();

        // Other initializations
        // ...
    }
}

```

Required Fields in the database
-------------------------------

To function properly it requires:

- ``parentId`` unsigned int
- ``path`` varchar

in the database table for the model.

Methods
-------

It will add "parent" and "children" Rels to the repo. The model will get the convenience methods:

- ``getParent``
- ``setParent``
- ``getChildren``
- ``isRoot``
- ``getDescendants``
- ``getAnsestors``
- ``isDescendantOf``
- ``isAnsestorOf``

License
-------

Copyright (c) 2014, Clippings Ltd. Developed by Ivan Kerin

Under BSD-3-Clause license, read LICENSE file.

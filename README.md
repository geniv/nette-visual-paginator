Visual paginator
================
Paginator component

Installation
------------
```sh
$ composer require geniv/nette-visual-paginator
```
or
```json
"geniv/nette-visual-paginator": ">=1.0.0"
```

require:
```json
"php": ">=5.6.0",
"nette/nette": ">=2.4.0"
```

Include in application
----------------------
neon configure:
```neon
services:
    - VisualPaginator
```

presenters:
```php
use VisualPaginator;
...
/** @var VisualPaginator @inject */
public $visualPaginator;
...
public function render...()
    // for dibi
    $items = $this->model->getList();

    $items = range(1, 150);

    $vp = $this->visualPaginator->getPaginator();
    $vp->setItemCount(count($items))
        ->setItemsPerPage(5);

    // for dibi
    $this->template->items = $items->limit($vp->getLength())->offset($vp->getOffset());

    // for array
    $this->template->items = array_slice($items, $vp->getOffset(), $vp->getLength())
}
...
protected function createComponentVisualPaginator()
{
    //$this->visualPaginator->setPathTemplate(__DIR__.'/VisualPaginator.latte');
    return $this->visualPaginator;
}
```
and
```php
use VisualPaginator;
...
$vp = $this['VisualPaginator']->getPaginator();
...
protected function createComponentVisualPaginator(VisualPaginator $visualPaginator): VisualPaginator
{
    //$visualPaginator->setPathTemplate(__DIR__.'/templates/VisualPaginator.latte');
    return $visualPaginator;
}
```

usage:
```latte
{control visualPaginator}
or
{control visualPaginator, count=>200, perPage=>5}
```

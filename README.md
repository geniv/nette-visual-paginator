Visual paginator
================

inspiration: https://github.com/iPublikuj/visual-paginator

Installation
------------
```sh
$ composer require geniv/nette-visual-paginator
```
or
```json
"geniv/nette-visual-paginator": "^1.1"
```

require:
```json
"php": ">=7.0",
"nette/application": ">=2.4",
"nette/utils": ">=2.4",
"geniv/nette-general-form": ">=1.0"
```

Include in application
----------------------
neon configure:
```neon
services:
    - VisualPaginator\VisualPaginator
```

renderer (implements `IPaginatorRenderer`):
```php
BasicRenderer
1 2 3 4 5 6 7 8 9 10

AdvanceTypeARenderer(['relatedPages'=>3, 'count'=>4])
1 2 3 4 ... 13 ... 26 ... 38 ... 50

AdvanceTypeBRenderer(['part' => 3, 'middle' => 2])
1 2 3 ... 48 49 50
```

presenters:
```php
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
    //$this->visualPaginator->setTemplatePath(__DIR__.'/VisualPaginator.latte');
    $this->visualPaginator->setPaginatorRenderer(new BasicRenderer);
    return $this->visualPaginator;
}
```

or

```php
$vp = $this['VisualPaginator']->getPaginator();

...

protected function createComponentVisualPaginator(VisualPaginator $visualPaginator): VisualPaginator
{
    //$visualPaginator->setTemplatePath(__DIR__.'/templates/visualPaginator.latte');
    $visualPaginator->setPaginatorRenderer(new BasicRenderer);

    $visualPaginator->onSelectPage[] = function (int $page) {
        if ($this->isAjax()){
            $this->redrawControl('grid');
        }
    };

    return $visualPaginator;
}
```

callback:
```php
onSelectPage(int $page)
```

usage:
```latte
{control visualPaginator}
or
{control visualPaginator, count=>200, perPage=>5}

{* link for presenter: *}
<a href="{plink this, 'page'=>$step}" n:class="$step==$paginator->getPage()?active, ajax">{$step}</a>

{* link for component: *}
<a n:href="this, 'page'=>$step" n:class="$step==$paginator->getPage()?active, ajax">{$step}</a>

{* link for ajax: *}
<a n:href="SelectPage!, 'page'=>$step" n:class="$step==$paginator->getPage()?active, ajax">{$step}</a>
```

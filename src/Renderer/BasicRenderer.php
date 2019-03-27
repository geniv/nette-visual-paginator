<?php declare(strict_types=1);

namespace VisualPaginator\Renderer;

use Nette\Utils\Paginator;


/**
 * Class BasicRenderer
 *
 * @author  geniv
 * @package VisualPaginator\Renderer
 */
class BasicRenderer implements IPaginatorRenderer
{

    /**
     * Get steps.
     *
     * @param Paginator $paginator
     * @return array
     */
    public function getSteps(Paginator $paginator): array
    {
        return range($paginator->getFirstPage(), $paginator->getLastPage());
    }
}

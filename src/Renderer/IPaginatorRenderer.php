<?php declare(strict_types=1);

namespace VisualPaginator\Renderer;

use Nette\Utils\Paginator;


/**
 * Interface IPaginatorRenderer
 *
 * @author  geniv
 * @package VisualPaginator\Renderer
 */
interface IPaginatorRenderer
{
    /**
     * Get steps.
     *
     * @param Paginator $paginator
     * @return array
     */
    public function getSteps(Paginator $paginator): array;
}

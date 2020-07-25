<?php declare(strict_types=1);

namespace VisualPaginator;

/**
 * Interface VisualPaginatorFactory
 *
 * @author  hermajan
 * @author  geniv
 * @package VisualPaginator
 */
interface VisualPaginatorFactory
{
    /**
     * @return VisualPaginator
     */
    public function create(): VisualPaginator;
}

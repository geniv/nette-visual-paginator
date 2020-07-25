<?php declare(strict_types=1);

namespace VisualPaginator;

/**
 * Class VisualPaginatorFactory
 *
 * @package VisualPaginator
 */
interface VisualPaginatorFactory
{
    public function create(): VisualPaginator;
}

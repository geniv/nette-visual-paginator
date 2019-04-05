<?php declare(strict_types=1);

namespace VisualPaginator\Renderer;

use Nette\Utils\Paginator;


/**
 * Class AdvanceTypeARenderer
 *
 * @see https://github.com/iPublikuj/visual-paginator
 * @author  geniv
 * @package VisualPaginator\Renderer
 */
class AdvanceTypeARenderer implements IPaginatorRenderer
{
    /** @var array */
    private $options = [];


    /**
     * AdvanceTypeARenderer constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
    }


    /**
     * Get steps.
     *
     * @param Paginator $paginator
     * @param array     $options
     * @return array
     */
    public function getSteps(Paginator $paginator, array $options = []): array
    {
        $options = array_merge($this->options, $options);

        $relatedPages = $options['relatedPages'] ?? 3;
        $count = $options['count'] ?? 4;
        $page = $paginator->page;
        $arr = range(max($paginator->firstPage, $page - $relatedPages), min($paginator->lastPage, $page + $relatedPages));
        $quotient = ($paginator->pageCount - 1) / $count;
        for ($i = 0; $i <= $count; $i++) {
            $arr[] = round($quotient * $i) + $paginator->firstPage;
        }
        sort($arr);
        $steps = array_values(array_unique($arr));
        return $steps;
    }
}

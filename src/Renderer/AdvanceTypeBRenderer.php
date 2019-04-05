<?php declare(strict_types=1);

namespace VisualPaginator\Renderer;

use Nette\Utils\Paginator;


/**
 * Class AdvanceTypeBRenderer
 *
 * @author  geniv
 * @package VisualPaginator\Renderer
 */
class AdvanceTypeBRenderer implements IPaginatorRenderer
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

        $part = $options['part'] ?? 3;
        $middle = $options['middle'] ?? 2;

        $min = $part + $middle + 1 + $middle + $part;

        $page = $paginator->page;
        if ($min > $paginator->getPageCount()) {
            $steps = range($paginator->getFirstPage(), $paginator->getLastPage());
        } else {
            $steps = range($paginator->getFirstPage(), $part);
            if ($page >= $middle && $page <= $paginator->getLastPage() - $middle + 1) {
                $steps = array_merge($steps, range(max($page - $middle, $part + 1), min($page + $middle, $paginator->getLastPage() - $middle - 1)));
            }
            $steps = array_merge($steps, range($paginator->getLastPage() + 1 - $part, $paginator->getLastPage()));  //OK
        }
        return $steps;
    }
}

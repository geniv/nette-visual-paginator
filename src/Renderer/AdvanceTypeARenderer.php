<?php declare(strict_types=1);

namespace VisualPaginator\Renderer;

use Nette\Utils\Paginator;


/**
 * Class AdvanceTypeARenderer
 *
 * @author  geniv
 * @package VisualPaginator\Renderer
 */
class AdvanceTypeARenderer implements IPaginatorRenderer
{

    /**
     * Get steps.
     *
     * @param Paginator $paginator
     * @param array     $options
     * @return array
     */
    public function getSteps(Paginator $paginator, array $options = []): array
    {
        return range($paginator->getFirstPage(), $paginator->getLastPage());
//
//        $relatedPages = $this->displayRelatedPages ?: 3;
//        $arr = range(max($paginator->firstPage, $page - $relatedPages), min($paginator->lastPage, $page + $relatedPages));
//        $count = 4;
//        $quotient = ($paginator->pageCount - 1) / $count;
//        for ($i = 0; $i <= $count; $i++) {
//            $arr[] = round($quotient * $i) + $paginator->firstPage;
//        }
//        sort($arr);
//        $steps = array_values(array_unique($arr));
//        $paginator = $this->getPaginator();
//        $page = $paginator->page;
//        if ($paginator->pageCount < 2) {
//            $steps = array($page);
//        } else {
//            $arr = range(max($paginator->firstPage, $page - 3), min($paginator->lastPage, $page + 3));
//            if ($this->countBlocks) {
//                $quotient = ($paginator->pageCount - 1) / $this->countBlocks;
//                for ($i = 0; $i <= $this->countBlocks; $i++) {
//                    $arr[] = round($quotient * $i) + $paginator->firstPage;
//                }
//            }
//            sort($arr);
//            $steps = array_values(array_unique($arr));
//        }


    }
}

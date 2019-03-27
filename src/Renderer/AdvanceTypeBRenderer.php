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
//        foreach (range(1, 100) as $page) {
//            $paginator = new Paginator;
//
//            $items = range(1, 500);
//            $paginator->setItemCount(count($items))
//                ->setItemsPerPage(5)
//                ->setPage($page);
//
////        $option = ['fullStep' => 10, 'firstPart' => 5, 'lastPart' => 5, 'middleStep' => 2, 'middleFirstStep' => 3, 'middleLastStep' => 3];
//
//            $part = 3;
//            $middle = 2;
//
//            $min = $part + $middle + 1 + $middle + $part;
//
//            if ($min > $paginator->getPageCount()) {
//                $steps = range($paginator->getFirstPage(), $paginator->getLastPage());
//            } else {
//                $steps = range($paginator->getFirstPage(), $part);
//                if ($page >= $middle && $page <= $paginator->getLastPage() - $middle + 1) {
//                    $steps = array_merge($steps, range(max($page - $middle, $part + 1), min($page + $middle, $paginator->getLastPage() - $middle - 1)));
//                }
//                $steps = array_merge($steps, range($paginator->getLastPage() + 1 - $part, $paginator->getLastPage()));  //OK
//            }
//            dump($page . ' : ' . implode(' - ', $steps));
//        }

    }
}

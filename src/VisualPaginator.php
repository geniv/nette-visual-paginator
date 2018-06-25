<?php declare(strict_types=1);

use GeneralForm\ITemplatePath;
use Nette\Utils\Paginator;
use Nette\Application\UI\Control;
use Nette\Localization\ITranslator;


/**
 * Class VisualPaginator
 *
 * @author  geniv
 */
class VisualPaginator extends Control implements ITemplatePath
{
    /** @var Paginator */
    private $paginator;
    /** @persistent */
    public $page = 1;
    /** @var ITranslator */
    private $translator;
    /** @var string path to template */
    private $pathTemplate;
    /** @var array */
    private $options;


    /**
     * VisualPaginator constructor.
     *
     * @param ITranslator|null $translator
     */
    public function __construct(ITranslator $translator = null)
    {
        parent::__construct();

        $this->translator = $translator;
        $this->pathTemplate = __DIR__ . '/VisualPaginator.latte';
    }


    /**
     * Get paginator.
     *
     * @return Paginator
     */
    public function getPaginator(): Paginator
    {
        if (!$this->paginator) {
            $this->paginator = new Paginator;
        }
        return $this->paginator;
    }


    /**
     * Set template path.
     *
     * @param string $path
     */
    public function setTemplatePath(string $path)
    {
        $this->pathTemplate = $path;
    }


    /**
     * Set options.
     *
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }


    /**
     * Render.
     *
     * @param array $options
     * @return void
     */
    public function render(array $options = null)
    {
        $template = $this->getTemplate();
        $paginator = $this->getPaginator();

        if (isset($options['count'])) {
            $paginator->setItemCount($options['count']);
        }

        if (isset($options['perPage'])) {
            $paginator->setItemsPerPage($options['perPage']);
        }

        $page = $paginator->getPage();

        $fullStep = $this->options['fullStep'] ?? 10;
        $firstPart = $this->options['firstPart'] ?? 5;
        $lastPart = $this->options['lastPart'] ?? 5;
        $middleStep = $this->options['middleStep'] ?? 2;
        $middleFirstStep = $this->options['middleFirstStep'] ?? 3;
        $middleLastStep = $this->options['middleLastStep'] ?? 3;

        if ($paginator->getPageCount() <= $fullStep) {
            $steps = range($paginator->getFirstPage(), $paginator->getLastPage());
        } else {
            if ($page <= $firstPart) {
                // first part
                $steps = range($paginator->getFirstPage(), $firstPart);
                $steps[] = $paginator->getLastPage();
            } else if ($page >= $firstPart && ($paginator->getLastPage() + 1) - $page > $lastPart) {
                // middle part
                $steps = range($paginator->getFirstPage(), $middleFirstStep);
                $steps = array_merge($steps, range($page - $middleStep, $page + $middleStep));
                $steps = array_merge($steps, range(($paginator->getLastPage() + 1) - $middleLastStep, $paginator->getLastPage()));
            } else if ($paginator->getLastPage() - $page <= $lastPart) {
                // last part
                $steps[] = $paginator->getFirstPage();
                $steps = array_merge($steps, range(($paginator->getLastPage() + 1) - $lastPart, $paginator->getLastPage()));
            }
        }

//        if ($paginator->getPageCount() < 2) {
//            $steps = array($page);
//        } else {
//            $arr = range(max($paginator->getFirstPage(), $page - 3), min($paginator->getLastPage(), $page + 3));
//            $count = 4;
//            $quotient = ($paginator->getPageCount() - 1) / $count;
//            for ($i = 0; $i <= $count; $i++) {
//                $arr[] = round($quotient * $i) + $paginator->getFirstPage();
//            }
//            sort($arr);
//            $steps = array_values(array_unique($arr));
//        }

        $template->steps = $steps;
        $template->paginator = $paginator;

        $template->setTranslator($this->translator);
        $template->setFile($this->pathTemplate);
        $template->render();
    }


    /**
     * Load state.
     *
     * @param array $params
     * @throws \Nette\Application\BadRequestException
     */
    public function loadState(array $params)
    {
        parent::loadState($params);
        $this->getPaginator()->page = $this->page;
    }
}

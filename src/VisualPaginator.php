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
     * Set page.
     *
     * @param int $page
     */
    public function setPage(int $page)
    {
        $this->paginator->setPage($page);
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
     * Render.
     *
     * @param array $options
     * @return void
     */
    public function render(array $options = null)
    {
        $template = $this->getTemplate();
        $paginator = $this->getPaginator();

        if (isset($options)) {
            $paginator->setItemCount($options['count']);
            $paginator->setItemsPerPage($options['perPage']);
        }

        $page = $paginator->getPage();

        if ($paginator->getPageCount() < 2) {
            $steps = array($page);
        } else {
            $arr = range(max($paginator->getFirstPage(), $page - 3), min($paginator->getLastPage(), $page + 3));
            $count = 4;
            $quotient = ($paginator->getPageCount() - 1) / $count;
            for ($i = 0; $i <= $count; $i++) {
                $arr[] = round($quotient * $i) + $paginator->getFirstPage();
            }
            sort($arr);
            $steps = array_values(array_unique($arr));
        }

        $template->steps = $steps;
        $template->paginator = $paginator;

        $template->setTranslator($this->translator);
        $template->setFile($this->pathTemplate);
        $template->render();
    }


    /**
     * Loads state informations.
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

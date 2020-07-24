<?php declare(strict_types=1);

namespace VisualPaginator;

use GeneralForm\ITemplatePath;
use Nette\Application\BadRequestException;
use Nette\Application\UI\Control;
use Nette\Localization\ITranslator;
use Nette\Utils\Paginator;
use stdClass;
use VisualPaginator\Renderer\BasicRenderer;
use VisualPaginator\Renderer\IPaginatorRenderer;


/**
 * Class VisualPaginator
 *
 * @author  geniv
 * @package VisualPaginator
 * @method onSelectPage(int $page)
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
    private $options = [];
    /** @var IPaginatorRenderer */
    private $paginatorRenderer;
    /** @var array */
    public $onSelectPage;


    /**
     * VisualPaginator constructor.
     *
     * @param ITranslator|null        $translator
     * @param IPaginatorRenderer|null $paginatorRenderer
     */
    public function __construct(ITranslator $translator = null, IPaginatorRenderer $paginatorRenderer = null)
    {
        $this->translator = $translator;
        $this->paginatorRenderer = $paginatorRenderer;
        $this->pathTemplate = __DIR__ . '/VisualPaginator.latte';
    }


    /**
     * Get paginator renderer.
     *
     * @return IPaginatorRenderer
     */
    public function getPaginatorRenderer(): IPaginatorRenderer
    {
        return $this->paginatorRenderer;
    }


    /**
     * Set paginator renderer.
     *
     * @param IPaginatorRenderer $paginatorRenderer
     * @return VisualPaginator
     */
    public function setPaginatorRenderer(IPaginatorRenderer $paginatorRenderer)
    {
        $this->paginatorRenderer = $paginatorRenderer;
        return $this;
    }


    /**
     * Get paginator.
     * Singleton.
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
     * @return VisualPaginator
     */
    public function setTemplatePath(string $path)
    {
        $this->pathTemplate = $path;
        return $this;
    }


    /**
     * Set options.
     *
     * @param array $options
     * @return VisualPaginator
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }


    /**
     * Handle select page.
     *
     * @param int $page
     */
    public function handleSelectPage(int $page)
    {
        $this->onSelectPage($page);
    }


    /**
     * Render.
     *
     * @param array $options
     * @return void
     */
    public function render(array $options = [])
    {
        $template = $this->getTemplate();
        $paginator = $this->getPaginator();

        if (isset($options['itemCount'])) {
            $paginator->setItemCount($options['itemCount']);
        }

        if (isset($options['itemsPerPage'])) {
            $paginator->setItemsPerPage($options['itemsPerPage']);
        }

        if (!$this->paginatorRenderer) {
            $this->paginatorRenderer = new BasicRenderer;
        }
        // use global options and rewrite with local options
        /** @var stdClass $template */
        $template->steps = $this->paginatorRenderer->getSteps($paginator, array_merge($this->options, $options));
        $template->paginator = $paginator;

        /** @noinspection PhpUndefinedMethodInspection */
        $template->setTranslator($this->translator);
        $template->setFile($this->pathTemplate);
        $template->render();
    }


    /**
     * Load state.
     *
     * @param array $params
     * @throws BadRequestException
     */
    public function loadState(array $params): void
    {
        parent::loadState($params);

        $page = $this->page;    // send to persistent parameter
        $this->onSelectPage($page);
        $this->getPaginator()->page = $page;
    }
}

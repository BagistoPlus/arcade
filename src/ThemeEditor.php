<?php

namespace EldoMagan\BagistoArcade;

class ThemeEditor
{
    protected $renderingLayout = '';

    protected $renderingView = '';

    protected $renderingSectionGroup = 'beforeContent';

    protected $renderedSections = [];

    protected $templates = [];

    public function active()
    {
        return request()->query->has('designMode');
    }

    public function inDesignMode()
    {
        return $this->active();
    }

    public function isPreviewMode()
    {
        return request()->query->has('previewMode');
    }

    public function registerTemplateForRoute($routeName, $template)
    {
        $this->templates[$routeName] = $template;
    }

    public function renderingView($view)
    {
        if ($view) {
            $this->renderingView = $view;
        }

        return $this->renderingView;
    }

    public function startRenderingTemplate()
    {
        $this->renderingSectionGroup = 'beforeContent';
    }

    public function stopRenderingTemplate()
    {
        $this->renderingSectionGroup = 'afterTemplate';
    }

    public function startRenderingLayout()
    {
        $this->renderingSectionGroup = 'beforeTemplate';
    }

    public function startRenderingContent()
    {
        $this->renderingSectionGroup = 'content';
    }

    public function stopRenderingContent()
    {
        $this->renderingSectionGroup = 'afterContent';
    }

    public function collectRenderedSection($type, $viewType, $viewName, $id = null)
    {
        if ('layouts' === $viewType && ! $this->renderingLayout) {
            $this->startRenderingLayout();
            $this->renderingLayout = $viewName;
        }

        $this->renderedSections[] = [
            'id' => $id ?: $type,
            'group' => $this->renderingSectionGroup,
        ];
    }

    public function renderedSections()
    {
        return $this->renderedSections;
    }
}

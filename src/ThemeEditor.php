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
        return self::inDesignMode();
    }

    public static function inDesignMode()
    {
        return request()->query->has('designMode') || request()->headers->has('x-arcade-editor-theme');
    }

    public static function inPreviewMode()
    {
        return request()->query->has('previewMode') || request()->headers->has('x-arcade-preview-theme');
    }

    public static function editorTheme()
    {
        if (self::inDesignMode()) {
            return request()->query->get('designMode', request()->headers->get('x-arcade-editor-theme'));
        }

        return request()->query->get('previewMode', request()->headers->get('x-arcade-preview-theme'));
    }

    public function registerTemplateForRoute($routeName, array $template)
    {
        $this->templates[$routeName] = $template;
    }

    public function getTemplateForRoute($routeName)
    {
        if (isset($this->templates[$routeName])) {
            return $this->templates[$routeName]['template'];
        }

        return 'index';
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

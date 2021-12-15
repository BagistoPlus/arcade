<?php

namespace EldoMagan\BagistoArcade\View;

class BladeDirectives
{
    public static function viewInfo()
    {
        $path = app('blade.compiler')->getPath();
        $filename = basename($path);
        $folder = basename(dirname($path));
        list($viewName) = explode('.', $filename);

        return [
            'type' => $folder,
            'view' => $viewName,
            'path' => $path,
            'name' => $folder . '/' . $viewName,
        ];
    }

    public static function arcadeLayoutContent()
    {
        $viewInfo = self::viewInfo();

        if ('layouts' !== $viewInfo['type']) {
            throw new \Exception('You should use @arcade_layout_content only inside layout views');
        }

        return '<?php echo $__env->yieldContent(\'layout_content\'); ?>';
    }

    public static function arcadeContent()
    {
        return '<?php $__env->startSection(\'layout_content\'); ?>';
    }

    public static function endArcadeContent()
    {
        return '<?php $__env->stopSection(); ?>';
    }

    public static function arcadeDynamicContent($template)
    {
        $viewInfo = self::viewInfo();

        if ('templates' !== $viewInfo['type']) {
            throw new \Exception('You should use @arcade_dynamic_content only inside template views');
        }

        $compiled = app('blade.compiler')->compileString(
            "@includeIf('shop::__dynamic.{$viewInfo['view']}')"
        );

        return $compiled;
    }

    public static function arcadeSlot($expression)
    {
        return sprintf("<?php echo view_render_event(%s); ?>", $expression);
    }
}

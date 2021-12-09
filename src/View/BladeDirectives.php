<?php

namespace EldoMagan\BagistoArcade\View;

use EldoMagan\BagistoArcade\Exceptions\SectionNotFoundException;
use EldoMagan\BagistoArcade\Facades\Sections;

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

    public static function arcadeSection($expression)
    {
        $viewInfo = self::viewInfo();

        if (! in_array($viewInfo['type'], ['templates', 'layouts'])) {
            throw new \Exception('You should use @arcade_section only inside templates or layouts views');
        }

        $type = str_replace(["'", '"'], '', $expression);

        if (! Sections::has($type)) {
            throw new SectionNotFoundException(sprintf(
                "Can not found section '%s'.",
                $type
            ));
        }

        $section = Sections::get($type);

        $compiled = app('blade.compiler')->compileString(
            $section->renderToBlade($section->slug)
        );

        return "<?php
arcade()->collectSectionData('{$section->slug}');
arcade()->collectSectionGlobals('{$section->slug}', collect(get_defined_vars()['__data'] ?: [])->except(['__env', 'app']));
?>
$compiled";
    }

    public static function arcadeSlot($expression)
    {
        return sprintf("<?php echo view_render_event(%s); ?>", $expression);
    }
}

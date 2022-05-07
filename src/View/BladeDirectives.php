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

        $themeEditorBefore = "<?php
if (arcadeEditor()->active()) {
    arcadeEditor()->renderingView('{$viewInfo['name']}');
    arcadeEditor()->startRenderingTemplate();
}
?>";

        $themeEditorAfter = "<?php
if (arcadeEditor()->active()) {
    arcadeEditor()->stopRenderingTemplate();
}
?>";

        return $themeEditorBefore . '
<?php echo $__env->yieldContent(\'layout_content\'); ?>
' . $themeEditorAfter;
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

        return "<?php
if (arcadeEditor()->active()) {
    arcadeEditor()->startRenderingContent();
}
?>
$compiled
<?php
if (arcadeEditor()->active()) {
    arcadeEditor()->stopRenderingContent();
}
?>";
    }

    public static function arcadeSlot($expression)
    {
        return sprintf("<?php echo view_render_event(%s); ?>", $expression);
    }

    public static function preserveQueryString()
    {
        return "<?php
foreach (\$_GET as \$key => \$value) {
    echo \"<input type='hidden' name='\" . e(\$key) . \"' value='\" . e(\$value) . \"'>\";
}
?>";
    }
}

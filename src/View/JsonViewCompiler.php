<?php

namespace EldoMagan\BagistoArcade\View;

use EldoMagan\BagistoArcade\Exceptions\SectionNotFoundException;
use EldoMagan\BagistoArcade\Facades\Sections;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Compilers\Compiler;
use Illuminate\View\Compilers\CompilerInterface;
use Symfony\Component\Yaml\Yaml;

class JsonViewCompiler extends Compiler implements CompilerInterface
{
    public const EXTENSIONS = ['json', 'yml', 'yaml'];

    private $bladeCompiler;

    /**
     * Create a new compiler instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @param  string  $cachePath
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(Filesystem $files, $cachePath, BladeCompiler $bladeCompiler)
    {
        parent::__construct($files, $cachePath);
        $this->bladeCompiler = $bladeCompiler;
    }

    /**
     * Compile the view at the given path.
     *
     * @param  string|null  $path
     * @return void
     */
    public function compile($path = null)
    {
        if (is_null($path) || is_null($this->cachePath)) {
            return;
        }

        $bladeTemplate = $this->compileToBlade($path);

        $compiled = $this->bladeCompiler->compileString($bladeTemplate);
        $compiled = $this->injectThemeEditorMetadata($compiled);
        $compiled = $this->appendFilePath($compiled, $path);

        $this->ensureCompiledDirectoryExists(
            $compiledPath = $this->getCompiledPath($path)
        );

        $this->files->put($compiledPath, $compiled);
    }

    protected function compileToBlade($path)
    {
        $jsonView = $this->loadView($path);

        if (null === $jsonView || ! isset($jsonView['sections']) || ! isset($jsonView['order'])) {
            return '';
        }

        return collect($jsonView['order'])
            ->map(function ($sectionId) use ($jsonView, $path) {
                $sectionData = $jsonView['sections'][$sectionId];
                $section = Sections::get($sectionData['type']);

                if (! $section) {
                    throw new SectionNotFoundException(sprintf(
                        "Can not found section '%s' used in template %s",
                        $sectionData['type'],
                        $path
                    ));
                }

                list($templateName) = explode('.', basename($path));

                return "<?php
arcade()->collectSectionData('$sectionId', '$path');
arcade()->collectSectionGlobals('$sectionId', collect(get_defined_vars()['__data'] ?: [])->except(['__env', 'app']));
if (arcadeEditor()->active()) {
    arcadeEditor()->collectRenderedSection('{$section->slug}', 'templates', '$templateName', '$sectionId');
}
?>
{$section->renderToBlade($sectionId)}";
            })
            ->join("\n");
    }

    protected function loadView($path)
    {
        $viewExtension = pathinfo($path, PATHINFO_EXTENSION);

        if ($viewExtension === 'json') {
            return json_decode($this->files->get($path), true);
        }

        return Yaml::parse($this->files->get($path));
    }

    protected function injectThemeEditorMetadata($content)
    {
        return "<?php
if (arcadeEditor()->active()) {
    arcadeEditor()->startRenderingContent();
}
?>
$content
<?php
if (arcadeEditor()->active()) {
    arcadeEditor()->stopRenderingContent();
}
?>";
    }

    /**
     * Append the file path to the compiled string.
     *
     * @param  string  $contents
     * @return string
     */
    protected function appendFilePath($contents, $path)
    {
        $tokens = $this->getOpenAndClosingPhpTokens($contents);

        if ($tokens->isNotEmpty() && $tokens->last() !== T_CLOSE_TAG) {
            $contents .= ' ?>';
        }

        return $contents."<?php /**PATH {$path} ENDPATH**/ ?>";
    }

    /**
     * Get the open and closing PHP tag tokens from the given string.
     *
     * @param  string  $contents
     * @return \Illuminate\Support\Collection
     */
    protected function getOpenAndClosingPhpTokens($contents)
    {
        return collect(token_get_all($contents))
            ->pluck(0)
            ->filter(function ($token) {
                return in_array($token, [T_OPEN_TAG, T_OPEN_TAG_WITH_ECHO, T_CLOSE_TAG]);
            });
    }
}

<?php

namespace EldoMagan\BagistoArcade\View;

use EldoMagan\BagistoArcade\Exceptions\SectionNotFoundException;
use EldoMagan\BagistoArcade\Facades\Sections;
use Illuminate\View\Compilers\ComponentTagCompiler;

class ArcadeTagsCompiler extends ComponentTagCompiler
{
    public function compile($value)
    {
        $this->aliases = $this->blade->getClassComponentAliases();
        $this->namespaces = $this->blade->getClassComponentNamespaces();

        return parent::compile($this->compileSelftClosingSectionTag($value));
    }

    public function compileSelftClosingSectionTag($value)
    {
        $viewInfos = BladeDirectives::viewInfo();
        $pattern = '<\s*arcade:section\s*name="(?<name>[^\'"]+)"\s*\/>';

        return preg_replace_callback($pattern, function (array $matches) use ($viewInfos) {
            if (! in_array($viewInfos['type'], ['templates', 'layouts'])) {
                throw new \Exception('You should use @arcade_section only inside templates or layouts views');
            }

            $sectionName = $matches['name'];

            if (! Sections::has($sectionName)) {
                throw new SectionNotFoundException(sprintf(
                    "Can not found section '%s'.",
                    $sectionName
                ));
            }

            $section = Sections::get($sectionName);

            $template = trim($section->renderToBlade($section->slug), '<>');

            return "<?php
arcade()->collectSectionData('{$section->slug}');
arcade()->collectSectionGlobals('{$section->slug}', collect(get_defined_vars()['__data'] ?: [])->except(['__env', 'app']));
?>
$template";
        }, $value);
    }
}

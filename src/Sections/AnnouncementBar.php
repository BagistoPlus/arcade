<?php

namespace EldoMagan\BagistoArcade\Sections;

use EldoMagan\BagistoArcade\SettingTypes\CheckboxType;
use EldoMagan\BagistoArcade\SettingTypes\SelectType;
use EldoMagan\BagistoArcade\SettingTypes\TextType;

class AnnouncementBar extends BladeSection
{
    public static function description(): string
    {
        return __('arcade::app.sections.annoucement-bar.description');
    }

    public static function settings(): array
    {
        return [
            CheckboxType::make('show_announcement', __('arcade::app.sections.annoucement-bar.show_annoucement'))
                ->default(true)
                ->info(__('arcade::app.sections.announcement-bar.show_announcement_info')),

            TextType::make('announcement', __('arcade::app.sections.annoucement-bar.title'))
                ->default(__('arcade::app.sections.annoucement-bar.default-content'))
                ->info(__('arcade::app.sections.annoucement-bar.content-info')),

            SelectType::make('position', __('arcade::app.sections.annoucement-bar.position'))
                ->options([
                    'left' => __('arcade::app.sections.annoucement-bar.position-left'),
                    'center' => __('arcade::app.sections.annoucement-bar.position-center'),
                    'right' => __('arcade::app.sections.annoucement-bar.position-right'),
                ])
                ->default('center')
                ->info(__('arcade::app.sections.annoucement-bar.position-info')),
        ];
    }

    public function render()
    {
        return view('shop::sections.announcement-bar');
    }
}

<?php

namespace EldoMagan\BagistoArcade\Sections;

interface SectionInterface
{
    public static function slug();

    public static function label();

    public static function wrapper();

    public static function settings();

    public static function blocks();

    public static function maxBlocks();

    public static function description();

    public static function previewImageUrl();

    public static function previewDescription();
}

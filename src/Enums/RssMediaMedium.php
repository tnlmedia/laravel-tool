<?php

namespace TNLMedia\LaravelTool\Enums;

enum RssMediaMedium: string
{
    case Image = 'image';
    case Audio = 'audio';
    case Video = 'video';
    case Document = 'document';
    case Executable = 'executable';
}

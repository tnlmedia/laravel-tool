<?php

namespace TNLMedia\LaravelTool\Enums;

enum SitemapPriority: string
{
    case Index = '1.0';
    case Menu = '0.9';
    case Category = '0.8';
    case Collection = '0.6';
    case Article = '0.5';
}

<?php


namespace App\Services\Log;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function __construct(private LogProvider $logProvider)
    {

    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getLatestLogs', [$this->logProvider, 'getLatestLogs']),
        ];
    }
}
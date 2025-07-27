<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use App\Notification\SaisonNotification;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension implements GlobalsInterface
{
    private $saisonNotification;

    public function __construct(SaisonNotification $saisonNotification)
    {
        $this->saisonNotification = $saisonNotification;
    }

    public function getGlobals(): array
    {
        return [
            'saison' => $this->saisonNotification->saison(),
        ];
    }
}


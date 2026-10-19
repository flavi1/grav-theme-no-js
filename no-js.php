<?php
namespace Grav\Theme;

use Grav\Common\Grav;
use Grav\Common\Theme;

class NoJs extends Theme
{

    public static function getSubscribedEvents(): array
    {
        return [
            'onThemeInitialized' => ['onThemeInitialized', 0]
        ];
    }
    
    public function fetchMessages(): array
    {
        $session = $this->grav['session'];
        $messages = $session->public_messages ?? [];
        if (!empty($messages)) {
            unset($session->public_messages);
        }
        return $messages;
    }
    
    static public function addMessage(string $message, string $scope = 'info'): void
    {
		$grav = Grav::instance();
        $session = $grav['session'];
        $messages = $session->public_messages ?? [];
        $messages[] = [
            'message' => $message,
            'scope'   => $scope
        ];
        $session->public_messages = $messages;
    }

    public function onThemeInitialized(): void
    {
        if ($this->isAdmin()) {
            $this->active = false;
            return;
        }

        $this->enable([
            'onTwigSiteVariables' => ['onTwigSiteVariables', 0]
        ]);
    }

    public function onTwigSiteVariables(): void
    {
		$this->grav['twig']->twig_vars['public_messages'] = $this->fetchMessages();
        $this->grav['assets']
            ->addCss('plugin://css/mytheme-core.css')
            ->addCss('plugin://css/mytheme-custom.css');
    }
}

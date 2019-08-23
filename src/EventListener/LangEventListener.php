<?php

namespace App\EventListener;


use App\Service\Translator;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class LangEventListener
{
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $translator = new Translator($request);
        $request->attributes->set('translator', $translator);
    }
}
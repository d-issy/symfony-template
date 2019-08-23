<?php
/**
 * Created by IntelliJ IDEA.
 * User: shepabashi
 * Date: 2019-08-24
 * Time: 00:36
 */

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
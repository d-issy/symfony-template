<?php

namespace App\Service;


use Symfony\Component\HttpFoundation\Request;

class Translator
{
    const LANG_EN = 'en';
    const LANG_JA = 'ja';

    const LANG_DEFAULT = self::LANG_EN;
    const LANGUAGES = [self::LANG_EN, self::LANG_JA];

    /** @var string */
    private $lang;

    /**
     * LanguageManager constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $lang = $request->query->get('lang');
        if (isset($lang)) {
            $this->lang = $lang;
            return;
        }
        $this->lang = self::parse($request->getLanguages());
    }

    /**
     * @return string
     */
    public function getLang(): string
    {
        return $this->lang;
    }

    /**
     * @param string $lang
     */
    public function setLang(string $lang)
    {
        $this->lang = $lang;
    }

    private function getJA()
    {
        return [];
    }

    private function getEN()
    {
        return [];
    }

    private function getOrElse($d, $k, $n)
    {
        return isset($d[$k]) ? $d[$k] : $n;
    }

    public function trans($name)
    {
        switch ($this->lang) {
            case self::LANG_EN:
                return $this->getOrElse($this->getEN(), $name, $name);
            case self::LANG_JA:
                return $this->getOrElse($this->getJA(), $name, $name);
        }
        return $name;
    }

    /**
     * @param string[] $languages
     * @return string
     */
    private static function parse(array $languages)
    {
        if (count($languages) === 0) {
            return self::LANG_DEFAULT;
        }
        foreach ($languages as $lang) {
            $lang = mb_substr(mb_strtolower($lang), 0, 2);
            switch ($lang) {
                case 'en':
                    return self::LANG_EN;
                case 'ja':
                    return self::LANG_JA;
            }
        }
        return self::LANG_DEFAULT;
    }
}
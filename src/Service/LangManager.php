<?php

namespace App\Service;


use Symfony\Component\HttpFoundation\Request;

class LangManager
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
        $this->lang = self::getLanguage($request->getLanguages());
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

    /**
     * @param string[] $languages
     * @return string
     */
    private static function getLanguage(array $languages)
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
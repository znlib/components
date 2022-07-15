<?php

namespace ZnLib\Components\I18n\Traits;

use ZnBundle\Language\Domain\Entities\LanguageEntity;
use ZnBundle\Language\Domain\Interfaces\Services\LanguageServiceInterface;
use ZnBundle\Language\Domain\Interfaces\Services\RuntimeLanguageServiceInterface;
use ZnCore\Arr\Helpers\ArrayHelper;
use ZnCore\Code\Helpers\PropertyHelper;
use ZnCore\Container\Helpers\ContainerHelper;
use ZnLib\Components\I18n\Enums\LanguageI18nEnum;

trait I18nTrait
{

    protected $_language = "ru";
    protected $_languageService;
    protected $_runtimeLanguageService;

    /** @var \ZnCore\Collection\Interfaces\Enumerable | LanguageEntity[] */
    static protected $_languages = null;

    protected function _forgeLanguages(LanguageServiceInterface $languageService = null)
    {
        if (self::$_languages) {
            return;
        }
        $languageService = $this->_forgeLanguageService($languageService);
        self::$_languages = $languageService->allEnabled();
    }

    protected function _forgeLanguageService(LanguageServiceInterface $languageService = null): LanguageServiceInterface
    {
        if (!$this->_languageService) {
            if (!$languageService) {
                $languageService = ContainerHelper::getContainer()->get(LanguageServiceInterface::class);
            }
            $this->_languageService = $languageService;
        }
        return $this->_languageService;
    }

    protected function _forgeRuntimeLanguageService(RuntimeLanguageServiceInterface $languageService = null): RuntimeLanguageServiceInterface
    {
        if (!$this->_runtimeLanguageService) {
            if (!$languageService) {
                $languageService = ContainerHelper::getContainer()->get(RuntimeLanguageServiceInterface::class);
            }
            $this->_runtimeLanguageService = $languageService;
        }
        return $this->_runtimeLanguageService;
    }

    protected function _setRuntimeLanguageService(RuntimeLanguageServiceInterface $languageService = null)
    {
        $languageService = $this->_forgeRuntimeLanguageService($languageService);
        $this->_setCurrentLanguage($languageService->getLanguage());
    }

    protected function _setCurrentLanguage(string $language)
    {
        $this->_language = LanguageI18nEnum::encode($language);
    }

    protected function _getCurrentLanguage(string $defaultLanguage = null): string
    {
        if ($defaultLanguage) {
            $language = $defaultLanguage;
        } else {
            $this->_setRuntimeLanguageService();
            $language = $this->_language;
        }

        $encodedLanguage = LanguageI18nEnum::encode($language);
        $language = $encodedLanguage ?: $language;
        return $language;
    }

    protected function _setI18n(string $attribute, $value, string $language = null): void
    {
        $this->$attribute = $value;
        $i18nAttribute = $attribute . 'I18n';
        $language = $this->_getCurrentLanguage($language);
        $this->{$i18nAttribute}[$language] = $value;
    }

    protected function _getI18n(string $attribute, string $language = null): ?string
    {
        $i18nAttribute = $attribute . 'I18n';
        $value = PropertyHelper::getValue($this, $i18nAttribute);
        if (!empty($value)) {
            $translations = !is_array($value) ? json_decode($value, JSON_OBJECT_AS_ARRAY) : $value;
            $language = $this->_getCurrentLanguage($language);
            $result = ArrayHelper::getValue($translations, $language);
            if (empty($result)) {
                foreach ($translations as $code => $translation) {
                    if (trim($translation) != '') {
                        return $translation;
                    }
                }
            }
            return $result;
        }
        return $this->$attribute;
    }

    protected function _getI18nArray(string $attribute, string $language = null)
    {
        $language = $this->_getCurrentLanguage($language);
        $i18nAttribute = $attribute . 'I18n';
        $result = [];
        if (!empty($this->$i18nAttribute)) {
            $result = $this->$i18nAttribute;
        } elseif (!empty($this->$attribute)) {
            $result = [
                $language => $this->$attribute
            ];
        }
        $this->_forgeLanguages();
        foreach (self::$_languages as $languageEntity) {
            $code = $languageEntity->getCode();
            if (empty($result[$code])) {
                $result[$code] = ArrayHelper::first($result);
            }
        }
        return $result;
    }

    protected function _setI18nArray(string $attribute, ?array $valueI18n, string $language = null): void
    {
        $language = $this->_getCurrentLanguage($language);
        $i18nAttribute = $attribute . 'I18n';
        $this->$i18nAttribute = $valueI18n;
        if (!empty($valueI18n[$language])) {
            $this->$attribute = $valueI18n[$language];
        } else {
            $this->_forgeLanguages();
            foreach (self::$_languages as $languageEntity) {
                $code = $languageEntity->getCode();
                if (!empty($valueI18n[$code])) {
                    $this->$attribute = $valueI18n[$code];
                }
            }
        }
    }
}
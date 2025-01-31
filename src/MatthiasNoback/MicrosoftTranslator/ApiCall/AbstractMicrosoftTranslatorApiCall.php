<?php

namespace MatthiasNoback\MicrosoftTranslator\ApiCall;

use MatthiasNoback\Exception\InvalidResponseException;

abstract class AbstractMicrosoftTranslatorApiCall implements ApiCallInterface
{
    const HTTP_API_URL = 'https://api.cognitive.microsofttranslator.com/';

    /**
     * Maximum Request Size (characters)
     * @link https://learn.microsoft.com/en-us/azure/ai-services/translator/service-limits
     *
     * Operation:
     * - Translate
     * - Detect
     * - BreakSentence
     */
    const MAXIMUM_LENGTH_OF_TEXT = 50000;

    /**
     * Dictionary Lookup Maximum Request Size (characters)
     * @link https://learn.microsoft.com/en-us/azure/ai-services/translator/service-limits
     */
    const DICTIONARY_LOOKUP_MAXIMUM_LENGTH = 1000;

    abstract public function getApiMethodName();

    public function getUrl()
    {
        $url = self::HTTP_API_URL.$this->getApiMethodName();
        if (null !== $queryParameters = $this->getQueryParameters()) {
            $queryParameters['api-version'] = '3.0';
            $url .= '?'.http_build_query($queryParameters, null, '&');
        }
        return $url;
    }

    protected static function calculateTotalLengthOfTexts(array $texts)
    {
        $totalLength = 0;

        array_walk($texts, function($text) use (&$totalLength) {
            $totalLength += strlen($text);
        });

        return $totalLength;
    }

    public function getRequestHeaders() {
        return [];
    }

    public function sendHeaders()
    {
        return true;
    }
}

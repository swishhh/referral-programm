<?php
/**
 * Created by PhpStorm.
 * User: kharidas
 * Date: 31.08.19
 * Time: 01:24
 */

namespace Swish\Referral\Exception;

use Exception;
use Magento\Framework\Phrase;

class ValidateCode extends Exception
{
    /**
     * @var Phrase
     */
    protected $phrase;

    /**
     * @param Phrase $phrase
     * @param Exception $cause
     * @param int $code
     */
    public function __construct(Phrase $phrase, Exception $cause = null, $code = 0)
    {
        $this->phrase = $phrase;
        parent::__construct($phrase->render(), (int)$code, $cause);
    }

    /**
     * Get the un-processed message, without the parameters filled in
     *
     * @return string
     */
    public function getRawMessage()
    {
        return $this->phrase->getText();
    }

    /**
     * Get parameters, corresponding to placeholders in raw exception message
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->phrase->getArguments();
    }
}
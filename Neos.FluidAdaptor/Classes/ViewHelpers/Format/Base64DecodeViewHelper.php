<?php
namespace Neos\FluidAdaptor\ViewHelpers\Format;

/*
 * This file is part of the Neos.FluidAdaptor package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use Neos\FluidAdaptor\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;

/**
 * Applies base64_decode to the input
 *
 * @see http://www.php.net/base64_decode
 *
 * = Examples =
 *
 * <code title="default notation">
 * <f:format.base64Decode>{encodedText}</f:format.base64Decode>
 * </code>
 * <output>
 * Text in Base64 encoding will be decoded
 * </output>
 *
 * <code title="inline notation">
 * {text -> f:format.base64Decode()}
 * </code>
 * <output>
 * Text in Base64 encoding will be decoded
 * </output>
 *
 * @api This is used by the Fluid adaptor internally.
 */
class Base64DecodeViewHelper extends AbstractViewHelper
{
    /**
     * @var boolean
     */
    protected $escapeChildren = false;

    /**
     * Disable the output escaping interceptor so that the result is not htmlspecialchar'd
     *
     * @var boolean
     */
    protected $escapeOutput = false;

    /**
     * Converts all HTML entities to their applicable characters as needed using PHPs html_entity_decode() function.
     *
     * @param string $value string to format
     * @param boolean $keepQuotes if TRUE, single and double quotes won't be replaced (sets ENT_NOQUOTES flag)
     * @param string $encoding
     * @return string the altered string
     * @see http://www.php.net/html_entity_decode
     * @api
     */
    public function render($value = null, $keepQuotes = false, $encoding = 'UTF-8')
    {
        return self::renderStatic(array('value' => $value, 'keepQuotes' => $keepQuotes, 'encoding' => $encoding), $this->buildRenderChildrenClosure(), $this->renderingContext);
    }

    /**
     * Applies base64_decode() on the specified value.
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $value = $arguments['value'];
        if ($value === null) {
            $value = $renderChildrenClosure();
        }
        if (!is_string($value) && !(is_object($value) && method_exists($value, '__toString'))) {
            return $value;
        }

        return base64_decode($value);
    }
}

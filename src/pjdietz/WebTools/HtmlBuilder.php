<?php

namespace pjdietz\WebTools;

/**
 * Class with methods for generating HTML.
 */
class HtmlBuilder
{
    /**
     * Returns a string representation of an element with the provided tagname,
     * attributes, and content.
     *
     * For calls to element() with $contents=null, the returned markup will be
     * self closed. If $contents is '', the markup will include a complete
     * closing tag, as in <div></div>
     *
     * @param string $tagname
     * @param array $attributes
     * @param string $content
     * @return string
     */
    public function element($tagname, $attributes = null, $content = null)
    {
        // Build a string from the array of attributes passed.
        $atts = '';
        if (is_array($attributes)) {
            foreach ($attributes as $k => $v) {
                $atts .= sprintf(' %s="%s"', $k, $v);
            }
        }

        // Contruct the markup.
        if (!is_null($content)) {
            $html = sprintf('<%1$s%2$s>%3$s</%1$s>', $tagname, $atts, $content);
        } else {
            $html = sprintf('<%s%s />', $tagname, $atts);
        }

        return $html;
    }

    /**
     * Returns the markup to include the link to an external stylesheet.
     *
     * @param string $uri
     * @param string $media
     * @return string
     */
    public function stylesheet($uri, $media = null)
    {
        $atts = array(
            'rel' => 'stylesheet',
            'type' => 'text/css',
            'href' => $uri
        );

        if ($media) {
            $atts['media'] = $media;
        }

        return $this->element('link', $atts);
    }

    /**
     * Returns the markup to include the link to an external JavaScript.
     *
     * @param string $uri
     * @param bool $defer
     * @return string
     */
    public function javascript($uri, $defer = false)
    {
        $atts = array(
            'type' => 'text/javascript',
            'src' => $uri
        );

        if ($defer) {
            $atts['defer'] = 'defer';
        }

        return $this->element('script', $atts, '');
    }

    /**
     * Returns the markup for a definition list made from the passed
     * associative array using keys as terms and values as definitions.
     *
     * @param array $defs
     * @return string
     */
    public function definitionList($defs)
    {
        $html = '';
        if ($defs) {
            $html .= '<dl>';
            foreach ($defs as $name => &$value) {
                $html .= sprintf('<dt>%s</dt><dd>%s</dd>', $name, $value);
            }
            $html .= '</dl>';
        }
        return $html;
    }

}

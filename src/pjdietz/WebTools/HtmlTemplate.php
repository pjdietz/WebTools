<?php

namespace pjdietz\WebTools;

abstract class HtmlTemplate extends HtmlBuilder
{
    const DOCTYPE = '<!DOCTYPE html>';

    // -----------------------------------------------------------------------------------------------------------------
    /* HTML */

    /**
     * Return a string representing the entire page as HTML, including doctype,
     * and start and end html tags.
     *
     * This is the primary function called by the user, and this function
     * will call other html*() functions as needed to create the page.
     *
     * @return string
     */
    public function getHtml()
    {
        $html = "";

        $html .= self::DOCTYPE . "\n";
        $html .= $this->element("html", $this->htmlAttributes(), $this->htmlContent());

        return $html;
    }

    /**
     * Return an associative array of attributes for the html element.
     *
     * @return array|null
     */
    protected function htmlAttributes()
    {
        return array(
            "xmlns" => "http://www.w3.org/1999/xhtml"
        );
    }

    /**
     * Return string contents for the html element.
     *
     * @return string
     */
    protected function htmlContent()
    {
        $html = "";
        $html .= $this->htmlHead();
        $html .= $this->htmlBody();
        return $html;
    }

    // -----------------------------------------------------------------------------------------------------------------
    /* Head */

    /**
     * Return a string for the entire head element, including tags.
     *
     * @return string
     */
    protected function htmlHead()
    {
        return $this->element("head", $this->htmlHeadAttributes(), $this->htmlHeadContent());
    }

    /**
     * Return an associative array of attributes for the head element.
     *
     * @return array
     */
    protected function htmlHeadAttributes()
    {
        return array();
    }

    /**
     * Return string contents for the head element.
     *
     * @return string
     */
    protected function htmlHeadContent()
    {
        $html = "";

        $html .= sprintf("<title>%s</title>", $this->getTitle());
        $html .= $this->htmlMeta();
        $html .= $this->htmlStyle();
        $html .= $this->htmlScript();

        return $html;
    }

    /**
     * Return markup for meta tags, etc.
     *
     * @return string
     */
    protected function htmlMeta()
    {
    }

    /**
     * Return markup for the stylesheets
     *
     * @return string
     */
    protected function htmlStyle()
    {
    }

    /**
     * Return markup for the scripts
     *
     * @return string
     */
    protected function htmlScript()
    {
    }

    // -----------------------------------------------------------------------------------------------------------------
    /* Body */

    /**
     * Return a string for the entire body element, including tags.
     *
     * @return string
     */
    protected function htmlBody()
    {
        return $this->element("body", $this->htmlBodyAttributes(), $this->htmlBodyContent());
    }

    /**
     * Return an associative array of attributes for the body element.
     *
     * @return array
     */
    protected function htmlBodyAttributes()
    {
        return array();
    }

    /**
     * Return string contents for the body element.
     *
     * @return string
     */
    protected function htmlBodyContent()
    {
    }

    // -----------------------------------------------------------------------------------------------------------------
    /* Abstract */

    abstract protected function getTitle();

}

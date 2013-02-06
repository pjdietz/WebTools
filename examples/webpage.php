<?php

// TODO Update to work with refactored files

// This example script is intended to give you a general strategy for how to use
// the WebPageBase class. You'll want to break this up into several files; I
// just kept the example all in one for simplicity.


require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'WebPageBase.inc.php');



// Create a subclass to use throughtout your site.
// This class will add in site-wide stylesheets and JavaScripts, add the global
// navigation, and possibly add other convenience methods that may be helpful
// throughout your site.

abstract class SiteWebPage extends WebPageBase {

    // Make a new constructor to setup defaults for the site, including a better
    // doctype.

    public function __construct($doctype=self::DOCTYPE_HTML5) {

        // Don't forget to call the parent constructor!
        parent::__construct($doctype);

    }

    // Add default metatags, stylesheets, and JavaScripts.

    protected function htmlMeta() {
        $html = parent::htmlMeta();
        $html .= '<meta charset="utf-8" />';
        $html .= '<link rel="icon" href="/favicon.ico" type="image/x-icon" />';
        return $html;
    }

    protected function htmlStyle() {
        $html = parent::htmlStyle();
        // Include site-wide stylesheets. You can use the built-in stylesheet,
        // or provide the style or link elements directly.
        $html .= $this->stylesheet('/includes/reset.css');
        $html .= $this->stylesheet('/includes/site.css');
        $html .= $this->stylesheet('/includes.print.css', 'print');
        return $html;
    }

    protected function htmlScript() {
        $html = parent::htmlScript();
        $html .= $this->javascript('/includes/jquery.min.js');
        $html .= $this->javascript('/includes/site.js');
        return $html;
    }

    // Make all pages output an H1 at the that includes the page title.
    protected function htmlBodyContent() {
        $html = parent::htmlBodyContent();
        $html .= sprintf('<h1>%s</h1>', $this->title);
        return $html;
    }

}



// Create a subclass of your site class to create an actual, concrete web page.
// (If your site is complox, you may also want to create subclasses for
// various sections.)

class WebPage extends SiteWebPage {

    // Set the variables for the page, such as the page title.
    public function __construct() {
        parent::__construct();
        // Set a title for the page.
        $this->title = 'Hello World!';
    }

    // Return an array of attributes to add to the body element.
    // In this case, we'll add class="my-body-class".
    protected function htmlBodyAttributes() {
        $atts = parent::htmlBodyAttributes();
        $atts['class'] = 'my-body-class';
        return $atts;
    }

    // Add the content of the page, appended after the content output site's
    // htmlBodyContent() method.
    protected function htmlBodyContent() {
        $html = parent::htmlBodyContent();
        $html .= '<p>This content is appended after the default H1.<p>';
        return $html;
    }

}

// Output the page to the browser.

$page = new WebPage();
print $page->html();
exit;

?>

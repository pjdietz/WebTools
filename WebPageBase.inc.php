<?php

/*******************************************************************************
 * WebPageBase
 * 
 * WebPageBase is a simple abstract base class for creating valid HTML for a
 * web page. To use this, subclass it and override methods to produce the
 * desired result. For example, provide your own htmlBodyContent() that returns
 * the contents for your page's <body> element. To output the <head> element,
 * either redefine the htmlHeadContent() method, or redefine the helper methods,
 * htmlMeta(), htmlStyle(), and htmlScript() to keep the head's metatags, 
 * stylesheets, and javascripts organized.
 *
 * WebSiteBase also provides some convenience methods. The element() method
 * returns a string representation of an element given the tag, array of
 * attributes, and contents.
 * 
 ******************************************************************************/

/**
 * @property string $doctype The DOCTYPE used by the page
 * @property bool $isXhtml The instance is set to render as XHTML 
 */
abstract class WebPageBase {

    // DOCTYPEs
    const DOCTYPE_QUIRKS = '';
    const DOCTYPE_HTML4_STRICT = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
    const DOCTYPE_HTML4_TRANSITIONAL = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">'; 
    const DOCTYPE_HTML4_FRAMESET = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">';
    const DOCTYPE_XHTML_STRICT = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
    const DOCTYPE_XHTML_TRANSITIONAL = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
    const DOCTYPE_XHTML_FRAMESET = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">';
    const DOCTYPE_HTML5 = '<!DOCTYPE html>';
    
    /**
     * The docyype used by the page
     * @var string
     */
    protected $doctype_p;
   
    /**
     * Is the page XHTML?
     * var bool
     */
    protected $isXhtml_p; 
    
    /**
     * Value for the <title> of the page
     * @var string
     */   
    protected $title = '';

    /**
     * Create a new WebPage.
     * 
     * @param string $doctype
     * @return WebPageBase
     */
    public function __construct($doctype=self::DOCTYPE_QUIRKS) {
        $this->setDoctype($doctype);    
    }

    public function __get($name) {

        switch ($name) {
            case 'doctype':
                return $this->getDoctype();
            case 'isXhtml':
                return $this->getIsXhtml();
        }   

    }
    
    public function __set($name, $value) {
    
        switch ($name) {
            case 'doctype':
                return $this->setDoctype($value);
            case 'isXhtml':
                return $this->setIsXhtml($value);
        }           
    
    }
    
    
    
    ////////////////////////////////////////////////////////////////////////////
    // !Accessor Methods
    ////////////////////////////////////////////////////////////////////////////
    
    /**
     * Return the applied doc type.
     * 
     * @return string
     */
    public function getDoctype() {
        return $this->doctype_p;    
    }
    
    /**
     * Set the doc type.
     * 
     * @param string $d
     */
    public function setDoctype($doctype) {
    
        $this->doctype_p = $doctype;
        $this->isXhtml_p = (in_array($doctype, array(
            self::DOCTYPE_XHTML_STRICT,
            self::DOCTYPE_XHTML_TRANSITIONAL,
            self::DOCTYPE_XHTML_FRAMESET,
            self::DOCTYPE_HTML5 
        )));     
    
    }
    
    /**
     * Return if the instance is set to render as XHTML.
     * 
     * @return bool
     */
    public function getIsXhtml() {
        return $this->isXhtml_p;    
    }
    
    /**
     * Set the instance to render as XHTML. You do not need to call this unless
     * you supply a doc type other than one of the class constants.
     * 
     * @param mixed $b
     */
    public function setIsXhtml($b) {
        $this->isXhtml_p = (bool) $b;    
    }
    
    
    
    ////////////////////////////////////////////////////////////////////////////
    // !Markup Methods 
    ////////////////////////////////////////////////////////////////////////////
    
    ////
    // !HTML
    ////
    
    /**
     * Return a string representing the entire page as HTML, including doctype,
     * and start and end html tags.
     *
     * This is the primary function called by the user, and this function
     * will call other html*() functions as needed to create the page.
     * 
     * @return string
     */
    public function html() {
    
        $html = '';

        $html .= $this->doctype . "\n";
        $html .= $this->element('html', $this->htmlAttributes(), $this->htmlContent());        

        return $html; 
        
    }
    
    /**
     * Return an associative array of attributes for the html element.
     *
     * @return array|null
     */
    protected function htmlAttributes() {
    
        $atts = array();
        
        if ($this->isXhtml) {
            $atts['xmlns'] = 'http://www.w3.org/1999/xhtml';
        }
        
        return $atts;
    
    }
    
    /**
     * Return string contents for the html element.
     *
     * @return string
     */
    protected function htmlContent() {
    
        $html = '';
    
        $html .= $this->htmlHead();
        $html .= $this->htmlBody();
    
        return $html;
        
    }
    
    ////
    // !HEAD
    ////
    
    /**
     * Return a string for the entire head element, including tags.
     *
     * @return string
     */
    protected function htmlHead() {
        return $this->element('head', $this->htmlHeadAttributes(), $this->htmlHeadContent());
    }
    
    /**
     * Return an associative array of attributes for the head element.
     *
     * @return array
     */
    protected function htmlHeadAttributes() { return array(); }
    
    /**
     * Return string contents for the head element.
     *
     * @return string
     */
    protected function htmlHeadContent() {
    
        $html = '';
        
        $html .= sprintf('<title>%s</title>', $this->title);
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
    protected function htmlMeta() {}
    
    /**
     * Return markup for the stylesheets
     * 
     * @return string
     */
    protected function htmlStyle() {}
    
    /**
     * Return markup for the scripts
     * 
     * @return string
     */
    protected function htmlScript() {}

    
    ////
    // !BODY
    ////
    
    /**
     * Return a string for the entire body element, including tags.
     *
     * @return string
     */
    protected function htmlBody() {
        return $this->element('body', $this->htmlBodyAttributes(), $this->htmlBodyContent());
    }
    
    /**
     * Return an associative array of attributes for the body element.
     *
     * @return array
     */
    protected function htmlBodyAttributes() { return array(); }
    
    /**
     * Return string contents for the body element.
     *
     * @return string
     */
    protected function htmlBodyContent() {}
    
    
        
    
    ////////////////////////////////////////////////////////////////////////////
    // !Convenience  Methods 
    ////////////////////////////////////////////////////////////////////////////
    
    /**
     * Returns a string representation of an element with the provided tagname,
     * attributes, and content.
     * 
     * For calls to element() with $contents=null, the returned markup will be 
     * self closed if the instance is set to be XHTML. If $contents is '', the
     * markup will include a complete closing tag, as in <div></div> 
     * 
     * @param string $tagname
     * @param array $attributes
     * @param string $contents
     * @return string
     */
    public function element($tagname, $attributes=null, $content=null) {
    
        // Build a string from the array of attributes passed.
        $atts = '';
        if (is_array($attributes)) {
            foreach ($attributes as $k => $v) {
                $atts.= sprintf(' %s="%s"', $k, $v);
            }
        }
        
        // Contruct the markup.
        if (!is_null($content)) {
            $html = sprintf('<%1$s%2$s>%3$s</%1$s>', $tagname, $atts, $content);
        } else {
            if ($this->isXhtml_p) {
                $html = sprintf('<%s%s />', $tagname, $atts);
            } else {
                $html = sprintf('<%s%s>', $tagname, $atts);
            }   
        }        
            
        return $html;
    }
    
    /**
     * Returns the markup to include the link to an external stylesheet.
     * 
     * @param string $uri
     * @return string
     */
    public function stylesheet($uri, $media=null) {
    
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
    public function javascript($uri, $defer=false) {
       
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
    public function definitionList($defs) {
    
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

?>

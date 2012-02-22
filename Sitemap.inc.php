<?php

/**
* @package Sitemap
*/

class Sitemap {

    /**
     * Prefix for any URLs that begin with "/".
     * Should be something like "http://www.mysite.com"
     * 
     * @var string
     */
    protected $prefix;
    
    
    /**
     * Array of associative arrays of URLs, each using the keys 'loc', 'lastmod',
     * 'changefreq', and 'priority'.
     *     
     * @var array
     */
    protected $urls;
    
    /**
     * Construct a new Sitemap, passing an array of associative arrays of URLS, 
     * each using the keys 'loc', 'lastmod', 'changefreq', and 'priority'.
     *  
     * @param mixed $urls
     * @return Sitemap
     */
    public function __construct($prefix=null) {

        if (!is_null($prefix)) {
            $this->prefix = $prefix;
        }

        $this->urls = array();

    }    

    public function __set($key, $value) {
        switch ($key) {
            case 'prefix':
                return $this->setPrefix($prefix);
        }
    }

    public function setPrefix($prefix) {
        $this->prefix = $prefix;
    }

    /**
     * Add a new URL to the Sitemap. This value can be a string representing the
     * URL itself or an associative array containing 'loc', 'lastmod', etc.
     *
     * @param $url array|string
     */
    public function addUrl($url) {
        
        if (is_array($url)) {
            $this->urls[] = $url;
        } else if (is_string($url)) {
            $this->urls[] = array('loc' => $url);
        } else {
            throw new InvalidArgumentException('addUrl expects an array or string.');
        }
        
    }

    /**
     * Return the markup for the Sitemap.
     * 
     * @return string
     */
    public function xml() {
    
        $xml = '';
        $xml .= '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        
        foreach ($this->urls as $url) {
            $xml.= $this->xmlUrl($url);
        }
        
        $xml .= '</urlset>';
        
        return $xml;
    }
    
    /**
     * Return the markup for one <url> element given one URL associative array.
     * 
     * @param array $url
     * @return string
     */
    protected function xmlUrl($url) {
    
        $xml = '';
        
        $xml .= '<url>';
        $xml .= '<loc>' . $this->urlWithPrefix($url['loc']) . '</loc>';
        
        if (isset($url['lastmod'])) {
            $xml .= '<lastmod>' . $url['lastmod'] . '</lastmod>';
        }
        
        if (isset($url['changefreq'])) {
            $xml .= '<changefreq>' . $url['changefreq'] . '</changefreq>';
        }
        
        if (isset($url['priority'])) {
            $xml .= '<priority>' . $url['priority'] . '</priority>';
        }
        
        $xml .= '</url>';
        
        return $xml;        
    }
    
    protected function urlWithPrefix($url) {
    
        if (is_string($url) && $url[0] === '/' && isset($this->prefix)) {
            $url = $this->prefix . $url;
        }
        
        return $url;
    
    }
    
}
  
?>

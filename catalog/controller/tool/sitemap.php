<?php
class ControllerToolSitemap extends Controller{
    public function index(){
        $this->load->model('catalog/product');
		
        $products = $this->model_catalog_product->getProducts([]);

        $doc = new DOMDocument;

        $urlset = $doc->createElement("urlset");
        $doc->appendChild($urlset);

		foreach ($products as $product) {
			$url = $doc->createElement('url');
			
			$location_value = 'http://localhost/index.php?route=product/product&amp;product_id=' . $product['product_id'];
			$location = $doc->createElement('loc', $location_value);
			$url->appendChild($location);
			
			$lastmod = $doc->createElement('lastmod', date(DATE_ATOM, time()));
			$url->appendChild($lastmod);
			
			$changefreq = $doc->createElement('changefreq', 'monthly');
			$url->appendChild($changefreq);
			
			$priority = $doc->createElement('priority', '0.8');
			$url->appendChild($priority);
			
			$urlset->appendChild($url);
		}

        $this->response->addHeader('Content-Type: application/xml');
        $this->response->setOutput($doc->saveXML());
    }
}
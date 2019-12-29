<?php
class ControllerExtensionModuleprodvar extends Controller {	
	private $error = array();
	private $modpath = 'module/prodvar'; 
	private $modtpl = 'default/template/module/prodvar.tpl'; 
	private $modname = 'prodvar';
	private $modtext = 'Product Variants';
	private $modssl = 'SSL';
	private $modemail = 'info@opencart3x.ru'; 
	private $langid = 0;
	
	public function __construct($registry) {
		parent::__construct($registry);
		
		$this->langid = (int)$this->config->get('config_language_id');
 		
		if(substr(VERSION,0,3)>='3.0' || substr(VERSION,0,3)=='2.3') { 
			$this->modtpl = 'extension/module/prodvar';
			$this->modpath = 'extension/module/prodvar';
		} else if(substr(VERSION,0,3)=='2.2') {
			$this->modtpl = 'module/prodvar';
		} 
		
		if(substr(VERSION,0,3)>='3.0') { 
			$this->modname = 'module_prodvar';
		} 
		
		if(substr(VERSION,0,3)>='3.0' || substr(VERSION,0,3)=='2.3' || substr(VERSION,0,3)=='2.2') { 
			$this->modssl = true;
		} 
 	} 
	
	public function index() {
		$data['prodvar_status'] = $this->setvalue($this->modname.'_status');
		if ($data['prodvar_status'] && isset($this->request->get['product_id'])) {
			
			$this->load->model('tool/image');
			$this->load->model('catalog/product');
			
			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['manufacturer_id'])) {
				$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
			}

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . $this->request->get['tag'];
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
		
			$prodvar_data = $this->getprodvardata($this->request->get['product_id']);
 			
			$data['prodvar_title'] = json_decode($prodvar_data['prodvar_title'], true);
 			$data['prodvar_title'] = $data['prodvar_title'][$this->langid];
			
			$products = ($prodvar_data['prodvar_product_str_id']) ? explode(",", $prodvar_data['prodvar_product_str_id']) : array();
			
			$data['prodvar_product_str_ids'] = array();
			 			
			foreach ($products as $product_id) {
				$related_info = $this->model_catalog_product->getProduct($product_id);
	
				if ($related_info) {
					if ($related_info['image']) {
						$image = $this->model_tool_image->resize($related_info['image'], 157, 236);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', 157, 236);
					}

					$data['prodvar_product_str_ids'][] = array(
						'product_id' => $related_info['product_id'],
						'name' => $related_info['name'],
						'colorprod' => $related_info['colorprod'],
						'image' => $image,
						'ajaxurl' => 'index.php?route=product/product' . $url . '&product_id=' . $product_id,
						'ajaxseourl' => $this->url->link('product/product', $url . '&product_id=' . $product_id)
					); 
				}
			}
			
			return $this->load->view($this->modtpl, $data);
 		} 
	}
	
	private function setvalue($postfield) {
		return $this->config->get($postfield);
	}
	
	public function getprodvardata($product_id) { 
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "prodvar WHERE product_id = '" . (int)$product_id . "' limit 1");
		if($query->num_rows){
			return $query->row;
		} 
	}
}
<?php
class ControllerCommonTopMenu extends Controller {
	public function index() {
		$this->load->language('common/top_menu');

		// Menu
		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['action_new'] = $this->url->link('information/information', array('information_id'=>11)); 

		$data['action_sale'] = $this->url->link('information/information', array('information_id'=>12));

		$data['action_help'] = $this->url->link('information/information', array('information_id'=>13));

		$data['action_contact'] = $this->url->link('information/contact', array());

		$data['action_checkout_mi'] = $this->url->link('information/information', array('information_id'=>8));

		$data['action_payment_mi'] = $this->url->link('information/information', array('information_id'=>9));

		$data['action_delivery_mi'] = $this->url->link('information/information', array('information_id'=>6));

		$data['action_dropshipping'] = $this->url->link('information/information', array('information_id'=>10));

		$data['action_return'] = $this->url->link('information/information', array('information_id'=>15));

		$data['email'] = $this->config->get('config_email');


		$data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			if ($category['top']) {
				// Level 2
				$children_data = array();

				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach ($children as $child) {
					$children_lv3_data = array();
					
					$children_lv3 = $this->model_catalog_category->getCategories($child['category_id']);
					
					foreach ($children_lv3 as $child_lv3) {
						$filter_data_lv3 = array(
							'filter_category_id'  => $child_lv3['category_id'],
							'filter_sub_category' => true
						);
						
						$children_lv3_data[] = array(
							'name'  => $child_lv3['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data_lv3) . ')' : ''),
							'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'] . '_' . $child_lv3['category_id'])
						);
					}

					$filter_data = array(
						'filter_category_id'  => $child['category_id'],
						'filter_sub_category' => true
					);

					$children_data[] = array(
						'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
						'children_lv3' => $children_lv3_data,
						'column'   => $child['column'] ? $child['column'] : 1,
						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					);
				}

				// Level 1
				$data['categories'][] = array(
					'name'     => $category['name'],
					'children' => $children_data,
					'column'   => $category['column'] ? $category['column'] : 1,
					'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
				);
			}
		}

		return $this->load->view('common/top_menu', $data);
	}
}

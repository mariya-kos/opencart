<?php
class ControllerExtensionModuleUpdateprice extends Controller {
	public function index() {
		$this->load->language('extension/module/updateprice');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_admin'] = $this->language->get('entry_admin');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true),
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true),
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/updateprice', 'token=' . $this->session->data['token'], true),
		);

		$filename = 'D:\OpenServer\opencart_test\localhost\admin\controller\extension\module\products.csv';
		$handler = fopen($filename, 'w+');

		$filter_data = array(
			'sort' => 'name',
			'order' => 'ASC',
		);
		$products = $this->model_catalog_product->getProducts($filter_data);

		fwrite($handler, 'product_id;quantity;price;model' . PHP_EOL);
		$l = count($products);
		foreach ($products as $k => $product) {
			$export_array = [
				$product['product_id'],
				$product['quantity'],
				$product['price'],
				$product['model'],
			];
			$line = implode(';', $export_array);
			$line = mb_convert_encoding($line, 'cp1251');
			if ($k < $l - 1) {
				fwrite($handler, $line . PHP_EOL);
			} else {
				fwrite($handler, $line);
			}

		}
		echo '<pre>';
		echo mb_convert_encoding(file_get_contents($filename), 'utf-8', 'cp1251');
		fclose($handler);
		exit;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/updateprice', $data));
	}
}
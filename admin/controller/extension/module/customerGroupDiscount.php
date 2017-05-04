<?php
 class ControllerextensionmodulecustomerGroupDiscount extends Controller {
     private $error = array();

     public function index() {
         $this->load->language('extension/module/customerGroupDiscount');

         $this->document->setTitle($this->language->get('heading_title'));

         $this->load->model('setting/setting');

         if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
             $this->model_setting_setting->editSetting('customerGroupDiscount', $this->request->post);

             $this->session->data['success'] = $this->language->get('text_success');

             $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
         }

         $this->load->model('customer/customer_group');
         $data['customerGroupDiscount_group'] = $this->model_customer_customer_group->getCustomerGroups();

         $data['heading_title'] = $this->language->get('heading_title');

         $data['text_edit'] = $this->language->get('text_edit');
         $data['text_enabled'] = $this->language->get('text_enabled');
         $data['text_disabled'] = $this->language->get('text_disabled');

         $data['entry_status'] = $this->language->get('entry_status');
         $data['entry_group'] = $this->language->get('entry_group');
         $data['entry_sale'] = $this->language->get('entry_sale');

         $data['button_save'] = $this->language->get('button_save');
         $data['button_cancel'] = $this->language->get('button_cancel');

         if (isset($this->error['warning'])) {
             $data['error_warning'] = $this->error['warning'];
         } else {
             $data['error_warning'] = '';
         }

         $data['breadcrumbs'] = array();

         $data['breadcrumbs'][] = array(
             'text' => $this->language->get('text_home'),
             'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
         );

         $data['breadcrumbs'][] = array(
             'text' => $this->language->get('text_extension'),
             'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
         );

         $data['breadcrumbs'][] = array(
             'text' => $this->language->get('heading_title'),
             'href' => $this->url->link('extension/module/customerGroupDiscount', 'token=' . $this->session->data['token'], true)
         );

         $data['action'] = $this->url->link('extension/module/customerGroupDiscount', 'token=' . $this->session->data['token'], true);

         $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

         if (isset($this->request->post['customerGroupDiscount_status'])) {
             $data['customerGroupDiscount_status'] = $this->request->post['customerGroupDiscount_status'];
         } else {
             $data['customerGroupDiscount_status'] = $this->config->get('customerGroupDiscount_status');
         }
//         if (isset($this->request->post['customerGroupDiscount_group'])) {
//             $data['customerGroupDiscount_group'] = $this->request->post['customerGroupDiscount_group'];
//         } else {
//             $data['customerGroupDiscount_group'] = $this->config->get('customerGroupDiscount_group');
//         }
//         if (isset($this->request->post['customerGroupDiscount_sale'])) {
//             $data['customerGroupDiscount_sale'] = $this->request->post['customerGroupDiscount_sale'];
//         } else {
//             $data['customerGroupDiscount_sale'] = $this->config->get('customerGroupDiscount_sale');
//         }

         $data['header'] = $this->load->controller('common/header');
         $data['column_left'] = $this->load->controller('common/column_left');
         $data['footer'] = $this->load->controller('common/footer');

         $this->response->setOutput($this->load->view('extension/module/customerGroupDiscount', $data));
     }

     protected function validate() {
         if (!$this->user->hasPermission('modify', 'extension/module/customerGroupDiscount')) {
             $this->error['warning'] = $this->language->get('error_permission');
         }

         return !$this->error;
     }
 }
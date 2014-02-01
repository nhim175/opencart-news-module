<?php
################################################################################################
#  DIY Module Builder for Opencart 1.5.1.x From HostJars http://opencart.hostjars.com    	   #
################################################################################################
?><?php

class ControllerModuleMyModule extends Controller {
	protected function index($setting) {
		//Load the language file for this module - catalog/language/module/my_module.php
		$this->language->load('module/my_module');
		

		//Load any required model files - catalog/product is a common one, or you can make your own DB access
		//methods in catalog/model/module/my_module.php
		$this->load->model('module/my_module');
		$this->load->model('tool/image');

		//Example functionality: pull through customer firstnames and make them available to the view.
		$this->data['customers'] = $this->model_module_my_module->getCustomerFirstnames();
		$this->data['setting'] = $setting;
		$this->data['text_readmore'] = $this->language->get('text_readmore');
		$id = $setting['category'];
		$category = $this->model_module_my_module->getCategory($id);
		
		//Get the title from the language file
      	$this->data['heading_title'] = $category['category_title'];

		$limit = $setting['limit'];
		$posts = $this->model_module_my_module->getPostsFromCategory($id, $limit);
		foreach ($posts as $post) {
			if($post['status'] == 1) {
				$this->data['posts'][] = array(
					'post_id' => $post['post_id'],
					'post_title' => $post['post_title'],
					'post_description' => mb_substr(strip_tags(html_entity_decode($post['post_content'])), 0, 100),
					'post_img' => $this->model_tool_image->resize($post['post_img'], $setting['image_width'], $setting['image_height']),
					'post_date' => $post['post_date'],
					'post_link' => $this->url->link('module/my_module/post', 'path=' . $post['post_id'])
	 			);
			}			
		}
		//Choose which template to display this module with
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/my_module.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/my_module.tpl';
		} else {
			$this->template = 'default/template/module/my_module.tpl';
		}

		//Render the page with the chosen template
		$this->render();
	}

	public function post() {
		$this->language->load('module/my_module');
		$this->load->model('module/my_module');
		$this->load->model('tool/image');

		$this->data['text_related'] = $this->language->get('text_related');

		if (isset($this->request->get['path'])) {
			$post_id = $this->request->get['path'];
			$post = $this->model_module_my_module->getPost($post_id);
			$category_id = $post['category_id'];
			$this->data['heading_title'] = $post['post_title'];
			$related_posts = $this->model_module_my_module->getPostsFromCategory($category_id, 5);
			foreach ($related_posts as $p) {
				$this->data['related_posts'][] = array(
					'post_title' => $p['post_title'],
					'post_link' => $this->url->link('module/my_module/post', 'path=' . $p['post_id'])
				);
			}

			$this->data['post'] =  array(
				'post_id' => $post['post_id'],
				'post_title' => $post['post_title'],
				'post_content' => html_entity_decode($post['post_content']),
				'post_date' => $post['post_date'],
				'post_link' => $this->url->link('module/my_module/post', 'path=' . $post['post_id'])
			);
			$this->data['breadcrumbs'] = array();

	   		$this->data['breadcrumbs'][] = array(
	       		'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home'),
	       		'separator' => false
	   		);
	   		$this->data['breadcrumbs'][] = array(
	       		'text'      => $post['post_title'],
				'href'      => $this->url->link('module/my_module/post', 'path=' . $post['post_id']),
	       		'separator' => '::'
	   		);	

	   		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/my_module_post.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/my_module_post.tpl';
			} else {
				$this->template = 'default/template/module/my_module_post.tpl';
			}
			
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);
				
			$this->response->setOutput($this->render());


		} else {
			//display not found
		}
	}
}
?>
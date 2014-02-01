<?php
################################################################################################
#  DIY Module Builder for Opencart 1.5.1.x From HostJars http://opencart.hostjars.com  		   #
################################################################################################
class ControllerModuleMyModule extends Controller {
	
	private $error = array();
	
	public function index() {   
		//Load the language file for this module
		$this->load->language('module/my_module');

		//Set the title from the language file $_['heading_title'] string
		$this->document->setTitle($this->language->get('heading_title'));
		
		//Load the settings model. You can also add any other models you want to load here.
		$this->load->model('setting/setting');
		$this->load->model('module/my_module');
		$this->load->model('tool/image');
		//Save the settings if the user has submitted the admin form (ie if someone has pressed save).


		if (isset($this->request->post['action']) && $this->request->post['action'] == 'delete' && $this->validate()) {
			$post_ids = $this->request->post['selected'];
			foreach ($post_ids as $id) {
				$this->model_module_my_module->deletePost($id);
			}
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect($this->url->link('module/my_module/', 'token=' . $this->session->data['token'], 'SSL'));
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate() && $this->request->post['action'] == 'update_module') {
			$this->model_setting_setting->editSetting('my_module', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('module/my_module/', 'token=' . $this->session->data['token'], 'SSL'));
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		//This is how the language gets pulled through from the language file.
		//
		// If you want to use any extra language items - ie extra text on your admin page for any reason,
		// then just add an extra line to the $text_strings array with the name you want to call the extra text,
		// then add the same named item to the $_[] array in the language file.
		//
		// 'my_module_example' is added here as an example of how to add - see admin/language/english/module/my_module.php for the
		// other required part.
		
		$text_strings = array(
				'heading_title',
				'text_enabled',
				'text_disabled',
				'text_content_top',
				'text_content_bottom',
				'text_column_left',
				'text_column_right',
				'text_title',
				'text_content',
				'text_category',
				'text_image',
				'text_date',
				'text_action',
				'text_new',
				'text_status',
				'text_delete',
				'entry_layout',
				'entry_limit',
				'entry_image',
				'entry_position',
				'entry_category',
				'entry_status',
				'entry_sort_order',
				'button_save',
				'button_cancel',
				'button_add_module',
				'button_remove',
				'button_insert',
				'button_category',
				'button_delete'
		);
		
		foreach ($text_strings as $text) {
			$this->data[$text] = $this->language->get($text);
		}
		//END LANGUAGE
		
		//The following code pulls in the required data from either config files or user
		//submitted data (when the user presses save in admin). Add any extra config data
		// you want to store.
		//
		// NOTE: These must have the same names as the form data in your my_module.tpl file
		//
		$config_data = array(
				'my_module_example' //this becomes available in our view by the foreach loop just below.
		);
		
		foreach ($config_data as $conf) {
			if (isset($this->request->post[$conf])) {
				$this->data[$conf] = $this->request->post[$conf];
			} else {
				$this->data[$conf] = $this->config->get($conf);
			}
		}

		
		

		$posts = $this->model_module_my_module->getPosts();
		foreach ($posts as $post) {
			$this->data['posts'][] = array(
					"post_id" 		=> $post['post_id'],
					"post_title"	=> $post['post_title'],
					"category_title" 	=> $post['category_title'],
					"post_content" => mb_substr(strip_tags(html_entity_decode($post['post_content'])), 0, 20) . "...",
					"post_img"		=> $this->model_tool_image->resize($post['post_img'], 40, 40),
					"status" 			=> ($post['status']==1) ? $this->data['text_enabled'] : $this->data['text_disabled'],
					"post_date" 	=> $post['post_date'],
					"action"			=> array(
							array(
								'href' => $this->url->link('module/my_module/post_edit', 'token=' . $this->session->data['token'] . '&post_id=' . $post['post_id'], 'SSL'),
								'text' =>	$this->language->get('text_edit')
								)
						)
				);
		}

		//This creates an error message. The error['warning'] variable is set by the call to function validate() in this controller (below)
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		//SET UP BREADCRUMB TRAIL. YOU WILL NOT NEED TO MODIFY THIS UNLESS YOU CHANGE YOUR MODULE NAME.
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/my_module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/my_module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action2'] = $this->url->link('module/my_module', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['insert'] = $this->url->link('module/my_module/post_insert', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['category'] = $this->url->link('module/my_module/category', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['categories'] = $this->model_module_my_module->getCategories();
		//This code handles the situation where you have multiple instances of this module, for different layouts.
		$this->data['modules'] = array();
		
		if (isset($this->request->post['my_module_module'])) {
			$this->data['modules'] = $this->request->post['my_module_module'];
		} elseif ($this->config->get('my_module_module')) { 
			$this->data['modules'] = $this->config->get('my_module_module');
		}

		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		//Choose which template file will be used to display this request.
		$this->template = 'module/my_module.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);

		//Send the output.
		$this->response->setOutput($this->render());
	}
	
	/*
	 * 
	 * This function is called to ensure that the settings chosen by the admin user are allowed/valid.
	 * You can add checks in here of your own.
	 * 
	 */

	public function post_insert() {
		//Load the language file for this module
		$this->load->language('module/my_module');

		//Set the title from the language file $_['heading_title'] string
		$this->document->setTitle($this->language->get('heading_title'));
		
		//Load the settings model. You can also add any other models you want to load here.
		$this->load->model('setting/setting');
		$this->load->model('module/my_module');
		$this->load->model('tool/image');
		
		//Save the settings if the user has submitted the admin form (ie if someone has pressed save).
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_module_my_module->addPost($this->request->post);
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('module/my_module/', 'token=' . $this->session->data['token'], 'SSL'));
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		//This is how the language gets pulled through from the language file.
		//
		// If you want to use any extra language items - ie extra text on your admin page for any reason,
		// then just add an extra line to the $text_strings array with the name you want to call the extra text,
		// then add the same named item to the $_[] array in the language file.
		//
		// 'my_module_example' is added here as an example of how to add - see admin/language/english/module/my_module.php for the
		// other required part.
		
		$text_strings = array(
				'post_heading_title',
				'button_save',
				'button_cancel',
				'post_heading_title',
				'text_general',
				'entry_category',
				'entry_post_title',
				'entry_post_content',
				'entry_post_status',
				'entry_image',
				'text_data',
				'text_browse',
				'text_image_manager',
				'text_clear'
		);
		
		foreach ($text_strings as $text) {
			$this->data[$text] = $this->language->get($text);
		}
		//END LANGUAGE
		
		//The following code pulls in the required data from either config files or user
		//submitted data (when the user presses save in admin). Add any extra config data
		// you want to store.
		//
		// NOTE: These must have the same names as the form data in your my_module.tpl file
		//
		$config_data = array(
				'my_module_example' //this becomes available in our view by the foreach loop just below.
		);
		
		foreach ($config_data as $conf) {
			if (isset($this->request->post[$conf])) {
				$this->data[$conf] = $this->request->post[$conf];
			} else {
				$this->data[$conf] = $this->config->get($conf);
			}
		}

		$this->data['token'] = $this->session->data['token'];
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		$this->data['categories'] = $this->model_module_my_module->getCategories();
	
		//This creates an error message. The error['warning'] variable is set by the call to function validate() in this controller (below)
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		//SET UP BREADCRUMB TRAIL. YOU WILL NOT NEED TO MODIFY THIS UNLESS YOU CHANGE YOUR MODULE NAME.
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/my_module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/my_module/post_insert', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('module/my_module/', 'token=' . $this->session->data['token'], 'SSL');
	
		//This code handles the situation where you have multiple instances of this module, for different layouts.
		$this->data['modules'] = array();
		
		if (isset($this->request->post['my_module_module'])) {
			$this->data['modules'] = $this->request->post['my_module_module'];
		} elseif ($this->config->get('my_module_module')) { 
			$this->data['modules'] = $this->config->get('my_module_module');
		}		

		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		//Choose which template file will be used to display this request.
		$this->template = 'module/my_module_post_insert.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);

		//Send the output.
		$this->response->setOutput($this->render());
	}


	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/my_module')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}

	public function install() {
		$this->load->model('module/my_module');
		$this->model_module_my_module->createTables();
	}

	public function uninstall() {
		$this->load->model('module/my_module');
		$this->model_module_my_module->removeTables();
	}

	public function category() {
		//Load the language file for this module
		$this->load->language('module/my_module');
		$this->load->model('module/my_module');

		//Set the title from the language file $_['heading_title'] string
		$this->document->setTitle($this->language->get('heading_title'));
		
		//Load the settings model. You can also add any other models you want to load here.
		$this->load->model('setting/setting');
		
		//Save the settings if the user has submitted the admin form (ie if someone has pressed save).
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate() && $this->request->post['action'] == 'add') {
			$this->model_module_my_module->addCategory($this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('module/my_module/category', 'token=' . $this->session->data['token'], 'SSL'));
		} else if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate() && $this->request->post['action'] == 'delete') {
			$category_ids = $this->request->post['selected'];
			foreach ($category_ids as $id) {
				$this->model_module_my_module->deleteCategory($id);

			}
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect($this->url->link('module/my_module/category', 'token=' . $this->session->data['token'], 'SSL'));
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$categories = $this->model_module_my_module->getCategories();

		//Add actions for entries
		foreach($categories as $category) {
			$this->data['categories'][] = array(
				'category_id' 		=> $category['category_id'],
				'category_title' 	=> $category['category_title'],
				'action'					=> array(
															array(
																'href' => $this->url->link('module/my_module/category_edit', 'token=' . $this->session->data['token'] . '&category_id=' . $category['category_id'], 'SSL'),
																'text' => $this->language->get('text_edit')
															)
														)
			);
			
		}

		//This is how the language gets pulled through from the language file.
		//
		// If you want to use any extra language items - ie extra text on your admin page for any reason,
		// then just add an extra line to the $text_strings array with the name you want to call the extra text,
		// then add the same named item to the $_[] array in the language file.
		//
		// 'my_module_example' is added here as an example of how to add - see admin/language/english/module/my_module.php for the
		// other required part.
		
		$text_strings = array(
				'heading_title',
				'category_heading_title',
				'button_save',
				'button_cancel',
				'button_insert',
				'button_delete',
				'text_category_name',
				'entry_category',
				'column_title',
				'text_action'
		);
		
		foreach ($text_strings as $text) {
			$this->data[$text] = $this->language->get($text);
		}
		//END LANGUAGE
		
		//The following code pulls in the required data from either config files or user
		//submitted data (when the user presses save in admin). Add any extra config data
		// you want to store.
		//
		// NOTE: These must have the same names as the form data in your my_module.tpl file
		//
		$config_data = array(
				'my_module_example' //this becomes available in our view by the foreach loop just below.
		);
		
		foreach ($config_data as $conf) {
			if (isset($this->request->post[$conf])) {
				$this->data[$conf] = $this->request->post[$conf];
			} else {
				$this->data[$conf] = $this->config->get($conf);
			}
		}
	
		//This creates an error message. The error['warning'] variable is set by the call to function validate() in this controller (below)
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		//SET UP BREADCRUMB TRAIL. YOU WILL NOT NEED TO MODIFY THIS UNLESS YOU CHANGE YOUR MODULE NAME.
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/my_module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/my_module/category', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('module/my_module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['insert'] = $this->url->link('module/my_module/category_insert', 'token=' . $this->session->data['token'], 'SSL');
	
		//This code handles the situation where you have multiple instances of this module, for different layouts.
		$this->data['modules'] = array();
		
		if (isset($this->request->post['my_module_module'])) {
			$this->data['modules'] = $this->request->post['my_module_module'];
		} elseif ($this->config->get('my_module_module')) { 
			$this->data['modules'] = $this->config->get('my_module_module');
		}		

		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		//Choose which template file will be used to display this request.
		$this->template = 'module/my_module_category.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);

		//Send the output.
		$this->response->setOutput($this->render());
	}

	public function category_edit() {
		//Load the language file for this module
		$this->load->language('module/my_module');

		//Set the title from the language file $_['heading_title'] string
		$this->document->setTitle($this->language->get('heading_title'));
		
		//Load the settings model. You can also add any other models you want to load here.
		$this->load->model('setting/setting');
		$this->load->model('module/my_module');
		
		//Save the settings if the user has submitted the admin form (ie if someone has pressed save).
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_module_my_module->updateCategory($this->request->post);
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('module/my_module/category', 'token=' . $this->session->data['token'], 'SSL'));
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['category'] = $this->model_module_my_module->getCategory($this->request->get['category_id']);

		//This is how the language gets pulled through from the language file.
		//
		// If you want to use any extra language items - ie extra text on your admin page for any reason,
		// then just add an extra line to the $text_strings array with the name you want to call the extra text,
		// then add the same named item to the $_[] array in the language file.
		//
		// 'my_module_example' is added here as an example of how to add - see admin/language/english/module/my_module.php for the
		// other required part.
		
		$text_strings = array(
				'category_heading_title',
				'button_save',
				'button_cancel',
				'button_insert',
				'button_delete',
				'text_general',
				'entry_category'
		);
		
		foreach ($text_strings as $text) {
			$this->data[$text] = $this->language->get($text);
		}
		//END LANGUAGE
		
		//The following code pulls in the required data from either config files or user
		//submitted data (when the user presses save in admin). Add any extra config data
		// you want to store.
		//
		// NOTE: These must have the same names as the form data in your my_module.tpl file
		//
		$config_data = array(
				'my_module_example' //this becomes available in our view by the foreach loop just below.
		);
		
		foreach ($config_data as $conf) {
			if (isset($this->request->post[$conf])) {
				$this->data[$conf] = $this->request->post[$conf];
			} else {
				$this->data[$conf] = $this->config->get($conf);
			}
		}
	
		//This creates an error message. The error['warning'] variable is set by the call to function validate() in this controller (below)
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		//SET UP BREADCRUMB TRAIL. YOU WILL NOT NEED TO MODIFY THIS UNLESS YOU CHANGE YOUR MODULE NAME.
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/my_module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/my_module/category_edit', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('module/my_module/category', 'token=' . $this->session->data['token'], 'SSL');
	
		//This code handles the situation where you have multiple instances of this module, for different layouts.
		$this->data['modules'] = array();
		
		if (isset($this->request->post['my_module_module'])) {
			$this->data['modules'] = $this->request->post['my_module_module'];
		} elseif ($this->config->get('my_module_module')) { 
			$this->data['modules'] = $this->config->get('my_module_module');
		}		

		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		//Choose which template file will be used to display this request.
		$this->template = 'module/my_module_category_edit.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);

		//Send the output.
		$this->response->setOutput($this->render());
	}



	public function post_edit() {


		//Load the language file for this module
		$this->load->language('module/my_module');

		//Set the title from the language file $_['heading_title'] string
		$this->document->setTitle($this->language->get('heading_title'));
		
		//Load the settings model. You can also add any other models you want to load here.
		$this->load->model('setting/setting');
		$this->load->model('module/my_module');
		$this->load->model('tool/image');
		
		//Save the settings if the user has submitted the admin form (ie if someone has pressed save).
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate() && $this->request->post['action'] == 'update') {
			$this->model_module_my_module->updatePost($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('module/my_module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		//This is how the language gets pulled through from the language file.
		//
		// If you want to use any extra language items - ie extra text on your admin page for any reason,
		// then just add an extra line to the $text_strings array with the name you want to call the extra text,
		// then add the same named item to the $_[] array in the language file.
		//
		// 'my_module_example' is added here as an example of how to add - see admin/language/english/module/my_module.php for the
		// other required part.
		
		$text_strings = array(
				'post_heading_title',
				'button_save',
				'button_cancel',
				'post_heading_title',
				'text_general',
				'entry_category',
				'entry_post_title',
				'entry_post_content',
				'entry_post_status',
				'entry_image',
				'text_data',
				'text_browse',
				'text_image_manager',
				'text_clear',
				'text_not_found'
		);
		
		foreach ($text_strings as $text) {
			$this->data[$text] = $this->language->get($text);
		}
		//END LANGUAGE
		
		//The following code pulls in the required data from either config files or user
		//submitted data (when the user presses save in admin). Add any extra config data
		// you want to store.
		//
		// NOTE: These must have the same names as the form data in your my_module.tpl file
		//
		$config_data = array(
				'my_module_example' //this becomes available in our view by the foreach loop just below.
		);
		
		foreach ($config_data as $conf) {
			if (isset($this->request->post[$conf])) {
				$this->data[$conf] = $this->request->post[$conf];
			} else {
				$this->data[$conf] = $this->config->get($conf);
			}
		}
	
		//This creates an error message. The error['warning'] variable is set by the call to function validate() in this controller (below)
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		//SET UP BREADCRUMB TRAIL. YOU WILL NOT NEED TO MODIFY THIS UNLESS YOU CHANGE YOUR MODULE NAME.
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/my_module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		if(!isset($this->request->get['post_id'])) {
			$this->template = 'error/not_found.tpl';
				$this->children = array(
				'common/header',
				'common/footer',
			);

			//Send the output.
			$this->response->setOutput($this->render());
			return;
		} else {
			$id = $this->request->get['post_id'];
		}


		$this->data['action'] = $this->url->link('module/my_module/post_edit', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('module/my_module/', 'token=' . $this->session->data['token'], 'SSL');
	
		//This code handles the situation where you have multiple instances of this module, for different layouts.
		$this->data['modules'] = array();

		$this->data['post'] = $this->model_module_my_module->getPost($id);
		$this->data['post']['thumb'] = $this->model_tool_image->resize($this->data['post']['post_img'], 100, 100);
		$this->data['categories'] = $this->model_module_my_module->getCategories();
		$this->data['token'] = $this->session->data['token'];
		
		if (isset($this->request->post['my_module_module'])) {
			$this->data['modules'] = $this->request->post['my_module_module'];
		} elseif ($this->config->get('my_module_module')) { 
			$this->data['modules'] = $this->config->get('my_module_module');
		}		

		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		//Choose which template file will be used to display this request.
		$this->template = 'module/my_module_post_edit.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);

		//Send the output.
		$this->response->setOutput($this->render());
	}
}
?>
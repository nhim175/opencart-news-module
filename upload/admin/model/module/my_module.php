<?php
################################################################################################
#  DIY Module Builder for Opencart 1.5.1.x From HostJars http://opencart.hostjars.com    	   #
################################################################################################
class ModelModuleMyModule extends Model {
	
	/*
	 * Most modules do not require their own database access. If you do want to store some new data that doesn't fit into the existing
	 * database tables, you could create them here like the example function below.
	 * 
	 * This file is basically just included for completeness of the DIY module. There are some uses for it, but these are more advanced and
	 * by the time you get to those I doubt you'll be needing my help :)
	 */
	
	// This function is how my blog module creates it's tables to store blog entries. You would call this function in your controller in a
	// function called install(). The install() function is called automatically by OC versions 1.4.9.x, and maybe 1.4.8.x when a module is
	// installed in admin.

	public function createTables() {
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "e_post (post_id INT(11) AUTO_INCREMENT, post_title text, post_content text, post_img VARCHAR(255), status INT(1), post_date DATE, PRIMARY KEY (post_id))");
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "e_category (category_id INT(11) AUTO_INCREMENT, category_title VARCHAR(255), PRIMARY KEY (category_id))");
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "e_post_category (id INT(11) AUTO_INCREMENT, post_id INT(11), category_id INT(11), PRIMARY KEY (id))");
	}

	public function removeTables() {
		$query = $this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "e_post");
		$query = $this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "e_category");
		$query = $this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "e_post_category");
	}

	public function getPosts() {
		$query = $this->db->query("SELECT p.*, c.category_title FROM " . DB_PREFIX . "e_post p LEFT JOIN " . DB_PREFIX . "e_post_category x ON p.post_id = x.post_id LEFT JOIN " . DB_PREFIX . "e_category c ON x.category_id = c.category_id" );
		return $query->rows;
	}

	public function getPost($id) {
		$query = $this->db->query("SELECT p.*, c.category_title, c.category_id FROM " . DB_PREFIX . "e_post p LEFT JOIN " . DB_PREFIX . "e_post_category x ON p.post_id = x.post_id LEFT JOIN " . DB_PREFIX . "e_category c ON x.category_id = c.category_id WHERE p.post_id = " . $id );
		return $query->row;
	}

	public function addPost($data) {
		
		$query = $this->db->query("INSERT INTO " . DB_PREFIX . "e_post SET post_title = '" . $this->db->escape($data['post_title']) . "', post_content = '". $this->db->escape($data['post_content']) . "', post_img = '" . $data['post_img'] . "', status = '" . $data['status'] . "'");
		$postId = $this->db->getLastId();
		$query = $this->db->query("INSERT INTO " . DB_PREFIX . "e_post_category SET post_id = " . $postId . ", category_id = " . $data['category_id']);
	}

	public function updatePost($data) {
		$query = $this->db->query("UPDATE " . DB_PREFIX . "e_post SET post_title = '" . $this->db->escape($data['post_title']) . "', post_content = '". $this->db->escape($data['post_content']) . "', post_img = '" . $data['post_img'] . "', status = '" . $data['status'] . "' WHERE post_id = " . $data['post_id']);
		$query = $this->db->query("UPDATE " . DB_PREFIX . "e_post_category SET category_id = " . $data['category_id'] . " WHERE post_id = " . $data['post_id']);

	}

	public function deletePost($id) {
		$query = $this->db->query("DELETE FROM " . DB_PREFIX . "e_post WHERE post_id = ". $id);
		$query = $this->db->query("DELETE FROM " . DB_PREFIX . "e_post_category WHERE post_id = " . $id);
	}

	public function getCategories() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "e_category");
		return $query->rows;
	}

	public function getCategory($id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "e_category WHERE category_id = " . $id);
		return $query->row;
	}

	public function addCategory($data) {
		$query = $this->db->query("INSERT INTO " . DB_PREFIX . "e_category SET category_title = '" . $this->db->escape($data['category_title']) . "'");
	}

	public function deleteCategory($id) {
		$query = $this->db->query("DELETE FROM " . DB_PREFIX . "e_category WHERE category_id = ". $id);
		$query = $this->db->query("DELETE FROM " . DB_PREFIX . "e_post_category WHERE category_id = " . $id);
	}

	public function updateCategory($data) {
		$query = $this->db->query("UPDATE " . DB_PREFIX . "e_category SET category_title = '". $data['category_title'] . "' WHERE category_id = " . $data['category_id'] );
	}
}
?>

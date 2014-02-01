<?php
################################################################################################
#  DIY Module Builder for Opencart 1.5.1.x From HostJars http://opencart.hostjars.com 		   #
################################################################################################
class ModelModuleMyModule extends Model {
	
	//Place any functions you like in here to access the DB and present data to the controller to display or otherwise
	//control the display of the view. Before writing your own functions here, check to see if you can use functions
	//in other model files, as you can just as easily pull through those models to use their functions.
	
	//Example function to get customer firstnames:
	function getCustomerFirstnames() {
		$query = "SELECT firstname FROM " . DB_PREFIX . "customer";
		$result = $this->db->query($query);
		return $result->rows;
	}
	
	function getPostsFromCategory($id, $limit = 0) {
		$query = "SELECT p.* FROM " . DB_PREFIX . "e_post p INNER JOIN ". DB_PREFIX ."e_post_category x ON p.post_id = x.post_id WHERE x.category_id = " . $id . " AND p.status = 1 ORDER BY p.post_id DESC LIMIT 0, " . $limit ;
		$result = $this->db->query($query);
		return $result->rows;
	}

	function getCategory($id) {
		$query = "SELECT * FROM " . DB_PREFIX . "e_category WHERE category_id = " . $id;
		return $this->db->query($query)->row;
	}

	function getPost($id) {
		$query = "SELECT p.*, x.category_id FROM " . DB_PREFIX . "e_post p LEFT JOIN ". DB_PREFIX ."e_post_category x ON p.post_id = x.post_id WHERE p.post_id = ". $id;
		return $this->db->query($query)->row;
	}
}

?>
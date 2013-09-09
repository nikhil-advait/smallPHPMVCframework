<?php
class PostsController extends ApplicationController {
	
	public function index(){
		$this->posts = Model::find_many("select * from posts");
	}

	public function show(){
		$this->post = Model::find_one("select * from posts where id =" . Controller::$params['id']);
	}

	public function neo(){
		
	}

	public function create(){
		if(Model::save("INSERT INTO posts (title, body) values (" .  "'" . Controller::$params['post']['title']  . "'" . ',' . "'" . Controller::$params['post']['body'] . "'"  . ')')){
			Flash::add("success", "Post created successfully!");
			$this->posts = Model::find_many("select * from posts");
			Controller::render(array('action' => 'index'));
			/*Controller::redirect_to( APP_DIR . '/' . Controller::$params['controller'] );*/
		}else {
			Flash::add("failure", "Post could not be created!");
			Controller::redirect_to( APP_DIR . '/' . Controller::$params['controller'] . '/neo' );
		}		
	}

	public function edit(){
		$this->post = Model::find_one("select * from posts where id =" . Controller::$params['id']);
	}

	public function update(){
		if(Model::save("UPDATE posts SET title ='" . Controller::$params['post']['title'] . "' , body ='" . Controller::$params['post']['body'] . "' WHERE id = " . Controller::$params['id'] ) ){
			Flash::add("success", "Post updated successfully!");
			Controller::redirect_to( APP_DIR . '/' . Controller::$params['controller'] . '/' . Controller::$params['id'] ); 
		}else {
			$this->post = Model::find_one("select * from posts where id =" . Controller::$params['id']);	
			Flash::add("failure", "Post could not be updated!");
			Controller::redirect_to( APP_DIR . '/' . Controller::$params['controller'] . '/' . Controller::$params['id'] . '/edit');
		}		
	}
	

	public function destroy(){
		
		if(Model::save("DELETE FROM posts WHERE id = " . Controller::$params['id'] )){
			Flash::add("success", "Post deleted successfully!");
			Controller::redirect_to( APP_DIR . '/' . Controller::$params['controller']); 
		}else {
			Flash::add("failure", "Post could not be updated!");
			Controller::redirect_to( APP_DIR . '/' . Controller::$params['controller']); 
		}
	}	
}
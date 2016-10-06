<?php

include 'conf.php';

class ApiConnector
{
	function __construct($userId, $postId,$accessToken,$blob)
	{

		$this->user = $userId;
		$this->post = $postId;
		$this->accessToken = $accessToken;
		$this->blob = $blob;


	}

	function getShares(){

		$matches = array();
		preg_match_all("/user[\\.]php[\\?]id=([0-9]+)/",$this->blob, $matches);
		$matches = $matches[1];
		return $matches;

	}
	function getLikes(){

		$fb = new Facebook\Facebook([
			'app_id' => APP_ID,
			'app_secret' => APP_SECRET,
			'version' => VERSION
		]);

		$fb->setDefaultAccessToken($this->accessToken);
		$response = $fb->get("/{$this->user}_{$this->post}/likes?limit=5000");
		$body = json_decode($response->getBody());
		$data = $body->data;
		$likes = array();
		foreach ($data as $item) {
			array_push($likes, array(
				'id' => $item->id,
				'name' => $item->name
			));

		}
		//$likes = $body['data'];
		return $likes;

	}

	function getComments(){
		$fb = new Facebook\Facebook([
			'app_id' => APP_ID,
			'app_secret' => APP_SECRET,
			'version' => VERSION
		]);

		$fb->setDefaultAccessToken($this->accessToken);
		$response = $fb->get("/{$this->user}_{$this->post}/comments?limit=5000");
		$body = $response->getBody();
		$body = json_decode($response->getBody());
		$data = $body->data;
		$comments = array();
		foreach ($data as $item) {
			array_push($comments, array(
				'from' => $item->from->id,
				'message' => $item->message
			));

		}
		//$likes = $body['data'];
		return $comments;
	}

	public function interpolateData(){
		$likes = $this->getLikes();
		$comments = $this->getComments();
		$shares = $this->getShares();
		$data = array();
		foreach ($comments as $comment) {
			foreach ($likes as $like) {


					if ($comment['from'] == $like['id']) {
						array_push($data, array(
							'from' => $like['name'],
							'message' => $comment['message']
						));
						break;
					}



			}


		}
		return $data;
	}

}
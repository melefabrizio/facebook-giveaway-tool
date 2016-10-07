<?php

include_once 'conf.php';

class ApiConnector
{
	function __construct($userId, $postId,$accessToken)
	{

		$this->user = $userId;
		$this->post = $postId;
		$this->accessToken = $accessToken;
		$this->blob = null;



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
		$response = $fb->get("/{$this->user}_{$this->post}/likes?filter=stream&summary=true&limit=".API_REQUEST_LIMIT);
		$body = $response->getBody();
		$body = json_decode($response->getBody());
		$data = $body->data;
		$currentCount = count($data);
		$totalCount = $body->summary->total_count;
		$nextHash = $body->paging->cursors->after;
		while($currentCount<$totalCount){
			$response = $fb->get("/{$this->user}_{$this->post}/likes?after=$nextHash&filter=stream&summary=true&limit=".API_REQUEST_LIMIT);
			$body = json_decode($response->getBody());
			$data1 = $body->data;

			$nextHash = $body->paging->cursors->after;
			foreach ($data1 as $item1) {
				array_push($data, $item1);

			}
			$currentCount += count($data);

		}



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
		$response = $fb->get("/{$this->user}_{$this->post}/comments?filter=stream&summary=true&limit=".API_REQUEST_LIMIT);
		$body = $response->getBody();
		$body = json_decode($response->getBody());
		$data = $body->data;
		$currentCount = count($data);
		$totalCount = $body->summary->total_count;
		$nextHash = $body->paging->cursors->after;
		while($currentCount<$totalCount){
			$response = $fb->get("/{$this->user}_{$this->post}/comments?after=$nextHash&filter=stream&summary=true&limit=".API_REQUEST_LIMIT);
			$body = json_decode($response->getBody());
			$data1 = $body->data;

			$nextHash = $body->paging->cursors->after;
			foreach ($data1 as $item1) {
				array_push($data, $item1);

			}
			$currentCount += count($data);

		}



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
							'from_id' => $comment['from'],
							'message' => $comment['message']
						));
						break;
					}



			}


		}
		return $data;
	}

}
<?php

namespace controller;

use model\BoardModel;

class BoardController extends ParentsController {
	protected $arrBoardInfo;
	protected $titleBoardName;
	protected $boardType;


	// 게시판 리스트 페이지
	protected function listGet() {

		// 파라미터 셋팅
		$b_type = isset($_GET["b_type"]) ? $_GET["b_type"] : "0";
		
		$arrBoardInfo = [
			"b_type" => $b_type
		];

		// 페이지의 제목 세팅
		foreach($this->arrBoardNameInfo as $item) {
			if($item["b_type"] === $b_type){
				$this->titleBoardName = $item["b_name"];
				$this->boardType = $item["b_type"];
				break;
			}
		}

		// 모델 인스턴스
		$boardModel = new BoardModel();

		// board 리스트 획득
		$this->arrBoardInfo = $boardModel->getBoardList($arrBoardInfo);
		
		// 데이터 가공처리
		// $this->arrBoardInfo["b_content"] = mb_substr($this->arrBoardInfo["b_content"], 0, 10)."...";
		// $this->arrBoardInfo["b_img"] = isset($this->arrBoardInfo["b_img"]) ? _PATH_USERIMG.$this->arrBoardInfo["b_img"] : "";
		// 사용한 모델 파기
		$boardModel->destroy();

		return "view/list.php";
	}

	// 글 작성

	protected function addPost(){
		
		// 작성 데이터 생성
		
		$u_pk = $_SESSION["u_pk"];
		$b_type = isset($_POST["b_type"]) ? $_POST["b_type"] : "";
		$b_title = isset($_POST["b_title"]) ? $_POST["b_title"] : "";
		$b_content = isset($_POST["b_content"]) ? $_POST["b_content"] : "";
		$b_img = $_FILES["b_img"]["name"];

		$arrAddBoardInfo = [
			"u_pk" => $u_pk
			,"b_type" => $b_type 
			,"b_title" => $b_title
			,"b_content" => $b_content
			,"b_img" => $b_img
		];

		// 이미지 파일 저장
		move_uploaded_file($_FILES["b_img"]["tmp_name"], _PATH_USERIMG.$b_img);

		//인서트 처리
		// 모델 인스턴스
		$boardModel = new BoardModel();
		$boardModel->beginTransaction();
		$result = $boardModel->addBoard($arrAddBoardInfo);
		if($result !== true) {
			$boardModel->rollBack();
		} else {
			$boardModel->commit();
		}

		// 파기
		$boardModel->destroy();

		return "Location: /board/list?b_type=".$b_type;
	}

	// 상세 정보 API
	protected function detailGet() {
		$id = $_GET["id"]; //정수가 맞는지 체크

		$arrBoardDetailInfo = [
			"id" => $id
		];

		$boardModel = new BoardModel();
		$result = $boardModel->getBoardDetail($arrBoardDetailInfo);

		//이미지 패스 재설정
		$result[0]["b_img"] = "/"._PATH_USERIMG.$result[0]["b_img"];

		// 작성 유저 플래그 설정
		$result[0]["uflg"] = $result[0]["u_pk"] === $_SESSION["u_pk"] ? "1" : "0";

		// 레스폰스 데이터 작성
		$arrTmp = [
			"errflg" => "1"
			,"msg" => "권한에러"
			,"data" => $result[0]
		];
		$response = json_encode($arrTmp);

		// response 처리 (html이 아니라 json으로 보내기 때문에)
		header('Content-type: application/json');
		echo $response;
		exit();

	}

	// 글 삭제

	protected function boardDeleteGet() {

		$id = $_GET["id"];
		$boardModel = new BoardModel();
		$boardModel->beginTransaction();
		$result = $boardModel->boardDeleteId($id);
		if($result !== true) {
			$boardModel->rollBack();
		} else {
			$boardModel->commit();
		}
		
		// 파기
		$boardModel->destroy();

		return "Location: /board/list";

	}

	// 삭제 처리 API
	protected function removeGet() {
		$errFlg = "0";
		$errMsg = "";
		$arrDeleteBoardInfo = [
			"id" => $_GET["id"]
			,"u_pk" => $_SESSION["u_pk"]
		];

		// 삭제 처리
		$boardModel = new BoardModel();
		$boardModel->beginTransaction();
		$result = $boardModel->removeBoardCard($arrDeleteBoardInfo);
		if($result !== 1 ) {
			$errFlg = "1";
			$errMsg = "삭제 처리 이상";
			$boardModel->rollBack();
		} else {
			$boardModel->commit();
		}

		// response 데이터 작성 : 삭제된 id 데이터를 보내줌
		$arrTmp = [
			"errflg" => $errFlg
			,"msg" => $errMsg
			,"id" => $arrDeleteBoardInfo["id"]
		];

		$boardModel->destroy();

		$response = json_encode($arrTmp);

		// response 처리
		header('Content-type: applicaition/json');
		echo $response;
		exit();
	}
}
<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $this->titleBoardName; ?> 페이지</title>
	<link rel="stylesheet" href="/view/css/common.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
	<?php require_once("view/inc/header.php");
		?>
		<div class="text-center mt-5 mb-5">
			<h1><?php echo $this->titleBoardName; ?></h1>
			<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" data-bs-toggle="modal" data-bs-target="#modalInsert" fill="currentColor" class="bi bi-signpost-split" viewBox="0 0 16 16">
				<path d="M7 7V1.414a1 1 0 0 1 2 0V2h5a1 1 0 0 1 .8.4l.975 1.3a.5.5 0 0 1 0 .6L14.8 5.6a1 1 0 0 1-.8.4H9v10H7v-5H2a1 1 0 0 1-.8-.4L.225 9.3a.5.5 0 0 1 0-.6L1.2 7.4A1 1 0 0 1 2 7h5zm1 3V8H2l-.75 1L2 10h6zm0-5h6l.75-1L14 3H8v2z"/>
			</svg>
		</div>
		<!-- 모달 테스트 -->
	<!-- <div id="modal" class="displayNone">
		<div id="modalW">
			<button id="btnModalClose">닫기</button>
		</div>
	</div> -->
	<main class="">
		<?php
			foreach($this->arrBoardInfo as $item) {
		?>
		<div class="card" id="card<?php echo $item["id"]; ?>">
			<img src="<?php echo isset($item["b_img"])? "/"._PATH_USERIMG.$item["b_img"] : ""; ?>" class="card-img-top" alt="이미지 없음">
			<div class="card-body">
			  <h5 class="card-title"><?php echo $item["b_title"]; ?></h5>
			  <p class="card-text"><?php echo mb_substr($item["b_content"], 0, 10)."..."; ?></p>
			  <!-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDetail">상세</button> -->
			  <button class="btn btn-primary" onclick="openDetail(<?php echo $item['id'] ?>); return false;">상세</button>
			  <!-- 모달 창 : 감춰뒀다가 버튼을 누르면 보여줌 -->
			</div>
		  </div>
		<?php
			}
		?>
	</main>
	<!--modal -->
	<form action="/board/delete" method="get">
	<div class="modal" id="modalDetail" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable">
		  <div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title" id="b_title">포켓몬 도감</h5>
			  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeDetailModal(); return false;"></button>
			</div>
			<div class="modal-body">
				<p id="writer"> 작성일 </p>
				<p id="create_date"> 작성일 </p>
				<p id="update_date"> 수정일 </p>
				<span id="b_content">나몰빼미는 날개 소리를 내지 않고 하늘을 날 수 있다.
					상대가 눈치채지 않게 다가가서 강력한 발차기를 반복하거나 커터 같은 날카로운 잎과 일체가 된 날개를 멀리서도 공격할 수 있다.
					밤이라도 낮과 동일하게 사물을 볼 수 있다. 야간 배틀에는 압도적으로 유리하다.
					나몰빼미의 목은 180도 가까이 회전한다.
					배틀 중이라도 포켓몬 트레이너 지시를 목을 돌려서 기다리고 있다.</span>
				<img src="../img/도감.png" alt="" id="b_img">
			</div>
			<div class="modal-footer justify-content-between">
				<input type="hidden" id="deleteId" name="id">
				<button id="btn_del" type="submit" class="btn btn-dark">삭제</button>
				<input type="hidden" id="del_id" value="">
				<!-- <span id="del_id" class="d-none"></span> 스판으로 세팅하는 법-->
				<button type="button" class="btn btn-dark me-auto" onclick="deleteCard(); return false;">삭제onclick</button>
			<div class="flex-end">
				<button type="button" class="btn btn-dark">수정</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeDetailModal(); return false;">Close</button>
			</div>
			</div>
		  </div>
		</div>
	  </div>
	</form>

	<!-- 작성 모달 -->
	<div class="modal" id="modalInsert" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/board/add" method="POST" enctype="multipart/form-data"> <!-- 라우터 주소 -->
				<div class="modal-header">
					<h5 class="modal-title">도감 등록</h5>
					<!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
				</div>
				<div class="modal-body">
					<input type="hidden" id="b_type" name="b_type" value="<?php echo $this->boardType; ?>">
					<div class="mb-3">
						<input type="text" name="b_title" class="form-control" placeholder="제목을 입력해주세요.">
					</div>
					<div class="mb-3">
						<textarea class="form-control" name="b_content" rows="10" placeholder="내용을 입력하세요"></textarea>
					</div>
					<br><br>
					<input type="file" accept="image /*" name="b_img" name="b_img">
					</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" data-bs-dismiss="modal">작성</button>
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
			</form>
		</div>
		</div>
	</div>
	</div>
	<footer class="bg-dark fixed-bottom text-light text-center p-3">저작권 by.바나나공장</footer>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="/view/js/common.js"></script>
</body>
</html>
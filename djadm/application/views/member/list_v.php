<script type="text/javascript">
	var sSearchUrl = '/<?php echo $sCurrentClass . '/lists'; ?>';
</script>
<script src="/assets/js/member.js"></script>

<article>
	<div>
		<?php 	echo form_open('/' . $sCurrentClass . '/lists', array('id'=>'search_form', 'class'=>'well form-search')); ?>
		<!--form id="member_search" method="post" class="well form-search" -->
			<i class="icon-search"></i><select name="sSearchKey"><option value="m_id"<?php if ($sSearchKey === 'm_id') : ?> selected<?php endif; ?>>아이디</option><option value="m_name"<?php if ($sSearchKey === 'm_name') : ?> selected<?php endif; ?>>이름</option></select> <input type="text" name="sSearchWord" value="<?php echo $sSearchWord; ?>" class="input-medium search-query" /> <input type="button" value="검색" id="btnSearch" class="btn btn-primary" />
		</form>
	</div>
	<table cellspacing="0" cellpadding="0" class="table table-striped table-hover">
		<thead>
			<tr class="title">
				<th scope="col" class="text-center">회원번호</th>
				<th scope="col" class="text-center">아이디</th>
				<th scope="col" class="text-center">이름</th>
				<th scope="col" class="text-center">성별</th>
				<th scope="col" class="text-center">전화번호</th>
				<th scope="col" class="text-center">포인트</th>
				<th scope="col" class="text-center">등급</th>
				<th scope="col" class="text-center">가입일시</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($list as $lt) : ?>
			<tr>
				<td scope="row"><?php echo $lt->m_no;?></td>
				<td scope="row"><?php echo $lt->m_id;?></td>
				<td><?php echo $lt->m_name;?></td>
				<td><?php echo $aMemberItems['aSexItems'][$lt->m_sex];?></td>
				<td><?php echo $lt->m_hp;?></td>
				<td>0 p</td>
				<td><?php echo $aMemberItems['aRoleItems'][$lt->m_role];?></td>
				<td><?php echo mdate("%Y-%m-%d %H:%i", human_to_unix($lt->m_join_datetime));?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="8" class="text-center"><?php echo $pagination;?></th>
			</tr>
		</tfoot>
	</table>
</article>

<article class="col-xs-offset-3">
	<?php echo form_open('/' . $sCurrentClass . '/update', array('class' => 'form-horizontal', 'id' => 'modify_form')); ?>
		<div class="form-group">
			<legend class="col-xs-8">[정동수] 회원정보</legend>
		</div>
	    	<div class="form-group">
		 	<label for="mNoId" class="col-md-1 col-xs-1 control-label">회원번호</label>
		    	<div class="col-md-3">
		      		<input type="text" class="form-control" id="mNoId" value="" readonly>
		    	</div>
		    	<label for="mSiteId" class="col-md-1 control-label">가입경로</label>
		    	<div class="col-md-3">
		      		<input type="text" class="form-control" id="mSiteId" value="" readonly>
		    	</div>
		</div>
		<div class="form-group">
		 	<label for="mNameId" class="col-md-1 col-xs-1 control-label">이름</label>
		    	<div class="col-md-3">
		      		<input type="text" class="form-control" id="mNameId" name="m_name" value="">
		    	</div>
		    	<label for="inputEmail1" class="col-md-1 control-label">성별</label>
		    	<div class="col-md-3">
		      		<input type="text" class="form-control" id="inputEmail1">
		    	</div>
		</div>
		<div class="form-group">
		 	<label for="mPwId" class="col-md-1 col-xs-1 control-label">비밀번호</label>
		    	<div class="col-md-3">
		      		<input type="password" class="form-control" id="mPwId">
		    	</div>
		    	<label for="mRePwId" class="col-md-1 control-label">2차 PW</label>
		    	<div class="col-md-3">
		      		<input type="text" class="form-control" id="mRePwId">
		    	</div>
		</div>
		<div class="form-group">
		 	<label for="inputEmail3" class="col-md-1 col-xs-1 control-label">생년월일</label>
		    	<div class="col-md-3">
		      		<input type="text" class="form-control" id="inputEmail3">
		    	</div>
		    	<label for="inputEmail1" class="col-md-1 control-label">이메일</label>
		    	<div class="col-md-3">
		      		<input type="email" class="form-control" id="inputEmail1">
		    	</div>
		</div>
		<div class="form-group">
		 	<label for="inputEmail3" class="col-md-1 col-xs-1 control-label">핸드폰</label>
		    	<div class="col-md-3">
		      		<input type="text" class="form-control" id="inputEmail3">
		    	</div>
		    	<label for="inputEmail1" class="col-md-1 control-label">전화번호</label>
		    	<div class="col-md-3">
		      		<input type="text" class="form-control" id="inputEmail1">
		    	</div>
		</div>
		<div class="form-group">
		 	<label for="inputEmail3" class="col-md-1 col-xs-1 control-label">예약 책임자</label>
		    	<div class="col-md-3">
		      		<input type="text" class="form-control" id="inputEmail3">
		    	</div>
		    	<label for="inputEmail1" class="col-md-1 control-label">예약 멘토</label>
		    	<div class="col-md-3">
		      		<input type="text" class="form-control" id="inputEmail1">
		    	</div>
		</div>
		<div class="form-group">
		 	<label for="inputEmail3" class="col-md-1 col-xs-1 control-label">메일수신</label>
		    	<div class="col-md-3">
		      		<input type="text" class="form-control" id="inputEmail3">
		    	</div>
		    	<label for="inputEmail1" class="col-md-1 control-label">불량고객</label>
		    	<div class="col-md-3">
		      		<input type="text" class="form-control" id="inputEmail1">
		    	</div>
		</div>

		<div class="form-group">
		 	<label for="inputEmail2" class="col-md-1 control-label">특이사항</label>
		    	<div class="col-md-7">
		      		<input type="text" class="form-control" id="inputEmail2">
		    	</div>
		</div>

		<div class="form-group">
		 	<label for="inputEmail3" class="col-md-1 col-xs-1 control-label">가입일</label>
		    	<div class="col-md-3">
		      		<input type="email" class="form-control" id="inputEmail3">
		    	</div>
		    	<label for="inputEmail1" class="col-md-1 control-label">가입IP</label>
		    	<div class="col-md-3">
		      		<input type="email" class="form-control" id="inputEmail1">
		    	</div>
		</div>

		<div class="form-group">
			<div class="col-md-9 text-center">
			      	<button type="button" id="btnLoginAction" class="btn btn-primary">수 정</button>
		        		<button class="btn" id="btnLoginCancel">취 소</button>
			</div>
      		</div>
	</form>
</article>


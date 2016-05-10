<script type="text/javascript">
	var sSearchUrl = '/<?php echo $sCurrentClass . '/lists'; ?>';
</script>
<script src="/djadm/assets/js/member.js"></script>

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

<?php if ($aMemInfo !== FALSE) : ?>
<article class="col-xs-offset-3">
	<?php echo form_open('/' . $sCurrentClass . '/update', array('class' => 'form-horizontal', 'id' => 'memberModifyForm')); ?>
		<div class="form-group">
			<legend class="col-xs-8">[<?php echo $aMemInfo['m_name']; ?>] 직원정보</legend>
		</div>
	    	<div class="form-group">
		 	<label for="mNoId" class="col-md-1 col-xs-1 control-label">회원번호</label>
		    	<div class="col-md-3">
		      		<input type="text" class="form-control" id="mNoId" value="<?php echo $aMemInfo['m_no']; ?>" readonly="readonly">
		      		<p class="help-block" id="mNoIdError">&nbsp;</p>
		    	</div>
		    	<label for="mIdId" class="col-md-1 col-xs-1 control-label">아이디</label>
		    	<div class="col-md-3">
		      		<input type="text" class="form-control" id="mIdId" value="<?php echo $aMemInfo['m_id']; ?>" readonly="readonly">
		      		<p class="help-block" id="mIdIdError">&nbsp;</p>
		    	</div>
		</div>
		<div class="form-group">
		 	<label for="mNameId" class="col-md-1 col-xs-1 control-label">이름</label>
		    	<div class="col-md-3">
		      		<input type="text" class="form-control form_validate" id="mNameId" name="m_name" value="<?php echo $aMemInfo['m_name']; ?>" alt="name">
		      		<p class="help-block" id="mNameIdError">&nbsp;</p>
		    	</div>
		    	<label for="mSexId" class="col-md-1 control-label">성별</label>
		    	<div class="col-md-3">
		    		<?php foreach ($aMemberItems['aSexItems'] as $s_k => $s_v) : ?>
		      		<label class="radio-inline">
					<input type="radio" class="form_validate" name="m_sex" id="mSexId" value="<?php echo $s_k; ?>" <?php if ($s_k == $aMemInfo['m_sex']) : ?>checked<?php endif; ?>><?php echo $s_v; ?>
				</label>
				<?php endforeach; ?>
		      		<p class="help-block" id="mSexIdError">&nbsp;</p>
		    	</div>
		</div>
		<div class="form-group">
		 	<label for="mHpId" class="col-md-1 col-xs-1 control-label">핸드폰</label>
		    	<div class="col-md-3">
		      		<input type="text" class="form-control form_validate" id="mHpId" name="m_hp" value="<?php echo $aMemInfo['m_hp']; ?>" alt="phone">
		      		<p class="help-block" id="mHpIdError">&nbsp;</p>
		    	</div>
		    	<label for="mPhoneId" class="col-md-1 control-label">전화번호</label>
		    	<div class="col-md-3">
		      		<input type="text" class="form-control" id="mPhoneId" name="m_phone" value="<?php echo $aMemInfo['m_phone']; ?>" alt="phone">
		      		<p class="help-block" id="mPhoneIdError">&nbsp;</p>
		    	</div>
		</div>
		<div class="form-group">
			<label for="mEmailId" class="col-md-1 control-label">이메일</label>
		    	<div class="col-md-3">
		      		<input type="email" class="form-control form_validate" id="mEmailId" name="m_email" value="<?php echo $aMemInfo['m_email']; ?>" alt="email">
		      		<p class="help-block" id="mEmailIdError">&nbsp;</p>
		    	</div>
		    	<label for="mRoleId" class="col-md-1 control-label">권한</label>
		    	<div class="col-md-3">
		    		<?php foreach ($aMemberItems['aRoleItems'] as $s_k => $s_v) : if ($s_k == 1) continue; ?>
		      		<label class="radio-inline">
					<input type="radio" class="form_validate" name="m_role" id="mRoleId" value="<?php echo $s_k; ?>" <?php if ($s_k == $aMemInfo['m_role']) : ?>checked<?php endif; ?>><?php echo $s_v; ?>
				</label>
				<?php endforeach; ?>
		      		<p class="help-block" id="mRoleIdError">&nbsp;</p>
		    	</div>
		</div>
		<div class="form-group">
		 	<label for="mEtcDescrId" class="col-md-1 control-label">특이사항</label>
		    	<div class="col-md-7">
		      		<textarea name="m_etc_descr" class="form-control" rows="4" id="mEtcDescrId"><?php echo $aMemInfo['m_etc_descr']; ?></textarea>
		      		<p class="help-block" id="mEtcDescrIdError">&nbsp;</p>
		    	</div>
		</div>

		<div class="form-group">
			<div class="col-md-9 text-center">
			      	<button type="button" id="memberModify" class="btn btn-primary btnFormSubmit">수 정</button>
		        		<button type="button" class="btn" id="btnMemberCancel">취 소</button>
			</div>
      		</div>
	</form>
</article>
<?php endif; ?>

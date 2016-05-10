<script src="/assets/js/member.js"></script>

<article>
	<?php
	$attributes = array('class' => 'form-horizontal', 'id' => 'memberLoginForm');
	echo form_open('/member/login/loginAction', $attributes);
	?>
		<fieldset>
		    	<legend>렌터카 관리자 로그인</legend>
		    	<div class="control-group">
		      		<label class="control-label" for="input01">아이디</label>
		      		<div class="controls">
		        			<input type="text" class="input-xlarge" id="memberId" name="m_id" value="<?php echo set_value('m_id'); ?>">
		        			<p class="help-block" id="memberIdError"></p>
		      		</div>
		      		<label class="control-label" for="input02">비밀번호</label>
		      		<div class="controls">
				        <input type="password" class="input-xlarge" id="memberPw" name="m_pw">
				        <p class="help-block" id="memberPwError"></p>
		      		</div>

		      		<div class="form-actions">
				        <button type="button" id="btnLoginAction" class="btn btn-primary">로그인</button>
				        <button class="btn" id="btnLoginCancel">취소</button>
		      		</div>
		    	</div>
		</fieldset>
	</form>
</article>
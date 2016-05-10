<script src="/djadm/assets/js/member.js"></script>

<article class="vertical-align-center-3 login-form-width">
	<?php
	$attributes = array('class' => 'form-horizontal', 'id' => 'memberLoginForm');
	echo form_open('/member/login/loginAction', $attributes);
	?>
		<fieldset>
		    	<legend>렌터카 관리자 로그인</legend>
		    	<div class="form-group">
			 	<label for="memberId" class="col-md-3 col-xs-1 control-label">아이디</label>
			    	<div class="col-md-7">
			      		<input type="text" class="form-control" id="memberId" name="m_id" value="<?php echo set_value('m_id'); ?>">
			      		<p class="help-block" id="memberIdError">&nbsp;</p>
			    	</div>
			</div>
			<div class="form-group">
			 	<label for="memberPw" class="col-md-3 col-xs-1 control-label">비밀번호</label>
			    	<div class="col-md-7">
			      		<input type="password" class="form-control" id="memberPw" name="m_pw">
			      		<p class="help-block" id="memberPwError">&nbsp;</p>
			    	</div>
			</div>
			<div class="form-group">
			    	<div class="col-md-12 text-center">
			      		<button type="button" id="btnLoginAction" class="btn btn-primary">로그인</button>
					<button class="btn" id="btnLoginCancel">취소</button>
			    	</div>
			</div>
		</fieldset>
	</form>
</article>



<div class="container">
	
	<br>

	<h3>Đổi mật khẩu</h3>

	<br />
	<br />
	
	<form method="POST">
		
		<div class="form-group">
			<label for="exampleInputPassword1">Mật khẩu cũ</label>
			<input type="password" class="form-control" id="oldPassword" placeholder="Mật khẩu cũ" name="oldPassword" required="true">
		</div>
		
		<div class="form-group">
			<label for="exampleInputPassword2">Mật khẩu mới</label>
			<input type="password" class="form-control" id="newPassword" placeholder="Mật khẩu mới" name="newPassword" required="true">
		</div>
		
		<div class="form-group">
			<label for="exampleInputPassword3">Nhập lại mật khẩu mới</label>
			<input type="password" class="form-control" id="confirmNewPassword" placeholder="Nhập lại mật khẩu mới" name="confirmNewPassword" required="true">
		</div>

		<button type="submit" class="btn btn-default">Đổi mật khẩu</button>
	</form>



	<?if($this->msg){?>
	<br/>
	<p class="bg-danger"><?= $this->msg ?></p>
	<br/>
	<?}?>
	
	<?if($this->msg2){?>
	<br/>
	<p class="bg-success"><?= $this->msg2 ?></p>
	<br/>
	<?}?>

</div>

<script>
	
</script>


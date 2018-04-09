
<script>
	var isInIFrame = (window.location != window.parent.location);
	if (isInIFrame == true) {
		// iframe
		window.parent.location = '<?= BASE_URL ?>user/login';
	} else {
		// no iframe
	}
</script>

<br/><br/>

<div class="container">
	<form method="POST">
		<div class="form-group">
			<label for="exampleInputEmail1">Tên đăng nhập</label>
			<input type="username" class="form-control" id="exampleInputEmail1" placeholder="Tên đăng nhập" name="username">
		</div>
		<div class="form-group">
			<label for="exampleInputPassword1">Mật khẩu</label>
			<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Mật khẩu" name="password">
		</div>

		<button type="submit" class="btn btn-default">Đăng nhập</button>
	</form>



	<?if($this->msg){?>
	<br/>
	<p class="bg-danger"><?= $this->msg ?></p>
	<br/>
	<?}?>

</div>


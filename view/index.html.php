<?php
	use Core\View;
	/** @var View $this */
?>

<html>
	<head>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
		<script src="/view/js/index.js?v=<?php print time() ?>"></script>
		<link rel="stylesheet" href="/view/css/index.css?v=<?php print time() ?>">
	</head>
	<body class="main-content">

		<main class="container row justify-content-center">
			<div class="sidebar col-3 mr-1 d-none d-md-block">
				<?php if($this->user->logged()){ ?>
					<?php print $this->renderMenu('user') ?>
				<?php }else{ ?>
					<?php print $this->renderMenu('guest') ?>
				<?php } ?>
			</div>
			<div class="content col-12 col-sm-12 col-md-8 ml-1">
				<?php $this->printContent() ?>
			</div>
		</main>

		<script src="https://kit.fontawesome.com/948e2eb059.js" crossorigin="anonymous"></script>

		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	</body>
</html>
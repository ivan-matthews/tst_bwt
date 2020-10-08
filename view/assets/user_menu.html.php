<?php
	use Core\View;
	/** @var View $this */

	$user_name = $this->user->getName();
	$user_login = $this->user->getLogin();
?>

<ul class="list-group user-menu">
	<li class="list-group-item">
		<div class="row">
			<div class="name"><?php print $user_name ?></div>
			<div class="login ml-2">(<?php print $user_login ?>)</div>
		</div>
	</li>
	<li class="list-group-item m-0 p-0">
		<a href="/">
			<div class="link m-0 p-3">
				Allowed Contacts
			</div>
		</a>
	</li>
	<li class="list-group-item m-0 p-0">
		<a href="/home/contacts">
			<div class="link m-0 p-3">
				My Contacts
			</div>
		</a>
	</li>
	<li class="list-group-item m-0 p-0">
		<a href="/auth/logout">
			<div class="link m-0 p-3">
				Leave Site
			</div>
		</a>
	</li>
</ul>
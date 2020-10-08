<?php
	use Core\View;
	/** @var View $this */
	/**
	 * @var array $content
	 * @var array $fields
	 * @var array $errors
	 * @var array $form
	 */
?>

<div class="form-content">
	<div class="form-head">
		Login Form
	</div>
	<div class="form-body">
		<?php print $this->renderForm($content) ?>
	</div>
</div>

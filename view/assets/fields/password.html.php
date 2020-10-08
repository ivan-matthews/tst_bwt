<?php
	use Core\View;
	/** @var View $this */
	/**
	 * @var array $field
	 * @var array $errors
	 */
?>

<div class="form-group">
	<?php if($errors){ ?>
		<div class="errors">
			<?php foreach($errors as $error){ ?>
				<div class="error">
					<?php print $error ?>
				</div>
			<?php } ?>
		</div>
	<?php } ?>
	<label for="exampleInputPassword1">
		<?php if(isset($field['required'])){ ?>
			<span class="errors">
				<span class="error">
					*
				</span>
			</span>
		<?php } ?>
		Enter Password
	</label>
	<input class="form-control" <?php print $this->makeAttributesString($field) ?>>
	<small id="emailHelp" class="form-text text-muted">Enter your password here</small>
</div>
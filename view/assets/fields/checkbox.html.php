<?php
	use Core\View;
	/** @var View $this */
	/**
	 * @var array $field
	 * @var array $errors
	 */
?>

<div class="form-check">
	<?php if($errors){ ?>
		<div class="errors">
			<?php foreach($errors as $error){ ?>
				<div class="error">
					<?php print $error ?>
				</div>
			<?php } ?>
		</div>
	<?php } ?>
	<input class="form-check-input" <?php print $this->makeAttributesString($field) ?>>
	<label class="form-check-label" for="exampleCheck1">
		<?php if(isset($field['required'])){ ?>
			<span class="errors">
				<span class="error">
					*
				</span>
			</span>
		<?php } ?>
		Member me?
	</label>
</div>
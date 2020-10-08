<?php
	use Core\View;
	/** @var View $this */
	/**
	 * @var array $fields
	 * @var array $errors
	 * @var array $form
	 */
?>

<form <?php print $this->makeAttributesString($form) ?>>

	<?php if(isset($errors['form'])){ ?>
		<div class="errors">
			<?php foreach($errors['form'] as $error){ ?>
				<div class="error">
					<?php print $error ?>
				</div>
			<?php } ?>
		</div>
	<?php } ?>

	<?php foreach($fields as $field){ ?>
		<?php $field = array_diff($field,array('')) ?>
		<?php print $this->renderField($field['type'], $field, (isset($errors[$field['name']]) ? $errors[$field['name']] : null)) ?>
	<?php } ?>

	<div class="form-group send-form-button">
		<button type="submit" class="btn btn-primary">Send Form</button>
	</div>
</form>

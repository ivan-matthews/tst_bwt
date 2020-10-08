<?php
	use Core\View;
	/** @var View $this */
	/**
	 * @var array $content
	 * @var array $contacts
	 * @var array $my_contacts
	 */
?>
<?php if($contacts){ ?>
	<div class="contacts">
		<div class="contact-head row col-12 m-0 p-3">
			<div class="id col-1">ID</div>
			<div class="name col-5">Name</div>
			<div class="date col-3">Date created</div>
			<div class="menu col-3">Actions</div>
		</div>
		<?php foreach($contacts as $contact){ ?>
			<div class="contact row col-12 m-0 p-3">
				<div class="id col-1">
					<?php print $contact['id'] ?>
				</div>
				<div class="name col-5">
					<?php print $contact['name'] ?>
				</div>
				<div class="date col-3">
					<?php print date('d m, Y H:i',$contact['date_created']) ?>
				</div>
				<div class="menu col-3">
					<?php if(in_array($contact['id'],$my_contacts)){ ?>
						<a href="/home/delete/<?php print $contact['id'] ?>" class="del">
							<i class="fas fa-times"></i>
							delete
						</a>
					<?php }else{ ?>
						<a href="/home/add/<?php print $contact['id'] ?>" class="add">
							<i class="fas fa-user-plus"></i>
							add
						</a>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
	</div>
<?php } ?>
<?php
/**
 * @version		2.6.x
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2014 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

$document = JFactory::getDocument();

$document->addScriptDeclaration("
	// Show the loaded iframe contant when it has finished loading and hhide loading
	function onEditModalShow() {
	  jQuery('#loadingModal').hide();
	  jQuery('iframe').show();
	};

	// Initialise a global flag for if an article was edited
	var savedArticle = 0;

	// Called when the 'save and close' modal button is pressed. Triggers the 
	// edit view save method and closes the modal. 
	function saveAndCloseEditModal() {
		jQuery('#editModalIframe').contents().find('#saveEdit').trigger('click');
		savedArticle = 1;
		jQuery('#editModal').modal('hide');
	};

	// When the modal is opened, make it taller (isn't done automatically due to iframe)
	// and add onload call to be called when iframe content is loaded (can't do in HTML 
	// as would be called twice - when the empty iframe is created in the DOM and this).
	jQuery(document).on('click', '.openExampleModal', function () {
	    var url = jQuery(this).data('url');
	    var browserHeight = 0.75 * jQuery(window).height();
	    
	    jQuery('#editModal .modal-dialog .modal-content .modal-body').css({'max-height': browserHeight, 'height': browserHeight});
	    jQuery('#loadingModal').show();
	    
	    jQuery('iframe').attr('src', url);
	    jQuery('iframe').attr('onload', 'onEditModalShow();');
	});

	// When the modal is hidden, hide the iframe and clear its content. If the 
	// modal was closed due to saving, reload the page. 
	jQuery(function(){
	  jQuery('#editModal').on('hidden.bs.modal', function(){
	    if (savedArticle == 1) {
	    	window.location.reload();
	    	savedArticle = 0;
	    }
	    
	    jQuery('iframe').hide();
	    jQuery('iframe').attr('html', '');
	    jQuery('iframe').attr('src', '');
	    jQuery('iframe').attr('onload', '');
	  });
	});
");

?>

<!-- Start K2 Category Layout -->
<div id="k2Container" class="itemListView<?php if($this->params->get('pageclass_sfx')) echo ' '.$this->params->get('pageclass_sfx'); ?>">

	<?php if($this->params->get('show_page_title')): ?>
	<!-- Page title -->
	<h1 class="componentheading<?php echo $this->params->get('pageclass_sfx')?>">
		<?php echo $this->escape($this->params->get('page_title')); ?>
	</h1>
	<?php endif; ?>

	<?php if((isset($this->leading) || isset($this->primary) || isset($this->secondary) || isset($this->links)) && (count($this->leading) || count($this->primary) || count($this->secondary) || count($this->links))): ?>
	<!-- Item list -->
	<div class="itemList">

		<?php if(isset($this->leading) && count($this->leading)): ?>
		<!-- Leading items -->
		<div id="itemListLeading">
			<?php foreach($this->leading as $key=>$item): ?>
			
			<div class="itemContainerNoLine">
				<?php
					// Load category_item.php by default
					$this->item=$item;
					echo $this->loadTemplate('item');
				?>
			</div>
			<?php if(($key+1)%($this->params->get('num_leading_columns'))==0): ?>
			<div class="clr"></div>
			<?php endif; ?>
			<?php endforeach; ?>
			<div class="clr"></div>
		</div>
		<?php endif; ?>

		<?php if(isset($this->primary) && count($this->primary)): ?>
		<!-- Primary items -->
		<div class="row" id="itemListPrimary">
			<?php foreach($this->primary as $key=>$item): ?>
			
			<div class="itemContainerNoLine col-sm-4">
				<?php
					// Load category_item.php by default
					$this->item=$item;
					echo $this->loadTemplate('item');
				?>
			</div>
			
			<?php endforeach; ?>

			<?php if(isset($this->category) || ( $this->params->get('subCategories') && isset($this->subCategories) && count($this->subCategories) )): ?>
			<!-- Blocks for current category and subcategories -->
			<!-- <div class="itemListCategoriesBlock"> -->

				<?php if($this->params->get('subCategories') && isset($this->subCategories) && count($this->subCategories)): ?>
				<!-- Subcategories -->
					<?php foreach($this->subCategories as $key=>$subCategory): ?>

					<div class="subCategoryContainer col-sm-4">
						<div class="subCategory">
							<?php if($this->params->get('subCatImage') && $subCategory->image): ?>
							<!-- Subcategory image -->
							<a class="subCategoryImage" href="<?php echo $subCategory->link; ?>">
								<img alt="<?php echo K2HelperUtilities::cleanHtml($subCategory->name); ?>" src="<?php echo $subCategory->image; ?>" />
							</a>
							<?php endif; ?>

							<?php if($this->params->get('subCatTitle')): ?>
							<!-- Subcategory title -->
							<h2>
								<?php echo $subCategory->name; ?>
							</h2>
							<?php endif; ?>

							<?php if($this->params->get('subCatDescription')): ?>
							<!-- Subcategory description -->
							<?php echo $subCategory->description; ?>
							<?php endif; ?>

							<!-- Subcategory more... -->
							<a class="subCategoryMore" href="<?php echo $subCategory->link; ?>">
								<?php echo JText::_('K2_VIEW_ITEMS'); ?>
							</a>
						</div>
					</div>
					<?php endforeach; ?>
				<?php endif; ?>
			<?php endif; ?>
		</div>
		<?php endif; ?>
	</div>

	<!-- Pagination -->
	<?php if($this->pagination->getPagesLinks()): ?>
	<div class="k2Pagination">
		<?php if($this->params->get('catPagination')) echo $this->pagination->getPagesLinks(); ?>
		<div class="clr"></div>
		<?php if($this->params->get('catPaginationResults')) echo $this->pagination->getPagesCounter(); ?>
	</div>
	<?php endif; ?>

	<?php endif; ?>

	<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="editModalLabel">Edit Item</h4>
	      </div>
	      <div class="modal-body">
	      	<div class="text-center" id="loadingModal">
	      	  <span class="fa fa-circle-o-notch fa-spin fa-5x"></span>
	      	  <p>Loading...</p>
	      	</div>
	      	<iframe id="editModalIframe" src="about:blank" onload=""></iframe>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	        <button type="button" class="btn btn-primary" onclick="saveAndCloseEditModal();">Save and Close</button>
	      </div>
	    </div>
	  </div>
	</div>

</div>
<!-- End K2 Category Layout -->

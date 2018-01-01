<?php 
    $user = JFactory::getUser();

    if ($user->id != 0) {
        $public = false;
    } else {
        $public  = true;
    } 

    $eventPermissions = JHelperContent::getActions('com_jem'); 
    $canCreateEvent = $eventPermissions->get('core.create');
    $canEditEvent = $eventPermissions->get('core.edit');
    $canEditOwnEvent = $eventPermissions->get('core.edit.own');
    $canDeleteEvent = $eventPermissions->get('core.delete');
    
    $articlePermissions = JHelperContent::getActions('com_k2'); 
    $canCreateArticle = $articlePermissions->get('core.create');
    $canEditArticle = $articlePermissions->get('core.edit');
    $canEditOwnArticle = $articlePermissions->get('core.edit.own');
    $canDeleteArticle = $articlePermissions->get('core.delete');
?>

<div class="row">
    <?php if ($public) { ?>
        <div class="col-xs-12">
            <p>You are not logged in. To see more options, please log in using the log in form available from the user icon in the top-right of the page. If you do not have an account, and believe you should do, please contact the website administrator using our <a href="/contact">contact form</a>.</p>
        </div>
    <?php } else { ?>
        <div class="col-xs-12">
            <p>This page provides a starting point to all the benefits of having an SYO website account. Account holders are generally able to add new news articles and orienteering events to the website, in addition to modifying existing articles and events. Users are also able to view club documentation, which is useful when organising events. If you have any questions regarding the SYO website and how to use it, please don't hesitate to contact the website administrator using our <a href="/contact">contact form</a>.</p>
        </div>

        <div class="col-sm-6">
            <div class="inner-events">
                <h2>Events</h2>
                <?php if ($canEditEvent) { ?>
                    <p>You are able to edit all SYO events and venues. To do so, navigate to the event or venue you wish to edit using the site's navigation and click the edit button on the event's or venue's page.</p>
                <?php } else if ($canEditOwnEvent) { ?>
                    <p>You are able to edit only those events or venues that you have created. <a href="/index.php?option=com_jem&amp;view=myevents">View a list of events that you have created</a> or <a href="/index.php?option=com_jem&amp;view=myvenues">view a list of venues that you have created</a>.</p>
                    <p>If you wish to edit an event or venue that you did not create, please contact the <a href="/about-syo/syo-officials">Fixtures Secretary</a> through our <a href="/contact">contact form</a>. If you believe you should be able to edit events or venues you did not create, please contact the website administrator through the same form.</p> 
                <?php } if ($canCreateEvent) { ?>
                    <p>You are able to create new events or venues using the buttons below:</p>
                    <a href="index.php?option=com_jem&amp;view=editevent&amp;layout=edit&amp;Itemid=81" class="btn btn-primary btn-block">Add new event...</a>
                    <a href="index.php?option=com_jem&amp;view=editvenue&amp;layout=edit&amp;Itemid=547" class="btn btn-primary btn-block">Add new venue...</a>
                    <p> </p>
                <?php } else { ?>
                    <p>You are not able to create new SYO events or venues. If you wish to create a new event or venue, please contact the <a href="/about-syo/syo-officials">Fixtures Secretary</a> through our <a href="/contact">contact form</a>. If you believe you should be able to create new events or venues, please contact the website administrator through the same form.</p>
                <?php } if (!($canCreateEvent || $canDeleteEvent || $canEditEvent || $canEditOwnEvent)) { ?>
                    <p>You are not able to create, edit or manage events. If you think you should be able to, please <a href="/contact">contact the website administrator</a>. 
                <?php } ?>
            </div>          
        </div>

        <div class="col-sm-6">
            <div class="inner-events">
                <h2>Articles</h2>
                <p>Some members are able to create and publish articles on the SYO website. Commonly, these are news articles about club achievements and are featured prominently on the SYO homepage. To ensure an article is shown on the homepage, make sure the 'featured' option is selected.</p>

                <?php if ($canEditArticle) { ?>
                    <p>You are able to edit all articles on the SYO website. To do so, navigate to the article you wish to edit using the site's navigation and click the edit button next to the article's title.</p>
                <?php } else if ($canEditOwnArticle) { ?>
                    <p>You are able to edit only those articles that you have created. If you believe you should be able to edit articles you did not create, please contact the website administrator using our <a href="/contact">contact form</a>.</p> 
                <?php } if ($canCreateArticle) { ?>
                    <p>You are able to create new articles on the SYO website using the button below:</p>
                    <a href="index.php?option=com_k2&amp;view=item&amp;layout=itemform&amp;task=add&amp;Itemid=66" class="openExampleModal btn btn-primary btn-block">Add new article...</a>
                <?php } else { ?>
                    <p>You are not able to create new articles for the SYO website. If you believe you should be able to create new articles, please contact the website administrator using our <a href="/contact">contact form</a>.</p> 
                <?php } if (!($canCreateEvent || $canDeleteEvent || $canEditEvent || $canEditOwnEvent)) { ?>
                    <p>You are not able to create, edit or manage articles on the SYO website. If you think you should be able to, please <a href="/contact">contact the website administrator</a>. 
                <?php } ?>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="inner-events">
                <h2>Documents</h2>
                <p>As a member of SYO you have access to a range of club documentation such as event organisation manuals and supporting material, AGM and committee meeting minutes, historical club newsletters, club logos and other policies and guidance.</p>
                {phocadownload view=category|id=1} {phocadownload view=category|id=2} {phocadownload view=category|id=3} {phocadownload view=category|id=4} {phocadownload view=category|id=5} {phocadownload view=category|id=7} <a href="index.php?option=com_phocadownload&amp;view=categories&amp;Itemid=257" class="btn btn-primary btn-block">View all documents...</a>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="inner-events">
                <h2>Settings</h2>
                <p>Here you are able to view and change your account details (such as your email address and password).</p>
                <a href="index.php?option=com_users&amp;view=profile&amp;Itemid=548" class="btn btn-primary btn-block">View account details...</a>
            </div>
        </div>
    <?php } ?>

    <div class="col-sm-6">
        <div class="inner-events">
            <h2>Participation T-shirt Scheme</h2>
            <p>Content to follow shortly...</p>
        </div>
    </div>
</div>

<div id="editModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                <h4 id="editModalLabel" class="modal-title">Edit Item</h4>
            </div>
            <div class="modal-body">&nbsp;</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> <button type="button" class="btn btn-primary" onclick="jQuery('#editModalIframe').contents().find('#saveEdit').trigger('click');">Save and Close</button>
            </div>
        </div>
    </div>
</div>
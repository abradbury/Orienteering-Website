<div class="acym_front_page <?php echo $data['paramsCMS']['suffix']; ?>">
    <?php
    if (!empty($data['paramsCMS']['show_page_heading'])) {
        echo '<h1 class="contentheading '.$data['paramsCMS']['suffix'].'"> '.$data['paramsCMS']['page_heading'].'</h1>';
    }
    ?>
	<div class="acym__front__archive ">
		<form method="post" action="<?php
        echo $data['actionUrl']; ?>" id="acym_form" class="acym__archive__form">
			<h1><?php echo acym_translation('ACYM_NEWSLETTERS'); ?></h1>
            
            <?php
            echo '{module 280}';
            
            foreach($data['newsletters'] as $newsletter):
                $grouped_newsletters[date_parse($newsletter->sending_date)['year']][] = $newsletter;
            endforeach;

            while ($group = current($grouped_newsletters)) {
                echo "<h2>" . key($grouped_newsletters) . "</h2>";

                foreach ($group as $oneNewsletter) {
                    $archiveURL = acym_frontendLink('archive&task=view&id='.$oneNewsletter->id.'&'.acym_noTemplate());

                    echo '<div class="mb-2">';
                        if ($data['popup']) {
                            $iframeClass = 'acym__modal__iframe';
                            if (empty($data['userId'])) $iframeClass .= ' acym__front__not_connected_user';
                            echo acym_frontModal($archiveURL, $oneNewsletter->subject, false, $oneNewsletter->id, $iframeClass);
                        } else {
                            echo '<p class="acym__front__archive__raw"><a href="'.$archiveURL.'" target="_blank">'.$oneNewsletter->subject.'</a></p>';
                        }
                        echo '<p class="acym__front__archive__newsletter_sending-date">';
                        echo acym_translation('ACYM_SENDING_DATE').' : '.acym_date($oneNewsletter->sending_date, 'd M Y');
                        echo '</p>';
                    echo '</div>';
                }

                next($grouped_newsletters);
            }

            echo $data['pagination']->display('archive', '', true);
            acym_formOptions(true, 'listing', '', '', false);
            ?>

			<input type="hidden" name="acym_front_page" id="acym__front__archive__next-page" value="1">
		</form>
	</div>
</div>

<?php
/**
 * This is the template used for displaying the results after the user has voted.
 */
?>
<p><?php print t('You voted for ' . $variables['results']['song'] . ' from ' . $variables['results']['band']);?></p>

<p>Here are the current rankings for <?php print $variables['results']['band'];?></p>
<ol>
<?php

foreach($variables['results']['results'] as $key => $result) {
  print "<li>" . $key . "</li>";
}
?>
</ol>

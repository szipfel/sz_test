<?php
/**
 * This is the template used for displaying the results after the user has voted. 
 */
?>
<p>You voted for next year's <?php print $variables['results']['event'];?> to take place in <?php print $variables['results']['city']?></p>

<p>Here are the current rankings for <?php print $variables['results']['event'];?></p>
<ol>
<?php

foreach($variables['results']['results'] as $key => $result) {
  print "<li>" . $key . "</li>";
}
?>
</ol>

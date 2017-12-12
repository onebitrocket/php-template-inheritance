<?php
  $nav = view('partials/nav', array('links' => $settings['menu']));
?>

<?php
  $intro = 'Some interesting content <br />';
?>

<?php $start('content');?>
  my new shiny content on the home page<br />
<?php $end(); ?>

<?php $extends = '_layout'; ?>

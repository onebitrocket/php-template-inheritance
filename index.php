<?php
require('func/view.php');

$settings = array(
  'menu' => array (

    'facebook' => 'https://www.facebook.com/',
    'twitter' => 'https://twitter.com/'
  )
);

echo view('home', $settings);

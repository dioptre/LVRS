<?php if(!defined('KIRBY')) exit ?>

title: Page
pages:
  template:
    - article
files: true
fields:
  title:
    label: Title
    type:  text
  subtitle:
    label: Sub Title
    type:  text
  coverpic:
    label: Cover Picture
    type: select
    options: images
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
  text:
    label: Sidebar Content (html)
    type: textarea
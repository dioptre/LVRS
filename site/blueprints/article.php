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
  author:
    label: Author
    type: text
  releasedate:
    label: Date
    type: date
  text:
    label: Blogpost (markdown formatting)
    type: textarea
    buttons: true
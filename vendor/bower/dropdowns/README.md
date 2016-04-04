Dropdowns
=========

A simple library to generate custom dropdown menus. Appends LIs to your empty list.

##Installation

Install with [Bower](http://bower.io): `bower install --save dropdowns`

##Usage

JS

    var dropdown = new Dropdown({
      container: '.Dropdown',
      options: ['Bananas', 'Apples', 'Oranges', 'Strawberries', 'Grapes']
    });
      
HTML

This HTML is just an example. Your trigger can be anything, your list can be anywhere, and your output container can be anything. The hidden input isn't required. If you don't make one, one will be created for you.

    <div class="Dropdown">
      <div class="trigger output"></div>
      <ul class="list"></ul>
    </div>

    <input type="hidden" id="myInput" value="">

CSS

    .list {
      display: none;
    }

Dropdown allows you to set a few parameters. The parent containing element, the list container, a custom trigger, and the dropdown options themselves. If you don't pass in an ID or Class for a hidden input to store your data, one will be created for you. The `default` parameter allows you to choose the onload text displayed in the trigger. Pass in a custom `eventName` to be triggered upon making a selection, or use the default `selected`.

    var dropdown = new Dropdown({
      container: '.Dropdown',
      outputContainer: '.output',
      trigger: '.trigger',
      list: '.list',
      storage: '.custom-input',
      default: 'Pick a fruit!',
      eventName: 'selected',
      options: ['Bananas', 'Apples', 'Oranges', 'Strawberries', 'Grapes']
    });
      
##Requirements

- [jQuery](http://jquery.com/)

/**
 ** Dropdown class
 ** Author: Freddie Carthy
 ** License: Do what you want!
 **/

(function(){

/**
 * Class initiation.
 *
 * @param {Object} settings: Object containing option overrides.
 */

  var Dropdown = function (settings) {
    var defaults = {
      container: '.Dropdown',
      outputContainer: null,
      trigger: null,
      list: null,
      storage: null,
      default: null,
      eventName: 'selected',
      options: []
    };  

    this.settings = $.extend({}, defaults, settings || {});
    this.el = this.settings.container;
    this.settings.outputContainer = this.settings.outputContainer || $(this.settings.container).find('.output');
    this.settings.trigger = this.settings.trigger || $(this.el).find('.trigger');
    this.settings.list = this.settings.list || $(this.el).find('.list');
    this.settings.storage = this.settings.storage || '#dropdownData';
    this.setup();
    };

  /**
   * Setup HTML and click listeners
   */ 
  Dropdown.prototype.setup = function () {
    var self = this;
    if (this.settings.default) $(this.settings.trigger).text(this.settings.default);
    $(this.settings.options).each(function(){
      $(self.settings.list).append('<li class="option" data-value="'+this.toString()+'">'+this.toString()+'</li>');
    });
    if (this.settings.storage === null) $(this.el).after('<input type="hidden" id="dropdownData" value="null">');

    $(this.settings.trigger).on('click', function(e){
      e.stopPropagation();
      e.preventDefault();
      self.show();
    });
    $(this.el).find('.option').on('click', function(){
      self.select(this);
      self.close();
    });
    $('html').on('click', function(){
      self.close();
    });
  };

  /**
   * Displays the dropdown.
   */ 
  Dropdown.prototype.show = function () {
    $(this.settings.list).show();    
  };

  /**
   * Closes the dropdown.
   */ 
  Dropdown.prototype.close = function () {
    $(this.settings.list).hide();    
  };

  /**
   * Make a selection
   */ 
  Dropdown.prototype.select = function (option) {
    var selection = $(option).data('value');

    $(this.settings.list).data('selection', selection).attr('data-selection', selection).hide();    
    $(this.settings.storage).attr('value', selection);
    $(this.settings.outputContainer).text(selection);
    $(window).trigger(this.settings.eventName);
  };

  window.Dropdown = Dropdown;

})();

(function($) {  
  $.entwine('ss', function($) {
    $.entwine('colymba', function($) {


      $('.colorField').entwine({
        onmatch: function(){
          this.sync();
        },
        onunmatch: function(){},
        sync: function()
        {
          var $parent = this.parents('.field'),
              $proxy  = $parent.find('.colorFieldProxy'),
              hex     = $proxy.val().replace('#', ''),
              alpha   = parseFloat($proxy.attr('data-opacity')) * 100;

          alpha = ('000' + alpha).slice(-3);
          this.val(hex + alpha).attr('value', hex + alpha);
        }
      });


      $('.colorFieldProxy').entwine({
        onmatch: function(){
          var $parent = this.parents('.field'),
              $field  = $parent.find('.colorField'),
              config  = $field.data('config') ? $field.data('config') : {};


          config.change = function(hex, opacity) {
            var $proxy  = $(this),
                $parent = $proxy.parents('.field'),
                $field  = $parent.find('.colorField'),
                $color  = $parent.find('.colorFieldPreview .color'),
                $hex    = $parent.find('.colorFieldControls .hex'),
                $red    = $parent.find('.colorFieldControls .r'),
                $green  = $parent.find('.colorFieldControls .g'),
                $blue   = $parent.find('.colorFieldControls .b'),
                $alpha  = $parent.find('.colorFieldControls .alpha'),
                rgba    = $proxy.minicolors('rgbObject');
           
              $color.css({
                backgroundColor: hex,
                opacity: rgba.a
              });

              $hex.val(hex.replace('#', ''));
              $alpha.val(rgba.a);

              $red.val(rgba.r);
              $green.val(rgba.g);
              $blue.val(rgba.b);

              $field.sync();
          };

          this.minicolors(config);
        },
        onunmatch: function(){}
      });


      $('.colorFieldControls input').entwine({
        onmatch: function(){},
        onunmatch: function(){},

        onchange: function(e){          
          var $parent  = this.parents('.field'),
              $proxy   = $parent.find('.colorFieldProxy'),
              $r       = $parent.find('.colorFieldControls .r'),
              $g       = $parent.find('.colorFieldControls .g'),
              $b       = $parent.find('.colorFieldControls .b'),
              type     = this.attr('name').split('_').pop(),
              rgbRegEx = new RegExp('[^0-9]', 'i'),
              r, g, b, a;

          switch (type)
          {
            case 'red':
            case 'green':
            case 'blue':
              r = $r.val().replace(rgbRegEx, '');
              r = (!r) ? 0 : parseInt(r);

              g = $g.val().replace(rgbRegEx, '');
              g = (!g) ? 0 : parseInt(g);

              b = $b.val().replace(rgbRegEx, '');
              b = (!b) ? 0 : parseInt(b);

              $r.val(r);
              $g.val(g);
              $b.val(b);

              $proxy.minicolors('value', '#' + 
                ('00' + r.toString(16)).slice(-2) +
                ('00' + g.toString(16)).slice(-2) +
                ('00' + b.toString(16)).slice(-2)
              );
              break;

            case 'alpha':
              a = this.val().replace(new RegExp('[^0-9.]', 'i'), '');
              a = (!a) ? 1 : parseFloat(a);

              if ( a < 0 ) { a = 0; }
              if ( a > 1 ) { a = 1; }

              this.val(a);
              $proxy.minicolors('opacity', a);
              break;
          }
        }
      });


      $('.colorFieldControls .colorMode').entwine({
        onmatch: function(){},
        onunmatch: function(){},

        onchange: function(e){          
          var $parent = this.parents('.field'),
              $proxy  = $parent.find('.colorFieldProxy');

          $proxy.minicolors('settings', {control: this.val()});
        }
      });


    }); // colymba namespace
  }); // ss namespace
}(jQuery));
<?php
/**
 * ColorField is a and advanced color picker.
 * Implements JQuery Minicolors, a preview and direct Hex, RGB and Alpha input.
 *
 * @author Thierry Francois @colymba
 *
 * @package SS_ColorField
 * @subpackage Form
 */
class ColorField extends FormField {

  /**
   * Field's max length RRGGBBAAA
   * @var int
   */
  protected $maxLength = 9;

  /**
   * JQuery Minicolors plugin config
   * https://github.com/claviska/jquery-minicolors
   * 
   * @var array
   */
  protected $jsConfig = array(
    'animationSpeed'  => 50,
    'animationEasing' => 'swing',
    'change'          => null,
    'changeDelay'     => 0,
    'control'         => 'hue',
    'defaultValue'    => '',
    'hide'            => null,
    'hideSpeed'       => 100,
    'letterCase'      => 'lowercase',
    'opacity'         => true,
    'position'        => 'bottom left',
    'show'            => null,
    'showSpeed'       => 100,
    'theme'           => 'default'
  );

  /**
   * JQuery Minicolors plugin config overrides
   * 
   * @var array
   */
  protected $jsConfigOverrides = array(
    'inline' => true
  );

  /**
   * Return a new ColorField
   * 
   * @param string $name     Field's name
   * @param string $title    Field's title
   * @param string $value    Field's value
   * @param array  $jsConfig JQuery Minicolors plugin config
   */
  public function __construct($name, $title = null, $value = null, $jsConfig = array()) {
    $this->jsConfig = array_merge($this->jsConfig, $jsConfig);

    parent::__construct($name, $title, $value);
  }

  /**
   * Returns the field's HTML attributes
   * @return array HTML attributes
   */
  public function getAttributes() {
    return array_merge(
      parent::getAttributes(),
      array(
        'size' => $this->maxLength,
        'class' => 'text colorField'
      )
    );
  }

  /**
   * Return the JQuery Minicolors plugin config
   * @return array Minicolors plugin config
   */
  public function getJSConfig() {
    return $this->jsConfig;
  }

  /**
   * Sets a JQuery Minicolors plugin config option
   * 
   * @param string $key Config name
   * @param mixed $val Config value
   */
  public function setJSConfig($key, $val) {
    $this->jsConfig[$key] = $val;
    return $this;
  }


  /**
   * Return's the field for the template
   * 
   * @return string
   */
  public function Field($properties = array()) {
    Requirements::javascript(FRAMEWORK_DIR . '/thirdparty/jquery/jquery.js');
    Requirements::javascript(FRAMEWORK_DIR . '/thirdparty/jquery-entwine/dist/jquery.entwine-dist.js');

    Requirements::javascript(SS_COLORFIELD . '/js/vendor/jquery-minicolors/jquery.minicolors.js');
    Requirements::css(SS_COLORFIELD . '/js/vendor/jquery-minicolors/jquery.minicolors.css');

    Requirements::javascript(SS_COLORFIELD . '/js/ColorField.js');
    Requirements::css(SS_COLORFIELD . '/css/ColorField.css');

    $jsConfig = array_merge($this->jsConfig, $this->jsConfigOverrides);

    $id = $this->ID();

    $color = DBField::create_field('Color', $this->Value(), 'Color');
    $hex   = $color->Hex();
    $red   = $color->R();
    $green = $color->G();
    $blue  = $color->B();
    $alpha = $color->Alpha();

    if (!$jsConfig['opacity'])
    {
      $alpha = 1;
    }

    $data = array(
      'JSConfig' => htmlspecialchars(json_encode($jsConfig)),
      'Options' => array(
        'Alpha' => $this->jsConfig['opacity']
      ),
      'Color' => array(
        'Hex' => $hex,
        'R'   => $red,
        'G'   => $green,
        'B'   => $blue,
        'A'   => $alpha
      ),
      'Controls' => array(
        'Mode'       => DropdownField::create($id . '_mode', $jsConfig['control'], array(
                          'hue'        => 'Hue',
                          'brightness' => 'Brightness',
                          'saturation' => 'Saturation',
                          'wheel'      => 'Wheel'
                        ))
                        ->addExtraClass('no-change-track colorMode'),

        'Proxy'      => HiddenField::create($id . '_proxy', '', $hex)
                        ->addExtraClass('no-change-track colorFieldProxy')
                        ->setAttribute('data-opacity', $alpha),

        'Hex'        => TextField::create($id . '_hex', '', $hex, 6)
                        ->addExtraClass('no-change-track hex'),

        'Red'        => NumericField::create($id . '_red', '', $red, 3)
                        ->addExtraClass('no-change-track mode_wheel r'),

        'Green'      => NumericField::create($id . '_green', '', $green, 3)
                        ->addExtraClass('no-change-track mode_wheel g'),

        'Blue'       => NumericField::create($id . '_blue', '', $blue, 3)
                        ->addExtraClass('no-change-track mode_wheel b'),
        /*
        'Hue'        => NumericField::create($id . '_hue', '', $hue, 3)
                        ->addExtraClass('no-change-track'),

        'Saturation' => NumericField::create($id . '_saturation', '', $saturation, 3)
                        ->addExtraClass('no-change-track'),

        'Brightness' => NumericField::create($id . '_brightness', '', $brightness, 3)
                        ->addExtraClass('no-change-track'),
        */
        'Alpha'      => NumericField::create($id . '_alpha', '', $alpha, 3)
                        ->addExtraClass('no-change-track alpha')
      )
    );

    return $this->customise($data)->renderWith('ColorField');
  }
}

<?php
/**
 * DBField for Color manipulation and DB storage.
 *
 * Color are stored in the DB as RRGGBBAAA:
 * Hex RGB value + 3 digit Alpha
 * AAA = [0,100] : 100 = 1 alpha / 001 = 0.01 alpha
 *
 * @author Thierry Francois @colymba
 *
 * @package SS_ColorField
 * @subpackage Field
 */
class Color extends DBField {

  /**
   * Color Hexadecimal value
   * @var string
   */
  protected $hex; // RRGGBB

  /**
   * Decimal 0-1 Alpah value
   * @var float
   */
  protected $alpha; // X.X

  /**
   * DBField contrustor
   * 
   * @param string $name Field name
   */
  public function __construct($name = null) {
    $this->defaultVal = '000000100';

    parent::__construct($name);
  }

  /**
   * (non-PHPdoc)
   * @see DBField::requireField()
   */
  public function requireField() {
    $parts = array(
      'datatype'      => 'varchar',
      'precision'     => 9,
      'character set' => 'utf8',
      'collate'       => 'utf8_general_ci',
      'arrayValue'    => $this->arrayValue
    );

    $values = array(
      'type' => 'varchar',
      'parts' => $parts
    );

    DB::require_field($this->tableName, $this->name, $values);
  }

  /**
   * (non-PHPdoc)
   * @see DBField::scaffoldFormField()
   */
  public function scaffoldFormField($title = null) {
    $field = new ColorField($this->name, $title);

    return $field;
  }

  /**
   * Returns the value to be set in the database to blank this field.
   *
   * @return null
   */
  public function nullValue() {
    return null;
  }

  /**
   * Make sure the field's actual value is in an acceptable format
   * or convert's it.
   * 
   * @param  mixed $value Field's value
   * @return string       Correct field's value
   */
  protected function formatValue($value)
  {
    $val = $value;

    if ( $val === null || $val === '' || $val === 0 )
    {
      $val = $this->defaultVal;
    }

    return $val;
  }

  /**
   * Sets the field's value
   * and sync Hex and Alpah properties.
   * 
   * @param string $value Field's value (RRGGBBAAA)
   * @param mixed $record Associated record
   */
  public function setValue($value, $record = NULL) {
    $value = $this->formatValue($value);

    $this->value = $value;
    $this->hex   = $this->extractHex($value);
    $this->alpha = intval($this->extractAlpha($value)) / 100;
  }

  /**
   * Updates the fiels's value from the Hex and Alpha properties
   */
  protected function syncValue() {
    $hex   = $this->hex;
    $alpha = str_pad(($this->alpha * 100), 3, '0', STR_PAD_LEFT);

    $this->value = $hex . $alpha;
  }

  /**
   * Extrac the RGB Hex value from a RRGGBBAAA string
   * @param  string $value RGBA String
   * @return string        Hex RGB
   */
  protected function extractHex($value)
  {
    return substr($value, 0, 6);
  }

  /**
   * Extrac the Alpah value from a RRGGBBAAA string
   * @param  string $value RGBA String
   * @return string        Alpha
   */
  protected function extractAlpha($value)
  {
    return substr($value, -3);
  }

  /**
   * Sets the field's RGB value in Hex format
   * @param string $hex RGB or RRGGBB Hex value
   */
  public function setHex($hex)
  {
    $this->hex = self::format_hex($hex);
    $this->syncValue();
    return $this;
  }

  /**
   * Return the Hex representation of the color
   * @return string Hex value
   */
  public function Hex()
  {
    return $this->hex;
  }

  /**
   * Sets the field's Alpah value
   * @param float $alpha Alpha value between 0 and 1 (e.g. 0.55)
   */
  public function setAlpha($alpha)
  {
    $this->alpha = $alpha;
    $this->syncValue();
    return $this;
  }

  /**
   * Return the Alpha value or the color
   * @return float Alpah value
   */
  public function Alpha()
  {
    return $this->alpha;
  }

  /**
   * Return an RGB array representation of this color
   * @return array Associative RGB array
   */
  public function RGB()
  {
    return self::hex_to_rgb($this->hex);
  }

  /**
   * Return the decimal Red component of the color
   * @return integer Red value
   */
  public function R()
  {
    return self::hex_to_rgb($this->hex)['R'];
  }

  /**
   * Return the decimal Green component of the color
   * @return integer Green value
   */
  public function G()
  {
    return self::hex_to_rgb($this->hex)['G'];
  }

  /**
   * Return the decimal Blue component of the color
   * @return integer Blue value
   */
  public function B()
  {
    return self::hex_to_rgb($this->hex)['B'];
  }

  /**
   * Return a correctly formatted Hex value RRGGBB
   * @param  string $hex Possible Hex value
   * @return string      RRGGBB hex value
   */
  public static function format_hex($hex)
  {
    if ( strlen($hex) < 6 )
    {
      $r = substr($hex, 0, 1);
      $g = substr($hex, 1, 1);
      $b = substr($hex, 2, 1);

      return $r . $r . $g . $g . $b . $b;
    }
    else {
      return $hex;
    }
  }

  /**
   * Convert and Hex color into RGB decimal components
   * @param  string $hex Hex color value
   * @return array Associative RGB array
   */
  public static function hex_to_rgb($hex)
  {
    $hex = self::format_hex($hex);

    return array(
      'R' => hexdec(substr($hex, 0, 2)),
      'G' => hexdec(substr($hex, 2, 2)),
      'B' => hexdec(substr($hex, 4, 2))
    );
  }

  /**
   * Convert RGB color component int an Hex color string
   * @param  integer $r Red component
   * @param  integer $g Green component
   * @param  integer $b Blue component
   * @return string     RRGGBB Hex value
   */
  public static function rgb_to_hex($r, $g, $b)
  {
    $r = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
    $g = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
    $b = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

    return $r . $g . $b;
  }  
}

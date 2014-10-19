SilverStripe COLOR FIELD
========================

[![Latest Stable Version](https://poser.pugx.org/colymba/silverstripe-colorfield/v/stable.svg)](https://github.com/colymba/silverstripe-colorfield/releases)
[![Latest Unstable Version](https://poser.pugx.org/colymba/silverstripe-colorfield/v/unstable.svg)](https://github.com/colymba/silverstripe-colorfield/tree/master)
[![License](https://poser.pugx.org/colymba/silverstripe-colorfield/license.svg)](#license-bsd-simplified)

Color picker and DBField field with attitude.

![preview](screenshots/preview.png)
![preview](screenshots/preview_2.png)

# ColorField
The `ColorField` form field implementing a color picker with extra input methods. Using [jQuery MiniColors](https://github.com/claviska/jquery-minicolors).

# Color
The `Color` DBField for storing and manipulating colors:
- `$color->RGB()`, `$color->Hex()`, `$color->Alpha()`
- `Color::hex_to_rgb($hex)`, `Color::rgb_to_hex($r, $g, $b)`
- `$Color.R`, `$Color.G`, `$Color.B`, `$Color.Alpha`, `$Color.Hex`

## Requirements
* Silverstripe 3+

## Installation
### Composer
* `composer require "colymba/silverstripe-colorfield:*"`
### Manual
* Download and copy module in SilverStripe root directory

#### @TODO
* HSL/HSB/CMYK/RGB/HEX convertions
* HSL/HSB filed input

## License (BSD Simplified)

Copyright (c) 2013, Thierry Francois (colymba)

All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

 * Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
 * Neither the name of Thierry Francois, colymba nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.
 
THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
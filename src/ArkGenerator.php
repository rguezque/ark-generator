<?php

declare(strict_types=1);

namespace rguezque\ArkGenerator;

class ArkGenerator {
    /** @var string The current scheme for identifier */
    private string $scheme;

    /** @var string The NAAN */
    private string $naan;

    /** @var string A custom _blade_ */
    private ?string $blade = null;

    /**
     * Setup the generator
     * 
     * @param string The NAAN
     * @param string Identifier scheme [ARK, DOI, URN, HDL (Handle)]
     */
    public function __construct(string $naan, string $scheme = Constants::ARK_SCHEME) {
        $this->naan = trim($naan);
        $this->scheme = pipe('trim', 'strtolower')($scheme);
    }

    /**
     * Set a custom _blade_
     * 
     * @param string $blade The string suffix
     * @return ArkGenerator
     */
    public function setBlade(string $blade): ArkGenerator {
        $this->blade = pipe('clean_hyphens', 'trim')($blade);
        return $this;
    }

    /**
     * Reset the _blade_ to `null`
     * 
     * @return ArkGenerator
     */
    public function resetBlade(): ArkGenerator {
        $this->blade = null;
        return $this;
    }

    /**
     * Generate the suffix and return a data array about the identifier
     * 
     * @param string $shoulder The _shoulder_ for prepend to _blade_
     * @param string $mask A string mask to define how to generate the _blade_
     * @return array
     */
    function generate(string $shoulder, string $mask): array {
        $shoulder = pipe('clean_hyphens', 'trim', 'strtolower')($shoulder);
        $blade = $this->blade ?? $this->generateBlade($mask);

        $bow = $this->scheme . ':' . $this->naan;
        $suffix = $shoulder . $blade;
        $identifier = $this->naan . '/' . $suffix;

        return [ 
            'scheme' => $this->scheme,
            'prefix' => $this->naan,
            'bow' => $bow,
            'shoulder' => $shoulder,
            'blade' => $blade,
            'suffix' => $suffix,
            'identifier' => $identifier,
            'full_scheme' => $this->scheme . ':' . $identifier,
            'created_at' => time()
        ];
    }

    /**
     * Generate and return the _blade_, based on the given mask
     * 
     * @param string $mask A string mask to define how to generate the _blade_
     * @return string
     */
    public function generateBlade(string $mask): string {
        if(0 === pipe('trim', 'strlen')($mask)) {return '';}

        // Charsets availables
        $digits = Constants::DIGITS;
        $lcase_consonantic = Constants::LCASE_CONSONANTIC;
        $betanumeric = Constants::BETA_NUMERIC;
        $special_chars = Constants::SPECIAL_CHARS;
        
        $d_count = strlen($digits);
        $lc_count = strlen($lcase_consonantic);
        $b_count = strlen($betanumeric);
        $s_count = strlen($special_chars);
        
        $mask = pipe('trim', 'str_split')($mask);
        $blade = '';

        // Recorre cada carácter de la máscara
        foreach ($mask as $mask_char) {
            switch ($mask_char) {
                case 'd':
                    // 'd': Generate a digit (0-9)
                    $blade .= $digits[random_int(0, $d_count - 1)];
                    break;
                case 'c':
                    // 'c': Generate an consonantic alphabet char in lowercase excluding "l" (elle) letter (bcdfghjkmnpqrstvwxz)
                    $blade .= $lcase_consonantic[random_int(0, $lc_count - 1)];
                    break;
                case 'b':
                    // 'b': Generate an betanumeric char (bcdfghjkmnpqrstvwxz0123456789)
                    $blade .= $betanumeric[random_int(0, $b_count - 1)];
                    break;
                case 's':
                    // 's': Generate an special char (=~*+@_$)
                    $blade .= $special_chars[random_int(0, $s_count - 1)];
                    break;
                default:
                    // Any other char is directly added
                    $blade .= strtolower($mask_char);
                    break;
            }
        }

        return $blade;
    }
}

<?php declare(strict_types = 1);

namespace rguezque\ArkGenerator;

class Constants {
    /** @var string ARK scheme */
    const ARK_SCHEME = 'ark';

    /** @var string DOI scheme */
    const DOI_SCHEME = 'doi';
    
    /** @var string URN scheme */
    const URN_SCHEME = 'urn';
    
    /** @var string Handle scheme */
    const HDL_SCHEME = 'hdl';

    /** @var string Integer digits */
    const DIGITS = '0123456789';

    /** @var string Lowercase consonantic alphabet, excluding "l" (elle) letter */
    const LCASE_CONSONANTIC = 'bcdfghjkmnpqrstvwxyz';
    
    /** @var string Uppercase alphabet */
    const UCASE_CONSONANTIC = 'BCDFGHJKLMNPQRSTVWXYZ';
    
    /** @var string Special chars (=~*+@_$) */
    const SPECIAL_CHARS = '=~*+@_$';
    
    /** @var string Betanumeric digits (bcdfghjkmnpqrstvwxz0123456789) excluding vocals and "l" (elle) letter */
    const BETA_NUMERIC = self::DIGITS . self::LCASE_CONSONANTIC;
    
    /** @var string Extended betanumeric digits (bcdfghjkmnpqrstvwxz0123456789BCDFGHJKLMNPQRSTVWXYZ) */
    const EXTENDED = self::BETA_NUMERIC . self::UCASE_CONSONANTIC;
}

?>
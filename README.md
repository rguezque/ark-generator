# Ark Generator

Un sencillo generador de identificadores ARK (Archival Resource Key). También puede utilizarse para generar identificadores *DOI*, *URN* o *Handle*.

## Generar un identificador ARK

Para empezar crea una instancia de la clase `Generator` la cual recibe dos argumentos:

- El número NAAN. Un identificador único asignado por [ARK Alliance](https://arks.org/).
- El esquema del identificador. En este caso por default es `ark`; sin embargo tambien puede especificarse como `doi`, `urn` o `hdl` (*Handle*)

Después ejecuta el método `ArkGenerator::generate` el cual recibe dos argumentos:

- Un *shoulder*. Es un *string* que sirve a su vez como *cabecera* del prefijo a generar. El usuario lo define.
- Una *máscara*. Es una cadena betanumérica que le dice al generador como formar el *blade* (Que se agrega al final del *shoulder*).

Juntos forman el sufijo del ark.

```php
// index.php
declare(strict_types = 1);

use rguezque\ArkGenerator\ArkGenerator;

require __DIR__.'/vendor/autoload.php';

$gen = new ArkGenerator('68066');
$result = $gen->generate('p3  ', 'cbbbddck');

echo print_r($result, true);
```

Ejecuta desde la terminal:

```bash
php ./index.php
```

Esto devolvera un *array* con los datos resultantes, en una estructura como la siguiente:

```php
[
    'scheme' => 'ark',
    'prefix' => '68066',
    'bow' => 'ark:68066',
    'shoulder' => 'p3',
    'blade' => 'f8j491xk',
    'suffix' => 'p3f8j491xk',
    'identifier' => '68066/p3f8j491xk',
    'full_scheme' => 'ark:68066/p3f8j491xk',
    'created_at' => '1763060594'
];
```

Si se prefiere definir un *blade* explicitamente por el usuario, utiliza el método `ArkGenerator::setBlade` antes de invocar `ArkGenerator::generate`. Restablece el *blade* a `null` con `ArkGenerator::resetShoulderPrefix`. 

>[!NOTE]
>Evita utilizar el NAAN `99999`, y el *shoulder* `fk`, ya que son considerados por lo regular como identificadores de prueba.
>Si el *shoulder* contiene guiones (`-`) estos serán ignorados. Ej. `x3-k` se convertirá a `x3k`.
>Por convención de ARK, todo se generará en minúsculas.

## Acerca de la mascara para generar los sufijos

Al momento de generar un sufijo, el método `ArkGenerator::generate` necesita un *string* que sirve como una mascara que permite definir como se formara el sufijo del ARK; a continuación el significado de cada caracter o _flag_ que puede formar una mascara:

- `d`: Genera un número entero entre el `0` y el `9`.
- `c`: Genera una letra del alfabeto consonántico omitiendo la letra `l` (ele) para evitar confusiones con el número `1` (`bcdfghjkmnpqrstvwxyz`).
- `b`: Genera un caracter betanúmerico (`bcdfghjkmnpqrstvwxz0123456789`).
- `s`: Genera un caracter especial (`=~*+@_$`). Se omite `:` y `/` porque están reservados por el resolutor (*resolver*).

Las *flags* con `case-sensitive` y cualquier otra letra que no sea una _flag_, se asignará directamente al prefijo resultante en el orden en que haya sido definida.

## Documentación adicional

### Sobre el esquema del identificador ARK

- [Sitio oficial](https://arks.org)
- [Recursos relacionados a ARK](https://arks.org/resources/)
- Consulta [The ARK Identifier Scheme Specifications](https://datatracker.ietf.org/doc/draft-kunze-ark/) o bien el archivo de texto [`draft-kunze-ark-42.txt`](./docs/draft-kunze-ark-42.txt) ubicado en `/docs/`.
- [General Identifier Concepts and Conventions](https://arks.org/about/identifier-concepts-and-conventions/)

### Sobre el esquema DOI
- [Constructing your DOIs](https://www-crossref-org.translate.goog/documentation/member-setup/constructing-your-dois/?_x_tr_sl=en&_x_tr_tl=es&_x_tr_hl=es&_x_tr_pto=tc)

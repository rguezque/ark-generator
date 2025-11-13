# Ark Generator

Un sencillo generador de identificadores ARK (Archival Resource Key). También puede utilizarse para generar identificadores *DOI*, *URN* o *Handle*.

## Generar un identificador ARK

Para empezar crea una instancia de la clase `Generator` la cual recibe dos argumentos:

- El número NAAN. Un identificador único asignado por [ARK Alliance](https://arks.org/).
- El esquema del identificador. En este caso por default es `ark`; sin embargo tambien puede especificarse como `doi`, `urn` o `hdl` (*Handle*)

Después ejecuta el método `Generator::generate` el cual recibe dos argumentos:

- Un *shoulder prefix*. Es un *string* que sirve a su vez como *prefijo*, del prefijo a generar. El usuario lo define.
- Una *máscara*. Es una cadena alfabética que le dice al generador como formar el *shoulder suffix* (Es a su vez el *sufijo* del prefijo a conformar).

```php
// index.php
declare(strict_types = 1);

use rguezque\ArkGenerator\Generator;

require __DIR__.'/vendor/autoload.php';

$gen = new Generator('68066');
$result = $gen->generate('p3  ', 'aaadaaadk');

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
    'shoulder_prefix' => 'p3',
    'shoulder_suffix' => 'it81so08k',
    'suffix' => 'p3it81so08k',
    'identifier' => '68066/p3it81so08k',
    'identifier_length' => '17',
    'full_scheme' => 'ark:68066/p3it81so08k',
    'created_at' => '1763060594'
];
```

Si se prefiere definir un *shoulder prefix* explicitamente por el usuario, utiliza el método `Generator::setShoulderPrefix` antes de invocar `Generator::generate`. Restablece el *shoulder prefix* a `null` con `Generator::resetShoulderPrefix`. 

>[!NOTE]
>Evita utilizar el NAAN `99999`, ni el *shoulder prefix* `fk`, ya que son considerados por lo regular como identificadores de prueba.
>Si el *shoulder prefix* contiene guiones (`-`) estos serán ignorados. Ej. `x3-k` se convertirá a `x3k`.

## Sobre la mascara para generar los sufijos

Al momento de generar un sufijo, el método `Generator::generate` necesita un *string* que sirve como una mascara que permite definir como se formara el sufijo del ARK; a continuación el significado de cada caracter o _flag_ que puede formar una mascara:

- `d`: Genera un número entero entre el `0` y el `9`.
- `l`: Genera una letra del alfabeto (se omite la `ñ`) en minúsculas (`a-z`).
- `u`: Genera una letra del alfabeto (se omite la `Ñ`) en mayúsculas (`A-Z`).
- `a`: Genera un caracter alfanúmerico (se omite la ñ) (`0-9`, `a-z`,).
- `e`: Genera un caracter alfanúmerico extendido (se omite la `ñ` y la `Ñ`) (`0-9`, `a-z`, `A-Z`).
- `s`: Genera un caracter alfanúmerico extendido incluyendo algunos caracteres especiales (se omite la `ñ` y la `Ñ`) (`0-9`, `a-z`, `A-Z`, `=~*+@_$`).

Las *flags* con `case-sensitive` y cualquier otra letra que no sea una _flag_, se asignará directamente al prefijo resultante en el orden en que haya sido definida.

## Documentación adicional

### Sobre el esquema del identificador ARK

- [Sitio oficial](https://arks.org)
- [Recursos relacionados a ARK](https://arks.org/resources/)
- Consulta [The ARK Identifier Scheme Specifications](https://datatracker.ietf.org/doc/draft-kunze-ark/) o bien el archivo de texto [`draft-kunze-ark-42.txt`](./docs/draft-kunze-ark-42.txt) ubicado en `/docs/`.
- [General Identifier Concepts and Conventions](https://arks.org/about/identifier-concepts-and-conventions/)

### Sobre el esquema DOI
- [Constructing your DOIs](https://www-crossref-org.translate.goog/documentation/member-setup/constructing-your-dois/?_x_tr_sl=en&_x_tr_tl=es&_x_tr_hl=es&_x_tr_pto=tc)

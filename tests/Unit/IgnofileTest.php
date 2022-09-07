<?php

use Sikessem\Ignorant\Ignorefile;
use Sikessem\Capsule\Encapsulable;

test('Test ignore files', function () {
    expect($ignore = new Ignorefile(__DIR__.'/.skeignore'))
        ->toBeInstanceOf(Ignorefile::class)
        ->toBeInstanceOf(Encapsulable::class)
    ;

    expect($ignore->file)
        ->toBeString()
        ->toEqual(__DIR__.DIRECTORY_SEPARATOR.'.skeignore')
    ;

    $this->assertTrue($ignore->contains('#/bin/'));
    $this->assertTrue($ignore->contains('/.GIT/'));
    $this->assertTrue($ignore->contains('#/bin/'));
    $this->assertTrue($ignore->contains('.*IGNORE'));
    $this->assertTrue($ignore->contains('!/tests/unit/.skeignore'));
    $this->assertTrue($ignore->includes('/.git'));
    $this->assertTrue($ignore->includes('/.git/'));
    $this->assertTrue($ignore->includes('.ftpignore'));
    $this->assertTrue($ignore->includes('/ske/.ftpignore'));
    $this->assertTrue($ignore->includes('/tests/unit/.gitignore'));
    $this->assertTrue($ignore->excludes('/ske/.git'));
    $this->assertTrue($ignore->excludes('/tests/unit/.skeignore'));
    $this->assertTrue($ignore->excludes('ske.ini'));
    $this->assertTrue($ignore->excludes('/.ske/'));
    $this->assertTrue($ignore->excludes('/ske'));

    $this->assertFalse(!$ignore->contains('#/bin/'));
    $this->assertFalse(!$ignore->contains('/.GIT/'));
    $this->assertFalse(!$ignore->contains('#/bin/'));
    $this->assertFalse(!$ignore->contains('.*IGNORE'));
    $this->assertFalse(!$ignore->contains('!/tests/Unit/.skeignore'));
    $this->assertFalse(!$ignore->includes('/.git'));
    $this->assertFalse(!$ignore->includes('/.git/'));
    $this->assertFalse(!$ignore->includes('.ftpignore'));
    $this->assertFalse(!$ignore->includes('/ske/.ftpignore'));
    $this->assertFalse(!$ignore->includes('/tests/unit/.gitignore'));
    $this->assertFalse(!$ignore->excludes('/ske/.git'));
    $this->assertFalse(!$ignore->excludes('/tests/unit/.skeignore'));
    $this->assertFalse(!$ignore->excludes('ske.ini'));
    $this->assertFalse(!$ignore->excludes('/.ske/'));
    $this->assertFalse(!$ignore->excludes('/ske'));

    
    $gitignore = new Ignorefile(dirname(__DIR__, 2).'/.gitignore');

    $this->assertTrue($gitignore->contains('/vendor/'));
    $this->assertTrue($gitignore->contains('/.phpunit*'));

    $this->assertTrue($gitignore->includes('/vendor/autoload.php'));
    $this->assertTrue($gitignore->includes('/.phpunit.result.cache'));

    $this->assertTrue($gitignore->excludes('src'));
    $this->assertTrue($gitignore->excludes('/tests/Unit'));
});

<?php

namespace Sikessem\Ignorant;

class Ignorefile extends Ignore {
    public function __construct(string $file) {
        $this->setFile($file);
    }

    protected string $file;

    public function setFile(string $file): self {
        if (!is_file($file)) {
            throw new Exception("No such file $file");
        }
        $this->file = realpath($file);
        return $this->setLines(self::load($file));
    }

    public function getFile(): string {
        return $this->file;
    }

    public static function load(string $file, bool $ignore_blank_lines = false): array {
        return file($file, $ignore_blank_lines ? FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES : 0);
    }

    public function save(string $eol = PHP_EOL, int $flags = 0): string {
        $data = $this->render();
        file_put_contents($this->getFile(), $data, $flags);
        return $data;
    }
}
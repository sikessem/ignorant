<?php

namespace Sikessem\Ignorant;

use Sikessem\Capsule\{Encapsulable, Encapsuler};

class Ignore implements Encapsulable {
    use Encapsuler;

    protected array $lines = [];

    public function resetLines(): self {
        $this->lines = [];
        return $this;
    }

    public function setLines(array $lines): self {
        return $this->resetLines()->addLines($lines);
    }

    public function getLines(): array {
        return $this->lines;
    }

    public function addLines(array $lines): self {
        foreach($lines as $line) {
            $this->addLine($line);
        }
        return $this;
    }

    public function addLine(string $line): self {
        $line = trim($line);
        if (!$this->contains($line)) {
            $this->lines[] = $line;
        }
        return $this;
    }

    public function removeLines(array $lines): self {
        foreach($lines as $line) {
            $this->removeLine($line);
        }
        return $this;
    }

    public function removeLine(string $line): self {
        $lines = [];
        foreach($this->lines as $_line) {
            if (strtolower($line) === strtolower($_line)) {
                continue;
            }
            $lines[] = $line;
        }
        return $this->setLines($lines);
    }

    public function contains(string $pattern): bool {
        foreach ($this->getLines() as $line) {
            if (self::normalize($line) === self::normalize($pattern)) {
                return true;
            }
        }
        return false;
    }

    public function excludes(string $path): bool {
        return !$this->includes($path);
    }

    public function includes(string $path): bool {
        return self::ignores($this->getLines(), $path);
    }

    public static function ignores(array $patterns, string $path): bool {
        $ignores = false;
        foreach($patterns as $pattern) {
            if (\str_starts_with('#', $pattern)) {
                continue;
            }

            if (\str_starts_with($pattern, '!') && $ignores) {
                $pattern = \substr($pattern, 1);
                if (self::matches($pattern, $path)) {
                    $ignores = false;
                }
            }
            elseif (self::matches($pattern, $path)) {
                $ignores = true;
            }
        }
        return $ignores;
    }

    public static function matches(string $pattern, string $path): bool {
        $pattern = self::normalize($pattern);
        $path = self::normalize($path);
        if (\str_ends_with($pattern, '/')) {
            $pattern .= '*';
            if (!\str_ends_with($path, '/')) {
                $path .= '/';
            }
        }
        return fnmatch($pattern, \str_starts_with($pattern, '/') ? $path : \basename($path));
    }

    public static function normalize(string $name): string {
        $name = \strtolower($name);
        $name = \str_replace('\\', '/', $name);
        return $name;
    }

    public function render(string $eol = PHP_EOL): string {
        return implode($eol, $this->getLines());
    }

    public function __toString(): string {
        return $this->render();
    }
}
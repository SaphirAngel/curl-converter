<?php

namespace CurlConverter\CurlParser;

use http\Params;

abstract class CurlOption
{
    private string $rawOptionName;
    private string $name;
    private string $type;
    private bool $expand;
    private bool $canBeList;
    private ?array $removedVersion = null;

    private function setRemoveVersionFromString(?string $removedVersion): void
    {
        if (is_null($removedVersion)) {
            return;
        }

        $removedVersionDetails = explode('.', $removedVersion);

        $this->removedVersion[0] = $removedVersionDetails[0] ?? 0;
        $this->removedVersion[1] = $removedVersionDetails[1] ?? 0;
        $this->removedVersion[2] = $removedVersionDetails[2] ?? 0;
    }

    private function getBooleanValue()
    {
    }

    public function __construct(
        string  $rawOptionName,
        string  $name,
        string  $type,
        bool    $expand = true,
        bool    $canBeList = false,
        ?string $removedVersion = null
    ) {
        $this->rawOptionName = $rawOptionName;
        $this->name = $name;
        $this->type = $type;
        $this->expand = $expand;
        $this->canBeList = $canBeList;
        $this->setRemoveVersionFromString($removedVersion);
    }

    public function getRawOptionName(): string
    {
        return $this->rawOptionName;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function isExpand(): bool
    {
        return $this->expand;
    }

    public function isRemovedForVersion(string $curlVersion): bool
    {
        if (empty($this->removedVersion)) {
            return false;
        }

        $versionDetails = explode('.', $curlVersion);
        $patchNumber = $versionDetails[2] ?? 0;
        $minorNumber = $versionDetails[1] ?? 0;
        $majorNumber = $versionDetails[0] ?? 0;

        $stringVersion = implode('.', [$majorNumber, $minorNumber, $patchNumber]);
        $stringRemovedVersion = implode('.', $this->removedVersion);

        if ($stringVersion === $stringRemovedVersion) {
            $isRemoved = true;
        } elseif ($majorNumber > $this->removedVersion[0]) {
            $isRemoved = true;
        } elseif ($minorNumber > $this->removedVersion[1]) {
            $isRemoved = true;
        } elseif ($patchNumber > $this->removedVersion[2]) {
            $isRemoved = true;
        } else {
            $isRemoved = false;
        }

        return $isRemoved;
    }

    public function getRemovedVersion(): ?array
    {
        return $this->removedVersion;
    }

    public function canBeList(): bool
    {
        return $this->canBeList;
    }

    abstract public function getProcessedValue(mixed $rawValue = null): mixed;

    abstract public function applyToRequest(array $request, mixed $rawValue = null): array;
}


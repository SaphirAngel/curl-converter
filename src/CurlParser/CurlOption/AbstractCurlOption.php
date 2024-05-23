<?php

namespace CurlConverter\CurlParser\CurlOption;

use CurlConverter\CurlParser\CurlRequest;

abstract class AbstractCurlOption
{
    private string $rawOptionName;
    private string $name;
    private string $type;
    private bool $expand;
    private bool $canBeList;
    private ?array $removedVersion = null;
    private ?string $internalName;

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

    public function __construct(
        string  $rawOptionName,
        string  $name,
        string  $type,
        bool    $expand = true,
        bool    $canBeList = false,
        ?string $removedVersion = null,
        ?string $internalName = null
    ) {
        $this->rawOptionName = $rawOptionName;
        $this->name = $name;
        $this->type = $type;
        $this->expand = $expand;
        $this->canBeList = $canBeList;
        $this->setRemoveVersionFromString($removedVersion);
        $this->internalName = $internalName;
    }

    public function getRawOptionName(): string
    {
        return $this->rawOptionName;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getInternalName(): string
    {
        return $this->internalName;
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

    public function applyToRequest(CurlRequest $request, mixed $rawValue = null): void
    {
        $optionName = $this->internalName ?? $this->name;
        $request->setOption($optionName, $this->getProcessedValue($rawValue));
    }
}


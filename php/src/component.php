<?php
class Component
{
    private $tag;
    private $attributes;
    private $value;
    private $html;
    private $subComponents;

    public function __construct(string $tag, array $attributes = [], string $value = '', array $subComponents = [])
    {
        $this->setTag($tag);
        $this->setAttributes($attributes);
        $this->setValue($value);
        $this->setHtml('');
        $this->setSubComponents($subComponents);
    }

    private function setTag(string $tag): void
    {
        $this->tag = $tag;
    }

    private function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }

    public function setAttribute(string $attributeName, string $attributeValue)
    {
        $this->attributes[$attributeName] = $attributeValue;
    }

    public function getAttribute(string $attributeName): string
    {
        return $this->attributes[$attributeName];
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function setHtml(string $html): void
    {
        $this->html = $html;
    }

    public function getHtml(): string
    {
        return $this->html;
    }

    private function setSubComponents(array $subComponents): void
    {
        $this->subComponents = $subComponents;
    }

    public function getSubComponents(): array
    {
        return $this->subComponents;
    }

    public function getSubComponent(string $subComponentName): Component
    {
        return $this->subComponents[$subComponentName];
    }

    public function addSubComponent(string $subComponentName, Component $subComponent): void
    {
        $this->subComponents[$subComponentName] = $subComponent;
    }

    public function removeSubComponent(string $subComponentName): void
    {
        unset($this->subComponents[$subComponentName]);
    }

    public function checkSubComponent(string $subComponentName): bool
    {
        return isset($this->subComponents[$subComponentName]);
    }

    public function build(): void
    {
        $attributes = '';

        if (!empty($this->attributes) === true) {
            foreach ($this->attributes as $attributeName => $attributeValue) {
                if ($attributeName === 'noName') {
                    $attributes = $attributes . " " . $attributeValue;
                } else {
                    $attributes = $attributes . " " . $attributeName . "=" . $attributeValue;
                }
            }
        }

        $value = '';

        if (!empty($this->subComponents) === true) {
            foreach ($this->subComponents as $subComponentName => $subComponent) {
                $subComponent->build();
                $value = $value . $subComponent->getHtml();
            }
        } else {
            $value = $this->value;
        }

        if ($this->tag === '!DOCTYPE' || $this->tag === 'input' || $this->tag === 'meta' || $this->tag === 'br' || $this->tag === 'hr') {
            $this->html = "<" . $this->tag . $attributes . ">";
        } else {
            $this->html = "<" . $this->tag . $attributes . ">" . $value . "</" . $this->tag . ">";
        }
    }
}

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

    private function setTag(string $tag)
    {
        $this->tag = $tag;
    }

    private function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function getAttribute(string $attributeName)
    {
        return $this->attributes[$attributeName];
    }

    private function setValue(string $value)
    {
        $this->value = $value;
    }

    private function setHtml(string $html)
    {
        $this->html = $html;
    }

    public function getHtml()
    {
        return $this->html;
    }

    private function setSubComponents(array $subComponents)
    {
        $this->subComponents = $subComponents;
    }

    public function getSubComponent(string $subComponentName)
    {
        return $this->subComponents[$subComponentName];
    }

    public function addSubComponent(string $subComponentName, Component $subComponent)
    {
        $this->subComponents[$subComponentName] = $subComponent;
    }

    public function removeSubComponent(string $subComponentName)
    {
        unset($this->subComponents[$subComponentName]);
    }

    public function checkSubComponent(string $subComponentName)
    {
        return isset($this->subComponents[$subComponentName]);
    }

    public function build()
    {
        $attributes = '';

        if (!empty($this->attributes) === true) {
            foreach ($this->attributes as $attributeName => $attributeValue) {
                $attributes = $attributes . " " . $attributeName . "=" . $attributeValue;
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
            $this->html = $this->html . "<" . $this->tag . $attributes . ">";
        } else {
            $this->html = $this->html . "<" . $this->tag . $attributes . ">" . $value . "</" . $this->tag . ">";
        }
    }
}

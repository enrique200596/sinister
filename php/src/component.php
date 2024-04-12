<?php
class Component
{
    private $tag;
    private $attributes;
    private $value;
    private $subComponents;
    private $html;

    public function __construct(string $tag, array $attributes = [], string $value = '', array $subComponents = [])
    {
        $this->setTag($tag);
        $this->setAttributes($attributes);
        $this->setValue($value);
        $this->setSubComponents($subComponents);
        $this->setHtml('');
    }

    private function getTag()
    {
        return $this->tag;
    }

    private function setTag(string $tag)
    {
        $this->tag = $tag;
    }

    private function getAttributes()
    {
        return $this->attributes;
    }

    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue(string $value)
    {
        $this->value = $value;
    }

    public function getSubComponents(string $subComponentName = '*')
    {
        if ($subComponentName === '*') {
            return $this->subComponents;
        } else {
            if (isset($this->subComponents[$subComponentName]) === true) {
                return $this->subComponents[$subComponentName];
            } else {
                return '';
            }
        }
    }

    public function setSubComponents(array $subComponents)
    {
        $this->subComponents = $subComponents;
    }

    public function addSubComponents(string $subComponentName, Component $subComponent)
    {
        $this->subComponents[$subComponentName] = $subComponent;
    }

    public function getHtml()
    {
        return $this->html;
    }

    private function setHtml(string $html)
    {
        $this->html = $html;
    }

    public function build()
    {
        $attributes = '';

        if (empty($this->getAttributes()) != true) {
            foreach ($this->getAttributes() as $key => $value) {
                if ($key === 'noKey') {
                    $attributes = $attributes . ' ' . $value;
                } else {
                    $attributes = $attributes . ' ' . $key . '=' . $value;
                }
            }
        }

        $tag = $this->getTag();

        if ($tag === '!DOCTYPE' || $tag === 'input' || $tag === 'br' || $tag === 'hr' || $tag === 'meta') {
            $this->setHtml('<' . $tag . ' ' . $attributes . '>');
        } else {
            $value = '';
            if (count($this->getSubComponents()) > 0) {
                foreach ($this->getSubComponents() as $key => $v) {
                    $v->build();
                    $value = $value . $v->getHtml();
                }
            } else {
                $value = $this->getValue();
            }
            $this->setHtml('<' . $tag . ' ' . $attributes . '>' . $value . '</' . $tag . '>');
        }
    }
}

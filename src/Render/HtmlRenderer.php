<?php

namespace Species\HtmlForm\Render;

use Species\HtmlForm\Contract\Field\HtmlCheckboxField;
use Species\HtmlForm\Contract\Field\HtmlInputField;
use Species\HtmlForm\Contract\Field\HtmlNumberInputField;
use Species\HtmlForm\Contract\Field\HtmlRadioField;
use Species\HtmlForm\Contract\Field\HtmlSelectField;
use Species\HtmlForm\Contract\Field\HtmlSelectMultipleField;
use Species\HtmlForm\Contract\Field\HtmlSubmitField;
use Species\HtmlForm\Contract\Field\HtmlTextareaField;
use Species\HtmlForm\Contract\Node\LeafNode;

/**
 * Html renderer.
 */
final class HtmlRenderer
{

    /**
     * @param LeafNode $node
     * @param array    $attributes = []
     * @return string
     */
    public function render(LeafNode $node, array $attributes = []): string
    {
        if ($node instanceof HtmlInputField) {
            return $this->renderInput($node, $attributes);
        }
        if ($node instanceof HtmlTextareaField) {
            return $this->renderTextarea($node, $attributes);
        }
        if ($node instanceof HtmlSubmitField) {
            return $this->renderSubmit($node, $attributes);
        }
        if ($node instanceof HtmlCheckboxField) {
            return $this->renderCheckbox($node, $attributes);
        }
        if ($node instanceof HtmlRadioField) {
            return $this->renderRadio($node, $attributes);
        }
        if ($node instanceof HtmlSelectField) {
            return $this->renderSelect($node, $attributes);
        }
        if ($node instanceof HtmlSelectMultipleField) {
            return $this->renderSelectMultiple($node, $attributes);
        }

        return '';
    }



    /**
     * @param HtmlInputField $node
     * @param array          $attributes
     * @return string
     */
    public function renderInput(HtmlInputField $node, array $attributes = []): string
    {
        $attributes = array_replace([
            'type' => $node->getType(),
        ], $attributes, [
            'name' => $node->getName(),
            'value' => $node->getValue(),
            'required' => $node->isRequired(),
        ]);

        if ($node->getType() === 'password') {
            unset($attributes['value']);
        }

        if ($node instanceof HtmlNumberInputField) {
            $attributes = array_replace([
                'min' => $node->getMin(),
                'max' => $node->getMax(),
                'step' => $node->getStep(),
            ], $attributes);
        }

        $attributes = $this->attributesToHtml($attributes);

        return "<input $attributes>";
    }

    /**
     * @param HtmlTextareaField $node
     * @param array             $attributes
     * @return string
     */
    public function renderTextarea(HtmlTextareaField $node, array $attributes = []): string
    {
        $attributes = array_replace($attributes, [
            'name' => $node->getName(),
            'required' => $node->isRequired(),
        ]);

        $attributes = $this->attributesToHtml($attributes);
        $value = $this->stringToHtml($node->getValue());

        return "<textarea $attributes>$value</textarea>";
    }

    /**
     * @param HtmlSubmitField $node
     * @param array           $attributes
     * @return string
     */
    public function renderSubmit(HtmlSubmitField $node, array $attributes = []): string
    {
        $button = $attributes['button'] ?? false;

        $attributes = array_replace($attributes, [
            'type' => 'submit',
            'name' => $node->getName(),
            'value' => $node->getCheckedValue(),
        ]);

        if (!$button) {
            return "<input $attributes>";
        }

        $label = $this->stringToHtml($button === true ? $node->getValue() : $button);

        return "<button $attributes>$label</button>";
    }

    /**
     * @param HtmlCheckboxField $node
     * @param array             $attributes
     * @return string
     */
    public function renderCheckbox(HtmlCheckboxField $node, array $attributes = []): string
    {
        $attributes = $this->attributesToHtml(array_replace($attributes, [
            'type' => 'checkbox',
            'name' => $node->getName(),
            'value' => $node->getCheckedValue(),
            'checked' => $node->isChecked(),
            'required' => $node->isRequired(),
        ]));

        return "<input $attributes>";
    }

    /**
     * @param HtmlRadioField $node
     * @param array          $attributes
     * @return string
     */
    public function renderRadio(HtmlRadioField $node, array $attributes = []): string
    {
        $attributes = $this->attributesToHtml(array_replace($attributes, [
            'type' => 'radio',
            'name' => $node->getName(),
            'value' => $node->getCheckedValue(),
            'checked' => $node->isChecked(),
            'required' => $node->isRequired(),
        ]));

        return "<input $attributes>";
    }

    /**
     * @param HtmlSelectField $node
     * @param array           $attributes
     * @return string
     */
    public function renderSelect(HtmlSelectField $node, array $attributes = []): string
    {
        $labels = array_values($attributes['labels'] ?? []);
        unset($attributes['labels']);

        $attributes = $this->attributesToHtml(array_replace([
        ], $attributes, [
            'name' => $node->getName(),
            'required' => $node->isRequired(),
        ]));

        $options = [];
        foreach ($node->getOptions() as $index => $option) {
            $optionAttributes = $this->attributesToHtml([
                'value' => $option,
                'checked' => ($node->getValue() === $option),
            ]);
            $options[] = "<option $optionAttributes>" . $this->stringToHtml($labels[$index] ?? $option) . '</option>';
        }
        $options = implode('', $options);

        return "<select $attributes>$options</select>";
    }

    /**
     * @param HtmlSelectMultipleField $node
     * @param array                   $attributes
     * @return string
     */
    public function renderSelectMultiple(HtmlSelectMultipleField $node, array $attributes = []): string
    {
        $labels = array_values($attributes['labels'] ?? []);
        unset($attributes['labels']);

        $attributes = $this->attributesToHtml(array_replace($attributes, [
            'name' => $node->getName(),
            'multiple' => true,
            'required' => $node->isRequired(),
        ]));

        $options = [];
        foreach ($node->getOptions() as $index => $option) {
            $optionAttributes = $this->attributesToHtml([
                'value' => $option,
                'checked' => in_array($option, $node->getValues()),
            ]);
            $label = $this->stringToHtml($labels[$index] ?? $option);
            $options[] = "<option $optionAttributes>$label</option>";
        }
        $options = implode('', $options);

        return sprintf("<select $attributes>$options</select>");
    }



    /**
     * @param array $attributes
     * @return string
     */
    final private function attributesToHtml(array $attributes): string
    {
        array_walk($attributes, function (&$value, string $attribute) {
            if ($value === false || $value === null) {
                return;
            }

            if ($value === true) {
                $value = $attribute;
            } else {
                $value = sprintf('%s="%s"', $attribute, htmlspecialchars($value, ENT_QUOTES));
            }
        });

        return implode(' ', array_filter($attributes));
    }

    /**
     * @param string $string
     * @return string
     */
    final private function stringToHtml(string $string): string
    {
        return htmlspecialchars($string);
    }

}

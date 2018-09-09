<?php

namespace Species\HtmlForm\SimpleForm;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldName;
use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldValue;
use Species\HtmlForm\Contract\Node\Node;
use Species\HtmlForm\SimpleForm\Abstraction\SimpleNodeCollection;
use Species\HtmlForm\SimpleForm\Field\CheckboxField;
use Species\HtmlForm\SimpleForm\Field\Input\ColorField;
use Species\HtmlForm\SimpleForm\Field\Input\DateField;
use Species\HtmlForm\SimpleForm\Field\Input\DateTimeField;
use Species\HtmlForm\SimpleForm\Field\Input\EmailField;
use Species\HtmlForm\SimpleForm\Field\Input\HiddenField;
use Species\HtmlForm\SimpleForm\Field\Input\MonthField;
use Species\HtmlForm\SimpleForm\Field\Input\NumberField;
use Species\HtmlForm\SimpleForm\Field\Input\RangeField;
use Species\HtmlForm\SimpleForm\Field\Input\SearchField;
use Species\HtmlForm\SimpleForm\Field\Input\TextField;
use Species\HtmlForm\SimpleForm\Field\Input\TimeField;
use Species\HtmlForm\SimpleForm\Field\Input\UrlField;
use Species\HtmlForm\SimpleForm\Field\Input\WeekField;
use Species\HtmlForm\SimpleForm\Field\RadioFields;
use Species\HtmlForm\SimpleForm\Field\SelectField;
use Species\HtmlForm\SimpleForm\Field\SelectMultipleField;
use Species\HtmlForm\SimpleForm\Field\SubmitField;
use Species\HtmlForm\SimpleForm\Field\TextareaField;

/**
 * Form factory.
 */
final class FormFactory
{

    /**
     * @param array    $config
     * @param callable $handler
     * @return Form
     * @throws HtmlInvalidFieldName
     * @throws HtmlInvalidFieldValue
     */
    public function createFormFromArray(array $config, callable $handler)
    {
        return new Form($this->createCollectionFromArray($config), $handler);
    }

    /**
     * @param array $config
     * @return SimpleNodeCollection
     * @throws HtmlInvalidFieldName
     * @throws HtmlInvalidFieldValue
     */
    public function createCollectionFromArray(array $config): SimpleNodeCollection
    {
        return new SimpleNodeCollection($this->createNodesFromArray($config));
    }

    /**
     * @param array $config
     * @return Node[]
     * @throws HtmlInvalidFieldName
     * @throws HtmlInvalidFieldValue
     */
    public function createNodesFromArray(array $config): array
    {
        $nodes = [];

        foreach ($config as $name => $nodeConfig) {
            $nodes[$name] = $this->createNodeFromArray($name, $nodeConfig);
        }

        return $nodes;
    }

    /**
     * @param string $name
     * @param array  $config
     * @return Node
     * @throws HtmlInvalidFieldName
     * @throws HtmlInvalidFieldValue
     */
    public function createNodeFromArray(string $name, array $config): Node
    {
        $c = (object)[
            'set' => $config['$set'] ?? null,
            'list' => $config['$list'] ?? null,
            'type' => strtolower($config['$type'] ?? 'text'),
            'value' => $config['$value'] ?? '',
            'values' => $config['$values'] ?? [],
            'checked' => $config['$checked'] ?? false,
            'options' => $config['$options'] ?? [],
            'handler' => $config['$handler'] ?? null,
            'required' => $config['$required'] ?? true,
            'min' => $config['$min'] ?? null,
            'max' => $config['$max'] ?? null,
            'step' => $config['$step'] ?? null,
            'multiple' => $config['$multiple'] ?? false,
        ];

        // create date value for date fields.
        $dateFields = ['date', 'datetime', 'week', 'month'];
        if (in_array($c->type, $dateFields, true)) {
            $c->date = null;
            if (!empty($c->value) && !$c->value instanceof \DateTimeInterface) {
                try {
                    $c->date = new \DateTimeImmutable($c->value);
                } catch (\Exception $e) {
                }
            }
        }

        // FieldSet
        if ($c->set !== null) {
            $collection = $this->createNodesFromArray($c->set);

            return new FieldSet($name, $collection, $c->handler);
        }

        // FieldList
        if ($c->list !== null) {
            $prototype = $this->createNodeFromArray($name, $c->list);

            return new FieldList($prototype, $c->values, $c->required, $c->handler);
        }

        // Input fields
        switch ($c->type) {

            case 'text':
                return new TextField($name, $c->value, $c->required, $c->handler);
            case 'textarea':
                return new TextareaField($name, $c->value, $c->required, $c->handler);

            case 'checkbox':
                return new CheckboxField($name, $c->checked, $c->required, $c->handler);

            case 'radio':
                return new RadioFields($name, $c->value, $c->options, $c->required, $c->handler);

            case 'select':
                if ($c->multiple) {
                    return new SelectMultipleField($name, $c->values, $c->options, $c->required, $c->handler);
                } else {
                    return new SelectField($name, $c->value, $c->options, $c->required, $c->handler);
                }

            case 'submit':
                return new SubmitField($name, $c->value, $c->handler);

            case 'color':
                return new ColorField($name, $c->value, $c->required, $c->handler);
            case 'email':
                return new EmailField($name, $c->value, $c->required, $c->handler);
            case 'hidden':
                return new HiddenField($name, $c->value, $c->required, $c->handler);
            case 'search':
                return new SearchField($name, $c->value, $c->required, $c->handler);
            case 'url':
                return new UrlField($name, $c->value, $c->required, $c->handler);

            case 'number':
                return new NumberField($name, $c->value, $c->required, $c->handler, $c->min, $c->max, $c->step);
            case 'range':
                return new RangeField($name, $c->value, $c->handler, $c->min, $c->max, $c->step);

            case 'time':
                return new TimeField($name, $c->value, $c->required, $c->handler);
            case 'date':
                return new DateField($name, $c->value, $c->required, $c->handler);
            case 'datetime':
                return new DateTimeField($name, $c->value, $c->required, $c->handler);
            case 'week':
                return new WeekField($name, $c->value, $c->required, $c->handler);
            case 'month':
                return new MonthField($name, $c->value, $c->required, $c->handler);

            default:
                return new TextField($name, $c->value, $c->required, $c->handler);
        }

    }

}

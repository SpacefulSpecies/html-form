<?php

namespace Species\HtmlForm\SimpleForm\Abstraction;

use Species\HtmlForm\Contract\Exception\HtmlInvalidFieldValue;
use Species\HtmlForm\Contract\Node\NodeCollection;
use Species\HtmlForm\Contract\Value\ArrayValue;
use Species\HtmlForm\Contract\Value\FormValue;
use Species\HtmlForm\Contract\Value\StringValue;
use Species\HtmlForm\SimpleForm\Exception\ExpectingArrayValue;
use Species\HtmlForm\SimpleForm\Exception\ExpectingStringValue;
use Species\HtmlForm\SimpleForm\Exception\InvalidValue;

/**
 * Delegate value trait.
 */
trait DelegateValueTrait
{

    /** @var string|null */
    private $error;



    /**
     * @param NodeCollection $nodes
     * @return array
     */
    final protected function getValuesFrom(NodeCollection $nodes): array
    {
        $values = [];
        foreach ($nodes as $offset => $node) {
            if ($node instanceof StringValue) {
                $values[$offset] = $node->getValue();
            } elseif ($node instanceof ArrayValue) {
                $values[$offset] = $node->getValues();
            }
        }

        return $values;
    }

    /**
     * @param NodeCollection $nodes
     * @return array
     */
    final protected function getDefaultValuesFrom(NodeCollection $nodes): array
    {
        $defaults = [];
        foreach ($nodes as $offset => $node) {
            if ($node instanceof StringValue) {
                $defaults[$offset] = $node->getDefaultValue();
            } elseif ($node instanceof ArrayValue) {
                $defaults[$offset] = $node->getDefaultValues();
            }
        }

        return $defaults;
    }

    /**
     * @param NodeCollection $nodes
     * @return bool
     */
    final protected function isRequiredFor(NodeCollection $nodes): bool
    {
        foreach ($nodes as $node) {
            if ($node instanceof FormValue && $node->isRequired()) {
                return true;
            }
        }

        return false;
    }



    /**
     * @return string|null
     */
    final protected function getDelegateError(): ?string
    {
        return $this->error;
    }

    /**
     * @param NodeCollection $nodes
     * @return array
     */
    final protected function getErrorsFrom(NodeCollection $nodes): array
    {
        $errors = [];
        foreach ($nodes as $offset => $node) {
            if ($node instanceof StringValue) {
                $errors[$offset] = $node->getError();
            } elseif ($node instanceof ArrayValue) {
                if ($node instanceof NodeCollection) {
                    $errors[$offset] = $node->getErrors();
                } else {
                    $errors[$offset] = $node->getError();
                }
            }
        }

        return $errors;
    }



    /**
     * @param NodeCollection    $nodes
     * @param callable|null $handler
     * @param array         $values
     * @param array         $context = []
     * @return mixed
     * @throws HtmlInvalidFieldValue
     */
    final protected function submitTo(NodeCollection $nodes, ?callable $handler, array $values, array $context = [])
    {
        try {
            $this->error = null;

            foreach ($nodes as $offset => $node) {
                if (isset($values[$offset])) {
                    if ($node instanceof StringValue) {
                        $values[$offset] = '';
                    } elseif ($node instanceof ArrayValue) {
                        $values[$offset] = [];
                    }
                }
            }

            $handled = [];
            $submitError = null;
            foreach ($nodes as $offset => $node) {
                if ($node instanceof StringValue || $node instanceof ArrayValue) {
                    try {
                        $this->guardNodeValueType($node, $values[$offset]);
                        $handled[$offset] = $node->submit($values[$offset], $values);
                    } catch (\Throwable $e) {
                        $submitError = $submitError ?: $e; // pick first occurred error
                    }
                }
            }

            if ($submitError instanceof \Throwable) {
                throw $submitError;
            }

            return $handler ? $handler($handled, $context) : $handled;

        } catch (\Throwable $e) {

            $e = InvalidValue::withReason($e);
            $this->error = $e->getMessage();

            throw $e;
        }
    }

    /**
     * @param NodeCollection $nodes
     */
    final protected function resetOn(NodeCollection $nodes): void
    {
        foreach ($nodes as $key => $node) {
            if ($node instanceof FormValue) {
                $node->reset();
            }
        }
        $this->error = null;
    }



    /**
     * @param mixed $node
     * @param mixed $value
     * @throws HtmlInvalidFieldValue
     */
    final private function guardNodeValueType($node, $value): void
    {
        if ($node instanceof StringValue) {
            if (!is_string($value)) {
                throw new ExpectingStringValue();
            }
        } elseif ($node instanceof ArrayValue) {
            if (!is_array($value)) {
                throw new ExpectingArrayValue();
            }
        }
    }

}

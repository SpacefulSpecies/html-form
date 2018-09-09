<?php

namespace Species\HtmlForm\Contract\Value;

/**
 * Checked string value interface.
 */
interface CheckedStringValue extends StringValue
{

    /** @inheritdoc */
    public function isChecked(): bool;

    /** @inheritdoc */
    public function getCheckedValue(): string;

}

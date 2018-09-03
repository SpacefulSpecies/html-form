<?php

namespace Species\HtmlForm\Contract;


/**
 * Html field group interface.
 *
 * eg: <input name="contact[name]"><input name="contact[email]">
 */
interface HtmlFieldGroup extends HtmlFieldName, HtmlFieldCollection
{

}

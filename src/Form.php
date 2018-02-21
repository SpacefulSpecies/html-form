<?php

namespace Species\HtmlForm;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Form interface.
 */
interface Form
{

    /**
     * Get the form fields.
     *
     * @return FormFields
     */
    public function getFields(): FormFields;



    /**
     * Submit a PSR-7 server request.
     *
     * @param ServerRequestInterface $request
     * @return bool
     */
    public function submit(ServerRequestInterface $request): bool;

    /**
     * Submit an array of values.
     *
     * @param iterable $values
     * @return bool
     */
    public function submitIterable(iterable $values): bool;



    /**
     * Return a list of errors that occurred on submitting.
     *
     * @return array
     */
    public function getErrors(): iterable;

}

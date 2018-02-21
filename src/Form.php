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
     */
    public function submitRequest(ServerRequestInterface $request): void;

    /**
     * Submit an array of values.
     *
     * @param array $values
     */
    public function submitArray(array $values): void;



    /**
     * Return an array of errors that occurred on submitting.
     *
     * @return array
     */
    public function getErrors(): array;

}

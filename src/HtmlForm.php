<?php

namespace Species\HtmlForm;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Html form interface.
 */
interface HtmlForm
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
     * @param array $values
     * @return bool
     */
    public function submitArray(array $values): bool;



    /**
     * Return an array of errors that occurred on submitting.
     *
     * @return array
     */
    public function getErrors(): array;

}

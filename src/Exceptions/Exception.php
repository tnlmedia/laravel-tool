<?php

namespace TNLMedia\LaravelTool\Exceptions;

use Exception as ExceptionBase;
use Throwable;

class Exception extends ExceptionBase
{
    /**
     * Structure: 000(HTTP Status)-00(Serial)
     */
    protected $code = 50000;

    /**
     * Hint field
     *
     * @var string
     */
    protected string $hint = '';

    /**
     * Override message
     *
     * @param string $message
     * @return $this
     */
    public function setMessage(string $message = ''): Exception
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Set hint field
     *
     * @param string $hint
     * @return $this
     */
    public function setHint(string $hint = ''): Exception
    {
        $this->hint = $hint;
        return $this;
    }

    /**
     * Get hint field
     *
     * @return string
     */
    public function getHint(): string
    {
        return $this->hint;
    }

    /**
     * Create new exception with hint
     *
     * @param string $hint
     * @param Throwable|null $previous
     * @return Exception
     */
    public static function invalidField(string $hint = '', ?Throwable $previous = null): Exception
    {
        $return = new static('', 0, $previous);
        $return->setHint($hint);
        return $return;
    }
}

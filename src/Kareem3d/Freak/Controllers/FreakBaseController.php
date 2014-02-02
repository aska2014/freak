<?php namespace Kareem3d\Freak\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\MessageBag;

class FreakBaseController extends Controller {

    /**
     * @var MessageBag
     */
    protected $errors;

    /**
     * @param $messages
     */
    protected function addErrors($messages)
    {
        if(! $this->errors) $this->errors = new MessageBag;

        // If it's array then merge it
        if(is_array($messages)) $this->errors->merge($messages);

        if(is_string($messages)) $this->errors->merge(array($messages));

        // If it's message bag then merge it's messages
        if($messages instanceof MessageBag) $this->errors->merge($messages->getMessages());
    }

    /**
     * @return mixed
     */
    protected function emptyErrors()
    {
        return ! $this->errors || $this->errors->isEmpty();
    }

    /**
     * @return MessageBag
     */
    protected function getErrors()
    {
        return $this->errors;
    }
}
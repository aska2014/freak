<?php namespace Kareem3d\Freak\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class PackageData {

    /**
     * @var array
     */
    protected static $required = array('model_type', 'model_id');

    /**
     * @var \Kareem3d\Eloquent\Model
     */
    protected $model;

    /**
     * @var array
     */
    protected $options = array();

    /**
     * @param Model $model
     * @param array $options
     * @return \Kareem3d\Freak\Core\PackageData
     */
    public function __construct(Model $model, $options = array())
    {
        $this->model = $model;
        $this->options = $options;
    }

    /**
     * @param $inputs
     * @return PackageData|null
     */
    public static function make( $inputs )
    {
        if(static::validate($inputs)) {

            return new static( static::generateModel($inputs['model_type'],$inputs['model_id']), static::extractOptions($inputs) );
        }
    }

    /**
     * @param $inputs
     * @return bool
     */
    protected static function validate($inputs)
    {
        foreach(static::$required as $key) {

            if(!isset($inputs[$key])) return false;
        }

        return true;
    }

    /**
     * @param $inputs
     * @return array
     */
    protected static function extractOptions($inputs)
    {
        $options = array();

        if(isset($inputs['noObject']))
        {
            foreach($inputs as $key => $value)
            {
                if(strpos($key, 'options_') !== false) {

                    $options[str_replace('options_', '', $key)] = $value;
                }
            }
        }

        else
        {
            if(isset($inputs['options']) && is_array($inputs['options'])) {

                $options = $inputs['options'];
            }
        }

        return $options;
    }

    /**
     * @param $type
     * @param $id
     * @throws PackageDataException
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected static function generateModel($type, $id)
    {
        if(class_exists($type))
        {
            $model = App::make($type);

            if($model instanceof Model)
            {
                return $model->find($id);
            }
        }

        throw new PackageDataException("Model: {$type} doesn't exist");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param $key
     * @return bool
     */
    public function hasOption( $key )
    {
        return isset($this->options[$key]);
    }

    /**
     * @param $key
     * @param string $default
     * @return string
     */
    public function getOption( $key, $default = '' )
    {
        return $this->hasOption($key) ? $this->options[$key] : $default;
    }

    /**
     * @param $key
     * @throws PackageDataException
     * @return string
     */
    public function getOptionRequired( $key )
    {
        if(! $this->hasOption($key))
        {
            throw new PackageDataException("The option {$key} is required");
        }

        return $this->getOption($key);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            'model' => $this->getModel(),
            'options' => $this->options
        );
    }
}
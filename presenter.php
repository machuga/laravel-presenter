<?php

class Presenter
{
	public $resource = null;
	public $resource_name = 'resource';
	public $default = 'resource';

	public function __construct($resource = null)
	{
		if ($resource) {
			$this->resource = $resource;
		}

        // Alias the resource name for nicer, more meaninful access
        // Example: $this->entry, $this->post, $this->user
		$this->{$this->resource_name} = $this->resource;
	}

	public function __get($key)
	{
		if (method_exists($this, $key)) {
			return $this->{$key}();
		} else {
			return $this->resource->$key ?: $this->default;
		}
	}

	public function __call($key, $args)
	{
		if (method_exists($this->resource, $key)) {
			return call_user_func_array([$this->resource, $key], $args);
		} else {
			throw new Exception('Presenter: '.get_called_class().'::'.$key.' method does not exist');
		}
	}

    public function __toString()
    {
        return $this->entry->__toString();
    }
}

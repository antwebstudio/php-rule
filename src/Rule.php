<?php
namespace Ant\Rule;

class Rule {
	public $rules;
	public $context = [];
	
	public static function make($context = null) {
		$rule = new static;
		$rule->context = $context;
		return $rule;
    }
	
	public function setContext($context) {
		$this->context = $context;
		return $this;
	}
	
	public function setRules($rules) {
		$this->rules = $rules;
		return $this;
    }
    
    public function addRule($rule) {
        $this->rules[] = $rule;
        return $this;
    }

    public function when($rule) {
        $this->addRule($rule);
        return $this;
    }
	
	public function match($rulesContext = []) {
		$this->prepare();
		
		foreach ((array) $this->rules as $rule) {
            if ($rule === false) return false;

            if ($rule !== true) {   
                if (is_callable($rule)) {
                    $value = call_user_func_array($rule, []);
                    if (!$value) {
                        return false;
                    }
                } else {
					if (!is_object($rule)) {
						$rule = $this->instantiateRule($rule, $this);
					}
                
                    if (!$rule->match($rulesContext)) {
                        return false;
                    }
                }
            }
		}
		
		// If all rules matched
		return true;
	}
	
	protected function instantiateRule($rule, $parent = null) {
		if (is_array($rule)) {
			if (isset($rule[0]) && $rule[0] == 'or') {
				// @TODO
			} else if (isset($rule[0]) && $rule[0] == 'not') {
				// @TODO
			} else if (is_callable($rule)) {
				// @TODO
			} else if (isset($rule['class'])) {
				$class = $rule['class'];
				$context = $rule;
				unset($context['class']);
				$context['parent'] = $parent;
				$rule = $class::make($context);
				return $rule;
			} else {
				
			}
		} else {
			throw new \Exception('Invalid rule: '.$rule);
		}
	}
	
	public function call() {
		$this->prepare();
		return $this->apply();
	}
	
	public function apply() {
	}
	
	public function map($context) {
		return $context;
	}
	
	protected function evaluate($value) {
		if (is_array($value) && isset($value['class'])) {
			return Yii::createObject($value)->call();
		}
		return $value;
	}
	
	protected function prepare($context = []) {
		$context = array_merge((array) $this->context, (array) $context);
		foreach($context as $name => $value) {
			if (is_callable($value)) {
				call_user_func_array($value, [$this->context['parent']]);
			} else {
				$this->{$name} = $this->evaluate($value);
			}
		}
		return $this;
	}
}
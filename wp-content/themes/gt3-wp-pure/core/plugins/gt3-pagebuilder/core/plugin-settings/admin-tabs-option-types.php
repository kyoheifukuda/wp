<?php
abstract class Option
{
	public $params = array();
	
	protected $template = '<div class="mix-tab-control tab_{$ID}">
		<label for="{$ID}">{$NAME}</label>
		<div class="input">
			{$INPUT}
			<span class="help-block">{$DESC}</span>
		</div>
	</div>';
	
	protected $vars = array(
		'{$ID}',
		'{$NAME}',
		'{$INPUT}',
		'{$DESC}'
	);
	
	protected $defaults = array(
		'id'      => '',
		'name'    => '',
		'desc'    => '',
		'default' => ''
	);
	
	protected $value = '';
	protected $def_value = '';
	
	public function __construct(Array $params)
	{
		$this->params = array_merge($this->defaults, $params);
		
		$as_array = (isset($params['as_array']))?$params['as_array']:FALSE;
		$this->def_value = (isset($params['default']) && !empty($params['default']))?$params['default']:'';
		if ($as_array) {
			$temp_value = gt3pb_get_option($as_array);
			if (isset($temp_value[$params['id']])) {
				$this->value = $temp_value[$params['id']];
			}else{
				$this->value = $def_value;
			}
		}else{
			$this->value = stripslashes(gt3pb_get_option($params['id'], (isset($params['default']) && !empty($params['default']))?$params['default']:''));
		}
	}
	
	public function render(){
		return str_replace($this->vars, array(
			$this->params['id'],
			$this->params['name'],
			$this->render_control(),
			$this->params['desc']
		), $this->template);
	}
	
	abstract protected function render_control();
}


/**
* Checkbox Option
*/
class CheckboxOption extends Option
{
	protected $template = '<div class="mix-tab-control">
		<div class="input">
			<ul class="inputs-list">
				<li>
					<label>
						{$INPUT}
						<span>{$NAME}</span>
					</label>
				</li>
			</ul>
			<span class="help-block">{$DESC}</span>
		</div>
	</div>';
	
	protected function render_control()
	{
		return '<input type="checkbox" name="'.$this->params['id'].'" id="'.$this->params['id'].'" value="1" '.(!empty($this->value)?'checked="checked"':'').' />';
	}
}

/**
* Color Option
*/
class ColorOption extends Option
{
	protected function render_control()
	{
		/*if (empty($this->value)) {
			$this->value = $this->def_value;
		}*/

        if (empty($this->value) && $this->params['not_empty'] == true) {
            $this->value = $this->def_value;
        }

		return '<div class="color_option_admin"><span class="sharp">#</span><input class="medium cpicker textoption type1" maxlength="25" type="text" name="'.$this->params['id'].'" id="'.$this->params['id'].'" '.(!empty($this->value)?'value="'.htmlspecialchars($this->value).'"':'').' /><input disabled="disabled" type="text" class="textoption type1 cpicker_preview" value=""></div>';
	}
}

/**
* Radio Option
*/
class RadioOption extends Option
{
	protected function render_control()
	{
		$control = '';
		foreach ($this->params['options'] as $ind => $val) {
			$control .= '<input type="radio" name="'.$this->params['id'].'" value="'.$ind.'" '.(($this->value == $ind)?'checked="checked"':'').' /> '.htmlspecialchars($val) .'<br />';
		}
		
		return $control;
	}
}

/**
* Select Option
*/
class SelectOption extends Option
{
	protected function render_control()
	{
		$control = '<select class="xlarge bg_hover1" name="'.$this->params['id'].'" id="'.$this->params['id'].'">';
		foreach ($this->params['options'] as $val => $name) {
			$control .= '<option value="'.htmlspecialchars($val).'" '.(($this->value == $val)?'selected="selected"':'').'>'.htmlspecialchars($name).'</option>';
		}
		$control .= '</select>';
		
		return $control;
	}
}

/**
* Text Option
*/
class TextOption extends Option
{
	protected function render_control()
	{
	
		if (isset($this->params['not_empty']) && (empty($this->value) && $this->params['not_empty'] == true)) {
			$this->value = $this->def_value;
		}

        if (isset($this->params['width']) && strlen($this->params['width'])>0) {
            $wstyle = " width:".$this->params['width']." !important; ";
        }

        if (isset($this->params['textalign']) && strlen($this->params['textalign'])>0) {
            $textalign = " text-align:".$this->params['textalign']." !important; ";
        }

        if (!isset($wstyle)) {
            $wstyle = '';
        }
        if (!isset($textalign)) {
            $textalign = '';
        }
		
		return '<input class="xxlarge textoption type1" type="text" style="'.$wstyle.$textalign.'" name="'.$this->params['id'].'" id="'.$this->params['id'].'" '.(!empty($this->value)?'value="'.htmlspecialchars($this->value).'"':'').' />';
	}
}


/**
* Textarea Option
*/
class TextareaOption extends Option
{
	protected function render_control()
	{
	
		if (isset($this->params['not_empty']) && (empty($this->value) && $this->params['not_empty'] == true)) {
			$this->value = $this->def_value;
		}
	
		return '<textarea class="xxlarge textareaoption type1" name="'.$this->params['id'].'" id="'.$this->params['id'].'" rows="5">'.(!empty($this->value)?htmlspecialchars($this->value):'').'</textarea>';
	}
}

/**
* Upload Option
*/
class UploadOption extends Option
{
	protected function render_control()
	{
		$control = '<input class="textoption type2" name="'. $this->params['id'] .'" id="' . $this->params['id'] .'_upload" type="text" value="'. htmlspecialchars($this->value) .'" />';
		
		$control .= '<div class="up_btns"><span class="button btn_upload_image ok_btn but_'. $this->params['id'] .'" id="'. $this->params['id'] .'">Upload Image</span>';
		
		if(!empty($this->value)) {
			$hide = '';
		}else{
			$hide = 'hide';
		}
		
		$control .= '<span class="button btn_reset_image danger_btn '. $hide.'" id="reset_' . $this->params['id'] .'" title="' . $this->params['id'] . '">Remove</span>
</div><div class="clear"></div>';
		if(!empty($this->value)){
			$control .= '<a class="uploaded-image" href="'. $this->value . '" target="_blank"><img class="option-image" id="image_'. $this->params['id'].'" src="'.$this->value.'" alt="" /></a>';
		}
		
		return $control;
	}
}

/**
* Ajax Button Option
*/
class AjaxButtonOption extends Option
{
	protected function render_control()
	{
		return '<script>
			if (typeof window.ajaxButtonData == "undefined") {
				window.ajaxButtonData = {};
			}
			
			window.ajaxButtonData["'. $this->params['id'] .'"] = '. json_encode($this->params['data']) .'
		</script>
		<a class="btn mix_ajax_button button" data-confirm="'. (empty($this->params['confirm'])?0:1) .'" data-id="'. $this->params['id'] .'">'. $this->params['title'] .'</a>
		<img class="ajax_loader_img" style="display: none;" src="'.get_template_directory_uri().'/core/admin/img/ajax_active.gif" alt="active..." />
		<span></span>';
	}
}
?>
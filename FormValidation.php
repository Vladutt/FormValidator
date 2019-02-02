class FormValidation {

  protected $data = [];
  protected $errors = [];
  protected $customErrors = [];
  protected $rules = [];

  public function __construct(array $data){
    $this->data = $data;
  }

  public function setRules(array $rules){
    $this->rules = $rules;
  }

  public function isValidated(){

    $this->process();
    return count($this->errors) ? 0 : 1;

  }

  protected function process(){

    foreach($this->rules as $field => $rule){

      if(isset($this->data[$field])){
        
        if(strpos($rule, '|') == true){

          $bits = explode('|', $rule);
          foreach($bits as $bit){
            $this->processSecondRule($bit, $field);
          }
  
        }else{
          $this->processSecondRule($rule, $field);
        }

      }else{
        die('nu am găsit acest camp.');
      }

    }

  }

  protected function processSecondRule($rule, $field){
    if(strpos($rule, ':') == true){
      $pieces = explode(':', $rule);
      $this->{$pieces[0]}($field, $pieces[1]);
    }else{
      $this->{$rule}($field);
    }
  }

  public function setCustomErrors(array $errors){
    foreach($errors as $field => $error){
      if(strpos($field, '.') == true){
        $this->customErrors[$field] = $error;
      }else{
        die('Nu ai speficicat corect inputul pentru care vrei să adaugi mesajul.');
      }
    }
  }

  protected function required($field){
    if(empty($this->data[$field])){
      $message = 'Acest câmp ' . $field . ' este gol.';
      if(empty($this->customErrors[$field.'.required'])){
        $this->newErrors($field, $message); 
      }else{
        $this->newErrors($field, $this->customErrors[$field.'.required']);
      }
    }
  }

  protected function email($field){
    if(!filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)){
      $message = 'Acest câmp ' . $field . ' nu este un email valid.';
      if(empty($this->customErrors[$field.'.email'])){
        $this->newErrors($field, $message); 
      }else{
        $this->newErrors($field, $this->customErrors[$field.'.email']);
      }
    }
  }

  protected function min($field, $length){
    if(strlen($this->data[$field]) < $length){
      $message = 'Acest câmp ' . $field . ' necesită cel puțin ' . $length . ' caractere.';
      if(empty($this->customErrors[$field.'.min'])){
        $this->newErrors($field, $message); 
      }else{
        $this->newErrors($field, $this->customErrors[$field.'.min']);
      }
    }
  }

  protected function max($field, $length){
    if(strlen($this->data[$field]) > $length){
      $message = 'Acest câmp ' . $field . ' necesită cel mult ' . $length . ' caractere.';
      if(empty($this->customErrors[$field.'.max'])){
        $this->newErrors($field, $message); 
      }else{
        $this->newErrors($field, $this->customErrors[$field.'.max']);
      }
    }
  }

  public function getErrors(){
    return $this->errors;
  }
  public function newErrors($field, $message){

    if(!isset($this->errors[$field])){
      $this->errors[$field] = $message;
    }

  }



}

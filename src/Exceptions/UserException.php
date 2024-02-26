<?php
class UserException extends Exception {

  public function errorMessage(string $customMessage = null) {
    $errorMsg = 'Error on line '.$this->getLine().' in '.$this->getFile()
    .':'. $this->getMessage() . $customMessage ?? '';

    return $errorMsg;
  }
}
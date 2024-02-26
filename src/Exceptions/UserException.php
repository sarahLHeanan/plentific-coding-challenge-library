<?php

namespace Sarahheanan\PlentificCodingChallengeLibrary\Exceptions;

use Exception;

class UserException extends Exception {

  public function errorMessage(string $customMessage = null) {
    $errorMsg = 'Error on line '.$this->getLine().' in '.$this->getFile()
    .':'. $this->getMessage() . $customMessage ?? '';

    return $errorMsg;
  }
}